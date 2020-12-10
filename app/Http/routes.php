<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


// AUTO GENERATED BY LARAVEL AUTH
Route::auth();

// USER ROUTES
Route::get('/product-category/brands', 'User\BrandController@index');
Route::get('/product-category/brands/{sub_category}', 'User\BrandController@sub_category_list');

Route::get('/product-category/all-products', 'User\ProductPageController@allProducts');
Route::get('/product-category/{category}', 'User\ProductPageController@sub_category');
Route::get('/product-category/{category}/{sub_category}', 'User\ProductPageController@sub_category_list');

Route::get('/color-swatches', 'User\ProductPageController@color_swatches');

Route::get('/contact-us', function () {
	return view('user.contact-us.index');
});

Route::get('/request-a-quote', function () {
	return view('user.request-a-quote.index');
});

Route::get('/how-to-paint', function () {
	return view('user.how-to-paint.index');
});

Route::get('/paint-calculator', function () {
	return view('user.paint-calculator.index');
});
Route::get('/paintCalculatorResult/{surfaceLocation}/{surfaceType}', 'User\ProductPageController@paintSuggestion');
Route::get('/paintCalculatorResult/{paint}', 'User\ProductPageController@paintResultFromQueryString');

Route::get('/product-category/brands/aquaGuard-elastomeric-paint ', function () {
	return view('user.brand-1.index');
});
//Email Request Quote
Route::post('request-a-qoute/send-qoute', 'User\ProductPageController@quoteSent')->name('sendmail.quote');

Route::get('products/checkout', 'User\CheckoutController@index');
Route::get('/under-maintenance', function () {
	return view('user.under-maintenance.index');
});
//Email To User
Route::get('/email_user', 'User\HomePageController@email_request');
Route::get('/email_user_pdf', 'User\HomePageController@email_request_pdf');

//login
Route::get('/', 'User\HomePageController@index');
Route::post('login', 'Auth\AuthController@postAjaxLogin');
Route::post('register-customer', 'User\RegisterController@register_customer');

//Interior
// Route::get('/product-category/interior', 'User\InteriorController@index');
Route::get('/product-category/interior/search', 'User\InteriorController@search');
Route::get('/product-category/interior/{id}', 'User\InteriorController@details');

Route::post('/autocomplete/fetch', 'User\ProductPageController@fetch')->name('autocomplete.fetch');
//Exterior
// Route::get('/product-category/exterior', 'User\ExteriorPageController@index');
Route::get('/product-category/exterior/search', 'User\ExteriorPageController@search');
Route::get('/product-category/exterior/{id}', 'User\ExteriorPageController@details');

//products
Route::get('/products', 'User\ProductPageController@index');
Route::get('/products/search', 'User\ProductPageController@search');
Route::get('/product/{id}', 'User\ProductPageController@details');
Route::post('/product-variance', 'User\ProductPageController@productvariance');
Route::post('/product-view', 'User\ProductPageController@productview');
Route::post('/add-cart', 'User\CartController@addcart');
Route::post('/color-add-cart', 'User\CartController@coloraddtocart');
Route::post('/remove-cart', 'User\CartController@removecart');
Route::post('/check-cart', 'User\CartController@checkcart');
Route::get('/get-shipping-rate', 'User\CartController@get_shipping');
Route::get('/cart', 'User\CartController@index');
Route::group(['middleware' => ['auth']], function () {  
	Route::get('logout', 'Admin\AuthController@getSignOut');
	// Route::get('/cart', 'User\CartController@index');
}); 
Route::post('/checkout-details', 'User\CheckoutController@send_checkoutDetails');
Route::post('/checkout-dragonpay','User\CheckoutController@payment_dragonpay');
Route::post('/checkout-dragonpaypostback','User\CheckoutController@payment_dragonpay_postback');
Route::get('/checkout-dragonpayreturn','User\CheckoutController@payment_dragonpay_return');
// Route::post('/checkout-validate', 'User\CheckoutController@validate_customer_detail');
Route::post('/checkout-paypal-create', 'User\CheckoutController@payment_paypal_create');
Route::post('/checkout-paypal-execute', 'User\CheckoutController@payment_paypal_execute');
Route::get('/delfilt/{type}/{filter}/{name}', 'User\ProductPageController@removeFilters');
Route::get('/putfilt/{type}/{filter}/{name}', 'User\ProductPageController@putFilters');
Route::get('/getclear/{type}/{sess_name}', 'User\ProductPageController@clearAllFilters');
Route::post('/product/add-wishlist', 'User\ProductPageController@add_wishlist');
//cart
// Route::get('/cart', 'User\ProductPageController@cart');
// Route::get('/checkout', 'User\ProductPageController@checkout');
// Route::post('/add_to_cart', 'User\ProductPageController@add_to_cart');
// Route::post('/remove_product_from_cart', 'User\ProductPageController@remove_product_from_cart');
// Route::post('/adjust_product_quantity', 'User\ProductPageController@adjust_product_quantity');
//brand
// Route::get('/brands', 'User\BrandController@index');
// Route::get('/brand/{slug}', 'User\BrandController@detail');
//category
Route::get('/category', 'User\CategoryController@index');

Route::any('single-page/{name}', 'User\SinglePageController@index');
Route::post('single-page/', 'User\SinglePageController@contact_form');

//checkout
Route::post('/process_payment', 'User\OrderPageController@process_payment');
Route::get('/bank_details', 'User\OrderPageController@bank_details');

//About Us
Route::get('/about-us','User\AboutController@index');

//Contact Us
/*Route::get('/contact-us','User\ContactUsController@index');*/
//Route::post('/contact-us',['uses'=>'User\ContactUsController@contact_form']);
// Route::post('/Contact Us','User\ContactUsController@contact_form');
Route::post('/newsletter','User\ContactUsController@newsletter');

// Registration
Route::resource('/register','User\RegisterController@index');

//User Order List and Information
Route::get('/profile-data','User\UserPageController@index');
Route::post('/update-profile','User\UserPageController@SaveProfile');
Route::post('/order-details','User\UserPageController@OrderDetails');

// ADMIN ROUTES
Route::get("admin", "Admin\AuthController@getSignIn");

Route::get('admin/signin', 'Admin\AuthController@getSignIn');
Route::post('admin/signin', 'Admin\AuthController@postSignIn');

Route::resource('product', 'User\ProductPageController@product_ratings');

Route::group(['prefix' => 'admin', 'middleware' => ['auth','admin']], function () {    
        
    Route::get('logout', 'Admin\AuthController@getSignOut');

	Route::resource('email-template', 'Admin\EmailTemplateController');
	Route::post('email-template-update', 'Admin\EmailTemplateController@update');
	Route::post('image_upl','Admin\UserController@image_upl');
    Route::resource('payment-method', 'Admin\PaymentMethodController');
    Route::resource('dashboard', 'Admin\DashboardController');
	Route::resource('orders', 'Admin\OrderController');
	Route::get('orders', 'Admin\OrderController@search');
	Route::post('orders/view-details', 'Admin\OrderController@order_details');
	Route::post('orders/order-update-status', 'Admin\OrderController@update_status');
    Route::any('category', 'Admin\CategoryController@index');
	Route::post('category-store', 'Admin\CategoryController@store');
	Route::post('category-update', 'Admin\CategoryController@update');
	Route::delete('category-delete/{id}', 'Admin\CategoryController@destroy');
    Route::any('brand', 'Admin\BrandController@index');
    Route::post('brand-store', 'Admin\BrandController@store');
    Route::post('brand-update', 'Admin\BrandController@update');
	Route::get('brand-delete/{id}', 'Admin\BrandController@destroy');
	Route::delete('brand/{id}', 'Admin\BrandController@destroy');
    Route::get('item-delete/{id}/{name}', 'Admin\PageController@destroyBrands');
    Route::resource('supplier', 'Admin\SupplierController');
	Route::post('supplier-update', 'Admin\SupplierController@update');
	Route::delete('supplier/{id}', 'Admin\SupplierController@destroy');
    Route::resource('post', 'Admin\PostController');
    Route::post('update-post', 'Admin\PostController@update');
    Route::resource('page', 'Admin\PageController');
	Route::get('page/edit/{id}', 'Admin\PageController@edit');
	Route::delete('page/delete/{id}', 'Admin\PageController@deletePostLink');
    Route::post('page/updatemetadata', 'Admin\PageController@updatemetadata');
	Route::post('page/link-save', 'Admin\PageController@lnk_store');
	Route::post('page/lnk-info','Admin\PageController@get_lnk_info');
	Route::post('page/lnk-add_post','Admin\PageController@link_manage_post');
	Route::resource('reviews-and-rating', 'Admin\ReviewsandRatingController');
	Route::post('reviews-and-rating/review-action', 'Admin\ReviewsandRatingController@review_ratings');
	Route::resource('shipping', 'Admin\ShippingController');
	Route::delete('shipping/{id}', 'Admin\ShippingController@destroy');
	Route::post('shipping-add', 'Admin\ShippingController@storeShipping');
    Route::post('shipping-update', 'Admin\ShippingController@update');
    Route::post('shipping-dimension-update', 'Admin\ShippingController@update_shipping_dimension');

    Route::resource('users', 'Admin\UserController');
	Route::get('profile', [
			'uses'=>'Admin\UserController@profile'
	]);
	Route::post('update_profile/{id}', [
			'uses'=>'Admin\UserController@update_profile'
	]);
	Route::post('address_details', [
			'uses'=>'Admin\UserController@address_details'
	]);
	 
	
    Route::resource('roles','Admin\RoleController');
	Route::resource('user-types', 'Admin\UserTypesController');
	Route::post('user-types-update', 'Admin\UserTypesController@update');
	
	Route::resource('settings','Admin\SettingsController');
	Route::post('settings/setting_save','Admin\SettingsController@setting_save');
	
	/*Variable*/
	Route::any('variable', 'Admin\VariableController@index');
	Route::post('variable-store', 'Admin\VariableController@store');
	Route::post('variable/{id}', [
        'uses' => 'Admin\VariableController@update'
	]);
	
	/*Attribute*/
	Route::any('attribute', 'Admin\AttributeController@index');
	Route::post('attribute-store', 'Admin\AttributeController@store');
	Route::post('attribute/{id}', [
        'uses' => 'Admin\AttributeController@update'
	]);
	
	/*Product*/
	Route::resource('product', 'Admin\ProductController');
	Route::any('product', 'Admin\ProductController@index');
	Route::post('product/store', 'Admin\ProductController@store');
	Route::post('product/variation-details', [
		'uses'=>'Admin\ProductController@variation_details'
	]);
	Route::post('product/{id}', [
		'uses' => 'Admin\ProductController@update'
	]);
	Route::delete('product/product-image/{id}', [
		'uses' => 'Admin\ProductController@deleteImage'
	]);
	Route::delete('product/{id}', 'Admin\ProductController@destroy');
	//Subscriber
	Route::resource('subscriber', 'Admin\SubscriberController');
	Route::resource('subscriber/status', 'Admin\SubscriberController@status_update');
	
	
});

Route::group(['prefix' => 'customer', 'middleware' => 'auth'], function () {
	Route::resource('profile', 'Customer\ProfileController');
	Route::resource('manage-password', 'Customer\ProfileController@manage_password');
	Route::resource('manage-profile', 'Customer\ProfileController@manage_profile');
	Route::resource('manage-addressbook', 'Customer\ProfileController@manage_address');
	Route::resource('manage-creditcard', 'Customer\ProfileController@manage_creditcard');
	Route::get('orders', 'User\OrderPageController@index');

	Route::post('update_profile','Customer\ProfileController@update_profile');
	Route::post('update_address','Customer\ProfileController@address_details');
	Route::post('update_creditcard','Customer\ProfileController@update_ccdetails');

	Route::post('update_password','Customer\ProfileController@update_password');

	Route::post('product-ratings','User\ProductPageController@product_ratings');
	Route::post('image_upl','Customer\ProfileController@image_upl');

	Route::resource('wishlist','Customer\ProfileController@manage_wishlist');
	Route::post('remove-wishlist', 'Customer\ProfileController@remove_wishlist');
	
	/*Route::post('order-view-details', 'Customer\ProfileController@order_details');*/
	Route::get('order-details/{id}', 'Customer\ProfileController@order_details');
	Route::post('order-update-status', 'Customer\ProfileController@update_status');	
	
}); 
