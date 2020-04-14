@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.users.show', $user) }}
@endsection

@section('content')
    @if($assignedRoles->count())
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title">Roles</h5>
                    </div>
                    <div class="col text-right">
                        @if($roles->isNotEmpty())
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-info"
                                        data-toggle="modal" data-target="#assignRole">
                                    <icon-plus></icon-plus>
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
                @include('admin.users.roles')
            </div>
        </div>
    @endif

    @if($contents->count())
        <div class="card shadow-sm mt-4">
            <div class="card-body">
                <h5 class="card-title">Content Access</h5>
                <table class="table">
                    <thead>
                    <tr>
                        <th class="col"></th>
                        <th class="col-auto"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($contents as $content)
                        <tr>
                            <td>{{ $content }}</td>
                            <td>
                                <form action="{{ route('admin.content.editors.remove', $content) }}" method="post">
                                    @csrf
                                    @method('patch')
                                    <input type="hidden" id="user_id" name="user_id" value="{{ $user->id }}">
                                    <button type="submit" class="btn btn-link btn-sm">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    @if($translations->count())
        <div class="card shadow-sm mt-4">
            <div class="card-body">
                <h5 class="card-title">Translations Access</h5>
                <table class="table">
                    <thead>
                    <tr>
                        <th class="col"></th>
                        <th class="col-auto"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($translations as $translation)
                        <tr>
                            <td>{{ $translation }}</td>
                            <td>
                                <form action="{{ route('admin.translations.editors.remove', [$translation]) }}"
                                      method="post">
                                    @csrf
                                    @method('patch')
                                    <input type="hidden" id="user_id" name="user_id" value="{{ $user->id }}">
                                    <button type="submit" class="btn btn-link btn-sm">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <div class="modal" id="assignRole" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Roles</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-borderless">
                        <tbody>
                        @foreach($roles as $role)
                            <tr>
                                <td>{{ $role->name }}</td>
                                <td class="text-right">
                                    <form id="role-{{ $role->id }}->assign"
                                          action="{{ route('admin.users.roles.assign', [$user, $role]) }}" method="post"
                                          autocomplete="off">
                                        @csrf
                                        @method('patch')
                                        <input type="submit" value="Assign" class="btn btn-sm btn-link">
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
