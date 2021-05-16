<table class="table">
    <thead>
    <tr>
        <th class="col-auto"></th>
        <th class="col"></th>
        <th class="col-auto text-right text-nowrap d-none d-md-table-cell">Last Modified</th>
    </tr>
    </thead>
    <tbody id="{{ can(\App\Library\Permissions::update_content, 'sortable') }}"
           data-route="{{ route('admin.dev.exercises.move') }}">
    @foreach($exercises as $exercise)
        <tr data-sortable="{{ $exercise->id }}" class="clickable-row"
            data-href="{{ route('admin.dev.exercises.show', $exercise) }}">
            <td>{{ $exercise->index }}</td>
            <td class="last-child-mb-0">
                @includeWhen($exercise->isDisabled($content->language), 'admin.components.disabled.content')
                @foreach($exercise->exerciseData as $data)
                    @include('admin.development.exercises.data.show')
                @endforeach
            </td>
            <td class="text-nowrap text-right d-none d-md-table-cell">{{ $exercise->updated_at->diffForHumans() }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
