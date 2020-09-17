@extends('layouts.user.app')

@section('content')
<style>

#first-section .slick-next::before {
    content: url('img/right.png');
}

#first-section .slick-prev::before {
    content: url('img/left.png');
}

#fourth-section .slick-next::before {
    content: url('img/right white.png');
}

#fourth-section .slick-prev::before {
    content: url('img/left white.png');
}

</style>
<div id="first-section">
    <div class="banner-content">
        <div>
        <div class="banner-slide" style="background-image: url('img/banner 1.png'); background-size: cover; background-repeat: no-repeat; background-position: center center;">
            <div class="container">
                <div class="widget-box">
                    <div class="heading">for<br>EXTERIOR<br>PAINT<br>products</div>
                    <div class="desc">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                    </div>
                    <a href="#" class="btn white">READ MORE</a>
                </div>
            </div>
        </div></div>
        <div>
        <div class="banner-slide" style="background-image: url('img/banner 2.png'); background-size: cover; background-repeat: no-repeat; background-position: center center;">
            <div class="container">
                <div class="widget-box">
                    <div class="heading">for<br>EXTERIOR<br>PAINT<br>products</div>
                    <div class="desc">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                    </div>
                    <a href="#" class="btn white">READ MORE</a>
                </div>
            </div>
        </div></div>
    </div>
</div>
<!-- Second Section -->
<div id="second-section">
  <div class="container">
    <div class="block">
      <div class="widget-box">
        <div class="left-col">
          <div class="title">Whats new, products or services</div>
          <div class="description">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut</div>
        </div>
        <div class="right-col">
          <div class="bg-img" style="background-image: url('img/001.png'); background-size: cover; background-repeat: no-repeat; background-position: center center;"></div>
        </div>
      </div>
      <div class="widget-box">
        <div class="left-col">
          <div class="title">Company news & latest promos</div>
          <div class="description">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut</div>
        </div>
        <div class="right-col">
          <div class="bg-img" style="background-image: url('img/002.png'); background-size: cover; background-repeat: no-repeat; background-position: center center;"></div>
        </div>
      </div>
      <div class="widget-box">
        <div class="left-col">
          <div class="title">Color Depot</div>
          <div class="description">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut</div>
        </div>
        <div class="right-col">
          <div class="bg-img" style="background-image: url('img/003.png'); background-size: cover; background-repeat: no-repeat; background-position: center center;"></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Third Section -->
<div id="third-section">
    <div class="container">
        <div class="heading">Color Charts and brochures</div>
        <div class="description">Browse by colour scheme</div>
        <!-- color picker -->
        <div class="color-row">
          <div class="color-picker">
            <div class="color-box" style="background-color:#F6F7F2;"></div>
            <div class="ttl">Whites </br>& Neutrals</div>
          </div>
          <div class="color-picker">
            <div class="color-box" style="background-color:#373E42;"></div>
            <div class="ttl">Greys</div>
          </div>
          <div class="color-picker">
            <div class="color-box" style="background-color:#B39F94;"></div>
            <div class="ttl">Browns</div>
          </div>
          <div class="color-picker">
            <div class="color-box" style="background-color:#7E7999;"></div>
            <div class="ttl">Purples</div>
          </div>
          <div class="color-picker">
            <div class="color-box" style="background-color:#29436E;"></div>
            <div class="ttl">Blue</div>
          </div>
          <div class="color-picker">
            <div class="color-box" style="background-color:#9DBFAF;"></div>
            <div class="ttl">Greens</div>
          </div>
          <div class="color-picker">
            <div class="color-box" style="background-color:#FAE196;"></div>
            <div class="ttl">Yellows</div>
          </div>
          <div class="color-picker">
            <div class="color-box" style="background-color:#CC5327;"></div>
            <div class="ttl">Oranges</div>
          </div>
          <div class="color-picker">
            <div class="color-box" style="background-color:#A8312F;"></div>
            <div class="ttl">Reds</div>
          </div>
        </div>
    </div>
</div>
<!-- Fourth Section -->
<div id="fourth-section">
    <div class="block">
        <div>
        <div class="bg-img" style="background-image: url('img/aqua guard bg.png'); background-size: cover; background-repeat: no-repeat; background-position: center center;">
            <div class="container">
                <div class="heading-bx">
                    <div class="thumbnail-img"><img src="img/universal paint small logo.png"></div>
                    <div class="thumbnail-desc">featured product</div>
                </div>
                <div class="widget-box">
                    <div class="thumbnail-logo"><img src="img/Aqua guard logo.png"></div>
                    <div class="lrg-title">paint seal protect</div>
                    <div class="sml-title">The Premium Elastometric Waterproofing Paint</div>
                    <div class="desc">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo</div>
                    <a href="#" class="btn">DOWNLOAD PRODUCT BROCHURE PDF</a>
                </div>
            </div>
        </div></div>
        <div>
        <div class="bg-img" style="background-image: url('img/aqua guard bg.png'); background-size: cover; background-repeat: no-repeat; background-position: center center;">
            <div class="container">
                <div class="heading-bx">
                    <div class="thumbnail-img"><img src="img/universal paint small logo.png"></div>
                    <div class="thumbnail-desc">featured product</div>
                </div>
                <div class="widget-box">
                    <div class="thumbnail-logo"><img src="img/Aqua guard logo.png"></div>
                    <div class="lrg-title">paint seal protect</div>
                    <div class="sml-title">The Premium Elastometric Waterproofing Paint</div>
                    <div class="desc">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliqui. o</div>
                    <a href="#" class="btn">DOWNLOAD PRODUCT BROCHURE PDF</a>
                </div>
            </div>
        </div></div>
    </div>
</div>
<!-- Fifth Section -->
 <div id="fifth-section">
    <div class="container">
        <div class="heading-bx">
            <div class="thumbnail-img"><img src="img/universal paint small logo 2.png"></div>
            <div class="thumbnail-desc">featured product</div>
        </div>
        <div class="block">
            <div class="align-bx row-bx">
                <div class="widget-box" style="background-image: url('img/p1.png'); background-size: cover; background-repeat: no-repeat; background-position: center center;">
                    <div class="color-desc brown">
                        <div class="ttl">exterior paint</div>
                        <div class="desc">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et</div>
                    </div>
                </div>
                <div class="widget-box" style="background-image: url('img/p2.png'); background-size: cover; background-repeat: no-repeat; background-position: center center;">
                    <div class="color-desc blue-green">
                        <div class="ttl">exterior paint</div>
                        <div class="desc">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et</div>
                    </div>
                </div>
            </div>
            <div class="center-bx row-bx">
                <div class="widget-box" style="background-image: url('img/p3.png'); background-size: cover; background-repeat: no-repeat; background-position: center center;">
                    <div class="color-desc dark-blue">
                        <div class="ttl">exterior paint</div>
                        <div class="desc">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et</div>
                    </div>
                </div>
            </div>
            <div class="align-bx row-bx">
                <div class="widget-box" style="background-image: url('img/p4.png'); background-size: cover; background-repeat: no-repeat; background-position: center center;">
                    <div class="color-desc light-gray">
                        <div class="ttl">exterior paint</div>
                        <div class="desc">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et</div>
                    </div>
                </div>
                <div class="widget-box" style="background-image: url('img/p5.png'); background-size: cover; background-repeat: no-repeat; background-position: center center;">
                    <div class="color-desc orange">
                        <div class="ttl">exterior paint</div>
                        <div class="desc">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Sixth Section -->
 <div id="sixth-section" style="background-image: url('img/footer bg.png'); background-size: cover; background-repeat: no-repeat; background-position: top center;">
    <div class="container">
        <div class="heading-bx">
            <div class="thumbnail-img"><img src="img/universal paint small logo 2.png"></div>
            <div class="thumbnail-desc">get expert help</div>
        </div>
        <div class="block">
            <div class="widget-box">
                <div class="top-con">
                    <div class="ttl">REQUEST COLOR BROCHURES</div>
                    <div class="desc"> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et</div>
                </div>
                <div class="btn-con">
                    <a href="#" class="btn yellow">Read More</a>
                </div>
            </div>
            <div class="widget-box">
                <div class="top-con">
                    <div class="ttl">HOW TO PAINT GUIDE & TIPS FOR PAINTING</div>
                    <div class="desc"> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et</div>
                </div>
                <div class="btn-con">
                    <a href="#" class="btn yellow">Read More</a>
                </div>
            </div>
            <div class="widget-box">
                <div class="top-con">
                    <div class="ttl">COLOR CHARTS</div>
                    <div class="desc"> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et</div>
                </div>
                <div class="btn-con">
                    <a href="#" class="btn yellow">Read More</a>
                </div>
            </div>
            <div class="widget-box">
                <div class="top-con">
                    <div class="ttl">PAINT CALCULATOR</div>
                    <div class="desc"> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et</div>
                </div>
                <div class="btn-con">
                    <a href="#" class="btn yellow">Read More</a>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
