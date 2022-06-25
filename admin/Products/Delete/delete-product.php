<?php
session_start(); 
$backRoute = '../../../';
require_once $backRoute.'Core/connect.php';
require_once $backRoute.'Core/checkAuth.php';
require_once $backRoute.'Core/checkFlagAdmin.php';

$id = $_GET['id'];

$method = $_SERVER['REQUEST_METHOD'];
if($method === 'DELETE'){
        if(isset($id)){
            deleteProduct($connect, $id);
        }
}

function deleteProduct($connect, $id){
    mysqli_query($connect, "DELETE FROM `products` WHERE `products`.`ID` = '$id'");
    http_response_code(200);
    $res = [
        "status" => true,
        "message" => "Product is deleted"
    ];        
    echo json_encode($res);
}








