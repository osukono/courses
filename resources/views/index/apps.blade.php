<div id="apps" class="container pt-4 mb-5">
    <div class="row">
        <div class="d-none col-5 text-center d-lg-table-cell">
            <img src="{{ URL::asset('/images/' . __('web.index.section.app.screen')) }}"
                 class="w-50 border rounded shadow" alt="Yummy Lingo's application">
        </div>
        <div class="col-10 offset-1 text-center col-lg-7 offset-lg-0 text-md-left">
            <h1 class="text-primary">{{ __('web.index.section.app.header') }}</h1>
            <div class="lead mt-4">{!! __('web.index.section.app.description') !!}</div>
            <div class="mt-4 text-center text-md-left">
                <a href="{{ __('web.index.section.app.links.android') }}" target="_blank">
                    <img src="{{ URL::asset('images/' . __('web.index.section.app.badges.google_play.image')) }}"
                         alt="{{ __('web.index.section.app.badges.google_play.alt') }}"
                         width="148" height="44"
                         class="mr-2"
                    >
                </a>
                <a href="{{ __('web.index.section.app.links.ios') }}" target="_blank">
                    <img src="{{ URL::asset('images/' . __('web.index.section.app.badges.app_store.image')) }}"
                         alt="{{ __('web.index.section.app.badges.app_store.alt') }}"
                         width="131.630477" height="44"
                    >
                </a>
            </div>
        </div>
    </div>
</div>
