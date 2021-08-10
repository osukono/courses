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
                <div class="col-auto text-end">
                    <v-button-modal modal="#assign-role" enabled="{{ $roles->isNotEmpty() }}">
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
                    <h5 class="card-title">Course Access</h5>
                </div>
                <div class="col-auto text-end">
                    <v-button-modal modal="#assign-content" enabled="{{ $contents->isNotEmpty() }}">
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
                <div class="col-auto text-end">
                    <v-button-modal modal="#assign-translation" enabled="{{ $translations->isNotEmpty() }}">
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
    'label' => 'Role',
    'route' => route('admin.users.roles.assign', $user),
    'field' => 'role_id',
    'options' => $roles,
    'submitLabel' => 'Assign'])

    @include('admin.components.modals.select',[
    'id' => 'assign-content',
    'title' => 'Course Access',
    'label' => 'Course',
    'route' => route('admin.users.content.access.assign', $user),
    'field' => 'content_id',
    'options' => $contents,
    'submitLabel' => 'Assign'])

    @include('admin.components.modals.select',[
    'id' => 'assign-translation',
    'title' => 'Translations Access',
    'label' => 'Language',
    'route' => route('admin.users.translations.access.assign', $user),
    'field' => 'language_id',
    'options' => $translations,
    'submitLabel' => 'Assign'])
@endsection
