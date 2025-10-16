<?php
require_once "../../../assets/template/layout.top.php";


$req_no 		= $_REQUEST['req_no'];

$sql="select * from requisition_master where  req_no='$req_no'";
$data=mysql_query($sql);
$all=mysql_fetch_object($data);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Requsition Copy</title>
<link href="../../css/invoice.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript">
function hide()
{
    document.getElementById("pr").style.display="none";
}
</script>
</head>
<body>
<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><div class="header">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
			
			   <tr>
                <td style="text-align:center">
			<h1><?=$_SESSION['company_name']?></h1>
			 
			   </td>
               </tr>
	
               
			  
	
            </table></td>
          </tr>

        </table></td>
	    </tr>
	  <tr>
	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
		    <td align="center" valign="bottom"><strong>
		      <? $war=find_all_field('warehouse','','warehouse_id='.$all->warehouse_id);
              echo $war->warehouse_name;?>
		    </strong></td>
			</tr>
		</table>		</td>
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
    <td><div class="header2">
          <div class="header2_left">
        <p><span style="font-weight:bold;">Purchase Requisition</span><br />Date: <?php echo $all->req_date;?><br />
          Requisition  No : <?php echo $all->req_no;?><br />
          Requisition For : <?php echo $all->req_for;?><br />
        </p>
      </div>
      <div class="header2_right">
        <p>
          Note : <?php echo $all->req_note;?><br />
          Need Before : <?php echo $all->need_by;?><br />
        </p>
      </div>
    </div></td>
  </tr>
  <tr>
    <td>
	<div id="pr">
<div align="left">
<form action="" method="get">

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="1"><input name="button" type="button" onclick="hide();window.print();" value="Print" /></td>
  </tr>
</table>

</form>
</div>
</div>
<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="2" cellpadding="2" style="border-collapse:collapse;">
       <tr style="background:#CCCCCC;">
        <td width="2%"><strong>SL.</strong></td>
        <td><strong>REQ-ID</strong></td>
        <td><strong>Description of the Goods </strong></td>
		<td><strong>Remarks</strong></td>
        <td><strong>In Stock</strong></td>
        <td><strong>Last Pur. Date</strong></td>
        <td><strong>Last Pur. QTY</strong></td>
		  <td><strong>Unit</strong></td>
        <td><strong>Req QTY</strong></td>
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
$last_p_date=$info->last_p_date;
$last_p_qty=$info->last_p_qty;
$item_for=$info->item_for;
$total_qty +=$qty;
?>
      <tr>
        <td valign="top"><?=$sl?></td>
        <td align="left" valign="top"><?=$info->id?></td>
        <td align="left" valign="top">Code:<?=$info->item_id?><br><?=$item->item_name.' : '.$item->item_description?></td>
        <td valign="top"><?=$info->item_for?></td>
		<td valign="top"><?=$qoh?></td>
        <td valign="top"><?=$last_p_date?></td>
        <td align="right" valign="top"><?=$last_p_qty?></td>
        <td valign="top"><?=$item->unit_name?></td>
		<td valign="top"><?=$qty?></td>
      </tr>
<? }?>
<tr style="background:#CCCCCC;">
 <th colspan="8" style="text-align:right;">Total</th>
 <th align="right"><?=number_format($total_qty,2)?></th>
</tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
   <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
   <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">
	<div class="footer1"></div>
	<div class="footer1">
     <table width="551" border="0">
       <tr>
         <td align="center"><?=find_a_field('user_activity_management','fname','user_id='.$all->entry_by)?></td>
         <td align="center"><?=find_a_field('user_activity_management','fname','user_id='.$all->approve_by)?></td>
         <td align="center"><?=find_a_field('user_activity_management','fname','user_id='.$all->checked_by)?></td>
       </tr>
	   <tr>
         <td align="center">______________</td>
         <td align="center">______________</td>
		 <td align="center">______________</td>
       </tr>
       <tr>
         <td align="center">Prepared By:           </td>
         <td style="text-align:center">Checked By: </td>
		 <td align="center">Approved By: </td>
       </tr>
     </table>
     </div></td>
  </tr>
</table>
</body>
</html>

