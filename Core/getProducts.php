<?php
header('Content-Type: application/json');
require_once 'connect.php';

$query = $_GET['query'];
$productList = [];

switch($query){
    case 'catalog':
        $category = $_GET['name'];
        $type = $_GET['type'];
        $subtype = $_GET['subtype'];
        if($type !== 'all'){
            if(isset($subtype) && $subtype != ''){
                $category = mysqli_real_escape_string($connect, $category);
                $type = mysqli_real_escape_string($connect, $type);
                $subtype = mysqli_real_escape_string($connect, $subtype);
                $products = mysqli_query($connect, "SELECT * FROM `products`,`category` WHERE `category`.`CATEGORY-NAME` = '$category' AND `category`.`SUBCATEGORY-NAME` = '$type' AND `category`.`SUBSUBCATEGORY-NAME` = '$subtype' AND `products`.`CATEGORY-ID` = `category`.`CATEGORY-ID` ORDER BY `COUNT` DESC");
                while($popular = mysqli_fetch_assoc($products)){
                    $arrjs = $popular['ATTRIBUTES'];
                    $arrjs = json_decode($arrjs);
                    unset($popular['ATTRIBUTES']);
                    $popular['ATTRIBUTES'] = $arrjs;
                                                                
                    $productList[] = $popular;
                }
                $title = $category.' '.mb_strtolower($type).' '.mb_strtolower($subtype);
                
            } else{
                $category = mysqli_real_escape_string($connect, $category);
                $type = mysqli_real_escape_string($connect, $type);
                $products = mysqli_query($connect, "SELECT * FROM `products`,`category` WHERE `category`.`CATEGORY-NAME` = '$category' AND `category`.`SUBCATEGORY-NAME` = '$type' AND `products`.`CATEGORY-ID` = `category`.`CATEGORY-ID` ORDER BY `COUNT` DESC");
                while($popular = mysqli_fetch_assoc($products)){
                    $arrjs = $popular['ATTRIBUTES'];
                    $arrjs = json_decode($arrjs);
                    unset($popular['ATTRIBUTES']);
                    $popular['ATTRIBUTES'] = $arrjs;
                                                                
                    $productList[] = $popular;
                    
                }
                $title = $category.' '.mb_strtolower($type);
            }
            
        } else {
            $category = mysqli_real_escape_string($connect, $category);
            $products = mysqli_query($connect, "SELECT * FROM `products`,`category` WHERE `category`.`CATEGORY-NAME` = '$category' AND `products`.`CATEGORY-ID` = `category`.`CATEGORY-ID` ORDER BY `COUNT` DESC");
            while($popular = mysqli_fetch_assoc($products)){
                $arrjs = $popular['ATTRIBUTES'];
                    $arrjs = json_decode($arrjs);
                    unset($popular['ATTRIBUTES']);
                    $popular['ATTRIBUTES'] = $arrjs;
                                                                
                    $productList[] = $popular;
            }
            $title = $category;
        }
        break;
    case 'popular':
        $popular_products = mysqli_query($connect, "SELECT * FROM `products`,`popular` WHERE `products`.`ID` = `popular`.`product_id` ORDER BY `COUNT` DESC");
        while($popular = mysqli_fetch_assoc($popular_products)){
            $arrjs = $popular['ATTRIBUTES'];
                    $arrjs = json_decode($arrjs);
                    unset($popular['ATTRIBUTES']);
                    $popular['ATTRIBUTES'] = $arrjs;
                                                                
                    $productList[] = $popular;
        }
        $title = 'Популярные';
        break;
    case 'best':
        
        break;
    default:
        header('Location: /');
}
if(count($productList) === 0){
    $title = 'Товары не найдены';            
}

echo json_encode($productList);