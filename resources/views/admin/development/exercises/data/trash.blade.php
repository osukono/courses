@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.dev.exercise.data.trash', $exercise) }}
@endsection

@section('toolbar')
    {{ $exerciseData->links() }}
@endsection

@section('content')
    @if($exerciseData->count() > 0)
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-borderless">
                        <thead>
                        <tr>
                            <th class="col-12"></th>
                            <th class="text-end">Deleted</th>
                            <th>By</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($exerciseData as $data)
                            <tr>
                                <td class="last-child-mb-0">
                                    @include('admin.development.exercises.data.show')
                                </td>
                                <td class="text-nowrap text-end">{{ $data->deleted_at->diffForHumans() }}</td>
                                <td class="text-nowrap">{{ $data->ledgers->first()->user }}</td>
                                <td class="text-end">
                                    <form class="me-1" action="{{ route('admin.dev.exercise.data.restore') }}" method="post">
                                        @csrf
                                        <input type="hidden" id="id" name="id" value="{{ $data->id }}">
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
