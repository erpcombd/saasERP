<?php
session_start();
//
require "../../config/inc.all.php";

$_POST['mon'] = 8;
$_POST['year'] = 2020;

?>
 <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
 <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
 <script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
 <script type="text/javascript">
 	
 	$(document).ready(function() {
    $('#example').DataTable();
} );
 </script>
  <table width="100%" cellspacing="0" cellpadding="2" border="0">

    <thead>

      <tr>

        <td style="border:0px;" colspan="6" align="left"><img src="../../img/company_logo.png" style="height:100px; width:65px;"  /></td>

        <td style="border:0px;" colspan="30" align="center"><?=$str?></td>

      </tr>
  </thead>
</table>
<table id="example" width="100%" cellspacing="0" cellpadding="2" border="0">

    <thead>

      <tr>

        <th rowspan="3">S/L</th>

        <th rowspan="3"><div align="center">ID</div></th>

        <th rowspan="3"><div align="center">Name</div></th>

        <th rowspan="3"><div align="center">Designation</div></th>

        <th rowspan="3" nowrap="nowrap"><div align="center">

          Joining Date </th>

        <th colspan="13" align="center"><div align="center">Attendance</div></th>

        <th colspan="5"><div align="center">Salary and Allowance </div></th>

        <th colspan="5"><div align="center">Extra Allowance </div></th>

        <th rowspan="3"><div align="center">Total Allowances</div></th>

        <th rowspan="3"><div align="center">OT. Hrs.</div></th>

        <th rowspan="3"><div align="center">OT. Amt. </div></th>

        <th rowspan="3"><div align="center">Salary Adjustment</div></th>

        <th colspan="9" align="center"><div align="center">Deduction</div></th>

        <th rowspan="3"><div align="center">Total Deduction </div></th>

        <th rowspan="3" align="center"><div align="center">Net Salary </div></th>

        <th rowspan="3" align="center"><div align="center">Net Payable Salary </div></th>

        <th rowspan="3"><div align="center">Bank A/C</div></th>

        <th rowspan="3"><div align="center">Payroll Card No</div></th>

        <th rowspan="3"><div align="center">Remarks</div></th>

      </tr>

      <tr>

        <th colspan="9"><div align="center">No of Leave's </div></th>

        <th rowspan="2"><div align="center">LP</div></th>

        <th rowspan="2"><div align="center">LWP</div></th>

        <th rowspan="2"><div align="center">AB</div></th>

        <th rowspan="2"><div align="center">Total Days Works </div></th>

        <th><div align="center">Gross </div></th>

        <th><div align="center">Basic</div></th>

        <th><div align="center">House Rent </div></th>

        <th><div align="center">Medical</div></th>

        <th><div align="center">Conveyance</div></th>

        <th rowspan="2"><div align="center">Food</div></th>

        <th rowspan="2"><div align="center">Transport</div></th>

        <th rowspan="2"><div align="center">Offday</div></th>

        <th rowspan="2"><div align="center">Site visit</div></th>

        <th rowspan="2"><div align="center">Others</div></th>

        <th rowspan="2"><div align="center">Mobile</div></th>

        <th rowspan="2"><div align="center">Tax</div></th>

        <th rowspan="2"><div align="center">Food </div></th>

        <th rowspan="2"><div align="center">Loan /Advance</div></th>

        <th rowspan="2"><div align="center">Absent</div></th>

        <th rowspan="2"><div align="center">LWP</div></th>

        <th rowspan="2"><div align="center">Late</div></th>

        <th rowspan="2"><div align="center">HR Action</div></th>

        <th rowspan="2"><div align="center">Others</div></th>

      </tr>

      <tr>

        <th>CL</th>

        <th>SL</th>

        <th>AL</th>

        <th>SHL</th>

        <th>ML</th>

        <th>PL</th>

        <th>EOL</th>

        <th>HL</th>

        <th>MLV</th>

        <th><div align="center">100%</div></th>

        <th><div align="center">50%</div></th>

        <th><div align="center">25%</div></th>

        <th><div align="center">15%</div></th>

        <th><div align="center">10%</div></th>

      </tr>

    </thead>

    <tbody>

      <?


$found = find_a_field('salary_attendence','lock_status','mon="'.$_POST['mon'].'" and year="'.$_POST['year'].'"');


  if($found==0){

  if($_POST['PBI_ORG']!='')

	$salaryCon =' and a.PBI_ORG = "'.$_POST['PBI_ORG'].'"';


if ($_POST['JOB_LOCATION'] !='')

	$salaryCon .= ' and t.job_location='.$_POST['JOB_LOCATION'];


if ($_POST['department'] !='')


	$salaryCon .= ' and t.department='.$_POST['department'];


if ($_POST['job_status'] !='')

$salaryCon .=' and a.PBI_JOB_STATUS="'.$_POST['job_status'].'"'; 


    $sqld = 'select t.*, a.PBI_ID, a.PBI_NAME, a.PBI_DOJ, d.DESG_SHORT_NAME as Designation from salary_attendence t,designation d, personnel_basic_info a  where t.designation = d.DESG_ID and t.pay>0 and t.remarks_details!="hold" and  t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' and t.PBI_ID=a.PBI_ID '.$salaryCon.' order by (t.total_payable) desc';


}else{

 if($_POST['PBI_ORG']!='')


	$salaryConn =' and a.PBI_ORG = "'.$_POST['PBI_ORG'].'"';


if ($_POST['JOB_LOCATION'] !='')

	$salaryConn .= ' and t.job_location='.$_POST['JOB_LOCATION'];


if ($_POST['department'] !='')

	$salaryConn .= ' and t.department='.$_POST['department'];


            $m_s_date = $_POST['year'].'-'.$_POST['mon'].'-'.'01';


	   $m_e_date = $_POST['year'].'-'.$_POST['mon'].'-'.'31';


   $sqld = 'select t.*, a.PBI_ID, a.PBI_NAME, a.PBI_DOJ, d.DESG_SHORT_NAME as Designation from salary_attendence_lock t,designation d, personnel_basic_info a where t.designation = d.DESG_ID and t.pay>0 and t.remarks_details!="hold" and  t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' and t.PBI_ID=a.PBI_ID '.$salaryConn.' order by (t.total_payable) desc';




$queryd=db_query($sqld);



while($data = mysqli_fetch_object($queryd)){



$m_s_date = $_POST['year'].'-'.$_POST['mon'].'-'.'01';



$m_e_date = $_POST['year'].'-'.$_POST['mon'].'-'.'31';


$entry_by=$data->entry_by;


  //$slq = 'select sum(total_days) from hrm_leave_info where PBI_ID="'.$data->PBI_ID.'" and type=1 and s_date>="'.$m_s_date.'" and e_date<="'.$m_e_date.'" and  leave_status="GRANTED"';



  $tot_ded = $data->other_deduction+$data->other_deductions;


?>

     <tr>

        <td><?=++$s?></td>

        <td><?=$data->PBI_ID?></td>

        <td nowrap="nowrap"><?=$data->PBI_NAME?></td>

        <td nowrap="nowrap"><?=$data->Designation?></td>

        <td><?=date('d-M-Y',strtotime($data->PBI_DOJ))?></td>

        <td><?  $dd = 'select s_date,e_date from hrm_leave_info where s_date>="'.$m_s_date.'" and PBI_ID="'.$data->PBI_ID.'" and leave_status="GRANTED" and type in (1)';




				$dumping = db_query($dd);



				$day_count = '';




				$last_date = $_POST['year'].'-'.$_POST['mon'].'-'.'31';



				while($leave_d = mysqli_fetch_object($dumping)){



				 $d = date_parse_from_format("Y-m-d", $leave_d->e_date);



                  $next_m =  $d["month"];


				   if($_POST['mon']<$next_m){




				   $e_date = $last_date;



				   }else{



				   $e_date = $leave_d->e_date;


				   }


				$s_date = $leave_d->s_date;


				$e_date = date('Y-m-d H:i:s', strtotime($e_date . ' +1 day'));


		 $begin = new DateTime($s_date);


        $end = new DateTime($e_date);


      $interval = DateInterval::createFromDateString('1 day');


      $period = new DatePeriod($begin, $interval, $end);


    foreach ($period as $dt) {

     $dt->format("l Y-m-d H:i:s\n");


    $today = $dt->format("Y-m-d");


    if($dt->format("l")!='Friday')


    {


       $found = 0;


       $found = find_a_field('salary_holy_day','1',' holy_day="'.$today.'" ');


       if($found==0)


       $day_count++;


       }


}


}


  echo $day_count;


?>

        </td>

        <td><?  $dd = 'select s_date,e_date from hrm_leave_info where s_date>="'.$m_s_date.'" and PBI_ID="'.$data->PBI_ID.'" and leave_status="GRANTED" and type in (2)';


				$dumping = db_query($dd);


				$day_count = '';


				$last_date = $_POST['year'].'-'.$_POST['mon'].'-'.'31';


				while($leave_d = mysqli_fetch_object($dumping)){


				 $d = date_parse_from_format("Y-m-d", $leave_d->e_date);


                  $next_m =  $d["month"];



				   if($_POST['mon']<$next_m){

				   $e_date = $last_date;


				   }else{


				   $e_date = $leave_d->e_date;


				   }


				$s_date = $leave_d->s_date;


				$e_date = date('Y-m-d H:i:s', strtotime($e_date . ' +1 day'));


		 $begin = new DateTime($s_date);

        $end = new DateTime($e_date);

      $interval = DateInterval::createFromDateString('1 day');



      $period = new DatePeriod($begin, $interval, $end);


    foreach ($period as $dt) {


     $dt->format("l Y-m-d H:i:s\n");


    $today = $dt->format("Y-m-d");


    if($dt->format("l")!='Friday')


    {

       $found = 0;


       $found = find_a_field('salary_holy_day','1',' holy_day="'.$today.'" ');


       if($found==0)


       $day_count++;

       }


}


}

  echo $day_count;


?></td>

        <td><?  $dd = 'select s_date,e_date from hrm_leave_info where s_date>="'.$m_s_date.'" and PBI_ID="'.$data->PBI_ID.'" and leave_status="GRANTED" and type in (3)';


				$dumping = db_query($dd);


				$day_count = '';


				$last_date = $_POST['year'].'-'.$_POST['mon'].'-'.'31';


				while($leave_d = mysqli_fetch_object($dumping)){


				 $d = date_parse_from_format("Y-m-d", $leave_d->e_date);

                  $next_m =  $d["month"];


				   if($_POST['mon']<$next_m){


				   $e_date = $last_date;


				   }else{

				   $e_date = $leave_d->e_date;


				   }


				$s_date = $leave_d->s_date;


				$e_date = date('Y-m-d H:i:s', strtotime($e_date . ' +1 day'));

		 $begin = new DateTime($s_date);

        $end = new DateTime($e_date);


      $interval = DateInterval::createFromDateString('1 day');

      $period = new DatePeriod($begin, $interval, $end);


    foreach ($period as $dt) {

     $dt->format("l Y-m-d H:i:s\n");

    $today = $dt->format("Y-m-d");


    if($dt->format("l")!='Friday')


    {


       $found = 0;

       $found = find_a_field('salary_holy_day','1',' holy_day="'.$today.'" ');

       if($found==0)


       $day_count++;


       }

}

}

  echo $day_count;


?></td>

        <td><?=find_a_field('hrm_leave_info','sum(total_days)','PBI_ID='.$data->PBI_ID.' and type="Short Leave (SHL)" and leave_status="GRANTED" and mon='.$_POST['mon'].' and year='.$_POST['year'].'') ?></td>

        <td><?=find_a_field('hrm_leave_info','sum(total_days)','PBI_ID='.$data->PBI_ID.' and type=4 and s_date>="'.$m_s_date.'" and e_date<="'.$m_e_date.'" and  leave_status="GRANTED" ')?></td>

        <td><?=find_a_field('hrm_leave_info','sum(total_days)','PBI_ID='.$data->PBI_ID.' and type=6 and s_date>="'.$m_s_date.'" and e_date<="'.$m_e_date.'" and  leave_status="GRANTED" ')?></td>

        <td><?=find_a_field('hrm_leave_info','sum(total_days)','PBI_ID='.$data->PBI_ID.' and type=8 and s_date>="'.$m_s_date.'" and e_date<="'.$m_e_date.'" and  leave_status="GRANTED" ')?></td>

        <td><?=find_a_field('hrm_leave_info','sum(total_days)','PBI_ID='.$data->PBI_ID.' and type=7 and s_date>="'.$m_s_date.'" and e_date<="'.$m_e_date.'" and  leave_status="GRANTED" ')?></td>

        <td><?=find_a_field('hrm_leave_info','sum(total_days)','PBI_ID='.$data->PBI_ID.' and type=5 and s_date>="'.$m_s_date.'" and e_date<="'.$m_e_date.'" and  leave_status="GRANTED" ')?></td>

        <td align="center"><?=($data->lt>0)? $data->lt : '';?></td>

        <td align="center"><?=($data->lwp>0)? $data->lwp : '';?></td>

        <td align="center"><?=($data->ab>0)? $data->ab : '';?></td>

        <td align="center"><?=($data->pay>0)? $data->pay : '';?></td>

        <td align="right"><?=($data->gross_salary>0)? $data->gross_salary : '';               $totGross += $data->gross_salary?></td>

        <td align="right"><?=($data->basic_salary>0)? $data->basic_salary : '';               $totBasic += $data->basic_salary?></td>

        <td align="right"><?=($data->house_rent>0)? $data->house_rent : '';                   $totHouse += $data->house_rent?></td>

        <td align="right"><?=($data->medical_allowance>0)? $data->medical_allowance : '';     $totMedical += $data->medical_allowance?></td>

        <td align="right"><?=($data->special_allowance>0)? $data->special_allowance : '';     $totspecial += $data->special_allowance?></td>

        <td align="right"><?=($data->food_allowance>0)? $data->food_allowance : '';           $totFood += $data->food_allowance?></td>

        <td align="right"><?=($data->transport_allowance>0)? $data->transport_allowance :''; $totTransport += $data->transport_allowance?></td>

        <td align="right"><?=($data->offday_allowance>0)? $data->offday_allowance :''; $totOffday += $data->offday_allowance?></td>

        <td align="right"><?=($data->sitevisit_allowance>0)? $data->sitevisit_allowance :''; $totSitevisit += $data->sitevisit_allowance?></td>

        <td align="right"><?=($data->other_allowance>0)? $data->other_allowance :'';        $totOther += $data->other_allowance?></td>

        <td align="right"><? if($data->offday_allowance+$data->sitevisit_allowance+$data->food_allowance+$data->transport_allowance+$data->other_allowance>0){echo $data->offday_allowance+$data->sitevisit_allowance+$data->food_allowance+$data->transport_allowance+$data->other_allowance;


	 $totAllowance +=$data->offday_allowance+$data->sitevisit_allowance+$data->food_allowance+$data->transport_allowance+$data->other_allowance;


	}


	?></td>

        <td align="right"><?=($data->over_time_hour>0)? $data->over_time_hour : '';           $totOverTimeHr += $data->over_time_hour?></td>

        <td align="right"><?=($data->over_time_amount>0)? $data->over_time_amount : '';       $totOverTimeAmt += $data->over_time_amount?></td>

        <td align="right"><?=($data->adjustment_amount>0)? number_format($data->adjustment_amount,0) : '';       $totAdjustmentAmt += $data->adjustment_amount?></td>

        <td align="right"><?=($data->mobile_deduction>0)? $data->mobile_deduction : '';       $totMobileDeduct += $data->mobile_deduction?></td>

        <td align="right"><?=($data->income_tax>0)? $data->income_tax : '';                   $totIincomeTax += $data->income_tax?></td>

        <td align="right"><?=($data->food_deduction>0)? $data->food_deduction : '';           $totFoodDeduct += $data->food_deduction?></td>

        <td align="right"><?=($data->advance_install>0)? $data->advance_install : '';         $totAdvInstall += $data->advance_install?></td>

        <td align="right"><?=($data->absent_deduction>0)? $data->absent_deduction : '';       $totAbsentDeduct += $data->absent_deduction?></td>

        <td align="right"><?=($data->lwp_deduction>0)? $data->lwp_deduction : '';             $totLwpDeduct += $data->lwp_deduction?></td>

        <td align="right"><?=($data->late_deduction>0)? $data->late_deduction : '';           $totLateDeduct += $data->late_deduction?></td>

         <td align="right"><?=($data->hr_action_amt>0)? $data->hr_action_amt : '';           $totHrAcDeduct += $data->hr_action_amt?></td>

        <td align="right"><?=($tot_ded>0)? $tot_ded : '';       $totOtherDeduct += $tot_ded?></td>

        <td align="right"><?=($data->total_deduction>0)? $data->total_deduction : '';         $totTotalDeduct += $data->total_deduction?></td>

        <td align="right"><? echo ($data->total_earning>0)? $data->total_earning : '';        $total_cash_earning = $total_cash_earning + $data->total_earning;?></td>

        <td align="right"><? echo ($data->total_payable>0)? $data->total_payable : '';        $total_cash = $total_cash + $data->total_payable;?></td>

        <td><?=($data->cash>0)? $data->cash : '';?></td>

        <td><?=($data->card_no>0)? $data->card_no : '';?></td>

        <?




 $hr_action_remarks = find_a_field('admin_action_detail','ADMIN_ACTION_SUBJECT','EFFECT_MON="'.$_POST['mon'].'" and EFFECT_YEAR="'.$_POST['year'].'" and PBI_ID="'.$data->PBI_ID.'" ');


 ?>

        <? if($data->remarks_details!=''){ ?>
         <td nowrap="nowrap" style="width:150px;"><?=$data->remarks_details?></td>
       

        <? } else{?>

        <td nowrap="nowrap" style="width:150px;"><?=$hr_action_remarks?></td>

        <? } ?>

      </tr>

      <?

}


?>

      <!--<tr>

        <td colspan="18" align="right" style="font-weight:bold;">Total:</td>

        <td align="right"><strong>

          <?=($totGross>0)? number_format($totGross,0) : '';?>

          </strong></td>

        <td align="right"><strong>

          <?=($totBasic>0)? number_format($totBasic,0) : '';?>

          </strong></td>

        <td align="right"><strong>

          <?=($totHouse>0)? number_format($totHouse,0) : '';?>

          </strong></td>

        <td align="right"><strong>

          <?=($totMedical>0)? number_format($totMedical,0) : '';?>

          </strong></td>

        <td align="right"><strong>

          <?=($totspecial>0)? number_format($totspecial,0) : '';?>

          </strong></td>

        <td align="right"><strong>

          <?=($totFood>0)? number_format($totFood,0) : '';?>

          </strong></td>

        <td align="right"><strong>

          <?=($totTransport>0)? number_format($totTransport,0) : '';?>

          </strong></td>

        <td align="right"><strong>

          <?=($totOffday>0)? number_format($totOffday,0) : '';?>

          </strong></td>

        <td align="right"><strong>

          <?=($totSitevisit>0)? number_format($totSitevisit,0) : '';?>

          </strong></td>

        <td align="right"><strong>

          <?=($totOther>0)? number_format($totOther,0) : '';?>

          </strong></td>

        <td align="right"><strong>

          <?=($totAllowance>0)? number_format($totAllowance,0) : '';?>

          </strong></td>

        <td align="right"><strong>

          <?=($totOverTimeHr>0)? number_format($totOverTimeHr,0) : '';?>

          </strong></td>

        <td align="right"><strong>

          <?=($totOverTimeAmt>0)? number_format($totOverTimeAmt,0) : '';?>

          </strong></td>

          <td align="right"><strong>

          <?=($totAdjustmentAmt>0)? number_format($totAdjustmentAmt,0) : '';?>

          </strong></td>

        <td align="right"><strong>

          <?=($totMobileDeduct>0)? number_format($totMobileDeduct,0) : '';?>

          </strong></td>

        <td align="right"><strong>

          <?=($totIincomeTax>0)? number_format($totIincomeTax,0) : '';?>

          </strong></td>

        <td align="right"><strong>

          <?=($totFoodDeduct>0)? number_format($totFoodDeduct,0) : '';?>

          </strong></td>

        <td align="right"><strong>

          <?=($totAdvInstall>0)? number_format($totAdvInstall,0) : '';?>

          </strong></td>

        <td align="right"><strong>

          <?=($totAbsentDeduct>0)? number_format($totAbsentDeduct,0) : '';?>

          </strong></td>

        <td align="right"><strong>

          <?=($totLwpDeduct>0)? number_format($totLwpDeduct,0) : '';?>

          </strong></td>

        <td align="right"><strong>

          <?=($totLateDeduct>0)? number_format($totLateDeduct,0) : '';?>

          </strong></td>

          <td align="right"><strong>

          <?=($totHrAcDeduct>0)? number_format($totHrAcDeduct,0) : '';?>

          </strong></td>

        <td align="right"><strong>

          <?=($totOtherDeduct>0)? number_format($totOtherDeduct,0) : '';?>

          </strong></td>

        <td align="right"><strong>

          <?=($totTotalDeduct>0)? number_format($totTotalDeduct,0) : '';?>

          </strong></td>

        <td align="right"><strong>

          <?=($total_cash_earning>0)? number_format($total_cash_earning,0) : '';?>

          </strong></td>

        <td align="right"><strong>

          <?=($total_cash>0)? number_format($total_cash,0) : '';?>

          </strong></td>

        <td>&nbsp;</td>

        <td>&nbsp;</td>

        <td>&nbsp;</td>

      </tr>-->

    </tbody>

  </table>

  In Words:

  <?
//echo convertNumberMhafuz($total_cash);


?>

  <br>

  <br>

  <br>

  <div style="width:100%; margin:60px auto">

    <div style="float:left; width:20%; text-align:center">-------------------<br>

      Prepared By</div>

    <div style="float:left; width:20%; text-align:center">-------------------<br>

      Audit</div>

    <div style="float:left; width:20%; text-align:center">-------------------<br>

      Accounts</div>

    <div style="float:left; width:20%; text-align:center">-------------------<br>

      Managing Director</div>

    <div style="float:left; width:20%; text-align:center">-------------------<br>

      Chairman</div>

  </div>

  <?































}
?>