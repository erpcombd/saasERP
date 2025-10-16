<?php



if(!isset($_SESSION))



session_start();

$level=$_SESSION['user']['level'];







?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>   <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<title>Accounts Module <?=PROJECT?></title>
<meta name="Developer" content="Md. Mhafuzur Rahman Cell:01815-224424 email:mhafuz@yahoo.com" />

<?
require_once "../../../assets/support/inc.all.js.php";
require_once "../../../assets/support/inc.all.css.php";
?>



</head>
<body>
<div class="wrapper">
			<div class="header">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td>				<img src="<?=SERVER_ROOT?>public/uploads/logo/logo.jpg"  height="35" border="0" /></td>
				<td valign="top"><div class="header2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td valign="top" class="title"><div align="right">
                      <p class="style1">
					  <? 
					  if($_SESSION['user']['depot']>0)
					  echo find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']);
					  else
					  {unset($_SESSION);
					  }?>
					  </p>
                    </div></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                </table>
				</div></td>
			  </tr>
			</table>
			</div>
			<div class="top_bar"><table width="100%" border="0" cellspacing="0" cellpadding="0">
				  <tr>
					<td><div class="heading">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=POWERED_BY?></div></td>
					<td>
					
					<div class="icon">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						  <tr>
							<td class="heading"><?=$title?> </td>
							<td>
<? if(isset($msg)){?>	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
	<td><div class="msg_text"><?=$msg?></div></td>
	<td width="2%">&nbsp;</td>
  </tr>
</table>
<? }else{?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td>Welcome .. <?=$_SESSION['user']['fname']?></td>
<td width="2%">&nbsp;</td>
</tr>
</table>
<? }?>
							</td>
						  </tr>
						</table>

					 </div>
					
					</td>
				  </tr>
				</table>
  </div>
			<div class="body_box">
			  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td><img src="../../images/index_green_04.jpg" width="21" height="10" /></td>
                      <td class="body_box_topbar"><img src="../../images/index_green_05.jpg" width="51" height="10" /></td>
                      <td><img src="../../images/index_green_06.jpg" width="15" height="10" /></td>
                    </tr>
                    <tr>
                      <td class="body_box_leftbar" valign="top"><img src="../../images/index_green_07.jpg" width="21" height="420" /></td>
                      <td valign="top">
					    <div class="body_middlebox_bar">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
						  <tr>
							<td valign="top">
							<?
					if($_SESSION['mhafuz'])
					{
					?>
							<div class="menu">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tr>
									<td><img src="../../images/menu_01.jpg" width="219" height="14" /></td>
								  </tr>
								  <tr>
									<td valign="top">
									<? include("../../template/main_layout_menu.php");?>
									</td>
								  </tr>
								  <tr>
									<td><img src="../../images/menu_030.jpg" width="219" height="15" /></td>
								  </tr>
								</table>

							</div><? }?></td>
							<td valign="top" align="right">
							<div class="right_main">
							<?=$main_content?>
							</div>
							</td>
						  </tr>
						</table>
						</div>					  </td>
                      <td class="body_box_rightbar" valign="top"><img src="../../images/index_green_09.jpg" width="15" height="420" /></td>
                    </tr>
                    <tr>
                      <td><img src="../../images/index_green_10.jpg" width="21" height="25" /></td>
                      <td class="body_box_bottombar">&nbsp;</td>
                      <td><img src="../../images/index_green_12.jpg" width="15" height="25" /></td>
                    </tr>
                  </table></td>
                </tr>
              </table>
			</div>
</div>


</body>
</html>
