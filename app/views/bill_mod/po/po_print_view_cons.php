<?php



session_start();



require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

require_once "../../../assets/support/class.numbertoword.php";


$d_id		= $_REQUEST['d_id'];

$sql1="select * from daily_plan_master where d_id='$d_id'";
$data=mysqli_fetch_object(db_query($sql1));
 $progress_for = $data->progress_for;
$vendor=find_all_field('vendor','','vendor_id='.$data->vendor_id );
$whouse=find_all_field('warehouse','','warehouse_id='.$data->warehouse_id);
 $dept = find_a_field('daily_progress_setup','type','id="'.$progress_for.'"');

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: Daily Work Plan :.</title>
<link href="../../../css_js/css/invoice.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript">
function hide(){
    document.getElementById("pr").style.display="none";
}



</script>
<style type="text/css">
.style4 {
	font-size: 12px;
	font-weight: bold;
}

.style5 {font-weight: bold}

.style6 {font-weight: bold}

.style7 {font-weight: bold}

.style9 {font-weight: bold}

.style10 {font-weight: bold}
</style></head>

<body>


<table width="100%" border="0" bordercolor="#FFFFFF" cellpadding="0" cellspacing="0" style="border:0px;border-color:#FFF" >


<tr>
<td width="33%" align="left" style="border:0px;border-color:#FFF;"><strong>Head Office:</strong></td>
<td width="33%" align="center" style="border:0px;border-color:#FFF;"><strong>Action Plan of</strong></td>
<td width="33%" align="center" style="border:0px;border-color:#FFF;"><img src="<?=SERVER_ROOT?>public/uploads/logo/demo7.png" style="float:right; margin-right:40px ; width:120px" ></td>
 
</tr>


<tr>
  <td width="33%" align="left" style="border:0px;border-color:#FFF;">34 Topkhana Road, Dhaka-1000</td>
  <td width="33%" align="center" style="border:0px;border-color:#FFF;">Of</td>
  
 
</tr>

<tr>
  <td width="33%" align="left" style="border:0px;border-color:#FFF;"><strong>Factory:</strong></td>
  <td width="33%" align="center" style="border:0px;border-color:#FFF;"><strong><?=$dept?></strong></td>
</tr>

<tr>
  <td width="33%" align="left" style="border:0px;border-color:#FFF;">103/1, Promixco Industrial Park</td>
  <td width="33%" align="center" style="border:0px;border-color:#FFF;"><?=date('d-M-Y')?></td>
</tr>

<tr>
  <td width="33%" align="left" style="border:0px;border-color:#FFF;">Mouchak, Kaliakair, Gazipur-1750, Bangladesh</td>
</tr>


</table>


	
  <tr>
    <td><div class="line">
      <div align="center"><span class="style4"></span><br />

      </div>
    </div>
	</td>
	
  </tr>
  </table>

  <tr>
    <td><div id="pr">
      <div align="left">
          <table width="60%" border="0" cellspacing="0" cellpadding="0">
		  
        <tr>
          <td><input name="button" type="button" onclick="hide();window.print();" value="Print" /></td>
		  
            <input type="hidden" name="d_id" id="d_id" value="<?=$d_id?>" /></td>
        </tr>
		
      </table>
      </div>
    </div>

<? if($progress_for=='1'){ ?>

<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0">
	<thead>
       <tr>
        <td width="4%" align="center"><strong>SL</strong></td>
		<td width="10%" align="center"><strong>Name</strong></td>
		<td width="11%" align="center" ><strong>Section</strong></td>
		<td width="30%" align="center"><strong>Action Plan</strong></td>
		<td width="11%" align="center" ><strong>Target Amount</strong></td>
		<td width="15%" align="center" ><strong>Challenges</strong></td>
		<td width="20%" align="center" ><strong>Progress</strong></td>
		<td width="11%" align="center" ><strong>Follow Up</strong></td>
      </tr>
	 </thead>
	  <?php
$final_amt=0;
$pi=0;
$total=0;
 $sql2='select a.id, a.customer_name as name, a.address as section, a.pet_type as action_plan, a.delivery as target_amount, a.gap_analysis as challenges, a.collection as progress, a.next_visit as follow_up, "x" from daily_plan_details a where  a.d_id='.$d_id;
$data2=db_query($sql2);
while($info=mysqli_fetch_object($data2)){ 
$pi++;
$sl=$pi;
$qty=$info->qty;
$unit_name=$info->unit_name;
$rate=$info->rate;
$disc=$info->disc;
?>
	<tr>
        <td valign="top" align="center"><?=$sl?></td>
        <td align="center" valign="top"><?=$info->name?></td>
        <td align="left" valign="top"><?=$info->section?></td>
        <td align="Center" valign="top"><?=$info->action_plan?></td>
        <td align="left" valign="top"><?=$info->target_amount?></td>
		 <td align="left" valign="top"><?=$info->challenges?></td>
        <td align="Center" valign="top"><?=$info->progress?></td>
        <td align="left" valign="top"><?=$info->follow_up?></td>
     </tr>
<? }?>
    </table>
	
	
	<? }elseif($progress_for=='31'){ ?>

<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0">
	<thead>
       <tr>
        <td width="4%" align="center"><strong>SL No</strong></td>
		<td width="4%" align="center"><strong>Project</strong></td>
        <td width="11%" align="center"><strong>Section</strong></td>
		<td width="30%" align="center"><strong>Action Plan</strong></td>
		<td width="8%" align="center"><strong>Amount/Qty</strong></td>
		<td width="11%" align="center"><strong>Challenges</strong></td>
		<td width="11%" align="center"><strong>Departmental Step</strong></td>
		<td width="20%" align="center"><strong>Progress</strong></td>
		<td width="15%" align="center"><strong>Recommendation</strong></td>
		<td width="15%" align="center"><strong>Suggestion</strong></td>
		<td width="11%" align="center"><strong>Time Line</strong></td>
      </tr>
	</thead>
	  <?php
$final_amt=0;
$pi=0;
$total=0;
 $sql2='select a.id, a.address as project, a.customer_name as section, a.plan as action_plan, a.man_power as challenges, a.service_type as departmental_step,a.collection as qty, a.progress, a.gap_analysis as recommendation, a.findings as suggestion, a.next_visit as time_line, "x" from daily_plan_details a where  a.d_id='.$d_id;
$data2=db_query($sql2);
while($info=mysqli_fetch_object($data2)){ 
$pi++;
$sl=$pi;
$qty=$info->qty;
$unit_name=$info->unit_name;
$rate=$info->rate;
$disc=$info->disc;
?>
	<tr>
        <td valign="top" align="center"><?=$sl?></td>
		<td align="center" valign="top"><?=$info->project?></td>
        <td align="center" valign="top"><?=$info->section?></td>
        <td align="left" valign="top"><?=$info->action_plan?></td>
		<td align="Center" valign="top"><?=$info->qty?></td>
        <td align="Center" valign="top"><?=$info->challenges?></td>
		<td align="left" valign="top"><?=$info->departmental_step?></td>
        <td align="left" valign="top"><?=$info->progress?></td>
		 <td align="left" valign="top"><?=$info->recommendation?></td>
		 <td align="left" valign="top"><?=$info->suggestion?></td>
		 <td align="left" valign="top"><?=$info->time_line?></td>
     </tr>
<? }?>
    </table>
	
	
	<? }elseif($progress_for=='53'){ ?>

<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0">
	<thead>
       <tr>
        <td width="4%" align="center"><strong>SL</strong></td>
		<td width="8%" align="center" ><strong>Project Name</strong></td>
		<td width="20%" align="center"><strong>Action Plan</strong></td>
		<td width="8%" align="center"><strong>Manpower</strong></td>
		<td width="30%" align="center"><strong>Consumption Plan</strong></td>
		<td width="20%" align="center"><strong>Progress</strong></td>
		<td width="20%" align="center"><strong>Actual Consumption</strong></td>
		<td width="11%" align="center"><strong>Production</strong></td>
      </tr>
	</thead>
	  <tbody>
	  <?php
$final_amt=0;
$pi=0;
$total=0;
 $sql2='select a.id, a.day, a.customer_name, a.plan, a.man_power, a.progress,a.requisition , a.amount, "x" from daily_plan_details a where  a.d_id='.$d_id;
$data2=db_query($sql2);
while($info=mysqli_fetch_object($data2)){ 
$pi++;
$sl=$pi;
$qty=$info->qty;
$unit_name=$info->unit_name;
$rate=$info->rate;
$disc=$info->disc;
?>
	<tr>
        <td valign="top" align="center"><?=$sl?></td>
        <td valign="top" style="padding:5px;"><?=$info->day?></td>
        <td align="center" valign="top"><textarea style="width:100%; height:100% auto"><?=$info->customer_name?></textarea></td>
        <td align="center" valign="top"><?=$info->plan?></td>
        <td align="Center" valign="top"><textarea style="width:100%; height:100% auto"><?=$info->man_power?></textarea></td>
        <td align="left" valign="top"><textarea style="width:100%; height:100% auto"><?=$info->progress?></textarea></td>
		<td align="left" valign="top"><textarea style="width:100%; height:100% auto"><?=$info->requisition?></textarea></td>
		<td align="left" valign="top"><?=$info->amount?></td>
     </tr>
<? 
$total_req_amt += $info->amount;
}?>

	<tr>
      <td colspan="7">Total</td>
	  <td align="center"><?=number_format($total_req_amt,2) ?></td>
    </tr>
	</tbody>
    </table>
	
	
	<? }
	
	
	elseif($progress_for=='52'){ ?>

<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0">
	<thead>
       <tr>
        <td width="4%" align="center"><strong>SL</strong></td>
		<td width="15%" align="center"><strong>Customer Name</strong></td>
		<td width="11%" align="center"><strong>Lot No</strong></td>
		<td width="11%" align="center"><strong>Product Name</strong></td>
		<td width="20%" align="center"><strong>Consumption Cost</strong></td>
		<td width="20%" align="center"><strong>Operating Cost</strong></td>
		<td width="15%" align="center"><strong>Overhead Cost</strong></td>
		<td width="11%" align="center" ><strong>Production Target</strong></td>
		<td width="11%" align="center" ><strong>Production Achieved</strong></td>
		<td width="11%" align="center" ><strong>Production Cost</strong></td>
      </tr>
	</thead>
	  <tbody>
	  <?php
$final_amt=0;
$pi=0;
$total=0;
 $sql2='select a.id, a.customer_name, a.man_power, a.plan, a.delivery, a.amount, a.collection, a.outstanding, a.category, a.pet_type, "x" from daily_plan_details a where  a.d_id='.$d_id;
$data2=db_query($sql2);
while($info=mysqli_fetch_object($data2)){ 
$pi++;
$sl=$pi;
$qty=$info->qty;
$unit_name=$info->unit_name;
$rate=$info->rate;
$disc=$info->disc;
?>
	<tr>
        <td valign="top" align="center"><?=$sl?></td>
        <td align="center" valign="top"><?=$info->customer_name?></td>
        <td align="Center" valign="top"><?=$info->man_power?></td>
        <td align="left" valign="top"><?=$info->plan?></td>
		<td align="left" valign="top"><?=$info->delivery?></td>
        <td align="left" valign="top"><?=$info->amount?></td>
		 <td align="left" valign="top"><?=$info->collection?></td>
		 <td align="left" valign="top"><?=$info->outstanding?></td>
		 <td align="left" valign="top"><?=$info->category?></td>
		 <td align="left" valign="top"><?=$info->pet_type?></td>
     </tr>
<? 
$total_req_amt += $info->pet_type;

}?>

<tr>
      <td colspan="9">Total Production Cost =</td>
	  <td><?=number_format($total_req_amt,2) ?></td>
    </tr>
	</tbody>
    </table>
	


<? }elseif($progress_for=='32'){ ?>

<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0">
	<thead>
       <tr>
        <td width="4%" align="center"><strong>SL</strong></td>
        <td width="11%" align="center" ><strong>Owner</strong></td>
		<td width="16%" align="center" ><strong>Address</strong></td>
		<td width="8%" align="center"><strong>Pet Name</strong></td>
		<td width="11%" align="center" ><strong>Pet Type</strong></td>
		<td width="11%" align="center"><strong>Patient Category</strong></td>
		<td width="15%" align="center" ><strong>Service type</strong></td>
		<td width="11%" align="center" ><strong>Mobile</strong></td>
		<td width="11%" align="center" ><strong>Email</strong></td>
		<td width="8%" align="center" ><strong>Next Visit</strong></td>
		<td width="11%" align="center" ><strong>Total</strong></td>
		<td width="11%" align="center" ><strong>Remarks</strong></td>
      </tr>
	</thead>
	  <?php
$final_amt=0;
$pi=0;
$total=0;
 $sql2='select a.id, a.customer_name,a.address,a.man_power ,a.pet_type,a.pet_category,a.service_type,a.mobile,a.email,a.next_visit,a.amount,a.findings from daily_plan_details a where  a.d_id='.$d_id;
$data2=db_query($sql2);
while($info=mysqli_fetch_object($data2)){ 
$pi++;
$sl=$pi;
$qty=$info->qty;
$unit_name=$info->unit_name;
$rate=$info->rate;
$disc=$info->disc;
?>
	<tr>
        <td valign="top" align="center"><?=$sl?></td>
        <td align="left" valign="top" style="padding:5px;"><?=$info->customer_name?></td>
        <td valign="top" style="padding:5px;"><?=$info->address?></td>
        <td align="center" valign="top"><?=$info->man_power?></td>
        <td align="center" valign="top"><?=$info->pet_type?></td>
        <td align="Center" valign="top"><?=$info->pet_category?></td>
        <td align="left" valign="top"><?=$info->service_type?></td>
		 <td align="left" valign="top"><?=$info->mobile?></td>
        <td align="Center" valign="top"><?=$info->email?></td>
        <td align="left" valign="top"><?=$info->next_visit?></td>
		<td align="center" valign="top"><?=$info->amount?></td>
		<td align="left" valign="top"><?=$info->findings?></td>
     </tr>
<? }?>
    </table>


	
	
<? } elseif($progress_for=='2'){ ?>
<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0">
	<thead>
       <tr>
        <td width="4%" align="center"><strong>SL</strong></td>
        <td width="11%" align="center" ><strong>Particulars</strong></td>
		<td width="11%" align="center" ><strong>Customer Name</strong></td>
		<td width="11%" align="center" ><strong>Amount</strong></td>
		<td width="30%" align="center" ><strong>Plan</strong></td>
		<td width="20%" align="center" ><strong>Progress</strong></td>
		<td width="15%" align="center"><strong>Problem</strong></td>
		<td width="15%" align="center"><strong>Requisition</strong></td>
      </tr>
	</thead>
	  <tbody>
	  <?php
$final_amt=0;
$pi=0;
$total=0;
 $sql2='select a.id, d.category, a.particular, a.amount, a.customer_name, a.plan, a.progress, a.problem, a.requisition, "x" 
  from daily_plan_details a,daily_progress_setup d where a.particular=d.id and  a.d_id='.$d_id; 
$data2=db_query($sql2);
while($info=mysqli_fetch_object($data2)){ 
$pi++;
$sl=$pi;
$qty=$info->qty;
$unit_name=$info->unit_name;
$rate=$info->rate;
$disc=$info->disc;
?>
	<tr>
        <td valign="top" align="center"><?=$sl?></td>
        <td align="left" valign="top" style="padding:5px;"><?=$info->particular?></td>
        <td valign="top" style="padding:5px;"><?=$info->customer_name?></td>
        <td align="center" valign="top"><?=$info->amount?></td>
        <td align="left" valign="top"><?=$info->plan?></td>
        <td align="Center" valign="top"><?=$info->progress?></td>
        <td align="left" valign="top"><?=$info->problem?></td>
		<td align="left" valign="top"><?=$info->requisition?></td>
     </tr>
<? 
$total_req_amt += $info->amount;
}?>

	<tr>
      <td colspan="3">Total</td>
	  <td align="center"><?=number_format($total_req_amt,2) ?></td>
	  <td></td>
	  <td></td>
	  <td></td>
	  <td></td>
    </tr>

</tbody>
    </table>
<? } elseif($progress_for=='3'){ ?>
<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0">
	<thead>
       <tr>
        <td width="4%" align="center"><strong>SL</strong></td>
        <td width="11%" align="center"  ><strong>Particulars</strong></td>
		<td width="20%" align="center"  ><strong>Plan</strong></td>
		<td width="11%" align="center"  ><strong>Amount</strong></td>
		<td width="20%" align="center"  ><strong>Progress</strong></td>
		<td width="15%" align="center"  ><strong>Problem</strong></td>
      </tr>
	</thead>
	  <tbody>
	  <?php
$final_amt=0;
$pi=0;
$total=0;
 $sql2='select a.id, d.particulars as particular,  a.amount, a.plan, a.progress, a.problem, "x" 
  from daily_plan_details a,daily_progress_setup d where a.particular=d.id and  a.d_id='.$d_id;  
$data2=db_query($sql2);
while($info=mysqli_fetch_object($data2)){ 
$pi++;
$sl=$pi;
$qty=$info->qty;
$unit_name=$info->unit_name;
$rate=$info->rate;
$disc=$info->disc;
?>
	<tr>
        <td valign="top" align="center"><?=$sl?></td>
        <td align="left" valign="top" style="padding:5px;"><?=$info->particular?></td>
		<td align="center" valign="top"><?=$info->plan?></td>
        <td valign="top" style="padding:5px; text-align:center"><?=$info->amount?></td>
        
        <td align="left" valign="top"><?=$info->progress?></td>
        <td align="Center" valign="top"><?=$info->problem?></td>
     </tr>
<? 
$total_req_amt += $info->amount;
}?>

	<tr>
      <td colspan="3">Total</td>
	  <td align="center"><?=number_format($total_req_amt,2) ?></td>
	  <td></td>
	  <td></td>
    </tr>

<tbody>
    </table>
	
	
<? }elseif($progress_for=='4'){ ?>

<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0">
	<thead>
       <tr>
        <td width="4%" align="center"><strong>SL</strong></td>
        <td width="11%" align="center" ><strong>Date</strong></td>
		<td width="20%" align="center"><strong>Customer Name</strong></td>
		<td width="11%" align="center"><strong>Amount</strong></td>
		<td width="20%" align="center"><strong>Problem</strong></td>
      </tr>
	</thead>
	  <?php
$final_amt=0;
$pi=0;
$total=0;
 $sql2='select a.id, a.date, a.customer_name, a.amount, a.problem
 from daily_plan_details a where  a.d_id='.$d_id;
$data2=db_query($sql2);
while($info=mysqli_fetch_object($data2)){ 
$pi++;
$sl=$pi;
$qty=$info->qty;
$unit_name=$info->unit_name;
$rate=$info->rate;
$disc=$info->disc;
?>
	<tr>
        <td valign="top" align="center"><?=$sl?></td>
        <td align="left" valign="top" style="padding:5px;"><?=$info->date?></td>
        <td valign="top" style="padding:5px;"><?=$info->customer_name?></td>
        <td align="center" valign="top"><?=$info->amount?></td>
        <td align="left" valign="top"><?=$info->problem?></td>
     </tr>
<? }?>
    </table>
	
	
	<? } elseif($progress_for=='55'){ ?>

<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0">
	<thead>
       <tr>
        <td width="4%" align="center"><strong>SL</strong></td>
		<td width="11%" align="center"><strong>Section</strong></td>
		<td width="20%" align="center"><strong>Action Plan</strong></td>
		<td width="20%" align="center"><strong>Challenges</strong></td>
		<td width="11%" align="center"><strong>Amount/Qty</strong></td>
		<td width="20%" align="center"><strong>Progress</strong></td>
		<td width="11%" align="center"><strong>Follow up</strong></td>
      </tr>
	</thead>
	  <?php
$final_amt=0;
$pi=0;
$total=0;
 $sql2='select a.id, a.customer_name as section, a.plan as action_plan, a.man_power as challenges,a.collection as qty, a.progress, a.gap_analysis as follow_up,  "x" from daily_plan_details a where  a.d_id='.$d_id;
$data2=db_query($sql2);
while($info=mysqli_fetch_object($data2)){ 
$pi++;
$sl=$pi;
$qty=$info->qty;
$unit_name=$info->unit_name;
$rate=$info->rate;
$disc=$info->disc;
?>
	<tr>
        <td valign="top" align="center"><?=$sl?></td>
        <td align="center" valign="top"><?=$info->section?></td>
        <td align="left" valign="top"><?=$info->action_plan?></td>
        <td align="Center" valign="top"><?=$info->challenges?></td>
		<td align="Center" valign="top"><?=$info->qty?></td>
        <td align="left" valign="top"><?=$info->progress?></td>
		 <td align="left" valign="top"><?=$info->follow_up?></td>
     </tr>
<? }?>
    </table>
	
	
	<? } elseif($progress_for=='35'){ ?>
<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0">
	<thead>
       <tr>
        <td width="4%" align="center"><strong>SL</strong></td>
        <td width="11%" align="center"  ><strong>Particulars</strong></td>
		<td width="11%" align="center"  ><strong>Action Plan</strong></td>
		<td width="11%" align="center"  ><strong>Amount</strong></td>
		<td width="11%" align="center"  ><strong>Follow Up</strong></td>
      </tr>
	</thead>
	  <?php
$final_amt=0;
$pi=0;
$total=0;
 $sql2='select a.id, a.particular,  a.head_office, a.showroom, a.ld_hospital, "x" 
  from daily_plan_details a where  a.d_id='.$d_id;  
$data2=db_query($sql2);
while($info=mysqli_fetch_object($data2)){ 
$pi++;
$sl=$pi;
$qty=$info->qty;
$unit_name=$info->unit_name;
$rate=$info->rate;
$disc=$info->disc;
?>
	<tr>
        <td valign="top" align="center"><?=$sl?></td>
        <td align="left" valign="top" style="padding:5px;"><?=$info->particular?></td>
        <td valign="top" style="padding:5px;"><?=$info->head_office?></td>
        <td align="center" valign="top"><?=$info->showroom?></td>
        <td align="center" valign="top"><?=$info->ld_hospital?></td>
     </tr>
<? }?>
    </table>
	
	
	<? }elseif($progress_for=='54'){ ?>
<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0">
	<thead>
       <tr>
        <td width="4%" align="center"><strong>SL</strong></td>
        <td width="11%" align="center"  ><strong>Particulars</strong></td>
		<td width="11%" align="center"  ><strong>Action Plan</strong></td>
		<td width="11%" align="center"  ><strong>Amount</strong></td>
		<td width="11%" align="center"  ><strong>Follow Up</strong></td>
      </tr>
	</thead>
	  <?php
$final_amt=0;
$pi=0;
$total=0;
 $sql2='select a.id, a.particular,  a.head_office, a.showroom, a.ld_hospital, "x" 
  from daily_plan_details a where  a.d_id='.$d_id;  
$data2=db_query($sql2);
while($info=mysqli_fetch_object($data2)){ 
$pi++;
$sl=$pi;
$qty=$info->qty;
$unit_name=$info->unit_name;
$rate=$info->rate;
$disc=$info->disc;
?>
	<tr>
        <td valign="top" align="center"><?=$sl?></td>
        <td align="left" valign="top" style="padding:5px;"><?=$info->particular?></td>
        <td valign="top" style="padding:5px;"><?=$info->head_office?></td>
        <td align="center" valign="top"><?=$info->showroom?></td>
        <td align="center" valign="top"><?=$info->ld_hospital?></td>
     </tr>
<? }?>
    </table>
	
	
	<? } elseif($progress_for=='51'){ ?>

<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0">
	<thead>
       <tr>
        <td width="4%" align="center"><strong>SL No</strong></td>
		<td width="4%" align="center"><strong>Project</strong></td>
        <td width="15%" align="center"><strong>Section</strong></td>
		<td width="20%" align="center"><strong>Action Plan</strong></td>
		<td width="11%" align="center"><strong>Amount/Qty</strong></td>
		<td width="11%" align="center"><strong>Challenges</strong></td>
		<td width="11%" align="center"><strong>Departmental Step</strong></td>
		<td width="20%" align="center"><strong>Progress</strong></td>
		<td width="15%" align="center"><strong>Recommendation</strong></td>
		<td width="15%" align="center"><strong>Suggestion</strong></td>
		<td width="15%" align="center"><strong>Time Line</strong></td>
      </tr>
	</thead>
	  <?php
$final_amt=0;
$pi=0;
$total=0;
 $sql2='select a.id, a.address as project, a.customer_name as section, a.plan as action_plan, a.man_power as challenges, a.service_type as departmental_step,a.collection as qty, a.progress, a.gap_analysis as recommendation, a.findings as suggestion, a.next_visit as time_line, "x" from daily_plan_details a where  a.d_id='.$d_id;
$data2=db_query($sql2);
while($info=mysqli_fetch_object($data2)){ 
$pi++;
$sl=$pi;
$qty=$info->qty;
$unit_name=$info->unit_name;
$rate=$info->rate;
$disc=$info->disc;
?>
	<tr>
        <td valign="top" align="center"><?=$sl?></td>
		<td align="center" valign="top"><?=$info->project?></td>
        <td align="center" valign="top"><?=$info->section?></td>
        <td align="left" valign="top"><?=$info->action_plan?></td>
		<td align="Center" valign="top"><?=$info->qty?></td>
        <td align="Center" valign="top"><?=$info->challenges?></td>
		<td align="left" valign="top"><?=$info->departmental_step?></td>
        <td align="left" valign="top"><?=$info->progress?></td>
		 <td align="left" valign="top"><?=$info->recommendation?></td>
		 <td align="left" valign="top"><?=$info->suggestion?></td>
		 <td align="left" valign="top"><?=$info->time_line?></td>
     </tr>
<? }?>
    </table>
	
	
	<? } elseif($progress_for=='5'){ ?>
<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0">
       <tr>
        <td width="4%" align="center"><strong>SL</strong></td>
        <td width="11%" align="center"  ><strong>Particulars</strong></td>
		<td width="11%" align="center"  ><strong>Customers</strong></td>
		<td width="11%" align="center"  ><strong>Project Name</strong></td>
		<td width="11%" align="center"  ><strong>Man power</strong></td>
		<td width="11%" align="center"  ><strong>Target</strong></td>
		<td width="11%" align="center"  ><strong>Plan</strong></td>
		<td width="20%" align="center"  ><strong>Progress</strong></td>
		<td width="20%" align="center"  ><strong>Problem</strong></td>
		<td width="20%" align="center"  ><strong>Requisition</strong></td>
      </tr>
	  <?php
$final_amt=0;
$pi=0;
$total=0;
 
  $sql2='select a.id, d.particulars as particular, a.man_power, a.customer_name, a.target, a.project_name, a.plan, a.progress, a.problem, a.requisition, "x" 
  from daily_plan_details a,daily_progress_setup d where a.particular=d.id and  a.d_id='.$d_id;
$data2=db_query($sql2);
while($info=mysqli_fetch_object($data2)){ 
$pi++;
$sl=$pi;
$qty=$info->qty;
$unit_name=$info->unit_name;
$rate=$info->rate;
$disc=$info->disc;
?>
	<tr>
        <td valign="top" align="center"><?=$sl?></td>
        <td align="left" valign="top" style="padding:5px;"><?=$info->particular?></td>
        <td valign="top" style="padding:5px;"><?=$info->customer_name?></td>
        <td align="left" valign="top"><?=$info->project_name?></td>
		<td align="center" valign="top"><?=$info->man_power?></td>
		<td align="center" valign="top"><?=$info->target?></td>
        <td align="left" valign="top"><?=$info->plan?></td>
        <td align="left" valign="top"><?=$info->progress?></td>
		<td align="left" valign="top"><?=$info->problem?></td>
		<td align="left" valign="top"><?=$info->requisition?></td>
     </tr>
<? }?>
    </table>
<? } ?>

<table width="100%" border="0" bordercolor="#FFFFFF" cellpadding="0" cellspacing="0" style="border:0px;border-color:#FFF; position:absolute; bottom:0%" >
<tr>
  <td style="border:0px;border-color:#FFF;">&nbsp;</td>
  <td style="border:0px;border-color:#FFF;">&nbsp;</td>
  <td style="border:0px;border-color:#FFF;">&nbsp;</td>
  <td style="border:0px;border-color:#FFF;">&nbsp;</td>
</tr>
<tr>
  <td style="border:0px;border-color:#FFF;">&nbsp;</td>
  <td style="border:0px;border-color:#FFF;">&nbsp;</td>
  <td style="border:0px;border-color:#FFF;">&nbsp;</td>
  <td style="border:0px;border-color:#FFF;">&nbsp;</td>
</tr>
<tr>
  <td style="border:0px;border-color:#FFF;">&nbsp;</td>
  <td style="border:0px;border-color:#FFF;">&nbsp;</td>
  <td style="border:0px;border-color:#FFF;">&nbsp;</td>
  <td style="border:0px;border-color:#FFF;">&nbsp;</td>
</tr>
<tr>
  <td style="border:0px;border-color:#FFF;">&nbsp;</td>
  <td style="border:0px;border-color:#FFF;">&nbsp;</td>
  <td style="border:0px;border-color:#FFF;">&nbsp;</td>
  <td style="border:0px;border-color:#FFF;">&nbsp;</td>
</tr>

<? if($progress_for=="31"){?>
<tr>
<td width="25%" align="center" style="border:0px;border-color:#FFF;"><strong><u>Prepared by</u></strong></td>
<td width="25%" align="center" style="border:0px;border-color:#FFF;"><strong><u>Veried By</u></strong></td>
<td width="25%" align="center" style="border:0px;border-color:#FFF;"><strong><u>Checked By</u></strong></td>
<td width="25%" align="center" style="border:0px;border-color:#FFF;"><strong><u>Approved by</u></strong></td>
<? } ?> 
</tr>

<? if($progress_for=="31"){?>
<tr>
  <td align="center" style="border:0px;border-color:#FFF;"><strong>Manager, Marketing & Sales</strong></td>
  <td align="center" style="border:0px;border-color:#FFF;"><strong>AGM, Marketing &  Sales</strong></td>
  <td align="center" style="border:0px;border-color:#FFF;"><strong>PS to MD</strong></td>
  <td align="center" style="border:0px;border-color:#FFF;"><strong>Director, Marketing & Sales</strong></td>
  <? } ?> 
</tr>

<? if($progress_for=="1"){?>
<tr>
<td width="33%" align="center" style="border:0px;border-color:#FFF;"><strong><u>Prepared by</u></strong></td>
<td width="33%" align="center" style="border:0px;border-color:#FFF;"><strong><u>Checked By</u></strong></td>
<td width="33%" align="center" style="border:0px;border-color:#FFF;"><strong><u>Approved by</u></strong></td>
<? } ?> 
</tr>

<? if($progress_for=="1"){?>
<tr>
  <td align="center" style="border:0px;border-color:#FFF;"><strong>Executive, MIS</strong></td>
  <td align="center" style="border:0px;border-color:#FFF;"><strong>AGM, Admin</strong></td>
  <td align="center" style="border:0px;border-color:#FFF;"><strong>Head of Accounts & Finance</strong></td>
  <? } ?> 
</tr>


<? if($progress_for=="35"){?>
<tr>
<td width="50%" align="center" style="border:0px;border-color:#FFF;"><strong><u>Prepared by</u></strong></td>
<td width="50%" align="center" style="border:0px;border-color:#FFF;"><strong><u>Approved by</u></strong></td>
<? } ?> 
</tr>

<? if($progress_for=="35"){?>
<tr>
  <td align="center" style="border:0px;border-color:#FFF;"><strong>AGM, BDM & HRM</strong></td>
  <td align="center" style="border:0px;border-color:#FFF;"><strong>GM, Administration</strong></td>
  <? } ?> 
</tr>

<? if($progress_for=="54"){?>
<tr>
<td width="50%" align="center" style="border:0px;border-color:#FFF;"><strong><u>Prepared by</u></strong></td>
<td width="50%" align="center" style="border:0px;border-color:#FFF;"><strong><u>Approved by</u></strong></td>
<? } ?> 
</tr>

<? if($progress_for=="54"){?>
<tr>
  <td align="center" style="border:0px;border-color:#FFF;"><strong>AGM, BDM & HRM</strong></td>
  <td align="center" style="border:0px;border-color:#FFF;"><strong>GM, Administration</strong></td>
  <? } ?> 
</tr>

</table>



</form>
</div>


</body>



</html>



