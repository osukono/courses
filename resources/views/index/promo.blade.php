<div class="container-fluid" style="background-color: #D9DFF6;">
    <div class="container">
        <div class="row py-3">
            <div class="col-12 col-md-8 text-center align-self-center">
                <h5 class="text-primary mb-0">
                    {{ __('web.index.section.promo.text', ['number' => number_format($users_count, 0, ",", " ")]) }}
                </h5>
            </div>
            <div class="col-12 text-center pt-3 ps-0 pe-0 col-md-4 pt-md-0 pe-md-5">
                <a class="btn btn-primary btn-lg rounded-pill shadow-sm text-uppercase" target="_blank"
                   rel="noopener" href="{{ route('download') }}">{{ __('web.index.section.promo.button') }}</a>
            </div>
        </div>
    </div>
</div>
