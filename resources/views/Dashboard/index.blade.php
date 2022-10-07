@extends('master')

@section('breadcrumb')
<div class="mr-auto w-p50">
    <h3 class="page-title border-0">Dashboard</h3>
</div>
@endsection

@section('content')

{{-- Dashboard 1 --}}

<div class="row">
    <div class="col-xl-4">
        <!--begin::Stats Widget 13-->
        <a href="{{ url('/') }}" class="card card-custom bg-hover-state-danger card-stretch gutter-b">
            <!--begin::Body-->
            <div class="card-body">
                <span class="svg-icon svg-icon-white svg-icon-3x ml-n1">
                    <!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Media/Equalizer.svg-->
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <rect x="0" y="0" width="24" height="24" />
                            <rect fill="#000000" opacity="0.3" x="13" y="4" width="3" height="16" rx="1.5" />
                            <rect fill="#000000" x="8" y="9" width="3" height="11" rx="1.5" />
                            <rect fill="#000000" x="18" y="11" width="3" height="9" rx="1.5" />
                            <rect fill="#000000" x="3" y="13" width="3" height="7" rx="1.5" />
                        </g>
                    </svg>
                    <!--end::Svg Icon-->
                </span>
                <h5> {{$acWaiting}} / Pengajuan</h5>
                <div class="text-inverse-danger font-weight-bolder font-size-h5 mb-2 mt-5">
                    Submit SPPA
                </div>
                <div class="font-weight-bold text-inverse-danger font-size-lg" id="todayData">
                    {{-- today data --}}
                </div>
            </div>
            <!--end::Body-->
        </a>
        <!--end::Stats Widget 13-->
    </div>
    <div class="col-xl-4">
        <!--begin::Stats Widget 13-->
        <a href="{{url('claim')}}" class="card card-custom bg-hover-state-warning card-stretch gutter-b">
            <!--begin::Body-->
            <div class="card-body">
                <span class="svg-icon svg-icon-white svg-icon-3x ml-n1">
                    <!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Media/Equalizer.svg-->
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <rect x="0" y="0" width="24" height="24" />
                            <rect fill="#000000" opacity="0.3" x="13" y="4" width="3" height="16" rx="1.5" />
                            <rect fill="#000000" x="8" y="9" width="3" height="11" rx="1.5" />
                            <rect fill="#000000" x="18" y="11" width="3" height="9" rx="1.5" />
                            <rect fill="#000000" x="3" y="13" width="3" height="7" rx="1.5" />
                        </g>
                    </svg>
                    <!--end::Svg Icon-->
                </span>
                <h5> {{ $claimWaiting }} / Pengajuan</h5>
                <div class="text-inverse-warning font-weight-bolder font-size-h5 mb-2 mt-5">
                    Claim
                </div>
                <div class="font-weight-bold text-inverse-warning font-size-lg" id="weekData">
                    {{-- week data --}}
                </div>
            </div>
            <!--end::Body-->
        </a>
        <!--end::Stats Widget 13-->
    </div>

</div>
</div>


@endsection