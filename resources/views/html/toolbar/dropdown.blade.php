<div class="btn-group" role="group">
    <button class="btn btn-info dropdown-toggle" type="button" id="more" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
        @includeWhen(isset($icon), 'admin.components.svg.' . $icon)
        @isset($label) $label @endisset
    </button>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="more">
        {{ $items }}
    </div>
</div>
