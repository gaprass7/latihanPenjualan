@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3>Keranjang Belanja</h3>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @php
                            $total_price = 0;
                        @endphp

                        @foreach ($carts as $cart)
                            <div class="row mb-4">
                                <div class="col-md-3">
                                    <img src="{{ url('storage/' . $cart->product->image) }}" alt="{{ $cart->product->name }}" height="100px" class="img-thumbnail">
                                </div>
                                <div class="col-md-6">
                                    <h5>{{ $cart->product->name }}</h5>
                                    <p class="text-muted">Harga: Rp. {{ number_format($cart->product->price, 0, ',', '.') }}</p>
                                    <form action="{{ route('update_cart', $cart) }}" method="POST" class="mb-2">
                                        @method('patch')
                                        @csrf
                                        <div class="input-group">
                                            <input type="number" name="amount" class="form-control" value="{{ $cart->amount }}">
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </form>
                                    <form action="{{ route('delete_cart', $cart) }}" method="POST">
                                        @method('delete')
                                        @csrf
                                        <button type="submit" class="btn btn-danger">Remove</button>
                                    </form>
                                </div>
                                <div class="col-md-3 text-end">
                                    <p class="fw-bold">Total: Rp. {{ number_format($cart->product->price * $cart->amount, 0, ',', '.') }}</p>
                                </div>
                                @php
                                    $total_price += $cart->product->price * $cart->amount;
                                @endphp
                            </div>
                        @endforeach

                        <hr>

                        <div class="text-end">
                            <p class="fw-bold">Total Harga: Rp. {{ number_format($total_price, 0, ',', '.') }}</p>
                            <form action="{{ route('checkout') }}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-primary" @if ($carts->isEmpty()) disabled @endif>Checkout</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
