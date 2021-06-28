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
                $q->orWhere('cat_color','like','%'.$request->search_item);
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
            $best_selling = (isset($request->best_selling) && $request->best_selling == "on") ? 1 : 0;
			$attrb = new Attribute;
			$attrb->variable_id  = $request->attrb_variable_name;
            $attrb->name  = $request->attrb_name;
            $attrb->cat_color  = $request->attrb_catcolor;
            $attrb->r_attr  = $request->attrb_red;
            $attrb->g_attr  = $request->attrb_green;
            $attrb->b_attr  = $request->attrb_blue;
            $attrb->description  = $request->attrb_description;
            $attrb->best_selling = $best_selling;
			$attrb->created_at = date('Y-m-d h:i:s');
			if($attrb->save()){
				$message = 'New Attribute successfully added!';
				return redirect()->back()->with('success',$message);
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
            $best_selling = (isset($request->edit_attrb_best_selling) && $request->edit_attrb_best_selling == "on") ? 1 : 0;
			$attribute = Attribute::where('id',$id)->get(); 
			$n_attribute = $attribute[0];
			$n_attribute->variable_id  = $request->edit_variable_name;
            $n_attribute->name  = $request->edit_attrb_name;
            $n_attribute->cat_color  = $request->edit_attrb_catcolor;
            $n_attribute->r_attr  = $request->edit_attrb_red;
            $n_attribute->g_attr  = $request->edit_attrb_green;
            $n_attribute->b_attr  = $request->edit_attrb_blue;
            $n_attribute->description  = $request->edit_attrb_description;
            $n_attribute->best_selling  = $best_selling;
			$n_attribute->updated_at = date('Y-m-d h:i:s');
			if($n_attribute->save()){
			$message = 'Attribute successfully updated!'; 
			   return redirect()->back()->with('success',$message);
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
        $attr_data = Attribute::findOrFail($id);
        if($attr_data->delete()) {
            $status = 'success';
            $message = 'Attribute successfully deleted!';
        } else {
            $status = 'error';
            $message = 'Error deleting Attribute!';
        }
        
        return redirect()->back()->with($status, $message);
    }
}
