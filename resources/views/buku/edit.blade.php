@extends('layouts.buku.main')

@section('title', 'Edit Buku')

@section('content')
<div class="container">
    <h4>Edit Buku</h4>
    <form method="post" action="{{ route('buku.update', $buku->id) }}">
        @csrf
        <div>Judul <input type="text" name="judul" value="{{ $buku->judul }}"></div>
        <div>Penulis <input type="text" name="penulis" value="{{ $buku->penulis }}"></div>
        <div>Harga <input type="text" name="harga" value="{{ $buku->harga }}"></div>
        <div>Tanggal Terbit <input type="date" name="tanggal_terbit" value="{{ $buku->tanggal_terbit }}"></div>
        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('buku.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
