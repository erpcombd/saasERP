<?php



require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Attendace Report';

do_calander("#f_date");

do_calander("#t_date");

do_calander("#start_date");

do_calander("#end_date");

//auto_complete_from_db('dealer_info','concat(dealer_code,"-",dealer_name_e)','dealer_code','canceled="Yes"','dealer_code');

auto_complete_from_db('dealer_info','dealer_code','concat(dealer_code,"-",dealer_name_e)','1','dealer_code');

auto_complete_from_db('dealer_info','dealer_code','concat(dealer_code,"-",dealer_name_e)','1','dealer_code_to');

auto_complete_from_db('item_info','concat(finish_goods_code,"-",item_name)','item_id','1 and product_nature="Salable" and finish_goods_code>0 and finish_goods_code<5000','item_id');?>



<!--
<div class="d-flex justify-content-center">

<h1 style="background-color:#00CCFF; color:#FFFFFF; text-align:center"> Daily Basis Reports </h1>
</div>-->



<div class="">

    

    <form class="n-form1 pt-4" action="att_master_report.php" method="post" name="form1" target="_blank" id="form1">
        <div class="row m-0 p-0">
            <div class="col-sm-5">
                <div align="left">Select Daily Basis Report </div>

                <div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="210907001" checked="checked"  />
                    <label class="form-check-label p-0" for="report1-btn">
                        Daily Attendance Report
                    </label>
                </div>
                <div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report2-btn" value="210907002" checked="checked"  />
                    <label class="form-check-label p-0" for="report2-btn">
                        Daily Absence Report
                    </label>
                </div>
                <div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report2-btn" value="2244" />
                    <label class="form-check-label p-0" for="report2-btn">
                        Daily Out Punch Report
                    </label>
                </div>
				
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report2-btn" value="2030" />
                    <label class="form-check-label p-0" for="report2-btn">
                        Daily Attendance Report  New
                    </label>
                </div>

            </div>

            <div class="col-sm-7">
			
			    
			   <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center"> Company :</label>
                    <div class="col-sm-8 p-0">
                        <select name="PBI_ORG" id="PBI_ORG" class="form-control" >
						<option selected>
					  <?=find_a_field('user_group','group_name','id="'.$_POST['PBI_ORG'].'"');?>
						</option>
						<option>
					 <? foreign_relation('user_group','id','group_name',$_POST['PBI_ORG'],' 1');?>
						</option>
					  </select>
                    </div>
                </div>
                
                
			       
		         <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center"> Cost Center :</label>
                    <div class="col-sm-8 p-0">
                        <select name="cost_center" id="cost_center" class="form-control" >
						<option selected>
						<?=find_a_field('hrm_cost_center','center_name','id="'.$_POST['cost_center'].'"');?>
						</option>
						<option>
						<? foreign_relation('hrm_cost_center','id','center_name',$_POST['cost_center'],' 1');?>
						</option>
					  </select>
                    </div>
                </div>
			
				
				
					<div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center"> Class :</label>
                    <div class="col-sm-8 p-0">
                          <select name="class" id="class" class="form-control" >
							<option></option>
							<option selected>
							<?=find_a_field('hrm_class','class_name','id="'.$_POST['class'].'"');?>
							</option>
							<? foreign_relation('hrm_class','id','class_name',$_POST['class'],' 1');?>
						  </select>
                    </div>
                </div>
				
				
	           	<div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center"> Section:</label>
                    <div class="col-sm-8 p-0">
                       <select name="section" id="section" class="form-control" >
						<option></option>
						<option selected>
						<?=find_a_field('PBI_Section','sec_name','sec_id="'.$_POST['section'].'"');?>
						</option>
						<? foreign_relation('PBI_Section','sec_id','sec_name',$_POST['section'],' 1');?>
					  </select>
                    </div>
                </div>
				
				
				  	<div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center"> Job Location :</label>
                    <div class="col-sm-8 p-0">
                        <select name="JOB_LOC_ID" id="JOB_LOC_ID"  class="form-control"  >
						<option></option>
						<option selected>
						<?=find_a_field('project','PROJECT_DESC','PROJECT_ID="'.$_POST['JOB_LOC_ID'].'"');?>
						</option>
						<? foreign_relation('project','PROJECT_ID','PROJECT_DESC',$_POST['JOB_LOC_ID']);?>
					  </select>
                    </div>
                </div>
				
	
	
                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Department:</label>
                    <div class="col-sm-8 p-0">
                        <select name="DEPT_ID" id="DEPT_ID"  >
                            <option></option>
                            <? foreign_relation('department','DEPT_ID','DEPT_DESC',$DEPT_ID,' 1 order by DEPT_DESC');?>
                        </select>
                    </div>
                </div>

        


                

                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Job Status :</label>
                    <div class="col-sm-8 p-0">
                        <select name="JOB_STATUS" id="JOB_STATUS">
                            <option>In Service</option>
                            <option>Not In Service</option>
                        </select>
                    </div>
                </div>


                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Date :</label>
                    <div class="col-sm-8 p-0">
                        <span class="oe_form_group_cell">
                            <input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d')?>"/>


                        </span>

                    </div>
                </div>




            </div>

        </div>
        <div class="n-form-btn-class">
            <input name="submit" type="submit" class="btn1 btn1-bg-submit" value="Report" />
        </div>
    </form>
</div>


<div class="">
    <form class="n-form1 pt-4" action="att_master_report_user.php" method="post" name="form1" target="_blank" id="form1">
        <div class="row m-0 p-0">
            <div class="col-sm-5">
                <div align="left">Select Monthly Basis Report </div>
                <div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="210980001" tabindex="1">
                    <label class="form-check-label p-0" for="report1-btn">
                        Daily Attendance Report
                    </label>
                </div>
			

            </div>

            <div class="col-sm-7">
                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Employee Name:</label>
                    <div class="col-sm-8 p-0">
                       <select name="PBI_ID"  id="PBI_ID">
					    
                        <?
					
						foreign_relation('personnel_basic_info','PBI_ID','PBI_NAME',$_POST['PBI_ID'],'1');
					
						?>
					
                      </select>
                    </div>
                </div>

      			<div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Start Date:</label>
                    <div class="col-sm-8 p-0">
                       <input  name="start_date" type="text" id="start_date" value="<?=date('Y-m-01')?>" />
                    </div>
                </div>


                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">End Date:</label>
                    <div class="col-sm-8 p-0">
                      <span class="oe_form_group_cell">
                        	<input  name="end_date" type="text" id="end_date" value="<?=date('Y-m-d')?>" />
                      </span>

                    </div>
                </div>
				
				
			
                




            </div>

        </div>
        <div class="n-form-btn-class">
            <input name="submit" type="submit" class="btn1 btn1-bg-submit" value="Report" tabindex="6">
        </div>
    </form>
</div>




<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>
