<form method="POST" action="{{ route('register') }}" id="registration-form">
    @csrf
    <input type="text" name="name" placeholder="Ad" value="{{ old('name') }}" id="name" required>
    <span id="name-error" class="text-danger"></span>
    <input type="email" name="email" placeholder="E-posta" value="{{ old('email') }}" id="email" required>
    <span id="email-error" class="text-danger"></span>
    <input type="password" name="password" placeholder="Şifre" id="password" required>
    <span id="password-error" class="text-danger"></span>
    <input type="password" name="password_confirmation" placeholder="Şifre Tekrar" id="password_confirmation" required>
    <span id="password_confirmation-error" class="text-danger"></span>
    <button type="submit" id="submit-button">Kayıt Ol</button>
    <div id="loading-indicator" style="display: none;">Yükleniyor...</div>
</form>
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

<script src="{{ asset('js/app.js') }}"></script>