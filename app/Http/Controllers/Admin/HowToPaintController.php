<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\HowToPaint;
use App\HowToPaintContent;
use Validator;

class HowToPaintController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search_item = $request->search_item;
        $HowToPaint = HowToPaint::where('title','LIKE','%'.$search_item.'%')->with('SubTitles')->paginate(20);
        return view('admin.content-management.how-to-paint.index', compact('search_item','HowToPaint'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $message   = "";
        $status    = "error";
        $validator = Validator::make($request->all(), [
            'title'          => 'required',    
            'parent_id'      => 'required',  
        ]);
        if($validator->fails()){
            foreach ($validator->errors()->all() as $error) {
                $message .= $error."\r\n";
            }
        } else {
            $howtopaint            = new HowToPaint;
            $howtopaint->title     = $request->title;
            $howtopaint->parent_id = $request->parent_id;
            $howtopaint->status    = isset($request->status) || $request->status == "on" ? 1 : 0; 

            if ($howtopaint->save()) {
                $message = "How to paint title successfully saved";
                $status  = "success";
            } else {
                $message = "Error saving How to paint title.";
            }
        }

        return redirect()->back()->with($status, $message);
    }

    public function add_content(Request $request)
    {
        $message   = "";
        $status    = "error";
        $validator = Validator::make($request->all(), [
            'ac_how_to_paint_id'  => 'required',    
            'ac_content'          => 'required', 
        ]);
        if($validator->fails()){
            foreach ($validator->errors()->all() as $error) {
                $message .= $error."\r\n";
            }
        } else {
            $new_filename = '';
            $allowedfileExtension   =['PDF','JPG','PNG','JPEG','jpg','png','jpeg','pdf'];
            if($request->hasFile('ac_image')) {
                $banner             = $request->file('ac_image');
                $filename           = $banner->getClientOriginalName();
                $extension          = $banner->getClientOriginalExtension();
                $check              = in_array($extension,$allowedfileExtension);

                if ($check) {
                    $new_filename   = time() . '-' . str_replace(' ', '-',$filename);
                    $post_path      = public_path('img/how-to-paint');
                    $request->file('ac_image')->move($post_path, $new_filename);
                } else {
                    $status  = "error";
                    $message = 'Invalid File Type';
                }
            }
            
            $howtopaint                   = new HowToPaintContent;
            $howtopaint->how_to_paint_id  = $request->ac_how_to_paint_id;
            $howtopaint->content          = $request->ac_content;
            $howtopaint->image            = $new_filename;
            $howtopaint->status           = isset($request->ac_status) || $request->ac_status == "on" ? 1 : 0; 

            if(empty($message)) {
                if ($howtopaint->save()) {
                    $message = "How to paint content successfully saved";
                    $status  = "success";
                } else {
                    $message = "Error saving How to paint content.";
                }
            }
        }

        return redirect()->back()->with($status, $message);
    }

    public function show_content(Request $request) {

        $message            = "";
        $status             = "error";
        $howtopaint_content = [];
        $validator          = Validator::make($request->all(), [
            'id'  => 'required',    
        ]);
        if($validator->fails()){
            foreach ($validator->errors()->all() as $error) {
                $message .= $error."\r\n";
            }
        } else {
            $howtopaint_content = HowToPaintContent::where('how_to_paint_id',$request->id)->get()->toArray();
        }

        return response()->json($howtopaint_content);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $message   = '';
        $status    = 'error';
        $validator = Validator::make($request->all(), [
            'e_id'           => 'required',   
            'e_title'        => 'required',    
            'e_parent_id'    => 'required',  
        ]);
        if($validator->fails()){
            foreach ($validator->errors()->all() as $error) {
                $message .= $error."\r\n";
            }
        } else {
            $howtopaint            = HowToPaint::findOrFail($request->e_id);
            $howtopaint->title     = $request->e_title;
            $howtopaint->parent_id = $request->e_parent_id;
            $howtopaint->status    = isset($request->e_status) || $request->e_status == "on" ? 1 : 0; 
            if ($howtopaint->update()) {
                $message = "How to paint title successfully updated";
                $status  = 'success';
            } else {
                $message = "Error updating How to paint title.";
            }
        }

        return redirect()->back()->with($status, $message);
    }

    public function update_content(Request $request)
    {
        $message   = "";
        $status    = "error";
        $validator = Validator::make($request->all(), [
            'ec_id'               => 'required',    
            'ec_content'          => 'required', 
        ]);
        if($validator->fails()){
            foreach ($validator->errors()->all() as $error) {
                $message .= $error."\r\n";
            }
        } else {
            $new_filename = '';
            $allowedfileExtension   =['PDF','JPG','PNG','JPEG','jpg','png','jpeg','pdf'];
            if($request->hasFile('ec_image')) {
                $banner             = $request->file('ec_image');
                $filename           = $banner->getClientOriginalName();
                $extension          = $banner->getClientOriginalExtension();
                $check              = in_array($extension,$allowedfileExtension);

                if ($check) {
                    $new_filename   = time() . '-' . str_replace(' ', '-',$filename);
                    $post_path      = public_path('img/how-to-paint');
                    $request->file('ec_image')->move($post_path, $new_filename);
                } else {
                    $status  = "error";
                    $message = 'Invalid File Type';
                }
            }
            
            $howtopaintcontent                   = HowToPaintContent::find($request->ec_id);
            $howtopaintcontent->content          = $request->ec_content;
            $howtopaintcontent->status           = isset($request->ec_status) || $request->ec_status == "on" ? 1 : 0; 
            if(!empty($new_filename)) { 
                $howtopaintcontent->image        = $new_filename; 
            }

            if(empty($message)) {
                if ($howtopaintcontent->update()) {
                    $message = "How to paint content successfully updated";
                    $status  = "success";
                } else {
                    $message = "Error updating How to paint content.";
                }
            }
        }

        return redirect()->back()->with($status, $message);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $howtopaint = HowToPaint::find($id);
        if ($howtopaint->delete()) {
            $message = "How to paint title successfully deleted";
            $status  = "success";
        } else {
            $message = "Error deleting How to paint title.";
            $status  = "error";
        }
        return redirect()->back()->with($status, $message);
    }

    public function destroy_content($id)
    {
        $howtopaint_content = HowToPaintContent::find($id);
        if ($howtopaint_content->delete()) {
            $message = "How to paint title successfully deleted";
            $status  = "success";
        } else {
            $message = "Error deleting How to paint title.";
            $status  = "error";
        }
        return redirect()->back()->with($status, $message);
    }
}
