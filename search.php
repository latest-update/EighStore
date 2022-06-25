<?php

require_once 'Core/connect.php';
include 'Template/Header.php';
$searchData = $_POST['searchData'];
$productList = [];

$products = mysqli_query($connect, "SELECT * FROM `products` WHERE (CONVERT(`ID` USING utf8) LIKE '%${searchData}%' OR CONVERT(`PRODUCT-NAME` USING utf8) LIKE '%${searchData}%' OR CONVERT(`ARTICUL` USING utf8) LIKE '%${searchData}%' OR CONVERT(`TYPE` USING utf8) LIKE '%${searchData}%' OR CONVERT(`BRAND` USING utf8) LIKE '%${searchData}%' OR CONVERT(`MANUFACTURER` USING utf8) LIKE '%${searchData}%' OR CONVERT(`DESCRIPTION` USING utf8) LIKE '%${searchData}%' OR CONVERT(`ATTRIBUTES` USING utf8) LIKE '%${searchData}%')");

if(mysqli_num_rows($products)){
    while($popular = mysqli_fetch_assoc($products)){
        unset($popular['ATTRIBUTES']);
        $productList[] = $popular;
    }
}

?>

<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="utf-8">
        <meta name="viewport" content="width=806">
		<title>EIGHSTORE</title>
		<link href="style.css<? echo $style ?>" rel="stylesheet">
        <link href="flex.css<? echo $flex ?>" rel="stylesheet">
        <script src="header.js<? echo $script ?>"></script>
        
        
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
        
                
                
            <div class="catalog-of-products container column">
                <br><br>
                <div class="pre__desc row-between pos-center">
                
                    <div class="row-between pos-center"><h2>Поиск</h2></div>
                
                </div>
            
                <div class="popular-items-parent-2">
                
                    <div class="popular-items-2">
                        
                        <script>
                        
                        
                        
                        </script>
                        
                        <?php
                            
                            foreach($productList as $product){
                                ?>
                                
                                <div class="popular-item-2 column">
                                        <input type="hidden" value="<? echo $product['ID'] ?>" id="prod-id-<? echo $product['ID'] ?>">
                                    <a href="product.php?product=<? echo $product['ID'] ?>"><img src="<? echo $product['MAIN-IMAGE'] ?>" class="product-card"> </a>
                                    <div class="product-card-info column-between">
                                        
                                        <h3><a href="product.php?product=<? echo $product['ID'] ?>"><? echo $product['PRODUCT-NAME'] ?></a></h3>
                                        <p>ЭРА ECO LED Р45-10W-840-E27</p>
                                        <div class="product-card-func row-between">
                                            
                                            <h3 class="product-card-cost"><? echo $product['PRICE'] ?>₸</h3>
                                            
                                            <?php 
                                                if($product['COUNT'] > 0){
                                                    echo "<a><h3 style=\"color: #278458; cursor: pointer\" id=\"prod-${product['ID']}\" onclick=\"addInBasket(${product['ID']}, '${product['PRODUCT-NAME']}', 1, '${product['PRICE']}', '${product['MAIN-IMAGE']}')\">Купить</h3></a>";
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
<!--                 Main Content               -->           
        
        <!--   Bottom   -->
        <?php
            printBottom('');
        ?>
        <!--   Bottom   -->
        <script>CheckEveryProductInBasket();</script>
	</body>
</html>