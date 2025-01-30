@extends('admin.layouts.app')
@section('title', 'Detail User')

@section('content')

<h1>User Details</h1>

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Name: {{ $user->name }}</h5>
        <p class="card-text">Email: {{ $user->email }}</p>
        <!-- Tambahkan data lainnya jika perlu -->

        <a href="{{ route('users.index') }}" class="btn btn-primary">Back to Users</a>
        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">Edit</a>
    </div>
</div>

@endsection
