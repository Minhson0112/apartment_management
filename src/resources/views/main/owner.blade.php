@extends('layouts.app')

@section('title', 'owner')
@vite(['resources/js/owner.js'])
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')
<div id="owner-page" class="page-content">
    <h1 class="page-title">Danh sách chủ căn hộ</h1>
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
                    <th>Ngày Tạo</th>
                    <th>Ảnh</th>
                </tr>
            </thead>
            <tbody>
                @forelse($owners as $owner)
                    <tr>
                        <td>{{ $owner->cccd }}</td>
                        <td>{{ $owner->full_name }}</td>
                        <td>{{ $owner->date_of_birth }}</td>
                        <td>{{ $owner->created_at->format('Y-m-d') }}</td>
                        <td>
                            <a href="{{ route('owner.image', ['cccd' => $owner->cccd]) }}" class="action-detail">
                                <img src="{{ asset('images/image.png') }}" alt="Ảnh">
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">Chưa có dữ liệu</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-wrapper">
        {{ $owners->links() }}
    </div>
</div>
<div id="add-owner-modal" class="modal-overlay">
    <div class="modal-content">
        <h2>Thêm chủ căn hộ</h2>
        <form id="add-owner-form" action="{{ route('owner.store') }}" enctype="multipart/form-data">
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
