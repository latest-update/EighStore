<?php
session_start(); 
$backRoute = '../../../';
require_once $backRoute.'Core/connect.php';
require_once $backRoute.'Core/checkAuth.php';
require_once $backRoute.'Core/checkFlagAdmin.php';

$id = $_POST['delete-id'];
$subcatName = $_POST['subcat-name'];
$catName = $_POST['subcategory-name'];
$categoryName = $_POST['category-name'];
$categoryImage = $_POST['category-image'];


if($subcatName != '' and !(isset($catName))){
    mysqli_query($connect, "INSERT INTO `category` (`CATEGORY-ID`, `CATEGORY-NAME`, `SUBCATEGORY-NAME`, `SUBSUBCATEGORY-NAME`, `CATEGORY-IMAGE`) VALUES (NULL, '$categoryName', '$subcatName', NULL, '$categoryImage')");
    header("Location: ${backRoute}Template/HeaderRender.php");
} elseif($subcatName != '' and isset($catName)){
//    mysqli_query($connect, "INSERT INTO `category` (`CATEGORY-ID`, `CATEGORY-NAME`, `SUBCATEGORY-NAME`, `SUBSUBCATEGORY-NAME`, `CATEGORY-IMAGE`) VALUES (NULL, '$categoryName', '$catName', '$subcatName', '$categoryImage')");
//    mysqli_query($connect, "DELETE FROM `category` WHERE `category`.`CATEGORY-ID` = '$delete'");
    $count = mysqli_query($connect, "SELECT COUNT(*) as `count` FROM `category` WHERE `CATEGORY-NAME` = '$categoryName' AND `SUBCATEGORY-NAME` = '$catName' AND `SUBSUBCATEGORY-NAME` != ''");
    $count = mysqli_fetch_assoc($count);
    if($count['count'] > 0){
        mysqli_query($connect, "INSERT INTO `category` (`CATEGORY-ID`, `CATEGORY-NAME`, `SUBCATEGORY-NAME`, `SUBSUBCATEGORY-NAME`, `CATEGORY-IMAGE`) VALUES (NULL, '$categoryName', '$catName', '$subcatName', '$categoryImage')");
    } else {
        mysqli_query($connect, "UPDATE `category` SET `SUBSUBCATEGORY-NAME` = '$subcatName' WHERE `category`.`CATEGORY-ID` = '$id'");
    }
    header("Location: ${backRoute}Template/HeaderRender.php");
}

?>
