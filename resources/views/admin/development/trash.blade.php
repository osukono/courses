@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.dev.courses.trash') }}
@endsection

@section('toolbar')
    {{ $contents->links() }}
@endsection

@section('content')
    @if($contents->count() > 0)
        <div class="card shadow-sm">
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
                        @foreach($contents as $content)
                            <tr>
                                <td class="text-nowrap">{{ $content }}</td>
                                <td class="text-nowrap text-end">{{ $content->deleted_at->diffForHumans() }}</td>
                                <td class="text-nowrap">{{ $content->ledgers->first()->user }}</td>
                                <td class="text-end">
                                    <form class="me-1" action="{{ route('admin.dev.courses.restore') }}" method="post">
                                        @csrf
                                        <input type="hidden" id="id" name="id" value="{{ $content->id }}">
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
