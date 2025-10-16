<?php
/*ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);*/
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$head='<link href="../../css/report_selection.css" type="text/css" rel="stylesheet"/>';
$title='Depreciation Calculation';
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
	  
	  <th scope="col">Dep. value</th>
	  
	  <th scope="col">Period</th>
	  <th scope="col">DPC Date</th>
	  
	  <th scope="col">Action</th>

    </tr>
  </thead>

  <tbody>

    <?php
     
      $sql='select a.*,i.*,d.id as master_id,d.dpc_date,sum(f.dr_amt-f.cr_amt) current_values 
	 
	 from asset_register a, item_info i, dpc_duration_info d, fixed_asset_journal f 
	 
	 where a.item_id=i.item_id and a.asset_id=d.asset_id and d.status="pending" and dpc_date<="'.date('Y-m-d').'" and a.group_for="'.$_POST['group_for'].'" and f.fixed_asset_id=a.asset_id group by a.asset_id,d.id';

     $query=db_query($sql);

     $i=1;

     while($data=mysqli_fetch_object($query)){
	 
	 $actual_value = $data->current_values-$data->salvage_value;
	 $dpc_value = $actual_value/$data->life_duration;
     ?>

   <tr>

      <td><input type="checkbox" name="check[]" id="check<?=$data->master_id?>" value="<?=$data->master_id?>" class="form-control" /></td>


      <td><?=$data->asset_id?></td>

      <td><?=$data->item_name?></td>
	  
	  <td><?=$data->depreciation_start_date?></td>

      <td><div align="right"><?=number_format($data->current_values,2);?></div></td>

	  <td><div align="right"><?=number_format($dpc_value,2);?></div></td>
	  <td><?=date('M-Y',strtotime($data->dpc_date))?></td>
	  <td><input type="dpc_date" id="dpc_date" value="<?=$data->dpc_date;?>" required/></td>
	  <td><span id="msg<?=$data->master_id?>"><input type="button" value="Save" onclick="dpc_cal(<?=$data->master_id?>)"/></span></td>
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

  function dpc_cal(master_id) {
  var group_for = document.getElementById('group_for').value;
  var dpc_date = document.getElementById('dpc_date').value;
    $.ajax({
      url: 'dpc_calculation_ajax.php',
      type: 'POST',
      data: {
        master_id: master_id,
		group_for: group_for,
		dpc_date: dpc_date
		
      },
      success: function(response) {
      
        var res = JSON.parse(response);
        
		document.getElementById("msg"+master_id).innerHTML = res['msg']
		
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