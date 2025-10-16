<?php



 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$title='Product Advance Reports';


$tr_type="Show";


do_calander("#f_date");


do_calander("#t_date");


auto_complete_from_db('dealer_info','concat(dealer_code,"-",product_group,"-",dealer_name_e)','dealer_code','dealer_type="Distributor" and canceled="Yes"','dealer_code');

$tr_from="Warehouse";
?>






<div class="d-flex justify-content-center">
    <form class="n-form1 pt-4" action="master_report.php" method="post" name="form1" target="_blank" id="form1">
        <div class="row m-0 p-0">
            <div class="col-sm-5">
                <div align="left">Select Report </div>
             
                <div class="form-check">
             
					<input name="report" type="radio" class="radio1" id="report2-btn"  value="888811"  tabindex="2"/>
                    <label class="form-check-label p-0" for="report2-btn">
                        Product Information Report
                    </label>
                </div>
				
				
				<div class="form-check">
              
					<input name="report" type="radio" class="radio1" id="report2-btn"  value="888823"  tabindex="2"/>
                    <label class="form-check-label p-0" for="report2-btn">
                        Product Stock Alert Report
                    </label>
                </div>
				
				<div class="form-check">
                   
					<input name="report" type="radio" class="radio1" id="report3-btn"  value="2019"  tabindex="2"/>
                    <label class="form-check-label p-0" for="report3-btn">
                        Barcode Print Report
                    </label>
                </div>

            </div>

            <div class="col-sm-7">
                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Form Date:</label>
                    <div class="col-sm-8 p-0">
                        <input class="m-0" name="f_date" type="text" id="f_date" value="<?=date('Y-m-01')?>"/>
                    </div>
                </div>

                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">To Date:</label>
                    <div class="col-sm-8 p-0">
                        <input  class="m-0" name="t_date" type="text" id="t_date" value="<?=date('Y-m-d')?>"/>
                    </div>
                </div>


                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Item Name</label>
                    <div class="col-sm-8 p-0">
                      <span class="oe_form_group_cell">
                        <select name="item_id" id="item_id">
                          <option></option>
                          <?=foreign_relation('item_info','item_id','item_name','1');?>
                      </select>
                      </span>

                    </div>
                </div>

                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Product Group</label>
                    <div class="col-sm-8 p-0">

                        <span class="oe_form_group_cell">

                          <select name="group_id" id="group_id" tabindex="3" onchange="getData2('item_sub_group_ajax.php', 'item_sub_group', this.value,document.getElementById('group_id').value);">

                              <option></option>
                              <? foreign_relation('item_group','group_id','group_name',$group_id,' 1');?>

                          </select>

                        </span>


                    </div>
                </div>


                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Product Sub Group</label>
                    <div class="col-sm-8 p-0">
                        <span class="oe_form_group_cell">

                              <select name="item_sub_group" tabindex="4">

                                <option></option>

                                <? foreign_relation('item_sub_group','sub_group_id','sub_group_name',$item_sub_group, '1');?>

                              </select>


                        </span>

                    </div>
                </div>




            </div>

        </div>
        <div class="n-form-btn-class">
            <input name="submit" type="submit" class="btn1 btn1-bg-submit" value="Report" tabindex="6" />
        </div>
    </form>
</div>




















<?


require_once SERVER_CORE."routing/layout.bottom.php";

?>
