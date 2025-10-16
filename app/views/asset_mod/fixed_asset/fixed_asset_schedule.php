<?php

//

//


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Fixed Asset Schedule';



do_calander("#f_date");

do_calander("#t_date");



//auto_complete_from_db('dealer_info','concat(dealer_code,"-",dealer_name_e)','dealer_code','canceled="Yes"','dealer_code');

auto_complete_from_db('dealer_info','dealer_code','concat(dealer_code,"-",dealer_name_e)','1','dealer_code');

auto_complete_from_db('dealer_info','dealer_code','concat(dealer_code,"-",dealer_name_e)','1','dealer_code_to');

auto_complete_from_db('item_info','concat(finish_goods_code,"-",item_name)','item_id','1 and product_nature="Salable" and finish_goods_code>0 and finish_goods_code<5000','item_id');?>










    <div class="d-flex justify-content-center">
        <form class="n-form1 pt-4" action="fixed_ass_master_report.php" method="post" name="form1" target="_blank" id="form1">
            <div class="row m-0 p-0">
                <div class="col-sm-5">
                    <div align="left">Select Report </div>
                    <div class="form-check">
                        <input name="report" type="radio" class="radio1" id="report1-btn" value="230303001"  checked="checked" />
                        <label class="form-check-label p-0" for="report1-btn">
                           Fixed Asset Schedule
                        </label>
                    </div>
                    

                </div>

                <div class="col-sm-7">


 <div class="form-group row m-0 mb-1 pl-3 pr-3">
                        <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Company :	</label>
                        <div class="col-sm-8 p-0">
                            <select name="group_for" id="group_for" required>
                            <option></option>
                            <? foreign_relation('user_group','id','group_name',$_POST['group_for'],'1')?>
                            </select>
                        </div>
                    </div>

    <div class="form-group row m-0 mb-1 pl-3 pr-3">
                        <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Asset Group :	</label>
                        <div class="col-sm-8 p-0">
                            <input list="group_list" name="group_id" type="text" value="" id="group_id" autocomplete="off">
					<datalist id="group_list">
<? foreign_relation('item_group','concat(group_name,"#",group_id)','""',$item_id,'ptype="asset"')?>
				</datalist>
                        </div>
                    </div>
					
					<div class="form-group row m-0 mb-1 pl-3 pr-3">
                        <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Asset Sub Group :	</label>
                        <div class="col-sm-8 p-0">
                            <input list="itms" name="sub_group_id" type="text" value="" id="sub_group_id" autocomplete="off">
					<datalist id="itms">
<? foreign_relation('item_sub_group s,item_group g','concat(s.sub_group_name,"#",s.sub_group_id)','""',$item_id,'s.group_id=g.group_id and g.ptype="asset"')?>
				</datalist>
                        </div>
                    </div>
        

    
		
		<div class="form-group row m-0 mb-1 pl-3 pr-3">

          <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Branch:</label>

          <div class="col-sm-8 p-0">

 <input list="branchList" name="warehouse_id" type="text" value="" id="warehouse_id" autocomplete="off">
					<datalist id="branchList">
<? foreign_relation('warehouse','concat(warehouse_name,"#",warehouse_id)','""',$_POST['warehouse_id'],'1')?>
				</datalist>

          </div>

        </div>
		
		 <div class="form-group row m-0 mb-1 pl-3 pr-3">
                        <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">From :</label>
                        <div class="col-sm-8 p-0">
                      <span class="oe_form_group_cell">
                        <input  name="f_date" type="text" id="f_date" value="<?=date('Y-01-01')?>" class="form-control"/>
                      </span>

                        </div>
                    </div>

                    <div class="form-group row m-0 mb-1 pl-3 pr-3">
                        <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">To :</label>
                        <div class="col-sm-8 p-0">

                        <span class="oe_form_group_cell">
                            <input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d')?>" class="form-control"/>

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

//

//

require_once SERVER_CORE."routing/layout.bottom.php";

?>