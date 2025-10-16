<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$title='L/C Payment Entry';
 
// ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
 // create_combobox('do_no');
  
   create_combobox('lc_no');
  
  

do_calander('#invoice_date');
do_calander('#boe_date');
do_calander('#r_date');

 $data_found = $_POST['lc_no'];
 
 
function auto_insert_lc_all_payment_secoundary_cus($payment_no)
{
	
	 $sql = 'select payment_no, payment_date, payment_method, group_for, lc_no, lc_number, lc_part_no, bill_type, lc_ledger, cr_ledger_id, sum(pay_amt_in) as tot_pay_amt, loan_ledger from lc_bill_payment
	 where payment_no="'.$payment_no.'" GROUP by payment_no';
	

	$query = db_query($sql);
	$data=mysqli_fetch_object($query);

			$proj_id='clouderp';
			$group_for = $data->group_for;
			$cc_code = $group_for;
			
			$bank_cash_group=find_a_field('accounts_ledger','ledger_group_id','ledger_id="'.$data->cr_ledger_id.'"');
		
		//$tr_from = 'LC Journal';
			
			 if($data->bill_type==8) {

					if($bank_cash_group==126003){

					$tr_from = 'Cash Payment';

				}
					else if($bank_cash_group==126002){

					$tr_from = 'Bank Payment';

				}

			}
			
			
			$config = find_all_field('config_group_class','',"group_for=".$group_for);
			$jv_no=next_journal_sec_voucher_id('',$tr_from,$_SESSION['user']['group']);
			
			$tr_no = $data->payment_no;
			$tr_id = $data->lc_no;
			$jv_date = $data->payment_date;
			
			//$jv_date = strtotime($data->payment_date);
			
			if($data->bill_type==3 || $data->bill_type==4 || $data->bill_type==5 || $data->bill_type==6) {
			$narration_cr = $data->lc_part_no;
			}else{
			$narration_cr = $data->lc_number;
			}
	
	
//add_to_sec_journal($proj_id,$jv_no, $jv_date, $data->cr_ledger_id, $narration_cr,  0, $data->tot_pay_amt, $tr_from, $tr_no, $data->lc_ledger, $tr_id, $cc_code, $group_for, '','','','',$data->cheque_no, $data->cheque_date, $data->lc_ledger, 'NO', $data->payment_method, 'LC Journal');

add_to_sec_journal($proj_id, $jv_no, $jv_date, $data->cr_ledger_id, $narration_cr,  '0', ($data->tot_pay_amt), $tr_from, $tr_no,0,$tr_id, $cc_code, $group_for,'','', '', '', '', '',$data->lc_ledger, 'NO', $data->payment_method,'','','','LC Journal', '' );

 		
	
	
	
		$sql2 = 'select a.* from lc_bill_payment a, lc_bill_category b where a.bill_category=b.id and a.payment_no="'.$payment_no.'"  order by a.id';

		$query2 = db_query ($sql2);
		
		while($data2=mysqli_fetch_object($query2)){
	
		//$narration_dr ='PR# '.$data2->pr_no.' (PO# '.$data2->po_no.')';
		
		//if($data->bill_type==3) {
//		$narration_dr = $narration_cr;
//		}else {
//		$narration_dr = $data2->category_view;
//		}	
	$item_name_get=find_a_field('item_wise_payment p,item_info i','item_name','p.item_id=i.item_id and p.payment_id="'.$payment_no.'"');
	//add_to_sec_journal($proj_id,$jv_no, $jv_date, $data2->lc_ledger, $data2->category_view, ($data2->pay_amt_in),  0, $tr_from, $tr_no, $data2->cr_ledger_id, $tr_id, $cc_code, $group_for, '','','','',$data->cheque_no, $data->cheque_date, $data2->cr_ledger_id, 'NO', $data2->payment_method, 'LC Journal', $data2->bill_category);
	$custom_narration=$data2->category_view."(".$item_name_get.")";
	add_to_sec_journal($proj_id, $jv_no, $jv_date,$data2->lc_ledger, $custom_narration, ($data2->pay_amt_in), '0', $tr_from, $tr_no,0, $tr_id, $cc_code, $group_for,'','', '', '', '', '', $data2->cr_ledger_id, 'NO', $data->payment_method,'','','','LC Journal', $data2->bill_category );

 

		}
		
		
		
//		$sql3 = 'select a.*, b.ledger_id from lc_bill_payment a, lc_bill_category b where a.bill_category=b.id and a.payment_no="'.$payment_no.'" and b.ledger_id>0 order by a.id';
//
//		$query3 = db_query ($sql3);
//		
//		while($data3=mysqli_fetch_object($query3)){
//
//		add_to_sec_journal($proj_id, $jv_no, $jv_date, $data3->ledger_id, $narration_cr,  ($data3->pay_amt_in), '0', $tr_from, $tr_no,$data3->cr_ledger_id,$tr_id, $cc_code, $group_for,
//		'','','','','','',$data3->cr_ledger_id,'NO');
//
//		}
			
			
	

$jv_config = find_a_field('voucher_config','direct_journal','voucher_type="'.$tr_from.'"');

//if($jv_config=="Yes"){

sec_journal_journal($jv_no,$jv_no,$tr_from);

$time_now = date('Y-m-d H:i:s');

$up2='update secondary_journal set checked="YES",checked_at="'.$time_now.'",checked_by="'.$_SESSION['user']['id'].'" where jv_no="'.$jv_no.'" and tr_from="'.$tr_from.'"';

db_query($up2);
//
//}




}
 

if ($data_found==0) {
 //create_combobox('lc_no');
  }



if(prevent_multi_submit()){

if(isset($_REQUEST['confirmit']))

{


		$payment_date=$_POST['invoice_date'];
		$payment_method=$_POST['payment_method'];
		$group_for=$_POST['group_for'];
		$lc_no=$_POST['lc_no'];
		$lc_number=$_POST['lc_number'];
		$note=$_POST['note'];	
		$boe_no=$_POST['boe_no'];
		$boe_date=$_POST['boe_date'];
		$r_no=$_POST['r_no'];
		$r_date=$_POST['r_date'];	
		$bank_ledger_id=$_POST['bank_ledger_id'];
		$bank_pay_id=$_POST['bank_pay_id'];
		
		if($bank_pay_id>0){
		$lc_part=$bank_pay_id;
		}
		else{
		$lc_part=$_POST['lc_part'];
		}
		$entry_by= $_SESSION['user']['id'];
		$entry_at = date('Y-m-d H:i:s');
	
		$ledger_id=$_POST['ledger_id'];
		
		
		
		$lc_part_view=find_a_field('lc_part','lc_part','id="'.$lc_part.'"');
		
		if($lc_part==1) {
			$lc_no_part=$lc_number;
		}elseif($lc_part==""){
			$lc_no_part=$lc_number;
		}else {
			$lc_no_part=$lc_number.' - ('.$lc_part_view.')';
		}
		

		
		//if($_POST['bill_type']==3) {
//			$ledger_id=find_a_field('lc_ledger_config','lc_margin','id="1"');
//		}else{
//			$ledger_id=$_POST['ledger_id'];
//		}
		
		
		if($_POST['cr_loan_ledger_id']>0) {
			$cr_ledger_id=$_POST['cr_loan_ledger_id'];
		}else {
			$cr_ledger_id=$_POST['cr_ledger_id'];
		}
		
		
		
		
	
  if($_POST['bill_type']!='')
  $bill_type_con=" and bill_type=".$_POST['bill_type'];
  


	
		
		
		//$YR = date('Y',strtotime($ch_date));
//  		$yer = date('y',strtotime($ch_date));
//  		$month = date('m',strtotime($ch_date));
//
//  		$ch_cy_id = find_a_field('sale_do_chalan','max(ch_id)','year="'.$YR.'"')+1;
//   		$cy_id = sprintf("%07d", $ch_cy_id);
//   		$chalan_no=''.$yer.''.$month.''.$cy_id;


		$tr_unique=77;

		$payment_no = next_tr_no('Payment');

    $sqlc = 'select d.*, i.item_name from lc_purchase_master m, lc_purchase_invoice d, item_info i where m.po_no=d.po_no and i.item_id=d.item_id and m.lc_no='.$_POST['lc_no'].'
			 group by d.id order by d.id';
			$queryc=db_query($sqlc);
			while($datac = mysqli_fetch_object($queryc)){
										$sql = "SELECT id, bill_type, bill_category FROM lc_bill_category WHERE 1 ".$bill_type_con." and partial_charge='YES' order  by bill_type,id ";
					  $query = db_query($sql);
					  while($data=mysqli_fetch_object($query)){
					  	$bill_type=$_POST['bill_type_'.$datac->item_id.'_'.$data->id];
						$bill_category=$_POST['bill_category_'.$datac->item_id.'_'.$data->id];
						$payment_amt=$_POST['payment_amt_'.$datac->item_id.'_'.$data->id];
						  $assesment_value=$_POST['assesment_value_'.$datac->item_id];
						//$bill_type=$_POST['bill_type_'.$datac->item_id.'_'.$data->id];
					  if($payment_amt>0){
					    $insql='insert into item_wise_payment(payment_id,item_id,lc_no,bill_category,payment_amt,payment_date)values("'.$payment_no.'","'.$datac->item_id.'","'.$lc_no.'","'.$bill_category.'","'.$payment_amt.'","'.$payment_date.'")';
					db_query($insql);
					
							$ins_invoice = 'INSERT INTO lc_bill_payment (payment_no, payment_date, payment_method, lc_no, lc_number, lc_ledger, bank_pay_id, lc_part, lc_part_no, group_for, bill_type, bill_category, category_view, cr_ledger_id, pay_amt_in, pay_amt_out, remarks, note, r_no, r_date, status, entry_by, entry_at, boe_no, boe_date,assesment_value)
  
  VALUES("'.$payment_no.'", "'.$payment_date.'", "'.$payment_method.'", "'.$lc_no.'", "'.$lc_number.'", "'.$ledger_id.'", "'.$lc_part.'", "'.$lc_part_view.'", "'.$lc_no_part.'", "'.$group_for.'",  "'.$bill_type.'", "'.$bill_category.'", "'.$data->bill_category.'", "'.$cr_ledger_id.'", "'.$payment_amt.'", "0", "'.$remarks.'", "'.$note.'", "'.$r_no.'", "'.$r_date.'", "CHECKED", "'.$entry_by.'", "'.$entry_at.'", "'.$boe_no.'", "'.$boe_date.'", "'.$assesment_value.'")';
  db_query($ins_invoice);
  }
					  }
					  
			
			}












		  $sql = "SELECT id, bill_type, bill_category as category_view FROM lc_bill_category WHERE 1 ".$bill_type_con." order  by bill_type,id";

		$query = db_query($sql);

		while($data=mysqli_fetch_object($query))

		{
			if($_POST['payment_amt_'.$data->id]>0)

			{

				$payment_amt=$_POST['payment_amt_'.$data->id];
				$bill_type=$_POST['bill_type_'.$data->id];
				$bill_category=$_POST['bill_category_'.$data->id];
				$remarks=$_POST['remarks_'.$data->id];

   // $ins_invoice = 'INSERT INTO lc_bill_payment (payment_no, payment_date, payment_method, lc_no, lc_number, lc_ledger, bank_pay_id, lc_part, lc_part_no, group_for, bill_type, bill_category, category_view, cr_ledger_id, pay_amt_in, pay_amt_out, remarks, note, r_no, r_date, status, entry_by, entry_at, boe_no, boe_date)
  
  //VALUES("'.$payment_no.'", "'.$payment_date.'", "'.$payment_method.'", "'.$lc_no.'", "'.$lc_number.'", "'.$ledger_id.'", "'.$lc_part.'", "'.$lc_part_view.'", "'.$lc_no_part.'", "'.$group_for.'",  "'.$bill_type.'", "'.$bill_category.'", "'.$data->category_view.'", "'.$cr_ledger_id.'", "'.$payment_amt.'", "0", "'.$remarks.'", "'.$note.'", "'.$r_no.'", "'.$r_date.'", "CHECKED", "'.$entry_by.'", "'.$entry_at.'", "'.$boe_no.'", "'.$boe_date.'")';

//db_query($ins_invoice);


}

}


if($payment_no>0)
{
auto_insert_lc_all_payment_secoundary_cus($payment_no);
}
		$link = "voucher_view.php?payment_no=".$payment_no;
$redirect = "item_wise_payment.php"; // page you want current tab to go

echo "<script>
        // Open invoice in a new tab
        window.open('$link', '_blank');

        // Redirect current page to another page
        window.location.href = '$redirect';
      </script>";

?>

<script language="javascript">
//window.location.href = "item_wise_payment.php";
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



	function update_value(pi_id)



	{



var pi_id=pi_id; // Rent


var lc_no=(document.getElementById('lc_no').value);


var flag=(document.getElementById('flag_'+pi_id).value); 

var strURL="lc_update_ajax.php?pi_id="+pi_id+"&lc_no="+lc_no+"&flag="+flag;



		var req = getXMLHTTP();



		if (req) {



			req.onreadystatechange = function() {

				if (req.readyState == 4) {

					// only if "OK"

					if (req.status == 200) {						

						document.getElementById('divi_'+pi_id).style.display='inline';

						document.getElementById('divi_'+pi_id).innerHTML=req.responseText;						

					} else {

						alert("There was a problem while using XMLHTTP:\n" + req.statusText);

					}

				}				

			}

			req.open("GET", strURL, true);

			req.send(null);

		}	



}


function sum_sum(id){
var tot_due_amt = (document.getElementById('tot_due_amt_'+id).value)*1;

document.getElementById('payment_amt_'+id).value = tot_due_amt;

}





//function SUMcalculation(item_id,id){//
//var total_amt = 0;
//
//<?
//
//if($_POST['bill_type']!='')
//$bill_type_con=" and bill_type=".$_POST['bill_type'];
//
// $sqlc = 'select d.*, i.item_name from lc_purchase_master m, lc_purchase_invoice d, item_info i where m.po_no=d.po_no and i.item_id=d.item_id and m.lc_no='.$_POST['lc_no'].'
//			 group by d.id order by d.id';
//			$queryc=db_query($sqlc);
//			while($datac = mysqli_fetch_object($queryc)){
//
//$sql = "SELECT id, bill_type, bill_category FROM lc_bill_category WHERE 1 ".$bill_type_con." order  by bill_type,id ";
//$query = db_query($sql);
//while($data=mysqli_fetch_object($query)){
//?>
//total_amt = total_amt + document.getElementById('payment_amt_<?=$datac->item_id?>_<?=$data->id?>').value*1;;
//<?
//}
//}
//
//?>
//document.getElementById('total_amt').value = total_amt;
//
//
//
//}






</script>


 <script>
var itemsData = <?php 
    $items = [];
    
    $sqlc = 'SELECT d.id as item_id, d.*, i.item_name 
             FROM lc_purchase_master m
             JOIN lc_purchase_invoice d ON m.po_no = d.po_no
             JOIN item_info i ON i.item_id = d.item_id 
             WHERE m.lc_no = ' . (int) $_POST['lc_no'] . ' 
             GROUP BY d.id ORDER BY d.id';

    $queryc = db_query($sqlc);
    if ($queryc) {
        while ($datac = mysqli_fetch_object($queryc)) {
            $sql = "SELECT id, bill_type, bill_category 
                    FROM lc_bill_category 
                    WHERE 1 " . (isset($_POST['bill_type']) ? " AND bill_type=" . (int)$_POST['bill_type'] : "") . " 
                    ORDER BY bill_type, id";

            $query = db_query($sql);
            $bills = [];
            if ($query) {
                while ($data = mysqli_fetch_object($query)) {
                    $bills[] = [
                        'id' => $data->id,
                        'bill_type' => $data->bill_type,
                        'bill_category' => $data->bill_category
                    ];
                }
            }
            $items[] = [
                'item_id' => $datac->item_id,
                'bills' => $bills
            ];
        }
    }
    
    echo json_encode($items);
?>;




function SUMcalculation() {
    var total_amt = 0;

    itemsData.forEach(item => {
        item.bills.forEach(bill => {
            // Access the input by dynamically generated ID
            var inputElem = document.getElementById(`payment_amt_${item.item_id}_${bill.id}`);
            if (inputElem && inputElem.value) {
                total_amt += parseFloat(inputElem.value) || 0;
            }
        });
    });

    // Set the total amount in the respective field
    document.getElementById('total_amt').value = total_amt.toFixed(2);
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
    width: 200px;
    height: 38px;
    border-radius: 0px !important;
}


/*table thead  {
  / Important /
  background-color: red;
  position: sticky;
  z-index: 100;
  top: 0;
}*/


</style>



<div class="form-container_large">

<form action="" method="post" name="codz" id="codz">

<? if ($data_found==0) { ?>

<div class="box" style="width:100%;">

								<table width="100%" border="0" cellspacing="0" cellpadding="0">

								  <tr>



    <td align="right" ><strong>L/C NO: </strong></td>



    <td ><select name="lc_no" id="lc_no" style="width:220px;" required>
      <option></option>
      <?

//foreign_relation('lc_number_setup','id','lc_number',$_POST['lc_no'],'status!="COMPLETED"');
foreign_relation('lc_bank_entry','lc_no','bank_lc_no',$_POST['lc_no'],'1');

?>
    </select></td>
	
	
	 <td align="right" ><strong>Payment Type: </strong></td>



    <td ><select name="bill_type" id="bill_type" style="width:220px;" required>
      <option></option>
      <?

foreign_relation('lc_bill_type','id','bill_type',$_POST['bill_type'],'1 and id=8');

?>
    </select></td>



    <td rowspan="4" ><strong>

      <input type="submit" name="submit" id="submit" value="View Data" style="width:180px; font-weight:bold; font-size:12px; height:30px; color:#090"/>

    </strong></td>
    </tr>
								  
								  
  
								  
								  
								  
								  
								  
								</table>

    </div>

<? }?>


<? if(isset($_POST['submit'])){ ?>


<div class="box" style="width:100%;">

								<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:12px;">

								  <tr>

								 <td width="11%">PAYMENT DATE:</td>

									<td width="20%">
									
									<?php /*?><?=($invoice_date!='')?$invoice_date:date('Y-m-d')?><?php */?>
									
			<input style="width:220px; height:32px;"  name="invoice_date" type="text" id="invoice_date"  value="<?=$_POST['invoice_date']?>"   required />									</td>
									<td width="14%" align="right">L/C  NO  :</td>
									<td width="21%">
									
									<?
									 $lc_data = find_all_field('lc_number_setup','','id='.$_POST['lc_no']); 
									 $bank_ledger = find_a_field('lc_bank_entry','bank_ledger','lc_no='.$_POST['lc_no']); 
									?>
									
					<input name="bill_type" type="hidden" id="bill_type"  readonly="" style="width:220px; height:32px;" value="<?=$_POST['bill_type'];?>"  required tabindex="105" />
									
					<input name="group_for" type="hidden" id="group_for"  readonly="" style="width:220px; height:32px;" value="<?=$lc_data->group_for;?>"  required tabindex="105" />
					
					<input name="bank_ledger_id" type="hidden" id="bank_ledger_id"  readonly="" style="width:220px; height:32px;" value="<?=$bank_ledger;?>"  required tabindex="105" />
						
					<input name="lc_no" type="hidden" id="lc_no"  readonly="" style="width:220px; height:32px;" value="<?=$lc_data->id;?>"  required tabindex="105" />
									
					<input name="ledger_id" type="hidden" id="ledger_id"  readonly="" style="width:220px; height:32px;" value="<?=$lc_data->ledger_id;?>"  required tabindex="105" />
									
				<input name="lc_number" type="text" id="lc_number"  readonly="" style="width:220px; height:32px;" value="<?=$lc_data->lc_number;?>"  required tabindex="105" />										</td>
									<td width="14%" align="right">COMPANY :</td>
									<td width="20%">
									
									<table>
		  	<tr>
				<td><input name="company" type="text" id="company"  readonly="" style="width:220px; height:32px;" value="<?=find_a_field('user_group','group_name','id='.$lc_data->group_for); ?>"   tabindex="105" />	</td>
				
			</tr>
		  </table>
									</td>
								  </tr>
								  
								  
					<? if ($_POST['bill_type']==1) {?>
								  
								  <tr>

								 <td>&nbsp;</td>

									<td>&nbsp;</td>
									<td align="right">INSURANCE COMPANY:</td>
									<td>
								
									
									
									
									<select name="cr_ledger_id" id="cr_ledger_id" required="required" style="width:220px;">
									  <option></option>
									  <? foreign_relation('insurance_company','ledger_id','company_name',$_POST['cr_ledger_id'],'1');?>
									</select>
									
									</td>
									<td align="right">REMARKS:</td>
									<td><input name="note" type="text" id="note"  style="width:220px; height:32px;" value=""   tabindex="105" />									</td>
								  </tr>
								  
								  
							<? } elseif ($_POST['bill_type']==2 ) {?>	  
								  
								  
								
  
							<tr>
								  
								  
								  
								   	 <td>PMT. METHOD:</td>

									<td>
								<!--	onchange="getData2('cash_bank_ajax.php', 'cash_bank_filter', this.value,  document.getElementById('payment_method').value);" -->

	<select name="payment_method" id="payment_method" required style="width:220px;" >
		
										<? foreign_relation('payment_method','payment_method','payment_method',$_POST['payment_method'],'1 order by payment_method');?>
									</select>									</td>
									<td align="right">CASH/BANK:</td>
									<td>
								
									<span id="cash_bank_filter">
									
									
									<select name="cr_ledger_id" id="cr_ledger_id" required="required" style="width:220px;">
									  <option></option>
									  <? foreign_relation('accounts_ledger','ledger_id','ledger_name',$bank_ledger,'ledger_group_id in (126002,126003)');?>
									</select>
									</span>
									</td>
									<td align="right">REMARKS:</td>
									<td><input name="note" type="text" id="note"  style="width:220px; height:32px;" value=""   tabindex="105" />									</td>
								  </tr>


								
						<? }  elseif ($_POST['bill_type']==3) {?>
						
						
						
								  
								  
								  
								  
								  <tr>
					
								  
								   	 <td>PMT. METHOD:</td>

									<td>

									<select name="payment_method" id="payment_method"  style="width:220px;">
									<option></option>
	
								
										<? foreign_relation('payment_method','payment_method','payment_method',$_POST['payment_method'],'1');?>
									</select>									</td>
									<td align="right">CASH/BANK:</td>
									<td>
								
									<span id="cash_bank_filter">
									
									
									<select name="cr_ledger_id" id="cr_ledger_id" style="width:220px;">
									  <option></option>
									  <? foreign_relation('accounts_ledger','ledger_id','ledger_name',$_POST['cr_ledger_id'],'ledger_group_id in (126003,126003)');?>
									</select>
									</span>
									</td>
									<td align="right">L/C Part:</td>
									<td>
									
									<select name="lc_part" id="lc_part" required="required" style="width:220px;">
									  <option></option>
									  <? foreign_relation('lc_part','id','lc_part',$_POST['lc_part'],'1');?>
									</select>
									</td>
				 </tr>
				 
				 
				 
				 <tr>

								 <td>&nbsp;</td>

									<td>&nbsp;</td>
									
									<td align="right">REMARKS:</td>
									<td><input name="note" type="text" id="note"  style="width:220px; height:32px;" value=""   tabindex="105" />									</td>
								  </tr>
								  
					  
					  
								  
						
						
						<? } elseif ($_POST['bill_type']==4) { ?>
						
						
						
						<tr>
					
								  
								   	 		<td align="right">LOAN LEDGER: </td>
									<td>
								
								
									<select name="cr_loan_ledger_id" id="cr_loan_ledger_id" style="width:220px;">
									  <option></option>
									  <? foreign_relation('lc_ltr_loan','ledger_id','ltr_number',$_POST['cr_ledger_id'],'ltr_complete!="Yes" and lc_no="'.$_POST['lc_no'].'"');?>
									</select>
									
									</td>
										 <td>SHIPMENT NO</td>

									<td>
									<select name="bank_pay_id" id="bank_pay_id" required="required" style="width:220px;">
									  <option></option>
									  <? foreign_relation('lc_bank_payment','id','lc_no_part',$_POST['bank_pay_id'],'lc_no="'.$_POST['lc_no'].'"');?>
									</select>
									</td> 
								 
								  </tr>
						
						
								
						
						<? } elseif ($_POST['bill_type']==5) { ?>
						
						 
						<tr>
					
								  
								   	<td align="right">Transport  COMPANY:</td>

									<td>

									<select name="cr_ledger_id" id="cr_ledger_id" required="required" style="width:220px;">
									  <option></option>
									  <? foreign_relation('transport_company','ledger_id','company_name',$_POST['cr_ledger_id'],'1');?>
									</select>									</td>
									 
									 
									<td align="right">L/C Part:</td>
									<td>
									
									<select name="lc_part" id="lc_part" required="required" style="width:220px;">
									  <option></option>
									  <? foreign_relation('lc_part','id','lc_part',$_POST['lc_part'],'1');?>
									</select>
									</td>
								  </tr>
						
								  
								  
						
						<? } elseif ($_POST['bill_type']==6 || $_POST['bill_type']==8) {?>
						
						
<tr>

								<td>L/C Part:</td>
									<td>
									
									<select name="lc_part" id="lc_part" required="required" style="width:220px;">
									  <option></option>
									  <? foreign_relation('lc_part','id','lc_part',$_POST['lc_part'],'1');?>
									</select>
									</td>

								 <td align="right">BILL OF ENTRY NO: </td>

									<td>
									<input name="boe_no" type="text" id="boe_no"  style="width:220px; height:32px;" value=""   tabindex="105" />
									</td>
									<td align="right">BILL OF ENTRY DATE: </td>
									<td>
								
								
									
									<input name="boe_date" type="text" id="boe_date"  style="width:220px; height:32px;" value=""   tabindex="105" />
									
									</td>
									
								  </tr>
						
						<tr>

								 <td>C&amp;F COMPANY:</td>

									<td>
									<select name="cr_ledger_id" id="cr_ledger_id" required="required" style="width:220px;">
									  <option></option>
									  <? foreign_relation('cnf_company','ledger_id','company_name',$_POST['cr_ledger_id'],'1');?>
									</select>
									</td>
									<td align="right">R. NO: </td>
									<td>
							
									<input name="r_no" type="text" id="r_no"  style="width:220px; height:32px;" value=""   tabindex="105" />
									
									</td>
									<td align="right">R. DATE :</td>
									<td><input name="r_date" type="text" id="r_date"  style="width:220px; height:32px;" value=""   tabindex="105" />									</td>
								  </tr>
								  
						
						
						<? }elseif ($_POST['bill_type']==7){?>
						
						<tr>
								  
								  
								  
								   	 <td>PMT. METHOD:</td>

									<td>
								<!--	onchange="getData2('cash_bank_ajax.php', 'cash_bank_filter', this.value,  document.getElementById('payment_method').value);" -->

	<select name="payment_method" id="payment_method"  style="width:220px;" >
									<option></option>
	
								
										<? foreign_relation('payment_method','payment_method','payment_method',$_POST['payment_method'],'1');?>
									</select>									</td>
									<td align="right">CASH/BANK:</td>
									<td>
								
									<span id="cash_bank_filter">
									
									
									<select name="cr_ledger_id" id="cr_ledger_id" required="required" style="width:220px;">
									  <option></option>
									  <? foreign_relation('accounts_ledger','ledger_id','ledger_name',$_POST['cr_ledger_id'],'ledger_group_id in (126002,126003)');?>
									</select>
									</span>
									</td>
									<td align="right">REMARKS:</td>
									<td><input name="note" type="text" id="note"  style="width:220px; height:32px;" value=""   tabindex="105" />									</td>
								  </tr>
						
						
						<? } else{ ?>
						
						
						



<tr>
								  
						   	 <td>PMT. METHOD:</td>

									<td>
								<!--	onchange="getData2('cash_bank_ajax.php', 'cash_bank_filter', this.value,  document.getElementById('payment_method').value);" -->

	<select name="payment_method" id="payment_method" required style="width:220px;" >
									<option></option>
	
								
										<? foreign_relation('payment_method','payment_method','payment_method',$_POST['payment_method'],'1');?>
									</select>									</td>
									<td align="right">CASH/BANK:</td>
									<td>
								
									<span id="cash_bank_filter">
									
									
									<select name="cr_ledger_id" id="cr_ledger_id" required="required" style="width:220px;">
									  <option></option>
									  <? foreign_relation('accounts_ledger','ledger_id','ledger_name',$_POST['cr_ledger_id'],'ledger_group_id in (126002,126003)');?>
									</select>
									</span>
									</td>
									<td align="right">REMARKS:</td>
									<td><input name="note" type="text" id="note"  style="width:220px; height:32px;" value=""   tabindex="105" />									</td>
								  </tr>
						
						
						
						
						<? }?>
								  
								  
							
								 
								</table>

    </div>
	
	<? }?>



<? if(isset($_POST['submit'])){ ?>

<div class="tabledesign2" style="width:100%">
 
<table width="100%" border="0" align="center" id="grp" cellpadding="0" cellspacing="0" style="font-size:12px; text-transform:uppercase;">
 <thead>
 <?php 
 
   if($_POST['fdate']!=''&&$_POST['tdate']!='') $date_con .= ' and c.chalan_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
  
  
	
 if($_POST['account_code']!='')
  $account_code_con=" and d.ledger_id=".$_POST['account_code'];
  
 if($_POST['bill_type']!='')
  $bill_type_con=" and bill_type=".$_POST['bill_type'];
  
    $sqlc = 'select d.*, i.* from lc_purchase_master m, lc_purchase_invoice d, item_info i where m.po_no=d.po_no and i.item_id=d.item_id and m.lc_no='.$_POST['lc_no'].'
			 group by d.id order by d.id';
			$queryc=db_query($sqlc);
			while($datac = mysqli_fetch_object($queryc)){
 ?>
 <tr>
  <th colspan="6">
    <label>Assessment Value</label>
    <input type="text" 
           class="form-control assesment_value" 
           name="assesment_value_<?=$datac->item_id?>" 
           id="assesment_value_<?=$datac->item_id?>" 
           style="max-width:30%;border:2px solid red!important;" />
  </th>
</tr>
 <tr>
	<th>Item Name</th>
	<th>Item Unit</th>
	<th>Item Qty</th>
	<th>Item Rate</th>
	<th>Item Amount</th>
	<th></th>
</tr>
 <tr>
	<td><?php echo $datac->item_name;?></td>
	<td><?php echo $datac->item_unit;?></td>
	<td><?php echo $datac->qty;?></td>
	<td><?php echo $datac->rate_usd;?></td>
	<td><?php echo $datac->amount_usd;?></td>
	<td></td>
	
</tr>
  <tr>
    <th width="6%">Code</th>

    <th width="15%">Payment Type </th>

    <th width="33%">Payment Category </th>
	 <th width="33%">Percentage </th>
    <th width="15%">Payment Amt </th>
    <th width="15%">Remarks</th>
  </tr>
  </thead>

   


<?php 
    $sql = "SELECT id, bill_type, bill_category FROM lc_bill_category WHERE 1 ".$bill_type_con." and partial_charge='YES' order  by bill_type,id ";
  $query = db_query($sql);
  while($data=mysqli_fetch_object($query)){$i++;
  ?>



<? //if ($due_amt=$data->invoice_amt-$payment_amt[$data->ledger_id][$data->tr_no]+$return_amt[$data->ledger_id][$data->tr_no]>0) {?>

  <tr bgcolor="<?=($i%2)?'#E8F3FF':'#fff';?>">
    <td><span class="style13" style="color:#000000; font-weight:700;">
      <?=$data->id;?>
    </span></td>

    <td>
     <?=find_a_field('lc_bill_type','bill_type','id='.$data->bill_type);?>    </td>

    <td><?=$data->bill_category;?></td>
	 <td>
	<input name="percentage_<?=$datac->item_id?>_<?=$data->id?>" id="percentage_<?=$datac->item_id?>_<?=$data->id?>" type="text"   value="<?php 
	 if($data->id==25){
	 echo $datac->cd;
	 } 
	 else if($data->id==26){
	  echo $datac->rd;
	 }
	  else if($data->id==27){
	  echo $datac->sd;
	 }
	   else if($data->id==28){
	  echo $datac->vat;
	 }
	   else if($data->id==29){
	  echo $datac->ait;
	 }
	   else if($data->id==30){
	  echo $datac->at;
	 }
	   else if($data->id==31){
	  echo $datac->atv;
	 }
	 
	 ?>" style="width:200px; height:25px;"  />
	 </td>
    <td>
	
	<input name="bill_type_<?=$datac->item_id?>_<?=$data->id?>" id="bill_type_<?=$datac->item_id?>_<?=$data->id?>" type="hidden" size="10"  value="<?=$data->bill_type;?>" style="width:80px;" />
 <input name="bill_category_<?=$datac->item_id?>_<?=$data->id?>" id="bill_category_<?=$data->item_id?>" type="hidden" size="10"  value="<?=$data->id;?>" style="width:80px;" />
 <input name="payment_amt_<?=$datac->item_id?>_<?=$data->id?>" id="payment_amt_<?=$datac->item_id?>_<?=$data->id?>" type="text" size="10"  value="" onkeyup="SUMcalculation(<?=$datac->item_id?>,<?=$data->id?>)"  style="width:120px; height:25px;"  />	</td>
    <td align="center"><input name="remarks_<?=$datac->item_id?>_<?=$data->id?>" id="remarks_<?=$datac->item_id?>_<?=$data->id?>" type="text"   value="" style="width:200px; height:25px;"  />	</td>
  </tr>
  <? } }?>
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="center"><div align="right"><strong>Total:</strong></div></td>
    <td><input name="total_amt" id="total_amt" type="text" size="10"  value="<?=$total_amt?>" style="width:120px; height:25px;"  />	</td>
    <td align="center">&nbsp;</td>
  </tr>

  
</table>



</div>
<br /><br />

<table width="100%" border="0">






<tr>

<td align="center">&nbsp;

</td>

<td align="center">
<!--<input  name="do_no" type="hidden" id="do_no" value="<?=$_POST['do_no'];?>"/>-->
<input name="confirmit" type="submit" class="btn1" value="SAVE & NEW" style="width:220px; font-weight:bold; float:right; background:#6699FF; font-size:12px; height:30px; color: #000000;" /></td>

</tr>



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
<script>
document.addEventListener("DOMContentLoaded", function() {

    function recalcPayments() {
        let grandTotal = 0;

        // Loop through all assessment inputs (per item)
        document.querySelectorAll("input[id^='assesment_value_']").forEach(function(assessInput) {
            let item_id = assessInput.id.split("_")[2];
            let assesmentValue = parseFloat(assessInput.value) || 0;

            // Loop percentages for this item
            document.querySelectorAll(`input[id^='percentage_${item_id}_']`).forEach(function(percInput) {
                let bill_id = percInput.id.split("_")[2];
                let percentage = parseFloat(percInput.value) || 0;
                let payment = (assesmentValue * percentage) / 100;

                let paymentInput = document.getElementById(`payment_amt_${item_id}_${bill_id}`);
                if (paymentInput) {
                    paymentInput.value = payment.toFixed(2);
                    grandTotal += payment;
                }
            });
        });

        // Update grand total field
        let totalField = document.getElementById("total_amt");
        if (totalField) {
            totalField.value = grandTotal.toFixed(2);
        }
    }

    // Trigger recalculation on keyup for assessment and percentage fields
    document.querySelectorAll("input[id^='assesment_value_'], input[id^='percentage_']").forEach(function(input) {
        input.addEventListener("keyup", recalcPayments);
    });

});
</script>


</div>



<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>