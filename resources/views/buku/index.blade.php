@extends('layouts.buku.main')

@section('title', 'Daftar Buku')

@section('content')
<div class="row justify-content-center mt-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Dashboard</div>
                <div class="card-body">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            {{ $message }}
                        </div>
                    @else
                        <div class="alert alert-success">
                            You are logged in!
                        </div>
                    @endif

                    @if (Auth::user()->level === 'admin') 
                        <a href="{{ route('buku.create') }}" class="btn btn-primary float-end">Tambah Buku</a>
                    @endif

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <!--<th>ID</th>-->
                                <th>Judul Buku</th>
                                <th>Penulis</th>
                                <th>Harga</th>
                                <th>Tanggal Terbit</th>
                                @if (Auth::user()->level === 'admin')
                                    <th>Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data_buku as $index => $buku)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <!--<td>{{ $buku->id }}</td>-->
                                    <td>{{ $buku->judul }}</td>
                                    <td>{{ $buku->penulis }}</td>
                                    <td>{{ "Rp. " . number_format($buku->harga, 2, ',', '.') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($buku->tanggal_terbit)->format('d/m/Y') }}</td>

                                    @if (Auth::user()->level === 'admin') 
                                        <td>
                                            <a href="{{ route('buku.edit', $buku->id) }}" class="btn btn-warning">Edit</a>
                                            <form action="{{ route('buku.destroy', $buku->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button onclick="return confirm('Apakah yakin akan dihapus?')" type="submit" 
                                                class="btn btn-danger">Hapus</button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach

                            @if ($data_buku->isEmpty())
                                <tr>
                                    <td colspan="{{ Auth::user()->level === 'admin' ? 6 : 5 }}" class="text-center">Tidak ada buku</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                    <p>Total jumlah buku: {{ $jumlah_buku }}</p>
                    <p>Total harga semua buku: Rp. {{ number_format($total_harga, 2, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
