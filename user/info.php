<?php
session_start(); 
$backRoute = '../';
include $backRoute.'Template/Header.php';
require_once $backRoute.'Core/connect.php';
require_once $backRoute.'Core/checkAuth.php';

if($_SESSION['flag'] == 'ADMIN'){
    $leftbar = 'admin';
} elseif($_SESSION['flag'] == 'USER') {
    $leftbar = 'user-setting';
}


if(isset($_POST['submit'])){
    
    $id = $_POST['id'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    
    mysqli_query($connect, "UPDATE `users` SET `EMAIL` = '$email', `NAME` = '$name', `SURNAME` = '$surname', `PHONE` = '$phone' WHERE `users`.`LOCAL-ID` = '$id'");
    
    $_SESSION['name'] = $name;
    $_SESSION['surname'] = $surname;
    $_SESSION['phone'] = $phone;
    $_SESSION['email'] = $email;
    
    $err[] = 'Успешно';
    
}
if(isset($_POST['savePass'])){
    $err = [];
    $id = $_POST['id'];
    $old = $_POST['OldPass'];
    $new = $_POST['NewPass'];
    $new1 = $_POST['NewPassCheck'];
    
    if($new == $new1){
        
        $passfromdb = mysqli_query($connect, "SELECT `PASSWORD` FROM `users` WHERE `LOCAL-ID` = '$id'");
        $passfromdb = mysqli_fetch_assoc($passfromdb);
        
        if(md5(md5(trim($old))) === $passfromdb['PASSWORD']){
            $password = md5(md5(trim($new)));
            mysqli_query($connect, "UPDATE `users` SET `PASSWORD` = '$password' WHERE `users`.`LOCAL-ID` = '$id'");
            $_COOKIE['KEY'] = $password;
            $err[] = 'Успешно';
        } else {
            $err[] = "Неправильный пароль";
        }
        
    } else{
        $err[] = "Новые пароли не совпадают";
    }
}
if(isset($_POST['saveImage'])){
    $id = $_SESSION['id'];
    $name = $_SESSION['user'];
    $path = '../Data/User/'.$name.'/';
    if(!file_exists($path)){
        mkdir($path, 0777);
    }
    $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
    move_uploaded_file($_FILES['file']['tmp_name'], "../Data/User/".$name.'/user.'.$ext);
    $img = "Data/User/".$name.'/user.'.$ext;
    $_SESSION['picture'] = $img;
    mysqli_query($connect, "UPDATE `users` SET `PICTURE` = '$img' WHERE `users`.`LOCAL-ID` = '$id'");
    $err[] = 'Успешно';
}


if(isset($_POST['deleteImage'])){
    $id = $_SESSION['id'];
    $name = $_SESSION['user'];
    $path = '../Data/User/'.$name.'/';
    if(file_exists($path)){
        array_map('unlink', glob("$path/*.*"));
        rmdir($path);
        $img = 'Data/User/Default/user.svg';
        $_SESSION['picture'] = $img;
        mysqli_query($connect, "UPDATE `users` SET `PICTURE` = '$img' WHERE `users`.`LOCAL-ID` = '$id'");
        $err[] = 'Успешно';
    } else {
        $err[] = 'Удаление не возможно';
    }
    
}
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
    <!--     custom input     -->
    <link rel="stylesheet" href="<? echo $backRoute ?>lib/CustomInput/input-file.css">
    <!--     custom input     -->
    <script src="../header.js<? echo $script ?>"></script>
    <style>
        @media screen and (max-width: 991px) {
            .panel-left-bar {
                display: none;
            }
        }

    </style>
    <script>
        let alertinfo = '<? echo $err[0] ?>';
        if (alertinfo !== '') {
            alert(alertinfo);
        }

        function checkPass() {
            let one = document.getElementById('Pass1Check');
            let two = document.getElementById('Pass2Check');
            if (one.value != two.value) {
                document.getElementById('id123122').innerHTML = "Пароли не совпадают";
                document.querySelector('.id241').disabled = true;
            } else {
                document.querySelector('.id241').disabled = false;
                document.getElementById('id123122').innerHTML = "";
            }

        }

        function telselect() {
            let i = document.getElementById('telnumber');
            if (i.value == '') {
                i.value = 8;
            }
        }

        function onlyNumberKey(evt) {
            var ASCIICode = (evt.which) ? evt.which : evt.keyCode
            if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57)) return false;
            return true;
        }

        function clearifempty() {
            let i = document.getElementById('telnumber');
            if (i.value == 8) {
                i.value = '';
            }
        }

    </script>

</head>

<body>
    <!--                 Header                -->
    <?php
            include $backRoute.'Template/HeaderHtml.php';
            $username = $_SESSION['user'];
            headershow($username, '', $leftbar);
        ?>
    <!--                 Header                -->

    <!--                 Main Content               -->
    <div class="eigh-main-content">

        <div class="user-panel-main-content row-center">

            <div class="user-panel-content-block column">

                <h2 style="margin-bottom: 25px;"><a href="../user/"><img class="main_catalog_link_arrow img-right" src="<? echo $backRoute ?>icons/down.svg"></a>Личная информация</h2>


                <div class="content-block-add-product">

                    <h4 id="id13241">
                        <? echo mb_strtoupper($_SESSION['user']) ?>
                    </h4>
                    <form method="post">
                        <br>
                        <input class="user-panel-input-1-small" type="text" placeholder="Имя" name="name" value="<? echo $_SESSION['name'] ?>" required><br><br>
                        <input class="user-panel-input-1-small" type="text" placeholder="Фамилия" name="surname" value="<? echo $_SESSION['surname'] ?>" required><br><br>
                        <input type="tel" placeholder="Номер телефона" class="user-panel-input-1-small" style="width: 50%" id="telnumber" onclick="telselect()" onfocusout="clearifempty()" pattern="^\+?87([0124567][0-8]\d{7})$" onkeypress="return onlyNumberKey(event)" name="phone" value="<? echo $_SESSION['phone'] ?>" required><br><br>
                        <input class="user-panel-input-1-small" type="email" placeholder="Почта" name="email" value="<? echo $_SESSION['email'] ?>" required><br><br>
                        <input type="hidden" value="<? echo $_SESSION['id'] ?>" name="id">
                        <button id="button-login" type="submit" class="user-info-btn" name="submit">Сохранить</button>
                    </form>
                    <br><br>
                    <div style="border-top: 1px solid #eee"></div>
                    <br><br>
                    <div id="id013" style="display: block">
                        <a onclick="changeElements('id013', 'id012')"><button id="button-login" class="user-info-btn" type="button">Сменить пароль</button></a>
                    </div>

                    <div id="id012" style="display: none; border-bottom: 1px solid #eee">
                        <form method="post">
                            <input class="user-panel-input-1-small" type="password" placeholder="Старый пароль" style="width: 50%" name="OldPass" required><br><br>
                            <input class="user-panel-input-1-small" id="Pass1Check" type="password" placeholder="Новый пароль" style="width: 50%" name="NewPass" required><br><br>
                            <input class="user-panel-input-1-small" id="Pass2Check" type="password" placeholder="Новый пароль" onkeyup="checkPass()" style="width: 50%" name="NewPassCheck" required><br><br>
                            <button id="button-login" type="submit" disabled class="user-info-btn id241" name="savePass">Сменить пароль</button><a onclick="changeElements('id013', 'id012')"><button id="button-login" type="button" class="user-info-btn">Отмена</button></a><br><br>
                            <h4 style="color: red" id="id123122"></h4>
                            <input type="hidden" value="<? echo $_SESSION['id'] ?>" name="id">
                        </form>
                    </div><br>

                    <div id="id014" style="display: block">
                        <a onclick="changeElements('id014', 'id015')"><button id="button-login" class="user-info-btn" type="button">Сменить портрет</button></a>
                    </div><br>

                    <div id="id015" style="display: none; border-bottom: 1px solid #eee">
                        <form method="post" enctype="multipart/form-data">
                            <div id="fileInput">
                                <input type="file" name="file" accept="image/*" id="input"><br>
                            </div><button id="button-login" type="submit" disabled class="user-info-btn id244" name="saveImage">Сохранить</button><a onclick="changeElements('id014', 'id015')"><button id="button-login" type="button" class="user-info-btn">Отмена</button></a><button id="button-login" type="submit" class="user-info-btn" name="deleteImage">Удалить картинку</button><br><br>
                        </form>
                    </div>

                </div>

            </div>

        </div>

    </div>
    <!--                 Main Content               -->

    <script src="<? echo $backRoute ?>lib/CustomInput/input-file.min.js"></script>
    <script>
        new InputFile({
            hint: 'или перетащите сюда',
            buttonText: 'Выберите картинки вашего профиля',
            message: 'Файл выбран'
        });

    </script>
    <script>
        var elm = false;
        const input = document.getElementById('input');
        let btn = document.querySelector('.id244');

        input.addEventListener("change", function(event) {
            if (input.files[0]['size'] > 200000) { // 1 000 000 = 1 mb
                if (!elm) {
                    document.querySelector('#fileInput').insertAdjacentHTML("beforeend", '<p id="warningFileSize" style="color: red; margin-bottom: 10px;">! Допустимый размер файла 200kB</p>');
                    btn.disabled = true;
                    elm = true;
                }
            } else {
                let sasd = document.getElementById('warningFileSize');
                if (sasd != null) {
                    sasd.remove();
                }
                btn.disabled = false;
                elm = false;
            }
        });

    </script>

</body>

</html>
