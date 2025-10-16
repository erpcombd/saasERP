<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Production Receive Line';



do_calander('#fdate');

do_calander('#tdate');



$table = 'purchase_master';

$unique = 'po_no';

$status = 'CHECKED';

$target_url = '../production_receive/production_receive_report.php';



if($_REQUEST[$unique]>0)

{

$_SESSION[$unique] = $_REQUEST[$unique];

header('location:'.$target_url);

}



?>

<script language="javascript">

function custom(theUrl)

{

	window.open('<?=$target_url?>?v_no='+theUrl);

}

</script>
<div class="form-container_large">

<form action="" method="post" name="codz" id="codz">

  <div class="container-fluid bg-form-titel">
    <div class="row">
      <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
        <div class="form-group row m-0">
          <label class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Date From:</label>
          <div class="col-sm-7 col-md-7 col-lg-7 col-xl-7 p-0">
          <input type="text" name="fdate" id="fdate" style="width:80px;" value="<?=($_POST['fdate']!='')?$_POST['fdate']:date('Y-m-01');?>" />
          </div>
        </div>

      </div>
      <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
        <div class="form-group row m-0">
          <label class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Date To:</label>
          <div class="col-sm-7 col-md-7 col-lg-7 col-xl-7 p-0">
          <input type="text" name="tdate" id="tdate" style="width:80px;" value="<?=($_POST['tdate']!='')?$_POST['tdate']:date('Y-m-d');?>" />
          </div>
        </div>

      </div>
      <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
        <div class="form-group row m-0">
          <label class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Production Line: </label>
          <div class="col-sm-7 col-md-7 col-lg-7 col-xl-7 p-0">
          <select name="line_id" id="line_id" style="width:200px;">
		        <option></option>
            <? foreign_relation('warehouse','warehouse_id','warehouse_name','','use_type="PL" order by warehouse_name',$_POST['line_id']);?>
          </select>
          </div>
        </div>
      </div>

      <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
        <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" class="btn1 btn1-submit-input" />
      </div>

    </div>
  </div>







  <div class="container-fluid pt-2 p-0 ">


      
<? 

if(isset($_POST['submitit'])){


if($_POST['fdate']!=''&&$_POST['tdate']!='')

$con .= 'and a.pr_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';



if($_POST['line_id']>0)

$con .= 'and a.warehouse_to = "'.$_POST['line_id'].'"';

 $res='select a.pr_no, a.pr_no, a.pr_date, a.remarks as batch_no, c.warehouse_name as production_line, a.carried_by,u.fname as entry_by,a.entry_at from production_floor_receive_master a,

production_floor_receive_detail b, warehouse c,user_activity_management u where u.user_id=a.entry_by and a.pr_no=b.pr_no and a.warehouse_to=c.warehouse_id  and c.use_type="PL" '.$con.' group by a.pr_no order by a.pr_no desc';

// echo link_report($res,'production_receive_report.php');

$query = db_query($res);

// }

?>

<table class="table1  table-striped table-bordered table-hover table-sm">
    <thead class="thead1">
      <tr class="bgc-info">
        <th>Pr No</th>
        <th>Pr Date</th>
        <th>Batch No</th>
        <th>Production Line</th>
        <th>Carried By</th>
        <th>Entry By</th>
        <th>Entry At  </th>
        <th>Action </th>


      </tr>
      </thead>


      <tbody class="tbody1">
        
      <?
          while($row = mysqli_fetch_object($query)){
      ?>
      <tr>
        <td><?=$row->pr_no?></td>
        <td><?=$row->pr_date?></td>
        <td><?=$row->batch_no?></td>
        <td><?=$row->production_line?></td>
        <td><?=$row->carried_by?></td>
        <td><?=$row->entry_by?></td>
        <td><?=$row->entry_at?></td>

        <td>
          <input type="submit" name="submitit" id="submitit" value="RECEIVED" class="btn1 btn1-submit-input" onclick="custom(<?=$row->pr_no?>);" />
        </td>



      </tr>
      <? } ?>
      </tbody>
    </table>

    <? } ?>






  </div>
</form>
</div>



<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>