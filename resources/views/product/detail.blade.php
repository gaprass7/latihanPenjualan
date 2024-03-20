@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0">{{ __('Product Detail') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <img src="{{ url('storage/'.$product->image) }}" alt="{{ $product->name }}" class="img-fluid">
                            </div>
                            <div class="col-md-8">
                                <h1>{{ $product->name }}</h1>
                                    <h6>{{ $product->description }}</h6>
                                    <h3>Rp{{ $product->price }}</h3>
                                    <hr>
                                    <p>{{ $product->stock }} left</p>
                                    {{-- untuk menyembunyikan fitur ini dari admin --}}
                                    @if(!Auth::user()->is_admin)
                                        <form action="{{ route('add_to_cart', $product) }}" method="post">
                                            @csrf
                                            <div class="input-group mb-3">
                                                <input type="number" class="form-control" aria-describedby="basic-addon2"
                                                    name="amount" value=1>
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary" type="submit">Add to
                                                        cart</button>
                                                </div>
                                            </div>
                                        </form>
                                    @else
                                        <form action="{{ route('edit', $product) }}" method="get">
                                            <button type="submit" class="btn btn-primary">Edit product</button>
                                        </form>
                                    @endif
                            </div>

                        </div>
                    </div>
                </div>
                @if($errors->any())
                    <div class="alert alert-danger mt-3">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
