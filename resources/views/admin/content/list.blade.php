<table class="table">
    <thead>
    <tr>
        <th class="col-12 col-md-9"></th>
        <th class="d-none d-md-table-cell">Title</th>
        <th class="d-none d-md-table-cell">Lessons</th>
        <th class="text-nowrap text-right d-none d-md-table-cell">Last Modified</th>
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
