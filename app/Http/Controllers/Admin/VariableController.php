<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Validator;
use Auth;
use App\UserImages;
use App\Variable;

class VariableController extends Controller
{
    public function __construct()
    {
        //check permission
   
 
    	//sidebar session
		session(['getpage' => 'variable']); 
    }
	
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id = Auth::id();
        $search_item = false;

        // if(isset($this->filter['search_item'])) {
        //     $meta = $this->filter['search_item'];
        //     unset($hits->filter['search_item']);
        // }

        // if(!empty($this->filter)) {
        //     $query->where($this->filter);
        // }

        // if(!empty($meta)) {
        //     $table = $query->getModel()->getTable();
        //     dd($table);
        //     $query->join('meta', $table . '.id', '=', 'meta.object_id');
        //     $metaQuery = $query->getQuery()->newQuery();
        //     foreach ($meta as $k => $v) {
        //         $metaQuery->orWhere(['meta.key' => $k, 'meta.value' => $v]);
        //     }
        //     $query->addNestedWhereQuery($metaQuery);
        //     $query->groupBy($table . '.id');
        //     $results = $query->get();
        // }

        //$variablelist = Variable::all();
        //dd(count($variablelist));
        $uimage = UserImages::where('user_id',$id)->with('ImageData')->get();
        //$search_item = ($request->search_item) ? $request->search_item : '';
        $variablelist = Variable::where(function($q) use($request){
                $q->where('name','like', '%'.$request->search_item);
        })->paginate(10);
       return view('admin.master-record.variable.index',compact('uimage','variablelist','search_item'));
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
            'variable_name'            => 'required',
        ]);

        if($validator->fails()){
            $message = '';
            foreach($validator->errors()->all() as $error){
                $message .= $error."\r\n";
            }
        } else { 
			$variable = new Variable;
			$variable->name  = $request->variable_name;
			$variable->description  = $request->variable_description;
			$variable->created_at = date('Y-m-d h:i:s');
			if($variable->save()){
			$message = 'New Variable successfully added!';
			   return redirect()->action('Admin\VariableController@index')->with('success',$message);
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
            'edit_variable_name'            => 'required',
        ]);

        if($validator->fails()){
            $message = '';
            foreach($validator->errors()->all() as $error){
                $message .= $error."\r\n";
            }
        } else {
			$variable = Variable::where('id',$id)->get(); 
			$n_variable = $variable[0];
			$n_variable->name  = $request->edit_variable_name;
			$n_variable->description  = $request->edit_variable_description;
			$n_variable->updated_at = date('Y-m-d h:i:s');
			if($n_variable->save()){
			$message = 'Variable successfully updated!'; 
			   return redirect()->action('Admin\VariableController@index')->with('success',$message);
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
        $var_data = Variable::findOrFail($id);
        if($var_data->delete()) {
            $status = 'success';
            $message = 'Variable successfully deleted!';
        } else {
            $status = 'error';
            $message = 'Error deleting Variable!';
        }
        
        return redirect()->back()->with($status, $message);
    }



}
