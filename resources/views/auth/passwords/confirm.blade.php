@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-10 col-md-8">
            <div class="card shadow-sm my-5">
                <div class="card-body">
                    <h3 class="card-title text-center mb-4 font-weight-normal">{{ __('Confirm Password') }}</h3>

                    {{ __('Please confirm your password before continuing.') }}

                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <div class="row">
                            <div class="col-md-8 offset-md-2">
                                <div class="form-floating mb-3">
                                    <input id="password" type="password" name="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           autocomplete="current-password" placeholder="{{ __('Password') }}">
                                    <label class="sr-only" for="password">{{ __('Password') }}</label>
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-2">
                                <button type="submit" class="btn btn-lg btn-primary">
                                    {{ __('Confirm Password') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-lg btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
