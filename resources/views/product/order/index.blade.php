@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-body p-4">
                        @foreach ($order as $order)
                            <a href="{{ url('order/' . $order->id) }}" class="text-decoration-none text-dark">
                                <div class="mb-4">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="mb-0">Order ID: {{ $order->id }}</h5>
                                        <div class="status">
                                            @if ($order->is_paid)
                                                <span class="badge bg-success">Paid</span>
                                            @else
                                                <span class="badge bg-danger">Unpaid</span>
                                            @endif
                                        </div>
                                    </div>
                                    <p class="mb-3">User: {{ $order->user->name }}</p>
                                    <p class="mb-3">Tanggal Order: {{ $order->created_at }}</p>

                                    @if (!$order->is_paid)
                                        <div class="d-flex justify-content-end">
                                            @if ($order->payment_receipt)
                                                <a href="{{ url('storage/' . $order->payment_receipt) }}" class="btn btn-outline-primary me-2">Lihat Bukti Pembayaran</a>
                                            @endif
                                            @if(Auth::user()->is_admin)
                                                <form action="{{ route('confirm_payment', $order) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary">Confirm</button>
                                                </form>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                                <hr>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
