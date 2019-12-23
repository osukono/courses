@extends('layouts.app')

@section('content')
    <div class="row justify-content-center mt-3">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="card-title text-center mb-4 font-weight-normal">{{ __('Member Login') }}</h3>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <input type="hidden" name="remember" id="remember" value="yes">

                        <div class="form-group row">
                            <div class="col-md-8 offset-md-2">
                                <label class="sr-only" for="email">{{ __('Email') }}</label>
                                <input id="email" type="email"
                                       class="form-control form-control-lg @error('email') is-invalid @enderror"
                                       name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                                       placeholder="{{ __('Email') }}" tabindex="1">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-8 offset-md-2">
                                <label class="sr-only" for="password">{{ __('Password') }}</label>
                                <input id="password" type="password"
                                       class="form-control form-control-lg @error('password') is-invalid @enderror"
                                       name="password" required autocomplete="current-password"
                                       placeholder="{{ __('Password') }}" tabindex="2">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-8 offset-md-2">
{{--                                <div class="custom-control custom-checkbox">--}}
{{--                                    <input class="custom-control-input" type="checkbox" name="remember"--}}
{{--                                           id="remember" {{ old('remember') ? 'checked' : '' }}>--}}
{{--                                    <label class="custom-control-label" for="remember">{{ __('Remember Me') }}</label>--}}
{{--                                </div>--}}
                                @if (Route::has('password.request'))
                                    <div class="text-right">
                                        <a class="btn btn-link text-secondary" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
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
                                    {{ __('Create an Account') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
