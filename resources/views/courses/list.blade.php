@foreach($courses as $course)
    <div class="card mb-3 border-0">
        <div class="card-body">
            <div class="card-title">
                <h5>
                    {{ $course->language . ' ' . $course->level }}
                    @if($course->free)
                        <span class="badge badge-success ml-2">{{ __('Free') }}</span>
                    @endif
                </h5>
            </div>
            <p class="card-text">{{ $course->description }}</p>
            <a href="{{ route('courses.practice', $course) }}" class="btn btn-outline-primary">{{ __('Practice') }}</a>
        </div>
    </div>
@endforeach
