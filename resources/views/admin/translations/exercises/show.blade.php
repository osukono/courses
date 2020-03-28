@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.translations.exercise.show', $language, $exercise) }}
@endsection

@section('toolbar')
    <div class="d-flex">
        <div class="btn-group" role="group">
            @isset($previous)
                @include('admin.components.menu.previous', ['route' => route('admin.translations.exercise.show', [$language, $previous])])
            @endisset

            @isset($next)
                @include('admin.components.menu.next', ['route' => route('admin.translations.exercise.show', [$language, $next])])
            @endisset
        </div>

        <div class="btn-group ml-2" role="group">
            @can(\App\Library\Permissions::update_translations)
                <div class="btn-group" role="group">
                    <button class="btn btn-info dropdown-toggle" type="button" id="more" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                        @include('admin.components.svg.more-vertical')
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="more">
                        @if($exercise->isDisabled($language))
                            <button class="dropdown-item" type="button" id="enable"
                                    onclick="$('#exercise-{{ $exercise->id }}-enable').submit();">
                                Enable
                            </button>
                            <form class="d-none" id="exercise-{{ $exercise->id }}-enable"
                                  action="{{ route('admin.translations.exercise.enable', [$language, $exercise]) }}"
                                  method="post">
                                @method('patch')
                                @csrf
                            </form>
                        @else
                            <button class="dropdown-item" type="button" id="disable"
                                    onclick="$('#exercise-{{ $exercise->id }}-disable').submit();">
                                Disable
                            </button>
                            <form class="d-none" id="exercise-{{ $exercise->id }}-disable"
                                  action="{{ route('admin.translations.exercise.disable', [$language, $exercise]) }}"
                                  method="post">
                                @method('patch')
                                @csrf
                            </form>
                        @endif
                    </div>
                </div>
            @endif

            @can($languages->isNotEmpty())
                @include('admin.components.menu.translations', ['route' => 'admin.translations.exercise.show', 'arg' => $exercise])
            @endcan

            @can(\App\Library\Permissions::view_content)
                <a class="btn btn-info" href="{{ route('admin.exercises.show', $exercise) }}">
                    Content @include('admin.components.svg.chevron-right')
                </a>
            @endcan
        </div>
    </div>
@endsection

@section('content')
    @if($exerciseData->count())
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">@include('admin.translations.title')</h5>
                @if($exercise->isDisabled($content->language) or $exercise->isDisabled($language))
                    <h6 class="card-subtitle">
                        @if($exercise->isDisabled($content->language))
                            <span class="badge badge-warning text-uppercase">Disabled</span>
                        @endif
                        @if($exercise->isDisabled($language))
                            <span class="badge badge-light text-uppercase">Disabled</span>
                        @endif
                    </h6>
                @endif
                @include('admin.translations.exercises.data.list')
            </div>
        </div>
    @endif
@endsection

@push('scripts')
    @include('admin.components.audio.player')
@endpush
