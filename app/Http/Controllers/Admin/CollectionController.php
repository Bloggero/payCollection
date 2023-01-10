<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Collection;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class CollectionController extends Controller
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
                    $requestToArray = $request;
                    $request = CollectionController::newCollection($requestToArray);
                break;
                case 'get':
                    $request = CollectionController::show($request->user_id);
                break;
                default:
                    $request = response()->json(['success' => false]);
                break;
            }
            return $request;

        }else{
            
            $getData = Collection::orderBy('id', 'desc')->get();/*use username in the element for foreing key*/
            $getUsers = User::orderBy('id', 'desc')->get();
            return view('admin.dashboard', 
                        ['data' => $getData,
                        'users' => $getUsers]
                    );
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($request, $user)
    {
        $user_id = $user;
        $response = new Collection();
        $response->user_id      = $user_id;
        $response->description  = $request['description'];
        $response->amount       = $request['amount'];
        $response->credit_type  = $request['credit_type'];
        $response->time_type    = $request['time_type'];
        $response->date_info    = Date($request['date_info']);
        $response->extends      = $request['extends'] == 'true' ? 1 : 0;

        return $response->save();

    }

    /**
     * New Collection is here, first create a new user
     *
     * @return \Illuminate\Http\Response
     */
    public function newCollection($request)
    {

        if($request->user != 'nothing'){
            $request = CollectionController::create($request, $request['user']);
            
            return response()->json([
                'success' => $request, 
                'user_id' => '', 
                'name' => '', 
                'email' => ''
                ]);
        }

        $newEmail = Str::remove(' ', $request->name) . '@example.com';
        $thisDataForNewCollection = $request;
        try {
            $createNewUser = User::create([
                'name' => $request->name,
                'email' => $newEmail,
                'role' => 'member',
                'status' => '0',
                'password' => Hash::make(Str::random(40)),
            ]);
        } catch (\Throwable $th) {
            return false;
        }

        //en caso que si se ha guardado seguimos con el resto
        $request = CollectionController::create($request, $createNewUser->id);


            return response()->json([
                                    'success' => $request, 
                                    'user_id' => $createNewUser->id, 
                                    'name' => $createNewUser->name, 
                                    'email' => $createNewUser->email
                                    ]);




    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $response = Collection::orderBy('id', 'desc')->where('user_id', $id)->get();
        return response()->json(['success' => true, 'items' => $response]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Collection  $collection
     * @return \Illuminate\Http\Response
     */
    public function edit(Collection $collection)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Collection  $collection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Collection $collection)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Collection  $collection
     * @return \Illuminate\Http\Response
     */
    public function destroy(Collection $collection)
    {
        //
    }
}
