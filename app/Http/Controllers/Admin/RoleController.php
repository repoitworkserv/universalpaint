<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Role;
use App\ProductCategory;
use App\UserImages;
use Validator;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $id = Auth::id();
        $uimage = UserImages::where('user_id',$id)->with('ImageData')->get();
        if(!empty(Auth::user()->permission)){
            $role_list = Role::where('id','<>',1)->paginate(10);
            return view('admin.user.list_role', compact('uimage','role_list'));
        } else {
            return redirect('admin/signin');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $id = Auth::id();
        $uimage = UserImages::where('user_id',$id)->with('ImageData')->get();
        if(!empty(Auth::user()->permission)){
            return view('admin.user.role_create',compact('uimage'));
        } else {
            return redirect('admin/signin');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role_name' => 'required',
        ]);
        if($validator->fails()){
            $message = '';
            foreach($validator->errors()->all() as $error){
            	$message .= $error."\r\n";
            }
        } else {
        	$myrole = new Role;
			$myrole->role_name       = trim($request->role_name);
            $myrole->created_at = date('Y-m-d h:i:s'); 
            if($myrole->save()){                    
               $message = 'New Role Added.';
                return redirect()->action('Admin\RoleController@index')->with('status', $message);
                
            }
        }            
        

        //error on save
        
        return redirect()->back()->with('status', $message);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = Auth::id();
        $uimage = UserImages::where('user_id',$id)->with('ImageData')->get();
        if(!empty(Auth::user()->permission)){
            $RoleID = Role::find($id);
            $ProductCat = ProductCategory::all();
            if (empty($RoleID)) {
                abort(404);
            }

            return view('admin.user.role_edit', compact('uimage','RoleID','ProductCat'));
        } else {
            return redirect('admin/signin');
        }       
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
        $validator = Validator::make($request->all(), [
            'role_name' => 'required',
        ]);
        if($validator->fails()){
            $message = '';
            foreach($validator->errors()->all() as $error){
            	$message .= $error."\r\n";
            }
        } else {
        	$myrole = Role::find($id);
			$myrole->role_name       = trim($request->role_name);
            $myrole->updated_at = date('Y-m-d h:i:s'); 
            if($myrole->save()){                    
               $message = 'Existing Role Updated.';
                return redirect()->action('Admin\RoleController@index')->with('status', $message);
                
            }
        }            
        

        //error on save
        
        return redirect()->back()->with('status', $message);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete =  Role::find($id)->delete();
        $message = 'Role successfully deleted!';
        return redirect()->back()->with('status', $message);
    }
}
