<?php
session_start(); 
require_once 'Core/connect.php';
require_once 'Core/checkAuthPassive.php';
include 'Template/Header.php';

$login = $_SESSION['user'];
if($login == ''){
    $login = 'unauthorized';
}


?>
<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="utf-8">
        <meta name="viewport" content="width=806">
		<title>EIGHSTORE - Корзина</title>
        <link rel="shortcut icon" href="/icons/favicon.svg" type="image/x-icon">
		<link href="style.css<? echo $style ?>" rel="stylesheet">
        <link href="flex.css<? echo $flex ?>" rel="stylesheet">
        <script src="header.js<? echo $script ?>"></script>
    
        <script>
            
            function checkedAll() {
	           var aa= document.getElementById('frm1');
	           if (checked == false){
                   checked = true;
                } else {
                   checked = false;
                }
	           for (var i = 0; i < aa.elements.length; i++){
	               aa.elements[i].checked = checked;
	           }
                changeEventRefresher();
            }
            function checkedAllOff(){
                if(checked = true){
                    document.querySelector('#checkall').checked = false;
                    checked = false;
                }
                changeEventRefresher();
            }
            
            async function order(){
                var cartData = getCartData();
                var orderData = {};
                var login = '<? echo $login ?>';
    
                for(items in cartData){
                    let id = cartData[items][0];
                    let count = Number(cartData[items][2]);
                    let status = cartData[items][5];
        
                    if(status){
                        orderData[id] = [id, count];
                    }
        
                }
                
                
                let order = JSON.stringify(orderData)
                let formData = new FormData();
                formData.append('login', login);
                formData.append('order', order);
                
                let res = await fetch('<? echo $SiteUrl ?>order/query?type=new', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await res.json();
                
                if(data.status === true){
                    
//                    for(items in cartData){
//                        let id = cartData[items][0];
//                        let count = Number(cartData[items][2]);
//                        let status = cartData[items][5];
//                        if(status){
//                            deleteFromBasket(id);
//                        }
//                    }
                    
                    window.location.replace('<? echo $SiteUrl ?>order/?transit='+data['order_id']+'&order='+data['order_stamp']);
                    
                } 
                
            }
            
            
        </script>
	</head>

	<body>
        <!--                 Header                -->  
        <?php
            include 'Template/HeaderHtml.php';
            $username = $_SESSION['user'];
            headershow($username, '', '');
        ?>
        <!--                 Header                -->  
        
<!--                 Main Content               -->           
        <div class="eigh-main-content">
        
        
            <div class="basket-page-container">
            
                <h2 style="margin-bottom: 25px;" id="basket-back"><a onclick="window.history.back()" style="cursor: pointer"><img class="main_catalog_link_arrow img-right" src="<? echo $backRoute ?>icons/down.svg"></a>Ваша корзина</h2>
                
                <form id="frm1">
                
                    <div class="basketCase">
                        
                <div class="basket-all-info row-between pos-center">
                
                    
                </div><br>
                

                    </div>
                </form>
                
                <a style="cursor: pointer" onclick="order()"><div class="basket-page-order row-center pos-center" id="order-button">
                
                    <h3>ЗАКАЗАТЬ</h3>
                
                </div></a>
                    
            </div>
           
            
        </div>
<!--                 Main Content               -->           
        
        <!--   Bottom   -->
        <?php
            printBottom('');
        ?>
        <!--   Bottom   -->
        <script>openCart('');</script>
	</body>
</html>