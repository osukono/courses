<table class="table">
    <thead>
    <tr>
        <th></th>
        <th class="col-12 col-md-9"></th>
        <th class="d-none d-md-table-cell">Exercises</th>
        <th class="text-right text-nowrap d-none d-md-table-cell">Last Modified</th>
    </tr>
    </thead>
    <tbody>
    @foreach($lessons as $lesson)
        <tr>
            <td>{{ $lesson->index }}</td>
            <td class="clickable-row"
                data-href="{{ route('admin.translations.lesson.show', [$language, $lesson]) }}">
                @if($lesson->isDisabled($content->language))
                    <span class="badge badge-warning text-uppercase">Disabled</span>
                @endif
                @if($lesson->isDisabled($language))
                    <span class="badge badge-light text-uppercase">Disabled</span>
                @endif
                {{ $lesson }}
            </td>
            <td class="d-none d-md-table-cell d-none d-md-table-cell">{{ $lesson->exercises_count }}</td>
            <td class="text-nowrap text-right d-none d-md-table-cell">{{ $lesson->updated_at->diffForHumans() }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
