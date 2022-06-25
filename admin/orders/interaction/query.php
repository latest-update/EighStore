<?php
$backRoute = '../../../';
//header('Access-Control-Allow-Origin: *');   SELECT * FROM `orders` ORDER BY `TIME` DESC
//header('Access-Control-Allow-Headers: *');
//header('Access-Control-Allow-Methods: *');
//header('Access-Control-Allow-Credentials: true');
header('Content-Type: application/json');
require_once $backRoute.'Core/connect.php';

$method = $_SERVER['REQUEST_METHOD'];
$query = $_GET['type'];

if($method === 'GET'){
    
    switch($query){
        case 'orders':
            
            $orderJson = mysqli_query($connect, "SELECT * FROM `orders` WHERE `DONE` > 0 ORDER BY `TIME` DESC");
            $orderList = [];
            
            while($order = mysqli_fetch_assoc($orderJson)){                      
                $orderList[] = $order;
            }
            
            echo json_encode($orderList);
            
        break;
        
        case 'order_items':
            
            $orderId = $_GET['order_id'];
            $orderJson = mysqli_fetch_assoc(mysqli_query($connect, "SELECT `ORDER-JSON`,`TOTAL` FROM `orders` WHERE `ID` = '$orderId'"));
            $products = '';
            $productList = [];
            $total = 0;
            
            $orderJson = (array) json_decode($orderJson['ORDER-JSON'], true);
            
            foreach($orderJson as $arr){
                if($products == ''){
                    $products .= $arr[0];
                } else {
                    $products .= ','.$arr[0];
                }
            }
            
            $products = mysqli_query($connect, "SELECT * FROM `products` WHERE `ID` IN (".$products.")");
            
            if(count($orderJson) > 0){
            while($product = mysqli_fetch_assoc($products)){
                $product['BUYCOUNT'] = (integer) $orderJson[$product['ID']][1];
                if($product['BUYCOUNT'] > $product['COUNT']){
                    $product['BUYCOUNT'] = (integer) $product['COUNT'];
                    $edit = true;
                    $orderJson[$product['ID']][1] = $product['BUYCOUNT'];
                } 
                $total += $product['BUYCOUNT'] * $product['PRICE'];
                unset($product['ATTRIBUTES']);
                $productList[] = $product;
            }
            }
            
            echo json_encode($productList);
            
        break;    
            
    }
    
} elseif($method === 'POST'){
    
    switch($query){
            
        case 'new':
            
    
            
        break;
            
    }
    
}



?>