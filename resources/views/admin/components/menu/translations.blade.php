<div class="btn-group" role="group">
    <button class="btn btn-info dropdown-toggle" type="button" id="translations" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
        Translations
    </button>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="translations">
        @foreach($languages as $language)
            <a class="dropdown-item"
               href="{{ isset($arg) ? route($route, [$language, $arg]) : route($route, $language) }}">{{ $language }}</a>
        @endforeach
    </div>
</div>
