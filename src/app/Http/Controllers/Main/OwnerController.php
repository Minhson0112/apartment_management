<?php

namespace App\Http\Controllers\Main;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OwnerController extends Controller
{
    public function showOwner()
    {
        if (Auth::user()->role != UserRole::ADMIN->value) {
            return response()->view('error.permission', [], 403);
        }

        return view('main.owner');
    }
}
