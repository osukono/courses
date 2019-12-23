<a href="#" data-location="{{ Storage::url($audio) }}"
   onclick="event.stopPropagation(); play($(this), event); return false;"
>@include('admin.components.svg.play')</a>
