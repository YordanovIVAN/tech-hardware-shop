<?php
session_start();
require_once 'db.php';

$cartProducts = [];
$total_lev = 0;
$euro_rate = 1.95583;

if (!empty($_SESSION['cart'])) {
    $placeholders = implode(',', array_fill(0, count($_SESSION['cart']), '?'));
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
    $stmt->execute($_SESSION['cart']);
    $dbProducts = $stmt->fetchAll();

    foreach ($dbProducts as $prod) {
        $cartProducts[$prod['id']] = $prod;
    }

    $validCart = [];
    foreach ($_SESSION['cart'] as $id) {
        if (isset($cartProducts[$id])) {
            $validCart[] = $id;
            $total_lev += $cartProducts[$id]['price'];
        }
    }
    $_SESSION['cart'] = $validCart;
}

$cartCount = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
$total_euro = $total_lev / $euro_rate;

$english_names = [
    1 => 'Graphics Card NVIDIA RTX 4070 Ti Super 16GB',
    2 => 'Mechanical Gaming Keyboard (Logitech G Pro X)',
    3 => 'Gaming Monitor 27" IPS QHD 165Hz (ASUS TUF)'
];
?>

<!DOCTYPE html>
<html lang="bg">
<head>
<meta charset="UTF-8">
<title>Количка - TechGear Hub</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<style>
    body { background-color: #0b0c10; color: #c5c6c7; }
    .navbar { background-color: #1f2833 !important; border-bottom: 2px solid #45f3ff; }
    .table-dark { --bs-table-bg: #1f2833; color: #fff; }
    .text-neon { color: #45f3ff !important; }
    .btn-neon { background-color: #45f3ff; color: #0b0c10; font-weight: bold; }
    .btn-neon:hover { background-color: #00c2cb; color: #fff; }
</style>
</head>
<body>

<nav class="navbar navbar-dark">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center fw-bold" href="index.php">
      <i class="bi bi-cpu me-2 text-neon"></i> TechGear <span class="text-neon ms-1">Hub</span>
    </a>
    <a href="cart.php" class="btn btn-neon position-relative">
      <i class="bi bi-gpu-card"></i> Количка
      <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
        <?php echo $cartCount; ?>
      </span>
    </a>
  </div>
</nav>

<div class="container mt-5">
  <h2 class="mb-4 text-neon"><i class="bi bi-cart4"></i> Вашата Гейминг Количка</h2>

  <?php if(!empty($_SESSION['cart'])): ?>
    <div class="table-responsive shadow rounded border border-secondary">
      <table class="table table-dark table-hover align-middle text-center mb-0">
        <thead>
          <tr class="border-bottom border-info">
            <th>Компонент</th>
            <th>Цена</th>
            <th>Премахване</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($_SESSION['cart'] as $id): 
            if(!isset($cartProducts[$id])) continue;
            $product = $cartProducts[$id]; 
            $prod_lev = $product['price'];
            $prod_euro = $prod_lev / $euro_rate;
            $part_title = isset($english_names[$product['id']]) ? $english_names[$product['id']] : $product['name'];
          ?>
            <tr>
              <td><strong class="text-light"><?php echo htmlspecialchars($part_title); ?></strong></td>
              <td class="text-neon fw-bold">
                <?php echo number_format($prod_euro, 2); ?> €
                <br><span class="text-muted fw-normal" style="font-size: 0.85rem;">(<?php echo number_format($prod_lev, 2); ?> лв.)</span>
              </td>
              <td>
                <a href="remove.php?id=<?php echo $id; ?>" class="btn btn-outline-danger btn-sm">
                  <i class="bi bi-trash3-fill"></i> Изтрий
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <h4 class="text-end mt-4 text-light">
      Обща сума: <span class="fw-bold text-neon"><?php echo number_format($total_euro, 2); ?> €</span>
      <span class="text-muted" style="font-size: 1.1rem;">(<?php echo number_format($total_lev, 2); ?> лв.)</span>
    </h4>
    <div class="d-flex justify-content-between mt-4 mb-5">
      <a href="index.php" class="btn btn-outline-light"><i class="bi bi-arrow-left"></i> Назад към каталога</a>
      <button class="btn btn-neon shadow"><i class="bi bi-wallet2"></i> Към плащане</button>
    </div>

  <?php else: ?>
    <div class="alert alert-dark text-center border-secondary text-light fs-5">Количката ви хардуер е празна.</div>
    <div class="text-center">
      <a href="index.php" class="btn btn-neon"><i class="bi bi-joystick"></i> Виж Продуктите</a>
    </div>
  <?php endif; ?>
</div>

</body>
</html>