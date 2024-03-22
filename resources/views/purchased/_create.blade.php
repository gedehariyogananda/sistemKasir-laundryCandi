@extends('masters', ['title' => 'Set Customer'] )

@section('content')

<div class="row mt-4">
    <h3 class="text-center mt-2">Check Pemesanan</h3>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-secondary">
                <h5 class="mb-0 text-light">Set Customer <i class="fas fa-user"></i></h5>
            </div>
            <div class="card-body">
                @if(\Route::currentRouteName() == 'purchased.edit')
                <form action="{{ route('purchased.update') }}" method="post">
                    @csrf
                    @method('patch')
                    @endif

                    @if(\Route::currentRouteName() == 'purchased.create')
                    <form action="{{ route('purchased.store') }}" method="post">
                        @csrf
                        @endif

                        <div class="row">
                            <div class="col-md-6">
                                <label for="nama">Nama Customer</label>
                                <input class="form-control" type="text" name="name"
                                    value="{{ old('name', $bind->user->name ?? '') }}" id="">
                                <input type="hidden" name="tanggal_mulai_laundry" id="">
                                <input type="hidden" name="no_pelanggan" id="">
                                <input type="hidden" name="subtotal_laundry" id="">
                            </div>
                            <div class="col-md-6">
                                <label for="no_telp">No Telp</label>
                                <input class="form-control" value="{{ old('no_telp', $bind->user->no_telp ?? '') }}"
                                    type="text" name="no_telp" id="">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label for="">Spesifikasi Cuci</label>
                                <select class="form-control" name="spesification_id" id="">
                                    <option value="">-- Pilih Spesifikasi Cuci --</option>
                                    @foreach($spesifications as $spesification)
                                    <option value="{{ $spesification->id }}" {{ old('spesification_id', $bind->
                                        spesification_id ?? '') == $spesification->id ? 'selected' : '' }}>
                                        {{ $spesification->spesifikasi_cuci }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="">Gender</label>
                                <select class="form-control" name="gender" id="">
                                    <option value="" selected disabled>-- Masukkan Gender --</option>
                                    <option value="L" {{ old('gender', $bind->user->gender ?? '') == 'L' ?
                                        'selected'
                                        : '' }}>
                                        Laki Laki
                                    </option>
                                    <option value="P" {{ old('gender', $bind->user->gender ?? '') == 'P' ?
                                        'selected'
                                        : '' }}>
                                        Perempuan
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="">Quantity Laundry</label>
                                <input value="{{ old('quantity_laundry', $bind->quantity_laundry ?? '') }}"
                                    class="form-control" type="text" name="quantity_laundry">
                            </div>
                            <div class="col-md-6">
                                <label for="">Tanggal selesai</label>
                                <input
                                    value="{{ old('tanggal_selesai_laundry', $bind->tanggal_selesai_laundry ?? '') }}"
                                    class="form-control" type="date" name="tanggal_selesai_laundry">
                            </div>
                            <div class="col-md-6">
                                <label for="diantar">Pesanan Diantar?</label>
                                <div>
                                    <input class="form-checkbox" type="checkbox" id="diantarCheckbox"> iya
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div id="alamatInput" style="display:none;">
                                    <label for="">Alamat</label>
                                    <input value="{{ old('alamat', $bind->user->alamat ?? '') }}" class="form-control"
                                        type="text" name="alamat">
                                </div>
                            </div>
                        </div>

                        @if(\Route::currentRouteName() == 'purchased.get')
                        <button class="btn btn-sm btn-primary mt-2 float-left" hidden type="submit">Submit</button>
                        @endif
                        @if(\Route::currentRouteName() == 'purchased.edit')
                        <button class="btn btn-sm btn-primary mt-2 float-left" type="submit">Submit</button>
                        @endif
                    </form>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-secondary">
                <h5 class="mb-0 text-light">Daftar Harga <i class="fas fa-list-alt"></i></h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Spesifikasi Cuci</th>
                            <th>Harga/kilo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $no = 1;
                        @endphp
                        @foreach($spesifications as $spesification)
                        <tr>
                            <td>#{{ $no++}}</td>
                            <td>{{ $spesification->spesifikasi_cuci }}</td>
                            <td>{{ $spesification->hargakilo }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<br>


<div class="d-flex justify-content-end mb-3">
    <button class="btn btn-success" id="checkoutButton">
        <i class="fas fa-shopping-cart"></i> Checkout
    </button>
</div>



{{-- table checkout --}}
<table class="mt-3 table table-bordered">
    <thead class="thead-dark">
        <tr>
            <th>Nama Pelanggan</th>
            <th>No Telp</th>
            <th>Alamat</th>
            <th>Quantity Laundry</th>
            <th>Spesifikasi Cuci</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            @foreach($userPurchaseds as $userPurchased)
            <td>{{ $userPurchased->user->name }}</td>
            <td>{{ $userPurchased->user->no_telp }}</td>
            <td>{{ $userPurchased->user->alamat }}</td>
            <td>{{ $userPurchased->quantity_laundry ? $userPurchased->quantity_laundry : "-" }}</td>
            <td>{{ $userPurchased->spesification ? $userPurchased->spesification->spesifikasi_cuci : "-" }}
            </td>
            <td>

                @if($userPurchased->spesification != null)
                @if(\Route::currentRouteName() == 'purchased.get')
                <a href="{{ route('purchased.edit') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-edit"></i> Edit Pemesanan
                </a>
                <form action="{{ route('purchased.destroyPemesanan', $userPurchased->user_id) }}" method="post">
                    @csrf
                    @method('patch')
                    <button class="btn btn-sm btn-danger" type="submit">
                        <i class="fas fa-trash-alt"></i> Clear Pemesanan
                    </button>
                </form>
                @else
                @if(\Route::currentRouteName() == 'purchased.edit')
                @if($bind->user->alamat != null)
                <a href="{{ route('purchased.get') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
                @endif
                @endif
                @endif
                @endif
            </td>
            @endforeach
        </tr>
    </tbody>
</table>
<script>
    document.getElementById('diantarCheckbox').addEventListener('change', function() {
            var alamatInput = document.getElementById('alamatInput');
    
            if (this.checked) {
                alamatInput.style.display = 'block';
            } else {
                alamatInput.style.display = 'none';
            }
        });

        document.getElementById('checkoutButton').addEventListener('click', function () {
        Swal.fire({
            title: 'Confirmation',
            text: 'Apakah yakin untuk checkout?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, Checkout',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ route('checkout.index') }}";
            }
        });
    });

</script>

@endsection

{{--

@extends('masters', ['title' => 'Set - Customer'] )

@section('content')

<div class="row">
    <div class="col-md-6">
        <div class="card">
            @if(\Route::currentRouteName() == 'purchased.edit')
            @if($bind->user->alamat != null)
            <a href="{{ route('purchased.get') }}">Back</a>
            @endif
            @endif
            <div class="card-header">Set Customer</div>
            <div class="card-body">
                @if(\Route::currentRouteName() == 'purchased.edit')
                <form action="{{ route('purchased.update') }}" method="post">
                    @csrf
                    @method('patch')
                    @endif

                    @if(\Route::currentRouteName() == 'purchased.create')
                    <form action="{{ route('purchased.store') }}" method="post">
                        @csrf
                        @endif


                        <div class="row">
                            <div class="col-md-6">
                                <label for="nama">Nama Customer</label>
                                <input class="form-control" type="text" name="name"
                                    value="{{ old('name', $bind->user->name ?? '') }}" id="">
                                <input type="hidden" name="tanggal_mulai_laundry" id="">
                                <input type="hidden" name="no_pelanggan" id="">
                                <input type="hidden" name="subtotal_laundry" id="">
                            </div>
                            <div class="col-md-6">
                                <label for="no_telp">No Telp</label>
                                <input class="form-control" value="{{ old('no_telp', $bind->user->no_telp ?? '') }}"
                                    type="text" name="no_telp" id="">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label for="">Spesifikasi Cuci</label>
                                <select class="form-control" name="spesification_id" id="">
                                    <option value="">-- Pilih Spesifikasi Cuci --</option>
                                    @foreach($spesifications as $spesification)
                                    <option value="{{ $spesification->id }}" {{ old('spesification_id', $bind->
                                        spesification_id ?? '') == $spesification->id ? 'selected' : '' }}>
                                        {{ $spesification->spesifikasi_cuci }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="">Gender</label>
                                <select class="form-control" name="gender" id="">
                                    <option value="" disabled>-- Masukkan Gender --</option>
                                    <option value="L" {{ old('gender', $bind->user->gender ?? '') == 'L' ?
                                        'selected'
                                        : '' }}>
                                        Laki Laki
                                    </option>
                                    <option value="P" {{ old('gender', $bind->user->gender ?? '') == 'P' ?
                                        'selected'
                                        : '' }}>
                                        Perempuan
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="">Quantity Laundry</label>
                                <input value="{{ old('quantity_laundry', $bind->quantity_laundry ?? '') }}"
                                    class="form-control" type="text" name="quantity_laundry">
                            </div>
                            <div class="col-md-6">
                                <label for="">Tanggal selesai</label>
                                <input
                                    value="{{ old('tanggal_selesai_laundry', $bind->tanggal_selesai_laundry ?? '') }}"
                                    class="form-control" type="date" name="tanggal_selesai_laundry">
                            </div>
                            <div class="col-md-6">
                                <label for="diantar">Pesanan Diantar?</label>
                                <div>
                                    <input class="form-checkbox" type="checkbox" id="diantarCheckbox"> iya
                                    <input class="form-checkbox" type="checkbox" id=""> tidak
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div id="alamatInput" style="display:none;">
                                    <label for="">Alamat</label>
                                    <input value="{{ old('alamat', $bind->user->alamat ?? '') }}" class="form-control"
                                        type="text" name="alamat">
                                </div>
                            </div>
                        </div>

                        @if(\Route::currentRouteName() == 'purchased.get')
                        <button class="btn btn-sm btn-primary mt-2 float-left" hidden type="submit">Submit</button>
                        @endif
                        @if(\Route::currentRouteName() == 'purchased.edit')
                        <button class="btn btn-sm btn-primary mt-2 float-left" type="submit">Submit</button>
                        @endif
                    </form>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Daftar Harga</div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Spesifikasi Cuci</th>
                            <th>Harga/kilo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $no = 1;
                        @endphp
                        @foreach($spesifications as $spesification)
                        <tr>
                            <td>#{{ $no++}}</td>
                            <td>{{ $spesification->spesifikasi_cuci }}</td>
                            <td>{{ $spesification->hargakilo }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<a href="{{ route('checkout.index') }}">Checkout</a>
<table class="mt-3 table table-bordered">
    <thead class="thead-dark">
        <tr>
            <th>Nama Pelanggan</th>
            <th>No Telp</th>
            <th>Diantar</th>
            <th>Quantity Loundry</th>
            <th>Spesifikasi Cuci</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            @foreach($userPurchaseds as $userPurchased)
            <td>{{ $userPurchased->user->name }}</td>
            <td>{{ $userPurchased->user->no_telp }}</td>
            <td>{{ $userPurchased->user->alamat }}</td>
            <td>{{ $userPurchased->quantity_laundry ? $userPurchased->quantity_laundry : "-" }}</td>
            <td>{{ $userPurchased->spesification ? $userPurchased->spesification->spesifikasi_cuci : "-" }}
            </td>
            <td>

                @if($userPurchased->spesification != null)
                @if(\Route::currentRouteName() == 'purchased.get')
                <a href="{{ route('purchased.edit') }}">edit</a>
                <form action="{{ route('purchased.destroyPemesanan', $userPurchased->user_id) }}" method="post">
                    @csrf
                    @method('patch')
                    <button class="btn btn-sm btn-success" type="submit">Clear Pemesanan User</button>
                </form>
                @else
                <p>back main menu to access action</p>
                @endif
                @endif
            </td>
            @endforeach
        </tr>
    </tbody>
</table>
<script>
    document.getElementById('diantarCheckbox').addEventListener('change', function() {
            var alamatInput = document.getElementById('alamatInput');
    
            if (this.checked) {
                alamatInput.style.display = 'block';
            } else {
                alamatInput.style.display = 'none';
            }
        });
</script>



@endsection --}}