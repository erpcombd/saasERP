<?
session_start();
require_once "../../config/inc.all.php";

$crud      =new crud('salary_attendence');
$unique = 'id';


//echo 'PBI_ID="'.$_REQUEST['PBI_ID'].'" and mon="'.$_REQUEST['mon'].'" and year="'.$_REQUEST['year'].'" ';
$_POST[$unique] = $$unique = find_a_field('salary_attendence','id','PBI_ID="'.$_REQUEST['PBI_ID'].'" and mon="'.$_REQUEST['mon'].'" and year="'.$_REQUEST['year'].'" ');
$salary = find_all_field('salary_info','','PBI_ID='.$_REQUEST['PBI_ID']);

$area=$_REQUEST['area'];
$_REQUEST['basic_salary']=$salary->basic_salary;
$_REQUEST['house_rent']=$salary->house_rent;
$_REQUEST['medical_allowance']=$salary->medical_allowance;
$_REQUEST['other_allowance']=$salary->others;
$_REQUEST['special_allowance']=$salary->special_allowance;
$_REQUEST['mobile_allowance']=$salary->mobile_allowance;
$_REQUEST['ta_da']=($salary->ta+$salary->da);
$_REQUEST['food_allowance']=$salary->food_allowance;

$_REQUEST['pf']=$salary->pf_organization;
$_REQUEST['pf_own']=$salary->pf;
$_REQUEST['group_insurance']=$salary->group_insurance;
$_REQUEST['cfund']=$salary->cfund;
$_REQUEST['security_amount']=$salary->security_amount;
$_REQUEST['income_tax']=$salary->income_tax;

$_REQUEST['over_time_amount']=($salary->basic_salary/208)*($_REQUEST['ot']);


$_REQUEST['absent_deduction']=($salary->basic_salary/($_REQUEST['td']))*($_REQUEST['td']-$_REQUEST['pay']);

$_REQUEST['advance_install'] = find_a_field('salary_advance','sum(payable_amt)','PBI_ID="'.$_REQUEST['PBI_ID'].'" and current_mon="'.$_REQUEST['mon'].'" and  	current_year="'.$_REQUEST['year'].'" and  	advance_type="Advance Cash" ');
$_REQUEST['other_install'] = find_a_field('salary_advance','sum(payable_amt)','PBI_ID="'.$_REQUEST['PBI_ID'].'" and current_mon="'.$_REQUEST['mon'].'" and  	current_year="'.$_REQUEST['year'].'" and  	advance_type="Other Advance" ');

if($_REQUEST['bonus']=='Yes')
$_REQUEST['bonus_amt']=($salary->basic_salary);
else
$_REQUEST['bonus_amt']=0;



$_REQUEST['total_salary']=$salary->consolidated_salary;
$_REQUEST['total_deduction'] = $_REQUEST['pf'] + $_REQUEST['pf_own'] + $_REQUEST['group_insurance'] + $_REQUEST['cfund'] + $_REQUEST['security_amount'] + $_REQUEST['income_tax'] + $_REQUEST['absent_deduction'] + $_REQUEST['advance_install'] + $_REQUEST['other_install'] + $_REQUEST['deduction'];
$_REQUEST['total_benefits'] = $_REQUEST['bonus_amt'] + $_REQUEST['over_time_amount'] + $_REQUEST['benefits'];
$_REQUEST['total_payable'] = ($_REQUEST['total_salary'] + $_REQUEST['total_benefits']) - $_REQUEST['total_deduction'];
if($$unique>0)
{
$_REQUEST['edit_by']=$_SESSION['user']['id'];
$_REQUEST['edit_at']=date('Y-m-d h:i:s');
echo 'Updated!';
$crud->update($unique);
}
else
{
$_REQUEST['entry_by']=$_SESSION['user']['id'];
$_REQUEST['entry_at']=date('Y-m-d h:i:s');
echo 'Saved!';
$crud->insert();
}
?>