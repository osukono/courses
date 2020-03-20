<table class="table">
    <thead>
    <tr>
        <th class="col-9"></th>
        <th>Lessons</th>
        <th class="text-nowrap text-right">Committed</th>
        <th class="text-nowrap text-right">Status</th>
        <th>Firebase ID</th>
    </tr>
    </thead>
    <tbody>
    @foreach($courses as $course)
        <tr class="clickable-row" data-href="{{ route('admin.courses.show', $course) }}">
            <td class="text-nowrap">{{ $course }}</td>
            <td>{{ $course->course_lessons_count }}</td>
            <td class="text-nowrap text-right">
                @isset($course->committed_at)
                    {{ $course->committed_at->diffForHumans() }}
                @endisset
            </td>
            <td class="text-nowrap text-right">
                @isset($course->firebase_id)
                    @if($course->is_updating)
                        Updating
                    @else
                        @isset($course->uploaded_at)
                            {{ 'Published ' . $course->uploaded_at->diffForHumans() }}
                        @endisset
                    @endif
                @else
                    New
                @endisset
            </td>
            <td>
                {{ $course->firebase_id }}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
