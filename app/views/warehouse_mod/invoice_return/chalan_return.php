<?php

session_start();

ob_start();


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Invoice Wise Return';

do_calander('#fdate');

do_calander('#tdate');

$table_master='sale_do_master';

$unique='do_no';

$table_details='sale_do_details';

//$unique_chalan='id';

$$unique=$_POST[$unique];

//if(isset($_POST['delete']))

//{

//		$crud   = new crud($table_master);

//		$condition=$unique_master."=".$$unique_master;		

//		$crud->delete($condition);

//		$crud   = new crud($table_detail);

//		$crud->delete_all($condition);

//		$crud   = new crud($table_chalan);

//		$crud->delete_all($condition);

//		unset($$unique_master);

//		unset($_SESSION[$unique_master]);

//		$type=1;

//		$msg='Successfully Deleted.';

//}

if(isset($_POST['confirm']))

{

unset($_POST);

$_POST[$unique_master]=$$unique_master;

$_POST['entry_at']=date('Y-m-d h:s:i');

//$_POST['do_date']=date('Y-m-d');

$_POST['status']='COMPLETED';

$crud   = new crud($table_master);

$crud->update($unique_master);

$crud   = new crud($table_detail);

$crud->update($unique_master);

$crud   = new crud($table_chalan);

$crud->update($unique_master);

unset($$unique_master);

unset($_SESSION[$unique_master]);

$type=1;

$msg='Successfully Instructed to Depot.';

}

$table='sale_do_master';

$do_no='do_no';

$text_field_id='do_no';

$target_url = '../invoice_return/chalan_return_calculate.php';

?>

<script language="javascript">

window.onload = function() {

document.getElementById("dealer").focus();

}

</script>

<script language="javascript">

function custom(theUrl)

{



window.location='<?=$target_url?>?chalan_no='+theUrl;

}

</script><div class="form-container_large">

<!--<style>

div.form-container_large input {

width: 250px;

height: 38px;

border-radius: 0px !important;

}

</style>-->

<div class="form-container_large">

<form action="" method="post" name="codz" id="codz">

<div class="container-fluid bg-form-titel">

<div class="row">

<!--<div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">

<div class="form-group row m-0">

<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Customer Name:</label>

<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">

<select name="dealer_code" id="dealer_code" >

<option></option>

<?

foreign_relation('dealer_info','dealer_code','dealer_name_e',$_POST['dealer_code'],'1 order by dealer_code');

?>

</select>

</div>

</div>

</div>-->

<div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">

<div class="form-group row m-0">

<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Invoice No:</label>

<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">

<input list="cvb" name="chalan_no" id="chalan_no" type="text" class="form-control" autocomplete="off" />

<datalist id="cvb">
<? foreign_relation('sale_do_chalan','chalan_no','chalan_no',$_POST['chalan_no'],'status  in ("CHECKED")');?>

</datalist>

</div>

</div>

</div>

<div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">

<input type="submit" name="submitit" id="submitit" value="Show" class="btn1 btn1-submit-input"/ >

</div>

<?=$_SESSION['cmsg'];unset($_SESSION['cmsg']);?>

</div>

</div>

<div class="container-fluid pt-5 p-0 ">

<table class="table1  table-striped table-bordered table-hover table-sm">

<thead class="thead1">

<tr class="bgc-info">

<th>Challan No.</th>

<th>Challan Date</th>

<th>Order No</th>

<th>Customer Name</th>

<th>Action</th>

</tr>

</thead>

<tbody class="tbody1">

<? 

if(isset($_POST['submitit'])){

}

//if($_POST['fdate']!=''&&$_POST['tdate']!='') $con .= ' and m.do_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';

if($_POST['dealer_code']!='') 

$con .= ' and c.dealer_code in ('.$_POST['dealer_code'].') ';

if($_POST['chalan_no']!='') 

$con .= ' and c.chalan_no='.$_POST['chalan_no'].'';

$sql = "select   c.do_no, sum(c.total_unit) as ch_qty  from sale_do_master m, sale_do_chalan c where m.do_no=c.do_no  group by c.do_no ";

$query = db_query($sql);

while($info=mysqli_fetch_object($query)){

$ch_qty[$info->do_no]=$info->ch_qty;

}

$res="select  m.do_no, c.chalan_no, m.dealer_code, c.chalan_date,  c.status, sum(d.total_unit) as wo_qty

from sale_do_master m, sale_do_details d, sale_do_chalan c

where m.do_no=c.do_no and m.do_no=d.do_no and  c.status in ('CHECKED') and c.depot_id='".$_SESSION['user']['depot']."' ".$con." group by c.chalan_no order by c.chalan_date desc limit 10";

//echo link_report($res,'po_print_view.php');

$query = db_query($res);

?>

<?

while($row = mysqli_fetch_object($query)){

?>

<tr>

<td><?=$row->chalan_no?></td>

<td><?=$row->chalan_date?></td>

<td><?=$row->do_no?></td>

<td <?=$row->do_no?>><?= find_a_field('dealer_info','dealer_name_e','dealer_code="'.$row->dealer_code.'"');?></td>

<td>

<input type="button" value="Challan Return" onClick="custom(<?=$row->chalan_no;?>);" class="btn1 btn1-bg-submit" / >

</td>

</tr>

<?

}

?>

</tbody>

</table>

</div>

</form>

</div>

<?

$main_content=ob_get_contents();

ob_end_clean();

require_once SERVER_CORE."routing/layout.bottom.php";

?>