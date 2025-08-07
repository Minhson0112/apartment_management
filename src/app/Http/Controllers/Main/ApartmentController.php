<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Repositories\Apartment\ApartmentRepositoryInterface;
use Illuminate\Http\Request;

class ApartmentController extends Controller
{
    protected ApartmentRepositoryInterface $apartRepo;

    public function __construct(ApartmentRepositoryInterface $apartRepo)
    {
        $this->apartRepo = $apartRepo;
    }

    public function showApartment(Request $request)
    {
        $perPage = (int) $request->input('per_page', self::DEFAULT_PER_PAGE);

        $apartments = $this->apartRepo
            ->queryForAdmin()
            ->paginate($perPage)
            ->withQueryString();

        return view('main.apartment', compact('apartments', 'perPage'));
    }
}
