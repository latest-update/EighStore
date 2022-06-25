var media_size;
window.onload = function () {
    switchClass();
    BasketCountRefresh();
};
window.onresize = function () {
    switchClass();
};

function switchClass() {
    let command = document.getElementById('header-catalog-a');
    let search_onoff = document.getElementById('search_onoff');
    media_size = parseInt(window.getComputedStyle(document.head, null).getPropertyValue('width'), 10);
    if(media_size < 991 && (command.getAttribute('onclick') != 'open_close_catalog_mobile()')) {
        command.setAttribute('onclick',  'open_close_catalog_mobile()');
        search_onoff.setAttribute('onclick', 'open_search_bar()');
    }
    else if(media_size > 991 && (command.getAttribute('onclick') != 'open_close_catalog()')){
        command.setAttribute('onclick',  'open_close_catalog()');
        document.getElementById("search_bar_mobile").style.display = "none";
        search_onoff.setAttribute('onclick', '');    
    } 
}

function open_search_bar(){
    let x = document.getElementById("search_bar_mobile");
    if(x.style.display === "none"){
        x.style.display = "flex";
        
    } else{
        x.style.display = "none";
    }
}


function open_close_catalog() {
        let x = document.getElementById("catalog");
        if(x.style.display === "none"){
            x.style.display = "flex";
            document.querySelectorAll('body :not(#catalog):not(#catalog_m):not(#header-catalog):not(.header-catalog-a):not(.header-catalog-a p):not(.arrow):not(.eigh-header-top)').forEach(element => element.style.filter = "blur(1px)");
            let nodes = document.getElementById('catalog');
            let th = nodes.getElementsByTagName("*");
            for(var i=0; i<th.length; i++) {
                th[i].style.filter = "blur(0)";
            }
            document.getElementById("header-catalog").style.borderBottom = "none";
            arrow.classList.toggle('rotate');
        } else{
            document.querySelectorAll("body :not(#catalog)").forEach(element => element.style.filter = "blur(0)");
            arrow.classList.toggle('rotate');
            x.style.display = "none";
            document.getElementById("header-catalog").style.borderBottom = "1px solid #eee";
        }
}
function open_close_catalog_mobile() {
        let y = document.getElementById("catalog_m");
        let z = document.getElementById("catalog_m_sub");
        let l = document.getElementById("catalog_m_subsub");
        if(y.style.display === "none" && z.style.display === "none" && l.style.display === "none"){
            y.style.display = "flex";
            arrow.classList.toggle('rotate');   
        } else{
            arrow.classList.toggle('rotate');
            y.style.display = "none";
            z.style.display = "none";
            let allel = z.children;
            for(let i = 0; i < allel.length; i++){
                allel[i].style.display = "none";
            }
            l.style.display = "none";
        }
   
}
function open_sub_cat(pinof){
    let parentEl = document.getElementById('catalog_m_sub');
    let parentCat = document.getElementById('catalog_m');
    let subCatEl = document.getElementById(pinof);
    
    if(parentEl.style.display === "none"){
        parentCat.style.display = "none";
        parentEl.style.display = "block";
        subCatEl.style.display = "block";
        document.getElementById('id900').style.display = "block";
    } else{
        let allel = parentEl.children;
        for(let i = 0; i < allel.length; i++){
            allel[i].style.display = "none";
        }
        parentCat.style.display = "flex";
        parentEl.style.display = "none";
    }
} 
function open_subsub_cat(pinof, mode, gp){
    let grandparentEl = document.getElementById('catalog_m_sub');
    let parentEl = document.getElementById('catalog_m_subsub');
    let parentCat = document.getElementById('catalog_m');
    let subsubCatEl = document.getElementById(pinof);
    
    
    if(parentEl.style.display === "none" && mode === "subsub"){
        parentCat.style.display = "none";
        grandparentEl.style.display = "none";
        parentEl.style.display = "block";
        subsubCatEl.style.display = "block";
        document.getElementById('main_catalog_link').style.display = "block";
        document.getElementById('back__link').style.display = "block";
        document.getElementById('id777').style.display = "block";
        document.getElementById('back__link').setAttribute('onclick', "open_subsub_cat('" + gp + "', 'back', 'empty');");
        document.getElementById('id777').setAttribute('onclick', "open_subsub_cat('" + pinof + "', 'main', 'empty');");
    } else if(mode === "back"){
        parentCat.style.display = "none";
        parentEl.style.display = "none";
        grandparentEl.style.display = "flex";
        subsubCatEl.style.display = "block";
        let allel = parentEl.children;
        for(let i = 0; i < allel.length; i++){
            allel[i].style.display = "none";
        }
    } else if(mode === "main"){
        parentCat.style.display = "flex";
        parentEl.style.display = "none";
        subsubCatEl.style.display = "none";
        let allel = grandparentEl.children;
        for(let i = 0; i < allel.length; i++){
            allel[i].style.display = "none";
        }
        
    }
} 

function desc_text_hidden_visiblity(){
    let text = document.getElementById("id110");
    let btn = document.getElementById("id111");
    if(text.style.height === "80px"){
        text.style.height = "100%";
        btn.innerHTML = " - Скрыть описание - ";
        btn.style.marginTop = "0";
    } else{
        text.style.height = "80px";
        btn.innerHTML = " - Показать полностью - ";
        btn.style.marginTop = "-5px";
    }
}


checked=false;

function addInBasket(id, name, count, price, image){
    
    var cartData = getCartData() || {}, itemId = id, itemTitle = name, itemCount = count, itemPrice = price, itemImage = image, itemSelected = true;
    
    if(cartData.hasOwnProperty(itemId)){ 
		
	} else { 
		cartData[itemId] = [itemId, itemTitle, itemCount, itemPrice, itemImage, itemSelected];
	}
    setCartData(cartData);
    BasketCountRefresh();
    CheckEveryProductInBasket();
    setTimeout(checkInBasket, 250, itemId);
	return false;
}

function CheckEveryProductInBasket(){
     var cartData = getCartData();
     for(var items in cartData){
         let tm = cartData[items][0];
         let sl = document.getElementById('prod-id-'+tm);
         if(sl != null){
              if(sl.value == tm){
                    document.getElementById('prod-'+tm).innerHTML = 'В корзине';   
                    document.getElementById('prod-'+tm).style.color = 'black';
                    let r = document.getElementById('prod-i'+tm);
                    if(r != null){
                        r.innerHTML = 'В корзине';
                        r.style.color = 'black';
                    }
              }
         }
                                
     }
}


function getCartData(){
	return JSON.parse(localStorage.getItem('cart'));
}
function setCartData(o){
	localStorage.setItem('cart', JSON.stringify(o));
}

function changeProductCount(elem, id){
    let inpElem = document.getElementById('countOf' + elem);
    var cartData = getCartData();
    cartData[id][2] = inpElem.value;
    setCartData(cartData);
    changeEventRefresher();
}

function changeEventRefresher(){
    var cartData = getCartData(), totalCount = 0, totalSum = 0, thsId = 0;
    
    let Count = Object.keys(cartData).length;
    let allSelected = 0;
    
    for(var items in cartData){
        let chk = document.getElementById('chk'+thsId);
        if(chk.checked){
            totalCount++;
            totalSum += cartData[items][2] * cartData[items][3];
            cartData[items][5] = true;
//            checked = true;
            allSelected++;
        } else {
            cartData[items][5] = false;
//            checked = false;
        }
        thsId++;
    }
    
    if(totalCount == 1){
        totalCountS = totalCount + " товар на сумму";
        document.getElementById('order-button').style.display = "flex";
    } else if(totalCount > 1){
        totalCountS = totalCount + " товара на сумму";
        document.getElementById('order-button').style.display = "flex";
    } else {
        totalCountS = "В корзине нету товара";
        document.getElementById('order-button').style.display = "none";
    }
    
    if(allSelected == Count){
        document.getElementById('checkall').checked = true;
        checked = true;
    } else {
        document.getElementById('checkall').checked = false;
        checked = false;
    }
        
    document.querySelector('#totalCountOfTop').innerHTML = `
        <h4>${totalCountS}</h4><h4 style="color: #278458">${totalSum}₸</h4> 
    `;
    setCartData(cartData);
}

function deleteFromBasket(id){
    var cartData = getCartData();
    delete cartData[id];
    setCartData(cartData);
    openCart('');
    BasketCountRefresh();
//    checkedAll();
}

function BasketCountRefresh(){
    var cartData = getCartData();
    var Count = Object.keys(cartData).length;
    document.querySelector('.basket-counter').innerHTML = Count;
}
function checkInBasket(id){
    var cartData = getCartData();
    let sga = document.getElementById('buy-clicked');
    if(sga != null){
        if(cartData.hasOwnProperty(id)){
            sga.innerHTML = 'В корзине';
            sga.onclick = '';
        }
    }
    
}

function openCart(e){
	
	var cartData = getCartData(), totalCount = 0, totalSum = 0, SumOf = 0;
	
	if(cartData !== null){

        document.querySelector('.basketCase').innerHTML = '';
        document.querySelector('.basketCase').innerHTML += `<div class="basket-all-info row-between pos-center"></div><br>`;
        let Count = Object.keys(cartData).length;
        let allSelected = 0;
		for(var items in cartData){
            let zs = '';
            if(cartData[items][5] == true){
                zs = 'checked';  
                allSelected++;
                totalSum += cartData[items][2] * cartData[items][3];
                totalCount++;
            } 
            
            document.querySelector('.basketCase').innerHTML += `

            <div class="basket-element row-between pos-center">
                    
                    <div style="margin: 0 0 0 50px"><input type="checkbox" name="chk${SumOf}" id="chk${SumOf}" onclick="checkedAllOff()" ${zs}></div>
                
                    <div class="category-product-info row-between">
                                
                                <div class="product-info-image">
                                    <img src="${cartData[items][4]}">
                                </div>
                                <div class="product-info-info column-around pos-center">
                                
                                    <a href="product?product=${cartData[items][0]}"><h4>${cartData[items][1]}</h4></a>
                                    
                                </div>
                                
                    </div>
                    
                    <div class="category-product-counts column-around pos-center">
                        <div style="margin-bottom: 10px"><h4>Цена: <span style="color: #278458">${cartData[items][3]}₸</span></h4></div>
                        <div class="row-between" style="">
                            <input type="number" value="${cartData[items][2]}" onchange="changeProductCount('${SumOf}', ${cartData[items][0]});" min="1" class="basket-count-input" id="countOf${SumOf}">
                            <h4>(шт)</h4>
                            
                        </div>
                    </div>
                    
                    
                    <a style="margin: 0 50px; cursor: pointer" style="" onclick="deleteFromBasket(${cartData[items][0]})">
                        <img class="search-img" src="icons/delete.svg">
                    </a>
                
                </div>

            `;
            SumOf++;
            
		}
        if(totalCount == 1){
            totalCountS = totalCount + " товар на сумму";
        } else if(totalCount > 1){
            totalCountS = totalCount + " товара на сумму";
        } else {
            totalCountS = "В корзине нету товара";
            document.getElementById('order-button').style.display = "none";
        }
        
        if(allSelected == Count){
            allSelected = 'checked';
            checked = true;
        } else {
            allSelected = '';
            checked = false;
        }
        
        document.querySelector('.basket-all-info').innerHTML = `
            <div style="margin: 0 0 0 50px" class="row pos-center"><input type='checkbox' name='checkall' onclick='checkedAll();' id="checkall" ${allSelected}><h4 style="margin: 0 0 0 10px">Выбрать все</h4></div>
                    <div></div> 
                    <div class="row-between pos-center" id="totalCountOfTop" style="width: 250px; margin-right: 50px;"><h4>${totalCountS}</h4><h4 style="color: #278458">${totalSum}₸</h4></div>  
        `;
	}
    
    
}

function changeElements(first, second){
    let ist = document.getElementById(first);
    let jst = document.getElementById(second);
    if(jst.style.display === "none"){
        ist.style.display = "none";
        jst.style.display = "block";
    } else {
        ist.style.display = "block";
        jst.style.display = "none";
    }
}












