@extends('layouts.user.app')
@section('css')
<style>
    #footer {
        display: none !important;
    }
</style>
@endsection
@section('content')
<div id="wrapper-customer" style="margin:2% auto;">
	<div class="container">
		<div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8"><h3 class="box-title">My Wishlist</h3></div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
				<button class="btn btn-gold pull-right mt15" tabindex="0"><a role="button" style="color: #FFFFFF;" href="{{ URL::to('/customer/profile') }}">Dashboard</a></button>
			</div>		
		</div>
        <div class="row">
            <div class="col-lg-12">
                <table class="table table-striped cart-table">
                    <thead class="cart-header">
                        <tr>
                            <th colspan="2" class="col-md-10">Product</th>  
                            <th class="col-md-1">Price</th>
                            <th colspan="2"  class="col-md-1">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($Wishlist as $list)
                            <tr class="wishlist-product">
                                <td><div class="wishlist-img" style="background: url('{{ URL::asset('img/products') }}/{{$list->ParentData['featured_image']}}');"></div></td>
                                <td><div class="lead">{{$list->ParentData['name']}}</div>
                                    <div class="elip-two">{!!$list->ParentData['description']!!}</div></td>
                                <td><a href="/product/{{$list->ParentData['slug_name']}}"><button class="btn btn-sm btn-success add-cart">View</button></a></td>
                                <td><button class="btn btn-sm btn-danger remove-wishlist" data-wishlistid="{{$list->id}}">Delete</button></td>
                            </tr>                            
                        @endforeach
                    </tbody>
                </table>
                <div class="pagination"> {{ $Wishlist->links() }} </div>
            </div>
        </div>
	</div>
</div>
@stop
@section('scripts')

@endsection	