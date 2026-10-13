<?php /** @var array $product @var array $categories @var array $suppliers @var array $errors @var string $submitLabel */ ?>
<?php foreach ($errors as $err): ?>
  <div class="alert error" role="alert"><?= e($err) ?></div>
<?php endforeach; ?>
<form method="post" novalidate>
  <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">

  <label for="name">Nama produk</label>
  <input type="text" id="name" name="name" value="<?= e((string) $product['name']) ?>" required>

  <label for="category_id">Kategori</label>
  <select id="category_id" name="category_id" required>
    <option value="">-- Pilih kategori --</option>
    <?php foreach ($categories as $c): ?>
      <option value="<?= (int) $c['id'] ?>" <?= (int) $product['category_id'] === (int) $c['id'] ? 'selected' : '' ?>><?= e($c['name']) ?></option>
    <?php endforeach; ?>
  </select>

  <label for="supplier_id">Supplier</label>
  <select id="supplier_id" name="supplier_id" required>
    <option value="">-- Pilih supplier --</option>
    <?php foreach ($suppliers as $s): ?>
      <option value="<?= (int) $s['id'] ?>" <?= (int) $product['supplier_id'] === (int) $s['id'] ? 'selected' : '' ?>><?= e($s['name']) ?></option>
    <?php endforeach; ?>
  </select>

  <div class="row">
    <div>
      <label for="price">Harga (Rp)</label>
      <input type="number" step="0.01" min="0" id="price" name="price" value="<?= e((string) $product['price']) ?>" required>
    </div>
    <div>
      <label for="stock">Stok</label>
      <input type="number" min="0" id="stock" name="stock" value="<?= e((string) $product['stock']) ?>" required>
    </div>
  </div>

  <div class="actions">
    <button type="submit"><?= e($submitLabel) ?></button>
    <a class="btn secondary" href="index.php">Batal</a>
  </div>
</form>
