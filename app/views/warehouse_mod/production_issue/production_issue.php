<?php










require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";





$title='Production Line Issue';











//do_calander('#pi_date','-100','0');

do_calander('#pi_date');



$page = 'production_issue.php';



if($_GET['req']!=''){

	$all = find_all_field('master_requisition_master','',' req_no='.$_GET['req']);

	$_SESSION['line_id']=$all->req_for;

	$_SESSION['req_no']=$all->req_no;

	$_SESSION['entry_by']=$all->entry_by;

}



if($_POST['line_id']!='') 

	$line_id = $_SESSION['line_id'];

elseif($_SESSION['line_id']!='') 

	$line_id = $_POST['line_id']=$_SESSION['line_id'];



$table_master='production_issue_master';

$unique_master='pi_no';

$table_detail='production_issue_detail';

$unique_detail='id';



if($_REQUEST['old_pi_no']>0)

$$unique_master=$_REQUEST['old_pi_no'];

elseif(isset($_GET['del'])){

	$$unique_master=find_a_field($table_detail,$unique_master,'id='.$_GET['del']); $del = $_GET['del'];

}

else

$$unique_master=$_REQUEST[$unique_master];



if(prevent_multi_submit()){

	if(isset($_POST['new'])){

		$crud   = new crud($table_master);

		$_POST['entry_at']=date('Y-m-d H:i:s');

		$_POST['entry_by']=$_SESSION['user']['id'];

		$_POST['status']='MANUAL';

		if($_POST['flag']<1){

		$$unique_master=$crud->insert();

		

		// Auto insert

		$table		=$table_detail;

		/*$sql3='select * from warehouse_requisition_details where req_no='.$_SESSION['req_no'];

		echo $sql3;

		$rs = db_query($sql3);

		while($row=mysqli_fetch_object($rs)){			

			$crud      	=new crud($table);

			echo $row->order_qty;

			$_POST['item_id']=$row->item_id;

			$_POST['status']='ISSUE';

			$_POST['unit_price']= find_a_field('item_info','d_price','item_id='.$row->item_id);

			$_POST['total_unit'] = $row->order_qty;

			$_POST['total_amt']= ($_POST['total_unit'] * $_POST['unit_price']);

			$xid = $crud->insert();

		}*/

		unset($$unique);

		$type=1;

		$msg='Product Issued. (PI No-'.$$unique_master.')';

	}else {

		$crud->update($unique_master);

		$type=1;

		$msg='Successfully Updated.';

	}

}



$$unique=$_SESSION[$unique];



if(isset($_POST['delete']))





{





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





if(isset($_POST['add'])&&($_POST[$unique_master]>0)){

		$table		=$table_detail;

		$crud      	=new crud($table);

		$iii=explode('#>',$_POST['item_id']);

		$_POST['item_id']=$iii[2];

		$_POST['status']='ISSUE';

		$_POST['unit_price']= find_a_field('journal_item','final_price','item_id='.$_POST['item_id'].   ' and tr_from in ("Production Receive","Local Purchase","Purchase") and order by final_price desc limit 1  ');

		$_POST['total_amt']= ($_POST['total_unit'] * $_POST['unit_price']);

		$xid = $crud->insert();

		//journal_item_control($_POST['item_id'] ,$_SESSION['user']['depot'],$_POST['pi_date'],0,$_POST['total_unit'],'Issue',$xid,'',$_SESSION['line_id'],$_POST['remarks']);

		//journal_item_control($_POST['item_id'] ,$_SESSION['line_id'],$_POST['pi_date'],$_POST['total_unit'],'0','Issue',$xid,'',$_SESSION['user']['depot'],$_POST['remarks']);

}











}





else





{





	$type=0;





	$msg='Data Re-Submit Error!';





}











if($del>0)





{	





		$crud   = new crud($table_detail);





		$condition=$unique_detail."=".$del;		





		$crud->delete_all($condition);





		$sql = "delete from journal_item where tr_from = 'Issue' and tr_no = '".$del."'";





		db_query($sql);





		$type=1;





		$msg='Successfully Deleted.';





}











if($$unique_master>0)





{





		$condition=$unique_master."=".$$unique_master;





		$data=db_fetch_object($table_master,$condition);





		foreach ($data as $key => $value)





		{ $$key=$value;}





		





}











		auto_complete_from_db('item_info','item_name','concat(item_name,"#>",item_description,"#>",item_id)','1','item_id');





?>











<script language="javascript">





function focuson(id) {





  if(document.getElementById('item_id').value=='')





  document.getElementById('item_id').focus();





  else





  document.getElementById(id).focus();





}





window.onload = function() {





if(document.getElementById("warehouse_id").value>0)





  document.getElementById("item_id").focus();





  else





  document.getElementById("req_date").focus();





}





</script>















  <div class="form-container_large">

	<form action="production_issue.php?req_no=<?=$req_no?>&pi_no=<?=$pi_no?>" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
      <div class="container-fluid bg-form-titel">

        <div class="row">

          <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">

            <div class="container n-form2">





              <div class="form-group row m-0 pb-1">

                <label for="req_note" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">PI No :</label>

                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

                  

      <input  name="pi_no" type="text" id="pi_no" value="<? if($$unique_master>0) echo $$unique_master; else echo (find_a_field($table_master,'max('.$unique_master.')','1')+1);?>" readonly/>



                </div>

              </div>





              <div class="form-group row m-0 pb-1">

                <label for="req_note" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Carried by :</label>

                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">



					<? $carried_by= find_a_field('user_activity_management','fname',' user_id='.$_SESSION['entry_by']); ?>

				  <input name="carried_by" type="text" id="carried_by" value="<?=$carried_by?>" />



                </div>

              </div>

			  

              <div class="form-group row m-0 pb-1">

                <label for="req_note" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Req. No:</label>

                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

						<? $req_no = $_SESSION['req_no']; ?>

						<input name="req_no" type="text" id="req_no"  value="<?=$req_no?>" readonly required/>

		

                </div>

              </div>







            </div>







          </div>

		  



			<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">

						<div class="container n-form2">

			

			

						  <div class="form-group row m-0 pb-1">

							<label for="req_note" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Issue Date : </label>

							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

							  <input name="pi_date" type="text" id="pi_date" value="<?=$pi_date?>" autocomplete="off" required/>			

							</div>

						  </div>

			

			

						  <div class="form-group row m-0 pb-1">

							<label for="req_note" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Notes :</label>

							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

							  <input name="remarks" type="text" id="remarks" value="<?=$remarks?>" tabindex="105" />

			

							</div>

						  </div>

						  

			

						  <div class="form-group row m-0 pb-1">

							<label for="req_note" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Manual Req no : </label>

							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

							 	<input name="manual_req_no" type="text" id="manual_req_no" value="<?=find_a_field('master_requisition_master','manual_req_no','req_no='.$_SESSION['req_no'])?>" tabindex="105" />

			

							</div>

						  </div>

			

			

			

			

						</div>

			

			

			

					  </div>

		  

          <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 ">

            <div class="container n-form2">



              <div class="form-group row m-0 pb-1">

                <label for="req_note" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">From :</label>

                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

                  

        <input name="warehouse_from" type="hidden" id="warehouse_from"  value="<?=$_SESSION['user']['depot']?>" />

        <input name="warehouse_from3" type="text" id="warehouse_from3"  value="<?=find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot'])?>" readonly required/>



                </div>

              </div>



              <div class="form-group row m-0 pb-1">

                <label for="req_note" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Production Line :</label>

                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

                          <input name="warehouse_to" type="hidden" id="warehouse_to"  value="<?=$line_id?>" />

        <input name="warehouse_from4" type="text" id="warehouse_from4" value="<?=find_a_field('warehouse','warehouse_name','warehouse_id='.$line_id)?>" required/>



                </div>

              </div>

			  

             





            </div>





          </div>



        </div>



        <div class="n-form-btn-class">

		

		<? if($$unique_master>0) {?>

		

		

		<input name="new" type="submit" value="Update Production Issue" class="btn1 btn1-bg-update" />

		

		

		<input name="flag" id="flag" type="hidden" value="1" />

		

		

		<? }else{?>

		

		

		<input name="new" type="submit" value="Initiate Production Issue" class="btn1 btn1-bg-submit"/>

		

		

		<input name="flag" id="flag" type="hidden" value="0" />

		

		

		<? }?>

	

        </div>

      </div>

	  

    </form>









<form action="select_prodiction_line.php?req_no=<?=$req_no?>&pi_no=<?=$pi_no?>" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">

	

      <!--Data multi Table design start-->

<div class="container-fluid pt-5 p-0 ">





	  

	  

<? if($$unique_master>0){?>





<table class="table1  table-striped table-bordered table-hover table-sm">

    <thead class="thead1">

		<tr class="bgc-info">

		  <th >S/L</th>

		  <th >Item Name</th>

		  <th >Item Description</th>

		  <th >Unit</th>

		  <th >STK Qty</th>

		  <th >Requisition Qty</th>

		  <th >Issue  Qty</th>

		</tr>

	</thead>

	<tbody  class="tbody1">

<? 

	 $res='select w.id,i.item_name,i.item_id,i.item_description,i.unit_name,w.order_qty,w.qty,w.warehouse_id from master_requisition_details w,item_info i where i.item_id=w.item_id and w.req_no='.$_SESSION['req_no'];

	$rs=db_query($res);

	

	

	$stock_flag = 0;

	

	while($row=mysqli_fetch_object($rs)){

		$i++;

		?>

		  <tr>

            	<td><?=$i?></td>

                <td><?=$row->item_name?></td>

                <td><?=$row->item_description?></td>

                <td><?=$row->unit_name?></td>

				

                <td>
				<input  type="text" name="stk<?=$row->id?>" id="stk<?=$row->id?>" value="<?=$stock=find_a_field('journal_item','sum(item_in-item_ex)','item_id="'.$row->item_id.'" and warehouse_id='.$row->warehouse_id); ?>" readonly />
				</td>

                <td><input type="text" name="req<?=$row->id?>" id="req<?=$row->id?>" value="<?=$row->order_qty?>" readonly /></td>

                <td>
				<? if($row->order_qty <= $stock){?>

					<input type="number" step="any" onchange="limitCross(<?=$row->id?>)" id="id<?=$row->id?>" name="id<?=$row->id?>" value="<?=($row->order_qty);?>" required/>
					
					<? }else{?>
					
					<input type="number" step="any" onchange="limitCross(<?=$row->id?>)" id="id<?=$row->id?>" name="id<?=$row->id?>" value="<?=($stock);?>" required/>

					
					<? }?>
					
					
					

                </td>

            </tr>

		<?

	}

?>

      </tbody>

  </table>









    <!--button design start-->



      <div class="container-fluid p-0 ">



        <div class="n-form-btn-class">

			  <input name="return" type="submit" class="btn1 btn1-bg-cancel" value="RETURN"/>

	  	  <input name="confirm" type="submit" class="btn1 btn1-bg-submit" value="CONFIRM" />

		  

        </div>



      </div>

	  

	  



<? }?>



</div>



    </form>







  </div>







<script>

function limitCross(id){


var stk= document.getElementById('stk'+id).value*1;
 
var reqStk=document.getElementById('id'+id).value*1;//$("#id"+id).val();

var req=document.getElementById('req'+id).value*1;//$("#req"+id).val();



if(reqStk>stk){
alert("Stock Qty Limit");
$("#id"+id).val(stk);
}
}

</script>













<script>$("#cz").validate();$("#cloud").validate();</script>





<?











require_once SERVER_CORE."routing/layout.bottom.php";





?>