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
  } 
  
  elseif ($_POST['template_id'] == 2) {
      $_POST['template_name'] = 'Advanced';
  } 
  
  else {
    $_POST['template_name'] = 'Super-Advanced';
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

  
  <fieldset class="scheduler-border">
    <legend class="scheduler-border" style="font-size: 16px !important;">Choose a Template</legend>
      <div class="row col-md-12 p-0 m-0">
	  
    <div class="col-md-4">
      <label class="btn btn-outline-secondary active custom-control custom-radio pt-2" style="margin: 0px; padding: 0px;">
        <input type="radio" name="template_id" value="1" <?= $tempAll->id == 1 ? 'checked' : ''; ?> style="height: 20px; width: 20px;"><br>
        <img src="../../../../public/assets/images/template1.png" style="width: 100%;" alt="">
		<h4 class="pt-2 bold" style="font-size: inherit;"> CLASSICAL </h4>
		
    </div>

    <div class="col-md-4">
      <label class="btn btn-outline-success active custom-control custom-radio pt-2" style="margin: 0px; padding: 0px;">
        <input type="radio" name="template_id" value="2" <?= $tempAll->id == 2 ? 'checked' : ''; ?> style="height: 20px; width: 20px;"><br>
        <img src="../../../../public/assets/images/template2.png" style="width: 100%;" alt="">
		<h4 class="pt-2 bold" style="font-size: inherit;"> ADVANCED </h4>
    </div>
	
	    <div class="col-md-4">
      <label class="btn btn-outline-info active custom-control custom-radio pt-2" style="margin: 0px; padding: 0px;">
        <input type="radio" name="template_id" value="3" <?= $tempAll->id == 3 ? 'checked' : ''; ?> style="height: 20px; width: 20px;"><br>
        <img src="../../../../public/assets/images/template2.png" style="width: 100%;" alt="">
		<h4 class="pt-2 bold" style="font-size: inherit;"> COMING SOON..</h4>
    </div>
	  
	  
	  
	  </div>
</fieldset>


  
  <fieldset class="scheduler-border">
    <legend class="scheduler-border" style="font-size: 16px !important;">Template Color Setup</legend>
    
	
	<div class="row col-md-12 p-0 m-0">

    <div class="col-md-3">
      <label class="btn btn-outline-info active custom-control custom-radio">Template Base Color
        <input type="color" name="base_color" value="<?= $tempAll->base_color ?>" class="form-control">
      </label>
    </div>
    <div class="col-md-3">
      <label class="btn btn-outline-warning active custom-control custom-radio">Table Top BG Color
        <input type="color" name="table_top_bg_color" value="<?= $tempAll->table_top_bg_color ?>" class="form-control">
      </label>
    </div>
    <div class="col-md-3">
      <label class="btn btn-outline-primary active custom-control custom-radio">Table Top Text Color
        <input type="color" name="table_top_text_color" value="<?= $tempAll->table_top_text_color ?>" class="form-control">
      </label>
    </div>
    <div class="col-md-3">
      <label class="btn btn-outline-danger active custom-control custom-radio">Table Footer Color
        <input type="color" name="table_footer_color" value="<?= $tempAll->table_footer_color ?>" class="form-control">
      </label>
    </div>
    <div class="col-md-3">
      <label class="btn btn-outline-success active custom-control custom-radio">Table Row Even Color
        <input type="color" name="table_row_even_color" value="<?= $tempAll->table_row_even_color ?>" class="form-control">
      </label>
    </div>

    <div class="col-md-3">
      <label class="btn btn-outline-info active custom-control custom-radio">Table Row Odd Color
        <input type="color" name="table_row_odd_color" value="<?= $tempAll->table_row_odd_color ?>" class="form-control">
      </label>
    </div>
	
    <div class="col-md-3">
      <label class="btn btn-outline-warning active custom-control custom-radio">Table Row Hover Color
        <input type="color" name="table_row_hover_color" value="<?= $tempAll->table_row_hover_color ?>" class="form-control">
      </label>
    </div>
	
	
	</div>
	
	
</fieldset>


  	
	
	
	
	  
  <fieldset class="scheduler-border">
    <legend class="scheduler-border" style="font-size: 16px !important;">Choose a Font & Size</legend>
    
	<div class="row col-md-12 p-0 m-0">
		
    <div class="col-md-2">
      <label class="btn btn-outline-success active custom-control custom-radio">Font Size
	
		<select name="font_size"  id="font_size" >
            <option value="<?= $tempAll->font_size ?>"><?= $tempAll->font_size ?></option>
			<option value="9px">09 px</option>
			<option value="10px">10 px</option>
			<option value="11px">11 px</option>
            <option value="12px">12 px</option>
            <option value="13px">13 px</option>
			<option value="14px">14 px</option>
            <option value="15px">15 px</option>
            <option value="16px">16 px</option>
			<option value="17px">17 px</option>
            <option value="18px">18 px</option>
            <option value="19px">19 px</option>
			<option value="20px">20 px</option>
            <option value="21px">21 px</option>
            <option value="22px">22 px</option>
          </select>
		
      </label>
    </div>
	
	
	    <div class="col-md-4">
      <label class="btn btn-outline-info active custom-control custom-radio">Google Font Family
        <?=$tempAll->font_family; ?>
		
		<select name="font_family"  id="font_family" >
            <option value="<?=$tempAll->font_family;?>"><? if($tempAll->font_family == "font-family: 'Montserrat', sans-serif;"){echo "Montserrat";}else{echo $tempAll->font_family;}?></option>
			<option value="font-family: 'Montserrat', sans-serif;">Montserrat</option>
			<option value="font-family: 'Montserrat', sans-serif;"> </option>
			<option value="font-family: 'Montserrat', sans-serif;"> </option>
            <option value="font-family: 'Montserrat', sans-serif;"> </option>
            <option value="font-family: 'Montserrat', sans-serif;"> </option>
          </select>
      </label>
    </div>
	
    <div class="col-md-6">
      <label class="btn btn-outline-warning active custom-radio" style="width: 100%;">Google Font API Link
     
		<input  class="form-control" type="text" name="font_family_api" value="<?= $tempAll->font_family_api ?>">
		
		<textarea class="form-control" readonly="readonly" style="text-align:justify;" >
		<?= $tempAll->font_family_api ?>
		</textarea>
      </label>
    </div>
	
	


  </div>
	
	
</fieldset>
	
	
  <br>





  <button class="btn btn-success btn-sm" type="submit" name="add"
  >Submit</button>
</form>


</div>





<?



require_once SERVER_CORE."routing/layout.bottom.php";





?>