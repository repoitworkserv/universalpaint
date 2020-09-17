<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

//Model
use App\Product;
use App\ProductCategory;
use App\ProductPhoto;
use App\User;

class StaticPageController extends Controller
{

    /**
     * Display a listing of the products.
     *
     * @param  \App\Http\Requests\PaginationRequest $request
     * @return \Response
     */
    public function index()
    {
        $products = Product::paginate(20);
        return view('user.product.index', compact('products'));
        
    }

}
