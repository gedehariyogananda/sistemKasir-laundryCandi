@extends('masters', ['title' => 'Home'])

@section('content')

<a href="{{ route('purchased.edit') }}" class="btn btn-primary mt-3">
    <i class="fas fa-edit"></i> Edit Pemesanan
</a>
<div class="card mt-2">
    <div class="card-body">
        <div class="text-center">
            <img class="w-25" src="/img/icon.png" alt="">
            <h3>No Pelanggan : #{{ $users->user->no_pelanggan }}</h3>
            <h5>Nama Pelanggan : {{ $users->user->name }}</h5>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Spesifikasi Cuci</th>
                    <th>Quantity</th>
                    <th>Harga</th>
                    <th>Sub Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $users->spesification->spesifikasi_cuci }}</td>
                    <td>{{ $users->quantity_laundry }} kg</td>
                    <td>Rp {{ number_format($users->spesification->hargakilo, 0, ',', '.') }}/kg</td>
                    <td>Rp {{ number_format($users->subtotal_laundry, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
        <h6>Setup Pembayaran : </h6>
        <form action="{{ route('checkout.update', $users->id) }}" method="post">
            @csrf
            @method('patch')
            <div class="d-flex items-center">
                <select class="form-control w-25" name="payment_method_id" id="">
                    <option value="">-- Pilih Pembayaran --</option>
                    @foreach($payments as $payment)
                    <option value="{{ $payment->id }}">{{ $payment->payment_method_name }}</option>
                    @endforeach
                </select>
                <button class="btn btn-sm btn-success mx-2" type="submit">
                    <i class="fa fa-cart-plus"></i>
                </button>

            </div>

        </form>

    </div>
</div>


@endsection