<?php
$backRoute = '../';
include $backRoute.'Template/Header.php';
require_once $backRoute.'Core/connect.php';
$errs = '';

// Страница регистрации нового пользователя

if(isset($_POST['submit']))
{
    $err = [];
    $login = mb_strtolower($_POST['login']);
    $phone = $_POST['phone'];
    $email = mb_strtolower($_POST['email']);
    $name  = $_POST['name'];
    $surname =$_POST['surname'];
    $password = $_POST['password'];
    
    // проверям логин
    if(!preg_match("/^[a-zA-Z0-9]+$/",$login))
    {
        $err[] = "Логин может состоять только из букв английского алфавита и цифр";
    }

    if(strlen($login) < 6 or strlen($login) > 11)
    {
        $err[] = "Логин должен быть не меньше 6-х символов и не больше 12";
    }

    $query0 = mysqli_query($connect, "SELECT `LOCAL-ID` FROM `users` WHERE `LOGIN`='".mysqli_real_escape_string($connect, $login)."'");
    $query1 = mysqli_query($connect, "SELECT `LOCAL-ID` FROM `users` WHERE `EMAIL`='".mysqli_real_escape_string($connect, $email)."'"); 
    $query2 = mysqli_query($connect, "SELECT `LOCAL-ID` FROM `users` WHERE `PHONE`='".mysqli_real_escape_string($connect, $phone)."'");
    // проверяем, не сущестует ли пользователя с таким именем
    
    if(mysqli_num_rows($query0) > 0)
    {
        $err[] = "Пользователь с таким логином уже существует";
    }
    if(mysqli_num_rows($query1) > 0)
    {
        $err[] = "Пользователь с таким почтой уже существует";
    }
    if(mysqli_num_rows($query2) > 0)
    {
        $err[] = "Пользователь с таким номером телефона уже существует";
    }
    // Если нет ошибок, то добавляем в БД нового пользователя
    if(count($err) == 0)
    {
        
        // Убераем лишние пробелы и делаем двойное хеширование
        $password = md5(md5(trim($password)));
        
        mysqli_query($connect, "INSERT INTO `users` (`LOCAL-ID`, `SN-ID`, `LOGIN`, `PASSWORD`, `EMAIL`, `NAME`, `SURNAME`, `PICTURE`, `PHONE`, `BASKET-ID`, `FLAG`) VALUES (NULL, NULL, '$login', '$password', '$email', '$name', '$surname', 'Data/User/Default/user.svg', '$phone', NULL, 'USER')");
        header("Location: login.php");
    }
    else
    {
         
    }
}

session_start();

if($_SESSION['auth'] == true) {
    header("Location: ../admin/");
}



?>
<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="utf-8">
        <meta name="viewport" content="width=806">
		<title>EIGHSTORE - Регистрация</title>
        <link rel="shortcut icon" href="../icons/favicon.svg" type="image/x-icon">
		<link href="../style.css<? echo $style ?>" rel="stylesheet">
        <link href="../flex.css<? echo $flex ?>" rel="stylesheet">
        <script src="../header.js<? echo $script ?>"></script>
        <style>
            .login-block-login, .login-block-info{
                height: 550px;
            }
        
        </style>
        <script>
            let alertinfo = '<? echo $err[0] ?>';
            if(alertinfo !== ''){
                alert(alertinfo);
            }
            function telselect(){
                let i = document.getElementById('telnumber');
                if(i.value == ''){
                    i.value = 8;
                }
            }
            
            function onlyNumberKey(evt) {
                var ASCIICode = (evt.which) ? evt.which : evt.keyCode
                if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57)) return false;
                return true;
                }
            function clearifempty(){
                let i = document.getElementById('telnumber');
                if(i.value == 8){
                    i.value = '';
                }
            }
        </script>
        
	</head>

	<body>
        <!--                 Header                -->  
        <?php
            include $backRoute.'Template/HeaderHtml.php';
            headershow('', '', '');
        ?>
        <!--                 Header                -->  
        
<!--                 Main Content               -->           
        <div class="eigh-main-content">
        
               <div class="login-block-container">
                   
                   
            
                <div class="login-block-login column pos-center">
                    <h1>Регистрация</h1><br>
                    
                    
                    <form method="post">
                        <br>
                        <input type="text" placeholder="Имя" class="input-login" maxlength="32" name="name" value="<? echo $_POST['name'] ?>" required><br><br>
                        <input type="text" placeholder="Фамилия" class="input-login" maxlength="32" name="surname" value="<? echo $_POST['surname'] ?>" required><br><br>
                        <input type="text" placeholder="Логин" class="input-login" maxlength="11" name="login" pattern="[a-zA-Z0-9-]+" title="Логин может состоять только из англ букв и цифр" required><br><br>
                        <input type="email" placeholder="E-Mail" class="input-login" name="email" required><br><br>
                        <input type="tel" placeholder="Номер телефона" class="input-login" id="telnumber" onclick="telselect()" onfocusout="clearifempty()" pattern="87([0124567][0-8]\d{7})" onkeypress="return onlyNumberKey(event)" name="phone" title="Казахстан (87XX XXX XX XX)" maxlength="11" required><br><br>
                        <input type="password" placeholder="Пароль" class="input-login" name="password" required><br><br>
                        <div class="row-center"><button id="button-login" name="submit" type="submit">Регистрация</button></div><br>
                    </form>
                    <h6 style="text-align:center">Регистрируясь, вы соглашаетесь с правилами  <br>пользования сайтом и даёте согласие <br> на обработку персональных данных.</h6>

                    
                </div>
                
                <div class="login-block-info column-center">
                
                    <div class="sign-in-info column-between pos-center">
                    
                        <h2 style="color: white;">Добро пожаловать</h2>
                        <h5 style="color: white;">У вас уже есть аккаунт?</h5>
                        <a href="login"><button id="button-signin">Войти</button></a>
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