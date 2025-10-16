<?php
session_start();
//====================== EOF ===================

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

require_once ('../../../acc_mod/common/class.numbertoword.php');


$chalan_no 		= $_REQUEST['v_no'];

if(isset($_POST['cash_discount']))
{
	$po_no = $_POST['po_no'];
	$cash_discount = $_POST['cash_discount'];
	$ssql='update purchase_master set cash_discount="'.$_POST['cash_discount'].'" where po_no="'.$po_no.'"';
	db_query($ssql);
}


//$do_no=find_a_field('sale_do_chalan','do_no','chalan_no='.$chalan_no );

$ch=find_all_field('sale_do_chalan','','chalan_no='.$chalan_no );

 $sql1="select * from sale_return_master where sr_no='$chalan_no'";
$data=mysqli_fetch_object(db_query($sql1));


$dealer=find_all_field('dealer_info','','dealer_code='.$data->dealer_code );
$whouse=find_all_field('warehouse','','warehouse_id='.$data->depot_id);




?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: Sales Return Note :.</title>
<link href="../../../assets/css/invoice.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript">
function hide()
{
    document.getElementById("pr").style.display="none";
}
</script>
<style type="text/css">
<!--
.style8 {
	color: #FFFFFF;
	font-weight: bold;
}
-->
</style></head>
<body>
<form action="" method="post">
<table width="700" border="0" cellspacing="0" cellpadding="0" align="center">
  
  <tr>
    <td width="60%">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
	
	<tr>

    <td align="left"><strong style="font-size:24px">
	
				
			
				
				
				<img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$data->group_for?>.png" style="width:250px;" />
				<br /></strong>    </td>
  </tr>
    </table>	</td>
    <td width="40%">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
	
	<tr>

    <td align="left"  ><strong><font style="font-size:20px; text-transform: uppercase;">
      <?=find_a_field('user_group','group_name','id='.$data->group_for);?>
    </font></strong></td>
  </tr>
  
  
  <tr>

    <td align="left">&nbsp; </td>
  </tr>
  
  <tr height="40" style="background:#000; color:#FFFFFF" align="center">

    <td ><strong><font style="font-size:20px">SALES RETURN </font> </strong></td>
  </tr>
    </table>	</td>
  </tr>
  
  <tr>
    <td colspan="2"><div class="line">
      <div align="center">      </div>
    </div></td>
  </tr>
  
  
  
  
  
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  
   <tr>
    <td >
	<table  width="400" border="0" cellspacing="0" cellpadding="0" align="center">
  	<tr>
  	  <td colspan="2">&nbsp;</td>
  	  <td>&nbsp;</td>
  	  </tr>
  	<tr>
  	  <td height="25" colspan="2" bgcolor="#004269" headers="25"><span style="font-size:14px; font-weight:700; color:#FFFFFF; padding-left:10px;"> DETAILS OF CUSTOMER</span></td>
  	  <td width="6%">&nbsp;</td>
  	  </tr>
  	<tr style="font-size:14px;">
		<td  height="25"  width="29%">&nbsp;&nbsp;Name</td>
		<td  height="25"  width="65%">: <?=$dealer->dealer_name_e;?></td>
		<td  height="25" width="6%"></td>
		</tr>
		
		
		<tr style="font-size:14px;">
		<td  height="25"  width="29%">&nbsp;&nbsp;Arabic Name</td>
		<td  height="25"  width="65%" style="font-size:18px">: <?=$dealer->dealer_name_a;?></td>
		<td  height="25" width="6%"></td>
		</tr>
		
		<tr style="font-size:14px;">
		<td  height="25"  width="29%">&nbsp;&nbsp;Code</td>
		<td  height="25"  width="65%">: <?=$dealer->customer_id;?></td>
		<td  height="25" width="6%"></td>
		</tr>
		
	<tr style="font-size:14px;">
		<td  height="25"  width="29%">&nbsp;&nbsp;Address</td>
		<td  height="25"  width="65%">: <?=$dealer->address_e;?></td>
		<td  height="25" width="6%"></td>
		</tr>
	<tr style="font-size:14px;">
		<td  height="25"  width="29%">&nbsp;&nbsp;Phone</td>
		<td  height="25"  width="65%">: <?=$dealer->mobile_no;?></td>
		<td  height="25" width="6%"></td>
		</tr>
	
	<tr style="font-size:14px;">
		<td  height="25"  width="29%">&nbsp;&nbsp;E-mail</td>
		<td  height="25"  width="65%">: <?=$dealer->email;?></td>
		<td  height="25" width="6%"></td>
		</tr>
	
	<tr>
  	  <td colspan="2">&nbsp;</td>
  	  <td>&nbsp;</td>
  	  </tr>
  </table>
	
	
	</td>
    <td>
		<table width="100%" border="1">
		
		<tr>
				<td width="50%"><div align="right"><strong>SR NO: </strong></div></td>
				<td width="50%" align="center"><strong>
				  <?=$data->sr_no?>
				</strong></td>
		  </tr>
			<tr>
				<td width="50%"><div align="right"><strong>SR Date: </strong></div></td>
				<td width="50%" align="center"><strong>
				  <?php echo date("d-m-Y",strtotime($data->sr_date)); ?>
				</strong></td>
			</tr>
			
			<tr>
				<td width="50%"><div align="right"><strong>Invoice No: </strong></div></td>
				<td width="50%" align="center"><strong>
				  <?=$data->chalan_no?>
				</strong></td>
			</tr>
			
			
			
			
			
	  </table>	</td>
  </tr>
  
   
  
  
  </table>
  
  
  
  
  
  <table width="700" border="0" cellspacing="0" cellpadding="0" align="center">
 
  
  <tr>
    <td colspan="2">
		<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0">
       <tr>
        <td width="20%" bgcolor="#004269"><span class="style8"> Reason:</span></td>
        <td width="80%" align="left" bgcolor="#FFFFFF"><strong>
          &nbsp;<?=$data->return_note?>
        </strong></td>
        </tr>
</table>
	
	</td>
	<tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  </tr>
  <tr>
    <td colspan="2"><div id="pr">
      <div align="left">
        
          <table width="60%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><input name="button" type="button" onclick="hide();window.print();" value="Print" /></td>
         <?php /*?> <td><span class="style3">Special Cash Discount: </span></td>
          <td><label>
            <input name="cash_discount" type="text" id="cash_discount" value="<?=$cash_discount?>" />
            </label>
            <input type="hidden" name="po_no" id="po_no" value="<?=$po_no?>" /></td>
          <td><label>
            <input type="submit" name="Update" value="Update" />
          </label></td><?php */?>
        </tr>
      </table>
      </div>
    </div>
<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0">
       <tr>
        <td width="3%" bgcolor="#004269"><span class="style8">SL</span></td>
        <td width="15%" bgcolor="#004269"><span class="style8">Item Code </span></td>
        <td width="46%" bgcolor="#004269"><div align="center" class="style8">Description of the Goods </div></td>
        <td width="14%" bgcolor="#004269"><span class="style8">Price</span></td>
        <td width="7%" bgcolor="#004269"><span class="style8">Qty</span></td>
        <td width="15%" bgcolor="#004269"><span class="style8">Amount</span></td>
      </tr>
	  <?php
$final_amt=0;
$pi=0;
$total=0;
$sql2="select * from sale_return_details where sr_no='$chalan_no'";
$data2=db_query($sql2);
//echo $sql2;
while($info=mysqli_fetch_object($data2)){ 
$pi++;

$amount=$info->total_amt;

$total_unit=$info->total_unit;

$unit_price=$info->unit_price;

$total_amount +=$amount;

$sl=$pi;
$item=find_all_field('item_info','concat(item_short_name)','item_id='.$info->item_id);
$qty=$info->qty;
$unit_name=$info->unit_name;
$rate=$info->rate;
$disc=$info->disc;
?>
<tr>
        <td valign="top"><?=$sl?></td>
        <td align="left" valign="top"><?=$item->finish_goods_code?></td>
        <td align="left" valign="top"><?=$item->item_short_name?>
		<? if ($info->item_color>0  ){
			echo  find_a_field('color_setup','concat(" - ", color_name)','color_id="'.$info->item_color.'"');
		}?>		</td>
        <td valign="top"><?=number_format($unit_price,2)?></td>
        <td align="right" valign="top"><?=$total_unit.' '.$unit_name?></td>
        <td align="right" valign="top"><?=number_format($amount,2)?></td>
      </tr>
<? }?>
      <tr>
        <td colspan="4"></td>
        <td align="right"><strong>Total:</strong></td>
        <td align="right"><strong><?php echo number_format($total_amount,2);?></strong></td>
      </tr>
    </table>
	
	 <table width="700" border="0" cellspacing="0" cellpadding="0" align="center">
	 <tr>
	   <td >&nbsp;</td>
	   <td>&nbsp;</td>
	   </tr>
	 <tr>
    <td width="60%" >&nbsp;</td>
    <td width="40%">
		<table width="100%" border="1">
			<tr>
				<td width="50%"><div align="right"><strong>Sub Total: </strong></div></td>
				<td width="50%" align="center"><strong><?php echo number_format($total_amount,2);?>
				</strong></td>
			</tr>
			
			
			<?php /*?><?
			 if ($data->sp_discount>0) {
			 	$cash_discount = ($total_amount * $data->sp_discount)/100;
				}else {
				$cash_discount = $data->cash_discount;
				}
			?>
			
			<? if($cash_discount>0){?>
			<tr>
			  <td><div align="right"><strong>Discount: </strong></div></td>
			  <td align="center"><strong><? echo number_format(($cash_discount),2);?></strong>
			  <? $net_total=($total_amount-$cash_discount);?>
			  
			  </td>
			  </tr>
			  
			  <? }?><?php */?>
			  
			  <? $net_total=$total_amount;?>
			  
			<? if($data->vat>0){?>
			<tr>
				<td width="50%"><div align="right"><strong>VAT(<?=$data->vat?> %): </strong> <? $vat_amt=(($net_total*$data->vat)/100);?></div></td>
				<td width="50%" align="center"><strong>
				  <?  echo number_format($vat_amt,2);?>
				</strong></td>
			</tr>
			<? }?>
			
			<? $grand_total=($net_total+$vat_amt);?>
			
			
			<tr>
			  <td><div align="right"><strong>Adjusted Amt: </strong></div></td>
			  <td align="center"><strong><? echo number_format(($grand_total),2);?></strong></td>
			  </tr>
	  </table>	</td>
  </tr>
	 </table>
	
	
	
	
      <table width="100%" border="0" bordercolor="#000000" cellspacing="3" cellpadding="3" class="tabledesign1" style="width:700px">
        <!--<tr>
		<td><strong>In Word:</strong> SAR <?
		
		$invoice_amt = $grand_total;
		
		$scs =  number_format($invoice_amt,3);
			 $credit_amt = explode('.',$scs);
	 if($credit_amt[0]>0){
	 
	 echo convertNumberToWordsForIndia($credit_amt[0]);}
	 if($credit_amt[1]>0){
	 if($credit_amt[1]<10) $credit_amt[1] = $credit_amt[1]*10;
	 echo  ' & '.convertNumberToWordsForIndia($credit_amt[1]).' paisa ';}
	 echo ' Only.';
		?></td>
          </tr>-->
<? if($data->transport_bill>0){?>
<? }?>
<? if($data->labor_bill>0){?>
<? }?>
        <tr>
          <td align="left">&nbsp;</td>
        </tr>
        
        <tr>
          <td align="left" style="font-size:10px" >
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
			  
			  <td width="25%" valign="bottom"><em><?=find_a_field('user_activity_management','fname','user_id='.$data->entry_by);?>
                  <br />
                  --------------<br />
                </em><strong>Prepared By</strong></td>
				
				<td width="25%" valign="top"><p><br />
                </p>
                  <p><br />
                      <br />
                    --------------<br />
                Invoiced Create &nbsp;</p></td>
				
				
				<td width="25%" valign="top"><p><br />
                </p>
                  <p><br />
                    <br />
                    --------------<br />
                    Sr.  Manager (Sales) </p></td>
				
                <td width="25%" valign="top"><p><br />
                </p>
                  <p><br />
                      <br />
                    -----------------------<br />
                Executive Director&nbsp;</p></td>
              </tr>
            </table></td>
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
          <td align="left">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</form>
</body>
</html>
