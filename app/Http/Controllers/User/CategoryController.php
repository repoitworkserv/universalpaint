<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Category;
use App\Product;

use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{

    public function index(Request $request)
    {
        $searchKey = trim($request->search);

        if(empty($searchKey)){
            $category  = Category::get();
        }
        else {
            $category = Category::where(function($q) use($searchKey){
            if($searchKey != ''){
                    $q->where('name','like', '%'.$searchKey. '%');
                }
            })->orderBy('name')
            ->get();
        }

		$uid = Auth::id();
        return view('user/category/index', compact('category', 'uid'));
    }

    public function detail($slug = '')
    {
    }
}
