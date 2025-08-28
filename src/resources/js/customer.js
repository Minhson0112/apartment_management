document.addEventListener("DOMContentLoaded", function () {
    /**
     * 1. Xử lý select#origin
     */
    const originSelects = document.querySelectorAll("select#origin");

    if (originSelects.length > 0) {
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

                    // Giữ lại giá trị đã chọn (nếu có)
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
    }

    /**
     * 2. Xử lý modal ghi chú
     */
    const modal = document.getElementById("note-modal");
    const noteText = document.getElementById("note-text");
    const closeBtn = document.querySelector(".note-modal-close");
    const showNoteBtn = document.querySelector(".show-note");

    if (modal && noteText && closeBtn && showNoteBtn) {
        showNoteBtn.addEventListener("click", function (e) {
            e.preventDefault();

            const note = this.getAttribute("data-note") || "Không có ghi chú";
            noteText.textContent = note;
            modal.style.display = "block";
        });

        closeBtn.onclick = function () {
            modal.style.display = "none";
        };

        window.onclick = function (event) {
            if (event.target === modal) {
                modal.style.display = "none";
            }
        };
    }
});
