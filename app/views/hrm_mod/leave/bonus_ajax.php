<?php
//session_start();
//require "../../config/inc.all.php";


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');

$str = $_POST['data'];
$data=explode('##',$str);
$PBI_ID=$data[0];
$info=explode('<#>',$data[1]);
$persentage = $info[0];
$remarks = $info[1];
$bonus_type = $info[2];
$year = $info[3];


   $sql = 'select * from salary_bonus where PBI_ID="'.$PBI_ID.'" and `year`="'.$year.'" and bonus_type= "'.$bonus_type.'"';
   $query = db_query($sql);
   $data = mysqli_fetch_object($query);
   
   $s_sql = 'select * from salary_info where PBI_ID="'.$PBI_ID.'"';
   $query_sql = db_query($s_sql);
   $s_data = mysqli_fetch_object($query_sql);
   $bonus_given_by = $s_data->cash_bank;
    
   $bonus_percent = $persentage;
   $PBI_ID = $data->PBI_ID;
   $year = $data->year;
   $remarks;
   $bonus_type = $data->bonus_type;
   $basic_salary = $s_data->basic_salary;
   $gross_salary = $s_data->gross_salary;
   $bonus_amt = $gross_salary*$bonus_percent/100;
   
   
         /*  if($bonus_given_by==5){
		   $cash_bonus = round(($s_data->basic_salary_cash*$bonus_percent)/100);
		   $bank_bonus = round(($s_data->basic_salary_bank*$bonus_percent)/100);
		   $paroll_card_bonus = 0;
		   }elseif($bonus_given_by==1){
		   $cash_bonus = $bonus_amt;
		   $bank_bonus = 0;
		   $paroll_card_bonus = 0;
		   }elseif($bonus_given_by==2){
		   $bank_bonus = $bonus_amt;
		   $cash_bonus = 0;
		   $paroll_card_bonus = 0;
		   }elseif($bonus_given_by==3){
		   $paroll_card_bonus = $bonus_amt;
		   $cash_bonus = 0;
		   $bank_bonus = 0;
		   }else{
		   $cash_bonus = 0;
		   $bank_bonus = 0;
		   $paroll_card_bonus = 0;
		   }*/
		   
		   if($bonus_given_by=="Cash+Bank"){

		   $cash_bonus = round($datas->basic_salary_cash);

		   $bank_bonus = round($datas->basic_salary_bank);

	       }elseif($bonus_given_by=="Cash"){

		   $cash_bonus = $bonus_amt;

		   $bank_bonus = 0;

	       }elseif($bonus_given_by=="Bank"){

		   $bank_bonus = $bonus_amt;

		   $cash_bonus = 0;

           }else{

		   $cash_bonus = 0;

		   $bank_bonus = 0;

		   }
		   
		   
		   
		   
		   
   
   if($PBI_ID>0 && $year>0 && $bonus_type>0){
   $update = 'update salary_bonus set bonus_percent="'.$bonus_percent.'",bank_paid="'.$bank_bonus.'",cash_paid="'.$cash_bonus.'",payroll_card_paid="'.$paroll_card_bonus.'",bonus_amt="'.$bonus_amt.'",remarks="'.$remarks.'",edit_at="'.date('Y-m-d h:i:s').'",edit_by="'.$_SESSION['user']['id'].'" where year="'.$year.'" and bonus_type="'.$bonus_type.'"and PBI_ID="'.$PBI_ID.'"';
   $sqlupdate = db_query($update);

  echo '<span style="color:green; font-size:15px; font-weight:bold;">Success</span>';
  }else{
  echo '<span style="color:red;font-size:15px; font-weight:bold;">Failed! Refresh the page</span>';
  }



?>