@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.content.index') }}
@endsection

@section('toolbar')
    {!! $toolbar->render() !!}
@endsection

@section('content')
    @if($contents->count())
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Content</h5>
                @include('admin.content.list')
            </div>
        </div>
    @endif
@endsection
