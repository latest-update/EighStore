<?php
session_start(); 
$backRoute = '../../../';
require_once $backRoute.'Core/connect.php';
require_once $backRoute.'Core/checkAuth.php';

require_once $backRoute.'Core/checkFlagAdmin.php';

$action = $_GET['action'];
$subcatid = $_GET['id'];
$name = $_GET['name'];
$type = $_GET['type'];


if($subcatid != '' and $action == 'deleteSub'){
    $count = mysqli_query($connect, "SELECT COUNT(*) as `count` FROM `category` WHERE `CATEGORY-NAME` = '$name'");
    $count = mysqli_fetch_assoc($count);
    if($count['count'] > 1){
        mysqli_query($connect, "DELETE FROM `category` WHERE `category`.`CATEGORY-ID` = '$subcatid'");
    } else {
        mysqli_query($connect, "UPDATE `category` SET `SUBCATEGORY-NAME` = NULL WHERE `category`.`CATEGORY-ID` = '$subcatid'");
    }
} elseif ($subcatid != '' and $action == 'deleteSubSub'){
    $count = mysqli_query($connect, "SELECT COUNT(*) as `count` FROM `category` WHERE `CATEGORY-NAME` = '$name' AND `SUBCATEGORY-NAME` = '$type'");
    $count = mysqli_fetch_assoc($count);
        
    if($count['count'] > 1){
        mysqli_query($connect, "DELETE FROM `category` WHERE `category`.`CATEGORY-ID` = '$subcatid'");
    } else {
        mysqli_query($connect, "UPDATE `category` SET `SUBSUBCATEGORY-NAME` = NULL WHERE `category`.`CATEGORY-ID` = '$subcatid'");
    }
}
header("Location: ${backRoute}Template/HeaderRender.php");
?>