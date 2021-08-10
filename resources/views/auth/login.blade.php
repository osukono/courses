@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-10 col-md-8">
            <div class="card shadow-sm my-5">
                <div class="card-body">
                    <h3 class="card-title text-center mb-4 font-weight-normal">{{ __('Member Login') }}</h3>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <input type="hidden" name="remember" id="remember" value="yes">

                        <div class="row">
                            <div class="col-md-8 offset-md-2">
                                <div class="form-floating mb-3">
                                    <input id="email" type="email" name="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           value="{{ old('email') }}" autocomplete="email" autofocus
                                           placeholder="{{ __('Email') }}" tabindex="1">
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
                                    <input id="password" type="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           name="password" autocomplete="current-password"
                                           placeholder="{{ __('Password') }}" tabindex="2">
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
                                @if (Route::has('password.request'))
                                    <div class="text-end">
                                        <a class="btn btn-link text-secondary" href="{{ route('password.request') }}">
                                            {{ __('Forgot your password?') }}
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-2">
                                <button type="submit" class="btn btn-lg btn-primary" tabindex="3">
                                    {{ __('Log In') }}
                                </button>

                                <a class="btn btn-lg btn-link" href="{{ route('register') }}">
                                    {{ __('Create account') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
