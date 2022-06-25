<?php
session_start(); 
$backRoute = '../';
require_once $backRoute.'Core/connect.php';
require_once $backRoute.'Core/checkAuthPassive.php';
include $backRoute.'Template/Header.php';
$order_id = $_GET['transit'];
$order = $_GET['order'];

$doneOfOrderRegistration = mysqli_fetch_assoc(mysqli_query($connect, "SELECT `DONE` FROM `orders` WHERE `ID` = '$order_id'"));
if($doneOfOrderRegistration['DONE'] > 0){
    header("Location: status?order=${order}");
} 

?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=806">
    <title>EIGHSTORE - Оформление заказа №
        <? echo $order ?>
    </title>
    <link rel="shortcut icon" href="../icons/favicon.svg" type="image/x-icon">
    <link href="../style.css<? echo $style ?>" rel="stylesheet">
    <link href="../flex.css<? echo $flex ?>" rel="stylesheet">
    <script src="../header.js<? echo $script ?>"></script>

    <script>
        var step = 0;
        var step_content = 0;
        var deliver_type = null;
        var deliverCost = 0;
        var deliverPeriod = null;
        var orderCost = 0;
        var City = null;
        var address = null;
        var nameFamily = null;
        var telNum = null;
        var steps0 = 0;
        var delName = null;
        var payName = null;
        var paymentType = null;
        var paymentInfo = null;
        <?php
            if($order != '' and $order_id != ''){
        ?>
        var order_id = <? echo $order_id ?>;
        var order_stamp = '<? echo $order ?>';
        <?php 
            } 
        ?>


        function step_back() {
            let btn = document.getElementById('step-back');
            if (step > 0) {
                if(step == 3){
                    document.getElementById('step-next').innerHTML = 'Дальше';
                }
                step = step - 1;
                
                setStepStatusBack(step);
                
            }
        }


        function step_next() {
            let btn = document.getElementById('step-next');
            if (step < 4) {
                if(checkForSteps(step) === true){
                    setStepStatus(step);
                    step = step + 1;
                }
            }
        }
        
        function checkForSteps(step){
            switch(step){
                case 0:
                    
                    let a = document.getElementById('address-order').value;
                    let b = document.getElementById('fio-order').value;
                    let c = document.getElementById('telnumber-order').value;
                    
                    if(a != '' && b != '' && c != ''){
                        address = a;
                        nameFamily = b;
                        telNum = c;
                        document.getElementById('del-conf').innerHTML = '';
                        document.getElementById('del-conf').innerHTML = `
                            <div class="order-list-el row-between pos-center">
                    
                                <img src="../icons/${delName}.svg" width="96" style="margin-right: 10px;">
    
                                    <p>${address}</p>
                        
                        
                                <p style="text-align: center">${nameFamily}</p>
                    
                                <p>${telNum}</p>
                        
                            </div>
                        `;
                        
                        getOrderInfo();
                        return true;
                    } 
                    return false;
                    
                break;
                    
                case 1:
                    
                    let s = document.getElementById('confirmation');
                    
                    if(s.checked){
                        return true;
                    } 
                    return false;
                    
                break; 
                case 2:
                    paymentInfo = document.getElementById('payid002').value;
                    if(paymentInfo.length == 11){
                        document.getElementById('step-next').innerHTML = 'Подтвердить';
                        document.getElementById('pay-conf').innerHTML = '';
                        document.getElementById('pay-conf').innerHTML = `
                            <div class="order-list-el row-between pos-center">
                    
                                <img src="../icons/${payName}.svg" width="96">
                                <div class="column pos-center">
                                    <h4>Оплата на ${paymentType}</h4>
                                    <p>${paymentInfo}</p>
                                </div>
                                <div class="column pos-center">
                                    <h4>Тип оплаты</h4>
                                    <p>Kaspi Pay</p>
                                </div>
                                
                                <div class="column pos-center">
                                    <h4>Cумма к оплате</h4>
                                    <p>${Number(orderCost)+Number(deliverCost)}₸</p>
                            </div>
                        
                    </div>
                        `;
                        
                        return true;
                    } 
                    return false;
                    
                break;  
                case 3:
                    
                    document.getElementById('step-back').style.display = "none";
                    document.getElementById('step-next').style.display = "none";
                    
                    if(paymentType === 'Kaspi.kz'){
                        
                        confirmPaymentKaspi();
                        
                        return true;
                        
                    } else if(paymentType === 'BANK'){
                        
                        
                        
                    }
                    
                break;    
                    
            }
            
        }
        
        async function confirmPaymentKaspi(){
            let formData = new FormData();
            formData.append('order_id', order_id);
            formData.append('order_stamp', order_stamp);
            formData.append('city', City);
            formData.append('address', address);
            formData.append('deliveryType', deliver_type);
            formData.append('nameFamily', nameFamily);
            formData.append('telNum', telNum);
            formData.append('paymentType', paymentType);
            formData.append('paymentInfo', paymentInfo);
            
            let res = await fetch('<? echo $SiteUrl ?>order/query?type=kaspi', {
                method: 'POST',
                body: formData
            });
            const data = await res.json();
            
            var content_block = document.getElementById('stepcontent4');
            
            if(data.status === true){
                content_block.innerHTML = '';
                content_block.innerHTML = `
                    <h3>Спасибо за покупку</h3><br>
                <div style="border-top: 1px solid #eee;"></div><br>
                
                <div class="row-start pos-center"><img src="../icons/done.svg" width="100" style="margin-right: 20px;"><h1>Успешно</h1></div><br>
                
                <div style="border-top: 1px solid #eee;"></div><br>
                
                <p>${data['orderStatusForUser']}</p><br><br>
                
                <p><strong>Статус заказа: </strong></p><br>
                <div style="border-top: 1px solid #eee;"></div><br>
                
                <p>Заказ №${data['orderStamp']}</p>
                
                <p>${data['orderStatus']}</p><br>
                <div style="border-top: 1px solid #eee;"></div><br>
                <a href="<? echo $SiteUrl ?>order/status" style="text-decoration: underline">Страница проверки статуса заказа</a><br><br>
                `;
            } else if(data.status === false){
                content_block.innerHTML = '';
                content_block.innerHTML = `
                    <h3>Упс...</h3><br>
                <div style="border-top: 1px solid #eee;"></div><br>
                
                <div class="row-start pos-center"><img src="../icons/attention.svg" width="100" style="margin-right: 20px;"><h1>Ошибка</h1></div><br>
                
                <div style="border-top: 1px solid #eee;"></div><br>
                
                <p>${data['notification']}</p><br><br>
                
                <div style="border-top: 1px solid #eee;"></div><br>
                <a href="<? echo $SiteUrl ?>service/feedback" style="text-decoration: underline">Обратная связь</a><br><br>
                `;
            }
            
        }
        
        

        function setStepStatus(o) {
            document.getElementById('stepcontent0').style.display = "none";
            document.getElementById('stepcontent1').style.display = "none";
            document.getElementById('stepcontent2').style.display = "none";
            document.getElementById('stepcontent3').style.display = "none";
            document.getElementById('stepcontent4').style.display = "none";
            for (let i = 0; i <= o; i++) {
                document.getElementById('step' + i).style.backgroundColor = "#278458";
                if (i != 3) {
                    document.getElementById('rect' + i).style.backgroundColor = "#278458";
                }
            }
            if(o != 4){
                document.getElementById('stepcontent'+(o+1)).style.display = "block";
            }
        }
        
        function setStepStatusBack(o) {
            document.getElementById('stepcontent0').style.display = "none";
            document.getElementById('stepcontent1').style.display = "none";
            document.getElementById('stepcontent2').style.display = "none";
            document.getElementById('stepcontent3').style.display = "none";
            document.getElementById('stepcontent4').style.display = "none";
            document.getElementById('stepcontent'+o).style.display = "block";
        }

        async function getDeliveryCost(city) {
            let formData = new FormData();
            formData.append('order_id', order_id);
            formData.append('order_stamp', order_stamp);
            formData.append('city', city);
            formData.append('deliveryType', deliver_type);
            
            
            let res = await fetch('<? echo $SiteUrl ?>order/query?type=delivery', {
                method: 'POST',
                body: formData
            });
            
            const data = await res.json();
            
            if(data.status === true){
                deliverCost = Number(data['deliverCost']);
                orderCost = Number(data['orderCost']);
                City = data['city'];
                deliver_type = data['deliverType'];
                deliverPeriod = data['deliverPeriod'];
            }
            
            document.getElementById('del-price').innerHTML = deliverCost;
            document.querySelector('.order-info').style.display = "block";
            
        }
        
        
        async function getOrderInfo(){
            if(steps0 == 0){
                let res = await fetch('<? echo $SiteUrl ?>order/query?type=order&order_id='+order_id+'&order_stamp='+order_stamp);
                let products = await res.json();
                let d = document.querySelector('.order-list-conf');
                d.innerHTML = '';
                for(let product of products){
                    d.innerHTML += `<div class="order-list-el row-between pos-center">
                    
                        <img src="<? echo $SiteUrl ?>${product['MAIN-IMAGE']}" width="56">
                        <div class="column">
                            <h4 style="width: 200px; overflow: hidden">${product['PRODUCT-NAME']}</h4>
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
                    <div></div>
                    <div class="row pos-center"><p style="margin-right: 10px;">Сумма товаров: </p><h4>${orderCost}₸</h4></div>
                `;
                
                steps0++;
            }
            document.querySelector('.order-list-del').innerHTML = `
                <div class="row pos-center"><p style="margin-right: 10px;">Срок доставки: </p><h4>${deliverPeriod} Дней</h4></div>
                <div class="row pos-center"><p style="margin-right: 10px;">Доставка: </p><h4>${deliverCost}₸</h4></div>
            `;
            //console.log(products);
            
        }
        

        
        function telselect() {
            let i = document.getElementById('telnumber-order');
            if (i.value == '') {
                i.value = 8;
            }
        }

        function onlyNumberKey(evt) {
            var ASCIICode = (evt.which) ? evt.which : evt.keyCode
            if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57)) return false;
            return true;
        }

        function clearifempty() {
            let i = document.getElementById('telnumber-order');
            if (i.value == 8) {
                i.value = '';
            }
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

    <!--                 Main Content               -->
    <div class="eigh-main-content">


        <div class="order-page-container">

            <h2 style="margin-bottom: 25px;">Оформление заказа №
                <? echo $order ?>
            </h2>

            <div class="progress-bar">

                <div class="step-dot" id="step0" style="background-image: url(../icons/fast-del-truck.svg); background-size: 20px;"></div>
                <div class="step-rect" id="rect0"></div>
                <div class="step-dot" id="step1" style="background-image: url(../icons/confirmation-del.svg); background-size: 20px;"></div>
                <div class="step-rect" id="rect1"></div>
                <div class="step-dot" id="step2" style="background-image: url(../icons/credit-card.svg); background-size: 20px;"></div>
                <div class="step-rect" id="rect2"></div>
                <div class="step-dot" id="step3" style="background-image: url(../icons/checked.svg); background-size: 18px;"></div>

            </div>


            <div class="order-page-content" id="stepcontent0" style="display: block">

                <h3>Доставка</h3><br>
                <div style="border-top: 1px solid #eee;"></div><br>


                <div class="payment-method">
                    
                    <label for="delivery" class="method paypal">
                        <img src="../icons/delivery-man.svg" width="64">
                        <div class="radio-input">
                            <input id="delivery" type="radio" name="delivery">
                            Доставка 
                        </div>
                    </label>
                    
                    <label for="kazpost" class="method card">
                        <div class="card-logos">
                            <img src="../icons/kazpost.svg" width="200">
                        </div>
                        <div class="radio-input">
                            <input id="kazpost" type="radio" name="delivery">
                            Казпочта
                        </div>
                    </label>

                    
                    <label for="pickup" class="method paypal">
                        <img src="../icons/pickup.svg" width="64">
                        <div class="radio-input">
                            <input id="pickup" type="radio" name="delivery" disabled>
                            Самовывоз (Не доступно)
                        </div>
                    </label>
                    
                    <label for="transport-co" class="method paypal">
                        <img src="../icons/delivery.svg" width="64">
                        <div class="radio-input">
                            <input id="transport-co" type="radio" name="delivery" disabled>
                            Транспортные компании (Не доступно)
                        </div>
                    </label>
                </div>

                <div class="row-between">
                    <div class="select">
                        <select name="city" id="city" disabled>
                            <option selected disabled id="city_default">Ваш город</option>
                            <option value="Алматы" id="almaty" name="e-city">Алматы</option>
                            <option value="Астана" id="astana" name="e-city">Астана</option>
                            <option value="Караганды" id="karagandy" name="e-city">Караганды</option>
                        </select>
                    </div>

                    <div class="column-around pos-center">
                        <div class="delivery-price row-around pos-center">
                            <p style="margin: 0 10px">Стоимость доставки: </p>
                            <h2><span id="del-price">0</span>₸</h2>
                        </div>
                        
                        <div><h5>Бесплатно от 10000₸</h5></div>
                    </div>
                </div>

                <br>

                
                <div class="order-info" style="display: none">
                    <input class="order-page-input-1" type="text" placeholder="Адрес" id="address-order" value="" required><br><br>
                    <input class="order-page-input-1" type="text" placeholder="Имя Фамилия" id="fio-order" value="<?php if($_SESSION['name'] != '' and $_SESSION['surname'] != ''){echo $_SESSION['name'].' '.$_SESSION['surname'];} ?>" required><br><br>
                    <input type="tel" placeholder="Номер телефона" class="order-page-input-1" style="width: 50%" id="telnumber-order" onclick="telselect()" onfocusout="clearifempty()" pattern="^\+?87([0124567][0-8]\d{7})$" onkeypress="return onlyNumberKey(event)" value="<? echo $_SESSION['phone'] ?>" maxlength="11" required><br><br>
                </div>


            </div>
            
            <div class="order-page-content" id="stepcontent1" style="display: none">
            
                <h3>Подтверждение</h3><br>
                <div style="border-top: 1px solid #eee;"></div><br>
                
                <div class="order-list-conf column pos-center">
                
                    
                
                </div><br>
                
                <div class="order-list-lp row-between pos-center">
                
                
                
                </div><br>
                
                <div class="order-list-del row-between pos-center">
                
                
                
                </div><br>
                <label for="confirmation">
                <div class="order-list-confirmation row pos-center">
                
                    <input type="checkbox" name="confirmation" id="confirmation"><h5 style="margin-left: 10px">Покупая товар в магазине я подтверждаю что прочитал чек и количество заказуемых товаров а так же даю согласие на обработку персональных данных</h5>
                    
                </div>
                </label>
            
            </div>
            
            <div class="order-page-content" id="stepcontent2" style="display: none; padding: 25px 30px 0px;">
            
                <h3>Оплата</h3><br>
                <div style="border-top: 1px solid #eee;"></div><br><br>
                
                <h5>Выберите способ оплаты: </h5><br><br>
                <div class="payment-method" style="margin-bottom: 20px;">
                    
                    <label for="cardpay" class="method card">
                        <div class="card-logos">
                            <img src="../icons/mastercard.svg" width="85">
                            <img src="../icons/visa.svg" width="85">
                        </div>
                        <div class="radio-input">
                            <input id="cardpay" type="radio" name="payment" disabled>
                            Банковская карта (Не доступно)
                        </div>
                    </label>
                    
                    <label for="kaspi" class="method kaspi">
                        <div class="card-logos">
                            <img src="../icons/kaspi.svg" width="150">
                        </div>
                        <div class="radio-input">
                            <input id="kaspi" type="radio" name="payment">
                            Kaspi Pay, Kaspi Red
                        </div>
                    </label>
                    
                </div>
                
                <div class="payment-content" style="display: none">
                
                    
                    
                </div><br><br>
            
            </div>
            
            <div class="order-page-content" id="stepcontent3" style="display: none">
                
                <h3>Подтверждение</h3><br>
                <div style="border-top: 1px solid #eee;"></div><br>
                
                
                <h5>Данные доставки: </h5><br>
                
                <div class="order-list-conf column pos-center" id="del-conf">
                
                
                    
                </div><br>
                
                <div style="border-top: 1px solid #eee;"></div><br>
                
                <h5>Данные оплаты: </h5><br>
            
                <div class="order-list-conf column pos-center" id="pay-conf">
                
                    
                
                </div><br>
                
            </div>
            
            
            <div class="order-page-content" id="stepcontent4" style="display: none">
                

                <h3>Загрузка</h3><br>
                <div style="border-top: 1px solid #eee;"></div><br>
                
                <p>Формирование заказа</p><br><br><br>

                
            </div>
            
                
            
            <br><br><div class="progress-bar row-around pos-center">
                <button type="button" id="step-back" onclick="step_back()">Назад</button>
                <button type="button" id="step-next" onclick="step_next()">Дальше</button>
            </div>

        </div>


    </div>
    <!--                 Main Content               -->

    <!--   Bottom   -->
    <?php
            printBottom('../');
        ?>
    <!--   Bottom   -->

    <script>
        document.getElementById('city').addEventListener("change", function() {
            var e = document.getElementById('city');
            var city = e.value;
            getDeliveryCost(city);
        });
        var kazpost = document.getElementById('kazpost');
        kazpost.addEventListener("click", function() {
            deliver_type = 'Казпочта';
            delName = 'kazpost';
            document.getElementById('city_default').selected = "selected";
            var cities = document.getElementsByName('e-city');
            for(var city of cities){
                city.disabled = false;
            }
            document.getElementById('almaty').disabled = true;
            
            document.getElementById('city').disabled = false;
        });
        
        var delivery = document.getElementById('delivery');
        delivery.addEventListener("click", function() { 
            deliver_type = 'Доставка';
            delName = 'delivery-man';
            document.getElementById('city_default').selected = "selected";
            document.getElementById('city').disabled = false;
            var cities = document.getElementsByName('e-city');
            for(var city of cities){
                city.disabled = true;
            }
            document.getElementById('almaty').disabled = false;
        });
        
        var card = document.getElementById('cardpay');
        card.addEventListener("click", function() {
            let block = document.querySelector('.payment-content');
            block.style.display = "block";
            block.innerHTML = '';
            block.innerHTML = `<h5>Данные об оплате</h5><br>
                    <div style="border-top: 1px solid #eee;"></div><br>
                    
                    <div class="input-fields-card">
                        <div class="cardds-1">
                            <label for="cardholder-card">Владелец карты</label>
                            <input type="text" id="cardholder-card">
 
                            <div class="small-inputs">
                                <div>
                                    <label for="date-card">Срок карты</label>
                                    <input type="text" id="date-card" placeholder="ММ / ГГ" >
                                </div>
    
                                <div>
                                    <label for="verification-card">CVV / CVC *</label>
                                    <input type="password" id="verification-card">
                                </div>
                            </div><br>
 
                        </div>
                        <div class="cardds-2">
                            <label for="cardnumber-card">Номер карты (без пробелов)</label>
                            <input type="text" id="cardnumber-card">
 
                            <span class="info">* CVV или CVC - это код безопасности карты, уникальный трехзначный номер на обратной стороне вашей карты, отдельный от его номера.</span>
                        </div>
                    </div>`;
        });
        
        var kaspi = document.getElementById('kaspi');
        kaspi.addEventListener("click", function() {
            let block = document.querySelector('.payment-content');
            paymentType = 'Kaspi.kz';
            payName = 'kaspi';
            block.style.display = "block";
            block.innerHTML = '';
            block.innerHTML = `<h5>Данные об оплате</h5><br>
                <div style="border-top: 1px solid #eee;"></div><br>
                    
                    <h5 style="color: green" id="payid001">В течение часа <span style="color: black">(C 09:00 До 21:00)</span> на ваш <span style="color: red">Kaspi</span> будет отправлен счет для оплаты от <span style="color: black">ТОО "DDS-CORPORATION"</span> (Приложение Kaspi.kz)<br>Оплату можно произвести любым способом (Kaspi Red, Kaspi Gold, Kaspi Kredit)</h5><br>
                    
                    <input type="tel" placeholder="Kaspi номер 87xxxxxxxxx" class="order-page-input-1" style="width: 50%" id="payid002" onclick="telselect()" onfocusout="clearifempty()"  onkeypress="return onlyNumberKey(event)" value="" maxlength="11" required><br><br>`;
        });
        
        
    </script>
</body>

</html>
