@extends('masters', ['title' => 'Set Customer'])

@section('content')

<div class="text-center">
    <img class="" src="/img/icon.png" alt="">
</div>

<div class="row">
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
                                    class="form-control" type="number" name="quantity_laundry">
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
                        <button id="checkButton" class="btn btn-sm btn-primary mt-2 float-left" type="submit">
                            <i class="fas fa-check"></i> Submit
                        </button>

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
                            <td> Rp {{ number_format ($spesification->hargakilo, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

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

@endsection