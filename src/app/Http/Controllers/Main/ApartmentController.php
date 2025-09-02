<?php

namespace App\Http\Controllers\Main;

use App\Enums\ApartmentStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Apartment\AddApartmentRequest;
use App\Http\Requests\Apartment\ContractExtensionRequest;
use App\Http\Requests\Apartment\UpdateApartmentRequest;
use App\Http\Requests\Apartment\SearchApartmentRequest;
use App\Repositories\Apartment\ApartmentRepositoryInterface;
use App\Repositories\ApartmentImage\ApartmentImageRepositoryInterface;
use App\Repositories\ContractExtension\ContractExtensionRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;
use Illuminate\Support\Facades\Auth;
use App\Enums\UserRole;
use App\Http\Requests\Apartment\AddApartmentImageRequest;

class ApartmentController extends Controller
{
    protected ApartmentRepositoryInterface $apartRepo;
    protected ApartmentImageRepositoryInterface $apartImgRepo;
    protected ContractExtensionRepositoryInterface $contractExtensionRepo;

    public function __construct(
        ApartmentRepositoryInterface $apartRepo,
        ApartmentImageRepositoryInterface $apartImgRepo,
        ContractExtensionRepositoryInterface $contractExtensionRepo
    ) {
        $this->apartRepo = $apartRepo;
        $this->apartImgRepo = $apartImgRepo;
        $this->contractExtensionRepo = $contractExtensionRepo;
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
                'balcony_direction' => $request['balcony_direction'],
                'toilet_count' => $request['toilet_count'],
                'note' => $request['note'],
                'youtube_url' => $request['youtube_url'],
                'apartment_owner' => $request['apartment_owner'],
                'appliances_price' => $request['appliances_price'],
                'rent_price' => $request['rent_price'],
                'rent_start_time' => $request['rent_start_time'],
                'rent_end_time' => $request['rent_end_time'],
            ]);

            $this->contractExtensionRepo->create([
                'apartment' => $apartment->id,
                'rent_start_time' => $request['rent_start_time'],
                'rent_end_time' => $request['rent_end_time'],
                'rent_price' => $request['rent_price'],
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
            Log::error($e->getMessage());
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

    public function detail(string $id, Request $request)
    {
        if (Auth::user()->role != UserRole::ADMIN->value) {
            return response()->view('error.permission', [], 403);
        }

        $perPage = (int) $request->input('per_page', self::DEFAULT_PER_PAGE);

        $apartment = $this->apartRepo->detail($id);
        $contracts = $this->contractExtensionRepo
            ->findByApartmentId($id)
            ->paginate($perPage)
            ->withQueryString();

        return view('apartment.detail', compact('apartment', 'contracts', 'perPage'));
    }

    public function deleteImage(string $apartmentId, int $imageId)
    {
         $img = $this->apartImgRepo->findByIdAndApartmentId($imageId, $apartmentId);

    // xóa file trên disk
    Storage::disk('public')->delete($img->image_file_name);

    // xóa record trong DB
    $this->apartImgRepo->deleteById($imageId);

    return redirect()
        ->route('apartment.image', ['id' => $apartmentId])
        ->with('success', 'Đã xóa ảnh.');
    }

    public function storeImages(AddApartmentImageRequest $request, string $apartmentId )
    {
         $savedImages = [];
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $file) {
            // đặt tên file duy nhất
            $filename = Str::uuid()->toString() . '.' . $file->getClientOriginalExtension();
            // lưu theo thư mục apartments/{id}/
            $path = $file->storeAs("apartments/{$apartmentId}", $filename, 'public'); 

            $savedImages[] = [
                'apartment' => $apartmentId,
                'image_file_name' => $path, // lưu path tương đối
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if (!empty($savedImages)) {
            $this->apartImgRepo->createMany($savedImages);
        }
    }

    return redirect()
        ->route('apartment.image', ['id' => $apartmentId])
        ->with('success', 'Đã thêm ảnh thành công.');
    }

    public function contractExtension(string $id, ContractExtensionRequest $request)
    {
        $apartment = $this->apartRepo->findByIdOrFail($id);
        $newRentPrice = $apartment->rent_price += $request['rent_price'];

        DB::beginTransaction();
        try {
            $UpdateApartmentCount = $this->apartRepo->updateById(
                $id,
                [
                    'rent_price' => $newRentPrice,
                    'rent_start_time' => $request['rent_start_time'],
                    'rent_end_time' => $request['rent_end_time'],
                ],
            );

            $this->contractExtensionRepo->create([
                'apartment' => $apartment->id,
                'rent_start_time' => $request['rent_start_time'],
                'rent_end_time' => $request['rent_end_time'],
                'rent_price' => $request['rent_price'],
            ]);

            if (!$UpdateApartmentCount) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Có lỗi xảy ra khi lưu dữ liệu.'
                ], 500);

                DB::rollBack();
            }

            DB::commit();
            return response()->json([
                'status'  => 'success',
                'message' => 'Lưu căn hộ thành công.',
            ], 201);

        } catch (Throwable $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return response()->json([
                'status'  => 'error',
                'message' => 'Có lỗi xảy ra khi lưu dữ liệu.',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    public function update(string $id, UpdateApartmentRequest $request)
    {
        DB::beginTransaction();
        try {
            $UpdateApartmentCount = $this->apartRepo->updateById(
                $id,
                [
                    'apartment_name' => $request['apartment_name'],
                    'type' => $request['type'],
                    'area' => $request['area'],
                    'balcony_direction' => $request['balcony_direction'],
                    'toilet_count' => $request['toilet_count'],
                    'note' => $request['note'],
                    'youtube_url' => $request['youtube_url'],
                    'apartment_owner' => $request['apartment_owner'],
                    'appliances_price' => $request['appliances_price'],
                ],
            );

            if (!$UpdateApartmentCount) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Có lỗi xảy ra khi lưu dữ liệu.'
                ], 500);

                DB::rollBack();
            }

            DB::commit();
            return response()->json([
                'status'  => 'success',
                'message' => 'Lưu căn hộ thành công.',
            ], 201);

        } catch (Throwable $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return response()->json([
                'status'  => 'error',
                'message' => 'Có lỗi xảy ra khi lưu dữ liệu.',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    public function info()
    {
        //TODO
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
