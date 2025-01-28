@extends('admin.layouts.app')

@section('content')
<div class="container-edit" style="max-width: 600px; margin: 0 auto; padding: 20px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); background: linear-gradient(to bottom right, #6a11cb, #2575fc); animation: fadeIn 1s ease; color: #fff;">
    <h1 style="text-align: center; font-size: 24px; font-weight: bold; color: #fff; margin-bottom: 20px;">Edit Kategori</h1>
    <form action="{{ route('kategoris.update', $kategori) }}" method="POST" style="display: flex; flex-direction: column; gap: 15px;">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name" style="font-weight: bold; color: #fff;">Nama</label>
            <input type="text" id="name" name="name" value="{{ $kategori->name }}" required style="width: 100%; padding: 10px; border: none; border-radius: 5px; box-sizing: border-box; transition: all 0.3s ease; background-color: rgba(255, 255, 255, 0.8); color: #333;">
        </div>
        <div class="form-group">
            <label for="description" style="font-weight: bold; color: #fff;">Deskripsi</label>
            <textarea id="description" name="description" style="width: 100%; padding: 10px; border: none; border-radius: 5px; box-sizing: border-box; min-height: 100px; transition: all 0.3s ease; background-color: rgba(255, 255, 255, 0.8); color: #333;">{{ $kategori->description }}</textarea>
        </div>
        <div class="form-group">
            <label for="weight" style="font-weight: bold; color: #fff;">Bobot</label>
            <input type="number" id="weight" name="weight" value="{{ $kategori->weight }}" required style="width: 100%; padding: 10px; border: none; border-radius: 5px; box-sizing: border-box; transition: all 0.3s ease; background-color: rgba(255, 255, 255, 0.8); color: #333;">
        </div>
        <div class="form-group">
            <label for="status" style="font-weight: bold; color: #fff;">Status</label>
            <select id="status" name="status" required style="width: 100%; padding: 10px; border: none; border-radius: 5px; box-sizing: border-box; transition: all 0.3s ease; background-color: rgba(255, 255, 255, 0.8); color: #333;">
                <option value="active" {{ $kategori->status == 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="inactive" {{ $kategori->status == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
            </select>
        </div>
        <button type="submit" style="padding: 10px 15px; background: linear-gradient(to right, #43cea2, #185a9d); color: #fff; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; font-weight: bold; text-align: center; transition: all 0.3s ease; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
            Update
        </button>
    </form>
</div>
<!-- Alert Scripts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Display success alert when 'success' session variable is set
    @if (session('success'))
        Swal.fire({
            title: 'Sukses!',
            text: "{{ session('success') }}",  // Gunakan tanda kutip ganda di sini
            icon: 'success',
            confirmButtonText: 'Oke'
        });
    @endif

    // Display error alert when 'error' session variable is set
    @if (session('error'))
        Swal.fire({
            title: 'Gagal!',
            text: "{{ session('error') }}",  // Gunakan tanda kutip ganda di sini
            icon: 'error',
            confirmButtonText: 'Coba Lagi'
        });
    @endif
</script>
<!-- Inline Animation CSS -->
<style>
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
input:focus, textarea:focus, select:focus {
    background-color: rgba(255, 255, 255, 1);
    border: none;
    box-shadow: 0 0 5px rgba(255, 255, 255, 0.5);
}
button:hover {
    transform: scale(1.05);
    box-shadow: 0 6px 10px rgba(0, 0, 0, 0.2);
}
</style>
@endsection
