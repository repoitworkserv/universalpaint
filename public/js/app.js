$(document).ready(function () {

setTimeout(function(){$('#checkout-page .ship-loc').trigger("change");}, 1000)

setTimeout(function(){$('#shipping-location').trigger("change");}, 1000)

//DEFAULT

    $(".numbers-only").keypress(function (e) {

        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {

            return false;

        }

    });



    $('.numbers-only').on("cut copy paste", function (e) {

        e.preventDefault();

    });

//DEFAULT END

    $('.navbar-toggle, .filter-toggle').on('click touchmove',function(e){

        e.stopPropagation();

        target = $(this).data('target');

        if($(this).hasClass('collapsed')) {

            $(this).removeClass('collapsed');

            $(target).addClass('in');

            $('body').css('overflow', 'hidden');

        } else {

            $(this).addClass('collapsed');

            $(target).removeClass('in');

            $('body').css('overflow', '');

        }

    });

    $(this).click(function (e) {

        if($(".mobile-menu").hasClass('in')){

            $('.navbar-toggle').click();

        }

        if ($("#products .filter").hasClass('in')){

            $('.filter-toggle').click();

        }

    });

    $('input#customerpaswd_log').keyup(function(e){

        var CumsID = $('input#customerid_log').val();

        var Passwd = $(this).val();

        if(CumsID != '' && Passwd != ''){

            if(e.keyCode == 13)

            {

                client_Login();          

            }

        }        

    });



    $('button#vieworder').on('click',function(){

        $('tbody#tblSearchTr').html('<tr><td colspan="4"><p class="text-success">Please wait while getting the details...</p></td></tr> ');

        var OrderId = $(this).attr('data-id');

        var myTblApps = '';

        $.ajax({

            url: '/order-details',

            method: "post",

            dataType: "json",

            data :{orderID:OrderId},

            success: function (data) {

                for(var a=0; a<data.length; a++){

                    myTblApps += '<tr>'+

                                    '<td>'+data[a].ProductName+'</td>'+

                                    '<td>'+data[a].ProductQty+'</td>'+

                                    '<td>'+data[a].ProductPrice+'</td>'+

                                    '<td>'+data[a].ProductTotal+'</td>'+

                                 '</tr>';                    

                }



                $('tbody#tblSearchTr').html(myTblApps);

            }

        });



    });



//PRODUCT DETAIL

          $('select.atrribute-list').on('change', function() {

            $('.prod_qty').val('0');

            var attri = '';

            $('select[name^="prod-attri"]').each(function() {

                attri = attri + ',' + $(this).val();

            });

            var parent_id = $('input#parentid').val();

            var varcount = $('input#var-count').val();

            var Token = $('input[name="_token"]').val();

            $.ajax({

                url: '/product-variance',

                method: "post",

                dataType: "json",

                data: {

                    parent_id: parent_id,

                    attri: attri,

                    varcount: varcount,

                    _token: Token

                },

                success: function (data) {
                    
                    if (data.product_child[0]) {

                        $('.quantity-text').html('&nbsp;');

                    	var imageUrl = data.product_child[0].featured_image;

                   		var flagsUrl = data.url;

                    	//$('.base-zoom').css('background-image',"url("+ flagsUrl+ '/' + imageUrl +")");

                    	//$('.base-zoom').css('background-repeat', 'no-repeat');

                    	$('.base-zoom').data(flagsUrl+ '/' + imageUrl)

						$('.photo-zoom').css('background-image',"url("+ flagsUrl+ '/' + imageUrl +")");



                        $('.quantity-text').html(data.product_child[0].quantity + ' stocks available');

                        if (data.product_child[0].is_sale == '1') {

                            $('.price').html('&#8369; ' + data.product_child[0].sale_price.toFixed(2));

                            $('input#item_price').val(data.product_child[0].price.toFixed(2));

                            $('input#item_discount').val(data.product_child[0].discount);

                            $('input#item_discount_type').val(data.product_child[0].discount_type);

                            $('input#item_sale_price').val(data.product_child[0].sale_price);

                        } else {

                            if(data.product_child[0].price === 0) {

                                if(data.product_child[0].parent_data.is_sale === 1) {

                                    var parent_price = data.product_child[0].parent_data.price;

                                    var parent_discount = data.product_child[0].parent_data.discount;

                                    if(data.product_child[0].product_type == 'fix'){

                                        $('.price').html('&#8369; ' + data.product_child[0].parent_data.sale_price.toFixed(2));

                                        $('.regular-price').html('<span class="price-before">&#8369;' + parent_price.toFixed(2).toString() + '   </span> <span class="discount">&#8369;' + parent_discount.toString().toFixed(2) + ' OFF</span>');

                                    } else {

                                        $('.price').html('&#8369; ' + data.product_child[0].parent_data.sale_price.toFixed(2));

                                        $('.regular-price').html('<span class="price-before">&#8369;' + parent_price.toFixed(2).toString() + '   </span> <span class="discount"> ' + parent_discount.toString() + ' % OFF</span>');

                                    }

                                    $('input#item_price').val(data.product_child[0].parent_data.price);

                                    $('input#item_discount').val(data.product_child[0].parent_data.discount);

                                    $('input#item_discount_type').val(data.product_child[0].parent_data.discount_type);

                                    $('input#item_sale_price').val(data.product_child[0].parent_data.sale_price);

                                } else {

                                    $('input#item_price').val(data.product_child[0].parent_data.price);

                                    $('.price').html('&#8369; ' + data.product_child[0].parent_data.price);

                                    $('.regular-price').html('');

                                    $('input#item_discount').val(0);

                                    $('input#item_discount_type').val(0);

                                    $('input#item_sale_price').val(0);

                                }

                            } else {

                                for(var i=0; data.pricetype.length > i; i++){

                                    if(data.pricetype[i].user_types_id === data.user_type_id){

                                        $('input#item_price').val(data.pricetype[i].price.toFixed(2));

                                        $('.price').html('&#8369; ' + data.pricetype[i].price.toFixed(2));

                                        $('.regular-price').html('');

                                        $('input#item_discount').val(0);

                                        $('input#item_discount_type').val(0);

                                        $('input#item_sale_price').val(0);

                                    }

                                }

                            }

                        }

                        data.product_child[0].shipping_weight === 0 ? $('input#shipping_weight').val(data.product_child[0].parent_data.shipping_weight) : $('input#shipping_weight').val(data.product_child[0].shipping_weight);

                        data.product_child[0].shipping_height === 0 ? $('input#shipping_height').val(data.product_child[0].parent_data.shipping_height) : $('input#shipping_height').val(data.product_child[0].shipping_height);

                        data.product_child[0].shipping_length === 0 ? $('input#shipping_length').val(data.product_child[0].parent_data.shipping_length) : $('input#shipping_length').val(data.product_child[0].shipping_length);

                        data.product_child[0].shipping_width === 0 ? $('input#shipping_width').val(data.product_child[0].parent_data.shipping_width) : $('input#shipping_width').val(data.product_child[0].shipping_width);

                        $('#avail-qty').val(data.product_child[0].quantity);

    

                        $('input#item_description').val(data.product_child[0].description);

    

                        $('input#item_id').val(data.product_child[0].id);

                    } else {

                        $('#add-cart').prop('disabled', true);

                    }

                },

                    error: function(data) {

                        //if body is empty we end up here

                        console.log('error');

                        $('.minus-qty').trigger('click');

                        $('#add-cart').prop('disabled', true);

                      }

            });

            check_qty();

          	$('.plus-qty').trigger('click');

        })



    $('input.prod_qty').on('keyup', function() {

        if (parseInt($(this).val()) > parseInt($('#avail-qty').val())) {

            $(this).val($('#avail-qty').val());

        }

        check_qty();

    })



    $('.plus-qty').on('click', function() {

        if (parseInt($('#avail-qty').val()) > parseInt($('input.prod_qty').val())) {

            $('input.prod_qty').val(parseInt($('input.prod_qty').val()) + 1);

        }

        check_qty();

    })



    $('.minus-qty').on('click', function() {

        if ($('input.prod_qty').val() > 0) {

            $('input.prod_qty').val(parseInt($('input.prod_qty').val()) - 1);

        }

        check_qty();

    })



    $('#add-wishlist').on('click', function () {

        var Token = $('input[name="_token"]').val();

        var product_id = $("#productid").val();

        $.ajax({

            url: '/product/add-wishlist',

            method: "post",

            dataType: "json",

            data: {

                product_id: product_id,

                _token: Token

            },

            async: false,

            success: function (data) {

            	location.reload();

            }

        });

        //location.reload();

    })



    $('.remove-wishlist').on('click', function () {

        var Token = $('input[name="_token"]').val();

        var wishlist_id = $(this).data("wishlistid");

        $.ajax({

            url: 'remove-wishlist',

            method: "post",

            dataType: "json",

            data: {

                wishlist_id: wishlist_id,

                _token: Token

            },

            async: false,

            success: function (data) {

            }

        });

        location.reload();

    })

    

//PRODUCT DETAIL END



//CART

    $('.remove-cart').on('click', function () {

        var cart_id = $(this).data('index')

        var Token = $('input[name="_token"]').val();

        if(confirm("Are you sure you want to remove?")) {
            $.ajax({

                url: '/remove-cart',

                method: "post",

                dataType: "json",

                data: {

                    cart_id: cart_id,

                    _token: Token

                },

                success: function (data) {

                    console.log('ok');

                    location.reload();

                },

                error: function(){

                    console.log('error');

                }

            });

        }

    })



    function check_existing_qty(classcntnt) {

        var _token = $('input[name="_token"]').val();

        var cart_index = $(classcntnt).data('index');

        var newqty = $(classcntnt).val();

        var color =  $(classcntnt).data('color');

        var liter = $(classcntnt).data('liter');

        var price =  $(classcntnt).data('price');

        var totalsubtotal = $('.subtotal').text().replace('P','').replace(',','').trim();

        var data  = {
            _token,
            cart_index,
            newqty, 
            liter,
            color,
            price,
            totalsubtotal
        }

        console.log(data);

        $.ajax({

            url: '/check-cart',

            method: "post",

            dataType: "json",

            data,

            success: function (data) {
                var new_subtotal_price = data.subtotal;
                var new_total_subtotal = data.subtotal_total;
                $('.list-price-'+cart_index).text('P'+new_subtotal_price); 
                $('.subtotal').text('P '+new_total_subtotal);
            }

        });

    }



    $('#cart .cart-qty').on('change keyup', function () {
        check_existing_qty($(this));

    })

    

    $('#cart .qty-minus').on('click', function () {

        var item_qty = $(this).prev().val();

        if (item_qty > 1) {

            // $('.cart-qty-cntn .cart-qty').val(parseInt(item_qty)+1);

            $(this).prev().val(parseInt(item_qty)-1);

            check_existing_qty($(this).prev());

        }

    })

    

    $('#cart .qty-plus').on('click', function () {

        var item_qty = $(this).next().val();

        // $('.cart-qty-cntn .cart-qty').val(parseInt(item_qty)+1);

        $(this).next().val(parseInt(item_qty)+1);

        check_existing_qty($(this).next());

    })



    $('#shipping-location').on('change', function () {

        // console.log($(this).val());

        // console.log($(this).find(':selected').data('amount'));

        var Token = $('input[name="_token"]').val();

        $('input#shipping-amount').val($(this).find(':selected').data('amount'));

    	var datafee = $('input#shipping-amount').val($(this).find(':selected').data('amount'));

        $.ajax({

            url: "/get-shipping-rate",

            type: "GET",   

            dataType: "json",

            data: {

                location: $(this).val(),

                _token: Token

            },   

            success: function(data){

                $('input#shipping-amount').val(data);

                $('.total-amount').html('&#8369; ' + addCommas((parseFloat(datafee.val().replace(/,/g,'')) + parseFloat($('input.sub-total').val())).toFixed(2)));

            }

        });

    })

    function addCommas(nStr) {

        nStr += '';

        x = nStr.split('.');

        x1 = x[0];

        x2 = x.length > 1 ? '.' + x[1] : '.00';

        var rgx = /(\d+)(\d{3})/;

        while (rgx.test(x1)) {

            x1 = x1.replace(rgx, '$1' + ',' + '$2');

        }

        return x1 + x2;

    }

//CART END

// CHECKOUT

    $("#checkout-page input.diff-shipping").change(function () {

        if ($(this).prop("checked") == true) {

            $(".shipping-details").show();

        } else {

            $(".shipping-details").hide();

        }

    }).change();



    $('#checkout-page .ship-loc').on('change', function () {

        var location = 0;

        var Token = $('input[name="_token"]').val();

        if ($('#checkout-page .diff-shipping').is(":checked")) {

            location = $('#checkout-page #s_city').val();

        } else {

            location = $('#checkout-page #b_city').val();

        }

        $.ajax({

            url: "/get-shipping-rate",

            type: "GET",   

            dataType: "json",

            data: {

                location: location,

                _token: Token

            },   

            success: function(data){

                // console.log(data);

                $('.shppng').html('&#8369; ' + data);

                $('.shppng-ttl').html(format2(parseFloat(data) + parseFloat($('span.shppng-sb-ttl').html().replace(',','')), '&#8369; '));

                

            }

        });

    })

// CHECKOUT END

});



$(document).ajaxStart(function () {

    $('#loading-image').show();

});



$(document).ajaxComplete(function () {

    $('#loading-image').hide();

});



$(document).ready(function () {

    $(document).on("scroll", onScroll);



    //smoothscroll

    $('#brand a[href^="#"]').on('click', function (e) {

        e.preventDefault();

        $(document).off("scroll");



        $('a').each(function () {

            $(this).removeClass('active');

        });

        $(this).addClass('active');



        var target = this.hash,

            menu = target;

        $target = $(target);

        $('html, body').stop().animate({

            'scrollTop': $target.offset().top + 2

        }, 500, 'swing', function () {

            window.location.hash = target;

            console.log($target.offset().top);

            $(document).on("scroll", onScroll);

        });

    });

});



function onScroll(event) {

    var scrollPos = $(document).scrollTop();

    $('#my-section-navigation a').each(function () {

        var currLink = $(this);

        var refElement = $(currLink.attr("href"));

        if (refElement.position().top <= (scrollPos - 110) && refElement.position().top + (refElement.height() + 110) > scrollPos) {

            $('#my-section-navigation ul li a').removeClass("active");

            currLink.addClass("active");

        }

        else {

            currLink.removeClass("active");

        }

    });

}



$(window).scroll(function () {

    // Get the header

    var header = document.getElementById("my-section-navigation");

    if (header) {

        var sticky = header.offsetTop;

        if (window.pageYOffset > $("#header").height() + $(".pg-hdr").height()) {

            header.classList.add("sticky-two");

        } else {

            header.classList.remove("sticky-two");

        }        

    }

});



function isScrolledIntoView(elem) {

    var $elem = $(elem);

    var $window = $(window);



    var docViewTop = $window.scrollTop();

    var docViewBottom = docViewTop + $window.height();



    var elemTop = $elem.offset().top;

    var elemBottom = elemTop + $elem.height();



    return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));

}



function format2(n, currency) {

    return currency + n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');

}



function check_qty() {

    if (parseInt($('input.prod_qty').val()) < 1) {

        $('#add-cart').prop('disabled', true);

        $('#qty-err').html('Please Check Quantity');

    } else {

        $('#add-cart').prop('disabled', false);

        $('#qty-err').html('');

    }

    $('input#item_quantity').val($('.prod_qty').val());

}



function client_Login(){

	var Uname = $('input#customerid_log').val();

	var Paswd = $('input#customerpaswd_log').val();

	var Token = $('input[name="_token"]').val();



	$('div#customerid_log').removeClass('has-error');

	$('div.error_handler_customerid').html('');

	$('div#pawd_log').removeClass('has-error');

	$('div.error_handler_paswd').html('');

	jQuery.ajax({

        url: '/login',

        method: "post",

        dataType: "json",

        data:

        {

        	customerid : Uname,

        	customerpaswd : Paswd,

        	_token : Token

        },

        success: function (data) {

        	if (data.action == 'success'){

        		$('a#loginmodal').addClass("hide");

        		$('a#logoutmodal').removeClass("hide").text('Log Out ('+data.clientname+')');

        		$('div#myModal').modal('hide');

                location.reload();

        	} else {

        		if(data.username){

        			$('div#customerid_log').addClass('has-error');

        			$('div.error_handler_customerid').html('<span class="help-block"><strong>'+data.username+'</strong></span>');

        		} 



        		if (data.password){

        			$('div#pawd_log').addClass('has-error');

        			$('div.error_handler_paswd').html('<span class="help-block"><strong>'+data.password+'</strong></span>');

        		}

        	}

        }

    });

}



//ratings 

$('.sbmt_rating_btn').click(function(){

	$data = $('#ratingform').serializeArray();

	val_count = 0;

	$.each($data,function(key, field_val) {

		if(field_val.value.length > 0){

			val_count++;

		}

	});

	if(val_count > 3){

		$.ajax({

	        url: base_url+'/customer/product-ratings',

	        method: "post",

	        dataType: "json",

	        data : $data,

	        success: function (data) {

	        	$msg = 'Your Review is under process.';

	        	$icon = '<i class="fa fa-close icon-msg-error"></i>';

	        	if (data.msg == 'success'){

	        		$msg = '<h3>Gotcha!</h3>'+

            				'<p>Ratings succesfully sent.</p>';

	        		$icon = '<i class="fa fa-check-circle-o  icon-msg-success"></i>';

	        	}

	        	$('.icon-div').html($icon);

	        	$('.msg-div').html($msg);

	        	$('#rating_modal').modal('show');

	        	setTimeout(function(){

	        		$('#rating_modal').modal('hide');

	        		location.reload();

	        	},3000);

	        	//modal here

	        }

	    });

	}else{

		//handle validation

	}

});



$('.sharebtn').on('click',function(){

	var shareuri = $(this).data('shareuri');

	 window.open(shareuri, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,width=400,height=400");

});

    $(document).ready(function() {

        $("img").on("contextmenu",function(){

           return false;

        });

        $(".photo-zoom").on("contextmenu",function(){

            return false;

        });

        $(".bg-img").on("contextmenu",function(){

            return false;

        });

    });

    $('#my-section-navigation .btn').click(function(e){

        console.log(e.target.id)

        if(!$(this).hasClass("active")){

            console.log($(e.target.id));

            $(".active").removeClass("active");

            $(".e.target.id").removeClass("active");

            $("e.target.id").addClass("active");

            $(this).addClass("active");

        } else {

            return false;

        } 



    });

    $(document).on("click", ".open-email-dialog", function () {
        var product_id = $(this).data('broc');
   
        $(".panel-body #broc_product").val( product_id );
        // As pointed out in comments, 
        // it is unnecessary to have to manually call the modal.
        // $('#addBookDialog').modal('show');
   });

    $(document).ready(function(){
        //Color Swatches

        function deactivateActiveColorSwatch() {
            let tablinks = $('.tablinks');
            let tab = $('.tabcontent');

            $.each(tablinks, function(){
                if($(this).hasClass('active')){
                    $(this).removeClass('active');
                }
            });

            $.each(tab,function(){
                $(this).css({'display':'none'});
            });
        }

        function activateNewColorSwatch(newActiveColorSwatch) {
            let item = newActiveColorSwatch.data('color');

            if (item === 'View-All-Colors') {
                let tabContent = $(".tabcontent").not("#Regular-Colors");

                tabContent.css("display", "block");       
                tabContent.css("margin-top", "");
            } else {
                $("#"+item).css("display", "block");

                if (item != "White") {                    
                    $("#"+item).css("margin-top", "0");
                }
            }
            
            newActiveColorSwatch.addClass('active');
        }

        $('.tablinks').on('click',function(){
            deactivateActiveColorSwatch();
            activateNewColorSwatch($(this));          
        });

        $("#defaultOpen").click();
     	$(".box-widget .color-picker .color-box").on('click',function(){          
            if ($(this).hasClass('color-selected')) $(this).removeClass('color-selected');
            else $(this).addClass('color-selected');
        });

        $('#proceed').on('click',function(e){
            parent_id = $(".box-widget .color-box").data('parent-id');
            productid = $(".box-widget .color-selected").map(function(){
             return $(this).data('product-id');
            }).get();            
            Token = $('input[name="_token"]').val();
            data = {_token: Token, productid:productid, parent_id:parent_id, multiple: true };            
            $.ajax({
                url: base_url+'/add-cart',
                method: 'post',
                dataType: 'json',
                data: data,        
                success: function(data) {
                    // console.log('asd');
                    console.log(data);         
                    window.location.href = data.url;
                    // console.log(data);
                },error: function(event,request,settings, thrownError){
                        console.log(thrownError);
                }
            });
        });
    
        $(".accordion-group").click(function (e) {
            let accordionBody = $(this).find('.accordion-body');
            if (e.target.classList.contains('sub-list') && accordionBody.length > 1) {
                return;
            }            
            let accordionHeading = $(this).find('.accordion-heading').not('.sub-list');
            let accordionHeadingSubList = $(this).find('.accordion-heading.sub-list');
    
            if (e.target.classList.contains('accordion-toggle') && !e.target.classList.contains('sub-list')) {
                if (accordionBody.hasClass('show')) {
                    accordionHeading.removeClass('accordion-opened');
                } else {
                    accordionHeading.addClass('accordion-opened');
                }
            } else {
                if (accordionBody.hasClass('show')) {
                    accordionHeadingSubList.removeClass('accordion-opened');
                } else {
                    accordionHeadingSubList.addClass('accordion-opened');
                }
            }
        });

        $(".customComboBox").click(function(e){
            let icon = $(this).find("span");

            if (icon.is(".fa-chevron-down")) {
                icon.removeClass("fa-chevron-down").addClass("fa-chevron-up");
            } else {
                icon.removeClass("fa-chevron-up").addClass("fa-chevron-down");
            }

            $(this).find("li").toggle("100", "swing");
            $(this).toggleClass("open");
        });

        $(".customComboBox li").click(function(e){
            $(this).parent()
                .find(".value")
                .text(e.target.textContent)
                .removeClass("default");

                getPaintSuggestion();
        });
      
        $("#area-in-sqm").keypress(function(e){
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                return false;
            }      
        }).keyup(function(e){            
            computePerLiter();
        });

        function computePerLiter() {
            let surfaceCondition = $("#surface-condition").text();
            let perLiter;
            let sqmDivisor;

            if (surfaceCondition === "NEW PAINT") {
                sqmDivisor = 25;
            } else {
                sqmDivisor = 30;
            }
            
            perLiter = 4;

            let liter;
            let sqm = $("#area-in-sqm").val();

            if (isFinite(sqm)) {
                liter = Math.ceil((sqm /sqmDivisor) * perLiter);
            }

            $(".liter").text(liter);
        }

        function checkComboBox(value) {
            return value.includes('Surface');
        }
        
        function getPaintFromQueryString() {
            let surfaceType = $("#surface-type").text();
            let surfaceLocation = $("#surface-location").text();
            let surfaceCondition = $("#surface-condition").text();
            let comboBox = [surfaceType, surfaceLocation, surfaceCondition].filter(checkComboBox);
            let paint = $("#query-string-value").val();
            
            if (comboBox.length > 0) {
                return;
            } else {
                let url = `/paintCalculatorResult/${paint}`;

                $.ajax({
                    url,
                    type: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        var result = response.data;
                        
                        $("#paint").empty();
                        $("#liter").empty();

                        $("#paint").append(
                            "<p>USE</p>"
                        );

                        $("#liter").append(
                            "<p>LITERS</p>"
                        );

                        $.each(result, function (index, list) { 
                            $("#paint").append(
                                "<div class=\"paint\">" +
                                    list.name +
                                "</div>"
                            );
    
                            $("#liter").append(
                                "<div class=\"liter\">0</div>"
                            );
                        });

                        getPaintSuggestion(surfaceLocation, surfaceType);

                        $("#area-in-sqm").removeAttr("disabled");

                        setTimeout(() => {
                            if ($("#area-in-sqm").val() != "") {
                                computePerLiter(); 
                            } 
                        }, 550);
                    },        
                    error: function () {        
                        alert("Error in getPaintFromQueryString!");
                    }
                });
            }
        }

        function getPaintSuggestion() {
            let surfaceType = $("#surface-type").text();
            let surfaceLocation = $("#surface-location").text();
            let surfaceCondition = $("#surface-condition").text();
            let comboBox = [surfaceType, surfaceLocation, surfaceCondition].filter(checkComboBox);            

            if (comboBox.length > 0) {
                return;
            } else {
                let url = `/paintCalculatorResult/${surfaceLocation}/${surfaceType}`;

                $.ajax({
                    url,
                    type: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        var result = response.data;
                        
                        $("#paint").empty();
                        $("#liter").empty();
    
                        $("#paint").append(
                            "<p>USE</p>"
                        );
    
                        $("#liter").append(
                            "<p>LITERS</p>"
                        );
    
                        $.each(result, function (index, list) { 
                            if (list.name === $("#query-string-value").val()) { 
                                $("#paint").find('.paint:first-of-type').before(
                                    "<div class=\"paint\">" +
                                        list.name +
                                    "</div>"
                                );
                            } else {
                                $("#paint").append(
                                    "<div class=\"paint\">" +
                                        list.name +
                                    "</div>"
                                );
                            }

                            $("#liter").append(
                                "<div class=\"liter\">0</div>"
                            );
                        });
                            
                        $("#result-container").show();
                        $("#area-in-sqm").removeAttr("disabled");
                        if ($("#area-in-sqm").val() != "") {
                            computePerLiter(); 
                        }
                    },        
                    error: function () {        
                        alert("Error in getPaintSuggestion!");
                    }
                });
            }
        }

        var showColorsDropdown = function(item_id,token,dropdown) 
        {
            let url   = `/get-colors`;

            $.ajax({
                url,
                type: 'POST',
                data: {
                    product_id : item_id,
                    _token     : token
                },
                dataType: 'json',
                beforeSend: function() {
                    dropdown.attr('readonly',true);
                },
                success: function (response) {
                    dropdown.html('<option value=""> Select Color </option>');
                    dropdown.attr('readonly',false);
                    for (const [key, value] of Object.entries(response)) {
                        dropdown.append(`<option value="${key}">${value}</option>`);     
                    }

                },        
                error: function () {        
                    alert("Error retrieving colors!");
                    dropdown.html('<option value=""> Select Color </option>');
                    dropdown.attr('readonly',false);
                }
            });

        }

        var showFullColors = function(product_id,container,dropdown,dropdown_liter,token) 
        {
            let url       = `/get-full-colors`;
            const whites  = container.find('#White');
            const greys   = container.find('#Grey');
            const browns  = container.find('#Brown');
            const purples = container.find('#Purple');
            const blues   = container.find('#Blue');
            const greens  = container.find('#Green');
            const yellows = container.find('#Yellow');
            const oranges = container.find('#Orange');
            const reds    = container.find('#Red');
            const regs    = container.find('#Regular-Colors');
            let html      = '';

            $.ajax({
                url,
                type: 'POST',
                data: {
                    product_id : product_id,
                    _token     : token
                },
                dataType: 'json',
                beforeSend: function() {
                    whites.children().children().html('');
                    greys.children().children().html('');
                    browns.children().children().html('');
                    purples.children().children().html('');
                    blues.children().children().html('');
                    greens.children().children().html('');
                    yellows.children().children().html('');
                    oranges.children().children().html('');
                    reds.children().children().html('');
                    regs.children().children().html('');
                },
                success: function (response) {
                    response.forEach(function(item) {
                        if(item.attribute_data.cat_color.trim().toLowerCase() == "white" ) {
                            html = '<div class="color-box box color-modal" data-id="'+ item.attribute_data.id +'" data-name="'+ item.attribute_data.name +'" data-rcolor="'+ item.attribute_data.r_attr +'" data-gcolor="'+ item.attribute_data.g_attr +'" data-bcolor="'+ item.attribute_data.b_attr +'" data-parent-id="'+ product_id +'" data-product-id="'+ product_id +'" style="';
                            if(item.attribute_data.cat_color != null && (item.attribute_data.cat_color == "White" && item.attribute_data.cat_color == "OFF WHITES" ) ) {
                                html += 'color: #848484;';
                            }
                            html += 'background-color:rgb('+ item.attribute_data.r_attr +', '+ item.attribute_data.g_attr +', ' + item.attribute_data.b_attr +');"><div class="title">'+ item.attribute_data.name +'</div></div>';
                            whites.children().children().append(html);
                        }
                        if(item.attribute_data.cat_color.trim().toLowerCase() == "gray") {
                            html = '<div class="color-box box color-modal" data-id="'+ item.attribute_data.id +'" data-name="'+ item.attribute_data.name +'" data-rcolor="'+ item.attribute_data.r_attr +'" data-gcolor="'+ item.attribute_data.g_attr +'" data-bcolor="'+ item.attribute_data.b_attr +'" data-parent-id="'+ product_id +'" data-product-id="'+ product_id +'" style="';
                            if(item.attribute_data.cat_color != null && (item.attribute_data.cat_color == "White" && item.attribute_data.cat_color == "OFF WHITES" ) ) {
                                html += 'color: #848484;';
                            }
                            html += 'background-color:rgb('+ item.attribute_data.r_attr +', '+ item.attribute_data.g_attr +', ' + item.attribute_data.b_attr +');"><div class="title">'+ item.attribute_data.name +'</div></div>';
                            greys.children().children().append(html);
                        }
                        if(item.attribute_data.cat_color.trim().toLowerCase() == "brown") {
                            html = '<div class="color-box box color-modal" data-id="'+ item.attribute_data.id +'" data-name="'+ item.attribute_data.name +'" data-rcolor="'+ item.attribute_data.r_attr +'" data-gcolor="'+ item.attribute_data.g_attr +'" data-bcolor="'+ item.attribute_data.b_attr +'" data-parent-id="'+ product_id +'" data-product-id="'+ product_id +'" style="';
                            if(item.attribute_data.cat_color != null && (item.attribute_data.cat_color == "White" && item.attribute_data.cat_color == "OFF WHITES" ) ) {
                                html += 'color: #848484;';
                            }
                            html += 'background-color:rgb('+ item.attribute_data.r_attr +', '+ item.attribute_data.g_attr +', ' + item.attribute_data.b_attr +');"><div class="title">'+ item.attribute_data.name +'</div></div>';
                            browns.children().children().append(html);
                        }
                        if(item.attribute_data.cat_color.trim().toLowerCase() == "purple") {
                            html = '<div class="color-box box color-modal" data-id="'+ item.attribute_data.id +'" data-name="'+ item.attribute_data.name +'" data-rcolor="'+ item.attribute_data.r_attr +'" data-gcolor="'+ item.attribute_data.g_attr +'" data-bcolor="'+ item.attribute_data.b_attr +'" data-parent-id="'+ product_id +'" data-product-id="'+ product_id +'" style="';
                            if(item.attribute_data.cat_color != null && (item.attribute_data.cat_color == "White" && item.attribute_data.cat_color == "OFF WHITES" ) ) {
                                html += 'color: #848484;';
                            }
                            html += 'background-color:rgb('+ item.attribute_data.r_attr +', '+ item.attribute_data.g_attr +', ' + item.attribute_data.b_attr +');"><div class="title">'+ item.attribute_data.name +'</div></div>';
                            purples.children().children().append(html);
                        }
                        if(item.attribute_data.cat_color.trim().toLowerCase() == "blue") {
                            html = '<div class="color-box box color-modal" data-id="'+ item.attribute_data.id +'" data-name="'+ item.attribute_data.name +'" data-rcolor="'+ item.attribute_data.r_attr +'" data-gcolor="'+ item.attribute_data.g_attr +'" data-bcolor="'+ item.attribute_data.b_attr +'" data-parent-id="'+ product_id +'" data-product-id="'+ product_id +'" style="';
                            if(item.attribute_data.cat_color != null && (item.attribute_data.cat_color == "White" && item.attribute_data.cat_color == "OFF WHITES" ) ) {
                                html += 'color: #848484;';
                            }
                            html += 'background-color:rgb('+ item.attribute_data.r_attr +', '+ item.attribute_data.g_attr +', ' + item.attribute_data.b_attr +');"><div class="title">'+ item.attribute_data.name +'</div></div>';
                            blues.children().children().append(html);
                        }
                        if(item.attribute_data.cat_color.trim().toLowerCase() == "green") {
                            html = '<div class="color-box box color-modal" data-id="'+ item.attribute_data.id +'" data-name="'+ item.attribute_data.name +'" data-rcolor="'+ item.attribute_data.r_attr +'" data-gcolor="'+ item.attribute_data.g_attr +'" data-bcolor="'+ item.attribute_data.b_attr +'" data-parent-id="'+ product_id +'" data-product-id="'+ product_id +'" style="';
                            if(item.attribute_data.cat_color != null && (item.attribute_data.cat_color == "White" && item.attribute_data.cat_color == "OFF WHITES" ) ) {
                                html += 'color: #848484;';
                            }
                            html += 'background-color:rgb('+ item.attribute_data.r_attr +', '+ item.attribute_data.g_attr +', ' + item.attribute_data.b_attr +');"><div class="title">'+ item.attribute_data.name +'</div></div>';
                            greens.children().children().append(html);
                        }
                        if(item.attribute_data.cat_color.trim().toLowerCase() == "yellow") {
                            html = '<div class="color-box box color-modal" data-id="'+ item.attribute_data.id +'" data-name="'+ item.attribute_data.name +'" data-rcolor="'+ item.attribute_data.r_attr +'" data-gcolor="'+ item.attribute_data.g_attr +'" data-bcolor="'+ item.attribute_data.b_attr +'" data-parent-id="'+ product_id +'" data-product-id="'+ product_id +'" style="';
                            if(item.attribute_data.cat_color != null && (item.attribute_data.cat_color == "White" && item.attribute_data.cat_color == "OFF WHITES" ) ) {
                                html += 'color: #848484;';
                            }
                            html += 'background-color:rgb('+ item.attribute_data.r_attr +', '+ item.attribute_data.g_attr +', ' + item.attribute_data.b_attr +');"><div class="title">'+ item.attribute_data.name +'</div></div>';
                            yellows.children().children().append(html);
                        }
                        if(item.attribute_data.cat_color.trim().toLowerCase() == "orange") {
                            html = '<div class="color-box box color-modal" data-id="'+ item.attribute_data.id +'" data-name="'+ item.attribute_data.name +'" data-rcolor="'+ item.attribute_data.r_attr +'" data-gcolor="'+ item.attribute_data.g_attr +'" data-bcolor="'+ item.attribute_data.b_attr +'" data-parent-id="'+ product_id +'" data-product-id="'+ product_id +'" style="';
                            if(item.attribute_data.cat_color != null && (item.attribute_data.cat_color == "White" && item.attribute_data.cat_color == "OFF WHITES" ) ) {
                                html += 'color: #848484;';
                            }
                            html += 'background-color:rgb('+ item.attribute_data.r_attr +', '+ item.attribute_data.g_attr +', ' + item.attribute_data.b_attr +');"><div class="title">'+ item.attribute_data.name +'</div></div>';
                            oranges.children().children().append(html);
                        }
                        if(item.attribute_data.cat_color.trim().toLowerCase() == "red") {
                            html = '<div class="color-box box color-modal" data-id="'+ item.attribute_data.id +'" data-name="'+ item.attribute_data.name +'" data-rcolor="'+ item.attribute_data.r_attr +'" data-gcolor="'+ item.attribute_data.g_attr +'" data-bcolor="'+ item.attribute_data.b_attr +'" data-parent-id="'+ product_id +'" data-product-id="'+ product_id +'" style="';
                            if(item.attribute_data.cat_color != null && (item.attribute_data.cat_color == "White" && item.attribute_data.cat_color == "OFF WHITES" ) ) {
                                html += 'color: #848484;';
                            }
                            html += 'background-color:rgb('+ item.attribute_data.r_attr +', '+ item.attribute_data.g_attr +', ' + item.attribute_data.b_attr +');"><div class="title">'+ item.attribute_data.name +'</div></div>';
                            reds.children().children().append(html);
                        }
                        if(item.attribute_data.best_selling) {
                            html = '<div class="color-box box color-modal" data-id="'+ item.attribute_data.id +'" data-name="'+ item.attribute_data.name +'" data-rcolor="'+ item.attribute_data.r_attr +'" data-gcolor="'+ item.attribute_data.g_attr +'" data-bcolor="'+ item.attribute_data.b_attr +'" data-parent-id="'+ product_id +'" data-product-id="'+ product_id +'" style="';
                            if(item.attribute_data.cat_color != null && (item.attribute_data.cat_color == "White" && item.attribute_data.cat_color == "OFF WHITES" ) ) {
                                html += 'color: #848484;';
                            }
                            html += 'background-color:rgb('+ item.attribute_data.r_attr +', '+ item.attribute_data.g_attr +', ' + item.attribute_data.b_attr +');"><div class="title">'+ item.attribute_data.name +'</div></div>';
                            regs.children().children().append(html);
                        }

                    });

                    jQuery('.color-modal').click(function() {
                        const color = jQuery(this).data('name');
                        $(this).addClass('color-selected');
                        dropdown.append(`<option value="${color}" selected>${color}</option>`);
                        jQuery('#colorSwatchesModal').modal('toggle');
                        dropdown_liter.attr('disabled',false);
                        showLitersDropdown(product_id,color,token,dropdown_liter);
                    })

                },        
                error: function () {        
                    alert("Error retrieving colors!");
                    dropdown.html('<option value=""> Select Color </option>');
                    dropdown.attr('readonly',false);
                }
            });

        }

        var showLitersDropdown = function(product_id,selected_color,_token,dropdown) 
        {
            let url = `/get-liters`;

            $.ajax({
                url,
                type: 'POST',
                data: {
                    product_id,
                    selected_color,
                    _token
                },
                dataType: 'json',
                beforeSend: function() {
                    dropdown.attr('readonly',true);
                },
                success: function (response) {
                    dropdown.html('<option value=""> Select Liter </option>');
                    dropdown.attr('readonly',false);

                    for (const [key, value] of Object.entries(response)) {
                        dropdown.append(`<option value="${key}">${value}</option>`);     
                    }

                    let url = `/get-color-css`;

                    $.ajax({
                        url,
                        type: 'POST',
                        data: {
                            product_id,
                            selected_color,
                            _token
                        },
                        dataType: 'json',
                        success: function (response) {
                            var rgb = `rgb(${response.attributes_data[0].r_attr},${response.attributes_data[0].g_attr},${response.attributes_data[0].b_attr})`;
                            dropdown.parent().parent().parent().find('input[name="colorCss"]').val(rgb);
        
                        },        
                        error: function () {        
                            alert("Error retrieving Colors!");
                        }
                    });


                },        
                error: function () {        
                    alert("Error retrieving Liters!");
                    dropdown.html('<option value=""> Select Liter </option>');
                    dropdown.attr('readonly',false);
                }
            });

        }

        var showVariationDetails = function(product_id,subproduct_id,qty_input,_token) 
        {
            let url = `/get-variation-details`;

            $.ajax({
                url,
                type: 'POST',
                data: {
                    product_id,
                    subproduct_id,
                    _token
                },
                dataType: 'json',
                beforeSend: function() {
                    jQuery('.gotocart').hide();
                    jQuery('.loading_cart_product_list').show();
                },
                success: function (response) {
                    jQuery('.loading_cart_product_list').hide();
                    jQuery('.gotocart').show();
                    var error_message = qty_input.parent().parent().parent().find('span.error_message_listing');
                    var qty           = response.quantity;

                    qty_input.parent().parent().parent().parent().find('input[name="subProductId"]').val(response.id);
                    qty_input.attr('max', qty);
                    
                    if(qty > 0) {
                        qty_input.attr('min', 1);
                        qty_input.val(1);
                        error_message.css('visibility','hidden');
                    } else {
                        qty_input.attr('min', 0);
                        qty_input.val(0);
                        error_message.css('visibility','visible');
                    }
                },        
                error: function () {     
                    jQuery('.loading_cart_product_list').hide();   
                    alert("Error retrieving Liters!");
                }
            });
        }

        jQuery('.productattri_list').on('mousedown', function(e) {
            var item_id        = $(this).parent().parent().parent().find('input[name="productId"]').val();
            var token          = $(this).parent().parent().parent().find('input[name="_token"]').val();
            var color_count    = $(this).parent().parent().parent().find('input[name="colorCount"]').val().trim();
            var dropdown_liter = jQuery(this).parent().parent().parent().find('.product_liters_list');
            var dropdown       = $(this);
            var color_swatches = $('#color-swatches');

            if(color_count > 20) {
                e.preventDefault();
                this.blur();
                window.focus();
                jQuery('#colorSwatchesModal').modal('toggle');
                showFullColors(item_id,color_swatches,dropdown, dropdown_liter,token);

            } else {
                if(item_id !== null && item_id !== undefined && dropdown.val() == "") {
                    showColorsDropdown(item_id,token,dropdown)
                }
            }
        });

        jQuery('.productattri_list').on('change', function() 
        {
           var selected_color = jQuery(this).val();
           var product_id     = $(this).parent().parent().parent().find('input[name="productId"]').val();
           var color_choose   = $(this).parent().parent().parent().find('input[name="colorChoose"]');
           var dropdown_liter = jQuery(this).parent().parent().parent().find('.product_liters_list');
           var token          = $(this).parent().parent().parent().find('input[name="_token"]').val();
           if(selected_color != "") {
               dropdown_liter.attr('disabled',false);
               showLitersDropdown(product_id,selected_color,token,dropdown_liter);
               color_choose.val(selected_color);
           } else {
            dropdown_liter.attr('disabled',true);
           }
        });

        jQuery('.product_liters_list').on('change', function() 
        {
            var product_id      = $(this).parent().parent().parent().find('input[name="productId"]').val();
            var token           = $(this).parent().parent().parent().find('input[name="_token"]').val();
            var subproduct_id   = $(this).val();
            var qty_input       = $(this).parent().parent().parent().next().find('.prod_qty');

            showVariationDetails(product_id,subproduct_id,qty_input,token);
            
        });

        jQuery('.addtocart_from_listing').click(function(e) 
        {
            e.preventDefault();
            var button        = $(this);
            var quantity      = $(this).parent().parent().parent().find('input.prod_qty').val();
            var productId     = $(this).parent().parent().parent().prev().find('input[name="subProductId"]').val();
            var productName   = $(this).parent().parent().parent().prev().find('input[name="productName"]').val();
            var colorNameP    = $(this).parent().parent().parent().prev().find('select[name="colorNameP"]').val();
            var colorChoose   = $(this).parent().parent().parent().prev().find('input[name="colorChoose"]').val();
            var colorCss      = $(this).parent().parent().parent().prev().find('input[name="colorCss"]').val();
            var productLiters = $(this).parent().parent().parent().prev().find('select.product_liters_list option:selected').text();
            var _token        = $(this).parent().parent().parent().prev().find('input[name="_token"]').val();
            var url           = `/addtocart-from-listing`;

            if(quantity > 0 && productId != "" && productName != "" && colorNameP !="" && productLiters.trim() != "Select Liter") {
                $.ajax({
                    url,
                    type: 'POST',
                    data: {
                        productId,
                        productName,
                        colorNameP,
                        colorChoose,
                        colorCss,
                        productLiters,
                        quantity,
                        _token
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        button.attr('disabled',true);
                    },
                    success: function (response) {
                        if(response.status == "success") {
                            if(response.cart > 0) {
                                $('.cart-icon-img').html(`<img class="cart-icon" src="http://localhost:8000/img/cart-icon.png">(${response.cart})`);
                                $('.error_message_listing').html(response.msg);
                                $('.error_message_listing').show();
                                $('.error_message_listing').css('visibility','visible');
                                setTimeout(function() {
                                    $('.error_message_listing').hide();
                                    $('.error_message_listing').css('visibility','hidden');
                                },5000);
                            }
                        } else {
                            alert("Error adding to cart! Sorry for the inconvenience.Please try again later.");
                        }
                        button.attr('disabled',false);
                    },        
                    error: function () {        
                        alert("Error adding to cart! Sorry for the inconvenience.Please try again later.");
                        button.attr('disabled',false);
                    }
                });
            } else {
                if(quantity <= 0) {
                    alert('Please check quantity before adding to cart!');
                } else if(colorNameP  == "") {
                    alert('Please select Color');
                } else if(productLiters.trim() == "Select Liter") {
                    alert('Please select Liter');
                }
                else {
                    alert("Error adding to cart! Sorry for the inconvenience.Please try again later.");
                }
            }


        });

    });
