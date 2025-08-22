{{-- resources/views/apartment/detail.blade.php --}}
@extends('layouts.app')

@section('title', 'Apartment Detail')

@vite(['resources/js/apartmentDetail.js', 'resources/css/apartmentDetail.css', 'resources/js/contractExtension.js'])
<meta name="csrf-token" content="{{ csrf_token() }}">

@php
    use App\Enums\ApartmentType;
    use App\Enums\BalconyDirection;
    use App\Enums\ApartmentStatus;
@endphp

@section('content')
<div class="page-wrap">
    <div class="page-header">
        <div class="title-block">
            <h1 class="title">{{ $apartment->apartment_name }}</h1>
            <div class="meta">
                <span class="badge type">
                    {{ ApartmentType::from($apartment->type)->label() }}
                </span>
                <span class="badge status status-{{ $apartment->status }}">
                    {{ ApartmentStatus::from($apartment->status)->label() }}
                </span>
            </div>
        </div>

        <div class="header-actions">
            <a class="btn ghost" href="{{ route('apartment.image', ['id' => $apartment->id]) }}">Quản lý ảnh</a>
            <a class="btn ghost" href="{{ route('apartment.info', ['id' => $apartment->id]) }}">Trang quảng cáo</a>
            <button id="openEditModalBtn" class="btn primary">
                <img src="{{ asset('images/modify.png') }}" alt="Sửa" class="btn-icon">
                Sửa thông tin
            </button>
        </div>
    </div>

    <div class="content-grid">
        <section class="card span-2">
            <h2 class="card-title">Thông tin tổng quan</h2>
            <div class="kv-grid">
                <div class="kv"><div class="k">Tên căn hộ</div><div class="v" id="v_apartment_name">{{ $apartment->apartment_name }}</div></div>
                <div class="kv"><div class="k">Loại</div><div class="v" id="v_type">{{ ApartmentType::from($apartment->type)->label() }}</div></div>
                <div class="kv"><div class="k">Diện tích</div><div class="v" id="v_area">{{ number_format((float) $apartment->area, 1) }} m²</div></div>
                <div class="kv"><div class="k">Hướng ban công</div><div class="v" id="v_balcony">{{ BalconyDirection::from($apartment->balcony_direction)->label() }}</div></div>
                <div class="kv"><div class="k">Số WC</div><div class="v" id="v_toilet">{{ $apartment->toilet_count }}</div></div>
                <div class="kv"><div class="k">Trạng thái</div><div class="v" id="v_status">{{ ApartmentStatus::from($apartment->status)->label() }}</div></div>
                <div class="kv"><div class="k">Nhận phòng</div><div class="v" id="v_check_in">{{ $apartment->check_in_date }}</div></div>
                <div class="kv"><div class="k">Trả phòng</div><div class="v" id="v_check_out">{{ $apartment->check_out_date }}</div></div>
                <div class="kv span-2">
                    <div class="k">Ghi chú</div>
                    <div class="v" id="v_note">{{ $apartment->note ?: '—' }}</div>
                </div>
            </div>
        </section>

        <section class="card">
            <h2 class="card-title">Giá & Hợp đồng</h2>
            <div class="kv-grid">
                <div class="kv"><div class="k">Chi phí cứng</div><div class="v" id="v_appliances">{{ number_format((int) $apartment->appliances_price) }} đ</div></div>
                <div class="kv"><div class="k">Tổng tiền thuê luỹ kế</div><div class="v" id="v_rent">{{ number_format((int) $apartment->rent_price) }} đ</div></div>
                <div class="kv"><div class="k">Ngày hết hạn hợp đồng</div><div class="v" id="v_rent_end">{{ $apartment->rent_end_time }}</div></div>
            </div>
        </section>

        <section class="card">
            <h2 class="card-title">Chủ nhà</h2>
            <div class="kv-grid">
                <div class="kv"><div class="k">CCCD chủ nhà</div><div class="v" id="v_owner_cccd">{{ $apartment->owner->cccd }}</div></div>
                <div class="kv"><div class="k">Tên chủ nhà</div><div class="v" id="v_owner_name">{{ $apartment->owner->full_name }}</div></div>
                <div class="kv"><div class="k">Số điện thoại</div><div class="v" id="v_owner_name">{{ $apartment->owner->mobile_number }}</div></div>
                <div class="kv"><div class="k">Mail</div><div class="v" id="v_owner_name">{{ $apartment->owner->email }}</div></div>
            </div>
        </section>

        <section class="card span-2">
        <h2 class="card-title">Video giới thiệu</h2>
        @if($apartment->youtube_url)
            <div class="video-wrap">
            <iframe width="100%" height="450"
                    src="{{ $apartment->youtube_url }}"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    allowfullscreen></iframe>
            </div>
        @else
            <div class="placeholder">Chưa có video YouTube.</div>
        @endif
        </section>
    </div>

    <div class="ContractExtension">
        <h2>Lịch Sử Gia Hạn Hợp Đồng Căn {{ $apartment->apartment_name }}</h2>
        <button id="openContractExtensionModalBtn" class="btn primary">
            <img src="{{ asset('images/contractExtension.png') }}" alt="gia hạn" class="btn-icon">
            Gia hạn hợp đồng
        </button>
    </div>

    <div class="table-wrapper">
        <table class="table-list">
            <thead>
                <tr>
                    <th>số thứ tự</th>
                    <th>Ngày bắt đầu hợp đồng</th>
                    <th>Ngày kết thúc hợp đồng</th>
                    <th>Giá Thuê</th>
                </tr>
            </thead>
            <tbody>
                @forelse($contracts as $contract)
                    <tr>
                        <td>{{ $contract->id }}</td>
                        <td>{{ $contract->rent_start_time }}</td>
                        <td>{{ $contract->rent_end_time }}</td>
                        <td>{{ $contract->rent_price }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">Chưa có dữ liệu</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-wrapper">
        {{ $contracts->links() }}
    </div>
</div>

{{-- Modal Edit --}}
<div class="modal" id="editModal" aria-hidden="true" role="dialog" aria-modal="true">
    <div class="modal-backdrop" data-close-modal></div>
    <div class="modal-dialog" role="document" aria-labelledby="editModalTitle">
        <div class="modal-header">
            <h3 id="editModalTitle">Chỉnh sửa thông tin</h3>
            <button class="icon-btn" id="closeEditModalBtn" aria-label="Đóng">×</button>
        </div>
        <form id="editForm" action="{{ route('apartment.update', ['id' => $apartment->id]) }}" method="POST" class="modal-body">
            @csrf
            @method('PUT')

            <div class="form-grid">
                <div class="form-item">
                    <label for="apartment_name">Tên căn hộ</label>
                    <input type="text" id="apartment_name" name="apartment_name" value="{{ $apartment->apartment_name }}" maxlength="255" required>
                </div>

                <div class="form-item">
                    <label for="type">Loại</label>
                    <select id="type" name="type" required>
                        @foreach (ApartmentType::cases() as $t)
                            <option value="{{ $t->value }}" @selected($apartment->type == $t->value)>{{ $t->label() }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-item">
                    <label for="area">Diện tích (m²)</label>
                    <input type="number" step="0.1" min="0" id="area" name="area" value="{{ $apartment->area }}" required>
                </div>

                <div class="form-item">
                    <label for="balcony_direction">Hướng ban công</label>
                    <select id="balcony_direction" name="balcony_direction" required>
                        @foreach (BalconyDirection::cases() as $dir)
                            <option value="{{ $dir->value }}" @selected($apartment->balcony_direction == $dir->value)>{{ $dir->label() }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-item">
                    <label for="toilet_count">Số WC</label>
                    <input type="number" min="0" id="toilet_count" name="toilet_count" value="{{ $apartment->toilet_count }}" required>
                </div>

                <div class="form-item span-2">
                    <label for="note">Ghi chú</label>
                    <textarea id="note" name="note" rows="3" placeholder="Ghi chú giới thiệu căn hộ...">{{ $apartment->note }}</textarea>
                </div>

                <div class="form-item span-2">
                    <label for="youtube_url">YouTube URL</label>
                    <input type="url" id="youtube_url" name="youtube_url" value="{{ $apartment->youtube_url }}">
                </div>

                <div class="form-item">
                    <label for="apartment_owner">CCCD Chủ nhà</label>
                    <input type="text" id="apartment_owner" name="apartment_owner" value="{{ $apartment->owner->cccd }}" required>
                </div>

                <div class="form-item">
                    <label for="appliances_price">Chi phí cứng (đ)</label>
                    <input type="number" min="0" id="appliances_price" name="appliances_price" value="{{ $apartment->appliances_price }}" required>
                </div>
            </div>

            @if ($errors->any())
                <div class="alert error">
                    <ul>
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="modal-footer">
                <button type="button" class="btn ghost" data-close-modal>Hủy</button>
                <button type="submit" class="btn primary">Lưu thay đổi</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Contract Extension --}}
<div class="modal" id="contractExtensionModal" aria-hidden="true" role="dialog" aria-modal="true">
    <div class="modal-backdrop" data-close-modal></div>
    <div class="modal-dialog" role="document" aria-labelledby="contractExtensionModalTitle">
        <div class="modal-header">
            <h3 id="contractExtensionModalTitle">Gia hạn hợp đồng</h3>
            <button class="icon-btn" id="closeContractExtensionModalBtn" aria-label="Đóng">×</button>
        </div>

        <form id="contractExtensionForm"
                action="{{ route('apartment.contractExtension', ['id' => $apartment->id]) }}"
                method="POST"
                class="modal-body">
            @csrf

            <div class="form-grid">
                <div class="form-item">
                    <label for="rent_start_time">Ngày bắt đầu</label>
                    <input type="date" id="rent_start_time" name="rent_start_time" required>
                </div>

                <div class="form-item">
                    <label for="rent_end_time">Ngày kết thúc</label>
                    <input type="date" id="rent_end_time" name="rent_end_time" required>
                </div>

                <div class="form-item span-2">
                    <label for="rent_price">Giá thuê (đ)</label>
                    <input type="number" id="rent_price" name="rent_price" min="0" required>
                </div>
            </div>

            <div class="alert error" id="contractExtensionGeneralError" style="display:none"></div>

            <div class="modal-footer">
                <button type="button" class="btn ghost" data-close-modal>Hủy</button>
                <button type="submit" class="btn primary">Lưu gia hạn</button>
            </div>
        </form>
    </div>
</div>
@endsection
