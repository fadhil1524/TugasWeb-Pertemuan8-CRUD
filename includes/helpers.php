<?php
declare(strict_types=1);

session_start();

function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function flash(string $type, string $message): void
{
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function pull_flash(): ?array
{
    $f = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $f;
}

function redirect(string $url): never
{
    header("Location: $url");
    exit;
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

function csrf_valid(): bool
{
    return isset($_POST['csrf'], $_SESSION['csrf'])
        && hash_equals($_SESSION['csrf'], $_POST['csrf']);
}

function rupiah(string|float|int $n): string
{
    return 'Rp ' . number_format((float) $n, 0, ',', '.');
}

/** Validasi input produk. Mengembalikan [data, errors]. */
function validate_product(array $in, PDO $pdo): array
{
    $data = [
        'name' => trim($in['name'] ?? ''),
        'category_id' => filter_var($in['category_id'] ?? null, FILTER_VALIDATE_INT),
        'supplier_id' => filter_var($in['supplier_id'] ?? null, FILTER_VALIDATE_INT),
        'price' => filter_var($in['price'] ?? null, FILTER_VALIDATE_FLOAT),
        'stock' => filter_var($in['stock'] ?? null, FILTER_VALIDATE_INT),
    ];
    $errors = [];

    if ($data['name'] === '' || mb_strlen($data['name']) > 150) {
        $errors[] = 'Nama produk wajib diisi (maks. 150 karakter).';
    }
    if ($data['price'] === false || $data['price'] < 0) {
        $errors[] = 'Harga harus berupa angka >= 0.';
    }
    if ($data['stock'] === false || $data['stock'] < 0) {
        $errors[] = 'Stok harus berupa bilangan bulat >= 0.';
    }
    foreach (['category_id' => 'categories', 'supplier_id' => 'suppliers'] as $field => $table) {
        $ok = false;
        if ($data[$field] !== false && $data[$field] !== null) {
            $stmt = $pdo->prepare("SELECT 1 FROM {$table} WHERE id = :id");
            $stmt->execute([':id' => $data[$field]]);
            $ok = (bool) $stmt->fetchColumn();
        }
        if (!$ok) {
            $errors[] = ucfirst(rtrim($table, 's')) . ' tidak valid.';
        }
    }
    return [$data, $errors];
}
