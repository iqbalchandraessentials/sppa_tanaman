@extends('master')

@section('breadcrumb')
<div class="mr-auto w-p50">
    <h3 class="page-title border-0">List Submit Claim</h3>
</div>
@endsection


@section('content')

<div class="row">
    <div class="col-12">
        <div class="box">
            <div class="box-header">
                <div class="row">
                    <div class="col-6 text-left">
                        <h4 class="box-title">Submit Claim List</h4>
                    </div>
                    <div class="col-6 text-right">
                        <a href="" class="btn btn-bold btn-pure btn-info">Add New</a>
                    </div>
                </div>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-striped dataTables">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-left">Regno</th>
                                <th class="text-left text-nowrap">Nama tertanggung</th>
                                <th class="text-left text-nowrap">Lokasi</th>
                                <th class="text-left text-nowrap">Waktu kejadian</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $no = 1;
                            @endphp
                            @foreach ($data as $item)
                            <tr>
                                <td class="text-center">{{$no}}</td>
                                <td class="text-left text-nowrap">{{$item->no_polis}}</td>
                                <td class="text-left">{{$item->nama}}</td>
                                <td class="text-left">{{$item->info->lokasi_pertanggungan}}</td>
                                <td class="text-left">{{$item->info->tanggal_kerugian}}</td>
                                <td class="text-center text-success text-lowercase">
                                    @if($item->approval == "W")
                                    <span class="badge badge-dark">
                                        Waiting
                                    </span>
                                    @elseif($item->approval == "Y")
                                    <span class="badge badge-success">
                                        Approved
                                    </span>
                                    @else
                                    <span class="badge badge-danger">
                                        Reject
                                    </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($item->approval == "W")
                                    <a href="{{url('claim/'.$item->id)}}" class="ml-3" title="View">
                                        <i class="ti-eye"></i>
                                    </a>
                                    <a href="{{url('claim/Y/'.$item->id)}}" title="Approve" onclick="return confirm('Are you sure?')">
                                        <i class="ti-check-box"></i>
                                    </a>
                                    <a href="{{url('claim/N/'.$item->id)}}" class="ml-3" title="Reject" onclick="return confirm('Are you sure?')">
                                        <i class="ti-close"></i>
                                    </a>
                                    @else
                                    <a href="{{url('claim/'.$item->id)}}" class="ml-3" title="View">
                                        <i class="ti-eye"></i>
                                    </a>
                                    @endif
                                </td>

                            </tr>
                            @php
                            $no++;
                            @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection