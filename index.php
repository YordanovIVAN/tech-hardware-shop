<?php
session_start();
require_once 'db.php'; 

$stmt = $pdo->query("SELECT * FROM products");
$products = $stmt->fetchAll();

$cartCount = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
$euro_rate = 1.95583;

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
<title>TechGear Hub - Геймърски Магазин</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<style>
    body { background-color: #0b0c10; color: #c5c6c7; }
    .navbar { background-color: #1f2833 !important; border-bottom: 2px solid #45f3ff; }
    .card { background-color: #1f2833; border: 1px solid #2f3e46; color: #fff; }
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
  <h2 class="mb-4 text-center">Намаления на Геймърски Хардуер</h2>
  <div class="row g-4">
    <?php foreach($products as $product): 
      $price_in_lev = $product['price'];
      $price_in_euro = $price_in_lev / $euro_rate;
      $part_title = isset($english_names[$product['id']]) ? $english_names[$product['id']] : $product['name'];
    ?>
      <div class="col-md-4">
        <div class="card h-100 shadow">
          <div class="p-3 bg-secondary bg-opacity-10 text-center rounded-top">
            <img src="img/<?php echo $product['image']; ?>" class="card-img-top p-2" alt="<?php echo htmlspecialchars($part_title); ?>" style="height:200px; object-fit:contain;">
          </div>
          <div class="card-body d-flex flex-column">
            <h5 class="card-title fw-bold"><?php echo htmlspecialchars($part_title); ?></h5>
            <p class="card-text fw-bold text-neon fs-4 mt-2">
              <?php echo number_format($price_in_euro, 2); ?> € 
              <span class="text-muted fw-normal d-block" style="font-size: 0.85rem;">(<?php echo number_format($price_in_lev, 2); ?> лв.)</span>
            </p>
            <a href="add.php?id=<?php echo $product['id']; ?>" class="btn btn-outline-light mt-auto w-100">
              <i class="bi bi-cart-plus-fill text-neon"></i> Добави в количката
            </a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

</body>
</html>