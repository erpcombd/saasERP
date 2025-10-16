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

			<?php /*?><? $path='../logo/'.$_SESSION['proj_id'].'.jpg';

			if(is_file($path)) echo '<img src="'.$path.'" height="80" />';?>	<?php */?>	
			
			<img src="<?=SERVER_ROOT?>public/uploads/logo/fg-logo.png" style="width:90px;" />		</td>

            <td style="border:0px"> <table width="100%" border="0" cellspacing="0" cellpadding="0">

              <tr>

                <td align="center" style=" border:0px" class="title"><h1 style="margin:0; padding-bottom:10px; font-size:20px; font-weight:700;"><? echo $_SESSION['proj_name'];?></h1></td>

              </tr>

              <tr>

                <td align="center" style="border:0px; padding-left:25px;"><?=$_SESSION['company_address']?> </td>

              </tr>
			  
			  <tr>

            <td colspan="2" align="center" style="border:0px; font-size:14px; font-weight:700;">

           <span> <?=$_REQUEST['page_title']?> </span>
			
			

			<span><?=$_REQUEST['report_detail']?> </span></td>

          </tr>
		  
		 

            </table> </td>

          </tr>

          

</table>

<br>

<?=$datatodisplay?></body>

</html>

