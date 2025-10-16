<?php
session_start();
//====================== EOF ===================
//var_dump($_SESSION);
require "../../support/inc.all.php";
require "../../../engine/tools/class.numbertoword.php";



$req_no 		= $_REQUEST['req_no'];

$sql="select * from requisition_master where  req_no='$req_no'";
$data=db_query($sql);
$all=mysqli_fetch_object($data);

$sub_depot_id=$all->sub_depot;
$group_for=$all->group_for;

$warehouse=find_all_field('warehouse','warehouse_name','warehouse_id='.$all->warehouse_id);


$sub_ware=find_all_field('warehouse','warehouse_name','warehouse_id='.$all->sub_depot);

$sub_depot=$sub_ware->warehouse_name;

$address_depot=$sub_ware->address;

$delivery_spot=$sub_ware->delivery_spot;

$contect_p=$sub_ware->warehouse_company;
$contect_m=$sub_ware->contact_no;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Despatch Order Copy</title>
<link href="../../css/invoice.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript">
function hide()
{
    document.getElementById("pr").style.display="none";
}
</script>
</head>
<body>
<table width="701" border="0" cellspacing="0" cellpadding="0" align="center">
  
  
  
  <tr>
    <td  colspan="2">
		<table width="99%" border="0" cellspacing="0" cellpadding="0">
	
	<tr>

    <td align="left"><strong style="font-size:24px">
	
				
			
				
				
				<img src="<?=SERVER_ROOT?>public/uploads/logo/title.png" style="width:220px;" />
				<br /></strong>    </td>
  </tr>
    </table>	</td>
    <td  width="46%"  colspan="2">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	
	<tr>

    <td align="left"  ><strong><font style="font-size:18px; text-transform: uppercase;">
      <?=find_a_field('user_group','group_name','id='.$group_for);?>
    </font></strong></td>
  </tr>
  
  
  <tr>

    <td align="left">&nbsp; </td>
  </tr>
  
  <tr height="40" style="background:#000; color:#FFFFFF" align="center">

    <td >

    <strong><font style="font-size:20px">PURCHASE TENDERS </font></strong></td>
  </tr>
    </table>	</td>
  </tr>
  
  
  
  
  
<tr>
    <td colspan="3"><div class="line">
      <div align="center">      </div>
    </div></td>
  </tr>>
  
  
  
  
  
  
   <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  

<tr>
    <td colspan="2">&nbsp;</td>
    <td>
		<table width="100%" border="1">
			<tr>
				<td width="50%"><div align="right"><strong>Tender No: </strong></div></td>
				<td width="50%" align="center"><strong><?php echo $all->req_no;?></strong></td>
			</tr>
			<tr>
				<td width="50%"><div align="right"><strong>Tender Date: </strong></div></td>
				<td width="50%" align="center"><strong><?php echo date("d-m-Y",strtotime($all->req_date)); ?></strong></td>
			</tr>
	  </table>	</td>
</tr>



  
   <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  
  
  <tr>
    <td colspan="3">
	
	
	<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0">
       <tr>
        <td colspan="2" align="center" bgcolor="#CCCCCC"><strong><font style="font-size:16px; text-transform:uppercase;">CONSIGNOR DETAILS</font></strong></td>
        </tr>
	 
      <tr>
        <td width="21%" align="center" valign="top"><strong>Warehouse: </strong></td>
        <td width="79%" align="left" valign="top"><font style="font-size:14px;  ">
		
          <?=$warehouse->warehouse_name;?>
        </font></td>
      </tr>
      <tr>
        <td align="center" valign="top"><strong>Address: </strong></td>
        <td align="left" valign="top"><font style="font-size:14px;  ">
          <?=$warehouse->address;?>
        </font></td>
      </tr>
      <tr>
        <td align="center" valign="top"><strong>Contact Person: </strong></td>
        <td align="left" valign="top"><font style="font-size:14px;  ">
          <?=$warehouse->warehouse_company;?>
        </font></td>
      </tr>
      <tr>
        <td align="center" valign="top"><strong>Contact No: </strong></td>
        <td align="left" valign="top"><font style="font-size:14px;  ">
          <?=$warehouse->contact_no;?>
        </font></td>
      </tr>
      <tr>
        <td align="center" valign="top"><strong>E-mail: </strong></td>
        <td align="left" valign="top"><font style="font-size:14px;  ">
          <?=$warehouse->email;?>
        </font></td>
      </tr>
    </table>	</td>
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
    <td width="126"><input name="button" type="button" onclick="hide();window.print();" value="Print" /></td>
    </tr>
</table>
</form><br /><br />
</div>
</div>
<table width="100%">

<tr><td>

<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0">
       <tr>
        <td width="3%" bgcolor="#CCCCCC"><strong>SL</strong></td>
        <td width="42%" bgcolor="#CCCCCC"><strong>Product Name </strong></td>
        <td width="7%" bgcolor="#CCCCCC"><strong>Brand</strong></td>
        <td width="6%" bgcolor="#CCCCCC"><strong>Origin</strong></td>
        <td width="11%" bgcolor="#CCCCCC"><strong>Req Qty </strong></td>
        <td width="24%" bgcolor="#CCCCCC"><strong>Remarks</strong></td>
       </tr>
	  <?php
$final_amt=(int)$data1[0];
$pi=0;
$total=0;
$sql2="select * from requisition_order where  req_no='$req_no'";
$data2=db_query($sql2);
//echo $sql2;
while($info=mysqli_fetch_object($data2)){ 
$pi++;

$sl=$pi;
$item=find_all_field('item_info','concat(item_name," : ",	item_description)','item_id='.$info->item_id);

$ord_qty=$info->qty;
$ord_bag=$ord_qty/$item->pakg_ctn_size;

$in_stock=$info->in_stock;

$tot_ord_qty +=$ord_qty;
$tot_ord_bag +=$ord_bag;


?>
      <tr>
        <td valign="top"><?=$sl?></td>
        <td align="left" valign="top"><?=$item->item_name?></td>
        <td valign="top"><?=find_a_field('item_brand','brand_name','id='.$info->brand)?></td>
        <td valign="top"><?=find_a_field('country','country_name','id='.$info->origin)?></td>
        <td valign="top">1 <?=$item->unit_name?></td>
        <td valign="top"><?=$info->remarks?></td>
      </tr>
	  
	  <? }?>
    </table>
	
	
	</td>
  </tr>
  
  
  <tr>
  	<td>
			<table width="100%" border="0" bordercolor="#000000" cellspacing="3" cellpadding="3" class="tabledesign1" style="width:700px">
        <tr>
          <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
		<td colspan="4">&nbsp;</td>
          </tr>
        <tr>
		<td colspan="4" align="right">&nbsp;</td>
          </tr>
<? if($data->transport_bill>0){?>
<? }?>
<? if($data->labor_bill>0){?>
<? }?>
        <tr>
          <td colspan="4" align="left">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4" align="left">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4" align="left">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4" align="left">&nbsp;</td>
        </tr>
        <tr>
          <td align="center"><?=find_a_field('user_activity_management','fname','user_id='.$all->entry_by)?>
            <br>
            <?=$all->entry_at?></td>
          <td align="center"><? if ($all->checked_by>0) {?>
            <?=find_a_field('user_activity_management','fname','user_id='.$all->checked_by)?>
            <br />
            <?=$all->checked_at?>
            <? }?></td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
        </tr>
        <tr>
          <td align="center">-------------------</td>
          <td align="center">-------------------</td>
          <td align="center">-------------------</td>
          <td align="center">-------------------</td>
        </tr>
        <tr style="font-size:12px">
          <td align="center" width="25%"><strong> Prepared By</strong></td>
          <td align="center" width="25%"><strong> Checked By</strong></td>
          <td align="center" width="25%"><strong>Sr. Manager </strong></td>
          <td align="center" width="25%"><strong> Approved By</strong></td>
        </tr>
        
        
        <?php /*?><tr>
          <td align="left" style="font-size:10px">
          <ul>
            <li>The Copy of Work Order must be shown at the factory premises during the delivery.</li>
            <li>Company protects the right to reconsider or cancel the Work-Order every nowby any administrational dictation.</li>
            <li>Any inefficiency in maintanence must be informed(Officially) before the execution to avoid the compensation.</li>
        </ul></td>
        </tr><?php */?>
        <tr>
          <td colspan="4" align="left">&nbsp;</td>
        </tr>
      </table>
	
	</td>
  </tr>
  
  </table>
  
  
  
  
  
 
</table>


</body>
</html>
