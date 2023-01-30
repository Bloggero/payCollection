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
        if (isset($request->type)) {
            switch ($request->type) {
                case 'post':
                    $requestToArray = $request;
                    $request = CollectionController::newCollection($requestToArray);
                    break;
                case 'get':
                    $request = CollectionController::show($request->user_id);
                    break;
                case 'update':
                    $request = CollectionController::update($request->collection);
                    break;
                default:
                    $request = response()->json(['success' => false]);
                    break;
            }
            return $request;
        } else {

            $paidData = Collection::where('pay', '1')->orderBy('id', 'desc')->get();/*use username in the element for foreing key*/
            $payData = Collection::where('pay', '0')->orderBy('id', 'desc')->get();/*use username in the element for foreing key*/

            $getUsers = User::orderBy('id', 'desc')->get();
            return view(
                'admin.dashboard',
                [
                    'paidData' => $paidData,
                    'payData' => $payData,
                    'users' => $getUsers
                ]
            );
        }
    }

    /**
     * New Collection is here, first create a new user
     *
     * @return \Illuminate\Http\Response
     */
    public function newCollection($request)
    {
        //segun el curso de laravel 6 se guardan los datos en store y ahí se hacen las validaciones con $request->validate([])
        if ($request->user != 'nothing') {
            $response = CollectionController::store($request, $request['user']);
            $lastInsert = Collection::latest()->first();
            $user = User::find($request->user);

            return response()->json([
                'success' => $response,
                'user_id' => $user->id,
                'name' => $user->name,
                'itemId' => $lastInsert->id
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
        $response = CollectionController::store($request, $createNewUser->id);
        $lastInsert = Collection::latest()->first();


        return response()->json([
            'success' => $response,
            'user_id' => $createNewUser->id,
            'name' => $createNewUser->name,
            'itemId' => $lastInsert->id
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store($request, $user)
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
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        //
        $response = Collection::findOrFail($id);
        $user = User::find($response->user_id);
        $response->pay = 1;
            return response()->json([
                'success' => $response->save(),
                'user_id' => $response->user_id,
                'name' => $user->name,
                'description' => $response->description,
                'amount' => $response->amount,
                'itemId' => $response->id
            ]);
        
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
