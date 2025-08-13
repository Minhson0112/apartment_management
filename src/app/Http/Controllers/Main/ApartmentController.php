<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Repositories\Apartment\ApartmentRepositoryInterface;
use App\Repositories\ApartmentImage\ApartmentImageRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Requests\Apartment\AddApartmentRequest;
use App\Http\Requests\Apartment\SearchApartmentRequest;
use Illuminate\Support\Facades\DB;
use Throwable;
use App\Enums\ApartmentStatus;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ApartmentController extends Controller
{
    protected ApartmentRepositoryInterface $apartRepo;
    protected ApartmentImageRepositoryInterface $apartImgRepo;

    public function __construct(
        ApartmentRepositoryInterface $apartRepo,
        ApartmentImageRepositoryInterface $apartImgRepo
    )
    {
        $this->apartRepo = $apartRepo;
        $this->apartImgRepo = $apartImgRepo;
    }

    public function showApartment(Request $request)
    {
        $perPage = (int) $request->input('per_page', self::DEFAULT_PER_PAGE);

        $apartments = $this->apartRepo
            ->getApartments()
            ->paginate($perPage)
            ->withQueryString();

        return view('apartment.apartment', compact('apartments', 'perPage'));
    }

    public function store(AddApartmentRequest $request)
    {
        DB::beginTransaction();
        try {
            $apartment = $this->apartRepo->create([
                'apartment_name' => $request['apartment_name'],
                'type' => $request['type'],
                'area' => $request['area'],
                'status' => ApartmentStatus::AVAILABLE->value,
                'apartment_owner' => $request['apartment_owner'],
                'appliances_price' => $request['appliances_price'],
                'rent_price' => $request['rent_price'],
                'rent_start_time' => $request['rent_start_time'],
                'rent_end_time' => $request['rent_end_time'],
            ]);

            $savedImages = [];
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $file) {
                    $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs("apartments/{$apartment->id}", $filename, 'public');

                    $savedImages[] = [
                        'apartment' => $apartment->id,
                        'image_file_name' => $path,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                if (!empty($savedImages)) {
                    $this->apartImgRepo->createMany($savedImages);
                }
            }

            DB::commit();

            return response()->json([
                'status'  => 'success',
                'message' => 'Lưu căn hộ thành công.',
            ], 201);

        } catch (Throwable $e) {
            DB::rollBack();
            return response()->json([
                'status'  => 'error',
                'message' => 'Có lỗi xảy ra khi lưu dữ liệu.',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    public function showImage(string $id)
    {
        $apartment = $this->apartRepo->findByIdOrFail($id);
        $images = $this->apartImgRepo->getImages($id);
        $images = $images->map(function ($row) {
            $row->url = Storage::disk('public')->url($row->image_file_name);
            return $row;
        });

        return view('apartment.image', compact('apartment', 'images'));
    }

    public function showDetail()
    {

    }

    public function deleteImage()
    {

    }

    public function storeImages()
    {

    }

    public function search(SearchApartmentRequest $request)
    {
        $filters = $request->validated();
        $perPage = (int) $request->input('per_page', self::DEFAULT_PER_PAGE);

        $apartments = $this->apartRepo
        ->search($filters)
        ->paginate($perPage)
        ->appends($request->query());

        return view('apartment.apartment', compact('apartments', 'perPage'));
    }
}
