<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;

class ApartmentController extends Controller
{
    public function showApartment()
    {
        return view('main.apartment');
    }
}
