<?php

namespace App\Providers;

use App\Repositories\Apartment\ApartmentRepository;
use App\Repositories\Apartment\ApartmentRepositoryInterface;
use App\Repositories\ApartmentImage\ApartmentImageRepository;
use App\Repositories\ApartmentImage\ApartmentImageRepositoryInterface;
use App\Repositories\Owner\OwnerRepository;
use App\Repositories\Owner\OwnerRepositoryInterface;
use App\Repositories\OwnerImage\OwnerImageRepository;
use App\Repositories\OwnerImage\OwnerImageRepositoryInterface;
use App\Repositories\ContractExtension\ContractExtensionRepository;
use App\Repositories\ContractExtension\ContractExtensionRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{
    public function register(): void
    {
        // Bind từng interface với implementation
        $this->app->bind(ApartmentRepositoryInterface::class, ApartmentRepository::class);
        $this->app->bind(OwnerRepositoryInterface::class, OwnerRepository::class);
        $this->app->bind(OwnerImageRepositoryInterface::class, OwnerImageRepository::class);
        $this->app->bind(ApartmentImageRepositoryInterface::class, ApartmentImageRepository::class);
        $this->app->bind(ContractExtensionRepositoryInterface::class, ContractExtensionRepository::class);
    }

    public function boot(): void
    {
        //
    }
}
