@extends('layouts.buku.main')

@section('title', 'Tambah Buku')

@section('content')
<div class="container">
    <h4>Tambah Buku</h4>
    <form method="post" action="{{ route('buku.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="judul" class="form-label">Judul</label>
            <input type="text" class="form-control" id="judul" name="judul" required>
        </div>

        <div class="mb-3">
            <label for="penulis" class="form-label">Penulis</label>
            <input type="text" class="form-control" id="penulis" name="penulis" required>
        </div>

        <div class="mb-3">
            <label for="harga" class="form-label">Harga</label>
            <input type="text" class="form-control" id="harga" name="harga" required>
        </div>

        <div class="mb-3">
            <label for="tanggal_terbit" class="form-label">Tanggal Terbit</label>
            <input type="date" class="form-control" id="tanggal_terbit" name="tanggal_terbit" required>
        </div>

        <div class="mb-3 row">
            <label for="photo" class="col-md-4 col-form-label text-md-end text-start">Foto</label>
            <div class="col-md-6">
                <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo" 
                value="{{ old('photo') }}"> 
                @if ($errors->has('photo'))
                <span class="text-danger">{{ $errors->first('photo') }}</span>
                @endif
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('buku.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
