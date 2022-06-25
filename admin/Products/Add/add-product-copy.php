<?php
session_start(); 
$backRoute = '../../../';
require_once $backRoute.'Core/connect.php';
require_once $backRoute.'Core/checkAuth.php';
require_once $backRoute.'Core/checkFlagAdmin.php';

$category = $_GET['name'];
$subcat = $_GET['type'];
$subsubcat = $_GET['subtype']; 


if(isset($subsubcat) && $subsubcat != ''){
    $category = mysqli_real_escape_string($connect, $category);
    $subcat = mysqli_real_escape_string($connect, $subcat);
    $subsubcat = mysqli_real_escape_string($connect, $subsubcat);
    $catid = mysqli_query($connect, "SELECT `CATEGORY-ID` FROM `category` WHERE `CATEGORY-NAME` = '$category' AND `SUBCATEGORY-NAME` = '$subcat' AND `SUBSUBCATEGORY-NAME` = '$subsubcat'");
    $redirect = "../View/index.php?name=${category}&type=${subcat}&subtype=${subsubcat}";
} else{
    $category = mysqli_real_escape_string($connect, $category);
    $subcat = mysqli_real_escape_string($connect, $subcat);
    $catid = mysqli_query($connect, "SELECT `CATEGORY-ID` FROM `category` WHERE `CATEGORY-NAME` = '$category' AND `SUBCATEGORY-NAME` = '$subcat'");
    $redirect = "../View/index.php?name=${category}&type=${subcat}";
} 
$catid = mysqli_fetch_assoc($catid);
$catid = $catid['CATEGORY-ID'];


$product_name = $_POST['product-name'];
$articul = $_POST['articul'];
$type = $_POST['type'];
$brand = $_POST['brand'];
$manufacturer = $_POST['manufacturer'];
$description = $_POST['description'];
$price = $_POST['price'];
$count = $_POST['count'];
$attributes = $_POST['attributes'];
$frontImage = $_POST['main-image'];
$images = $_POST['images'];
$statusImg = $_POST['uploadImageStatus'];



if($statusImg === "false"){
mysqli_query($connect, "INSERT INTO `products` (`ID`, `CATEGORY-ID`, `BARCODE`, `COUNT`, `PRODUCT-NAME`, `ARTICUL`, `TYPE`, `BRAND`, `MANUFACTURER`, `DESCRIPTION`, `PRICE`, `ATTRIBUTES`, `MAIN-IMAGE`, `IMAGES`) VALUES (NULL, '$catid', NULL, '$count', '$product_name', '$articul', '$type', '$brand', '$manufacturer', '$description', '$price', '$attributes', '$frontImage', '$images')");

header("Location: ${redirect}");
} elseif($statusImg === "true") {
    
    if(isset($_FILES['files']['name']) and (count(array_filter($_FILES['files']['name'])) > 0)) {
    
    mkdir($backRoute.'Data/Product/'.$articul.'/', 0777);
    $target_dir = $backRoute.'Data/Product/'.$articul.'/';
 
    $total_files = count(array_filter($_FILES['files']['name']));
    $imagesjson = '[';
    
    for($key = 0; $key < $total_files; $key++) {
        if(isset($_FILES['files']['name'][$key]) && $_FILES['files']['size'][$key] > 0) {
            $original_filename = $_FILES['files']['name'][$key];
            $target = $target_dir . basename($original_filename);
            $tmp  = $_FILES['files']['tmp_name'][$key];
            move_uploaded_file($tmp, $target);
            if($total_files != $key+1){
                $imagesjson .= '"' . 'Data/Product/'.$articul.'/'.$original_filename = $_FILES['files']['name'][$key] . '", ';
            } else {
                $imagesjson .= '"' . 'Data/Product/'.$articul.'/'.$original_filename = $_FILES['files']['name'][$key] . '"]';
            }
            if($key == 0){
                $frontImage = 'Data/Product/'.$articul.'/'.$original_filename = $_FILES['files']['name'][$key];
            }
        }
    }
    
    mysqli_query($connect, "INSERT INTO `products` (`ID`, `CATEGORY-ID`, `BARCODE`, `COUNT`, `PRODUCT-NAME`, `ARTICUL`, `TYPE`, `BRAND`, `MANUFACTURER`, `DESCRIPTION`, `PRICE`, `ATTRIBUTES`, `MAIN-IMAGE`, `IMAGES`) VALUES (NULL, '$catid', NULL, '$count', '$product_name', '$articul', '$type', '$brand', '$manufacturer', '$description', '$price', '$attributes', '$frontImage', '$imagesjson')");
    
    header("Location: ${redirect}");
    
    } 
}
    







?>