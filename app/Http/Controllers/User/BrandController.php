<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Brand;
use App\UserBrands;
use App\Product;

use Illuminate\Support\Facades\Auth;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        $searchKey = trim($request->search);
        $brands = Brand::has('ProductByBrand')->get();
        $uid = Auth::id();
        $userBrands = UserBrands::where('user_id', $uid)->pluck('brand_id')->all();
        return view('user.brands.index', compact('brands', 'brandGroup', 'uid', 'userBrands'));
    }

    public function detail($slug = '')
    {
        $brand = Brand::where('hide_brand', 0)->orderBy('name', 'asc')
            ->get();
        $selectedBrand = Brand::where('slug_name', $slug)
            ->first();
        $productCount = Product::where('parent_id', 0)
            ->where('brand_id', $selectedBrand->id)
            ->count();
        $sampleProducts = Product::where('parent_id', 0)
            ->where('brand_id', $selectedBrand->id)
            ->paginate(12);
        $uid = Auth::id();

        $brandsimg = collect(Brand::where(function ($query) use ($slug) {
            if ($slug != '') {
                $query->where('slug_name', $slug);
            }
        })
            ->get());
        $brandsimggr = $brandsimg->groupBy(function ($item, $key) {
            return ucfirst($item->name[0]);
        })->first();
        $userBrands = UserBrands::where('user_id', $uid)->pluck('brand_id')->all();
        $featuredimg = array_key_exists('0', $brandsimggr) ? $brandsimggr[0]['featured_img'] : '';
        $slugname = array_key_exists('0', $brandsimggr) ? $brandsimggr[0]['slug_name'] : '';
        return view('user/brand/detail', compact('brand', 'selectedBrand', 'productCount', 'sampleProducts', 'uid', 'featuredimg', 'slugname', 'userBrands'));
    }

    public function slugName($id)
    {
        $brands = Brand::get();
        return view('user.brands.details', compact('brands'));
    }

    function sub_category_list(Request $request)
    {
        $sub_category = $request->sub_category;

        $cat = Brand::where(function ($q) use ($sub_category) {
            $q->where('slug_name', '=', $sub_category);
        })->get();

        $category = $cat[0]->name;

        $product = Product::where(function ($q) use ($cat) {
            $q->where('brand_id', '=', $cat[0]->id);
        })->get();

        return view('user.sub-category.list', compact('category', 'product'));
    }
}
