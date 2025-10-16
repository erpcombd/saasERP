<?php
session_start();
ob_start();

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Quotations Comparison';
do_calander('#fdate');
do_calander('#tdate');
$table_master='sale_do_master';
$unique='do_no';

//create_combobox('req_no');
//create_combobox('dealer_code');



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


$table='lc_number_setup';
$lc_no='id';
$text_field_id='id';

$target_url = 'quotations_comparison_print_view.php';


?>
<script language="javascript">
window.onload = function() {
  document.getElementById("dealer").focus();
}
</script>
<script language="javascript">
function custom(theUrl)
{
	window.open('<?=$target_url?>?req_no='+theUrl);
}
</script><div class="form-container_large">


  <div class="form-container_large">
    <form action="" method="post" name="codz" id="codz">

        <div class="container-fluid bg-form-titel">
    <div class="row">
      
      <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
        <div class="row">
          <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 pr-0">
            <div class="form-group row m-0">
              <label class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Date</label>
              <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0">
                <input type="text" name="fdate" id="fdate" value="<?=$_POST['fdate']?>" autocomplete="off" />
              </div>
            </div>
          </div>


          <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 pl-0">
            <div class="form-group row m-0">
              <label class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">TO</label>
              <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0">
                <input type="text" name="tdate" id="tdate" value="<?=$_POST['tdate']?>" autocomplete="off"/>

              </div>
            </div>

          </div>
        </div>
      </div>
	  
	  <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 p-0">
        <div class="form-group row m-0">
          <label class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">REQ. No:</label>
          <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0">
		  
            	<select name="req_no" id="req_no">
				<option value=""></option>		
				<? foreign_relation('requisition_master','req_no','req_no',$_POST['req_no'],'1');?>		
			  </select>

          </div>
        </div>
      </div>
	  
	        <?php /*?><tr>
        <td width="266" align="right" bgcolor="#FF9966"><strong>Challan No:</strong></td>
        <td colspan="3" bgcolor="#FF9966">
		
	
	<input type="text" name="invoice_no" id="invoice_no" value="<?=$_POST['invoice_no']?>" style="width:150px; font-weight:bold; font-size:12px; height:30px; color:#090"/>		</td>
      </tr><?php */?>


      <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
        <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" class="btn1 btn1-submit-input">
      </div>

    </div>
  </div>




<!--Table start-->
      <div class="container-fluid pt-5 p-0 ">

        <table id="grp" class="table1  table-striped table-bordered table-hover table-sm">
          <thead class="thead1">
          <tr class="bgc-info">
			  <th>REQ. No </th>
			  <th>REQ. Date </th>
			  <th>REQ. From</th>
			  <th>Entry By </th>
              <th width="8%">Action </th>

          </tr>
          </thead>

          <tbody class="tbody1">
		  
		  <? 

if(isset($_POST['submitit'])){





if($_POST['fdate']!=''&&$_POST['tdate']!='') $con .= ' and m.req_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';

if($_POST['dealer_code']!='') 
$con .= ' and dealer_code in ('.$_POST['dealer_code'].') ';

if($_POST['req_no']!='') 
$con .= ' and m.req_no in ('.$_POST['req_no'].') ';



 		//$sql = "select lc_no, lc_no as lc_number  from lc_bank_entry where 1 group by lc_no ";
//		 $query = db_query($sql);
//		 while($info=mysqli_fetch_object($query)){
//  		 $lc_number[$info->lc_no]=$info->lc_number;
//		}



   $res="select  m.* from  requisition_master m, requisition_order d where m.req_no=d.req_no and  m.status!='MANUAL'  ".$con." 
   group by m.req_no order by m.req_date desc, m.req_no";


$query = db_query($res);
while($data = mysqli_fetch_object($query))
{
?>

<? //if($lc_number[$data->id]==0) { } ?>

<tr <?=($data->RCV_AMT>0)?'style="background-color:#FFCCFF"':'';?>>
<td  <?=(++$z%2)?'':'class="alt"';?>><?=$data->req_no;?></td>
<td  <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?= date("d-m-Y",strtotime($data->req_date));?></td>
<td  <?=(++$z%2)?'':'class="alt"';?>><?= find_a_field('warehouse','warehouse_name','warehouse_id="'.$data->warehouse_id.'"');?></td>
<td  <?=(++$z%2)?'':'class="alt"';?>><?= find_a_field('user_activity_management','fname','user_id="'.$data->entry_by.'"');?></td>

<td> <button type="button" onClick="custom(<?=$data->req_no;?>);" class="btn2 btn1-bg-submit"><i class="fa-solid fa-eye"></i></button> </td>
</tr>


<? } } ?>



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