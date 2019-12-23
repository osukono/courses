<table class="table">
    <thead>
    <tr>
        <th class="col-8"></th>
        <th>Lessons</th>
        <th>Price</th>
        <th>Published</th>
        <th class="text-nowrap">Last Committed</th>
    </tr>
    </thead>
    <tbody>
    @foreach($courses as $course)
        <tr class="clickable-row" data-href="{{ route('admin.courses.show', $course) }}">
            <td class="text-nowrap">{{ $course }}</td>
            <td>{{ $course->latestContent->course_lessons_count }} / {{ $course->demo_lessons }}</td>
            <td>
                {{ $course->free ? 'Free' : $course->price }}
            </td>
            <td>
                @includeWhen($course->published, 'admin.components.svg.check')
            </td>
            <td class="text-nowrap text-right">
                @if($course->latestContent != null)
                    {{ $course->latestContent->updated_at->diffForHumans() }}
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
