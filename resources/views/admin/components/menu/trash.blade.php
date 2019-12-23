<a class="btn btn-info" href="{{ $route }}"
   data-toggle="tooltip" data-title="{{ __('admin.menu.trash') }}">
    @if($trashed > 0)
        @include('admin.components.svg.trash-2')
    @else
        @include('admin.components.svg.trash')
    @endif
</a>
