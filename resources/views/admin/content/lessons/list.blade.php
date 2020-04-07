<table class="table">
    <thead>
    <tr>
        <th></th>
        <th class="col-{{ (Auth::getUser()->can(\App\Library\Permissions::update_content)) ? '10' : '11'}} col-md-{{ (Auth::getUser()->can(\App\Library\Permissions::update_content)) ? '8' : '9'}}"></th>
        <th class="d-none d-md-table-cell">Exercises</th>
        <th class="text-right text-nowrap d-none d-md-table-cell">Last Modified</th>
        @can(\App\Library\Permissions::update_content)
            <th></th>
        @endcan
    </tr>
    </thead>
    <tbody id="sortable">
    @foreach($lessons as $lesson)
        <tr data-id="{{ $lesson->id }}">
            <td>{{ $lesson->index }}</td>
            <td class="clickable-row"
                data-href="{{ route('admin.lessons.show', $lesson) }}">
                @if($lesson->isDisabled($content->language))
                    <span class="badge badge-warning text-uppercase">Disabled</span>
                @endif
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

@includeWhen(\App\Library\Permissions::update_content, 'admin.components.sortable', ['route' => route('admin.lessons.move')])
