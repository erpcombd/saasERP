<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL); 


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title = 'Vehicle Cost Add';

$table_master = 'vehicle_other_cost_master';
$table_details = 'vehicle_other_cost_details ';

$crud = new crud($table_master);

$crud2= new crud($table_details);


$cost_no = $_GET["id"];

$req_info = 'SELECT * FROM vehicle_other_cost_master  WHERE id = "'.$_GET["id"].'" ';
$req_res=db_query($req_info);
$req_rows = mysqli_fetch_object($req_res);


if(isset($_POST['create_new'])){
    
    $_POST['entry_by'] = $_SESSION['user']['id'];
    $cost_no=$crud->insert();
    header("Location: other_cost_entry.php?id=" . $cost_no);
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
    header("Location: other_cost_entry.php?id=" . $_POST['ot_cost_id']);
    exit(); 
} 

$vehcilinfo_qry = 'SELECT * FROM vehicle_information WHERE 1';
$vehicle_res = db_query($vehcilinfo_qry);
while($v_rows = mysqli_fetch_object($vehicle_res)){
  $v_model[$v_rows->id] = $v_rows->vehicle_model;
  $v_reg_no[$v_rows->id] = $v_rows->reg_number;
}




$qry = 'SELECT * FROM other_cost_type WHERE status = "1" ';
$cost_res = db_query($qry);

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
                <label for="label">Other Cost Id:</label>
              </td>
              <td width="39%">
                <a type="text" class="form-control" readonly><?=$cost_no?> </a>
                <input name="id" type="text" id="id" value="<?=$cost_no?>" class="form-control" hidden />
              </td>
              <td width="10%">&nbsp;</td>
              
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
                <select name="vehicle_id" id="vehicle_id" class="form-select" required>
                            <? foreign_relation('vehicle_information', 'id', 'CONCAT(vehicle_model, " :: ", reg_number)', $req_rows->vehicle_id, '1');?>
                </select>
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

    <? 
 while($cost_rows = mysqli_fetch_object($cost_res)){
?>
    <div class='col-xs-12 col-md-12' style='display:flex; justify-content:center;flex-direction:column; background-color:white;'>
    <h3><?=$cost_rows->ot_cost_name?></h3>
    
    <form method="post" >


        <? $prev_entry = find_all_field('vehicle_other_cost_details','','ot_cost_id = "'.$cost_no.'" and ot_cost_type = "'.$cost_rows->id.'" ');
        ?>
         <input name="ot_cost_id" type="hidden" id="ot_cost_id" value="<?=$cost_no?>" class="form-control"  />
         <input name="ot_cost_type" type="hidden" id="ot_cost_type" value="<?=$cost_rows->id?>" class="form-control"  />
        <div class="row" >
            <div class="col-md-3 col-xs-12">
            <div class="form-group">
            <label>Amount</label>
             <input name="amount" type="number" id="amount" value="<?=$prev_entry->amount?>"  class="form-control"    tabindex="6"/>
            </div>
            </div>

            <div class="col-md-3 col-xs-12">
            <div class="form-group">
            <label>Note :</label>
            <textarea name="note" type="text" id="note" class="form-control"    tabindex="7"><?=$prev_entry->note?></textarea>
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
<? } ?> 
        
        

    <? } ?>
    
</div>



<script>$("#codz").validate(); $("#cloud").validate();</script>


<?
	require_once SERVER_CORE."routing/layout.bottom.php";
?>

<script src="https://www.jqueryscript.net/demo/Rich-Text-Editor-jQuery-RichText/jquery.richtext.js"></script>