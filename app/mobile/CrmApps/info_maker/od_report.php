<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Apps OD & TADA Report';
require_once '../assets/template/inc.header.php';
do_calander("#f_date");
do_calander("#t_date");
auto_complete_from_db('dealer_info','dealer_code','concat(dealer_code,"-",dealer_name_e)','1','dealer_code');
auto_complete_from_db('dealer_info','dealer_code','concat(dealer_code,"-",dealer_name_e)','1','dealer_code_to');
auto_complete_from_db('item_info','concat(finish_goods_code,"-",item_name)','item_id','1 and product_nature="Salable" and finish_goods_code>0 and finish_goods_code<5000','item_id');?>
<div class="d-flex justify-content-center mt-5">
  <div class="card shadow-lg w-100" style="max-width: 900px;">
    <div class="card-body">
      
      <form class="n-form1" action="master_report.php" method="post" name="form1" target="_blank" id="form1">
        <div class="row">
          
          <!-- Report Selection -->
          <div class="col-md-5 border-right">
            <h6 class="mb-3">Select Report</h6>
            <div class="form-check mb-2">
              <input name="report" type="radio" class="form-check-input" id="report1_btn_20241029" value="20241029" checked>
              <label class="form-check-label" for="report1_btn_20241029">OD & TADA Details (20241029)</label>
            </div>
            <div class="form-check mb-2">
              <input name="report" type="radio" class="form-check-input" id="report1_btn_20241030" value="202410292">
              <label class="form-check-label" for="report1_btn_20241030">TADA Summary Report (202410292)</label>
            </div>
            <div class="form-check mb-2">
              <input name="report" type="radio" class="form-check-input" id="report1_btn_20250806" value="20250806">
              <label class="form-check-label" for="report1_btn_20250806">Conveyance Bill Details Report (20250806)</label>
            </div>
            <div class="form-check">
              <input name="report" type="radio" class="form-check-input" id="report1_btn_202508061" value="202508061">
              <label class="form-check-label" for="report1_btn_202508061">Conveyance Bill Summary Report (202508061)</label>
            </div>
          </div>
          
          <!-- Filters -->
          <div class="col-md-7">
            
            <div class="form-group row mb-1">
              <label for="PBI_ID" class="col-sm-4 col-form-label">Employee Name:</label>
              <div class="col-sm-8">
                <select name="PBI_ID" id="PBI_ID" class="form-control">
                  <option></option>
                  <?php
                  if($_SESSION['employee_selected']==10001){
                    foreign_relation('personnel_basic_info','PBI_ID','PBI_NAME',$_POST['PBI_ID'],'1');
                  }else{
                    foreign_relation('personnel_basic_info','PBI_ID','PBI_NAME',$_POST['PBI_ID'],'PBI_ID="'.$_SESSION['employee_selected'].'"');
                  }
                  ?>
                </select>
              </div>
			  
            </div>
            
            <div class="form-group row mb-1">
              <label for="od_id" class="col-sm-4 col-form-label">Conveyance ID:</label>
              <div class="col-sm-8">
                <input name="od_id" type="text" id="od_id" class="form-control" value="">
              </div>
            </div>
            
            <div class="form-group row mb-1">
              <label for="type" class="col-sm-4 col-form-label">Conveyance Type:</label>
              <div class="col-sm-8">
                <select name="type" id="type" class="form-control">
                  <option value="">Select Type</option>
                  <option value="Food">Food</option>
                  <option value="Transport">Transport</option>
                  <option value="Other">Other</option>
                </select>
              </div>
            </div>
            
            <div class="form-group row mb-1">
              <label for="transport_type" class="col-sm-4 col-form-label">Means of Conveyance:</label>
              <div class="col-sm-8">
                <select name="transport_type" id="transport_type" class="form-control">
                  <option value="">Select Transport Type</option>
                  <option value="Bus">Bus</option>
                  <option value="CNG">CNG</option>
                  <option value="Bike">Bike</option>
                  <option value="Rickshaw">Rickshaw</option>
                  <option value="Other">Other</option>
                </select>
              </div>
            </div>
            
            <div class="form-group row mb-1">
              <label for="project_id" class="col-sm-4 col-form-label">Customer Name:</label>
              <div class="col-sm-8">
                <select class="form-control" name="project_id" id="project_id">
                  <option value="">Select Project Name</option>
                  <?php foreign_relation('crm_project_org','id','name',$project_id,'1'); ?>
                </select>
              </div>
            </div>
            
            <div class="form-group row mb-1">
              <label for="status" class="col-sm-4 col-form-label">Status:</label>
              <div class="col-sm-8">
                <select name="status" id="status" class="form-control">
                  <option value="">Select Status</option>
                  <?php
                    foreign_relation('bills_details','status','status',$_POST['status'],'1 group by status');
                  ?>
                </select>
              </div>
            </div>
            
            <div class="form-group row mb-1">
              <label for="f_date" class="col-sm-4 col-form-label">Start Date:</label>
              <div class="col-sm-8">
                <input name="f_date" type="text" id="f_date" class="form-control" value="<?=date('Y-m-01')?>">
              </div>
            </div>
            
            <div class="form-group row mb-1">
              <label for="t_date" class="col-sm-4 col-form-label">End Date:</label>
              <div class="col-sm-8">
                <input name="t_date" type="text" id="t_date" class="form-control" value="<?=date('Y-m-d')?>">
              </div>
            </div>
            
          </div>
        </div>
        
        <!-- Submit -->
        <div class="text-center mt-3">
          <button type="submit" name="submit" class="btn btn-success px-5">Generate Report</button>
        </div>
      </form>
    </div>
  </div>
</div>


<?
	require_once '../assets/template/inc.footer.php';
	selected_two("#PBI_ID");
?>