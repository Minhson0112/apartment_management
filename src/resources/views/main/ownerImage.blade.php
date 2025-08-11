@extends('layouts.app')

@section('title', 'Ảnh chủ căn hộ')
@vite(['resources/css/ownerImage.css'])
@section('content')
<div class="page-content owner-images" id="owner-images-page">
    <h1 class="owner-images__title">
        Ảnh của chủ hộ: {{ $owner->full_name }} (CCCD: {{ $owner->cccd }})
    </h1>

    {{-- Flash message --}}
    @if (session('success'))
        <div class="alert alert-success owner-images__alert">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger owner-images__alert">
            <ul>
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form thêm ảnh --}}
    <div class="owner-images__form-card">
        <h3 class="owner-images__form-title">Thêm ảnh mới</h3>
        <form action="{{ route('owner.image.store', ['cccd' => $owner->cccd]) }}"
              method="POST"
              enctype="multipart/form-data"
              class="owner-images__form">
            @csrf
            <input type="file" name="images[]" accept="image/*" multiple class="owner-images__file-input">
            <div class="owner-images__form-actions">
                <button type="submit" class="btn btn-primary">Tải lên</button>
                <a href="{{ route('owner') }}" class="btn btn-secondary">Quay lại danh sách</a>
            </div>
        </form>
    </div>

    {{-- Danh sách ảnh --}}
    <div class="owner-images__list">
        @forelse ($images as $img)
            <div class="owner-images__item">
                <div class="owner-images__item-content">
                    <img src="{{ $img->url }}"
                         alt="owner image"
                         class="owner-images__img">
                    <div class="owner-images__info">
                        <div class="owner-images__date">
                            <strong>Uploaded:</strong> {{ $img->created_at }}
                        </div>

                        <form action="{{ route('owner.image.delete', ['cccd' => $owner->cccd, 'imageId' => $img->id]) }}"
                              method="POST"
                              onsubmit="return confirm('Xóa ảnh này?');"
                              class="owner-images__delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Xóa ảnh</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-info owner-images__empty">Chưa có ảnh nào.</div>
        @endforelse
    </div>
</div>
@endsection
