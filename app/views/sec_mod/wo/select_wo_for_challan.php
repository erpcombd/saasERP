<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Delivery Challan';
do_calander('#fdate');
do_calander('#tdate');
$table_master='sale_do_master';
$unique='do_no';

create_combobox('do_no');
create_combobox('dealer_code');

$table_details='sale_do_details';
//$unique_chalan='id';

$$unique=$_POST[$unique];
$tr_type="Show";

if(isset($_POST['confirm']))
{
		unset($_POST);
		$_POST[$unique_master]=$$unique_master;
		$_POST['entry_at']=date('Y-m-d h:s:i');
	
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
		$tr_type="Complete";
}


$table='sale_do_master';
$do_no='do_no';
$text_field_id='do_no';

$target_url = '../wo/delivery_challan.php';

$tr_from="Warehouse";
?>
<script language="javascript">
window.onload = function() {
  document.getElementById("dealer").focus();
}
</script>
<script language="javascript">
function custom(theUrl)
{
	window.open('<?=$target_url?>?do_no='+theUrl);
}
</script><div class="form-container_large">




<style>




</style>


<div class="form-container_large">
 
    <form action="" method="post" name="codz" id="codz">
	<h3 align="center" class="n-form-titel1 mb-0">Customer Information</h3>
            
        <div class="container-fluid bg-form-titel">
            <div class="row">
                <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
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

                </div>
                <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Job No:</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <select name="do_no" id="do_no" >
		
								<option></option>
						
								<? foreign_relation('sale_do_master','do_no','job_no',$_POST['do_no'],'status  in ("CHECKED")');?>
							</select>

                        </div>
                    </div>
                </div>
				

                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                    
                    <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" class="btn1 btn1-submit-input"/ >
                </div>

            </div>
        </div>


        <div class="container-fluid pt-5 p-0 ">
		
		
		

                <table class="table1  table-striped table-bordered table-hover table-sm">
                    <thead class="thead1">
                    <tr class="bgc-info">
                        <th>SL No</th>
						<th>SO Date</th>
						<th>Job No</th>
						<th>Customer Name</th>
						<th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>

                    <tbody class="tbody1">
					
					
					<? 
if(isset($_POST['submitit'])){

}



if($_POST['dealer_code']!='') 
$con .= ' and m.dealer_code in ('.$_POST['dealer_code'].') ';

if($_POST['do_no']!='') 
$con .= ' and m.do_no in ('.$_POST['do_no'].') ';



 		$sql = "select   c.do_no, sum(c.total_unit) as ch_qty  from sale_do_master m, sale_do_chalan c where m.do_no=c.do_no  group by c.do_no ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $ch_qty[$info->do_no]=$info->ch_qty;
		
		
		}



  $res="select  m.do_no, m.job_no, m.dealer_code, m.do_date,m.depot_id,  m.status, sum(d.total_unit) as wo_qty,m.status
 
 
  from sale_do_master m, sale_do_details d 
  
 
 where m.do_no=d.do_no and m.depot_id='".$_SESSION['user']['depot']."' and  m.status  in ('CHECKED') ".$con." group by m.do_no order by m.do_date desc, m.do_no  ";


		$query = db_query($res);
		?>
					
					
					<?
					
					while($row = mysqli_fetch_object($query)){
					
					?>

                        <tr>
                            <td><?=$row->do_no?></td>
                            <td><?=$row->do_date?></td>
                            <td><?=$row->job_no?></td>
							<td <?=$row->do_no?>><?= find_a_field('dealer_info','dealer_name_e','dealer_code="'.$row->dealer_code.'"');?></td>
							<td><?=$row->status?></td>

                            <td>
							<input type="button" value="Complete SR" onClick="custom(<?=$row->do_no;?>);" class="btn1 btn1-bg-submit" / >

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
require_once SERVER_CORE."routing/layout.bottom.php";
?>