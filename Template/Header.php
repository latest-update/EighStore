<?php 

function printHeader($connect, $SiteUrl){
    $get_categories_name = mysqli_query($connect, "SELECT `CATEGORY-NAME`, `CATEGORY-IMAGE` FROM `category` GROUP BY `CATEGORY-NAME`, `CATEGORY-IMAGE` HAVING count(*)>=1");
    $get_categories_name = mysqli_fetch_all($get_categories_name);
    
    $categories_query = mysqli_query($connect, "SELECT * FROM `category`");
    $categories_query = mysqli_fetch_all($categories_query);
    ?>
    
        <div class="eigh-header-top row-start pos-center">
            
            <div class="eigh-header-logo row-center pos-center"><a href="<? echo $SiteUrl ?>"><p>EIGH<span>STORE</span></p></a></div>
                <div class="eigh-header-search row-start pos-center">
                    <a id="search_onoff"><div class="search-icon row-center pos-center"><img class="search-img" src="<? echo $SiteUrl ?>icons/search.svg"/></div></a>
                    <input class="search-field" type="search" placeholder="Поиск товаров, организации, категории ...">
                </div>
                <div id="header-catalog" class="eigh-header-catalog column-center"><a id="header-catalog-a" class="header-catalog-a row-center pos-center"  onclick="open_close_catalog()"><p>КАТАЛОГ</p><img class="arrow" id="arrow" src="<? echo $SiteUrl ?>icons/down.svg" width="16"></a></div>
                <div class="eigh-header-login column-center"><a class="row-center pos-center" href=""><p>ВОЙТИ</p></a></div>
                <div class="eigh-header-basket column-center"><a class="row-center pos-center" href=""><img class="basket" src="<? echo $SiteUrl ?>icons/basket.svg" width="24"/><span class="basket-counter">5</span></a></div>
            
            </div>
        
        <div id="search_bar_mobile" class="row-start pos-center" style="display: none">
            
            <div class="search-icon row-center pos-center"><img class="search-img-mobile" src="<? echo $SiteUrl ?>icons/search.svg"/></div>
            <input class="search-field-mobile" type="search" placeholder="Поиск товаров, организации, категории ...">
            
        </div>

        <div class="panel-left-bar">
            
                <a href="<? echo $SiteUrl ?>Admin/"><div class="left-bar-element row-center pos-center"><p>Домашняя страница</p></div></a>
                <a href=""><div class="left-bar-element row-center pos-center"><p>Пользователи</p></div></a>
                <a href="<? echo $SiteUrl ?>Admin/Products/"><div class="left-bar-element row-center pos-center"><p>Товары</p></div></a>
                <a href=""><div class="left-bar-element row-center pos-center"><p>Статистика</p></div></a>
                <a href=""><div class="left-bar-element row-center pos-center"><p>Настройки</p></div></a>
            
        </div>
        
        
        <div id="catalog" class="column" style="display: none">   
            <ul class="menu">
               
                
                
                <?php
                    $sampleshot = array();
                    foreach($get_categories_name as $category){ 
                        ?>
                <li class="menu__list"><a href="<? echo $SiteUrl ?>catalog.php?query=catalog&name=<? echo $category[0] ?>&type=all"><? echo $category[0] ?></a>
                    
                        <ul class="menu__drop">
                        <?php
                        foreach($categories_query as $subcategory){
                            if($category[0] === $subcategory[1] && !(in_array($subcategory[2], $sampleshot)) && $subcategory[2] != ''){
                                if($subcategory[3] != '' && $subcategory[3] != ' '){ 
                                    ?>
                                        <li class="menu__list_1"><a href="<? echo $SiteUrl ?>catalog.php?query=catalog&name=<? echo $category[0] ?>&type=<? echo $subcategory[2] ?>"><? echo $subcategory[2] ?></a>
                                                <ul class="menu__drop_1">
                                            <?php
                                        foreach($categories_query as $tmp_subcategory){
                                                    
                                        if($tmp_subcategory[2] == $subcategory[2] && $tmp_subcategory[1] == $category[0]){ ?>
                                                
                                                    <li><a href="<? echo $SiteUrl ?>catalog.php?query=catalog&name=<? echo $category[0] ?>&type=<? echo $subcategory[2] ?>&subtype=<? echo $tmp_subcategory[3] ?>"><? echo $tmp_subcategory[3] ?></a></li>
                        
                                            <?php
                                        }
                                    }
                                    ?>  </ul>
                                            </li>  <?php
                                    $sampleshot[] = $subcategory[2];
                                } else {
                                    ?>
                                    <li><a href="<? echo $SiteUrl ?>catalog.php?query=catalog&name=<? echo $category[0] ?>&type=<? echo $subcategory[2] ?>"><? echo $subcategory[2] ?></a></li>
                                    <?php
                                }
                            }
                        }
                        ?> </ul></li>  <?php
                    }
                ?>
                
        <li><a href="#">Посмотреть все</a></li>     
      </ul>
            
        </div>
        
        <!--                 MOBILE CATALOG                -->  
        <div id="catalog_m" class="column" style="display: none">
            
                <?php
                    $delim = 0;
                    $countofcat = count($get_categories_name);
                    for($i = 0; $i < $countofcat; $i++){ 
                        if($delim == 0){
                            echo '<div id="mobile_category_el_parent" class="row-between">';
                        }
                        echo '<a href="#" onclick="open_sub_cat(\'sub'.($i+1).'\');"><div id="mobile_category_element" class="column"><p id="subscript">'.$get_categories_name[$i][0].'</p><img src="'.$SiteUrl.$get_categories_name[$i][1].'" id="category_el_m_img"></div></a>';
                        if($delim == 2 || (($countofcat-1) == $i)){
                            echo '</div>';
                            $delim = 0;
                        } else {
                            $delim++;
                        }
                    }
                ?>
            
        
        </div>
        
        <div id="catalog_m_sub" class="column" style="display: none; margin-top: 130px;">
        <a id="id900" href="#" onclick="open_sub_cat('sub1');"><div id="main_catalog_link"><img class="main_catalog_link_arrow img-right" src="<? echo $SiteUrl ?>icons/down.svg">Главное меню</div></a>
            
            <?php
                $sampleshot = array();
                $subsublist = array();
                $counter = 0;
                $markforsubsub = 1;
                foreach($get_categories_name as $category){
                    ?> 
                    <ul id="sub<? echo ($counter+1) ?>" class="subcategory" style="display: none">
                    <?php
                    foreach($categories_query as $subcategory){
                        if($category[0] === $subcategory[1] && !(in_array($subcategory[2], $sampleshot))){
                            if($subcategory[3] != '' && $subcategory[3] != ' '){
                                ?>
                                <a class="row-between pos-center" href="#" onclick="open_subsub_cat('subsub<? echo $markforsubsub; ?>', 'subsub', 'sub<? echo ($counter+1) ?>');"><li><? echo $subcategory[2] ?></li><img class="main_catalog_link_sub main_catalog_link_arrow img-left" src="<? echo $SiteUrl ?>icons/down.svg"></a>
                                <?php
                                    $tmpshit = '<ul id="subsub'.$markforsubsub.'" class="subcategory" style="display: none">';
                                        foreach($categories_query as $tmp_subcategory){
                                                    
                                            if($tmp_subcategory[2] == $subcategory[2] && $tmp_subcategory[1] == $category[0]){ 
                                                
                                                $tmpshit .= '<li><a href="'.$SiteUrl.'catalog.php?query=catalog&name='.$category[0].'&type='.$subcategory[2].'&subtype='.$tmp_subcategory[3].'">'.$tmp_subcategory[3].'</a></li>';
                                            
                                            }
                                        }
                                    $tmpshit .= '</ul>';
                                    $subsublist[] = $tmpshit;
                                ?> 
                                <?php
                                    $sampleshot[] = $subcategory[2];
                            } else {
                                ?>
                                <li><a href="<? echo $SiteUrl ?>catalog.php?query=catalog&name=<? echo $category[0] ?>&type=<? echo $subcategory[2] ?>"><? echo $subcategory[2] ?></a></li>
                                <?php
                            } $markforsubsub++;
                        }
                    }
                    ?>
                    </ul> 
                        <?php
                    $counter++;
                }
            ?>

        
        </div>
        

        <div id="catalog_m_subsub" class="column" style="display: none; margin-top: 130px;">
            <a href="#" id="id777" onclick="open_subsub_cat('subsub2', 'main', 'empty');"><div id="main_catalog_link"><img class="main_catalog_link_arrow img-right" src="icons/down.svg">Главное меню</div></a>
        <a href="#" id="back__link" onclick="open_subsub_cat('', 'back', 'empty');"><div id="main_catalog_link"><img class="main_catalog_link_arrow img-mirror" src="<? echo $SiteUrl ?>icons/down.svg">Назад</div></a>
        
            <?php
                
                foreach($subsublist as $list){
                    echo $list;
                }
                
                ?>
            
        </div>
        <!--                 MOBILE CATALOG                -->

    <?php
}


function printAdminHeader($preword){
    
    echo '<div class="eigh-header-top row-start pos-center">
            
                <div class="eigh-header-logo row-center pos-center"><p>EIGH<span>STORE</span></p></div>
                <div class="eigh-header-search row-start pos-center">
                    <a id="search_onoff"><div class="search-icon row-center pos-center"><img class="search-img" src="'.$preword.'icons/search.svg"/></div></a>
                    <input class="search-field" type="search" placeholder="Поиск товаров, организации, категории ...">
                </div>
                <div id="header-catalog" class="eigh-header-catalog column-center"><a id="header-catalog-a" class="header-catalog-a row-center pos-center"  onclick="open_close_catalog()"><p>КАТАЛОГ</p><img class="arrow" id="arrow" src="'.$preword.'icons/down.svg" width="16"></a></div>
                <div class="eigh-header-login column-center"><a class="row-center pos-center" href=""><p>ВОЙТИ</p></a></div>
                <div class="eigh-header-basket column-center"><a class="row-center pos-center" href=""><img class="basket" src="'.$preword.'icons/basket.svg" width="24"/><span class="basket-counter">5</span></a></div>
            
            </div>
        
        <div id="search_bar_mobile" class="row-start pos-center" style="display: none">
            
            <div class="search-icon row-center pos-center"><img class="search-img-mobile" src="icons/search.svg"/></div>
            <input class="search-field-mobile" type="search" placeholder="Поиск товаров, организации, категории ...">
            
        </div>
        
        <div class="panel-left-bar">
            
                <a href="'.$preword.'Admin/index.php"><div class="left-bar-element row-center pos-center"><p>Домашняя страница</p></div></a>
                <a href=""><div class="left-bar-element row-center pos-center"><p>Пользователи</p></div></a>
                <a href="'.$preword.'Admin/Products/index.php"><div class="left-bar-element row-center pos-center"><p>Товары</p></div></a>
                <a href=""><div class="left-bar-element row-center pos-center"><p>Статистика</p></div></a>
                <a href=""><div class="left-bar-element row-center pos-center"><p>Настройки</p></div></a>
            
        </div>
        
        
         
        <div id="catalog" class="column" style="display: none">   
            
            <ul class="menu">
        <li class="menu__list"><a href="'.$preword.'catalog.php?query=catalog&name=Лампы&type=all">Лампы</a>
          <ul class="menu__drop">
            <li><a href="'.$preword.'catalog.php?query=catalog&name=Лампы&type=Люминесцентные">Люминесцентные</a></li>
            <li><a href="'.$preword.'catalog.php?query=catalog&name=Лампы&type=Накаливание">Накаливание</a></li>
            <li><a href="'.$preword.'catalog.php?query=catalog&name=Лампы&type=Светодиодные">Светодиодные</a></li>
            <li><a href="'.$preword.'catalog.php?query=catalog&name=Лампы&type=Галогенные">Галогенные</a></li>
            <li><a href="'.$preword.'catalog.php?query=catalog&name=Лампы&type=Энергосберегающие">Энергосберегающие</a></li>
          </ul>
        </li>
        <li><a href="#">Прожектора</a></li>
        <li class="menu__list"><a href="#">Панели</a>
          <ul class="menu__drop">
            <li class="menu__list_1"><a href="#">Подпункт 1</a>
                <ul class="menu__drop_1">
                    <li><a href="#">Подпункт 1</a></li>
                    <li><a href="#">Подпункт 2</a></li>
                    <li><a href="#">Подпункт 3</a></li>
                    <li><a href="#">Подпункт 4</a></li>
                    <li><a href="#">Подпункт 5</a></li>
                </ul>
              </li>
            <li><a href="#">Подпункт 2</a></li>
            <li><a href="#">Подпункт 3</a></li>
            <li><a href="#">Подпункт 4</a></li>
            <li><a href="#">Подпункт 5</a></li>
          </ul>
        </li>
        <li><a href="#">Розетки</a></li>
        <li class="menu__list"><a href="#">Светильники</a>
          <ul class="menu__drop">
            <li><a href="#">Подпункт 1</a></li>
            <li><a href="#">Подпункт 2</a></li>
            <li><a href="#">Подпункт 3</a></li>
            <li><a href="#">Подпункт 4</a></li>
            <li><a href="#">Подпункт 5</a></li>
          </ul>
        </li>
        <li class="menu__list"><a href="#">Выключатели</a>
          <ul class="menu__drop">
            <li><a href="#">Подпункт 1</a></li>
            <li><a href="#">Подпункт 2</a></li>
            <li><a href="#">Подпункт 3</a></li>
            <li><a href="#">Подпункт 4</a></li>
            <li><a href="#">Подпункт 5</a></li>
          </ul>
        </li>
        <li><a href="#">Посмотреть все</a></li>     
      </ul>
            
        </div>
        
        <!--                 MOBILE CATALOG                -->  
        <div id="catalog_m" class="column" style="display: none">
            
                <div id="mobile_category_el_parent" class="row-between">
                
                    <a href="#" onclick="open_sub_cat(\'sub1\');"><div id="mobile_category_element" class="column"><p id="subscript">Лампы</p><img src="imgs/lamp.png" id="category_el_m_img"></div></a>
                    
                    <a href="#" onclick="open_sub_cat(\'sub2\');"><div id="mobile_category_element" class="column"><p id="subscript">Прожектора</p><img src="imgs/projector.png" id="category_el_m_img"></div></a>
                    
                    <a href="#" onclick="open_sub_cat(\'sub3\');"><div id="mobile_category_element" class="column"><p id="subscript">Панели</p><img src="imgs/ledpanel.png" id="category_el_m_img"></div></a>
                
                </div>
                
                <div id="mobile_category_el_parent" class="row-between">
                
                    <a href="#" onclick="open_sub_cat(\'sub1\');"><div id="mobile_category_element" class="column"><p id="subscript">Розетки</p><img src="imgs/rozetka.png" id="category_el_m_img"></div></a>
                    
                    <a href="#" onclick="open_sub_cat(\'sub2\');"><div id="mobile_category_element" class="column"><p id="subscript">Светильники</p><img src="imgs/svetilnik.png" id="category_el_m_img"></div></a>
                    
                    <a href="#" onclick="open_sub_cat(\'sub3\');"><div id="mobile_category_element" class="column"><p id="subscript">Выключатели</p><img src="imgs/vyklyiuchatel.png" id="category_el_m_img"></div></a>
                
                </div>
            
                <div id="mobile_category_el_parent" class="row-between">
                
                    <a href="#" onclick="open_sub_cat(\'sub1\');"><div id="mobile_category_element" class="column"><p id="subscript">Посмотреть все</p><img src="imgs/viewall.png" id="category_el_m_img"></div></a>
                    
                </div>
        
        </div>
        
        <div id="catalog_m_sub" class="column" style="display: none; margin-top: 130px;">
        <a id="id900" href="#" onclick="open_sub_cat(\'sub1\');"><div id="main_catalog_link"><img class="main_catalog_link_arrow img-right" src="icons/down.svg">Главное меню</div></a>
            <ul id="sub1" class="subcategory" style="display: none">
                <li><a href="'.$preword.'catalog.php?query=catalog&name=Лампы&type=Люминесцентные">Люминесцентные</a></li>
                <li><a href="'.$preword.'catalog.php?query=catalog&name=Лампы&type=Накаливание">Накаливание</a></li>
                <li><a href="'.$preword.'catalog.php?query=catalog&name=Лампы&type=Светодиодные">Светодиодные</a></li>
                <li><a href="'.$preword.'catalog.php?query=catalog&name=Лампы&type=Галогенные">Галогенные</a></li>
                <li><a href="'.$preword.'catalog.php?query=catalog&name=Лампы&type=Энергосберегающие">Энергосберегающие</a></li>
            </ul>
            
            <ul id="sub2" class="subcategory" style="display: none">
                <li><a href="#">Подпункт 1 of 2</a></li>
                <a href="#"><li>Подпункт 2</li></a>
                <a href="#"><li>Подпункт 3</li></a>
                <a href="#"><li>Подпункт 4</li></a>
                <a href="#"><li>Подпункт 5</li></a>
            </ul>
            
            <ul id="sub3" class="subcategory" style="display: none">
                <!--  open_subsub_cat(\'Открыть подпункт, принимает айди подпункта\', \'если subsub - открыть подпункт, main-главное меню, back-назад\', \'имя этого пункта т.е sub3\')                 -->     
                <a class="row-between pos-center" href="#" onclick="open_subsub_cat(\'subsub1\', \'subsub\', \'sub3\');"><li>Подпункт 1 of 3</li><img class="main_catalog_link_sub main_catalog_link_arrow img-left" src="icons/down.svg"></a>
                <a href="#"><li>Подпункт 2</li></a>
                <a href="#"><li>Подпункт 3</li></a>
                <a href="#"><li>Подпункт 4</li></a>
                <a href="#"><li>Подпункт 5</li></a>
            </ul>
        
        </div>
        
        <div id="catalog_m_subsub" class="column" style="display: none; margin-top: 130px;">
        <a href="#" onclick="open_subsub_cat(\'subsub1\', \'main\', \'empty\');"><div id="main_catalog_link"><img class="main_catalog_link_arrow img-right" src="icons/down.svg">Главное меню</div></a>
        <a href="#" id="back__link" onclick="open_subsub_cat(\'\', \'back\', \'empty\');"><div id="main_catalog_link"><img class="main_catalog_link_arrow img-mirror" src="icons/down.svg">Назад</div></a>
            
            <ul id="subsub1" class="subcategory" style="display: none">
                <li><a href="#">Подподпункт 1 of 1</a></li>
                <a href="#"><li>Подподпункт 2</li></a>
                <a href="#"><li>Подподпункт 3</li></a>
                <a href="#"><li>Подподпункт 4</li></a>
                <a href="#"><li>Подподпункт 5</li></a>
            </ul>
            
        
        </div>
        <!--                 MOBILE CATALOG                -->';
}


function printBottom($backRoute){
    echo '<div class="eigh-bottom">
        
            <div style="border-top: 1px solid #eee;">
                <div class="eigh-bottom-services container-mini">
            
                    <a href="#">Сервис</a>
                    <a href="#">Доставка</a>
                    <a href="#">Возврат</a>
                    <a href="#">Контакты</a>
                    <a href="#">Покупка</a>
                    <a href="#">Помощь</a>
                    <a href="#">Правила</a>
                    <a href="#">Оплата</a>
                    <a href="#">О нас</a>
                
                
                </div>
            </div>
            
            <div class="eigh-bottom-site-info row-center">
            
                <div class="eigh-bottom-info">
                
                    <div class="eigh-social-m column-between pos-center">
                    
                        <div class="social-m-link row-between">
                        
                            <a href="#"><img src="'.$backRoute.'icons/instagram.svg"></a>
                            <a href="#"><img src="'.$backRoute.'icons/whatsapp.svg"></a>
                            <a href="#"><img src="'.$backRoute.'icons/envelope.svg"></a>
                            <a href="#"><img src="'.$backRoute.'icons/facebook.svg"></a>
                        
                        </div>
                        
                        
                    
                    </div>
                    
                    <p class="id103">EIGH Studio 2021. All rights reserved</p>
                
                </div>
                
                
            
            </div>
            
            
        
        </div>';
}

?>