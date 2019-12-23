@extends('layouts.app')

@section('content')
    <div class="col-lg-8 offset-lg-2">
        <course-player
            title="{{ $title }}"
            review="{{ json_encode($review) }}"
            storage-url="{{ Storage::url('.') }}"
            localization="{{ json_encode($locale) }}"
        >
        </course-player>
    </div>
@endsection
