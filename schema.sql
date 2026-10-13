-- Tugas Rutin 8: inventaris_db (3 tabel + FK, 3NF)
CREATE DATABASE IF NOT EXISTS inventaris_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE inventaris_db;

DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS suppliers;

CREATE TABLE categories (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB;

CREATE TABLE suppliers (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  phone VARCHAR(30) NULL
) ENGINE=InnoDB;

CREATE TABLE products (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  category_id INT UNSIGNED NOT NULL,
  supplier_id INT UNSIGNED NOT NULL,
  price DECIMAL(15,2) NOT NULL DEFAULT 0,
  stock INT NOT NULL DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_products_category FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE RESTRICT,
  CONSTRAINT fk_products_supplier FOREIGN KEY (supplier_id) REFERENCES suppliers(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

-- Seed: 5 data per tabel
INSERT INTO categories (name) VALUES
('Elektronik'), ('Alat Tulis'), ('Perabot'), ('Makanan Ringan'), ('Aksesoris');

INSERT INTO suppliers (name, phone) VALUES
('PT Maju Jaya', '061-5551001'),
('CV Sumber Rezeki', '061-5551002'),
('UD Berkah Abadi', '061-5551003'),
('PT Nusantara Supply', '061-5551004'),
('CV Mitra Sejati', '061-5551005');

INSERT INTO products (name, category_id, supplier_id, price, stock) VALUES
('Mouse Wireless', 1, 1, 150000, 40),
('Buku Tulis A5', 2, 2, 8000, 200),
('Kursi Kantor', 3, 3, 850000, 12),
('Keripik Singkong', 4, 4, 15000, 75),
('Casing HP Universal', 5, 5, 35000, 60);
