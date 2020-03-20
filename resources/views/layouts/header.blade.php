<div style="background-color: #F9F8F8" class="d-inline-flex">
    <img src="{{ $header_img }}" class="w-100 position-relative d-md-block d-none"
         style="right: 0; margin-top: -65px;">
    <img src="{{ $header_img_sm }}" class="w-100 position-relative d-md-none"
         style="right: 0; margin-top: -25px; padding-bottom: -300px;">
    <div class="w-100 position-absolute align-self-center pb-lg-5 pb-md-3 d-md-block d-none"
         style="margin-top: -35px;">
        <div class="container">
            <div class="col-md-6 offset-md-0 col-10 offset-1">
                <h1 class="text-primary">{{ $header_title }}</h1>
                <div class="lead">{{ $header_text }}</div>
                <a class="btn btn-primary btn-lg rounded-pill mt-4 shadow-sm"
                   href="{{ $header_button_link }}">{{ $header_button_caption }}</a>
            </div>
        </div>
    </div>
</div>
<div class="container d-block d-md-none text-center mb-5" style="margin-top: -30px;">
    <div class="row">
        <div class="col-10 offset-1">
            <h1 class="text-primary">{{ $header_title }}</h1>
            <div class="lead">{{ $header_text }}</div>
            <a class="btn btn-primary btn-lg rounded-pill mt-4 shadow-sm"
               href="{{ $header_button_link }}">{{ $header_button_caption }}</a>
        </div>
    </div>
</div>
<div class="container-fluid d-block d-md-none">
    <hr>
</div>
