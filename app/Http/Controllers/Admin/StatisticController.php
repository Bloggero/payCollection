<?php

namespace App\Http\Controllers\Admin;


use Error;
use Carbon\Carbon;
use App\Models\Statistic;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class StatisticController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(isset($request->type)){
            switch ($request->type) {
                case 'post':
                    $request = StatisticController::store($request);
                    $request = response()->json(['success' => $request]);

                break;
                case 'get':

                    $fullDate  = $request->month . '-' . $request->year;



                    $response = Statistic::where('info_date', $fullDate)->get();
                    $request = response()->json(['success' => true, 'items' => $response]);


                    break;
                case 'update':
                    // $request = StatisticController::update($request->collection);
                break;
                default:
                    $request = response()->json(['success' => false]);
                break;
            }
            return $request;

        }else{
            return view('admin.statistics', [
                'items' => Statistic::where('info_date', Carbon::now()->format('m-Y'))->orderBy('id', 'desc')->get(),
            ]);

        }

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
        $response = new Statistic();
        $response->info_date = $request['info_date'];
        $response->links = $request['links'];
        $response->referals = $request['referals'];
        $response->pop_ads = $request['pop_ads'];
        $response->other_ads = $request['other_ads'];

        return $response->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Statistic  $statistic
     * @return \Illuminate\Http\Response
     */
    public function show(Statistic $statistic)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Statistic  $statistic
     * @return \Illuminate\Http\Response
     */
    public function edit(Statistic $statistic)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Statistic  $statistic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Statistic $statistic)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Statistic  $statistic
     * @return \Illuminate\Http\Response
     */
    public function destroy(Statistic $statistic)
    {
        //
    }
}
