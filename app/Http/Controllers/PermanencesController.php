<?php

namespace App\Http\Controllers;

use App\Models\Permanence;
use Illuminate\Http\Request;

class PermanencesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!$request) {
        }
        $year = $request->year;
        $quarter = $request->quarter;
        // $year = 2020;
        // $quarter = 1;
        // $permanences = Permanence::all();

        $permanences = Permanence::where('year', $year)->where('quarter', $quarter)->with(array('user' => function ($query) {
            $query->select('id', 'name', 'email');
        }))->get()->groupBy(['year', 'quarter']);

        // $permanences = Permanence::where('year', $year)->where('quarter', $quarter)->get();
        // $permanences = Permanence::where('year', $year)->where('quarter', $quarter)->get()->groupBy('user_id');
        // $permanences = Permanence::where('year', $year)->where('quarter', $quarter)->get()->groupBy(['2020', 'year']);

        // $permanences = Permanence::where('year', $year)->where('quarter', $quarter)->with(array('user' => function ($query) {
        //     $query->select('id', 'name', 'email');
        // }))->get();

        return response()->json($permanences);
        // return response()->json($request->year);
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
     * @param  \App\Models\Permanence  $permanence
     * @return \Illuminate\Http\Response
     */
    public function show(Permanence $permanence)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Permanence  $permanence
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permanence $permanence)
    {
        // return response()->json($request);
        // var_dump($permanence->week1_attr);
        // $updatedPermanence = Permanence::find($request->id);
        // $updatedPermanence = Permanence::find($request->id);
        // $permanence->update(['week1_attr' => 10]);
        $permanence->update($request->all());

        // $permanence->year = $request->year;
        // $permanence->quarter = $request->quarter;
        // $permanence->month = $request->month;
        // $permanence->week1_dispo = $request->week1_dispo;
        // $permanence->week1_attr = $request->week1_attr;
        // $permanence->week1_dispo = $request->week1_dispo;
        // $permanence->week2_attr = $request->week2_attr;
        // $permanence->week2_dispo = $request->week2_dispo;
        // $permanence->week2_attr = $request->week2_attr;
        // $permanence->week3_dispo = $request->week3_dispo;
        // $permanence->week3_attr = $request->week3_attr;
        // $permanence->week3_dispo = $request->week3_dispo;
        // $permanence->week4_attr = $request->week4_attr;
        // $permanence->week4_attr = $request->week4_attr;
        // $permanence->week4_attr = $request->week4_attr;
        // $permanence->week5_attr = $request->week5_attr;
        // $permanence->week5_attr = $request->week5_attr;
        // $permanence->week5_attr = $request->week5_attr;
        // $permanence->week1_attr = 10;

        $permanence->save();

        return response()->json($permanence);
        // return response()->json($request->week1_attr);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Permanence  $permanence
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permanence $permanence)
    {
        //
    }
}
