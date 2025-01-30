@extends('admin.layouts.app')
@section('title', 'Editpassword Member')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg rounded-lg" style="border-radius: 20px; background: linear-gradient(135deg, #6a11cb, #2575fc);">
                <div class="card-header text-center text-white" style="border-top-left-radius: 20px; border-top-right-radius: 20px;">
                    <h4 class="fw-bold">Ganti Password</h4>
                </div>
                <div class="card-body p-4" style="background-color: #fff; border-radius: 20px;">
                    <!-- Alert untuk pesan error atau sukses -->
                    @if (session('success'))
                        <div class="alert alert-success mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger mb-4">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('members.update-password', $member->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="current_password" class="form-label text-secondary fw-semibold">Password Lama</label>
                            <input type="password" name="current_password" id="current_password" class="form-control form-control-lg shadow-sm" placeholder="Masukkan password lama" required>
                        </div>

                        <div class="mb-4">
                            <label for="new_password" class="form-label text-secondary fw-semibold">Password Baru</label>
                            <input type="password" name="new_password" id="new_password" class="form-control form-control-lg shadow-sm" placeholder="Masukkan password baru" required>
                        </div>

                        <div class="mb-4">
                            <label for="new_password_confirmation" class="form-label text-secondary fw-semibold">Konfirmasi Password Baru</label>
                            <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control form-control-lg shadow-sm" placeholder="Konfirmasi password baru" required>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-light btn-lg text-primary fw-bold shadow-lg hover-shadow-lg transition-all duration-300">Simpan Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
