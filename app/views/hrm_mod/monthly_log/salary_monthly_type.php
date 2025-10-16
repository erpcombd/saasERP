<?php



session_start();


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title = "Monthly Salary log Type";







?>



<div class="container">

    <h4 class="text-center bg-titel bold pt-2 pb-2">Salary Monthly Type</h4>

	

<form action="" method="post">

<table class="table1  table-striped table-bordered table-hover table-sm">

  <thead class="thead1">

  <tr class="bgc-info">

    <th>ID</th>

    <th>Month Start</th> 

	<th>Month End</th>

    <th>Status</th>

	<th>Action</th>

  </tr>

  </thead>

  

  

  <tbody class="tbody1">

    <?php

  $sql = 'select * from month_type';

  $query = db_query($sql);

  while ($data = mysqli_fetch_object($query)) {

    ?>

    <tr>

        <td><?= $data->id ?></td>

        <td><?= $data->month_start ?></td>

        <td><?= $data->month_end ?></td>

		

		<input type="hidden" name="upId<?=$data->id ?>" id="upId<?=$data->id ?>" value="<?=$data->id ?>">

        <td>

			<select name="statusUp<?=$data->id ?>"  id="statusUp<?=$data->id ?>"  class="form-control">

				<option value="<?= $data->status ?>"><?= $data->status ?></option>

				<option value="Active">Active</option>

				<option value="In-Active">In-Active</option>	

			</select>

		</td>	

		<td>

            <span id="show<?=$data->id ?>">

            <button type="button" name="update<?=$data->id ?>"  id="update<?=$data->id ?>" onclick="getData2('salary_monthly_type_ajax.php', 'show<?=$data->id ?>', document.getElementById('upId<?=$data->id ?>').value, document.getElementById('statusUp<?=$data->id ?>').value);" class="btn1 btn1-bg-update">Update</button>

        </span>

		

		</td>

		

    </tr>

  <? } ?>

  </tbody>

</table>

</form>

</div>



































<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>