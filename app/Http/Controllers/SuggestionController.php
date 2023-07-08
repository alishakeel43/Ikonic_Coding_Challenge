<?php

namespace App\Http\Controllers;

use App\Models\Connection;
use App\Models\User;
use App\View\Components\Suggestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuggestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $suggestions = $user->suggestions->paginate(10);
        $currentPage = $suggestions->currentPage();
        $newPageUrl = $suggestions->nextPageUrl();


        // $extraData = ['currentPage' => $currentPage , 'newPageUrl' =>$newPageUrl];
        $obj = new Suggestion($suggestions);
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
        dd($request);
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
