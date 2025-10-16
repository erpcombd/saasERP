<?php

session_start();

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title = "Template Error";

//do_datatable('ac_ledger');


?>

<!--    id="ac_ledger"-->
<div class="container">
    <h4 class="text-center bg-titel bold pt-2 pb-2">Page Problem & Debugger Issue Status</h4>
        <form action="" method="post">
<table class="table1  table-striped table-bordered table-hover table-sm">
  <thead class="thead1">
  <tr class="bgc-info">
    <th>Page ID</th>
    <th>Error Type</th>
    <th>Note</th>
    <th>URL</th>
    <th>Status</th>
    <th>Entry By</th>
    <th>Entry At</th>
    <th>Action</th>

  </tr>
  </thead>
  <tbody class="tbody1">
  <?php
  $sql = 'select * from error_check_details WHERE status !="SOLVED"';

//  $check_entry = find_all_field('error_check_details','id','page_id','error_type','note','url','status','entry_by','entry_at');
  $query = db_query($sql);
  while ($data = mysqli_fetch_object($query)) {
    ?>
    <tr>
        <td><?= $data->page_id ?></td>
        <td><?= $data->error_type ?></td>
        <td><?= $data->note ?></td>
        <td><?= $data->url ?></td>
        <input type="hidden" name="upId<?=$data->id ?>" id="upId<?=$data->id ?>" value="<?=$data->id ?>">
        <td>
            <select name="statusUp<?=$data->id ?>"  id="statusUp<?=$data->id ?>" class="form-control">
            <option value="<?=$data->status ?>"><?=$data->status ?></option>
            <option value="ON-PROGRESS">ON-PROGRESS</option>
            <option value="SOLVED">SOLVED</option>
          </select>
        </td>


      <td><?= $data->entry_by ?></td>
      <td><?= $data->entry_at ?></td>

        <td>
            <span id="show<?=$data->id ?>">
            <button type="button" name="update<?=$data->id ?>"  id="update<?=$data->id ?>" onclick="getData2('error_ajax.php', 'show<?=$data->id ?>', document.getElementById('upId<?=$data->id ?>').value, document.getElementById('statusUp<?=$data->id ?>').value);" class="btn btn-sm btn-warning">Update</button></td>
        </span>
    </tr>

  <? } ?>
  </tbody>

</table>
        </form>
</div>

















<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>