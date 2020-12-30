<div id="apps" class="container-fluid pt-4 mb-5">
    <div class="row">
        <div class="d-none pr-4 d-lg-table-cell col-lg-3 offset-1">
            <div id="screens" class="carousel slide carousel-fade float-right border rounded-lg shadow-sm"
                 data-ride="carousel" style="max-width: 278px">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{ URL::asset('/images/' . __('web.index.section.app.screen.library')) }}"
                             style="max-height: 600px" class="rounded-lg"
                             alt="Library">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ URL::asset('/images/' . __('web.index.section.app.screen.course')) }}"
                             style="max-height: 600px" class="rounded-lg"
                             alt="Course">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ URL::asset('/images/' . __('web.index.section.app.screen.player')) }}"
                             style="max-height: 600px" class="rounded-lg"
                             alt="Player">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-10 offset-1 col-lg-7 offset-lg-0 rounded-lg border-light py-4 px-lg-4 py-3"
             style="background-color: #fafafb">
            <h2 class="text-primary">{{ __('web.index.section.app.header') }}</h2>
            <div class="mt-4">{!! __('web.index.section.app.description') !!}</div>
            <div class="mt-4 text-center text-md-left">
                <a href="{{ __('web.index.section.app.links.android') }}" target="_blank">
                    <img src="{{ URL::asset('images/' . __('web.index.section.app.badges.google_play.image')) }}"
                         alt="{{ __('web.index.section.app.badges.google_play.alt') }}"
                         width="148" height="44" class="mr-2 mb-2"
                    >
                </a>
                <a href="{{ __('web.index.section.app.links.ios') }}" target="_blank">
                    <img src="{{ URL::asset('images/' . __('web.index.section.app.badges.app_store.image')) }}"
                         alt="{{ __('web.index.section.app.badges.app_store.alt') }}"
                         width="131.630477" height="44" class="mr-2 mb-2"
                    >
                </a>
            </div>
        </div>
    </div>
</div>
