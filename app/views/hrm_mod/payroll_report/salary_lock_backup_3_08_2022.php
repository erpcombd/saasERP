<?php

session_start();

//



require "../../config/inc.all.php";



//ini_set('display_errors', 1);

//ini_set('display_startup_errors', 1);

//error_reporting(E_ALL);

$head='<link href="../css/report_selection.css" type="text/css" rel="stylesheet"/>';

do_calander('#ijdb');

do_calander('#ijda');

do_calander('#ppjdb');

do_calander('#cut_off_date');

if($_POST['mon']!=''){

$mon=$_POST['mon'];}

else{

$mon=date('n');

}



if($_POST['year']!=''){

$year=$_POST['year'];}

else{

$year=date('Y');

}







$sqll = 'select * from salary_attendence s,personnel_basic_info p where s.mon="'.$_POST['mon'].'" and s.year="'.$_POST['year'].'"  and p.PBI_ID=s.PBI_ID and p.PBI_JOB_STATUS="In Service"';

$querr = db_query($sqll);







if(isset($_REQUEST['lock'])){

   

   while($data=mysqli_fetch_object($querr)){

   

   

   

   

   $insert = 'INSERT INTO `salary_attendence_lock`( `mon`, `year`, `bonus`, `PBI_ID`, `designation`, `department`, `job_location`, `mtd`, `td`, `od`, `hd`, `lt`, `ab`, `lwp`, `oDuty`, `lv`, `pre`, `pay`, `ot`, `deduction`, `benefits`, `gross_salary`, `basic_salary`, `house_rent`, `medical_allowance`, `other_allowance`, `special_allowance`, `mobile_allowance`, `food_allowance`, `transport_allowance`,`offday_allowance`,`sitevisit_allowance`, `other_benefits`, `bonus_amt`, `income_tax`, `over_time_hour`, `over_time_amount`, `adjustment_amount`, `absent_deduction`,`joining_deduction`, `late_deduction`, `lwp_deduction`, `food_deduction`, `mobile_bill_limit`, `mobile_bill_amt`, `mobile_deduction`, `other_deduction`, `advance_install`, `other_install`, `other_deductions`, `total_salary`, `total_benefits`, `total_deduction`,`cash_amt`,`bank_amt`, `total_payable`, `cash`, `card_no`, `bank_or_cash`, `status`, `remarks_details`, `entry_by`, `entry_at`, `edit_by`, `edit_at`,`total_earning`,`hr_action_amt`,`total_earning_cash`) VALUES ("'.$_POST['mon'].'" ,"'.$_POST['year'].'","'.$data->bonus.'","'.$data->PBI_ID.'","'.$data->designation.'","'.$data->department.'","'.$data->job_location.'","'.$data->mtd.'","'.$data->td.'","'.$data->od.'","'.$data->hd.'","'.$data->lt.'","'.$data->ab.'","'.$data->lwp.'","'.$data->oDuty.'","'.$data->lv.'","'.$data->pre.'","'.$data->pay.'","'.$data->ot.'","'.$data->deduction.'","'.$data->benefits.'","'.$data->gross_salary.'","'.$data->basic_salary.'","'.$data->house_rent.'","'.$data->medical_allowance.'","'.$data->other_allowance.'","'.$data->special_allowance.'","'.$data->mobile_allowance.'","'.$data->food_allowance.'","'.$data->transport_allowance.'","'.$data->offday_allowance.'","'.$data->sitevisit_allowance.'","'.$data->other_benefits.'","'.$data->bonus_amt.'","'.$data->income_tax.'","'.$data->over_time_hour.'","'.$data->over_time_amount.'","'.$data->adjustment_amount.'","'.$data->absent_deduction.'","'.$data->joining_deduction.'","'.$data->late_deduction.'","'.$data->lwp_deduction.'","'.$data->food_deduction.'","'.$data->mobile_bill_limit.'","'.$data->mobile_bill_amt.'","'.$data->mobile_deduction.'","'.$data->other_deduction.'","'.$data->advance_install.'","'.$data->other_install.'","'.$data->other_deductions.'","'.$data->total_salary.'","'.$data->total_benefits.'","'.$data->total_deduction.'","'.$data->cash_amt.'","'.$data->bank_amt.'","'.$data->total_payable.'","'.$data->cash.'","'.$data->card_no.'","'.$data->bank_or_cash.'","'.$data->status.'","'.$data->remarks_details.'","'.$data->entry_by.'","'.$data->entry_at.'","'.$data->edit_by.'","'.$data->edit_at.'","'.$data->total_earning.'","'.$data->hr_action_amt.'",
"'.$data->total_earning_cash.'")';

   

   $row = db_query($insert);

   

   

   

    $update = 'update salary_attendence set lock_status=1 where mon="'.$_POST['mon'].'" and year="'.$_POST['year'].'" and PBI_ID="'.$data->PBI_ID.'"';

   $upqr = db_query($update);

   

   

   }

   

   /* $select = 'select job_location,sum(total_deduction) as total_ded,sum(total_payable) as total_pay from salary_attendence where mon="'.$_POST['mon'].'" and year="'.$_POST['year'].'" group by job_location';

   $qrr = db_query($select); 

   

   while($dataa=mysqli_fetch_object($qrr)){

  

  $updatee = 'update salary_journal set total_deduction="'.$dataa->total_ded.'",total_payable="'.$dataa->total_pay.'",cheked_by="'.$_SESSION['user']['id'].'" where mon="'.$_POST['mon'].'" and year="'.$_POST['year'].'" and project="'.$dataa->job_location.'"';

   $upqre = db_query($updatee);

  

   }

   

    $selectt = 'select department,sum(total_deduction) as total_ded,sum(total_payable) as total_pay from salary_attendence where mon="'.$_POST['mon'].'" and year="'.$_POST['year'].'" group by department';

   $qrrr = db_query($selectt); 

   

   while($dataa1=mysqli_fetch_object($qrrr)){

  

  //$updatee1 = 'update salary_journal set total_deduction="'.$dataa1->total_ded.'",total_payable="'.$dataa1->total_pay.'",cheked_by="'.$_SESSION['user']['id'].'" where mon="'.$_POST['mon'].'" and year="'.$_POST['year'].'" and department="'.$dataa1->department.'"';

   //$upqre = db_query($updatee1);

  

   }*/

   

   

   //project brief salary to secondary journal

   $sss = 'select proj.PROJECT_DESC,proj.account_ledger,proj.cc_code,a.job_location,sum(a.gross_salary+a.food_allowance+a.transport_allowance+a.other_allowance+a.adjustment_amount+a.offday_allowance+a.sitevisit_allowance) as total_pay,
   sum(a.absent_deduction+a.joining_deduction+a.late_deduction+a.lwp_deduction+a.hr_action_amt+a.other_deduction+a.other_deductions) as total_deduction,
   sum(a.income_tax+a.food_deduction+a.mobile_deduction) as credit_total_deduction from salary_attendence a, personnel_basic_info b, project proj where a.PBI_ID = b.PBI_ID and mon='.$_POST['mon'].' and year='.$_POST['year'].' and b.PBI_JOB_STATUS="In Service"  and  a.job_location = proj.PROJECT_ID and a.pay>0 GROUP BY proj.PROJECT_ID';

		$query12 = db_query($sss);

		



		

   $date = $_POST['year'].'-'.$_POST['mon'].'-'.'30';

  

   $jv_date = strtotime($date);

   $narration_dr = 'Salary expense for the month of ' .$_POST['mon']. ' and year of ' .$_POST['year'];

   $narration_cr = 'Salary Payable for the month of ' .$_POST['mon']. ' and year of ' .$_POST['year'];

   $tr_from = 'Payroll';

   $tr_no = date('Ym'.'01');

   $jv_no = next_journal_sec_voucher_id();

   $jv_no1 = next_journal_voucher_id();

   

	$ledger_id_cr = 2063000200000000;

   while($dataaa = mysqli_fetch_object($query12)){

   

   $total_payable = $dataaa->total_pay-$dataaa->total_deduction;
   $total_payable_credit = $dataaa->total_pay-$dataaa->total_deduction-$dataaa->credit_total_deduction;

   

   $ledger_id_dr = $dataaa->account_ledger;
   $proj_cc_code_dr = $dataaa->cc_code;

   $total_amt = $total_amt+ $total_payable_credit;

   

   $insert = 'INSERT INTO `salary_journal`(`department`, `project`, `mon`, `year`, `total_salary`, `total_deduction`, `total_payable`, `entry_at`, `entry_by`, `checked_at`, `cheked_by`) VALUES ("","'.$dataaa->job_location.'","'.$_POST['mon'].'","'.$_POST['year'].'","'.$total_payable.'","","","'.$date.'","'.$_SESSION['user']['id'].'","","")';

   $row = db_query($insert);

   

   add_to_sec_journal('Aksid', $jv_no, $jv_date, $ledger_id_dr, $narration_dr, $total_payable, '0', $tr_from, $tr_no,0,0,$proj_cc_code_dr,2);

   

   //add_to_journal('Aksid', $jv_no1, $jv_date, $ledger_id_dr, $narration_dr,  $total_payable, '0', $tr_from, $tr_no,0,0,22,2);
   add_to_journal('Aksid', $jv_no1, $jv_date, $ledger_id_dr, $narration_dr, $total_payable, '0', $tr_from, $tr_no,$sub_ledger='',$tr_id='',$proj_cc_code_dr,$c_no='',$c_date='',$receive_ledger='');
   
   
    add_to_sec_journal('Aksid', $jv_no, $jv_date, $ledger_id_cr, $narration_cr, '0',$total_payable_credit,$tr_from,$tr_no,0,0,$proj_cc_code_dr,2);
    add_to_journal('Aksid', $jv_no1, $jv_date, $ledger_id_cr, $narration_cr,'0',$total_payable_credit, $tr_from, $tr_no,$sub_ledger='',$tr_id='',$proj_cc_code_dr,$c_no='',$c_date='',$receive_ledger='');
	
	
	
	
	

   }

   

   

   

//department brief salary to secondary journal



		$sqli11 = 'select dept.DEPT_DESC,dept.account_ledger,dept.cc_code,a.department, sum(a.gross_salary+a.food_allowance+a.transport_allowance+a.other_allowance+a.adjustment_amount+a.offday_allowance+a.sitevisit_allowance) as total_pay,
sum(a.absent_deduction+a.joining_deduction+a.late_deduction+a.lwp_deduction+a.hr_action_amt+a.other_deduction+a.other_deductions) as total_deduction,
sum(a.income_tax+a.food_deduction+a.mobile_deduction) as credit_total_deduction from salary_attendence a, personnel_basic_info b, department dept where a.PBI_ID = b.PBI_ID and mon='.$_POST['mon'].' and year='.$_POST['year'].'  and b.PBI_JOB_STATUS="In Service"   and a.department = dept.DEPT_ID and  a.pay>0 and dept.DEPT_ID not in (13,10)  GROUP BY dept.DEPT_ID  ';

		$query13 = db_query($sqli11);

    while($dataa1 = mysqli_fetch_object($query13)){

	

	$total_payable1 = $dataa1->total_pay-$dataa1->total_deduction;
	$total_payable_credit1 = $dataa1->total_pay-$dataa1->total_deduction-$dataa1->credit_total_deduction;

	

	 $ledger_id_dr = $dataa1->account_ledger;
	 $dep_cc_code_dr = $dataa1->cc_code;

   $total_amt = $total_amt+ $total_payable_credit1;

   $insert11 = 'INSERT INTO `salary_journal`(`department`, `project`, `mon`, `year`, `total_salary`, `total_deduction`, `total_payable`, `entry_at`, `entry_by`, `checked_at`, `cheked_by`) VALUES ("'.$dataa1->department.'","","'.$_POST['mon'].'","'.$_POST['year'].'","'.$total_payable1.'","","","'.$date.'","'.$_SESSION['user']['id'].'","","")';

   

   $row = db_query($insert11);

   

   

     add_to_sec_journal('Aksid', $jv_no, $jv_date, $ledger_id_dr, $narration_dr, $total_payable1, '0', $tr_from, $tr_no,0,0,$dep_cc_code_dr,2);
	 add_to_sec_journal('Aksid', $jv_no, $jv_date, $ledger_id_cr, $narration_cr, '0', $total_payable_credit1, $tr_from, $tr_no,0,0,$dep_cc_code_dr,2);

   //add_to_journal('Aksid', $jv_no1, $jv_date, $ledger_id_dr, $narration_dr,  $total_payable1, '0', $tr_from, $tr_no,0,0,22,2);

    

   add_to_journal('Aksid', $jv_no1, $jv_date, $ledger_id_dr, $narration_dr, $total_payable1, '0', $tr_from, $tr_no,$sub_ledger='',$tr_id='',$dep_cc_code_dr,$c_no='',$c_date='',$receive_ledger='');
   add_to_journal('Aksid', $jv_no1, $jv_date, $ledger_id_cr, $narration_cr,'0',$total_payable_credit1, $tr_from, $tr_no,$sub_ledger='',$tr_id='',$dep_cc_code_dr,$c_no='',$c_date='',$receive_ledger='');
	
	
	

   }

   

    // add_to_sec_journal('Aksid', $jv_no, $jv_date, $ledger_id_cr, $narration_cr, '0', $total_amt, $tr_from, $tr_no,0,0,22,2);

   

  // add_to_journal('Aksid', $jv_no1, $jv_date, $ledger_id_cr, $narration_cr, '0',  $total_amt, $tr_from, $tr_no,0,0,22,2);

   

  // add_to_journal('Aksid', $jv_no1, $jv_date, $ledger_id_cr, $narration_cr,'0',$total_amt, $tr_from, $tr_no,$sub_ledger='',$tr_id='',$cc_code='22',$c_no='',$c_date='',$receive_ledger='');
  
  
  
  
  
  // ################################ START    Casual Staff Salary Automation   ################################################



 $sqli11c = 'select e.acledger_for_salary_casual_staff,e.cc_code_for_casual_staff,
sum(a.gross_salary+a.food_allowance+a.transport_allowance+a.other_allowance+a.adjustment_amount+a.offday_allowance+a.sitevisit_allowance) as total_pay,
sum(a.absent_deduction+a.joining_deduction+a.late_deduction+a.lwp_deduction+a.hr_action_amt+a.other_deduction+a.other_deductions) as total_deduction,
sum(a.income_tax+a.food_deduction+a.mobile_deduction) as credit_total_deduction 

from salary_attendence a,personnel_basic_info b,essential_info e
where a.PBI_ID = b.PBI_ID and a.PBI_ID=e.PBI_ID and mon='.$_POST['mon'].' and year='.$_POST['year'].' and e.acledger_for_salary_casual_staff>0 and 
b.PBI_JOB_STATUS="In Service"  and  a.pay>0 GROUP BY a.PBI_ID';

	$query13c = db_query($sqli11c);
    while($dataa1c = mysqli_fetch_object($query13c)){

    $total_payable1c        = $dataa1c->total_pay-$dataa1c->total_deduction;
	$total_payable_credit1c = $dataa1c->total_pay-$dataa1c->total_deduction-$dataa1c->credit_total_deduction;
    $ledger_id_drc          = $dataa1c->acledger_for_salary_casual_staff;
	$dep_cc_code_drc        = $dataa1c->cc_code_for_casual_staff;
    $ledger_id_crc = 2063000200000000;



   
     add_to_sec_journal('Aksid', $jv_no, $jv_date, $ledger_id_drc, $narration_dr, $total_payable1c, '0', $tr_from, $tr_no,0,0,$dep_cc_code_drc,2);
	 add_to_sec_journal('Aksid', $jv_no, $jv_date, $ledger_id_crc, $narration_cr, '0', $total_payable_credit1c, $tr_from, $tr_no,0,0,$dep_cc_code_drc,2);

   //add_to_journal('Aksid', $jv_no1, $jv_date, $ledger_id_dr, $narration_dr,  $total_payable1, '0', $tr_from, $tr_no,0,0,22,2);

   add_to_journal('Aksid', $jv_no1, $jv_date, $ledger_id_drc, $narration_dr, $total_payable1c, '0', $tr_from, $tr_no,$sub_ledger='',$tr_id='',$dep_cc_code_drc,$c_no='',$c_date='',$receive_ledger='');
   add_to_journal('Aksid', $jv_no1, $jv_date, $ledger_id_crc, $narration_cr,'0',$total_payable_credit1c, $tr_from, $tr_no,$sub_ledger='',$tr_id='',$dep_cc_code_drc,$c_no='',$c_date='',$receive_ledger='');
	
	
	

   }
  
  
   // ################################ END    Casual Staff Salary Automation   ################################################
  
  
  
  
  
  
  
  
  
  

}





 /*======================*/







/*==========Mobile Bill============*/





$sqlll = 'select s.* from salary_attendence s where s.mon="'.$_POST['mon'].'" and s.year="'.$_POST['year'].'" ';

$qu = db_query($sqlll);





if(isset($_REQUEST['m_lock'])){





   

   while($data1=mysqli_fetch_object($qu)){

   

   $mobile_no = find_a_field('personnel_basic_info','PBI_MOBILE','PBI_ID='.$data1->PBI_ID);

   

  

     $m_bil_insert = 'INSERT INTO `mobile_bill_lock` (`PBI_ID`,`mon`, `year`, `designation`, `department`, `job_location`,`mobile_no`, `mobile_bill_limit`, `billing_amount`, `deduction`, `entry_by`) VALUES ( "'.$data1->PBI_ID.'", "'.$_POST['mon'].'", "'.$_POST['year'].'", "'.$data1->designation.'", "'.$data1->department.'","'.$data1->job_location.'", "'.$mobile_no.'", "'.$data1->mobile_bill_limit.'", "'.$data1->mobile_bill_amt.'", "'.$data1->mobile_deduction.'", "'.$_SESSION['user']['id'].'")';

	 

	 db_query($m_bil_insert);

  

  

    $updatee = 'update salary_attendence set m_lock=1 where mon="'.$_POST['mon'].'" and year="'.$_POST['year'].'" and PBI_ID="'.$data1->PBI_ID.'"';

   $upq = db_query($updatee);

   

   

   }

   
// ======= START   ====================```````````````````````` mobile bill for project 
   

   $sss = 'select proj.PROJECT_DESC,proj.acc_ledger_for_mobile_bill,proj.cc_code,a.job_location,sum(a.mobile_bill_amt) as total_amt,sum(a.mobile_deduction) as deduction_amt from salary_attendence a, personnel_basic_info b, project proj where a.PBI_ID = b.PBI_ID and mon='.$_POST['mon'].' and year='.$_POST['year'].' and b.PBI_JOB_STATUS="In Service"  and  a.job_location = proj.PROJECT_ID  GROUP BY proj.PROJECT_ID';

		$query12 = db_query($sss);

		



		

   $date = $_POST['year'].'-'.$_POST['mon'].'-'.'30';

  

   $jv_date = strtotime($date);

   $narration_dr = 'Mobile Bill for the month of ' .$_POST['mon']. ' and year of ' .$_POST['year'];

   $narration_cr = 'Mobile Bill Payable for the month of ' .$_POST['mon']. ' and year of ' .$_POST['year'];

   $tr_from = 'Mobile_bill';

   $tr_no = date('Ym'.'01');

   $jv_no = next_journal_sec_voucher_id();

   $jv_no1 = next_journal_voucher_id();

   

	$ledger_id_cr = 2063000100020000;

   while($mdata = mysqli_fetch_object($query12)){

   

   $ledger_id_dr = $mdata->acc_ledger_for_mobile_bill;
   
   $proj_cc_code = $mdata->cc_code;

   $total_amt = $total_amt+ $mdata->total_amt;
   
   $total_amt_deduction_credit =$mdata->deduction_amt;

   

   $insert = 'INSERT INTO `salary_journal`(`department`, `project`, `mon`, `year`, `total_salary`, `total_deduction`, `total_payable`, `entry_at`, `entry_by`, `checked_at`, `cheked_by`) VALUES ("","'.$mdata->job_location.'","'.$_POST['mon'].'","'.$_POST['year'].'","'.$mdata->total_amt.'","","","'.$date.'","'.$_SESSION['user']['id'].'","","")';

   $row = db_query($insert);

   

   add_to_sec_journal('Aksid', $jv_no, $jv_date, $ledger_id_dr, $narration_dr, $mdata->total_amt, '0', $tr_from, $tr_no,0,0,$proj_cc_code,2);
   add_to_sec_journal('Aksid', $jv_no, $jv_date, $ledger_id_cr, $narration_dr,'0', $mdata->total_amt, $tr_from, $tr_no,0,0,$proj_cc_code,2);
   
   // for actuall mobile bill credit single mobile bill 
   add_to_sec_journal('Aksid', $jv_no, $jv_date, $ledger_id_dr, $narration_dr,'0', $mdata->deduction_amt, $tr_from, $tr_no,0,0,$proj_cc_code,2);
   
   
   
   
   add_to_journal('Aksid', $jv_no1, $jv_date, $ledger_id_dr, $narration_dr,  $mdata->total_amt, '0', $tr_from, $tr_no,0,0,$proj_cc_code);
   add_to_journal('Aksid', $jv_no1, $jv_date, $ledger_id_cr, $narration_dr,'0',$mdata->total_amt, $tr_from, $tr_no,0,0,$proj_cc_code);
   
   // for actuall mobile bill credit single mobile bill
   add_to_journal('Aksid', $jv_no1, $jv_date, $ledger_id_dr, $narration_dr,'0',  $mdata->deduction_amt, $tr_from, $tr_no,0,0,$proj_cc_code);


   }

   

   

   

// START ================ ````````````````````````````````  department brief mobile bill to secondary journal



		$sqli11 = 'select dept.DEPT_DESC,dept.acc_ledger_for_mobile_bill,dept.cc_code,a.department, sum(a.mobile_bill_amt) as total_amt,sum(a.mobile_deduction) as deduction_amt  from salary_attendence a, personnel_basic_info b, department dept where a.PBI_ID = b.PBI_ID and mon='.$_POST['mon'].' and year='.$_POST['year'].'  and b.PBI_JOB_STATUS="In Service"   and a.department = dept.DEPT_ID  and dept.DEPT_ID not in (13)  GROUP BY dept.DEPT_ID  ';

		$query13 = db_query($sqli11);

    while($dataa1 = mysqli_fetch_object($query13)){

	 $ledger_id_dr = $dataa1->acc_ledger_for_mobile_bill;
	 $dep_cc_code = $dataa1->cc_code;
  

   $total_amt = $total_amt+ $dataa1->total_amt;
   $total_amt_deduction_credit1 =$dataa1->deduction_amt;

   $insert11 = 'INSERT INTO `salary_journal`(`department`, `project`, `mon`, `year`, `total_salary`, `total_deduction`, `total_payable`, `entry_at`, `entry_by`, `checked_at`, `cheked_by`) VALUES ("'.$dataa1->department.'","","'.$_POST['mon'].'","'.$_POST['year'].'","'.$dataa1->total_amt.'","","","'.$date.'","'.$_SESSION['user']['id'].'","","")';

   

   $row = db_query($insert11);

   

   

   //add_to_sec_journal('Aksid', $jv_no, $jv_date, $ledger_id_dr, $narration_dr, $dataa1->total_amt, '0', $tr_from,$tr_no,$dep_cc_code);


   
   
   add_to_sec_journal('Aksid', $jv_no, $jv_date, $ledger_id_dr, $narration_dr,$dataa1->total_amt, '0', $tr_from, $tr_no,0,0,$dep_cc_code,2);
   add_to_sec_journal('Aksid', $jv_no, $jv_date, $ledger_id_cr, $narration_dr,'0', $dataa1->total_amt, $tr_from, $tr_no,0,0,$dep_cc_code,2);
   
   // for actuall mobile bill credit single mobile bill
   add_to_sec_journal('Aksid', $jv_no, $jv_date, $ledger_id_dr, $narration_dr,'0', $dataa1->deduction_amt, $tr_from, $tr_no,0,0,$dep_cc_code,2);
   
    
	
   add_to_journal('Aksid', $jv_no1, $jv_date, $ledger_id_dr, $narration_dr, $dataa1->total_amt, '0', $tr_from,$tr_no,0,0,$dep_cc_code);
   add_to_journal('Aksid', $jv_no1, $jv_date, $ledger_id_cr, $narration_dr,'0',  $dataa1->total_amt, $tr_from, $tr_no,0,0,$dep_cc_code);
   
   // for actuall mobile bill credit single mobile bill
   add_to_journal('Aksid', $jv_no1, $jv_date, $ledger_id_dr, $narration_dr,'0',  $dataa1->deduction_amt, $tr_from, $tr_no,0,0,$dep_cc_code);
   
   //add_to_journal($proj_id, $jv_no, $jv_date, $ledger_id, $narration, $dr_amt, $cr_amt, $tr_from, $tr_no,$sub_ledger='',$tr_id='',$cc_code='',$c_no='',$c_date='',$receive_ledger='')

    

   

   }

   

   //add_to_sec_journal('Aksid', $jv_no, $jv_date, $ledger_id_cr, $narration_cr, '0', $total_amt, $tr_from, $tr_no,'0',$proj_cc_code);
   //add_to_journal('Aksid', $jv_no1, $jv_date, $ledger_id_cr, $narration_cr, '0',  $total_amt, $tr_from, $tr_no,'0',$dep_cc_code);
   
   
   //add_to_sec_journal('Aksid', $jv_no, $jv_date, $ledger_id_cr, $narration_cr, '0', $total_amt, $tr_from, $tr_no,0,0,22,2);
   
  // add_to_journal('Aksid', $jv_no1, $jv_date, $ledger_id_cr, $narration_cr, '0',  $total_amt, $tr_from, $tr_no,0,22,2);




}





/*==========Mobile Bill END============*/











/*==========Bonus============*/







$sqll2 = 'select s.* from salary_bonus s,personnel_basic_info p where bonus_type="'.$_POST['bonus_type'].'" and year="'.$_POST['year'].'"  and p.PBI_ID=s.PBI_ID and p.PBI_JOB_STATUS="In Service"';

$querr2 = db_query($sqll2);



if(isset($_REQUEST['b_lock'])){

   

   while($data2=mysqli_fetch_object($querr2)){

   

   $insert2 = 'INSERT INTO `salary_bonus_lock`(`bonus_type`,`mon`, `year`, `PBI_ID`, `pbi_department`, `pbi_designation`, `pbi_organization`, `pbi_job_location`, `pbi_doj`, `job_status`, `gross_salary`, `basic_salary`, `bonus_percentage`, `cut_off_date`, `job_period`, `bonus_days`, `bonus_percent`, `bonus_amt`, `bank_paid`, `cash_paid`,`payroll_card_paid`, `entry_by`, `entry_at`, `remarks`) 
   VALUES ("'.$data2->bonus_type.'","'.$data2->mon.'","'.$data2->year.'","'.$data2->PBI_ID.'","'.$data2->pbi_department.'","'.$data2->pbi_designation.'","'.$data2->pbi_organization.'","'.$data2->pbi_job_location.'","'.$data2->pbi_doj.'","'.$data2->job_status.'","'.$data2->gross_salary.'","'.$data2->basic_salary.'","'.$data2->bonus_percentage.'","'.$data2->cut_off_date.'","'.$data2->job_period.'","'.$data2->bonus_days.'","'.$data2->bonus_percent.'","'.$data2->bonus_amt.'","'.$data2->bank_paid.'","'.$data2->cash_paid.'","'.$data2->payroll_card_paid.'","'.$data2->entry_by.'","'.$data2->entry_at.'","'.$data2->remarks.'")';

   

   $row = db_query($insert2);

   

     $update2 = 'update salary_bonus set lock_status=1 where bonus_type="'.$_POST['bonus_type'].'" and year="'.$_POST['year'].'" and PBI_ID="'.$data2->PBI_ID.'"';

   $upqr2 = db_query($update2);

   

   

   }

   

   

   

   

   //project brief bonus to secondary journal and journal

   $sss = 'select proj.PROJECT_DESC ,proj.account_ledger, sum(a.bonus_amt) as total_amt,proj.cc_code from salary_bonus a, personnel_basic_info b, project proj where a.PBI_ID = b.PBI_ID and bonus_type='.$_POST['bonus_type'].' and year='.$_POST['year'].' and b.PBI_JOB_STATUS="In Service" and a.pbi_job_location = proj.PROJECT_ID  GROUP BY proj.PROJECT_ID';

		$query12 = db_query($sss);

		

    

	if($_POST['bonus_type']==1){

	  $bonus_type = 'Eid-Ul-Fitre';

	}elseif($_POST['bonus_type']==2){

	  $bonus_type = 'Eid-Ul-Adha';

	}

		

   $date = date('Y-m-d');

   $jv_date = strtotime($date);

   $narration_dr = 'Bonus expense for the ' .$bonus_type. ' year of ' .$_POST['year'];

   $narration_cr = 'Bonus Payable for the ' .$bonus_type. ' year of ' .$_POST['year'];

   $tr_from = 'bonus';

   $tr_no = date('Y').$_POST['bonus_type'];

   $jv_no = next_journal_sec_voucher_id();

   $jv_no1 = next_journal_voucher_id();

   

	$ledger_id_cr = 2063000200000000;

   while($dataaa = mysqli_fetch_object($query12)){

   

   $total_payable = $dataaa->total_amt;
   $bonus_proj_cc_code=$dataaa->cc_code;
   $ledger_id_dr = $dataaa->account_ledger;

   $total_amt = $total_amt+ $total_payable;

   

   add_to_sec_journal('Aksid', $jv_no, $jv_date, $ledger_id_dr, $narration_dr, $total_payable, '0', $tr_from, $tr_no,0,0,$bonus_proj_cc_code,2);
   
   
   add_to_sec_journal('Aksid', $jv_no, $jv_date, $ledger_id_cr, $narration_cr, '0', $total_payable, $tr_from, $tr_no,0,0,$bonus_proj_cc_code,2);

   

   add_to_journal('Aksid', $jv_no1, $jv_date, $ledger_id_dr, $narration_dr,  $total_payable, '0', $tr_from, $tr_no,0,0,$bonus_proj_cc_code,2);
   
   add_to_journal('Aksid', $jv_no1, $jv_date, $ledger_id_cr, $narration_cr, '0',  $total_payable, $tr_from, $tr_no,0,0,$bonus_proj_cc_code,2);
   
   

   }

   

   

   

//department brief salary to secondary journal and journal



		$sqli11 = 'select dept.DEPT_DESC,dept.account_ledger, sum(a.bonus_amt) as total_amt,dept.cc_code from salary_bonus a, personnel_basic_info b, department dept where a.PBI_ID = b.PBI_ID and bonus_type='.$_POST['bonus_type'].' and year='.$_POST['year'].' and b.PBI_JOB_STATUS="In Service" and a.pbi_department = dept.DEPT_ID  and dept.DEPT_ID not in (13)  GROUP BY dept.DEPT_ID ';

		$query13 = db_query($sqli11);

    while($dataa1 = mysqli_fetch_object($query13)){

	

	$total_payable1 = $dataa1->total_amt;
    $ledger_id_dr = $dataa1->account_ledger;
	$bonus_dep_cc_code= $dataa1->cc_code;

   $total_amt = $total_amt+ $total_payable1;

  

   add_to_sec_journal('Aksid', $jv_no, $jv_date, $ledger_id_dr, $narration_dr, $total_payable1, '0', $tr_from, $tr_no,0,0,$bonus_dep_cc_code,2);
   add_to_sec_journal('Aksid', $jv_no, $jv_date, $ledger_id_cr, $narration_cr, '0', $total_payable1, $tr_from, $tr_no,0,0,$bonus_dep_cc_code,2);

   add_to_journal('Aksid', $jv_no1, $jv_date, $ledger_id_dr, $narration_dr,  $total_payable1, '0', $tr_from, $tr_no,0,0,$bonus_dep_cc_code,2);
   add_to_journal('Aksid', $jv_no1, $jv_date, $ledger_id_cr, $narration_cr, '0',  $total_payable1, $tr_from, $tr_no,0,0,$bonus_dep_cc_code,2);

    

   

   }

   

   

   

   







 /*======================*/





}


// ******============  ===  FOOD bill LOCK   START ==================================    

$sqlll = 'select s.* from salary_attendence s where s.mon="'.$_POST['mon'].'" and s.year="'.$_POST['year'].'" ';

$qu = db_query($sqlll);





if(isset($_REQUEST['f_lock'])){





   

   while($data1=mysqli_fetch_object($qu)){

   

   $mobile_no = find_a_field('personnel_basic_info','PBI_MOBILE','PBI_ID='.$data1->PBI_ID);

   

  

     $f_bil_insert = 'INSERT INTO `food_bill_lock` (`PBI_ID`,`mon`, `year`, `designation`, `department`, `job_location`,`mobile_no`, `food_allowance`, `food_deduction`, `deduction`, `entry_by`) VALUES ( "'.$data1->PBI_ID.'", "'.$_POST['mon'].'", "'.$_POST['year'].'", "'.$data1->designation.'", "'.$data1->department.'","'.$data1->job_location.'", "'.$mobile_no.'", "'.$data1->food_allowance.'", "'.$data1->food_deduction.'", "'.$data1->food_deduction.'", "'.$_SESSION['user']['id'].'")';

	 

	 db_query($f_bil_insert);

  

  

    $updatee = 'update salary_attendence set f_lock=1 where mon="'.$_POST['mon'].'" and year="'.$_POST['year'].'" and PBI_ID="'.$data1->PBI_ID.'"';

   $upq = db_query($updatee);

   

   

   }

   
// ======= START   ====================```````````````````````` food bill for project 
   

   $sss = 'select proj.PROJECT_DESC,proj.acc_ledger_for_food_bill,proj.cc_code,a.job_location, sum(a.food_deduction) as total_amt from salary_attendence a, personnel_basic_info b, project proj where a.PBI_ID = b.PBI_ID and mon='.$_POST['mon'].' and year='.$_POST['year'].' and b.PBI_JOB_STATUS="In Service"  and  a.job_location = proj.PROJECT_ID  GROUP BY proj.PROJECT_ID';

		$query12 = db_query($sss);

		



		

   $date = $_POST['year'].'-'.$_POST['mon'].'-'.'30';

  

   $jv_date = strtotime($date);

   $narration_dr = 'Food Bill for the month of ' .$_POST['mon']. ' and year of ' .$_POST['year'];

   $narration_cr = 'Food Bill Payable for the month of ' .$_POST['mon']. ' and year of ' .$_POST['year'];

   $tr_from = 'Food_bill';

   $tr_no = date('Ym'.'01');

   $jv_no = next_journal_sec_voucher_id();

   $jv_no1 = next_journal_voucher_id();

   

	$ledger_id_cr = 1091000900020000;

   while($mdata = mysqli_fetch_object($query12)){

   

   $ledger_id_dr = $mdata->acc_ledger_for_food_bill;
   
   $proj_cc_code = $mdata->cc_code;

   $total_amt = $total_amt+ $mdata->total_amt;

   

   $insert = 'INSERT INTO `salary_journal`(`department`, `project`, `mon`, `year`, `total_salary`, `total_deduction`, `total_payable`, `entry_at`, `entry_by`, `checked_at`, `cheked_by`) VALUES ("","'.$mdata->job_location.'","'.$_POST['mon'].'","'.$_POST['year'].'","'.$mdata->total_amt.'","","","'.$date.'","'.$_SESSION['user']['id'].'","","")';

   $row = db_query($insert);

   

   add_to_sec_journal('Aksid', $jv_no, $jv_date, $ledger_id_dr, $narration_dr,'0', $mdata->total_amt , $tr_from, $tr_no,0,0,$proj_cc_code,2);
   
   add_to_journal('Aksid', $jv_no1, $jv_date, $ledger_id_dr, $narration_dr, '0',$mdata->total_amt, $tr_from, $tr_no,0,0,$proj_cc_code);
   
   
   

   }

   

   

   

// START ================ ````````````````````````````````  department brief food bill to secondary journal



		$sqli11 = 'select dept.DEPT_DESC,dept.acc_ledger_for_food_bill,dept.cc_code,a.department, sum(a.food_deduction) as total_amt from salary_attendence a, personnel_basic_info b, department dept where a.PBI_ID = b.PBI_ID and mon='.$_POST['mon'].' and year='.$_POST['year'].'  and b.PBI_JOB_STATUS="In Service"   and a.department = dept.DEPT_ID  and dept.DEPT_ID not in (13)  GROUP BY dept.DEPT_ID  ';

		$query13 = db_query($sqli11);

    while($dataa1 = mysqli_fetch_object($query13)){

	 $ledger_id_dr = $dataa1->acc_ledger_for_food_bill;
	 $dep_cc_code = $dataa1->cc_code;
  

   $total_amt = $total_amt+ $dataa1->total_amt;

   $insert11 = 'INSERT INTO `salary_journal`(`department`, `project`, `mon`, `year`, `total_salary`, `total_deduction`, `total_payable`, `entry_at`, `entry_by`, `checked_at`, `cheked_by`) VALUES ("'.$dataa1->department.'","","'.$_POST['mon'].'","'.$_POST['year'].'","'.$dataa1->total_amt.'","","","'.$date.'","'.$_SESSION['user']['id'].'","","")';

   

   $row = db_query($insert11);

   

   

   //add_to_sec_journal('Aksid', $jv_no, $jv_date, $ledger_id_dr, $narration_dr, $dataa1->total_amt, '0', $tr_from,$tr_no,$dep_cc_code);


   
   
   add_to_sec_journal('Aksid', $jv_no, $jv_date, $ledger_id_dr, $narration_dr, '0',$dataa1->total_amt, $tr_from, $tr_no,0,0,$dep_cc_code,2);
   
   add_to_journal('Aksid', $jv_no1, $jv_date, $ledger_id_dr, $narration_dr, '0',$dataa1->total_amt, $tr_from,$tr_no,0,0,$dep_cc_code);
   
    

    

   

   }

   

   //add_to_sec_journal('Aksid', $jv_no, $jv_date, $ledger_id_cr, $narration_cr, '0', $total_amt, $tr_from, $tr_no,'0',$proj_cc_code);
   //add_to_journal('Aksid', $jv_no1, $jv_date, $ledger_id_cr, $narration_cr, '0',  $total_amt, $tr_from, $tr_no,'0',$dep_cc_code);
   
   
  // add_to_sec_journal('Aksid', $jv_no, $jv_date, $ledger_id_cr, $narration_cr, '0', $total_amt, $tr_from, $tr_no,0,0,22,2);
   
  // add_to_journal('Aksid', $jv_no1, $jv_date, $ledger_id_cr, $narration_cr, '0',  $total_amt, $tr_from, $tr_no,0,22,2);




}



// ================   ========`````````FOOD bill LOCK END  =================================




// ******============  ===  TAX bill LOCK   START ==================================    

$sqlll = 'select s.* from salary_attendence s where s.mon="'.$_POST['mon'].'" and s.year="'.$_POST['year'].'" ';

$qu = db_query($sqlll);





if(isset($_REQUEST['t_lock'])){





   

   while($data1=mysqli_fetch_object($qu)){

   

   $mobile_no = find_a_field('personnel_basic_info','PBI_MOBILE','PBI_ID='.$data1->PBI_ID);

   

  

     $f_bil_insert = 'INSERT INTO `tax_bill_lock` (`PBI_ID`,`mon`, `year`, `designation`, `department`, `job_location`,`income_tax`, `entry_by`) VALUES ( "'.$data1->PBI_ID.'", "'.$_POST['mon'].'", "'.$_POST['year'].'", "'.$data1->designation.'", "'.$data1->department.'","'.$data1->job_location.'","'.$data1->income_tax.'","'.$_SESSION['user']['id'].'")';

	 

	 db_query($f_bil_insert);

  

  

    $updatee = 'update salary_attendence set t_lock=1 where mon="'.$_POST['mon'].'" and year="'.$_POST['year'].'" and PBI_ID="'.$data1->PBI_ID.'"';

   $upq = db_query($updatee);

   

   

   }

   
// ======= START   ====================```````````````````````` TAX bill for project 
   

   $sss = 'select proj.PROJECT_DESC,proj.acc_ledger_for_tax,proj.cc_code,a.job_location, sum(a.income_tax) as total_amt from salary_attendence a, personnel_basic_info b, project proj where a.PBI_ID = b.PBI_ID and mon='.$_POST['mon'].' and year='.$_POST['year'].' and b.PBI_JOB_STATUS="In Service" and a.pay>0 and  a.job_location = proj.PROJECT_ID  GROUP BY proj.PROJECT_ID';

		$query12 = db_query($sss);

		



		

   $date = $_POST['year'].'-'.$_POST['mon'].'-'.'30';

  

   $jv_date = strtotime($date);

   $narration_dr = 'Tax Bill for the month of ' .$_POST['mon']. ' and year of ' .$_POST['year'];

   $narration_cr = 'Tax Bill Payable for the month of ' .$_POST['mon']. ' and year of ' .$_POST['year'];

   $tr_from = 'Tax_bill';

   $tr_no = date('Ym'.'01');

   $jv_no = next_journal_sec_voucher_id();

   $jv_no1 = next_journal_voucher_id();

   

	$ledger_id_cr = 2063000400000000;

   while($mdata = mysqli_fetch_object($query12)){

   

   $ledger_id_dr = $mdata->acc_ledger_for_tax;
   
   $proj_cc_code = $mdata->cc_code;

   $total_amt = $total_amt+ $mdata->total_amt;

   

  // $insert = 'INSERT INTO `salary_journal`(`department`, `project`, `mon`, `year`, `total_salary`, `total_deduction`, `total_payable`, `entry_at`, `entry_by`, `checked_at`, `cheked_by`) VALUES ("","'.$mdata->job_location.'","'.$_POST['mon'].'","'.$_POST['year'].'","'.$mdata->total_amt.'","","","'.$date.'","'.$_SESSION['user']['id'].'","","")';
//$row = db_query($insert);

   

   add_to_sec_journal('Aksid', $jv_no, $jv_date, $ledger_id_dr, $narration_dr,'0',$mdata->total_amt, $tr_from, $tr_no,0,0,$proj_cc_code,2);
   
   add_to_journal('Aksid', $jv_no1, $jv_date, $ledger_id_dr, $narration_dr,'0',$mdata->total_amt, $tr_from, $tr_no,0,0,$proj_cc_code);
   
   
   

   }

   

   

   

// START ================ ````````````````````````````````  department brief tax bill to secondary journal



		$sqli11 = 'select dept.DEPT_DESC,dept.acc_ledger_for_tax,dept.cc_code,a.department, sum(a.income_tax) as total_amt from salary_attendence a, personnel_basic_info b, department dept where a.PBI_ID = b.PBI_ID and mon='.$_POST['mon'].' and year='.$_POST['year'].'  and b.PBI_JOB_STATUS="In Service" and a.pay>0 and a.department = dept.DEPT_ID  and dept.DEPT_ID not in (13)  GROUP BY dept.DEPT_ID  ';

		$query13 = db_query($sqli11);

    while($dataa1 = mysqli_fetch_object($query13)){

	 $ledger_id_dr = $dataa1->acc_ledger_for_tax;
	 $dep_cc_code = $dataa1->cc_code;
  

   $total_amt = $total_amt+ $dataa1->total_amt;

   //$insert11 = 'INSERT INTO `salary_journal`(`department`, `project`, `mon`, `year`, `total_salary`, `total_deduction`, `total_payable`, `entry_at`, `entry_by`, `checked_at`, `cheked_by`) VALUES ("'.$dataa1->department.'","","'.$_POST['mon'].'","'.$_POST['year'].'","'.$dataa1->total_amt.'","","","'.$date.'","'.$_SESSION['user']['id'].'","","")';
//$row = db_query($insert11);

   

   

   //add_to_sec_journal('Aksid', $jv_no, $jv_date, $ledger_id_dr, $narration_dr, $dataa1->total_amt, '0', $tr_from,$tr_no,$dep_cc_code);


   
   
   add_to_sec_journal('Aksid', $jv_no, $jv_date, $ledger_id_dr, $narration_dr,'0',$dataa1->total_amt, $tr_from, $tr_no,0,0,$dep_cc_code,2);
   
   add_to_journal('Aksid', $jv_no1, $jv_date, $ledger_id_dr, $narration_dr,'0',$dataa1->total_amt, $tr_from,$tr_no,0,0,$dep_cc_code);
   
    

    

   

   }

   

   //add_to_sec_journal('Aksid', $jv_no, $jv_date, $ledger_id_cr, $narration_cr, '0', $total_amt, $tr_from, $tr_no,'0',$proj_cc_code);
   //add_to_journal('Aksid', $jv_no1, $jv_date, $ledger_id_cr, $narration_cr, '0',  $total_amt, $tr_from, $tr_no,'0',$dep_cc_code);
   
   
  // add_to_sec_journal('Aksid', $jv_no, $jv_date, $ledger_id_cr, $narration_cr, '0', $total_amt, $tr_from, $tr_no,0,0,22,2);
   
   //add_to_journal('Aksid', $jv_no1, $jv_date, $ledger_id_cr, $narration_cr, '0',  $total_amt, $tr_from, $tr_no,0,22,2);




}



// ================   ========`````````TAX bill LOCK END  =================================









// ******============  ===  ADVANCE  bill LOCK   START ==================================    

$sqlll = 'select s.* from salary_attendence s where s.mon="'.$_POST['mon'].'" and s.year="'.$_POST['year'].'" ';

$qu = db_query($sqlll);





if(isset($_REQUEST['ad_lock'])){


while($data1=mysqli_fetch_object($qu)){

$updatee = 'update salary_attendence set ad_lock=1 where mon="'.$_POST['mon'].'" and year="'.$_POST['year'].'" and PBI_ID="'.$data1->PBI_ID.'"';
$upq = db_query($updatee);

}

   
// ======= START   ====================```````````````````````` ADVANCE bill for project 
$sqli11 = 'select dept.DEPT_DESC,dept.cc_code,a.department,a.advance_install,b.advance_ledger_id, 
sum(a.advance_install) as total_amt from salary_attendence a, personnel_basic_info b, department dept where a.PBI_ID = b.PBI_ID and mon='.$_POST['mon'].' and year='.$_POST['year'].'  and b.PBI_JOB_STATUS="In Service"   and a.department = dept.DEPT_ID  and a.advance_install>0  GROUP BY a.PBI_ID  ';

$query13 = db_query($sqli11);

   $date = $_POST['year'].'-'.$_POST['mon'].'-'.'30';
   $jv_date = strtotime($date);
   $narration_dr = 'Advance Bill for the month of ' .$_POST['mon']. ' and year of ' .$_POST['year'];
   $narration_cr = 'Advance Bill Payable for the month of ' .$_POST['mon']. ' and year of ' .$_POST['year'];
   $tr_from = 'advance_salary';
   $tr_no = date('Ym'.'01');
   $jv_no = next_journal_sec_voucher_id();
   $jv_no1 = next_journal_voucher_id();
  
	
	
while($dataa1 = mysqli_fetch_object($query13)){

	 $dep_cc_code = $dataa1->cc_code;
     $total_amt = $total_amt+ $dataa1->total_amt;
	 $ledger_id_dr = 2063000200000000; 
     $ledger_id_cr = $dataa1->advance_ledger_id;
     $advance_amount = $dataa1->advance_install;

   add_to_sec_journal('Aksid', $jv_no, $jv_date, $ledger_id_dr, $narration_dr,$advance_amount,'0', $tr_from, $tr_no,0,0,$dep_cc_code,2);
   add_to_sec_journal('Aksid', $jv_no, $jv_date, $ledger_id_cr, $narration_cr, '0',$advance_amount,$tr_from, $tr_no,0,0,$dep_cc_code,2);
   
   //for advance sallary 
	add_to_journal('Aksid', $jv_no1, $jv_date, $ledger_id_dr, $narration_dr,$advance_amount,'0', $tr_from, $tr_no,0,0,$dep_cc_code);
    add_to_journal('Aksid', $jv_no1, $jv_date, $ledger_id_cr, $narration_cr, '0',$advance_amount, $tr_from, $tr_no,0,0,$dep_cc_code);
   
 }
 
 
 
 
 
 
    
// ======= START  IOU  ====================```````````````````````` ADVANCE IOU bill for project 
$sqli11i = 'select dept.DEPT_DESC,dept.cc_code,a.department,a.other_install,b.advance_iou_ledger_id,b.emp_cc_code,
sum(a.other_install) as total_amt from salary_attendence a, personnel_basic_info b, department dept where a.PBI_ID = b.PBI_ID and mon='.$_POST['mon'].' and year='.$_POST['year'].'  and b.PBI_JOB_STATUS="In Service"   and a.department = dept.DEPT_ID and a.other_install > 0  GROUP BY a.PBI_ID';

$query14 = db_query($sqli11i);

   $date = $_POST['year'].'-'.$_POST['mon'].'-'.'30';
   $jv_date = strtotime($date);
   $narration_dr = 'Advance IOU Bill for the month of ' .$_POST['mon']. ' and year of ' .$_POST['year'];
   $narration_cr = 'Advance IOU Bill Payable for the month of ' .$_POST['mon']. ' and year of ' .$_POST['year'];
   $tr_from = 'advance_iou';
   $tr_no = date('Ym'.'01');
   $jv_no = next_journal_sec_voucher_id();
   $jv_no1 = next_journal_voucher_id();
  
	
	
while($dataa1i = mysqli_fetch_object($query14)){

	 $dep_cc_code = $dataa1i->emp_cc_code;
     $total_amt = $total_amt+ $dataa1i->total_amt;
	 $ledger_id_dr = 2063000200000000; 
     $ledger_id_cr = $dataa1i->advance_iou_ledger_id;
     $advance_amount = $dataa1i->other_install;

   add_to_sec_journal('Aksid', $jv_no, $jv_date, $ledger_id_dr, $narration_dr,$advance_amount,'0', $tr_from, $tr_no,0,0,$dep_cc_code,2);
   add_to_sec_journal('Aksid', $jv_no, $jv_date, $ledger_id_cr, $narration_cr, '0',$advance_amount,$tr_from, $tr_no,0,0,$dep_cc_code,2);
   
   //for advance sallary 
	add_to_journal('Aksid', $jv_no1, $jv_date, $ledger_id_dr, $narration_dr,$advance_amount,'0', $tr_from, $tr_no,0,0,$dep_cc_code);
    add_to_journal('Aksid', $jv_no1, $jv_date, $ledger_id_cr, $narration_cr, '0',$advance_amount, $tr_from, $tr_no,0,0,$dep_cc_code);
   
 }
   
   


   




}



// ================   ========`````````advance bill LOCK END  =================================





?>

<div class="right_col" role="main">
<!-- Must not delete it ,this is main design header-->
<div class="">
  <div class="clearfix"></div>
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Salary Lock</h2>
          <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
            <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="#">Settings 1</a> </li>
                <li><a href="#">Settings 2</a> </li>
              </ul>
            </li>
            <li><a class="close-link"><i class="fa fa-close"></i></a> </li>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="openerp openerp_webclient_container">
          <div class="x_content">
            <form action="" method="post">
              <div class="oe_view_manager oe_view_manager_current">
                <div class="oe_view_manager_body">
                  <div  class="oe_view_manager_view_list"></div>
                  <div class="oe_view_manager_view_form">
                    <div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">
                      <div class="oe_form_buttons"></div>
                      <div class="oe_form_sidebar"></div>
                      <div class="oe_form_pager"></div>
                      <div class="oe_form_container">
                        <div class="oe_form">
                          <div class="">
                            <div class="oe_form_sheetbg">
                              <div class="oe_form_sheet oe_form_sheet_width">
                                <div  class="oe_view_manager_view_list">
                                  <div  class="oe_list oe_view">
                                    <table width="100%" border="0" class="oe_list_content">
                                      <thead>
                                        <tr class="oe_list_header_columns">
                                          <th colspan="4"><span style="text-align: center; font-size:18px; color:#09F">Locking</span></th>
                                        </tr>
                                      </thead>
                                      <tfoot>
                                      </tfoot>
                                      <tbody>
                                        <tr>
                                          <td width="24%" align="right" class="alt"><strong>Month  : </strong></td>
                                          <td width="35%" align="left" class="alt"><strong>
                                            <select name="mon" style="width:160px;" id="mon" required="required">
                                              <option value="1" <?=($mon=='1')?'selected':''?>>Jan</option>
                                              <option value="2" <?=($mon=='2')?'selected':''?>>Feb</option>
                                              <option value="3" <?=($mon=='3')?'selected':''?>>Mar</option>
                                              <option value="4" <?=($mon=='4')?'selected':''?>>Apr</option>
                                              <option value="5" <?=($mon=='5')?'selected':''?>>May</option>
                                              <option value="6" <?=($mon=='6')?'selected':''?>>Jun</option>
                                              <option value="7" <?=($mon=='7')?'selected':''?>>Jul</option>
                                              <option value="8" <?=($mon=='8')?'selected':''?>>Aug</option>
                                              <option value="9" <?=($mon=='9')?'selected':''?>>Sep</option>
                                              <option value="10" <?=($mon=='10')?'selected':''?>>Oct</option>
                                              <option value="11" <?=($mon=='11')?'selected':''?>>Nov</option>
                                              <option value="12" <?=($mon=='12')?'selected':''?>>Dec</option>
                                            </select>
                                            </strong></td>
                                          <td width="29%" align="right" class="alt"><strong>Year </strong>: </td>
                                          <td width="12%"><select name="year" style="width:160px;" id="year" required="required">
                                              <option <?=($year=='2017')?'selected':''?>>2017</option>
                                              <option <?=($year=='2018')?'selected':''?>>2018</option>
                                              <option <?=($year=='2019')?'selected':''?>>2019</option>
                                              <option <?=($year=='2020')?'selected':''?>>2020</option>
                                              <option <?=($year=='2021')?'selected':''?>>2021</option>
                                              <option <?=($year=='2022')?'selected':''?>>2022</option>
                                              <option <?=($year=='2021')?'selected':''?>>2021</option>
                                              <option <?=($year=='2022')?'selected':''?>>2022</option>
                                              <option <?=($year=='2023')?'selected':''?>>2023</option>
                                              <option <?=($year=='2024')?'selected':''?>>2024</option>
                                              <option <?=($year=='2025')?'selected':''?>>2025</option>
                                              <option <?=($year=='2026')?'selected':''?>>2026</option>
                                              <option <?=($year=='2027')?'selected':''?>>2027</option>
                                              <option <?=($year=='2028')?'selected':''?>>2028</option>
                                              <option <?=($year=='2029')?'selected':''?>>2029</option>
                                              <option <?=($year=='2030')?'selected':''?>>2030</option>
                                            </select></td>
                                        </tr>
                                        <tr>
                                          <td align="right" class="alt"><strong>Lock Type </strong> :</td>
                                          <td align="left" class="alt"><select name="lock_type" style="width:160px;" id="lock_type">
                                              <option></option>
                                              <option value="2"  <?=($_POST['lock_type']=='2')?'selected':''?> >Mobile Bill</option>
                                              <option value="1" <?=($_POST['lock_type']=='1')?'selected':''?> >Salary</option>
                                              <option value="3"  <?=($_POST['lock_type']=='3')?'selected':''?> >Festival Bonus</option>
                                              <option value="4"  <?=($_POST['lock_type']=='4')?'selected':''?> >Food</option>
                                              <option value="5"  <?=($_POST['lock_type']=='5')?'selected':''?> >Tax</option>
											  <option value="6"  <?=($_POST['lock_type']=='6')?'selected':''?> >Advance Salary</option>
                                            </select></td>
                                          <td align="right"><strong>Bonus Type</strong></td>
                                          <td><span class="oe_form_group_cell">
                                            <select name="bonus_type" style="width:160px;" id="bonus_type">
                                              <option></option>
                                              <option value="1" <?=($_POST['bonus_type']=='1')?'selected':''?> >Eid-Ul-Fitre</option>
                                              <option value="2"  <?=($_POST['bonus_type']=='2')?'selected':''?> >Eid-Ul-Adha</option>
                                            </select>
                                            </span></td>
                                        </tr>
                                      </tbody>
                                    </table>
                                    <br />
                                    <div style="text-align:center">
                                      <input name="show" type="submit" id="show" value="SHOW" />
                                    </div>
                                    <?

    if(isset($_POST['show'])){

	

	$type = $_POST['lock_type'];

	

	if($type == 1){

  ?>
                                    <table width="100%" class="oe_list_content">
                                      <tr>
                                        <td colspan="6"><div align="center">Salary Lock</div></td>
                                      </tr>
                                      <?		

		

		

		  $sqli1 = 'select proj.PROJECT_DESC , sum(a.total_payable) as total_amt from salary_attendence a, personnel_basic_info b, project proj where a.PBI_ID = b.PBI_ID and mon='.$_POST['mon'].' and year='.$_POST['year'].' and b.PBI_JOB_STATUS="In Service" and a.lock_status=0 and  a.job_location = proj.PROJECT_ID and a.pay>0 GROUP BY proj.PROJECT_ID';

		$query1 = db_query($sqli1);$s = 1 ;

		



   while($info1 = mysqli_fetch_object($query1)){

   

?>
                                      <tr style="font-size:10px; padding:3px; ">
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td style="width:250px; font-size:16px;"><?=$info1->PROJECT_DESC?></td>
                                        <td style="width:100px"><input type="text" value="<?=$info1->total_amt?>" name="bonus_percent_<?=$info1->PBI_ID?>" id="bonus_percent_<?=$info1->PBI_ID?>" style="width:100px;"/>
                                          <input type="hidden" value="<?=$info1->basic_salary?>" name="basic_salary_<?=$info1->PBI_ID?>" id="basic_salary_<?=$info1->PBI_ID?>" />
                                          <input type="hidden" value="<?=$info1->PBI_ID?>" name="PBI_ID_<?=$info1->PBI_ID?>" id="PBI_ID_<?=$info1->PBI_ID?>" />
                                        </td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                      </tr>
                                      <? } 

		

		

		if($_POST['year']!='')	$con .= " and s.year = '".$_POST['year']."'";

		if($_POST['dept']!='')	$con .= " and s.department = '".$_POST['dept']."'";

		if($_POST['JOB_LOCATION']!='')  $con .= " and s.job_location = '".$_POST['JOB_LOCATION']."'";

		if($_POST['mon']!='')  $con .= " and s.mon = '".$_POST['mon']."'";

		

		 $sqli = 'select dept.DEPT_DESC, sum(a.total_payable) as total_amt from salary_attendence a, personnel_basic_info b, department dept where a.PBI_ID = b.PBI_ID and mon='.$_POST['mon'].' and year='.$_POST['year'].'  and b.PBI_JOB_STATUS="In Service" and a.lock_status=0  and a.department = dept.DEPT_ID and  a.pay>0 and dept.DEPT_ID not in (13)  GROUP BY dept.DEPT_ID  ';

		$query = db_query($sqli);$s = 1 ;

		



   while($info = mysqli_fetch_object($query)){

   

?>
                                      <tr style="font-size:10px; padding:3px; ">
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td style="width:250px; font-size:16px;"><?=$info->DEPT_DESC?></td>
                                        <td style="width:100px"><input type="text" value="<?=$info->total_amt?>" name="bonus_percent_<?=$info->PBI_ID?>" id="bonus_percent_<?=$info->PBI_ID?>" style="width:100px;"/>
                                          <input type="hidden" value="<?=$info->basic_salary?>" name="basic_salary_<?=$info->PBI_ID?>" id="basic_salary_<?=$info->PBI_ID?>" />
                                          <input type="hidden" value="<?=$info->PBI_ID?>" name="PBI_ID_<?=$info->PBI_ID?>" id="PBI_ID_<?=$info->PBI_ID?>" />
                                        </td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                      </tr>
                                      <? }  ?>
                                      <tr>
                                        <td colspan="6">&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <? $found = find_a_field('salary_attendence','lock_status','mon="'.$_POST['mon'].'" and year="'.$_POST['year'].'"');

		    if($found == 0){

		  ?>
                                        <td colspan="6"><div align="center">
                                            <input type="submit" name="lock" value="Lock" style="width:100px; height:30px" />
                                          </div></td>
                                        <? } else{?>
                                        <td colspan="6"><div align="center"><strong>Already Locked</strong></div></td>
                                        <? } ?>
                                      </tr>
                                    </table>
                                    <? }elseif($type == 2){ ?>
                                    <table width="100%" class="oe_list_content">
                                      <tr>
                                        <td colspan="6"><div align="center">Mobile Bill Lock</div></td>
                                      </tr>
                                      <?		

		

		

		  $sqli1 = 'select proj.PROJECT_DESC , sum(a.mobile_bill_amt) as total_amt from salary_attendence a, personnel_basic_info b, project proj where a.PBI_ID = b.PBI_ID and mon='.$_POST['mon'].' and year='.$_POST['year'].' and b.JOB_LOCATION = proj.PROJECT_ID and a.m_lock=0 and b.PBI_JOB_STATUS="In Service" GROUP BY proj.PROJECT_ID';

		$query1 = db_query($sqli1);$s = 1 ;

		



   while($info1 = mysqli_fetch_object($query1)){

   

?>
                                      <tr style="font-size:10px; padding:3px; ">
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td style="width:250px; font-size:16px;"><?=$info1->PROJECT_DESC?></td>
                                        <td style="width:100px"><input type="text" value="<?=$info1->total_amt?>" name="bonus_percent_<?=$info1->PBI_ID?>" id="bonus_percent_<?=$info1->PBI_ID?>" style="width:100px;"/>
                                          <input type="hidden" value="<?=$info1->basic_salary?>" name="basic_salary_<?=$info1->PBI_ID?>" id="basic_salary_<?=$info1->PBI_ID?>" />
                                          <input type="hidden" value="<?=$info1->PBI_ID?>" name="PBI_ID_<?=$info1->PBI_ID?>" id="PBI_ID_<?=$info1->PBI_ID?>" />
                                        </td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                      </tr>
                                      <? } 

		

		

		if($_POST['year']!='')	$con .= " and s.year = '".$_POST['year']."'";

		if($_POST['dept']!='')	$con .= " and s.department = '".$_POST['dept']."'";

		if($_POST['JOB_LOCATION']!='')  $con .= " and s.job_location = '".$_POST['JOB_LOCATION']."'";

		if($_POST['mon']!='')  $con .= " and s.mon = '".$_POST['mon']."'";

		

		 $sqli = 'select dept.DEPT_DESC, sum(a.mobile_bill_amt) as total_amt  from salary_attendence a, personnel_basic_info b, department dept where a.PBI_ID = b.PBI_ID and mon='.$_POST['mon'].' and year='.$_POST['year'].' and b.PBI_DEPARTMENT = dept.DEPT_ID and a.m_lock=0 and dept.DEPT_ID not in (13) and b.PBI_JOB_STATUS="In Service" GROUP BY dept.DEPT_ID  ';

		$query = db_query($sqli);$s = 1 ;

		



   while($info = mysqli_fetch_object($query)){

   

?>
                                      <tr style="font-size:10px; padding:3px; ">
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td style="width:250px; font-size:16px;"><?=$info->DEPT_DESC?></td>
                                        <td style="width:100px"><input type="text" value="<?=$info->total_amt?>" name="bonus_percent_<?=$info->PBI_ID?>" id="bonus_percent_<?=$info->PBI_ID?>" style="width:100px;"/>
                                          <input type="hidden" value="<?=$info->basic_salary?>" name="basic_salary_<?=$info->PBI_ID?>" id="basic_salary_<?=$info->PBI_ID?>" />
                                          <input type="hidden" value="<?=$info->PBI_ID?>" name="PBI_ID_<?=$info->PBI_ID?>" id="PBI_ID_<?=$info->PBI_ID?>" />
                                        </td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                      </tr>
                                      <? }  ?>
                                      <tr>
                                        <td colspan="6">&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <? $found = find_a_field('salary_attendence','m_lock','mon="'.$_POST['mon'].'" and year="'.$_POST['year'].'"');

		    if($found == 0){

		  ?>
                                        <td colspan="6"><div align="center">
                                            <input type="submit" name="m_lock" value="Lock" style="width:100px; height:30px" />
                                          </div></td>
                                        <? } else{?>
                                        <td colspan="6"><div align="center"><strong>Already Locked</strong></div></td>
                                        <? } ?>
                                      </tr>
                                    </table>
                                    <!--	START FOOD BILL  \-->
                                    <? }elseif($type == 4){ ?>
                                    <table width="100%" class="oe_list_content">
                                      <tr>
                                        <td colspan="6"><div align="center">FooD Bill Lock</div></td>
                                      </tr>
                                      <?		

		

		

		  $sqli1 = 'select proj.PROJECT_DESC , sum(a.food_deduction) as total_amt from salary_attendence a, personnel_basic_info b, project proj where a.PBI_ID = b.PBI_ID and mon='.$_POST['mon'].' and year='.$_POST['year'].' and b.JOB_LOCATION = proj.PROJECT_ID and a.f_lock=0 and b.PBI_JOB_STATUS="In Service" GROUP BY proj.PROJECT_ID';

		$query1 = db_query($sqli1);$s = 1 ;

		



   while($info1 = mysqli_fetch_object($query1)){

   

?>
                                      <tr style="font-size:10px; padding:3px; ">
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td style="width:250px; font-size:16px;"><?=$info1->PROJECT_DESC?></td>
                                        <td style="width:100px"><input type="text" value="<?=$info1->total_amt?>" name="bonus_percent_<?=$info1->PBI_ID?>" id="bonus_percent_<?=$info1->PBI_ID?>" style="width:100px;"/>
                                          <input type="hidden" value="<?=$info1->basic_salary?>" name="basic_salary_<?=$info1->PBI_ID?>" id="basic_salary_<?=$info1->PBI_ID?>" />
                                          <input type="hidden" value="<?=$info1->PBI_ID?>" name="PBI_ID_<?=$info1->PBI_ID?>" id="PBI_ID_<?=$info1->PBI_ID?>" />
                                        </td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                      </tr>
                                      <? } 

		

		

		if($_POST['year']!='')	$con .= " and s.year = '".$_POST['year']."'";

		if($_POST['dept']!='')	$con .= " and s.department = '".$_POST['dept']."'";

		if($_POST['JOB_LOCATION']!='')  $con .= " and s.job_location = '".$_POST['JOB_LOCATION']."'";

		if($_POST['mon']!='')  $con .= " and s.mon = '".$_POST['mon']."'";

		

		 $sqli = 'select dept.DEPT_DESC, sum(a.food_deduction) as total_amt  from salary_attendence a, personnel_basic_info b, department dept where a.PBI_ID = b.PBI_ID and mon='.$_POST['mon'].' and year='.$_POST['year'].' and b.PBI_DEPARTMENT = dept.DEPT_ID and a.f_lock=0 and dept.DEPT_ID not in (13) and b.PBI_JOB_STATUS="In Service" GROUP BY dept.DEPT_ID  ';

		$query = db_query($sqli);$s = 1 ;

		



   while($info = mysqli_fetch_object($query)){

   

?>
                                      <tr style="font-size:10px; padding:3px; ">
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td style="width:250px; font-size:16px;"><?=$info->DEPT_DESC?></td>
                                        <td style="width:100px"><input type="text" value="<?=$info->total_amt?>" name="bonus_percent_<?=$info->PBI_ID?>" id="bonus_percent_<?=$info->PBI_ID?>" style="width:100px;"/>
                                          <input type="hidden" value="<?=$info->basic_salary?>" name="basic_salary_<?=$info->PBI_ID?>" id="basic_salary_<?=$info->PBI_ID?>" />
                                          <input type="hidden" value="<?=$info->PBI_ID?>" name="PBI_ID_<?=$info->PBI_ID?>" id="PBI_ID_<?=$info->PBI_ID?>" />
                                        </td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                      </tr>
                                      <? }  ?>
                                      <tr>
                                        <td colspan="6">&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <? $found = find_a_field('salary_attendence','f_lock','mon="'.$_POST['mon'].'" and year="'.$_POST['year'].'"');

		    if($found == 0){

		  ?>
                                        <td colspan="6"><div align="center">
                                            <input type="submit" name="f_lock" value="Lock" style="width:100px; height:30px" />
                                          </div></td>
                                        <? } else{?>
                                        <td colspan="6"><div align="center"><strong>Already Locked</strong></div></td>
                                        <? } ?>
                                      </tr>
                                    </table>
                                    <!-- END FOOD-->
                                    <!--	START tax BILL  \-->
                                    <? }elseif($type == 5){ ?>
                                    <table width="100%" class="oe_list_content">
                                      <tr>
                                        <td colspan="6"><div align="center">Tax Bill Lock</div></td>
                                      </tr>
                                      <?		

		

		

		  $sqli1 = 'select proj.PROJECT_DESC , sum(a.income_tax) as total_amt from salary_attendence a, personnel_basic_info b, project proj where a.PBI_ID = b.PBI_ID and mon='.$_POST['mon'].' and year='.$_POST['year'].' and b.JOB_LOCATION = proj.PROJECT_ID and a.t_lock=0 and b.PBI_JOB_STATUS="In Service" GROUP BY proj.PROJECT_ID';

		$query1 = db_query($sqli1);$s = 1 ;

		



   while($info1 = mysqli_fetch_object($query1)){

   

?>
                                      <tr style="font-size:10px; padding:3px; ">
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td style="width:250px; font-size:16px;"><?=$info1->PROJECT_DESC?></td>
                                        <td style="width:100px"><input type="text" value="<?=$info1->total_amt?>" name="bonus_percent_<?=$info1->PBI_ID?>" id="bonus_percent_<?=$info1->PBI_ID?>" style="width:100px;"/>
                                          <input type="hidden" value="<?=$info1->basic_salary?>" name="basic_salary_<?=$info1->PBI_ID?>" id="basic_salary_<?=$info1->PBI_ID?>" />
                                          <input type="hidden" value="<?=$info1->PBI_ID?>" name="PBI_ID_<?=$info1->PBI_ID?>" id="PBI_ID_<?=$info1->PBI_ID?>" />
                                        </td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                      </tr>
                                      <? } 

		

		

		if($_POST['year']!='')	$con .= " and s.year = '".$_POST['year']."'";

		if($_POST['dept']!='')	$con .= " and s.department = '".$_POST['dept']."'";

		if($_POST['JOB_LOCATION']!='')  $con .= " and s.job_location = '".$_POST['JOB_LOCATION']."'";

		if($_POST['mon']!='')  $con .= " and s.mon = '".$_POST['mon']."'";

		

		 $sqli = 'select dept.DEPT_DESC, sum(a.income_tax) as total_amt  from salary_attendence a, personnel_basic_info b, department dept where a.PBI_ID = b.PBI_ID and mon='.$_POST['mon'].' and year='.$_POST['year'].' and b.PBI_DEPARTMENT = dept.DEPT_ID and a.t_lock=0 and dept.DEPT_ID not in (13) and b.PBI_JOB_STATUS="In Service" GROUP BY dept.DEPT_ID  ';

		$query = db_query($sqli);$s = 1 ;

		



   while($info = mysqli_fetch_object($query)){

   

?>
                                      <tr style="font-size:10px; padding:3px; ">
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td style="width:250px; font-size:16px;"><?=$info->DEPT_DESC?></td>
                                        <td style="width:100px"><input type="text" value="<?=$info->total_amt?>" name="bonus_percent_<?=$info->PBI_ID?>" id="bonus_percent_<?=$info->PBI_ID?>" style="width:100px;"/>
                                          <input type="hidden" value="<?=$info->basic_salary?>" name="basic_salary_<?=$info->PBI_ID?>" id="basic_salary_<?=$info->PBI_ID?>" />
                                          <input type="hidden" value="<?=$info->PBI_ID?>" name="PBI_ID_<?=$info->PBI_ID?>" id="PBI_ID_<?=$info->PBI_ID?>" />
                                        </td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                      </tr>
                                      <? }  ?>
                                      <tr>
                                        <td colspan="6">&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <? $found = find_a_field('salary_attendence','t_lock','mon="'.$_POST['mon'].'" and year="'.$_POST['year'].'"');

		    if($found == 0){

		  ?>
                                        <td colspan="6"><div align="center">
                                            <input type="submit" name="t_lock" value="Lock" style="width:100px; height:30px" />
                                          </div></td>
                                        <? } else{?>
                                        <td colspan="6"><div align="center"><strong>Already Locked</strong></div></td>
                                        <? } ?>
                                      </tr>
                                    </table>
                                    <!-- END tax lok-->
									
									
									
									
									
									
									 <!--	START advance BILL  \-->
                                    <? }elseif($type == 6){ ?>
                                    <table width="100%" class="oe_list_content">
                                      <tr>
                                        <td colspan="6"><div align="center">Advance Bill Lock</div></td>
                                      </tr>
                                      <?		

		

		

		  $sqli1 = 'select proj.PROJECT_DESC , sum(a.advance_install) as total_amt from salary_attendence a, personnel_basic_info b, project proj where a.PBI_ID = b.PBI_ID and mon='.$_POST['mon'].' and year='.$_POST['year'].' and b.JOB_LOCATION = proj.PROJECT_ID and a.ad_lock=0 and b.PBI_JOB_STATUS="In Service" GROUP BY proj.PROJECT_ID';

		$query1 = db_query($sqli1);$s = 1 ;

		



   while($info1 = mysqli_fetch_object($query1)){

   

?>
                                      <tr style="font-size:10px; padding:3px; ">
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td style="width:250px; font-size:16px;"><?=$info1->PROJECT_DESC?></td>
                                        <td style="width:100px"><input type="text" value="<?=$info1->total_amt?>" name="bonus_percent_<?=$info1->PBI_ID?>" id="bonus_percent_<?=$info1->PBI_ID?>" style="width:100px;"/>
                                          <input type="hidden" value="<?=$info1->basic_salary?>" name="basic_salary_<?=$info1->PBI_ID?>" id="basic_salary_<?=$info1->PBI_ID?>" />
                                          <input type="hidden" value="<?=$info1->PBI_ID?>" name="PBI_ID_<?=$info1->PBI_ID?>" id="PBI_ID_<?=$info1->PBI_ID?>" />
                                        </td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                      </tr>
                                      <? } 

		

		

		if($_POST['year']!='')	$con .= " and s.year = '".$_POST['year']."'";

		if($_POST['dept']!='')	$con .= " and s.department = '".$_POST['dept']."'";

		if($_POST['JOB_LOCATION']!='')  $con .= " and s.job_location = '".$_POST['JOB_LOCATION']."'";

		if($_POST['mon']!='')  $con .= " and s.mon = '".$_POST['mon']."'";

		

		 $sqli = 'select dept.DEPT_DESC, sum(a.advance_install+a.other_install) as total_amt  from salary_attendence a, personnel_basic_info b, department dept where a.PBI_ID = b.PBI_ID and mon='.$_POST['mon'].' and year='.$_POST['year'].' and b.PBI_DEPARTMENT = dept.DEPT_ID and a.ad_lock=0  and b.PBI_JOB_STATUS="In Service" GROUP BY dept.DEPT_ID  ';

		$query = db_query($sqli);$s = 1 ;

		



   while($info = mysqli_fetch_object($query)){

   

?>
                                      <tr style="font-size:10px; padding:3px; ">
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td style="width:250px; font-size:16px;"><?=$info->DEPT_DESC?></td>
                                        <td style="width:100px"><input type="text" value="<?=$info->total_amt?>" name="bonus_percent_<?=$info->PBI_ID?>" id="bonus_percent_<?=$info->PBI_ID?>" style="width:100px;"/>
                                          <input type="hidden" value="<?=$info->basic_salary?>" name="basic_salary_<?=$info->PBI_ID?>" id="basic_salary_<?=$info->PBI_ID?>" />
                                          <input type="hidden" value="<?=$info->PBI_ID?>" name="PBI_ID_<?=$info->PBI_ID?>" id="PBI_ID_<?=$info->PBI_ID?>" />
                                        </td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                      </tr>
                                      <? }  ?>
                                      <tr>
                                        <td colspan="6">&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <? $found = find_a_field('salary_attendence','ad_lock','mon="'.$_POST['mon'].'" and year="'.$_POST['year'].'"');

		    if($found == 0){

		  ?>
                                        <td colspan="6"><div align="center">
                                            <input type="submit" name="ad_lock" value="Lock" style="width:100px; height:30px" />
                                          </div></td>
                                        <? } else{?>
                                        <td colspan="6"><div align="center"><strong>Already Locked</strong></div></td>
                                        <? } ?>
                                      </tr>
                                    </table>
                                    <!-- END advance lok-->
									
									
									
									
									
									
                                    <? } else{?>
                                    <table width="100%" class="oe_list_content">
                                      <tr>
                                        <td colspan="6"><div align="center">Bonus Lock</div></td>
                                      </tr>
                                      <?		

		

		

		  $sqli1 = 'select proj.PROJECT_DESC , sum(a.bonus_amt) as total_amt from salary_bonus a, personnel_basic_info b, project proj where a.PBI_ID = b.PBI_ID and bonus_type='.$_POST['bonus_type'].' and year='.$_POST['year'].' and b.PBI_JOB_STATUS="In Service" and a.lock_status=0 and a.pbi_job_location = proj.PROJECT_ID  GROUP BY proj.PROJECT_ID';

		$query1 = db_query($sqli1);$s = 1 ;

		



   while($info1 = mysqli_fetch_object($query1)){

   

?>
                                      <tr style="font-size:10px; padding:3px; ">
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td style="width:250px; font-size:16px;"><?=$info1->PROJECT_DESC?></td>
                                        <td style="width:100px"><input type="text" value="<?=$info1->total_amt?>" name="bonus_percent_<?=$info1->PBI_ID?>" id="bonus_percent_<?=$info1->PBI_ID?>" style="width:100px;"/>
                                          <input type="hidden" value="<?=$info1->basic_salary?>" name="basic_salary_<?=$info1->PBI_ID?>" id="basic_salary_<?=$info1->PBI_ID?>" />
                                          <input type="hidden" value="<?=$info1->PBI_ID?>" name="PBI_ID_<?=$info1->PBI_ID?>" id="PBI_ID_<?=$info1->PBI_ID?>" />
                                        </td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                      </tr>
                                      <? } 

		

		

		if($_POST['year']!='')	$con .= " and s.year = '".$_POST['year']."'";

		

		

		if($_POST['mon']!='')  $con .= " and s.mon = '".$_POST['mon']."'";

		

		 $sqli = 'select dept.DEPT_DESC, sum(a.bonus_amt) as total_amt from salary_bonus a, personnel_basic_info b, department dept where a.PBI_ID = b.PBI_ID and bonus_type='.$_POST['bonus_type'].' and year='.$_POST['year'].' and b.PBI_JOB_STATUS="In Service" and a.lock_status=0 and a.pbi_department = dept.DEPT_ID  and dept.DEPT_ID not in (13)  GROUP BY dept.DEPT_ID  ';

		$query = db_query($sqli);$s = 1 ;

		



   while($info = mysqli_fetch_object($query)){

   

?>
                                      <tr style="font-size:10px; padding:3px; ">
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td style="width:250px; font-size:16px;"><?=$info->DEPT_DESC?></td>
                                        <td style="width:100px"><input type="text" value="<?=$info->total_amt?>" name="bonus_percent_<?=$info->PBI_ID?>" id="bonus_percent_<?=$info->PBI_ID?>" style="width:100px;"/>
                                          <input type="hidden" value="<?=$info->basic_salary?>" name="basic_salary_<?=$info->PBI_ID?>" id="basic_salary_<?=$info->PBI_ID?>" />
                                          <input type="hidden" value="<?=$info->PBI_ID?>" name="PBI_ID_<?=$info->PBI_ID?>" id="PBI_ID_<?=$info->PBI_ID?>" />
                                        </td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                      </tr>
                                      <? }  ?>
                                      <tr>
                                        <td colspan="6">&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <? $found = find_a_field('salary_bonus','lock_status','bonus_type="'.$_POST['bonus_type'].'" and year="'.$_POST['year'].'"');

		    if($found == 0){

		  ?>
                                        <td colspan="6"><div align="center">
                                            <input type="submit" name="b_lock" value="Lock" style="width:100px; height:30px" />
                                          </div></td>
                                        <? } else{?>
                                        <td colspan="6"><div align="center"><strong>Already Locked</strong></div></td>
                                        <? } ?>
                                      </tr>
                                    </table>
                                    <? } } ?>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="oe_chatter" style="padding:0px;">
                              <div class="oe_followers oe_form_invisible">
                                <div class="oe_follower_list"></div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /page content -->
<?

$main_content=ob_get_contents();

ob_end_clean();

require_once SERVER_CORE."routing/layout.bottom.php";

include_once("../../template/footer.php");

?>
