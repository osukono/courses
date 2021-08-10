<table class="table">
    <thead>
    <tr>
        <th></th>
        <th class="col-12"></th>
        <th class="d-none d-md-table-cell">Exercises</th>
        <th class="text-end text-nowrap d-none d-md-table-cell">Last Modified</th>
    </tr>
    </thead>
    <tbody>
    @foreach($lessons as $lesson)
        <tr class="clickable-row" data-href="{{ route('admin.translations.lessons.show', [$language, $lesson]) }}">
            <td>{{ $lesson->index }}</td>
            <td>
                @includeWhen($lesson->isDisabled($content->language), 'admin.components.disabled.content')
                @includeWhen($lesson->isDisabled($language), 'admin.components.disabled.translation')
                {{ $lesson }}
            </td>
            <td class="d-none d-md-table-cell">{{ $lesson->exercises_count }}</td>
            <td class="text-nowrap text-end d-none d-md-table-cell">{{ $lesson->updated_at->diffForHumans() }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
