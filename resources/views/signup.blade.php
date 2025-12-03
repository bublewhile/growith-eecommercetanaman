@extends('templates.app')

@section('content')
<div class="position-relative" style="height: 85vh;">
    <div class="position-absolute top-50 start-50 translate-middle" style="width: 80%; max-width: 540px;">
        <div class="card border-0 shadow-lg rounded-4 p-5" style="background-color: #ffffff;">
            <div class="text-center mb-4">
                <h3 class="fw-bold" style="color: #2e7d32;">Create Account</h3>
                <p class="text-muted mb-0">Sign up to start using Growith</p>
            </div>

            {{-- alert success / error --}}
            @if (Session::get('success'))
                <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif
            @if (Session::get('error'))
                <div class="alert alert-danger">{{ Session::get('error') }}</div>
            @endif

            <form method="POST" action="{{ route('signup.add') }}">
                @csrf

                {{-- First Name --}}
                <div class="mb-3">
                    <label for="first_name" class="form-label fw-semibold">First Name</label>
                    <input type="text" id="first_name" name="first_name" class="form-control border-success-subtle @error('first_name') is-invalid @enderror"
                        placeholder="Enter your first name" value="{{ old('first_name') }}" required />
                    @error('first_name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Last Name --}}
                <div class="mb-3">
                    <label for="last_name" class="form-label fw-semibold">Last Name</label>
                    <input type="text" id="last_name" name="last_name" class="form-control border-success-subtle @error('last_name') is-invalid @enderror"
                        placeholder="Enter your last name" value="{{ old('last_name') }}" required />
                    @error('last_name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Email Address</label>
                    <input type="email" id="email" name="email" class="form-control border-success-subtle @error('email') is-invalid @enderror"
                        placeholder="Enter your email" value="{{ old('email') }}" required />
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold">Password</label>
                    <input type="password" id="password" name="password" class="form-control border-success-subtle @error('password') is-invalid @enderror"
                        placeholder="Create a password" required />
                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Button --}}
                <button type="submit" class="btn w-100 py-2 fw-semibold text-white"
                    style="background-color: #2e7d32; border-radius: 12px;">
                    Sign Up
                </button>

                {{-- Login redirect --}}
                <div class="text-center mt-4">
                    <p class="mb-1">Already have an account?
                        <a href="{{ route('login') }}" class="text-success fw-semibold text-decoration-none">
                            Sign in
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    body {
        background-color: #f4f7f2;
        margin: 0;
        padding: 0;
    }

    .form-control:focus {
        border-color: #2e7d32;
        box-shadow: 0 0 0 0.2rem rgba(46, 125, 50, 0.25);
    }

    .btn-outline-success:hover {
        background-color: #2e7d32;
        color: #fff;
    }
</style>
@endsection
