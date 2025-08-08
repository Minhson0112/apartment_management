@extends('layouts.app')

@section('title', 'owner')

@section('content')
<div id="owner-page" class="page-content">
    <h1 class="page-title">Danh sách chủ căn hộ</h1>

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
@endsection
