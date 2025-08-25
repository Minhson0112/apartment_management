@extends('layouts.app')

@section('title', 'owner')

<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')
<div id="customer-page" class="page-content">
    <h1 class="page-title">Danh sách khách hàng</h1>
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
    {{-- Form tìm kiếm customer --}}
    <form action="{{ route('customer.search') }}" method="GET" class="search-form">
        <div class="search-section">
            <label for="search_cccd" class="section-label">CCCD</label>
            <input
                type="text"
                id="search_cccd"
                name="cccd"
                class="form-control large-input @error('cccd') is-invalid @enderror"
                value="{{ old('cccd', request('cccd')) }}"
            >
            @error('cccd')
                <div class="error-text">{{ $message }}</div>
            @enderror
        </div>

        <div class="search-section">
            <label for="search_full_name" class="section-label">Tên khách hàng</label>
            <input
                type="text"
                id="search_full_name"
                name="full_name"
                class="form-control large-input @error('full_name') is-invalid @enderror"
                value="{{ old('full_name', request('full_name')) }}"
            >
            @error('full_name')
                <div class="error-text">{{ $message }}</div>
            @enderror
        </div>

        <div class="search-section">
            <label for="search_apartment_name" class="section-label">Tên căn hộ</label>
            <input
                type="text"
                id="search_apartment_name"
                name="apartment_name"
                class="form-control large-input @error('apartment_name') is-invalid @enderror"
                value="{{ old('apartment_name', request('apartment_name')) }}"
                placeholder="VD: T81702..."
            >
            @error('apartment_name')
                <div class="error-text">{{ $message }}</div>
            @enderror
        </div>

        <div class="search-section">
            <label class="section-label">Ngày sinh</label>
            <div class="range-inputs">
                <input
                    type="date"
                    id="search_date_from"
                    name="date_from"
                    class="form-control large-input @error('date_from') is-invalid @enderror"
                    value="{{ old('date_from', request('date_from')) }}"
                >
                <span class="range-separator">-</span>
                <input
                    type="date"
                    id="search_date_to"
                    name="date_to"
                    class="form-control large-input @error('date_to') is-invalid @enderror"
                    value="{{ old('date_to', request('date_to')) }}"
                >
            </div>
            @error('date_from') <div class="error-text">{{ $message }}</div> @enderror
            @error('date_to')   <div class="error-text">{{ $message }}</div> @enderror
        </div>

        <div class="search-section">
            <label for="search_mobile_number" class="section-label">Số điện thoại</label>
            <input
                type="text"
                id="search_mobile_number"
                name="mobile_number"
                class="form-control large-input @error('mobile_number') is-invalid @enderror"
                value="{{ old('mobile_number', request('mobile_number')) }}"
                placeholder="VD: 0912345678"
            >
            @error('mobile_number')
                <div class="error-text">{{ $message }}</div>
            @enderror
        </div>

        <div class="search-section">
            <label for="search_email" class="section-label">Email</label>
            <input
                type="text"
                id="search_email"
                name="email"
                class="form-control large-input @error('email') is-invalid @enderror"
                value="{{ old('email', request('email')) }}"
                placeholder="VD: example@gmail.com"
            >
            @error('email')
                <div class="error-text">{{ $message }}</div>
            @enderror
        </div>

        <div class="search-section">
            <label for="search_origin" class="section-label" value="{{ old('origin', request('origin')) }}">Nguồn</label>
            <select id="search_origin" name="origin">
                <option value="">-- Chọn --</option>
            </select>
            @error('origin')
                <div class="error-text">{{ $message }}</div>
            @enderror
        </div>

        <div class="search-actions">
            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
            <a href="{{ route('customer') }}" class="btn btn-secondary btn-reset">Xóa bộ lọc</a>
        </div>
    </form>

    <div class="add-button-wapper">
        <button id='show-add-modal'>
            <img src = "{{ asset('images/addButton.png') }}" alt ="add" id='show-add-modal-img'>
        </button>
    </div>

    {{-- Bảng kết quả --}}
        <div class="table-wrapper">
        <table class="table-list">
            <thead>
                <tr>
                    <th>CCCD</th>
                    <th>Tên</th>
                    <th>Ngày Sinh</th>
                    <th>Số Điện Thoại</th>
                    <th>Email</th>
                    <th>Nguồn</th>
                    <th>Ghi chú</th>
                    <th>Ảnh</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $customer)
                    <tr>
                        <td>{{ $customer->cccd }}</td>
                        <td>{{ $customer->full_name }}</td>
                        <td>{{ $customer->date_of_birth }}</td>
                        <td>{{ $customer->mobile_number }}</td>
                        <td>{{ $customer->email }}</td>
                        <td>{{ $customer->owner->full_name }}</td>
                        <td>
                            <a href="" id="show_note" class="action-detail">
                                <img src="{{ asset('images/note.png') }}" alt="Ghi chú">
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('customer.image', ['cccd' => $customer->cccd]) }}" class="action-detail">
                                <img src="{{ asset('images/image.png') }}" alt="Ảnh">
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8">Chưa có dữ liệu</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-wrapper">
        {{ $customers->links() }}
    </div>
</div>
@endsection
