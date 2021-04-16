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

    public function product_brochure_save(Request $request) {
        $new_filename           = '';
        $allowedfileExtension   = ['PDF', 'pdf'];
        $brochure_path          = public_path('img/product_brochure');
        $message                = '';

        $settings = Settings::first();
        if($request->hasFile('product_brochure')) {
            $brochure_pdf       = $request->file('product_brochure');
            $filename           = $brochure_pdf->getClientOriginalName();
            $extension          = $brochure_pdf->getClientOriginalExtension();
            $check              = in_array($extension,$allowedfileExtension);

            if ($check) {
                if (is_file($brochure_path.$settings->product_brochure_pdf)) {
                    unlink($brochure_path.$settings->product_brochure_pdf);
                }
                $new_filename = time() . '-' . str_replace(' ', '-',$filename);
                $request->file('product_brochure')->move($brochure_path, $new_filename);
            } else {
                $message = 'Invalid File Type'; 
                return redirect()->back()->with('status',$message);
            }

            $settings->product_brochure_pdf = $new_filename;
            $message  = $settings->save() ? "Product Brochure PDF successfully saved" : "Error saving Product Brochure PDF";
        } else if ($request->brochure_form_action == "DELETE") {
            $settings->product_brochure_pdf = "";
            $message  = $settings->save() ? "Product Brochure PDF successfully deleted" : "Error deleting Product Brochure PDF";
        }

        return redirect()->back()->with('status',$message);
        
    }
}
