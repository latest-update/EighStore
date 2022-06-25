<?php
session_start(); 
//SELECT * FROM `products`,`category` WHERE `category`.`SUBCATEGORY-NAME` = 'Энергосберегающие' AND `category`.`ID` = `products`.`CATEGORY-ID`
require_once 'Core/connect.php';
require_once 'Core/checkAuthPassive.php';
require_once 'Core/productFilter.php';
include 'Template/Header.php';
$query = $_GET['query'];
if($_GET['type'] == 'all'){
    $title = $_GET['name'];
} else {
$title = $_GET['name'].' '.mb_strtolower($_GET['type']).' '.mb_strtolower($_GET['subtype']);
}
if(isset($_GET['page'])){
    $page = $_GET['page'];
} else {
    $page = 1;
}

?>
<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="utf-8">
        <meta name="viewport" content="width=806">
		<title>EIGHSTORE - <? echo $title ?></title>
        <link rel="shortcut icon" href="/icons/favicon.svg" type="image/x-icon">
		<link href="style.css<? echo $style ?>" rel="stylesheet">
        <link href="flex.css<? echo $flex ?>" rel="stylesheet">
        <script src="header.js<? echo $script ?>"></script>
        <script>
        var products = null;
        var FilterProducts = [];    
        var sortByCheap = false;    
        var numberOfProducts = 0;   
        var pageOfProducts = 0;  
        var thisPage = 1;
        var thisHref = null;
        <?php echo printParams($_GET['name']); ?>    
        <?php if(isset($_GET['price'])){ ?>  var price = '<? echo $_GET['price'] ?>'; <?php } else { ?> var price = null; <?php } ?>
            
        async function serverQuery(){
            let res = await fetch('Core/getProducts.php?query=<? echo $query ?>&name=<? echo $_GET['name'] ?>&type=<? echo $_GET['type'] ?>&subtype=<? echo $_GET['subtype'] ?>');
            products = await res.json();
            numberOfProducts = products.length;
            pageOfProducts = Math.ceil(numberOfProducts/8);
            thisHref = window.location.href.replace('&page=<? echo $page ?>','');
            thisHref = thisHref.replace('&price=up', '');
            thisHref = thisHref.replace('&price=down', '');
            if(price === 'up'){
                sortByCheap = false;
                sortByPrice();
            } else if(price === 'down'){
                sortByCheap = true;
                sortByPrice();
            }
            getProducts(<? echo $page ?>, false);
        }
            
        function getProducts(page, filtered){
            thisPage = page;
            
            let numberOfElementsThisPage = page * 8;
            
            document.querySelector('.popular-items-2').innerHTML = '';
            
            for(let i = numberOfElementsThisPage - 8; i < numberOfElementsThisPage && i < numberOfProducts; i++){
                let product = null;
                if(filtered){
                    product = FilterProducts[i];
                } else {
                    product = products[i];
                }
                let cocol = '';
                let protection = '';
                let lightemp = '';
                if(product["ATTRIBUTES"]!=null && product["ATTRIBUTES"]['Цоколь'] != null){
                    cocol = product["ATTRIBUTES"]['Цоколь'];
                }
                if(product["ATTRIBUTES"]!=null && product["ATTRIBUTES"]['Степень защиты'] != null){
                    protection = product["ATTRIBUTES"]['Степень защиты'];
                }
                if(product["ATTRIBUTES"]!=null && product["ATTRIBUTES"]['Цветовая температура'] != null){
                    lightemp = product["ATTRIBUTES"]['Цветовая температура'];
                }
                
                if(product.COUNT > 0){
                document.querySelector('.popular-items-2').innerHTML += `
                    <div class="popular-item-2 column">
                                        <input type="hidden" value="${product.ID}" id="prod-id-${product.ID}">
                                    <a href="product.php?product=${product.ID}"><img src="${product["MAIN-IMAGE"]}" class="product-card"></a>
                                    <div class="product-card-info column-between">
                                        
                                        <h3><a href="product.php?product=${product.ID}" target="_blank">${product["PRODUCT-NAME"]}</a></h3>
                                        <p></p>
                                        <div class="product-card-func row-between">
                                            
                                            <h3 class="product-card-cost">${product.PRICE}₸</h3>
                                            
                                           <a><h3 style="color: #278458; cursor: pointer" id="prod-${product['ID']}" onclick="addInBasket(${product['ID']}, '${product['PRODUCT-NAME']}', 1, '${product['PRICE']}', '${product['MAIN-IMAGE']}')">Купить</h3></a>
                                                
                                        </div>
                                            
                                    </div>
                                            
                                </div>
                `;} else {
                    document.querySelector('.popular-items-2').innerHTML += `
                            <div class="popular-item-2 column">
                                        <input type="hidden" value="${product.ID}" id="prod-id-${product.ID}">
                                    <a href="product.php?product=${product.ID}"><img src="${product["MAIN-IMAGE"]}" class="product-card"></a>
                                    <div class="product-card-info column-between">
                                        
                                        <h3><a href="product.php?product=${product.ID}" target="_blank">${product["PRODUCT-NAME"]}</a></h3>
                                        <p></p>
                                        <div class="product-card-func row-between">
                                            
                                            <h3 class="product-card-cost">${product.PRICE}₸</h3>
                                            
                                            <a><h3 style="color: red">Нет в наличии</h3></a>
                                                
                                        </div>
                                            
                                    </div>
                                            
                                </div>
                        `;
                    }  
            }
            
            
            history.pushState(null, null, thisHref+'&page='+page);
            
            
            if(pageOfProducts > 1){
                
                document.querySelector('.pagination').innerHTML = '';
                
                for(let i = 1; i <= pageOfProducts; i++){
                    
                    if(i == thisPage){
                        document.querySelector('.pagination').innerHTML += `
                            <a style="cursor: pointer" class="active" onclick="getProducts(${i}, ${filtered})">${i}</a>
                        `;
                    } else {
                        document.querySelector('.pagination').innerHTML += `
                            <a style="cursor: pointer" href="#" onclick="getProducts(${i}, ${filtered})">${i}</a>
                        `;
                    }
                
                }
            } else {
                document.querySelector('.pagination').innerHTML = '';
            }
            
            CheckEveryProductInBasket();
            }
        
            function sortByPrice(filtered) {
                if(sortByCheap){
                    products.sort((a, b) => b.PRICE - a.PRICE);
                    FilterProducts.sort((a, b) => b.PRICE - a.PRICE);
                    
                    sortByCheap = false;
                    thisHref = thisHref.replace('&price=up', '');
                    thisHref = thisHref+'&price=down';
                    history.pushState(null, null, thisHref);
                } else {
                    products.sort((a, b) => a.PRICE - b.PRICE);
                    FilterProducts.sort((a, b) => a.PRICE - b.PRICE);
                    sortByCheap = true;
                    thisHref = thisHref.replace('&price=down', '');
                    thisHref = thisHref+'&price=up';
                    history.pushState(null, null, thisHref);
                }
                
                getProducts(1, filtered);
            }
            
            function openFilters(){
                let filters = document.getElementById("filters");
                if(filters.style.height == "0px"){
                    filters.style.borderBottom = "1px solid #eee";
                    filters.style.height = "310px";
                } else {
                    filters.style.height = "0px";
                    filters.style.borderBottom = "none";
                }
            }
            

            
            function filterBrands(){
                let tmp_arr = [];
                var markedCheckbox = document.getElementsByName('Brand');
                let leng = 0;
                for (var checkbox of markedCheckbox) {  
                    if (checkbox.checked){  
                        for(var product of products){
                            if(product.BRAND === checkbox.value){
                                tmp_arr.push(product);
                            }
                        }
                        leng++;
                    } 
                } 
                if(leng == 0){
                    numberOfProducts = products.length;
                    pageOfProducts = Math.ceil(numberOfProducts/8);
                    return [products, false];
                } else {
                    numberOfProducts = tmp_arr.length;
                    pageOfProducts = Math.ceil(numberOfProducts/8);
                    return [tmp_arr, true];
                }
            }
            
            
            
            
            function filterLoop(arr, prev_checked, name, attrName){
                let tmp_arr = [];
                var markedCheckbox = document.getElementsByName(name);
                let leng = 0;
                for (var checkbox of markedCheckbox) {  
                    if (checkbox.checked){  
                        for(var product of products){
                            if(product['ATTRIBUTES'] != null && product['ATTRIBUTES'][attrName] == checkbox.value){
                                tmp_arr.push(product);
                            }
                        }
                        leng++;
                    } 
                }     
                
                let intersection = arr.filter(x => tmp_arr.includes(x));
                if(leng == 0 && !prev_checked){
                    refreshProductsInfo(false);
                    return [products, false];
                } else if(leng > 0 && !prev_checked){
                    FilterProducts = tmp_arr;
                    refreshProductsInfo(true);
                    return [FilterProducts, true];
                } else if(leng > 0 && prev_checked){
                    FilterProducts = intersection;
                    refreshProductsInfo(true);
                    return [FilterProducts, true];
                } else if(leng == 0 && prev_checked){
                    FilterProducts = arr;
                    refreshProductsInfo(true);
                    return [FilterProducts, true];
                }
            }
            

            function filterStart(){
                let loppsArr = [];
                let changed = filterBrands();
                let status = changed[1];
                let i = 0;
                for(let every in filterWords){
                    if(i == 0){
                        loppsArr = filterLoop(changed[0], status, every, filterWords[every]);
                        status = loppsArr[1];
                        i++;
                    } else {
                        loppsArr = filterLoop(loppsArr[0], status, every, filterWords[every]);
                        status = loppsArr[1];
                    }
                }
                status = filterOtherInputs(status, 'power', 'Мощность');
                status = filterPrice(status);
                refreshProductsInfo(status);
                getProducts(1, status);
                openFilters();
            }
            
            
            function filterOtherInputs(status, name, attrName){
                let tmp_arr = [];
                let arr = [];
                var name = document.getElementsByName(name);
                if(status){
                    arr = FilterProducts;
                } else {
                    arr = products;
                }
                let from = Number(name[0].value);
                let till = Number(name[1].value);
                
                if(from != '' && till != ''){
                    
                    for(var product of arr){
                        if(product['ATTRIBUTES'] != null && product['ATTRIBUTES'][attrName] != null && Number(parseInt(product['ATTRIBUTES'][attrName].replace(/\D+/g,""))) >= from && Number(parseInt(product['ATTRIBUTES'][attrName].replace(/\D+/g,""))) <= till){
                            tmp_arr.push(product);
                        }
                    }
                    
                } else if(from != '' && till == ''){
                    
                    for(var product of arr){
                        if(product['ATTRIBUTES'] != null && product['ATTRIBUTES'][attrName] != null && Number(parseInt(product['ATTRIBUTES'][attrName].replace(/\D+/g,""))) >= from){
                            tmp_arr.push(product);
                        }
                    }
                    
                } else if(from == '' && till != ''){
                    for(var product of arr){
                        if(product['ATTRIBUTES'] != null && product['ATTRIBUTES'][attrName] != null && Number(parseInt(product['ATTRIBUTES'][attrName].replace(/\D+/g,""))) <= till){
                            tmp_arr.push(product);
                        }
                    }
                } else {
                    return status;
                }
                FilterProducts = tmp_arr;
                return true;
                
            }
            
            function filterPrice(status){
                let tmp_arr = [];
                let arr = [];
                var price = document.getElementsByName('price');
                if(status){
                    arr = FilterProducts;
                } else {
                    arr = products;
                }
                let from = Number(price[0].value);
                let till = Number(price[1].value);
                if(from != '' && till != ''){
                    
                    for(var product of arr){
                        if(Number(product.PRICE) >= from && Number(product.PRICE) <= till){
                            tmp_arr.push(product);
                        }
                    }
                    
                } else if(from != '' && till == ''){
                    
                    for(var product of arr){
                        if(Number(product.PRICE) >= from){
                            tmp_arr.push(product);
                        }
                    }
                    
                } else if(from == '' && till != ''){
                    for(var product of arr){
                        if(Number(product.PRICE) <= till){
                            tmp_arr.push(product);
                        }
                    }
                } else {
                    return status;
                }
                
                FilterProducts = tmp_arr;
                return true;
            }
            
            
            function refreshProductsInfo(status){
                if(status){
                    numberOfProducts = FilterProducts.length;
                    pageOfProducts = Math.ceil(numberOfProducts/8);
                    document.getElementById('sortByPrice').setAttribute('onclick', "sortByPrice(true)");
                } else {
                    numberOfProducts = products.length;
                    pageOfProducts = Math.ceil(numberOfProducts/8);
                    document.getElementById('sortByPrice').setAttribute('onclick', "sortByPrice(false)");
                }
            }
            
            

               
                
                
        </script>
        
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
                <br>
                <div class="pre__desc row-between pos-center">
                
                    <div class="row-between pos-center"><h2><? echo $title ?></h2></div>
                
                </div>
                
                
                
                <div class="products-filtering row-between pos-center">
                
                    <div class="dropdown">
                        <button class="dropbtn">Сортировать по</button>
                        <div class="dropdown-content">
                            <a style="cursor: pointer" onclick="sortByPrice(false)" id="sortByPrice">Цене</a>
                            <a style="cursor: pointer" >Рейтингу</a>
                            <a style="cursor: pointer" >Покупкам</a>
                        </div>
                    </div>
                    
                    <a style="cursor: pointer" onclick="openFilters()"><h4>Фильтры</h4></a>
                    
                    
                </div>
                
                <div id="filters" class="row" style="height: 0px;">
                    
                        <div class="filters-brand column">
                        
                            <div class="filter-name"><p><strong>Бренд</strong></p></div>
                            <div class="filter-body">
                                <div class="filter-checkbox row-start pos-center">
                                
                                    <input type="checkbox" class="filter-checkbox-input" name="Brand" value="Заря">
                                    <p>Заря</p>
                                    
                                </div>
                                <div class="filter-checkbox row-start pos-center">
                                
                                    <input type="checkbox" class="filter-checkbox-input" name="Brand" value="Эра">
                                    <p>Эра</p>
                                    
                                </div>
                                <div class="filter-checkbox row-start pos-center">
                                
                                    <input type="checkbox" class="filter-checkbox-input" name="Brand" value="Шам">
                                    <p>Шам</p>
                                    
                                </div>
                                <div class="filter-checkbox row-start pos-center">
                                
                                    <input type="checkbox" class="filter-checkbox-input" name="Brand" value="Эко">
                                    <p>Эко</p>
                                    
                                </div>
                                <div class="filter-checkbox row-start pos-center">
                                
                                    <input type="checkbox" class="filter-checkbox-input" name="Brand" value="Philips">
                                    <p>Philips</p>
                                    
                                </div>
                                <div class="filter-checkbox row-start pos-center">
                                
                                    <input type="checkbox" class="filter-checkbox-input" name="Brand" value="Восток">
                                    <p>Восток</p>
                                    
                                </div>
                                <div class="filter-checkbox row-start pos-center">
                                
                                    <input type="checkbox" class="filter-checkbox-input" name="Brand" value="Свет">
                                    <p>Свет</p>
                                    
                                </div>
                                <div class="filter-checkbox row-start pos-center">
                                
                                    <input type="checkbox" class="filter-checkbox-input" name="Brand" value="Xiaomi">
                                    <p>Xiaomi</p>
                                    
                                </div>
                                <div class="filter-checkbox row-start pos-center">
                                
                                    <input type="checkbox" class="filter-checkbox-input" name="Brand" value="Morris">
                                    <p>Morris</p>
                                    
                                </div>
                                
                                
                            </div>
                            
                            
                    
                        </div>
                    
                    
                        <?php
                            echo PrintFilterElems($_GET['name']);
                        ?>
                    
                    
                        <div class="column pos-center">
                            
                            <div class="filters-part4 column">
                        
                            <div class="filter-name"><p><strong>Мощность, Вт</strong></p></div>
                            <div class="filter-body">
                                
                                <div class="filtering-price row">
                    
                                    <div class="price-from column">
                                        <p>От</p>
                                        <input type="number" step="5" min="0" class="price-input" name="power">
                                    </div>
                        
                                    <div class="price-from column">
                                        <p>До</p>
                                        <input type="number" step="5" min="0" class="price-input" name="power">
                                    </div>
                        
                                </div>
                                
                            </div>
                    
                            </div> 
                    
                            <div class="filters-part4 column">
                        
                            <div class="filter-name"><p><strong>Цена, ₸</strong></p></div>
                            <div class="filter-body">
                                
                                <div class="filtering-price row">
                    
                                    <div class="price-from column">
                                        <p>От</p>
                                        <input type="number" step="50" min="0" class="price-input" name="price">
                                    </div>
                        
                                    <div class="price-from column">
                                        <p>До</p>
                                        <input type="number" step="50" min="0" class="price-input" name="price">
                                    </div>
                        
                                </div>
                                
                            </div>
                    
                            </div>
                            
                            <button id="button-mid" type="button" onclick="filterStart()">Применить</button>
                        
                        </div>
                    
                        
                        
                </div>
                
                
                
                
                
                
<!--
                
-->
                
            
                <div class="popular-items-parent-2">
                

                    <div class="popular-items-2">
                        
                        
                                    
                                    
                    </div>

                
                </div><br><br>
                
                <div class="row-center pos-center">
                
                    <div class="pagination">
                    
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
            serverQuery();
        </script>
	</body>
</html>