@extends('layouts.user.app')

@section('content')

<div id="products">
    <div class="page-header">
        <div class="page-title">SERVICES</div>        
    </div>
    <div class="row">
        <div class="col-lg-2">
            
        </div>
        <div class="col-lg-8">            
           
            <!-- PAGINATION -->
            <div class="pagination"> {{ $servlist->links() }} </div>

            <!-- DISPLAY PRODUCTS -->
            
            @php
                $ctrl = 1;

                foreach($servlist as $listserv)
                {
                    if($ctrl == 1){
                        echo '<div class="row">';
                    }
            @endphp

                <div class="col-lg-4">
                    <div class="item">
                        <div class="item-image bg-img" style="background: url({{ URL::asset('img/materials/prod1.jpg') }});">

                        </div>
                        <div class="separator"></div>
                        <div class="item-content">
                            <div class="item-title">{{ $listserv->name }}</div>
                            <a href="/services/{{$listserv->id}}" tabindex="-1"><button class="button button--aylen" tabindex="-1">VIEW DETAILS</button></a>                            
                        </div>
                    </div>
                </div>

         @php
                    if($ctrl == 3){
                        echo '</div><br><br>';
                    }
                
                    $ctrl++;
                    if($ctrl == 4){ $ctrl=1; }

                }
            @endphp
           


            <!-- PAGINATION -->
            <div class="pagination"> {{ $servlist->links() }} </div>


        </div>
    </div>
</div>
@endsection