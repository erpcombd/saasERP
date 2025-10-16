<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Vendor Bill Payment';

do_calander('#fdate');

do_calander('#tdate');

$table = 'purchase_receive';

$unique = 'grn_no';

$status = 'CHECKED';

$target_url = '../vendor_invoice/new_bill_create.php';


if($_REQUEST[$unique]>0)

{

$_SESSION[$unique] = $_REQUEST[$unique];

header('location:'.$target_url);

}


if(isset($_POST['confirm_payment'])){
 
 
$doc_vendor = 3021100143;
$tds_payable = 3021000132;
$vds_payable = 3021000133;
$advance_to_vendor_dr = 1022400004;
$tr_from = 'Vendor_payment';
$entry_by = $_SESSION['user']['id'];
$entry_at = date('Y-m-d H:i:s');
$jv_no=next_journal_sec_voucher_id();		
$proj_id = 'MEP';

$jv_date = date('Y-m-d');

 $vendor = explode("#",$_POST['vendor_id']);
 $con = 'and m.vendor_id="'.$vendor[1].'"';
 
  $res='select m.invoice_no,m.system_invoice_no,m.invoice_date,m.po_no,m.grn_no,sum(d.amount) as amount,m.tds_percent,v.vendor_name,v.sub_ledger_id,v.sub_ledger_id,m.entry_at,u.fname from vendor_invoice_master m, vendor_invoice_details d, vendor v, user_activity_management u where m.system_invoice_no=d.system_invoice_no and m.vendor_id=v.vendor_id and m.entry_by=u.user_id '.$con.' group by m.system_invoice_no';

$query = db_query($res);
while($data=mysqli_fetch_object($query)){

$checked = $_POST['system_invoice_no'.$data->system_invoice_no];
if($checked){

$total_amount = $_POST['total_amount'];
$advance_amt = $_POST['advance_amt'.$data->system_invoice_no];
$net_payable = $_POST['net_payable']; 
$cheq_no = $_POST['cheq_no'];
$cheq_date = $_POST['cheq_date'];
$invoice_value = $data->amount;
$credit_sub_ledger = end(explode("#",$_POST['receive_sub_ledger']));
$credit_ledger = find_a_field('general_sub_ledger','ledger_id','sub_ledger_id="'.$credit_sub_ledger.'"');


$tds_amount = ($data->amount*$data->tds_percent)/100;
$po_info = find_all_field('purchase_master','','po_no="'.$data->po_no.'"');
if($po_info->deductible=='Yes'){
$vds_amount = ($data->amount*$po_info->vat)/100;
}else{
$vds_amount = 0;
}


$narration = 'Invoice No.'.$invoice_no;

$tr_no = $data->system_invoice_no;


$narration = "Vendor Payable. Invoice No.".$data->invoice_no."";
add_to_sec_journal($proj_id, $jv_no, $jv_date, $doc_vendor, $narration, $total_amount, 0, $tr_from, $tr_no,$data->sub_ledger_id,$tr_id,$cc_code,$group,$entry_by,$entry_at);
add_to_journal($proj_id, $jv_no, $jv_date, $doc_vendor, $narration, $total_amount, 0, $tr_from, $tr_no,$data->sub_ledger_id,$tr_id,$cc_code,$group,$entry_by,$entry_at);

if($tds_amount>0){ 
$narration = "Vendor TDS Payable. Invoice No.".$data->invoice_no."";
add_to_sec_journal($proj_id, $jv_no, $jv_date, $tds_payable, $narration, 0, $tds_amount, $tr_from, $tr_no,$data->sub_ledger_id,$tr_id,$cc_code,$group,$entry_by,$entry_at);
add_to_journal($proj_id, $jv_no, $jv_date, $tds_payable, $narration, 0, $tds_amount, $tr_from, $tr_no,$data->sub_ledger_id,$tr_id,$cc_code,$group,$entry_by,$entry_at);
}

if($vds_amount>0){
$narration = "Vendor VDS Payable. Invoice No.".$data->invoice_no."";
add_to_sec_journal($proj_id, $jv_no, $jv_date, $vds_payable, $narration, 0, $vds_amount, $tr_from, $tr_no,$data->sub_ledger_id,$tr_id,$cc_code,$group,$entry_by,$entry_at);
add_to_journal($proj_id, $jv_no, $jv_date, $vds_payable, $narration, 0, $vds_amount, $tr_from, $tr_no,$data->sub_ledger_id,$tr_id,$cc_code,$group,$entry_by,$entry_at);
}

if($advance_amt>0){
$narration = "Advance Adjustment. Invoice No.".$data->invoice_no."";
add_to_sec_journal($proj_id, $jv_no, $jv_date, $advance_to_vendor_dr, $narration, 0, $advance_amt, $tr_from, $tr_no,$data->sub_ledger_id,$tr_id,$cc_code,$group,$entry_by,$entry_at);
add_to_journal($proj_id, $jv_no, $jv_date, $advance_to_vendor_dr, $narration, 0, $advance_amt, $tr_from, $tr_no,$data->sub_ledger_id,$tr_id,$cc_code,$group,$entry_by,$entry_at);
}


$paid_amount = find_a_field('journal','sum(dr_amt)','ledger_id="'.$doc_vendor.'" and sub_ledger="'.$data->sub_ledger_id.'" and tr_no="'.$data->system_invoice_no.'" and tr_from="Vendor_payment"');
if($invoice_value==$paid_amount){
$invoice_update = 'update vendor_invoice_master set status="PAID" where system_invoice_no="'.$data->system_invoice_no.'"';
db_query($invoice_update);
}
$all_invoice .= $data->invoice_no.', ';
}

}

$narration = "Cheque No.".$cheq_no.", Cheque Date ".$cheq_date." Invoice No.".$data->invoice_no."";
add_to_sec_journal($proj_id, $jv_no, $jv_date, $credit_ledger, $narration, 0, $net_payable, $tr_from, $tr_no,$credit_sub_ledger,$tr_id,$cc_code,$group,$entry_by,$entry_at);
add_to_journal($proj_id, $jv_no, $jv_date, $credit_ledger, $narration, 0, $net_payable, $tr_from, $tr_no,$credit_sub_ledger,$tr_id,$cc_code,$group,$entry_by,$entry_at);
//sec_journal_journal2($jv_no,$jv_no,$tr_from);
 
}



?>

<script language="javascript">

function custom(theUrl)

{

	window.open('<?=$target_url?>?<?=$unique?>='+theUrl);
	//window.location.href = "<?=$target_url?>?<?=$unique?>="+theUrl;

}

</script>



<div style="text-align:center;"><?=$_SESSION['inv_msg']; unset($_SESSION['inv_msg']);?></div>
<div class="form-container_large">
    <form action="" method="post" name="codz" id="codz">
            
        <div class="container-fluid bg-form-titel">
            <div class="row">
                <div class="col-sm-10 col-md-10 col-lg-10 col-xl-10">
                
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Select Vendor: </label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <input type="text" name="vendor_id" id="vendor_id" value="<?=$_POST['vendor_id']?>" list="vendor" />
							<datalist id="vendor">
							  <? foreign_relation('vendor','concat(vendor_name,"#",vendor_id)','""',$vendor_id,'vendor_category=2')?>
							</datalist>
                        </div>
                    </div>

                </div>
                

                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                   
                    <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" class="btn1 btn1-submit-input"/>
                </div>

            </div>
        </div>





        <div class="container-fluid pt-5 p-0 ">

            <?

            if(isset($_POST['submitit'])){

            
                $vendor = explode("#",$_POST['vendor_id']);
                $con = 'and m.vendor_id="'.$vendor[1].'"';
				

$res='select m.invoice_no,m.system_invoice_no,m.invoice_date,m.po_no,m.grn_no,sum(d.amount) as amount,m.tds_percent,v.vendor_name,v.sub_ledger_id,v.sub_ledger_id,m.entry_at,u.fname from vendor_invoice_master m, vendor_invoice_details d, vendor v, user_activity_management u where m.system_invoice_no=d.system_invoice_no and m.vendor_id=v.vendor_id and m.entry_by=u.user_id and m.status="PENDING" '.$con.' group by m.system_invoice_no';

            $query = db_query($res);

            //echo link_report($res,'po_print_view.php');
            ?>


                <table class="table1  table-striped table-bordered table-hover table-sm">
                    <thead class="thead1">
					<tr class="bgc-info">
					 <th>Invoice Count<input type="text" id="invoice_count" name="invoice_count" readonly /></th>
					 <th>Total Amount<input type="text" id="total_amount" name="total_amount" readonly /></th>
					 <th>Net Advance<input type="text" id="total_advance" name="total_advance" readonly /></th>
					 <th>TDS Amount<input type="text" id="total_tds_amount" name="total_tds_amount" readonly /></th>
					
					 <th>VDS Amount<input type="text" id="total_vds_amount" name="total_vds_amount" readonly /></th>
					 
					 <th>Net Payable<input type="text" id="net_payable" name="net_payable" readonly /></th>
					 <th>Cash/Bank<input type="text" id="receive_sub_ledger" name="receive_sub_ledger" list="cash_bank"/>
					 <datalist id="cash_bank">
							  <? foreign_relation('general_sub_ledger','concat(sub_ledger_name,"#",sub_ledger_id)','""',$receive_ledger,'tr_from="custom" and type="Bank"')?>
							</datalist>					 </th>
					 
					 <th>Cheq. No.<input type="text" id="cheq_no" name="cheq_no"/></th>
					 <th>Cheq. Date<input type="date" id="cheq_date" name="cheq_date"/></th>
					 <th></th>
					 <th></th>
					 <th></th>
					</tr>
                    <tr class="bgc-info">
                        <th>SL</th>
                        <th>Invoice No.</th>
                        <th>Invoice Date</th>
						<th>PO No.</th>
                        <th>GRN No.</th>
                        <th>Amount With Vat</th>
                        <th>Unpaid Amount</th>
						<th>Advance Adjustment</th>
						<th>Payable</th>
						<th>TDS Amount</th>
						<th>VDS Amount</th>
                    </tr>
                    </thead>

                    <tbody class="tbody1">

                    <?
					$doc_vendor = 3021100143;
					$advance_to_vendor_dr = 1022400004;
                    while($row = mysqli_fetch_object($query)){
					$tds_amount = ($row->amount*$row->tds_percent)/100;
					
					$po_info = find_all_field('purchase_master','','po_no="'.$row->po_no.'"');
					$vat_amount = ($row->amount*$po_info->vat)/100;
					$amount_with_vat = $row->amount+$vat_amount;
					
					if($po_info->deductible=='Yes'){
					$vds_amount = $vat_amount;
					}else{
					$vds_amount = 0;
					}
					
				    $paid_amount = find_a_field('journal','sum(dr_amt)','ledger_id="'.$doc_vendor.'" and sub_ledger="'.$row->sub_ledger_id.'" and tr_no="'.$row->system_invoice_no.'" and tr_from="Vendor_payment"');
					
					$advance_amt = find_a_field('journal','sum(dr_amt)','ledger_id="'.$advance_to_vendor_dr.'" and sub_ledger="'.$row->sub_ledger_id.'" and tr_no="'.$row->po_no.'" and tr_from="Vendor_advance_payment"');
					
					$advance_amt_adjusted = find_a_field('journal','sum(cr_amt)','ledger_id="'.$advance_to_vendor_dr.'" and sub_ledger="'.$row->sub_ledger_id.'" and tr_no="'.$row->system_invoice_no.'" and tr_from="Vendor_payment"');
					//$sql = 'select sum(dr_amt) from journal where ledegr_id="'.$doc_vendor.'" and sub_ledger="'.$row->sub_ledger_id.'" and tr_no="'.$row->system_invoice_no.'" and tr_from="Vendor_payment"';
					$rest_advance_amt = $advance_amt-$advance_amt_adjusted;
					$unpaid_amount = $amount_with_vat-($paid_amount);
					
                        ?>

                        <tr>
<td>
<input type="hidden" name="sub_ledger_id" id="sub_ledger_id" value="<?=$row->sub_ledger_id?>" />
<input type="checkbox" name="system_invoice_no<?=$row->system_invoice_no?>" class="form-control" id="system_invoice_no<?=$row->system_invoice_no?>" onclick="payment_cal(<?=$row->system_invoice_no?>)" /></td>
							<td><?=$row->invoice_no?></td>
                            <td><?=$row->invoice_date?></td>
                            <td><?=$row->po_no?></td>
                            <td><?=$row->grn_no?></td>
                            <td><?=number_format($amount_with_vat,2)?></td>
                            <td><?=number_format($unpaid_amount,2)?><input type="hidden" name="net_amount<?=$row->system_invoice_no?>" id="net_amount<?=$row->system_invoice_no?>" value="<?=$unpaid_amount?>" /></td>
                            <td><input type="text" name="advance_amt<?=$row->system_invoice_no?>" id="advance_amt<?=$row->system_invoice_no?>" value="<?=$rest_advance_amt?>" onChange="advance_cal(<?=$row->system_invoice_no?>);" readonly /></td>
                            
                          <td><input type="text" name="actual_payable<?=$row->system_invoice_no?>" id="actual_payable<?=$row->system_invoice_no?>" value="<?=$unpaid_amount-$rest_advance_amt?>" /></td>
<td><?=$tds_amount?><input type="hidden" name="tds_amount<?=$row->system_invoice_no?>" id="tds_amount<?=$row->system_invoice_no?>" value="<?=$tds_amount?>" /></td>
<td><?=$vds_amount?><input type="hidden" name="vds_amount<?=$row->system_invoice_no?>" id="vds_amount<?=$row->system_invoice_no?>" value="<?=$vds_amount?>" /></td>
                        </tr>

                    <? } ?>
					
					<tr>
					  
					  <td colspan="11"><input type="submit" name="confirm_payment" id="confirm_payment" value="Confirm Payment" /></td>
					</tr>
                    </tbody>
                </table>

                <? } ?>


        </div>
    </form>
</div>


<script>

function advance_cal(invoice_no){
	
	 var actual_amt = document.getElementById("net_amount"+invoice_no).value*1;
	 //alert(actual_amt);
	 var advance_amt = document.getElementById("advance_amt"+invoice_no).value*1;
	 var actual = actual_amt-advance_amt;
	 document.getElementById('actual_payable'+invoice_no).value = actual;
	}

 function payment_cal(invoice_no){

/*alert('test');
$.ajax({
url:"payment_ajax.php",
method:"POST",
dataType:"JSON",
data:{ 
       year:year,
       mon:mon,
	 },
success: function(result, msg){
var res = result;
//setTimeout(view_data, 5000);
//$("#presentStock").html(res[0]);
$("#invoice_count").val('10');*/
	 
	 
	 
	 
	
 var checked_invoice = $("#system_invoice_no"+invoice_no);
 //alert(invoice_no);
 if(document.getElementById("system_invoice_no"+invoice_no).checked == true){
  document.getElementById('invoice_count').value  = $('input:checkbox:checked').length;
  
  var total_amt = document.getElementById("net_amount"+invoice_no).value*1;
  var actual_payable = document.getElementById("actual_payable"+invoice_no).value*1;
  var tds_amt = document.getElementById("tds_amount"+invoice_no).value*1;
  var vds_amt = document.getElementById("vds_amount"+invoice_no).value*1;
  var advance_amt = document.getElementById("advance_amt"+invoice_no).value*1;
  
  var pre_total_amt = document.getElementById("total_amount").value*1;
  var pre_tds = document.getElementById("total_tds_amount").value*1;
  var pre_vds = document.getElementById("total_vds_amount").value*1;
  var pre_advance = document.getElementById("total_advance").value*1;
  var pre_net_payable = document.getElementById("net_payable").value*1;
  
  
  var total_payable = actual_payable+pre_total_amt+advance_amt;
  var grand_total_tds = tds_amt+pre_tds;
  var grand_total_vds = vds_amt+pre_vds;
  var grand_total_advance = advance_amt+pre_advance;
  var grand_total_payable = (total_payable)-(grand_total_tds+grand_total_vds+grand_total_advance);
  
  document.getElementById('total_amount').value = total_payable;
  document.getElementById('total_tds_amount').value = grand_total_tds;
  document.getElementById('total_vds_amount').value = grand_total_vds;
  document.getElementById('total_advance').value = grand_total_advance;
  document.getElementById('net_payable').value = grand_total_payable;
  
  
  }else{
  
  document.getElementById('invoice_count').value  = $('input:checkbox:checked').length;
  
  var total_amt = document.getElementById("net_amount"+invoice_no).value*1;
  var actual_payable = document.getElementById("actual_payable"+invoice_no).value*1;
  var tds_amt = document.getElementById("tds_amount"+invoice_no).value*1;
  var vds_amt = document.getElementById("vds_amount"+invoice_no).value*1;
  var advance_amt = document.getElementById("advance_amt"+invoice_no).value*1;
  
  var pre_total_amt = document.getElementById("total_amount").value*1;
  var pre_tds = document.getElementById("total_tds_amount").value*1;
  var pre_vds = document.getElementById("total_vds_amount").value*1;
  var pre_advance = document.getElementById("total_advance").value*1;
  var pre_net_payable = document.getElementById("net_payable").value*1;
  
  
  
  var total_payable = pre_total_amt-(actual_payable+advance_amt);
  var grand_total_tds = pre_tds-tds_amt;
  var grand_total_vds = pre_vds-vds_amt;
  var grand_total_advance = advance_amt-pre_advance;
  var grand_total_payable = (total_payable)-(grand_total_tds+grand_total_vds);
  
  document.getElementById('total_amount').value = total_payable;
  document.getElementById('total_tds_amount').value = grand_total_tds;
  document.getElementById('total_vds_amount').value = grand_total_vds;
  document.getElementById('total_advance').value = grand_total_advance;
  document.getElementById('net_payable').value = grand_total_payable;
  
  }
 
 
 }
</script>

<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>