<?php

namespace App\Http\Controllers;

use App\Models\Claim\ClaimAcceptance;
use App\Models\SPPA\Acceptance;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function view()
    {
        $acc = Acceptance::get();
        $claim = ClaimAcceptance::get();
        return view('Dashboard.index')->with([
            'acWaiting' => $acc->where('approval', 'W')->count(),
            'acAll' => $acc->count(),
            'claim' => $claim->count(),
            'claimWaiting' => $claim->where('approval', 'W')->count(),
            'claimProgress' => $claim->where('approval', 'P')->count(),
        ]);
    }
}
