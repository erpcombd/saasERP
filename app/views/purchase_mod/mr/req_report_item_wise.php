<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Requisition Status Report';

do_calander('#f_date');
do_calander('#t_date');
$tr_type="Show";
$table = 'purchase_master';
$unique = 'req_no';
$status = 'CHECKED';
$target_url = '../pr/chalan_view2.php';

if($_REQUEST[$unique]>0)
{
$_SESSION[$unique] = $_REQUEST[$unique];
header('location:'.$target_url);
}
$tr_from="Purchase";
?>
<script language="javascript">
function custom(theUrl)
{
	window.open('<?=$target_url?>?v_no='+theUrl);
}
</script>


<div class="d-flex justify-content-center">
    <form class="n-form1 pt-4" action="master_report_mr_pending.php" method="post" name="form1" target="_blank" id="form1">
        <div class="row m-0 p-0">
            <div class="col-sm-5">
                <div align="left">Select Report </div>
                <div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="3005" checked="checked" tabindex="1"/>
                    <label class="form-check-label p-0" for="report1-btn">
                        Requisition Summary Report 
                    </label>
                </div>
                

            </div>

            <div class="col-sm-7">
                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Product Name:</label>
                    <div class="col-sm-8 p-0">
						
						<input type="text" list="item" name="item_id" id="item_id" class="form-control" />
                      <datalist id="item">
                        <option></option>
                      
						<? foreign_relation('item_info','item_id','item_name',$item_id,'1 and group_for="'.$_SESSION['user']['group'].'"');?>
                    </datalist>
                    </div>
                </div>
				<div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Product Sub-Category:</label>
                    <div class="col-sm-8 p-0">
						<input type="text" list="sub_group" name="sub_group_id" id="sub_group_id" class="form-control" />
                      <datalist id="sub_group">
					  		<option></option>
							<? foreign_relation('item_sub_group','sub_group_id','sub_group_name',$_POST['sub_group_id'],'group_for="'.$_SESSION['user']['group'].'"');?>
					</datalist>
                    </div>
                </div>

                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">From Date:</label>
                    <div class="col-sm-8 p-0">
                     <input  name="f_date" type="text" id="f_date" value="<?=date('Y-m-01')?>" required autocomplete="off"  class="form-control">
                    </div>
                </div>


                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">To Date:</label>
                    <div class="col-sm-8 p-0">
                      <span class="oe_form_group_cell">
                     <input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d')?>" required autocomplete="off"  class="form-control">
                      </span>

                    </div>
                </div>

                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Vendor Name:</label>
                    <div class="col-sm-8 p-0">

                        <span class="oe_form_group_cell">
							<input type="text" name="vendor_id" id="vendor_id" list="vendor" class="form-control" /> 
                            <datalist id="vendor">
                       		 <option></option>
								<? 
								$sql = "select v.vendor_id,v.vendor_name from vendor v where v.group_for='".$_SESSION['user']['group']."'  order by v.vendor_name";
								foreign_relation_sql($sql);?>
                   			 </datalist>

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