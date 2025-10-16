<?php
/*ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);*/
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$head='<link href="../../css/report_selection.css" type="text/css" rel="stylesheet"/>';
$title='Monthly DPC Rate Calculation';
unset($_SESSION['ids']);
do_calander('#dpc_date');

?>

		
<form method="post" action="">
	<div class="col-12 tabledesign2">
	<? if(isset($_SESSION['msg'])){?>
  <div class="alert alert-success" role="alert"><?=$_SESSION['msg'];unset($_SESSION['msg'])?></div>
  <? } ?>
  
  <div class="box" style="width:100%;">

								<table width="100%" border="0" cellspacing="0" cellpadding="0">

								  <tr>



   
	  <td width="30%">
	  <select name="group_for" id="group_for" class="form-control" required>
                               <option></option>
                               <? foreign_relation('user_group','id','group_name',$_POST['group_for'],'1')?>
                               </select>
							   </td>
	
	 <td width="13%" rowspan="9" align="center" ><strong>

      <input type="submit" name="find_data" id="find_data" value="Find Data" style="width:180px; text-transform:uppercase; background:#87CEFA; color:#000000; text-align:center; font-weight:bold; font-size:12px; height:30px; "/>

    </strong></td>
    </tr>
								  
								</table>

</div>

    <table class="table table-striped" id="grp">

  <thead>

    <tr>

      <th scope="col">S/L</th>
      <th scope="col">Asset ID</th>

	  <th scope="col">Asset Name</th>

      <th scope="col">Dep. Start Date</th>
	  
	  <th scope="col">Asset Value</th>
	  
	  <th scope="col">Unit Cost</th>
	  
	  <th scope="col">DPC Date</th>
	  
	  <th scope="col">Monthly Production</th>
	  
	  <th scope="col">Action</th>

    </tr>
  </thead>

  <tbody>

    <?php
     
     $sql='select a.*,i.* from asset_register a, item_info i where a.item_id=i.item_id and a.group_for="'.$_POST['group_for'].'"';

     $query=db_query($sql);

     $i=1;

     while($data=mysqli_fetch_object($query)){
	 
	 $actual_value = $data->price-$data->salvage_value;
	 $dpc_value = $actual_value/$data->life_duration;
     ?>

   <tr>

      <td><input type="checkbox" name="check[]" id="check<?=$data->id?>" value="<?=$data->id?>" class="form-control" /></td>


      <td><?=$data->asset_id?></td>

      <td><?=$data->item_name?></td>
	  
	  <td><?=$data->depreciation_start_date?></td>

      <td><div align="right"><?=number_format($actual_value,2);?></div></td>

	  <td><div align="right"><?=number_format($data->unit_cost,2);?></div></td>
	  <td><input type="text" id="dpc_date" name="dpc_date"  required <?=$_POST['dpc_date']?> autocomplete="off"/></td>
	  <td><input type="text" id="monthly_production" name="monthly_production"  required value="<?=$_POST['monthly_production']?>"/></td>
	  <td><span id="msg<?=$data->id?>"><input type="button" value="Save" onclick="dpc_cal(<?=$data->id?>)"/></span></td>
    </tr>

  <? }?>
  
  <tr>
   <td colspan="9"><div align="center"><input type="submit" name="submit" id="submit" value="Confirm Calculation" class="btn btn-primary" /></div></td>
  </tr>
  </tbody>
</table>

    </div>	

		

    </div>
	
	</form>


<script>

  function dpc_cal(id) {
  var group_for = document.getElementById('group_for').value;
  var dpc_date = document.getElementById('dpc_date').value;
  var monthly_production = document.getElementById('monthly_production').value*1;
    $.ajax({
      url: 'production_dpc_calculation_ajax.php',
      type: 'POST',
      data: {
        id: id,
		group_for: group_for,
		dpc_date: dpc_date,
		monthly_production: monthly_production
		
      },
      success: function(response) {
      
        var res = JSON.parse(response);
        
		document.getElementById("msg"+id).innerHTML = res['msg']
		
      },
      error: function(xhr, status, error) {
        
        console.error(error);
      }
    });
  }
</script>


<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>