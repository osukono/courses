<table class="table">
    <thead>
    <tr>
        <th class="col-auto"></th>
        <th class="col"></th>
        <th class="col-auto text-right text-nowrap d-none d-md-table-cell">Last Modified</th>
    </tr>
    </thead>
    <tbody id="{{ Auth::getUser()->can(\App\Library\Permissions::update_content) ? 'sortable' : '' }}" data-route="{{ route('admin.exercises.move') }}">
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
            <td class="text-nowrap text-right d-none d-md-table-cell">{{ $exercise->updated_at->diffForHumans() }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
