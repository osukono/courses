@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.exercise.data.trash', $exercise) }}
@endsection

@section('toolbar')
    {{ $exerciseData->links() }}
@endsection

@section('content')
    @if($exerciseData->count() > 0)
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
                @foreach($exerciseData as $data)
                    <tr>
                        <td class="last-child-mb-0">
                            @include('admin.content.exercises.data.show')
                        </td>
                        <td class="text-nowrap text-right">{{ $data->deleted_at->diffForHumans() }}</td>
                        <td class="text-nowrap">{{ $data->ledgers->first()->user }}</td>
                        <td class="text-right">
                            <form class="mr-1" action="{{ route('admin.exercise.data.restore') }}" method="post">
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
    @endif
@endsection