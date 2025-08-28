@extends('layouts.app')

@section('title', 'owner')

@vite(['resources/js/customer.js', 'resources/js/addCustomer.js'])

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
            <label for="origin" class="section-label" value="{{ old('origin', request('origin')) }}">Nguồn</label>
            <select id="origin" name="origin" class="form-control large-input @error('origin') is-invalid @enderror">
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
                    <th>Chỉnh sửa</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $customer)
                    <tr>
                        <td>{{ $customer->cccd }}</td>
                        <td>{{ $customer->full_name }}</td>
                        <td>{{ $customer->date_of_birth }}</td>
                        <td>{{ $customer->phone_number }}</td>
                        <td>{{ $customer->email }}</td>
                        <td>{{ $customer->user->full_name }}</td>
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
                        <td>
                            <a href="" id="show_modify" class="action-detail">
                                <img src="{{ asset('images/modify.png') }}" alt="chỉnh sửa">
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9">Chưa có dữ liệu</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-wrapper">
        {{ $customers->links() }}
    </div>
</div>
<div id="add-customer-modal" class="modal-overlay">
    <div class="modal-content">
        <h2>Thêm khánh hàng</h2>
        <form id="add-customer-form" action="{{ route('customer.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="cccd">CCCD</label>
                <input type="text" id="cccd" name="cccd" required>
            </div>
            <div class="form-group">
                <label for="full_name">Tên</label>
                <input type="text" id="full_name" name="full_name" required>
            </div>
            <div class="form-group">
                <label for="date_of_birth">Ngày Sinh</label>
                <input type="date" id="date_of_birth" name="date_of_birth" required>
            </div>

            <div class="form-group">
                <label for="phone_number">Số điện thoại</label>
                <input type="text" id="phone_number" name="phone_number" placeholder="VD: 0912345678">
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="VD: example@gmail.com">
            </div>

            <div class="form-group">
                <label for="note_input">Ghi chú</label>
                <textarea rows="10" cols="50" type="text" id="note_input" name="note"></textarea>
            </div>

            <div class="form-group">
                <label for="origin">Nguồn</label>
                <select id="origin" name="origin" required>
                    <option value="">-- Chọn --</option>
                </select>
            </div>

            <div class="form-group">
                <label>Ảnh</label>
                <div id="drop-area" class="drop-area">
                    <p>Kéo thả hoặc nhấp để chọn ảnh</p>
                    <input type="file" id="images" name="images[]" accept="image/*" multiple>
                </div>
                <ul id="file-list" class="file-list"></ul>
            </div>

            <div class="form-actions">
                <button type="submit">Thêm</button>
                <button type="button" id="cancel-modal">Hủy</button>
            </div>
        </form>
    </div>
</div>
@endsection
