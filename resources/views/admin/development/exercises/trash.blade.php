@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.dev.exercises.trash', $lesson) }}
@endsection

@section('toolbar')
    {{ $exercises->links() }}
@endsection

@section('content')
    @if($exercises->count() > 0)
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-borderless">
                        <thead>
                        <tr>
                            <th class="col"></th>
                            <th class="text-end col-auto">Deleted</th>
                            <th class="col-auto">By</th>
                            <th class="col-auto"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($exercises as $exercise)
                            <tr>
                                <td>
                                    @foreach($exercise->exerciseData as $data)
                                        @include('admin.development.exercises.data.show')
                                    @endforeach
                                </td>
                                <td class="text-nowrap text-end">{{ $exercise->deleted_at->diffForHumans() }}</td>
                                <td class="text-nowrap">{{ $exercise->ledgers->first()->user }}</td>
                                <td class="text-end">
                                    <form class="me-1" action="{{ route('admin.dev.exercises.restore') }}" method="post">
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
