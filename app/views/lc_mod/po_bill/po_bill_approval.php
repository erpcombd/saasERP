<?php

//

//


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='PO Bill Approval';

//create_combobox('pi_id');
//create_combobox('dealer_code');

do_calander('#po_date');
//do_calander('#tdate');

//do_calander('#odate');



  $bill_id 		= $_REQUEST['bill_id'];
  
  $bill_data = find_all_field('po_bill_master','','bill_id="'.$bill_id.'"');




if(prevent_multi_submit()){



if(isset($_POST['confirm'])){
	
	$status = 'COMPLETED';
	$checked_by = $_SESSION['user']['id'];
	$checked_at=date('Y-m-d H:i:s');
		
	$group_for = $_POST['group_for'];
	$bill_id = $_POST['bill_id'];
	$bill_no = $_POST['bill_no'];
	$purchase_manager = $_POST['purchase_manager'];
	$bill_date = $_POST['bill_date'];
	$remarks = $_POST['remarks'];
	
	$purchase_manager_ledger = find_a_field('purchase_manager',' ledger_id','id='.$purchase_manager);
	
	$jv_no=next_journal_sec_voucher_id('','Bill Adjustment',$group_for);
	$proj_id = 'Faridgroup';
	$jv_date = $bill_date;
	$tr_from = 'Bill Adjustment';
	$cc_code = $_POST['group_for'];
	
	$narration = 'Bill#'.$bill_no.' (DT#'.$bill_date.')';


	 
	 
 $sql = "select  m.*, v.vendor_name, v.ledger_id
   from purchase_sp_master m, po_bill_details d, vendor v 
   where m.po_no=d.po_no and m.vendor_id=v.vendor_id and d.bill_id='".$bill_id."'  group by m.po_no  order by m.po_date, m.po_no";

		$query = db_query($sql);	
		while($data=mysqli_fetch_object($query))
		{
			if($_POST['po_amt_'.$data->po_no]>0)
			{
				
				$po_amt=$_POST['po_amt_'.$data->po_no];
				$ledger_id=$_POST['ledger_id_'.$data->po_no];
			
				$tot_po_amt += $po_amt;
				
				
				add_to_sec_journal($proj_id, $jv_no, $jv_date, $ledger_id, $narration, $po_amt, '0.00',  $tr_from, $bill_no, $data_pr->item_group_ledger, 
$bill_id, $cc_code, $group_for);	


			}
		}
		
		
		add_to_sec_journal($proj_id, $jv_no, $jv_date, $purchase_manager_ledger, $narration,  '0.00', $tot_po_amt, $tr_from, $bill_no, $data_pr->item_group_ledger, 
$bill_id, $cc_code, $group_for);




$jv_config = find_a_field('voucher_config','direct_journal','voucher_type="'.$tr_from.'"');

if($jv_config=="Yes"){

sec_journal_journal($jv_no,$jv_no,$tr_from);

$time_now = date('Y-m-d H:i:s');

$up2='update secondary_journal set checked="YES",checked_at="'.$time_now.'",checked_by="'.$_SESSION['user']['id'].'" where jv_no="'.$jv_no.'" and tr_from="'.$tr_from.'"';

db_query($up2);

}


	
	
	$new_sql="UPDATE po_bill_master SET status='".$status."' WHERE bill_id = '".$bill_id."' ";
	 db_query($new_sql); 
	 
	 
//if ($pi_data->pi_type==3) {
//	
//		
////Text Sms
//
//$sms_rec = find_all_field('sms_receiver','','id=1');
//
//function sms($dest_addr,$sms_text){
//
//$url = "https://vas.banglalink.net/sendSMS/sendSMS?userID=NASSA@123&passwd=LizAPI@019014&sender=NASSA_GROUP";
//
//
//$fields = array(
//    'userID'      => "NASSA@123",
//    'passwd'      => "LizAPI@019014",
//    'sender'      => "NASSA GROUP",
//    'msisdn'      => $dest_addr,
//    'message'     => $sms_text
//);
//$ch = curl_init();
//curl_setopt($ch, CURLOPT_URL, $url);
//curl_setopt($ch, CURLOPT_POST, count($fields));
//curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));
//$result = curl_exec($ch);
//curl_close($ch);
//}
//
//$recipients =$sms_rec->receiver_3;
//$recipients2 =$sms_rec->receiver_2;
//$massage  = "Dear Sir,\r\nRequest for PI Approval. \r\n";
//$massage  .= "PI No : ".$pi_no_generate." \r\n";
//$massage  .= "Login : https://boxes.com.bd/NATIVE/lc_mod/pages/main/index.php?module_id=13 \r\n";
//$sms_result=sms($recipients, $massage);
//if($recipients2>0) {
//$sms_result=sms($recipients2, $massage);
//}
	
//Text Sms

		//}
	 
	 
	 
	 
	 ?>

<script language="javascript">
window.location.href = "po_bill_pending_for_approval.php";
</script>

<?


	 
	 
	 
	 
	 
		

}


}

else

{

	$type=0;

	$msg='Data Re-Submit Warning!';

}






?>

<script>



function getXMLHTTP() { //fuction to return the xml http object



		var xmlhttp=false;	



		try{



			xmlhttp=new XMLHttpRequest();



		}



		catch(e)	{		



			try{			



				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");

			}

			catch(e){



				try{



				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");



				}



				catch(e1){



					xmlhttp=false;



				}



			}



		}



		 	



		return xmlhttp;



    }



	function update_value(po_no)



	{



var po_no=po_no; // Rent

var bill_id=(document.getElementById('bill_id_'+po_no).value);
var bill_no=(document.getElementById('bill_no_'+po_no).value);
var bill_date=(document.getElementById('bill_date_'+po_no).value);
var purchase_manager=(document.getElementById('purchase_manager_'+po_no).value);
var vendor_id=(document.getElementById('vendor_id_'+po_no).value);
var ledger_id=(document.getElementById('ledger_id_'+po_no).value);
var jv_no=(document.getElementById('jv_no_'+po_no).value);

var flag=(document.getElementById('flag_'+po_no).value); 

var strURL="po_bill_remove_ajax.php?po_no="+po_no+"&bill_id="+bill_id+"&bill_no="+bill_no+"&bill_date="+bill_date+"&purchase_manager="+purchase_manager+"&vendor_id="+vendor_id+"&ledger_id="+ledger_id+"&jv_no="+jv_no+"&flag="+flag;





		var req = getXMLHTTP();



		if (req) {



			req.onreadystatechange = function() {

				if (req.readyState == 4) {

					// only if "OK"

					if (req.status == 200) {						

						document.getElementById('divi_'+po_no).style.display='inline';

						document.getElementById('divi_'+po_no).innerHTML=req.responseText;						

					} else {

						alert("There was a problem while using XMLHTTP:\n" + req.statusText);

					}

				}				

			}

			req.open("GET", strURL, true);

			req.send(null);

		}	



}










</script>






<style>
/*
.ui-state-default a, .ui-state-default a:link, .ui-state-default a:visited, a.ui-button, a:link.ui-button, a:visited.ui-button, .ui-button {
    color: #454545;
    text-decoration: none;
    display: none;
}*/


div.form-container_large input {
    width: 280px;
    height: 38px;
    border-radius: 0px !important;
}



</style>



<div class="form-container_large">

<form action="" method="post" name="codz" id="codz">

<div class="box" style="width:100%;">

								<table width="100%" border="0" cellspacing="0" cellpadding="0">

								  <tr>

								 <td width="9%">Bill No:</td>

									<td width="21%">
									
									<input name="bill_id" type="hidden" id="bill_id" tabindex="1" value="<?=$bill_id?>" readonly>
								
								

								<input name="bill_no" type="text" id="bill_no" style="width:200px; height:32px;" value="<?=$bill_data->bill_no?>" readonly="" tabindex="105" />	
								<input name="group_for" type="hidden" id="group_for" style="width:200px; height:32px;" value="<?=$bill_data->group_for?>" readonly="" tabindex="105" />									</td>
									<td width="10%">Purchase Manager:</td>
									<td width="23%">
									
									<input name="purchase_manager" type="hidden" id="purchase_manager"  readonly="" style="width:220px; height:32px;" value="<?=$bill_data->purchase_manager?>"  required  />
									
									<input name="purchase_manager_name" type="text" id="purchase_manager_name"  readonly="" style="width:220px; height:32px;" 
									value="<?=find_a_field('purchase_manager','purchase_manager','id='.$bill_data->purchase_manager);?>"  required  />										</td>
								  </tr>
								  
								  
  
								  <tr>

								 <td> Bill Date:</td>

									<td>

									
									
									<input style="width:200px; height:32px;"  name="bill_date" type="text" id="bill_date"  value="<?=$bill_data->bill_date?>"  readonly="" required />									</td>
									<td>Remarks: </td>
									<td>
								
									<input style="width:220px; height:32px;"  name="remarks" type="text" id="remarks"  value="<?=$_POST['remarks'];?>"  />																		</td>
								  </tr>
								</table>
								
								</div>
								
		<div class="box" style="width:100%;">						
								<table width="100%">
                            <thead>
                              <tr class="oe_list_header_columns">
                                <th><input name="create" type="submit" id="create" value="VIEW PO DATA" style="width:150px; height:30px; background:#20B2AA; color:#000000; font-weight:700;" /></th>
                                <th><a href="po_bill_print_view.php?bill_id=<?=$bill_id?>" target="_blank" style="padding:5px 30px; background:#20B2AA; color:#000000; font-size:12px; font-weight:700;">PO Bill</a></th>
                                <th><a href="po_bill_top_shit_print_view.php?bill_id=<?=$bill_id?>" target="_blank"  style="padding:5px 30px; background:#20B2AA; color:#000000; font-size:12px; font-weight:700;">PO Top Sheet</a></th>
                              </tr>
                            </thead>
                            <tfoot>
                            </tfoot>
                            <tbody>
                            </tbody>
                          </table>

    </div>



<?

if($bill_id>0){

?>

<div class="tabledesign2" style="width:100%">




<table width="100%" border="0" align="center" id="grp" cellpadding="0" cellspacing="0" style="font-size:14px; text-transform:uppercase;">

  <tr>

    <th width="9%">PO  No </th>

    <th width="10%">PO Date </th>
    <th width="15%">Memo No </th>
    <th width="26%">Vendor Name </th>
    <th width="14%">TOTAL VALUE </th>
    </tr>
  

  <?
  
  
  if($_POST['fdate']!=''&&$_POST['tdate']!='') $date_con .= ' and c.chalan_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
  
  
		//if($_POST['dealer_code']!='')
// 		$dealer_con=" and m.dealer_code='".$_POST['dealer_code']."'";
//		
//		if($_POST['do_no']!='') 
//		$do_con .= ' and m.do_no in ('.$_POST['do_no'].') ';


    if($_POST['po_date']!='')
	$po_dt_con=" and m.po_date='".$_POST['po_date']."'";
	
	
	
	 	 //$sql = "select po_no, po_no from po_bill_details where 1 group by po_no";
//		 $query = db_query($sql);
//		 while($info=mysqli_fetch_object($query)){
//  		 $po_no[$info->po_no]=$info->po_no;
//		}


		 $sql = "select j.tr_id, v.ledger_id, j.cr_amt, j.jv_no from journal j, vendor v where j.ledger_id=v.ledger_id and j.tr_from='Purchase' group by j.tr_id";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $cr_amt[$info->ledger_id][$info->tr_id]=$info->cr_amt;
		 $jv_no[$info->ledger_id][$info->tr_id]=$info->jv_no;
	
		}

		
		

     $sql = "select  m.*, v.vendor_name, v.ledger_id
   from purchase_sp_master m, po_bill_details d, vendor v 
   where m.po_no=d.po_no and m.vendor_id=v.vendor_id and m.purchase_manager='".$bill_data->purchase_manager."' and m.status!='MANUAL' ".$po_dt_con." group by m.po_no  order by m.po_date, m.po_no";

  $query = db_query($sql);

  while($data=mysqli_fetch_object($query)){$i++;

 // $op = find_all_field('journal_item','','warehouse_id="'.$_POST['warehouse_id'].'" and group_for="'.$_POST['group_for'].'" and item_id = "'.$data->item_id.'" and tr_from = "Opening" order by id desc');

  ?>



<? //if($po_no[$data->po_no]==0) { } ?>

  <tr bgcolor="<?=($i%2)?'#E8F3FF':'#fff';?>">

    <td>
	<a href="../po/po_print_view.php?po_no=<?=$data->po_no;?>" target="_blank" style=" color:#000000; font-size:14px; font-weight:700;"> <?=$data->po_no;?> </a>	</td>

    <td><?php echo date('d-m-Y',strtotime($data->po_date));?> </td>
    <td><?= $data->invoice_no;?>
	<input name="bill_id_<?=$data->po_no?>" type="hidden" id="bill_id_<?=$data->po_no?>" value="<?=$bill_data->bill_id?>" />
	<input name="bill_no_<?=$data->po_no?>" type="hidden" id="bill_no_<?=$data->po_no?>" value="<?=$bill_data->bill_no?>" />
	<input name="bill_date_<?=$data->po_no?>" type="hidden" id="bill_date_<?=$data->po_no?>" value="<?=$bill_data->bill_date?>" />
	<input name="purchase_manager_<?=$data->po_no?>" type="hidden" id="purchase_manager_<?=$data->po_no?>" value="<?=$bill_data->purchase_manager?>" />
	<input name="vendor_id_<?=$data->po_no?>" type="hidden" id="vendor_id_<?=$data->po_no?>" value="<?=$data->vendor_id?>" />
	<input name="ledger_id_<?=$data->po_no?>" type="hidden" id="ledger_id_<?=$data->po_no?>" value="<?=$data->ledger_id?>" />
	<input name="jv_no_<?=$data->po_no?>" type="hidden" id="jv_no_<?=$data->po_no?>" value="<?= $jv_no[$data->ledger_id][$data->po_no];?>" />	</td>
    <td>
	
	<? if ($data->vendor_id==48) {
			echo $data->po_details;
		} else {
			echo $data->vendor_name;
		}?>	</td>
    <td><?= number_format($cr_amt[$data->ledger_id][$data->po_no],2);?>
		<input name="po_amt_<?=$data->po_no?>" type="hidden" id="po_amt_<?=$data->po_no?>" value="<?= $cr_amt[$data->ledger_id][$data->po_no];?>" style="width:120px;" />	</td>
    </tr>

  <? } ?>
</table>
</div>
<br /><br />




<table width="100%" border="0">





<? if($bill_data->status!="COMPLETED") {?>
<tr>

<td align="center">&nbsp;

</td>

<td align="center">
<!--<input  name="do_no" type="hidden" id="do_no" value="<?=$_POST['do_no'];?>"/>-->
<input name="confirm" type="submit" class="btn1" value="CONFIRM &amp; SEND" style="width:270px; font-weight:bold; float:right; font-size:12px; height:30px;  background: #1E90FF; color: #000000; border-radius: 50px 20px;" /></td>

</tr>
<? }?>


</table>


<?php /*?><table width="100%" border="0">

<? 

 		$pi_status = find_a_field('pi_master','status','id="'.$_POST['pi_id'].'"');
		 // $issue_qty = find_a_field('sale_do_production_issue','sum(total_unit)','do_no='.$_POST['do_no']);


if($pi_status!="MANUAL"){




?>

<tr>

<td colspan="2" align="center" bgcolor="#FF3333"><strong> Master PI Data Entry Completed</strong></td>

</tr>

<? }else{?>

<tr>

<td align="center">&nbsp;

</td>

<td align="center">
<!--<input  name="do_no" type="hidden" id="do_no" value="<?=$_POST['do_no'];?>"/>-->
<input name="confirm" type="submit" class="btn1" value="COMPLETE" style="width:270px; font-weight:bold; float:right; font-size:12px; height:30px; color:#090" /></td>

</tr>

<? }?>

</table><?php */?>




<? }?>








<p>&nbsp;</p>

</form>

</div>



<?

//

//

require_once SERVER_CORE."routing/layout.bottom.php";

?>