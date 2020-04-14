<table class="table">
    <thead>
    <tr>
        <th class="col-auto"></th>
        <th class="col"></th>
        <th class="col-auto d-none d-md-table-cell">Exercises</th>
        <th class="col-auto text-right text-nowrap d-none d-md-table-cell">Last Modified</th>
        @can(\App\Library\Permissions::update_content)
            <th class="col-auto"></th>
        @endcan
    </tr>
    </thead>
    <tbody id="{{ can(\App\Library\Permissions::update_content, 'sortable') }}"
           data-route="{{ route('admin.lessons.move') }}">
    @foreach($lessons as $lesson)
        <tr data-sortable="{{ $lesson->id }}" class="clickable-row"
            data-href="{{ route('admin.lessons.show', $lesson) }}">
            <td>{{ $lesson->index }}</td>
            <td>
                @includeWhen($lesson->isDisabled($content->language), 'admin.components.disabled.content')
                {{ $lesson }}
            </td>
            <td class="d-none d-md-table-cell">{{ $lesson->exercises_count }}</td>
            <td class="text-nowrap text-right d-none d-md-table-cell">{{ $lesson->updated_at->diffForHumans() }}</td>
            @can(\App\Library\Permissions::update_content)
                <td class="text-right">
                    <a href="{{ route('admin.lessons.edit', $lesson) }}">
                        <icon-edit></icon-edit>
                    </a>
                </td>
            @endcan
        </tr>
    @endforeach
    </tbody>
</table>

