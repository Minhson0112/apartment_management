<?php

namespace App\Http\Controllers\Main;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashBoardController extends Controller
{
    public function showDashBoard()
    {
        if (Auth::user()->role != UserRole::ADMIN->value) {
            return redirect()->route('login');
        }

        return view('main.dashboard');
    }
}
