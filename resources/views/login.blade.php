@extends('layouts.default')

@section('maincontent')
<div class="login-container">
    <div class="login-form">
        <img src="https://www.supergenericosdelvalle.com/wp-content/uploads/2023/12/Grupo-130.png" class="login-img" alt="Logo">
        <h1>Login</h1>

        <form method="POST" action="{{ route('login.post') }}">
            @csrf

            <div class="form-group">
                <input type="email" name="email" required>
                <label>Email</label>
                @error('email')
                    <small class="error-message">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <input type="password" name="password" required>
                <label>Password</label>
                @error('password')
                    <small class="error-message">{{ $message }}</small>
                @enderror
            </div>

          

            <div class="forgot-password">
                <a href="#">¿Olvidaste la contraseña?</a>
            </div>
            
        
            <button type="submit" class="btn btn-login">Iniciar</button>
        </form>
    </div>
</div>
@endsection
