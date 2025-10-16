<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title = "Asset Registration";
$allData=find_all_field('fa_register','','id="'.$_GET['edit_id'].'"');

//*custom function
 do_calander('#purchase_date');
 do_datatable('cvd');
 $crud=new crud('fa_register');

  //TODO:insert data
if(isset($_POST['submit'])){
  $_POST['entry_by']=$_SESSION['user']['id'];
  $crud->insert();
}

//TODO: Update Data
if(isset($_POST['update'])){

$crud->update('id');
echo "<script>location.href='fa_register.php'</script>";
}
?>


<form action="" method="post" style="text-align:left" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
<div class="row">
<div class="form-group col-2">

  <label for="item_id" class="col-form-label">Sub Group:</label>
<? if($_GET['edit_id']!=''){ ?>
  <input type="text" class="form-control" value="<?=find_a_field('fa_item_sub_group','sub_group_name','sub_group_id="'.$allData->fa_sub_group.'"')?>"  readonly>
    <? }else{?>

      <select type="text" class="form-control" name="fa_sub_group" id="fa_sub_group" required>
      <option value=""> </option>
      <? foreign_relation('fa_item_sub_group','sub_group_id','sub_group_name',$fa_sub_group,'1')?>
      </select>
      <? }?>

</div>
<div class="form-group col-2">

  <label for="item_code" class="col-form-label">Item Code:</label>

  <input type="text" class="form-control" name="item_code" id="item_code" value="<?=$allData->item_code?>"  readonly>
  <input type="hidden" name="id" value="<?=$allData->id?>">

</div>

<div class="form-group col-3">

  <label for="item_details" class="col-form-label">Item Name:</label>

  <input type="text" class="form-control" name="item_details" id="item_details" value="<?=$allData->item_details?>" required>

</div>

<div class="form-group col-3">

<label for="rate" class="col-form-label">Rate:</label>

<input type="text" class="form-control" name="rate" id="rate" value="<?=$allData->rate?>"  required>

</div>

<div class="form-group col-2">

<label for="qty" class="col-form-label">Quantity:</label>

<input type="text" class="form-control" name="qty" id="qty" value="<?=$allData->qty?>" >

</div>

<div class="form-group col-2">

<label for="purchase_date" class="col-form-label">Purchase Date:</label>

<input type="text" class="form-control" name="purchase_date" id="purchase_date" value="<?=$allData->purchase_date?>"  required>

</div>

<div class="form-group col-3">

<label for="origin" class="col-form-label">Origin:</label>

<input type="text" class="form-control" name="origin" id="origin" value="<?=$allData->origin?>" >

</div>

<div class="form-group col-3">

<label for="brand" class="col-form-label">Brand:</label>

<input type="text" class="form-control" name="brand" id="brand" value="<?=$allData->brand?>" >

</div>
<div class="form-group col-2">

<label for="validity" class="col-form-label">Depreciation Rate(%):</label>

<input type="text" class="form-control" name="depreciation_rate" id="depreciation_rate" value="<?=$allData->depreciation_rate?>"  required> 

</div>

<div class="form-group col-2">

<label for="validity" class="col-form-label">Valiity:</label>

<input type="text" class="form-control" name="validity" id="validity" value="<?=$allData->validity?>"  required>

</div>
</div>
<? if($_GET['edit_id']!=''){ ?>
<div class="row justify-content-center">

  <div class="col-1">
  <input type="submit" class="form-control btn btn-warning" name="update" value="Update">
</div>
<div class="col-1">
<input type="button" onclick="location.href='fa_register.php'" class="form-control btn btn-danger" name="RESET" value="Clear">
</div>
</div>

<? }else{?>
  <div class="row justify-content-center">
  <div class="col-2">
  <input type="submit" class="form-control btn btn-success" name="submit" value="Confirm">
  </div>
   </div>
  <? }?>

</form>
<br><hr><br>
<table class="table1  table-striped table-bordered table-hover table-sm" >
  <thead class="thead1">
    <tr class="bgc-info">
      <th>S/L</th>
      <th>Item Name</th>
      <th>Item Code</th>
      <th>Sub Group</th>
      <th>Purchase Date</th>
      <th>Item Rate</th>
      <th>D.Rate</th>
      <th>Origin</th>
      <th>Brand</th>
      <th>Validity</th>
    </tr>
  </thead>
  <tbody>
    <?  $sql='select r.*,s.sub_group_name from fa_register r,fa_item_sub_group s where r.fa_sub_group=s.sub_group_id group by r.id';
    $query=db_query($sql);
    $i=1;
    while($data=mysqli_fetch_object($query)){
    ?>
    <tr onclick=" location.href='fa_register.php?edit_id=<?=$data->id?>'" style="cursor:pointer">
      <th><?=$i++;?></th>
      <td><?=$data->item_details?></td>
      <td><?=$data->item_code?></td>
      <td><?=$data->sub_group_name?></td>
      <td><?=$data->purchase_date?></td>
      <td align="right"><?=$data->rate?></td>
      <td align="right"><?=$data->depreciation_rate?>(%)</td>
      <td><?=$data->origin?></td>
      <td><?=$data->brand?></td>
      <td><?=$data->validity?></td>
    </tr>
    <? }?>
  </tbody>
</table>

<!-- //*ajax data for group -->
<script>
  $(document).ready(function(){

    $('#fa_sub_group').change(function(){
      var group=$(this).val();
      $.ajax({
        url:"fa_register_ajax.php",
        method:"POST",
        type:"JSON",
        data:{group_id:group},
        success:function(data,msg){
        $('#item_code').val(data);
        }
      });
    });

  });
</script>
<?
require_once SERVER_CORE."routing/layout.bottom.php";

?>