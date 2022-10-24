@extends('layouts.admin.main')

@section('content')
	 <!-- Content Wrapper. Contains page content -->
	
	
	
	  <section class="content-header">
	    <h1>
	      Product
	    </h1>
@include('flash-message')
<?php 
  $myPermit = explode(",",Auth::user()->permission);
?>
	  </section>
	  <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-gold">
            <div class="box-header">
              <div class="col-xs-2">
              

              </div>
            </div>



        <!-- /.box-header -->
            <div class="box-body">
              <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap">

                <div class="row mb20">
                  <div class="col-md-4 col-sm-4 col-xs-12">
                  	<form  action="{{URL::to('/admin/product')}}" method="get"  accept-charset="UTF-8" enctype="multipart/form-data">
                  		{!! csrf_field() !!}
	                  	<div class="input-group">
	                  		<input type="text" class="form-control input-gold" name="search_item" value="{{($search_item) ? $search_item : ''}}">
		                    <span class="input-group-btn">
		                      <button type="type" class="btn btn-gold"><i class="fa fa-search"></i> Search Product</button>
		                    </span>
			              </div>
                    <select class="form-control input-gold" name="search_brand">
                              <option value="" disabled selected>Select your Brand</option>
                            @foreach($brand_id as $brands)
                              <option value="{{ $brands->id }}">{{ $brands->name }}</option>
                            @endforeach
                        </select>
		            </form>
                  </div>
                  <div class="col-md-8 col-sm-8 text-right">
                  	<a href="{!! URL::action('Admin\ProductController@create') !!}" ><div class="btn btn-gold">Add Product</div></a>
                  </div>
                </div>

                <div class="row">
                	
                  <div class="col-md-12 col-sm-12 col-xs-12">

                    <table id="example1" class="table table-striped" role="grid" aria-describedby="example1_info">
                    <thead>
                    <tr role="row">
                      <th>View Links</th>
                      <th>Product Code</th>
                      <th>Product Name</th>
                      <th>Type</th>
                      <th>Brand</th>
                      <th>Sale</th>
					  <th>Action</th>
                    </tr>
                    </thead>

                    <tbody>

                      @foreach( $productlist as $pl )
						<tr role="row" class="odd">
            <td><button class="view_product_btn cpointer btn btn-info" data-all="{{$pl->ProductOverview}}" data-howtouse="{{$pl->howtousetab_details}}" data-deliveryopt="{{$pl->deliveryopt_tab_details}}" data-rating="{{$pl->rating}}" data-quantity="{{$pl->quantity}}" data-productcode="{{$pl->product_code}}" data-producttype="{{$pl->product_type}}" data-desc="{{$pl->description}}" data-price="{{number_format($pl->price, 2)}}" data-orderid="{{$pl->id}}" data-featuredImage="{{$pl->featured_image}}" data-name="{{$pl->name}}" data-branddesc="{{isset($pl->BrandData['description']) ? $pl->BrandData['description'] : '' }}" data-brand="{{isset($pl->BrandData['name']) ? $pl->BrandData['name'] : '' }}"/>Preview</td>
							            <td>{{ $pl->product_code }}</td>
                        	<td>{{ $pl->name }}</td>
                        	<td>{{ $pl->product_type }}</td>
                        	<td>{{ isset($pl->BrandData['name']) ? $pl->BrandData['name'] : ""  }}</td>
                        	<td>{{ ($pl->is_sale == 1 ? 'Yes' : 'No') }}</td>
                        	<td>
                        		<a target="_blank" href="{!! URL::action('Admin\ProductController@edit', $pl->id) !!}" class="badge bg-orange edit-product" ><i class="	fa fa-pencil-square-o"></i> View</a>
                            @if(in_array(3.4, $myPermit))
                            <form action="{{ URL::action('Admin\ProductController@destroy', $pl->id) }}" method="POST">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                <a id="alert{{$pl->id}}" class="badge bg-red"><span class="fa fa-trash"></span> Delete</a>
                            </form>
                            @endif
                        	</td>
                        </tr>
                        <tr>
                        </tr>
				          	@endforeach
                    </tbody>
                    </table>
                  </div>
                </div>
          
		<div>{{ $productlist->firstItem() }} - {{ $productlist->lastItem() }} of {{ $productlist->total() }} </div>
        <!-- /.box-body -->
          <div class="pagination"> {{ $productlist->appends(request()->query())->links() }} </div>
        </div>



      </div>
    
  </div>

</div>
</section>
<!-- /.content-wrapper -->
<div id="previewProduct" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg">
      <div class="panel panel-primary">
        <div class="panel-heading"><h4 class="modal-title">Product Preview</h4></div>
        <div class="panel-body">
          <input type="hidden" name="image-source" id="image-source" value="">
          <input type="hidden" name="product-id-view" id="product-id-view" value="">
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="xtra">

                </div>
              </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="row">
                  <label class="col-md-4 col-sm-4 col-xs-12" >Product Code</label>
                  <span class="product-code col-md-8 col-sm-8 col-xs-12" >

                  </span>
                </div>
              </div>

              <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="row">
                  <label class="col-md-4 col-sm-4 col-xs-12" >Name</label>
                  <span class="product-name col-md-8 col-sm-8 col-xs-12" >

                  </span>
                </div>
              </div>

              <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="row">
                  <label class="col-md-4 col-sm-4 col-xs-12" >Brand</label>
                  <span class="product-brand col-md-8 col-sm-8 col-xs-12" >

                  </span>
                </div>
              </div>

              <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="row">
                  <label class="col-md-4 col-sm-4 col-xs-12" >Quantity</label>
                  <span class="product-quantity col-md-8 col-sm-8 col-xs-12" >

                  </span>
                </div>
              </div>

              <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="row">
                  <label class="col-md-4 col-sm-4 col-xs-12" >Price</label>
                  <span class="product-price col-md-8 col-sm-8 col-xs-12" >

                  </span>
                </div>
              </div>

              <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="row">
                  <label class="col-md-4 col-sm-4 col-xs-12" >Rating</label>
                  <span class="product-rating col-md-8 col-sm-8 col-xs-12" >

                  </span>
                </div>
              </div>

              <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="row">
                  <label class="col-md-4 col-sm-4 col-xs-12" >Product Type</label>
                  <span class="product-type col-md-8 col-sm-8 col-xs-12" >

                  </span>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-12">
              <div class="tabs">
                  <ul class="tab-links nav nav-tabs">
                      <li class="active"><a data-toggle="tab"  href="#tab1">Overview</a></li>
                      <li><a data-toggle="tab"  href="#tab2">Product Details</a></li>
                      <li><a data-toggle="tab"  href="#tab3">How To Use</a></li>
                      <li><a data-toggle="tab"  href="#tab4">About the Brand</a></li>
                      <li><a data-toggle="tab"  href="#tab5">Delivery Option</a></li>
                  </ul>
                  <div class="tab-content">
                      <div id="tab1" class="tab-pane fade in active">
                          <div class="" style="word-break: break-all;">
                            @php  @endphp
                                  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                      <div class="row">
                                          <div class="content-line-text row" id="row-overview-text">

                                          </div>
                                      </div>
                                  </div>
                          </div>
                      </div>
                      <div id="tab2" class="tab-pane fade" style="word-break: break-all;">
                        <span class="product-desc col-md-8 col-sm-8 col-xs-12" >

                        </span>
                      </div>
                      <div id="tab3" class="tab-pane fade" style="word-break: break-all;">
                        <span class="product-howtouse col-md-8 col-sm-8 col-xs-12">

                        </span>
                      </div>
                      <div id="tab4" class="tab-pane fade" style="word-break: break-all;">
                        <span class="product-brand-desc col-md-8 col-sm-8 col-xs-12">

                        </span>
                      </div>
                      <div id="tab5" class="tab-pane fade" style="word-break: break-all;">
                        <span class="product-deliveryopt col-md-8 col-sm-8 col-xs-12">

                        </span>
                      </div>
                  </div>
              </div>
          </div>
          </div>
        </div>
        <div class="panel-footer" style="text-align: right">
          <div class="button-group">
              <button type="button" id="btnClose" class="btn btn-warning" data-dismiss="modal">Close</button>
          </div>
      </div>
      </div>
      </div>
  </div>
</div>
@stop



@section('scripts')
<script type="text/javascript" src="{{URL::asset('static/bootstrap-toggle-master/js/bootstrap-toggle.min.js')}}"></script>
<script>
  var Token = $('input[name="_token"]').val();
  $('.view_product_btn').on('click',function(){
    var orderid = $(this).data("orderid");
    $('#product-id-view').val(orderid);
    $('.product-code').html($(this).data("productcode"));
    $('.product-brand').html($(this).data("brand"));
    $('.product-howtouse').html($(this).data("howtouse"));
    $('.product-deliveryopt').html($(this).data("deliveryopt"));
    $('.product-quantity').html($(this).data("quantity"));
    $('.product-name').html($(this).data("name"));
    $('.product-rating').html($(this).data("rating"));
    $('.product-price').html($(this).data("price"));
    $('.product-type').html($(this).data("producttype"));
    $('.product-desc').html($(this).data("desc"));
    $('.product-brand-desc').html($(this).data("branddesc"));
    var product_image_container = '<img src="/img/products/' + $(this).data('featuredimage') + '" width="50%" class="img-thumbnail post-img">'
    $('#previewProduct panel panel-body .xtra').html('');
    $('.xtra').append(product_image_container);
    $('#previewProduct').modal("show");

    //loop
    console.log($(this).data('all'));
    for(var i=0;i<$(this).data('all').length; i++){
      var overview_product_desc =  '<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"><span class="product-orverview-title">'+ $(this).data('all')[i]['title'] +'</span></div>'+'<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8"><span class="product-overview-desc">'+ $(this).data('all')[i]['description'] +'</span></div>';
    }
    $('#row-overview-text').append(overview_product_desc);
  });

  $('#btnClose').on('click', function(){
    $('.xtra').html('');
    $('#row-overview-text').html('');
  });

//Delete product
$("a[id*=alert]").on("click", function(){

    if(confirm("Do you want to delete this item?")){
        $(this).parent('form').submit();
    }
    
});
</script>
@stop
