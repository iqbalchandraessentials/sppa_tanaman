<?php

namespace App\Http\Controllers;

use App\Models\SPPA\Acceptance;
use App\Models\SPPA\Client;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class SppaController extends Controller
{

    public function view()
    {
        $data = Acceptance::with(['ainfo', 'r_cover', 'i_cover', 'customer', 'payment', 'client'])->latest()->get();
        return view(
            'MeetingRoom.index',
            [
                'data' => $data,
            ]
        );
    }

    public function show($id)
    {
        $sppa = Acceptance::with(['client', 'customer', 'ainfo', 'r_cover', 'payment', 'i_cover'])->findOrFail($id);

        return view('MeetingRoom.show')->with([
            'sppa' => $sppa,
            'client' => $sppa->client,
            'ainfo' => $sppa->ainfo,
            'i_cover' => $sppa->i_cover,
            'r_cover' => $sppa->r_cover,
            'customer' => $sppa->customer,
        ]);
    }


    public function akseptasi($request, $id)
    {
        $item = Acceptance::find($id);
        $item->approval = $request;
        $item->save();
        return Redirect::to(url('http://localhost/jth2h-app/public/sppa'));
    }
}
