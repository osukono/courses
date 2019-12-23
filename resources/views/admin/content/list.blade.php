<table class="table">
    <thead>
    <tr>
        <th class="col-10"></th>
        <th>Lessons</th>
        <th class="text-nowrap text-right">Last Modified</th>
    </tr>
    </thead>
    <tbody>
    @foreach($contents as $content)
        <tr class="clickable-row" data-href="{{ route('admin.content.show', $content) }}">
            <td class="text-nowrap">{{ $content }}</td>
            <td>{{ $content->lessons_count }}</td>
            <td class="text-nowrap text-right">{{ $content->updated_at->diffForHumans() }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
