@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.content.index') }}
@endsection

@section('toolbar')
    {!! $toolbar->render() !!}
@endsection

@section('content')
    @if($contents->count())
        @include('admin.content.list')
    @endif
@endsection
