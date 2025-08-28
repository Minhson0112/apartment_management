<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Enums\UserRole;
use App\Repositories\Customer\CustomerRepositoryInterface;
use App\Repositories\CustomerImage\CustomerImageRepositoryInterface;
use App\Http\Requests\Customer\AddCustomerRequest;
use Illuminate\Support\Facades\DB;
use Throwable;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
{
    protected CustomerRepositoryInterface $customerRepo;
    protected CustomerImageRepositoryInterface $customerImgRepo;

    public function __construct(
        CustomerRepositoryInterface $customerRepo,
        CustomerImageRepositoryInterface $customerImgRepo
    ) {
        $this->customerRepo = $customerRepo;
        $this->customerImgRepo = $customerImgRepo;
    }

    public function showCustomer(Request $request)
    {
        if (Auth::user()->role != UserRole::ADMIN->value) {
            return response()->view('error.permission', [], 403);
        }

        $perPage = (int) $request->input('per_page', self::DEFAULT_PER_PAGE);

        $customers = $this->customerRepo
            ->queryAll()
            ->paginate($perPage)
            ->withQueryString();

        return view('customer.customer', compact('customers', 'perPage'));
    }

    public function search()
    {

    }

    public function showImage()
    {

    }

    public function store(AddCustomerRequest $request)
    {
        DB::beginTransaction();
        try {
            $customer = $this->customerRepo->create([
                'cccd' => $request['cccd'],
                'full_name' => $request['full_name'],
                'date_of_birth' => $request['date_of_birth'],
                'phone_number' => $request['phone_number'],
                'email' => $request['email'],
                'note' => $request['note'],
                'origin' => $request['origin'],
            ]);

            $savedImages = [];
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $file) {
                    // đặt tên file duy nhất
                    $filename = Str::uuid()->toString() . '.' . $file->getClientOriginalExtension();
                    // lưu theo thư mục customers/{cccd}/
                    $path = $file->storeAs("customers/{$customer->cccd}", $filename, 'public'); // disk 'public'

                    $savedImages[] = [
                        'customer' => $customer->cccd,
                        'image_file_name' => $path, // lưu path tương đối trên disk
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                if (!empty($savedImages)) {
                    $this->customerImgRepo->createMany($savedImages);
                }
            }

            DB::commit();

            return response()->json([
                'status'  => 'success',
                'message' => 'Lưu khách hàng thành công.',
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
}
