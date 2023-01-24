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

                    $fullDate   = $request->month . '-' . $request->year;


                    $lastItems = StatisticController::getLastDate($fullDate);



                    $response = Statistic::where('info_date', $fullDate)->get();
                    // $last = Statistic::where('info_date', $fullDate)->get();
                    $request = response()->json(['success' => true, 'items' => $response, 'lastItems' => $lastItems]);


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
            $thisMontItems = Statistic::where('info_date', Carbon::now()->format('m-Y'))->orderBy('id', 'desc')->get();
            $revenue = $thisMontItems->sum('pop_ads') + $thisMontItems->sum('other_ads');
            $expenses    = $thisMontItems->sum('links') + $thisMontItems->sum('referals');

            $lastItems = Statistic::where('info_date', StatisticController::getLastDate(Carbon::now()->format('m-Y')))->orderBy('id', 'desc')->get();
            $lastRevenue   = $lastItems->sum('pop_ads') + $lastItems->sum('other_ads');
            $lastExpenses    = $lastItems->sum('links') + $lastItems->sum('referals');

            return view('admin.statistics', [
                'items' => $thisMontItems,
                'revenue' => $revenue,
                'expenses' => $expenses,
                'lastRevenue' => $lastRevenue,
                'lastExpenses' => $lastExpenses,
            ]);

        }

    }


    static public function getLastDate($value){

                    /**
                     * To get the last month date, we need to substract the date 1 day
                     */
                    $lastItems  = date('01-'.$value);
                    $lastItems  = date('m-Y', strtotime($lastItems.'- 1 days'));
                    return $lastItems;

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
}
