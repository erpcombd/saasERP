<?php

session_start();

ob_start();

require "../../support/inc.all.php";
require_once('../excel_lib/php-excel-reader/excel_reader2.php');
require_once('../excel_lib/SpreadsheetReader.php');


if (isset($_POST["import"]))
{
 $show_data = 1;
    
    
  $allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
  
  if(in_array($_FILES["file"]["type"],$allowedFileType)){

        $targetPath = '../excel_lib/'.$_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);
        
        $Reader = new SpreadsheetReader($targetPath);
        
        $sheetCount = count($Reader->sheets());
        for($i=0;$i<$sheetCount;$i++)
        {
            
            $Reader->ChangeSheet($i);
            
            foreach ($Reader as $Row)
            {
          
                $PBI_ID = "";
                if(isset($Row[0])) {
                    $PBI_ID_R = mysqli_real_escape_string($Row[0]);
					$PBI_ID = substr($PBI_ID_R, 4);
	                
                }
				
				$PBI_ID2 = "";
                if(isset($Row[0])) {
                    $PBI_ID_R2 = mysqli_real_escape_string($Row[0]);
					$PBI_ID2 = substr($PBI_ID_R, 4);
	                
                }
                
                $salary_type = "";
                if(isset($Row[1])) {
                    $salary_type =mysqli_real_escape_string($Row[1]);
                }
				
				$basic_salary = "";
                if(isset($Row[2])) {
                    $basic_salary =mysqli_real_escape_string($Row[2]);
                }
				
				$consolidated_salary = "";
                if(isset($Row[3])) {
                    $consolidated_salary =mysqli_real_escape_string($Row[3]);
                }
				
				$house_rent = "";
                if(isset($Row[4])) {
                    $house_rent =mysqli_real_escape_string($Row[4]);
                }
				
				$special_allowance = "";
                if(isset($Row[5])) {
                    $special_allowance =mysqli_real_escape_string($Row[5]);
                }
				
				$ta_type = "";
                if(isset($Row[6])) {
                    $ta_type =mysqli_real_escape_string($Row[6]);
                }
				
				$ta = "";
                if(isset($Row[7])) {
                    $ta =mysqli_real_escape_string($Row[7]);
                }
				
				$da = "";
                if(isset($Row[8])) {
                    $da =mysqli_real_escape_string($Row[8]);
                }
				
				
				
				$basic_percent = "";
                if(isset($Row[9])) {
                    $basic_percent =mysqli_real_escape_string($Row[9]);
                }
				
				$house_rent_percent = "";
                if(isset($Row[10])) {
                    $house_rent_percent =mysqli_real_escape_string($Row[10]);
                }
				$conveyance_percent = "";
                if(isset($Row[11])) {
                    $conveyance_percent =mysqli_real_escape_string($Row[11]);
                }
				
				$medical_percent = "";
                if(isset($Row[12])) {
                    $medical_percent =mysqli_real_escape_string($Row[12]);
                }
				
				$food_allowance = "";
                if(isset($Row[13])) {
                    $food_allowance =mysqli_real_escape_string($Row[13]);
                }
				
				$mob_alw_app = "";
                if(isset($Row[14])) {
                    $mob_alw_app =mysqli_real_escape_string($Row[14]);
                }
				
				$mobile_allowance = "";
                if(isset($Row[15])) {
                    $mobile_allowance =mysqli_real_escape_string($Row[15]);
                }
				
				$medical_allowance = "";
                if(isset($Row[16])) {
                    $medical_allowance =mysqli_real_escape_string($Row[16]);
                }
                
				$transport_allowance = "";
                if(isset($Row[17])) {
                    $transport_allowance =mysqli_real_escape_string($Row[17]);
                }
				$other_allowance = "";
                if(isset($Row[18])) {
                    $other_allowance =mysqli_real_escape_string($Row[18]);
                }
				$mobile_ceiling = "";
                if(isset($Row[19])) {
                    $mobile_ceiling =mysqli_real_escape_string($Row[19]);
                }
				
				$mobile_deduction = "";
                if(isset($Row[20])) {
                    $mobile_deduction =mysqli_real_escape_string($Row[20]);
                }
                $bonus_applicable = "";
                if(isset($Row[21])) {
                    $bonus_applicable =mysqli_real_escape_string($Row[21]);
                }
				$bonus_percent = "";
                if(isset($Row[22])) {
                    $bonus_percent =mysqli_real_escape_string($Row[22]);
                }
				
				$bonus_amount = "";
                if(isset($Row[23])) {
                    $bonus_amount =mysqli_real_escape_string($Row[23]);
                }
				
				$overtime_applicable = "";
                if(isset($Row[24])) {
                    $overtime_applicable =mysqli_real_escape_string($Row[24]);
                }
				$overtime_hr_rate = "";
                if(isset($Row[25])) {
                    $overtime_hr_rate =mysqli_real_escape_string($Row[25]);
                }
				$extra_allowance = "";
                if(isset($Row[26])) {
                    $extra_allowance =mysqli_real_escape_string($Row[26]);
                }
				$pf = "";
                if(isset($Row[27])) {
                    $pf =mysqli_real_escape_string($Row[27]);
                }
				$income_tax = "";
                if(isset($Row[28])) {
                    $income_tax =mysqli_real_escape_string($Row[28]);
                }
				
				$group_insurance = "";
                if(isset($Row[29])) {
                    $group_insurance =mysqli_real_escape_string($Row[29]);
                }
				
				$cfund = "";
                if(isset($Row[30])) {
                    $cfund =mysqli_real_escape_string($Row[30]);
                }
				
				$cash_amt = "";
                if(isset($Row[31])) {
                    $cash_amt =mysqli_real_escape_string($Row[31]);
                }
				$bank_amt = "";
                if(isset($Row[32])) {
                    $bank_amt =mysqli_real_escape_string($Row[32]);
                }
				$cash_bank = '';
                if(isset($Row[33])) {
                    $cash_bank =mysqli_real_escape_string($Row[33]);
                }
				$cash = "";
                if(isset($Row[34])) {
                    $cash =mysqli_real_escape_string($Row[34]);
                }
				$card_no = "";
                if(isset($Row[35])) {
                    $card_no =mysqli_real_escape_string($Row[35]);
                }
				$branch_info = "";
                if(isset($Row[36])) {
                    $branch_info =mysqli_real_escape_string($Row[36]);
                }
				$security_amount = "";
                if(isset($Row[37])) {
                    $security_amount =mysqli_real_escape_string($Row[37]);
                }
				$cooperative_share = "";
                if(isset($Row[38])) {
                    $cooperative_share =mysqli_real_escape_string($Row[38]);
                }
				$motorcycle_install = "";
                if(isset($Row[39])) {
                    $motorcycle_install =mysqli_real_escape_string($Row[39]);
                }
				$security_amnt = "";
                if(isset($Row[40])) {
                    $security_amnt =mysqli_real_escape_string($Row[40]);
                }
				$security_amnt_till_date = "";
                if(isset($Row[41])) {
                    $security_amnt_till_date =mysqli_real_escape_string($Row[41]);
                }
				
				$gross_salary = "";
                if(isset($Row[42])) {
                    $gross_salary =mysqli_real_escape_string($Row[42]);
                }
				$loan_or_advance = "";
                if(isset($Row[43])) {
                    $loan_or_advance =mysqli_real_escape_string($Row[43]);
                }
				$cash_amt_applicable = "";
                if(isset($Row[44])) {
                    $cash_amt_applicable =mysqli_real_escape_string($Row[44]);
                }  
				$bank_percent = "";
                if(isset($Row[45])) {
                    $bank_percent =mysqli_real_escape_string($Row[45]);
                }  
				$bank_amount = "";
                if(isset($Row[46])) {
                    $bank_amount =mysqli_real_escape_string($Row[46]);
                }  
				$Wallet_percent = "";
                if(isset($Row[47])) {
                    $Wallet_percent =mysqli_real_escape_string($Row[47]);
                }  
				$Wallet_amount = "";
                if(isset($Row[48])) {
                    $Wallet_amount =mysqli_real_escape_string($Row[48]);
                }  
				
				  $payment_type = find_a_field('salary_payment_method','id','payment_method_name like "%'.$cash_bank.'%" ');
				  if($PBI_ID>0){
                 $id_exist = find_a_field('salary_info','PBI_UNIQUE_ID','PBI_UNIQUE_ID='.$PBI_ID);
                  
				   if($id_exist>0){
				   
				   }else{
                
                    $query = 'INSERT INTO `salary_info`( `PBI_ID`,`PBI_UNIQUE_ID`, `salary_type`, `basic_salary`, `consolidated_salary`, `house_rent`, `special_allowance`, `ta_type`, `ta`, `da`,  `basic_percent`, `house_rent_percent`, `conveyance_percent`, `medical_percent`, `food_allowance`, `mob_alw_app`, `mobile_allowance`, `medical_allowance`, `transport_allowance`, `other_allowance`, `mobile_ceiling`, `mobile_deduction`, `bonus_applicable`, `bonus_percent`, `bonus_amount`, `overtime_applicable`, `overtime_hr_rate`, `extra_allowance`, `pf`, `income_tax`, `group_insurance`, `cfund`, `cash_amt`, `bank_amt`, `cash_bank`, `cash`, `card_no`, `branch_info`, `security_amount`, `cooperative_share`, `motorcycle_install`, `security_amnt`, `security_amnt_till_date`, `gross_salary`, `loan_or_advance`, `cash_amt_applicable`,`bank_percent`,`bank_amount`,`Wallet_percent`,`Wallet_amount`) VALUES ("'.$PBI_ID2.'","'.$PBI_ID.'","'.$salary_type.'","'.$basic_salary.'","'.$consolidated_salary.'","'.$house_rent.'","'.$special_allowance.'","'.$ta_type.'","'.$ta.'","'.$da.'","'.$basic_percent.'","'.$house_rent_percent.'","'.$conveyance_percent.'","'.$medical_percent.'","'.$food_allowance.'","'.$mob_alw_app.'","'.$mobile_allowance.'","'.$medical_allowance.'","'.$transport_allowance.'","'.$other_allowance.'","'.$mobile_ceiling.'","'.$mobile_deduction.'","'.$bonus_applicable.'","'.$bonus_percent.'","'.$bonus_amount.'","'.$overtime_applicable.'","'.$overtime_hr_rate.'","'.$extra_allowance.'","'.$pf.'","'.$income_tax.'","'.$group_insurance.'","'.$cfund.'","'.$cash_amt.'","'.$bank_amt.'","'.$payment_type.'","'.$cash.'","'.$card_no.'","'.$branch_info.'","'.$security_amount.'","'.$cooperative_share.'","'.$motorcycle_install.'","'.$security_amnt.'","'.$security_amnt_till_date.'","'.$gross_salary.'","'.$loan_or_advance.'","'.$cash_amt_applicable.'","'.$bank_percent.'","'.$bank_amount.'","'.$Wallet_percent.'","'.$Wallet_amount.'")';
                    $result = db_query($query);
                
                    if (! empty($result)) {
                        $type = "success";
                        $message = "Excel Data Imported into the Database";
                    } else {
                        $type = "error";
                        $message = "Problem in Importing Excel Data";
                    }
					}
					}
                
             }
        
         }
  }
  else
  { 
        $type = "error";
        $message = "Invalid File Type. Upload Excel File.";
  }
}
?>

<style>    
body {
	font-family: Arial;
	width: 100%;
}

.outer-container {
	background: #F0F0F0;
	border: #e0dfdf 1px solid;
	padding: 40px 20px;
	border-radius: 2px;
}

.btn-submit {
	background: #333;
	border: #1d1d1d 1px solid;
    border-radius: 2px;
	color: #f0f0f0;
	cursor: pointer;
    padding: 5px 20px;
    font-size:0.9em;
}

.tutorial-table {
    margin-top: 40px;
    font-size: 0.8em;
	border-collapse: collapse;
	width: 100%;
}

.tutorial-table th {
    background: #f0f0f0;
    border-bottom: 1px solid #dddddd;
	padding: 8px;
	text-align: left;
}

.tutorial-table td {
    background: #FFF;
	border-bottom: 1px solid #dddddd;
	padding: 8px;
	text-align: left;
}

#response {
    padding: 10px;
    margin-top: 10px;
    border-radius: 2px;
    display:none;
}

.success {
    background: #c7efd9;
    border: #bbe2cd 1px solid;
}

.error {
    background: #fbcfcf;
    border: #f3c6c7 1px solid;
}

div#response.display-block {
    display: block;
}
</style>

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
    <h2>Import Salary Info</h2>
    
    <div class="outer-container">
        <form action="" method="post"
            name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
            <div>
                <label>Choose Excel
                    File</label> <input type="file" name="file"
                    id="file" accept=".xls,.xlsx">
                <button type="submit" id="submit" name="import"
                    class="btn-submit">Import</button>
        
            </div>
        
        </form>
        
    </div>
    <div id="response" class="<?php if(!empty($type)) { echo $type . " display-block"; } ?>"><?php if(!empty($message)) { echo $message; } ?></div>
    
	<?    
	      if ($show_data> 0){
	      $sql ="SELECT * FROM salary_info";
          $query = db_query($sql);
         

	 ?>
         
     
    <table class='tutorial-table'>
        <thead>
            <tr>
                <th>PBI_ID</th>
                <th>Gross Salary</th>
				 <th>Basic Salary</th>
                <th>House Rent</th>
				<th>Special Allowance</th>
				<th>Medical Allowance</th>
				<th>Extra Allowance</th>
				<th>Food Allowance</th>
				<th>Transport Allowance</th>
				<th>Other Allowance</th>
				<th>Bonus Applicable</th>
				<th>Bonus Amount</th>
				<th>Cash Amount Applicable</th>
				<th>Cash Amount</th>
				<th>Overtime Applicable</th>
				<th>Mobile bill Applicable</th>
				<th>Mobile Allowance</th>
				<th>PF</th>
				<th>Group Insurance</th>
				<th>Cash Bank</th>
				<th>Cash</th>
				<th>Card No</th>
				<th>Branch Info</th>
				<th>Bank Amount</th>
				

            </tr>
        </thead>
<?php

 while ($row=mysqli_fetch_object($query)) {

?>                  
        <tbody>
        <tr>
            <td><?php  echo $row->PBI_UNIQUE_ID ?></td>
            <td><?php  echo $row->gross_salary ?></td>
			<td><?php  echo $row->basic_salary ?></td>
			<td><?php  echo $row->house_rent ?></td>
			<td><?php  echo $row->special_allowance ?></td>
			<td><?php  echo $row->medical_allowance ?></td>
			<td><?php  echo $row->extra_allowance ?></td>
			<td><?php  echo $row->food_allowance ?></td>
		    <td><?php  echo $row->transport_allowance ?></td>
			<td><?php  echo $row->other_allowance ?></td>
		    <td><?php  echo $row->bonus_applicable ?></td>
			<td><?php  echo $row->bonus_percent ?></td>
		    <td><?php  echo $row->bonus_amount ?></td>
			<td><?php  echo $row->cash_amt_applicable ?></td>
			<td><?php  echo $row->cash_amt ?></td>
			<td><?php  echo $row->overtime_applicable ?></td>
			<td><?php  echo $row->mob_alw_app ?></td>
			<td><?php  echo $row->mobile_allowance ?></td>
			<td><?php  echo $row->pf ?></td>
			<td><?php  echo $row->group_insurance ?></td>
			<td><?php  echo $row->cash_bank ?></td>
			<td><?php  echo $row->cash ?></td>
			<td><?php  echo $row->card_no ?></td>
			<td><?php  echo $row->branch_info ?></td>
							
							   	
        </tr>
<?php
    } 
?>
        </tbody>
    </table>
	
	<? } ?>
</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


<?php

$main_content=ob_get_contents();

ob_end_clean();

require_once SERVER_CORE."routing/layout.bottom.php";

?>
