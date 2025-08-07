{{-- resources/views/permission.blade.php --}}
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Không có quyền</title>
    @vite(['resources/css/permissionError.css'])
</head>
<body>
    <div class="permission-box">
        <h1>Bạn không có quyền xem trang này</h1>
        <button type="button" onclick="history.back()">Quay lại</button>
    </div>
</body>
</html>
