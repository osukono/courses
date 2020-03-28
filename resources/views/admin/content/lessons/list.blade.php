<table class="table">
    <thead>
    <tr>
        <th></th>
        <th class="col-{{ (Auth::getUser()->can(\App\Library\Permissions::update_content)) ? '8' : '9'}}"></th>
        <th>Exercises</th>
        <th class="text-right text-nowrap">Last Modified</th>
        @can(\App\Library\Permissions::update_content)
            <th></th>
        @endcan
    </tr>
    </thead>
    <tbody id="sortable">
    @foreach($lessons as $lesson)
        <tr data-id="{{ $lesson->id }}">
            <td>{{ $lesson->index }}</td>
            <td class="text-nowrap clickable-row"
                data-href="{{ route('admin.lessons.show', $lesson) }}">
                @if($lesson->isDisabled($content->language))
                    <span class="badge badge-warning text-uppercase">Disabled</span>
                @endif
                {{ $lesson }}
            </td>
            <td>{{ $lesson->exercises_count }}</td>
            <td class="text-nowrap text-right">{{ $lesson->updated_at->diffForHumans() }}</td>
            <td class="text-right">
                @can(\App\Library\Permissions::update_content)
                    <div class="text-nowrap">
                        <a href="{{ route('admin.lessons.edit', $lesson) }}">
                            @include('admin.components.svg.edit')
                        </a>
                    </div>
                @endcan
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

@includeWhen(\App\Library\Permissions::update_content, 'admin.components.sortable', ['route' => route('admin.lessons.move')])
