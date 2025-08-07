<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>Đăng nhập</title>

    {{-- load login.css và login.js từ Vite --}}
    @vite(['resources/css/login.css', 'resources/js/login.js'])
</head>
<body>
    <div class="login-card">
        <h2>Đăng nhập</h2>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label for="user_name">User Name</label>
                <input id="user_name" type="text" name="user_name" value="{{ old('user_name') }}" autofocus>
            </div>
            <div class="error">
                @error('user_name')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="password">Mật khẩu</label>
                <div class="password-wrapper">
                    <input id="password" type="password" name="password">
                    <span id="togglePassword" class="toggle-password">👁️</span>
                </div>
            </div>
            <div class="error">
                @error('password')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>
            <div class="error">
                @error('errorMsg')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="btn">Đăng nhập</button>
        </form>
    </div>
</body>
</html>
