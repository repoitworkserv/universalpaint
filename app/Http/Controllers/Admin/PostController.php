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
use App\Post;
use App\PostMetaData;

class PostController extends Controller
{
    public function index()
    {
        $Post       = Post::where('post_type', 'post')->paginate(10);
        $id = Auth::id();
        $uimage = UserImages::where('user_id',$id)->with('ImageData')->get();
        return view('admin.content-management.post.index', compact('uimage','Post'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'post_title'          => 'required',    
        ]);

        $message ='';
        if($validator->fails()){
            foreach ($validator->errors()->all() as $error) {
                $message .= $error."\r\n";
            }
            return redirect()->back()->with('error', $message);
        } else {
            $new_filename = '';
            $allowedfileExtension   =['PDF','JPG','PNG','JPEG','jpg','png','jpeg','pdf'];
            if($request->hasFile('featured_image')) {
                $banner             = $request->file('featured_image');
                $filename           = $banner->getClientOriginalName();
                $extension          = $banner->getClientOriginalExtension();
                $check              = in_array($extension,$allowedfileExtension);

                if ($check) {
                    $new_filename   = time() . '-' . str_replace(' ', '-',$filename);
                    $post_path      = public_path('img/post');
                    $request->file('featured_image')->move($post_path, $new_filename);
                } else {
                    $message = 'Invalid File Type';
                }
            }
            $newbanner_filename = '';
            $allowedbannerExtension   =['JPG','PNG','JPEG','jpg','png','jpeg'];
            if($request->hasFile('featured_banner')) {
                $banner_image                   = $request->file('featured_banner');
                $bannerfilename           = $banner_image->getClientOriginalName();
                $bannerextension          = $banner_image->getClientOriginalExtension();
                $bannercheck              = in_array($bannerextension,$allowedbannerExtension);

                if ($bannercheck) {
                    $newbanner_filename   = time() . '-' . str_replace(' ', '-', $bannerfilename);
                    $post_paths      = public_path('img/post');
                    $request->file('featured_banner')->move($post_paths, $newbanner_filename);
                } else {
                    $message = 'Invalid File Type';
                }
            }
           

            $post_name = str_replace(' ', '-', trim(strtolower($request->post_title)));
            $post_name_count = Post::where('post_title', '=', $request->post_title)->count();
            $postdata = new Post;
            $postdata->post_title           = $request->post_title;
            $postdata->post_name            = $post_name;
            $postdata->post_type            = 'post';
            $postdata->post_content         = $request->post_content;
            $postdata->displayed_title          = $request['displayed_title'];
            $postdata->displayed_post_content   = $request['displayed_post_content'];
            $postdata->displayed_button         = $request['displayed_button'];
            $postdata->button_name          = $request->button_name;
            $postdata->button_link          = $request->button_link;
            $postdata->featured_image       = $new_filename;
            $postdata->featured_banner      = $newbanner_filename;
            if ($postdata->save()) {
                $message = 'Post is successfully save';
            }
        }
        return redirect()->back()->with('success', $message);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'e_post_title'          => 'required',    
        ]);

        if($validator->fails()){
            foreach ($validator->errors()->all() as $error) {
                $message .= $error."\r\n";
            }
        } else { 
            $new_filename = '';
            $allowedfileExtension   =['JPG','PNG','JPEG','jpg','png','jpeg','PDF', 'pdf'];
            $post_path      = public_path('img/post');
            
            $postdata = Post::where('id', $request->e_post_id)->get();
			$postdata_0 = $postdata[0];
            if($request->hasFile('e_featured_image')) {
                $featured_image     = $request->file('e_featured_image');
                $filename           = $featured_image->getClientOriginalName();
                $extension          = $featured_image->getClientOriginalExtension();
                $check              = in_array($extension,$allowedfileExtension);

                if ($check) {
                    if (is_file($post_path.$postdata_0->featured_image)) {
                        unlink($post_path.$postdata_0->featured_image);
                    }
                    $new_filename = time() . '-' . str_replace(' ', '-',$filename);
                    $request->file('e_featured_image')->move($post_path, $new_filename);
                } else {
                    $message = 'Invalid File Type';
                }
            } else {
                $new_filename = $request->e_featured_image_value;
            }
            $newbanner_filename = '';
            $allowedbannerExtension   =['JPG','PNG','JPEG','jpg','png','jpeg'];
            if($request->hasFile('e_featured_banner')) {
                $banner_image             = $request->file('e_featured_banner');
                $bannerfilename           = $banner_image->getClientOriginalName();
                $bannerextension          = $banner_image->getClientOriginalExtension();
                $bannercheck              = in_array($bannerextension,$allowedbannerExtension);

                if ($bannercheck) {
                    $newbanner_filename   = time() . '-' . str_replace(' ', '-', $bannerfilename);
                    $post_paths      = public_path('img/post');
                    $request->file('e_featured_banner')->move($post_paths, $newbanner_filename);
                } else {
                    $message = 'Invalid File Type';
                }
            } else {
                $newbanner_filename = $request->e_featured_banner_value;
            }

            //banner
           
           
            //dd($newbanner_filename);
            if ($postdata_0->post_name == $request->e_post_name) {
                $post_name = $request->e_post_name;
            } else {
                $post_name = str_replace(' ', '-', strtolower($request->e_post_title));
                $post_name_count = Post::where('post_title', '=', $request->e_post_title)->count();
                
                if ($post_name_count > 0) {
                    $post_name .= '-' . ($post_name_count + 1);
                }
            }
            if ($new_filename == '' && $newbanner_filename) {
                if (is_file($post_path.$postdata_0->featured_image) && is_file($post_path.$postdata_0->featured_banner)) {
                    unlink($post_path.$postdata_0->featured_image);
                    unlink($post_path.$postdata_0->featured_banner);
                }
            }

			$detail = urldecode($request->e_post_content);
			/*$dom = new \domdocument();
			$dom->loadHtml($detail, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            $detail = $dom->savehtml();*/
            $postdata_0 = Post::find($request->e_post_id);
            $postdata_0->post_title           = $request->e_post_title;
            $postdata_0->post_name            = $post_name;
            $postdata_0->post_content         = $detail;
            $postdata_0->displayed_title          = $request['e_displayed_title'];
            $postdata_0->displayed_post_content   = $request['e_displayed_post_content'];
            $postdata_0->displayed_button         = $request['e_displayed_button'];
            $postdata_0->button_name          = $request->e_button_name;
            $postdata_0->button_link          = $request->e_button_link;
            $postdata_0->featured_image       = $new_filename;
            $postdata_0->featured_banner      = $newbanner_filename;
            if ($postdata_0->save()) {
                $status = 'success';
                $message = 'Post is successfully updated';
            }
        }
        return redirect()->back()->with($status, $message);
    }

    public function destroy($id)
    {
		$deletePost = PostMetaData::where('source_type', 'post')->get();
        $post = array();
        foreach($deletePost as $postmetadata){
            $postUse[] = explode(',',$postmetadata['meta_value']);
        }
        foreach($postUse as $data){
            foreach($data as $single){
                array_push($post, $single);
            }
        }
        if(in_array($id, array_unique(array_filter($post)))){ 
            $status = 'info';
            $message = 'This Post is already use!';
        } else {
            $delete =  Post::find($id)->delete();
            $status = 'success';
            $message = 'Post Article successfully deleted!';
        }
        return redirect()->back()->with($status ,$message);      

    }
}
