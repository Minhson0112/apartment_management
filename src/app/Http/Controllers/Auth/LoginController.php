<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        // validate
        $credentials = $request->only('user_name', 'password');

        // attempt với user_name
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            // lấy role sau khi đăng nhập thành công
            $user = Auth::user();
            // role khác nhau sau khi đăng nhập sẽ đến các trang khác nhau
            return match ($user->role) {
                UserRole::ADMIN->value => redirect('/dashboard'),
                UserRole::MANAGER->value => redirect('/apartment'),
                UserRole::COLLABORATOR->value => redirect('/apartment'),
                default => redirect('/apartment'),
            };
        }

        // nếu mật khẩu hoặc tài khoải sai trả về lỗi và giữ nguyên trường user name
        return back()
            ->withErrors(['errorMsg' => 'Tên đăng nhập hoặc mật khẩu sai.'])
            ->onlyInput('user_name');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
