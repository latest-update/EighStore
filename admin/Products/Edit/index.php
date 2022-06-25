<?php
session_start(); 
$backRoute = '../../../';
require_once $backRoute.'Core/connect.php';
require_once $backRoute.'Core/checkAuth.php';

require_once $backRoute.'Core/checkFlagAdmin.php';

$product_id = $_GET['id'];
settype($product_id, 'integer');

$product = mysqli_query($connect, "SELECT * FROM `products`,`category` WHERE `products`.`ID` = '$product_id' AND `products`.`CATEGORY-ID` = `category`.`CATEGORY-ID`");
if(mysqli_num_rows($product) === 0){
    header('Location: ../');
} else{
    $product = mysqli_fetch_assoc($product);
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
        <!--     custom input     -->
        <link rel="stylesheet" href="<? echo $backRoute ?>lib/CustomInput/input-file.css">
        <!--     custom input     -->
        <script>
        var attr = 0;
        var deleteId = [];        
        <?php
            if($product['ATTRIBUTES'] != null && $product['ATTRIBUTES'] != ''){
                echo 'var attributes = '.$product['ATTRIBUTES'].';';
            }
        ?>      
        function getAttributes(){
            let arr = JSON.parse(JSON.stringify(attributes));
            for(let key in arr){
                addAttribute(key, arr[key]);
            }
            console.log(attr);
        }
            
        function saveAttributes(){
            var attrib = new Map();
            var res = '{';
            for(let i = 1; i <= attr; i++){
                if(!deleteId.includes(i)){
                    let name = document.getElementById('attr' + i).value;
                    let val = document.getElementById('val' + i).value;
                    document.getElementById("attr" + i).readOnly = true;
                    document.getElementById("val" + i).readOnly = true;
                    attrib.set(name, val);
                }
            }
            let tmp_attr = attrib.size;
            for(let pair of attrib) {
                tmp_attr--;
                if(tmp_attr !== 0){
                    res += '"' + pair[0] + '": "'+pair[1]+'", ';    
                } else {
                    res += '"' + pair[0] + '": "'+pair[1]+'"';
                }
                
            }
            res+= '}';
            document.getElementById("jsonAttribute").setAttribute("value", res);
            document.querySelector('#attributes').insertAdjacentHTML("beforeend", "<p>! Сохранен</p>");
            let s = document.getElementById("addAttributes").remove();
            document.getElementById("saveAttribute").remove();
            document.getElementById("saveParentEl").remove();
            let m = document.querySelectorAll("#removeEv");
            for(let i = 0; i < m.length; i++){
                m[i].parentNode.removeChild(m[i]);
            }
            
            
            
        }     
            
        function addAttribute(option, opt){
            this.attr++;
            if(option === '' && opt === ''){
                document.querySelector('#attributes').insertAdjacentHTML("beforeend", '<div id="root'+ attr +'"><input class="add-product-input-2" id="attr'+ attr +'" placeholder="Имя атрибута">   <input class="add-product-input-2" id="val'+ attr +'" placeholder="Значение"> <a id="removeEv" onclick="deleteAttribute('+ attr +')" style="cursor: pointer">x</a><br><br></div>');
            } else {
                document.querySelector('#attributes').insertAdjacentHTML("beforeend", '<div id="root'+ attr +'"><input class="add-product-input-2" id="attr'+ attr +'" placeholder="Имя атрибута" value="'+ option +'">   <input class="add-product-input-2" id="val'+ attr +'" placeholder="Значение" value="' + opt + '"> <a id="removeEv" onclick="deleteAttribute('+ attr +')" style="cursor: pointer">x</a><br><br></div>');
            }
        }  
            
        function deleteAttribute(delAttr){
            document.getElementById('root' + delAttr).remove();
            deleteId.push(delAttr);
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
                    
                    
                    <h2 style="margin-bottom: 25px;"><a onclick="window.history.back()" style="cursor: pointer"><img class="main_catalog_link_arrow img-right" src="<? echo $backRoute ?>icons/down.svg"></a><? echo $product['PRODUCT-NAME'] ?></h2>
                    
                    
                    <div class="content-block-add-product">
                        
                        <form action="edit-product.php?id=<? echo $product['ID'] ?>" method="post" enctype="multipart/form-data">
                    
                        <input value="<? echo $product['PRODUCT-NAME'] ?>" class="add-product-input-1" type="text" placeholder="Имя товара" name="product-name" required><br><br>
                        <input value="<? echo $product['ARTICUL'] ?>" class="add-product-input-1" type="text" placeholder="Артикул товара" name="articul" required><br><br>
                        <input value="<? echo $product['TYPE'] ?>" class="add-product-input-1" type="text" placeholder="Тип" name="type" required><br><br>
                        <input value="<? echo $product['BRAND'] ?>" class="add-product-input-1" type="text" placeholder="Бренд" name="brand" required><br><br>
                        <input value="<? echo $product['MANUFACTURER'] ?>" class="add-product-input-1" type="text" placeholder="Производитель" name="manufacturer" required><br><br>
                        <textarea class="add-product-input-1" rows="5" placeholder="Описание" name="description" required><? echo $product['DESCRIPTION'] ?></textarea><br><br>
                        <input value="<? echo $product['PRICE'] ?>" class="add-product-input-1" type="number" step="50" placeholder="Цена" name="price" required><br><br>
                        <input value="<? echo $product['COUNT'] ?>" class="add-product-input-1" type="number" placeholder="Количество на складе" name="count" required><br><br>
                        <input type="hidden" id="jsonAttribute" name="attributes">   
                        <div id="parent-attr">
                            <div id="attributes">
                                <h4>Аттрибуты</h4><br>
                                
                            </div>
                            <div id="addAttributes"><a onclick="addAttribute('', '')" style="cursor: pointer; margin: 0 10px;" id="addAttribute"> + Добавить</a></div><br>
                        <center id="saveParentEl"><div style="border: 1px solid #eee; border-top: none; padding: 20px;"><a onclick="saveAttributes()" id="saveAttribute" style="cursor: pointer;">Сохранить аттрибуты</a></div></center>    
                        </div><br><br>    
                            
                            <center id="saveParentEl"><div style="border: 1px solid #eee; border-top: none; padding: 20px;"><button id="saveBtn" onclick="saveAttributes()" type="submit" style="border: none; background-color: transparent; cursor: pointer; font-size: 16px;">Сохранить</button></div></center> 
                        </form>
                        
                    </div>
                    
                
                </div>
                
            </div> 
        
        </div>
        <!--                 Main Content               -->
        
        <script>
            getAttributes();
        </script>
    </body>
</html>