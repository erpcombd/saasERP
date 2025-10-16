<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE ."core/init.php";
require_once SERVER_CORE."routing/layout.top.php";
$title="Auto Payroll";


do_calander("#m_date");


$head = '<link href="../../css/report_selection.css" type="text/css" rel="stylesheet"/>';

//$table = "hrm_inout";
//$unique = "id";
//$fix_intime = "05:00:00";

//$fix_outtime = "11:59:00";


if (isset($_POST["upload"])) {

$year_mon = $_POST['salary_month'];

$data =explode("-",$_POST['salary_month']);

$year =$data[0];

$mon = $data[1];

$mon_type = find_a_field('salary_months','month_type','salary_month="'.$_POST['salary_month'].'"');

$mon_date = find_all_field('month_type','','1 and id='.$mon_type);


$firstDay = date('Y-m-01', strtotime($_POST['salary_month']));
$lastDay = date('Y-m-t', strtotime($_POST['salary_month']));
$total_days_dynamic = (strtotime($lastDay) - strtotime($firstDay)) / (60 * 60 * 24) + 1;



if($mon_type==1){

	$start_mon =date('m', strtotime(date(''.$year.'-'.$mon.'')." -1 month"));

	$start_year =date('Y', strtotime(date(''.$year.'-'.$mon.'')." -1 month"));

	

	$start_date = $start_year."-".$start_mon."-".$mon_date->month_start;

	$end_date  = $year."-".$mon."-".$mon_date->month_end;

}

else{



	$start_date = $year."-".$mon."-".$mon_date->month_start;

	$end_date  = $year."-".$mon."-".$total_days_dynamic;



}







if($_POST['emp_id']>0)
$emp_id = $_POST['emp_id'];

if($emp_id>0)    $emp_con = " and p.PBI_ID='".$emp_id."'";

//$emp_id = find_a_field('personnel_basic_info','PBI_ID','PBI_CODE="'.$_POST['emp_id'].'"');
//$PBI_ORG = $_POST["PBI_ORG"];

if($_POST['JOB_LOCATION']>0) $job_location_con = " and p.JOB_LOC_ID='".$_POST['JOB_LOCATION']."'";

$datetime = date("Y-m-d H:i:s");
$startTime = $days1 = strtotime($start_date);
$days_in_month = date('t',$startTime);
$days_mon = date("t", $startTime);
$endTime = $days2 = mktime(23, 59, 59, $mon, $days_in_month, $year);

$m_s_date = $year . "-" . $mon . "-01";
$m_e_date = $year . "-" . $mon . "-" . $days_mon;


  $sql ="SELECT h.*,p.DESG_ID,p.DEPT_ID,p.PBI_ORG,p.JOB_LOC_ID,p.class,p.PBI_JOB_STATUS,p.cost_center,p.section
 
 
FROM `hrm_attendence_final` h, personnel_basic_info p 
 
 WHERE p.PBI_ID=h.PBI_ID and h.mon='" .$mon ."' and 
 h.year='" .$year ."' " .$emp_con .$ORG_con .$job_location_con.

"  group by h.PBI_ID";

$query = db_query($sql);

while ($data = mysqli_fetch_object($query)) {
$pi++;



$salary = find_all_field('salary_info','','PBI_ID="'.$data->PBI_ID.'"');




//___________Attendance__________	
$values[$pi]["PBI_ID"] = $data->PBI_ID;
$values[$pi]['designation'] = $data->DESG_ID;
$values[$pi]['department'] = $data->DEPT_ID;
$values[$pi]['job_location'] = $data->JOB_LOC_ID;
$values[$pi]['pbi_organization'] = $data->PBI_ORG;
$values[$pi]['hrm_class'] = $data->class;
$values[$pi]['PBI_JOB_STATUS'] = $data->PBI_JOB_STATUS;
$values[$pi]['cost_center'] = $data->cost_center;
$values[$pi]['section'] = $data->section;
$values[$pi]['mtd'] = $days_in_month;




$values[$pi]["td"] = $data->td;
$values[$pi]['od'] = $data->od;
$values[$pi]["hd"] = $data->hd;
$values[$pi]['lt'] = $data->lt;
$values[$pi]['eo'] = $data->eo;
$values[$pi]["ab"] = $data->ab;
$values[$pi]['lwp'] = $data->lwp;
$values[$pi]["lv"] = $data->lv;
$values[$pi]['pre'] = $data->pre;
$values[$pi]["pay"] = $data->pay;
$values[$pi]["ot"] = $data->ot;
$values[$pi]["total_late_min"] = $data->total_late_min;
//___________Salary Information__________
$values[$pi]["gross_salary"] = $salary->gross_salary;
$values[$pi]['basic_salary'] = $salary->basic_salary;
$values[$pi]["house_rent"] = $salary->house_rent;
$values[$pi]['medical_allowance'] = $salary->medical_allowance;
$values[$pi]["convenience"] = $salary->convenience;
$values[$pi]["food_allowance"] = $salary->food_allowance;
$values[$pi]["ta_da_data"] = $salary->ta;
$values[$pi]["special_allowance"] = $salary->special_allowance;
$values[$pi]['mobile_allowance'] = $salary->mobile_allowance;
$values[$pi]["bank_or_cash"] = $salary->cash_bank;
$values[$pi]["over_time_amount"] = round(((($salary->basic_salary)/104)*($data->ot)));

//________ ATTENDANCE BONUS FOR WORKER _____
if($data->class==3 && $data->ab==0 && $data->lwp==0 && $data->td==$days_mon){
	 if($data->lt+$data->eo ==0){
	   $values[$pi]['attendence_bonus'] = 500;
	  }elseif($data->lt+$data->eo == 1){
	    $values[$pi]['attendence_bonus'] = 350;
	  }elseif($data->lt+$data->eo == 2){
	    $values[$pi]['attendence_bonus'] = 250;
	  }else{
	    $values[$pi]['attendence_bonus'] = 0;
	  }
}else{
$values[$pi]['attendence_bonus'] = 0;
}

//________ Late Min Deduction  _____

if($data->total_late_min>0){
$late_min_deduction = round(((($salary->basic_salary)/(14400))*($data->total_late_min)));
}else{
$late_min_deduction  = 0;
}

$values[$pi]['late_min_deduction'] = $late_min_deduction;

//$values[$pi]['attendence_bonus'] = $attendence_bonus;
//________DEDUCTIONS_________
$values[$pi]['income_tax'] = $salary->income_tax;
$values[$pi]["pf"] = $salary->pf;
$values[$pi]["cpf"] = $salary->pf_company;

//_______ JOINING DEDUCTION _____
$joining_data = find_all_field_sql("SELECT PBI_ID, PBI_DOJ FROM personnel_basic_info WHERE PBI_ID='".$data->PBI_ID."' and PBI_DOJ BETWEEN '".$start_date."' AND '".$end_date."' ");
if ($joining_data->PBI_ID>0) {
$joining_date = strtotime($joining_data->PBI_DOJ);
$month_first_date = strtotime($start_date);
$datediff = $joining_date - $month_first_date;
$joining_ab_days =  round($datediff / (60 * 60 * 24));
$values[$pi]["joining_deduction"] = ((($salary->gross_salary)/($days_mon))*($joining_ab_days));

}

//_______ END JOINING DEDUCTION _____

 $resign_date  = find_all_field_sql("SELECT PBI_ID, resign_date FROM personnel_basic_info 
WHERE PBI_ID='".$data->PBI_ID."' and resign_date BETWEEN '".$start_date."' AND '".$end_date."' ");
if ($resign_date->PBI_ID>0) {

$resign_days = $days_mon -$data->td;
if($resign_days>0){

$resign_date_data = strtotime($resign_date->resign_date);
$month_last_date = strtotime($end_date);

$datediff = $month_last_date - $resign_date_data;
$resign_ab_days =  round($datediff / (60 * 60 * 24));

$values[$pi]["resign_deduction"] = ((($salary->gross_salary)/($days_mon))*($resign_ab_days));
}
 
 }



//____________LATE __________
$late_deduct_day = ((int) $data->lt /3);
$late_deduct_days = floor($late_deduct_day);
$values[$pi]["absent_deduction"] = round(((($salary->basic_salary)/(30))*(($data->lwp+$data->ab))));
$values[$pi]["administrative_deduction"]= find_a_field('hrm_admin_action_detail','sum(ADMIN_ACTION_AMT)','ADMIN_ACTION_DATE between "'.$start_date.'" and "'.$end_date.'" and PBI_ID="'.$data->PBI_ID.'" ');

//________ ADVANCE ______
$values[$pi]["advance_install"] = find_a_field('salary_advance','sum(payable_amt)','PBI_ID="'.$data->PBI_ID.'" and current_mon="'.$mon.'" and  	current_year="'.$year.'" and  	
 advance_type="Advance Cash" ');

$values[$pi]["motorcycle_install"] = find_a_field('motorcycle_install','sum(payable_amt)','PBI_ID="'.$data->PBI_ID.'" and current_mon="'.$mon.'" and  	current_year="'.$year.'" and  	
advance_type="Advance Cash" ');

$values[$pi]["adjustment_amount"] = find_a_field('salary_adjustment','sum(adjustment_amt)','PBI_ID="'.$data->PBI_ID.'" and adjustment_date between "'.$start_date.'" and "'.$end_date.'"');

//_______SALARY______



$values[$pi]["total_salary"] = $salary->gross_salary;



$total_deduction_befor_stamp = $values[$pi]["advance_install"]+$values[$pi]["other_install"]+$values[$pi]['income_tax']+
$values[$pi]["late_deduction"]+$values[$pi]["absent_deduction"]+$values[$pi]["pf"]+$values[$pi]['late_min_deduction']+
$values[$pi]["joining_deduction"]+$values[$pi]["resign_deduction"];


$values[$pi]["total_benefits"] = $values[$pi]["over_time_amount"]+$values[$pi]['attendence_bonus'];

$values[$pi]["total_earning"] = round((($salary->gross_salary) - $values[$pi]["absent_deduction"]-$values[$pi]['late_min_deduction']-
$values[$pi]["joining_deduction"]-$values[$pi]["resign_deduction"]))+$values[$pi]["total_benefits"]+$values[$pi]["adjustment_amount"];




$payable_before_stamp = round((($salary->gross_salary) - $total_deduction_befor_stamp))+$values[$pi]["total_benefits"]+$values[$pi]["adjustment_amount"];

if ($data->class==3) {

if($payable_before_stamp>1000 && $payable_before_stamp<50000){
$values[$pi]["stamp_deduction"] = 20;
}elseif($payable_before_stamp>50000){
$values[$pi]["stamp_deduction"] = 50;
}else{
$values[$pi]["stamp_deduction"] = 0;
}

}else{

$values[$pi]["stamp_deduction"] = 0;

}






$values[$pi]["total_deduction"]  = ($total_deduction_befor_stamp+$values[$pi]["stamp_deduction"]);

$values[$pi]["total_payable"]  = round((($salary->gross_salary) - $values[$pi]["total_deduction"]))+$values[$pi]["total_benefits"]+$values[$pi]["adjustment_amount"];

//__________CASH BANK SALARY _________

if($salary->cash_bank=="Both"){
$values[$pi]["cash_amt"] = $salary->cash_amt;
$values[$pi]["bank_amt"] = $salary->bank_amt-$values[$pi]["total_deduction"];
}elseif($salary->cash_bank=="Bank"){
$values[$pi]["cash_amt"]=0;
$values[$pi]["bank_amt"] = $values[$pi]["total_payable"];
}elseif($salary->cash_bank=="Cash"){
$values[$pi]["bank_amt"] = 0;
$values[$pi]["cash_amt"] = $values[$pi]["total_payable"];
}else{
$values[$pi]["bank_amt"] = 0;
$values[$pi]["cash_amt"]  = 0;
}


$pf_date   = $year.'-'.($mon).'-'.$days_mon;


}





//***************** INSERT & UPDATE DATA *******************////////

for ($y = 1; $y <= $pi; $y++) {
$found = find_a_field("salary_attendence","1",'PBI_ID="' .$values[$y]["PBI_ID"] .'" and mon="' .$mon .'" and year="' .$year .'"');

if ($found == 0) {

  $sql ="INSERT INTO `salary_attendence` 

(`mon`, `year`, `PBI_ID`, designation,department,job_location,hrm_class,section,cost_center,mtd,  
`td`, `od`, `hd`, `lt`,`eo`,`ab`, `lv`,`lwp`, `pre`, `pay`,`ot`, `entry_at`, `entry_by`,
gross_salary,basic_salary,house_rent,medical_allowance,convenience,food_allowance,ta_da_data,`special_allowance`,  
mobile_allowance,income_tax,bank_or_cash,pf,pbi_organization,
over_time_amount,absent_deduction,joining_deduction,late_deduction,advance_install,other_install,total_deduction,total_salary,
cash_amt,bank_amt,total_payable,total_late_min,attendence_bonus,late_min_deduction,total_earning,stamp_deduction,resign_deduction,
PBI_JOB_STATUS,adjustment_amount, hr_action_amt


) 

values ('" .$mon."','".$year."','" .$values[$y]["PBI_ID"] ."','" .$values[$y]["designation"] ."','" .$values[$y]["department"] ."',
'" .$values[$y]["job_location"]."','" .$values[$y]["hrm_class"] ."','" .$values[$y]["section"] ."' , '" .$values[$y]["cost_center"] ."' ,
'" .$values[$y]["mtd"] ."',
'" .$values[$y]["td"] ."',
'" .$values[$y]["od"] ."', 
'" .$values[$y]["hd"] ."','" .$values[$y]["lt"] ."', '" .$values[$y]["eo"] ."' ,'" .$values[$y]["ab"] ."','" .$values[$y]["lv"] ."','" .$values[$y]["lwp"] ."',
'" .$values[$y]["pre"] ."','" .$values[$y]["pay"] ."','" .$values[$y]["ot"] ."','" .date("Y-m-d H:i:s")."', '".$_SESSION["user"]["id"]."',
'" .$values[$y]["gross_salary"] ."','" .$values[$y]["basic_salary"] ."','" .$values[$y]["house_rent"] ."',
'" .$values[$y]["medical_allowance"] ."','" .$values[$y]["convenience"] ."','" .$values[$y]["food_allowance"] ."',
'" .$values[$y]["ta_da_data"] ."',  '" .$values[$y]["special_allowance"] ."' ,
'" .$values[$y]["mobile_allowance"] ."','" .$values[$y]["income_tax"] ."','" .$values[$y]["bank_or_cash"] ."','" .$values[$y]["pf"] ."','" .$values[$y]["pbi_organization"] ."',

'" .$values[$y]["over_time_amount"] ."','" .$values[$y]["absent_deduction"] ."','" .$values[$y]["joining_deduction"] ."','" .$values[$y]["late_deduction"] ."','" .$values[$y]["advance_install"] ."',
'" .$values[$y]["other_install"] ."','" .$values[$y]["total_deduction"] ."','" .$values[$y]["total_salary"] ."','" .$values[$y]["cash_amt"]."','" .$values[$y]["bank_amt"] ."',
'" .$values[$y]["total_payable"] ."', '" .$values[$y]["total_late_min"] ."' , '" .$values[$y]["attendence_bonus"] ."' , 
'" .$values[$y]["late_min_deduction"] ."' , '" .$values[$y]["total_earning"] ."' , '" .$values[$y]["stamp_deduction"] ."',
 '" .$values[$y]["resign_deduction"] ."', '" .$values[$y]["PBI_JOB_STATUS"] ."' , '" .$values[$y]["adjustment_amount"] ."' ,
'" .$values[$y]["administrative_deduction"] ."')";

db_query($sql);

//______________ FOR PROVIDENT FUND  INSERET_______/////
if($values[$y]["pf"]>0){
$pf_insert="INSERT INTO provident_fund (PBI_ID,year,mon,pf_amount,date,entry_by) 
VALUES ('".$values[$y]["PBI_ID"]."','".$year."', '".$mon."', '".$values[$y]["pf"]."','".$start_date."','".$_SESSION["user"]["id"]."' ) ";
$pf_query=db_query($pf_insert);


}


} else {

  $sql = "Update `salary_attendence` set td='" .$values[$y]["td"] ."',  mtd='" .$values[$y]["mtd"] ."' , od='" .$values[$y]["od"] ."',hd='" .$values[$y]["hd"] ."',
   lt='" .$values[$y]["lt"] ."',  eo='" .$values[$y]["eo"] ."',ab='" .$values[$y]["ab"] ."',
lv='" .$values[$y]["lv"] ."',lwp='" .$values[$y]["lwp"] ."',pre='" .$values[$y]["pre"] ."',pay='" .$values[$y]["pay"] ."',

gross_salary='" .$values[$y]["gross_salary"] ."', basic_salary='" .$values[$y]["basic_salary"] ."', 
house_rent='" .$values[$y]["house_rent"] ."' ,
convenience='" .$values[$y]["convenience"] ."', 
food_allowance='" .$values[$y]["food_allowance"] ."',

medical_allowance='" .$values[$y]["medical_allowance"] ."',

special_allowance='" .$values[$y]["special_allowance"] ."',

bank_or_cash='" .$values[$y]["bank_or_cash"] ."', pf='" .$values[$y]["pf"] ."', 
pbi_organization='" .$values[$y]["pbi_organization"] ."' , 

job_location='" .$values[$y]["job_location"] ."' , 
hrm_class='" .$values[$y]["hrm_class"] ."' , 
cost_center='" .$values[$y]["cost_center"] ."' , 
section='" .$values[$y]["section"] ."' , 



over_time_amount='" .$values[$y]["over_time_amount"] ."',

absent_deduction='" .$values[$y]["absent_deduction"] ."',joining_deduction='" .$values[$y]["joining_deduction"] ."',late_deduction='" .$values[$y]["late_deduction"] ."',

advance_install='" .$values[$y]["advance_install"] ."',other_install='" .$values[$y]["other_install"] ."',total_deduction='" .$values[$y]["total_deduction"] ."',

total_salary='" .$values[$y]["total_salary"] ."',cash_amt='" .$values[$y]["cash_amt"] ."',bank_amt='" .$values[$y]["bank_amt"] ."',

total_payable='" .$values[$y]["total_payable"] ."',hr_action_amt='" .$values[$y]["administrative_deduction"] ."', ot='" .$values[$y]["ot"] ."',
total_late_min='" .$values[$y]["total_late_min"] ."',  attendence_bonus = '" .$values[$y]["attendence_bonus"] ."' ,

late_min_deduction = '" .$values[$y]["late_min_deduction"] ."' , total_earning = '" .$values[$y]["total_earning"] ."' ,
resign_deduction = '" .$values[$y]["resign_deduction"] ."', stamp_deduction = '" .$values[$y]["stamp_deduction"] ."',
PBI_JOB_STATUS = '" .$values[$y]["PBI_JOB_STATUS"] ."', adjustment_amount = '" .$values[$y]["adjustment_amount"] ."',
entry_at='" .date("Y-m-d H:i:s") ."',
entry_by='" .$_SESSION["user"]["id"] ."' where mon='" .$mon ."' and year='" .$year ."' and PBI_ID='" .$values[$y]["PBI_ID"] ."'";

db_query($sql);

//______________ FOR PROVIDENT FUND  UPDATE ________/////
$pf_update = "UPDATE provident_fund SET year='".$year."',mon='".$mon."',pf_amount='".$values[$y]["pf"]."',date='".$start_date."',entry_by='".$_SESSION["user"]["id"]."' 
WHERE mon='".$mon."' and PBI_ID='".$values[$y]["PBI_ID"]."' and year='".$year."'";
$pf_update_query=db_query($pf_update);





}


//______________ FOR PROVIDENT FUND  INSERET_______/////

if($values[$y]["pf"]>0){


//pf_loan
$actual_pf_loan = find_a_field('pf_loan_details','sum(monthly_payable_without_interest)','PBI_ID="'.$values[$y]["PBI_ID"].'" and current_mon="'.$mon.'" and current_year="'.$year.'" and advance_type="pf_loan" and status="unpaid"');

$jv_date = date('Y-m-d');
if($actual_pf_loan>0){
db_query('delete from salary_pl_journal where tr_from="pf_loan_adjustment" and year="'.$year.'" and month="'.$mon.'" and PBI_ID="'.$values[$y]["PBI_ID"].'"');
echo $pf_loan_insert = 'insert into salary_pl_journal set PBI_ORG="2", year="'.$year.'", month="'.$mon.'", PBI_ID="'.$values[$y]["PBI_ID"].'", jv_date="'.$jv_date.'",amt_in="'.$actual_pf_loan.'",tr_from="pf_loan_adjustment", tr_no="'.$tr_no.'",period="'.$year_month.'",entry_by="'.$_SESSION['user']['id'].'"';
db_query($pf_loan_insert);
}

//interest
$pf_loan_interest = find_a_field('pf_loan_details','sum(interest_amt)','PBI_ID="'.$values[$y]["PBI_ID"].'" and current_mon="'.$mon.'" and current_year="'.$year.'" and  	advance_type="pf_loan" and status="unpaid"');
if($pf_loan_interest>0){
db_query('delete from pf_interest where year="'.$year.'" and mon="'.$mon.'" and employee_id="'.$values[$y]["PBI_ID"].'"');
$interest_insert = 'insert into pf_interest set tr_date="'.$_POST['salary_date'].'", mon="'.$mon.'",year="'.$year.'",employee_id="'.$values[$y]["PBI_ID"].'",amount="'.$pf_loan_interest.'",entry_at="'.date('Y-m-d H:i:s').'",entry_by="'.$_SESSION['user']['id'].'"';
db_query($interest_insert);
}

$update_pf_loan = 'update pf_loan_details set status="paid" where PBI_ID="'.$values[$y]["PBI_ID"].'" and current_mon="'.$mon.'" and current_year="'.$year.'" and  	advance_type="pf_loan"';
db_query($update_pf_loan);


//pf
if($values[$y]["pf"]>0){
db_query('delete from salary_pl_journal where tr_from="self_pf" and year="'.$year.'" and month="'.$mon.'" and PBI_ID="'.$values[$y]["PBI_ID"].'"');
$jv_date = date('Y-m-d');
 $pf_insert = 'insert into salary_pl_journal set PBI_ORG="2", year="'.$year.'", month="'.$mon.'", PBI_ID="'.$values[$y]["PBI_ID"].'", jv_date="'.$jv_date.'",amt_in="'.$values[$y]["pf"].'",tr_from="self_pf", tr_no="'.$tr_no.'",period="'.$year_month.'",entry_by="'.$_SESSION['user']['id'].'"';
db_query($pf_insert);
}

if($values[$y]["cpf"]>0){
db_query('delete from salary_pl_journal where tr_from="company_pf" and year="'.$year.'" and month="'.$mon.'" and PBI_ID="'.$values[$y]["PBI_ID"].'"');
$pf_insert = 'insert into salary_pl_journal set PBI_ORG="2", year="'.$year.'", month="'.$mon.'", PBI_ID="'.$values[$y]["PBI_ID"].'", jv_date="'.$jv_date.'",amt_in="'.$values[$y]["cpf"].'",tr_from="company_pf", tr_no="'.$tr_no.'",period="'.$year_month.'",entry_by="'.$_SESSION['user']['id'].'"';
db_query($pf_insert);
}
/////////////////// PF end


}


}

echo "Complete";

//echo $sql;

}



?>







<style type="text/css">







<!--







.style1 {font-size: 24px}







.style2 {







color: #FF66CC;







font-weight: bold;







}







-->







</style>







<form action=""  method="post" enctype="multipart/form-data">







    <div class="d-flex justify-content-center">







        <div class="n-form1 fo-width pt-0">



            <h4 class="text-center bg-titel bold pt-2 pb-2">Salary Process HRM Attendance Final</h4>



            <div class="container-fluid p-0">



                <div class="row">



                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">



                        <div class="form-group row  m-0 mb-1 pl-3 pr-3">



                            <label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Employee Code :  </label>



                            <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">



                          
							  
							  
    <input type="text"  list='eip_ids' name="emp_id" id="emp_id" value="<?=$_POST['emp_id']?>" />
                <datalist id='eip_ids'>
                  <option></option>
                  <?
			foreign_relation('personnel_basic_info','PBI_ID','concat(PBI_CODE," - ",PBI_NAME)',$emp_id,'1');
			?>
                </datalist>



                            </div>



                        </div>



                    </div>







                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">







                        <div class="form-group row m-0 mb-1 pl-3 pr-3">



                            <label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Company :    </label>



                            <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">



                              <select name="PBI_ORG" id="PBI_ORG">



                              <option></option>



								<? foreign_relation('user_group','id','group_name',$PBI_ORG);?>



								



								</select>



                            </div>



                        </div>







                    </div>



					



					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">







                        <div class="form-group row m-0 mb-1 pl-3 pr-3">



                            <label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Job Location :    </label>



                            <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">




								<select name="JOB_LOCATION" id="JOB_LOCATION"  class="form-control"  >
                                            <option></option>
                                            <? foreign_relation('project','PROJECT_ID','PROJECT_DESC',$JOB_LOCATION);?>
                                          </select>



                            </div>



                        </div>



						



                    </div>



                            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">



                                

							<div class="form-group row m-0 mb-1 pl-3 pr-3">



                                    <label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Month :    </label>



                                    <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">







                                       <select name="salary_month"  id="salary_month" required>

	

												  <option></option>

	

												  <?=foreign_relation('salary_months','salary_month','salary_month',$_POST['salary_month'],'1 and status="Active"');?>

											  </select>







                                    </div>



                                </div>

								



                            </div>


                            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

                            </div>



                </div>

                <div class="n-form-btn-class">



                    <input name="upload" type="submit" class="btn1 btn1-bg-submit" id="upload" value="Sync All Data" />


                </div>

            </div>

        </div>


    </div>


</form>


<script>
  // Get current date
  var currentDate = new Date();

  // Get current year and month
  var currentYear = currentDate.getFullYear();
  var currentMonth = ('0' + (currentDate.getMonth() + 1)).slice(-2);

  // Create the current year and month string in the format "YYYY-MM"
  var currentYearMonth = currentYear + '-' + currentMonth;

  // Set the selected attribute for the option with the current year and month value
  document.getElementById('salary_month').value = currentYearMonth;
</script>



<?










require_once SERVER_CORE."routing/layout.bottom.php";







?>