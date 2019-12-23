<a class="btn btn-info{{ isset($route) ? '' : ' disabled' }}" href="{{ isset($route) ? $route : '#' }}"
   data-toggle="tooltip" data-title="{{ __('pagination.previous') }}">
    @include('admin.components.svg.chevron-left')
</a>
