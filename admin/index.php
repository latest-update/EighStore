<?php
session_start(); 
$backRoute = '../';
require_once $backRoute.'Core/connect.php';
require_once $backRoute.'Core/checkAuth.php';
require_once $backRoute.'Core/checkFlagAdmin.php';

?>

<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="utf-8">
        <meta name="viewport" content="width=806">
		<title>EIGHSTORE</title>
        <link rel="shortcut icon" href="../icons/favicon.svg" type="image/x-icon">
		<link href="../style.css<? echo $style ?>" rel="stylesheet">
        <link href="../flex.css<? echo $flex ?>" rel="stylesheet">
        <script src="../header.js<? echo $script ?>"></script>
    
        
	</head>

	<body>
        <!--                 Header                -->  
        <?php
            include $backRoute.'Template/HeaderHtml.php';
            $username = $_SESSION['user'];
            headershow($username, 0, '');
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
                        
                            <img src="<? echo $backRoute ?>icons/statistics.svg" width="150">
                            <p>Статистика</p>
                        
                        </div> 
                        <div class="elem-box column pos-center">
                        
                            <img src="<? echo $backRoute ?>icons/sells.svg" width="150">
                            <p>Продажи</p>
                        
                        </div>
                        <a href="orders/"><div class="elem-box column pos-center">
                        
                            <img src="<? echo $backRoute ?>icons/user-truck.svg" width="150">
                            <p>Заказы</p>
                        
                        </div></a>
                        <div class="elem-box column pos-center">
                        
                            <img src="<? echo $backRoute ?>icons/user-headphone.svg" width="150">
                            <p>Обращение пользователей</p>
                        
                        </div>
                        <div class="elem-box column pos-center">
                        
                            <img src="<? echo $backRoute ?>icons/users.svg" width="150">
                            <p>Пользователи</p>
                        
                        </div>
                        <a href="Products/"><div class="elem-box column pos-center">
                        
                            <img src="<? echo $backRoute ?>icons/products.svg" width="150">
                            <p>Товары и категории</p>
                        
                        </div></a>
                        <div class="elem-box column pos-center">
                        
                            <img src="<? echo $backRoute ?>icons/settings.svg" width="150">
                            <p>Настройки</p>
                        
                        </div>
                        <a href="../user/info"><div class="elem-box column pos-center">
                        
                            <img src="<? echo $backRoute ?>icons/user-settings.svg" width="150">
                            <p>Личная информация</p>
                        
                        </div></a>
                        <a href="../user/logout"><div class="elem-box column pos-center">
                        
                            <img src="<? echo $backRoute ?>icons/user-logout.svg" width="150">
                            <p>Выйти из аккаунта</p>
                        
                        </div></a>
                    </div>
                
                </div>
            
            
            </div>          
             
        </div>
<!--                 Main Content               -->           
        
	</body>
</html>