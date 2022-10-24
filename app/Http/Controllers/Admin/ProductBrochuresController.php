<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\ProductBrochuresContent;
use App\ProductBrochure;
use Validator;
use File;

class ProductBrochuresController extends Controller
{
    
    public $moduleIndex = 5.1;

    public function __construct() 
    {   
        $this->middleware('uac:'.$this->moduleIndex);
    }

    public function index(Request $request)
    {
        $search_item = $request->search_item;
        $subheading = ProductBrochuresContent::where('component','subheading')->first();
        return view('admin.content-management.how-to-paint.index', compact('subheading'));
    }


    public function update_content(Request $request)
    {
        $content                           = $request->content;
        $product_brochure_content          = ProductBrochuresContent::where('component','subheading')->first();
        if($product_brochure_content) {
            $product_brochure_content->content = $content;
            $product_brochure_content->update();
        } else {
            $product_brochure_content_new            = new ProductBrochuresContent;
            $product_brochure_content_new->component = 'subheading';
            $product_brochure_content_new->content   = $content;
            $product_brochure_content_new->save();
        }
        $message = 'Product Brochure Subheading successfully updated!';

        return redirect()->back()->withInput()->with(array('status'=>'success','msg'=>$message));
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'operation'      => 'required',
            'brochure_title' => 'required',
            'brochure_image' => 'mimes:jpeg,jpg,png,gif',
            'brochure_file'  => 'required',
        ]);
        if($validator->fails()){
            $message = '';
            foreach($validator->errors()->all() as $error){
            	$message .= $error."\r\n";
            }
        } else {

            if($request->operation == "UPDATE") {

                $product_brochure = ProductBrochure::findOrFail($request->brochure_id);
                

                if($request->brochure_image) {
                    $oldfeaturedImageName = $product_brochure->brochure_image;
                    $featuredImageName    = time().'.'.$request->brochure_image->extension();  
                    $request->brochure_image->move(public_path('images/brochures'), $featuredImageName);

                    if(!empty($oldfeaturedImageName) && File::exists(public_path('images/brochures/'.$oldfeaturedImageName))){
                        File::delete(public_path('images/brochures/'.$oldfeaturedImageName));
                    }
                    $product_brochure->brochure_image = $featuredImageName;
                }

                if($request->brochure_file) {
                    $oldfeaturedFileName = $product_brochure->brochure_file;
                    $featuredFileName    = time().'.'.$request->brochure_file->extension();  
                    $request->brochure_file->move(public_path('images/brochures/files'), $featuredFileName);

                    if(!empty($oldfeaturedFileName) && File::exists(public_path('images/brochures/files'.$oldfeaturedFileName))){
                        File::delete(public_path('images/brochures/files/'.$oldfeaturedFileName));
                    }
                    $product_brochure->brochure_file = $featuredFileName;
                }

                $product_brochure->brochure_title = $request->brochure_title;
                $product_brochure->status         = isset($request->brochure_status) ? true : false;

                $product_brochure->update();

                $message = 'Product Brochure successfully updated!';

            } else {
                $featuredImageName = time().'.'.$request->brochure_image->extension();  
                $request->brochure_image->move(public_path('images/brochures'), $featuredImageName);
                $featuredFileName = time().'.'.$request->brochure_file->extension();  
                $request->brochure_file->move(public_path('images/brochures/files'), $featuredFileName);
            
                $product_brochure = new ProductBrochure;
    
                $product_brochure->brochure_title = $request->brochure_title;
                $product_brochure->brochure_image = $featuredImageName;
                $product_brochure->brochure_file  = $featuredFileName;
                $product_brochure->status         = isset($request->brochure_status) ? true : false;
    
                $product_brochure->save();
    
                $message = 'Product Brochure successfully added!';
            }

        }
        
        return redirect()->back()->withInput()->with(array('status'=>'success','msg'=>$message));
    }

    public function destroy($id)
    {
        $brochure         = ProductBrochure::find($id);
        $oldFeaturedImage = $brochure->brochure_image;
        $oldFeaturedFile  = $brochure->brochure_file;
            
            
        if(!empty($oldFeaturedImage) && File::exists(public_path('images/brochures/'.$oldFeaturedImage))){
            File::delete(public_path('images/brochures/'.$oldFeaturedImage));
        }
        if(!empty($oldFeaturedFile) && File::exists(public_path('images/brochures/files/'.$oldFeaturedFile))){
            File::delete(public_path('images/brochures/files/'.$oldFeaturedFile));
        }

        if($brochure->delete()) {
            $status = 'success';
            $message = 'Product Brochure successfully deleted!';
        } else {
            $status = 'error';
            $message = 'Error deleting Product Brochured!';
        }
        return redirect()->back()->withInput()->with(array('status'=>'success','msg'=>$message));
    }
}
