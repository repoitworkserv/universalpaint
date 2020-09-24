<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;


use Validator;
use Auth;
use App\UserImages;
use App\Variable;
use App\Attribute;
class AttributeController extends Controller
{
    public function __construct()
    {
        //check permission
   
 
    	//sidebar session
		session(['getpage' => 'attribute']); 
    }
	
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       $variablelist = Variable::get();
       
	   $attributelist       = Attribute::where(function($q) use($request){
				$q->where('name','like', '%'.$request->search_item);
        })->paginate(10);
        $id = Auth::id();
       $search_item = ($request->search_item) ? $request->search_item : '';
       $uimage = UserImages::where('user_id',$id)->with('ImageData')->get();
       return view('admin.master-record.attribute.index',compact('uimage','variablelist', 'attributelist','search_item'));
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
    	 $validator = Validator::make($request->all(), [
            'attrb_variable_name'   => 'required',
            'attrb_name'			=> 'required',
        ]);

        if($validator->fails()){
            $message = '';
            foreach($validator->errors()->all() as $error){
                $message .= $error."\r\n";
            }
        } else { 
			$attrb = new Attribute;
			$attrb->variable_id  = $request->attrb_variable_name;
			$attrb->name  = $request->attrb_name;
			$attrb->description  = $request->attrb_description;
			$attrb->created_at = date('Y-m-d h:i:s');
			if($attrb->save()){
				$message = 'New Attribute successfully added!';
				return redirect()->action('Admin\AttributeController@index')->with('success',$message);
			}
        }
        //error on save       
        return redirect()->back()->with('error',$message);	
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
    	$validator = Validator::make($request->all(), [
            'edit_variable_name'    => 'required',
            'edit_attrb_name' 		=> 'required',
        ]);

        if($validator->fails()){
            $message = '';
            foreach($validator->errors()->all() as $error){
                $message .= $error."\r\n";
            }
        } else {
			$attribute = Attribute::where('id',$id)->get(); 
			$n_attribute = $attribute[0];
			$n_attribute->variable_id  = $request->edit_variable_name;
			$n_attribute->name  = $request->edit_attrb_name;
			$n_attribute->description  = $request->edit_attrb_description;
			$n_attribute->updated_at = date('Y-m-d h:i:s');
			if($n_attribute->save()){
			$message = 'Attribute successfully updated!'; 
			   return redirect()->action('Admin\AttributeController@index')->with('success',$message);
			}
        }
        //error on save       
        return redirect()->back()->with('error',$message);
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
