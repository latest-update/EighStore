<?php
session_start(); 
$backRoute = '../../';
require_once $backRoute.'Core/connect.php';
require_once $backRoute.'Core/checkAuth.php';
require_once $backRoute.'Core/checkFlagAdmin.php';

?>
<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="utf-8">
        <meta name="viewport" content="width=806">
		<title>EIGHSTORE</title>
        <link rel="shortcut icon" href="../../icons/favicon.svg" type="image/x-icon">
		<link href="../../style.css<? echo $style ?>" rel="stylesheet">
        <link href="../../flex.css<? echo $flex ?>" rel="stylesheet">
        <script src="../../header.js<? echo $script ?>"></script>
        <script>
        var orders = null;
        var tab_orders = [];    
        var this_tab = 'tab-all';
        var orders_status = '777';    
        var thisPage = 1;        
        var numberOfOrders = 0;   
        var pageOfOrders = 0;  
            
        async function serverQuery(){
            let res = await fetch('interaction/query?type=orders');
            orders = await res.json();
            tab_orders = orders;
            numberOfOrders = orders.length;
            pageOfOrders = Math.ceil(numberOfOrders/2);
            setTab(this_tab, orders_status);
        }
        
        function refreshData(){
            document.querySelector('#product-table-body').innerHTML = '';
            serverQuery();
        }    
           
        function setTab(tab, done){
            let tmp_arr = [];
            let current_tab = document.getElementById(this_tab);
            this_tab = tab;
            let next_tab = document.getElementById(this_tab);
            orders_status = done;
            if(orders_status === '777'){ 
                tab_orders = orders;
            } else {
                for(var order of orders){
                    if(order.DONE === orders_status){
                        tmp_arr.push(order);
                    }
                }
                tab_orders = tmp_arr;
            }
            
            current_tab.className = 'tab-item';
            next_tab.className = 'tab-item active';
            
            numberOfOrders = tab_orders.length;
            pageOfOrders = Math.ceil(numberOfOrders/2);
            setOrdersData();
        }    
        
        function setOrdersData(){
            showData(1, tab_orders);
        }
            
        function searchOrders(searchWord){
            let tmp_arr = [];
            
            if(searchWord !== '' || searchWord !== ' ' || searchWord !== null){
                        
            for(var order of tab_orders){
                
                let nf = order['NAME-FAMILY'].toLowerCase(), lgn = order['LOGIN'].toLowerCase(), cty = order['CITY'].toLowerCase(), ors = order['ORDER-STAMP'].toLowerCase(), tl = order['TELNUM'].toLowerCase(), pay = order['PAYMENT-TYPE'].toLowerCase(), del = order['DELIVER-TYPE'].toLowerCase();
                
                if((nf.includes(searchWord)) || (lgn.includes(searchWord)) || (cty.includes(searchWord)) || (ors.includes(searchWord)) || (tl.includes(searchWord)) || (pay.includes(searchWord)) || (del.includes(searchWord))){
                    tmp_arr.push(order);
                }
            }
            
            numberOfOrders = tmp_arr.length;
            pageOfOrders = Math.ceil(numberOfOrders/2);
            showData(1, tmp_arr);
            } else {
                showData(thisPage, tab_orders);
            }
        }    
            
        function showData(page, dataArray){
            thisPage = page;
//            tab_orders = dataArray;
            let numberOfElementsThisPage = page * 2;
            document.querySelector('#product-table-body').innerHTML = '';
            for(let i = numberOfElementsThisPage - 2; i < numberOfElementsThisPage && i < numberOfOrders; i++){
                let order = dataArray[i];
                let order_status = null;
                let total = Number(order['TOTAL']) + Number(order['DELIVERY-PRICE']);
                let paymentType = order['PAYMENT-TYPE'];
                let delivery = null;
                
                
                switch(order.DONE){
                    case '1':
                        order_status = `<div id="status_new" class="row-around pos-center"  style="cursor: pointer; min-width: 100px; margin: auto" title="${order.STATUS}"><div id="doted" style="background-color: #28A729"></div><h5>НОВЫЙ</h5></div>`;
                    break;    
                    case '2':
                        order_status = `<div id="status_inprocess" style="cursor: pointer" title="${order.STATUS}"><h5>В ОБРАБОТКЕ</h5></div>`;
                    break;
                    case '3':
                        order_status = `<div id="status_ready" style="cursor: pointer" title="${order.STATUS}"><h5>ГОТОВО</h5></div>`;
                    break;
                    case '4':
                        order_status = `<div id="status_done" style="cursor: pointer" title="Доставлено"><h5>ДОСТАВЛЕНО</h5></div>`;
                    break;    
                        
                }
                
                switch(paymentType){
                    case 'kaspi': 
                        paymentType = `<img src="../../icons/kaspi.svg" width="80">`;
                    break;  
                    case 'cardPay': 
                        paymentType = `<img src="../../icons/cardPay.svg" width="30">`;
                    break; 
                }
                
                switch(order['DELIVER-TYPE']){
                    case "Доставка":
                        delivery = `<td title="Адрес: Г.${order.CITY + ', ' + order.ADDRESS}" style="cursor: pointer"><img src="../../icons/delivery-man.svg" width="30"></td>`;
                    break;
                    case "Казпочта":
                        delivery = `<td title="Адрес: Г.${order.CITY + ', ' + order.ADDRESS}" style="cursor: pointer"><img src="../../icons/kazpost.svg" width="60"></td>`;
                    break;
                    case "Самовывоз":
                        
                    break;
                    case "Транспортные компании":
                        
                    break;    
                }
                
                
                
                document.querySelector('#product-table-body').innerHTML += `
                    <tr>
                            
                        <td><a href="order?id=${order['ID']}&stamp=${order['ORDER-STAMP']}" target="_blank">${order['ORDER-STAMP']}</a></td>
                        <td title="Контактный телефон: ${order.TELNUM}" style="cursor: pointer">${order['NAME-FAMILY']}</td>
                        <td>${order_status}</td>
                        <td>${total} ₸</td>
                        <td>${order.TIME}</td>
                        <td title="Тип платежа" style="cursor: pointer">${paymentType}</td>
                        ${delivery}
                            
                    </tr>
                `;
                
            }
            if(pageOfOrders > 1){
                
                document.querySelector('.pagination').innerHTML = '';
                
                for(let i = 1; i <= pageOfOrders; i++){
                    
                    if(i == thisPage){
                        document.querySelector('.pagination').innerHTML += `
                            <a style="cursor: pointer" class="active" onclick="showData(${i}, tab_orders)">${i}</a>
                        `;
                    } else {
                        document.querySelector('.pagination').innerHTML += `
                            <a style="cursor: pointer" href="#" onclick="showData(${i}, tab_orders)">${i}</a>
                        `;
                    }
                
                }
                } else {
                    document.querySelector('.pagination').innerHTML = '';
                }
        }    
        </script>
        
	</head>

	<body>
        <!--                 Header                -->  
        <?php
            include $backRoute.'Template/HeaderHtml.php';
            $username = $_SESSION['user'];
            headershow($username, 0, 'admin');
        ?>
        <!--                 Header                -->  
        
<!--                 Main Content               -->           
        <div class="eigh-main-content">   
            
            <div class="orders-main-content">
                <br>
                <div class="row-between pos-center">
                    <h2 style="margin-bottom: 25px;"><a onclick="window.history.back()" style="cursor: pointer"><img class="main_catalog_link_arrow img-right" src="<? echo $backRoute ?>icons/down.svg"></a>Заказы</h2>
                    <a style="cursor: pointer" onclick="refreshData()"><h4 style="margin-bottom: 10px; margin-left: -100px;">Обновить</h4></a>
                </div>
                
            
                <div class="tab row-start">
                        
                        
                    <div class="tab-item active" id="tab-all">
                        <a onclick="setTab('tab-all', '777')" style="text-decoration: none; cursor: pointer">
                            <h3>Все</h3>
                        </a>
                    </div>
                        
                        
                    <div class="tab-item" id="tab-new">
                        <a onclick="setTab('tab-new', '1')" style="text-decoration: none; cursor: pointer">
                        <h3>Новые</h3>
                        </a>
                    </div>
                    
                    <div class="tab-item" id="tab-inprocess">
                        <a onclick="setTab('tab-inprocess', '2')" style="text-decoration: none; cursor: pointer">
                        <h3>В обработке</h3>
                        </a>
                    </div>
                    
                    <div class="tab-item" id="tab-ready">
                        <a onclick="setTab('tab-ready', '3')" style="text-decoration: none; cursor: pointer">
                        <h3>Готовые</h3>
                        </a>
                    </div>
                    
                    <div class="tab-item" id="tab-done">
                        <a onclick="setTab('tab-done', '4')" style="text-decoration: none; cursor: pointer">
                        <h3>Доставлено</h3>
                        </a>
                    </div>
                    
                </div><br>
                
                <div class="orders-search row-start pos-center">
                    
                    <a id="search_onoff"><div class="search-icon row-center pos-center"><img class="search-img" src="<? echo $backRoute ?>icons/search.svg"/></div></a>
                    <input class="order-search-field" type="search" placeholder="Поиск заказов" name="orderSearch" id="orderSearch">
                    
                </div><br>
                
                
                <div class="admin-orders-content">
                
                <div class="product-page-models">
                    
                    <table id="product-table">
                    
                        <thead>
                        
                            <tr>
                                
                                <th>Заказ #</th>
                                <th>Покупатель</th>
                                <th>Статус</th>
                                <th>Сумма покупки</th>
                                <th>Время</th> 
                                <th>Тип платежа</th>
                                <th>Доставка</th>
                            
                            </tr>
                        
                        </thead>
                        
                        <tbody id="product-table-body">
                            
                        
                            <tr>
                            
                                <td>51651566165</td>
                                <td title="Контактный телефон: 87478801397" style="cursor: pointer">Рахат Бакытжанов</td>
                                <td><div id="status_new" class="row-around pos-center"  style="cursor: pointer" title="Ожидание отправки счета для оплаты"><div id="doted" style="background-color: #28A729"></div><h5>НОВЫЙ</h5></div></td>
                                <td>56000 ₸</td>
                                <td>2021-07-12 18:58:57</td>
                                <td title="Каспи счет: 87781328796" style="cursor: pointer"><img src="../../icons/kaspi.svg" width="80"></td>
                                <td title="Адрес: Г.Алматы, Жибек жолы 11б" style="cursor: pointer"><img src="../../icons/delivery-man.svg" width="30"></td>
                            
                            </tr>
                            
                            
                            <tr>
                            
                                <td>51651566165</td>
                                <td>Данияр Бауыржан</td>
                                <td><div id="status_done" style="cursor: pointer" title="Доставлено"><h5>ДОСТАВЛЕНО</h5></div></td>
                                <td>15000 ₸</td>
                                <td>2021-07-12 18:58:57</td>
                                <td>Оплачено</td>
                                <td title="Адрес: Г.Астана, Жибек жолы 11б" style="cursor: pointer"><img src="../../icons/kazpost.svg" width="60"></td>
                            
                            </tr>
                            
                            <tr>
                            
                                <td>51651566165221</td>
                                <td>Рахат Бакытжанов</td>
                                <td><div id="status_inprocess" style="cursor: pointer" title="В пути на адрес доставки"><h5>В ОБРАБОТКЕ</h5></div></td>
                                <td>56000 ₸</td>
                                <td>2021-07-12 18:58:57</td>
                                <td>Kaspi</td>
                                <td>Посмотреть</td>
                            
                            </tr>
                            
                            <tr>
                            
                                <td>51651566165</td>
                                <td>Данияр Бауыржан</td>
                                <td><div id="status_done" style="cursor: pointer" title="Доставлено"><h5>ДОСТАВЛЕНО</h5></div></td>
                                <td>15000 ₸</td>
                                <td>2021-07-12 18:58:57</td>
                                <td>Kaspi</td>
                                <td>Посмотреть</td>
                            
                            </tr>
                            
                            <tr>
                            
                                <td>51651566165221</td>
                                <td>Рахат Бакытжанов</td>
                                <td><div id="status_inprocess" style="cursor: pointer" title="В пути на адрес доставки"><h5>В ОБРАБОТКЕ</h5></div></td>
                                <td>56000 ₸</td>
                                <td>2021-07-12 18:58:57</td>
                                <td>Kaspi</td>
                                <td>Посмотреть</td>
                            
                            </tr>
                            
                            <tr>
                            
                                <td>51651566165221</td>
                                <td>Рахат Бакытжанов</td>
                                <td><div id="status_inprocess" style="cursor: pointer" title="В пути на адрес доставки"><h5>В ОБРАБОТКЕ</h5></div></td>
                                <td>56000 ₸</td>
                                <td>2021-07-12 18:58:57</td>
                                <td>Kaspi</td>
                                <td>Посмотреть</td>
                            
                            </tr>
                            
                            <tr>
                            
                                <td>51651566165</td>
                                <td>Данияр Бауыржан</td>
                                <td><div id="status_done" style="cursor: pointer" title="Доставлено"><h5>ДОСТАВЛЕНО</h5></div></td>
                                <td>15000 ₸</td>
                                <td>2021-07-12 18:58:57</td>
                                <td>Kaspi</td>
                                <td>Посмотреть</td>
                            
                            </tr>
                            
                            <tr>
                            
                                <td>51651566165</td>
                                <td>Данияр Бауыржан</td>
                                <td><div id="status_close" style="cursor: pointer" title="Не оплачено"><h5>ОТМЕНЕНО</h5></div></td>
                                <td>15000 ₸</td>
                                <td>2021-07-12 18:58:57</td>
                                <td>Kaspi</td>
                                <td>Посмотреть</td>
                            
                            </tr>
                            
                            <tr>
                            
                                <td>51651566165</td>
                                <td>Рахат Бакытжанов</td>
                                <td><div id="status_new" class="row-around pos-center"  style="cursor: pointer" title="Ожидание подтверждении"><div id="doted" style="background-color: #28A729"></div><h5>НОВЫЙ</h5></div></td>
                                <td>56000 ₸</td>
                                <td>2021-07-12 18:58:57</td>
                                <td><img src="../../icons/mastercard.svg" width="80"></td>
                                <td>Посмотреть</td>
                            
                            </tr>
                            
                            <tr>
                            
                                <td>51651566165</td>
                                <td>Рахат Бакытжанов</td>
                                <td><div id="status_new" class="row-around pos-center"  style="cursor: pointer" title="Ожидание отправки счета для оплаты"><div id="doted" style="background-color: #28A729"></div><h5>НОВЫЙ</h5></div></td>
                                <td>56000 ₸</td>
                                <td>2021-07-12 18:58:57</td>
                                <td>Kaspi</td>
                                <td>Посмотреть</td>
                            
                            </tr>
                            
                            
                        
                        </tbody>
                        
                    </table>
                
                </div>
                
                </div><br>
                
                <div class="row-center pos-center">
                
                    <div class="pagination">
                        
                    </div>
                
                </div>
            
            </div>          
             
        </div>
<!--                 Main Content               -->           
        <script>
            serverQuery();
            document.getElementById('orderSearch').addEventListener("keyup", function() {
                var e = document.getElementById('orderSearch');
                searchOrders(e.value.toLowerCase());
            });
        </script>
	</body>
</html>