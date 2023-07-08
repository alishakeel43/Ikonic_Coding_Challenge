<?php

namespace App\Http\Controllers;

use App\Models\Connection as ModelsConnection;
use App\Models\User;
use App\View\Components\Connection;
use App\View\Components\ConnectionInCommon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConnectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $connections = $user->connections->paginate(10);
        $currentPage = $connections->currentPage();
        $newPageUrl = $connections->nextPageUrl();


        // $extraData = ['currentPage' => $currentPage , 'newPageUrl' =>$newPageUrl];
        $obj = new Connection($connections);
        $view = $obj->render()->with($obj->data())->render();
        if($request->ajax())
        {
         return response()->json([
             'content' => $view,
             'currentPage' => $currentPage ,
             'newPageUrl' =>$newPageUrl,
             'suggestionsTotal' => $user->suggestions->count(),
             'sendRequestTotal' => $user->sendRequests->count(),
             'receiveRequestTotal' => $user->receiveRequests->count(),
             'connectionsTotal' => $connections->total(),
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
        $user = User::where('id', $id)->first();
        
        $connections = $user->connections->paginate(10);
        $currentPage = $connections->currentPage();
        $newPageUrl = $connections->nextPageUrl();


        // $extraData = ['currentPage' => $currentPage , 'newPageUrl' =>$newPageUrl];
        $obj = new ConnectionInCommon($connections);
        $view = $obj->render()->with($obj->data())->render();
    
         return response()->json([
             'content' => $view,
             'currentPage' => $currentPage ,
             'newPageUrl' =>$newPageUrl,
             'suggestionsTotal' => $user->suggestions->count(),
             'sendRequestTotal' => $user->sendRequests->count(),
             'receiveRequestTotal' => $user->receiveRequests->count(),
             'connectionsTotal' => $connections->total(),
         ]);

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

        $user = Auth::user();
        
        $sendRequestDelete = ModelsConnection::where(['sender_user_id' => $user->id, 'receiver_user_id'=>$id,'status'=>'approved'])
                ->Where(['receiver_user_id' => $user->id, 'sender_user_id'=>$id,'status'=>'approved'])->delete();

        $connectionDelete =  ModelsConnection::where(function($query) use ($user){
                                        $query->where('sender_user_id','=',$user->id)
                                            ->orWhere('receiver_user_id','=',$user->id);
                                    })
                                    ->where(function($query) use($id) {
                                        $query->where('sender_user_id','=',$id)
                                            ->orWhere('receiver_user_id','=',$id);
                                    })
                                    ->where('status','=','approved')->delete();

        $suggestions = $user->suggestions->count();
        $connections = $user->connections->get()->count();
        return response()->json([
            'connectionDelete' => $connectionDelete,
            'suggestions' => $suggestions,
            'connections' => $connections,

        ]);
        //
    }
}
