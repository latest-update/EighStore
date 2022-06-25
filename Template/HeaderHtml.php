<?php
        function headershow($as, $inbasket, $options){
    ?>        <div class="eigh-header-top row-start pos-center">
            
                <div class="eigh-header-logo row-center pos-center"><a href="http://eighstore-php-easier/"><p>EIGH<span id="span-img"><img width="22" src="http://eighstore-php-easier/icons/bio-energy.svg"></span><span>STORE</span></p></a></div>
                <div class="eigh-header-search row-start pos-center">
                    <a id="search_onoff"><div class="search-icon row-center pos-center"><img class="search-img" src="http://eighstore-php-easier/icons/search.svg"/></div></a>
                    <input class="search-field" type="search" placeholder="Поиск товаров, организации, категории ..." name="searchData">
                </div>
                <div id="header-catalog" class="eigh-header-catalog column-center"><a id="header-catalog-a" class="header-catalog-a row-center pos-center"  onclick="open_close_catalog()"><p>КАТАЛОГ</p><img class="arrow" id="arrow" src="http://eighstore-php-easier/icons/down.svg" width="16"></a></div>
            <div class="eigh-header-login column-center"><a class="row-center pos-center" href="http://eighstore-php-easier/user/login"><p><?php if($as != ''){echo mb_strtoupper($as);}else{echo 'ВОЙТИ';} ?></p></a></div>
                <div class="eigh-header-basket column-center"><a class="row-center pos-center" href="http://eighstore-php-easier/basket"><img class="basket" src="http://eighstore-php-easier/icons/basket.svg" width="24"/><span class="basket-counter"><?php if($inbasket != ''){echo $inbasket;}else{echo '';} ?></span></a></div>
            
            </div>
        <div id="search_bar_mobile" class="row-start pos-center" style="display: none">
            
            <div class="search-icon row-center pos-center"><img class="search-img-mobile" src="http://eighstore-php-easier/icons/search.svg"/></div>
            <input class="search-field-mobile" type="search" placeholder="Поиск товаров, организации, категории ...">
            
        </div>

        <?php 
            switch($options){
                case 'admin':
                    echo '<div class="panel-left-bar">
            
                            <a href="http://eighstore-php-easier/admin/"><div class="left-bar-element row-center pos-center"><p>Домашняя страница</p></div></a>
                            <a href=""><div class="left-bar-element row-center pos-center"><p>Пользователи</p></div></a>
                            <a href="http://eighstore-php-easier/admin/Products/"><div class="left-bar-element row-center pos-center"><p>Товары</p></div></a>
                            <a href=""><div class="left-bar-element row-center pos-center"><p>Статистика</p></div></a>
                            <a href=""><div class="left-bar-element row-center pos-center"><p>Настройки</p></div></a>
                            <a href="http://eighstore-php-easier/user/info"><div class="left-bar-element row-center pos-center"><p>Личная информация</p></div></a>
                            <a href="http://eighstore-php-easier/user/logout"><div class="left-bar-element row-center pos-center"><p>Выйти</p></div></a>
                        </div>';
                    break;
                case 'user':
                    echo '<div class="panel-left-bar">
            
                            <a href="http://eighstore-php-easier/user/"><div class="left-bar-element row-center pos-center"><p>Домашняя страница</p></div></a>
                            <a href=""><div class="left-bar-element row-center pos-center"><p>Мои покупки</p></div></a>
                            <a href="http://eighstore-php-easier/user/favorites"><div class="left-bar-element row-center pos-center"><p>Избранные</p></div></a>
                            <a href=""><div class="left-bar-element row-center pos-center"><p>Статистика</p></div></a>
                            <a href=""><div class="left-bar-element row-center pos-center"><p>Настройки</p></div></a>
                            <a href="http://eighstore-php-easier/user/logout"><div class="left-bar-element row-center pos-center"><p>Выйти</p></div></a>
            
                        </div>';
                    break; 
                case 'user-setting':
                    echo '<div class="panel-left-bar" id="panel-left-bar-only-desktop">
            
                            <a href="http://eighstore-php-easier/user/"><div class="left-bar-element row-center pos-center"><p>Домашняя страница</p></div></a>
                            <a href="http://eighstore-php-easier/user/info"><div class="left-bar-element row-center pos-center"><p>Личная информация</p></div></a>
                            <a href=""><div class="left-bar-element row-center pos-center"><p>Доставки</p></div></a>
                            <a href=""><div class="left-bar-element row-center pos-center"><p>Мои адреса</p></div></a>
                            <a href=""><div class="left-bar-element row-center pos-center"><p>Мои покупки</p></div></a>
            
                        </div>';
                    break;    
                default: 
                    echo '';
            }
            ?>        
        
        <div id="catalog" class="column" style="display: none">   
            <ul class="menu">
               
                
                
                                <li class="menu__list"><a href="http://eighstore-php-easier/catalog.php?query=catalog&name=Лампы&type=all">Лампы</a>
                    
                        <ul class="menu__drop">
                                                            <li><a href="http://eighstore-php-easier/catalog.php?query=catalog&name=Лампы&type=Светодиодные">Светодиодные</a></li>
                                                                        <li><a href="http://eighstore-php-easier/catalog.php?query=catalog&name=Лампы&type=Накаливание">Накаливание</a></li>
                                                                        <li><a href="http://eighstore-php-easier/catalog.php?query=catalog&name=Лампы&type=Люминесцентные">Люминесцентные</a></li>
                                                                        <li><a href="http://eighstore-php-easier/catalog.php?query=catalog&name=Лампы&type=Галогенные">Галогенные</a></li>
                                                                        <li><a href="http://eighstore-php-easier/catalog.php?query=catalog&name=Лампы&type=Энергосберегающие">Энергосберегающие</a></li>
                                                                        <li><a href="http://eighstore-php-easier/catalog.php?query=catalog&name=Лампы&type=Лайт">Лайт</a></li>
                                                                        <li><a href="http://eighstore-php-easier/catalog.php?query=catalog&name=Лампы&type=Daryn">Daryn</a></li>
                                     </ul></li>                  <li class="menu__list"><a href="http://eighstore-php-easier/catalog.php?query=catalog&name=Прожектора&type=all">Прожектора</a>
                    
                        <ul class="menu__drop">
                                                            <li><a href="http://eighstore-php-easier/catalog.php?query=catalog&name=Прожектора&type=Металлогалогенные">Металлогалогенные</a></li>
                                                                        <li><a href="http://eighstore-php-easier/catalog.php?query=catalog&name=Прожектора&type=Натриевые">Натриевые</a></li>
                                                                        <li><a href="http://eighstore-php-easier/catalog.php?query=catalog&name=Прожектора&type=Светодиодные">Светодиодные</a></li>
                                                                        <li><a href="http://eighstore-php-easier/catalog.php?query=catalog&name=Прожектора&type=Галогенные">Галогенные</a></li>
                                     </ul></li>                  
        <li><a href="#">Посмотреть все</a></li>     
      </ul>
            
        </div>
        
        <!--                 MOBILE CATALOG                -->  
        <div id="catalog_m" class="column" style="display: none">
            
                <div id="mobile_category_el_parent" class="row-between"><a href="#" onclick="open_sub_cat('sub1');"><div id="mobile_category_element" class="column"><p id="subscript">Лампы</p><img src="http://eighstore-php-easier/imgs/lamp.png" id="category_el_m_img"></div></a><a href="#" onclick="open_sub_cat('sub2');"><div id="mobile_category_element" class="column"><p id="subscript">Прожектора</p><img src="http://eighstore-php-easier/imgs/projector.png" id="category_el_m_img"></div></a></div>            
        
        </div>
        
        <div id="catalog_m_sub" class="column" style="display: none; margin-top: 130px;">
        <a id="id900" href="#" onclick="open_sub_cat('sub1');"><div id="main_catalog_link"><img class="main_catalog_link_arrow img-right" src="http://eighstore-php-easier/icons/down.svg">Главное меню</div></a>
            
             
                    <ul id="sub1" class="subcategory" style="display: none">
                                                    <li><a href="http://eighstore-php-easier/catalog.php?query=catalog&name=Лампы&type=Светодиодные">Светодиодные</a></li>
                                                                <li><a href="http://eighstore-php-easier/catalog.php?query=catalog&name=Лампы&type=Накаливание">Накаливание</a></li>
                                                                <li><a href="http://eighstore-php-easier/catalog.php?query=catalog&name=Лампы&type=Люминесцентные">Люминесцентные</a></li>
                                                                <li><a href="http://eighstore-php-easier/catalog.php?query=catalog&name=Лампы&type=Галогенные">Галогенные</a></li>
                                                                <li><a href="http://eighstore-php-easier/catalog.php?query=catalog&name=Лампы&type=Энергосберегающие">Энергосберегающие</a></li>
                                                                <li><a href="http://eighstore-php-easier/catalog.php?query=catalog&name=Лампы&type=Лайт">Лайт</a></li>
                                                                <li><a href="http://eighstore-php-easier/catalog.php?query=catalog&name=Лампы&type=Daryn">Daryn</a></li>
                                                    </ul> 
                         
                    <ul id="sub2" class="subcategory" style="display: none">
                                                    <li><a href="http://eighstore-php-easier/catalog.php?query=catalog&name=Прожектора&type=Металлогалогенные">Металлогалогенные</a></li>
                                                                <li><a href="http://eighstore-php-easier/catalog.php?query=catalog&name=Прожектора&type=Натриевые">Натриевые</a></li>
                                                                <li><a href="http://eighstore-php-easier/catalog.php?query=catalog&name=Прожектора&type=Светодиодные">Светодиодные</a></li>
                                                                <li><a href="http://eighstore-php-easier/catalog.php?query=catalog&name=Прожектора&type=Галогенные">Галогенные</a></li>
                                                    </ul> 
                        
        
        </div>
        

        <div id="catalog_m_subsub" class="column" style="display: none; margin-top: 130px;">
            <a href="#" id="id777" onclick="open_subsub_cat('subsub2', 'main', 'empty');"><div id="main_catalog_link"><img class="main_catalog_link_arrow img-right" src="icons/down.svg">Главное меню</div></a>
        <a href="#" id="back__link" onclick="open_subsub_cat('', 'back', 'empty');"><div id="main_catalog_link"><img class="main_catalog_link_arrow img-mirror" src="http://eighstore-php-easier/icons/down.svg">Назад</div></a>
        
                        
        </div>
        <!--                 MOBILE CATALOG                -->

<?php
}
?>