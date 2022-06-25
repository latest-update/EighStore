<?php 
session_start(); 
$backRoute = '../../../';
require_once $backRoute.'Core/connect.php';
require_once $backRoute.'Core/checkAuth.php';

require_once $backRoute.'Core/checkFlagAdmin.php';

$action = $_GET['action'];
$id = $_GET['id'];
$edit = $_GET['edit'];

switch($action){
    case 'sub':
        mysqli_query($connect, "UPDATE `category` SET `SUBCATEGORY-NAME` = '$edit' WHERE `category`.`CATEGORY-ID` = '$id'");    
        break;
    case 'subsub':
        mysqli_query($connect, "UPDATE `category` SET `SUBSUBCATEGORY-NAME` = '$edit' WHERE `category`.`CATEGORY-ID` = '$id'");        
        break;    
}
header('Location: ../');
?>