<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

use App\Http\Requests;
use App\Http\Controllers\Controller;

//Model
use App\Post;
use App\PostMetaData;
use App\Product;
use App\UserBrands;
use App\Brand;
class HomePageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
       
    }

    /**
     * Show the application homepage.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        $Page           = Post::find(1);
        $Post           = Post::where('post_type', 'post')->get();
        $Product        = Product::where('parent_id', 0)->orderby('id','desc')->get();
	    if (empty($Page)) {
			abort(404);
		}
        $uid = Auth::id();
        $user_type = Auth::user()['users_type_id'];
        $userBrands = UserBrands::where('user_id',$uid)->pluck('brand_id')->all();
        $brands = Brand::get();
        $colors = array(
            array(
                'name' => 'Whites </br>& Neutrals',
                'color' => '#F6F7F2'
            ),
            array(
                'name' => 'Greys',
                'color' => '#373E42'
            ),
            array(
                'name' => 'Browns',
                'color' => '#B39F94'
            ),
            array(
                'name' => 'Purples',
                'color' => '#7E7999'
            ),
            array(
                'name' => 'Blue',
                'color' => '#0045C7'
            ),
            array(
                'name' => 'Greens',
                'color' => '#9DBFAF'
            ),
            array(
                'name' => 'Yellows',
                'color' => '#FAE196'
            ),
            array(
                'name' => 'Oranges',
                'color' => '#CC5327'
            ),
            array(
                'name' => 'Reds',
                'color' => '#A8312F'
            ),           
        );        
        return view('user.home.index', compact('Page', 'Post', 'Product','uid', 'user_type','userBrands','brands','colors'));
    }

}
