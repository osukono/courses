@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.users.show', $user) }}
@endsection

@section('toolbar')
    <div class="btn-group" role="group">
        <button type="button" class="btn btn-info"
           data-toggle="modal" data-target="#assignRole">
            @include('admin.components.svg.plus')
        </button>
    </div>
@endsection

@section('content')
    @includeWhen($assignedRoles->count(), 'admin.users.roles')

    <div class="modal" id="assignRole" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Assign role to {{ $user }}</h5>
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
                                    <form id="role-{{ $role->id }}->assign" action="{{ route('admin.users.roles.assign', [$user, $role]) }}" method="post" autocomplete="off">
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
