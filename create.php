<?php
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/config/database.php';

$pdo = Database::getConnection();
$categories = $pdo->query('SELECT id, name FROM categories ORDER BY name')->fetchAll();
$suppliers = $pdo->query('SELECT id, name FROM suppliers ORDER BY name')->fetchAll();

$product = ['name' => '', 'category_id' => '', 'supplier_id' => '', 'price' => '', 'stock' => '0'];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_valid()) {
        $errors[] = 'Sesi form tidak valid. Muat ulang halaman.';
    } else {
        [$data, $errors] = validate_product($_POST, $pdo);
        $product = array_merge($product, array_map(fn($v) => $v === false ? '' : $v, $data));

        if (!$errors) {
            try {
                $stmt = $pdo->prepare(
                    'INSERT INTO products (name, category_id, supplier_id, price, stock)
                     VALUES (:name, :category_id, :supplier_id, :price, :stock)'
                );
                $stmt->execute([
                    ':name' => $data['name'],
                    ':category_id' => $data['category_id'],
                    ':supplier_id' => $data['supplier_id'],
                    ':price' => $data['price'],
                    ':stock' => $data['stock'],
                ]);
                flash('success', 'Produk berhasil ditambahkan.');
                redirect('index.php');
            } catch (PDOException $e) {
                error_log('Create error: ' . $e->getMessage());
                $errors[] = 'Gagal menyimpan produk. Coba lagi.';
            }
        }
    }
}

$pageTitle = 'Tambah Produk';
$submitLabel = 'Simpan';
require __DIR__ . '/includes/header.php';
echo '<h1>Tambah Produk</h1>';
require __DIR__ . '/includes/product_form.php';
require __DIR__ . '/includes/footer.php';
