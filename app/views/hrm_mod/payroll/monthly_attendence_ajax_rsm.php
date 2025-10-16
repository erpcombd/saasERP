<?
session_start();
require "../../config/inc.all.php";

$crud      =new crud('hrm_att_monthly');
$unique = 'id';
$mon=$_GET['mon'];
$year=$_GET['year'];
$startTime = $days1=mktime(0,0,0,$mon,01,$year);
$endTime = $days2=mktime(0,0,0,$mon,date('t',$startTime),$year);

$days_in_month = date('t',$endTime);

$basic_info = find_all_field('personnel_basic_info','','PBI_ID='.$_REQUEST['PBI_ID']);

$_REQUEST['pbi_department'] = $basic_info->PBI_DEPARTMENT;
$_REQUEST['pbi_designation'] = $basic_info->DESG_ID;
$_REQUEST['pbi_organization'] = $basic_info->PBI_ORG;
$_REQUEST['pbi_job_location'] = $basic_info->JOB_LOCATION;
//echo 'PBI_ID="'.$_REQUEST['PBI_ID'].'" and mon="'.$_REQUEST['mon'].'" and year="'.$_REQUEST['year'].'" ';
$_POST[$unique] = $$unique = find_a_field('salary_attendence','id','PBI_ID="'.$_REQUEST['PBI_ID'].'" and mon="'.$_REQUEST['mon'].'" and year="'.$_REQUEST['year'].'" ');

$salary = find_all_field('salary_info','','PBI_ID='.$_REQUEST['PBI_ID']);
$_REQUEST['basic_salary'] = $salary->basic_salary;
$_REQUEST['ta_da_data'] = $salary->ta;
$_REQUEST['spl_alw_data'] = $salary->special_allowance;

$salary_date=date('Y-m-d',mktime(0,0,0,$_REQUEST['mon'],1,$_REQUEST['year']));
//$_REQUEST['deduction']=;
//$_REQUEST['benifits']=;

if($_REQUEST['td']!=$days_in_month)
$_REQUEST['basic_salary_payable']=($salary->basic_salary/$days_in_month)*$_REQUEST['pay'];
else
$_REQUEST['basic_salary_payable']=$salary->basic_salary;

$_REQUEST['house_rent']=$salary->house_rent;

if($_REQUEST['td']!=$days_in_month)
$_REQUEST['house_rent']=$salary->house_rent = ($salary->house_rent/$days_in_month)*$_REQUEST['pay'];
else
$_REQUEST['house_rent']=$salary->house_rent;

$_REQUEST['medical_allowance']=$salary->medical_allowance;
$_REQUEST['other_allowance']=$salary->others;


if($_REQUEST['td']!=$days_in_month)
$_REQUEST['special_allowance']=$salary->special_allowance = ($salary->special_allowance/$days_in_month)*$_REQUEST['pay'];
else
$_REQUEST['special_allowance']=$salary->special_allowance;


$_REQUEST['mobile_allowance']=$salary->mobile_allowance;

if($salary->ta>1000)
$_REQUEST['ta_da']=number_format((($salary->ta/($_REQUEST['td']-$_REQUEST['od']))*($_REQUEST['pre']+$_REQUEST['hd'])),0,'.','');
else
$_REQUEST['ta_da']=number_format(($salary->ta*($_REQUEST['pre']+$_REQUEST['hd'])),0,'.','');

$_REQUEST['food_allowance']=$salary->food_allowance;
$_REQUEST['cooperative_share']=$salary->cooperative_share;
$_REQUEST['income_tax']=$salary->income_tax;
$_REQUEST['vehicle_allowance']=($salary->vehicle_allowance/$days_in_month)*$_REQUEST['pay'];

$_REQUEST['over_time_amount']=(($salary->basic_salary+$salary->consolidated_salary+$salary->special_allowance)/208)*($_REQUEST['ot']);
$_REQUEST['absent_deduction']=(($salary->basic_salary+$salary->consolidated_salary+$salary->special_allowance)/($_REQUEST['td']))*($_REQUEST['td']-$_REQUEST['pay']);

if($salary->food_allowance>0)
{
$_REQUEST['food_allowance'] = (($salary->food_allowance)*($_REQUEST['pre']));
}



if($salary->commission_type=="Conditional" && $salary->fixed_commission>0 && $salary->comm_till_date>$salary_date)
{
$_REQUEST['fixed_commission'] = (int)($salary->fixed_commission);
}

/*if($salary->ta_type=="DA"&&$salary->ta>0)
{
$_REQUEST['ta_da'] = (int)(@($salary->ta/25)*($_REQUEST['pre']+$_REQUEST['od']));
}*/

$_REQUEST['advance_install'] = find_a_field('salary_advance','sum(payable_amt)','PBI_ID="'.$_REQUEST['PBI_ID'].'" and current_mon="'.$_REQUEST['mon'].'" and  	current_year="'.$_REQUEST['year'].'" and  	advance_type="Advance Cash" ');

$_REQUEST['motorcycle_install'] = find_a_field('motorcycle_install','sum(payable_amt)','PBI_ID="'.$_REQUEST['PBI_ID'].'" and current_mon="'.$_REQUEST['mon'].'" and  	current_year="'.$_REQUEST['year'].'" and  	advance_type="Advance Cash" ');

$_REQUEST['other_install'] = find_a_field('salary_advance','sum(payable_amt)','PBI_ID="'.$_REQUEST['PBI_ID'].'" and current_mon="'.$_REQUEST['mon'].'" and  	current_year="'.$_REQUEST['year'].'" and  	advance_type="Other Advance" ');


if($_REQUEST['bonus']=='No')
$_REQUEST['bonus_amount']=0;
else
$_REQUEST['bonus_amount'] = ($salary->consolidated_salary/2);

$_REQUEST['total_salary'] = $_REQUEST['basic_salary_payable']+ $salary->consolidated_salary + $salary->special_allowance;

$_REQUEST['total_deduction'] = $_REQUEST['absent_deduction']+$_REQUEST['advance_install']+$_REQUEST['other_install']+$_REQUEST['deduction']+$_REQUEST['cooperative_share']+$_REQUEST['motorcycle_install']+$_REQUEST['income_tax'];

$_REQUEST['total_benefits'] = $_REQUEST['house_rent'] +$_REQUEST['bonus_amount'] + $_REQUEST['over_time_amount'] + $_REQUEST['other_benefits']+$_REQUEST['benefits']+$_REQUEST['ta_da']+$_REQUEST['food_allowance']+$_REQUEST['vehicle_allowance'];

$_REQUEST['total_payable'] = (int)(($_REQUEST['total_salary'] + $_REQUEST['total_benefits']) - $_REQUEST['total_deduction']);


$d_bank = $_REQUEST['total_payable'] - $salary->bank_paid;

if($d_bank>=0){
$_REQUEST['cash_paid'] = $d_bank;
$_REQUEST['bank_paid'] = $salary->bank_paid;
}
else
{
$_REQUEST['cash_paid'] = 0;
$_REQUEST['bank_paid'] = $_REQUEST['total_payable'];

}

if($$unique>0)
{
$_REQUEST['edit_by']=$_SESSION['user']['id'];
$_REQUEST['edit_at']=date('Y-m-d H:i:s');
echo 'Updated!';
$crud->update($unique);
}
else
{
$_REQUEST['entry_by']=$_SESSION['user']['id'];
$_REQUEST['entry_at']=date('Y-m-d H:i:s');
echo 'Saved!';
$crud->insert();
}
?>