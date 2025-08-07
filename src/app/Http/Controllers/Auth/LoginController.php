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
            // Lấy role sau khi đăng nhập thành công
            $user = Auth::user();

            return match ($user->role) {
                UserRole::ADMIN->value => redirect('/admin/dashboard'),
                UserRole::MANAGER->value => redirect('/manager/home'),
                UserRole::COLLABORATOR->value => redirect('/collab/workspace'),
                default => redirect('/home'),
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
