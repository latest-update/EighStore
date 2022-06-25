<?php
session_start(); 
require_once 'Core/connect.php';
include 'Template/Header.php';
require_once 'Core/checkAuthPassive.php';
$product_id = $_GET['product'];
settype($product_id, 'integer');

$product = mysqli_query($connect, "SELECT * FROM `products`,`category` WHERE `products`.`ID` = '$product_id' AND `products`.`CATEGORY-ID` = `category`.`CATEGORY-ID`");
if(mysqli_num_rows($product) === 0){
    header('Location: /');
} else{
    $product = mysqli_fetch_assoc($product);
    $attributes = (array) json_decode($product['ATTRIBUTES']);
    $images = (array) json_decode($product['IMAGES']);
}



?>
<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="utf-8">
        <meta name="viewport" content="width=806">
		<title>EIGHSTORE - <? echo $product['PRODUCT-NAME'] ?></title>
        <link rel="shortcut icon" href="/icons/favicon.svg" type="image/x-icon">
		<link href="style.css<? echo $style ?>" rel="stylesheet">
        <link href="flex.css<? echo $flex ?>" rel="stylesheet">
        <script src="header.js<? echo $script ?>"></script>
        <link rel="stylesheet" href="lib/SimpleSlider/simple-adaptive-slider.min.css">
        <script defer src="lib/SimpleSlider/simple-adaptive-slider.dev.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
            // инициализация слайдера
            new SimpleAdaptiveSlider('.product-imgs', {
            loop: true,
            autoplay: false,
            swipe: true,
            }); 
        });
        </script>
        <style>
            .slider__indicators{
                position: inherit;
            }
            .slider__indicator_active {
                background-color: #278458!important;
            }
            .slider__indicator{
                background-color: black;
            }
        </style>
        
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
            
            <ul class="breadcrumb">
                    <li><a href="/">#eighstore</a></li>
                    <li><a href="catalog.php?query=catalog&name=<? echo $product['CATEGORY-NAME'] ?>&type=all"><? echo $product['CATEGORY-NAME'] ?></a></li>
                    <li><a href="catalog.php?query=catalog&name=<? echo $product['CATEGORY-NAME'].'&type='.$product['SUBCATEGORY-NAME'] ?>"><? echo $product['SUBCATEGORY-NAME'] ?></a></li>
                    <?php
                        if($product['SUBSUBCATEGORY-NAME'] != ''){
                            ?>
                            <li><a href="catalog.php?query=catalog&name=<? echo $product['CATEGORY-NAME'].'&type='.$product['SUBCATEGORY-NAME'].'&subtype='.$product['SUBSUBCATEGORY-NAME'] ?>"><? echo $product['SUBCATEGORY-NAME'] ?></a></li>
                            <?php
                        } 
                    ?>
                    <li><? echo $product['PRODUCT-NAME'] ?></li>
            </ul>
            
            <div class="eigh-product-page container">
                
            
                <div class="product-page-main row-around pos-center">
                
                    <div class="product-page-img-box">
                    
                        <div class="product-imgs">
                            <div class="slider__wrapper">
                                <div class="slider__items">
                                    
                                    <?php
                                        foreach($images as $image){
                                            echo '<div class="slider__item row-center pos-center" style="background-color: white">
                                                    <img src="'.$image.'" class="product-page-img">
                                                  </div>';
                                        }
                                    ?>
                                    
                                </div>
                            </div>
                        </div>
                    
                    </div>
                    
                    <div class="product-page-buy-info column-around pos-start">
                    
                        <h2><? echo $product['PRODUCT-NAME'] ?></h2>
                        <h3>LED 5500K 220-240 Вт</h3>
                        <h3><span style="color: gray"><? echo $product['PRICE'] ?>₸</span>
                            <?php 
                                if($product['COUNT'] > 0){
                                    echo ' * В наличии';
                                } else {
                                    echo ' * Нет в наличии';
                                }
                            ?>
                        </h3>  
                        <div class="row">
                        
                            <div class="buy-info-star row-center pos-center">
                                <img src="icons/asterisk.svg" width="24" class="info-star-img">
                            </div>
                            <?php 
                                if($product['COUNT'] > 0){
                                    echo "<button class=\"button-mid-buy\" id='buy-clicked' onclick=\"addInBasket(${product['ID']}, '${product['PRODUCT-NAME']}', 1, '${product['PRICE']}', '${product['MAIN-IMAGE']}')\">Купить</button>";
                                } else {
                                    //echo '<button class="button-mid-buy" style="width: 230px">В лист ожидания</button>';
                                }
                            ?>
                            
                        
                        </div>
                    
                    </div>
                
                </div>
                
                
                
                <div class="product-page-desc-comment row-between">
                
                    <div class="product-page-desc">
                    
                        <div class="page-desc-subject">
                
                            <h3 class="desc-subject-h3">Oписание</h3>
                            <p class="desc-subject-full-desc" id="id110" style="height: 80px;"><? echo $product['DESCRIPTION'] ?></p>
                            <a onclick="desc_text_hidden_visiblity()" class="show-all row-center" id="id111">- Показать полностью -</a>
                            
                            <table>
                            
                            
                            
                                <tr>
                                
                                    <td>Производитель</td>
                                    <td><? echo $product['MANUFACTURER'] ?></td>
                                
                                </tr>
                                <tr>
                                
                                    <td>Бренд</td>
                                    <td><? echo $product['BRAND'] ?></td>
                                
                                </tr>
                                
                                <?php
                                    foreach($attributes as $value=>$attribute){
                                        echo '<tr>
                                
                                                <td>'.$value.'</td>
                                                <td>'.$attribute.'</td>
                                
                                        </tr>';
                                    }
                                ?>
                                
                                
                                
                            
                            </table>
                
                        </div>
                        
                    </div>
                    <div class="product-page-comment">
                    
                        <div class="page-desc-subject">
                
                            <h3 class="desc-subject-h3">Oтзывы</h3>
                            
                            <div class="comments column">
                            
                                <div class="comment">
                                
                                    <div class="comment-user row-between pos-center">
                                    
                                        <div class="user-img-name row">
                                        
                                            <img src="icons/user-ph.jpg" class="comment-user-img">
                                            <div class="user-info column-between">
                                            
                                                <p>Рахат Бакытжанов</p>
                                                <p>#2040</p>
                                            
                                            </div>
                                        
                                        </div>
                                        
                                        <div class="comment-date">
                                            
                                            <p>21 Апрель 2021</p>
                                        
                                        </div>
                                    
                                    </div>
                                    
                                    <div class="comment-user-word">
                                    
                                        <p>asdadada sadas dasd asd asd a dads dad sa da da das dasd ad asdasdasdad asdasd sa das das das dasd asd asd asdas d</p>
                                    
                                    </div>
                                
                                </div>
                                
                                <div class="comment">
                                
                                    <div class="comment-user row-between pos-center">
                                    
                                        <div class="user-img-name row">
                                        
                                            <img src="icons/user-ph.jpg" class="comment-user-img">
                                            <div class="user-info column-between">
                                            
                                                <p>Рахат Бакытжанов</p>
                                                <p>#2040</p>
                                            
                                            </div>
                                        
                                        </div>
                                        
                                        <div class="comment-date">
                                            
                                            <p>21 Апрель 2021</p>
                                        
                                        </div>
                                    
                                    </div>
                                    
                                    <div class="comment-user-word">
                                    
                                        <p>asdadada sadas dasd asd asd a dads dad sa da da das dasd ad asdasdasdad asdasd sa das das das dasd asd asd asdas d</p>
                                    
                                    </div>
                                
                                </div>
                            
                            </div>
                
                        </div>
                    
                    </div>
                
                </div>
            
            
            </div>
            
        </div>
<!--                 Main Content               -->           
        
        <!--   Bottom   -->
        <?php
            printBottom('');
        ?>
        <!--   Bottom   -->
        <script>
        checkInBasket(<? echo $product['ID'] ?>);
        </script>
	</body>
</html>