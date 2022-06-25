<?php

if($_SESSION['flag'] == 'ADMIN'){
    
} elseif($_SESSION['flag'] == 'USER') {
    header("Location: http://eighstore-php-easier/user/");
} 