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
use App\Brand;
use App\Product;
use App\PostMetaData;


class BrandController extends Controller
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
            $Brand  = Brand::paginate(10);
        }
        else {
            $Brand = Brand::where(function($q) use($request){
            if($request->search_item){
                    $q->where('name','like', '%'.$request->search_item. '%');
                    $q->orWhere('description','like', '%'.$request->search_item. '%');
                }
            })->paginate(10);
        }
        $id = Auth::id();
        $uimage = UserImages::where('user_id',$id)->with('ImageData')->get();
        return view('admin.master-record.brand.index', compact('uimage', 'Brand','search_item'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'brand_name'  => 'required',
            'brand_description' => 'required',
        ]);

        $message = '';
        if ($validator->fails()) {            
            foreach ($validator->errors()->all() as $error) {
                $message .= $error."\r\n";
            }
            return redirect()->back()->withInput()->with(array('status'=>'error','msg'=>$message));
        } else {
        	
			$parent_slug = '';
			$brand_slug = str_replace(' ','-',trim(strtolower($request->brand_name))); 
			$brand_slug_arr = Brand::where('slug_name',$brand_slug); 
			$parent_slug = $brand_slug; 
			if($brand_slug_arr->count() > 0 ){
				$brand_slug_arr_new = Brand::where('slug_name', 'like', '%' . $brand_slug . '%');  
				$get_count = $brand_slug_arr_new->count() + 1; 
				$parent_slug = $brand_slug.$get_count;
			}
			
			$new_filename_img = '';
            $allowedfileExtension   =['JPG','PNG','JPEG','jpg','png','jpeg'];
            if($request->hasfile('featured_img')) {  //
                $banner             = $request->file('featured_img');
                $filename           = $banner->getClientOriginalName();
                $extension          = $banner->getClientOriginalExtension();
                $check              = in_array($extension,$allowedfileExtension);

                if ($check) {
                    $new_filename_img   = time() . '-' . str_replace(' ', '-',$filename);
                    $brand_path      = public_path('img/brand/');
                    $request->file('featured_img')->move($brand_path, $new_filename_img);
                } else {
                    $message = 'Invalid File Type';
                }
            }
			
			$new_filename = '';
            $allowedfileExtension   =['JPG','PNG','JPEG','jpg','png','jpeg'];
            if($request->hasfile('featured_image_banner')) {  //
                $banner             = $request->file('featured_image_banner');
                $filename           = $banner->getClientOriginalName();
                $extension          = $banner->getClientOriginalExtension();
                $check              = in_array($extension,$allowedfileExtension);

                if ($check) {
                    $new_filename   = time() . '-' . str_replace(' ', '-', $filename);
                    $brand_path      = public_path('img/brand/');
                    $request->file('featured_image_banner')->move($brand_path, $new_filename);
                } else {
                    $message = 'Invalid File Type';
                }
            }
			
            $brand = new Brand;
            $brand->name                 = $request->brand_name; 
			$brand->slug_name            = $parent_slug;
            $brand->description          = $request->brand_description; 
			$brand->featured_img         = $new_filename_img;
			$brand->featured_img_banner  = $new_filename;
			
            $brand->save();
            $message = 'Brand is successfuly added';

            return redirect()->back()->withInput()->with(array('status'=>'success','msg'=>$message));
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'e_brand_name'  => 'required',
            'e_brand_description' => 'required',
        ]);

        $message = '';
        if ($validator->fails()) {            
            foreach ($validator->errors()->all() as $error) {
                $message .= $error."\r\n";
            }
            return redirect()->back()->withInput()->with(array('status'=>'error','msg'=>$message));
        } else {
        	
			$new_filename_img = '';
            $allowedfileExtension   =['JPG','PNG','JPEG','jpg','png','jpeg'];
            if($request->hasfile('e_featured_image')) {  //
                $banner             = $request->file('e_featured_image');
                $filename           = $banner->getClientOriginalName();
                $extension          = $banner->getClientOriginalExtension();
                $check              = in_array($extension,$allowedfileExtension);

                if ($check) {
                    $new_filename_img   = time() . '-' . str_replace(' ', '-', $filename);
                    $brand_path      = public_path('img/brand/');
                    $request->file('e_featured_image')->move($brand_path, $new_filename_img);
                } else {
                    $message = 'Invalid File Type';
                }
            }else{
            	$new_filename_img = $request->e_featured_image_value;
            }
			
        	$new_filename = '';
            $allowedfileExtension   =['JPG','PNG','JPEG','jpg','png','jpeg'];
            $brand_path      = public_path('img/brand/');
            
            $branddata = Brand::where('id', $request->e_brand_id)->get();
			$branddata_0 = $branddata[0];
            if($request->hasFile('e_featured_image_banner')) {
                $featured_image     = $request->file('e_featured_image_banner');
                $filename           = $featured_image->getClientOriginalName();
                $extension          = $featured_image->getClientOriginalExtension();
                $check              = in_array($extension,$allowedfileExtension);

                if ($check) {
                    if (is_file($brand_path.$branddata_0->featured_image_banner)) {
                        unlink($brand_path.$branddata_0->featured_image_banner);
                    }
                    $new_filename = time() . '-' . str_replace(' ', '-', $filename);
                    $request->file('e_featured_image_banner')->move($brand_path, $new_filename);
                } else {
                    $message = 'Invalid File Type';
                }
            } else {
                $new_filename = $request->e_featured_image_banner_value;
            }
			 $hide_brand = 0;
            if($request->has('e_hide_brand') == true){
                $hide_brand = 1;
            }
            else {
                $hide_brand = 0;
            }
			
			$brand = Brand::find($request->e_brand_id);
            $brand->name                 = $request->e_brand_name;
            $brand->description          = $request->e_brand_description;
			$brand->hide_brand           = $hide_brand;
			$brand->featured_img         = $new_filename_img;
			$brand->featured_img_banner  = $new_filename;
            $brand->save();
            $message = 'Brand is successfuly updated';

            return redirect()->back()->withInput()->with(array('status'=>'success','msg'=>$message));;
        }
    }

    public function destroy($id)
    {
        //$delete =  Brand::find($id)->delete();
        $data = PostMetaData::where('meta_key','official_brands')->orWhere('meta_value', $id)->first();
        $product_data = Product::where('brand_id', $id)->first();
        $brand_name = Brand::where('id', $id)->first()['name'];
        $brands_data = explode(',',$data->meta_value);
        //DB::table('product')->where('brand_id', $id)->delete();
        switch($id){
            case(in_array($id, $brands_data)):
                $status = 'info';
                $message = 'Banner are already use Please delete first in Home Page located in Official Brands';
                break;

            case(isset($product_data['brand_id']) && $product_data['brand_id'] == $id):
                $status = 'info';
                $message = $brand_name.' '.'already exists! Please change the products under the selected brand before deleting!';
                break;
            default:
                $delete =  Brand::find($id)->delete();
                $status = 'success';
                $message = 'Brand successfully deleted!';
        }
        return redirect()->back()->with($status, $message);
        
    }
}
