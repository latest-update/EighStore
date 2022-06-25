<?php
$backRoute = '../';
//header('Access-Control-Allow-Origin: *');
//header('Access-Control-Allow-Headers: *');
//header('Access-Control-Allow-Methods: *');
//header('Access-Control-Allow-Credentials: true');
header('Content-Type: application/json');
require_once $backRoute.'Core/connect.php';

$method = $_SERVER['REQUEST_METHOD'];
$query = $_GET['type'];


if($method === 'GET'){
    
    switch($query){
        case 'order':
            
            $orderId = $_GET['order_id'];
            $orderStamp = $_GET['order_stamp'];
            $orderJson = mysqli_fetch_assoc(mysqli_query($connect, "SELECT `ORDER-JSON`,`TOTAL` FROM `orders` WHERE `ID` = '$orderId' AND `ORDER-STAMP` = '$orderStamp'"));
            $products = '';
            $productList = [];
            $total = 0;
            $edit = false;
            
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
            
            if($edit and $total != $orderJson['TOTAL']){
                $json = json_encode($orderJson);
                mysqli_query($connect, "UPDATE `orders` SET `ORDER-JSON` = '$json', `TOTAL` = '$total' WHERE `orders`.`ID` = '$orderId'");
            }
            
            echo json_encode($productList);
            
            break;
            
        case 'status': 
            
            $order_id = $_GET['order'];
            
            $orders = mysqli_query($connect, "SELECT * FROM `orders` WHERE `ORDER-STAMP` = '$order_id' OR `TELNUM` = '$order_id'");
            
            $orderList = [];
            
            if(mysqli_num_rows($orders) > 0){
                
                while($order = mysqli_fetch_assoc($orders)){
                    $orderList[] = $order;
                }
                
                
            } 
            
            echo json_encode($orderList);
            
            
            break;
    }
    
} elseif($method === 'POST'){
    
    switch($query){
            
        case 'new':
            
            $login = $_POST['login'];
            $orderJson = $_POST['order'];
            $products = '';
            $total = 0;
            
            $orderJson = (array) json_decode($orderJson, true);
            
            foreach($orderJson as $arr){
                if($products == ''){
                    $products .= $arr[0];
                } else {
                    $products .= ','.$arr[0];
                }
            }
            
            $productList = [];
            
            $products = mysqli_query($connect, "SELECT `ID`, `COUNT`, `PRICE` FROM `products` WHERE `ID` IN (".$products.")");
            while($product = mysqli_fetch_assoc($products)){
                $id = $product['ID'];
                $count = $product['COUNT'];
                $price = $product['PRICE'];
                
                if($count >= $orderJson[$id][1]){
                    $total += $orderJson[$id][1] * $price;
                } elseif($count < $orderJson[$id][1]){
                    $total += $count * $price;
                    $orderJson[$id][1] = (integer) $count;
                } else {
                    $total += 0;
                    $orderJson[$id][1] = 0;
                }
                
            }
            $orderJson = json_encode($orderJson);
            $orderStamp = sprintf("%06d", mt_rand(1, 999999999999));
            if($total > 0){
                mysqli_query($connect, "INSERT INTO `orders` (`ID`, `LOGIN`, `TIME`, `ORDER-JSON`, `TOTAL`, `ORDER-STAMP`, `DELIVERY-PRICE`, `CITY`, `ADDRESS`, `DELIVER-TYPE`, `NAME-FAMILY`, `TELNUM`, `STATUS`, `PAYMENT-TYPE`, `DONE`) VALUES (NULL, '$login', CURRENT_TIMESTAMP, '$orderJson', '$total', '$orderStamp', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0)");
                http_response_code(201);
                $res = [
                    "status" => true,
                    "order_id" => mysqli_insert_id($connect),
                    "order_stamp" => $orderStamp
                ];
                
            } else {
                http_response_code(201);
                $res = [
                    "status" => false,
                    "notification" => "Продукты в корзине устарели, попробуйте добавить их снова",
                    "redirectUrl" => ""
                ]; 
            }
            
            echo json_encode($res);
            
            break;
            
        case 'delivery':
            
            $city = $_POST['city'];
            $order_id = $_POST['order_id'];
            $deliverType = $_POST['deliveryType'];
            $order_stamp = $_POST['order_stamp'];
            $orderCost = mysqli_fetch_assoc(mysqli_query($connect, "SELECT `TOTAL` FROM `orders` WHERE `ID` = '$order_id' AND `ORDER-STAMP` = '$order_stamp'"));
            $orderCost = (integer) $orderCost['TOTAL'];
            
            $deliveryCost = (array) mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `delivery_price` WHERE `CITY` = '$city' AND `DELIVER-TYPE` = '$deliverType'"));
            $Cost = (integer) $deliveryCost['COST'];
            $deliverPeriod = $deliveryCost['PERIOD'];
            
            if($orderCost >= 10000){
                $Cost = 0;
            }
            
            mysqli_query($connect, "UPDATE `orders` SET `DELIVERY-PRICE` = '$Cost' WHERE `orders`.`ID` = '$order_id'"); 
            
            if($orderCost !== '' and $orderCost !== 0 and $orderCost !== null and $Cost !== null){
                http_response_code(201);
                $res = [
                    "status" => true,
                    "deliverCost" => $Cost,
                    "orderCost" => $orderCost,
                    "city" => $city, 
                    "deliverType" => $deliverType,
                    "deliverPeriod" => $deliverPeriod
                ];
            } else {
                $res = [
                    "status" => false
                ];
            }
            
            echo json_encode($res);
            
        break;  
            
            
        case 'kaspi':
            
            $order_id = $_POST['order_id'];
            $order_stamp = $_POST['order_stamp'];
            $paymentType = $_POST['paymentType'];
            $paymentInfo = $_POST['paymentInfo'];
            $status = 'Ожидание отправки счета для оплаты';
            $statusForUser = 'В течение часа на ваш Kaspi по номеру '.$paymentInfo.' будет отправлен счет для оплаты вашей покупки. <br>Оплатить можно любым доступным способом (KASPI RED, KASPI GOLD, KASPI KREDIT)';
            $dbstatus = false;
            
            
            $existOrder = mysqli_query($connect, "SELECT `ID` FROM `orders` WHERE `ID` = '$order_id'");
            $existOrder = mysqli_num_rows($existOrder);
            
            if($existOrder == 1){
            
            
            if($paymentType === 'Kaspi.kz' and $paymentInfo != ''){
                
                if(mysqli_query($connect, "INSERT INTO `kaspi_payment` (`KP-ID`, `ORDER-ID`, `PAYMENT-INFO`, `STATUS`) VALUES (NULL, '$order_id', '$paymentInfo', '$status')") === true){
                    $dbstatus = true;
                }
                
            }
        
            $city = $_POST['city'];
            $address = $_POST['address'];
            $deliverType = $_POST['deliveryType'];
            $nameFamily = $_POST['nameFamily'];
            $telNum = $_POST['telNum'];
            
            if(mysqli_query($connect, "UPDATE `orders` SET `TIME` = CURRENT_TIMESTAMP, `CITY` = '$city', `ADDRESS` = '$address', `DELIVER-TYPE` = '$deliverType', `NAME-FAMILY` = '$nameFamily', `TELNUM` = '$telNum',`STATUS` = '$status', `PAYMENT-TYPE` = 'kaspi', `DONE` = '1' WHERE `orders`.`ID` = '$order_id'") === true){
                $dbstatus = true;
            } else {
                $dbstatus = false; 
            }
            
            }
            
            if($dbstatus === true){
                
                http_response_code(201);
                $res = [
                    "status" => true,
                    "orderStatus" => $status,
                    "orderStatusForUser" => $statusForUser,
                    "orderStamp" => $order_stamp
                ];
                
                echo json_encode($res);
                
            } else {
                http_response_code(201);
                $res = [
                    "status" => false,
                    "notification" => "Произошла ошибка, обратитесь в тех. поддержку",
                    "redirectUrl" => ""
                ];  // redirectUrl -> Страница обращение в тех поддержку
                
                echo json_encode($res);
            }
        
        break;
            
    }
    
}


