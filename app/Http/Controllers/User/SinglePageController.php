<?php

namespace App\Http\Controllers\User;

use Mail;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use App\Post;
use App\PostMetaData;

use App\ProductCategory;
use Validator;

use App\Settings;
use App\Subscriber;


class SinglePageController extends Controller
{
    public function index($name)
	{
		$postmetadata = PostMetaData::find($name);
		$postmetadata = PostMetaData::where('display_name',$name)->with('PostData')->get();
		$uid = Auth::id();
		if($postmetadata->count() > 0){
			return view('user.single_page', compact('postmetadata', 'uid'));
		}else{
			abort(404);
		}
	}

	public function contact_form(Request $request)
    { 
    	$validator = Validator::make($request->all(), [
			'fullname'      	=> 'required',
			'titlesubject'		=> 'required',
            'contactnumber' 	=> 'required|digits:11',
            'emailadd'   		=> 'required|email',
            'messagecontact'   	=> 'required',
        ]);
		
		$attributeNames = array(
		   'fullname' => 'Full Name',
		   'titlesubject' => 'Title Subject',
		   'contactnumber' => 'Contact Number', 
		   'emailadd'=>'Email Address',
		   'messagecontact'=>' Message',    
		);
		$validator->setAttributeNames($attributeNames);
        $message1 = '';
		$class = 'warning';
        if($validator->fails()){            
            foreach($validator->errors()->all() as $error){
                $message1 .= $error."\r\n"."<br />";
			}
			
			return redirect()->back()->withInput()->with('error',$message1);
        } else {
        	$settings =  Settings::get();
			$email_address_tosent = '';
			if($settings->count() > 0){
				$settings_arr = $settings->toArray();
				$email_address_tosent = $settings_arr[0]['email_address'];	
			}
			$postemail = $request->emailadd;
			$posttitlesubject = $request->titlesubject;
			$postfullname = $request->fullname;
			$postnumber = $request->contactnumber;
			$postmessage = $request->messagecontact;

			
        	//Send Email Here
        	$data = array(
				'fullname' 	 => trim($postfullname),
				'titlesubject' => trim($posttitlesubject),
		        'contactnum' => trim($postnumber),
		        'emailadd' 	 => trim($postemail),
		        'mymsg' 	 => trim($postmessage),
			); 
			
			
		   Mail::send('user.emailtemplate', compact('data'), function ($message) use($postemail,$postfullname,$email_address_tosent,$posttitlesubject, $data) {
		        $message->from($postemail, $postfullname);
		        $message->to($email_address_tosent)->subject($posttitlesubject);
				$message->embed(public_path() . '/img/EZDEAL_LOGO_NEW.jpg');

		    });
		
		    if (Mail::failures()) {
		        print_r("asd"); exit();
		    }
		    
        	$message = 'You have successfully submitted the form.';

        	return redirect()->back()->with('success_status', $message);
        	$class = 'success';
			$message1 = 'Inquiry Sent.';
        }
		
		$msg =  '<div class="alert alert-'.$class.' alert-dismissible text-left" style="position:relative;">
		                <button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="top: 5px;right: 5px;border: 2px solid #888;color: #888;">×</button>
		                <h4> '.strtoupper($class).'!</h4>
		               '.$message1.'
		              </div>';
		echo json_encode($msg);

    }
}
