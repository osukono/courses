@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.users.index') }}
@endsection

@section('toolbar')
    <v-button-group>
        <v-button tooltip="Create User"
                  route="{{ route('admin.users.create') }}"
                  visible="{{ Auth::getUser()->can(\App\Library\Permissions::create_users) }}">
            <template v-slot:icon>
                <icon-plus></icon-plus>
            </template>
        </v-button>
        <v-button route="{{ route('admin.firebase.users.index') }}">
            <template v-slot:label>
                Firebase
            </template>
        </v-button>
    </v-button-group>
@endsection

@section('content')
    @if($users->count())
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title mb-4">Users</h5>
                @include('admin.users.list')
            </div>
        </div>
    @endif
@endsection
