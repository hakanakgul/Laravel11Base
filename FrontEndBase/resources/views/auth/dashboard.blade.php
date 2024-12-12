@extends('layouts.app') {{-- Layout dosyanızı kullanıyorsanız ekleyin --}}

@section('content')
    <div class="container">
        <h1>Hoş Geldiniz, {{ session('user.name') }}!</h1>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit">Çıkış Yap</button>
        </form>
    </div>
@endsection
