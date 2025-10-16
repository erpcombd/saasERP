<?php

//


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$datatodisplay=$_REQUEST['datatodisplay1'];

$datatodisplay=str_replace('tr style="display: none;"','tr',$datatodisplay);



$datatodisplay=str_replace('\"','',$datatodisplay);

?>

<html>

<head>

<link href="../../../../public/assets/css/report.css" type="text/css" rel="stylesheet"/>

<style type="text/css">



</style>

</head>

<body onLoad="window.print()">

<table width="90%" align="center" cellpadding="0" cellspacing="0">

          <tr>

            <td style="border:0px" width="1%">

			
			
			<img src="<?=SERVER_ROOT?>public/uploads/logo/fg-logo.png" style="width:80px;" />		</td>

            <td style="border:0px"><table width="100%" border="0" cellspacing="0" cellpadding="0">

              <tr>

                <td style="border:0px" align="center" class="title">&nbsp;

								<?



echo $_SESSION['proj_name'];

				?>

                &nbsp;</td>

              </tr>

              <tr>

                <td align="center" style="border:0px; padding-left:25px;"><?=$_SESSION['company_address']?> </td>

              </tr>

              

            </table></td>

          </tr>

          <tr>

            <td colspan="2" align="center" style="border:0px">

            <?=$_REQUEST['page_title']?>

            </span>

			<span class="style1"><?=$_REQUEST['report_detail']?> </span></td>

          </tr>

</table>

<br>

<?=$datatodisplay?></body>

</html>

