@extends('layouts.buku.main')

@section('title', 'Edit Buku')

@section('content')
<div class="container">
    <h4>Edit Buku</h4>
    <form method="post" action="{{ route('buku.update', $buku->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label for="judul" class="form-label">Judul</label>
            <input type="text" class="form-control" id="judul" name="judul" value="{{ $buku->judul }}" required>
        </div>
        
        <div class="mb-3">
            <label for="penulis" class="form-label">Penulis</label>
            <input type="text" class="form-control" id="penulis" name="penulis" value="{{ $buku->penulis }}" required>
        </div>
        
        <div class="mb-3">
            <label for="harga" class="form-label">Harga</label>
            <input type="text" class="form-control" id="harga" name="harga" value="{{ $buku->harga }}" required>
        </div>
        
        <div class="mb-3">
            <label for="tanggal_terbit" class="form-label">Tanggal Terbit</label>
            <input type="date" class="form-control" id="tanggal_terbit" name="tanggal_terbit" value="{{ $buku->tanggal_terbit }}" required>
        </div>

        <div class="mb-3">
            <label for="photo" class="form-label">Foto</label>
            @if ($buku->photo)
                <img src="{{ asset('storage/photos/' . $buku->photo) }}" alt="Current Photo" width="100" class="mb-2">
                <p>Foto saat ini: {{ $buku->photo }}</p>
            @else
                <p>Tidak ada foto</p>
            @endif
            <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('buku.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
