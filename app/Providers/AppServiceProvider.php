<?php

namespace App\Providers;

use App\ProductCategory;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

use App\PostMetaData;
use DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //$product_categories = ProductCategory::all();
        //View::share('product_categories', $product_categories);
        DB::getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
        $footerlinks_left = PostMetaData::where('meta_key','footer_left_col')->get();
		View::share('footerlinks_left',$footerlinks_left);
		$footerlinks_right = PostMetaData::where('meta_key','footer_right_col')->get();
		View::share('footerlinks_right',$footerlinks_right);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
