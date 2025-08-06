# Dự Án App Quản Lý Căn Hộ Dịch Vụ 

## Các bước xây dựng môi trường

1. clone source code từ github  
    `git clone https://github.com/Minhson0112/apartment_management.git`  
2. Trên command line vào đường dẫn gốc dự án, chạy build docker  
    `docker compose build `
3. sau khi build xong khởi động container  
    `docker compose up -d`
4. vào container để cài composer và migration db mặc định của laravel, cài cấu hình env biến môi trường
    ```
    docker exec -it laravel_app_apartment bash
    cp .env.example .env
    composer install
    php artisan key:generate
    php artisan migrate
    ```
## Kiểm tra môi trường 
- vào link bên dưới và thấy trang welcome của laravel
    - http://localhost:8000/

## Thông tin môi trường các container đang chạy
- nginx_apartment (web server)
    - Ubuntu24.04 + nginx1.27.5
- laravel_app_apartment (app logic)
    - Ubuntu24.04 + PHP8.2 + laravel 12.x
- mysql_apartment (DB server)
    - MySQL8.4.5

## Luật Phát Triển app

1. chỉ được phép phát triển trên các nhánh /feature
    - main -> develop -> feature/name_of_feature1 , feature/name_of_feature2
2. commit msg phải có tiền tố như sau 
    - add: thêm file mới
    - update: sửa file (trừ fix lỗi)
    - fix: sửa file (mục đích fix lỗi)
    - clean: refactor code
    - remove: xoá file
    - rename: đổi tên file
3. trước khi commit bất kì cái gì đều phải chạy lệnh sau để format code
    ```
    docker exec -it laravel_app_apartment bash
    npm run format
    ```