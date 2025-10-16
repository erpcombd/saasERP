<?php
$file = 'gardian/7575.jpg';
$newfile = 'gardian/10107575.jpg';

if (!copy($file, $newfile)) {
    echo "failed to copy $file...\n";
}

 foreach(glob('./gardian/*.*') as $filename){
     echo $filename.'<br>';
 }
?>