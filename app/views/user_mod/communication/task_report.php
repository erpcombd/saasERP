<?php

//

//

 
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$head='<link href="../../../assets/css/report_selection.css" type="text/css" rel="stylesheet"/>';

$title = 'Conveyance  Report';

do_calander('#ijdb');

do_calander('#ijda');

do_calander('#ppjdb');

do_calander('#ppjda');

create_combobox('PBI_ID');

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


<div class="d-flex justify-content-center">
  <form class="n-form1 fo-width pt-4" action="crm_master_report.php" autocomplete="off" method="post" name="form1" target="_blank" id="form1">
    <div class="row m-0 p-0">
      <div class="col-sm-5">
        <div align="left">Select Report</div>
        <div class="form-check">
            <input name="report" type="radio" class="radio1" value="205" checked="checked" tabindex="1"/>
            <label class="form-check-label p-0" for="report1-btn">
            Conveyance Report (205)
            </label>
        </div>

        <div class="form-check">
            <input name="report" type="radio" class="radio1" value="2805" tabindex="1"/>
            <label class="form-check-label p-0" for="report1-btn">
            Conveyance Report Summary (2805)
            </label>
        </div>
      </div>
      <div class="col-sm-7">
        <div class="form-group row m-0 mb-1 pl-3 pr-3">
          <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Employee ID :</label>
          <div class="col-sm-8 p-0">
            <input type="text"  list='eip_ids' name="emp_code" id="emp_code" value="<?=$_POST['emp_code']?>" />
            <input type="hidden"  name="emp_code2" id="emp_code2" value="<?=find_a_field('personnel_basic_info','PBI_ID','PBI_CODE='.$_POST['emp_code']);?>" />
            <datalist id='eip_ids'>
              <option></option>
              <?
              foreign_relation('personnel_basic_info','PBI_CODE','concat(PBI_CODE," - ",PBI_NAME)',$emp_code,'1');
              ?>
            </datalist>
          </div>
        </div>

        <div class="form-group row m-0 mb-1 pl-3 pr-3">
          <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Type :</label>
          <div class="col-sm-8 p-0">
            <select name="con_type" id="con_type" class="form-control">
              <option value=""></option>
              <option value="Food">Food</option>
              <option value="Transport">Transport</option>
              <option value="Overtime">Overtime</option>
            </select>
          </div>
        </div>

        <div class="form-group row m-0 mb-1 pl-3 pr-3">
          <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Date From :</label>
          <div class="col-sm-8 p-0">
            <input type="date" name="f_date" id="f_date" class="form-control" style="width:50%;" />
          </div>
        </div>

        <div class="form-group row m-0 mb-1 pl-3 pr-3">
          <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Date To :</label>
          <div class="col-sm-8 p-0">
          <input type="date" name="t_date" id="t_date" class="form-control" style="width:50%;" />
          </div>
        </div>

        <div class="form-group row m-0 mb-1 pl-3 pr-3">
          <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Status :</label>
          <div class="col-sm-8 p-0">
          <select name="status" id="status">
            <option></option>
            <option>PENDING</option>
            <option>LEADER CHECKED</option>
            <option>COMPLETED</option>
          </select>
          </div>
        </div>

      </div>
    </div>

    <div class="n-form-btn-class">
    <input name="submit" type="submit" id="submit" value="&emsp;SHOW&emsp;" class="btn1 btn1-bg-submit" />
    </div>
    
  </form>
</div>


<?

//

//

require_once SERVER_CORE."routing/layout.bottom.php";

?>