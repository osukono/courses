@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.exercises.log', $exercise) }}
@endsection

@section('toolbar')
    {{ $ledgers->links() }}
@endsection

@section('content')
    @include('admin.components.ledgers')
@endsection
