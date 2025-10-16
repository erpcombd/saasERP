<?php

ini_set('memory_limit', '1024M'); // or you could use 1G

session_start ();
include "config/access_admin.php";
include "config/db.php";
include 'config/function.php';

$pic    =$_GET['pic'];


if(isset($_POST['submit'])){

    $fileName = "../sec_mobile_app/".$pic;
    $degrees = 90;
    
    $source = imagecreatefromjpeg($fileName);
     
    $rotate = imagerotate($source, $degrees, 0);
    
    imagejpeg($rotate, "../sec_mobile_app/".$pic);

echo 'Picture Rotate!';
redirect('shop_pic_view.php?pic='.$pic);
}

?>


<form action="" method="post">
<button name="submit" type="submit" id="button">Rotate me!</button>
</form>

<img src="../sec_mobile_app/<?=$pic?>" height="100%" id="image" />

