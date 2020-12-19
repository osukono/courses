<div id="apps" class="container-fluid pt-4 mb-5">
    <div class="row">
        <div class="d-none text-right pr-4 d-lg-table-cell col-lg-5">
            <img src="{{ URL::asset('/images/' . __('web.index.section.app.screen')) }}"
                 class="w-50 border rounded-lg shadow-sm" alt="Yummy Lingo's application">
        </div>
        <div class="col-10 pr-0 offset-1 pr-lg-5 col-lg-7 offset-lg-0">
            <h2 class="text-primary">{{ __('web.index.section.app.header') }}</h2>
            <div class="mt-4">{!! __('web.index.section.app.description') !!}</div>
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
