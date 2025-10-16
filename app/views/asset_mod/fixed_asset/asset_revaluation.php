<?php
/*ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);*/
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$head='<link href="../../css/report_selection.css" type="text/css" rel="stylesheet"/>';
$title='Asset Revaluation';
unset($_SESSION['ids']);
do_calander('#revaluation_date');

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
	  
	  <th scope="col">Current Value</th>
	  
	  <th scope="col">Unit Cost</th>
	  
	  <th scope="col">Revaluation Date</th>
	  
	  <th scope="col">Revaluation Amount</th>
	  
	  <th scope="col">Action</th>

    </tr>
  </thead>

  <tbody>

    <?php
     
      $sql='select a.*,i.*, sum(f.dr_amt-f.cr_amt) as current_amt,f.tr_from 
	 
	 from asset_register a, item_info i , fixed_asset_journal f
	 
	 where a.item_id=i.item_id and a.group_for="'.$_POST['group_for'].'" and f.fixed_asset_id=a.asset_id and a.item_status!="Disposed" group by f.fixed_asset_id';

     $query=db_query($sql);

     $i=1;

     while($data=mysqli_fetch_object($query)){
	 
	// $disposal=finad_a_field('fixed_asset_journal','tr_from','fixed_asset_id="'.$data->asset_id.'" and tr_from="Disposal"');
	 
	// if($disposal==''){
	 
	 $actual_value = $data->current_amt;
	 $dpc_value = $actual_value/$data->life_duration;
     ?>

   <tr>

      <td><input type="checkbox" name="check[]" id="check<?=$data->id?>" value="<?=$data->id?>" class="form-control" /></td>


      <td><?=$data->asset_id?></td>

      <td><?=$data->item_name?></td>
	  
	  <td><?=$data->depreciation_start_date?></td>

      <td><div align="right"><?=number_format($actual_value,2);?></div></td>

	  <td><div align="right"><?=number_format($data->unit_cost,2);?></div></td>
	  <td><input type="text" id="revaluation_date" name="revaluation_date"  required <?=$_POST['revaluation_date']?> autocomplete="off"/></td>
	  <td><input type="text" id="amount" name="amount"  required value="<?=$_POST['amount']?>"/></td>
	  <td><span id="msg<?=$data->id?>"><input type="button" value="Save" onclick="dpc_cal(<?=$data->id?>)"/></span></td>
    </tr>

  <? }//}?>
  
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
  var revaluation_date = document.getElementById('revaluation_date').value;
  var amount = document.getElementById('amount').value*1;
    $.ajax({
      url: 'asset_revaluation_ajax.php',
      type: 'POST',
      data: {
        id: id,
		group_for: group_for,
		revaluation_date: revaluation_date,
		amount: amount
		
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