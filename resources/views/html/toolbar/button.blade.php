<a class="btn btn-info"
   @isset($links) href="{{ $links }}" @else href="#" @endisset
   @isset($tooltip) data-toggle="tooltip" data-title="{{ $tooltip }}" @endisset
   @isset($submits) onclick="$('#{{ $submits->id() }}').submit();" @endisset
>
    @includeWhen(isset($icon), 'admin.components.svg.' . $icon)
    @isset($label) {{ $label }} @endisset
</a>
@isset($submits)
    {!! $submits->render() !!}
@endisset
