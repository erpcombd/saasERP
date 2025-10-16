<?php

session_start();

//====================== EOF ===================

//var_dump($_SESSION);

require_once "../../../assets/support/inc.all.php";

require "../../../engine/tools/class.numbertoword.php";







$req_no 		= $_REQUEST['req_no'];



$sql="select r.*, w.* from requisition_master r, warehouse w where r.warehouse_id=w.warehouse_id and  req_no='$req_no'";

$data=mysql_query($sql);

$all=mysql_fetch_object($data);

$whouse=find_all_field('warehouse','','warehouse_id='.$all->warehouse_id);

$depot=find_all_field('warehouse','','warehouse_id='.$all->depot);





?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>Requsition Copy</title>

<link href="../../../css_js/css/invoice.css" type="text/css" rel="stylesheet"/>

<script type="text/javascript">

function hide()

{

    document.getElementById("pr").style.display="none";

}

</script>

<style type="text/css">
<!--
.style2 {font-size: 22px; }
.style5 {
	font-size: 14px;
	font-weight: bold;
}
.style6 {font-size: 20px; }
.style7 {font-size: 14px}
-->
</style>
</head>

<body>

<table width="700" border="0" cellspacing="0" cellpadding="0" align="center">

  <tr>

    <td><div class="header">

	<table width="100%" border="0" cellspacing="0" cellpadding="0">

	  <tr>

	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

          <tr>

            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
			
			
			
			<tr>

                <td>
				
					<center><h2 class="style6" style="margin:0; padding:0;">M. Ahmed Tea &amp; Lands Co. Ltd</h2>
					  	<p class="style2" style="margin:0; padding:0; font-size:18px; font-weight:600;">(Packaging Division)</p> 
					    <p style="margin:0; padding:0; font-size:16px; font-weight:500;">Khan Tea Estate, Chiknagool, Jaintiapur, Sylhet</p>
					</center>

				</td>

              </tr>
			
			

              <tr>

                <td>

				<div class="header_title">

				Factory Indent

				</div></td>

              </tr>

            </table></td>

          </tr>



        </table></td>

	    </tr>

	  

    </table>

    </div></td>

  </tr>

  <tr>

    

	<td>	</td>

  </tr>

  <tr>

    <td><div class="line"></div></td>

  </tr>

  <tr>

    <td width="100%;"><div class="header2">

          <div class="header2_left" style="width:50%; font-size:14px;">

        <p>
		 Req. No: <strong><?php echo $all->req_no;?></strong><br />
		
		
		
		Req. Date: <?php echo $all->req_date;?><br />


          Req. From: <?php echo $whouse->warehouse_name;?><br />

        </p>

      </div>

      <div class="header2_right" style="width:45%;  font-size:14px;">

        <p>

         

          Need Before: <?php echo $all->need_by;?><br />
		  
		   Note: <?php echo $all->req_note;?><br />

		   
		   Req. To: <?php echo $depot->warehouse_name;?>

        </p>

      </div>

    </div></td>

  </tr>

  <tr>

    <td><div id="pr">

<div align="left">

<form action="" method="get">



<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td width="1"><input name="button" type="button" onclick="hide();window.print();" value="Print" /></td>

  </tr>

</table>



</form><br />

</div>

</div>

<table width="743" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0">

       <tr>

        <td width="6%" rowspan="2"><span class="style5">SL</span></td>

        <td width="34%" rowspan="2"><span class="style5">Description</span></td>

        <td width="15%" rowspan="2"><span class="style5">Required</span></td>
        <td width="13%" rowspan="2"><span class="style5">Present Stock</span></td>

        <td colspan="2"><span class="style5">Last Purchased </span><span class="style5"></span></td>
        <td rowspan="2"><span class="style5">Remarsk</span></td>
       </tr>
       <tr>
         <td><span class="style5">Date</span></td>
         <td><span class="style5">Quantity</span></td>
        </tr>

	  <?php

$final_amt=(int)$data1[0];

$pi=0;

$total=0;

$sql2="select * from requisition_order where  req_no='$req_no'";

$data2=mysql_query($sql2);

//echo $sql2;

while($info=mysql_fetch_object($data2)){ 

$pi++;

$amount=$info->qty*$info->rate;

$total=$total+($info->qty*$info->rate);

$sl=$pi;

$item=find_all_field('item_info','concat(item_name," : ",	item_description)','item_id='.$info->item_id);

$qty=$info->qty;

$qoh=$info->qoh;


//DATE_FORMAT(somedate, "%d/%m/%Y")

$last_p_date=$info->last_p_date;

$last_p_qty=$info->last_p_qty;

$remarsk=$info->remarsk;

?>

      <tr>

        <td valign="top"><span class="style7">
          <?=$sl?>
        </span></td>

        <td align="left" valign="top"><span class="style7">
          <?=$item->item_name?>
        </span></td>

        <td valign="top"><span class="style7">
          <?=$qty.' '.$item->unit_name?>
        </span></td>
        <td valign="top"><span class="style7">
          <?=$qoh?>
        </span></td>

        <td width="16%" valign="top"><span class="style7">
          <?=$last_p_date;?>
        </span></td>

        <td width="16%" valign="top"><span class="style7">
          <?=$last_p_qty.' '.$item->unit_name?>
        </span></td>
        <td width="16%" valign="top"><span class="style7">
          <?=$remarsk;?>
        </span></td>
        </tr>

<? }?>
    </table></td>

  </tr>

  <tr>

    <td align="center">

	<div class="footer1">

	  <div style="float:left">
	  
	  <br /><br />

	  <p style="text-align:left; margin:0; padding:0; ">--------------------------------</p>
	  <p style="margin:0; padding:0; font-size:14px; font-weight:700; text-align:left">Assistant Manager</p>
	 <p style="margin:0; padding:0; font-size:14px; font-weight:500; text-align:left"> M. Ahmed Tea &amp; Lands Co. Ltd. Pkg Div. <br />
	  Khan Tea Estate </p>
	  </div>

	</div>

	<div class="footer1">

      <p style="float:left; font-weight:bold;">Prepared By: <?=find_a_field('user_activity_management','fname','user_id='.$all->entry_by)?></p>

	</div></td>

  </tr>

</table>

</body>

</html>

