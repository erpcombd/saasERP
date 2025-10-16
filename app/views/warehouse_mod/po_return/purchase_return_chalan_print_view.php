<?php



session_start();



//====================== EOF ===================



//var_dump($_SESSION);




 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// require_once ('../../../acc_mod/common/class.numbertoword.php');

 $pr_no = $_REQUEST['v_no'];

$group = find_all_field('user_group','','id="'.$_SESSION['user']['group'].'"');

//$do_no= find_a_field('sale_return_details','do_no','chalan_no='.$chalan_no);


$return_master = find_all_field('purchase_return_master','','pr_no='.$pr_no);

$group = find_all_field('user_group','','id="'.$return_master->group_for.'"');



$master = find_all_field('purchase_return_details','','pr_no='.$pr_no);




  		  $barcode_content = $pr_no;
		  $barcodeText = $barcode_content;
          $barcodeType='code128';
		  $barcodeDisplay='horizontal';
          $barcodeSize=40;
          $printText='';


foreach($challan as $key=>$value){
$$key=$value;
}

  $ssql = 'select a.*,b.* from vendor a, purchase_return_details b where a.vendor_id=b.vendor_id and b.pr_no='.$pr_no;

 $dealer = find_all_field_sql($ssql);

$entry_time=$dealer->do_date;



$dept = 'select warehouse_name from warehouse where warehouse_id='.$dept;

$deptt = find_all_field_sql($dept);

$to_ctn = find_a_field('purchase_return_details','sum(pkt_unit)','pr_no='.$pr_no);

$to_pcs = find_a_field('purchase_return_details','sum(dist_unit)','pr_no='.$pr_no); 



$ordered_total_ctn = find_a_field('purchase_return_details','sum(pkt_unit)','dist_unit = 0 and pr_no='.$pr_no);

$ordered_total_pcs = find_a_field('purchase_return_details','sum(dist_unit)','pr_no='.$pr_no); 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
   <meta charset="UTF-8">
<title>.: Purchase Ruturn :.</title>
<link href="../css/invoice.css" type="text/css" rel="stylesheet"/>
	<?php include("../../../../public/assets/css/theme_responsib_new_table_report.php");?>
<script type="text/javascript">



function hide()



{



    document.getElementById("pr").style.display="none";



}



</script>
<style type="text/css">



<!--
.header table tr td table tr td table tr td table tr td {
	color: #000;
}

/*@media print{
.footer {
   position: fixed;
   left: 0;
   bottom: 0;
   width: 100%;

   color: white;
   text-align: center;
}
}*/
-->
<?php /*?>div.page_brack
{
    page-break-after:always;
}<?php */?>



@font-face {
  font-family: 'MYRIADPRO-REGULAR';
  src: url('MYRIADPRO-REGULAR.OTF'); /* IE9 Compat Modes */

}

@font-face {
  font-family: 'TradeGothicLTStd-Extended';
  src: url('TradeGothicLTStd-Extended.otf'); /* IE9 Compat Modes */

}


@font-face {
  font-family: 'Humaira demo';
  src: url('Humaira demo.otf'); /* IE9 Compat Modes */

}


@media print{
.footer {
   position: fixed;
   left: 0;
   bottom: 0;
   width: 100%;

   
   text-align: center;
}
}

@media print {
  .brack {page-break-after: always;}
}

#pr input[type="button"] {
	width: 70px;
	height: 25px;
	background-color: #6cff36;
	color: #333;
	font-weight: bolder;
	border-radius: 5px;
	border: 1px solid #333;
	cursor: pointer;
}

</style>
</head>
<body style="font-family:Tahoma, Geneva, sans-serif; font-size: 10px;">

<div class="page_brack" >

<table width="1000" border="0" cellspacing="0" cellpadding="0" align="center">

  
  <thead>
  <tr>
    <td>
	
	<div class="header">
		<table class="table1">
		<tr>
		<td class="logo">
			<img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$group->id?>.png" class="logo-img"/>
		</td>
		
	<td class="titel">
				<h2 class="text-titel"> <?=$group->company_name?> </h2>			
				<h6 ><p class="text"><?=$group->address?></p>
				<p class="text">Cell: <?=$group->mobile?>. Email: <?=$group->email?> <br> <?=$group->vat_reg?></p><h6>
		</td>
		
		<td class="Qrl_code">
					<?='<img class="barcode Qrl_code_barcode" alt="'.$barcodeText.'" src="barcode.php?text='.$barcodeText.'&codetype='.$barcodeType.'&orientation='.$barcodeDisplay.'&size='.$barcodeSize.'&print='.$printText.'"/>' ?>
			<p class="qrl-text"><?=$dealer->pr_no?></p>
		</td>
		
		</tr>
		 
		</table>
	</div>
	
	
	</td>
  </tr>
  
  
  


 
 
 
 
 <tr> <td><hr /></td></tr>

 
  
 
  
  
  <tr> <td>
  <table width="100%" border="0" cellspacing="0" cellpadding="0"  style="font-size:12px">
  
  <tr><td>&nbsp;</td></tr>
  
  	<tr height="30">
  	  <td width="25%" valign="top"></td>
  	  <td width="50%"  style="text-align:center; "><span style="color:#FFF; font-size:18px; background:#CCCCCC; padding:8px 40px; color:#000000; font-weight:bold; border: 2px solid #000000; border-radius: 5px; ">
	  PURCHASE RETURN CHALAN </span> </td>
  	  <td width="25%" align="right" valign="right">&nbsp;</td>
	  </tr>
	  
	  <tr><td>&nbsp;</td></tr>
	 
  </table>
  
  </td></tr>
  
  
  
 
	  
	  
	   
  
  
  <tr>

	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
		
		

		  <tr>

		    <td valign="top">

		      <table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:13px">
			  
			  
			  
			  
			  
			  
			  
			  <tr>
				  
				  <td><table width="100%" border="1" cellspacing="0" cellpadding="5" style=" ">

		            <tr>

		              <td ><span style="font-size:14px; font-weight:bold;" class="style8"> Return Chalan No: <?php echo $dealer->pr_no?> &nbsp;</span></td>
		              </tr>

		            </table></td>

		          <td><table width="100%" border="1" cellspacing="0" cellpadding="5" style=" ">

		            <tr>

		              <td ><span style="font-size:14px; font-weight:bold; float: left;" class="style8"> Chalan Date:
                            <?=date("j-M-Y",strtotime($dealer->entry_time));?>
                     &nbsp;</span></td>
		              </tr>

		            </table></td>
		          </tr>

		        

                  <tr>
				  
				  <td><table width="100%" border="1" cellspacing="0" cellpadding="5" style=" ">

		            <tr>

		              <td ><span style="font-size:14px; " class="style8">
		               Customer:  <?php echo $dealer->vendor_name?>
		              &nbsp;</span></td>
		              </tr>

		            </table></td>

		          <td><table width="100%" border="1" cellspacing="0" cellpadding="5" style=" ">

		            <tr>

		              <td ><span style="font-size:14px; " class="style8"> Type: <?php
if ($return_master->return_type == 1) {
    echo "GRN";
} else {
    echo "Bulk";
}
?>
  &nbsp;</span></td>
		              </tr>

		            </table></td>
		          </tr>

		        <tr>

		          <td><table width="100%" border="1" cellspacing="0" cellpadding="5">

		            <tr>

		              <td  valign="top"><span style="font-size:14px; " class="style8">VAT No: <?=$dealer->vat_reg?>&nbsp;</span></td>
		              </tr>

		            </table></td>
					
					<td><table width="100%" border="1" cellspacing="0" cellpadding="5">

		            <tr>

		              <td  valign="top"><span style="font-size:14px; " class="style8">Contact No: <?php echo $dealer->contact_no?>&nbsp;</span></td>
		              </tr>

		            </table></td>
		          </tr>
				  
				  
				  <tr>

		          <td><table width="100%" border="1" cellspacing="0" cellpadding="5">

		            <tr>

		              <td  valign="top"><span style="font-size:14px; " class="style8">C.R No: <?php echo $dealer->cr_no?>&nbsp;</span></td>
		              </tr>

		            </table></td>
					
					<td><table width="100%" border="1" cellspacing="0" cellpadding="5">

		            <tr>

		              <td  valign="top"><span style="font-size:14px; " class="style8">Address: <?php echo $dealer->address?>&nbsp;</span></td>
		              </tr>

		            </table></td>
		          </tr>
					<td><table width="100%" border="1" cellspacing="0" cellpadding="5">

		            <tr>

		              <td  valign="top"><span style="font-size:14px; " class="style8">GRN Number: <a target="_blank" href="../po_receiving/chalan_view2.php?v_no=<?=$return_master->invoice_no ?> "><?php echo $return_master->invoice_no?></a>&nbsp;</span></td>
		              </tr>

		            </table></td>
		        

                  
		        </table>		      </td>
<?php /*?>
			<td width="30%"><table width="100%" border="1" cellspacing="0" cellpadding="0"  style="font-size:13px">
			
			
	

			  <tr>

			    <td align="center" valign="middle"><img style="margin:0; padding:0;"  src="https://chart.googleapis.com/chart?chs=140x140&cht=qr&chl=<?=$group->group_name?>&choe=UTF-8" title="ERP COM BD"  /></td>
			    </tr>
				
				
				
				
				
			

			  

			  </table></td><?php */?>

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
  
  
   </thead>
  
 
  <tbody >
 
  <tr >
    <td valign="top">
      
      <table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="5"  style="font-size:12px"  >
       
       
<tr>

<th width="4%" bgcolor="#CCCCCC">SL</th>

<th width="6%" bgcolor="#CCCCCC">Code</th>
<th width="29%" bgcolor="#CCCCCC">Item Description</th>
<th width="7%" bgcolor="#CCCCCC">Ctn Size </th>
<!--<th width="8%" bgcolor="#CCCCCC">Unit Price </th>-->
<th width="6%" bgcolor="#CCCCCC">Ctn</th>
<th width="7%" bgcolor="#CCCCCC">Pcs</th>
<?php /*?><th width="7%" bgcolor="#CCCCCC"><span role="presentation" dir="ltr">Net  Amount</span></th><?php */?>
</tr>


        
   <? 

//, (a.init_pkt_unit*a.unit_price) as Total,(a.init_pkt_unit-a.inStock_ctn) as Shortage

  $res='select  s.sub_group_name,  b.item_name, a.*
   from purchase_return_details a, item_info b, item_sub_group s 
   where b.item_id=a.item_id  and b.sub_group_id=s.sub_group_id and a.pr_no='.$pr_no.' order by a.pr_no ';
   
   
   $i=1;

$query = db_query($res);

while($data=mysqli_fetch_object($query)){

?>
        <tr>

<td><?=$i++?></td>

<td><?=$data->item_id?></td>
<td><?=$data->item_name?></td>
<td><?=$data->pkt_size?></td>
<?php /*?><td><?=$data->unit_price?></td><?php */?>
<td><?=$data->pkt_unit?></td>
<td><?=$data->total_unit; $total_qty+=$data->total_unit;?></td>
<?php /*?><td><?=$data->total_amt; $tot_total_amt +=$data->total_amt;?></td><?php */?>
</tr>
        
        <?  } ?>
        <tr>

<td colspan="5"><div align="right"><strong>Sub Total:</strong></div></td>

<td><strong>
  <?=number_format($total_qty,2);?>
</strong></td>
</tr>

 <?php /*?><? if($return_master->vat>0) {?>
      <tr  align="right">
        <td colspan="7"><strong>VAT (<?=number_format($return_master->vat,2)?>%):</strong></td>
        <td style="text-align:left"><strong>
          <?  echo number_format($tax_total=(($tot_total_amt*$return_master->vat)/100),2);?>
        </strong></td>
      </tr>
	  <? }?>
	  
	  <tr>
        <td   align="right" colspan="7"><strong>Net Amount: </strong></td>
        <td align="left"><strong><? echo number_format($payable_amount=($tot_total_amt+$tax_total),2);?></strong></td>
      </tr><?php */?>
	  
      </table>      
	  </td>
  </tr>
  

  
  </tbody>
  
	
	
	<tfoot >

	<tr>
		<td>
	
	 <div class="footer"> 
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
		  
		  <?php $uid=$return_master->entry_by;
		   echo find_a_field('user_activity_management','fname','user_id="'.$uid.'"')?> </br> 
		   <?=$return_master->entry_at;?></td>
		  <td align="center"></td>
		  <td align="center"></td>
		  </tr>
		<tr>
		  <td align="center" >---------------------------------</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">---------------------------------</td>
		  </tr>
		<tr>
		  <td align="center"></td>
		  <td align="center"></td>
		  <td align="center"></td>
		  </tr>
		<tr style="font-size:12px">
            <td align="center" width="25%"><strong>Sales Officer </strong></td>
		    <td  align="center" width="25%">&nbsp;</td>
		    <td  align="center" width="25%"><strong>Customer</strong></td>
		    </tr>
		<tr style="font-size:12px">
		  <td align="center" colspan="4"><?php include("../../../assets/template/report_print_buttom_content.php");?></td>
		  
		  </tr>
		
		
	</table>
	
	</div>
	
</td>
	  </tr>
	
	</tfoot>
	
  
</table>


</div>



</body>
</html>
