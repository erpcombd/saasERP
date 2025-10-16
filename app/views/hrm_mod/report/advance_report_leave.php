<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$head='<link href="../css/report_selection.css" type="text/css" rel="stylesheet"/>';

$title='Leave Encashment Advance Reporting';

do_calander('#ijdb');
do_calander('#ijda');
do_calander('#ppjdb');
do_calander('#ppjda');
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
?>




<form action="../report/master_report.php" target="_blank" method="post">
    <div class="form-container_large">
        <h4 class="text-center bg-titel bold pt-2 pb-2"> COMPENSATION MANAGEMENT </h4>
        <div class="container-fluid bg-form-titel">
            <div class="row">
                <!--left form-->
                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <div class="container n-form2">
       
                        <div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Company</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <select name="PBI_ORG"  id="PBI_ORG">
                                  <? foreign_relation('user_group','id','group_name',$PBI_ORG);?>
							
                                </select>
                            </div>
                        </div>
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Designation </label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <select name="designation"  id="designation">
								<option></option>
                                 <? foreign_relation('designation','DESG_ID','DESG_DESC',$ESS_DESIGNATION,'1 order by DESG_DESC');?>
                                </select>
                            </div>
                        </div>
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Region </label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <select name="branch"  id="branch">
									<? foreign_relation('branch','BRANCH_ID','BRANCH_NAME',$PBI_BRANCH);?>
								 </select>
                            </div>
                        </div>
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Zone </label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <select name="zone" id="zone" class="form-control">
									<? foreign_relation('zon','ZONE_CODE','ZONE_NAME',$PBI_ZONE);?>
								  </select>
                            </div>
                        </div>
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Section </label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <select name="PBI_DOMAIN" class="form-control">
									<? foreign_relation('domai','DOMAIN_DESC','DOMAIN_DESC',$_POST['PBI_DOMAIN']);?>
								  </select>
                            </div>
                        </div>
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Initail Joining Date (Before) </label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <input name="ijdb" type="text" id="ijdb"  class="form-control">
                            </div>
                        </div>
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">P Post Joining Date (Before) </label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <input name="ppjdb" type="text" id="ppjdb"  class="form-control">
                            </div>
                        </div>
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Eid </label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
							<select name="bonus_type" class="form-control">
							  <option></option>
								<option value="1">Eid-Ul-Fitre</option>
								<option value="2">Eid-Ul-Adha</option>
							  </select>
                            </div>
                        </div>




                    </div>
                </div>

                <!--Right form-->
                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <div class="container n-form2">
                       

                        <div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Department</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <select name="department" id="department" class="form-control">
									<? foreign_relation('department','DEPT_SHORT_NAME','DEPT_DESC',$PBI_DEPARTMENT,' 1 order by DEPT_DESC');?>
								  </select>
                            </div>
                        </div>
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Job Location</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <select name="JOB_LOCATION" id="JOB_LOCATION" class="form-control">
									<? foreign_relation('office_location','ID','LOCATION_NAME',$_POST['JOB_LOCATION'],'1');?>
								  </select>
                            </div>
                        </div>
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Area</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <select name="area" id="area" class=" form-control">
									<? foreign_relation('area','AREA_CODE','AREA_NAME',$PBI_AREA);?>
							</select>
                            </div>
                        </div>
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Group</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <select name="PBI_GROUP" id="PBI_GROUP" class="form-control">
								<? foreign_relation('product_group','group_name','group_name',$PBI_GROUP);?>
							  </select>
                            </div>
                        </div>
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Job Status</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <select name="job_status"  class="form-control">
								  <option></option>
									<option>IN SERVICE</option>
									<option>NOT IN SERVICE</option>
								  </select>
                            </div>
                        </div>
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Initial Joining Date(After)</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <input name="ijda" type="text" id="ijda"  class="form-control">
                            </div>
                        </div>
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">P Post Joining Date(After)</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <input name="ppjda" type="text" id="ppjda" class="form-controls">
                            </div>
                        </div>
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">PBI ID IN</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <input name="pbi_id_in" type="text" id="pbi_id_in" / class="form-control">
                            </div>
                        </div>
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Bank Name</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
							<select name="cash_bank" class="form-control">
								<option selected="selected"> <?=$cash_bank?></option>
								<option <?=($cash_bank=='DBBL')?'selected':'';?>>DBBL</option>
								<option <?=($cash_bank=='ROCKET')?'selected':'';?>>ROCKET</option>
								<option <?=($cash_bank=='NCC')?'selected':'';?>>NCC</option>
								<option <?=($cash_bank=='EBL')?'selected':'';?>>EBL</option>
							  </select>
                            </div>
                        </div>
						
						





                    </div>
                </div>


            </div>

        </div>
		<br />
		<div class="container-fluid bg-form-titel">
            <div class="row">
                
                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">For Payroll (Month)</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <select name="mon" id="mon" required="required">
                                  <option value="01" <?=($mon=='1')?'selected':''?>>Jan</option>
                                  <option value="02" <?=($mon=='2')?'selected':''?>>Feb</option>
                                  <option value="03" <?=($mon=='3')?'selected':''?>>Mar</option>
                                  <option value="04" <?=($mon=='4')?'selected':''?>>Apr</option>
                                  <option value="05" <?=($mon=='5')?'selected':''?>>May</option>
                                  <option value="06" <?=($mon=='6')?'selected':''?>>Jun</option>
                                  <option value="07" <?=($mon=='7')?'selected':''?>>Jul</option>
                                  <option value="08" <?=($mon=='8')?'selected':''?>>Aug</option>
                                  <option value="09" <?=($mon=='9')?'selected':''?>>Sep</option>
                                  <option value="10" <?=($mon=='10')?'selected':''?>>Oct</option>
                                  <option value="11" <?=($mon=='11')?'selected':''?>>Nov</option>
                                  <option value="12" <?=($mon=='12')?'selected':''?>>Dec</option>
                           </select>

                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">For Payroll (Year)</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <select name="year"  id="year" required="required">
                                  <option <?=($year=='2013')?'selected':''?>>2013</option>
                                  <option <?=($year=='2014')?'selected':''?>>2014</option>
                                  <option <?=($year=='2015')?'selected':''?>>2015</option>
                                  <option <?=($year=='2016')?'selected':''?>>2016</option>
                                  <option <?=($year=='2017')?'selected':''?>>2017</option>
                                  <option <?=($year=='2018')?'selected':''?>>2018</option>
                                  <option <?=($year=='2019')?'selected':''?>>2019</option>
                                  <option <?=($year=='2020')?'selected':''?>>2020</option>
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
                                </select>

                        </div>
                    </div>
                </div>

            </div>
        </div>
		<br/>

        <h4 class="text-center bg-titel bold pt-2 pb-2">
            Select report
        </h4>

        <div class="container-fluid p-0 ">
<!--            table start hear-->
            <table class="table1  table-striped table-bordered table-hover table-sm">
                <thead class="thead1">
                <tr class="bgc-info">
                    <th  width="5%"></th>
                    <th class="text-left"></th>
					 <th  width="5%"></th>
                    <th class="text-left"></th>
                </tr>
                </thead>
                <tbody class="tbody1">


                <tr>
                    <td><input type="radio" placeholder="test 2" id="1" id="report" name="report" value="208" checked="checked"/></td>
                    <td class="bold" align="left"> <label for="1">Employee Leave Consumption Report-2020(208)</label> </td>
					
					<td><input type="radio" placeholder="test 2" id="2" id="report" name="report" value="203"/></td>
                    <td class="bold" align="left"> <label for="2">Employee Leave Encashment Report 2020 Final (203)</label> </td>
                </tr>
				
				 <tr>
                    <td><input type="radio" id="8" placeholder="test 2" id="report" name="report" value="202"/></td>
                    <td class="bold" align="left"> <label for="8">Employee Leave Consumption Report-2019(202)</label> </td>
					
					<td><input type="radio" placeholder="test 2" id="4" id="report" name="report" value="201" /></td>
                    <td class="bold" align="left"> <label for="4">Employee Leave Encashment Report-2019(201)</label> </td>
                </tr>
				<tr>
                    <td><input type="radio" placeholder="test 2" id="3" id="report" name="report" value="205" /></td>
                    <td class="bold" align="left"> <label for="3">Store wise summary report (205)</label> </td>
					
					<td><input type="radio" placeholder="test 2" id="5" id="report" name="report" value="207"/></td>
                    <td class="bold" align="left"> <label for="5">Store wise summary report (207)</label> </td>
                </tr>
				<tr>
                    <td><input type="radio" id="6" placeholder="test 2" id="report" name="report" value="206"/></td>
                    <td class="bold" align="left"> <label for="6">Region wise summary report (206)</label> </td>
					
					<td><input type="radio" placeholder="test 2" id="7" id="report" name="report" value="301" /></td>
                    <td class="bold" align="left"> <label for="7">Factory Leave Report-2019 (301)</label> </td>
                </tr>
				
				
				


                </tbody>
            </table>


            <div class="n-form-btn-class">
                <!--            button code hear-->
                <input name="submit" type="submit" class="btn1 btn1-bg-submit" id="submit" value="SHOW" />
            </div>

        </div>
    </div>

</form>



<?php /*?><form action="../report/master_report.php" target="_blank" method="post">
<div class="oe_view_manager oe_view_manager_current">
        
        <div class="oe_view_manager_body">
            
                <div  class="oe_view_manager_view_list"></div>
            
                <div class="oe_view_manager_view_form"><div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">
        <div class="oe_form_buttons"></div>
        <div class="oe_form_sidebar"></div>
        <div class="oe_form_pager"></div>
        <div class="oe_form_container"><div class="oe_form">
          <div class="">
<div class="oe_form_sheetbg">
        <div class="oe_form_sheet oe_form_sheet_width">

          <div  class="oe_view_manager_view_list"><div  class="oe_list oe_view">
<table width="100%" border="0" class="oe_list_content"><thead>
<!--<tr class="oe_list_header_columns" style="text-align:center">
  <th colspan="4"><span style="text-align: center; font-size:18px; color:#09F">Advance Reporting</span></th>
  </tr>-->
<!--<tr class="oe_list_header_columns" style="text-align:center">
  <th colspan="4"><span style="text-align: center; font-size:16px; color:#C00">Select Options</span></th>
  </tr>-->
</thead><tfoot>
</tfoot><tbody>
  <tr>
    <td align="right" class="alt"><strong>Company :</strong></td>
    <td align="left" class="alt"><span class="oe_form_group_cell">
      <select name="PBI_ORG" style="width:160px;" id="PBI_ORG" class="form-control">
        <? foreign_relation('user_group','id','group_name',$PBI_ORG);?>
      </select>
    </span></td>
    <td width="40%" align="right" class="alt"><strong>Department :</strong></td>
    <td width="10%"><span class="oe_form_group_cell">
      <select name="department" style="width:160px;" id="department" class="form-control">
        <? foreign_relation('department','DEPT_SHORT_NAME','DEPT_DESC',$PBI_DEPARTMENT,' 1 order by DEPT_DESC');?>
      </select>
    </span></td>
  </tr>

  <tr  class="alt">
    <td align="right"><strong>Designation :</strong></td>
    <td align="left"><span class="oe_form_group_cell">
      <select name="designation" style="width:160px;" id="designation" class="form-control">
        <? foreign_relation('designation','DESG_SHORT_NAME','DESG_DESC',$designation,' 1 order by DESG_DESC');?>
      </select>
    </span></td>
    <td align="right"><strong>Job Location:</strong></td>
    <td><span class="oe_form_group_cell">
      <select name="JOB_LOCATION" id="JOB_LOCATION" class="form-control">
        <? foreign_relation('office_location','ID','LOCATION_NAME',$_POST['JOB_LOCATION'],'1');?>
      </select>
    </span></td>
  </tr>
  <tr >
    <td align="right"><strong>Region :</strong></td>
    <td><span class="oe_form_group_cell">
      <select name="branch" style="width:160px;" id="branch">
        <? foreign_relation('branch','BRANCH_ID','BRANCH_NAME',$PBI_BRANCH);?>
      </select>
    </span></td>
    <td align="right"><strong>Area :</strong></td>
    <td><span class="oe_form_group_cell">
      <select name="area" style="width:160px;" id="area" class=" form-control">
        <? foreign_relation('area','AREA_CODE','AREA_NAME',$PBI_AREA);?>
        </select></span></td>
  </tr>
  <tr >
    <td align="right"><strong>Zone :</strong></td>
    <td align="left"><span class="oe_form_group_cell">
      <select name="zone" style="width:160px;" id="zone" class="form-control">
        <? foreign_relation('zon','ZONE_CODE','ZONE_NAME',$PBI_ZONE);?>
      </select>
    </span></td>
    <td align="right"><strong>Group  :</strong></td>
    <td><span class="oe_form_group_cell">
      <select name="PBI_GROUP" style="width:160px;" id="PBI_GROUP" class="form-control">
        <? foreign_relation('product_group','group_name','group_name',$PBI_GROUP);?>
      </select></span></td>
  </tr>
  <tr >
    <td align="right"><strong>Section:</strong></td>
    <td align="left"><strong>
      <select name="PBI_DOMAIN" class="form-control">
        <? foreign_relation('domai','DOMAIN_DESC','DOMAIN_DESC',$_POST['PBI_DOMAIN']);?>
      </select>
    </strong></td>
    <td align="right"><strong>Job Status :</strong></td>
    <td><span class="oe_form_group_cell">
      <select name="job_status" style="width:160px;" class="form-control">
      <option></option>
        <option>IN SERVICE</option>
        <option>NOT IN SERVICE</option>
      </select></span></td>
  </tr>
  <tr >
    <td align="right"><strong>Initial Joining Date(Before) :</strong></td>
    <td align="left"><input name="ijdb" type="text" id="ijdb" size="30" style="width:160px;" / class="form-control"></td>
    <td align="right"><strong>Initial Joining Date(After) :</strong></td>
    <td><input name="ijda" type="text" id="ijda" size="30" style="width:160px;" / class="form-control"></td>
  </tr>
  <tr >
    <td align="right"><strong>P Post Joining Date(Before)  :</strong></td>
    <td align="left"><input name="ppjdb" type="text" id="ppjdb" size="30" style="width:160px;" / class="form-control"></td>
    <td align="right"><strong>P Post  Joining Date(After)  :</strong></td>
    <td><input name="ppjda" type="text" id="ppjda" size="30" style="width:160px;" / class="form-controls"></td>
  </tr>
  <tr >
    <td align="right"><strong>Eid : </strong></td>
    <td align="left"><strong>
      <select name="bonus_type" class="form-control">
	  <option></option>
        <option value="1">Eid-Ul-Fitre</option>
		<option value="2">Eid-Ul-Adha</option>
      </select>
    </strong></td>
    <td align="right"><strong>PBI ID IN:</strong></td>
    <td><input name="pbi_id_in" type="text" id="pbi_id_in" / class="form-control"></td>
  </tr>
  <tr >
    <td align="right">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="right"><strong>Bank Name   :</strong></td>
    <td><span class="oe_form_group_cell">
      <select name="cash_bank" class="form-control">
        <option selected="selected"> <?=$cash_bank?></option>
        <option <?=($cash_bank=='DBBL')?'selected':'';?>>DBBL</option>
        <option <?=($cash_bank=='ROCKET')?'selected':'';?>>ROCKET</option>
        <option <?=($cash_bank=='NCC')?'selected':'';?>>NCC</option>
        <option <?=($cash_bank=='EBL')?'selected':'';?>>EBL</option>
      </select>
    </span></td>
  </tr>
  <tr >
    <td align="right" bgcolor="#FF99FF">(For Payroll) Month  :</td>
    <td align="left" bgcolor="#FF99FF"><span class="oe_form_group_cell">
      <select name="mon" style="width:160px;" id="mon" required="required" class="form-control">
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
    </span></td>
    <td align="right" bgcolor="#FF99FF">(For Payroll) Year  :</td>
    <td bgcolor="#FF99FF"><select name="year" style="width:160px;" id="year" required="required" class="form-control">
		<option <?=($year=='2020')?'selected':''?>>2020</option>
	  	<option <?=($year=='2021')?'selected':''?>>2021</option>
		<option <?=($year=='2022')?'selected':''?>>2022</option>
		<option <?=($year=='2023')?'selected':''?>>2023</option>
		<option <?=($year=='2024')?'selected':''?>>2024</option>
		<option <?=($year=='2025')?'selected':''?>>2025</option>
    </select></td>
  </tr>
  </tbody></table>
<br /><div style="text-align:center">
<table width="100%" class="oe_list_content">
  <thead>
<tr class="oe_list_header_columns">
  <th colspan="4"><span style="text-align: center; font-size:16px; color:#C00">Select Report</span></th>
  </tr>
  </thead>
  <tfoot>
  </tfoot>
  <tbody>
	      <tr  class="alt">
	        <td align="center"><input name="report" type="radio" class="radio" value="208" /></td>
	        <td><strong>Employee Leave Consumption Report-2020(208)</strong></td>
	        <td align="center">&nbsp;</td>
	        <td>&nbsp;</td>
	        </tr>
	      <tr  class="alt">
	        <td align="center"><input name="report" type="radio" class="radio" value="203" /></td>
	        <td><strong>Employee Leave Encashment Report 2020 Final (203)</strong></td>
	        <td align="center">&nbsp;</td>
	        <td>&nbsp;</td>
	        </tr>
	      <tr  class="alt">
	        <td align="center">&nbsp;</td>
	        <td>&nbsp;</td>
	        <td align="center">&nbsp;</td>
	        <td>&nbsp;</td>
	        </tr>
	      <tr  class="alt">
	        <td width="4%" align="center"><input name="report" type="radio" class="radio" value="202"></td>
	        <td width="44%"><strong>Employee Leave Consumption Report-2019(202)</strong></td>
	        <td width="4%" align="center">&nbsp;</td>
	        <td width="44%">&nbsp;</td>
	        </tr>
	      <tr  class="alt">
	        <td align="center"><input name="report" type="radio" class="radio" value="201"  /></td>
	        <td><strong>Employee Leave Encashment Report-2019(201)</strong></td>
	        <td align="center">&nbsp;</td>
	        <td>&nbsp;</td>
	        </tr>
	      <tr  class="alt">
	        <td align="center">&nbsp;</td>
	        <td>&nbsp;</td>
	        <td align="center">&nbsp;</td>
	        <td>&nbsp;</td>
	        </tr>
	      <tr  class="alt">
	        <td align="center">&nbsp;</td>
	        <td>&nbsp;</td>
	        <td align="center">&nbsp;</td>
	        <td>&nbsp;</td>
	        </tr>
	      
<? if($_SESSION['user']['username']=='faysal'){ ?>	 
		  <tr  class="alt">
	        <td align="center"><input name="report" type="radio" class="radio" value="204" /></td>
	        <td><strong>Friday Working Bill(204)</strong></td>
	        <td align="center">&nbsp;</td>
	        <td>&nbsp;</td>
	        </tr> <? } ?>
	      
		  <tr  class="alt">
		    <td align="center"><input name="report" type="radio" class="radio" value="205" /></td>
		    <td><strong>Store wise summary report (205)</strong></td>
	        <td align="center">&nbsp;</td>
	        <td>&nbsp;</td>
	        </tr>
	      <tr  class="alt">
	        <td align="center"><input name="report" type="radio" class="radio" value="207" /></td>
	        <td><strong>Store wise summary report (207)</strong></td>
	        <td align="center">&nbsp;</td>
	        <td>&nbsp;</td>
	        </tr>
	      <tr  class="alt">
	        <td align="center"><input name="report" type="radio" class="radio" value="206" /></td>
	        <td><strong>Region wise summary report (206)</strong></td>
	        <td align="center">&nbsp;</td>
	        <td>&nbsp;</td>
	        </tr>
	      <tr  class="alt">
	        <td align="center">&nbsp;</td>
	        <td>&nbsp;</td>
	        <td align="center">&nbsp;</td>
	        <td>&nbsp;</td>
	        </tr>
	      <tr  class="alt">
	        <td align="center"><input name="report" type="radio" class="radio" value="301"></td>
	        <td><strong>Factory Leave Report-2019 (301)</strong></td>
	        <td align="center">&nbsp;</td>
	        <td>&nbsp;</td>
	        </tr>
<!--    <tr >
      <td align="center" class="alt"><input name="report" type="radio" class="radio" value="5" /></td>
      <td class="alt"><strong>Salary Payroll Report (Detail)</strong><strong></strong></td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      </tr>
    <tr >
      <td align="center" class="alt"><input name="report" type="radio" class="radio" value="6" /></td>
      <td class="alt"><strong>Salary Payroll Report (Summary)</strong><strong></strong></td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>-->
    <tr >
      <td align="center" class="alt">&nbsp;</td>
      <td class="alt">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </tbody>
</table>
<input name="submit" type="submit" class="btn1 btn1-bg-submit" id="submit" value="SHOW" />
          </div></div></div>
          </div>
    </div>
    <div class="oe_chatter"><div class="oe_followers oe_form_invisible">
      <div class="oe_follower_list"></div>
    </div></div></div></div></div>
    </div></div>
            
        </div>
  </div>
</form><?php */?>
<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>