<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='User Action Reports	';


$php_ip=substr($_SESSION['php_ip'],0,11);
if($php_ip=='115.127.35.' || $php_ip=='192.168.191'){ 
do_calander('#f_date'/*,'-1800','0'*/);
do_calander('#t_date'/*,'-1800','30'*/);
} else {
	do_calander('#f_date'/*,'-60','0'*/);
	do_calander('#t_date'/*,'-60','0'*/);		
}



do_calander("#cut_date");
?>




<div class="d-flex justify-content-center">
    <form class="n-form1 pt-4" action="master_report.php" method="post" name="form1" target="_blank" id="form1">
        <div class="row m-0 p-0">
            <div class="col-sm-5">
                <div class="text-start">Select Report </div>
              <div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn1" value="1" checked="checked" />
                    <label class="form-check-label p-0" for="report1-btn1">User Action Log</label>
                    </div>
					<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn2" value="2"/>
                    <label class="form-check-label p-0" for="report1-btn2">User transaction Report</label>
                    </div>

                

            </div>

            <div class="col-sm-7">
                

                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">User Name:</label>
                    <div class="col-sm-8 p-0">
                        <select name="user_id" id="user_id" class="form-control">
                       		 <option></option>
                      
							<? foreign_relation('user_activity_management','user_id','fname',$user_id,'1 order by fname asc');?>
                   		 </select>
                    </div>
                </div>
				
				<div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Module Name:</label>
                    <div class="col-sm-8 p-0">
                        <select name="mod_id" id="mod_id" class="form-control">
                       		 <option></option>
                      
							<? foreign_relation('user_module_manage','id','module_name',$mod_id,'1');?>
                   		 </select>
                    </div>
                </div>
				
				


                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">From Date:</label>
                    <div class="col-sm-8 p-0">
                      <span class="oe_form_group_cell">
                        <input  name="f_date" type="text" id="f_date" value="<?=date('Y-m-01')?>" required/>
                      </span>

                    </div>
                </div>

                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">To Date:</label>
                    <div class="col-sm-8 p-0">
                        <input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d')?>" required/>
                    </div>
                </div>
	
            </div>

        </div>
        <div class="n-form-btn-class">
			
            <input name="submit" type="submit" class="btn1 btn1-bg-submit" value="Report" />
        </div>
    </form>
</div>



<?
require_once SERVER_CORE."routing/layout.bottom.php";

?>