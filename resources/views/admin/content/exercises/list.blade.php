<table class="table">
    <thead>
    <tr>
        <th></th>
        <th class="col-{{ (Auth::getUser()->can(\App\Library\Permissions::update_content)) ? '10' : '11' }}"></th>
        <th class="text-right text-nowrap">Last Modified</th>
    </tr>
    </thead>
    <tbody id="sortable">
    @foreach($exercises as $exercise)
        <tr data-id="{{ $exercise->id }}">
            <td>{{ $exercise->index }}</td>
            <td class="clickable-row last-child-mb-0"
                data-href="{{ route('admin.exercises.show', $exercise) }}">
                @if($exercise->isDisabled($content->language))
                    <div>
                        <span class="badge badge-warning text-uppercase">Disabled</span>
                    </div>
                @endif
                @foreach($exercise->exerciseData as $data)
                    @include('admin.content.exercises.data.show')
                @endforeach
            </td>
            <td class="text-nowrap text-right">{{ $exercise->updated_at->diffForHumans() }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

@includeWhen(\App\Library\Permissions::update_content, 'admin.components.sortable', ['route' => route('admin.exercises.move')])
