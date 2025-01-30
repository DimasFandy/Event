@extends('admin.layouts.app')
@section('title', 'Edit Permission')

@section('content')
<div class="container">
    <h1>Edit Permission</h1>
    <form action="{{ route('permissions.update', $permission->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Permission Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $permission->name }}" required>
        </div>
        <button type="submit" class="btn btn-success mt-2">Update</button>
        <a href="{{ route('permissions.index') }}" class="btn btn-secondary mt-2">Back</a>
    </form>
</div>
@endsection
