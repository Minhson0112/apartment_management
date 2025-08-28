<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Repositories\User\UserRepositoryInterface;

class UserController extends Controller
{
    protected UserRepositoryInterface $userRepo;

    public function __construct(
        UserRepositoryInterface $userRepo
    ) {
        $this->userRepo = $userRepo;
    }

    public function getAll()
    {
        $users = $this->userRepo->all();

        $result = $users->map(function ($user) {
            return [
                'cccd' => $user->cccd,
                'full_name' => $user->full_name,
            ];
        });

        return response()->json($result);
    }
}
