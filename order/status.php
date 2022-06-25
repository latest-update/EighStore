<?php
session_start(); 
$backRoute = '../';
require_once $backRoute.'Core/connect.php';
require_once $backRoute.'Core/checkAuthPassive.php';
include $backRoute.'Template/Header.php';
$order = $_GET['order'];
$content = '';

if(isset($order)){
    
    $content = '<div class="order-page-content" id="id1046">
            
                    <h3>Проверка заказа</h3><br>
                    <div style="border-top: 1px solid #eee;"></div><br>
                    
                    <div id="contentishe" style="display: block">
                        
                    </div><br>
                    
                    <div class="order-list-conf column pos-center" id="listishe" style="display: none">
                    
                        
                
                    </div><br>
                
                </div>';
    
} else {
    $content = '<div class="order-page-content" id="id1046">
            
                    <h3>Проверка заказа</h3><br>
                    <div style="border-top: 1px solid #eee;"></div><br>
                    
                    <p>Проверить статус заказа можно по <span style="color: green">№ заказа</span> или по указанному в оформлении<span style="color: green"> контактному номеру</span></p><br>
                    
                    <div style="border-top: 1px solid #eee;"></div><br>
                    
                    
                    <div id="contentishe" style="display: block">
                    <input class="order-page-input-1" type="text" placeholder="Номер заказа или ваш номер телефона" id="order"><br><br>
                    
                    <button type="button" id="step-next" onclick="checkOrder()">Проверить</button><br>
                    </div><br>
                    
                    <div class="order-list-conf column pos-center" id="listishe" style="display: none">
                    
                        
                
                    </div><br>
                
                </div>';
}

?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=806">
    <title>EIGHSTORE - Проверка заказа
    </title>
    <link rel="shortcut icon" href="../icons/favicon.svg" type="image/x-icon">
    <link href="../style.css<? echo $style ?>" rel="stylesheet">
    <link href="../flex.css<? echo $flex ?>" rel="stylesheet">
    <script src="../header.js<? echo $script ?>"></script>
    <script>
    var orderSearch = `<input class="order-page-input-1" type="text" placeholder="Номер заказа или ваш номер телефона" id="order"><br><br><button type="button" id="step-next" onclick="checkOrder()">Проверить</button><br>`;
    var orders = null;
    
        
    async function checkOrder(stamp){
        let inpch = null;
        if(stamp == null){
            inpch = document.getElementById('order').value;
        } else {
            inpch = stamp;
        }
        let content_div = document.getElementById('contentishe');
        let list_div = document.getElementById('listishe');
        content_div.innerHTML = '';
        content_div.innerHTML = `
            <p>Поиск заказов</p><br>
        `;
        
        let res = await fetch('<? echo $SiteUrl ?>order/query?type=status&order='+inpch);
        orders = await res.json();
        let d = document.querySelector('.order-list-conf');
        d.innerHTML = '';
        
        if(orders.length > 0){
            
            for(let order of orders){
                
                d.innerHTML += `
                    <div class="order-list-el row-between pos-center">
                    
                        <img src="<? echo $SiteUrl ?>icons/status_box.svg" width="56">
                        <div class="column">
                            <h4 style="width: 200px; overflow: hidden">Номер заказа</h4>
                            <p>${order['ORDER-STAMP']}</p>
                        </div>
                        <div class="column pos-center">
                            <h3>Статус заказа</h3>
                            <h5>${order['STATUS']}</h5>
                        </div>
                        <h4></h4>
                        
                        
                    </div>
                `;
                
            }
            
            content_div.style.display = "none";
            list_div.style.display = "flex";
            
        } else {
            d.innerHTML += `
                    <div class="order-list-el row-between pos-center">
                    
                        <img src="<? echo $SiteUrl ?>icons/not-found.svg" width="56">
                        <div class="column">
                            <h4 style="width: 200px; overflow: hidden">Уведомление</h4>
                            <p>Не найдено заказов по вашему запросу</p>
                        </div>
                        <div class="column pos-center">
                            <h3></h3>
                            <h5></h5>
                        </div>
                        <h4></h4>
                        
                    </div>
                `;
            
            content_div.style.display = "none";
            list_div.style.display = "flex";
        }
        
        d.innerHTML += `
            <div class="order-list-el row-between pos-center"><button type="button" id="step-back" onclick="home()">Назад</button></div>
        `;
        
    }
        
    function home(){
        let content_div = document.getElementById('contentishe');
        let list_div = document.getElementById('listishe');
        content_div.innerHTML = orderSearch;
        
        list_div.style.display = "none";
        content_div.style.display = "block";
        
    }    
    
    </script>
</head>
    
    <body>
        <!--                 Header                -->
    <?php
            include '../Template/HeaderHtml.php';
            $username = $_SESSION['user'];
            headershow($username, '', '');
        ?>
    <!--                 Header                -->
        
        <div class="eigh-main-content">
        
            <div class="order-page-container">
            
            
                <?php echo $content;  ?>
                
            
            </div>
        
        
        </div>
        
        <?php
            printBottom('../');
        ?>
    
    <script>
        
        <?php
            if(isset($order)){
                echo "checkOrder(${order});";
            }
        ?>
    
    </script>
    </body>
</html>