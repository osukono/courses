@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.exercises.trash', $lesson) }}
@endsection

@section('toolbar')
    {{ $exercises->links() }}
@endsection

@section('content')
    @if($exercises->count() > 0)
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
                        @foreach($exercises as $exercise)
                            <tr>
                                <td>
                                    @foreach($exercise->exerciseFields as $exerciseField)
                                        @include('admin.content.exercises.fields.show')
                                    @endforeach
                                </td>
                                <td class="text-nowrap text-right">{{ $exercise->deleted_at->diffForHumans() }}</td>
                                <td class="text-nowrap">{{ $exercise->ledgers->first()->user }}</td>
                                <td class="text-right">
                                    <form class="mr-1" action="{{ route('admin.exercises.restore') }}" method="post">
                                        @csrf
                                        <input type="hidden" id="id" name="id" value="{{ $exercise->id }}">
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
