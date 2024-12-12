<form method="POST" action="{{ route('login') }}">
    @csrf
    <input type="email" name="email" placeholder="E-posta" required value="{{ old('email') }}">
    <input type="password" name="password" placeholder="Şifre" required>
    <button type="submit">Giriş</button>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

</form>
