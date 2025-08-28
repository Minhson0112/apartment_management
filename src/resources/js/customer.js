document.addEventListener("DOMContentLoaded", function () {
    // Lấy tất cả select có id = origin (trong form search + form add)
    const originSelects = document.querySelectorAll("select#origin");

    if (originSelects.length === 0) return;

    fetch('/user/all', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
    })
    .then(response => {
        if (!response.ok) {
            throw new Error("Lỗi khi fetch dữ liệu người dùng");
        }
        return response.json();
    })
    .then(data => {
        originSelects.forEach(select => {
            // Reset options ban đầu
            select.innerHTML = '<option value="">-- Chọn --</option>';

            // Thêm option từ API
            data.forEach(user => {
                const option = document.createElement("option");
                option.value = user.cccd;
                option.textContent = user.full_name;

                // Giữ lại giá trị đã chọn (nếu có trong request cũ)
                if (select.getAttribute("value") === user.cccd ||
                    select.dataset.selected === user.cccd ||
                    select.value === user.cccd) {
                    option.selected = true;
                }

                select.appendChild(option);
            });
        });
    })
    .catch(error => {
        console.error("Fetch error:", error);
    });
});
