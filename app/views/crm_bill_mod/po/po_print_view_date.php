<?php



session_start();



require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

require_once "../../../assets/support/class.numbertoword.php";
//require "../../../engine/tools/class.numbertoword.php";

$d_id		= $_REQUEST['d_id'];

$sql1="select * from daily_progress_master where d_id='$d_id'";
$data=mysqli_fetch_object(db_query($sql1));
 $progress_for = $data->progress_for;
$vendor=find_all_field('vendor','','vendor_id='.$data->vendor_id );
$whouse=find_all_field('warehouse','','warehouse_id='.$data->warehouse_id);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: Daily Work Progress :.</title>
<link href="../../../css_js/css/invoice.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript">
function hide(){
    document.getElementById("pr").style.display="none";
}



</script>
<style type="text/css">
.style4 {
	font-size: 12px;
	font-weight: bold;
}

.style5 {font-weight: bold}

.style6 {font-weight: bold}

.style7 {font-weight: bold}

.style9 {font-weight: bold}

.style10 {font-weight: bold}
</style></head>

<body>
<form action="" method="post">
<table width="1000" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><div class="line">
      <div align="center"><span class="style4"></span><br />
      </div>
    </div></td>
  </tr>

  <tr>
    <td><div id="pr">
      <div align="left">
          <table width="60%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><input name="button" type="button" onclick="hide();window.print();" value="Print" /></td>
            <input type="hidden" name="d_id" id="d_id" value="<?=$d_id?>" /></td>
        </tr>
      </table>
      </div>
    </div>



<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0">
       <tr>
        <td width="4%" align="center"><strong>SL</strong></td>
        <td width="30%" align="center" ><strong>Department</strong></td>
		<td width="11%" align="center" ><strong>Progress Details</strong></td>
		
      </tr>
	  <?php

$sql1="select * from daily_progress_master where d_id='$d_id'";
$data=mysqli_fetch_object(db_query($sql1));

//echo  $sql2=;'select a.id, a.date,m.progress_for, m.progress_date, a.day, a.customer_name, a.sales_order as "order", a.sales, a.delivery, a.gap_analysis, a.collection, a.outstanding
// from daily_progress_details a, daily_progress_master m where m.d_id=a.d_id and m.progress_date = "2022-06-27" '
$sql2 = 'select type, id from daily_progress_setup where tr_from = "progress for"';
$data2=db_query($sql2);
while($info=mysqli_fetch_object($data2)){ 

?>
	<tr>
        <td valign="top" align="center"><?=++$sl?></td>
        <td align="left" valign="top" style="padding:5px;"><?=$info->type;?></td>
        <td valign="top" style="padding:5px;">
			<table border="1" style="width:100%; border-collapse:collapse">
				<tr>
					<th>Assign Person</th>
					<th>Progress</th>
					<th>Customer</th>
					<th>Project Name</th>
					<th>Order</th>
					<th>Sales</th>
					<th>Delivery</th>
					<th>Collection</th>
					<th>Outsanding</th>
					<th>Particular</th>
					<th>Amount</th>
					<th>Plan</th>
					<th>Man power</th>
					<th>Problems</th>
					<th>Findings</th>
					<th>Target</th>
					<th>Requisition</th>
				</tr>
<?
$sq3 = 'select a.*,m.progress_for, m.progress_date,m.entry_by
 from daily_progress_details a, daily_progress_master m where m.d_id=a.d_id and m.progress_date = "'.date('Y-m-d').'" and m.progress_for='.$info->id.' ';
$data3=db_query($sq3);
while($info3=mysqli_fetch_object($data3)){ 
?>				
				<tr>
					<td><?=find_a_field('user_activity_management','fname','user_id='.$info3->entry_by);?></td>
					<td><?=$info3->progress;?></td>
					<td><?=$info3->customer_name;?></td>
					<td><?=$info3->project_name;?></td>
					<td><?=$info3->sales_order;?></td>
					<td><?=$info3->sales;?></td>
					<td><?=$info3->delivery;?></td>
					<td><?=$info3->collection;?></td>
					<td><?=$info3->outstanding;?></td>
					<td><?=$info3->particular;?></td>
					<td><?=$info3->amount;?></td>
					<td><?=$info3->plan;?></td>
					<td><?=$info3->man_power;?></td>
					<td><?=$info3->problem;?></td>
					<td><?=$info3->findings;?></td>
					<td><?=$info3->target;?></td>
					<td><?=$info3->requisition;?></td>
				</tr>
		<? } ?>		
			</table>
		</td>
        
     </tr>
<? } ?>
    </table>

      <table width="100%" border="0" bordercolor="#000000" cellspacing="3" cellpadding="3" class="tabledesign1" style="width:1000px">
        <tr>
          <td width="49" align="right">&nbsp;</td>
        </tr>
        <tr>
          <td align="right">&nbsp;</td>
        </tr>
        <tr>

          <td align="right">&nbsp;</td>
        </tr>

        <tr>

       

          <td align="left" style="font-size:14px" >



            <table width="100%" border="0" cellspacing="0" cellpadding="0">


              <tr>
			  
			  <td align="center"><?=find_a_field('user_activity_management','fname','user_id='.$data->entry_by);?><br />
			  .........................</td>
			   <!--<td align="center">.........................</td>-->
			  <td align="center"><?=find_a_field('user_activity_management','fname','user_id='.$data->approve_by);?><br />
			  ..............................</td>
			  <!-- <td align="center">.............................</td>-->
			  </tr>
				
				 <tr>
			  
			  <td align="center">Prepared By </td>
			  <!--<td align="center">Checked By <br /> Head of Department</td>-->
			  <td align="center">Approved By </td>
			  <!--<td align="center">Director Marketing</td>-->
			  </tr>
            </table></td>
        </tr>



        <tr>



          <td align="left" style="font-size:10px"><p><br />

          <em>



              <b>              </b>            </em>
            </p>            </td>
        </tr>
      </table></td>
  </tr>
</table>



</form>



</body>



</html>



