<?php

namespace App\Http\Controllers;

use App\Models\Connection;
use App\View\Components\Request as ComponentsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReceiveRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $suggestions = $user->receiveRequests()->paginate(10);
        $currentPage = $suggestions->currentPage();
        $newPageUrl = $suggestions->nextPageUrl();


        // $extraData = ['currentPage' => $currentPage , 'newPageUrl' =>$newPageUrl];
        $obj = new ComponentsRequest('receive',$suggestions);
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
             'connectionsTotal' => $user->connections->get()->count(),
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
        //
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
        $user = Auth::user();
        $receiveRequestaccept = Connection::where('sender_user_id', $id)->where('receiver_user_id' , $user->id)->update(['status' => 'approved']);
        // ->update(['status'=>'approved']);
        // $connections = Connection::where('sender_user_id' , $user->id)->where('status',"approved")->count();
        // $receiveRequests = Connection::where([['receiver_user_id' => $user->id],['status'=>"pending"]])->count();
        $receiveRequests = $user->receiveRequests->count();
        return response()->json([
            'sendRequestaccept' => $receiveRequestaccept,
            'receiveRequest' => $receiveRequests,
            'connections' => $user->connections->get()->count(),

        ]);
        
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
