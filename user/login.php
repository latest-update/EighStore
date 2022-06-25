<?php
$backRoute = '../';
include $backRoute.'Template/Header.php';
require_once $backRoute.'Core/connect.php';

$err = '';
//Стартуем сессию:
session_start(); 


if (empty($_SESSION['auth']) or $_SESSION['auth'] == false) {
		//Проверяем, не пустые ли нужные нам куки...
    if (!empty($_COOKIE["LOGIN"]) and !empty($_COOKIE["KEY"]) ) {
        
			//Пишем логин и ключ из КУК в переменные (для удобства работы):
        $id = $_COOKIE['ID'];
        $login = $_COOKIE['LOGIN']; 
        $key = $_COOKIE['KEY']; //ключ из кук (аналог пароля, в базе поле cookie)

			/*
				Формируем и отсылаем SQL запрос:
				ВЫБРАТЬ ИЗ таблицы_users ГДЕ поле_логин = $login.
			*/
        $query = 'SELECT * FROM `users` WHERE `LOGIN`="'.$login.'" AND `PASSWORD`="'.$key.'"';

			//Ответ базы запишем в переменную $result:
        $data = mysqli_fetch_assoc(mysqli_query($connect, $query)); 

			//Если база данных вернула не пустой ответ - значит пара логин-ключ_к_кукам подошла...
        if (!empty($data)) {
				//Стартуем сессию:
            

				//Пишем в сессию информацию о том, что мы авторизовались:
            $_SESSION['auth'] = true; 
            $_SESSION['flag'] = $data['FLAG'];
            $_SESSION['user'] = $data['LOGIN'];
            $_SESSION['name'] = $data['NAME'];
            $_SESSION['surname'] = $data['SURNAME'];
            $_SESSION['id'] = $data['LOCAL-ID'];
            $_SESSION['phone'] = $data['PHONE'];
            $_SESSION['picture'] = $data['PICTURE'];
            $_SESSION['email'] = $data['EMAIL'];
				/*
					Пишем в сессию логин и id пользователя
					(их мы берем из переменной $user!):
				*/
            
				//Тут можно добавить перезапись куки, см. ниже объяснение.
        }   
    } 
} elseif($_SESSION['auth'] == true) {
    if($_SESSION['flag'] == 'ADMIN'){
        header("Location: ../admin/");
    } elseif($_SESSION['flag'] == 'USER') {
        header("Location: index.php");
    }
}






// Страница авторизации


if(isset($_POST['submit'])){
    // Вытаскиваем из БД запись, у которой логин равняеться введенному
    $query = mysqli_query($connect, "SELECT * FROM `users` WHERE `LOGIN` = '".mysqli_real_escape_string($connect,mb_strtolower($_POST['login']))."' LIMIT 1");
    $data = mysqli_fetch_assoc($query);
    
    // Сравниваем пароли
    if($data['PASSWORD'] === md5(md5(trim($_POST['password']))))
    {
        
        
        // Ставим куки
        setcookie("ID", $data['LOCAL-ID'], time() + 3600, "/");
        setcookie("LOGIN", $data['LOGIN'], time() + 3600, "/");
        setcookie("KEY", $data['PASSWORD'], time() + 3600, "/");
        
        
        
		//Пишем в сессию информацию о том, что мы авторизовались:
		$_SESSION['auth'] = true;
        $_SESSION['flag'] = $data['FLAG'];
        $_SESSION['user'] = $data['LOGIN'];
        $_SESSION['name'] = $data['NAME'];
        $_SESSION['surname'] = $data['SURNAME'];
        $_SESSION['id'] = $data['LOCAL-ID'];
        $_SESSION['phone'] = $data['PHONE'];
        $_SESSION['picture'] = $data['PICTURE'];
        $_SESSION['email'] = $data['EMAIL'];
        
        

        // Переадресовываем браузер на страницу проверки нашего скрипта
        if($_SESSION['flag'] == 'ADMIN'){
            header("Location: ../admin/");
        } elseif($_SESSION['flag'] == 'USER') {
            header("Location: index.php");
        }
        exit();
    }
    else
    {
        $err = 'Вы ввели неправильный логин/пароль';
    }
}






?>
<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="utf-8">
        <meta name="viewport" content="width=806">
		<title>EIGHSTORE - Войти</title>
        <link rel="shortcut icon" href="../icons/favicon.svg" type="image/x-icon">
		<link href="../style.css<? echo $style ?>" rel="stylesheet">
        <link href="../flex.css<? echo $flex ?>" rel="stylesheet">
        <script src="../header.js<? echo $script ?>"></script>
        
        
	</head>

	<body>
        <!--                 Header                -->  
        <?php
            include $backRoute.'Template/HeaderHtml.php';
            headershow('', 0, '');
        ?>
        <!--                 Header                -->  
        
<!--                 Main Content               -->           
        <div class="eigh-main-content">
        
               <div class="login-block-container">
            
                <div class="login-block-login column pos-center">
                    <h1>Войти</h1>
                    <div class="login-social-m row-between">
                        <div class="social-m-circle row-center pos-center"><img src="<? echo $SiteUrl ?>icons/google-login.svg" width="16"></div>
                        <div class="social-m-circle row-center pos-center"><img src="<? echo $SiteUrl ?>icons/facebook-login.svg" width="16"></div>
                        <div class="social-m-circle row-center pos-center"><img src="<? echo $SiteUrl ?>icons/telegram-login.svg" width="16"></div>
                    </div>
                    <p>или</p>
                    <form method="post">
                        <br>
                        <input type="text" placeholder="Логин" class="input-login" name="login" maxlength="11" required><br><br>
                        <input type="password" placeholder="Пароль" class="input-login" name="password" required><br><br>
                        <div class="row-center"><button id="button-login" type="submit" name="submit">Войти</button></div><br>
                        <a href="#"><p>Забыли пароль?</p></a><br>
                        <h6 style="color: red"><? echo $err ?></h6>
                    </form>
                    
                </div>
                
                <div class="login-block-info column-center">
                
                    <div class="sign-in-info column-between pos-center">
                    
                        <h2 style="color: white;">Добро пожаловать</h2>
                        <h5 style="color: white;">Регистрируйтесь на нашем <br> сайте и продолжайте покупки</h5>
                        <a href="register"><button id="button-signin" style="">Регистрироваться</button></a>
                    </div>
                
                </div>
            
            </div>
            
        </div>
<!--                 Main Content               -->           
        
        <!--   Bottom   -->
        <?php
            printBottom($backRoute);
        ?>
        <!--   Bottom   -->
        
	</body>
</html>