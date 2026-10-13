<?php
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/config/database.php';

$pdo = Database::getConnection();
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    flash('error', 'ID produk tidak valid.');
    redirect('index.php');
}

$stmt = $pdo->prepare('SELECT * FROM products WHERE id = :id');
$stmt->execute([':id' => $id]);
$product = $stmt->fetch();

if (!$product) {
    flash('error', 'Produk tidak ditemukan.');
    redirect('index.php');
}

$categories = $pdo->query('SELECT id, name FROM categories ORDER BY name')->fetchAll();
$suppliers = $pdo->query('SELECT id, name FROM suppliers ORDER BY name')->fetchAll();
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
                    'UPDATE products
                     SET name = :name, category_id = :category_id, supplier_id = :supplier_id,
                         price = :price, stock = :stock
                     WHERE id = :id'
                );
                $stmt->execute([
                    ':name' => $data['name'],
                    ':category_id' => $data['category_id'],
                    ':supplier_id' => $data['supplier_id'],
                    ':price' => $data['price'],
                    ':stock' => $data['stock'],
                    ':id' => $id,
                ]);
                flash('success', 'Produk berhasil diperbarui.');
                redirect('index.php');
            } catch (PDOException $e) {
                error_log('Update error: ' . $e->getMessage());
                $errors[] = 'Gagal memperbarui produk. Coba lagi.';
            }
        }
    }
}

$pageTitle = 'Edit Produk';
$submitLabel = 'Perbarui';
require __DIR__ . '/includes/header.php';
echo '<h1>Edit Produk</h1>';
require __DIR__ . '/includes/product_form.php';
require __DIR__ . '/includes/footer.php';
