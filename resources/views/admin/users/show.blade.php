@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.users.show', $user) }}
@endsection

@section('content')
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h5 class="card-title">Roles</h5>
                </div>
                <div class="col-auto text-right">
                    <v-button-modal modal="#assign-role" visible="{{ $roles->isNotEmpty() }}">
                        <template v-slot:icon>
                            <icon-plus></icon-plus>
                        </template>
                    </v-button-modal>
                </div>
            </div>
            @includeWhen($assignedRoles->isNotEmpty(), 'admin.users.assigned.roles')
        </div>
    </div>

    <div class="card shadow-sm mt-4">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h5 class="card-title">Content Access</h5>
                </div>
                <div class="col-auto text-right">
                    <v-button-modal modal="#assign-content" visible="{{ $contents->isNotEmpty() }}">
                        <template v-slot:icon>
                            <icon-plus></icon-plus>
                        </template>
                    </v-button-modal>
                </div>
            </div>
            @includeWhen($assignedContents->isNotEmpty(), 'admin.users.assigned.contents')
        </div>
    </div>

    <div class="card shadow-sm mt-4">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h5 class="card-title">Translations Access</h5>
                </div>
                <div class="col-auto text-right">
                    <v-button-modal modal="#assign-translation" visible="{{ $translations->isNotEmpty() }}">
                        <template v-slot:icon>
                            <icon-plus></icon-plus>
                        </template>
                    </v-button-modal>
                </div>
            </div>
            @includeWhen($assignedTranslations->isNotEmpty(), 'admin.users.assigned.translations')
        </div>
    </div>

    @include('admin.components.modals.select',[
    'id' => 'assign-role',
    'title' => 'Assign Role',
    'route' => route('admin.users.roles.assign', $user),
    'field' => 'role_id',
    'options' => $roles,
    'submitLabel' => 'Assign'])

    @include('admin.components.modals.select',[
    'id' => 'assign-content',
    'title' => 'Content Access',
    'route' => route('admin.users.content.access.assign', $user),
    'field' => 'content_id',
    'options' => $contents,
    'submitLabel' => 'Assign'])

    @include('admin.components.modals.select',[
    'id' => 'assign-translation',
    'title' => 'Translations Access',
    'route' => route('admin.users.translations.access.assign', $user),
    'field' => 'language_id',
    'options' => $translations,
    'submitLabel' => 'Assign'])
@endsection
