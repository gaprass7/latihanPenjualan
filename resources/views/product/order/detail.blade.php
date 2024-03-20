@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-3">Order ID {{ $order->id }}</h5>
                            <div class="status">
                                @if ($order->is_paid)
                                    <span class="badge bg-success">Paid</span>
                                @else
                                    <span class="badge bg-danger">Unpaid</span>
                                @endif
                            </div>
                        </div>
                        <h6 class="card-subtitle mb-2 text-muted">By {{ $order->user->name }}</h6>

                        <hr>
                        @php
                            $total_price = 0;
                        @endphp
                        @foreach ($order->transactions as $transaction)
                            <div class="d-flex justify-content-between">
                                <p>{{ $transaction->product->name }} - {{ $transaction->amount }} pcs</p>
                                <p class="fw-bold">Rp {{ number_format($transaction->product->price * $transaction->amount, 0, ',', '.') }}</p>
                            </div>
                            @php
                                $total_price += $transaction->product->price * $transaction->amount;
                            @endphp
                        @endforeach
                        <hr>
                        <div class="d-flex justify-content-between">
                            <p class="fw-bold">Total Price:</p>
                            <p class="fw-bold">Rp {{ number_format($total_price, 0, ',', '.') }}</p>
                        </div>
                        <hr>

                        @if (!$order->is_paid && $order->payment_receipt == null && !Auth::user()->is_admin)
                            <form action="{{ route('submit_payment', $order) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="payment_receipt" class="form-label">Upload your payment receipt</label>
                                    <input type="file" name="payment_receipt" id="payment_receipt" class="form-control">
                                </div>
                                <button type="submit" class="btn btn-primary mt-3">Submit payment</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
