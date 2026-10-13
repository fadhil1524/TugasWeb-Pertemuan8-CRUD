<?php
$pageTitle = 'Daftar Produk';
require __DIR__ . '/includes/header.php';

$pdo = Database::getConnection();

try {
    // JOIN 2 tabel: products + categories + suppliers
    $stmt = $pdo->prepare(
        'SELECT p.id, p.name, p.price, p.stock, c.name AS category, s.name AS supplier
         FROM products p
         JOIN categories c ON c.id = p.category_id
         JOIN suppliers s ON s.id = p.supplier_id
         ORDER BY p.id DESC'
    );
    $stmt->execute();
    $products = $stmt->fetchAll();
} catch (PDOException $e) {
    error_log('Read error: ' . $e->getMessage());
    $products = [];
    echo '<div class="alert error">Data tidak dapat dimuat saat ini.</div>';
}
?>
<div class="head">
  <h1>Daftar Produk</h1>
  <a class="btn" href="create.php">+ Tambah produk</a>
</div>

<div class="table-wrap">
<table>
  <thead>
    <tr><th>#</th><th>Nama</th><th>Kategori</th><th>Supplier</th><th>Harga</th><th>Stok</th><th>Aksi</th></tr>
  </thead>
  <tbody>
  <?php if (!$products): ?>
    <tr><td colspan="7" class="empty">Belum ada data produk.</td></tr>
  <?php endif; ?>
  <?php foreach ($products as $i => $p): ?>
    <tr>
      <td><?= $i + 1 ?></td>
      <td><?= e($p['name']) ?></td>
      <td><?= e($p['category']) ?></td>
      <td><?= e($p['supplier']) ?></td>
      <td><?= e(rupiah($p['price'])) ?></td>
      <td><?= (int) $p['stock'] ?></td>
      <td class="cell-actions">
        <a class="btn small" href="edit.php?id=<?= (int) $p['id'] ?>">Edit</a>
        <form method="post" action="delete.php" onsubmit="return confirm('Yakin hapus produk ini?');">
          <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
          <input type="hidden" name="id" value="<?= (int) $p['id'] ?>">
          <button type="submit" class="small danger">Hapus</button>
        </form>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
