<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;


use Validator;
use DB;
use Config;
use Auth;

use App\UserImages;
use App\EmailTemplate;

class EmailTemplateController extends Controller
{
    //
    public function index()
    {
        $id = Auth::id();
        $template = EmailTemplate::get();
        $uimage = UserImages::where('user_id',$id)->with('ImageData')->get();
        return view('admin.content-management.email-template.index',compact('uimage', 'template'));
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'post_title'          => 'required',    
        ]);
        
        $message = '';
        if($validator->fails()){
            foreach ($validator->errors()->all() as $error) {
                $message .= $error."\r\n";
            }
        } else {
            $new_filename = '';
            $allowedfileExtension   =['JPG','PNG','JPEG','jpg','png','jpeg'];
            if($request->hasFile('image_template')) {
                $banner             = $request->file('image_template');
                $filename           = $banner->getClientOriginalName();
                $extension          = $banner->getClientOriginalExtension();
                $check              = in_array($extension,$allowedfileExtension);

                if ($check) {
                    $new_filename   = time() . '-' . $filename;
                    $post_path      = public_path('img/post');
                    $request->file('image_template')->move($post_path, $new_filename);
                } else {
                    $message = 'Invalid File Type';
                }
            }
            $post_name = str_replace(' ', '-', trim(strtolower($request->post_title)));
            $post_name_count = EmailTemplate::where('post_title', '=', $request->post_title)->count();
            
            if ($post_name_count > 0) {
                $post_name .= '-' . ($post_name_count + 1);
            }
            $postdata = new EmailTemplate;
            $postdata->post_title           = $request->post_title;
            $postdata->post_name            = $post_name;
            $postdata->type                  = $request->post_type;
            $postdata->post_content         = $request->post_content;
            $postdata->image_template       = $new_filename;
            if ($postdata->save()) {
                $message = 'Post is successfully save';
            }
            return redirect()->back()->with('status', $message);
        }
        
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
             
        ]);

        $message = '';
        if($validator->fails()){
            foreach ($validator->errors()->all() as $error) {
                $message .= $error."\r\n";
            }
        } else { 
            $new_filename = '';
            $allowedfileExtension   =['JPG','PNG','JPEG','jpg','png','jpeg'];
            $post_path      = public_path('img/post');
            
            $postdata = EmailTemplate::where('id', $request->e_post_id)->get();
			$postdata_0 = $postdata[0];
            if($request->hasFile('e_featured_image')) {
                $image_template     = $request->file('e_featured_image');
                $filename           = $image_template->getClientOriginalName();
                $extension          = $image_template->getClientOriginalExtension();
                $check              = in_array($extension,$allowedfileExtension);

                if ($check) {
                    if (is_file($post_path.$postdata_0->image_template)) {
                        unlink($post_path.$postdata_0->image_template);
                    }
                    $new_filename = time() . '-' . $filename;
                    $request->file('e_featured_image')->move($post_path, $new_filename);
                } else {
                    $message = 'Invalid File Type';
                }
            } else {
                $new_filename = $request->e_featured_image;
            }
            if ($postdata_0->post_name == $request->e_post_name) {
                $post_name = $request->e_post_name;
            } else {
                $e_post_name = str_replace(' ', '-', strtolower($request->e_post_title));
                $post_name_count = EmailTemplate::where('e_post_title', '=', $request->e_post_title)->count();
                
                if ($post_name_count > 0) {
                    $post_name .= '-' . ($post_name_count + 1);
                }
            }
            if ($new_filename == '') {
                if (is_file($post_path.$postdata_0->image_template)) {
                    unlink($post_path.$postdata_0->image_template);
                }
            }
			
			$detail = urldecode($request->e_post_content);
			/*$dom = new \domdocument();
			$dom->loadHtml($detail, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
			$detail = $dom->savehtml();*/
            $postdata_0->post_title           = $request->e_post_title;
            $postdata_0->post_name            = $post_name;
            $postdata->type                  = $request->e_post_type;
            $postdata_0->post_content         = $request->e_post_content;
            $postdata_0->image_template       = $new_filename;
            //dd($postdata_0, $request->all());
            if ($postdata_0->save()) {
                $message = 'Post is successfully updated';
            }
        }
        return redirect()->back()->with('status', $message);

    }
}
