@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.content.editors', $content) }}
@endsection

@section('toolbar')
    @if($users->isNotEmpty())
        <div class="btn-group" role="group" aria-label="Editors">
            <a class="btn btn-info" href="#" data-toggle="modal" data-target="#usersModal">
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

    <div class="modal fade" id="usersModal" tabindex="-1" role="dialog" aria-labelledby="usersLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="usersLabel">Assign Editors</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="users" action="{{ route('admin.content.editors.assign', $content) }}"
                          method="post">
                        @csrf
                        @method('patch')
                        @select(['name' => 'user_id', 'label' => 'Users', 'options' => $users])
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-info" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-info"
                            onclick="event.preventDefault(); document.getElementById('users').submit();">
                        Assign
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
