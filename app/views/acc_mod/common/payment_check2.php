<?php session_start();
$c=$_SESSION['count'];
$_SESSION['count']=$_SESSION['count']+5; 
$_SESSION['data'.($c+1)]=$_REQUEST['a'];
$_SESSION['data'.($c+2)]=$_REQUEST['b'];
$_SESSION['data'.($c+3)]=$_REQUEST['c'];
$_SESSION['data'.($c+4)]=$_REQUEST['d'];
$_SESSION['data'.($c+5)]=$_REQUEST['e'];
?>
<table width='100%' border="2" bordercolor="#333333" style="background-color:#FFFFFF;" style="border-collapse:collapse" class="style2">
<?php
for($j=0;$j<($c+5)/5;$j++){
?>
<tr align="center">
              <td width="12%"><?php echo $_SESSION['data'.($j*5+1)];?></td>
              <td width="33%" align="left"><?php echo $_SESSION['data'.($j*5+2)];?></td>
              <td width="16%"><?php echo $_SESSION['data'.($j*5+3)];?></td>
              <td width="17%"><?php echo $_SESSION['data'.($j*5+4)];?></td>
              <td width="22%"><?php echo $_SESSION['data'.($j*5+5)];?></td>
            </tr>
<?php }?>