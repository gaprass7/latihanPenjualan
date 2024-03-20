@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @foreach ($product as $row)
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="{{ url('storage/'.$row->image) }}" alt="{{ $row->name }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title text-center fw-bold mb-3" style="color: #333;">{{ $row->name }}</h5>
                            <p class="card-text" style="color: #888;">Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores fugit assumenda expedita, odit soluta tempora repudiandae! Sint quisquam quas pariatur!</p>
                            <div class="d-flex justify-content-center gap-2">
                                {{-- untuk user yang belum login dapat melihat produk tetapi jika melihat detail akan diredirect ke login --}}
                                @if(Auth::check() && Auth::user()->is_admin)
                                    <form action="{{ route('delete', $row) }}" method="post">
                                        @method('delete')
                                        @csrf
                                        <button type="submit" class="btn btn-danger">Hapus Produk</button>
                                    </form>
                                @endif
                                <form action="{{ route('show', $row) }}" method="get">
                                    <button type="submit" class="btn btn-primary">Detail Produk</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
