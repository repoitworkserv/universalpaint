<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use App\UserImages;
use App\Subscriber;

class SubscriberController extends Controller
{

    public $moduleIndex = 8.1;

    public function __construct()
    {
        //check permission
        $this->middleware('uac:'.$this->moduleIndex);
 
    	//sidebar session
		session(['getpage' => 'subscriber']); 
    }
	
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = Auth::id();
        $uimage = UserImages::where('user_id',$id)->with('ImageData')->get();
       $subscriberlist = Subscriber::paginate(10);
       return view('admin.subscriber.index',compact('uimage','subscriberlist'));
	}
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */ 
    public function create()
    {
       
	   
    }

    public function duplicate()
    {
    	
		
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    { 
       
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
	
	public function status_update(Request $request)
	{
		$subs_id = $request->subs_id;
		$status = $request->status;
		$subscriber = Subscriber::find($subs_id)->get();
		$subscriber_q = $subscriber[0];
		$subscriber_q->is_subscribe = $status;
		
		$response = ($subscriber_q->save() ? 'success' : 'error');
		echo json_encode($response);
		
	}
}
