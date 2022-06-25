<?php
    session_start(); 
    require_once 'Core/connect.php';
    include 'Template/Header.php';
    require_once 'Core/checkAuthPassive.php';

    $popular_products = mysqli_query($connect, "SELECT * FROM `products`,`popular` WHERE `products`.`ID` = `popular`.`product_id` ORDER BY `products`.`COUNT` DESC LIMIT 8");
    $popularList = [];
    while($popular = mysqli_fetch_assoc($popular_products)){
        $popularList[] = $popular;
    }
    
?>

<!-- web -->
<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="utf-8">
        <meta name="viewport" content="width=806">
		<title>Интернет магазин электротоваров - EIGHSTORE</title>
        <link rel="shortcut icon" href="/icons/favicon.svg" type="image/x-icon">
		<link href="style.css<? echo $style ?>" rel="stylesheet">
        <link href="flex.css<? echo $flex ?>" rel="stylesheet">
        <script src="header.js<? echo $script ?>"></script>
        
		<!--  LIB: SimpleSlide  -->
        <link rel="stylesheet" href="lib/SimpleSlider/simple-adaptive-slider.min.css">
        <script defer src="lib/SimpleSlider/simple-adaptive-slider.dev.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
            // инициализация слайдера
            var slider = new SimpleAdaptiveSlider('.slider', {
            loop: true,
            autoplay: false,
            interval: 2000,
            swipe: true,
            }); 
            var slider_top = new SimpleAdaptiveSlider('.slider-popular', {
                loop: true,
                autoplay: false,
                interval: 2000,
                swipe: true,
            });
            var slider_top_2 = new SimpleAdaptiveSlider('.slider-popular-mobile', {
                loop: true,
                autoplay: false,
                interval: 2000,
                swipe: true,
            });
        });
        </script>
        <!--  LIB: SimpleSlide  -->
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
        
            <!--   Under Top Category   -->
            <div class="category_el_parent container">
            
                <a href="#"><div class="category_el_child column pos-center"><img src="imgs/lamp.png" id="category_el_img"><p>Лампы</p></div></a>
                <a href="#"><div class="category_el_child column pos-center"><img src="imgs/projector.png" id="category_el_img"><p>Прожектора</p></div></a>
                <a href="#"><div class="category_el_child column pos-center"><img src="imgs/ledpanel.png" id="category_el_img"><p>Панели</p></div></a>
                <a href="#"><div class="category_el_child column pos-center"><img src="imgs/rozetka.png" id="category_el_img"><p>Розетки</p></div></a>
                <a href="#"><div class="category_el_child column pos-center"><img src="imgs/svetilnik.png" id="category_el_img"><p>Светильники</p></div></a>
                <a href="#"><div class="category_el_child column pos-center"><img src="imgs/vyklyiuchatel.png" id="category_el_img"><p>Выключатели</p></div></a>
                <a href="#"><div class="category_el_child column pos-center"><img src="imgs/viewall.png" id="category_el_img"><p>Посмотреть все</p></div></a>
            
            </div>
            <!--   Under Top Category   -->
            
            <!--   Slider   -->
            <div class="main-menu-slider" id="main-menu-slider">
                
                <div class="slider">
                    <div class="slider__wrapper">
                        <div class="slider__items">
                            <div class="slider__item">
                                <div class="element_of_slide row-around" style="background-image: url(imgs/slide-imgs/svg1.svg); background-color: #f7f7f7">
                                
                                    <div class="slider_description column-around pos-center">
                                    
                                        <h2>Открытие интернет-магазина</h2>
                                        <div class="column">
                                            <h2>Скидки до 90%</h2><br>
                                            <h4>Акция действует в течение недели<br>Ознакомьтесь с условиями акции ниже</h4>
                                        </div>
                                        
                                        <button id="button-mid" type="submit">Читать условия</button>
                                    
                                    </div>
                                    <div class="slider_image"><div id="id023"><p>EIGH<span id="span-img"><img width="22" src="../icons/bio-energy.svg"></span><span>STORE</span></p></div></div>
                                    
                                </div>
                            </div>
                            <div class="slider__item">
                                <div class="element_of_slide row-around" style="background: #f7f7f7;">
                                
                                    <div class="slider_description column-around pos-center">
                                    
                                        <h1>ЛЮМИНЕСЦЕНТНЫЕ ЛАМПЫ</h1>
                                        <button id="button-mid" type="submit">Перейти к товару</button>
                                    
                                    </div>
                                    <div class="slider_image"><img class="slide_box_img" src="imgs/slide-imgs/sl1.png" loading="lazy"></div>
                                    
                                </div>
                            </div>
                            <div class="slider__item">
                                <div class="element_of_slide row-around" style="background: #f7f7f7;">
                                
                                    <div class="slider_description column-around pos-center">
                                    
                                        <h1>ЛЮМИНЕСЦЕНТНЫЕ ЛАМПЫ</h1>
                                        <button id="button-mid" type="submit">Перейти к товару</button>
                                    
                                    </div>
                                    <div class="slider_image"><img class="slide_box_img" src="imgs/slide-imgs/sl1.png" ></div>
                                    
                                </div>
                            </div>
                            <div class="slider__item">
                                <div class="element_of_slide row-around" style="background: #f7f7f7;">
                                
                                    <div class="slider_description column-around pos-center">
                                    
                                        <h1>ЛЮМИНЕСЦЕНТНЫЕ ЛАМПЫ</h1>
                                        <button id="button-mid" type="submit">Перейти к товару</button>
                                    
                                    </div>
                                    <div class="slider_image"><img class="slide_box_img" src="imgs/slide-imgs/sl1.png" loading="lazy"></div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <a class="slider__control slider__control_prev" href="#" role="button" data-slide="prev"></a>
                    <a class="slider__control slider__control_next" href="#" role="button" data-slide="next"></a>
                </div>
            
            </div>
            <!--   Slider   -->
            
            <!--   Popular items   -->
            
            
            <div class="main-menu-popular container column">
            
                <div class="pre__desc row-between pos-center">
                
                    <div class="row-between pos-center"><h2>Популярные</h2></div>
                    <div><a href="catalog.php?query=popular">Посмотреть все</a></div>
                
                </div>
                
                <div class="popular-items-parent">
                
                  
                <div class="slider-popular" id="slider-popular">
                    
                        <div class="slider__wrapper slider__wrapper-popular" style="background-color: white;">
                            
                            <div class="slider__items">
                                
                                
                                <div class="slider__item">
                                    <div class="popular-items row">
                                        
                                        <?php
                                        for($i = 0; $i < 4; $i++){
                                        ?>
                                
                                        <div class="popular-item column">
                                        <input type="hidden" value="<? echo $popularList[$i]['ID'] ?>" id="prod-id-<? echo $popularList[$i]['ID'] ?>">
                                            <img src="<? echo $popularList[$i]['MAIN-IMAGE'] ?>" class="product-card"> 
                                            <div class="product-card-info column-between">
                                            
                                                <h3><a href="product.php?product=<? echo $popularList[$i]['ID'] ?>"><? echo $popularList[$i]['PRODUCT-NAME']; ?></a></h3>
                                                <p>ЭРА ECO LED Р45-10W-840-E27</p>
                                                <div class="product-card-func row-between">
                                            
                                                    <h3 class="product-card-cost"><? echo $popularList[$i]['PRICE'] ?>₸</h3>
                                                    <?php   
                                                        if($popularList[$i]['COUNT'] > 0){
                                                        echo "<a><h3 style=\"color: #278458; cursor: pointer\" id=\"prod-{$popularList[$i]['ID']}\" onclick=\"addInBasket({$popularList[$i]['ID']}, '{$popularList[$i]['PRODUCT-NAME']}', 1, '{$popularList[$i]['PRICE']}', '{$popularList[$i]['MAIN-IMAGE']}')\">Купить</h3></a>";
                                                        } else {
                                                            echo '<a><h3 style="color: red">Нет в наличии</h3></a>';
                                                        }
                                                    ?>
                                                </div>
                                            
                                            </div>
                                            
                                        </div>
                                        
                                        <?php
                                        }
                                            ?>
                                    
                                    </div>
                                </div>
                                <div class="slider__item">
                                    <div class="popular-items row">
            
                                       <?php
                                        for($i = 4; $i < 8; $i++){
                                        ?>
                                
                                        <div class="popular-item column">
                                        <input type="hidden" value="<? echo $popularList[$i]['ID'] ?>" id="prod-id-<? echo $popularList[$i]['ID'] ?>">
                                            <img src="<? echo $popularList[$i]['MAIN-IMAGE'] ?>" class="product-card"> 
                                            <div class="product-card-info column-between">
                                            
                                                <h3><a href="product.php?product=<? echo $popularList[$i]['ID'] ?>"><? echo $popularList[$i]['PRODUCT-NAME']; ?></a></h3>
                                                <p>ЭРА ECO LED Р45-10W-840-E27</p>
                                                <div class="product-card-func row-between">
                                            
                                                    <h3 class="product-card-cost"><? echo $popularList[$i]['PRICE'] ?>₸</h3>
                                                    <?php   
                                                        if($popularList[$i]['COUNT'] > 0){
                                                        echo "<a><h3 style=\"color: #278458; cursor: pointer\" id=\"prod-{$popularList[$i]['ID']}\" onclick=\"addInBasket({$popularList[$i]['ID']}, '{$popularList[$i]['PRODUCT-NAME']}', 1, '{$popularList[$i]['PRICE']}', '{$popularList[$i]['MAIN-IMAGE']}')\">Купить</h3></a>";
                                                        } else {
                                                            echo '<a><h3 style="color: red">Нет в наличии</h3></a>';
                                                        }
                                                    ?>
                                                </div>
                                            
                                            </div>
                                            
                                        </div>
                                        
                                        <?php
                                        }
                                            ?>
                                        
                                        
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                </div>
                    
                    <!--   Mobile Popular   -->
                    <div class="slider-popular-mobile" id="slider-popular-mobile">
                    
                        <div class="slider__wrapper slider__wrapper-popular" style="background-color: white;">
                            <div class="slider__items">
                                <div class="slider__item">
                                    <div class="popular-items row-center">
                                
                                        
                                        <?php
                                        for($i = 0; $i < 2; $i++){
                                        ?>
                                
                                        <div class="popular-item column">
                                        <input type="hidden" value="<? echo $popularList[$i]['ID'] ?>" id="prod-id-<? echo $popularList[$i]['ID'] ?>">
                                            <img src="<? echo $popularList[$i]['MAIN-IMAGE'] ?>" class="product-card"> 
                                            <div class="product-card-info column-between">
                                            
                                                <h3><a href="product.php?product=<? echo $popularList[$i]['ID'] ?>"><? echo $popularList[$i]['PRODUCT-NAME']; ?></a></h3>
                                                <p>ЭРА ECO LED Р45-10W-840-E27</p>
                                                <div class="product-card-func row-between">
                                            
                                                    <h3 class="product-card-cost"><? echo $popularList[$i]['PRICE'] ?>₸</h3>
                                                    <?php   
                                                        if($popularList[$i]['COUNT'] > 0){
                                                        echo "<a><h3 style=\"color: #278458; cursor: pointer\" id=\"prod-i{$popularList[$i]['ID']}\" onclick=\"addInBasket({$popularList[$i]['ID']}, '{$popularList[$i]['PRODUCT-NAME']}', 1, '{$popularList[$i]['PRICE']}', '{$popularList[$i]['MAIN-IMAGE']}')\">Купить</h3></a>";
                                                        } else {
                                                            echo '<a><h3 style="color: red">Нет в наличии</h3></a>';
                                                        }
                                                    ?>
                                                </div>
                                            
                                            </div>
                                            
                                        </div>
                                        
                                        <?php
                                        }
                                            ?>
                                        
                                    </div>
                                </div>
                                <div class="slider__item">
                                    <div class="popular-items row-center">
            
                                        <?php
                                        for($i = 2; $i < 4; $i++){
                                        ?>
                                
                                        <div class="popular-item column">
                                        <input type="hidden" value="<? echo $popularList[$i]['ID'] ?>" id="prod-id-<? echo $popularList[$i]['ID'] ?>">
                                            <img src="<? echo $popularList[$i]['MAIN-IMAGE'] ?>" class="product-card"> 
                                            <div class="product-card-info column-between">
                                            
                                                <h3><a href="product.php?product=<? echo $popularList[$i]['ID'] ?>"><? echo $popularList[$i]['PRODUCT-NAME']; ?></a></h3>
                                                <p>ЭРА ECO LED Р45-10W-840-E27</p>
                                                <div class="product-card-func row-between">
                                            
                                                    <h3 class="product-card-cost"><? echo $popularList[$i]['PRICE'] ?>₸</h3>
                                                    <?php   
                                                        if($popularList[$i]['COUNT'] > 0){
                                                        echo "<a><h3 style=\"color: #278458; cursor: pointer\" id=\"prod-i{$popularList[$i]['ID']}\" onclick=\"addInBasket({$popularList[$i]['ID']}, '{$popularList[$i]['PRODUCT-NAME']}', 1, '{$popularList[$i]['PRICE']}', '{$popularList[$i]['MAIN-IMAGE']}')\">Купить</h3></a>";
                                                        } else {
                                                            echo '<a><h3 style="color: red">Нет в наличии</h3></a>';
                                                        }
                                                    ?>
                                                </div>
                                            
                                            </div>
                                            
                                        </div>
                                        
                                        <?php
                                        }
                                            ?>
                                        
                                        
                                    </div>
                                </div>
                                <div class="slider__item">
                                    <div class="popular-items row-center">
            
                                        <?php
                                        for($i = 4; $i < 6; $i++){
                                        ?>
                                
                                        <div class="popular-item column">
                                        <input type="hidden" value="<? echo $popularList[$i]['ID'] ?>" id="prod-id-<? echo $popularList[$i]['ID'] ?>">
                                            <img src="<? echo $popularList[$i]['MAIN-IMAGE'] ?>" class="product-card"> 
                                            <div class="product-card-info column-between">
                                            
                                                <h3><a href="product.php?product=<? echo $popularList[$i]['ID'] ?>"><? echo $popularList[$i]['PRODUCT-NAME']; ?></a></h3>
                                                <p>ЭРА ECO LED Р45-10W-840-E27</p>
                                                <div class="product-card-func row-between">
                                            
                                                    <h3 class="product-card-cost"><? echo $popularList[$i]['PRICE'] ?>₸</h3>
                                                    <?php   
                                                        if($popularList[$i]['COUNT'] > 0){
                                                        echo "<a><h3 style=\"color: #278458; cursor: pointer\" id=\"prod-i{$popularList[$i]['ID']}\" onclick=\"addInBasket({$popularList[$i]['ID']}, '{$popularList[$i]['PRODUCT-NAME']}', 1, '{$popularList[$i]['PRICE']}', '{$popularList[$i]['MAIN-IMAGE']}')\">Купить</h3></a>";
                                                        } else {
                                                            echo '<a><h3 style="color: red">Нет в наличии</h3></a>';
                                                        }
                                                    ?>
                                                </div>
                                            
                                            </div>
                                            
                                        </div>
                                        
                                        <?php
                                        }
                                            ?>
                                        
                                        
                                    </div>
                                </div>
                                <div class="slider__item">
                                    <div class="popular-items row-center">
            
                                        <?php
                                        for($i = 6; $i < 8; $i++){
                                        ?>
                                
                                        <div class="popular-item column">
                                        <input type="hidden" value="<? echo $popularList[$i]['ID'] ?>" id="prod-id-<? echo $popularList[$i]['ID'] ?>">
                                            <img src="<? echo $popularList[$i]['MAIN-IMAGE'] ?>" class="product-card"> 
                                            <div class="product-card-info column-between">
                                            
                                                <h3><a href="product.php?product=<? echo $popularList[$i]['ID'] ?>"><? echo $popularList[$i]['PRODUCT-NAME']; ?></a></h3>
                                                <p>ЭРА ECO LED Р45-10W-840-E27</p>
                                                <div class="product-card-func row-between">
                                            
                                                    <h3 class="product-card-cost"><? echo $popularList[$i]['PRICE'] ?>₸</h3>
                                                    <?php   
                                                        if($popularList[$i]['COUNT'] > 0){
                                                        echo "<a><h3 style=\"color: #278458; cursor: pointer\" id=\"prod-i{$popularList[$i]['ID']}\" onclick=\"addInBasket({$popularList[$i]['ID']}, '{$popularList[$i]['PRODUCT-NAME']}', 1, '{$popularList[$i]['PRICE']}', '{$popularList[$i]['MAIN-IMAGE']}')\">Купить</h3></a>";
                                                        } else {
                                                            echo '<a><h3 style="color: red">Нет в наличии</h3></a>';
                                                        }
                                                    ?>
                                                </div>
                                            
                                            </div>
                                            
                                        </div>
                                        
                                        <?php
                                        }
                                        ?>
                                        
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <!--   Mobile Popular   -->
                    
                </div>
                
                
            
            </div>
            
            <!--   Popular items   -->
            
            <!--   Addition Popular items   -->
            
            <div class="main-menu-popular container column">
            
            
                <div class="pre__desc row-between pos-center">
                
                    <div class="row-between pos-center"><h2>Выбирайте лучшее</h2></div>
                    <div><a>Посмотреть все</a></div>
                
                </div>
            
                <div class="popular-items-parent-2">
                
                    <div class="popular-items-2">
                                
                        <div class="popular-item-2 column">
                                        
                            <img src="imgs/lamp.png" class="product-card"> 
                            <div class="product-card-info column-between">
                                            
                                <h3>Лампа Светодиодная 10W</h3>
                                <p>ЭРА ECO LED Р45-10W-840-E27</p>
                                <div class="product-card-func row-between">
                                            
                                    <h3 class="product-card-cost">300₸</h3>
                                    <a><h3 style="color: #278458">Купить</h3></a>
                                                
                                </div>
                                            
                            </div>
                                            
                        </div>
                        
                        <div class="popular-item-2 column">
                                        
                            <img src="imgs/lamp.png" class="product-card"> 
                            <div class="product-card-info column-between">
                                            
                                <h3>Лампа Светодиодная 10W</h3>
                                <p>ЭРА ECO LED Р45-10W-840-E27</p>
                                <div class="product-card-func row-between">
                                            
                                    <h3 class="product-card-cost">300₸</h3>
                                    <a><h3 style="color: #278458">Купить</h3></a>
                                                
                                </div>
                                            
                            </div>
                                            
                        </div>
                        
                        <div class="popular-item-2 column">
                                        
                            <img src="imgs/lamp.png" class="product-card"> 
                            <div class="product-card-info column-between">
                                            
                                <h3>Лампа Светодиодная 10W</h3>
                                <p>ЭРА ECO LED Р45-10W-840-E27</p>
                                <div class="product-card-func row-between">
                                            
                                    <h3 class="product-card-cost">300₸</h3>
                                    <a><h3 style="color: #278458">Купить</h3></a>
                                                
                                </div>
                                            
                            </div>
                                            
                        </div>
                        
                        <div class="popular-item-2 column">
                                        
                            <img src="imgs/lamp.png" class="product-card"> 
                            <div class="product-card-info column-between">
                                            
                                <h3>Лампа Светодиодная 10W</h3>
                                <p>ЭРА ECO LED Р45-10W-840-E27</p>
                                <div class="product-card-func row-between">
                                            
                                    <h3 class="product-card-cost">300₸</h3>
                                    <a><h3 style="color: #278458">Купить</h3></a>
                                                
                                </div>
                                            
                            </div>
                                            
                        </div>
                                        
                                        
                                    
                    </div>
                
                </div>
            
            </div>
            
            <!--   Addition Popular items   -->
            
        </div>
<!--                 Main Content               -->           
        
        <!--   Bottom   -->
        <?php 
            printBottom('');
        ?>
        <!--   Bottom   -->
        <script>CheckEveryProductInBasket();</script>
	</body>
</html>

<!-- RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^(([A-Za-z0-9\-]+/)*[A-Za-z0-9\-]+)?$ $1.php
-->

<!--
RewriteEngine On
RewriteBase /
RewriteRule ^(.*)index\.php$ $1 [R=301,L]
-->
