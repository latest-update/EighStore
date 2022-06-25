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

$category = $_GET['name'];
$type = $_GET['type'];
$subtype = $_GET['subtype'];  

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
            if($product['IMAGES'] != null && $product['IMAGES'] != ''){
                echo 'var images = '.$product['IMAGES'].';';
            } 
        ?>      
            
        function getImages(){
            let arr = JSON.parse(JSON.stringify(images));
            document.querySelector(".images-show").innerHTML = '';
            for(let i = 0; i < arr.length; i++){
                document.querySelector(".images-show").innerHTML += `
                    <div class="images-show-img row-center pos-center" id="show-img-${i}"><img src="<? echo $SiteUrl ?>${arr[i]}" width="180"></div>
                `;
            }
        }    
            
        function getAttributes(){
            let arr = JSON.parse(JSON.stringify(attributes));
            for(let key in arr){
                addAttribute(key, arr[key]);
            }
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
            
        function saveImages(){
            document.getElementById('statusOfImages').setAttribute("value", "true");
            document.querySelector('.id074').innerHTML = 'Сохранен';
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
        
        function uploadNew(first, second){
            let ist = document.getElementById(first);
            let jst = document.getElementById(second);
            let mst = document.querySelector('.id074');
            let kst = document.querySelector('.id075');
            if(jst.style.display === "none"){
                ist.style.display = "none";
                jst.style.display = "block";
                mst.style.display = "block";
                kst.style.display = "none";
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
            
                <div class="panel-main-content row-center">
            
                <div class="panel-content-block column">
                    
                    
                    <h2 style="margin-bottom: 25px;"><a onclick="window.history.back()" style="cursor: pointer"><img class="main_catalog_link_arrow img-right" src="<? echo $backRoute ?>icons/down.svg"></a>Добавить продукт</h2>
                    
                    
                    <div class="content-block-add-product">
                        
                        <form action="add-product-copy.php?name=<? echo $category ?>&type=<? echo $type ?>&subtype=<? echo $subtype ?>" method="post" enctype="multipart/form-data">
                    
                        <input value="<? echo $product['PRODUCT-NAME'] ?>" class="add-product-input-1" type="text" placeholder="Имя товара" name="product-name" required><br><br>
                        <input value="<? echo $product['ARTICUL'] ?>" pattern="^((?!<? echo $product['ARTICUL'] ?>).)*$" class="add-product-input-1" type="text" placeholder="Артикул товара" name="articul"  required><br><br>
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
                            <input type="hidden" name="main-image" value="<? echo $product['MAIN-IMAGE'] ?>">
                            <input type="hidden" name="images" value='<? echo $product['IMAGES'] ?>'>
                            <input type="hidden" name="uploadImageStatus" id="statusOfImages" value="false">
                            <div class="images-show" id="id071">
                            
                                <!--                                 -->
                                
                            </div>
                            <div class="fileInput" id="id072" style="display: none;">
                            <input type="file" name="files[]" accept="image/*" id="input" multiple><br>
                            </div><br>
                            <a onclick="uploadNew('id071', 'id072')"><button id="button-login" type="button" class="user-info-btn id075">Загрузить новые</button></a><button id="button-login" style="display: none" type="button" onclick="saveImages()" class="user-info-btn id074">Сохранить картинки</button><br><br>
                            
                            
                            <center id="saveParentEl"><div style="border: 1px solid #eee; border-top: none; padding: 20px;"><button id="saveBtn" onclick="saveAttributes()" type="submit" style="border: none; background-color: transparent; cursor: pointer; font-size: 16px;">Сохранить</button></div></center> 
                        </form>
                        
                    </div>
                    
                
                </div>
                
            </div> 
        
        </div>
        <!--                 Main Content               -->
        
        <script>
            getAttributes();
            getImages();
        </script>
        
        <!--     custom input     -->
        <script src="<? echo $backRoute ?>lib/CustomInput/input-file.min.js"></script>
        <script>new InputFile({
            hint: 'или перетащите сюда',
            buttonText: 'Выберите картинки товара',
            message: 'Файлы выбраны'
        });</script>
        <!--     custom input     -->
        <script>
        var elm = false;    
        const input = document.getElementById('input');
        let btn = document.getElementById('saveBtn');    

        input.addEventListener("change", function(event) {
            if(input.files[0]['size'] > 1000000){     // 1 000 000 = 1 mb
                if(!elm){
                document.querySelector('.fileInput').insertAdjacentHTML("beforeend", '<p id="warningFileSize" style="color: red">! Допустимый размер файла 1MB</p>');
                btn.disabled = true;    
                elm = true;
                }
            } else {
                if(elm){
                    document.getElementById('warningFileSize').remove();    
                    btn.disabled = false;
                    elm = false;
                }
            }
        });
        </script>
    </body>
</html>