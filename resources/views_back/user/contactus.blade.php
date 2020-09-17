@extends('layouts.user.app')

@section('content')

<div id="contact-us-form">
<div class="carousel-inner"> <!-- banner content -->
    <div class="item active bg-img" style="background-image: url({{ URL::asset('/img/banner/contact_us_banner.png') }}); background-size: cover; background-repeat: no-repeat; background-position: center center;">
        <div class="bg-overlay" style="height: "></div>
        <div class="banner-content" style="height: ">
            <div class="row vcenter">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="md-txt">
                        <h1></h1>
                    </div>
                    <div class="short-desc">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <div class="contact-us">
            <div class="pg-hdr">
                    @include('flash-message')
                    <div class="page-header">
                        <div class="page-title"><a href="{{ URL::to('/') }}">Home </a><span>Contact Us</span></div>
            
                    </div>
                </div>
        {{-- <div class="title">Contact Us</div> --}}
        <div class="row ">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="title-cont-center">

                </div>
                {{-- <div class="map">
                    <div class="title-cont">MAP</div>
                    <div class="map-img"><iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3859.986897812066!2d120.98336700000002!3d14.656685000000001!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x185d2e010b4a3d33!2sAraneta+Square!5e0!3m2!1sen!2ssg!4v1521193893934" width="100%" height="300" frameborder="0" style="border:0" allowfullscreen></iframe></div>
                </div> --}}

            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <h3>Talk to us, it’s EZ!</h3>
                <p>Send us your message and we’ll give you a response ASAP
                    <br /><b>From Mondays to Saturdays, from 8AM to 6PM.</b> (Holidays excluded)
                    </p>
                <p><b>For general inquiries:</b></p>
                <p><a href="https://mail.google.com/mail/?view=cm&fs=1&to=ezdeal.contactus@gmail.com" target="_blank">ezdeal.contactus@gmail.com</a></p>
                <p><b>For Business Concerns:</b></p>
                <p><a href="https://mail.google.com/mail/?view=cm&fs=1&to=ezdealphilippines@gmail.com" target="_blank">ezdealphilippines@gmail.com</a></p>
                <p><b>For EZ Deal Orders</b></p>
                <p><a href="https://mail.google.com/mail/?view=cm&fs=1&to=ezdealordermanagement@gmail.com" target="_blank">ezdealordermanagement@gmail.com</a></p>
                <div>
                    <p>Learn more about EZ DEAL Online Shopping via our social media accounts</p>
                </div>
                <div class="social-icon" style="display: flex">
                    <div class="icon-item"><a  target="_blank" href="https://www.facebook.com/EZDealOnline/"><img src="{{ URL::asset('img/icons/large-001-facebook.png') }}" class="logo"></a></div>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                    <div class="icon-item"><a target="_blank" href=""><img src="{{ URL::asset('img/icons/large-001-shopee.png') }}" class="logo"></a></div>

                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="inquery">
                    <div class="title-cont">FOR INQUIRY</div>
                    <!-- <form action="{{ URL::action('User\ContactUsController@contact_form') }}" method="post" accept-charset="UTF-8"> -->
                    <form id="inquiry_form" action="{{ URL::action('User\ContactUsController@contact_form') }}"  method="POST">
                        <div class="form-group contact_us_msg"></div>
                        {!! csrf_field() !!}
                        <div class="input-group inquiry-form">
                        <input type="text" id="fullname" name="fullname" class="form-control" value="{{old('fullname')}}" required placeholder="Name">

                            <input type="text" id="contactnumber" value="{{old('contactnumber')}}"  name="contactnumber" class="form-control" required placeholder="Contact">
                            <input type="text" id="emailadd" value="{{old('emailadd')}}" name="emailadd" class="form-control" required placeholder="Email">
                            <input type="text" class="form-control" value="{{old('titlesubject')}}" id="titlesubject" name="titlesubject" list="titlesubject" placeholder="Title Subject" >
                            <datalist style="display:none;" class="form-control" id="titlesubject" >
                                <option>Product Inquiry</option>
                                <option>Account Safety and Others</option>
                                <option>Orders & Payments</option>
                                <option>Shipping & Delivery</option>
                                <option>Tracking Updates</option>
                            </datalist>
                        <textarea class="form-control" required id="messagecontact" value="{{old('messagecontact')}}" name="messagecontact" placeholder="Your Message"></textarea>
                            <div align="right">
                                    <button  type="submit" class="btn btn-gold" id="send_contactus_btn">Send</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection