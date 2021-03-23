<table class="table">
    <thead>
    <tr>
        <th class="col"></th>
        <th class="col-auto d-none d-md-table-cell">{{ __('admin.development.courses.list.columns.title') }}</th>
        <th class="col-auto d-none d-md-table-cell">{{ __('admin.development.courses.list.columns.lessons') }}</th>
        <th class="col-auto text-nowrap text-right d-none d-md-table-cell">{{ __('admin.development.courses.list.columns.modified') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($contents as $content)
        <tr class="clickable-row" data-href="{{ route('admin.content.show', $content) }}">
            <td>{{ $content }}</td>
            <td class="text-nowrap d-none d-md-table-cell">{{ $content->title }}</td>
            <td class="d-none d-md-table-cell">{{ $content->lessons_count }}</td>
            <td class="text-nowrap text-right d-none d-md-table-cell">{{ $content->updated_at->diffForHumans() }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
