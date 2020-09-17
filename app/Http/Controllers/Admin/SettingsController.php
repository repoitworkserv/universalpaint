<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Config;
use Auth;
use App\UserImages;
use App\Settings;

class SettingsController extends Controller
{
    public function __construct()
    {
        //check permission
   
 
    	//sidebar session
		session(['getpage' => 'settings']); 
    }
	
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
       $settings = Settings::get()->toArray();
	   $settings = (count($settings) > 0 ) ? $settings[0] : array(); 
       $mode = Config::get('constants.mode');
       $id = Auth::id();
       $uimage = UserImages::where('user_id',$id)->with('ImageData')->get();
       return view('admin.settings.index',compact('uimage','settings','mode'));
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
	
	public function setting_save(Request $request)
	{
		$tags  = $request->tags;
		$value = '';
		$data = array();
		$checkrecord = Settings::get();
		$settings = new Settings;
		if($checkrecord->count() > 0){
			$settings = $checkrecord[0];	
		}
	
		if($tags == 'mode'){
			$settings->mode = $request->selectmode;
		}else if($tags == 'email'){
			$settings->email_address = $request->inpemail;
			$settings->delivery_and_order_email = $request->inpemail_delopt;
		}
		if($settings->save()){
			
			$txt = (($tags == 'mode') ? 'Maintenance Mode Updated' : 'Email Address Updated');
			
			$msg =  '<div class="alert alert-success alert-dismissible">
		                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		                <h4><i class="icon fa fa-check"></i> Success!</h4>
		               '.$txt.'
		              </div>';
			echo json_encode(array('msg' =>$msg));
		}
		
	}
}
