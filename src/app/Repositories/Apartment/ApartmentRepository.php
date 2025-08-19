<?php

namespace App\Repositories\Apartment;

use App\Enums\ApartmentStatus;
use App\Enums\UserRole;
use App\Models\Apartment;
use App\Repositories\Base\BaseRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ApartmentRepository extends BaseRepository implements ApartmentRepositoryInterface
{
    #[\Override]
    public function getModel(): string
    {
        return Apartment::class;
    }

    #[\Override]
    public function create(array $obj): Model
    {
        return parent::create($obj);
    }

    #[\Override]
    public function queryAll(): Builder
    {
        return parent::queryAll();
    }

    public function getApartments(): Builder
    {
        $query = $this->queryAll()
            ->select([
                'id',
                'apartment_name',
                'type',
                'area',
                'balcony_direction',
                'toilet_count',
                'status',
                'check_in_date',
                'check_out_date',
            ]);

        // Giới hạn cho COLLABORATOR
        if (Auth::user()?->role === UserRole::COLLABORATOR->value) {
            // chỉ cho 1,2,3
            $allowed = [
                ApartmentStatus::AVAILABLE->value,
                ApartmentStatus::RESERVED->value,
                ApartmentStatus::CHECKED_IN->value,
            ];

            $upperBound = Carbon::now()->addMonth()->toDateString();

            $query->whereIn('status', $allowed)
                ->where(function ($q) use ($upperBound) {
                    $q->where('status', '!=', ApartmentStatus::CHECKED_IN->value)
                        ->orWhereDate('check_out_date', '<=', $upperBound);
                });
        }

        return $query;
    }

    public function search(array $filters): Builder
    {
        $query = $this->queryAll();

        if (!empty($filters['apartment_name'])) {
            $query->where('apartment_name', 'like', '%' . $filters['apartment_name'] . '%');
        }

        if (!empty($filters['type'])) {
            $query->whereIn('type', $filters['type']);
        }

        if (!empty($filters['area_min'])) {
            $query->where('area', '>=', $filters['area_min']);
        }

        if (!empty($filters['area_max'])) {
            $query->where('area', '<=', $filters['area_max']);
        }

        if (!empty($filters['status'])) {
            $query->whereIn('status', $filters['status']);
        }

        if (!empty($filters['balcony_direction'])) {
            $query->whereIn('balcony_direction', $filters['balcony_direction']);
        }

        if (!empty($filters['check_in_from'])) {
            $query->whereDate('check_in_date', '>=', $filters['check_in_from']);
        }

        if (!empty($filters['check_in_to'])) {
            $query->whereDate('check_in_date', '<=', $filters['check_in_to']);
        }

        if (!empty($filters['check_out_from'])) {
            $query->whereDate('check_out_date', '>=', $filters['check_out_from']);
        }

        if (!empty($filters['check_out_to'])) {
            $query->whereDate('check_out_date', '<=', $filters['check_out_to']);
        }

        // --- Giới hạn cho COLLABORATOR: chỉ xem check_out_date trong 1 tháng đổ lại (<= today + 1 month)
        if (Auth::user()?->role === UserRole::COLLABORATOR->value) {
            // Chỉ cho 1,2,3
            $allowed = [
                ApartmentStatus::AVAILABLE->value,
                ApartmentStatus::RESERVED->value,
                ApartmentStatus::CHECKED_IN->value,
            ];
            $query->whereIn('status', $allowed);

            // Nếu CHECKED_IN thì yêu cầu check_out_date <= today+1m
            $upperBound = Carbon::now()->addMonth()->toDateString();
            $query->where(function ($q) use ($upperBound) {
                $q->where('status', '!=', ApartmentStatus::CHECKED_IN->value)
                    ->orWhereDate('check_out_date', '<=', $upperBound);
            });
        }

        return $query;
    }

    public function detail($id): Model
    {
        return $this->model::with(['owner:cccd,full_name,mobile_number,email'])
            ->findOrFail($id);
    }
}
