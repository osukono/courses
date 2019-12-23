@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.courses.index') }}
@endsection

@section('content')
    @includeWhen($courses->count() > 0, 'admin.courses.list')
@endsection
