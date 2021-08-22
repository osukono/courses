<table class="table">
    <thead>
    <tr>
        <th></th>
        <th class="col-12"></th>
        <th class="text-end text-nowrap d-none d-md-table-cell">Last Modified</th>
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
                    @include('admin.development.exercises.data.show', ['show_info' => true])
                @endforeach
            </td>
            <td class="text-nowrap text-end d-none d-md-table-cell">{{ $exercise->updated_at->diffForHumans() }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
