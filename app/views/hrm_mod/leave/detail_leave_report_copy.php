<?
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$head = '<link href="../css/report_selection.css" type="text/css" rel="stylesheet"/>';

//__________________________  Fractional Calculate method Function ______________
function roundToQuarter($number)
{
  $integerPart = floor($number);
  $fractionalPart = $number - $integerPart;

  if ($fractionalPart >= 0.0 && $fractionalPart <= 0.24) {
    $roundedFractionalPart = 0.0;
  } elseif ($fractionalPart >= 0.25 && $fractionalPart <= 0.49) {
    $roundedFractionalPart = 0.25;
  } elseif ($fractionalPart >= 0.5 && $fractionalPart <= 0.74) {
    $roundedFractionalPart = 0.5;
  } elseif ($fractionalPart >= 0.75 && $fractionalPart <= 0.99) {
    $roundedFractionalPart = 0.75;
  } else {
    // Handle invalid input or out-of-range fractional parts here
    return false;
  }

  return $integerPart + $roundedFractionalPart;
}

//__________________________ END  Fractional Calculate method Function ______________




$leave_id = $_REQUEST['PBI_ID'];


if($leave_id>0)
{

$g_s_date=date('Y-01-01');
$g_e_date=date('Y-12-31');


$hrm_leave_info=find_all_field('hrm_leave_info','','PBI_ID='.$leave_id);

//$leave_rule = find_all_field('hrm_leave_rull_manage','','1');

$leave_rule_check = find_all_field('hrm_leave_rull_manage_individual', '', 'PBI_ID="'.$leave_id.'"');
if($leave_rule_check->PBI_ID>0){
    
$leave_rule = find_all_field('hrm_leave_rull_manage_individual', '', 'PBI_ID="'.$leave_id.'"');    
    
}else{

$leave_rule = find_all_field('hrm_leave_rull_manage', '', '1');    
}



$leave_days_casual=find_a_field('hrm_leave_info','sum(total_days)','type=1 and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"  and PBI_ID='.$hrm_leave_info->PBI_ID);

$leave_days_sick=find_a_field('hrm_leave_info','sum(total_days)','type=2 and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"  and PBI_ID='.$hrm_leave_info->PBI_ID);

$leave_days_annual=find_a_field('hrm_leave_info','sum(total_days)','type=3 and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"  and PBI_ID='.$hrm_leave_info->PBI_ID);

$leave_days_compensatory=find_a_field('hrm_leave_info','sum(total_days)','type=10 and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"  and PBI_ID='.$hrm_leave_info->PBI_ID);

$leave_days_lwp=find_a_field('hrm_leave_info','sum(total_days)','type=9 and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"  and PBI_ID='.$hrm_leave_info->PBI_ID);

$leave_days_Hajj = find_a_field('hrm_leave_info', 'sum(total_days)', 'type=7 and leave_status="GRANTED" and s_date>="' . $g_s_date . '" 
 and e_date<="' . $g_e_date . '"   and PBI_ID=' . $hrm_leave_info->PBI_ID);
 
$leave_days_maternity = find_a_field('hrm_leave_info', 'sum(total_days)', 'type=5 and leave_status="GRANTED" and 
 s_date>="' . $g_s_date . '" and e_date<="' . $g_e_date . '"   and PBI_ID=' . $hrm_leave_info->PBI_ID);
 
$leave_days_EOL = find_a_field('hrm_leave_info', 'sum(total_days)', 'type=8 and leave_status="GRANTED" and s_date>="' . $g_s_date . '" 
 and e_date<="' . $g_e_date . '"   and PBI_ID=' . $hrm_leave_info->PBI_ID);
 

$personnel_basic_info=find_all_field('personnel_basic_info','','PBI_ID='.$hrm_leave_info->PBI_ID);

$designation=find_all_field('designation','','DESG_ID='.$personnel_basic_info->DESG_ID);


$hrm_leave_rull_manage=find_all_field('hrm_leave_rull_manage','','id='.$personnel_basic_info->LEAVE_RULE_ID);

$group = find_all_field('user_group','','id="'.$_SESSION['user']['group'].'"');


    //___________ !!!!!!!!  __  Fractional LEAVE BALANACE ____________!!!!!!!!!!!!!!!!!!!!!!!!!!
      $joiningdate = find_a_field('personnel_basic_info', 'PBI_DOJ', 'PBI_ID=' . $personnel_basic_info->PBI_ID);
      $year_e_datee = date('Y-12-31');
	  $g_e_datee = date('Y-m-d');
      $start = strtotime($joiningdate);
      $end = strtotime($g_e_datee);
      $days_between = ceil(abs($start - $end) / 86400);
	  
	  $current_y_end = strtotime($year_e_datee);
      $days_between_current_year = ceil(abs($start - $current_y_end) / 86400);

	  
	 $Check_joinDate = date('Y-m-d', strtotime($joiningdate . ' + ' . (date('Y', strtotime($g_e_datee)) - date('Y', strtotime($joiningdate))) . ' years'));
     $annual_leave_status_opening = find_a_field('annual_leave_balance', 'BALANCE', 'PBI_ID="' .$personnel_basic_info->PBI_ID. '"');
     $annual_leave_status_earn = find_a_field('hrm_att_summary', 'sum(annual_leave)', 'emp_id="' .$personnel_basic_info->PBI_ID. '" and 
	 att_date BETWEEN  "' . $g_s_date . '" and "' . $g_e_date . '" ');
		  
		if (strtotime($Check_joinDate) < strtotime($g_e_datee)) {
	      	 $final_annual_status_earn = ($annual_leave_status_earn / 18);
		 
		}else{
		 	 $final_annual_status_earn = 0;
		     }
		

		 $total_al_allocated = ($annual_leave_status_opening+$final_annual_status_earn);
		

	  
	   $joiningYear = date('Y', strtotime($joiningdate));
	   $currentYear = date('Y');
	   
	   
	   if ($joiningYear < $currentYear && $days_between >= 365) {
	   
        $total_casual = $leave_rule->CL;
        $total_MED = $leave_rule->MED;
        $total_ML = $leave_rule->ML;
		$total_ANU = $total_al_allocated;
		$total_HL = $leave_rule->HL;
	    $total_MTR = $leave_rule->MTR;
		
	   }elseif($joiningYear < $currentYear && $days_between < 365){
	   
	   $total_casual = $leave_rule->CL;
       $total_MED = $leave_rule->MED;
       $total_ML = $leave_rule->ML;
       $total_HL = $leave_rule->HL;
	   $total_MTR = $leave_rule->MTR;
	  // $total_ANU = $annual_leave->BALANCE+$final_annual_earnn; //roundToQuarter($annual_leave / 18);
	   
      } else {

        $total_casual =  roundToQuarter($leave_rule->CL / 360 * $days_between_current_year);
        $total_MED =  roundToQuarter($leave_rule->MED / 360 * $days_between_current_year);
        $total_ANU =  0; //roundToQuarter($annual_leave / 18);
        $total_ML = roundToQuarter($leave_rule->ML / 360 * $days_between_current_year);
      }






}




?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">



<html xmlns="http://www.w3.org/1999/xhtml">
<head>


<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Details Staff Report</title>

<script>
 	function printPage(){
		document.getElementById('print').style.display='none';
		window.print();
	}
</script>


<style type="text/css">
body { font-family:Tahoma, Geneva, sans-serif;
font-size:12px; }
table{ border:solid; border:#99C; padding:0px; font-size:11px; margin-bottom:5px;}
td{
text-align:center;
}



.style4 {font-size: 14px}



.style9 {color: #FFFFFF}



.style10 {font-size: 14px; color: #FFFFFF; }



.style14 {font-size: 16px; font-weight: bold; }



.style16 {font-size: 12}

td{
font-size:13px;
font-family:Arial, Helvetica, sans-serif;
    line-height: 2;

}
.new-table{
    padding-bottom: 15px;
}
.new-table td{
    line-height:0;
}
.new-css{
     text-align: left; 
     font-weight: 600;
}

.bold{
    font-weight:600;
}

@page {
 margin: 10mm 15mm 10mm 20mm;
}

.tr .td{
    border-style: dashed;
}


</style>


</head>


<body>




<table style="width:900px; margin:0px auto;" border="0" cellpadding="0" cellspacing="0" class="new-table">
    <tr>
        <td width="12%"><img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$_SESSION['proj_id']?>.png" style=" width: 100%;" class="logo-img"/></td>
        <td width="76%">
            
            <h2 style="line-height:20px;"><?=find_a_field('user_group','group_name','id='.$personnel_basic_info->PBI_ORG);?></h2>
            <p style=" line-height: 5px; font-size: 19px !important;"><b><u>Leave Report Summary for the year of 2023</u><b></p>
        </td>
        <td width="12%">&nbsp;</td>
    </tr>
    
  <tr>
    <td></td>
  </tr>
  <tr>
    <td></td>
  </tr>
</table>

<table  border="0" cellpadding="0" cellspacing="0" style="width:900px; margin:0px auto;">
  <tr>
    <td width="70%"><table style="width:100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="20%" class="new-css">Employee ID</td>
	<td>:</td>
    <td class="new-css">  <?php if(!empty($personnel_basic_info->PBI_CODE)) {echo $personnel_basic_info->PBI_CODE;} else{echo "N/A";}?></td>
	
  </tr>
  <tr>
    <td  class="new-css">Name </td>
	<td>:</td>
    <td class="new-css"> <?php if(!empty($personnel_basic_info->PBI_NAME)) {echo $personnel_basic_info->PBI_NAME;} else{echo "N/A";}?></td>
  </tr>

  
  <tr>
    <td class="new-css">Designation</td>
	<td>:</td>
    <td class="new-css"><?php if(!empty($designation->DESG_DESC)) {echo $designation->DESG_DESC;} else{echo "N/A";}?></td>
  </tr>
  
  
   <?php /*?><tr>
    <td class="new-css">Cost Center</td>
	<td>:</td>
    <td class="new-css"><?=find_a_field('hrm_cost_center','center_name','id='.$personnel_basic_info->cost_center);?></td>
  </tr><?php */?>
  
   <tr>
    <td class="new-css">Department</td>
	<td>:</td>
    <td class="new-css"><?=find_a_field('department','DEPT_DESC','DEPT_ID='.$personnel_basic_info->DEPT_ID); if(!empty($personnel_basic_info->DEPT_ID)) {echo $personnel_basic_info->DEPT_ID;} else{echo "N/A";}?></td>
  </tr>
  
    <!--<tr>
    <td class="new-css">Section</td>
	<td>:</td>
    <td class="new-css"><?=find_a_field('PBI_Section','sec_name','sec_id="'.$personnel_basic_info->section.'"');?></td>
  </tr>-->
  
  <tr>
    <td class="new-css"> DOJ </td>
	<td>:</td>
    <td class="new-css"> <?=date('d-M-Y',strtotime($personnel_basic_info->PBI_DOJ))?></td>
  </tr>
</table>
</td>
    <td width="30%"><table style="width:100%; float:right" border="1" cellpadding="0" cellspacing="0">
  <tr class="bold">
    <td>&nbsp;</td>
    <td colspan="3">Day(s)</td>
    <!--<td colspan="3">Hours</td>-->
    </tr>
  <tr class="bold">
    <td>Leave Type </td>
    <td>Allocated</td>
    <td>Availed</td>
    <td>Balance</td>
    <!--<td>Allocated</td>-->
    <!--<td>Availed</td>-->
    <!--<td>Balance</td>-->
  </tr>
  <tr>
    <td class="bold">Casual</td>
    <td><?=$leave_rule->CL;?></td>
    <td><?=$leave_days_casual?></td>
    <td><?=$leave_rule->CL-$leave_days_casual?></td>
    <!--<td>&nbsp;</td>-->
    <!--<td>&nbsp;</td>-->
    <!--<td>&nbsp;</td>-->
  </tr>
  <tr>
    <td class="bold">Sick</td>
    <td><?=$leave_rule->MED;?></td>
    <td><?=$leave_days_sick?></td>
    <td><?=$leave_rule->MED-$leave_days_sick?></td>
    <!--<td>&nbsp;</td>-->
    <!--<td>&nbsp;</td>-->
    <!--<td>&nbsp;</td>-->
  </tr>
  <tr>
    <td class="bold">Annual</td>
    <td><?=number_format($total_ANU,2);?></td>
    <td><?=number_format($leave_days_annual,2);?></td>
    <td><?=number_format($total_ANU-$leave_days_annual,2);?></td>
    <!--<td>&nbsp;</td>-->
    <!--<td>&nbsp;</td>-->
    <!--<td>&nbsp;</td>-->
  </tr>
  
   <tr>
    <td class="bold">LWP</td>
    <td></td>
    <td><?=$leave_days_lwp?></td>
    <td></td>
    <!--<td>&nbsp;</td>-->
    <!--<td>&nbsp;</td>-->
    <!--<td>&nbsp;</td>-->
  </tr> 
  
  
        
  
  
            <? if($leave_rule_check->PBI_ID>0){ ?>
			 <tr>
              <td class="bold">HL</td>
              <td><?=$total_HL;?></td>
              <td><?= $leave_days_Hajj ?></td>
              <td><?=number_format($total_HL - $leave_days_Hajj, 2);?></td>
            </tr>
			<?  } ?>
			
			<? if($leave_days_EOL>0){ ?>
			 <tr>
              <td class="bold">PL</td>
              <td></td>
              <td><?= $leave_days_EOL;?></td>
              <td></td>
            </tr>
			<?  } ?>
			
			<? if($total_MTR>0){ ?>
			 <tr>
              <td class="bold">ML</td>
              <td><?=$total_MTR?></td>
              <td><?=$leave_days_maternity?></td>
              <td><?=number_format($total_MTR - $leave_days_maternity, 2);?></td>
            </tr>
			 <?  } ?> 
			 
  
  
</table>
</td>
  </tr>
</table>

<div class="print" style="width:900px; margin:0px auto;">
	
	
	<button id="print" onclick="printPage()">Print</button>
</div>
<br />
<table style="width:900px; margin:0px auto;" border="1" cellpadding="0" cellspacing="0" class="table-table">
  <tr class="bold">
    <td>SL</td>
    <td>Type of Leave</td>
    <td>From Date</td>
    <td>To Date</td>
    <td>Day(s)</td>
    <td>Period</td>
    <td style="width: 40%;">Reason</td>
  </tr>
  <?
  $s=1;
  	 $res = "select o.*, a.PBI_ID, a.PBI_NAME from personnel_basic_info a, hrm_leave_info o where  a.PBI_ID=o.PBI_ID and leave_status='GRANTED' 

 and s_date>='".$g_s_date."' and e_date<='".$g_e_date."'  and o.PBI_ID='".$hrm_leave_info->PBI_ID."' order by s_date desc ";

	$sqll=db_query($res);
	while ($data=mysqli_fetch_object($sqll)){
  ?>
  
  <tr class="tr">
    <td class="td"><?=$s++?></td>
    <td class="td"><?=find_a_field('hrm_leave_type','leave_short_name','id='.$data->type);?></td>
    <td class="td"><? //=$data->s_date?> <?=date('d-M-Y',strtotime($data->s_date))?>  </td>
    <td class="td"><? //=date('d-M-Y',strtotime($row->e_date))?> <?=date('d-M-Y',strtotime($data->e_date))?> </td>
    <td class="td"><?=$data->total_days?></td>
    <td class="td"><?
		
				if($data->half_or_full=='Full'){
				echo 'Full';
				}elseif($data->half_or_full== 'Early Half'){
				echo '1st Half';
				}elseif($data->half_or_full=='Last Half'){
				 echo '2nd Half';
				}elseif($data->half_or_full=='first_qtr'){
				  echo '1st Qtr';
				}elseif($data->half_or_full=='second_qtr'){
				  echo '2nd Qtr';
				}elseif($data->half_or_full=='third_qtr'){
				  echo '3rd Qtr';
				}else{
				  echo '4th Qtr';
				}
	?></td>
    <td class="td"><?=$data->reason?></td>
  </tr>
  
  <? } ?>
</table>



  



  



  



</body>



</html>