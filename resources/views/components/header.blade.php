<div style="background-color: #F9F8F8; top: -65px; margin-bottom: -65px;" class="position-relative">
    <img src="{{ $header_img }}" class="w-100 position-relative d-md-block d-none" alt=""
         style="right: 0;">
    <img src="{{ $header_img_sm }}" class="w-100 position-relative d-md-none" alt=""
         style="right: 0;">
    <div class="w-100 position-absolute align-self-center d-md-block d-none"
         style="top: 35%;">
        <div class="container px-5">
            <div class="col-md-7 offset-md-0 col-10 offset-1 p-3 rounded text-center"
                 style="background-color: rgba(255, 255, 255, 0.4); border: 1px solid rgba(128, 128, 128, 0.2)">
                <h2 class="text-primary">{{ $header_title }}</h2>
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
