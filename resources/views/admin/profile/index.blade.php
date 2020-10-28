@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.user.profile', $user) }}
@endsection

@section('toolbar')
    <button type="button" class="btn btn-outline-info" onclick="$('#logout-form').submit()">Logout</button>
    <form id="logout-form" action="{{ route('logout') }}" method="post">
        @csrf
    </form>
@endsection

@section('content')
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title mb-4">Change Profile Information</h5>

            <form action="{{ route('admin.profile.update') }}" method="post">
                @csrf
                @method('patch')

                @input(['name' => 'name', 'label' => 'Name', 'default' => $user->name])
                @input(['name' => 'email', 'label' => 'Email', 'default' => $user->email])

                @submit(['text' => 'Update Profile'])
            </form>
        </div>
    </div>

    <div class="card shadow-sm mt-4">
        <div class="card-body">
            <h5 class="card-title mb-4">Change Password</h5>

            <form action="{{ route('admin.profile.password.update') }}" method="post">
                @csrf
                @method('patch')

                @input(['type' => 'password', 'name' => 'old_password', 'label' => 'Current Password'])
                @input(['type' => 'password', 'name' => 'new_password', 'label' => 'New Password'])
                @input(['type' => 'password', 'name' => 'new_password_confirmation', 'label' => 'Confirm Password'])

                @submit(['text' => 'Update Password'])
            </form>
        </div>
    </div>
@endsection
