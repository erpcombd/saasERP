<?php
/*ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);*/
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$head='<link href="../../css/report_selection.css" type="text/css" rel="stylesheet"/>';
$title='Asset Sales';
unset($_SESSION['ids']);

?>

		
<form method="post" action="sales.php">
	<div class="col-12 tabledesign2">
	<? if(isset($_SESSION['msg'])){?>
  <div class="alert alert-success" role="alert"><?=$_SESSION['msg'];unset($_SESSION['msg'])?></div>
  <? } ?>
    <table class="table table-striped" id="grp">

  <thead>

    <tr>

      <th scope="col">S/L</th>
      <th scope="col">Asset ID</th>

      <th scope="col">Asset Category</th>

      <th scope="col">Asset Name</th>
	  
	  <th scope="col">Serial No.</th>

      <th scope="col">Current Value</th>

    </tr>
  </thead>

  <tbody>

    <?php

     $sql='select r.*,i.item_name,s.sub_group_name 
	 
	 from asset_disposal_info r,item_info i, item_sub_group s 
	 
	 where r.item_id=i.item_id and s.sub_group_id=i.sub_group_id and r.status="Checked" group by r.asset_id';

     $query=db_query($sql);

     $i=1;

     while($data=mysqli_fetch_object($query)){
     ?>

   <tr>

      <td><input type="checkbox" name="check[]" id="check<?=$data->id?>" value="<?=$data->id?>" class="form-control" /></td>


      <td><?=$data->asset_id?></td>

      <td><?=$data->sub_group_name?></td>
	  
	  <td><?=$data->item_name?></td>

      <td><?=$data->serial_no?></td>

	  <td><?=number_format($data->current_value,2)?></td>
    </tr>

  <? }?>
  
  <tr>
   <td colspan="8"><div align="center"><input type="submit" name="submit" id="submit" value="Confirm Sales" class="btn btn-primary" /></div></td>
  </tr>
  </tbody>
</table>

    </div>	

		

    </div>
	
	</form>


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
      url: 'sales_approve_ajax.php',
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