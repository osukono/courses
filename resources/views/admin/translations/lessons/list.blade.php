<table class="table">
    <thead>
    <tr>
        <th class="col-auto"></th>
        <th class="col"></th>
        <th class="col-auto d-none d-md-table-cell">Exercises</th>
        <th class="col-auto text-right text-nowrap d-none d-md-table-cell">Last Modified</th>
    </tr>
    </thead>
    <tbody>
    @foreach($lessons as $lesson)
        <tr class="clickable-row" data-href="{{ route('admin.translations.lesson.show', [$language, $lesson]) }}">
            <td>{{ $lesson->index }}</td>
            <td>
                @includeWhen($lesson->isDisabled($content->language), 'admin.components.disabled.content')
                @includeWhen($lesson->isDisabled($language), 'admin.components.disabled.translation')
                {{ $lesson }}
            </td>
            <td class="d-none d-md-table-cell">{{ $lesson->exercises_count }}</td>
            <td class="text-nowrap text-right d-none d-md-table-cell">{{ $lesson->updated_at->diffForHumans() }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
