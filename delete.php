<?php
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrf_valid()) {
    flash('error', 'Permintaan tidak valid.');
    redirect('index.php');
}

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    flash('error', 'ID produk tidak valid.');
    redirect('index.php');
}

try {
    $stmt = Database::getConnection()->prepare('DELETE FROM products WHERE id = :id');
    $stmt->execute([':id' => $id]);
    flash($stmt->rowCount() ? 'success' : 'error', $stmt->rowCount() ? 'Produk berhasil dihapus.' : 'Produk tidak ditemukan.');
} catch (PDOException $e) {
    error_log('Delete error: ' . $e->getMessage());
    flash('error', 'Gagal menghapus produk.');
}
redirect('index.php');
