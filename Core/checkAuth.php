<?php

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
            session_start(); 

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
        } else {
            //header("Location: https://eighstore.com/");
            header("Location: http://eighstore-php-easier/user/login");
        }
    } else {
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
        //header("Location: https://eighstore.com/");
        header("Location: http://eighstore-php-easier/user/login");
    }
} elseif($_SESSION['auth'] == true) {
    
} else {
    //header("Location: https://eighstore.com/");
    header("Location: http://eighstore-php-easier/user/login");
}