<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$head='<link href="../css/report_selection.css" type="text/css" rel="stylesheet"/>';

$title='Bonus Calculation';

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

if($_POST['pbi_id_in']!=''){
$con= ' and s.PBI_ID in('.$_POST['pbi_id_in'].')';}

if(isset($_POST['submit'])){
		 $sql = 'select p.*, s.basic_salary, s.bonus_mode from personnel_basic_info p, salary_info s where p.PBI_ID=s.PBI_ID and p.PBI_JOB_STATUS="In Service" and p.PBI_ORG='.$_POST['PBI_ORG'].$con; // and p.PBI_ID=1867
		$query = db_query($sql);
		$num_rows = mysqli_num_rows($query);
		while($datas = mysqli_fetch_object($query)){
		$prevEntry = find_a_field('salary_bonus','PBI_ID','PBI_ID='.$datas->PBI_ID.' and bonus_type='.$_POST['bonus_type'].' and year='.$_POST['year']);
		$dealer_code = find_a_field('personnel_basic_info p, dealer_info d','d.dealer_code','p.PBI_ID='.$datas->PBI_ID.' and p.PBI_AREA = d.area_code AND d.canceled = "Yes" AND p.PBI_GROUP = d.product_group AND d.dealer_type = "Distributor" AND p.PBI_AREA !=0');
		$bonus_type=$_POST['bonus_type'];
		$year=$_POST['year'];
		$PBI_ID=$datas->PBI_ID;
		$pbi_department=$datas->PBI_DEPARTMENT;
		$pbi_designation= $datas->PBI_DESIGNATION;
		$pbi_organization=$datas->PBI_ORG;
		$pbi_job_location=$datas->JOB_LOCATION;
		$pbi_doj=$datas->PBI_DOJ;
		$job_status=$datas->PBI_PRIMARY_JOB_STATUS;
		$pbi_region=$datas->PBI_BRANCH;
		$pbi_zone=$datas->PBI_ZONE;
		$pbi_area=$datas->PBI_AREA;
		$pbi_group=$datas->PBI_GROUP;
		$pbi_held_up=$datas->held_up_status;
		$basic_salary=$datas->basic_salary;
		$bonus_percentage=$_POST['bonus_percentage'];
		$cut_off_date=$_POST['cut_off_date'];
		
		
		$from=date_create($datas->PBI_DOJ);
		$to=date_create($cut_off_date);
		$diff=date_diff($to,$from);
		
		$bonus_days=($diff->format('%a'))+1;
		
		$bonusAmount=round(($basic_salary/100)*55);
		
		if($datas->PBI_PRIMARY_JOB_STATUS=='Permanent'){
		$bonus_amt=round($bonusAmount);}
		else{
			if($bonus_days>=180){
			$bonus_amt=round($bonusAmount);}
			else{
			$bonus_amt=round(($bonusAmount/180)*$bonus_days);
			}
		}
		
		if($datas->bonus_mode=='Bank'){
		$bank_paid=$bonus_amt;
		$cash_paid=0;}
		else{
		$bank_paid=0;
		$cash_paid=$bonus_amt;}
		
		
		$entry_by=$_SESSION['user']['id'];
		$entry_at=date('Y-m-d');
		
if($prevEntry>0){
$delSql='delete from salary_bonus where PBI_ID='.$prevEntry.' and bonus_type='.$_POST['bonus_type'].' and year='.$_POST['year'];
db_query($delSql);}

if($bonus_days>29){		
 $insSql='INSERT INTO salary_bonus( bonus_type, year, PBI_ID, pbi_department, pbi_designation, pbi_organization, pbi_job_location, pbi_doj, job_status, pbi_region, pbi_zone, pbi_area, pbi_group, pbi_held_up, basic_salary, bonus_percentage, cut_off_date, bonus_days, bonus_amt, bank_paid, cash_paid, entry_by, entry_at, dealer_code) 
		
		VALUES ("'.$bonus_type.'", "'.$year.'", "'.$PBI_ID.'", "'.$pbi_department.'", "'.$pbi_designation.'", "'.$pbi_organization.'", "'.$pbi_job_location.'", "'.$pbi_doj.'", "'.$job_status.'", "'.$pbi_region.'", "'.$pbi_zone.'", "'.$pbi_area.'", "'.$pbi_group.'", "'.$pbi_held_up.'", "'.$basic_salary.'", "'.$bonus_percentage.'", "'.$cut_off_date.'", "'.$bonus_days.'", "'.$bonus_amt.'", "'.$bank_paid.'", "'.$cash_paid.'", "'.$entry_by.'", "'.$entry_at.'", "'.$dealer_code.'")';

db_query($insSql);
			}
		
		$msg = 'Successfully Calculated';
		
		}

}
?>




<form action="" method="post">




    <div class="d-flex justify-content-center">
        <div class="n-form1 fo-width pt-0">
            <div class="container-fluid pt-3">
                <div class="row m-0 p-0">
                    <div class="col-sm-6">

                        <div class="form-group row m-0 mb-1 pl-3 pr-3">
                            <label for="group_for" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Bonus Type :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                               <select name="bonus_type" required = "required" class="form-control">
								<option value="2">Eid-Ul-Adha</option>
								<option value="1">Eid-Ul-Fitre</option>
								
                                </select>
                            </div>
                        </div>

                        <div class="form-group row m-0 mb-1 pl-3 pr-3">
                            <label for="group_for" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Year :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <select name="year" style="width:160px;" id="year" required="required" class="form-control">
                                  <option <?=($year=='2018')?'selected':''?>>2018</option>
                                  <option <?=($year=='2019')?'selected':''?>>2019</option>
                                  <option <?=($year=='2020')?'selected':''?>>2020</option>
								  <option <?=($year=='2021')?'selected':''?>>2021</option>
								  <option <?=($year=='2022')?'selected':''?>>2022</option>
								  <option <?=($year=='2023')?'selected':''?>>2023</option>
								  <option <?=($year=='2024')?'selected':''?>>2024</option>
								  <option <?=($year=='2025')?'selected':''?>>2025</option>
                                </select>
                            </div>
                        </div>


                        <div class="form-group row m-0 mb-1 pl-3 pr-3">
                            <label for="group_for" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Cut off Date :
                            </label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <input name="cut_off_date" type="text" id="cut_off_date" value="<?=$_POST['cut_off_date']?>" class="form-control"/>
                            </div>
                        </div>





                    </div>

                    <div class="col-sm-6">


                        <div class="form-group row m-0 mb-1 pl-3 pr-3">
                            <label for="group_for" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Company :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <select name="PBI_ORG" style="width:160px;" id="PBI_ORG" class="form-control">
                                  <? foreign_relation('user_group','id','group_name',$_POST['PBI_ORG']);?>
                                </select>
                            </div>
                        </div>



                        <div class="form-group row m-0 mb-1 pl-3 pr-3">
                            <label for="group_for" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Bonus % :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <input name="bonus_percentage" type="text" id="bonus_percentage" value="55"  class="form-control"/>
                            </div>
                        </div>




                        <div class="form-group row m-0 mb-1 pl-3 pr-3">
                            <label for="group_for" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">PBI ID IN:</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <input name="pbi_id_in" type="text" id="pbi_id_in" class="form-control" />
                            </div>
                        </div>







                    </div>

                </div>

                <div class="n-form-btn-class">
					<input name="submit" class="btn1 btn1-submit-input" type="submit" id="submit" value="CALCULATE" />
                </div>

            </div>
        </div>

    </div>

    

</form>






<?php /*?><form action="" method="post">
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
                              <th colspan="8"><span style="text-align: center; font-size:18px; color: green"><?=$msg;?></span></th>
                            </tr>
                            <!--<tr class="oe_list_header_columns" style="text-align:center">
                              <th colspan="4"><span style="text-align: center; font-size:18px; color:#09F">Bonus Calculation</span></th>
                            </tr>-->
                          </thead>
                          <tfoot>
                          </tfoot>
                          <tbody>
                            <tr>
                              <td align="right" class="alt"><strong>Bonus Type  : </strong></td>
                              <td align="left" class="alt"><strong>
                                <select name="bonus_type" required = "required" class="form-control">
								<option value="2">Eid-Ul-Adha</option>
								<option value="1">Eid-Ul-Fitre</option>
								
                                </select>
                                </strong></td>
                              <td align="right" class="alt"><strong>Company :</strong></td>
                              <td><span class="alt"><span class="oe_form_group_cell">
                                <select name="PBI_ORG" style="width:160px;" id="PBI_ORG" class="form-control">
                                  <? foreign_relation('user_group','id','group_name',$_POST['PBI_ORG']);?>
                                </select>
                                </span></span></td>
                            </tr>
                            <tr>
                              <td align="right" class="alt">Year  :</td>
                              <td align="left" class="alt"><select name="year" style="width:160px;" id="year" required="required" class="form-control">
                                  <option <?=($year=='2018')?'selected':''?>>2018</option>
                                  <option <?=($year=='2019')?'selected':''?>>2019</option>
                                  <option <?=($year=='2020')?'selected':''?>>2020</option>
								  <option <?=($year=='2021')?'selected':''?>>2021</option>
								  <option <?=($year=='2022')?'selected':''?>>2022</option>
								  <option <?=($year=='2023')?'selected':''?>>2023</option>
								  <option <?=($year=='2024')?'selected':''?>>2024</option>
								  <option <?=($year=='2025')?'selected':''?>>2025</option>
                                </select></td>
                              <td width="40%" align="right" class="alt"><strong>Bonus % </strong>: </td>
                              <td width="10%"><input name="bonus_percentage" type="text" id="bonus_percentage" value="55"  class="form-control"/></td>
                            </tr>
                            
                            <tr  class="alt">
                              <td align="right">Cut off Date : </td>
                              <td align="left"><input name="cut_off_date" type="text" id="cut_off_date" value="<?=$_POST['cut_off_date']?>" class="form-control"/></td>
                              <td align="right"><strong>PBI ID IN:</strong></td>
                              <td><input name="pbi_id_in" type="text" id="pbi_id_in" class="form-control" /></td>
                            </tr>
                          </tbody>
                        </table>
                        <br />
                        <div style="text-align:center">
                          <input name="submit" class="btn1 btn1-bg-submit" type="submit" id="submit" value="CALCULATE" />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="oe_chatter">
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
</form><?php */?>
<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>
