<!-- resources/views/main/apartment.blade.php -->
@extends('layouts.app')

@section('title', 'apartment')
@vite(['resources/js/addApartment.js'])
<meta name="csrf-token" content="{{ csrf_token() }}">
@php
    use Illuminate\Support\Facades\Auth;
    use App\Enums\UserRole;
    use App\Enums\ApartmentType;
    use App\Enums\ApartmentStatus;
    use App\Enums\BalconyDirection;
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
    <form id="search-form" class="search-form" method="GET" action="{{ route('apartment.search') }}">
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
                @foreach([ApartmentType::ONE_BEDROOM->value => ApartmentType::ONE_BEDROOM->label(), ApartmentType::TWO_BEDROOM->value => ApartmentType::TWO_BEDROOM->label(), ApartmentType::THREE_BEDROOM->value => ApartmentType::THREE_BEDROOM->label(), ApartmentType::FOUR_BEDROOM->value => ApartmentType::FOUR_BEDROOM->label()] as $val => $label)
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

        <div class="search-section">
            <label class="section-label">Hướng ban công</label>
            <div class="options-inline">
                @foreach([BalconyDirection::EAST->value => BalconyDirection::EAST->label(), BalconyDirection::WEST->value => BalconyDirection::WEST->label(), BalconyDirection::SOUTH->value => BalconyDirection::SOUTH->label(), BalconyDirection::NORTH->value => BalconyDirection::NORTH->label(), BalconyDirection::SOUTHEAST->value => BalconyDirection::SOUTHEAST->label(), BalconyDirection::NORTHWEST->value => BalconyDirection::NORTHWEST->label(), BalconyDirection::SOUTHWEST->value => BalconyDirection::SOUTHWEST->label(), BalconyDirection::NORTHEAST->value => BalconyDirection::NORTHEAST->label(), ] as $val => $label)
                <label class="form-check-inline">
                    <input
                        type="checkbox"
                        name="balcony_direction[]"
                        value="{{ $val }}"
                        @if(in_array($val, request('type', []))) checked @endif
                    >
                    {{ $label }}
                </label>
                @endforeach
            </div>
        </div>
        @error('balcony_direction')
            <div class="error-text">{{ $message }}</div>
        @enderror

        @if($isAdmin)
            <div class="search-section">
                <label class="section-label">Trạng thái</label>
                <div class="options-inline">
                    @foreach([
                        ApartmentStatus::AVAILABLE->value => ApartmentStatus::AVAILABLE->label(),
                        ApartmentStatus::RESERVED->value => ApartmentStatus::RESERVED->label(),
                        ApartmentStatus::CHECKED_IN->value => ApartmentStatus::CHECKED_IN->label(),
                        ApartmentStatus::NOT_AVAILABLE->value => ApartmentStatus::NOT_AVAILABLE->label()
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
        @endif

        <div class="search-actions">
            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
            <a href="{{ route('apartment') }}" class="btn btn-secondary btn-reset">Xóa bộ lọc</a>
        </div>
    </form>
    @if($isAdmin)
        <div class="add-button-wapper">
            <button id='show-add-modal'>
                <img src = "{{ asset('images/addButton.png') }}" alt ="add" id='show-add-modal-img'>
            </button>
        </div>
    @endif

    {{-- Bảng kết quả --}}
    <div class="table-wrapper">
        <table class="table-list">
            <thead>
                <tr>
                    <th>Tên</th>
                    <th>Loại</th>
                    <th>Diện tích (m²)</th>
                    <th>Hướng</th>
                    <th>Số lượng wc</th>
                    <th>Trạng thái</th>
                    <th>Nhận phòng</th>
                    <th>Trả phòng</th>
                    <th>Ảnh</th>
                    <th>Link QC</th>
                    @if($isAdmin)
                    <th>Chi Tiết</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($apartments as $apt)
                    <tr>
                        <td>{{ $apt->apartment_name }}</td>
                        <td>{{ ApartmentType::from($apt->type)->label() }}</td>
                        <td>{{ $apt->area }}</td>
                        <td>{{ BalconyDirection::from($apt->balcony_direction)->label() }}</td>
                        <td>{{ $apt->toilet_count }}</td>
                        <td>{{ ApartmentStatus::from($apt->status)->label() }}</td>
                        <td>{{ $apt->check_in_date }}</td>
                        <td>{{ $apt->check_out_date }}</td>
                        <td>
                            <a href="{{ route('apartment.image', ['id' => $apt->id]) }}" class="action-detail">
                                <img src="{{ asset('images/image.png') }}" alt="Ảnh">
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('apartment.info', ['id' => $apt->id]) }}" class="action-detail">
                                <img src="{{ asset('images/copy.png') }}" alt="Ảnh">
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
                        <td colspan="{{ $isAdmin ? 11 : 10 }}">Chưa có dữ liệu</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-wrapper">
        {{ $apartments->links() }}
    </div>
</div>
<div id="add-apartment-modal" class="modal-overlay" style="display:none;">
    <div class="modal-content">
        <h2>Thêm căn hộ</h2>

        <form id="add-apartment-form" action="{{ route('apartment.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="apartment_name_input">Tên căn hộ</label>
                <input type="text" id="apartment_name_input" name="apartment_name" required>
            </div>

            <div class="form-group">
                <label for="type_input">Kiểu phòng ngủ</label>
                <select id="type_input" name="type" required>
                    <option value="">-- Chọn --</option>
                    <option value= "{{ ApartmentType::ONE_BEDROOM->value }}"> {{ ApartmentType::ONE_BEDROOM->label() }} </option>
                    <option value= "{{ ApartmentType::TWO_BEDROOM->value }}"> {{ ApartmentType::TWO_BEDROOM->label() }} </option>
                    <option value= "{{ ApartmentType::THREE_BEDROOM->value }}"> {{ ApartmentType::THREE_BEDROOM->label() }} </option>
                    <option value= "{{ ApartmentType::FOUR_BEDROOM->value }}"> {{ ApartmentType::FOUR_BEDROOM->label() }} </option>
                </select>
            </div>

            <div class="form-group">
                <label for="area_input">Diện tích (m²)</label>
                <input type="number" id="area_input" name="area" min="0" step="0.1" placeholder="VD: 45.5" required>
            </div>

            <div class="form-group">
                <label for="balcony_direction_input">Hướng ban công</label>
                <select id="balcony_direction_input" name="balcony_direction" required>
                    <option value="">-- Chọn --</option>
                    <option value= "{{ BalconyDirection::EAST->value }}"> {{ BalconyDirection::EAST->label() }} </option>
                    <option value= "{{ BalconyDirection::WEST->value }}"> {{ BalconyDirection::WEST->label() }} </option>
                    <option value= "{{ BalconyDirection::SOUTH->value }}"> {{ BalconyDirection::SOUTH->label() }} </option>
                    <option value= "{{ BalconyDirection::NORTH->value }}"> {{ BalconyDirection::NORTH->label() }} </option>
                    <option value= "{{ BalconyDirection::SOUTHEAST->value }}"> {{ BalconyDirection::SOUTHEAST->label() }} </option>
                    <option value= "{{ BalconyDirection::NORTHWEST->value }}"> {{ BalconyDirection::NORTHWEST->label() }} </option>
                    <option value= "{{ BalconyDirection::SOUTHWEST->value }}"> {{ BalconyDirection::SOUTHWEST->label() }} </option>
                    <option value= "{{ BalconyDirection::NORTHEAST->value }}"> {{ BalconyDirection::NORTHEAST->label() }} </option>
                </select>
            </div>

            <div class="form-group">
                <label for="toilet_count_input">Số lượng WC</label>
                <input type="number" id="toilet_count_input" name="toilet_count" min="1" step="1" required>
            </div>

            <div class="form-group">
                <label for="owner_cccd_input">CCCD của chủ hộ</label>
                <input type="text" id="owner_cccd_input" name="apartment_owner" placeholder="VD: 0123456789" required>
            </div>

            <div class="form-group">
                <label for="appliances_price_input">Chi phí cứng (VND)</label>
                <input type="number" id="appliances_price_input" name="appliances_price" min="0" step="1000" placeholder="VD: 1000000">
            </div>

            <div class="form-group">
                <label for="rent_price_input">Tiền thuê (VND)</label>
                <input type="number" id="rent_price_input" name="rent_price" min="0" step="1000" placeholder="VD: 8000000" required>
            </div>

            <div class="form-group">
                <label for="rent_start_time_input">Thời hạn bắt đầu hợp đồng</label>
                <input type="date" id="rent_start_time_input" name="rent_start_time" required>
            </div>

            <div class="form-group">
                <label for="rent_end_time_input">Thời hạn kết thúc hợp đồng</label>
                <input type="date" id="rent_end_time_input" name="rent_end_time" required>
            </div>

            <div class="form-group">
                <label for="note_input">Ghi chú</label>
                <textarea rows="10" cols="50" type="text" id="note_input" name="note"></textarea>
            </div>

            <div class="form-group">
                <label for="youtube_url_input">link video</label>
                <input rows="10" cols="50" type="text" id="youtube_url_input" name="youtube_url">
            </div>

            <div class="form-group">
                <label>Ảnh căn hộ</label>
                <div id="drop-area-apt" class="drop-area">
                    <p>Kéo thả hoặc nhấp để chọn ảnh</p>
                    <input type="file" id="images-apt" name="images[]" accept="image/*" multiple>
                </div>
                <ul id="file-list-apt" class="file-list"></ul>
            </div>

            <div class="form-actions">
                <button type="submit">Thêm</button>
                <button type="button" id="cancel-apartment-modal">Hủy</button>
            </div>
        </form>
    </div>
</div>
@endsection
