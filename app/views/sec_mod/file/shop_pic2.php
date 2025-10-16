<?php
session_start ();
include "config/access_admin.php";
include "config/db.php";
include 'config/function.php';




if(isset($_POST['submit'])){

    $fileName = "image/palash.jpg";
    $degrees = 90;
    
    $source = imagecreatefromjpeg($fileName);
     
    $rotate = imagerotate($source, $degrees, 0);
    
    imagejpeg($rotate, "image/palash.jpg");

echo 'Picture Rotate!';
redirect('shop_pic2.php');
}

?>


<form action="" method="post">
<button name="submit" type="submit" id="button">Rotate me!</button>
</form>

<img src="image/palash.jpg" height="100%" id="image" />

