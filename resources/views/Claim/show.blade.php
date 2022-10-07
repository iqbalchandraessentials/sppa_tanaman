@extends('master')

@section('breadcrumb')
<div class="mr-auto w-p50">

    <h3 class="page-title border-0">Information Data Claim</h3>

</div>
@endsection


@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- /.col-md-6 -->
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="m-0">Informasi Registrasi Claim</h5>
                </div>
                <div class="card-body">

                    <table class="table table-hover">
                        <tr>
                            <td>Nomor Polis</td>
                            <td>:</td>
                            <td>{{$claim->no_polis}}</td>
                        </tr>
                        <tr>
                            <td>Nama Produk</td>
                            <td>:</td>
                            <td>{{$acceptance->i_cover->description}}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Pengajuan Claim</td>
                            <td>:</td>
                            <td>{{\Carbon\Carbon::parse($claim->created_at)->format('d M Y')}}
                            </td>
                        </tr>
                        <tr>
                            <td>Nama Tertanggung</td>
                            <td>:</td>
                            <td>{{$claim->nama}}</td>
                        </tr>
                        <tr>
                            <td>Alamat Pertanggungan</td>
                            <td>:</td>
                            <td>{{$claim->info->lokasi_pertanggungan}}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Kerugian</td>
                            <td>:</td>
                            <td>{{\Carbon\Carbon::parse($claim->info->tanggal_kerugian)->format('d M Y')}}
                            </td>
                        </tr>
                        <tr>
                            <td>Penyebab Kerugian</td>
                            <td>:</td>
                            <td>{{$claim->info->penyebab_kerugian}}</td>
                        </tr>
                        <tr>
                            <td>Kronologi Kerugian</td>
                            <td>:</td>
                            <td>{{$claim->info->kronologi}}</td>
                        </tr>
                        <tr>
                            <td>Okupasi Harta Peristiwa</td>
                            <td>:</td>
                            <td>{{$claim->info->okupasi_harta_peristiwa}}</td>
                        </tr>
                        <tr>
                            <td>Harta Tercantum Polis</td>
                            <td>:</td>
                            <td>{{ number_format($claim->info->harta_tercantum_polis , 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Perubahan Okupasi Harta</td>
                            <td>:</td>
                            <td>{{$claim->info->perubahan_okupasi_harta}}</td>
                        </tr>
                        <tr>
                            <td>Nilai Sebelum Peristiwa</td>
                            <td>:</td>
                            <td>{{ number_format($claim->info->nilai_sebelum_peristiwa , 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Nilai Setelah Peristiwa</td>
                            <td>:</td>
                            <td>{{ number_format($claim->info->nilai_setelah_peristiwa , 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Pernah Terjadi Kerugian</td>
                            <td>:</td>
                            <td>{{$claim->info->pernah_terjadi_kerugian}}</td>
                        </tr>
                        <tr>
                            <td>Memiliki Asuransi Lain</td>
                            <td>:</td>
                            <td>{{$claim->info->memiliki_asuransi_lain}}</td>
                        </tr>
                        <tr>
                            <td>Syarat Terpenuhi</td>
                            <td>:</td>
                            <td>{{$claim->info->syarat_terpenuhi}}</td>
                        </tr>
                        <tr>
                            <td>Pihak Lain Terhadap Harta</td>
                            <td>:</td>
                            <td>{{$claim->info->pihaklain_terhadap_harta}}</td>
                        </tr>
                        <img src="/core/" alt="" srcset="">
                        <tr>
                            <td>File Polis</td>
                            <td>:</td>
                            <td>
                                <a href="{{url(Storage::url($claim->file_polis))}}" target="_blank">
                                    Link File
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>Berita Acara</td>
                            <td>:</td>
                            <td>
                                <a href="{{url(Storage::url($claim->berita_acara))}}" target="_blank">
                                    Link File
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>Informasi Tambahan</td>
                            <td>:</td>
                            <td>{{$claim->info->keterangan}}</td>
                        </tr>
                        <tr>
                            <td>Status Pengajuan</td>
                            <td>:</td>
                            <td>
                                @if($claim->approval == "W")
                                <span class="badge badge-dark">
                                    Waiting
                                </span>
                                @elseif($claim->approval == "Y")
                                <span class="badge badge-success">
                                    Approved
                                </span>
                                @else
                                <span class="badge badge-danger">
                                    Reject
                                </span>
                                @endif
                            </td>
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
                            <td>{{ $acceptance->client->name}}</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>:</td>
                            <td>{{ $acceptance->client->email}}</td>
                        </tr>
                        <tr>
                            <td>No Telepon</td>
                            <td>:</td>
                            <td>{{ $acceptance->client->phone}}</td>
                        </tr>
                        <tr>
                            <td>Alaman Lengkap</td>
                            <td>:</td>
                            <td>{{ $acceptance->client->address}}</td>
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
                            <td>{{ $acceptance->ainfo->valueid1}}</td>
                            <td>:</td>
                            <td>{{ $acceptance->ainfo->valuedesc1}}</td>
                        </tr>

                        <tr>
                            <td>{{ $acceptance->ainfo->valueid2}}</td>
                            <td>:</td>
                            <td>{{ $acceptance->ainfo->valuedesc2}}</td>
                        </tr>

                        <tr>
                            <td>{{ $acceptance->ainfo->valueid3}}</td>
                            <td>:</td>
                            <td>{{ $acceptance->ainfo->valuedesc3}}</td>
                        </tr>
                        <tr>
                            <td>{{ $acceptance->ainfo->valueid4}}</td>
                            <td>:</td>
                            <td>{{ $acceptance->ainfo->valuedesc4}}</td>
                        </tr>

                        <tr>
                            <td>{{ $acceptance->ainfo->valueid5}}</td>
                            <td>:</td>
                            <td>{{ $acceptance->ainfo->valuedesc5}}</td>
                        </tr>
                        <tr>
                            <td>{{ $acceptance->ainfo->valueid6}}</td>
                            <td>:</td>
                            <td>{{ $acceptance->ainfo->valuedesc6}}</td>
                        </tr>
                        <tr>
                            <td>{{ $acceptance->ainfo->valueid7}}</td>
                            <td>:</td>
                            <td>{{ $acceptance->ainfo->valuedesc7}}</td>
                        </tr>

                        <tr>
                            <td>{{ $acceptance->ainfo->valueid8}}</td>
                            <td>:</td>
                            <td>{{ $acceptance->ainfo->valuedesc8}}</td>
                        </tr>
                        <tr>
                            <td>{{ $acceptance->ainfo->valueid9}}</td>
                            <td>:</td>
                            <td>{{ $acceptance->ainfo->valuedesc9}}</td>
                        </tr>
                        <tr>
                            <td>{{ $acceptance->ainfo->valueid10}}</td>
                            <td>:</td>
                            <td>{{ $acceptance->ainfo->valuedesc10}}</td>
                        </tr>

                        <tr>
                            <td>{{ $acceptance->ainfo->valueid11}}</td>
                            <td>:</td>
                            <td>{{ $acceptance->ainfo->valuedesc11}}</td>
                        </tr>
                        <tr>
                            <td>{{ $acceptance->ainfo->valueid12}}</td>
                            <td>:</td>
                            <td>{{ $acceptance->ainfo->valuedesc12}}</td>
                        </tr>
                        <tr>
                            <td>{{ $acceptance->ainfo->valueid13}}</td>
                            <td>:</td>
                            <td>{{ $acceptance->ainfo->valuedesc13}}</td>
                        </tr>
                        <tr>
                            <td>{{ $acceptance->ainfo->valueid14}}</td>
                            <td>:</td>
                            <td>{{ $acceptance->ainfo->valuedesc14}}</td>
                        </tr>
                        <tr>
                            <td>{{ $acceptance->ainfo->valueid15}}</td>
                            <td>:</td>
                            <td>{{ $acceptance->ainfo->valuedesc15}}</td>
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
                            <td>{{ $acceptance->customer->name}}</td>
                        </tr>
                        <tr>
                            <td>Tempat & Tgl Lahir</td>
                            <td>:</td>
                            <td>{{ $acceptance->customer->place_of_birth}},
                                {{\Carbon\Carbon::parse($acceptance->customer->date_of_birth)->format('d M Y')}}
                            </td>
                        </tr>
                        <tr>
                            <td>No. {{$acceptance->customer->identity_type}}</td>
                            <td>:</td>
                            <td>{{ $acceptance->customer->identity_no}}</td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>:</td>
                            <td>{{ $acceptance->customer->address}}</td>
                        </tr>
                        <tr>
                            <td>Telepon Rumah</td>
                            <td>:</td>
                            <td>{{ $acceptance->customer->home_phone}}</td>
                        </tr>
                        <tr>
                            <td>Telepon Kantor</td>
                            <td>:</td>
                            <td>{{ $acceptance->customer->home_phone}}</td>
                        </tr>
                        <tr>
                            <td>Telepon Rumah</td>
                            <td>:</td>
                            <td>{{ $acceptance->customer->office_phone}}</td>
                        </tr>
                        <tr>
                            <td>Handphone</td>
                            <td>:</td>
                            <td>{{ $acceptance->customer->handphone}}</td>
                        </tr>
                        <tr>
                            <td>No. Faximile</td>
                            <td>:</td>
                            <td>{{ $acceptance->customer->fax_no}}</td>
                        </tr>
                        <tr>
                            <td>No. NPWP</td>
                            <td>:</td>
                            <td>{{ $acceptance->customer->npwp}}</td>
                        </tr>
                        <tr>
                            <td>Kewarganegaraan</td>
                            <td>:</td>
                            <td>{{ $acceptance->customer->citizen}}</td>
                        </tr>
                        <tr>
                            <td>Sumber Dana</td>
                            <td>:</td>
                            <td>{{ $acceptance->customer->source_premium_payment}}</td>
                        </tr>
                        <tr>
                            <td>{{ $acceptance->customer->valueid1}}</td>
                            <td>:</td>
                            <td>{{ $acceptance->customer->valuedesc1}}</td>
                        </tr>
                        <tr>
                            <td>{{ $acceptance->customer->valueid2}}</td>
                            <td>:</td>
                            <td>{{ $acceptance->customer->valuedesc2}}</td>
                        </tr>
                        <tr>
                            <td>{{ $acceptance->customer->valueid3}}</td>
                            <td>:</td>
                            <td>{{ $acceptance->customer->valuedesc3}}</td>
                        </tr>
                        <tr>
                            <td>{{ $acceptance->customer->valueid4}}</td>
                            <td>:</td>
                            <td>{{ $acceptance->customer->valuedesc4}}</td>
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
                                @foreach ($acceptance->r_cover as $item)
                                <tr>
                                    <td>{{ $item->description}}</td>
                                    <td>{{ $item->rate}}%</td>
                                    <td>{{ $item->unit}}</td>
                                    <td>{{ $item->scaling}}%</td>
                                    <td style="text-align: right;">{{ $item->premium,}}</td>
                                    <td>{{\Carbon\Carbon::parse($item->sdate)->format('d M Y')}} -
                                        {{\Carbon\Carbon::parse($item->edate)->format('d M Y')}}
                                    </td>
                                    <td>{{ $item->scaling}}%</td>

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