<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\Seqno;
use Illuminate\Http\Request;
use Validator;
use App\Models\SPPA\Acceptance;
use App\Models\SPPA\Ainfo;
use App\Models\SPPA\Client;
use App\Models\SPPA\Customer;
use App\Models\SPPA\Distribution;
use App\Models\SPPA\Icover;
use App\Models\SPPA\Payment\PaymentReceipt;
use App\Models\SPPA\Product;
use App\Models\SPPA\Rates;
use App\Models\SPPA\Rcover;
use App\Repositories\PDFRepository;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;

class SppaApiController extends Controller
{

    protected $pdf;

    public function __construct(PDFRepository $repoPdf)
    {

        $this->pdf      =   $repoPdf;
    }

    function getProduct($product)
    {
        return Product::where('product_code', $product)->first();
    }

    function createNumber($lno, $add, $type, $digits, $year)
    {
        $find = Seqno::where('lno', '=', $lno)->where('type', '=', $type)->where('year', $year)->first();

        if ($find == null) {
            $data = array(
                'lno'   => $lno, 'cno' => 1, 'type' => $type, 'year' => $year,
            );
            Seqno::create($data);
        } else {
            $new = $find["cno"] + 1;
            $update = Seqno::findOrfail($find["id"]);
            $update->cno = $new;
            $update->save();
        }

        $get = Seqno::where('lno', '=', $lno)->where('type', '=', $type)->where('year', $year)->first();
        $no = $get["cno"];
        if ($no >= 1 && $no <= 9) {
            $no = (($digits == 3) ?  '00' . $no . $lno . $add : (($digits == 4) ?  '000' . $no . $lno . $add : (('0000' . $no . $lno . $add))));
        } elseif ($no >= 10 && $no <= 99) {
            $no = (($digits == 3) ?  '0' . $no . $lno . $add : (($digits == 4) ?  '00' . $no . $lno . $add  : (('000' . $no . $lno . $add))));
        } elseif ($no >= 100 && $no <= 999) {
            $no = (($digits == 3) ? '' . $no . $lno . $add : (($digits == 4) ? '0' . $no . $lno . $add : (('00' . $no . $lno . $add))));
        }
        return $no;
    }

    function getRomawiInMonth($bln)
    {
        switch ($bln) {
            case 1:
                return "I";
                break;
            case 2:
                return "II";
                break;
            case 3:
                return "III";
                break;
            case 4:
                return "IV";
                break;
            case 5:
                return "V";
                break;
            case 6:
                return "VI";
                break;
            case 7:
                return "VII";
                break;
            case 8:
                return "VIII";
                break;
            case 9:
                return "IX";
                break;
            case 10:
                return "X";
                break;
            case 11:
                return "XI";
                break;
            case 12:
                return "XII";
                break;
        }
    }



    function getClientByApiKey($apiKey)
    {
        return Client::where('api_key', $apiKey)->first();
    }

    public function store($api_key, Request $request)
    {
        if ($this->getClientByApiKey($api_key) == null) {
            return ResponseFormatter::error(null, 'nggak oke');;
        }

        $validation = $this->validateEntries($request);
        if ($validation->fails()) {
            return $this->throwValidation($validation->messages()->first());
        }

        $data = $this->create($request->all(), $api_key);
        return ResponseFormatter::success(
            null,
            "SPPA Berhasil disimpan, Terima kasih telah melakukan submit SPPA"
        );
    }

    public function validateEntries(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'product_code' => 'required',
            'tanggal_awal_pertanggungan' => 'required|date',
            'tanggal_akhir_pertanggungan' => 'required|date',
            'tsi' => 'required|numeric',
            'nama_tertanggung' => 'required|max:191',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'id_tipe' => 'required',
            'id_no' => 'required',
            'alamat' => 'required',
            'kewarganegaraan' => 'required',
            'sumber_pembayaran_premi' => 'required',
            'perorangan' => 'required',
        ]);
        return $validation;
    }

    protected $oke;
    public function create(array $input, $apiKey)
    {
        DB::transaction(function () use ($input, $apiKey) {
            $mon = $this->getRomawiInMonth(Carbon::now()->format('m'));
            $y =  Carbon::now()->format('y');
            $input['regno']         = $this->createNumber("/SPPA/", $mon . '/' . $y, 'SPPA', 4, Carbon::now()->format('Y'));
            $input['product_id']    = $this->getProduct($input['product_code'])->id;
            $input['client_id']     = $this->getClientByApiKey($apiKey)->id;
            $input['customer_id']   = $this->customerInfo($input);
            $input['sdate']         = $input['tanggal_awal_pertanggungan'];
            $input['edate']         = $input['tanggal_akhir_pertanggungan'];

            if ($acc = Acceptance::create($input)) {
                $this->oke = $acc->id;
                $this->objectInfo($input, $acc->id);
                $this->interest($acc->id, $input['tsi'], $this->getProduct($input['product_code'])->product_name);
                $this->coverage($acc->id, $input['perluasan_resiko'],  $acc->sdate,  $acc->edate, $input['tsi']);
                $this->payment($acc->id, $input['regno']);
                $dist = Distribution::find($this->getClientByApiKey($apiKey)->distribution_id);
                // $dist->notify(new SppaNotification($acc));
                return true;
            }
            throw new GeneralException("Error Saat Menyimpan Data Divisi");
        });
        return $this->oke;
    }



    public function interest($p1, $p2, $p3)
    {
        Icover::create([
            "acceptance_id"     => $p1,
            "tsi"               => $p2,
            "description"       => $p3,
        ]);
    }

    public function coverage($p1, $input, $sdate, $edate, $tsi)
    {
        $presentyear = $sdate;
        $awal  = date_create($sdate);
        $akhir = date_create($edate);
        $diff  = date_diff($akhir, $awal);
        $mYear = $diff->y;
        $mDays = $diff->days;
        $data = "";
        if ($input == null) {
            $data = ["Flexa"];
        } else {
            $data = explode(",", $input);
            array_push($data, "Flexa");
        }
        // dd($data);
        $rates = [];
        foreach ($data as $param) {
            $rate = Rates::where('rate_code', $param)->first();

            for ($i = 0; $i < $mYear; $i++) {
                $start  = date("Y-m-d", mktime(0, 0, 0, date("m", strtotime($presentyear)),   date("d", strtotime($presentyear)),   date("Y", strtotime($presentyear)) + $i));
                $end =  date('Y-m-d', strtotime($start . ' + 1 years'));

                $to = Carbon::createFromFormat('Y-m-d', $end);
                $from = Carbon::createFromFormat('Y-m-d', $start);
                $diff_in_days = $to->diffInDays($from);
                $rates[] = [
                    'acceptance_id' => $p1,
                    'rate_code' => $rate->rate_code,
                    'rate' => $rate->rate,
                    'scaling' => 0,
                    'premium' => $tsi * $rate->rate / 100,
                    'unit' => $rate->unit,
                    'description' => $rate->description,
                    'sdate' => $start,
                    'edate' => $end,
                    'created_at'    => Carbon::now()
                ];
                if ($i == $mYear - 1) {
                    if ($diff->m != 0) {
                        $tos = Carbon::createFromFormat('Y-m-d', $edate);
                        $froms = Carbon::createFromFormat('Y-m-d', $end);
                        $diff_in_dayss = $tos->diffInDays($froms);
                        $rates[] = [
                            'acceptance_id' => $p1,
                            'rate_code' => $rate->rate_code,
                            'rate' => $rate->rate,
                            'scaling' => 20,
                            'premium' => $tsi * $rate->rate / 100  * 0.2,
                            'unit' => $rate->unit,
                            'description' => $rate->description,
                            'sdate' => $end,
                            'edate' => $edate,
                            'created_at'    => Carbon::now()
                        ];
                        // print('['. $end . ' s.d ' . $edate.']  ');
                    }
                }
            }
        };

        Rcover::insert($rates);
    }

    public function objectInfo($input, $id)
    {
        Ainfo::create([
            "acceptance_id"         => $id,
            "valueid1"              => "Jalan",
            "valuedesc1"            => $input['jalan'],
            "valueid2"              => "Kota Dan Provinsi",
            "valuedesc2"            => $input['kota_provinsi'],
            "valueid3"              => "Kode Pos",
            "valuedesc3"            => $input['kode_pos'],
            "valueid4"              => "Jenis Lahan",
            "valuedesc4"            => $input['jenis_lahan'],
            "valueid5"              => "Luas Lahan",
            "valuedesc5"            => $input['luas_lahan'],
            "valueid6"              => "Jumlah Pokok",
            "valuedesc6"            => $input['jumlah_pokok'],
            "valueid7"              => "Usia Tanaman",
            "valuedesc7"            => $input['usia_tanaman'],
            "valueid8"              => "Riwayat Pemupukan",
            "valuedesc8"            => $input['riwayat_pemupukan'],
            "valueid9"              => "Riwayat Penyemprotan",
            "valuedesc9"            => $input['riwayat_penyemprotan'],
            "valueid10"              => "Jarak Tanam",
            "valuedesc10"            => $input['jarak_tanam'],
            "valueid11"              => "Kiri Berbatasan Dengan",
            "valuedesc11"            => $input['kiri_berbatasan_dengan'],
            "valueid12"              => "Kanan Berbatasan Dengan",
            "valuedesc12"            => $input['kanan_berbatasan_dengan'],
            "valueid13"              => "Depan Berbatasan Dengan",
            "valuedesc13"            => $input['depan_berbatasan_dengan'],
            "valueid14"              => "Belakang Berbatasan Dengan",
            "valuedesc14"            => $input['belakang_berbatasan_dengan'],
            "valueid15"              => "Generator Sendiri, Bahan Bakar",
            "valuedesc15"            => $input['bahan_bakar_generator'],
        ]);
    }
    public function customerInfo($input)
    {

        $i = $input['perorangan'];
        $customer = Customer::create([
            "name"   => $input['nama_tertanggung'],
            "place_of_birth"   => $input['tempat_lahir'],
            "date_of_birth"   => $input['tanggal_lahir'],
            "identity_type"   => $input['id_tipe'],
            "identity_no"   => $input['id_no'],
            "address"   => $input['alamat'],
            "home_phone"   => $input['telp_rumah'],
            "office_phone"   => $input['telp_kantor'],
            "handphone"   => $input['handphone'],
            "fax_no"   => $input['fax_no'],
            "NPWP"   => $input['npwp'],
            "citizen"   => $input['kewarganegaraan'],
            "source_premium_payment"   => $input['sumber_pembayaran_premi'],
            "individual"   => $i,
            "valueid1"   => (($i == 'Y') ? "Pekerjaan" : "Jenis usaha/kegiatan"),
            "valuedesc1"   => $input['valuedesc1'],
            "valueid2"   => (($i == 'Y') ? "Jabatan" : "Akte Pendirian"),
            "valuedesc2"   => $input['valuedesc2'],
            "valueid3"   => (($i == 'Y') ? "Alamat" : "Izin usaha SIUP No."),
            "valuedesc3"   => $input['valuedesc3'],
            "valueid4"   => (($i == 'Y') ? "Penghasilan per bulan" : "NPWP"),
            "valuedesc4"   => $input['valuedesc4'],
        ]);
        return $customer->id;
    }



    function pecah($param)
    {
        return explode(",", $param);
    }

    public function check(Request $request, $api_key)
    {
        // dd($request);
        if ($this->getClientByApiKey($api_key) == null) {
            return ResponseFormatter::error(null, 'wrong api key');
        }
        $cover = $request->perluasan_resiko;
        $sdate = $request->tanggal_awal_pertanggungan;
        $edate = $request->tanggal_akhir_pertanggungan;
        $tsi = $request->tsi;
        $data =  $this->hitung($cover, $sdate, $edate, $tsi);
        return ResponseFormatter::success(
            [
                'tgl_mulai_asuransi' => $data['tgl_mulai_asuransi'],
                'tgl_akhir_asuransi' => $data['tgl_akhir_asuransi'],
                'rate' => $data['rate'],
                'premium' => $data['premium'],
                'jenis_cover' => $data['jenis_cover'],
                'informasi_cover' => $data['r_cover']
            ],
            'oke'
        );
    }

    public function list($api_key)
    {
        if ($this->getClientByApiKey($api_key) == null) {
            return ResponseFormatter::error(null, 'wrong api key');
        }
        $data =  $this->showAll();
        return ResponseFormatter::success($data, 'oke');
    }

    public function show($id, $api_key)
    {
        if ($this->getClientByApiKey($api_key) == null) {
            return ResponseFormatter::error(null, 'wrong api key');
        }
        $akseptasi =  $this->view($id);
        return ResponseFormatter::success($akseptasi, 'oke');
    }




    public function payment($p1, $p2)
    {
        $data = PaymentReceipt::create([
            "acceptance_id"     => $p1,
            "no_arsip" => $p2
        ]);
    }



    public function printPolis($id)
    {
        $id = Crypt::decryptString($id);
        $akseptasi = Acceptance::findOrFail($id)->with(['client', 'customer', 'ainfo', 'r_cover', 'payment', 'i_cover'])->first();
        $this->print($akseptasi);
    }

    public function print($acceptance)
    {
        $data = $acceptance;
        $cover = [];
        $tarif_premi = 0;
        $premium = 0;
        foreach ($acceptance->r_cover as $key => $value) {
            array_push($cover, $value->rate_code);
            $premium += $value->premium;
            $tarif_premi += $value->rate;
        }
        $risk_cover = implode(",", array_unique($cover));
        $this->pdf->setReleaseBackground();
        $this->pdf->labelTitle($acceptance->regno);
        $this->pdf->addPage();
        $this->pdf->setFonts('helvetica', 'B', 12);
        $this->pdf->setTitle(0, "POLIS", "R");
        $this->pdf->setFonts('helvetica', 'B', 11);

        $this->pdf->setLine(2);
        $this->pdf->setFonts('helvetica', 'N', 9);

        $content = '<table  cellspacing="0" cellpadding="0" border="0" width="100%">
        <tr>
            <td  width="20%" >Produk : </td>
            <td  width="5%">:</td>
            <td width="75%"><strong>' . $acceptance->i_cover->description . '</strong></td>
        </tr>
        <tr>
        <td  width="20%" >Nomor Polis : </td>
        <td  width="5%">:</td>
        <td width="75%">' . $acceptance->regno . '</td>
        </tr>
        ';

        $content    .= '</table><hr>';

        $content .= '<p>Sehubungan dengan adanya permintaan dari pihak ' . $acceptance->client->name . ' dan sementara menunggu polis asuransinya
        diterbitkan, dengan ini PT. Asuransi Jasa Tania Cabang Medan menyatakan sepat untuk menutup pertanggungan tersebut dengan
        data sebagai berikut : </p>';

        $content .= '<table style="padding:5px;">
                <tbody>
                    <tr>
                        <td width="35%"><b>Nama dan Alamat Tertanggung  </b></td>
                        <td width="5%">:</td>
                        <td width="60%">' . $acceptance->customer->name . ', ' . $acceptance->customer->address . '</td>
                    </tr>
                    <tr>
                    <td width="35%"><b>Obyek yang dipertanggungkan  </b></td>
                    <td width="5%">:</td>
                        <td width="60%"> ' . $acceptance->ainfo->valueid5 . ', ' . $acceptance->ainfo->valuedesc5 . '
                        <br>' . $acceptance->ainfo->valueid6 . ', ' . $acceptance->ainfo->valuedesc6 . ' 
                        <br>' . $acceptance->ainfo->valueid7 . ', ' . $acceptance->ainfo->valuedesc7 . ' 
                        <br>' . $acceptance->ainfo->valueid4 . ', ' . $acceptance->ainfo->valuedesc4 . ' 
                        </td>
                    </tr>
                    <tr>
                    <td width="35%"><b>Lokasi Pertanggungan </b></td>
                    <td width="5%">:</td>
                    <td width="60%">' . $acceptance->ainfo->valueid1 . ' : ' . $acceptance->ainfo->valuedesc1 . '
                    <br>' . $acceptance->ainfo->valueid2 . ', ' . $acceptance->ainfo->valuedesc2 . ' 
                    </td>
                    </tr>
                    <tr>
                        <td width="35%"><b>Nilai Pertanggungan </b></td>
                        <td width="5%">:</td>
                        <td width="60%">Rp. ' . number_format($acceptance->i_cover->tsi, 0, ',', '.') . '</td>
                    </tr>
                    <tr>
                        <td width="35%"><b>Jangka waktu Pertanggungan  </b></td>
                        <td width="5%">:</td>
                        <td width="60%">' . $acceptance->sdate  . ' s/d ' . $acceptance->edate  . '</td>
                    </tr>
                    <tr>
                        <td width="35%"><b>Risiko yang dijamin  </b></td>
                        <td width="5%">:</td>
                        <td width="60%">' . $risk_cover  . '</td>
                    </tr>
                    <tr>
                        <td width="35%"><b>Tarif Premi  </b></td>
                        <td width="5%">:</td>
                        <td width="60%">' . $tarif_premi  . ' % p.a</td>
                    </tr>
                    
                    <tr>
                    <td width="35%"><b>Perhitungan Premi</b>
                    <br>
                    <div class="total ml-1">
                        Nominal Pertanggungan
                        <br>
                        Biaya Materai
                        <br>
                        Biaya Polis
                        <br>
                        Total
                    </div>
                </td>
                

                <td width="60%" > <br> <br> <br>
                    = Rp. ' . number_format($premium, 0, ',', '.') . '
                    <br>
                    = Rp. 25.000
                    <br>
                    = <u>Rp. 10.000</u> +/+
                    <br>
                    = Rp. ' . number_format($premium + 35000, 0, ',', '.') . '
                </td>
            </tr>
                </tbody>
            </table>';


        $this->pdf->writeContent($content);
        $this->pdf->setLine(2);
        $this->pdf->setFonts('helvetica', 'N', 7);
        $this->pdf->setLine(5);

        $this->pdf::SetY(-30);
        // Set font
        $this->pdf::SetFont('helvetica', 'I', 7);
        $this->pdf::lastPage();
        $this->pdf->setOutputName("GTI_" . $acceptance->regno, 'I');
    }




    // function perhitungan premi
    public function hitung($input, $sdate, $edate, $tsi)
    {
        $presentyear = $sdate;
        $awal  = date_create($sdate);
        $akhir = date_create($edate);
        $diff  = date_diff($akhir, $awal);
        $mYear = $diff->y;
        $mDays = $diff->days;
        $data = "";
        if ($input == null) {
            $data = ["Flexas"];
        } else {
            $data = explode(",", $input);
            array_push($data, "Flexas");
        }

        $rates = [];
        foreach ($data as $param) {
            $rate = Rates::where('description', $param)->first();
            for ($i = 0; $i < $mYear; $i++) {
                $start  = date("Y-m-d", mktime(0, 0, 0, date("m", strtotime($presentyear)),   date("d", strtotime($presentyear)),   date("Y", strtotime($presentyear)) + $i));
                $end =  date('Y-m-d', strtotime($start . ' + 1 years'));
                $to = Carbon::createFromFormat('Y-m-d', $end);
                $from = Carbon::createFromFormat('Y-m-d', $start);
                $diff_in_days = $to->diffInDays($from);
                $rates[] = [
                    'sdate' => $start,
                    'edate' => $end,
                    'rate_code' => $rate->rate_code,
                    'rate' => $rate->rate,
                    'scaling' => 0,
                    'premium' => $tsi * $rate->rate / 100 * ($diff_in_days / 365),
                    'unit' => $rate->unit,
                    'description' => $rate->description,
                ];
                // print('[' . $start . ' s.d ' . $end . ']  ');
                if ($i == $mYear - 1) {
                    if ($diff->m != 0) {
                        $tos = Carbon::createFromFormat('Y-m-d', $edate);
                        $froms = Carbon::createFromFormat('Y-m-d', $end);
                        $diff_in_dayss = $tos->diffInDays($froms);
                        $rates[] = [
                            'sdate' => $start,
                            'edate' => $end,
                            'rate_code' => $rate->rate_code,
                            'rate' => $rate->rate,
                            'scaling' => 20,
                            'premium' => $tsi * $rate->rate / 100  * 0.2,
                            'description' => $rate->description,
                        ];
                    }
                }
            }
        };
        $tPremi = 0;
        $tRate = 0;
        foreach ($rates as $key => $value) {
            $tPremi += $value['premium'];
            $tRate += $value['rate'];
        }
        return [
            'tgl_mulai_asuransi' => $sdate,
            'tgl_akhir_asuransi' => $edate,
            'rate' => $tRate,
            'premium' => $tPremi,
            'jenis_cover' => implode(", ", $data),
            'r_cover' => $rates,
        ];
    }

    public function showAll()
    {
        $data = Acceptance::with(['ainfo', 'r_cover', 'i_cover', 'customer', 'payment', 'client'])->get();
        foreach ($data as $key => $id) {
            if ($data[$key]->approval == 'Y') {
                $data[$key]['link_polis'] = url('print/' . Crypt::encryptString($id->id));
            } else {
                $data[$key]['regno'] = '';
            }
        }
        return $data;
    }

    public function view($id)
    {
        $akseptasi = Acceptance::findOrFail($id)->with(['client', 'customer', 'ainfo', 'r_cover', 'payment', 'i_cover'])->first();
        if ($akseptasi->approval == 'Y') {
            $akseptasi['link_polis'] =  url('print/' . Crypt::encryptString($akseptasi->id));
        } else {
            $akseptasi['regno'] = '';
        }
        return $akseptasi;
    }

    public function pembayaran($api_key, Request $req)
    {
        if ($this->getClientByApiKey($api_key) == null) {
            return $this->throwValidation("INVALID_API_KEY");
        }
        $payment =  $this->confirmPayment($req);
        return $payment;
    }

    public function confirmPayment($data)
    {
        $check = paymentReceipt::where('no_arsip', $data->no_arsip)->first();
        if ($check) {
            $check->update([
                'nominal' => $data->nominal,
                'information' => $data->information,
                'payment_date' => $data->payment_date,
            ]);
            return ResponseFormatter::success(null, 'oke');
        } else {
            return ResponseFormatter::error(null, 'Gagal menyimpan data');
        }
    }
}
