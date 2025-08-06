<!DOCTYPE html>
<html lang="en">
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
        <input id="user" type="text" name="user_name" required autofocus>
      </div>
      <div class="form-group">
        <label for="password">Mật khẩu</label>
        <div class="password-wrapper">
          <input id="password" type="password" name="password" required>
          <span id="togglePassword" class="toggle-password">👁️</span>
        </div>
      </div>
      @error('user_name')
        <div class="error">
          <span class="error-msg">{{ $message }}</span>
        </div>
      @enderror
      <button type="submit" class="btn">Đăng nhập</button>
    </form>
  </div>
</body>
</html>
