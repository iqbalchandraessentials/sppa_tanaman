<?php

namespace App\Http\Controllers;

use App\Models\Claim\ClaimAcceptance;
use App\Models\SPPA\Acceptance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ClaimContoller extends Controller
{


    public function view()
    {
        $data = ClaimAcceptance::with(['info', 'Acceptance'])->latest()->get();
        return view(
            'Claim.index',
            [
                'data' => $data,
            ]
        );
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = ClaimAcceptance::with(['info', 'Acceptance'])->findOrFail($id);
        return view('Claim.show')->with([
            'claim' => $data,
            'acceptance' => $data->Acceptance
        ]);
    }

    public function akseptasi($request, $id)
    {
        $item = ClaimAcceptance::find($id);
        $item->approval = $request;
        $item->save();
        return Redirect::to('http://localhost/jth2h-app/public/claim');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
