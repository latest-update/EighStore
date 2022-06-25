<?php
session_start(); 
$backRoute = '../../../';
require_once $backRoute.'Core/connect.php';
require_once $backRoute.'Core/checkAuth.php';
require_once $backRoute.'Core/checkFlagAdmin.php';

$category = $_GET['name'];
$type = $_GET['type'];
$subtype = $_GET['subtype'];
$productList = [];
$thereissubsubcat = true;

if($type !== 'all'){
    if(isset($subtype)){
        $category = mysqli_real_escape_string($connect, $category);
        $type = mysqli_real_escape_string($connect, $type);
        $subtype = mysqli_real_escape_string($connect, $subtype);
        $products = mysqli_query($connect, "SELECT * FROM `products`,`category` WHERE `category`.`CATEGORY-NAME` = '$category' AND `category`.`SUBCATEGORY-NAME` = '$type' AND `category`.`SUBSUBCATEGORY-NAME` = '$subtype' AND `products`.`CATEGORY-ID` = `category`.`CATEGORY-ID` ORDER BY `COUNT` DESC");
        while($popular = mysqli_fetch_assoc($products)){
            $productList[] = $popular;
        }
        $title = $category.' '.mb_strtolower($type).' '.mb_strtolower($subtype);
    } else{
        $category = mysqli_real_escape_string($connect, $category);
        $type = mysqli_real_escape_string($connect, $type);
        $products = mysqli_query($connect, "SELECT * FROM `products`,`category` WHERE `category`.`CATEGORY-NAME` = '$category' AND `category`.`SUBCATEGORY-NAME` = '$type' AND `products`.`CATEGORY-ID` = `category`.`CATEGORY-ID` ORDER BY `COUNT` DESC");
        while($popular = mysqli_fetch_assoc($products)){
            $productList[] = $popular;
        }
        $title = $category.' '.mb_strtolower($type);
        $thereissubsubcat = mysqli_query($connect, "SELECT COUNT(*) AS `count` FROM `category` WHERE `CATEGORY-NAME` = '$category' AND `SUBCATEGORY-NAME` = '$type' AND `SUBSUBCATEGORY-NAME` != ''");
        $thereissubsubcat = mysqli_fetch_assoc($thereissubsubcat);
        if($thereissubsubcat['count'] > 0){
            $thereissubsubcat = false;
        } else {
            $thereissubsubcat = true;
        }
    }
} else {
    $category = mysqli_real_escape_string($connect, $category);
    $products = mysqli_query($connect, "SELECT * FROM `products`,`category` WHERE `category`.`CATEGORY-NAME` = '$category' AND `products`.`CATEGORY-ID` = `category`.`CATEGORY-ID` ORDER BY `COUNT` DESC");
    while($popular = mysqli_fetch_assoc($products)){
        $productList[] = $popular;
    }
    $title = $category;
}
    

?>
<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="utf-8">
        <meta name="viewport" content="width=806">
		<title>EIGHSTORE</title>
        <link rel="shortcut icon" href="../../../icons/favicon.svg" type="image/x-icon">
		<link href="../../../style.css<? echo $style ?>" rel="stylesheet">
        <link href="../../../flex.css<? echo $flex ?>" rel="stylesheet">
        <script src="../../../header.js<? echo $script ?>"></script>
        <script>
        
            async function confirmAction(elem, name){
                var ask = confirm("Удалить товар " + name + "?");
                if(ask){
                    let res = await removeProduct(elem);
                    if(res){
                        successfulRemove(elem, name);
                    }
                } 
            }
            
            async function removeProduct(id){
                let formData = new FormData();
                formData.append('id', id);
    
                let res = await fetch(`http://eighstore-php-easier/admin/Products/Delete/delete-product.php?id=`+id, {
                    method: 'DELETE'
                });
                const data = await res.json();
    
                return data.status;
    
            }
            function successfulRemove(id, name){
                
                document.getElementById('product'+id).remove();
                alert('Товар ' + name + ' успешно удалено');
                
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
            
                <div class="panel-main-content row-center">
            
                <div class="panel-content-block column">
                    
                    
                    <h2 style="margin-bottom: 25px;"><a onclick="window.history.back()" style="cursor: pointer"><img class="main_catalog_link_arrow img-right" src="<? echo $backRoute ?>icons/down.svg"></a><? echo $title ?></h2>
                    
                    
                    
                    <!--                   -->
                    <div class="content-block-category column">
                        
                        <?php  
                        foreach($productList as $product){
                        ?>
                    
                        <div class="block-category-product row-between pos-center" id="product<? echo $product['ID'] ?>">
                        
                            <div class="category-product-info row-between">
                                
                                <div class="product-info-image">
                                    <img src="<? echo $backRoute ?><? echo $product['MAIN-IMAGE'] ?>">
                                </div>
                                <div class="product-info-info column-around pos-center">
                                
                                    <a href="<? echo $backRoute.'product.php?product='.$product['ID'] ?>"><h4><? echo $product['PRODUCT-NAME'] ?></h4></a>
                                    <h5>Артикул: <? echo $product['ARTICUL'] ?></h5>
                                    <h5>Уникальный номер(ID): <? echo $product['ID'] ?></h5>
                                    
                                </div>
                                
                            </div>
                            <div class="category-product-counts column-around pos-center">
                                <?php 
                                    if($product['COUNT'] > 0){
                                        echo "<h5 style=\"color: #278458\">Кол-во на складе: ${product['COUNT']}</h5>";
                                    } else {
                                        echo "<h5 style=\"color: red\">Кол-во на складе: ${product['COUNT']}</h5>";
                                    }
                                ?>
                                <h5>Продано: 0шт</h5>
                            </div>
                            <div class="category-product-event row-between pos-center">
                                <a style="cursor: pointer" href="../Edit/index.php?id=<? echo $product['ID'] ?>">
                                    <img class="search-img" src="<? echo $backRoute ?>icons/edit.svg">
                                </a>
                                <?php 
                                    if($type !== 'all' and $thereissubsubcat){   
                                    ?>
                                <a style="cursor: pointer; margin: 0 10px;" href="../Add/copy-product.php?id=<? echo $product['ID'] ?>&name=<? echo $category ?>&type=<? echo $type ?>&subtype=<? echo $subtype ?>">
                                    <img class="search-img" src="<? echo $backRoute ?>icons/copy.svg">
                                </a>
                                <?php } ?>
                                <a style="cursor: pointer" onclick="confirmAction(<? echo $product['ID'] ?>, '<? echo $product['PRODUCT-NAME'] ?>')">
                                    <img class="search-img" src="<? echo $backRoute ?>icons/delete.svg">
                                </a>
                            </div>
                        
                        </div>
                        
                        <?php
                        }
                        if($type !== 'all' and $thereissubsubcat){                                                
                        ?>
                        
                        <a href="../Add?name=<? echo $category ?>&type=<? echo $type ?>&subtype=<? echo $subtype ?>"><div class="block-category-product row-between pos-center">
                        
                            <div class="category-product-info row-between">
                                
                                <div class="product-info-image">
                                    <img src="<? echo $backRoute ?>icons/add.svg">
                                </div>
                                <div class="product-info-info column-around pos-center">
                                
                                    <h4>Добавить товар</h4>
                                    
                                </div>
                                
                            </div>
                            
                        
                        </div></a>
                        <?php 
                        }
                            ?>
                    
                    </div>
                    <!--                   -->
                
                </div>
                
            </div> 
        
        </div>
<!--                 Main Content               -->           
        
	</body>
</html>