<?php
/*ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);*/
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$head='<link href="../../css/report_selection.css" type="text/css" rel="stylesheet"/>';
$title='Asset Disposal Approval';


?>











		

	<div class="col-12 tabledesign2">

    <table class="table table-striped" id="grp">

  <thead>

    <tr>

      <th scope="col">S/L</th>
      <th scope="col">Request Date</th>
      <th scope="col">Asset ID</th>

      <th scope="col">Asset Category</th>

      <th scope="col">Asset Name</th>
	  
	  <th scope="col">Serial No.</th>

      <th scope="col">Purchase Value</th>

      <th scope="col">Total Depreciation Value</th>
      
      <th scope="col">WDV</th>
	  
	  <th scope="col">Action</th>

    </tr>
  </thead>

  <tbody>

    <?php

     $sql='select r.*,i.item_name,s.sub_group_name from asset_disposal_info r,item_info i, item_sub_group s where r.item_id=i.item_id and s.sub_group_id=i.sub_group_id and r.status="Pending" group by r.asset_id';

     $query=db_query($sql);

     $i=1;

     while($data=mysqli_fetch_object($query)){
     ?>

   <tr>

      <th><?=$i++?></th>

      <td><?=$data->disposal_date?></td>

      <td><?=$data->asset_id?></td>

      <td><?=$data->sub_group_name?></td>
	  
	  <td><?=$data->item_name?></td>

      <td><?=$data->serial_no?></td>

      <td><?=number_format($data->po_value,2)?></td>

      <td><?=number_format($data->total_dpc,2)?></td>

	  <td><?=number_format($data->current_value,2)?></td>
	  
	  <td><span id="actionMsg<?=$data->id?>"> <button type="button" name="hold" id="hold" class="btn btn-warning" onclick="hold(<?=$data->id?>)">Hold</button>&nbsp;<br /><button type="button" name="approve" id="approve" class="btn btn-success" onclick="approve(<?=$data->id?>)">Approve</button></span></td>
    </tr>

  <? }?>
  </tbody>
</table>

    </div>	

		

    </div>


<script>

  function hold(id) {

    
    $.ajax({
      url: 'asset_hold_ajax.php',
      type: 'POST',
      data: {
        id: id
      },
      success: function(response) {
      
        var res = JSON.parse(response);
        document.getElementById("actionMsg"+id).innerHTML = res['msg'];
      },
      error: function(xhr, status, error) {
        
        console.error(error);
      }
    });
  }
  
  function approve(id) {

    
    $.ajax({
      url: 'asset_approve_ajax.php',
      type: 'POST',
      data: {
        id: id
      },
      success: function(response) {
     
        var res = JSON.parse(response);
        document.getElementById("actionMsg"+id).innerHTML = res['msg'];
      },
      error: function(xhr, status, error) {
        
        console.error(error);
      }
    });
  }
</script>
</script>


<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>