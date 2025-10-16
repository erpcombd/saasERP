<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Local Purchase Report';

do_calander("#f_date");
do_calander("#t_date");
?>


<div class="d-flex justify-content-center">
    <form class="n-form1 pt-4" action="master_report.php" method="post" name="form1" target="_blank" id="form1">
        <div class="row m-0 p-0">
            <div class="col-sm-5">
                <div align="left">Select Report </div>
                <div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="1105" checked="checked" />
                    <label class="form-check-label p-0" for="report1-btn">
                       Local Purchase Order Report(1105)
                    </label>
                </div>
                

            </div>

            <div class="col-sm-7">
                

                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Product Name:</label>
                    <div class="col-sm-8 p-0">
                        <select name="item_id" id="item_id" class="form-control">
                       		 <option></option>
                      
							<? foreign_relation('item_info','item_id','item_name',$item_id);?>
                   		 </select>
                    </div>
                </div>


                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">From Date:</label>
                    <div class="col-sm-8 p-0">
                      <span class="oe_form_group_cell">
					  <input  name="f_date" type="text" id="f_date" value="" autocomplete="off" / class="form-control">
<?php /*?> <input  name="f_date" type="text" id="f_date" value="<?=date('Y-m-01')?>" required autocomplete="off" / class="form-control"><?php */?>
                      </span>

                    </div>
                </div>

                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">To Date:</label>
                    <div class="col-sm-8 p-0">

                        <span class="oe_form_group_cell">
                           <input  name="t_date" type="text" id="t_date" value="" autocomplete="off" / class="form-control">
						   
                       <?php /*?>    <input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d')?>" required autocomplete="off" / class="form-control"><?php */?>

                        </span>


                    </div>
                </div>
				
				<div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Status:</label>
                    <div class="col-sm-8 p-0">

                        <span class="oe_form_group_cell">
                           <select name="status" id="status" class="form-control">
					  			<option></option>
							<? 
			$sql="SELECT a.or_no,a.status FROM `warehouse_other_receive` a WHERE status='checked' or status='unchecked' or status='manual' group by status";
							advance_foreign_relation($sql,$status);	  
							?>
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