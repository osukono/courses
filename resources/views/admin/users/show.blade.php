@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.users.show', $user) }}
@endsection

@section('toolbar')
    @if($roles->isNotEmpty())
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-info"
                    data-toggle="modal" data-target="#assignRole">
                <icon-plus></icon-plus>
            </button>
        </div>
    @endif
@endsection

@section('content')
    @if($assignedRoles->count())
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Roles</h5>
                @include('admin.users.roles')
            </div>
        </div>
    @endif

    <div class="modal" id="assignRole" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $user }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
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
