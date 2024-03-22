@extends('masters', ['title' => 'Home'])

@section('content')
<div class="row">
    <div class="col text-center mt-5">
        <a href="{{ route('purchased.index') }}">
            <img src="/img/icon.png" alt="" class="img-fluid mx-auto d-block">
        </a>
        <h1>Loundry <span class="text-primary fw-bold">Candi</span></h1>
    </div>
</div>
@endsection