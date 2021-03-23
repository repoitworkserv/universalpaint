<style>
    * {
        margin: auto;
    }
    img{
        max-width: 100%;
        max-height: 100%;
        display: block; /* remove extra space below image */
    }
    .product-image { width: 200px; }
    .center {
        margin: auto;
        width: 100%;
        margin: auto;
        border-style: none;
        text-align: center;
        color: gray;
        font-family: 'Asap';

    }
    .order-details table {
        text-align: center; 
        margin: auto; 
        width: 100%;
    }
    @media (max-width: 576px) {
        html { font-size: .10px; }
        .product-image { width: 100px; }
    }
    @media (max-width: 768px) {
        html { font-size: 12px; }
    }
    @media (max-width: 992px) {
        html { font-size: 14px; }
    }
    @media (max-width: 1200px) {
        html { font-size: 16px; }

    }
    .align-text-center {
        text-align: center;
    }
</style>

<h2 class="align-text-center"></h2>
<div class="align-text-center">
<img src=""/>
</div>
<div class="order-details">
<p class="center" style="margin: auto;border-style: none;padding: 10px;text-align: center;color: gray;font-family: \'Asap\';font-size: small;">
Fullname: {{ $data['fullname'] }} <br>
Email: {{ $data['email'] }}
</p>
<p class="center" style="margin: auto;border-style: none;padding: 10px;text-align: center;color: gray;font-family: \'Asap\';font-size: small;">Powered by iTWorks Global Solutions</p>
</div>
    