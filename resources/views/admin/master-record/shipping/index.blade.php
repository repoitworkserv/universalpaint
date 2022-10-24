@extends('layouts.admin.main')

@section('styles')
<link href="{!! asset('static/bootstrap-toggle-master/css/bootstrap-toggle.min.css') !!}" media="all" rel="stylesheet" type="text/css" />
@stop

@section('content')

  <section class="content-header">
    <h1>
      Shipping Rate
    </h1>
    @include('flash-message')
    <?php 
      $myPermit = explode(",",Auth::user()->permission);
   	?>  
  </section>
  <section class="content">
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-gold">
                <div class="box-header">
                    <h3 class="box-title"> Package Size </h3>
                </div>
                <div class="box-body">
<!--                     <button data-toggle="modal" data-target="addNewShipping" id="modalShow" class="btn btn-gold">Add</button> -->

                    <form action="{{ URL::action('Admin\ShippingController@update_shipping_dimension') }}" method="post" accept-charset="UTF-8">
                        {!! csrf_field() !!}
                        <h3>Weight (kg)</h3>
                        <div class="row">
                            @for($ship=0;$ShippingDimension->count() > $ship; $ship++)
                                <div class="col-lg-3 col-md-3 col-sm-12">
                                        {{-- <table style="width:20%">
                                            <tbody>
                                                <td style="width: 50px">{{ $ShippingDimension[$ship]['weight'] }} Kg</td>
                                                <td style="width: 50px"><input type="text" name="weight{{$ship}}" id="weight{{$ship}}" class="form-control" placeholder="Enter Weight" value="{{$ShippingDimension[$ship]['weight']}}"></td>
                                            </tbody>
                                        </table> --}}
                                    <div class="form-group">
                                        <label>{{ $ShippingDimension[$ship]['weight'] }} Kg</label>
                                        <input type="text" name="weight{{$ship}}" id="weight{{$ship}}" class="form-control" placeholder="Enter Weight" value="{{$ShippingDimension[$ship]['weight']}}">
                                    </div>
                                </div>
                                @endfor
                            </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="text-right">
                                    @if(in_array(3.3, $myPermit))
                                    <button type="submit" class="btn btn-gold pull-right">Update Shipping Dimension</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-gold">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-plus-circle"></i> Create Shipping </h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-lg-5">
                            <form action="{{ URL::action('Admin\ShippingController@store') }}" method="post" accept-charset="UTF-8">
                                <div class="form-group">
                                    <label>Location</label>
                                    <input type="text" name="location" style="text-transform: capitalize;" id="location"  class="form-control" placeholder="Enter Location">
                                </div>
                                <div class="form-group">
									<input type="checkbox" checked="true" name="status" value="1"><strong for="prodname"> Active</strong>
								</div>
                                @for($s=0;$ShippingDimension->count() > $s; $s++)
                                <div class="col-lg-3 col-md-3 col-sm-12">
                                    <div class="form-group">
                                    <label>{{ $ShippingDimension[$s]['weight'] }} Kg</label>
                                    <input type="text" name="price{{$s}}"  id="price{{$s}}" class="form-control" placeholder="Enter Amount">
                                    </div></div>
                                @endfor
                                <div class="text-right">
                                    @if(in_array(3.2, $myPermit))
                                        {!! csrf_field() !!}
                                    <button type="submit" class="btn btn-gold pull-right">Add Shipping</button>
                                    @endif
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-7">
                            @if($Shipping)
                            <table class="table table-striped">
                            	<thead>
                            		<tr>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                            	</thead>
                                <tbody>
                                    @if(!empty($Shipping[0]))
                                        @foreach( $Shipping as $list )
                                            <tr>
                                                <td>{{ $list->location }}</td>
                                                <td>{{ $list->amount }}</td>
                                                {{-- @if($list->id == 1)
                                                <td>
                                                    &nbsp;
                                                </td>
                                                @else --}}
                                                <td>
                                                  <a class="badge bg-orange edit-shipping" 
                                                    data-shippingid="{{$list->id}}" 
                                                    data-location="{{$list->location}}" 
                                                    data-shippingprice1="{{$list->below05kg}}" 
                                                    data-shippingprice2="{{$list->below1kg}}" 
                                                    data-shippingprice3="{{$list->below3kg}}" 
                                                    data-shippingprice4="{{$list->below4kg}}" 
                                                    data-shippingprice5="{{$list->below5kg}}" 
                                                    data-shippingprice6="{{$list->below6kg}}" 
                                                    data-shippingprice7="{{$list->below7kg}}" 
                                                    data-shippingprice8="{{$list->below8kg}}" 
                                                    data-shippingprice9="{{$list->below9kg}}" 
                                                    data-shippingprice10="{{$list->below10kg}}" 
                                                    data-shippingprice11="{{$list->below11kg}}" 
                                                    data-shippingprice12="{{$list->below12kg}}" 
                                                    data-shippingprice13="{{$list->below13kg}}" 
                                                    data-shippingprice14="{{$list->below14kg}}" 
                                                    data-shippingprice15="{{$list->below15kg}}" 
                                                    data-shippingprice16="{{$list->below16kg}}" 
                                                    data-shippingprice17="{{$list->below17kg}}" 
                                                    data-shippingprice18="{{$list->below18kg}}" 
                                                    data-shippingprice19="{{$list->below19kg}}" 
                                                    data-shippingprice20="{{$list->below20kg}}"
                                                    data-shippingstatus="{{$list->status}}">
                                                        <span class="fa fa-edit"></span> View
                                                    </a>
                                                    @if(in_array(3.4, $myPermit))
                                                    <form action="{{ URL::action('Admin\ShippingController@destroy', $list->id) }}" method="POST">
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                        <a id="alert{{$list->id}}" class="badge bg-red"><span class="fa fa-trash"></span> Delete</a>
                                                    </form>
                                                    @endif
                                                </td>
                                                {{-- @endif --}}
                                            </tr>
                                            <tr><td colspan="3"></td></tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="3">Nothing here!</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>    
                            @endif
                            <div class="pagination"> {{ $Shipping->links() }} </div>
                        </div>
                        <div id="editMdl" class="modal fade" role="dialog">
                            <div class="modal-dialog modal-lg">
                                <div class="panel panel-primary">
                                    <form action="{{ URL::action('Admin\ShippingController@update') }}" method="post"accept-charset="UTF-8">
                                        <div class="panel-heading"><h4 class="modal-title">Edit Shipping</h4></div>
                                        <div class="panel-body">
                                            {!! csrf_field() !!}
                                            <input type="hidden" name="e_id" id="e_id">
                                            <div class="form-group">
                                                <label>Location</label>
                                                <input type="text" name="e_location" id="e_location" class="form-control" placeholder="Enter ...">
                                            </div>
                                            <div class="form-group">
                                                <input type="checkbox" id="e_status" name="e_status"><strong for="prodname"> Active</strong>
                                            </div>
                                        	@php $i = 0; @endphp
                                        		@for($s=0;$ShippingDimension->count() > $s; $s++)
                                                <div class="form-group col-lg-3 col-md-3 col-sm-12">
                                                <label>{{ $ShippingDimension[$s]['weight'] }} Kg</label>
                                                <input type="text" name="e_price{{$s}}" id="e_price{{$s}}" class="form-control" placeholder="Enter ...">
                                                </div>
                                            	@endfor
                                            {{-- <div class="form-group">
                                                <label>Small Package Amount</label>
                                                <input type="text" name="e_small_amount" id="e_small_amount" class="form-control" placeholder="Enter ...">
                                            </div>
                                            <div class="form-group">
                                                <label>Medium Package Amount</label>
                                                <input type="text" name="e_medium_amount" id="e_medium_amount" class="form-control" placeholder="Enter ...">
                                            </div>
                                            <div class="form-group">
                                                <label>Large Package Amount</label>
                                                <input type="text" name="e_large_amount" id="e_large_amount" class="form-control" placeholder="Enter ...">
                                            </div> --}}
                                        </div>
                                        <div class="panel-footer" style="text-align: right">
                                            <div class="button-group">
                                                @if(in_array(3.3, $myPermit))
                                                <button type="submit" class="btn btn-success">Update</button>
                                                @endif
                                                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="addNewShipping" class="modal fade" role="dialog"> <!-- modal container -->
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content custom-modal" style="background: url({{ URL::asset('img/modal/pop_bg_002.png') }});">
                    <button type="button" class="close custom-close-modal" data-dismiss="modal">&times;</button>
                <div class="modal-body">
                    <div class="modal-announce">
                        <div class="top">
                        </div>
                        <div class="bottom">
                                <div class="row">
                                        <div >
                                                <form action="{{ URL::action('Admin\ShippingController@storeShipping') }}" method="post" accept-charset="UTF-8">
                                                       
                                            <div class="form-group">
                                                <label>Name (kg)</label>
                                                <input type="text" name="size" id="size" class="form-control" placeholder="Label" value="">
                                                <div class="form-group">
                                                    <input type="checkbox" checked="true" name="status" value="1"><strong for="prodname"> Active</strong>
                                                </div>
                                                <label>Weight</label>
                                                <input type="text" name="weight" id="weight" class="form-control" placeholder="Enter Weight" value="">
                                                <input type="hidden" name="width" id="width" class="form-control" placeholder="Enter width" value="">
                                                <input type="hidden" name="height" id="height" class="form-control" placeholder="Enter height" value="">
                                                <input type="hidden" name="length" id="length" class="form-control" placeholder="Enter length" value="">
                                            </div>
                                            <div class="panel-footer" style="text-align: right">
                                                    <div class="button-group">
                                                            {!! csrf_field() !!}
                                                        <button type="submit" class="btn btn-success">Update</button>
                                                        <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
                                                    </div>
                                                </div>
                                                </form>
                                        </div>
                                    </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </section>
@stop

@section('scripts')
<script type="text/javascript" src="{{URL::asset('static/bootstrap-toggle-master/js/bootstrap-toggle.min.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('js/app.js')}}"></script>
<script>

$(document).ready(function() {

$("#modalShow").on("click", function(){
    $('#addNewShipping').modal('show');
});
//Delete product
$("a[id*=alert]").on("click", function(){

    if(confirm("Do you want to delete this item?")){
        $(this).parent('form').submit();
    }
    
});

});
</script>
@stop