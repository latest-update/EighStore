<?php
$fd = fopen("HeaderHtml.php", 'w') or die("Не удалось создать файл");
$str = getRenderedHTML('HeaderUserSide.php');
fwrite($fd, $str);
fclose($fd);
header("Location: ../admin/Products/");

function getRenderedHTML($path){
    ob_start();
    include($path);
    $var=ob_get_contents(); 
    ob_end_clean();
    return $var;
}
?>