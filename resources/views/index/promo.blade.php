<div class="container-fluid" style="background-color: #D9DFF6;">
    <div class="container">
        <div class="row py-3">
            <div class="col-12 col-md-8 text-center align-self-center">
                <h4 class="text-primary mb-0">
                    {{ __('web.index.section.promo.text', ['course' => $courses->first()->language->native . ' › ' . $courses->first()->title]) }}
                </h4>
            </div>
            <div class="col-12 text-center pt-3 pl-0 pr-0 col-md-4 pt-md-0 pr-md-5">
                <a class="btn btn-primary btn-lg rounded-pill shadow-sm" target="_blank"
                   href="{{ route('download') }}">{{ __('web.index.section.promo.button') }}</a>
            </div>
        </div>
    </div>
</div>
