<?php



require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$quotation_no=$_GET['quotation_no'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>Quotation Rate History</h2>
   
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Item Name</th>
        <th>Previous Rate</th>
        <th>Change Rate</th>
		<th>Change By</th>
		<th>Change At</th>
      </tr>
    </thead>
    <tbody>
	<?php 
	  $rate_log='select * from quotation_rate_log where quotation_no="'.$quotation_no.'" and change_rate>0';
	$rate_query=db_query($rate_log);
	while($rate_row=mysqli_fetch_object($rate_query)){
	?>
      <tr>
        <td><?php echo find_a_field('item_info','item_name','item_id='.$rate_row->item_id);?></td>
        <td><?php echo $rate_row->rate;?></td>
        <td><?php echo $rate_row->change_rate;?></td>
		<td><?php echo $rate_row->change_by;?></td>
		<td><?php echo $rate_row->change_at;?></td>
      </tr>
	  <?php } ?>
       
    </tbody>
  </table>
</div>

</body>
</html>
