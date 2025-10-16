<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

//require_once ('../../../acc_mod/common/class.numbertoword.php');

$lc_no = $_REQUEST['lc_no'];

//$bnk_pay_data = find_all_field('lc_bank_payment','','id='.$payment_id);

$bnk_data = find_all_field('lc_bank_entry','','lc_no='.$lc_no); 

$lc_data = find_all_field('lc_number_setup','','id='.$lc_no); 

$lc_data2 = find_all_field('lc_bank_entry','','lc_no='.$lc_no); 

$po_data = find_all_field('lc_purchase_master','','lc_no='.$lc_no);



$group_data = find_all_field('user_group','','id='.$po_data->group_for);


$grn_value_usd = find_a_field('lc_purchase_receive','sum(amount_usd)','lc_no='.$lc_no);



 


$sql = "select sum(pay_amt_in) pay_amt_in,bill_type,order_no from lc_bill_payment  where lc_no=".$lc_no." group by bill_type,order_no";
$query = db_query($sql);

while($data=mysqli_fetch_object($query)){
	$journal_payment[$data->bill_type] = $data->pay_amt_in;
}


$sql_p = "select sum(pay_amt_in) pay_amt_in,bill_type,order_no from lc_provision_payment  where lc_no=".$lc_no." group by bill_type,order_no";
$query_p = db_query($sql_p);

while($data_p=mysqli_fetch_object($query_p)){
	$provision_payment[$data_p->bill_type] = $data_p->pay_amt_in;
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?=$lc_data->lc_number;?></title>
<link href="../css/invoice.css" type="text/css" rel="stylesheet"/>
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
                        <td width="20%">
                        <!--<img src="../../../logo/<?=$_SESSION['user']['group']?>.png" width="65%" />-->
                        <td width="60%"><table  width="80%" border="0" align="center" cellpadding="3" cellspacing="0">
                            <tr>
                              <td style="text-align:center; color:#000; font-size:14px; font-weight:bold;">
						
								<p style="font-size:20px; color:#000000; margin:0; padding:0; text-transform:uppercase;"><?=find_a_field('user_group','group_name','id='.$lc_data->group_for)?></p>
								<p style="font-size:14px; font-weight:300; color:#000000; margin:0; padding:0;"><?=find_a_field('user_group','address','id='.$lc_data->group_for)?></p>                              </td>
                            </tr>
                            <tr>


        <!--<td bgcolor="#666666" style="text-align:center; color:#FFF; font-size:18px; font-weight:bold;">WORK ORDER </td>-->
      </tr>
                          </table>
                      <td width="20%">                      </tr>
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
	  Commercial Invoice - LC No: <?=$lc_data2->bank_lc_no?></span> </td>
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
          <td colspan="6" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>L/C Payment Details </strong></td>
          </tr>
        <tr>
          <td width="4%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>SL</strong></td>
          <td width="17%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>TR No </strong></td>
          <td width="16%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Date</strong></td>
          <td width="38%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong> Payment Type </strong></td>
          <td width="12%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>DR Amt </strong></td>
          <td width="13%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>CR Amt </strong></td>
        </tr>

        
<?  
			
  $sql = "select tr_no, jv_no,tr_id  from journal where tr_from in('Payment','Journal') and tr_id=".$lc_no." group by jv_no ";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$jv_no[$data->tr_no]=$data->jv_no;

}
//	  $sqlitem = 'SELECT sum(i.payment_amt) as pay_amt_in,a.payment_no, a.payment_date, b.bill_type,i.lc_no,i.payment_id,i.item_id from lc_bill_payment a, lc_bill_type b, lc_bill_category c,item_wise_payment i 
//		 where b.id=c.bill_type and a.lc_no=i.lc_no and a.payment_no=i.payment_id and a.bill_category=c.id  and a.lc_no="'.$lc_no.'" and b.id=8 group by i.item_id ';
//			$queryitem=db_query($sqlitem);
//			while($dataquery = mysqli_fetch_object($queryitem)){
//			$item_wist_exp_amt[$dataquery->item_id]=$dataquery->pay_amt_in;
//			$tot_item_wise_pay_amt_cus_new+=$dataquery->pay_amt_in;
//			}	
		 // $tot_item_wise_pay_amt_cus_new;
		
		  $sqlc = 'SELECT sum(a.pay_amt_in) as pay_amt_in, sum(a.pay_amt_out) as pay_amt_out,   a.payment_no, a.payment_date, b.bill_type from lc_bill_payment a, lc_bill_type b, lc_bill_category c 
		 where b.id=c.bill_type and a.bill_category=c.id  and a.lc_no="'.$lc_no.'" group by a.payment_no order by a.payment_date,a.payment_no ';
			$queryc=db_query($sqlc);
			while($datac = mysqli_fetch_object($queryc)){

			?>
        <tr style="font-size:12px;">
          <td align="center" valign="top"><?=++$kksm;?></td>
          <td align="left" valign="top">
		  <a href="../../../acc_mod/pages/files/general_voucher_print_view_from_journal.php?jv_no=<?=$jv_no[$datac->payment_no]?>" target="_blank"><?=$datac->payment_no?> </a></td>
          <td align="left" valign="top"><?=date("d-m-Y",strtotime($datac->payment_date))?>   </td>
          <td align="left" valign="top"><?=$datac->bill_type?></td>
          <td align="right" valign="top"><?=number_format($datac->pay_amt_in,2); $tot_pay_amt_in +=$datac->pay_amt_in; ?></td>
          <td align="right" valign="top"><?=number_format($datac->pay_amt_out,2); $tot_pay_amt_out +=$datac->pay_amt_out; ?></td>
        </tr>
        
        <? }?>
        <tr style="font-size:12px;">
        <td colspan="4" align="right" valign="middle"><strong> Sub Total: <? $grn_value_usd; ?> </strong></td>
        <td align="right" valign="middle"><strong><?=number_format($tot_pay_amt_in,2) ;?>  </strong></td>
        <td align="right" valign="middle"><strong><?=number_format($tot_pay_amt_out,2) ;?></strong></td>
        </tr>
        <tr style="font-size:12px;">
          <td colspan="4" align="right" valign="middle"><strong>Total Expenses:</strong></td>
          <td colspan="2" align="center" valign="middle">
		  <strong><?=number_format($total_exp_bdt=($tot_pay_amt_in-$tot_pay_amt_out),2);?> <? //$exchange_rate_bdt = $total_exp_bdt/$grn_value_usd;?></strong></td>
          </tr>
		
		
		
		<?php 
		//$actual_exp_without_item=$total_exp_bdt-$tot_item_wise_pay_amt_cus_new;
		
			    $sql='select sum(payment_amt) as item_wise_pay,lc_no,item_id from item_wise_payment where 1 and lc_no="'.$lc_data->id.'" group by lc_no,item_id';
	  $query=db_query($sql);
	  while($row=mysqli_fetch_object($query)){
	   $tot_item_pay_amt[$row->lc_no][$row->item_id]=$row->item_wise_pay;
	  
	    $gr_tot_item_pay_amt+=$row->item_wise_pay;
	  }
	   // $gr_tot_item_pay_amt;
	// echo "tot  duty".$actual_duty_pay_common= $bill_wise_amt[6]-$gr_tot_item_pay_amt;
	// echo $total_exp_bdt;
	   // $total_pay_amt_without_partial=$total_exp_bdt-$gr_tot_item_pay_amt;
		    $total_pay_amt_without_partial=$total_exp_bdt-$gr_tot_item_pay_amt;
		?>
	
        
      </table>
	  
	  <table width="100%" border="1" align="center" id="grp" cellpadding="0" cellspacing="0" style="font-size:12px; text-transform:uppercase; border: 1px solid #FFFFFF;">
 <thead>
  <tr style="border:1px solid #000000;">
    <th width="26%" rowspan="2" >&nbsp;&nbsp;item name </th>

    <th width="6%" rowspan="2"><div align="center">Unit</div></th>

    <th colspan="3"><div align="center">Order Details </div></th>
    <th colspan="3"><div align="center">Received Details </div></th>
    <th width="8%" rowspan="2"><div align="center">Cost price </div></th>
    <th width="17%" rowspan="2"><div align="center">Value BDT </div></th>
  </tr>
  <tr style="border:1px solid #000000">
    <th width="5%"><div align="center">Qty</div></th>
    <th width="10%"><div align="center">Rate ($) </div></th>
    <th width="8%"><div align="center">value ($) </div></th>
    <th width="7%"><div align="center">Qty</div></th>
    <th width="7%"><div align="center">Rate ($) </div></th>
    <th width="6%"><div align="center">value ($) </div></th>
  </tr>
  </thead>

  <?
  
  
  if($_POST['fdate']!=''&&$_POST['tdate']!='') $date_con .= ' and c.chalan_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
  
  
	
 if($_POST['account_code']!='')
  $account_code_con=" and d.ledger_id=".$_POST['account_code'];
  
 if($_POST['bill_type']!='')
  $bill_type_con=" and bill_type=".$_POST['bill_type'];
  



  
     $sql = "select order_no, sum(qty) as rec_qty, rate_usd as rec_rate_usd, sum(amount_usd) as rec_amount_usd,po_no,item_id  from lc_purchase_receive where po_no=".$po_data->po_no." group by po_no,item_id ";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$rec_qty[$data->po_no][$data->item_id]=$data->rec_qty;
$rec_rate_usd[$data->po_no][$data->item_id]=$data->rec_rate_usd;
$rec_amount_usd[$data->po_no][$data->item_id]=$data->rec_amount_usd;
}
   
     $sql = "select  sum(qty) as rec_qty, rate_usd as rec_rate_usd, sum(amount_usd) as rec_amount_usd,po_no,item_id  from lc_purchase_invoice where po_no=".$po_data->po_no." group by po_no,item_id ";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$rec_qty_invoice[$data->po_no][$data->item_id]=$data->rec_qty;
$rec_rate_usd_invoice[$data->po_no][$data->item_id]=$data->rec_rate_usd;
$rec_amount_usd_invoice[$data->po_no][$data->item_id]=$data->rec_amount_usd;
}
 
        $sql = "select m.lc_no,  sum(r.amount_usd) as tot_rec_amt_usd,sum(r.qty) as tot_rec_qty  from lc_purchase_master m, lc_purchase_receive r where m.po_no=r.po_no and m.lc_no=".$lc_data->id." group by m.lc_no ";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$tot_rec_amt_usd[$data->lc_no]=$data->tot_rec_amt_usd;
$tot_rec_qty_get[$data->lc_no]=$data->tot_rec_qty;
}
            $sql = "select m.lc_no,  sum(r.amount_usd) as tot_rec_amt_usd,sum(r.qty) as rec_qty_inv from lc_purchase_master m, lc_purchase_invoice r where m.po_no=r.po_no and m.lc_no=".$lc_data->id." group by m.lc_no ";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$tot_rec_amt_invoice_usd[$data->lc_no]=$data->tot_rec_amt_usd;
$tot_rec_qty_invoice[$data->lc_no]=$data->rec_qty_inv;
}
	
       $sql = "SELECT p.*, i.item_name FROM lc_purchase_invoice p, item_info i WHERE p.item_id=i.item_id and  p.po_no=".$po_data->po_no." order  by  p.id ";
    $query = db_query($sql);
    while($data=mysqli_fetch_object($query)){$i++;


  ?>



<? //if ($due_amt=$data->invoice_amt-$payment_amt[$data->ledger_id][$data->tr_no]+$return_amt[$data->ledger_id][$data->tr_no]>0) {?>

  <tr bgcolor="<?=($i%2)?'#E8F3FF':'#fff';?>" style="border:1px solid #000000; ">
    <td><span class="style13" style="color:#000000; font-weight:700;">
&nbsp;&nbsp;<span class="style13" style="color:#000000; font-weight:700;">
<?=$data->item_name;?>
</span> </span></td>

    <td>
   &nbsp;&nbsp;  <?=$data->unit_name;?>    </td>

    <td><div align="right">
      <?=$data->qty;?>
    </div></td>
    <td><div align="right">
      <?=$data->rate_usd;?>
    </div></td>
    <td><div align="right">
      <?=number_format($data->amount_usd,2); $tot_amount_usd +=$data->amount_usd?>
    </div></td>
    <td><div align="right">
      <?=$rec_qty[$data->po_no][$data->item_id];
	 
	  ?>
	  
	  <input name="rec_qty_<?=$data->id?>" id="rec_qty_<?=$data->id?>" type="hidden" size="10"  value="<?=$rec_qty[$data->po_no][$data->item_id];?>" style="width:100px; height:25px;"  />
    </div></td>
    <td><div align="right">
      <?=$rec_rate_usd[$data->po_no][$data->item_id];?>
	  <input name="rec_rate_usd_<?=$data->id?>" id="rec_rate_usd_<?=$data->id?>" type="hidden" size="10"  value="<?=$rec_rate_usd[$data->po_no][$data->item_id];?>" style="width:100px; height:25px;"  />
    </div></td>
    <td><div align="right">
      <?=number_format($rec_amount_usd[$data->po_no][$data->item_id],2); $tot_rec_amount_usd +=$rec_amount_usd[$data->po_no][$data->item_id];?>
	   <input name="rec_amt_usd_<?=$data->id?>" id="rec_amt_usd_<?=$data->id?>" type="hidden" size="10"  value="<?=$rec_amount_usd[$data->po_no][$data->item_id];?>" style="width:100px; height:25px;"  />
    </div></td>
    <td><?php 
	
	//echo "tot_pay amt".$tot_item_pay_amt[$lc_data->id][$data->item_id];
if($tot_rec_amt_usd[$lc_data->id]>0){
 //echo $total_pay_amt_without_partial."pertial".$tot_item_pay_amt[$lc_data->id][$data->item_id]."<br>".$tot_rec_qty_get[$lc_data->id];
 
 $item_percentage_get=($rec_amount_usd[$data->po_no][$data->item_id]*100)/$tot_rec_amt_usd[$lc_data->id];
 
 $cost_get_item_wise=($total_pay_amt_without_partial*$item_percentage_get)/100;
 
   $first_process=$cost_get_item_wise/$rec_qty[$data->po_no][$data->item_id];
   //$first_process=$total_pay_amt_without_partial/$tot_rec_qty_get[$lc_data->id];
   
  $second_process=$first_process*$rec_qty[$data->po_no][$data->item_id];
   $third_process=$second_process+$tot_item_pay_amt[$lc_data->id][$data->item_id];
 $cost_price=$third_process/$rec_qty[$data->po_no][$data->item_id];
 
     //$exchange_rate=($total_pay_amt_without_partial+ $tot_item_pay_amt[$lc_data->id][$data->item_id])/$tot_rec_amt_usd[$lc_data->id];
	  //$cost_price=($total_pay_amt_without_partial+$tot_item_pay_amt[$lc_data->id][$data->item_id])/$tot_rec_qty_get[$lc_data->id];
	// $cost_price=$rec_rate_usd[$data->po_no][$data->item_id]*($exchange_rate);
	 $cost_amt=($rec_qty[$data->po_no][$data->item_id]*$cost_price);
	 }
	 else{
	  //$exchange_rate=($total_pay_amt_without_partial+ $tot_item_pay_amt[$lc_data->id][$data->item_id])/$tot_rec_amt_invoice_usd[$lc_data->id];
	  // $exchange_rate=($total_pay_amt_without_partial+ $tot_item_pay_amt[$lc_data->id][$data->item_id])/$tot_rec_amt_invoice_usd[$lc_data->id];
//echo $tot_rec_qty_invoice[$lc_data->id];
    $item_percentage_get=($data->amount_usd*100)/$tot_rec_amt_invoice_usd[$lc_data->id];

  $cost_get_item_wise=($total_pay_amt_without_partial*$item_percentage_get)/100;
 
   $first_process=$cost_get_item_wise/$data->qty;


	   // $first_process=$total_pay_amt_without_partial/$tot_rec_qty_invoice[$lc_data->id];
 $second_process=$first_process*$data->qty;
 $third_process=$second_process+$tot_item_pay_amt[$lc_data->id][$data->item_id];
 //$third_process=$second_process;
  $cost_price=$third_process/$data->qty;
 
	 // $cost_price=$rec_rate_usd_invoice[$data->po_no][$data->item_id]*($exchange_rate);
	  $cost_amt=($data->qty*$cost_price);
	 }
 
 ?>
 <input name="exchange_rate_<?=$data->id?>" type="hidden" id="exchange_rate_<?=$data->id?>"  readonly="" style="width:220px; height:32px;" value="<?=$exchange_rate;?>"  required tabindex="105" />
 <input name="cost_price_<?=$data->id?>" id="cost_price_<?=$data->id?>" type="text" size="10"  value="<?=$cost_price;?>" style="width:100px; height:25px;"  /></td>
    <td align="center"><input name="cost_amt_<?=$data->id?>" id="cost_amt_<?=$data->id?>" type="text"   value="<?=$cost_amt; $tot_cost_amt +=$cost_amt;?>" style="width:120px; height:25px;"  />	</td>
  </tr>
   <? 
   
 // $cost_price=0;
   } //}?>
  <tr bgcolor="<?=($i%2)?'#E8F3FF':'#fff';?>" style="border:1px solid #000000; font-size: 14px;">
    <td><div align="right"><strong>&nbsp;&nbsp;Total </strong></div></td>
    <td><div align="right"></div></td>
    <td><div align="right"></div></td>
    <td><div align="right"></div></td>
    <td><div align="right"><strong>
      <?=number_format($tot_amount_usd,2);?>
    </strong></div></td>
    <td><div align="right"></div></td>
    <td><div align="right"></div></td>
    <td><div align="right"><strong>
      <?=number_format($tot_rec_amount_usd,2);?>
    </strong>
	 <input name="tot_grn_amt_usd" type="hidden" id="tot_grn_amt_usd"  readonly="" style="width:220px; height:32px;" value="<?=$tot_rec_amount_usd;?>"  required tabindex="105" />
	</div></td>
    <td><div align="right"></div></td>
    <td align="center"><div align="center"><strong>
      <?=number_format($tot_cost_amt,2);?>
    </strong></div></td>
  </tr>
</table>
	  
	  </td>
		  </tr>
		</table>
	
	</td>
  
  </tr>
  
 <?php /*?> 
  
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
          <td colspan="3" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>PI Details </strong></td>
          <td colspan="3" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>GRN Details  </strong></td>
          <td width="9%" rowspan="2" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Cost Price </strong></td>
          <td width="12%" rowspan="2" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Value (BDT) </strong></td>
        </tr>
        <tr>
          <td width="4%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Qty</strong></td>
          <td width="8%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Rate($)</strong></td>
          <td width="10%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Amount($)</strong></td>
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
		
		
			 $sqlc = 'select d.*, i.item_name from lc_purchase_master m, lc_purchase_invoice d, item_info i where m.po_no=d.po_no and i.item_id=d.item_id and m.lc_no='.$lc_no.'
			 group by d.id order by d.id';
			$queryc=db_query($sqlc);
			while($datac = mysqli_fetch_object($queryc)){
			
			
			
			?>
        <tr style="font-size:12px;">
          <td align="center" valign="top"><?=++$kk;?></td>
          <td align="left" valign="top"><?=$datac->item_name;?></td>
          <td align="left" valign="top"><?=$datac->unit_name;?></td>
          <td align="left" valign="top"><?=number_format($datac->qty,2);  $tot_qty +=$datac->qty;?></td>
          <td align="right" valign="top"><?=$datac->rate_usd;?></td>
          <td align="right" valign="top"><?=number_format($datac->amount_usd,2);  $tot_amount_usd +=$datac->amount_usd;?></td>
          <td align="left" valign="top"><?=number_format($grn_qty[$datac->id],2);  ?></td>
          <td align="right" valign="top"><?=$grn_rate_usd[$datac->id]?></td>
          <td align="right" valign="top"><?=number_format($grn_amount_usd[$datac->id],2);  $tot_grn_amt_usd +=$grn_amount_usd[$datac->id];?></td>
          <td align="right" valign="top"><?=$cost_price_bdt = $grn_rate_usd[$datac->id]*$exchange_rate_bdt;?></td>
          <td align="right" valign="top"><?=number_format($cost_amt_bdt=$cost_price_bdt*$grn_qty[$datac->id],2);  $tot_cost_amt_bdt +=$cost_amt_bdt;?></td>
        </tr>
        
        <? }
		
		?>
        <tr style="font-size:12px;">
        <td colspan="3" align="right" valign="middle"><strong> Total:</strong></td>
        <td align="right" valign="middle">&nbsp;</td>
        <td align="right" valign="middle">&nbsp;</td>
        <td align="right" valign="middle"><strong>
          <?=number_format($tot_amount_usd,2) ;?>
        </strong></td>
        <td align="right" valign="middle">&nbsp;</td>
        <td align="right" valign="middle">&nbsp;</td>
        <td align="right" valign="middle"><strong>
          <?=number_format($tot_grn_amt_usd,2) ;?>
        </strong></td>
        <td align="right" valign="middle">&nbsp;</td>
        <td align="right" valign="middle"><strong>
          <?=number_format($tot_cost_amt_bdt,2) ;?>
        </strong></td>
        </tr>
      </table>      </td>
  </tr>
  

  
  
  <?php */?>
  
  
  
  
  
  
  <tr>
  	<td colspan="3">
			<table width="100%" border="0" bordercolor="#000000" cellspacing="0" cellpadding="0" class="tabledesign1" >
        
        
        
		  
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
		    <td colspan="2">This is an ERP generated report </td>
	      </tr>
	
	<tr>
            <td colspan="4">  <hr /> </td>
		</tr>
	
        
	
          <tr>
            <td colspan="4" style="border:0px;border-color:#FFF; color: #000; font-size:16px; text-transform:uppercase; font-weight:700;" align="center" >
			<? $data=mysqli_fetch_object(db_query("select * from project_info limit 1"));	?>	
			<?php echo $data->proj_name ?></td>
		</tr>
		  <tr>
			 <td colspan="4" style="border:0px;border-color:#FFF; color: #000;  font-size:12px; " align="center" >Head Office: <?php echo $data->proj_address;?></td>
		</tr>
		  <tr>
			 <td colspan="4" style="border:0px;border-color:#FFF; color: #000; font-size:12px; " align="center" >Phone: <?php echo $data->proj_phone;?></td>
          </tr>
		  <tr>
			 <td colspan="4" style="border:0px;border-color:#FFF; color: #000; font-size:12px; " align="center" >Web: <?php echo $data->website;?></td>
          </tr>
	</table>
	  </div>	</td>
  </tr>
  
  <!--</tfoot>-->
</table>
</body>
</html>
