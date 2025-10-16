<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
require_once SERVER_CORE."routing/inc.notify.php";

do_calander('#fdate');
do_calander('#tdate');

$title='Vehicle Requisition Approval';
$crud= new crud('vehicle_requisition');

if($_GET['approve']>0){
  $_POST['req_no']=$_GET['approve'];
  $_POST['status']="APPROVED";
  $crud->update('req_no');

}
if($_GET['reject']>0){
  $_POST['req_no']=$_GET['reject'];
  $_POST['status']="REJECT";
  $crud->update('req_no');

}



?>

<div class="form-container_large">

    <form action="" method="post" name="codz" id="codz" autocomplete="off">

        <div class="container-fluid bg-form-titel">
            <div class="row">
                <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5 pt-1 pb-1">
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Date From</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <input type="text" name="fdate" id="fdate"  value="<? if($fdate !=''){echo $_POST[fdate];}else{ } //=$_POST[fdate] ?>" required/>
                        </div>
                    </div>

                </div>
				<div class="col-sm-5 col-md-5 col-lg-5 col-xl-5 pt-1 pb-1">
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Date To</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <input type="text" name="tdate" id="tdate" value="<? if($tdate !=''){echo $_POST[tdate];}else{ } //=$_POST[tdate]?>" required />
                        </div>
                    </div>

                </div>

                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                    <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" class="btn1 btn1-submit-input"/>
                </div>

            </div>
        </div>

    </form>




        <div class="container-fluid pt-5 p-0 ">
                <table class="table1  table-striped table-bordered table-hover table-sm">
                    <thead class="thead1">
                    <tr class="bgc-info">
                        <th>Req No</th>
                        <th>Vehicle Type</th>
                        <th>From Time</th>
                        <th>To Time</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Person</th>
                        <th>Req By</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody class="tbody1">
<?php
if(isset($_POST['submitit'])){

$con=' and r.req_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
}
 $sql='select r.*,t.type,u.fname from vehicle_requisition r,vehicle_type t,user_activity_management u where r.vehicle_type=t.id and r.entry_by=u.user_id '.$con.' and r.status="PENDING" order by r.from_date DESC';
$query=db_query($sql);
while($data=mysqli_fetch_object($query)){
?>
                      <tr>
                        <td><?=$data->req_no ?></td>
                        <td><?=$data->type ?></td>
                        <td><?=$data->from_date." ".date('h:i A', strtotime($data->from_time)); ?></td>
                        <td><?=$data->to_date." ".date('h:i A', strtotime($data->to_time)); ?></td>
                        <td><?=$data->where_from ?></td>
                        <td><?=$data->where_to ?></td>
                        <td><?=$data->passenger ?></td>
                        <td><?=$data->fname ?></td>
                        <td><a class="btn btn-success btn-sm" href="requisition_approve.php?id=<?=$data->req_no?>">Approve</a>
                            
                       
                      </tr>
                  <? } ?>  
                    </tbody>
                </table>





        </div>

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
        <td align="right" bgcolor="#FF9966"><strong>Customer:</strong></td>
        <td colspan="3" bgcolor="#FF9966">
		<select name="dealer_code" id="dealer_code" style="width:280px;">
		
		<option></option>

        <? foreign_relation('dealer_info','dealer_code','dealer_name_e',$_POST['dealer_code'],'depot="'.$_SESSION['user']['depot'].'" order by dealer_code');?>
    </select>		</td>
        <td rowspan="5" align="center" bgcolor="#FF9966"><strong>
          <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" class="btn1 btn1-submit-input"/>
        </strong></td>
      </tr>
      
      <tr>
        <td align="right" width="20%" bgcolor="#FF9966"><strong>Date:</strong></td>
        <td    width="20%"  bgcolor="#FF9966"><strong>
		<!--<input type="text" name="fdate" id="fdate" style="width:120px;" value="<?=($_POST[fdate]!='')?$_POST[fdate]:date('Y-m-1')?>" />-->
          <input type="text" name="fdate" id="fdate" style="width:100%;" value="<?=$_POST[fdate]?>" />
        </strong></td>
        <td align="center"  width="20%"  bgcolor="#FF9966"><strong> -to- </strong></td>
        <td   width="20%"  bgcolor="#FF9966"><strong>
          <input type="text" name="tdate" id="tdate" style="width:100%;" value="<?=$_POST[tdate]?>" />
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
  <th width="5%">SO No</th>
  <th width="10%">SO Date</th>
  
  <th width="26%">Customer Name</th>
   
  <th width="15%">Warehouse Name</th>
  <th width="15%">Status</th>
 
<th width="13%">Entry By </th>
  </tr>


<? 

if(isset($_POST['submitit'])){

if($_POST['fdate']!=''&&$_POST['tdate']!='') $con .= ' and m.do_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';


		
		
		if($_POST['dealer_code']!='')
 		$dealer_con=" and m.dealer_code='".$_POST['dealer_code']."'";
		
		if($_POST['warehouse_id']!='') 
		$con .= ' and m.depot_id in ('.$_POST['warehouse_id'].') ';




    $res="select m.do_no, m.do_no, m.do_date, m.dealer_code, m.job_no, m.sales_type, m.depot_id,  d.dealer_name_e, m.entry_by, m.status from 
sale_do_master m, sale_do_details c,  dealer_info d, user_group u 
where 
  m.group_for=u.id  and m.dealer_code=d.dealer_code and m.do_no=c.do_no ".$group_for_con.$con.$dealer_con."  group by c.do_no order by m.do_no desc";
$query = mysql_query($res);

$two_weeks = time() - 14*24*60*60;
while($data = mysql_fetch_object($query))
{

?>
<tr <?=($data->RCV_AMT>0)?'style="background-color:#FFCCFF"':'';?>>
<td onClick="custom(<?=$data->do_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=$data->do_no;?></td>
<td onClick="custom(<?=$data->do_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?php echo date('d-m-Y',strtotime($data->do_date));?></td>
<!--<td onClick="custom(<?=$data->do_no;?>);" <?=(++$z%2)?'':'class="alt"';?>><?=$data->job_no;?></td>-->
<td onClick="custom(<?=$data->do_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=$data->dealer_name_e;?></td>
<td onClick="custom(<?=$data->do_no;?>);" <?=(++$z%2)?'':'class="alt"';?>><?= find_a_field('warehouse','warehouse_name','warehouse_id='.$data->depot_id);?></td>
<td onClick="custom(<?=$data->do_no;?>);" <?=(++$z%2)?'':'class="alt"';?>><?=$data->status;?></td>
<td onClick="custom(<?=$data->do_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;
  <?=find_a_field('user_activity_management','fname','user_id='.$data->entry_by);?></td>
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