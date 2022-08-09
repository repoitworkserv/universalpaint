<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

use Validator;
use DB;
use Config;
use Auth;
use App\UserImages;
use App\Post;
use App\PostMetaData;
use App\Product;
use App\Brand;
use App\Category;

class PageController extends Controller
{

    public $moduleIndex = 5.1;

    public function __construct() 
    {   
        $this->middleware('uac:'.$this->moduleIndex);
    }

    public function index()
    {
        $Pages = Post::where('post_type', 'page')->paginate(10);
        $Home = Post::where('post_type', 'page')->where('post_name', 'Home')
            ->get();
        $id = Auth::id();
        $uimage = UserImages::where('user_id', $id)->with('ImageData')
            ->get();
        return view('admin.content-management.page.index', compact('uimage', 'Pages', 'Home'));
    }

    public function edit($id)
    {
        $Page = Post::find($id);
        $Post = Post::where('post_type', 'post')->get();
        $Product = Product::where('parent_id', 0)->orderby('id', 'desc')
            ->get();
        $Brand = Brand::all();
        $Category = Category::all();
        $PostMetaData = PostMetaData::where('meta_key', 'footer_left_col')->orWhere('meta_key', 'footer_right_col')
            ->orWhere('meta_key', 'footer_mid_col')
            ->paginate(10);;
        $pageid = $id;
        if (empty($Page))
        {
            abort(404);
        }
        $id = Auth::id();
        $uimage = UserImages::where('user_id', $id)->with('ImageData')
            ->get();
        return view('admin.content-management.page.edit', compact('uimage', 'Page', 'Post', 'Product', 'Brand', 'Category', 'PostMetaData', 'pageid'));
    }

    public function updatebanner(Request $request)
    {
        $banner = PostMetaData::where('meta_key', 'banner')->where('source_id', 1)
            ->first();
        if ($banner)
        {
            $banner->meta_value = $request->banner;
            if ($banner->save())
            {
                $message = 'Banner is successfuly updated';
            }
        }
        else
        {
            $banner = new PostMetaData;
            $banner->meta_key = 'banner';
            $banner->source_id = 1;
            $banner->meta_value = $request->banner;
            $banner->save();
        }
        Session::flash('status', 'Banner is successfuly updated');
        Session::flash('msg', 'Successfully Remove Post in the link');
        echo json_encode('updated');
    }

    public function updatemetadata(Request $request)
    {
        $metadata = PostMetaData::where('meta_key', $request->meta_key)
            ->where('source_id', $request->source_id)
            ->first();
        $unique_value = explode(',', $request->meta_value);
        $value = array();
        foreach (array_unique($unique_value) as $item)
        {
            array_push($value, $item);
        }

				if (($key = array_search("", $value)) !== false)
        {
            unset($value[$key]);
        }

				if (($key = array_search("undefined", $value)) !== false)
        {
            unset($value[$key]);
        }
				
        if ($metadata)
        {
            $metadata->meta_value = implode(',', $value);
            if ($metadata->save())
            {
                $message = 'Data is successfuly updated';
            }
        }
        else
        {
            $metadata = new PostMetaData;
            $metadata->meta_key = $request->meta_key;
            $metadata->source_id = $request->source_id;
            $metadata->meta_value = implode(',', $value);
            $metadata->source_type = $request->source_type;
            $metadata->meta_type = $request->meta_type;
            $metadata->save();
        }
        Session::flash('status', 'Data is successfuly updated');
        Session::flash('msg', 'Successfully Remove Post in the link');
        echo json_encode('Data is successfuly updated');
    }
    public function lnk_store(Request $request)
    {
        $status = 'error';
        $validator = Validator::make($request->all() , ['lnk_name' => 'required', 'display_colmn' => 'required', ]);

        if ($validator->fails())
        {
            $message = '';
            foreach ($validator->errors()
                ->all() as $error)
            {
                $message .= $error . "\r\n";
            }
            return redirect()->back()
                ->with(array(
                'status' => $status,
                'msg' => $message
            ));
        }
        else
        {
            $txt = 'Added';
            $lnkinfo = new PostMetaData;
            if ($request->link_id)
            {
                $lnkinfo = PostMetaData::find($request->link_id);
                $txt = 'Updated';
            }
            $source_id = Post::where('post_name', 'footer')->first();
            $lnkinfo->source_id = $source_id->id;
            $lnkinfo->meta_key = $request->display_colmn;
            $lnkinfo->source_type = "post";
            $lnkinfo->display_name = $request->lnk_name;
            $lnkinfo->paste_lnk = $request->paste_lnk;

            $message = 'Please Check the form before saved';
            if ($lnkinfo->save())
            {
                $message = 'Successfully ' . $txt . ' the link.';
                $status = 'success';

            }
            return redirect()->back()
                ->with(array(
                'status' => $status,
                'msg' => $message
            ));
        }

    }
    public function get_lnk_info(Request $request)
    {
        $lnkinfo = (!empty($request->lnk_id)) ? PostMetaData::find($request->lnk_id) : '';
        echo json_encode($lnkinfo);

    }
    public function link_manage_post(Request $request)
    {
        $metadata = PostMetaData::find($request->post_id_metaval);
        //print_r($request->all()); exit();
        $list = $request->post_ist;
        $metavalue = (strpos($metadata->meta_value, ',') !== false) ? explode(',', $metadata->meta_value) : array(
            $metadata->meta_value
        );
        if (is_array($metavalue))
        {
            if ($request->tag_lnk == 'add')
            {
                if (!in_array($request->post_ist, $metavalue))
                {
                    for ($i = 0;$i < count($list);$i++)
                    {
                        array_push($metavalue, $list[$i]);
                    }
                }
                else
                {
                    return redirect()->back()
                        ->with(array(
                        'status' => 'error',
                        'msg' => 'The Post selected is currently in the list.'
                    ));
                }
            }
            else
            {
                if (($key = array_search($request->post_ist, $metavalue)) !== false)
                {
                    unset($metavalue[$key]);

                }
            }
        }
        // else{
        // 	if($request->tag_lnk == 'add'){
        // 		$metavalue = array_push($metavalue,$request->post_ist);
        // 	}
        // 	else{
        // 		$metavalue = array();
        // 	}
        // }
        if (($key = array_search("", $metavalue)) !== false)
        {
            unset($metavalue[$key]);
        }

				if (($key = array_search("undefined", $metavalue)) !== false)
        {
            unset($metavalue[$key]);
        }

        $metadata->meta_value = implode(',', $metavalue);
        if ($metadata->save())
        {
            if ($request->tag_lnk == 'add')
            {
                return redirect()
                    ->back()
                    ->with(array(
                    'status' => 'success',
                    'msg' => 'Successfully Add Post in the link'
                ));
            }
            else
            {
                Session::flash('status', 'success');
                Session::flash('msg', 'Successfully Remove Post in the link');
                echo json_encode('success');
            }

        }
    }

    public function add_contact_us_post(Request $request)
    {
        $metadata = !empty($request->post_meta_id) ?  PostMetaData::find($request->post_meta_id) : [];
        $unique_value = !empty($request->metavalues) ? explode(',', $request->metavalues) : [];
        $value = array();

        foreach (array_unique($unique_value) as $item)
        {
            array_push($value, $item);
        }

        if(!empty($request->post_list)) {
            $value = array_merge($value,$request->post_list);
        }

		if (($key = array_search("", $value)) !== false)
        {
            unset($value[$key]);
        }

				if (($key = array_search("undefined", $value)) !== false)
        {
            unset($value[$key]);
        }

				
        if ($metadata)
        {
            $metadata->meta_value = implode(',', $value);
           if($metadata->update()) {
                $status = 'success';
                $message = 'Contact Us Widget Box Post successfully saved';
            } else {
                $status = 'error';
                $message = 'Error Saving Contact Us Widget Box Post';
            }
            
        }
        else
        {
            $metadata = new PostMetaData;
            $metadata->meta_key = "contact_us_post";
            $metadata->source_id = $request->source_id;
            $metadata->meta_value = implode(',', $value);
            $metadata->source_type = "post";
            $metadata->meta_type = "post_array";
            $metadata->save();
               
            if($metadata->save()) {
                $status = 'success';
                $message = 'Contact Us Widget Box Post successfully saved';
            } else {
                $status = 'error';
                $message = 'Error Saving Contact Us Widget Box Post';
            }
            
        }

        return redirect()->back()
        ->with($status, $message);
        
    }

    public function store_contactus(Request $request) {
        $contact_us_post = Post::where('post_name','contact_us')->orWhere('post_title','Contact Us')->first();

        $contact_us_post->post_content = $request->post_content;
        $contact_us_post->button_link  = $request->button_link;
        
        if($contact_us_post->save()) {
            $status = 'success';
            $message = 'Cpntact Us Content successfully saved';
        } else {
            $status = 'error';
            $message = 'Error Saving Contact Us Content';
        }
        
        return redirect()->back()
            ->with($status, $message);

    }

    public function destroyBrands($id, $mkey)
    {
        $getMkey = snake_case($mkey);
        $delete = PostMetaData::where('meta_key', $getMkey)->first(); //->delete();
        $mvalexp = explode(',', $delete->meta_value);
        $getout = array_search($id, $mvalexp);
        unset($mvalexp[$getout]);

        $update = PostMetaData::find($delete->id);
        $update->meta_value = implode(',', $mvalexp);
        $update->save();

        //$metaEX = explode(",",$delete->meta_value);
        return redirect()
            ->back()
            ->withStatus('Item removed!');
    }

    public function deletePostLink($id)
    {
        $footerLinks = PostMetaData::find($id)->delete();
        $status = 'success';
        $message = 'Post Article successfully deleted!';
        return redirect()->back()
            ->with($status, $message);
    }
}

