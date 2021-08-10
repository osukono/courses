@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-10 col-md-8">
            <div class="card shadow-sm my-5">
                <div class="card-body">
                    <h3 class="card-title text-center mb-4 font-weight-normal">{{ __('Reset Password') }}</h3>

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="row">
                            <div class="col-md-8 offset-md-2">
                                <div class="form-floating mb-3">
                                    <input id="email" type="email" name="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           value="{{ $email ?? old('email') }}" autocomplete="email"
                                           placeholder="{{ __('Email') }}">
                                    <label for="email">{{ __('Email') }}</label>
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
                                           autocomplete="new-password" autofocus placeholder="{{ __('Password') }}">
                                    <label for="password">{{ __('Password') }}</label>
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
                                <div class="form-floating mb-3">
                                    <input id="password-confirm" type="password" class="form-control"
                                           name="password_confirmation" autocomplete="new-password"
                                           placeholder="{{ __('Confirm Password') }}">
                                    <label class="sr-only" for="password-confirm">{{ __('Confirm Password') }}</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-2">
                                <button type="submit" class="btn btn-lg btn-primary">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
