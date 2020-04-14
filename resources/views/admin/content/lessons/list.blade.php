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
    <tbody id="{{ Auth::getUser()->can(\App\Library\Permissions::update_content) ? 'sortable' : '' }}"
           data-route="{{ route('admin.lessons.move') }}">
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
                        <i data-feather="edit"></i>
                    </a>
                </td>
            @endcan
        </tr>
    @endforeach
    </tbody>
</table>

