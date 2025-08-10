<!-- resources/views/main/apartment.blade.php -->
@extends('layouts.app')

@section('title', 'apartment')

@php
    use Illuminate\Support\Facades\Auth;
    use App\Enums\UserRole;
    $isAdmin = Auth::user()->role === UserRole::ADMIN->value;
@endphp

@section('content')
<div id="apartment-page" class="page-content">
    <h1 class="page-title">Danh sách căn hộ</h1>
    @if ($errors->any())
        <div class="alert alert-danger" role="alert" style="margin-bottom: .75rem;">
            <strong>Không thể tìm kiếm:</strong>
            <ul style="margin: .5rem 0 0 1rem;">
                @foreach ($errors->all() as $msg)
                    <li>{{ $msg }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    {{-- Form tìm kiếm --}}
    <form id="search-form" class="search-form" method="GET" action="{{ route('apartment') }}">
        {{-- Mỗi nhóm tìm kiếm là một section có border-bottom --}}
        <div class="search-section">
            <label for="apartment_name" class="section-label">Tên căn hộ</label>
            <input
                type="text"
                name="apartment_name"
                id="apartment_name"
                class="form-control large-input"
                value="{{ request('apartment_name') }}"
                placeholder="Nhập tên căn hộ"
            >
        </div>

        @error('apartment_name')
            <div class="error-text">{{ $message }}</div>
        @enderror

        <div class="search-section">
            <label class="section-label">Kiểu phòng</label>
            <div class="options-inline">
                @foreach(['1'=> '1 phòng ngủ', '2'=>'2 phòng ngủ', '3'=>'3 phòng ngủ', '4'=>'4 phòng ngủ'] as $val => $label)
                <label class="form-check-inline">
                    <input
                        type="checkbox"
                        name="type[]"
                        value="{{ $val }}"
                        @if(in_array($val, request('type', []))) checked @endif
                    >
                    {{ $label }}
                </label>
                @endforeach
            </div>
        </div>

        <div class="search-section">
            <label class="section-label">Diện tích (m²)</label>
            <div class="range-inputs">
                <input
                    type="number"
                    name="area_min"
                    class="form-control large-input"
                    value="{{ request('area_min') }}"
                    placeholder="Từ"
                    min="0"
                >
                <span class="range-separator">-</span>
                <input
                    type="number"
                    name="area_max"
                    class="form-control large-input"
                    value="{{ request('area_max') }}"
                    placeholder="Đến"
                    min="0"
                >
            </div>
        </div>

        @error('area_min')
            <div class="error-text">{{ $message }}</div>
        @enderror

        @error('area_max')
            <div class="error-text">{{ $message }}</div>
        @enderror

        @if($isAdmin)
        <div class="search-section">
            <label class="section-label">Trạng thái</label>
            <div class="options-inline">
                @foreach([
                    '1' => 'Trống',
                    '2' => 'Đã đặt cọc',
                    '3' => 'Khách đang ở',
                    '4' => 'Không khả dụng'
                ] as $val => $label)
                <label class="form-check-inline">
                    <input
                        type="checkbox"
                        name="status[]"
                        value="{{ $val }}"
                        @if(in_array($val, request('status', []))) checked @endif
                    >
                    {{ $label }}
                </label>
                @endforeach
            </div>
        </div>
        @endif

        <div class="search-section">
            <label class="section-label">Nhận phòng</label>
            <div class="range-inputs">
                <input type="date" name="check_in_from" class="form-control large-input" value="{{ request('check_in_from') }}">
                <span class="range-separator">-</span>
                <input type="date" name="check_in_to" class="form-control large-input" value="{{ request('check_in_to') }}">
            </div>
        </div>

        @error('check_in_from')
            <div class="error-text">{{ $message }}</div>
        @enderror

        @error('check_in_to')
            <div class="error-text">{{ $message }}</div>
        @enderror
        
        <div class="search-section">
            <label class="section-label">Trả phòng</label>
            <div class="range-inputs">
                <input type="date" name="check_out_from" class="form-control large-input" value="{{ request('check_out_from') }}">
                <span class="range-separator">-</span>
                <input type="date" name="check_out_to" class="form-control large-input" value="{{ request('check_out_to') }}">
            </div>
        </div>

        @error('check_out_from')
            <div class="error-text">{{ $message }}</div>
        @enderror

        @error('check_out_to')
            <div class="error-text">{{ $message }}</div>
        @enderror

        <div class="search-actions">
            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
            <a href="{{ route('apartment') }}" class="btn btn-secondary btn-reset">Xóa bộ lọc</a>
        </div>
    </form>

    <!-- @if($isAdmin)
        <button id="add_apartment">
            <img src="{{ asset('images/addButton.png') }}" alt="add">
        </button>
    @endif -->

    {{-- Bảng kết quả --}}
    <div class="table-wrapper">
        <table class="table-list">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Loại</th>
                    <th>Diện tích (m²)</th>
                    <th>Trạng thái</th>
                    <th>Nhận phòng</th>
                    <th>Trả phòng</th>
                    <th>Ảnh</th>
                    @if($isAdmin)
                    <th>Chi Tiết</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($apartments as $apt)
                    <tr>
                        <td>{{ $apt->id }}</td>
                        <td>{{ $apt->apartment_name }}</td>
                        <td>{{ $apt->type }}</td>
                        <td>{{ $apt->area }}</td>
                        <td>{{ $apt->status }}</td>
                        <td>{{ $apt->check_in_date->format('Y-m-d') }}</td>
                        <td>{{ $apt->check_out_date->format('Y-m-d') }}</td>
                        <td>
                            <a href="{{ route('apartment.image', ['id' => $apt->id]) }}" class="action-detail">
                                <img src="{{ asset('images/image.png') }}" alt="Ảnh">
                            </a>
                        </td>
                        @if($isAdmin)
                        <td>
                            <a href="{{ route('apartment.detail', ['id' => $apt->id]) }}" class="action-detail">
                                <img src="{{ asset('images/detail.png') }}" alt="Chi tiết">
                            </a>
                        </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ $isAdmin ? 9 : 8 }}">Chưa có dữ liệu</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-wrapper">
        {{ $apartments->links() }}
    </div>
</div>
@endsection
