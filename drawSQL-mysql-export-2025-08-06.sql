CREATE TABLE `user`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `full_name` VARCHAR(255) NOT NULL,
    `date_of_birth` DATE NULL,
    `phone_number` BIGINT NULL,
    `mail` VARCHAR(255) NULL,
    `user_name` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `cccd` BIGINT NULL,
    `role` ENUM('1', '2', '3') NOT NULL COMMENT '1: admin
2: manager
3: collaborator'
);
CREATE TABLE `apartment`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `apartment_name` VARCHAR(255) NOT NULL,
    `type` ENUM('1', '2', '3', '4') NOT NULL COMMENT '1: 1 phòng ngủ
2: 2 phòng ngủ
3: 3 phòng ngủ
4: 4 phòng ngủ',
    `area` BIGINT NOT NULL,
    `status` ENUM('1', '2', '3', '4') NOT NULL COMMENT '1: available
2: reserved
3: checked_in
4: not available',
    `check_in date` DATE NOT NULL,
    `check_out date` DATE NOT NULL,
    `apartment_owner` BIGINT NOT NULL,
    `appliances_price` BIGINT NOT NULL,
    `rent_price` BIGINT NOT NULL,
    `rent_start_time` DATE NOT NULL,
    `rent_end_time` DATE NOT NULL
);
CREATE TABLE `owner`(
    `cccd` BIGINT UNSIGNED NOT NULL,
    `full_name` VARCHAR(255) NOT NULL,
    `date_of_birth` DATE NULL,
    PRIMARY KEY(`cccd`)
);
CREATE TABLE `customers`(
    `cccd` BIGINT UNSIGNED NOT NULL,
    `full_name` VARCHAR(255) NOT NULL,
    `date_of_birth` DATE NULL,
    `phone_number` BIGINT NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `note` VARCHAR(255) NOT NULL,
    `origin` BIGINT NOT NULL,
    PRIMARY KEY(`cccd`)
);
CREATE TABLE `bookings`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `customer` BIGINT NOT NULL,
    `apartment` BIGINT NOT NULL,
    `check_in_date` DATE NOT NULL,
    `check_out_date` DATE NOT NULL,
    `status` ENUM('1', '2', '3', '4') NOT NULL COMMENT '1: reserved
2: checked_in
3: checked_out
4: cancelled',
    `price` BIGINT NOT NULL,
    `incidental_costs` BIGINT NOT NULL,
    `payment_status` ENUM('1', '2') NOT NULL COMMENT '1: unpaid
2: paid',
    `needer_bill` BOOLEAN NOT NULL,
    `note` VARCHAR(255) NOT NULL
);
CREATE TABLE `contract_extension`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `apartment` BIGINT NOT NULL,
    `expiration date` DATE NOT NULL,
    `date_of_extension` DATE NOT NULL,
    `rent_price` BIGINT NOT NULL
);
CREATE TABLE `suppliers`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `phone_number` BIGINT NOT NULL,
    `email` VARCHAR(255) NULL
);
CREATE TABLE `product`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `price` BIGINT NOT NULL,
    `quantity` BIGINT NOT NULL,
    `supplier` BIGINT NOT NULL
);
CREATE TABLE `import_product`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `product` BIGINT NOT NULL,
    `supplier` BIGINT NOT NULL,
    `quantity` BIGINT NOT NULL,
    `price` BIGINT NOT NULL
);
CREATE TABLE `use_product`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `apartment` BIGINT NOT NULL,
    `product` BIGINT NOT NULL,
    `quantity` BIGINT NOT NULL
);
CREATE TABLE `owner_image`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `owner` BIGINT NOT NULL,
    `image_file_name` VARCHAR(255) NOT NULL
);
CREATE TABLE `customers_image`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `customer` BIGINT NOT NULL,
    `image_file_name` VARCHAR(255) NOT NULL
);
CREATE TABLE `apartment_image`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `apartment` BIGINT NOT NULL,
    `image_file_name` VARCHAR(255) NOT NULL
);
ALTER TABLE
    `bookings` ADD CONSTRAINT `bookings_customer_foreign` FOREIGN KEY(`customer`) REFERENCES `customers`(`cccd`);
ALTER TABLE
    `customers_image` ADD CONSTRAINT `customers_image_customer_foreign` FOREIGN KEY(`customer`) REFERENCES `customers`(`cccd`);
ALTER TABLE
    `import_product` ADD CONSTRAINT `import_product_supplier_foreign` FOREIGN KEY(`supplier`) REFERENCES `suppliers`(`id`);
ALTER TABLE
    `apartment_image` ADD CONSTRAINT `apartment_image_apartment_foreign` FOREIGN KEY(`apartment`) REFERENCES `apartment`(`id`);
ALTER TABLE
    `contract_extension` ADD CONSTRAINT `contract_extension_apartment_foreign` FOREIGN KEY(`apartment`) REFERENCES `apartment`(`id`);
ALTER TABLE
    `apartment` ADD CONSTRAINT `apartment_apartment_owner_foreign` FOREIGN KEY(`apartment_owner`) REFERENCES `owner`(`cccd`);
ALTER TABLE
    `owner_image` ADD CONSTRAINT `owner_image_owner_foreign` FOREIGN KEY(`owner`) REFERENCES `owner`(`cccd`);
ALTER TABLE
    `bookings` ADD CONSTRAINT `bookings_apartment_foreign` FOREIGN KEY(`apartment`) REFERENCES `apartment`(`id`);
ALTER TABLE
    `customers` ADD CONSTRAINT `customers_origin_foreign` FOREIGN KEY(`origin`) REFERENCES `user`(`id`);
ALTER TABLE
    `use_product` ADD CONSTRAINT `use_product_product_foreign` FOREIGN KEY(`product`) REFERENCES `product`(`id`);
ALTER TABLE
    `import_product` ADD CONSTRAINT `import_product_product_foreign` FOREIGN KEY(`product`) REFERENCES `product`(`id`);
ALTER TABLE
    `product` ADD CONSTRAINT `product_supplier_foreign` FOREIGN KEY(`supplier`) REFERENCES `suppliers`(`id`);
ALTER TABLE
    `use_product` ADD CONSTRAINT `use_product_apartment_foreign` FOREIGN KEY(`apartment`) REFERENCES `apartment`(`id`);