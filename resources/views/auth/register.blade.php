@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center">
    <div class="card shadow-lg border-0" style="width: 500px;">
        <div class="card-header text-center bg-primary text-white">
            <h4>{{ __('Register') }}</h4>
        </div>
        <div class="card-body p-4">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">{{ __('Name') }}</label>
                    <input id="name" type="text"
                        class="form-control @error('name') is-invalid @enderror"
                        name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('Email Address') }}</label>
                    <input id="email" type="email"
                        class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" required autocomplete="email">
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">{{ __('Password') }}</label>
                    <input id="password" type="password"
                        class="form-control @error('password') is-invalid @enderror"
                        name="password" required autocomplete="new-password">
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password-confirm" class="form-label">{{ __('Confirm Password') }}</label>
                    <input id="password-confirm" type="password"
                        class="form-control" name="password_confirmation" required autocomplete="new-password">
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Register') }}
                    </button>
                </div>

                <div class="text-center mt-3">
                    <a href="{{ route('login') }}" class="text-decoration-none">
                       Already have an account? <span style="color: blue"> Login</span>
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
