<?php
session_start();
require_once "../../config/inc.all.php";
$datatodisplay=$_REQUEST['datatodisplay1'];
$datatodisplay=str_replace('tr style="display: none;"','tr',$datatodisplay);

$datatodisplay=str_replace('\"','',$datatodisplay);
?>
<html>
<head>
<link href="../css/report.css" type="text/css" rel="stylesheet"/>
<style type="text/css">
<!--
.style1 {
	font-size: 18px;
	font-weight: bold;
}
-->
</style>
</head>
<body onLoad="window.print()">
<table width="90%" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td style="border:0px" width="1%">
				<img src="../../img/company_logo.png" height="80" />		</td>
            <td style="border:0px"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td style="border:0px" align="center" class="title">&nbsp;
								<?
if($_SESSION['user']['group']>1)
echo find_a_field('user_group','group_name',"id=".$_SESSION['user']['group']);
else
echo $_SESSION['proj_name'];
				?>
                &nbsp;</td>
              </tr>
              <tr>
                <td align="center" style="border:0px; padding-left:25px;"><?=$_SESSION['company_address']?></td>
              </tr>
              <tr>
                <td align="center" style="border:0px; padding-left:25px;"><span class="style1">
                  <?=$_REQUEST['page_title']?>
                </span>
                  <?=$_REQUEST['report_detail']?></td>
              </tr>
              <tr>
                <td align="center" style="border:0px; padding-left:25px;">&nbsp;</td>
              </tr>
              
            </table></td>
          </tr>
          <tr>
            <td colspan="2" align="center" style="border:0px">&nbsp;</td>
          </tr>
</table>
<br>
<?=$datatodisplay?></body>
</html>
