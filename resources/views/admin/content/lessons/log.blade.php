@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.lessons.log', $lesson) }}
@endsection

@section('toolbar')
    {{ $ledgers->links() }}
@endsection

@section('content')
    @include('admin.components.ledgers')
@endsection
