@extends('user.layouts.app')

@section('content')
    <!-- Main Stylesheet File -->
    <link href="{{ asset('css/loginuser.css') }}" rel="stylesheet">

    <div class="container1">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card login-card mb-5">
                    <div class="card-header">{{ __('Verifikasi OTP') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('user.auth.verify_otp') }}">
                            @csrf
                            <!-- Formulir untuk OTP -->
                            <div class="form-group row">
                                <label for="otp"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Kode OTP') }}</label>
                                <div class="col-md-6">
                                    <input id="otp" type="text"
                                        class="form-control @error('otp') is-invalid @enderror" name="otp"
                                        value="{{ old('otp') }}" required autofocus>
                                    @error('otp')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <!-- Tampilkan ID Member (optional) -->
                                    <input type="hidden" name="member_id" value="{{ $memberId }}">
                                </div>
                            </div>

                            <!-- Tombol Submit -->
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">{{ __('Verifikasi OTP') }}</button>
                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link"
                                            href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
