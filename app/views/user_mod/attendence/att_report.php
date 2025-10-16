<?php







//







//








require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";







$title='ATTENDANCE REPORT';















do_calander("#f_date");







do_calander("#t_date");















//auto_complete_from_db('dealer_info','concat(dealer_code,"-",dealer_name_e)','dealer_code','canceled="Yes"','dealer_code');







auto_complete_from_db('dealer_info','dealer_code','concat(dealer_code,"-",dealer_name_e)','1','dealer_code');







auto_complete_from_db('dealer_info','dealer_code','concat(dealer_code,"-",dealer_name_e)','1','dealer_code_to');







auto_complete_from_db('item_info','concat(finish_goods_code,"-",item_name)','item_id','1 and product_nature="Salable" and finish_goods_code>0 and finish_goods_code<5000','item_id');?>



<div class="d-flex justify-content-center">
    <form class="n-form1 pt-4" action="att_master_report.php" method="post" name="form1" target="_blank" id="form1">
        <div class="row m-0 p-0">
            <div class="col-sm-5">
                <div align="left">Select Report </div>
                <div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="210907001" checked="checked" tabindex="1">
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
						if($_SESSION['employee_selected']==10001){
						foreign_relation('personnel_basic_info','PBI_ID','PBI_NAME',$_POST['PBI_ID'],'1');
						}else{
						foreign_relation('personnel_basic_info','PBI_ID','PBI_NAME',$_POST['PBI_ID'],'PBI_ID="'.$_SESSION['employee_selected'].'"');
						}
						?>
					
                      </select>
                    </div>
                </div>

      			<div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Start Date:</label>
                    <div class="col-sm-8 p-0">
                       <input  name="f_date" type="text" id="f_date" value="<?=date('Y-m-01')?>" />
                    </div>
                </div>


                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">End Date:</label>
                    <div class="col-sm-8 p-0">
                      <span class="oe_form_group_cell">
                        	<input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d')?>" />
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

<br /><br />



<?







//







//







require_once SERVER_CORE."routing/layout.bottom.php";







?>
