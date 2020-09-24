$(document).ready(function () {



    /* 

        USERS

        Role on Change

    */

    $("select#usertype").on("change", function () {

        var myDiv = $(this).val(); var ValRole = "Admin";

        if (myDiv == "New User" || myDiv == "Old User" || myDiv == "Sister") { ValRole = myDiv; myDiv = "user"; }

        $('.roletype').addClass("hide");

        $('div#' + myDiv + "Control").removeClass("hide");

        $("input#role_name").val(ValRole);

    });





    /***                  ****

    **** Stock Management ****

    ****                  ***/



    $('input#keySearch').on('keyup', function () {



        if ($(this).val() == null || $(this).val() == '') {

            $('table tbody#tblSearchTr').html('');

        } else {



            var Token = $('input[name="_token"]').val();

            $('div#keySearchLoader').show();



            $.ajax({

                url: '/admin/stock-management/transfer-in/search-product',

                method: "post",

                dataType: "json",

                data:

                {

                    _token: Token,

                    searchKey: $(this).val()

                },

                success: function (data) {

                    var myData = '';



                    for (var num = 0; num < data.length; num++) {

                        myData += '<tr id="' + data[num].id + '">' +

                            '<td>' + data[num].name + '<input type="hidden" id="temp_price_' + data[num].id + '" value="' + data[num].price + '"></td>' +

                            '<td>' + data[num].description + '</td>' +

                            '<td>' + data[num].supplier + '</td>' +

                            '</tr>';

                    }



                    $('table tbody#tblSearchTr').html(myData);

                    $('div#keySearchLoader').hide();



                    $('tbody#tblSearchTr tr').on('click', function (event) {

                        $(this).addClass('highlight').siblings().removeClass('highlight');

                    });

                }

            });

        }

    });



    $('button#getProduct').on('click', function () {

        var ProductId = $('table tbody#tblSearchTr tr.highlight').attr('id');

        var ProductName = $('table tbody#tblSearchTr tr#' + ProductId + ' td:first-child').text();

        var ProductDescription = $('table tbody#tblSearchTr tr#' + ProductId + ' td:nth-child(2)').text();

        var ProductPrice = $('input#temp_price_' + ProductId).val();

        var TempTotalAmt = parseFloat(ProductPrice) * 1;





        var TblNum = $('input#tblnum').val();

        var TotalAmt = $('input#overall_totalamt').val().replace(/,/g, '');

        var TotalQty = $('input#overall_totalqty').val();



        if (ProductId == null || ProductId == '') {

            // Silent is everything (^_^

        } else {

            // Get Product Information

            TblNum = parseInt(TblNum) + 1;



            myNewTbl = '<tr id="tbl_' + TblNum + '">' +

                '<td>' +

                '<input type="checkbox" id="tblnumcheck" value="' + TblNum + '">' +

                '<input type="hidden" name="productInfo[]" value="' + ProductId + '">' +

                '</td>' +

                '<td>' + ProductName + '</td>' +

                '<td>' + ProductDescription + '</td>' +

                '<td><input type="number" name="productqty[]" id="productqty_' + TblNum + '" class="productqty" data-id="' + TblNum + '" value="1" min="1"></td>' +

                '<td><input type="text" name="productprice[]" id="productprice_' + TblNum + '" readonly class="form-readonly" value="' + addCommas(ProductPrice) + '"></td>' +

                '<td><input type="text" name="producttotalamt[]" id="productamt_' + TblNum + '" readonly class="form-readonly" value="' + addCommas(TempTotalAmt) + '"></td>' +

                '</tr>';



            $('input#tblnum').val(TblNum);

            $('input#overall_totalamt').val(addCommas(parseFloat(TotalAmt) + parseFloat(TempTotalAmt)));

            $('input#overall_totalqty').val(parseFloat(TotalQty) + 1);

            $('tbody#tblProductMain').append(myNewTbl);



            $('div#productSearchModal').modal('hide');

            $('tbody#tblSearchTr').html('');

            $('input#keySearch').val('');



            productQtyKeyPress();

        }

    });



    $('button#cancelProduct').on('click', function () {

        $('tbody#tblSearchTr').html('');

        $('input#keySearch').val('');

    });



    $('button#remproduct').on('click', function () {

        var checkedValues = $('input#tblnumcheck:checked').map(function () {

            return this.value;

        }).get();



        for (var a = 0; a < checkedValues.length; a++) {

            $('tbody#tblProductMain tr#tbl_' + checkedValues[a]).remove();

        }

        recompute();

    });





    $('button#getProductStatus').on('click', function () {

        var ProductId = $('table tbody#tblSearchTr tr.highlight').attr('id');

        var ProductName = $('table tbody#tblSearchTr tr#' + ProductId + ' td:first-child').text();



        if (product_id == null || product_id == '') {

            // Silent is everything (^_^

        } else {

            // Get Product Information

            $('div#productSearchModal').modal('hide');

            $('input#product_id').val(ProductId);

            $('input#product_name').val(ProductName);



        }

    });

// Kelvin

    $('.edit-category').on('click', function () {

        $("select#e_category_parent option").removeAttr("selected");

        // $('input#e_category_parent_id').val($(this).data('catid'));

        $('div#editMdl').modal('show');

        $('input#e_category_id').val($(this).data('catid'));

        $('input#e_category_name').val($(this).data('name'));

        $('textarea#e_category_description').val($(this).data('description'));

        $("select#e_category_parent option[value='" + $(this).data('parentid') + "']").attr("selected", "selected");

        if($(this).data('displayedname') === 0) {

            $('input#e_displayed_name').val($(this).data('displayedname')).prop('checked',true);

        } else {

            $('input#e_displayed_name').val($(this).data('displayedname')).prop('checked',false);

        }

        if($(this).data('displayeddescription') === 0) {

            $('input#e_displayed_description').val($(this).data('displayeddescription')).prop('checked',true);

        } else {

            $('input#e_displayed_description').val($(this).data('displayeddescription')).prop('checked',false);

        }



        img_name = $(this).data('featuredimg');

        img_name_banner = $(this).data('featuredimgbanner');

        img_name_background = $(this).data("featuredimgbackground");



        var image_container_featured = '<div class="form-group">' +

            '<label for="e_featured_image">Featured Image</label>' +

            '<input type="file" class="form-control" name="e_featured_image" id="e_featured_image" />' +

            '</div>';

        if (img_name != '') {

            image_container_featured = '<label>Featured Image</label><img src="/img/category/' + img_name + '" class="img-thumbnail post-img">' +

                '<button type="button" class="btn btn-danger btn-block remove-image"><span class="fa fa-trash"></span> Remove</button>' +

                '<input type="hidden" id="e_featured_image_value" name="e_featured_image_value" value="'+ img_name + '">';

        }

        $('#editMdl .panel .panel-body .edit_img').html(image_container_featured);

        $('input#e_featured_image').val(img_name);



        $('.remove-image').on('click', function () {

            $('#editMdl .panel .panel-body .edit_img').html('');

            var image_container_featured = '<div class="form-group">' +

                '<label for="e_featured_image">Featured Image</label>' +

                '<input type="file" class="form-control" name="e_featured_image" id="e_featured_image" />' +

                '</div>';

            $('#editMdl .panel .panel-body .edit_img').html(image_container_featured);

            $("input#e_featured_image_value").val("");

        });





        var image_container_banner = '<div class="form-group">' +

            '<label for="e_featured_image_banner">Banner Image</label>' +

            '<input type="file" class="form-control" name="e_featured_image_banner" id="e_featured_image_banner" />' +

            '</div>';

        if (img_name_banner != '') {

            image_container_banner = '<label>Banner</label><img src="/img/category/' + img_name_banner + '" class="img-thumbnail post-img">' +

                '<button type="button" class="btn btn-danger btn-block remove-image-banner"><span class="fa fa-trash"></span> Remove</button>' +

                '<input type="hidden" id="e_banner_image_value" name="e_banner_image_value" value="' + img_name_banner + '">';

        }

        $('#editMdl .panel .panel-body .edit_img_banner').html(image_container_banner);

        $('input#e_featured_image_banner').val(img_name_banner);



        $('.remove-image-banner').on('click', function () {

            $('#editMdl .panel .panel-body .edit_img_banner').html('');

            var image_container_banner = '<div class="form-group">' +

                '<label for="e_featured_image_banner">Banner Image</label>' +

                '<input type="file" class="form-control" name="e_featured_image_banner" id="e_featured_image_banner" />' +

                '</div>';

            $('#editMdl .panel .panel-body .edit_img_banner').html(image_container_banner);

            $("input#e_banner_image_value").val('');

        });





        var image_container_background = '<div class="form-group">' +

            '<label for="e_featured_image_background">Background Image</label>' +

            '<input type="file" class="form-control" name="e_featured_image_background" id="e_featured_image_background" />' +

            '</div>';

        if (img_name_background != '') {

            image_container_background = '<label>Featured Background Image</label><img src="/img/category/' + img_name_background + '" class="img-thumbnail post-img">' +

                '<button type="button" class="btn btn-danger btn-block remove-image-background"><span class="fa fa-trash"></span> Remove</button>' +

                '<input type="hidden" id="e_background_image_value" name="e_background_image_value" value="' + img_name_background + '">';

        }

        $('#editMdl .panel .panel-body .edit_img_background').html(image_container_background);

        $('input#e_featured_image_background').val(img_name_background);



        $('.remove-image-background').on('click', function () {

            $('#editMdl .panel .panel-body .edit_img_background').html('');

            var image_container_background = '<div class="form-group">' +

                '<label for="e_featured_image_background">Background Image</label>' +

                '<input type="file" class="form-control" name="e_featured_image_background" id="e_featured_image_background" />' +

                '</div>';

            $('#editMdl .panel .panel-body .edit_img_background').html(image_container_background);

            $("input#e_background_image_value").val("");

        });

    });



    $('.edit-brand').on('click', function () {

        $('div#editMdl').modal('show');

        $('input#e_brand_id').val($(this).data('catid'));

        $('input#e_brand_name').val($(this).data('name'));

        $('textarea#e_brand_description').val($(this).data('description'));

        $('input#e_featured_image_value').val($(this).data('featuredimg'));

        $('input#e_featured_image_banner_value').val($(this).data('featuredimgbanner'));

        if($(this).data('hide') == 1){

            $('input#e_hide_brand').prop("checked", true);

        } else {

            $('input#e_hide_brand').prop("checked", false);

        }

        img_name = $(this).data('featuredimg');

        img_name_banner = $(this).data('featuredimgbanner');



        var image_container = '<div class="form-group">' +

            '<label for="e_featured_image">Featured Image</label>' +

            '<input type="file" class="form-control" name="e_featured_image" id="e_featured_image" />' +

            '</div>';

        if (img_name != '') {

            image_container = '<label for="e_featured_image">Featured Image</label><img src="/img/brand/' + img_name + '" class="img-thumbnail post-img">' +

                '<button type="button" class="btn btn-danger btn-block remove-image"><span class="fa fa-trash"></span> Remove</button>';

        }

        $('#editMdl .panel .panel-body .edit_img').html(image_container);



        $('.remove-image').on('click', function () {

            $('#editMdl .panel .panel-body .edit_img').html('');

            var image_container = '<div class="form-group">' +

                '<label for="e_featured_image">Featured Image</label>' +

                '<input type="file" class="form-control" name="e_featured_image" id="e_featured_image" />' +

                '</div>';

            $('#editMdl .panel .panel-body .edit_img').html(image_container);

            $('input#e_featured_image_value').val('');

        });

        //baner

        var image_container_banner = '<div class="form-group">' +

            '<label for="e_featured_image_banner">Featured Banner</label>' +

            '<input type="file" class="form-control" name="e_featured_image_banner" id="e_featured_image_banner" />' +

            '</div>';

        if (img_name_banner != '') {

            image_container_banner = '<label for="e_featured_image_banner">Featured Banner</label><img src="/img/brand/' + img_name_banner + '" class="img-thumbnail post-img">' +

                '<button type="button" class="btn btn-danger btn-block remove-image-banner"><span class="fa fa-trash"></span> Remove</button>';

        }

        $('#editMdl .panel .panel-body .edit_banner_img').html(image_container_banner);



        $('.remove-image-banner').on('click', function () {

            $('#editMdl .panel .panel-body .edit_banner_img').html('');

            var image_container_banner = '<div class="form-group">' +

                '<label for="e_featured_image_banner">Featured Banner</label>' +

                '<input type="file" class="form-control" name="e_featured_image_banner" id="e_featured_image_banner" />' +

                '</div>';

            $('#editMdl .panel .panel-body .edit_banner_img').html(image_container_banner);

            $('input#e_featured_image_banner_value').val('');

        });

    });



    $('.edit-supplier').on('click', function () {

        $('div#editMdl').modal('show');

        $('input#e_supplier_id').val($(this).data('catid'));

        $('input#e_supplier_name').val($(this).data('name'));

        $('input#e_supplier_code').val($(this).data('code'));

        $('input#e_supplier_contact_no').val($(this).data('contactno'));

        $('input#e_supplier_email').val($(this).data('email'));

        $('input#e_supplier_address').val($(this).data('address'));

    });



    $('.edit-shipping').on('click', function () {

        $('div#editMdl').modal('show');

        $('input#e_id').val($(this).data('shippingid'));

        $('input#e_location').val($(this).data('location'));

        $('input#e_price0').val($(this).data('shippingprice1'));

        $('input#e_price1').val($(this).data('shippingprice2'));

        $('input#e_price2').val($(this).data('shippingprice3'));

        $('input#e_price3').val($(this).data('shippingprice4'));

        $('input#e_price4').val($(this).data('shippingprice5'));

        $('input#e_price5').val($(this).data('shippingprice6'));

        $('input#e_price6').val($(this).data('shippingprice7'));

        $('input#e_price7').val($(this).data('shippingprice8'));

        $('input#e_price8').val($(this).data('shippingprice9'));

        $('input#e_price9').val($(this).data('shippingprice10'));

        $('input#e_price10').val($(this).data('shippingprice11'));

        $('input#e_price11').val($(this).data('shippingprice12'));

        $('input#e_price12').val($(this).data('shippingprice13'));

        $('input#e_price13').val($(this).data('shippingprice14'));

        $('input#e_price14').val($(this).data('shippingprice15'));

        $('input#e_price15').val($(this).data('shippingprice16'));

        $('input#e_price16').val($(this).data('shippingprice17'));

        $('input#e_price17').val($(this).data('shippingprice18'));

        $('input#e_price18').val($(this).data('shippingprice19'));

    	$('input#e_price19').val($(this).data('shippingprice20'));

    	

    })



    $('.edit-post').on('click', function () {

        console.log($(this).data())

        $('#editMdl .panel .panel-body .xtra').html('');

        $('#editMdl .panel .panel-body .banner').html('');

        $('div#editMdl').modal('show');

    	$('input#e_button_name').val($(this).data('buttonname'));

    	$('input#e_button_link').val($(this).data('buttonlink'));

        $('input#e_post_id').val($(this).data('postid'));

        $('input#e_featured_image_value').val($(this).data('image'));

        if($(this).data('displayedpostcontent') === 0) {

            $('input#e_displayed_post_content').val($(this).data('displayedpostcontent')).prop('checked',true);

        } else {

            $('input#e_displayed_post_content').val($(this).data('displayedpostcontent')).prop('checked',false);

        }

        if($(this).data('displayedbutton') === 0) {

            $('input#e_displayed_button').val($(this).data('displayedbutton')).prop('checked',true);

        } else {

            $('input#e_displayed_button').val($(this).data('displayedbutton')).prop('checked',false);

        }

        if($(this).data("displayedtitle") === 0) {

            $('input#e_displayed_title').val($(this).data('displayedtitle')).prop('checked',true);

        } else {

            $('input#e_displayed_title').val($(this).data('displayedtitle')).prop('checked',false);

        }

        $("textarea#e_post_title").val($(this).data("posttitle"));

        $('input#e_post_name').val($(this).data('postname'));

        $('input#e_featured_banner_value').val($(this).data('bannerimage'));

        //$('textarea#e_post_content').val($(this).data('postcontent'));

       

       $('textarea#e_post_content').summernote('code',$(this).data('postcontent'));

        var image_container = '<div class="form-group">' +

            '<label for="e_featured_image">Image</label>' +

            '<input type="file" class="form-control" name="e_featured_image" id="e_featured_image" />' +

            '</div>';

        var fileName, fileExtension;

            fileName = $(this).data('image');

            fileExtension = fileName.substr((fileName.lastIndexOf('.') + 1));

        if ($(this).data('image') != '' && fileExtension == 'pdf') {

            image_container = '<embed src="/img/post/' + $(this).data('image') + '" class="img-thumbnail post-img">' +

                '<button type="button" class="btn btn-danger btn-block remove-post-image"><span class="fa fa-trash"></span> Remove</button>';

        } else if ($(this).data('image') != '' && fileExtension == 'png') {

            image_container = '<img src="/img/post/' + $(this).data('image') + '" class="img-thumbnail post-img">' +

                '<button type="button" class="btn btn-danger btn-block remove-post-image"><span class="fa fa-trash"></span> Remove</button>';

        }



        $('#editMdl .panel .panel-body .xtra').append(image_container);

        $('input#e_featured_image').val($(this).data('image'));

 



        $('.remove-post-image').on('click', function () {

            $('#editMdl .panel .panel-body .xtra').html('');

            $('input#e_featured_image_value').val('');

            var image_container = '<div class="form-group">' +

                '<label for="e_featured_image">Image</label>' +

                '<input type="file" class="form-control" name="e_featured_image" id="e_featured_image" />' +

                '</div>';

            $('#editMdl .panel .panel-body .xtra').append(image_container);

        });



        var image_banner = '<div class="form-group">' +

        '<label for="e_featured_banner">Banner</label>' +

        '<input type="file" class="form-control" name="e_featured_banner" id="e_featured_banner" />' +

        '</div>';



        if ($(this).data('bannerimage') != '') {        

            image_banner = '<label for="e_featured_image_banner">Featured Banner</label><img src="/img/post/' + $(this).data('bannerimage') + '" class="img-thumbnail post-img">' +

                '<button type="button" class="btn btn-danger btn-block remove-post-images"><span class="fa fa-trash"></span> Remove</button>';

        }

        

        $('#editMdl .panel .panel-body .banner').append(image_banner);

        $('input#e_featured_banner').val($(this).data('bannerimage'));



        $('.remove-post-images').on('click', function () {

            $('#editMdl .panel .panel-body .banner').html('');

            $('input#e_featured_banner_value').val('');

            var image_banner = '<div class="form-group">' +

            '<label for="e_featured_banner">Image</label>' +

            '<input type="file" class="form-control" name="e_featured_banner" id="e_featured_banner" />' +

            '</div>';

            $('#editMd1 .panel .panel-body .banner').append(image_banner);

        });

    });



    $('#add-banner').on('click', function () {

        if ($('#banner-post-list').val() == 0) {



        } else {

            var old_val = $('.banner-array-meta').val();

            if (old_val == '') {

                var new_banner = $('#banner-post-list').val();

            } else {

                var new_banner = old_val + ',' + $('#banner-post-list').val();

            }

            $('.banner-array-meta').val(new_banner);



            var Token = $('input[name="_token"]').val();

            $.ajax({

                url: '/admin/page/updatemetadata',

                method: "post",

                dataType: "json",

                data:

                {

                    _token: Token,

                    meta_value: new_banner,

                    meta_key: 'banner',

                    meta_type: "post_array",

                    source_id: 1,

                    source_type: 'post',

                },

                success: function (data) {

                    location.reload();

                }

            });



        }

    });



    $('#add-hot-deals').on('click', function () {

        if ($('#deals-product-list').val() == 0) {



        } else {

            var old_val = $('.deals-array-meta').val();

            if (old_val == '') {

                var new_value = $('#deals-product-list').val();

            } else {

                var new_value = old_val + ',' + $('#deals-product-list').val();

            }

            $('.deals-array-meta').val(new_value);



            var Token = $('input[name="_token"]').val();

            $.ajax({

                url: '/admin/page/updatemetadata',

                method: "post",

                dataType: "json",

                data:

                {

                    _token: Token,

                    meta_value: new_value,

                    meta_key: 'hot_deals',

                    meta_type: "product_array",

                    source_id: 1,

                    source_type: 'product',

                },

                success: function (data) {

                    location.reload();

                }

            });

        }

    });



    $("#add-featured-product").on("click", function () {

        if ($("#featured-product-list").val() == 0) {

        } else {

            var old_val = $(".featured-product-array-meta").val();

            if (old_val == "") {

                var new_value = $("#featured-product-list").val();

            } else {

                var new_value = old_val + "," + $("#featured-product-list").val();

            }

            $(".featured-product-array-meta").val(new_value);



            var Token = $('input[name="_token"]').val();

            $.ajax({

                url: "/admin/page/updatemetadata",

                method: "post",

                dataType: "json",

                data: {

                    _token: Token,

                    meta_value: new_value,

                    meta_key: "featured_products",

                    meta_type: "product_array",

                    source_id: 1,

                    source_type: "product"

                },

                success: function (data) {

                    location.reload();

                }

            });

        }

    });



    $("#add-official-brand").on("click", function () {

        if ($("#official-brand-list").val() == 0) {

        } else {

            var old_val = $(".official-brand-array-meta").val();

            if (old_val == "") {

                var new_value = $("#official-brand-list").val();

            } else {

                var new_value = old_val + "," + $("#official-brand-list").val();

            }

            $(".official-brand-array-meta").val(new_value);



            var Token = $('input[name="_token"]').val();

            $.ajax({

                url: "/admin/page/updatemetadata",

                method: "post",

                dataType: "json",

                data: {

                    _token: Token,

                    meta_value: new_value,

                    meta_key: "official_brands",

                    meta_type: "brand_array",

                    source_id: 1,

                    source_type: "brand"

                },

                success: function (data) {

                    location.reload();

                }

            });

        }

    });



    $("#add-product-category").on("click", function () {

        if ($("#product-category-list").val() == 0) {

        } else {

            var old_val = $(".product-categories-array-meta").val();

            if (old_val == "") {

                var new_value = $("#product-category-list").val();

            } else {

                var new_value = old_val + "," + $("#product-category-list").val();

            }

            $(".product-categories-array-meta").val(new_value);



            var Token = $('input[name="_token"]').val();

            $.ajax({

                url: "/admin/page/updatemetadata",

                method: "post",

                dataType: "json",

                data: {

                    _token: Token,

                    meta_value: new_value,

                    meta_key: "product_category",

                    meta_type: "category_array",

                    source_id: 1,

                    source_type: "category"

                },

                success: function (data) {

                    location.reload();

                }

            });

        }

    });

// Kelvin End

    $(function () {

        $.getJSON('http://www.highcharts.com/samples/data/jsonp.php?filename=aapl-c.json&callback=?', function (data) {

            window.chart = new Highcharts.StockChart({

                chart: {

                    renderTo: 'highchart-sample'

                },

                rangeSelector: {

                    selected: 1,

                    inputDateFormat: '%Y-%m-%d'

                },

                title: {

                    text: 'Sales Report'

                },

                series: [{

                    name: 'Sales',

                    data: data,

                    tooltip: {

                        valueDecimals: 2

                    }

                }]



            }, function (chart) {

                setTimeout(function () {

                    $('input.highcharts-range-selector', $('#' + chart.options.chart.renderTo)).datepicker()

                }, 0)

            });

        });

        $.datepicker.setDefaults({

            dateFormat: 'yy-mm-dd',

            onSelect: function (dateText) {

                this.onchange();

                this.onblur();

            }

        });



    });

    $('.select2').select2();



});



function productQtyKeyPress() {

    $('input.productqty').bind('keyup mouseup', function () {

        var myId = $(this).data('id');

        var TempQty = $('input#productqty_' + myId).val();

        var Price = $('input#productprice_' + myId).val().replace(/,/g, '');

        //Total Amount Sub        

        var TotalSubAmt = parseInt(TempQty) * parseFloat(Price);

        $('input#productamt_' + myId).val(addCommas(TotalSubAmt));

        recompute();

    });

}



function recompute() {

    //Get All Data

    var TblRemaining = $('input#tblnumcheck').map(function () {

        return this.value;

    }).get();



    var NumTempQty = 0; var TotalTempQty = 0;

    var NumTempPrice = 0; var TotalTempPrice = 0;

    for (var b = 0; b < TblRemaining.length; b++) {

        //Total Quantity

        NumTempQty = $("input#productqty_" + TblRemaining[b]).val();

        TotalTempQty = parseInt(TotalTempQty) + parseInt(NumTempQty);

        //Total Amount

        NumTempPrice = $("input#productamt_" + TblRemaining[b]).val().replace(/,/g, '');

        TotalTempPrice = parseFloat(TotalTempPrice) + parseFloat(NumTempPrice);

    }



    $('input#overall_totalqty').val(TotalTempQty);

    $('input#overall_totalamt').val(addCommas(TotalTempPrice));

}





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





function cleanArray(actual) {

    var newArray = new Array();

    for (var i = 0; i < actual.length; i++) {

        if (actual[i]) {

            newArray.push(actual[i]);

        }

    }

    return newArray;

}

$('.edit-variable').click(function () {

    var_id = $(this).data('varid');

    var_name = $(this).data('varname');

    var_desc = $(this).data('vardesc');



    $('#edit_variable_name').val(var_name);

    $('#edit_variable_description').val(var_desc);

    $('#edit_variable_id').val(var_id);

    $('#editVariableForm').attr('action', base_url + '/admin/variable/' + var_id);

    $('#editVariableModal').modal('show');

});





$('.edit-attrb').click(function () {

    attrb_varid = $(this).data('attrb_varid');

    attrbid = $(this).data('attrbid');

    attrbname = $(this).data('attrbname');

    attrbdesc = $(this).data('attrbdesc');

    variabletype = $(this).data('variabletype');

    cat_color = $(this).data('catcolor');

    r_attr = $(this).data('rattr');

    g_attr = $(this).data('gattr');

    b_attr = $(this).data('battr');



    str_id = $('#str_id').val();

    str_name = $('#str_name').val();



    str_id_arr = cleanArray(str_id.split(","));

    str_name_arr = cleanArray(str_name.split(","));

    edit_attrb_opt = '<option>Select Variable</option>';




    if (str_id_arr.length > 0) {

        for (s = 0; s < str_id_arr.length; s++) {

            add_htmlattrib = (str_id_arr[s] == attrb_varid) ? 'selected' : '';

            edit_attrb_opt += '<option ' + add_htmlattrib + ' value="' + str_id_arr[s] + '">' + str_name_arr[s] + '</option>';

        }

    }



    $('#edit_attrb_name').val(attrbname);

    $('#edit_attrb_description').val(attrbdesc);

    $('#edit_attrb_id').val(attrbid);

    $('#edit_variable_name').html(edit_attrb_opt);

    $('#edit_attrb_catcolor').val(cat_color);

    $('#edit_attrb_red').val(r_attr);

    $('#edit_attrb_green').val(g_attr);

    $('#edit_attrb_blue').val(b_attr);

    $('#editAttributeForm').attr('action', base_url + '/admin/attribute/' + attrbid);

    
    if(variabletype == 'Color') {
        $(".color_attrib").css("display","block");
    }else{
        $(".color_attrib").css("display","none");
    }

    $('#editAttributeModal').modal('show');

});



$('.revaction').click(function(){

	$('.temp_revaction').val($(this).data('action'));

	$('.temp_revid').val($(this).data('revid'));

	$('#rating_modal').modal('show');

});


