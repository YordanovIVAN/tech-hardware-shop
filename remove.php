<?php
session_start();

if(!isset($_GET['id'])){
    header("Location: cart.php");
    exit();
}

$id = intval($_GET['id']);

if(isset($_SESSION['cart'])){
    $key = array_search($id, $_SESSION['cart']);
    if($key !== false){
        unset($_SESSION['cart'][$key]);
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }
}

header("Location: cart.php");
exit();
?>