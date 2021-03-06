<?php
session_start(); 
$backRoute = '../../../';
require_once $backRoute.'Core/connect.php';
require_once $backRoute.'Core/checkAuth.php';

require_once $backRoute.'Core/checkFlagAdmin.php';

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
        var attr = 1;  
        var deleteId = [];    
            
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
            document.querySelector('#attributes').insertAdjacentHTML("beforeend", "<p>! ????????????????</p>");
            let s = document.getElementById("addAttributes").remove();
            document.getElementById("saveAttribute").remove();
            document.getElementById("saveParentEl").remove();
            let m = document.querySelectorAll("#removeEv");
            for(let i = 0; i < m.length; i++){
                m[i].parentNode.removeChild(m[i]);
            }
            
            
            
        }    
            
        function deleteAttribute(delAttr){
            //this.attr--;
            document.getElementById('root' + delAttr).remove();
            deleteId.push(delAttr);
        }    
            
        function addAttribute(option){
            this.attr++;
            if(option === ''){
                document.querySelector('#attributes').insertAdjacentHTML("beforeend", '<div id="root'+ attr +'"><input class="add-product-input-2" id="attr'+ attr +'" placeholder="?????? ????????????????">   <input class="add-product-input-2" id="val'+ attr +'" placeholder="????????????????"> <a id="removeEv" onclick="deleteAttribute('+ attr +')" style="cursor: pointer">x</a><br><br></div>');
            } else {
                document.querySelector('#attributes').insertAdjacentHTML("beforeend", '<div id="root'+ attr +'"><input class="add-product-input-2" id="attr'+ attr +'" placeholder="?????? ????????????????" value="'+ option +'">   <input class="add-product-input-2" id="val'+ attr +'" placeholder="????????????????"> <a id="removeEv" onclick="deleteAttribute('+ attr +')" style="cursor: pointer">x</a><br><br></div>');
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
                    
                    
                    <h2 style="margin-bottom: 25px;"><a onclick="window.history.back()" style="cursor: pointer"><img class="main_catalog_link_arrow img-right" src="<? echo $backRoute ?>icons/down.svg"></a>???????????????? ??????????</h2>
                    
                    
                    <div class="content-block-add-product">
                        
                        <form action="add-product.php?name=<? echo $category ?>&type=<? echo $type ?>&subtype=<? echo $subtype ?>" method="post" enctype="multipart/form-data">
                    
                        <input class="add-product-input-1" type="text" placeholder="?????? ????????????" name="product-name" required><br><br>
                        <input class="add-product-input-1" type="text" placeholder="?????????????? ????????????" name="articul" required><br><br>
                        <input class="add-product-input-1" type="text" placeholder="??????" name="type" required><br><br>
                        <input class="add-product-input-1" type="text" placeholder="??????????" name="brand" required><br><br>
                        <input class="add-product-input-1" type="text" placeholder="??????????????????????????" name="manufacturer" required><br><br>
                        <textarea class="add-product-input-1" rows="5" placeholder="????????????????" name="description" required></textarea><br><br>
                        <input class="add-product-input-1" type="number" step="50" placeholder="????????" name="price" required><br><br>
                        <input class="add-product-input-1" type="number" placeholder="???????????????????? ???? ????????????" name="count" required><br><br>
                        <input type="hidden" id="jsonAttribute" name="attributes">    
                        <div id="parent-attr">
                        <div id="attributes">
                            <h4>??????????????????</h4><br>
                            <div id="root1">
                                <input class="add-product-input-2" id="attr1" placeholder="?????? ????????????????">   <input class="add-product-input-2" id="val1" placeholder="????????????????"><br><br>
                            </div>
                        </div><br>
                        <div id="addAttributes"><a onclick="addAttribute('')" style="cursor: pointer; margin: 0 10px;" id="addAttribute"> + ????????????????</a> | <a onclick="addAttribute('??????')" style="cursor: pointer; margin: 0 10px;" id="addAttribute"> ??????</a> | <a onclick="addAttribute('?????????????? ????????????')" style="cursor: pointer; margin: 0 10px;" id="addAttribute"> ?????????????? ????????????</a> | <a onclick="addAttribute('???????? ????????????')" style="cursor: pointer; margin: 0 10px;" id="addAttribute"> ???????? ????????????</a> | <a onclick="addAttribute('????????????????????')" style="cursor: pointer; margin: 0 10px;" id="addAttribute"> ????????????????????</a> | <a onclick="addAttribute('????????????')" style="cursor: pointer; margin: 0 10px;" id="addAttribute"> ????????????</a> | <a onclick="addAttribute('????????????')" style="cursor: pointer; margin: 0 10px;" id="addAttribute"> ????????????</a> | <a onclick="addAttribute('???????????????? ????????????')" style="cursor: pointer; margin: 0 10px;" id="addAttribute"> ???????????? ????????????</a> | <a onclick="addAttribute('???????????????? ????????????????')" style="cursor: pointer; margin: 0 10px;" id="addAttribute"> ???????????? ????????????????</a></div><br><br>
                        <center id="saveParentEl"><div style="border: 1px solid #eee; border-top: none; padding: 20px;"><a onclick="saveAttributes()" id="saveAttribute" style="cursor: pointer;">?????????????????? ??????????????????</a></div></center>     
                        </div> <br><br>
                        <div id="fileInput">
                            <input type="file" name="files[]" accept="image/*" id="input" multiple><br>
                        </div><br>
                            <center id="saveParentEl"><div style="border: 1px solid #eee; border-top: none; padding: 20px;"><button id="saveBtn" onclick="saveAttributes()" type="submit" style="border: none; background-color: transparent; cursor: pointer; font-size: 16px;">??????????????????</button></div></center> 
                        </form>
                        
                    </div>
                    
                
                </div>
                
            </div> 
        
        </div>
<!--                 Main Content               -->    
        
        <!--     custom input     -->
        <script src="<? echo $backRoute ?>lib/CustomInput/input-file.min.js"></script>
        <script>new InputFile({
            hint: '?????? ???????????????????? ????????',
            buttonText: '???????????????? ???????????????? ????????????',
            message: '?????????? ??????????????'
        });</script>
        <!--     custom input     -->
        <script>
        var elm = false;    
        const input = document.getElementById('input');
        let btn = document.getElementById('saveBtn');    

        input.addEventListener("change", function(event) {
            if(input.files[0]['size'] > 1000000){     // 1 000 000 = 1 mb
                if(!elm){
                document.querySelector('#fileInput').insertAdjacentHTML("beforeend", '<p id="warningFileSize" style="color: red">! ???????????????????? ???????????? ?????????? 1MB</p>');
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