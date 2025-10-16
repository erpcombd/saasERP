<?php
//ini_set('display_errors',1); ini_set('display_startup_errors',1); error_reporting(E_ALL);
//require_once "../../../controllers/routing/default_values.php";
//require_once SERVER_CORE."routing/layout.top.php";


//require_once ('../../../acc_mod/common/class.numbertoword.php');

require_once "../../../controllers/routing/print_view.top.php";



$chalan_no = url_decode(str_replace(' ', '+', $_REQUEST['v']));
$c_id = url_decode(str_replace(' ', '+', $_REQUEST['c']));

//$chalan_no 		= $_REQUEST['v_no'];
$sql="select * from sale_return_master where  sr_no='$chalan_no'";
$data=db_query($sql);
$all=mysqli_fetch_object($data);
$group = find_all_field('user_group','','id='.$all->group_for);



 $barcode_content = $chalan_no;
		  $barcodeText = $barcode_content;
          $barcodeType='code128';
		  $barcodeDisplay='horizontal';
          $barcodeSize=40;
          $printText='';

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
<link href="../../../css/invoice.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript">
function hide()
{
    document.getElementById("pr").style.display="none";
}
</script>
<style type="text/css">

.style8 {
	color: #FFFFFF;
	font-weight: bold;
}
.fff{

	width: 1100px;
}

.footer1{
	padding-top: 100px !important;
}


@media print {
  .fff{
	width: auto;
	margin: 0 !important;
	padding: 0 !important;

  }
}





</style>
</head>
	<?php include("../../../../public/assets/css/theme_responsib_new_table_report.php");?>
<body >
<div style="  margin: 0px auto; " class="fff">





<div class="header">
		<table class="table1">
		<tr>
		<td class="logo">
			<img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$c_id?>.png" class="logo-img"/>
		</td>
		
		<td class="titel">
				<h2 class="text-titel"> <?=$group->group_name?> </h2>			
				<p class="text"><?=$group->address?></p>
				<p class="text">Cell: <?=$group->mobile?>. Email: <?=$group->email?> <br> <?=$group->vat_reg?></p>
				<p class="text">
                     <? $war=find_all_field('warehouse','','warehouse_id='.$all->warehouse_id);
                      echo $war->warehouse_name;?>
				</p>
		</td>
		
		
		<?php /*?><td class="Qrl_code">
					<?='<img class="barcode Qrl_code_barcode" alt="'.$barcodeText.'" src="barcode.php?text='.$barcodeText.'&codetype='.$barcodeType.'&orientation='.$barcodeDisplay.'&size='.$barcodeSize.'&print='.$printText.'"/>' ?>
			<p class="qrl-text"><?=$data->sr_no?></p>
		</td><?php */?>
		
		<td class="qr-code">
        <?php 
		$company_id=url_encode($cid);
        $req_no_qr_data = url_encode($chalan_no);
        $print_url = "https://saaserp.ezzy-erp.com/app/views/warehouse_mod/sales_return_invoice/sales_return_print_view.php?c=".rawurlencode($company_id)."&v=" . rawurlencode($req_no_qr_data);
        $qr_code = "https://api.qrserver.com/v1/create-qr-code/?size=80x80&data=" . urlencode($print_url);
        ?>
        <img src="<?=$qr_code?>" alt="QR Code" style=" width: 110px; height: 110px; ">
    </td>
		
		</tr>
		 
		</table>
	</div>
	
	
	<tr> 
		<td>
		  <table width="100%" border="0" cellspacing="0" cellpadding="0"  style="font-size:12px">
		  
		  <tr><td>&nbsp;</td></tr>
		  
			<tr height="30">
			  <td width="25%" valign="top"></td>
			  <td width="50%"  style="text-align:center; "><span style="color:#FFF; font-size:18px; background:#CCCCCC; padding:8px 40px; color:#000000; font-weight:bold; border: 2px solid #000000; border-radius: 5px; ">
			  SALES RETURN</span> </td>
			  <td width="25%" align="right" valign="right">&nbsp;</td>
			  </tr>
			  
			  <tr><td>&nbsp;</td></tr>
			 
		  </table>
  
  		</td>
  
  </tr>
  
  <tr>

	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
		
		

		  <tr>

		    <td valign="top">

		      <table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:13px">
			  
			  
			  
			  <tr>
				  
				  <td><table width="100%" border="1" cellspacing="0" cellpadding="5" style=" ">

		            <tr>

		              <td ><span style="font-size:14px; font-weight:bold;" > SR No: <?=$data->sr_no?> &nbsp;</span></td>
		              </tr>

		            </table></td>

		          <td><table width="100%" border="1" cellspacing="0" cellpadding="5" style=" ">

		            <tr>

		              <td ><span style="font-size:14px; font-weight:bold; float: left;"> SR Date:
                            <?php echo date("d-m-Y",strtotime($data->sr_date)); ?>
                     &nbsp;</span></td>
		              </tr>

		            </table></td>
		          </tr>

		        

                  <tr>
				  
				  <td><table width="100%" border="1" cellspacing="0" cellpadding="5" style=" ">

		            <tr>

		              <td ><span style="font-size:14px; font-weight:bold;" >
		               Customer Name: <?=$dealer->dealer_name_e;?>
		              &nbsp;</span></td>
		              </tr>

		            </table></td>

		          <td><table width="100%" border="1" cellspacing="0" cellpadding="5" style=" ">

		            <tr>

		              <td ><span style="font-size:14px; font-weight:bold;" > Invoice No:  <?=$data->chalan_no?> &nbsp;</span></td>
		              </tr>

		            </table></td>
		          </tr>

		        <tr>

		          <td><table width="100%" border="1" cellspacing="0" cellpadding="5">

		            <tr>

		              <td  valign="top"><span style="font-size:14px; font-weight:bold;" >Dealer Code : <?=$dealer->dealer_code;?>&nbsp;</span></td>
		              </tr>

		            </table></td>
					
					<td><table width="100%" border="1" cellspacing="0" cellpadding="5">

		            <tr>

		              <td  valign="top"><span style="font-size:14px; font-weight:bold;" >Contact No: <? if(!empty($dealer->mobile_no)) {echo $dealer->mobile_no;} else {echo "N/A";}?>&nbsp;</span></td>
		              </tr>

		            </table></td>
		          </tr>
				  
				  
				  <tr>

		          <td><table width="100%" border="1" cellspacing="0" cellpadding="5">

		            <tr>

		    <td  valign="top"><span style="font-size:14px; font-weight:bold;" >Address:<? if (!empty($dealer->address_e)) {echo $dealer->address_e;} else {echo "N/A";}?>&nbsp;</span></td>
		              </tr>
					  

		            </table></td>
					
					
					
					<td><table width="100%" border="1" cellspacing="0" cellpadding="5">

		            <tr>

		              <td  valign="top"><span style="font-size:14px; font-weight:bold;" >Email: <? if(!empty($dealer->email)) {echo $dealer->email;} else{echo "N/A";}?>&nbsp;</span></td>
		              </tr>

		            </table></td>
		          </tr>
				  <tr>

		          <td colspan="2"><table width="100%" border="1" cellspacing="0" cellpadding="5">

		            <tr>

		              <td  valign="top">
					  <span style="font-size:14px; font-weight:bold;" >
					  Reason: <? if(!empty($data->return_note)) {echo $data->return_note;} else{echo "N/A";}?>&nbsp;</span></td>
		              </tr>
					  

		            </table></td>
					
					
					
					
		          </tr>

		        

                  
		        </table>		      </td>


		  </tr>

		</table></td>

	  </tr>
	<tr><td>&nbsp;</td></tr>
	
	<tr>
  	<td>
		<div id="pr">
        <div align="left">
          <p>
            <input name="button" type="button" onclick="hide();window.print();" value="Print" />
          </p>
          <nobr>
          <!--<a href="chalan_bill_view.php?v_no=<?=$_REQUEST['v_no']?>">Bill</a>&nbsp;&nbsp;--><!--<a href="do_view.php?v_no=<?=$_REQUEST['v_no']?>" target="_blank"><span style="display:inline-block; font-size:14px; color: #0033FF;">Bill Copy</span></a>-->
          </nobr>
		  <nobr>
          
          <!--<a href="chalan_bill_distributor_vat_copy.php?v_no=<?=$_REQUEST['v_no']?>" target="_blank">Vat Copy</a>-->
          </nobr>	    </div>
      </div>
	</td>
  
  </tr>
  
  <tr >
    <td valign="top">
      
      <table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="5"  style="font-size:12px"  >
       
       
<tr>

<th width="4%" bgcolor="#CCCCCC">SL</th>

<th width="6%" bgcolor="#CCCCCC" style="text-align: center;">FG Code</th>
<th width="29%" bgcolor="#CCCCCC" style="text-align: center;">Item Description</th>
<th width="8%" bgcolor="#CCCCCC" style="text-align: center;">Unit Price </th>
<th width="7%" bgcolor="#CCCCCC" style="text-align: center;">Pcs</th>
<th width="7%" bgcolor="#CCCCCC" style="text-align: center;"><span role="presentation" dir="ltr">Net  Amount</span></th>
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

<td><?=$sl?></td>

<td><?=$item->finish_goods_code?></td>
<td><?=$item->item_name?>
		<? if ($info->item_color>0  ){
			echo  find_a_field('color_setup','concat(" - ", color_name)','color_id="'.$info->item_color.'"');
		}?>	</td>
<td style="text-align: right;"><?=number_format($unit_price,2)?></td>
<td style="text-align: right;"><?=$total_unit.' '.$unit_name?></td>
<td style="text-align: right;"><?=number_format($amount,2)?></td>
</tr>
        
        <?  } ?>
        <tr>

<td colspan="5"><div align="right"><strong>Sub Total:</strong></div></td>

<td style="text-align: right;"><strong>
  <?php echo number_format($total_amount,2);?>
</strong></td>
</tr>
<? $net_total=$total_amount;?>
 <? if($data->vat>0){?>
      <tr  align="right">
        <td colspan="5"><strong>VAT (<?=$data->vat?> %): </strong> <? $vat_amt=(($net_total*$data->vat)/100);?>:</strong></td>
        <td style="text-align:left"><strong>
          <?  echo number_format($vat_amt,2);?>
        </strong></td>
      </tr>
	  <? }?>
	  
	  <tr>
	    <td   align="right" colspan="5"><strong>Discount(<?=$data->sp_discount?> %)</strong></td>
	    <td style="text-align: right;"><? echo number_format(($cash_discount),2);?></td>
	    </tr>
		<? $grand_total=($net_total+$vat_amt)-($cash_discount);?>
	  <tr>
        <td   align="right" colspan="5"><strong>Net Amount: </strong></td>
        <td style="text-align: right;"><strong><? echo number_format(($grand_total),2);?></strong></td>
      </tr>
      </table>      
    </td>
  </tr>
  
<p class="p bold" style="margin-top: 5px !important;">
    In Words : 
    <?php 
        $scs = $grand_total;
        $credit_amt = explode('.', $scs);

        // Whole number part
        if (!empty($credit_amt[0]) && $credit_amt[0] > 0) {
            echo convertNumberToWordsForIndia($credit_amt[0]);
        }

        // Decimal part (paisa)
        if (isset($credit_amt[1]) && $credit_amt[1] > 0) {
            if ($credit_amt[1] < 10) {
                $credit_amt[1] = $credit_amt[1] * 10; // make sure single-digit becomes 2-digit paisa
            }
            echo ' & ' . convertNumberToWordsForIndia($credit_amt[1]) . ' paisa';
        }

        echo 'Taka Only.';
    ?> 
</p>

  
  
  <tr>
		<td>
	
	 <div class="footer1"> 
	<table width="100%" cellspacing="0" cellpadding="0"   >
		<tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  </tr>
		<tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  </tr>
		   <tr>
		  <td align="center"  style=" font-size:12px;">
		  
		  <?=find_a_field('user_activity_management','fname','user_id='.$data->entry_by);?></td>
		  <td align="center"></td>
		  <td align="center"></td>
		  </tr>
		
		<tr>
		  <td align="center">---------------------------------</td>
		  <td align="center">---------------------------------</td>
		  <td align="center">---------------------------------</td>
		  <td align="center">---------------------------------</td>
		  </tr>
		<tr style="font-size:12px">
            <td align="center" width="25%"><strong>Prepared By </strong></td>
		    <td  align="center" width="25%"><strong>Invoiced Create </strong></td>
		    <td  align="center" width="25%"><strong>Sr.  Manager (Sales)</strong></td>
			<td  align="center" width="25%"><strong>Executive Director</strong></td>
		    </tr>
		<tr style="font-size:12px">
		  <td align="center" colspan="4"><?
$page_name="PO Print View";
require_once SERVER_CORE."routing/layout.report.bottom.php";
?></td>
		  
		  </tr>
		
		
	</table>
	
	</div>
	
</td>
	  </tr>
	
	


</div>

</body>
</html>
