@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-10 col-md-8">
            <div class="card shadow-sm my-5">
                <div class="card-body">
                    <h3 class="card-title text-center mb-4 font-weight-normal">{{ __('Create a Member Account') }}</h3>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row">
                            <div class="col-md-8 offset-md-2">
                                <div class="form-floating mb-3">
                                    <input id="name" type="text" name="name"
                                           class="form-control @error('name') is-invalid @enderror"
                                           value="{{ old('name') }}" autocomplete="name" autofocus
                                           placeholder="{{ __('Name') }}">
                                    <label class="sr-only" for="name">{{ __('Name') }}</label>
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8 offset-md-2">
                                <div class="form-floating mb-3">
                                    <input id="email" type="email" name="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           value="{{ old('email') }}" autocomplete="email"
                                           placeholder="{{ __('Email') }}">
                                    <label class="sr-only" for="email">{{ __('Email') }}</label>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8 offset-md-2">
                                <div class="form-floating mb-3">
                                    <input id="password" type="password" name="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           autocomplete="new-password" placeholder="{{ __('Password') }}">
                                    <label class="sr-only" for="password">{{ __('Password') }}</label>
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8 offset-md-2">
                                <div class="form-floating mb-2">
                                    <input id="password-confirm" type="password" name="password_confirmation"
                                           class="form-control" autocomplete="new-password"
                                           placeholder="{{ __('Confirm Password') }}">
                                    <label class="sr-only" for="password-confirm">{{ __('Confirm Password') }}</label>
                                    @error('password_confirmation')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-8 offset-md-2 small text-end">
                                {!! __('By clicking Sign Up, you agree to our <a href=":privacy">Privacy Policy</a>.', ['privacy' => route('privacy')]) !!}
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-2">
                                <button type="submit" class="btn btn-lg btn-primary">
                                    {{ __('Sign Up') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
