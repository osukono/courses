<table class="table">
    <thead>
    <tr>
        <th class="col-9"></th>
        <th>Title</th>
        <th style="min-width: 25em;">Description</th>
        <th>Lessons</th>
        <th class="text-nowrap text-right">Last Modified</th>
    </tr>
    </thead>
    <tbody>
    @foreach($contents as $content)
        <tr class="clickable-row" data-href="{{ route('admin.content.show', $content) }}">
            <td class="text-nowrap">{{ $content }}</td>
            <td class="text-nowrap">{{ $content->title }}</td>
            <td>{{ $content->description }}</td>
            <td>{{ $content->lessons_count }}</td>
            <td class="text-nowrap text-right">{{ $content->updated_at->diffForHumans() }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
