@extends('admin.layouts.app')
@section('title', 'Tambah Permission')

@section('content')
<div class="container">
    <h1>Create Permission</h1>
    <form action="{{ route('permissions.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Permission Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success mt-2">Save</button>
        <a href="{{ route('permissions.index') }}" class="btn btn-secondary mt-2">Back</a>
    </form>
</div>
@endsection
