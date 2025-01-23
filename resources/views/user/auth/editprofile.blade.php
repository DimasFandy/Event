@extends('user.layouts.app')

@section('content')
    <!-- Main Stylesheet File -->
    <link href="{{ asset('css/editprofile.css') }}" rel="stylesheet">

    <div class="container1 mt-5 pt-5">
        @if(session('success'))
            <!-- Modal Success -->
            <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="successModalLabel">Profile Updated Successfully</h5>
                        </div>
                        <div class="modal-body">
                            Password berhasil di update. <b>klik dimana saja untuk menutup. Terima Kasih</b>
                        </div>
                        <div class="modal-footer">
                            <a href="{{ route('user.home') }}" class="btn btn-primary">Go to Home</a>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card edit-profile-card mb-5">
                    <div class="card-header">{{ __('Edit Profile') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('user.profile.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Input Nama -->
                            <div class="form-group row">
                                <label for="name"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>
                                <div class="col-md-6">
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name', $member->name) }}" required autocomplete="name" autofocus>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Input Email -->
                            <div class="form-group row">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Email Address') }}</label>
                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email', $member->email) }}" required autocomplete="email">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Input Nomor Telepon -->
                            <div class="form-group row">
                                <label for="phone"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Phone Number') }}</label>
                                <div class="col-md-6">
                                    <input id="phone" type="text"
                                        class="form-control @error('phone') is-invalid @enderror" name="phone"
                                        value="{{ old('phone', $member->phone) }}" required autocomplete="phone"
                                        pattern="\d*" maxlength="15" oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                                    @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Input Foto -->
                            <div class="form-group row">
                                <label for="photo"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Profile Photo') }}</label>
                                <div class="col-md-6">
                                    <input id="photo" type="file"
                                        class="form-control @error('photo') is-invalid @enderror" name="photo"
                                        accept="image/*">
                                    @error('photo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    @if ($member->photo)
                                        <img src="{{ asset('storage/' . $member->photo) }}" alt="Profile Photo"
                                            class="mt-2" style="max-height: 100px;">
                                    @endif
                                </div>
                            </div>

                            <!-- Tombol Submit -->
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Simpan Perubahan') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Show modal if success message exists
        document.addEventListener('DOMContentLoaded', function () {
            if ("{{ session('success') ? 'true' : 'false' }}") {
                var successModal = new bootstrap.Modal(document.getElementById('successModal'), {});
                successModal.show();
            }
        });
    </script>
@endsection
