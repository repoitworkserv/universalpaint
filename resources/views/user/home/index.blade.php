@extends('layouts.user.app')

@section('content')
<style>
    #first-section .slick-next::before {
        content: url('img/right_white.png');
    }

    #first-section .slick-prev::before {
        content: url('img/left_white.png');
    }

    #fourth-section .slick-next::before {
        content: url('img/right_white.png');
    }

    #fourth-section .slick-prev::before {
        content: url('img/left_white.png');
    }
</style>
<div id="first-section">
    <div class="banner-content">
        <div>
            <div class="banner-slide first" style="background-image: url('img/1.jpg'); background-size: cover; background-repeat: no-repeat; background-position: center center;">
                <div class="container">
                    <div class="widget-box">
                        <div class="heading">Premium quality white without the premium cost?</div>
                        <div class="desc">
                            Click here to know how Universal PLUS delivers white without the premium price tag.
                        </div>
                        <a href="/product/universal-professional-architectural-paint-plus-latex-paint" class="btn white">READ MORE</a>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div class="banner-slide second" style="background-image: url('img/2.jpg'); background-size: cover; background-repeat: no-repeat; background-position: center center;">
                <div class="container">
                    <div class="widget-box">
                        <div class="heading">Metal & Steel preparation paint</div>
                        <div class="desc">
                            Ptotect steel and metal from corrosion with Universal Paint industrial grade coatings
                        </div>
                        <a href="/product-category/industrial" class="btn white">READ MORE</a>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div class="banner-slide" style="background-image: url('img/3.jpg'); background-size: cover; background-repeat: no-repeat; background-position: center center;">
                <div class="container">
                    <div class="widget-box">
                        <div class="heading">Sometimes, all you need is color</div>
                        <div class="desc">
                            Check out the color depot page and choose from over a thousand unique interior and exterior colors
                        </div>
                        <a href="/color-swatches" class="btn white">READ MORE</a>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div class="banner-slide fourth" style="background-image: url('img/4.jpg'); background-size: cover; background-repeat: no-repeat; background-position: center center;">
                <div class="container">
                    <div class="widget-box">
                        <div class="heading">for<br>INTERIOR<br>PAINT<br>products</div>
                        <div class="desc">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                        </div>
                        <a href="/product/aquaguard-elastomeric-paint-aquaguard-elastomeric-paint" class="btn white">READ MORE</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Third Section -->
<div id="third-section">
    <div class="container">
        <div class="heading">Our thousands of colors, Your Choice</div>
        <div class="thumbnail-logo"><img src="img/bluelogo.png"></div>
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
                <div class="color-box" style="background-color:#0045C7;"></div>
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
            <div class="bg-img" style="background-image: url('img/aquaguard.png'); background-size: contain; background-repeat: no-repeat; background-position: center right;">
                <div class="container">
                    <div class="heading-bx">
                        <div class="thumbnail-desc">featured product</div>
                    </div>
                    <div class="widget-box">
                        <div class="lrg-title">AquaGuard Elastomeric Paint</div>
                        <div class="desc">AquaGuard is a premium quality elastomeric paint, it features a flexible and ultra-durable coating that fills and covers existing or developing cracks on your wall - creating a waterproof barrier against rain from entering your home. Guaranteed to protect your home against all types of tropical weather.</div>
                        <a href="#" class="btn">DOWNLOAD PRODUCT BROCHURE PDF</a>
                    </div>
                    <a href="/product/aquaguard-elastomeric-paint-aquaguard-elastomeric-paint">
                        <div class="widget-box clickable-paint">
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div>
            <div class="bg-img" style="background-image: url('img/pluslatex.png'); background-size: contain; background-repeat: no-repeat; background-position: center right;">
                <div class="container">
                    <div class="heading-bx">
                        <div class="thumbnail-desc">featured product</div>
                    </div>
                    <div class="widget-box">
                        <div class="lrg-title">Plus Latex Paint</div>
                        <div class="desc">PLUS is a premium-economy quality latex paint. Perfect for concrete and masonry surfaces where quality is needed without the premium price.</div>
                        <a href="#" class="btn">DOWNLOAD PRODUCT BROCHURE PDF</a>
                    </div>
                    <a href="/product/universal-professional-architectural-paint-plus-latex-paint">
                        <div class="widget-box clickable-paint">
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div>
            <div class="bg-img" style="background-image: url('img/roofarmor.png'); background-size: contain; background-repeat: no-repeat; background-position: center right;">
                <div class="container">
                    <div class="heading-bx">
                        <div class="thumbnail-desc">featured product</div>
                    </div>
                    <div class="widget-box">
                        <div class="lrg-title">Universal Roof Armour</div>
                        <div class="desc">Premium quality roof paint that is formulated using UV resistant pigments. Will protect your roof and keep it looking new longer.</div>
                        <a href="#" class="btn">DOWNLOAD PRODUCT BROCHURE PDF</a>
                    </div>
                    <a href="/product/universal-roof-armour-universal-roof-armour">
                        <div class="widget-box clickable-paint">
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div>
            <div class="bg-img" style="background-image: url('img/epoxshield.png'); background-size: contain; background-repeat: no-repeat; background-position: center right;">
                <div class="container">
                    <div class="heading-bx">
                        <div class="thumbnail-desc">featured product</div>
                    </div>
                    <div class="widget-box">
                        <div class="lrg-title">Otto EpoxShield Topcoat</div>
                        <div class="desc">Otto Epoxshield is an industrial quality two component epoxy topcoat that provides the ultimate in corrosion and abrasion resistance for your metal and steel projects. Dries to a smooth and glossy finish for easy maintenance</div>
                        <a href="#" class="btn">DOWNLOAD PRODUCT BROCHURE PDF</a>
                    </div>
                    <a href="/product/otto-epoxshield-otto-epoxshield-topcoat">
                        <div class="widget-box clickable-paint">
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Fifth Section -->
<div id="fifth-section">
    <div class="container">
        <div class="heading-bx">
            <div class="thumbnail-desc">what to paint</div>
        </div>
        <div class="block">
            <div class="align-bx row-bx">
                <div class="widget-box" style="background-image: url('img/surface.jpg'); background-size: cover; background-repeat: no-repeat; background-position: center center;">
                    <div class="color-desc light-gray">
                        <div class="ttl"><a href="/product-category/surface-preparation">Preparation</a></div>
                        <div class="desc"></div>
                    </div>
                </div>
                <div class="widget-box" style="background-image: url('img/p2.png'); background-size: cover; background-repeat: no-repeat; background-position: center center;">
                    <div class="color-desc brown">
                        <div class="ttl"><a href="/product-category/interior">Interior Paint</a></div>
                        <div class="desc"></div>
                    </div>
                </div>
            </div>
            <!--             <div class="center-bx row-bx">
                <div class="widget-box" style="background-image: url('img/p3.png'); background-size: cover; background-repeat: no-repeat; background-position: center center;">
                    <div class="color-desc dark-blue">
                        <div class="ttl">brands</div>
                        <div class="desc"></div>
                    </div>
                </div>
            </div> -->
            <div class="align-bx row-bx">
                <div class="widget-box" style="background-image: url('img/p1.png'); background-size: cover; background-repeat: no-repeat; background-position: center center;">
                    <div class="color-desc blue-green">
                        <div class="ttl"><a href="/product-category/exterior">exterior paint</a></div>
                        <div class="desc"></div>
                    </div>
                </div>
                <div class="widget-box" style="background-image: url('img/industrial.jpg'); background-size: cover; background-repeat: no-repeat; background-position: center center;">
                    <div class="color-desc orange">
                        <div class="ttl"><a href="/product-category/industrial">Industrial Paint</a></div>
                        <div class="desc"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection