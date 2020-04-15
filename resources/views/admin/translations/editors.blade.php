@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.translations.editors', $language, $content) }}
@endsection

@section('toolbar')
    <v-button-group>
        <v-button-modal modal="#assign-editor" visible="{{ $users->isNotEmpty() }}">
            <template v-slot:icon>
                <icon-plus></icon-plus>
            </template>
        </v-button-modal>
    </v-button-group>
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
                                          action="{{ route('admin.translations.editors.remove', [$language]) }}"
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
    'route' => route('admin.translations.editors.assign', [$language, $content]),
    'field' => 'user_id',
    'options' => $users,
    'submitLabel' => 'Assign'])
@endsection
