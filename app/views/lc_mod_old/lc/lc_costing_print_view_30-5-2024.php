<?php



//



//====================== EOF ===================



//var_dump($_SESSION);




 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$group = find_all_field('user_group','','id="'.$_SESSION['user']['group'].'"');

//require_once ('../../../acc_mod/common/class.numbertoword.php');

$lc_no = $_REQUEST['lc_no'];
		
		$barcode_content = $lc_no;
		  $barcodeText = $barcode_content;
          $barcodeType='code128';
		  $barcodeDisplay='horizontal';
          $barcodeSize=40;
          $printText='';
//$bnk_pay_data = find_all_field('lc_bank_payment','','id='.$payment_id);

$bnk_data = find_all_field('lc_bank_entry','','lc_no='.$lc_no); 

$lc_data = find_all_field('lc_number_setup','','id='.$lc_no); 

$po_data = find_all_field('lc_purchase_master','','lc_no='.$lc_no);



$group_data = find_all_field('user_group','','id='.$po_data->group_for);


$grn_value_usd = find_a_field('lc_purchase_receive','sum(amount_usd)','lc_no='.$lc_no);



$item_sql= "select d.id as order_no,i.item_name from lc_purchase_master m ,lc_purchase_invoice d,item_info i  where m.po_no=d.po_no and i.item_id=d.item_id and m.lc_no= ".$lc_no."";
$item_query=db_query($item_sql);
$p=0;
while($item_data=mysqli_fetch_object($item_query)){
$p++;
$item_name[$p] = $item_data->item_name;
$order_no[$p]= $item_data->order_no;
}


	 $sql = "select sum(pay_amt_in) pay_amt_in,rate,bill_type,order_no from lc_bill_payment  where lc_no=".$lc_no." group by bill_type,order_no";
$query = db_query($sql);

while($data=mysqli_fetch_object($query)){
	$journal_payment[$data->bill_type][$data->order_no] = $data->pay_amt_in;
	$journal_payment_rate[$data->bill_type][$data->order_no] = $data->rate;
}


$sql_p = "select sum(pay_amt_in) pay_amt_in,rate,bill_type,order_no from lc_provision_payment  where lc_no=".$lc_no." group by bill_type,order_no";
$query_p = db_query($sql_p);

while($data_p=mysqli_fetch_object($query_p)){
	$provision_payment[$data_p->bill_type][$data_p->order_no] = $data_p->pay_amt_in;
	$provision_payment_rate[$data_p->bill_type][$data_p->order_no] = $data_p->rate;
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?=$lc_data->lc_number;?></title>
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


.jvbutton {
    display: block;
	float:left;
    width: auto;
    height: 25px;
    background: #4E9CAF;
    padding: 5px 20px 5px 20px;
    text-align: center;
    border-radius: 5px;
    color: white;
    font-weight: bold;
    line-height: 25px;
	
	margin-right: 20px;
}


.jvbutton:hover {

    color: #000000;
    font-weight: bold;

}

</style>
</head>
<body style="font-family:Tahoma, Geneva, sans-serif; font-size: 10px;">
<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
<!--<thead>-->
  <tr>
    <td colspan="2"><div class="header">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                     
					 <tr>
						<td><div class="header">
							<table class="table1">
							<tr>
							<td class="logo">
								<img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$_SESSION['proj_id']?>.png" class="logo-img"/>
							</td>
							
							<td class="titel">
									<h2 class="text-titel"> <?=$group->group_name?> </h2>			
									<p class="text"><?=$group->address?></p>
									<p class="text">Cell: <?=$group->mobile?>. Email: <?=$group->email?> <br> <?=$group_data->vat_reg?></p>
									<p class="text">
										 <? $war=find_all_field('warehouse','','warehouse_id='.$all->warehouse_id);
										  echo $war->warehouse_name;?>
									</p>
							</td>
							
							
							<td class="Qrl_code">
										<?='<img class="barcode Qrl_code_barcode" alt="'.$barcodeText.'" src="barcode.php?text='.$barcodeText.'&codetype='.$barcodeType.'&orientation='.$barcodeDisplay.'&size='.$barcodeSize.'&print='.$printText.'"/>' ?>
								<p class="qrl-text"><?=$po_data->pi_no?></p>
							</td>
							
							</tr>
							 
							</table>
						</div></td>
					  </tr>
					 
					 
					 
					 
					  
                    </table></td>
                </tr>
              </table></td>
          </tr>
          <tr>          </tr>
        </table>
      </div></td>
  </tr>
  
 <!--</thead>-->
 
 
 
 
 
 
  <tbody>
 
  <tr> <td colspan="2"><hr /></td></tr>
 
  
  
  <tr> <td colspan="2">
  <table width="100%" border="0" cellspacing="0" cellpadding="0"  style="font-size:12px">
  
  	<tr height="30">
  	  <td valign="top"></td>
  	  <td  style="text-align:center; color:#FFF; font-size:18px; padding:0px 0px 10px 0px; color:#000000; font-weight:bold;"><span style="text-decoration:underline">
	  L/C No: <?=$lc_data->lc_number?></span> </td>
  	  <td valign="right" align="right"><strong><?php /*?>Order Date:
          <?=date("d M, Y",strtotime($master->po_date))?><?php */?>
  	  </strong></td>
	  </tr>
	
	<tr>
		<td width="5%" valign="top">&nbsp;</td>
			<td width="89%" valign="middle" align="center">&nbsp;</td>
		<td width="6%" valign="right" align="right">&nbsp;</td>
	</tr>
  </table>
  
  </td></tr>
  
  
  <tr> <td colspan="2">&nbsp;</td></tr>
  
  
  
 <tr> <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">


		  <tr>


		    <td width="68%" valign="top">


		      <table width="96%" border="0" cellspacing="0" cellpadding="3"  style="font-size:12px">
		        <tr>
		          <td align="left" valign="middle"><strong>L/C  No. </strong></td>
		          <td>: &nbsp;<?=$lc_data->lc_number?></td>
	            </tr>
		        <tr>
		          <td align="left" valign="middle"><strong>L/C Type </strong></td>
		          <td>: &nbsp;<?= find_a_field('lc_type','lc_type','id="'.$bnk_data->lc_type.'"');?></td>
	            </tr>
		        
		        
		        <tr>
		          <td align="left" valign="middle"><strong> Vendor Name</strong></td>
		          <td>: &nbsp;<?= find_a_field('vendor_foreign','vendor_name','vendor_id="'.$po_data->vendor_id.'"');?></td>
	            </tr>
		        <tr>
		          <td align="left" valign="middle"><strong>Vendor Agent</strong></td>
		          <td>: &nbsp;<?= find_a_field('agent_info','agent_name','agent_id="'.$po_data->supplier_agent.'"');?></td>
	            </tr>
	          </table>		      </td>


			<td width="32%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="2"  style="font-size:11px">
			
			
			
			<tr>


                <td width="51%" align="right" valign="middle"><strong> PI No: </strong></td>


			    <td width="49%"><table width="100%" border="1" cellspacing="0" cellpadding="1">


                    <tr height="20">


                      <td> &nbsp;<?=$po_data->pi_no?></td>
                    </tr>


                </table></td> </tr>




			  <tr>


                <td width="51%" align="right" valign="middle"><strong>PI Date:</strong></td>


			    <td width="49%"><table width="100%" border="1" cellspacing="0" cellpadding="1">
                  <tr height="20">
                    <td>
                      &nbsp;<?=date("d M, Y",strtotime($po_data->pi_date))?>                    </td>
                  </tr>
                </table></td> </tr>
				
				
				<tr>

				<td align="right" valign="middle"><strong> <span id="page14R_mcid21"><span role="presentation" dir="ltr">Import </span></span> L/C No: </strong></td>


			    <td><table width="100%" border="1" cellspacing="0" cellpadding="1">
                  <tr height="20">
                    <td>&nbsp;<?=$bnk_data->bank_lc_no?></td>
                  </tr>
                </table></td>
			    </tr>
				
				
				<tr>

				<td align="right" valign="middle"><strong>  L/C Date: </strong></td>


			    <td><table width="100%" border="1" cellspacing="0" cellpadding="1">
                  <tr height="20">
                    <td>
                      &nbsp;<?=date("d M, Y",strtotime($bnk_data->lc_issue_date))?>                    </td>
                  </tr>
                </table></td>
			    </tr>
				
				
				<tr>

				<td align="right" valign="middle"><strong>  L/C Value: </strong></td>


			    <td><table width="100%" border="1" cellspacing="0" cellpadding="1">
                  <tr height="20">
                    <td>
                      &nbsp;<?=number_format($bnk_data->lc_value,2);?>                   </td>
                  </tr>
                </table></td>
			    </tr>


			  


			  


		    </table></td>
		  </tr>


		</table>		</td></tr>
  
  
 
  <tr>
    <td width="95"><div id="pr">
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
      </div>	  </td>
	  
	  
	  <td width="705">&nbsp;</td>
  </tr>
  
  
  <tr>
  	<td colspan="2">
		<table width="100%" border="0" bordercolor="#000000" cellspacing="3" cellpadding="3" class="tabledesign1" >
        <tr>
          <td colspan="4"><table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="5"  style="font-size:12px">
        
        <tr>
          <td colspan="<?=($p*4)+2?>" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>L/C Provision Details </strong></td>
          </tr>
        <tr>
          <td rowspan="3" width="4%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>SL</strong></td>
          <td  rowspan="3" width="38%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong> Payment Type </strong></td>
          <td  colspan="<?=$p*4?>" width="12%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Item Name </strong></td>     
        </tr>
		<tr>
			<? for($j=1;$j<=$p;$j++){ ?>
					<td colspan="4" width="12%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong><?=$item_name[$j]?></strong></td>
			
			<? } ?>
		</tr>
		<tr>
		<? for($k=1;$k<=$p;$k++){ ?>
			<td  width="12%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Provision Rate</strong></td>
			<td  width="12%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Provision </strong></td>
			<td  width="12%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Pre Cost Rate </strong></td>
			<td  width="12%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Pre Cost </strong></td>
			<? } ?>
		
		</tr>

        
<?  
			
 $sql = "select tr_no, jv_no  from journal where note='LC Journal' and tr_id=".$lc_no." group by jv_no ";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$jv_no[$data->tr_no]=$data->jv_no;

}
			
		 $sqlc = 'SELECT  b.bill_type,b.id as bill_type_id from lc_bill_type b, lc_bill_category c 
		 where b.id=c.bill_type    group by b.bill_type';
			$queryc=db_query($sqlc);
			while($datac = mysqli_fetch_object($queryc)){

			?>
        <tr style="font-size:12px;">
          <td align="center" valign="top"><?=++$kksm;?></td>
          <?php /*?><td align="left" valign="top">
		  <a href="../../../acc_mod/pages/files/general_voucher_print_view_from_journal.php?jv_no=<?=$jv_no[$datac->payment_no]?>" target="_blank"><?=$datac->payment_no?> </a></td><?php */?>
          
          <td align="left" valign="top"><?=$datac->bill_type?></td>
		  
		  <? for($i=1;$i<=$p;$i++){ ?>
		  <td align="right" valign="top"><?=number_format($journal_payment_rate[$datac->bill_type_id][$order_no[$i]],2); ?></td>
          <td align="right" valign="top"><?=number_format($journal_payment[$datac->bill_type_id][$order_no[$i]],2); $tot_pay_amt_in[$order_no[$i]] +=$journal_payment[$datac->bill_type_id][$order_no[$i]]; ?></td>
		  <td align="right" valign="top"><?=number_format($provision_payment_rate[$datac->bill_type_id][$order_no[$i]],2); ?></td>
          <td align="right" valign="top"><?=number_format($provision_payment[$datac->bill_type_id][$order_no[$i]],2); $tot_pay_amt_out[$order_no[$i]] +=$provision_payment[$datac->bill_type_id][$order_no[$i]]; ?></td>
		  
		  
		  <? } ?>
		  
		  
        </tr>
        
        <? }?>
        <tr style="font-size:12px;">
        <td colspan="2" align="right" valign="middle"><strong>Total: <? $grn_value_usd; ?> </strong></td>
		<? for($r=1;$r<=$p;$r++){ ?>
		<td></td>
        <td align="right" valign="middle"><strong><?=number_format($tot_pay_amt_in[$order_no[$r]],2) ;?>  </strong></td>
		<td></td>
        <td align="right" valign="middle"><strong><?=number_format($tot_pay_amt_out[$order_no[$r]],2) ;?></strong></td>
		
		<? } ?>
        </tr>
        <?php /*?><tr style="font-size:12px;">
          <td colspan="4" align="right" valign="middle"><strong>Total Expenses:</strong></td>
          <td colspan="2" align="center" valign="middle">
		  <strong><?=number_format($total_exp_bdt=($tot_pay_amt_in-$tot_pay_amt_out),2);?> <? $exchange_rate_bdt = $total_exp_bdt/$grn_value_usd;?></strong></td>
          </tr>
<?php */?>		
		
		
		
	
        
      </table></td>
		  </tr>
		</table>
	
	</td>
  
  </tr>
  
  
  
  <? if($grn_value_usd>0) {?>
  <tr>
  	<td colspan="2">
		<table width="100%" border="0" bordercolor="#000000" cellspacing="3" cellpadding="3" class="tabledesign1" >
        <tr>
          <td colspan="4"><table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="5"  style="font-size:12px">
        
        <tr>
          <td colspan="6" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>L/C Goods Recive Details </strong></td>
          </tr>
        <tr>
          <td width="4%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>SL</strong></td>
          <td width="12%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Date</strong></td>
          <td width="27%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Warehouse</strong></td>
          <td width="28%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Item Name </strong></td>
          <td width="13%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Unit</strong></td>
          <td width="16%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Quantity</strong></td>
          </tr>

        
<?  
			
	
		
		
		$sqlr = 'SELECT b.item_name, b.unit_name, a.rec_date, a.warehouse_id, a.qty from lc_purchase_receive a, item_info  b
		 where a.item_id=b.item_id and a.lc_no="'.$lc_no.'" group by a.id order by a.rec_date,b.item_name ';
			$queryr=db_query($sqlr);
			while($datar = mysqli_fetch_object($queryr)){

			?>
        <tr style="font-size:12px;">
          <td align="center" valign="top"><?=++$kksr;?></td>
          <td align="left" valign="top"><?=date("d-m-Y",strtotime($datar->rec_date))?>   </td>
          <td align="left" valign="top"><?=find_a_field('warehouse','warehouse_name','warehouse_id='.$datar->warehouse_id); ?></td>
          <td align="left" valign="top"><?=$datar->item_name;?></td>
          <td align="left" valign="top"><?=$datar->unit_name;?></td>
          <td align="right" valign="top"><?=number_format($datar->qty,2); $tot_qty +=$datar->qty; ?></td>
          </tr>
        
        <? }?>
        <tr style="font-size:12px;">
        <td colspan="5" align="right" valign="middle"><strong>  Total: </strong></td>
        <td align="right" valign="middle"><strong><?=number_format($tot_qty,2) ;?>  </strong></td>
        </tr>
        
		
		
		
		
	
        
      </table></td>
		  </tr>
		</table>
	
	</td>
  
  </tr>

  <? }?>
  <tr>
    <td colspan="2">
      
      <table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="5"  style="font-size:12px">
       
		
		
		
		 
        <tr>
          <td width="4%" rowspan="2" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>SL</strong></td>
          <td width="27%" rowspan="2" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Item Name </strong></td>
          <td width="5%" rowspan="2" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Unit  </strong></td>
          <td colspan="5" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>PO Details </strong></td>
          <td colspan="3" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>GRN Details  </strong></td>
          <td width="9%" rowspan="2" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Pre Cost Price</strong></td>
          <td width="9%" rowspan="2" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Pre Cost Value</strong></td>
          <td width="9%" rowspan="2" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Cost Price </strong></td>
          <td width="12%" rowspan="2" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Value (BDT) </strong></td>
        </tr>
        <tr>
          <td width="4%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Qty</strong></td>
          <td width="8%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Rate($)</strong></td>
          <td width="10%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Amount($)</strong></td>
		  
          <td width="8%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Rate(BDT)</strong></td>
          <td width="10%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Amount(BDT)</strong></td>
          <td width="4%" align="center" bgcolor="#CCCCCC"><strong>Qty</strong></td>
          <td width="7%" align="center" bgcolor="#CCCCCC"><strong>Rate($)</strong></td>
          <td width="10%" align="center" bgcolor="#CCCCCC"><strong>Amount($)</strong></td>
        </tr>
        
        <?  
		
		
  $sql = "select order_no, sum(qty) as grn_qty, rate_usd as grn_rate_usd, sum(amount_usd) as grn_amount_usd  from lc_purchase_receive where lc_no=".$lc_no." group by order_no ";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$grn_qty[$data->order_no]=$data->grn_qty;
$grn_rate_usd[$data->order_no]=$data->grn_rate_usd;
$grn_amount_usd[$data->order_no]=$data->grn_amount_usd;
}

//provision data

$pro_sql = "select sum(rate) as rate,order_no from lc_provision_payment where lc_no=".$lc_no." group by order_no";
$pro_query = db_query($pro_sql);
while($pro_data=mysqli_fetch_object($pro_query)){
	$pro_rate[$pro_data->order_no] = $pro_data->rate;

}	

			$sql="select r.lc_part,p.lc_part as part_name from lc_purchase_receive r,lc_part p  where p.id=r.lc_part and r.lc_no= ".$lc_no."  group by r.lc_part";
			$query = db_query($sql);
			while($lc=mysqli_fetch_object($query)){
		
			?>
			<tr>
				<th colspan="15">LC PART : <?=$lc->part_name?></th>
			</tr>
			
			<?
			$tot_amount_usd=0;
			$tot_grn_amt_usd=0;
			$tot_pro_amt_bdt=0;
			$tot_cost_amt_bdt=0;
			
			
			 $sqlc = 'select d.*, i.item_name,r.lc_part from lc_purchase_master m, lc_purchase_invoice d,lc_purchase_receive r, item_info i where m.po_no=d.po_no and i.item_id=d.item_id and d.id=r.order_no and r.lc_part="'.$lc->lc_part.'" and m.lc_no='.$lc_no.' 
			 group by d.id order by d.id';
			$queryc=db_query($sqlc);
			while($datac = mysqli_fetch_object($queryc)){
			
			
			
			
			$provision_amount=$pro_rate[$datac->id]* $grn_qty[$datac->id]; 
			
			?>
        <tr style="font-size:12px;">
          <td align="center" valign="top"><?=++$kk;?></td>
          <td align="left" valign="top"><?=$datac->item_name;?></td>
          <td align="left" valign="top"><?=$datac->unit_name;?></td>
          <td align="left" valign="top"><?=number_format($datac->qty,2);  $tot_qty +=$datac->qty;?></td>
          <td align="right" valign="top"><?=$datac->rate_usd;?></td>
          <td align="right" valign="top"><?=number_format($datac->amount_usd,2);  $tot_amount_usd +=$datac->amount_usd;?></td>
          <td align="right" valign="top"><?=$datac->rate_bdt;?></td>
          <td align="right" valign="top"><?=number_format($datac->amount_bdt,2);  $tot_amount_bdt +=$datac->amount_bdt;?></td>
          <td align="left" valign="top"><?=number_format($grn_qty[$datac->id],2);  ?></td>
          <td align="right" valign="top"><?=$grn_rate_usd[$datac->id]?></td>
          <td align="right" valign="top"><?=number_format($grn_amount_usd[$datac->id],2);  $tot_grn_amt_usd +=$grn_amount_usd[$datac->id];?></td>
          <td align="right" valign="top"><?=$pro_rate[$datac->id];?></td>
          <td align="right" valign="top"><?=number_format($provision_amount,2); $tot_pro_amt_bdt +=$provision_amount; ?></td>
          <td align="right" valign="top"><?=$cost_price_bdt = $tot_pay_amt_in[$datac->id]/ $grn_qty[$datac->id];?></td>
          <td align="right" valign="top"><?=number_format($tot_pay_amt_in[$datac->id],2);  $tot_cost_amt_bdt +=$tot_pay_amt_in[$datac->id];?></td>
        </tr>
        
        <? } ?>
		
        <tr style="font-size:12px;">
        <td colspan="3" align="right" valign="middle"><strong> Total:</strong></td>
        <td align="right" valign="middle">&nbsp;</td>
        <td align="right" valign="middle">&nbsp;</td>
		 
        <td align="right" valign="middle"><strong>
          <?=number_format($tot_amount_usd,2) ;?>
        </strong></td>
		<td align="right" valign="middle">&nbsp;</td>
        <td align="right" valign="middle">&nbsp;</td>
        <td align="right" valign="middle">&nbsp;</td>
        <td align="right" valign="middle">&nbsp;</td>
        <td align="right" valign="middle"><strong>
          <?=number_format($tot_grn_amt_usd,2) ;?>
        </strong></td>
        <td align="right" valign="middle">&nbsp;</td>
        <td align="right" valign="middle"><strong><?=number_format($tot_pro_amt_bdt,2) ;?></strong></td>
        <td align="right" valign="middle">&nbsp;</td>
        <td align="right" valign="middle"><strong>
          <?=number_format($tot_cost_amt_bdt,2) ;?>
        </strong></td>
        </tr>
		
		<?  } ?>
		
		
      </table>      </td>
  </tr>
  

  
  
  
  
  
  
  
  
  
  <tr>
  	<td colspan="3">
			<table width="100%" border="0" bordercolor="#000000" cellspacing="3" cellpadding="3" class="tabledesign1" >
        
        
        
		  
		  <tr>
		<td colspan="2" align="right">&nbsp;</td>
          <td colspan="2" width="43%" align="right">		  </td>
          </tr>
		  
		  <tr>
		<td colspan="4" align="left" style="font-size:16px">&nbsp;</td>
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
          <td colspan="4" align="left">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4" align="left">&nbsp;</td>
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
      </table>	</td>
  </tr>
  </tbody>
	
	
	<!--<tfoot>-->
	<tr>
		<td colspan="2">
	
	
	<!-- style="border:1px solid #000; color: #000;"-->
	      <div class="footer"> 
	
	<table width="100%" cellspacing="0" cellpadding="0"  >
	
	
		
		<tr>
            <td colspan="4">&nbsp;  </td>
		</tr>
		
		<tr>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">-------------------------------------</td>
		  </tr>
		<tr style="font-size:12px">
            <td align="center" width="25%">&nbsp;</td>
		    <td  align="center" width="25%">&nbsp;</td>
		    <td  align="center" width="25%">&nbsp;</td>
		    <td align="center"  width="25%"><strong>Authorized By </strong></td>
		</tr>
		
		<tr>
            <td colspan="2"><!--Prepared By :
                <?=find_a_field('user_activity_management','fname','user_id='.$master->entry_by);?>,&nbsp; Prepared At :
                <?=$master->entry_at?> --> </td>
		    <td colspan="2">&nbsp;</td>
	      </tr>
	
	<tr>
            <td colspan="4">  <?php include("../../../assets/template/report_print_buttom_content.php");?> </td>
		</tr>
	
	</table>
	  </div>	</td>
  </tr>
  
  <!--</tfoot>-->
</table>
</body>
</html>
