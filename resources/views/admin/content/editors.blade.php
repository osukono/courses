@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.content.editors', $content) }}
@endsection

@section('toolbar')
    @if($users->isNotEmpty())
        <div class="btn-group" role="group" aria-label="Editors">
            <a class="btn btn-info" href="#" data-toggle="modal" data-target="#assign-editor">
                <icon-plus></icon-plus>
            </a>
        </div>
    @endif
@endsection

@section('content')
    @if($editors->count())
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Roles</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($editors as $editor)
                            <tr>
                                <td>{{ $editor->name }}</td>
                                <td>{{ $editor->roles->implode('name', ', ') }}</td>
                                <td class="text-right">
                                    <form class="mr-1"
                                          action="{{ route('admin.content.editors.remove', $content) }}"
                                          method="post">
                                        @csrf
                                        @method('patch')
                                        <input type="hidden" id="user_id" name="user_id" value="{{ $editor->id }}">
                                        <button type="submit" class="btn btn-link btn-sm">Remove</button>
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

    @include('admin.components.modals.select',[
    'id' => 'assign-editor',
    'title' => 'Assign Editor',
    'route' => route('admin.content.editors.assign', $content),
    'field' => 'user_id',
    'options' => $users,
    'submitLabel' => 'Assign'])
@endsection
