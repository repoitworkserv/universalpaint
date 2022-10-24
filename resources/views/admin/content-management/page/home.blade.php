<div class="row" id="cms-home">
   {!! csrf_field() !!}
   <?php 
    $myPermit = explode(",",Auth::user()->permission);
   ?>
   <div class="col-lg-12">
      {{-- 
      <div class="box-group" id="accordion">
         --}}
         <div class="row">
            <div class="col-lg-12">
               <div class="box box-gold ">
                  <div class="box-header">
                     <h3 class="box-title">Banner</h3>
                     <div class="pull-right">
                        <input type="hidden" name="banner-array-meta" value="{!! $Page->GetMetaData('banner', 'post')['meta_value']; !!}" class="banner-array-meta">
                        @if(in_array(5.2, $myPermit))
                           <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addBanner"><span class="fa fa-plus"></span></button>
                        @endif
                     </div>
                  </div>
                  <div class="box-body">
                     <div id="banner-carousel" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                           @php 
                           if($Page->GetMetaData('banner', 'post')['meta_value']) {
                           $x = 0;
                           foreach(explode(',', $Page->GetMetaData('banner', 'post')['meta_value']) as $banner) {
                           @endphp
                           <li data-target="#banner-carousel" data-slide-to="{{$x}}" class="{{ $x == 0 ? 'active' : '' }}"></li>
                           @php
                           $x++;
                           };
                           };
                           @endphp
                        </ol>
                        <div class="carousel-inner">
                           @php 
                           if($Page->GetMetaData('banner', 'post')['meta_value']) {
                           $x = 0;
                           foreach(explode(',', $Page->GetMetaData('banner', 'post')['meta_value']) as $banner) {
                           @endphp
                           <div class="item {{ $x == 0 ? 'active' : '' }}">
                              @if(in_array(5.4, $myPermit))
                              <div class="post-admin-btn">
                                 <a href="{{ url('admin/item-delete/'.\App\Post::findOrFail($banner)->id).'/banner' }}" id="alert{{\App\Post::findOrFail($banner)->name}}" onclick="return confirm('Are You Sure to delete this entry?')" class="badge bg-red"><span class="fa fa-trash"></span> Delete</a>
                              </div>
                              @endif
                              <div class="bnnr-img-cntnr" style="background: url({!! asset('img/post/') !!}/{!! \App\Post::findOrFail($banner)->featured_banner; !!});"></div>
                           </div>
                           @php
                           $x++;
                           };
                           };
                           @endphp
                        </div>
                        <a class="left carousel-control" href="#banner-carousel" data-slide="prev">
                        <span class="fa fa-angle-left"></span>
                        </a>
                        <a class="right carousel-control" href="#banner-carousel" data-slide="next">
                        <span class="fa fa-angle-right"></span>
                        </a>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
               <div class="box box-gold ">
                  <div class="box-header">
                     <h3 class="box-title">Featured Products</h3>
                     <div class="pull-right">
                        <input type="hidden" name="featured-product-array-meta" value="{!! $Page->GetMetaData('featured_products', 'product')['meta_value']; !!}" class="featured-product-array-meta">
                        @if(in_array(5.2, $myPermit))
                        <button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#addFeaturedProducts"><span class="fa fa-plus"></span> Add</button>
                        @endif
                     </div>
                  </div>
                  <div class="box-body">
                     <div id="featured-product-carousel" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                           @php 
                           if($Page->GetMetaData('featured_products', 'product')['meta_value']) {
                           $x = 0;                           
                           foreach(explode(',', $Page->GetMetaData('featured_products', 'product')['meta_value']) as $product) {
                           @endphp
                           <li data-target="#featured-product-carousel" data-slide-to="{{$x}}" class="{{ $x == 0 ? 'active' : '' }}"></li>
                           @php
                           $x++;
                           };
                           };
                           @endphp
                        </ol>
                        <div class="carousel-inner">
                           @php 
                           if($Page->GetMetaData('featured_products', 'product')['meta_value']) {
                           $x = 0;                           
                           foreach(explode(',', $Page->GetMetaData('featured_products', 'product')['meta_value']) as $product) {
                           @endphp
                           <div class="item {{ $x == 0 ? 'active' : '' }}">
                              @if(in_array(5.4, $myPermit))
                              <div class="post-admin-btn">
                                 <a href="{{ url('admin/item-delete/'.\App\Product::findOrFail($product)->id).'/featuredProducts' }}" id="alert{{\App\Product::findOrFail($product)->name}}" onclick="return confirm('Are You Sure to delete this entry?')" class="badge bg-red"><span class="fa fa-trash"></span> Delete</a>
                              </div>
                              @endif
                              <div class="row">
                                 <div class="col-lg-5">
                                    <div class="dls-img-cntnr" style="background: url({!! asset('img/products/') !!}/{!! \App\Product::findOrFail($product)->featured_image; !!});"></div>
                                 </div>
                                 <div class="col-lg-7">
                                    <div class="sld-ttl">{!! \App\Product::findOrFail($product)->name; !!}</div>
                                    <!-- <h3>SRP {!! \App\Product::findOrFail($product)->price; !!}</h3>
                                       <div class="sld-dsc">{!! \App\Product::findOrFail($product)->description; !!}</div> -->
                                 </div>
                              </div>
                           </div>
                           @php
                           $x++;
                           };
                           };
                           @endphp
                        </div>
                        <a class="left carousel-control" href="#featured-product-carousel" data-slide="prev">
                        <span class="fa fa-angle-left"></span>
                        </a>
                        <a class="right carousel-control" href="#featured-product-carousel" data-slide="next">
                        <span class="fa fa-angle-right"></span>
                        </a>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
               <div class="box box-gold ">
                  <div class="box-header">
                     <h3 class="box-title">Header Social Media Icons</h3>
                     <div class="pull-right">
                         @if(isset($Page->GetMetaData('social_media_icons', 'post')['meta_value']))
                        <input type="hidden" name="social-media-icon-array-meta" value="{!! $Page->GetMetaData('social_media_icons', 'post')['meta_value']; !!}" class="social-media-icon-array-meta">
                        @endif
                        @if(in_array(5.2, $myPermit))
                        <button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#addSocialMediaIcons"><span class="fa fa-plus"></span> Add</button>
                        @endif
                     </div>
                  </div>
                  <div class="box-body">
                     <div id="social-media-icons-carousel" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                           @php 
                           if(isset($Page->GetMetaData('social_media_icons', 'post')['meta_value']) && $Page->GetMetaData('social_media_icons', 'post')['meta_value']) {
                           $x = 0;                           
                           foreach(explode(',', $Page->GetMetaData('social_media_icons', 'post')['meta_value']) as $product) {
                           @endphp
                           <li data-target="#social-media-icons-carousel" data-slide-to="{{$x}}" class="{{ $x == 0 ? 'active' : '' }}"></li>
                           @php
                           $x++;
                           };
                           };
                           @endphp
                        </ol>
                        <div class="carousel-inner">
                           @php 
                           if(isset($Page->GetMetaData('social_media_icons', 'post')['meta_value']) && $Page->GetMetaData('social_media_icons', 'post')['meta_value']) {
                           $x = 0;
                           foreach(explode(',', $Page->GetMetaData('social_media_icons', 'post')['meta_value']) as $icon) {
                           @endphp
                           <div class="item {{ $x == 0 ? 'active' : '' }}">
                              @if(in_array(5.4, $myPermit))
                              <div class="post-admin-btn">
                                 <a href="{{ url('admin/item-delete/'.\App\Post::findOrFail($icon)->id).'/social_media_icons' }}" id="alert{{\App\Post::findOrFail($icon)->name}}" onclick="return confirm('Are You Sure to delete this entry?')" class="badge bg-red"><span class="fa fa-trash"></span> Delete</a>
                              </div>
                              @endif
                              <div class="row">
                                 <div class="col-lg-12">
                                    <div class="dls-img-cntnr" style="background: url({!! asset('img/post/') !!}/{!! \App\Post::findOrFail($icon)->featured_image; !!});"></div>
                                 </div>
                              </div>
                           </div>
                           @php
                           $x++;
                           };
                           };
                           @endphp
                        </div>
                        <!-- <a class="left carousel-control" href="#social-media-icons-carousel" data-slide="prev">
                        <span class="fa fa-angle-left"></span>
                        </a>
                        <a class="right carousel-control" href="#social-media-icons-carousel" data-slide="next">
                        <span class="fa fa-angle-right"></span>
                        </a> -->
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
               <div class="box box-gold ">
                  <div class="box-header">
                     <h3 class="box-title">Product Categories</h3>
                     <div class="pull-right">
                        <input type="hidden" name="deals-array-meta" value="{!! $Page->GetMetaData('product_category', 'category')['meta_value']; !!}" class="product-categories-array-meta">
                        @if(in_array(5.2, $myPermit))
                        <button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#addProductCategories"><span class="fa fa-plus"></span> Add</button>
                        @endif
                     </div>
                  </div>
                  <div class="box-body">
                     <div id="product-categories-carousel" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                           @php 
                           if($Page->GetMetaData('product_category', 'category')['meta_value']) {
                           $x = 0;                           
                           foreach(explode(',', $Page->GetMetaData('product_category', 'category')['meta_value']) as $category) {
                           @endphp
                           <li data-target="#product-categories-carousel" data-slide-to="{{$x}}" class="{{ $x == 0 ? 'active' : '' }}"></li>
                           @php
                           $x++;
                           };
                           };
                           @endphp
                        </ol>
                        <div class="carousel-inner">
                           @php 
                           if($Page->GetMetaData('product_category', 'category')['meta_value']) {
                           $x = 0;                           
                           foreach(explode(',', $Page->GetMetaData('product_category', 'category')['meta_value']) as $category) {
                           @endphp
                           <div class="item {{ $x == 0 ? 'active' : '' }}">
                              @if(in_array(5.4, $myPermit))
                              <div class="post-admin-btn">
                                 <a href="{{ url('admin/item-delete/'.\App\Category::findOrFail($category)->id).'/productCategory' }}" id="alert{{\App\Category::findOrFail($category)->name}}" onclick="return confirm('Are You Sure to delete this entry?')" class="badge bg-red"><span class="fa fa-trash"></span> Delete</a>
                              </div>
                              @endif
                              <div class="row">
                                 <div class="col-lg-12">
                                    <div class="dls-img-cntnr" style="background: url({!! asset('img/category/') !!}/{!! \App\Category::findOrFail($category)->featured_img; !!});"></div>
                                 </div>
                                 <div class="col-lg-12 text-center">
                                    <div class="sld-ttl">{!! \App\Category::findOrFail($category)->name; !!}</div>
                                    <div class="sld-dsc">{!! \App\Category::findOrFail($category)->description; !!}</div>
                                 </div>
                              </div>
                           </div>
                           @php
                           $x++;
                           };
                           };
                           @endphp
                        </div>
                        <a class="left carousel-control" href="#product-categories-carousel" data-slide="prev">
                        <span class="fa fa-angle-left"></span>
                        </a>
                        <a class="right carousel-control" href="#product-categories-carousel" data-slide="next">
                        <span class="fa fa-angle-right"></span>
                        </a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         {{-- 
      </div>
      --}}
   </div>
</div>
<div class="modal fade" id="addBanner" role="dialog" aria-labelledby="addBannerLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="addBannerLabel">Add Banner</h5>
         </div>
         <div class="modal-body">
            <div class="form-group">
               <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" multiple="multiple" id="banner-post-list" name="banner-post-list[]">
                  <option value="0">---Select Post---</option>
                  @foreach($Post as $list)
                  <option value="{{$list->id}}">{{$list->post_title}}</option>
                  @endforeach
               </select>
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="add-banner">ADD</button>
         </div>
      </div>
   </div>
</div>
<div class="modal fade" id="addFeaturedProducts" role="dialog" aria-labelledby="addFeaturedProductsLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="addFeaturedProductsLabel">Add Featured Product</h5>
         </div>
         <div class="modal-body">
            <div class="form-group">
               <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" id="featured-product-list" multiple="multiple" name="featured-product-list[]">
                  <option value="0">---Select Product---</option>
                  @foreach($Product as $list)
                  <option value="{{$list->id}}">{{$list->name}}</option>
                  @endforeach
               </select>
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="add-featured-product">ADD</button>
         </div>
      </div>
   </div>
</div>
<div class="modal fade" id="addSocialMediaIcons" role="dialog" aria-labelledby="addSocialMediaIcon" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="addSocialMediaIcon">Add Spcial Media Icon</h5>
         </div>
         <div class="modal-body">
            <div class="form-group">
               <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" multiple="multiple" id="socialmediaicon-post-list" name="socialmediaicon-post-list[]">
                  <option value="0">---Select Post---</option>
                  @foreach($Post as $list)
                  <option value="{{$list->id}}">{{$list->post_title}}</option>
                  @endforeach
               </select>
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="add-social-media-icon">ADD</button>
         </div>
      </div>
   </div>
</div>
<div class="modal fade" id="addProductCategories" role="dialog" aria-labelledby="addProductCategoriesLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="addProductCategoriesLabel">Add Product Category</h5>
         </div>
         <div class="modal-body">
            <div class="form-group">
               <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" id="product-category-list" multiple="multiple" name="product-category-list[]">
                  <option value="0">---Select Category---</option>
                  @foreach($Category as $list)
                  <option value="{{$list->id}}">{{$list->name}}</option>
                  @endforeach
               </select>
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="add-product-category">ADD</button>
         </div>
      </div>
   </div>
</div>
<style>
   #cms-home .sld-ttl{
   font-size: 22px;
   line-height: 1;
   overflow: hidden;
   text-overflow: ellipsis;
   -webkit-box-orient: vertical;
   -webkit-line-clamp: 1;
   height: calc(22px * 1 * 1);
   display: -webkit-box;
   }
   #cms-home .sld-dsc{
   font-size: 18px;
   line-height: 1.2;
   overflow: hidden;
   text-overflow: ellipsis;
   -webkit-box-orient: vertical;
   -webkit-line-clamp: 5;
   height: calc(18px * 1.2 * 5);
   display: -webkit-box;
   }
</style>