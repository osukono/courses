@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.users.index') }}
@endsection

@section('content')
    @includeWhen($users->count(), 'admin.users.list')
@endsection
