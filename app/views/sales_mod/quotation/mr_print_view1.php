<?php
session_start();
//====================== EOF ===================
//var_dump($_SESSION);

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$req_no 		= $_REQUEST['do_no'];

$sql="select * from sale_requisition_master where  do_no='$req_no'";
$data=db_query($sql);
$all=mysqli_fetch_object($data);



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Quotation</title>

<script type="text/javascript">
function hide()
{
    document.getElementById("pr").style.display="none";
}
</script>

<style type="text/css">
<!--
.style1 {color: #FFFFFF}
-->


body {
  font-family: 'Courier New', monospace;
}

table{
	font-size:12px;
}

.box{
	width:95%;
	margin:100px 20px;
	border-right:none;
}

.name{

	 padding: 10px;
	 padding-left:5px;
    color: #fff;
    background-color: #5995D3;
    width:30%;
    
    border-top-left-radius: 15px;
    border-bottom-right-radius: 15px;
	font-family: system-ui;
}


.footer img {
	width:100%;
}

@media print {
}


</style>
</head>
<body>






<div class="box" style="min-height:800px; position:relative">
<table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
  

  	<tr>
	<td colspan="4" style="text-align:center" >

    <strong><font style="font-size:20px"> Quotation </font></strong></td>
	</tr>
<tr>
	<td>&nbsp;</td>
	</tr>

<tr>

<td ><div align=""><strong>Quotation No: </strong> Q-<?=$all->do_no?></div></td>
</tr>
<tr>
<td ><div align=""><strong>Date: </strong> <?=date('D , j \ F Y ' ,strtotime($all->do_date))?></div></td>

</tr>
<tr>
	<td>&nbsp;</td>
	
</tr>

<tr>

<td ><div align=""><strong><?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$all->dealer_code)?> </strong></div></td>
</tr>

<tr>
<td><div align=""><strong>Address: </strong><?=find_a_field('dealer_info','address_e','dealer_code='.$all->dealer_code)?></div></td>

</tr>

<tr>

<td ><div align=""><strong> Unit: </strong><?=$all->unit?></div></td>
</tr>

<!--<tr>

<td ><div align=""><strong>ATTN: </strong><?=$all->attn?></div></td>
</tr>-->
<!--<tr>
<td ><div align=""><strong>Requisition No: </strong><?=$all->ref_no?></div></td>

</tr>-->

<tr>
    <td colspan="3">&nbsp;</td>
  </tr>


  

  
  
  
  
  
  
  
  
  
  
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  

  <tr>
    <td colspan="3"><div id="pr">
<div align="left">
<form action="" method="get">

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td ><input name="button" type="button" onclick="hide();window.print();" value="Print" /></td>
	
    <!--<td  style=" font-size:14px;">

<a href="mr_print_view_duplicate.php?do_no=<?=$req_no?>" target="_blank"><strong>Office Copy</strong></a>	</td>-->
  </tr>
</table>
</form><br />
</div>
</div>
<table width="100%">

<tr><td>

<table width="100%"  border="1px" bordercolor="grey" cellspacing="0" cellpadding="3">
       <tr>
        <td align="center" ><strong>SL</strong></td>
        <td align="center" ><strong>Item Name </strong></td>
        <td align="center" ><strong>Category</strong></td>
        <td align="center" ><strong>Rate</strong></td>
        <td align="center" ><strong>Quantity </strong></td>
        <td align="center" ><strong>Total</strong></td>
		<!--<td align="center" ><strong>Delivery</strong></td>-->
       </tr>
	  <?php
$final_amt=(int)$data1[0];
$pi=0;
$total=0;
$sql2="select a.* from sale_requisition_details a  where  do_no='$req_no'";
$data2=db_query($sql2);
//echo $sql2;
while($info=mysqli_fetch_object($data2)){ 
$pi++;

$sl=$pi;
$item=find_all_field('item_info','','item_id='.$info->item_id);
$brand = find_a_field('item_sub_group','sub_group_name','sub_group_id='.$item->sub_group_id);
$ord_qty=$info->qty;
$ord_bag=$ord_qty/$item->pakg_ctn_size;

$in_stock=$info->in_stock;

$tot_ord_qty +=$ord_qty;
$tot_ord_bag +=$ord_bag;


?>
      <tr>
        <td valign="top"><?=$sl?></td>
        <td align="left" valign="top"><?=$item->item_name?></td>
        <td align="center" valign="top"><?=$brand?></td>
		
        <td align="right" valign="top"> <?=$info->unit_price?></td>
        <td align="right" valign="top"><?=number_format($info->total_unit);?> Pcs</td>
        <td align="right" valign="top"><?=number_format($info->total_amt,2); $tot_amt +=$info->total_amt; ?></td>
		<!--<td ><?=$info->delivery;?></td>-->
      </tr>
	  
	  <? }?>
	  
	  <tr>
	  	<td colspan="5" style="text-align:right"><strong>Total &nbsp;</strong></td>
		<td style="text-align:right"><?=number_format($tot_amt,2);?></td>
		
	  </tr>
	  <? if($all->discount >0){ ?>
	  <tr>
	  	<td colspan="5" style="text-align:right">Discount (<?=$all->discount?> %) &nbsp;</td>
		<td style="text-align:right"><?=number_format($discount_amt=($tot_amt * $all->discount) / 100,2);?></td>
		
	  </tr>
	  <? } ?>	  
	   <? if($all->cash_discount >0){ ?>
	  <tr>
	  	<td colspan="5" style="text-align:right">Deduct &nbsp;</td>
		<td style="text-align:right"><?=number_format($deduct_amt=$all->cash_discount,2);?></td>
		
	  </tr>
	  <? } ?>
	  
	  <tr>
	  	<td colspan="5" style="text-align:right"><strong>Sub Total  &nbsp;</strong></td>
		<td style="text-align:right"><?=number_format($sub_total_amt=($tot_amt  - ($discount_amt+$deduct_amt)),2);?></td>
		
	  </tr>
	  
	   <? if($all->vat >0){ ?>
	  <tr>
	  	<td colspan="5" style="text-align:right">VAT (<?=$all->vat?> %) &nbsp;</td>
		<td style="text-align:right"><?=number_format($vat_amt=($sub_total_amt * $all->vat) / 100,2);?></td>
		
	  </tr>
	  <? } ?>
	  
	   <? if($all->ait >0){ ?>
	  <tr>
	  	<td colspan="5" style="text-align:right">AIT( <?=$all->ait?>%) &nbsp;</td>
		<td style="text-align:right"><?=number_format($ait_amt=($sub_total_amt * $all->ait) /100,2);?></td>
		
	  </tr>
	  <? } ?>
	  
	   <? if($all->vat_ait >0){ ?>
	  <tr>
	  	<td colspan="5" style="text-align:right">VAT & AIT(<?=$all->vat_ait?>%) &nbsp;</td>
		<td style="text-align:right"><?=number_format($vat_ait_amt=($sub_total_amt * $all->vat_ait)/100,2);?></td>
		
	  </tr>
	  <? } ?>
	  <tr>
	  	<td colspan="5" style="text-align:right"><b>Grand Total &nbsp;</b></td>
		<td style="text-align:right"><b><?=number_format($grand_amt=($sub_total_amt + ( $vat_amt + $ait_amt + $vat_ait_amt)),2);?></b></td>
		
	  </tr>
    </table>
	
	
	</td>
  </tr>
  
  
  <tr>
  
          <td align="left" style="font-size:12px;line-height:1.2">
		  
		  <div id="terms">
		  <p><u>Terms and Condition</u></p>
          <ul>
            <li>Validity: The Offer will be valid for only 7 (seven) days from the date here of.</li>
            <li>Payement Term: <?=$all->payment_terms?></li>
			<li>Quoted delivery subject to prior sale.</li>
			<li>Quoted prices are quantity bound.</li>
			<li>All payment should be made by accounts payee cheque or through bank</li>
			<? if($all->remarks !='') { 
			
			 $all->remarks;
			$array=explode("#",$all->remarks);
			$flag=count($array);


if($flag!=0)
{

for($i=1;$i<$flag;$i++){
	echo '<li>'.$array[$i].'</li>';
}

}  } ?>
        </ul>
		
		</div>
		
		</td>

  </tr>
  </table>
</table>
<div  style="text-align:right;width:95%;">
<p>Yours sincerely</p>
</br>
</br>
<?php $uid=find_a_field('sale_requisition_master','entry_by','do_no="'.$req_no.'"');
		   echo find_a_field('user_activity_management','fname','user_id="'.$uid.'"')?>
<p><?=$all->quo_by?></p>



</div>
</div>
<div style="clear:both"></div>
</body>
</html>
