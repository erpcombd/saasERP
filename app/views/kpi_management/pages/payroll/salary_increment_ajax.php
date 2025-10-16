<?
session_start();
require_once "../../config/inc.all.php";

$crud      =new crud('increment_detail');
$unique = 'INCREMENT_D_ID';
$flag=$_REQUEST['flag'];
$PBI_ID=$_REQUEST['PBI_ID'];
$year=$_REQUEST['year'];


$bs=$_REQUEST['bs'];
$hr=$_REQUEST['hr'];
$co=$_REQUEST['co'];
$cc=$_REQUEST['cc'];
$me=$_REQUEST['me'];
$pf=$_REQUEST['pf'];
$po=$_REQUEST['po'];

if($flag==0){
$data = find_all_field('increment_detail','','PBI_ID="'.$PBI_ID.'" order by INCREMENT_D_ID desc');
		$obs = (int)$data->new_basic_salary;
		$ohr = (int)$data->new_house_rent;
		$ome = (int)$data->new_medical_allowance;
		$oco = (int)$data->new_ta;
		$occ = (int)$data->new_da;
		$opf = (int)$data->new_pf;
		$opo = (int)$data->new_pf_organization;
}
else{
$data = find_all_field('increment_detail','INCREMENT_D_ID','PBI_ID="'.$PBI_ID.'" and year="'.$year.'" order by INCREMENT_D_ID desc');
$INCREMENT_D_ID = $data->INCREMENT_D_ID;
//		$obs = (int)$data->old_basic_salary;
//		$ohr = (int)$data->old_house_rent;
//		$ome = (int)$data->old_medical_allowance;
//		$oco = (int)$data->old_ta;
//		$occ = (int)$data->old_da;
//		$opf = (int)$data->old_pf;
//		$opo = (int)$data->old_pf_organization;
}

		$U_ID=$_SESSION['user']['id'];
		$USED_DT=date('Y-m-d h:i:s');
		$last_update_date=date('Y-m-d h:i:s');
if($flag==0)
{
$sql = "INSERT INTO `increment_detail` 
(`year`, `INCREMENT_TYPE`,  `INCREMENT_EFFECT_DATE`, `U_ID`, `USED_DT`, `PBI_ID`, `old_basic_salary`, `old_house_rent`, `old_medical_allowance`, `old_ta`, `old_da`,  `old_pf`, `old_pf_organization`, `new_basic_salary`, `new_house_rent`, `new_medical_allowance`, `new_ta`, `new_da`,  `new_pf`, `new_pf_organization`, `last_update_date`) 
VALUES 
( '$year', 'Yearly Increment', '$year-01-01', '$U_ID', '$USED_DT', '$PBI_ID', '$obs', '$ohr', '$ome', '$oco', '$occ',  '$opf', '$opo', '$bs', '$hr', '$me', '$co', '$cc',  '$pf', '$po','$last_update_date')";
mysql_query($sql);
echo 'Saved!';
}
else
{
$sql = "UPDATE `increment_detail` SET 
`new_basic_salary` = '$bs', `new_house_rent` = '$hr', `new_medical_allowance` = '$me', `new_ta` = '$co', `new_da` = '$cc', `new_pf` = '$pf', `new_pf_organization` = '$po'

, `U_ID` = '$U_ID', `USED_DT` = '$USED_DT', `last_update_date` = '$last_update_date'  WHERE `INCREMENT_D_ID` = ".$INCREMENT_D_ID;
mysql_query($sql);
echo 'Edit!';

}
$salary = find_all_field('salary_info','','PBI_ID='.$PBI_ID);

$consolidated_salary = 
$bs +   $hr +   $salary->special_allowance + $co + $cc +   $salary->others +   $salary->food_allowance+ $me +   $salary->mobile_allowance
+  
($pf + $po +  $salary->group_insurance + $salary->cfund+ $salary->security_amount+ $salary->income_tax);

mysql_query("UPDATE `salary_info` SET 
`consolidated_salary` = '".$consolidated_salary."', 
	`basic_salary` = '".$bs."', 
	`house_rent` = '".$hr."', 
	`ta` = '".$co."', 
	`da` = '".$cc."', 
	`medical_allowance` = '".$me."', 
	`pf` = '".$pf."', 
	`pf_organization` = '".$po."'
WHERE `PBI_ID` = '".$PBI_ID."'");
//,`old_basic_salary` = '$obs', `old_house_rent` = '$ohr', `old_medical_allowance` = '$ome', `old_ta` = '$oco', `old_da` = '$occ', `old_pf` = '$opf', `old_pf_organization` = '$opo'
?>