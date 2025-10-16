<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Import Receive Detail Report';

do_calander("#f_date");
do_calander("#t_date");
auto_complete_from_db('item_info','item_name','item_id','1 ','item_id');
?>
<div class="d-flex justify-content-center">
  <form class="n-form1 fo-width pt-4" action="master_report.php"  autocomplete="off" method="post" name="form1" target="_blank" id="form1">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <div class="row m-0 p-0">
      <div class="col-sm-5">
          <div align="left">Select Report </div>
            <div class="form-check">
                <input name="report" type="radio" class="radio1" id="report1-btn" value="5" checked="checked" tabindex="1"/>
                <label class="form-check-label p-0" for="report1-btn">
                Import Receive Report
                </label>
            </div>
      </div>
      <div class="col-sm-7">
        <div class="form-group row m-0 mb-1 pl-3 pr-3">
            <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Item Name:</label>
            <div class="col-sm-8 p-0">
              <input type="text" name="item_id" id="item_id" style="width:250px" class="form-control" />
              <datalist id="sub_group">
                  <option></option>
                    <? foreign_relation('item_sub_group','item_brand','item_brand');?>
              </datalist>
            </div>
        </div>
        <div class="form-group row m-0 mb-1 pl-3 pr-3">
            <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">From Date</label>
            <div class="col-sm-8 p-0">
            <input  name="f_date" type="text" id="f_date" value="<?=date('Y-m-01')?>" style="width:250px" class="form-control" />
            </div>
        </div>
        <div class="form-group row m-0 mb-1 pl-3 pr-3">
            <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">To Date</label>
            <div class="col-sm-8 p-0">
              <span class="oe_form_group_cell">
              <input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d')?>" style="width:250px" class="form-control" />
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
<?
$tr_from="Purchase";
require_once SERVER_CORE."routing/layout.bottom.php";

?>