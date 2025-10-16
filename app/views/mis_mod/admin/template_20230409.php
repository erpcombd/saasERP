<?php

session_start();

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title = "Template Configuration";

$tempAll = find_all_field('config_template', '', '1');


if (isset($_POST['add'])) {

  db_query('delete from config_template ');

  if ($_POST['template_id'] == 1) {
    $_POST['template_name'] = 'Classical';
  } else {
    $_POST['template_name'] = 'Advanced';
  }
  $_POST['id'] = $_POST['template_id'];
  $_POST['status'] = 1;

  $crud   = new crud("config_template");
  $crud->insert();
  echo "<script>window.top.location='template.php'</script>";
}


?>


<div class="container">


</div>
<form action="" method="post">
  <div class="col-md-12 d-flex justify-content-center">
    <h3 class="bg-warning">Choose a Template</h3>
  </div>


  <div class="row">

    <div class="col-md-6">
      <label class="btn btn-outline-secondary active custom-control custom-radio">
        <input type="radio" name="template_id" value="1" <?= $tempAll->id == 1 ? 'checked' : ''; ?>><br>
        <img src="../../../../public/assets/images/template1.png" style="width: 70%;" alt="">
    </div>

    <div class="col-md-6">
      <label class="btn btn-outline-success active custom-control custom-radio">
        <input type="radio" name="template_id" value="2" <?= $tempAll->id == 2 ? 'checked' : ''; ?>><br>
        <img src="../../../../public/assets/images/template2.png" style="width: 70%;" alt="">
    </div>


    <div class="col-md-2">
      <label class="btn btn-outline-info active custom-control custom-radio">Template Base Color
        <input type="color" name="base_color" value="<?= $tempAll->base_color ?>" class="form-control">
      </label>
    </div>
    <div class="col-md-2">
      <label class="btn btn-outline-warning active custom-control custom-radio">Table top BG Color
        <input type="color" name="table_top_bg_color" value="<?= $tempAll->table_top_bg_color ?>" class="form-control">
      </label>
    </div>
    <div class="col-md-2">
      <label class="btn btn-outline-primary active custom-control custom-radio">Table top Text Color
        <input type="color" name="table_top_text_color" value="<?= $tempAll->table_top_text_color ?>" class="form-control">
      </label>
    </div>
    <div class="col-md-2">
      <label class="btn btn-outline-danger active custom-control custom-radio">Table Footer Color
        <input type="color" name="table_footer_color" value="<?= $tempAll->table_footer_color ?>" class="form-control">
      </label>
    </div>
    <div class="col-md-2">
      <label class="btn btn-outline-success active custom-control custom-radio">Table Row Even Color
        <input type="color" name="table_row_even_color" value="<?= $tempAll->table_row_even_color ?>" class="form-control">
      </label>
    </div>

    <div class="col-md-2">
      <label class="btn btn-outline-info active custom-control custom-radio">Table Row odd Color
        <input type="color" name="table_row_odd_color" value="<?= $tempAll->table_row_odd_color ?>" class="form-control">
      </label>
    </div>
    <div class="col-md-2">
      <label class="btn btn-outline-warning active custom-control custom-radio">Table Row Hover Color
        <input type="color" name="table_row_hover_color" value="<?= $tempAll->table_row_hover_color ?>" class="form-control">
      </label>
    </div>


  </div>
  <br>


  <button class="btn btn-success btn-sm" type="submit" name="add"
  >Submit</button>
</form>


</div>





<?



require_once SERVER_CORE."routing/layout.bottom.php";





?>