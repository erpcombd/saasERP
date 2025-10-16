<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$title='New Production Planning Create';



do_calander('#exp_date');
do_calander('#req_date');







$table_master='production_planning_master';
$table_details='production_planning_details';



$unique='req_no';



if($_GET['new']>0){
unset($_SESSION[$unique]); 
}

	

if(isset($_POST['new'])){
$_SESSION[$unique];
$req_date=$_POST['req_date'];
$crud   = new crud($table_master); 

if($_SESSION[$unique] =='') { 
$_POST['rec_type']=$_SESSION['rec_type'];
$_POST['entry_by']=$_SESSION['user']['id'];
$_POST['entry_at']=date('Y-m-d H:i:s');
$_POST['edit_by']=$_SESSION['user']['id'];
$_POST['req_date']=$req_date;
$_POST['edit_at']=date('Y-m-d H:i:s');
$$unique=$_SESSION[$unique]=$crud->insert();
unset($$unique);
$type=1;
$msg='Requisition No Created. (Req No :-'.$_SESSION[$unique].')';

	}else {

$_POST['edit_by']=$_SESSION['user']['id'];
$_POST['edit_at']=date('Y-m-d H:i:s');
$crud->update($unique);
$type=1;
$msg='Successfully Updated.';
}
}










$$unique=$_SESSION[$unique];



if(isset($_POST['delete'])){

$crud   = new crud($table_master);
$condition=$unique."=".$$unique;		
$crud->delete($condition);
$crud   = new crud($table_details);
$condition=$unique."=".$$unique;		
$crud->delete_all($condition);
unset($$unique);
unset($_SESSION[$unique]);
$type=1;
$msg='Successfully Deleted.';

}







if($_GET['del']>0){

$crud   = new crud($table_details);
$condition="id=".$_GET['del'];		
$crud->delete_all($condition);
$type=1;
$msg='Successfully Deleted.';
}


if(isset($_POST['confirmm'])){

$req_no_id=$_POST['req_no_id'];
		// Details insert start
$res="select g.group_name, s.sub_group_name, i.item_id, i.item_name,i.status
		from item_group g, item_sub_group s, item_info i 
		where g.group_id=s.group_id and s.sub_group_id=i.sub_group_id ";		

//$res='select a.id,a.item_id,concat(b.item_name) as item_name,a.qoh as Floor_qty,a.exp_date,a.remarks,a.qty,"x" from master_requisition_details a,item_info b where b.item_id=a.item_id and  a.req_no='.$$unique;

 $q=db_query($res);
while($r=mysqli_fetch_object($q)){

$item_id=$r->item_id;
$production_qty=$_POST['qty_'.$r->item_id];
$entry_by=$_SESSION['user']['id'];

if($_POST['qty_'.$r->item_id]>0 && $req_no_id>0){

/*$update = "update master_requisition_details set qty='".$_POST['qty_'.$r->id]."', order_qty = '".$_POST['qty_'.$r->id]."' where id='".$r->id."' ";
db_query($update);*/

$insert_sql = "INSERT INTO production_planning_details (req_no,item_id,qty,entry_by,entry_at) VALUES ('$req_no_id', '$item_id', '$production_qty','$entry_by', NOW())";
db_query($insert_sql);
}else{
$delete = "delete from production_planning_details where item_id='".$r->item_id."' and req_no='".$req_no_id."' ";
db_query($delete);
}
}

							   

		// Details insert end	
unset($_POST);
$_POST[$unique]=$$unique;
$_POST['entry_by']=$_SESSION['user']['id'];
$_POST['entry_at']=date('Y-m-d H:i:s');
$_POST['status']='CHECKED';
$crud   = new crud($table_master);
$crud->update($unique);
unset($$unique);
unset($_SESSION[$unique]);
$type=1;
$msg='Successfully Forwarded for Approval.';
unset($_POST);
echo '<script> window.location.href = "mr_create.php"; </script>';
}



$req =$_POST['req_for'];
if(prevent_multi_submit()){

if(isset($_POST['add'])&&($_POST[$unique]>0)  && $_SESSION['csrf_token']===$_POST['csrf_token']){
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
	

//	if($_POST['rate'] != 0){


	$crud   = new crud($table_details);
	$_POST['qty']=$_POST['order_qty'];
	$_POST['req_for'] = $req;
	$iii=explode('#>',$_POST['item_id']);
	 $_POST['item_id']=$iii[2];



	$_POST['remarks'];



	$_POST['entry_by']=$_SESSION['user']['id'];



	$_POST['entry_at']=date('Y-m-d H:i:s');



	$_POST['edit_by']=$_SESSION['user']['id'];



	$_POST['edit_at']=date('Y-m-d H:i:s');



	$crud->insert();





	//}



	


/*
	else {



	 echo '<script>alert("You can not add a Zero value item.")</script>';



	}*/



	}



}







if($$unique>0){
$condition=$unique."=".$$unique;
$data=db_fetch_object($table_master,$condition);
foreach ($data as $key => $value)
{ $$key=$value;}
}



if($$unique>0) $btn_name='Update Planning'; else $btn_name='Initiate Planning';
if($_SESSION[$unique]<1)
$$unique=db_last_insert_id($table_master,$unique);




//auto_complete_from_db($table,$show,$id,$con,$text_field_id);

if($_SESSION['session_sub_group']=='all'){
$get_data = '';
}else{
$get_data =$_SESSION['session_sub_group'];
}



if($req_type=='DSTR'){ $con .= ' and s.status=0 and s.ledger_id_1 !=0';}



if($req_type=='Others'){ $con .= ' and (s.status=1 or s.ledger_id_1 =0) and s.group_id !=1100000000';}



if($req_type=='Asset'){ $con .= ' and s.group_id=1100000000';}



//auto_complete_from_db('item_info i,item_sub_group s','i.item_name','concat(i.item_name,"#>",i.item_id,"#>",i.item_id)',' 1 and i.sub_group_id=s.sub_group_id  '.$con.' ','item_id');











?>

<script language="javascript">



function sub_group_function(id){



	document.getElementById('sub_group_id').value=id;



	window.location.href = "../mr/mr_create.php?sub_group=" + id;



}



</script>









<div class="form-container_large">

	<form action="mr_create.php" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">

      <div class="container-fluid bg-form-titel">

        <div class="row">

          <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

		  <div class="container n-form2">



            <div class="form-group pb-1 row m-0">

			 <? $field='req_no';?>

              <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Planning No :</label>

              <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">

                <input  name="<?=$field?>" type="text" id="<?=$field?>" style="margin-left: 11px;" value="<?=$$field?>"/>

              </div>

            </div>

			 

			 <div class="form-group pb-1 row m-0">

						 <? $field='req_date'; if($req_date=='') $req_date =date('Y-m-d');?>

              <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Planning Date :</label>

              <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">

        			<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" style=""/>

              </div>

            </div>

			

			<?php /*?><div class="form-group pb-1 row m-0">

				<? $field='do_number';?>

              <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">PP No :</label>

              <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">

				<select name="do_number">

					<option></option>

					<? foreign_relation('production_requisition_master','req_no','req_no',$do_number,'status="CHECKED" ');?>

				</select>

		

              </div>

            </div><?php */?>

			 

			 <div class="form-group pb-1 row m-0">

			    <? $field='warehouse_id'; $table='warehouse';$get_field='warehouse_id';$show_field='warehouse_name';?>

              <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Warehouse :</label>

              <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">

			<select name="warehouse_id" id="warehouse_id">

					<option></option>

					<?php foreign_relation('warehouse','warehouse_id','warehouse_name',$warehouse_id,' use_type="WH"'); ?>

				</select>
 
              </div>

            </div>

</div>

          </div>

          <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

		  <div class="container n-form2">

		      <? $field='req_for';?>

            <div class="form-group pb-1 row m-0">

					<? $field = 'req_for' ?>

              <label  for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Requisition For :</label>

              <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">

					<select id="<?=$field?>" style="margin-left: 12px;" name="<?=$field?>"  onchange="getData2('manual_req_no_ajax.php', 'manual_req_no', this.value, document.getElementById('req_no').value);" required  >

					

					<? 

					

					if($_POST['req_for']>0)

					

					foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['req_for'],' use_type="SC"');

					

					elseif($req_for>0)

					

					foreign_relation('warehouse','warehouse_id','warehouse_name',$req_for,' use_type="SC"');

					

					else{

					

					echo '<option></option>';

					

					foreign_relation('warehouse','warehouse_id','warehouse_name',$req_for,' use_type="SC"');

					

					}

					

					?>

					</select>

              </div>

            </div>

           <?php /*?> <div class="form-group pb-1 row m-0">

			<? $field='manual_req_no';?>

              <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Line Req No :</label>

              <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">

					<span id="manual_req_no">

							<input  name="<?=$field?>" style="margin-left: 32px;" type="text" id="<?=$field?>" value="<?=$$field?>"/>

							<!--<input  name="pending_date" type="text" id="pending_date"   value="<?=$pending_date?>"/>-->

					</span>

              </div>

            </div><?php */?>

            <div class="form-group pb-1 row m-0">

			  <? $field='req_note';?>

              <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Additional Note :</label>

              <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">

       					 <input  name="<?=$field?>" style="margin-left: 10px;" type="text" id="<?=$field?>" value="<?=$$field?>"/>

              </div>

            </div>

            <?php /*?><div class="form-group pb-1 row m-0">

                <? $field='req_type';?>

              <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Requisition Type :</label>

              <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">	

			<select name="<?=$field?>" id="<?=$field?>">	

			 <option <? if ($$field=='DSTR') echo ' selected="selected"';?>>DSTR </option>	

			 <!--<option <? if ($$field=='Others') echo ' selected="selected"';?>>Others</option>	

			 <option <? if ($$field=='Asset') echo ' selected="selected"';?>>Asset</option>-->	

			</select>

			

              </div>

            </div><?php */?>

          </div>

		</div>

        </div>

		

		<div class="n-form-btn-class">

     			 <input name="new" type="submit" value="<?=$btn_name?>"  class="btn1 btn1-bg-submit"/>

		</div>

				

      </div>



</form>



<? if($_SESSION[$unique]>0){?>



<form action="?<?=$unique?>=<?=$$unique?>" method="post" name="cloud" id="cloud">

</form>





	<form action="" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">

      <div class="container-fluid pt-5 p-0">

<? 

 $chalan_qty="select item_id,sum(total_unit) as chalan_qty from sale_do_chalan where 1 group by item_id";
					$ch_query = db_query($chalan_qty);
					while($ch_data = mysqli_fetch_object($ch_query))
					{
					$ch_qty_get[$ch_data->item_id]=$ch_data->chalan_qty;
					}
$details_qty="select s.item_id as item, sum(s.total_unit) as so_qty from sale_do_details s 
inner join sale_do_master m on s.do_no = m.do_no 
where m.status in ('CHECKED','COMPLETED') group by s.item_id";
					$details_query = db_query($details_qty);
					while($details_data = mysqli_fetch_object($details_query))
					{
					$details_qty_get[$details_data->item]=$details_data->so_qty;
					}
$wh_stock_qty="select j.item_id,sum(j.item_in-j.item_ex) as stock_qty from journal_item j,warehouse w where 1 and j.warehouse_id=w.warehouse_id and w.use_type='WH' group by item_id";
					$stock_query = db_query($wh_stock_qty);
					while($stock_data = mysqli_fetch_object($stock_query))
					{
					$stock_qty_get[$stock_data->item_id]=$stock_data->stock_qty;
					}
$sec_stock_qty="select j.item_id,sum(j.item_in-j.item_ex) as stock_qty from journal_item j,warehouse w where 1 and j.warehouse_id=w.warehouse_id and w.use_type='SC' group by item_id";
					$sec_stock_query = db_query($sec_stock_qty);
					while($sec_stock_data = mysqli_fetch_object($sec_stock_query))
					{
					$sec_stock_qty_get[$sec_stock_data->item_id]=$sec_stock_data->stock_qty;
					}
					
 $sql="select g.group_name, s.sub_group_name, i.item_id, i.item_name,  i.sku_code, i.unit_name,  i.pack_size, 
    i.m_price, i.d_price, i.t_price, i.f_price, i.status
		from item_group g, item_sub_group s, item_info i where g.group_id=s.group_id and s.sub_group_id=i.sub_group_id ";

$query = db_query($sql);

//old
/*$res='select a.id,a.item_id,concat(b.item_name) as item_name,a.qoh as Floor_qty,a.exp_date,a.remarks,b.sub_group_id,a.qty,"x" from master_requisition_details a,item_info b where b.item_id=a.item_id and  a.req_no='.$req_no.' order by a.item_id';

	 

	 $found = 0;

 

 $query = db_query($res);*/





?>



<? 

//$res='select * from tbl_receipt_details where rec_no='.$str.' limit 5';

//echo link_report_del($res); ?>

		

		<table id="grp" class="table1  table-striped table-bordered table-hover table-sm">

          <thead class="thead1">

		<tr class="bgc-info">

			<th>Item Name</th>
			
			<!--<th>SO Qty</th>

			<th>Challaned Qty</th>-->

			<th>Pending Qty</th>

			<th>WH Stock Qty</th>
			<th>Section Stock Qty</th>

			<th>Production Qty</th>

			<!--<th>X</th>-->

		</tr>

		</thead>

	<tbody class="tbody1">

	<?

		 while($roww=mysqli_fetch_object($query)){
		 
		 $so_qty=$details_qty_get[$roww->item_id];
		 $ch_qty=$ch_qty_get[$roww->item_id];
 
	?>	

		<tr>

			<td><?=$roww->item_name;?></td>
			<td><?=$remain=$so_qty-$ch_qty;?></td>

			<td><?=$stock_qty_get[$roww->item_id];?></td>
			<td><?=$sec_stock_qty_get[$roww->item_id];?></td>
			<td><input type="text" name="qty_<?=$roww->item_id;?>" id="qty_<?=$roww->item_id;?>" value=" " /></td>

			

			<?php /*?><td><a onclick="if(!confirm('Are You Sure Execute this?')){return false;}" href="?del=<?=$roww->id;?>">&nbsp;X&nbsp;</a></td><?php */?>

		</tr>

<?

 }

?>

</tbody>

</table>

	  

	  <div class="n-form-btn-class">

<input name="delete"  type="submit" value="DELETE PLANNING" class="btn1 btn1-bg-cancel" />

			 <?php $detai=find_a_field('master_requisition_details','count(id)','req_no='.$req_no); if($detai>0){}?>
                  <input type="hidden" name="req_no_id" id="req_no_id" value="<?=$req_no;?>" />
				  <input name="confirmm" type="submit" value="CONFIRM PLANNING" class="btn1 btn1-bg-submit"/>


		</div>

      </div>

</form>



	

<? }?>

  </div>

  





<script>$("#codz").validate();$("#cloud").validate();</script>

<?

require_once SERVER_CORE."routing/layout.bottom.php";





?>