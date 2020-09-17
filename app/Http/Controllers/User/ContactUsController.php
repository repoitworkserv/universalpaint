<?php

namespace App\Http\Controllers\User;

use Mail;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\ProductCategory;
use Validator;
use Illuminate\Support\Facades\Auth;

use App\Settings;
use App\Subscriber;

class ContactUsController extends Controller
{
    //
    public function index()
    {   
		$uid = Auth::id();	
		$product_categories = ProductCategory::all();
    	return view('user.contactus', compact('product_categories', 'uid'));
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
			$emailContact = 'ezdeal.contactus@gmail.com';
			
		   Mail::send('user.emailtemplate', compact('data'), function ($message) use($postemail,$postfullname,$emailContact,$posttitlesubject, $data) {
		        $message->from($postemail, $postfullname);
		        $message->to($emailContact)->subject($posttitlesubject);
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
	
	public function newsletter(Request $request){
		$newsletter_email = $request->newsletter_email;
		if (!filter_var($newsletter_email, FILTER_VALIDATE_EMAIL)) {
		  echo json_encode('invalid_email');
		}

		$subscriber_exist = Subscriber::where('email_address',"=",$newsletter_email)->get();
		if($subscriber_exist->count() == 0 ){
			$settings =  Settings::get();
			$email_address_tosent = '';
			if($settings->count() > 0){
				$settings_arr = $settings->toArray();
				$email_address_tosent = $settings_arr[0]['email_address'];	
			}
			$newsletter = 'Great News!
			You have just veen subscribed to EZ Deals regular mailing list. Joining our newsletter will allow you to see our deals and promotions!
			Thank you for subcribing.';
			$newsubscriber = new Subscriber;
			$newsubscriber->email_address = $newsletter_email;
			$newsubscriber->is_subscribe  = 1;
			Mail::send('user.newsletter', compact('newsubscriber', 'newsletter'), function ($message) use($newsletter_email,$email_address_tosent) {
		        $message->from($email_address_tosent);
		        $message->to($newsletter_email)->subject('News Letter');
				$message->embed(public_path() . '/img/EZDEAL_LOGO_NEW.jpg');

		    });
			if($newsubscriber->save()){
				echo json_encode('success');
			}
		}else{
			echo json_encode('existing');
		}
		
	}

}