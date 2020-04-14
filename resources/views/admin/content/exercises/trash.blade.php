@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.exercises.trash', $lesson) }}
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
                            <th class="text-right col-auto">Deleted</th>
                            <th class="col-auto">By</th>
                            <th class="col-auto"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($exercises as $exercise)
                            <tr>
                                <td>
                                    @foreach($exercise->exerciseData as $data)
                                        @include('admin.content.exercises.data.show')
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
