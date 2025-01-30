@extends('admin.layouts.app')
@section('title', 'Tambah Member')

@section('content')
<div class="container-fluid" style="margin-left: px;"> <!-- Ensure this is beside the sidebar -->
    <h1>Add New Member</h1>

    <form action="{{ route('members.store') }}" method="POST" id="addMemberForm">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
            @error('email')
                <div class="text-danger">{{ $message }}</div> <!-- Menampilkan pesan error jika email sudah terdaftar -->
            @enderror
        </div>

        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone') }}" required>
            @error('phone')
                <div class="text-danger">{{ $message }}</div> <!-- Menampilkan pesan error jika phone sudah terdaftar -->
            @enderror
        </div>

        <button type="submit" class="btn btn-primary mt-3">Save</button>
    </form>
</div>

@if(session('error'))
    <script>
        alert("{{ session('error') }}"); // Menampilkan pop-up jika ada error
    </script>
@endif

@endsection
