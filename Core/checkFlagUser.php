<?php 
if($_SESSION['flag'] == 'ADMIN'){
    header("Location: http://eighstore-php-easier/admin/");
} elseif($_SESSION['flag'] == 'USER') {
    
}