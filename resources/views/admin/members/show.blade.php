@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h1>Member Details</h1>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Name: {{ $member->name }}</h5>
                <p class="card-text">Email: {{ $member->email }}</p>
                <p class="card-text">Phone: {{ $member->phone }}</p>
                <a href="{{ route('members.index') }}" class="btn btn-primary">Back to List</a>
            </div>
        </div>
    </div>
@endsection
