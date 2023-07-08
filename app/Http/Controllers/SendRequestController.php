<?php

namespace App\Http\Controllers;

use App\Models\Connection;
use App\View\Components\Request as ComponentsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SendRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $suggestions = $user->sendRequests()->paginate(10);
        $currentPage = $suggestions->currentPage();
        $newPageUrl = $suggestions->nextPageUrl();


        // $extraData = ['currentPage' => $currentPage , 'newPageUrl' =>$newPageUrl];
        $obj = new ComponentsRequest('sent',$suggestions);
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
        $rules = array(
            'userId'       => 'required|numeric',
            'suggestionId'      => 'required|numeric',
        );
        $validator = Validator::make($request->all(), $rules);
         
        if ($validator->fails()) {
             return response(['message'=>$validator->messages()->first(),'sendRequest'=> null]);
        }
        else {

            $user = Auth::user();
            $sendRequest = Connection::create(['sender_user_id' => $request->userId, 'receiver_user_id'=>$request->suggestionId]);
            $sendRequestCount = $user->sendRequests->count();
            $suggestions = $user->suggestions->count();
            return response()->json([
                'suggestions' => $suggestions,
                'sendRequest' => $sendRequest,
                'sendRequests' => $sendRequestCount,

            ]);
        }
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
        $sendRequestDelete = Connection::where([['sender_user_id' ,"=", $user->id], ['receiver_user_id','=',$id],['status','=','pending']])->delete();
        $sendRequestCount = $user->sendRequests->count();
        $suggestions = $user->suggestions->count();
        return response()->json([
            'sendRequestDelete' => $sendRequestDelete,
            'suggestions' => $suggestions,
            'sendRequests' => $sendRequestCount,

        ]);
        //
    }
}
