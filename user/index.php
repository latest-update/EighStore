<?php
session_start(); 
$backRoute = '../';
include $backRoute.'Template/Header.php';
require_once $backRoute.'Core/connect.php';
require_once $backRoute.'Core/checkAuth.php';
require_once $backRoute.'Core/checkFlagUser.php';
$username = $_SESSION['user'];

?>

<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="utf-8">
        <meta name="viewport" content="width=806">
		<title>EIGHSTORE - <? echo mb_strtoupper($username) ?></title>
        <link rel="shortcut icon" href="../icons/favicon.svg" type="image/x-icon">
		<link href="../style.css<? echo $style ?>" rel="stylesheet">
        <link href="../flex.css<? echo $flex ?>" rel="stylesheet">
        <script src="../header.js<? echo $script ?>"></script>
    
        
	</head>

	<body>
        <!--                 Header                -->  
        <?php
            include $backRoute.'Template/HeaderHtml.php';
            headershow($username, '', '');
        ?>
        <!--                 Header                -->  
        
<!--                 Main Content               -->           
        <div class="eigh-main-content">
        
            <div class="user-page-container">
            
            
                <div class="user-page-image row-center">
                
                    <div class="page-image-user-img">
                    
                        <img src="<? echo $backRoute.$_SESSION['picture'] ?>" id="user-img-elem">
                    
                    </div>
                
                </div><br><br>
                
                <div class="user-page-info row-between pos-center">
                
                    <div class="user-page-info-name">
                    
                        <h3><? echo $_SESSION['name'].' '.$_SESSION['surname'] ?></h3>
                    
                    </div>
                    
                    <div class="user-page-info-tel">
                    
                        <h3><? echo $_SESSION['phone'] ?></h3>
                    
                    </div>
                
                </div><br><br>
                
                <div class="user-page-main">
                    
                    <div class="user-page-main-elem">
                        <div class="elem-box column pos-center">
                        
                            <img src="<? echo $backRoute ?>icons/asterisk-2.svg" width="150">
                            <p>Избранные</p>
                        
                        </div> 
                        <div class="elem-box column pos-center">
                        
                            <img src="<? echo $backRoute ?>icons/user-bag.svg" width="150">
                            <p>Мои покупки</p>
                        
                        </div>
                        <div class="elem-box column pos-center">
                        
                            <img src="<? echo $backRoute ?>icons/user-truck.svg" width="150">
                            <p>Доставка</p>
                        
                        </div>
                        <div class="elem-box column pos-center">
                        
                            <img src="<? echo $backRoute ?>icons/user-coupon.svg" width="150">
                            <p>Купоны</p>
                        
                        </div>
                        <div class="elem-box column pos-center">
                        
                            <img src="<? echo $backRoute ?>icons/user-address.svg" width="150">
                            <p>Мои адреса</p>
                        
                        </div>
                        <div class="elem-box column pos-center">
                        
                            <img src="<? echo $backRoute ?>icons/user-headphone.svg" width="150">
                            <p>Поддержка</p>
                        
                        </div>
                        <a href="info"><div class="elem-box column pos-center">
                        
                            <img src="<? echo $backRoute ?>icons/user-settings.svg" width="150">
                            <p>Личная информация</p>
                        
                        </div></a>
                        <a href="logout"><div class="elem-box column pos-center">
                        
                            <img src="<? echo $backRoute ?>icons/user-logout.svg" width="150">
                            <p>Выйти из аккаунта</p>
                        
                        </div></a>
                    </div>
                
                </div>
            
            
            </div>           
             
        </div>
<!--                 Main Content               -->           
        <?php
            printBottom($backRoute);
        ?>
	</body>
</html>