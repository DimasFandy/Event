@extends('user.layouts.app')

@section('title', 'Edit Password')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/editpw.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <div class="container1 mt-5 p-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg rounded-lg animate__animated animate__fadeIn">
                    <div class="card-header text-center bg-primary text-white">
                        <h4>Edit Password</h4>
                    </div>
                    <div class="card-body">
                        <!-- Tampilkan pesan sukses atau error -->
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                            <script>
                                // Show modal on success with Bootstrap 5 JavaScript
                                document.addEventListener('DOMContentLoaded', function() {
                                    var successModal = new bootstrap.Modal(document.getElementById('successModal'));
                                    successModal.show();
                                });
                            </script>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('user.update-password') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="current_password" class="form-label">Password Lama</label>
                                <input type="password" class="form-control border-light shadow-sm" id="current_password"
                                    name="current_password" required>
                            </div>
                            <div class="mb-3">
                                <label for="new_password" class="form-label">Password Baru</label>
                                <input type="password" class="form-control border-light shadow-sm" id="new_password"
                                    name="new_password" required>
                            </div>
                            <div class="mb-3">
                                <label for="new_password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                                <input type="password" class="form-control border-light shadow-sm"
                                    id="new_password_confirmation" name="new_password_confirmation" required>
                            </div>
                            <div class="d-grid mt-4">
                                <button type="submit"
                                    class="btn btn-primary btn-block rounded-pill shadow-sm transition-transform hover-transform">Perbarui
                                    Password</button>
                            </div>
                            <div class="text-center mt-3">
                                <a href="{{ route('user.home') }}" class="btn btn-link">Kembali ke Halaman Utama</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Password Updated Successfully</h5>
                </div>
                <div class="modal-body">
                    Password berhasil di update. <b>klik dimana saja untuk menutup. Terima Kasih</b>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-primary">Go to Home</a>
                </div>
            </div>
        </div>
    </div>

    </script>
@endsection
