@extends('masters', ['title' => 'Home'])

@section('content')

<div class="text-center">
    <img class="w-25" src="/img/icon.png" alt="">
</div>

<div class="card mx-auto">
    <div class="card-header bg-secondary text-white"> <!-- Added background color and text color to the card header -->
        <div class="d-flex justify-content-between">
           <h3 class="text-center">Data Customer</h3>
            <a href="{{ route('purchased.create') }}" class="text-white">
                <i class="fas fa-user-plus"></i>
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive"> <!-- Added a container for responsive table design -->
            <table class="table table-bordered text-center"> <!-- Centered the table and added border -->
                <thead>
                    <tr>
                        <th>ID Customer</th>
                        <th>Nama</th>
                        <th>No Telp</th>
                        <th>Alamat</th>
                        <th>Riwayat Cuci</th>
                        <th>Quantity Laundry</th>
                        <th>Sub Total</th>
                        <th>Nota</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($userPurchaseds as $item)
                    <tr>
                        <td>#{{ $item->user->no_pelanggan }}</td>
                        <td>{{ $item->user->name }}</td>
                        <td>{{ $item->user->no_telp }}</td>
                        <td>{{ $item->user->alamat }}</td>
                        <td>{{ $item->spesification->spesifikasi_cuci }}</td>
                        <td>{{ $item->quantity_laundry }} kg</td>
                        <td>Rp {{ number_format($item->subtotal_laundry, 0, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('nota.index', $item->user_id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-file-alt"></i>
                            </a>
                        </td>
                        <td>
                            <form action="{{ route('nota.delete', $item->user_id) }}" method="post">
                            @csrf
                            @method('delete')
                            <button class="btn btn-sm btn-danger" type="submit"><i class="fa fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
