<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Apartment\ApartmentRepositoryInterface;
use App\Repositories\Apartment\ApartmentRepository;



class RepositoryProvider extends ServiceProvider
{
    public function register(): void
    {
        // Bind từng interface với implementation
        $this->app->bind(ApartmentRepositoryInterface::class,ApartmentRepository::class);
    }

    public function boot(): void
    {
        //
    }
}
