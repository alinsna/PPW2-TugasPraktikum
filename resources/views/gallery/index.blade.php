@extends('layouts.buku.main')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Dashboard</span>
                @if (Auth::user()->level === 'admin')
                    <a href="{{ route('gallery.create') }}" class="btn btn-primary">Create</a>
                @endif
            </div>
            <div class="card-body">
                <div class="row">
                    @if(count($galleries) > 0)
                        @foreach($galleries as $gallery)
                            <div class="col-sm-2">
                                <div>
                                    <a class="example-image-link" href="{{ asset('storage/posts_image/' . $gallery->picture) }}" 
                                    data-lightbox="roadtrip" data-title="{{ $gallery->description }}">
                                        <img class="example-image img-fluid mb-2" src="{{ asset('storage/posts_image/' . $gallery->picture) }}" 
                                        alt="image-1"/>
                                    </a>
                                </div>
                                @if (Auth::user()->level === 'admin')
                                    <div class="d-flex justify-content-between mt-2">
                                        <a href="{{ route('gallery.edit', $gallery->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('gallery.destroy', $gallery->id) }}" method="POST" onsubmit="return confirmDeletion();">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    @else
                        <h3>Tidak ada data.</h3>
                    @endif
                    <div class="d-flex">
                        {{ $galleries->links() }}
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-start">
                <a href="{{ route('buku.index') }}" class="btn btn-secondary">Kembali ke Daftar Buku</a>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDeletion() {
        return confirm('Apakah yakin akan dihapus?');
    }
</script>

<script>
    async function fetchGallery() {
        const response = await fetch('/api/gallery');
        const data = await response.json();
        const galleryList = document.getElementById('gallery-list');
        galleryList.innerHTML = '';

        if (data.data.length > 0) {
            data.data.forEach(gallery => {
                const col = document.createElement('div');
                col.classList.add('col-sm-2');
                col.innerHTML = `
                    <div>
                        <a class="example-image-link" href="/storage/posts_image/${gallery.picture}" 
                            data-lightbox="roadtrip" data-title="${gallery.description}">
                            <img class="example-image img-fluid mb-2" src="/storage/posts_image/${gallery.picture}" 
                            alt="image-1"/>
                        </a>
                    </div>
                `;
                galleryList.appendChild(col);
            });
        } else {
            galleryList.innerHTML = '<h3>Tidak ada data.</h3>';
        }
    }

    document.addEventListener('DOMContentLoaded', fetchGallery);
</script>

@endsection

