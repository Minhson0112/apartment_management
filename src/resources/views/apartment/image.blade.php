@extends('layouts.app')

@section('title', 'Ảnh căn hộ')
@vite(['resources/css/apartmentImage.css'])

@php
    use Illuminate\Support\Facades\Auth;
    use App\Enums\UserRole;
    use App\Enums\ApartmentType;
    $isAdmin = Auth::user()->role === UserRole::ADMIN->value;
@endphp

@section('content')
<div class="page-content apt-images" id="apt-images-page">
    <h1 class="apt-images__title">
        Ảnh căn hộ: {{ $apartment->apartment_name }}
    </h1>

    <div class="apt-images__alert">
        <strong>Thông tin:</strong>
        <div>Kiểu phòng: {{ \App\Enums\ApartmentType::tryFrom($apartment->type)?->label() ?? '' }}</div>
        <div>Diện tích: {{ $apartment->area }} m²</div>
    </div>

    @if (session('success'))
        <div class="alert alert-success apt-images__alert">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger apt-images__alert">
            <ul>
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if($isAdmin)
        <div class="apt-images__form-card">
            <h3 class="apt-images__form-title">Thêm ảnh mới</h3>
            <form action="{{ route('apartment.image.store', ['id' => $apartment->id]) }}"
                  method="POST" enctype="multipart/form-data"
                  class="apt-images__form">
                @csrf
                <input type="file" name="images[]" accept="image/*" multiple class="apt-images__file-input">
                <div class="apt-images__form-actions">
                    <button type="submit" class="btn btn-primary">Tải lên</button>
                    <a href="{{ route('apartment') }}" class="btn btn-secondary">Quay lại danh sách</a>
                </div>
            </form>
        </div>
    @endif

    <div class="apt-images__list">
        @forelse ($images as $img)
            <div class="apt-images__item">
                <div class="apt-images__item-content">
                    <img src="{{ $img->url ?? asset('storage/'.$img->image_file_name) }}"
                         alt="apartment image"
                         class="apt-images__img">
                    <div class="apt-images__info">
                        <div class="apt-images__date">
                            <strong>Uploaded:</strong> {{ $img->created_at }}
                        </div>
                        @if($isAdmin)
                        <form action="{{ route('apartment.image.delete', ['id' => $apartment->id, 'imageId' => $img->id]) }}"
                              method="POST"
                              onsubmit="return confirm('Xóa ảnh này?');"
                              class="apt-images__delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Xóa ảnh</button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-info apt-images__empty">Chưa có ảnh nào.</div>
        @endforelse
    </div>
</div>
@endsection
