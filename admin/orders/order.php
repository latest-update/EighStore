<?php
session_start(); 
$backRoute = '../../';
require_once $backRoute.'Core/connect.php';
require_once $backRoute.'Core/checkAuth.php';
require_once $backRoute.'Core/checkFlagAdmin.php';
$id = $_GET['id'];
$stamp = $_GET['stamp'];

$info = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `orders` WHERE `ID` = '$id'"));
$total = $info['TOTAL'] + $info['DELIVERY-PRICE'];

?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=806">
    <title>EIGHSTORE - Заказ №<? echo $stamp ?></title>
    <link rel="shortcut icon" href="../../icons/favicon.svg" type="image/x-icon">
    <link href="../../style.css<? echo $style ?>" rel="stylesheet">
    <link href="../../flex.css<? echo $flex ?>" rel="stylesheet">
    <script src="../../header.js<? echo $script ?>"></script>
    <script>
    var order_id = <? echo $id ?>;
    var paymentType = '<? echo $info['PAYMENT-TYPE'] ?>';    
    var statusOfOrder = <? echo $info['DONE'] ?>;    
       
    
    async function getOrderInfo(){
        let res = await fetch('interaction/query?type=order_items&order_id=' + order_id);
        let products = await res.json();
        let d = document.querySelector('.order-list-conf');
        d.innerHTML = '';
        for(let product of products){
            d.innerHTML += `<div class="order-list-el row-between pos-center">
                    
                <img src="<? echo $SiteUrl ?>${product['MAIN-IMAGE']}" width="56">
                <div class="column">
                    <a href="<? echo $SiteUrl ?>product?product=${product['ID']}"><h4 style="width: 200px; overflow: hidden">${product['PRODUCT-NAME']}</h4></a>
                    <p>${product['ARTICUL']}</p>
                </div>
                <div class="column">
                    <h3>${product['BUYCOUNT']}шт</h3>
                    <h5>Доступно на складе: ${product['COUNT']}</h5>
                </div>
                <h4>${product['PRICE']}₸</h4>
                        
                        
            </div>`;
        }
        document.querySelector('.order-list-lp').innerHTML = `
            <div class="row pos-center"><p style="margin-right: 10px;">Сумма товаров: </p><h4><? echo $info['TOTAL'] ?>₸</h4></div>
            <div class="row pos-center"><h4 style="margin-right: 10px; color: #278458">Общая сумма (с доставкой): </h4><h4><? echo $total ?>₸</h4></div>
        `;
        document.querySelector('.order-list-del').innerHTML = `
                <div class="row pos-center"><p style="margin-right: 10px;">Доставка: </p><h4><? echo $info['DELIVERY-PRICE'] ?>₸</h4></div>
        `; 
        document.querySelector('.order-info-delivery').innerHTML = `
                <p><strong>Город:</strong> <? echo $info['CITY'] ?></p>
                <p><strong>Адрес:</strong> <? echo $info['ADDRESS'] ?></p>
                <p><strong>Контактный телефон:</strong> <? echo $info['TELNUM'] ?></p>
                <p><strong>Покупатель:</strong> <? echo $info['NAME-FAMILY'] ?></p>
                <p><strong>Логин:</strong> ~<? echo $info['LOGIN'] ?></p>
        `;  
        let order_status = null;
        switch(statusOfOrder){
            case 1:
                order_status = `<div id="status_new" class="row-around pos-center"  style="cursor: pointer; width: 100px; margin: auto" title="<? echo $info['STATUS'] ?>"><div id="doted" style="background-color: #28A729"></div><h5>НОВЫЙ</h5></div>`;
            break;
            case 2:
                order_status = `<div id="status_inprocess" style="cursor: pointer" title="<? echo $info['STATUS'] ?>"><h5>В ОБРАБОТКЕ</h5></div>`;
            break;
            case 3:
                order_status = `<div id="status_ready" style="cursor: pointer" title="<? echo $info['STATUS'] ?>"><h5>ГОТОВО</h5></div>`;
            break;
            case 4:
                order_status = `<div id="status_done" style="cursor: pointer" title="<? echo $info['STATUS'] ?>"><h5>ДОСТАВЛЕНО</h5></div>`;
            break;    
        }
        document.querySelector('.order-info-status').innerHTML = `${order_status}`;
        
        
        
    }
    
    
    </script>
    
    
    
</head>
<body>
    <!--                 Header                -->  
        <?php
            include $backRoute.'Template/HeaderHtml.php';
            $username = $_SESSION['user'];
            headershow($username, 0, '');
        ?>
        <!--                 Header                -->  
        
<!--                 Main Content               -->    
    <div class="eigh-main-content">
    
        <div class="order-page-container">

            <h2 style="margin-bottom: 25px;">Просмотр заказа</h2>
            
        
        
        <div class="order-page-content">
            
                <h3>Заказ №<? echo $stamp; ?></h3><br>
                <div style="border-top: 1px solid #eee;"></div><br>
            
                <div class="row"><h4 style="margin-right: 20px;">Статус заказа: </h4><div class="order-info-status"></div></div><br>
            
                
                
                 
                <div class="order-list-conf column pos-center">
                
                    
                
                </div><br>
            
                
                <div class="order-info-delivery column-around pos-start">
                    
                    
                    
                </div><br>
                
            
                <div class="order-list-del row-between pos-center">
                
                
                
                </div><br>
                
                <div class="order-list-lp row-between pos-center">
                
                
                
                </div><br>
                
                
                <label for="confirmation">
<!--
                <div class="order-list-confirmation row pos-center">
                
                    <input type="checkbox" name="confirmation" id="confirmation"><h5 style="margin-left: 10px">Покупая товар в магазине я подтверждаю что прочитал чек и количество заказуемых товаров а так же даю согласие на обработку персональных данных</h5>
                    
                </div>
-->
                </label>
            
            </div>
            
        </div>
        
        
    </div>
    <script>
    
        getOrderInfo();    
        
    </script>
</body>
</html>