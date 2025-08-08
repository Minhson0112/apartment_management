<?php

namespace App\Providers;

use App\Repositories\Apartment\ApartmentRepository;
use App\Repositories\Apartment\ApartmentRepositoryInterface;
use App\Repositories\Owner\OwnerRepository;
use App\Repositories\Owner\OwnerRepositoryInterface;
use App\Repositories\OwnerImage\OwnerImageRepository;
use App\Repositories\OwnerImage\OwnerImageRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{
    public function register(): void
    {
        // Bind từng interface với implementation
        $this->app->bind(ApartmentRepositoryInterface::class, ApartmentRepository::class);
        $this->app->bind(OwnerRepositoryInterface::class, OwnerRepository::class);
        $this->app->bind(OwnerImageRepositoryInterface::class, OwnerImageRepository::class);
    }

    public function boot(): void
    {
        //
    }
}
