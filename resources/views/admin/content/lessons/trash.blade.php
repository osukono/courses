@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.lessons.trash', $content) }}
@endsection

@section('toolbar')
    {{ $lessons->links() }}
@endsection

@section('content')
    @if($lessons->count() > 0)
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-borderless">
                        <thead>
                        <tr>
                            <th class="col-9"></th>
                            <th class="text-right">Deleted</th>
                            <th>By</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($lessons as $lesson)
                            <tr>
                                <td class="last-child-mb-0">{!! $lesson->title !!}</td>
                                <td class="text-nowrap text-right">{{ $lesson->deleted_at->diffForHumans() }}</td>
                                <td class="text-nowrap">{{ $lesson->ledgers->first()->user }}</td>
                                <td class="text-right">
                                    <form class="mr-1" action="{{ route('admin.lessons.restore') }}" method="post">
                                        @csrf
                                        <input type="hidden" id="id" name="id" value="{{ $lesson->id }}">
                                        <button type="submit" class="btn btn-link btn-sm p-0">{{ __('admin.form.restore') }}</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
@endsection
