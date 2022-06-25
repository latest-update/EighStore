<?php
    session_start();
    $_SESSION['auth'] = false;
    $_SESSION['flag'] = '';
    $_SESSION['user'] = '';
    $_SESSION['name'] = '';
    $_SESSION['surname'] = '';
    $_SESSION['id'] = '';
    $_SESSION['phone'] = '';
    $_SESSION['picture'] = '';
$_SESSION['email'] = '';
    session_destroy();
    

    setcookie("ID", '', time() - 3600, "/");
    setcookie("LOGIN", '', time() - 3600, "/");
    setcookie("KEY", '', time() - 3600, "/");
    
    header("Location: http://eighstore-php-easier/");
    
?>