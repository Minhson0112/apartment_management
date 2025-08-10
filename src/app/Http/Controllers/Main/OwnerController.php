<?php

namespace App\Http\Controllers\Main;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Repositories\Owner\OwnerRepositoryInterface;
use App\Repositories\OwnerImage\OwnerImageRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Owner\AddOwnerRequest;
use App\Http\Requests\Owner\SearchOwnerRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;
use Illuminate\Support\Facades\Log;

class OwnerController extends Controller
{
    protected OwnerRepositoryInterface $ownerRepo;
    protected OwnerImageRepositoryInterface $ownerImgRepo;

    public function __construct(
        OwnerRepositoryInterface $ownerRepo,
        OwnerImageRepositoryInterface $ownerImgRepo
    )
    {
        $this->ownerRepo = $ownerRepo;
        $this->ownerImgRepo = $ownerImgRepo;
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

    public function store(AddOwnerRequest $request) 
    {
        DB::beginTransaction();
        try {
            $owner = $this->ownerRepo->create([
                'cccd' => $request['cccd'],
                'full_name' => $request['full_name'],
                'date_of_birth' => $request['date_of_birth'],
                'mobile_number' => $request['mobile_number'],
                'email' => $request['email'],
            ]);

            $savedImages = [];
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $file) {
                    // đặt tên file duy nhất
                    $filename = Str::uuid()->toString() . '.' . $file->getClientOriginalExtension();
                    // lưu theo thư mục owners/{cccd}/
                    $path = $file->storeAs("owners/{$owner->cccd}", $filename, 'public'); // disk 'public'

                    $savedImages[] = [
                        'owner' => $owner->cccd,
                        'image_file_name'=> $path, // lưu path tương đối trên disk
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                if (!empty($savedImages)) {
                    $this->ownerImgRepo->createMany($savedImages);
                }
            }

            DB::commit();

            return response()->json([
                'status'  => 'success',
                'message' => 'Lưu chủ căn hộ thành công.',
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

    public function showImage() 
    {

    }
    
    public function search(searchOwnerRequest $request) 
    {
        $filters = $request->validated();
        $perPage = (int) $request->input('per_page', self::DEFAULT_PER_PAGE);

        $owners = $this->ownerRepo
        ->search($filters)
        ->paginate($perPage)
        ->appends($request->query());

        return view('main.owner', compact('owners', 'perPage'));
    }
}
