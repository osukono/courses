@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.languages.index') }}
@endsection

@section('toolbar')
    <v-button-group>
        <v-button tooltip="Create Language"
                  route="{{ route('admin.languages.create') }}">
            <template v-slot:icon>
                <icon-plus></icon-plus>
            </template>
        </v-button>
    </v-button-group>
@endsection

@section('content')
    @if($languages->count())
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title mb-4">Languages</h5>
                @include('admin.languages.list')
            </div>
        </div>
    @endif
@endsection
