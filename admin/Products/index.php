<?php
session_start(); 
$backRoute = '../../';
require_once $backRoute.'Core/connect.php';
require_once $backRoute.'Core/checkAuth.php';
require_once $backRoute.'Core/checkFlagAdmin.php';

$get_categories_name = mysqli_query($connect, "SELECT `CATEGORY-NAME`, `CATEGORY-IMAGE` FROM `category` GROUP BY `CATEGORY-NAME`, `CATEGORY-IMAGE` HAVING count(*)>=1");
$get_categories_name = mysqli_fetch_all($get_categories_name);

$categories_query = mysqli_query($connect, "SELECT * FROM `category`");
$categories_query = mysqli_fetch_all($categories_query);


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
        
            function addSubCat(idNum){
                document.getElementById('addSubCat' + idNum).style.display = "none";
                document.getElementById('category-input' + idNum).style.display = "block";
                document.getElementById('category-action' + idNum).style.display = "flex";
            }
        
            function cancelAddCategory(idNum){
                document.getElementById('addSubCat' + idNum).style.display = "block";
                document.getElementById('category-input' + idNum).style.display = "none";
                document.getElementById('category-action' + idNum).style.display = "none";
            }
            
            function addSubSub(idNum){
                document.getElementById('subsubAdd' + idNum).style.display = "flex";
            }
            function cancelAddSubCategory(idNum){
                document.getElementById('subsubAdd' + idNum).style.display = "none";
            }
            function confirmAction(link, elem){
                var ask = confirm("Удалить категорию " + elem + "?");
                if(ask){
                    window.location.href = link;
                } 
            }
            function editCategory(idNum, name, rat){
                var edit = prompt("Изменить "+name+" на ?", '');
                if((rat == 'sub' || rat == 'subsub') && edit != '' && edit != ' ' && edit != null){
                    window.location.replace("Edit/edit-category.php?action="+rat+"&id="+idNum+"&edit="+edit);
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
                    
                    <div class="row-between pos-center">
                    <h2 style="margin-bottom: 25px;">Категория товаров</h2>
                    <a href="../../Template/HeaderRender.php"><h4 style="margin-bottom: 10px;">Обновить</h4></a>
                    </div>
                    
                    <?php
                    $sampleshot = array();
                    $lpb = 0;
                    $spb = 0;
                    foreach($get_categories_name as $category){ 
                    ?>
                    
                    <!--                   -->
                    <div class="content-block-category column">
                    
                        <div class="block-category-name row-between pos-center" style="background-color: #eee">
                        
                            <a href="View/index.php?name=<? echo $category[0] ?>&type=all"><p><? echo $category[0] ?></p></a>
                        
                        </div>
                        <?php
                        foreach($categories_query as $subcategory){
                            if($category[0] === $subcategory[1] && !(in_array($subcategory[2], $sampleshot)) && $subcategory[2] != ''){
                                
                            
                        ?>
                        <div class="block-category-element row-between pos-center">
                        
                            <a href="View/index.php?name=<? echo $category[0] ?>&type=<? echo $subcategory[2] ?>"><p><? echo $subcategory[2] ?></p></a>
                            <div class="block-option row-between pos-center">
                                <a onclick="editCategory(<? echo $subcategory[0] ?>, '<? echo $subcategory[2] ?>', 'sub')" style="cursor: pointer;"><img class="search-img" src="<? echo $backRoute ?>icons/edit.svg"></a>
                                <a onclick="addSubSub(<? echo $spb ?>)" style="cursor: pointer;"><img class="search-img" src="<? echo $backRoute ?>icons/add.svg"></a>
                                <a style="cursor: pointer" onclick="confirmAction('Delete/delete-category.php?action=deleteSub&id=<? echo $subcategory[0] ?>&name=<? echo $category[0] ?>', '<? echo $subcategory[2] ?>')">
                                    <img class="search-img" src="<? echo $backRoute ?>icons/delete.svg">
                                </a>
                            </div>
                        
                        </div>
                        
                        <form action="Add/add-category.php" method="post"> 
                        <div class="block-category-element row-between pos-center" id="subsubAdd<? echo $spb ?>" style="display: none">
                    
                            <input class="add-category-input-1" placeholder="Имя под-подкатегории" name="subcat-name">
                            <div class="row-between pos-center" style="width: 150px; display: flex">
                                <button type="submit" style="border: none; background-color: transparent; cursor: pointer; font-size: 16px;" onclick="">Сохранить</button>
                                <button type="button" style="border: none; background-color: transparent; cursor: pointer; font-size: 16px;" onclick="cancelAddSubCategory(<? echo $spb ?>)">Отмена</button>
                            </div>
                            <?php
                            
                                if($subcategory[3] == ''){
                                    ?>
                                    <input type="hidden" value="<? echo $subcategory[0] ?>" name="delete-id">
                                    <?php
                                }
                            
                            ?>
                            <input type="hidden" value="<? echo $category[0] ?>" name="category-name">
                            <input type="hidden" value="<? echo $subcategory[2] ?>" name="subcategory-name">
                            <input type="hidden" value="<? echo $get_categories_name[$lpb][1]  ?>" name="category-image">
                            
                        </div>
                        </form>
                        
                        <?php
                            
                                if($subcategory[3] != '' && $subcategory[3] != ' '){ 
                                    
                                    foreach($categories_query as $tmp_subcategory){
                                        
                                        if($tmp_subcategory[2] == $subcategory[2] && $tmp_subcategory[1] == $category[0]){ ?>
                                                
                                            <div class="block-subcategory-element row-between pos-center">
                                                <a href="View/index.php?name=<? echo $category[0] ?>&type=<? echo $subcategory[2] ?>&subtype=<? echo $tmp_subcategory[3] ?>"><p><? echo $tmp_subcategory[3] ?></p></a>
                                                <div class="block-option row-between pos-center">
                                                    <a onclick="editCategory(<? echo $tmp_subcategory[0] ?>, '<? echo $tmp_subcategory[3] ?>', 'subsub')" style="cursor: pointer;"><img class="search-img" src="<? echo $backRoute ?>icons/edit.svg"></a>
                                                    <a style="cursor: pointer" onclick="confirmAction('Delete/delete-category.php?action=deleteSubSub&id=<? echo $tmp_subcategory[0] ?>&name=<? echo $category[0] ?>&type=<? echo $subcategory[2] ?>', '<? echo $tmp_subcategory[3] ?>')">
                                                        <img class="search-img" src="<? echo $backRoute ?>icons/delete.svg">
                                                    </a>
                                                </div>
                                            </div>
                        
                                            <?php
                                        }
                                    }
                                    
                                    $sampleshot[] = $subcategory[2];
                                }
                            }
                            $spb++;
                        }
                        ?>
                        <form action="Add/add-category.php" method="post"> 
                        <div class="block-category-element row-between pos-center">
                            
                            <a onclick="addSubCat(<? echo $lpb ?>)" id="addSubCat<? echo $lpb ?>" style="display: block; cursor: pointer;"><p>Добавить подкатегорию +</p></a>
                            
                            <input class="add-category-input-1" id="category-input<? echo $lpb ?>" placeholder="Имя подкатегории" style="display: none" name="subcat-name">
                            <div class="row-between pos-center" id="category-action<? echo $lpb ?>" style="width: 150px; display: none">
                                <button type="submit" style="border: none; background-color: transparent; cursor: pointer; font-size: 16px;" onclick="">Сохранить</button>
                                <button type="button" style="border: none; background-color: transparent; cursor: pointer; font-size: 16px;" onclick="cancelAddCategory(<? echo $lpb ?>)">Отмена</button>
                            </div>
                            <input type="hidden" value="<? echo $category[0] ?>" name="category-name">
                            <input type="hidden" value="<? echo $get_categories_name[$lpb][1]  ?>" name="category-image">
                            
                        </div>
                        </form>
                    
                    </div>
                    <!--                   -->
                    
                    <?php
                        $lpb++;
                    }
                    ?>
                    
                
                </div>
                
            </div>    
        
        </div>
<!--                 Main Content               -->           
        
	</body>
</html>