@extends('master')

@section('breadcrumb')
<div class="mr-auto w-p50">
    <h3 class="page-title border-0">Growing Trees Insurance (Asuransi Tanaman)</h3>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- /.col-md-6 -->
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="m-0">Informasi Registrasi SPPA</h5>
                </div>
                <div class="card-body">

                    <table class="table table-hover">
                        <tr>
                            <td>Nomor Registrasi</td>
                            <td>:</td>
                            <td>{{$sppa->regno}}</td>
                        </tr>
                        <tr>
                            <td>Nomor Polis</td>
                            <td>:</td>
                            <td>{{$sppa->policy_no}}</td>
                        </tr>
                        <tr>
                            <td>Periode Polis</td>
                            <td>:</td>
                            <td>{{\Carbon\Carbon::parse($sppa->sdate)->format('d M Y')}} s/d
                                {{\Carbon\Carbon::parse($sppa->edate)->format('d M Y')}}
                            </td>
                        </tr>
                        <tr>
                            <td>Nama Produk</td>
                            <td>:</td>
                            <td>{{getProductId($sppa->product_id)->product_name}}</td>
                        </tr>
                        <tr>
                            <td>Nilai Harga Pertanggungan</td>
                            <td>:</td>
                            <td>{{formatRupiah($i_cover->tsi,2)}}</td>

                        </tr>
                        <tr>
                            <td>Status Pengajuan</td>
                            <td>:</td>
                            <td>{!!getSppaStatus($sppa->approval)!!}</td>
                        </tr>
                    </table>


                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="m-0">Informasi Klien</h5>
                </div>
                <div class="card-body">

                    <table class="table table-hover">
                        <tr>
                            <td>Nama Client</td>
                            <td>:</td>
                            <td>{{$client->name}}</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>:</td>
                            <td>{{$client->email}}</td>
                        </tr>
                        <tr>
                            <td>No Telepon</td>
                            <td>:</td>
                            <td>{{$client->phone}}</td>
                        </tr>
                        <tr>
                            <td>Alaman Lengkap</td>
                            <td>:</td>
                            <td>{{$client->address}}</td>
                        </tr>
                    </table>

                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="m-0">Objek Informasi</h5>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <tr>
                            <td>{{$ainfo->valueid1}}</td>
                            <td>:</td>
                            <td>{{$ainfo->valuedesc1}}</td>
                        </tr>

                        <tr>
                            <td>{{$ainfo->valueid2}}</td>
                            <td>:</td>
                            <td>{{$ainfo->valuedesc2}}</td>
                        </tr>

                        <tr>
                            <td>{{$ainfo->valueid3}}</td>
                            <td>:</td>
                            <td>{{$ainfo->valuedesc3}}</td>
                        </tr>
                        <tr>
                            <td>{{$ainfo->valueid4}}</td>
                            <td>:</td>
                            <td>{{$ainfo->valuedesc4}}</td>
                        </tr>

                        <tr>
                            <td>{{$ainfo->valueid5}}</td>
                            <td>:</td>
                            <td>{{$ainfo->valuedesc5}}</td>
                        </tr>
                        <tr>
                            <td>{{$ainfo->valueid6}}</td>
                            <td>:</td>
                            <td>{{$ainfo->valuedesc6}}</td>
                        </tr>
                        <tr>
                            <td>{{$ainfo->valueid7}}</td>
                            <td>:</td>
                            <td>{{$ainfo->valuedesc7}}</td>
                        </tr>

                        <tr>
                            <td>{{$ainfo->valueid8}}</td>
                            <td>:</td>
                            <td>{{$ainfo->valuedesc8}}</td>
                        </tr>
                        <tr>
                            <td>{{$ainfo->valueid9}}</td>
                            <td>:</td>
                            <td>{{$ainfo->valuedesc9}}</td>
                        </tr>
                        <tr>
                            <td>{{$ainfo->valueid10}}</td>
                            <td>:</td>
                            <td>{{$ainfo->valuedesc10}}</td>
                        </tr>

                        <tr>
                            <td>{{$ainfo->valueid11}}</td>
                            <td>:</td>
                            <td>{{$ainfo->valuedesc11}}</td>
                        </tr>
                        <tr>
                            <td>{{$ainfo->valueid12}}</td>
                            <td>:</td>
                            <td>{{$ainfo->valuedesc12}}</td>
                        </tr>
                        <tr>
                            <td>{{$ainfo->valueid13}}</td>
                            <td>:</td>
                            <td>{{$ainfo->valuedesc13}}</td>
                        </tr>
                        <tr>
                            <td>{{$ainfo->valueid14}}</td>
                            <td>:</td>
                            <td>{{$ainfo->valuedesc14}}</td>
                        </tr>
                        <tr>
                            <td>{{$ainfo->valueid15}}</td>
                            <td>:</td>
                            <td>{{$ainfo->valuedesc15}}</td>
                        </tr>
                    </table>

                </div>
            </div>

        </div>
        <div class="col-md-6">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="m-0">Informasi Data Tertanggung</h5>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <tr>
                            <td>Nama Tertanggung</td>
                            <td>:</td>
                            <td>{{$customer->name}}</td>
                        </tr>
                        <tr>
                            <td>Tempat & Tgl Lahir</td>
                            <td>:</td>
                            <td>{{$customer->place_of_birth}},
                                {{\Carbon\Carbon::parse($customer->date_of_birth)->format('d M Y')}}
                            </td>
                        </tr>
                        <tr>
                            <td>No. {{$customer->identity_type}}</td>
                            <td>:</td>
                            <td>{{$customer->identity_no}}</td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>:</td>
                            <td>{{$customer->address}}</td>
                        </tr>
                        <tr>
                            <td>Telepon Rumah</td>
                            <td>:</td>
                            <td>{{$customer->home_phone}}</td>
                        </tr>
                        <tr>
                            <td>Telepon Kantor</td>
                            <td>:</td>
                            <td>{{$customer->home_phone}}</td>
                        </tr>
                        <tr>
                            <td>Telepon Rumah</td>
                            <td>:</td>
                            <td>{{$customer->office_phone}}</td>
                        </tr>
                        <tr>
                            <td>Handphone</td>
                            <td>:</td>
                            <td>{{$customer->handphone}}</td>
                        </tr>
                        <tr>
                            <td>No. Faximile</td>
                            <td>:</td>
                            <td>{{$customer->fax_no}}</td>
                        </tr>
                        <tr>
                            <td>No. NPWP</td>
                            <td>:</td>
                            <td>{{$customer->npwp}}</td>
                        </tr>
                        <tr>
                            <td>Kewarganegaraan</td>
                            <td>:</td>
                            <td>{{$customer->citizen}}</td>
                        </tr>
                        <tr>
                            <td>Sumber Dana</td>
                            <td>:</td>
                            <td>{{$customer->source_premium_payment}}</td>
                        </tr>
                        <tr>
                            <td>{{$customer->valueid1}}</td>
                            <td>:</td>
                            <td>{{$customer->valuedesc1}}</td>
                        </tr>
                        <tr>
                            <td>{{$customer->valueid2}}</td>
                            <td>:</td>
                            <td>{{$customer->valuedesc2}}</td>
                        </tr>
                        <tr>
                            <td>{{$customer->valueid3}}</td>
                            <td>:</td>
                            <td>{{$customer->valuedesc3}}</td>
                        </tr>
                        <tr>
                            <td>{{$customer->valueid4}}</td>
                            <td>:</td>
                            <td>{{$customer->valuedesc4}}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="m-0">Informasi Resiko dan Perluasan</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Deskripsi</th>
                                    <th>Rate</th>
                                    <th>Unit</th>
                                    <th>Scaling</th>
                                    <th>Premi</th>
                                    <th>Periode</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($r_cover as $item)
                                <tr>
                                    <td>{{$item->description}}</td>
                                    <td>{{$item->rate}}%</td>
                                    <td>{{$item->unit}}</td>
                                    <td>{{$item->scaling}}%</td>
                                    <td style="text-align: right;">{{ formatRupiah($item->premium, 2)}}</td>
                                    <td>{{\Carbon\Carbon::parse($item->sdate)->format('d M Y')}} -
                                        {{\Carbon\Carbon::parse($item->edate)->format('d M Y')}}
                                    </td>
                                    <td>{{ link_to_route('frontend.app.memo.edit', 'Edit', [$item->id], ['class' => 'btn btn-info btn-sm']) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection