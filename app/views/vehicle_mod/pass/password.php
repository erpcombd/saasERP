<?php
require_once "../../../assets/template/layout.top.php";
$title='Change Password';

//echo $_SESSION['user']['id'];

$pass= find_a_field('user_activity_management','password','user_id="'.$_SESSION['user']['id'].'"');

if(isset($_POST['submit'])){

$sql='update user_activity_management set password="'.$_POST['password'].'" where user_id="'.$_SESSION['user']['id'].'"';
mysql_query($sql);
echo $msg="Password Change Successfully";
header('location:password.php?msg=<span class="btn btn-success">Password Change Successfully</span>');

}


?>


<?
if($_GET['msg']!=''){
echo $_GET['msg'];
}
?>


<h3>Update Your Password</h3> <br /><br />



Update Password 

<form action="" method="post">

<input type="text" name="password" id="password" value="<?=$pass?>" class="col-3" required/>


<input type="submit" name="submit" id="submit" value="Update"  class="btn btn-success"/>
</form>






<?php


require_once "../../../assets/template/layout.bottom.php";
?>