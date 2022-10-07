@extends('master')

@section('breadcrumb')
<div class="mr-auto w-p50">
    <h3 class="page-title border-0">Growing Trees Insurance (Asuransi Tanaman)</h3>
</div>
@endsection

@section('content')

<div class="row">
    <div class="col-12">
        <div class="box">
            <div class="box-header">
                <div class="row">
                    <div class="col-6 text-left">
                        <h4 class="box-title">SPPA GTI List</h4>
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
                                <th class="text-left">TSI</th>
                                <th class="text-left text-nowrap">tanggal mulai</th>
                                <th class="text-left text-nowrap">tanggal akhir </th>
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
                                <td class="text-left text-nowrap">{{$item->regno}}</td>
                                <td class="text-left">{{$item->customer->name}}</td>
                                <td class="text-left">{{$item->i_cover->tsi}}</td>
                                <td class="text-left">{{ $item->sdate}}</td>
                                <td class="text-left">{{$item->edate}}</td>
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
                                    <a href="{{url('show/'.$item->id)}}" class="ml-3" title="View">
                                        <i class="ti-eye"></i>
                                    </a>
                                    <a href="{{url('akseptasi/Y/'.$item->id)}}" title="Approve" onclick="return confirm('Are you sure?')">
                                        <i class="ti-check-box"></i>
                                    </a>
                                    <a href="{{url('akseptasi/N/'.$item->id)}}" class="ml-3" title="Reject" onclick="return confirm('Are you sure?')">
                                        <i class="ti-close"></i>
                                    </a>
                                    @else
                                    <a href="{{url('show/'.$item->id)}}" class="ml-3" title="View">
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


<!-- <script>
    function reload() {
        $('#table').DataTable().ajax.reload();
    }

    function sendConfirmation(id) {
        Swal.fire({
            title: 'Setujui pengajuan SPPA Ini?',
            icon: 'question',
            showCancelButton: true,
            showDenyButton: true,
            confirmButtonText: 'Setujui',
            denyButtonText: 'Tolak Pengajuan',
            cancelButtonText: 'Batal!'
        }).then((result) => {
            if (result.isConfirmed) {

                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    type: 'POST',
                    url: "",
                    data: {
                        _token: CSRF_TOKEN,
                        id: id,
                        approval: 'Y'
                    },
                    dataType: 'JSON',
                    success: function(results) {
                        if (results.success === true) {
                            Swal.fire(
                                'Berhasil',
                                results.message,
                                'success'
                            )
                            reload();
                        }
                    }
                });
            } else if (result.isDenied) {
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    type: 'POST',
                    url: "",
                    data: {
                        _token: CSRF_TOKEN,
                        id: id,
                        approval: 'N'
                    },
                    dataType: 'JSON',
                    success: function(results) {
                        if (results.success === true) {
                            Swal.fire(
                                'Berhasil',
                                results.message,
                                'success'
                            )
                            reload();
                        }
                    }
                });
            }
        })
    }
</script> -->

@endsection