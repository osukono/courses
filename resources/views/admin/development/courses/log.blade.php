@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.dev.courses.log', $content) }}
@endsection

@section('toolbar')
    {{ $ledgers->links() }}
@endsection

@section('content')
    @include('admin.components.ledgers')
@endsection
