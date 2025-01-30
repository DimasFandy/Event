@extends('admin.layouts.app')
@section('title', 'Peserta Event')

@section('content')
<div class="content-wrapper" style="margin: 20px; padding: 20px; background: linear-gradient(135deg, #0047ab, #ffa500); border-radius: 8px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);">
    <h1 class="mb-4 text-center" style="font-family: 'Merriweather Sans', sans-serif; font-weight: 700; color: #fff;">
        Tambah : <span style="color: #f0f0f0;">{{ $event->name }}</span>
    </h1>

    <form action="{{ route('events.members.store', ['event_id' => $event->id]) }}" method="POST" style="max-width: 600px; margin: 0 auto; color: #fff;">
        @csrf
        <div class="form-group mb-4">
            <label for="member_id" class="form-label" style="font-weight: 600;">Nama Peserta:</label>
            <select name="member_id" id="member_id" class="form-select" style="padding: 10px; border-radius: 6px; border: 1px solid #fff; background-color: #0047ab; color: #fff;" required>
                <option value="" disabled selected style="color: #ccc;">Pilih Peserta</option>
                @foreach ($availableMembers as $member)
                    <option value="{{ $member->id }}">{{ $member->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-primary" style="padding: 10px 20px; border-radius: 6px; background-color: #0047ab color: #fff; border: none; transition: transform 0.2s ease;"
                onmouseover="this.style.transform='scale(1.05)';" onmouseout="this.style.transform='scale(1)';">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection
