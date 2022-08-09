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
use App\Category;
use App\ProductCategory;
use App\PostMetaData;


class CategoryController extends Controller
{

    public $moduleIndex = 3.1;

    public function __construct() 
    {   
            $this->middleware('uac:'.$this->moduleIndex);
    }
  
    
    public function index(Request $request)
    {
        $search_item = ($request->search_item) ? $request->search_item : '';
        if(empty($search_item)){
            $Category  = Category::paginate(10);
            $AllCategory  = Category::get();
        }
        else {
            $Category   = Category::where(function($q) use($request){
            if($request->search_item){
                    $q->where('name','like', '%'.$request->search_item. '%');
                    $q->orWhere('description','like', '%'.$request->search_item. '%');
                }
            })->paginate(10);
            $AllCategory   = Category::where(function($q) use($request){
                if($request->search_item){
                        $q->where('name','like', '%'.$request->search_item. '%');
                        $q->orWhere('description','like', '%'.$request->search_item. '%');
                    }
                })->get();
        }
        $id = Auth::id();
        $uimage = UserImages::where('user_id',$id)->with('ImageData')->get();
        return view('admin.master-record.category.index', compact('uimage','Category','AllCategory','search_item'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_name'  => 'required',
            'category_description' => 'required',
        ]);

        $message = '';
        if ($validator->fails()) {            
            foreach ($validator->errors()->all() as $error) {
                $message .= $error."\r\n";
            }
            return redirect()->back()->withInput()->with('error',$message);
        } else {
        	$parent_slug = '';
			$category_slug = str_replace(' ','-',trim(strtolower($request->category_name))); 
			$category_slug_arr = Category::where('slug_name',$category_slug); 
			$parent_slug = $category_slug;
			if($category_slug_arr->count() > 0 ){
				$category_slug_arr = Category::where('slug_name', 'like', '%' . $category_slug . '%');
				$get_count = $category_slug_arr->count() + 1;
				$parent_slug = $category_slug.$get_count;
            }
            
            $allowedfileExtension   =['JPG','PNG','JPEG','jpg','png','jpeg'];
			
			$new_filename = '';
            if($request->hasfile('featured_image')) {  //
                $banner             = $request->file('featured_image');
                $filename           = $banner->getClientOriginalName();
                $extension          = $banner->getClientOriginalExtension();
                $check              = in_array($extension,$allowedfileExtension);

                if ($check) {
                    $new_filename   = time() . '-' . str_replace(' ', '-', $filename);
                    $category_path      = public_path('img/category/');
                    $request->file('featured_image')->move($category_path, $new_filename);
                } else {
                    $message = 'Invalid File Type';
                }
            }
			
			$new_filename_bg = '';
            if($request->hasfile('featured_image_background')) {  //
                $banner             = $request->file('featured_image_background');
                $filename           = $banner->getClientOriginalName();
                $extension          = $banner->getClientOriginalExtension();
                $check              = in_array($extension,$allowedfileExtension);

                if ($check) {
                    $new_filename_bg   = time() . '-' . str_replace(' ', '-', $filename);
                    $category_path      = public_path('img/category/');
                    $request->file('featured_image_background')->move($category_path, $new_filename_bg);
                } else {
                    $message = 'Invalid File Type';
                }
            }
			
			$new_filename_banner = '';
            if($request->hasfile('featured_image_banner')) {  //
                $banner             = $request->file('featured_image_banner');
                $filename           = $banner->getClientOriginalName();
                $extension          = $banner->getClientOriginalExtension();
                $check              = in_array($extension,$allowedfileExtension);

                if ($check) {
                    $new_filename_banner   = time() . '-' . str_replace(' ', '-', $filename);
                    $category_path      = public_path('img/category/');
                    $request->file('featured_image_banner')->move($category_path, $new_filename_banner);
                } else {
                    $message = 'Invalid File Type';
                }
            }
        	if($request->has('displayed_name') === true){
                $check = 0;
            } else {
                $check = 1;
            }

            if($request->has('displayed_description') === true){
                $checkdesc = 0;
            } else {
                $checkdesc = 1;
            }
			
			// print_r($new_filename." ".$new_filename_banner); exit();
            $category = new Category;
            $category->name                 = $request->category_name;
            $category->description          = $request->category_description;
            $category->parent_id            = $request->category_parent;
            $category->displayed_name       = $check;
            $category->displayed_discription = $checkdesc;
			$category->slug_name            = $parent_slug;
			$category->featured_img			= $new_filename;
			$category->featured_img_bg      = $new_filename_bg;
			$category->featured_img_banner  = $new_filename_banner;
            $category->save();
            $message = 'Category is successfuly added';

            return redirect()->back()->withInput()->with('success',$message);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'e_category_name'  => 'required',
        ]);

        $message = '';
        if ($validator->fails()) {            
            foreach ($validator->errors()->all() as $error) {
                $message .= $error."\r\n";
            }
            return redirect()->back()->withInput()->with(array('status'=>'error','msg'=>$message));
        } else {
        	
        	$new_filename = '';
            $allowedfileExtension   =['JPG','PNG','JPEG','jpg','png','jpeg'];
            $category_path      = public_path('img/category/');
            
            $categorydata = Category::where('id', $request->e_category_id)->get();
			$categorydata_0 = $categorydata[0];
            if($request->hasFile('e_featured_image')) {
                $featured_image     = $request->file('e_featured_image');
                $filename           = $featured_image->getClientOriginalName();
                $extension          = $featured_image->getClientOriginalExtension();
                $check              = in_array($extension,$allowedfileExtension);

                if ($check) {
                    if (is_file($category_path.$categorydata_0->featured_img)) {
                        unlink($category_path.$categorydata_0->featured_img);
                    }
                    $new_filename = time() . '-' . str_replace(' ', '-', $filename);
                    $request->file('e_featured_image')->move($category_path, $new_filename);
                } else {
                    $message = 'Invalid File Type';
                }
            } else {
                $new_filename = $request->e_featured_image_value;
            }
			
			//banner
			$new_filename_banner = '';
			if($request->hasFile('e_featured_image_banner')) {
                $featured_image     = $request->file('e_featured_image_banner');
                $filename           = $featured_image->getClientOriginalName();
                $extension          = $featured_image->getClientOriginalExtension();
                $check              = in_array($extension,$allowedfileExtension);

                if ($check) {
                    if (is_file($category_path.$categorydata_0->featured_img_banner)) {
                        unlink($category_path.$categorydata_0->featured_img_banner);
                    }
                    $new_filename_banner = time() . '-' . str_replace(' ', '-', $filename);
                    $request->file('e_featured_image_banner')->move($category_path, $new_filename_banner);
                } else {
                    $message = 'Invalid File Type';
                }
            } else {
                $new_filename_banner = $request->e_banner_image_value;
            }
			
			//background
			$new_filename_background = '';
			if($request->hasFile('e_featured_image_background')) {
                $featured_image     = $request->file('e_featured_image_background');
                $filename           = $featured_image->getClientOriginalName();
                $extension          = $featured_image->getClientOriginalExtension();
                $check              = in_array($extension,$allowedfileExtension);

                if ($check) {
                    if (is_file($category_path.$categorydata_0->featured_img_banner)) {
                        unlink($category_path.$categorydata_0->featured_img_banner);
                    }
                    $new_filename_background = time() . '-' . str_replace(' ', '-', $filename);
                    $request->file('e_featured_image_background')->move($category_path, $new_filename_background);
                } else {
                    $message = 'Invalid File Type';
                }
            } else {
                $new_filename_background = $request->e_background_image_value;
            }
            if($request->has('e_displayed_name') === true){
                $check = 0;
            } else {
                $check = 1;
            }

            if($request->has('e_displayed_description')){
                $checkdesc = 0;
            } else {
                $checkdesc = 1;
            }
						
            $category = Category::find($request->e_category_id);
            $category->name                  = $request->e_category_name;
            $category->description           = $request->e_category_description;
            $category->parent_id             = $request->e_category_parent;
            $category->displayed_name        = $check;
            $category->displayed_discription = $checkdesc;
			$category->featured_img          = $new_filename;
			$category->featured_img_banner   = $new_filename_banner;
			$category->featured_img_bg       = $new_filename_background;
            $category->save();
            $message = 'Category is successfuly updated';

            return redirect()->back()->withInput()->with('info',$message);
        }
        
        
    }


    public function destroy($id)
    {
        $array_data = PostMetaData::where('meta_key','product_category')->orWhere('meta_value', $id)->first();
        $product_data = ProductCategory::where('category_id', $id)->get();
        foreach($product_data as $data) {
            $data->delete();
        }
      //  $product_data = isset($product_data['category_id']) ? $product_data['category_id'] : "";
        $message = '';
        $category = explode(',', $array_data->meta_value);
        switch($id) {
            case (in_array($id, $category)):
                $status = 'info';
                $message = 'Category are already use Please delete first in Home Page located in Products Categories';
                break;
            // case($product_data == $id):
            //     $status = 'info';
            //     $message = 'Product Category already exists';
            //     break;

            default:
                $delete =  Category::find($id)->delete();
                $status = 'success';
                $message = 'Category successfully deleted!';
        }
        return redirect()->back()->with($status, $message);
    }
}
