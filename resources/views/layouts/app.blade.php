<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="{{ __('web.html.seo.keywords') }}">
    <meta name="description" content="{{ __('web.html.seo.description') }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($htmlTitle) ? $htmlTitle : config('app.name', 'Yummy Lingo') }}</title>

    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">

    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <script src="{{ mix('js/app.js') }}" async defer></script>
    <script src="{{ mix('js/vue.js') }}" async defer></script>
</head>
<body class="d-flex flex-column h-100">
<header>
    <nav class="navbar navbar-expand-md navbar-light">
        <div class="container mt-2 mb-2" style="z-index: 100;">
            <a class="navbar-brand" href="{{ route('welcome') }}">
                <img src="{{ URL::to('/') }}/images/brand_header.svg" alt="Yummy Lingo">
            </a>

            <div>
                <ul class="navbar-nav ml-auto">
                    <a class="btn btn-lg btn-outline-primary rounded-pill"
                       href="https://play.google.com/store/apps/details?id=com.yummylingo.app"
                       target="_blank">{{ __('web.header.download') }}</a>
                </ul>
            </div>
        </div>
    </nav>
</header>

<main role="main" class="flex-shrink-0">
    @yield('content')
</main>

<footer class="footer mt-auto py-3">
    <div class="container">
        <div class="row mt-4">
            <div class="col-12 text-center col-md-6 text-md-left">
                <div class="row mb-4">
                    <div class="col">
                        <img src="{{ URL::asset('images/brand_footer.svg') }}" alt="Yummy Lingo" width="169"
                             height="25">
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <a href="https://play.google.com/store/apps/details?id=com.yummylingo.app" target="_blank"><img
                                src="{{ URL::asset('images/google_play.svg') }}" alt="Google Play" width="148"
                                height="44"></a>
                        <img class="ml-1" src="{{ URL::asset('images/app_store.svg') }}" alt="App Store" width="148"
                             height="44">
                    </div>
                </div>
            </div>
            <div class="col-12 text-center pt-5 col-md-6 text-md-left pt-md-0">
                <div class="row">
                    <div class="col">
                        <h5 class="text-white mb-3">{{ __('web.footer.contact_us') }}</h5>
                        <div>support@yummylingo.com</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-12 order-2 col-md-8 order-md-1">
                <div class="row">
                    <div class="col-12 text-center order-2 mt-3 col-md-auto text-md-left order-md-1 mt-md-0">
                        <span class="text-nowrap">
                            {{ __('web.footer.copyright', ['year' => now()->year]) }}
                        </span>
                    </div>
                    <div class="col-12 text-center order-1 mt-3 col-md text-md-left order-md-2 mt-md-0">
                        <a href="{{ route('privacy') }}"
                           class="font-weight-bold text-white text-nowrap">{{ __('web.footer.privacy') }}</a>
                    </div>
                </div>
            </div>
            <div class="col-12 text-center order-1 mt-3 col-md-4 text-md-right order-md-2 mt-md-0">
                <img class="mr-2" src="{{ URL::asset('images/globe.svg') }}" alt="Languages" width="20" height="20">
                <span class="align-middle text-nowrap">
                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                        <a rel="alternate"
                           class="@if(LaravelLocalization::getCurrentLocale() == $localeCode) text-white font-weight-bold @endif text-uppercase text-decoration-none"
                           style="color: #D9DFF6" hreflang="{{ $localeCode }}"
                           href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                        {{ $localeCode }}
                    </a>
                        @if (! $loop->last) / @endif
                    @endforeach
                </span>
            </div>
        </div>
    </div>
</footer>

@stack('scripts')

</body>
</html>
