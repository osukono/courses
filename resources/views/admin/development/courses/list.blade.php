<table class="table">
    <thead>
    <tr>
        <th class="col-12"></th>
        <th class="d-none d-md-table-cell">{{ __('admin.dev.courses.list.columns.title') }}</th>
        <th class="d-none d-md-table-cell">{{ __('admin.dev.courses.list.columns.lessons') }}</th>
        <th class="text-nowrap text-end d-none d-md-table-cell">{{ __('admin.dev.courses.list.columns.modified') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($contents as $content)
        <tr class="clickable-row" data-href="{{ route('admin.dev.courses.show', $content) }}">
            <td>{{ $content }}</td>
            <td class="text-nowrap d-none d-md-table-cell">{{ $content->title }}</td>
            <td class="d-none d-md-table-cell">{{ $content->lessons_count }}</td>
            <td class="text-nowrap text-end d-none d-md-table-cell">{{ $content->updated_at->diffForHumans() }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
