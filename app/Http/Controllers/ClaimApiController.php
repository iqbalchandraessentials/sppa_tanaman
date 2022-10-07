<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\Claim\ClaimAcceptance;
use App\Models\Claim\ClaimInfo;
use App\Models\SPPA\Acceptance;
use App\Models\SPPA\Client;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ClaimApiController extends Controller
{
    public function submit(Request $request, $api)
    {
        // dd($request);
        // if (getClientByApiKey($api) == null) {
        //     return $this->throwValidation("INVALID_API_KEY");
        // }

        $user = Acceptance::with(['client', 'ainfo', 'customer'])->where('regno', $request->no_polis)->first();
        if ($user == null) {
            exit('not found regno');
        }
        $data = $request->all();
        $data['no_polis'] = $request->no_polis;
        $data['client_id'] = $user->client->id;
        $data['acceptance_id'] = $user->id;
        $data['customer_id'] = $user->customer->id;
        $data['nama'] = $user->customer->name;
        $data['alamat'] = $user->customer->address;
        $data['claim_info_id'] = $this->ClaimInfo($request, $user->ainfo);
        $data['file_polis'] = $request->file('file_polis')->store('assets/product', 'public');
        $data['berita_acara'] = $request->file('berita_acara')->store('assets/product', 'public');

        if ($acc = ClaimAcceptance::create($data)) {
            return ResponseFormatter::success(null, 'oke');
        }
    }
    public function ClaimInfo($request, $ainfo)
    {
        $ClaimInfo = ClaimInfo::create(
            [
                'lokasi_pertanggungan' => $ainfo->valuedesc1 . ',' . $ainfo->valuedesc2,
                'penyebab_kerugian' => $request->penyebab_kerugian,
                'tanggal_kerugian' => $request->tanggal_kerugian,
                'waktu_kerugian' => $request->waktu_kerugian,
                'kronologi' => $request->kronologi,
                'okupasi_harta_peristiwa' => $request->okupasi_harta_peristiwa,
                'harta_tercantum_polis' => $request->harta_tercantum_polis,
                'perubahan_okupasi_harta' => $request->perubahan_okupasi_harta,
                'nilai_sebelum_peristiwa' => $request->nilai_sebelum_peristiwa,
                'nilai_setelah_peristiwa' => $request->nilai_setelah_peristiwa,
                'pernah_terjadi_kerugian' => $request->pernah_terjadi_kerugian,
                'memiliki_asuransi_lain' => $request->memiliki_asuransi_lain,
                'syarat_terpenuhi' => $request->syarat_terpenuhi,
                'pihaklain_terhadap_harta' => $request->pihaklain_terhadap_harta,
                'keterangan' => $request->keterangan
            ]
        );
        return $ClaimInfo->id;
    }

    public function show($id)
    {
        $data = ClaimAcceptance::with('info')->findOrFail($id);

        return ResponseFormatter::success([
            $data
        ], 'oke');
    }

    public function all()
    {
        $akseptasi = ClaimAcceptance::with('info')->latest()->get();
        return ResponseFormatter::success([
            $akseptasi
        ], 'oke');
    }
}
