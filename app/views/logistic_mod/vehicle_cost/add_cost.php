<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL); 


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title = 'Vehicle Cost Add';

$table_master = 'vehicle_cost_master';
$table_details = 'vehicle_req_cost ';

$crud = new crud($table_master);

$crud2= new crud($table_details);


$cost_no = $_GET["id"];
$req_no = $_GET["req_no"];

$req_info = 'SELECT * FROM vehicle_cost_master  WHERE id = "'.$_GET["id"].'" ';

$req_res=db_query($req_info);

$req_rows = mysqli_fetch_object($req_res);


if(isset($_POST['create_new'])){
    
    $_POST['entry_by'] = $_SESSION['user']['id'];
    $cost_no=$crud->insert();
    header("Location: add_cost.php?id=" . $cost_no . "&req_no=" . $_POST['req_no']);
    //  exit(); 
} 

if(isset($_POST['update_cost'])){
    
    $_POST['update_by'] = $_SESSION['user']['id'];
    $_POST['update_at'] = date("Y-m-d H:i:s");
    $crud->update('id');
    header("Location: add_cost.php?id=" . $_POST['id'])."&req_no=" . $req_no;
     exit(); 
}


if(isset($_POST['add_new_cost'])){
    $_POST['entry_by'] = $_SESSION['user']['id'];
    $crud2->insert();
    header("Location: add_cost.php?id=" . $_POST['cost_id'] . "&req_no=" . $req_no);
    exit(); 
} 

$vehcilinfo_qry = 'SELECT * FROM vehicle_information WHERE 1';
$vehicle_res = db_query($vehcilinfo_qry);
while($v_rows = mysqli_fetch_object($vehicle_res)){
  $v_model[$v_rows->id] = $v_rows->vehicle_model;
  $v_reg_no[$v_rows->id] = $v_rows->reg_number;
}

?>

<link rel="stylesheet" href="https://www.jqueryscript.net/demo/Rich-Text-Editor-jQuery-RichText/richtext.min.css">
<style>
  .richText {
    border: #ccc solid 1px !important;
  }

  .richText .richText-toolbar {
    border-bottom: #ccd solid 1px;
  }
</style>
<style>
  .openerp td {
    padding: 5px 0px !important;
  }
  h3 {
  font-size: 20px !important;
  }
</style>

<div class="" style='display:flex; justify-content:center;flex-direction:column'>
<!--create cost-->
    <div class='col-xs-12 col-md-12'>
    <form action="?" method="post"onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
    
  <div class="form-container_large" >
    <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
      <tr>
        <td colspan="4">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="11%">
                <label for="label">Cost Id:</label>
              </td>
              <td width="39%">
                <a type="text" class="form-control" readonly><?=$cost_no?> </a>
                <input name="id" type="text" id="id" value="<?=$cost_no?>" class="form-control" hidden />
              </td>
              <td width="10%">&nbsp;</td>
              
              <td>
                <label for="label">Req No:</label>
              </td>
              <td>  
              <a  type="text" class="form-control" readonly><?=$req_no?> </a>
              <input name="req_no" type="text" id="req_no" value="<?=$req_no?>" class="form-control" hidden />
            </td>
            </tr>
            
            <tr>
              <td width="10%">
                <label >Driver: </label>
              </td>
              <td width="32%"><select name="driver_id" id="driver_id" class="form-select form-control" data-live-search="true" tabindex="4" required>
                    <option value="">--SELECT--</option>
			    <? foreign_relation('vehicle_driver_info','id','d_name',$req_rows->driver_id," 1 order by id");?>
	            </select></td>
             
	          <td>&nbsp;</td>
              <td>
                <label for="label">Date:</label>
              </td>
              <td><input name="entry_date" type="date" id="entry_date" value="<?=$req_rows->entry_date ?>" required="required" class="form-control"  /></td>
            </tr>
             <tr>
                 
              <td>
                <label for="label">Vehicle:</label>
              </td>
              <td>
                <?   
                // $v_model[$v_rows->id] ;
                // $v_reg_no[$v_rows->id];vehicle_id
                $v_id = find_a_field('vehicle_req_list','approved_vehicle','id="'.$req_no.'"');
                ?>
                 <a type="text" class="form-control" readonly><?=$v_model[$req_no] ?> ::  <?=$v_reg_no[$req_no] ?> </a>
                 <input name="vehicle_id" type="text" id="vehicle_id" value="<?=$v_id?>" class="form-control" hidden />
	        </td>
	        
	        
            
              <td>&nbsp;</td>
              <td width="11%">
                <? $field = 'po_details'; ?>
                <label for="label">Note:</label>
              </td>
              <td width="39%"><input name="note" type="text" id="note" value="<?=$req_rows->note?>" class="form-control" /></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>



          </table>
        </td>

      </tr>

      <tr>

        <td colspan="4">
          <div class="buttonrow" style="margin-left:240px;">

            <div align="center"></div>

          </div>
        </td>

      </tr>

    </table>
     <div class="col-md-12 col-xs-12" style='display:flex; align-items:center;flex-direction:column'>
            <div class="form-group">
            <label style="width: 100%;">&emsp13;</label>
            <? if($cost_no > 0 ){ ?>  
            <input name="update_cost" class="btn btn-success" type="submit" id="update_cost"  tabindex="9" value="Update" /><? }else { ?>
            <input name="create_new" class="btn btn-success" type="submit" id="create_new"  tabindex="9" value="Create New" />
            <? } ?>
            </div>
            </div>

    </div>

</div>
 

</form>
</div>

<? if($cost_no > 0){ ?>
<!--fuel cost -->
    <div class='col-xs-12 col-md-12' style='display:flex; justify-content:center;flex-direction:column; background-color: #F7F7F7;'>
    <h3>Fuel Cost Entry</h3>
    <form method="post" >
        <? $prev_fuel_entry = find_all_field('vehicle_req_cost','','cost_id = "'.$cost_no.'" and cost_type = "1" ');
        ?>
        <input name="req_no" type="hidden" id="req_no" value="<?=$req_no?>" class="form-control"  />
         <input name="cost_id" type="hidden" id="cost_id" value="<?=$cost_no?>" class="form-control"  />
         <input name="cost_type" type="hidden" id="cost_type" value="1" class="form-control"  />
        <div class="row" >
            <div class="col-md-3 col-xs-12">
            <div class="form-group">
            <label>Fuel Qty :(in Litre)</label>
             <input name="fuel_qty" type="number" id="fuel_qty" value="<?=$prev_fuel_entry->fuel_qty?>"  class="form-control"    tabindex="6"/>
            </div>
            </div>

            <div class="col-md-2 col-xs-12">
            <div class="form-group">
            <label>Cost Amount : (in taka)</label>
             <input name="cost_amt" type="number" id="cost_amt"   class="form-control" value="<?=$prev_fuel_entry->cost_amt?>"    tabindex="6"/>
            </div>
            </div>

            <div class="col-md-3 col-xs-12">
            <div class="form-group">
            <label>Note :</label>
            <textarea name="note" type="text" id="note" class="form-control"    tabindex="7"><?=$prev_fuel_entry->note?></textarea>
            </div>
            </div>

            <div class="col-md-3 col-xs-12">
            <div class="form-group">
            <label style="width: 100%;">&emsp13;</label>
            <?if($prev_fuel_entry->id == ''){?>
            <input name="add_new_cost" class="btn btn-success" type="submit" id="add_new_cost"  tabindex="9" value="Add New Cost" />
            <?}?>
            </div>
            </div>
        </div>
    </form>
</div>

<!--CNG cost -->
    <div class='col-xs-12 col-md-12' style='display:flex; justify-content:center;flex-direction:column; background-color: #E8F5E9;'>
    <h3>CNG GAS Entry</h3>
    <form method="post" >
        <? $prev_CNG_entry = find_all_field('vehicle_req_cost','','cost_id = "'.$cost_no.'" and cost_type = "2" ');
        ?>
        <input name="req_no" type="hidden" id="req_no" value="<?=$req_no?>" class="form-control"  />
         <input name="cost_id" type="hidden" id="cost_id" value="<?=$cost_no?>" class="form-control"  />
         <input name="cost_type" type="hidden" id="cost_type" value="2" class="form-control"  />
        <div class="row" >
            <div class="col-md-3 col-xs-12">
            <div class="form-group">
            <label>Gas Qty :(in Litre)</label>
             <input name="cng_gas_qty" type="number" id="cng_gas_qty" value="<?=$prev_CNG_entry->cng_gas_qty?>"  class="form-control"    tabindex="6"/>
            </div>
            </div>

            <div class="col-md-2 col-xs-12">
            <div class="form-group">
            <label>Cost Amount : (in taka)</label>
             <input name="cost_amt" type="number" id="cost_amt"   class="form-control" value="<?=$prev_CNG_entry->cost_amt?>"    tabindex="6"/>
            </div>
            </div>

            <div class="col-md-3 col-xs-12">
            <div class="form-group">
            <label>Note :</label>
            <textarea name="note" type="text" id="note" class="form-control"    tabindex="7"><?=$prev_CNG_entry->note?></textarea>
            </div>
            </div>

            <div class="col-md-3 col-xs-12">
            <div class="form-group">
            <label style="width: 100%;">&emsp13;</label>
            <?if($prev_CNG_entry->id == ''){?>
            <input name="add_new_cost" class="btn btn-success" type="submit" id="add_new_cost"  tabindex="9" value="Add New Cost" />
            <?}?>
            </div>
            </div>
                </div>
            </form>
        </div>
        
<!--Maintenance cost -->
    <div class='col-xs-12 col-md-12' style='display:flex; justify-content:center;flex-direction:column; background-color: #F3E5F5;'>
    <h3>Maintenance entry</h3>
    <form method="post" >
        <? $prev_Maintenance_entry = find_all_field('vehicle_req_cost','','cost_id = "'.$cost_no.'" and cost_type = "3" ');
        ?>
        <input name="req_no" type="hidden" id="req_no" value="<?=$req_no?>" class="form-control"  />
         <input name="cost_id" type="hidden" id="cost_id" value="<?=$cost_no?>" class="form-control"  />
         <input name="cost_type" type="hidden" id="cost_type" value="3" class="form-control"  />
        <div class="row" >

            <div class="col-md-2 col-xs-12">
            <div class="form-group">
            <label>Cost Amount : (in taka)</label>
             <input name="cost_amt" type="number" id="cost_amt"   class="form-control" value="<?=$prev_Maintenance_entry->cost_amt?>"    tabindex="6"/>
            </div>
            </div>

            <div class="col-md-3 col-xs-12">
            <div class="form-group">
            <label>Note :</label>
            <textarea name="note" type="text" id="note" class="form-control"    tabindex="7"><?=$prev_Maintenance_entry->note?></textarea>
            </div>
            </div>

            <div class="col-md-3 col-xs-12">
            <div class="form-group">
            <label style="width: 100%;">&emsp13;</label>
            <?if($prev_Maintenance_entry->id == ''){?>
            <input name="add_new_cost" class="btn btn-success" type="submit" id="add_new_cost"  tabindex="9" value="Add New Cost" />
            <?}?>
            </div>
            </div>
                </div>
            </form>
        </div>
        
<!--Over Timr (in Hour) -->
    <div class='col-xs-12 col-md-12' style='display:flex; justify-content:center;flex-direction:column; background-color: #EAEAEA;'>
    <h3>Over Time Entry</h3>
    <form method="post" >
        <? $prev_Overtime = find_all_field('vehicle_req_cost','','cost_id = "'.$cost_no.'" and cost_type = "4" ');
        ?>
        <input name="req_no" type="hidden" id="req_no" value="<?=$req_no?>" class="form-control"  />
         <input name="cost_id" type="hidden" id="cost_id" value="<?=$cost_no?>" class="form-control"  />
         <input name="cost_type" type="hidden" id="cost_type" value="4" class="form-control"  />
        <div class="row" >
            <div class="col-md-3 col-xs-12">
            <div class="form-group">
            <label>Over Time :(in Hour)</label>
             <input name="over_time" type="number" id="over_time" value="<?=$prev_Overtime->over_time?>"  class="form-control"    tabindex="6"/>
            </div>
            </div>

            <div class="col-md-2 col-xs-12">
            <div class="form-group">
            <label>Cost Amount : (in taka)</label>
             <input name="cost_amt" type="number" id="cost_amt"   class="form-control" value="<?=$prev_Overtime->cost_amt?>"    tabindex="6"/>
            </div>
            </div>

            <div class="col-md-3 col-xs-12">
            <div class="form-group">
            <label>Note :</label>
            <textarea name="note" type="text" id="note" class="form-control"    tabindex="7"><?=$prev_Overtime->note?></textarea>
            </div>
            </div>

            <div class="col-md-3 col-xs-12">
            <div class="form-group">
            <label style="width: 100%;">&emsp13;</label>
            <?if($prev_Overtime->id == ''){?>
            <input name="add_new_cost" class="btn btn-success" type="submit" id="add_new_cost"  tabindex="9" value="Add New Cost" />
            <?}?>
            </div>
            </div>
                </div>
            </form>
        </div>

        

<!-- Demurrage Entry -->
<div class='col-xs-12 col-md-12' style='display:flex; justify-content:center;flex-direction:column; background-color: #F7F7F7;
'>
    <h3>Demurrage Entry</h3>
    <form method="post" >
        <? $prev_fuel_entry = find_all_field('vehicle_req_cost','','cost_id = "'.$cost_no.'" and cost_type = "6" ');
        ?>
        <input name="req_no" type="hidden" id="req_no" value="<?=$req_no?>" class="form-control"  />
         <input name="cost_id" type="hidden" id="cost_id" value="<?=$cost_no?>" class="form-control"  />
         <input name="cost_type" type="hidden" id="cost_type" value="6" class="form-control"  />
        <div class="row" >

            <div class="col-md-2 col-xs-12">
            <div class="form-group">
            <label>Cost Amount : (in taka)</label>
             <input name="cost_amt" type="number" id="cost_amt"   class="form-control" value="<?=$prev_fuel_entry->cost_amt?>"    tabindex="6"/>
            </div>
            </div>

            <div class="col-md-3 col-xs-12">
            <div class="form-group">
            <label>Note :</label>
            <textarea name="note" type="text" id="note" class="form-control"    tabindex="7"><?=$prev_fuel_entry->note?></textarea>
            </div>
            </div>

            <div class="col-md-3 col-xs-12">
            <div class="form-group">
            <label style="width: 100%;">&emsp13;</label>
            <?if($prev_fuel_entry->id == ''){?>
            <input name="add_new_cost" class="btn btn-success" type="submit" id="add_new_cost"  tabindex="9" value="Add New Cost" />
            <?}?>
            </div>
            </div>
        </div>
    </form>
</div> 



        
<!--Other cost -->
    <div class='col-xs-12 col-md-12' style='display:flex; justify-content:center;flex-direction:column; background-color: #E8F5E9;'>
    <h3>Other Cost entry</h3>
    <form method="post" >
        <? $prev_Other_entry = find_all_field('vehicle_req_cost','','cost_id = "'.$cost_no.'" and cost_type = "5" ');
        ?>
        <input name="req_no" type="hidden" id="req_no" value="<?=$req_no?>" class="form-control"  />
         <input name="cost_id" type="hidden" id="cost_id" value="<?=$cost_no?>" class="form-control"  />
         <input name="cost_type" type="hidden" id="cost_type" value="5" class="form-control"  />
        <div class="row" >

            <div class="col-md-2 col-xs-12">
            <div class="form-group">
            <label>Cost Amount : (in taka)</label>
             <input name="cost_amt" type="number" id="cost_amt"   class="form-control" value="<?=$prev_Other_entry->cost_amt?>"    tabindex="6"/>
            </div>
            </div>

            <div class="col-md-3 col-xs-12">
            <div class="form-group">
            <label>Note :</label>
            <textarea name="note" type="text" id="note" class="form-control"    tabindex="7"><?=$prev_Other_entry->note?></textarea>
            </div>
            </div>

            <div class="col-md-3 col-xs-12">
            <div class="form-group">
            <label style="width: 100%;">&emsp13;</label>
            <?if($prev_Other_entry->id == ''){?>
            <input name="add_new_cost" class="btn btn-success" type="submit" id="add_new_cost"  tabindex="9" value="Add New Cost" />
            <?}?>
            </div>
            </div>
                </div>
            </form>
        </div> 
        
        

    <? } ?>
    
</div>



<script>$("#codz").validate(); $("#cloud").validate();</script>


<?
	require_once SERVER_CORE."routing/layout.bottom.php";
?>

<script src="https://www.jqueryscript.net/demo/Rich-Text-Editor-jQuery-RichText/jquery.richtext.js"></script>