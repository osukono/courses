@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.content.trash') }}
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
                            <th class="col"></th>
                            <th class="text-right col-auto">Deleted</th>
                            <th class="col-auto">By</th>
                            <th class="col-auto"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($contents as $content)
                            <tr>
                                <td class="text-nowrap">{{ $content }}</td>
                                <td class="text-nowrap text-right">{{ $content->deleted_at->diffForHumans() }}</td>
                                <td class="text-nowrap">{{ $content->ledgers->first()->user }}</td>
                                <td class="text-right">
                                    <form class="mr-1" action="{{ route('admin.content.restore') }}" method="post">
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
