<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Purchase Return Status';
do_calander('#fdate');
do_calander('#tdate');
$table_master='purchase_return_master';
$unique_master='pr_no';
$tr_type="Show";
 $master_id = find_a_field('user_activity_management','master_user','user_id='.$_SESSION['user']['id']);

//create_combobox('pr_no');
create_combobox('dealer_code');

$table_detail='purchase_return_detail';
$unique_detail='id';

//$table_chalan='sale_return_details';
//$unique_chalan='id';

$$unique_master=$_POST[$unique_master];

if(isset($_POST['delete']))
{
		$crud   = new crud($table_master);
		$condition=$unique_master."=".$$unique_master;		
		$crud->delete($condition);
		$crud   = new crud($table_detail);
		$crud->delete_all($condition);
		$crud   = new crud($table_chalan);
		$crud->delete_all($condition);
		unset($$unique_master);
		unset($_SESSION[$unique_master]);
		$type=1;
		$msg='Successfully Deleted.';
}
if(isset($_POST['confirm']))
{
		$pr_no=$_POST['pr_no'];

		$_POST[$unique_master]=$$unique_master;
		$_POST['send_to_depot_at']=date('Y-m-d H:i:s');
		$_POST['pr_date']=date('Y-m-d');
		$_POST['status']="CHECKED";
		
		
		$crud   = new crud($table_master);
		$crud->update($unique_master);
		$crud   = new crud($table_detail);
		$crud->update($unique_master);
		$crud   = new crud($table_chalan);
		$crud->update($unique_master);
				unset($_POST);
		unset($$unique_master);
		unset($_SESSION[$unique_master]);
		$type=1;
		$msg='Successfully Instructed to Depot.';
}


$table='purchase_return_master';
$show='vendor_id';
$id='pr_no';
$text_field_id='pr_no';

$target_url = 'purchase_invoice_print_view.php';

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
	window.open('<?=$target_url?>?v_no='+theUrl);
}
</script>


<style>
/*
.ui-state-default a, .ui-state-default a:link, .ui-state-default a:visited, a.ui-button, a:link.ui-button, a:visited.ui-button, .ui-button {
    color: #454545;
    text-decoration: none;
    display: none;
}*/


/*div.form-container_large input {
    width: 90%;
    height: 38px;
    border-radius: 0px !important;
}*/



</style>


<div class="form-container_large">
   
    <form action="" method="post" name="codz" id="codz">
            
        <div class="container-fluid bg-form-titel">
            

<div class="row">
    <div class="col-sm-10 col-md-10 col-lg-10 col-xl-10">
        <div class="row">
            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 pt-1 pb-1">
                <div class="form-group row m-0">
                    <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">From Date:</label>
                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                        <input type="text" name="fdate" id="fdate"  value="<?=$_POST['fdate']?>" autocomplete="off"/>
                    </div>
                </div>

            </div>
            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 pt-1 pb-1">
                <div class="form-group row m-0">
                    <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">To Date:</label>
                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                        <input type="text" name="tdate" id="tdate" value="<?=$_POST['tdate']?>" autocomplete="off"/>

                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 pt-1 pb-1">
                <div class="form-group row m-0">
                    <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Vendor Name</label>
                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
					<select name="vendor_id" id="vendor_id" >
		
					<option></option>
			
							<? foreign_relation('vendor','vendor_id','vendor_name',$_POST['vendor_id'],'1 order by vendor_id');?>
					</select>
		
                    </div>
                </div>

            </div>
            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 pt-1 pb-1">
                <div class="form-group row m-0">
                    <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Warehouse</label>
                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                        <? if($master_id==1){?>	
                      <select name="warehouse_id" id="warehouse_id" >
					  
					 

				 <? foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['warehouse_id'],'1');?>
 
                      </select>
					  
				<? }?>
					  
					  <? if($master_id==0){?>	
			
					  <select name="warehouse_id" id="warehouse_id" >
				

				 <? foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['warehouse_id'],'warehouse_id="'.$_SESSION['user']['depot'].'"');?>
 
                      </select>
					
				 <? }?>	 

                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
        
        <input type="submit" name="submitit" id="submitit" value="VIEW PRODUCT" class="btn1 btn1-submit-input"/ >
    </div>
</div>


        </div>






            
        <div class="container-fluid pt-5 p-0 ">


                <table class="table1  table-striped table-bordered table-hover table-sm">
                    <thead class="thead1">
                    <tr class="bgc-info">
                        <th>Pr No</th>
                        <th>Pr Date</th>
                        <th>Customer Name</th>

                        <th>Return Type</th>
                        <th>Warehouse Name</th>
                        <th>Entry By</th>
						<th>Status</th>
						<th>View</th>

           
                    </tr>
                    </thead>

                    <tbody class="tbody1">

                       <? 

							if(isset($_POST['submitit'])){
							
							if($_POST['fdate']!=''&&$_POST['tdate']!='') $con .= ' and m.pr_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
							
							
									
									
									if($_POST['vendor_id']!='')
									$dealer_con=" and m.vendor_id='".$_POST['vendor_id']."'";
									
									if($_POST['warehouse_id']>1) 
									$con .= ' and m.depot_id in ('.$_POST['warehouse_id'].') ';
							
							
							
							
							 $res="select m.pr_no, m.pr_no, m.pr_date, m.vendor_id, m.return_type	, m.depot_id,  d.vendor_name, m.entry_by, m.status from 
							purchase_return_master m, purchase_return_details c,  vendor d, user_group u 
							where 
							  m.group_for=u.id  and m.vendor_id=d.vendor_id and m.pr_no=c.pr_no and m.invoice_no!=''  ".$group_for_con.$con.$dealer_con."  group by c.pr_no order by m.pr_no  DESC";
							$query = db_query($res);
							
							//$two_weeks = time() - 14*24*60*60;
							while($data = mysqli_fetch_object($query))
							{
							
							?>
							<tr <?=($data->RCV_AMT>0)?'style="background-color:#FFCCFF"':'';?>>
							<td <?=$data->pr_no;?>;" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=$data->pr_no;?></td>
							<td <?=$data->pr_no;?>;" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?php echo date('d-m-Y',strtotime($data->pr_date));?></td>
							<td <?=$data->pr_no;?>;" <?=(++$z%2)?'':'class="alt"';?> style="text-align:left">&nbsp;<?=$data->vendor_name;?></td>
							<td <?=$data->pr_no;?>;" <?=(++$z%2)?'':'class="alt"';?> style="text-align:left"><?= find_a_field('purchase_return_type','return_type','id='.$data->return_type);?></td>
							<td <?=$data->pr_no;?>;" <?=(++$z%2)?'':'class="alt"';?> style="text-align:left"><?= find_a_field('warehouse','warehouse_name','warehouse_id='.$data->depot_id);?></td>
							<td <?=$data->pr_no;?>;" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;
							  <?=find_a_field('user_activity_management','fname','user_id='.$data->entry_by);?></td>
							  
							  <td <?=$data->pr_no?>)"<?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=$data->status;?></td>
							  
							  <td>
							  <button type="button" name="submitit" value="View" class="btn2 btn1-bg-submit" onClick="custom(<?=$data->pr_no;?>);" <?=(++$z%2)?'':'class="alt"';?> >
							 	 <i class="fa-solid fa-eye"></i>
							  </button>
							  					  
							  </td>
							</tr>
							
							<?
							$total_send_amt = $total_send_amt + $data->SEND_AMT;
							$total_rcv_amt = $total_rcv_amt + $data->RCV_AMT;
							}
							}
							?>

                    </tbody>
                </table>





        </div>
    </form>
</div>








<?php /*?><div class="form-container_large">
  <form action="" method="post" name="codz" id="codz">
    <table width="90%" border="0" align="center">
      <tr>
        <td>&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#FF9966"><strong>Vendor :</strong></td>
        <td colspan="3" bgcolor="#FF9966">
		<select name="vendor_id" id="vendor_id" style="width:280px;">
		
		<option></option>

        <? foreign_relation('vendor','vendor_id','vendor_name',$_POST['vendor_id'],'1 order by vendor_id');?>
    </select>		</td>
        <td rowspan="5" align="center" bgcolor="#FF9966"><strong>
          <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" class="btn1 btn1-submit-input"/>
        </strong></td>
      </tr>
      
      <tr>
        <td align="right" width="20%" bgcolor="#FF9966"><strong>Date:</strong></td>
        <td    width="20%"  bgcolor="#FF9966"><strong>
		<!--<input type="text" name="fdate" id="fdate" style="width:120px;" value="<?=($_POST[fdate]!='')?$_POST[fdate]:date('Y-m-1')?>" />-->
          <input type="text" name="fdate" id="fdate" style="width:100%;" value="<?=$_POST['fdate']?>" />
        </strong></td>
        <td align="center"  width="20%"  bgcolor="#FF9966"><strong> -to- </strong></td>
        <td   width="20%"  bgcolor="#FF9966"><strong>
          <input type="text" name="tdate" id="tdate" style="width:100%;" value="<?=$_POST['tdate']?>" />
        </strong></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#FF9966"><strong>Warehouse: </strong></td>
        <td colspan="3" bgcolor="#FF9966">
		
	
	
	<? if($master_id==1){?>	
                      <select name="warehouse_id" id="warehouse_id" style=" float:left; width:90%;">
					  
					  <option></option>

				 <? foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['warehouse_id'],'1');?>
 
                      </select>
					  
				<? }?>
					  
					  <? if($master_id==0){?>	
			
					  <select name="warehouse_id" id="warehouse_id" style=" float:left; width:90%;">
				

				 <? foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['warehouse_id'],'warehouse_id="'.$_SESSION['user']['depot'].'"');?>
 
                      </select>
					
				 <? }?>	 
		
		</td>
      </tr>
    </table>
  </form>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td><div class="tabledesign2">
<table width="100%" cellspacing="0" cellpadding="0" id="grp" style="font-size:12px;"><tbody>
<tr>
  <th width="5%">PR No</th>
  <th width="10%">PR Date</th>
  <th width="26%">Vendor  Name</th>
  <th width="13%">Return Type </th>
  <th width="15%">Warehouse Name</th>
  <!--<th>Zone</th>-->
<th width="13%">Entry By </th>
<th width="13%">Status </th>
  </tr>


<? 

if(isset($_POST['submitit'])){

if($_POST['fdate']!=''&&$_POST['tdate']!='') $con .= ' and m.pr_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';


		
		
		if($_POST['vendor_id']!='')
 		$dealer_con=" and m.vendor_id='".$_POST['vendor_id']."'";
		
		if($_POST['warehouse_id']!='') 
		$con .= ' and m.depot_id in ('.$_POST['warehouse_id'].') ';




    $res="select m.pr_no, m.pr_no, m.pr_date, m.vendor_id, m.return_type, m.depot_id,  d.vendor_name, m.entry_by, m.status from 
purchase_return_master m, purchase_return_details c,  vendor d, user_group u 
where 
  m.group_for=u.id  and m.vendor_id=d.vendor_id and m.pr_no=c.pr_no ".$group_for_con.$con.$dealer_con."  group by c.pr_no order by  m.pr_date, m.pr_no ";
$query = db_query($res);

//$two_weeks = time() - 14*24*60*60;
while($data = mysqli_fetch_object($query))
{

?>
<tr <?=($data->RCV_AMT>0)?'style="background-color:#FFCCFF"':'';?>>
<td onClick="custom(<?=$data->pr_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=$data->pr_no;?></td>
<td onClick="custom(<?=$data->pr_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?php echo date('d-m-Y',strtotime($data->pr_date));?></td>
<td onClick="custom(<?=$data->pr_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=$data->vendor_name;?></td>
<td onClick="custom(<?=$data->pr_no;?>);" <?=(++$z%2)?'':'class="alt"';?>><?= find_a_field('purchase_return_type','return_type','id='.$data->return_type);?></td>
<td onClick="custom(<?=$data->pr_no;?>);" <?=(++$z%2)?'':'class="alt"';?>><?= find_a_field('warehouse','warehouse_name','warehouse_id='.$data->depot_id);?></td>
<td onClick="custom(<?=$data->pr_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;
  <?=find_a_field('user_activity_management','fname','user_id='.$data->entry_by);?></td>
  
  <td onclick="custom(<?=$data->pr_no?>);"<?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=$data->status;?></td>
</tr>

<?
$total_send_amt = $total_send_amt + $data->SEND_AMT;
$total_rcv_amt = $total_rcv_amt + $data->RCV_AMT;
}
}
?>


</tbody></table>
</div></td>
</tr>
</table>
</div><?php */?>

<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>