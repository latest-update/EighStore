<?php
session_start(); 
$backRoute = '../../../';
require_once $backRoute.'Core/connect.php';
require_once $backRoute.'Core/checkAuth.php';

require_once $backRoute.'Core/checkFlagAdmin.php';

$id = $_GET['id'];

$product_name = $_POST['product-name'];
$articul = $_POST['articul'];
$type = $_POST['type'];
$brand = $_POST['brand'];
$manufacturer = $_POST['manufacturer'];
$description = $_POST['description'];
$price = $_POST['price'];
$count = $_POST['count'];
$attributes = $_POST['attributes'];
if(isset($id)){
    mysqli_query($connect, "UPDATE `products` SET `PRODUCT-NAME` = '$product_name', `ARTICUL` = '$articul', `COUNT` = '$count', `TYPE` = '$type', `BRAND` = '$brand', `MANUFACTURER` = '$manufacturer', `DESCRIPTION` = '$description', `PRICE` = '$price', `ATTRIBUTES` = '$attributes' WHERE `products`.`ID` = '$id'");
}
header("Location: ".$backRoute.'product.php?product='.$id);
?>
   


