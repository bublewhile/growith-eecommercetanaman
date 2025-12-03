@extends('templates.app')

@section('content')
    <div class="position-relative" style="height: 80vh;">
        <div class="position-absolute top-50 start-50 translate-middle" style="width: 80%; max-width: 540px;">
            <div class="card border-0 shadow-lg rounded-4 p-5" style="background-color: #ffffff;">
                <div class="text-center mb-4">
                    <h3 class="fw-bold" style="color: #2e7d32;">Welcome Back</h3>
                    <p class="text-muted mb-0">Sign in to continue to Growith</p>
                </div>

                {{-- alert success / error --}}
                @if (Session::get('success'))
                    <div class="alert alert-success">{{ Session::get('success') }}</div>
                @endif
                @if (Session::get('error'))
                    <div class="alert alert-danger">{{ Session::get('error') }}</div>
                @endif

                <form method="POST" action="{{ route('loginAuth') }}">
                    @csrf

                    {{-- Email --}}
                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">Email Address</label>
                        <input type="email" id="email" name="email" class="form-control border-success-subtle"
                            placeholder="Enter your email" required />
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold">Password</label>
                        <input type="password" id="password" name="password" class="form-control border-success-subtle"
                            placeholder="Enter your password" required />
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Remember me & forgot --}}
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="remember" checked>
                            <label class="form-check-label small" for="remember">Remember me</label>
                        </div>
                        <a href="#" class="small text-success text-decoration-none">Forgot password?</a>
                    </div>

                    {{-- Button --}}
                    <button type="submit" class="btn w-100 py-2 fw-semibold text-white"
                        style="background-color: #2e7d32; border-radius: 12px;">
                        Sign In
                    </button>

                    {{-- Register --}}
                    <div class="text-center mt-4">
                        <p class="mb-1">Not a member?
                            <a href="{{ route('signup.add') }}" class="text-success fw-semibold text-decoration-none">
                                Register
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
    body {
        background-color: #f4f7f2; /* sama seperti dashboard */
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
