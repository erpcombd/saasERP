<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
do_calander('#s_date');
do_calander('#e_date');
do_calander('#cut_off_date'); 
$head = '<link href="../css/report_selection.css" type="text/css" rel="stylesheet"/>';



//_______________________-  Annual Leave  _-________
class AnnualLeaveCalculator {
    private $workingDays;
    private $leavePerWorkedDays = 18; // 1 leave per 18 worked days
    private $carryForwardPercentage = 0.5; // 50% carry forward

    public function __construct($totalDays, $weeklyHolidays = ['Friday']) {
        $this->workingDays = $this->calculateWorkingDays($totalDays, $weeklyHolidays);
    }

    // Exclude off days (e.g., Fridays)
    private function calculateWorkingDays($totalDays, $weeklyHolidays) {
        $workingDays = 0;
        for ($i = 0; $i < $totalDays; $i++) {
            $date = new DateTime("-$i days");
            $dayName = $date->format('l'); // Get full day name (e.g., Friday)
            if (!in_array($dayName, $weeklyHolidays)) {
                $workingDays++;
            }
        }
        return $workingDays;
    }

    // Calculate Earned Leave
    public function calculateAnnualLeave() {
        return floor($this->workingDays / $this->leavePerWorkedDays);
    }

    // Carry Forward 50% of Unused Leave
    public function carryForwardLeave($unusedLeave) {
        return floor($unusedLeave * $this->carryForwardPercentage);
    }
}


/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/




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




if (isset($_POST['pbi_id_in']) && $_POST['pbi_id_in'] != '') {
    $con = ' and s.PBI_ID in(' . $_POST['pbi_id_in'] . ')';
} else {
    // Handle the case where 'pbi_id_in' is not set or is empty
    $con = ''; // Or any default condition you want to apply
}


if(isset($_POST['submit'])){




        $pre_del='delete from earn_leaves where pbi_organization = '.$_POST['PBI_ORG'].' and   year='.$_POST['year'];
        db_query($pre_del);
		


          //and e.EMPLOYMENT_TYPE not in("Contractual")
		 $sql = 'select p.*
		  
		  from personnel_basic_info p
		  
		  where  p.PBI_JOB_STATUS="In Service"  and p.PBI_ORG='.$_POST['PBI_ORG'].$con; // and p.PBI_ID=1867


        
		$query =db_query( $sql);



		$num_rows = mysqli_num_rows($query);



		while($datas = mysqli_fetch_object($query)){

       

		$prevEntry = find_a_field('earn_leaves','PBI_ID','PBI_ID='.$datas->PBI_ID.'  and year='.$_POST['year']);
        $bonus_type=$_POST['bonus_type'];
        
		  $year = $_POST['year'];  // Get the selected year from POST
          $prevYear = $year - 1;   // Calculate the previous year


			$PBI_ID=$datas->PBI_ID;
			$pbi_department=$datas->DEPT_ID;
			$pbi_designation= $datas->DESG_ID;
			$pbi_organization=$datas->PBI_ORG;
			$pbi_job_location=$datas->JOB_LOCATION;
			$pbi_doj=$datas->PBI_DOJ;
			$job_status=$datas->EMPLOYMENT_TYPE;
			$bonus_percentage=$_POST['bonus_percentage'];
			$cut_off_date=$_POST['cut_off_date'];
			$from=date_create($datas->PBI_DOJ);
			$to=date_create($cut_off_date);
			$diff=date_diff($to,$from);
		    $bonus_days=($diff->format('%a'));
			$job_period=($diff->format("%Y Y, %M M, %d D"));
			//$bonusAmount=$gross_salary;


        if($bonus_days>=365){
		
        
		$startDate = strtotime(date("Y-01-01"));
		$endDate = strtotime(date("Y-m-d"));
		$totalDays = ceil(abs($endDate - $startDate) / 86400);
		
		$employee = new AnnualLeaveCalculator($totalDays);
		$earnedLeave = $employee->calculateAnnualLeave();
		$leaveUsed = find_a_field('hrm_leave_info','SUM(total_days)', 'PBI_ID="' .$PBI_ID. '" AND leave_status="GRANTED" AND type=3 AND 
	      s_date BETWEEN "' . $year . '-01-01" AND "' . $year . '-12-31"');
	   
		$unusedLeave = $earnedLeave - $leaveUsed;
		//$carryForward = $employee->carryForwardLeave($unusedLeave);
	
		//________previouse YEAR ___ Calculation 
		$pre_startDate = strtotime($prevYear . "-01-01");  // Start of the previous year
		$pre_endDate = strtotime($prevYear . "-12-31");    // End of the previous year
		$pre_totalDays = ceil(abs($pre_endDate - $pre_startDate) / 86400); // Total days in the previous year
        $employees = new AnnualLeaveCalculator($pre_totalDays);
		$pre_earnedLeave = $employees->calculateAnnualLeave();
		$pre_leaveUsed = find_a_field('hrm_leave_info','SUM(total_days)', 'PBI_ID="' .$PBI_ID. '" AND leave_status="GRANTED" AND type=3 AND 
	     s_date BETWEEN "' . $prevYear . '-01-01" AND "' . $prevYear . '-12-31"');
		 
		$AL_earn_by_pre_year = $pre_earnedLeave - $pre_leaveUsed;
		$carryForward = $employees->carryForwardLeave($AL_earn_by_pre_year);

        $balance = $unusedLeave+$carryForward;

		 



		}else{
		$earnedLeave = 0;
		$unusedLeave =0;
		$AL_earn_by_pre_year =0;
		$carryForward =0;
		$balance =0;
		
		
		}




		
		$entry_by=$_SESSION['user']['id'];
		$entry_at=date('Y-m-d');
		$bonus_date = $_POST['year'].'-'.$_POST['mon'].'-'.'01';



		if($prevEntry>0){
			$delSql='delete from earn_leaves where PBI_ID='.$prevEntry.' and year='.$_POST['year'];
			db_query( $delSql);
			}



 $insSql='INSERT INTO earn_leaves (  year, PBI_ID, pbi_department, pbi_designation, pbi_organization, pbi_job_location, pbi_doj, job_status, cut_off_date, bonus_days, entry_by, entry_at, job_period, mon,bonus_date,AL_earn_by_year,AL_Carry,AL_earn_by_pre_year,AL_Actual_Balance) 



VALUES ("'.$year.'", "'.$PBI_ID.'", "'.$pbi_department.'", "'.$pbi_designation.'", "'.$pbi_organization.'", "'.$pbi_job_location.'", "'.$pbi_doj.'", "'.$job_status.'",  "'.$cut_off_date.'", "'.$bonus_days.'", "'.$entry_by.'", "'.$entry_at.'", "'.$job_period.'", "'.$_POST['mon'].'",
"'.$bonus_date.'","'.$unusedLeave.'","'.$carryForward.'","'.$AL_earn_by_pre_year.'","'.$balance.'")';


db_query($insSql);


}}

?>
<style type="text/css">
.click {
border: 1px solid #00FF7C;
position: relative;
top: 0px;
transition: all ease 0.3s;
}
.click:active {
box-shadow: 0 5px 0 #00823F;
top: 5px;
}
</style>
 <div class="page-wrapper">
  <div class="content">



            <table class="table table-bordered table-sm">
              <tbody>
                <tr>
                  <div class="x_content">
                    <form action="" method="post" onsubmit="return confirm('Do you really want to submit this?');">
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
                                      <div  class="oe_view_manager_view_list">
                                        <div  class="oe_list oe_view">
                                          <table width="100%" border="0" class="oe_list_content">
                                           <tbody>
                                              <tr>
           <td width="10%" align="left" class="alt"><strong>Up To Date : </strong></td>
           <td width="20%" align="left" class="alt"><strong>
           <input name="cut_off_date" type="text" id="cut_off_date" value="<?=$_POST['cut_off_date']?>"  
		   style="width:20px;" placeholder="YY-mm-dd" required/>
                                    
                                                  </strong></td>
                                                <td  align="right" class="alt"><strong> Carry Forward % </strong>: </td>
                                                <td width="20%"><input name="bonus_percentage" type="text" id="bonus_percentage" value="50" style="width:160px;"/></td>
                                              </tr>
											  
											  
											  
											  
											  
											  
                                              <tr>
                                                <td align="left" width="2%"><strong>Month:</strong></td>
                                                <td><span class="oe_form_group_cell">
                                                  <select name="mon" style="width:20px;" id="mon" required="required">
                                                    <option value="1" <?=($mon=='1')?'selected':''?>>January</option>
                                                    <option value="2" <?=($mon=='2')?'selected':''?>>February</option>
                                                    <option value="3" <?=($mon=='3')?'selected':''?>>March</option>
                                                    <option value="4" <?=($mon=='4')?'selected':''?>>April</option>
                                                    <option value="5" <?=($mon=='5')?'selected':''?>>May</option>
                                                    <option value="6" <?=($mon=='6')?'selected':''?>>June</option>
                                                    <option value="7" <?=($mon=='7')?'selected':''?>>July</option>
                                                    <option value="8" <?=($mon=='8')?'selected':''?>>Auguest</option>
                                                    <option value="9" <?=($mon=='9')?'selected':''?>>September</option>
                                                    <option value="10" <?=($mon=='10')?'selected':''?>>October</option>
                                                    <option value="11" <?=($mon=='11')?'selected':''?>>November</option>
                                                    <option value="12" <?=($mon=='12')?'selected':''?>>December</option>
                                                  </select>
                                                  </span></td>
                                                <td align="right"><strong>Department:</strong></td>
                                                <td><span class="oe_form_group_cell">
                                                  <select name="dept" style="width:20px;" id="dept">
												   <option></option>
                                                    <?=foreign_relation('department','DEPT_ID','DEPT_DESC',$_POST['dept'],'1 order by DEPT_DESC');?>
                                                  </select>
                                                  </span></td>
                                              </tr>
                                              <tr  class="alt">
                                                <td align="left" class="alt">Year  :</td>
                                                <td align="left" class="alt"><select name="year" style="width:20px;" id="year" required>
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
												  
                                                <td align="right"><strong>Company Name : </strong></td>
                                                <td><span class="oe_form_group_cell">
                                                  <select name="PBI_ORG" style="width:20px;" id="PBI_ORG">
												  <? foreign_relation('user_group','id','group_name',$_POST['PBI_ORG'],'1 order by id');?>
                                                  </select>
                                                  </span></td>
                                              </tr>
											  
											  
                                              
                                            </tbody>
                                          </table>
                                       
                                          <div style="text-align:center">
             
                                            <input name="show" type="submit" class="btn btn-info" id="show" value="SHOW" />
                                            <? //}else{?>
                                            <input name="submit" type="submit" class="btn btn-danger" id="submit" value="CALCULATE" />
                                            <? //} ?>
                                          </div> <br />
										  
                                          <?



    if(isset($_POST['show'])){



	$yy = date('Y');

	$count = 0;



    $ss = "select PBI_ID from earn_leaves where year='$yy'";



	$qq = db_query($ss);



	$found = mysqli_fetch_object($qq);



	   if($found->PBI_ID>0){



  ?>
                                          <table width="100%" class="table table-bordered table-sm">
                                            <thead align="center">
                                              <tr class="" align="center" style="font-size:10px;padding:3px; background:#2ECCFA;">
                                                <th width="4%">S/L</th>
                                                <th width="7%" >ID</th>
                                                <th width="15%">Full Name</th>
                                                <th width="14%">Designation</th>
                                                <th width="13%">Department</th>
                                                <th width="16%">Company</th>
                                                <th width="10%">Job Period </th>
                                                <th width="5%">Current Earn Leave</th>
												 <th width="10%">Previouse Earn Leave </th>
												  <th width="10%">Carry</th>
                                                <th width="10%">Balance</th>
                                                <th width="20%">Edit</th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                              <?		

			if($_POST['year']!='')	$con .= " and p.year = '".$_POST['year']."'";
			if($_POST['dept']!='')	$con .= " and p.pbi_department = '".$_POST['dept']."'";
			if($_POST['JOB_LOCATION']!='')  $con .= " and p.pbi_job_location = '".$_POST['JOB_LOCATION']."'";
			if($_POST['bonus_type']!='')  $con .= " and p.bonus_type = '".$_POST['bonus_type']."'";
			if($_POST['PBI_ORG']!='')  $con .= " and per.PBI_ORG = '".$_POST['PBI_ORG']."'";
			
			 $sqli = 'select p.year,p.PBI_ID,per.PBI_CODE, p.cut_off_date,p.pbi_department,p.pbi_designation,
			p.AL_earn_by_year,p.AL_earn_by_pre_year,p.AL_Carry,p.AL_Actual_Balance,
			p.pbi_job_location,p.pbi_organization,
			d.DESG_DESC,dept.DEPT_DESC,per.PBI_NAME,p.job_period,p.remarks
			from earn_leaves p,designation d,department dept,personnel_basic_info per 
			where p.pbi_designation=d.DESG_ID AND p.pbi_department=dept.DEPT_ID '.$con.' and 
			p.PBI_ID=per.PBI_ID and p.lock_status=0 order by p.id desc';
			
			$query = db_query($sqli);
			$s = 1 ;
			
			while($info = mysqli_fetch_object($query)){
			$count++;
			$relieving_date = $info->resign_date; // find_a_field('essential_info','ESSENTIAL_RESIG_DATE','PBI_ID='.$info->PBI_ID);

?>
                                              <tr style="font-size:10px; padding:3px; ">
                                                <td><?=$s++;?></td>
                                                <td><?=$info->PBI_CODE?></td>
                                                <td style="color:<? if($relieving_date>0){ echo"red";}?>"><?=$info->PBI_NAME?></td>
                                                <td><?=$info->DESG_DESC?></td>
                                                <td><?=$info->DEPT_DESC?></td>
                                                <td><?=find_a_field('user_group','group_name','id="'.$info->pbi_organization.'"');?></td>
                                                <td align="center"><?=$info->job_period?></td>
      <td><input type="text" value="<?=$info->AL_earn_by_year?>" name="bonus_percent_<?=$info->PBI_ID?>" id="bonus_percent_<?=$info->PBI_ID?>" style="width:100%;"/>
           <input type="hidden" value="<?=$info->basic_salary?>" name="basic_salary_<?=$info->PBI_ID?>" id="basic_salary_<?=$info->PBI_ID?>" />
           <input type="hidden" value="<?=$info->PBI_ID?>" name="PBI_ID_<?=$info->PBI_ID?>" id="PBI_ID_<?=$info->PBI_ID?>" />
          
           <input type="hidden" value="<?=$info->year?>" name="year_<?=$info->PBI_ID?>" id="year_<?=$info->PBI_ID?>" />
                                                </td>
	<td><input type="text" value="<?=$info->AL_earn_by_pre_year?>" name="gross_salary_<?=$info->PBI_ID?>" id="gross_salary_<?=$info->PBI_ID?>" style="width:100%;"/>
                                                </td>
<td><input type="text" value="<?=$info->AL_Carry?>" name="bonus_amt_<?=$info->PBI_ID?>" id="bonus_amt_<?=$info->PBI_ID?>" style="width:100%;"/>
                                                </td>
<td align="center"><input type="text" name="remarks_<?=$info->PBI_ID?>" id="remarks_<?=$info->PBI_ID?>" value="<?=$info->AL_Actual_Balance?>" style="width:100%;" />
                                            </td>
											
                                                <td><input type="hidden" value="<?=$info->PBI_ID?>" name="PBI_ID" />
                                                  <span id="bonus_<?=$info->PBI_ID?>">
                                                  <input type="button" name="edit" value="Edit"  onclick="getData2('bonus_ajax.php', 'bonus_<?=$info->PBI_ID?>', document.getElementById('PBI_ID_<?=$info->PBI_ID?>').value,  document.getElementById('bonus_percent_<?=$info->PBI_ID?>').value+'<#>'+document.getElementById('remarks_<?=$info->PBI_ID?>').value+'<#>'+document.getElementById('bonus_type_<?=$info->PBI_ID?>').value+'<#>'+document.getElementById('year_<?=$info->PBI_ID?>').value)" style="font-size:11px; font-weight: bold; background-color: #1c5fcc; padding:5px 8px; border-radius:3px; border:2px solid #CCC; box-shadow:2px 2px 2px 2px BLUE; color:white; width:100%; height:30px; align:center; padding:0px;" class="click" />
                                                  </span> </td>
                                              </tr>
                                              <? } if($count==0 || $count==''){ ?>
                                              <tr>
           <td colspan="10"><div align="center" style="color:red; font-size:16px; font-weight:bold;">Leave locked or not generated for this period</div></td>
                                              </tr>
                                              <? }?>
                                          </table>
                                          <? } }  ?>
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
                </tr>
              </tbody>
            </table>
    

</div>
</div>


<?




require_once SERVER_CORE."routing/layout.bottom.php";




?>