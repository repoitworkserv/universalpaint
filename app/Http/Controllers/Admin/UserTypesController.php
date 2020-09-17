<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\UserImages;
use App\UserTypes;
use Validator;

class UserTypesController extends Controller
{
    /**
     * Display a list of User
     *
     * @param  \App\Http\Requests\PaginationRequest $request
     * @return \Response
     */
    public function index()
    {   
        $id = Auth::id();
        $uimage = UserImages::where('user_id',$id)->with('ImageData')->get();
        if(!empty(Auth::user()->permission)){
           $usertypes = UserTypes::paginate(10);
            return view('admin.user.user_types',compact('uimage','usertypes'));
        } else {
            return redirect('admin/signin');
        }

    }

    /**
     * Show form for creating a new user.
     *
     * @return \Response
     */
    public function create()
    {
		//

    }
	
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Admin\ProductRequest $request
     * @return \Response
     */
    public function store(Request $request)
    {
    	
    	$validator = Validator::make($request->all(), [
            'utypes_name' => 'required',
        ]);
        if($validator->fails()){
            $message = '';
            foreach($validator->errors()->all() as $error){
            	$message .= $error."\r\n";
            }
        } else {
        	$myuser = new UserTypes;
			$myuser->name       = trim($request->utypes_name);
            $myuser->created_at = date('Y-m-d h:i:s'); 
            if($myuser->save()){                    
               $message = 'New User Type Added.';
                return redirect()->action('Admin\UserTypesController@index')->with('status', $message);
                
            }
        }            
        

        //error on save
        
        return redirect()->back()->with('status', $message);

    }

    /**
     * Edit the product in the specified resource in storage.
     *
     * @param  int $id
     * @return \Response
     */
    public function edit($id)
    {
       //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @param  \App\Http\Requests\Admin\UpdateRequest
     * @return \Response
     */
    public function update(Request $request)
    {

		 $validator = Validator::make($request->all(), [
            'utypes_name' => 'required',
        ]);
        if($validator->fails()){
            $message = '';
            foreach($validator->errors()->all() as $error){
            	$message .= $error."\r\n";
            }
        }else {
        	$user = UserTypes::find($id);
            $myuser->name       = trim($request->utypes_name);
            $myuser->updated_at = date('Y-m-d h:i:s'); 
            if($myuser->save()){
                $message = 'User Type'.$request->name.' has been successfully updated!';
                return redirect()->action('Admin\UserTypesController@index')->with('status', $message);
            }
		}
		//error on save        
        return redirect()->back()->with('status', $message);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Response
     */
    public function destroy($id)
    {
        
    }


}
