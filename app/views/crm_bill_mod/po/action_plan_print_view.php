<?php



session_start();



require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

require_once "../../../assets/support/class.numbertoword.php";
//require "../../../engine/tools/class.numbertoword.php";

$d_id		= $_REQUEST['d_id'];

$sql1="select * from daily_action_plan_master where d_id='$d_id'";
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
<title>.: Action Plan :.</title>
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
<form action="" method="post">
<table width="1000" border="0" cellspacing="0" cellpadding="0" align="center">
<tr style="width:20%">
			<td align="left">Head Office:<br/ >34, Topkhana Road, Dhaka-1000<br/ >Factory:<br/ >103/1, Promixco Industrial Park<br/ >Mouchak, Kaliakair, Gazipur-1750, Bangladesh</td>
			
		</tr>
		<tr style="width:20%" align="center">
			<td align="center">Action Plan</td>
		</tr>
		<tr style="width:20%" align="center">
			<td align="center"><?=$dept?></td>
		</tr>
		
		<tr style="width:20%" align="center">
			<td align="center"><?=date('M-Y');?></td>
		</tr>
		
		<tr style="width:20%" align="right">
			<td align="right"><?=date('d-m-y')?></td>
		</tr>
  <tr>
    <td><div class="line">
      <div align="center"><span class="style4"></span><br />
      </div>
    </div></td>
  </tr>

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
       <tr>
        <td width="4%" align="center"><strong>SL</strong></td>
        <td width="15%" align="center" ><strong>Date</strong></td>
		<td width="11%" align="center" ><strong>Day</strong></td>
		<td width="10%" align="center"><strong>Name</strong></td>
		<td width="11%" align="center" ><strong>Section</strong></td>
		<td width="11%" align="center"><strong>Action Plan</strong></td>
		<td width="11%" align="center" ><strong>Target Amount</strong></td>
		<td width="15%" align="center" ><strong>Challenges</strong></td>
		<td width="11%" align="center" ><strong>Progress</strong></td>
		<td width="11%" align="center" ><strong>Follow Up</strong></td>
      </tr>
	  <?php
$final_amt=0;
$pi=0;
$total=0;
 $sql2='select a.id, a.date, a.day, a.customer_name as name, a.address as section, a.pet_type as action_plan, a.delivery as target_amount, a.gap_analysis as challenges, a.collection as progress, a.man_power as follow_up, "x" from daily_progress_details a where  a.d_id='.$d_id;
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
        <td valign="top" style="padding:5px;"><?=$info->day?></td>
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
       <tr>
        <td width="4%" align="center"><strong>SL</strong></td>
        <td width="10%" align="center" ><strong>Date</strong></td>
		<td width="11%" align="center" ><strong>Day</strong></td>
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
	  <?php
$final_amt=0;
$pi=0;
$total=0;
 $sql2='select a.id, a.date, a.day, a.customer_name as section, a.plan as action_plan, a.man_power as challenges, a.service_type as departmental_step,a.collection as qty, a.progress, a.gap_analysis as recommendation, a.findings as suggestion, a.next_visit as time_line, "x" from daily_action_plan_details a where  a.d_id='.$d_id;
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
        <td valign="top" style="padding:5px;"><?=$info->day?></td>
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
       <tr>
        <td width="4%" align="center"><strong>SL No</strong></td>
		<td width="4%" align="center"><strong>Project</strong></td>
        <td width="15%" align="center"><strong>Section</strong></td>
		<td width="20%" align="center"><strong>Action Plan</strong></td>
		<td width="11%" align="center"><strong>Challenges</strong></td>
		<td width="11%" align="center"><strong>Departmental Step</strong></td>
		<td width="20%" align="center"><strong>Progress</strong></td>
		<td width="15%" align="center"><strong>Recommendation</strong></td>
		<td width="15%" align="center"><strong>Suggestion</strong></td>
		<td width="15%" align="center"><strong>Time Line</strong></td>
      </tr>
	  <?php
$final_amt=0;
$pi=0;
$total=0;
 $sql2='select a.id, a.address as project, a.customer_name as section, a.plan as action_plan, a.man_power as challenges, a.service_type as departmental_step, a.progress, a.gap_analysis as recommendation, a.findings as suggestion, a.next_visit as time_line, "x" from daily_action_plan_details a where  a.d_id='.$d_id;
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
        <td align="Center" valign="top"><?=$info->challenges?></td>
		<td align="left" valign="top"><?=$info->departmental_step?></td>
        <td align="left" valign="top"><?=$info->progress?></td>
		 <td align="left" valign="top"><?=$info->recommendation?></td>
		 <td align="left" valign="top"><?=$info->suggestion?></td>
		 <td align="left" valign="top"><?=$info->time_line?></td>
     </tr>
<? }?>
    </table>
	
	
	<? }
	
	
	elseif($progress_for=='52'){ ?>

<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0">
       <tr>
        <td width="4%" align="center"><strong>SL</strong></td>
        <td width="10%" align="center" ><strong>Date</strong></td>
		<td width="15%" align="center"><strong>Customer Name</strong></td>
		<td width="20%" align="center"><strong>Lot No</strong></td>
		<td width="11%" align="center"><strong>Product Name</strong></td>
		<td width="20%" align="center"><strong>Unit Price</strong></td>
		<td width="15%" align="center"><strong>Production Target</strong></td>
		<td width="11%" align="center" ><strong>Production Achieved</strong></td>
		<td width="11%" align="center" ><strong>Delivery Target</strong></td>
		<td width="11%" align="center" ><strong>Delivery Achieved</strong></td>
      </tr>
	  <?php
$final_amt=0;
$pi=0;
$total=0;
 $sql2='select a.id, a.date, a.customer_name, a.man_power, a.plan, a.amount, a.collection, a.outstanding, a.category, a.pet_type, "x" from daily_progress_details a where  a.d_id='.$d_id;
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
        <td align="center" valign="top"><?=$info->customer_name?></td>
        <td align="Center" valign="top"><?=$info->man_power?></td>
        <td align="left" valign="top"><?=$info->plan?></td>
        <td align="left" valign="top"><?=$info->amount?></td>
		 <td align="left" valign="top"><?=$info->collection?></td>
		 <td align="left" valign="top"><?=$info->outstanding?></td>
		 <td align="left" valign="top"><?=$info->category?></td>
		 <td align="left" valign="top"><?=$info->pet_type?></td>
     </tr>
<? }?>
    </table>
	


<? }elseif($progress_for=='32'){ ?>

<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0">
       <tr>
        <td width="4%" align="center"><strong>SL</strong></td>
        <td width="11%" align="center" ><strong>Owner</strong></td>
		<td width="16%" align="center" ><strong>Address</strong></td>
		<td width="8%" align="center"><strong>Pet Name</strong></td>
		<td width="11%" align="center" ><strong>Pet Type</strong></td>
		<td width="11%" align="center"><strong>Patient Category</strong></td>
		<td width="9%" align="center" ><strong>Service type</strong></td>
		<td width="11%" align="center" ><strong>Mobile</strong></td>
		<td width="11%" align="center" ><strong>Email</strong></td>
		<td width="11%" align="center" ><strong>Next Visit</strong></td>
		<td width="11%" align="center" ><strong>Total</strong></td>
		<td width="11%" align="center" ><strong>Remarks</strong></td>
      </tr>
	  <?php
$final_amt=0;
$pi=0;
$total=0;
 $sql2='select a.id, a.customer_name,a.address,a.man_power ,a.pet_type,a.pet_category,a.service_type,a.mobile,a.email,a.next_visit,a.amount,a.findings from daily_progress_details a where  a.d_id='.$d_id;
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
       <tr>
        <td width="4%" align="center"><strong>SL</strong></td>
        <td width="11%" align="center" ><strong>Particulars</strong></td>
		<td width="11%" align="center" ><strong>Customer Name</strong></td>
		<td width="11%" align="center" ><strong>Amount</strong></td>
		<td width="20%" align="center" ><strong>Plan</strong></td>
		<td width="11%" align="center" ><strong>Progress</strong></td>
		<td width="15%" align="center"><strong>Problem</strong></td>
		<td width="15%" align="center"><strong>Requisition</strong></td>
      </tr>
	  <?php
$final_amt=0;
$pi=0;
$total=0;
 $sql2='select a.id, d.category, a.particular, a.amount, a.customer_name, a.plan, a.progress, a.problem, a.requisition, "x" 
  from daily_progress_details a,daily_progress_setup d where a.particular=d.id and  a.d_id='.$d_id; 
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
<? }?>
    </table>
<? } elseif($progress_for=='3'){ ?>
<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0">
       <tr>
        <td width="4%" align="center"><strong>SL</strong></td>
        <td width="11%" align="center"  ><strong>Particulars</strong></td>
		<td width="20%" align="center"  ><strong>Plan</strong></td>
		<td width="11%" align="center"  ><strong>Amount</strong></td>
		<td width="20%" align="center"  ><strong>Progress</strong></td>
		<td width="15%" align="center"  ><strong>Problem</strong></td>
      </tr>
	  <?php
$final_amt=0;
$pi=0;
$total=0;
 $sql2='select a.id, d.particulars as particular,  a.amount, a.plan, a.progress, a.problem, "x" 
  from daily_progress_details a,daily_progress_setup d where a.particular=d.id and  a.d_id='.$d_id;  
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
        <td valign="top" style="padding:5px; text-align:right"><?=$info->amount?></td>
        
        <td align="left" valign="top"><?=$info->progress?></td>
        <td align="Center" valign="top"><?=$info->problem?></td>
     </tr>
<? }?>
    </table>
	
	
<? }elseif($progress_for=='4'){ ?>

<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0">
       <tr>
        <td width="4%" align="center"><strong>SL</strong></td>
        <td width="11%" align="center" ><strong>Date</strong></td>
		<td width="20%" align="center"><strong>Customer Name</strong></td>
		<td width="11%" align="center"><strong>Amount</strong></td>
		<td width="20%" align="center"><strong>Problem</strong></td>
      </tr>
	  <?php
$final_amt=0;
$pi=0;
$total=0;
 $sql2='select a.id, a.date, a.customer_name, a.amount, a.problem
 from daily_progress_details a where  a.d_id='.$d_id;
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
       <tr>
        <td width="4%" align="center"><strong>SL</strong></td>
        <td width="10%" align="center" ><strong>Date</strong></td>
		<td width="11%" align="center" ><strong>Day</strong></td>
		<td width="15%" align="center"><strong>Section</strong></td>
		<td width="20%" align="center"><strong>Action Plan</strong></td>
		<td width="11%" align="center"><strong>Challenges</strong></td>
		<td width="11%" align="center"><strong>Amount/Qty</strong></td>
		<td width="20%" align="center"><strong>Progress</strong></td>
		<td width="15%" align="center"><strong>Follow up</strong></td>
      </tr>
	  <?php
$final_amt=0;
$pi=0;
$total=0;
 $sql2='select a.id, a.date, a.day, a.customer_name as section, a.plan as action_plan, a.man_power as challenges,a.collection as qty, a.progress, a.gap_analysis as follow_up,  "x" from daily_progress_details a where  a.d_id='.$d_id;
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
        <td valign="top" style="padding:5px;"><?=$info->day?></td>
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
       <tr>
        <td width="4%" align="center"><strong>SL</strong></td>
        <td width="11%" align="center"  ><strong>Particulars</strong></td>
		<td width="11%" align="center"  ><strong>H/O</strong></td>
		<td width="11%" align="center"  ><strong>Showroom</strong></td>
		<td width="11%" align="center"  ><strong>LD Hospital</strong></td>
		<td width="11%" align="center"  ><strong>Factory</strong></td>
      </tr>
	  <?php
$final_amt=0;
$pi=0;
$total=0;
 $sql2='select a.id, d.particulars as particular,  a.head_office, a.showroom, a.ld_hospital, a.factory, "x" 
  from daily_progress_details a,daily_progress_setup d where a.particular=d.id and  a.d_id='.$d_id;  
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
        <td align="Center" valign="top"><?=$info->factory?></td>
     </tr>
<? }?>
    </table>
	
	
	<? } elseif($progress_for=='51'){ ?>
<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0">
       <tr>
        <td width="4%" align="center"><strong>SL</strong></td>
        <td width="11%" align="center"  ><strong>Date</strong></td>
		<td width="11%" align="center"  ><strong>Time</strong></td>
		<td width="20%" align="center"  ><strong>Address</strong></td>
		<td width="25%" align="center"  ><strong>Work Details</strong></td>
		<td width="20%" align="center"  ><strong>Progress</strong></td>
		<td width="20%" align="center"  ><strong>Problem</strong></td>
      </tr>
	  <?php
$final_amt=0;
$pi=0;
$total=0;
 $sql2='select a.id,  a.date, a.day, a.customer_name, a.plan,a.progress,a.gap_analysis, "x" 
  from daily_progress_details a where  a.d_id='.$d_id;  
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
        <td valign="top" style="padding:5px;"><?=$info->day?></td>
        <td align="left" valign="top"><?=$info->customer_name?></td>
        <td align="left" valign="top"><?=$info->plan?></td>
        <td align="left" valign="top"><?=$info->progress?></td>
		<td align="left" valign="top"><?=$info->gap_analysis?></td>
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
  from daily_progress_details a,daily_progress_setup d where a.particular=d.id and  a.d_id='.$d_id;
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
      <table width="100%" border="0" bordercolor="#000000" cellspacing="3" cellpadding="3" class="tabledesign1" style="width:1000px">
        <tr>
          <td width="49" align="right">&nbsp;</td>
        </tr>
        <tr>
          <td align="right">&nbsp;</td>
        </tr>
        <tr>

          <td align="right">&nbsp;</td>
        </tr>

        <tr>

       

          <td align="left" style="font-size:14px">



            <table width="100%" border="0" cellspacing="0" cellpadding="0" style="position:absolute; bottom:0%">
			
			<? if($progress_for=="53"){?>
              <tr>
			  <!--<td align="center"><?=find_a_field('user_activity_management','fname','user_id='.$data->entry_by);?><br />
			  .........................</td>-->
			  <td align="center">Prepared by<br />
			  .........................</td>
			  <td align="center">Checked By<br />
			  .........................</td>
			  <td align="center">Approved by<br />
			  .............................</td>
			   <!--<td align="center">.........................</td>
			  <td align="center"><?=find_a_field('user_activity_management','fname','user_id='.$data->approve_by);?><br />
			  ..............................</td>
			  <td align="center">.............................</td>-->
			  <? } ?> 
			  </tr>
				<? if($progress_for=="53"){?>
				 <tr>
			  <td align="center">Manager, Engineering & Construction</td>
			  <td align="center">GM, Administration</td>
			  <td align="center"></td>
				<? } ?> 
			  </tr>


              <!--<tr>
			  <td align="center"><?=find_a_field('user_activity_management','fname','user_id='.$data->entry_by);?><br />
			  .........................</td>
			  <td align="center">.........................</td>
			  <td align="center"><?=find_a_field('user_activity_management','fname','user_id='.$data->approve_by);?><br />
			  ..............................</td>
			 <td align="center">.............................</td>
			  </tr>
			  <tr>
			  <td align="center">Prepared By </td>
			 <td align="center">Checked By <br /> Head of Department</td>
			  <td align="center">Approved By </td>
			 <td align="center">Director Marketing</td>
			  </tr>-->
            </table></td>
        </tr>



        <tr>



          <td align="left" style="font-size:10px"><p><br />

          <em>



              <b>              </b>            </em>
            </p>            </td>
        </tr>
      </table></td>
  </tr>
</table>



</form>



</body>



</html>



