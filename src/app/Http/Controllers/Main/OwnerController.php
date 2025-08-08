<?php

namespace App\Http\Controllers\Main;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Repositories\Owner\OwnerRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OwnerController extends Controller
{
    protected OwnerRepositoryInterface $ownerRepo;

    public function __construct(OwnerRepositoryInterface $ownerRepo)
    {
        $this->ownerRepo = $ownerRepo;
    }

    public function showOwner(Request $request)
    {
        if (Auth::user()->role != UserRole::ADMIN->value) {
            return response()->view('error.permission', [], 403);
        }

        $perPage = (int) $request->input('per_page', self::DEFAULT_PER_PAGE);

        $owners = $this->ownerRepo
            ->queryAll()
            ->paginate($perPage)
            ->withQueryString();

        return view('main.owner', compact('owners', 'perPage'));
    }
}
