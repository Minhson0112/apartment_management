<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Apartment\ApartmentRepositoryInterface;
use App\Repositories\Apartment\ApartmentRepository;
use App\Repositories\Owner\OwnerRepositoryInterface;
use App\Repositories\Owner\OwnerRepository;

class RepositoryProvider extends ServiceProvider
{
    public function register(): void
    {
        // Bind từng interface với implementation
        $this->app->bind(ApartmentRepositoryInterface::class, ApartmentRepository::class);
        $this->app->bind(OwnerRepositoryInterface::class, OwnerRepository::class);
    }

    public function boot(): void
    {
        //
    }
}
