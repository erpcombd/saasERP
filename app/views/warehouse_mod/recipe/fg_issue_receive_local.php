<?php





session_start();




ob_start();




 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

//
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$title='New FG Receive';

$tr_type="Show";



$page = "fg_issue_receive.php";





$ajax_page = "fg_issue_ajax.php";





$page_for = 'fg_transfer';





do_calander('#st_date');


$table_master='fg_transfer_master';





$table_details='fg_transfer_details';





$unique='st_no';







if(isset($_GET['st_no']) && $_GET['st_no']>0){

$_SESSION[$unique]=$_GET['st_no'];

}









if(isset($_POST['new']))





{





		$crud   = new crud($table_master);


		if(!isset($_SESSION[$unique])) {



		$_POST['Issue_type'] = $page_for;

		$_POST['entry_by']=$_SESSION['user']['id'];





		$_POST['entry_at']=date('Y-m-d H:i:s');





	//	$_POST['edit_by']=$_SESSION['user']['id'];





		//$_POST['edit_at']=date('Y-m-d H:i:s');


		$_POST['status']='MANUAL';


		$$unique=$_SESSION[$unique]=$crud->insert();


		unset($$unique);

		$type=1;





		$msg=$title.'  No Created. (No :-'.$_SESSION[$unique].')';

		



		}





		else {





		$_POST['edit_by']=$_SESSION['user']['id'];





		$_POST['edit_at']=date('Y-m-d H:i:s');





		$crud->update($unique);





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











if($_GET['del']>0)

{





		$crud   = new crud($table_details);





		$condition="id=".$_GET['del'];		





		$crud->delete_all($condition);





	//	$sql = "delete from journal_item where tr_from = '".$page_for."' and tr_no = '".$_GET['del']."'";





	//	db_query($sql);





		$type=1;





		$msg='Successfully Deleted.';





		





}





if(isset($_POST['return']))

{





		//unset($_POST);





		$_POST[$unique]=$$unique;


		$_POST['status']='RETURNED';


		$crud   = new crud($table_master);

		$crud->update($unique);	
		
		
		
			unset($$unique);





		unset($_SESSION[$unique]);





		$type=1;





		$msg='Successfully Forwarded.';

echo '<script> window.location.assign("../recipe/select_fg_issue_local.php"); </script>';	
				
		}


	





if(isset($_POST['confirmm']))

{


			$_POST[$unique]=$$unique;
		
			$jv_no=next_journal_voucher_id();
		
		
			$jv=next_journal_voucher_id();
		
		
	$sql='select d.id,d.st_no,d.item_id,d.rate,d.qty,d.amount,m.warehouse_from,m.warehouse_to,m.st_date,m.group_for 
	from fg_transfer_master m, fg_transfer_details d 
	where m.st_no=d.st_no and d.st_no='.$$unique;

$query=db_query($sql);

while($databy=mysqli_fetch_object($query)){

journal_item_control($databy->item_id ,$databy->warehouse_from,$databy->st_date,0,$databy->qty,'fg_transfer',$databy->st_no,$databy->rate,0,$databy->id,'','',$databy->group_for,'');



journal_item_control($databy->item_id ,$databy->warehouse_to,$databy->st_date,$databy->qty,0,'fg_transfer',$databy->st_no,$databy->rate,0,$databy->id,'','',$databy->group_for,'');
				
				
		}
		
		
		

		
		$_POST['received_by']=$_SESSION['user']['id'];

		$_POST['received_at']=date('Y-m-d H:i:s');

		$_POST['status']='COMPLETE';

		$crud   = new crud($table_master);

		$crud->update($unique);

		unset($$unique);

		unset($_SESSION[$unique]);

		$type=1;

		$msg='Successfully Forwarded.';

		$tr_type="Complete";


}



if(isset($_POST['add'])&&($_POST[$unique]>0))





{





		$crud   = new crud($table_details);

		$iii_from=explode('#>',$_POST['item_id']);


		//$iii_to=explode('#>',$_POST['item_id_to']);
		
		
	//	$rate_from =explode('##>',$_POST['item_id']);
		//$rate_to =explode('##>',$_POST['item_id_to']);

		$_POST['item_id']=$iii_from[1];

		//$_POST['item_id_to']=$iii_to[1];

		$_POST['qty'] =$_POST['pcs'];

		//$_POST['rate'] =$rate_from[1];
		
	//	$_POST['rate_to'] =$rate_to[1];
		

		//$_POST['amount'] =( $_POST['qty'] * );

	//	$_POST['amount_to'] =( $_POST['qty'] * $rate_to[1] );

		$_POST['entry_by']=$_SESSION['user']['id'];





		$_POST['entry_at']=date('Y-m-d H:i:s');





		$_POST['edit_by']=$_SESSION['user']['id'];





		$_POST['edit_at']=date('Y-m-d H:i:s');





		$xid = $crud->insert();





	//	journal_item_control($_POST['item_id'] ,$_POST['warehouse_from'],$_POST['oi_date'],0,$_POST['qty'],$page_for,$xid,$_POST['rate'],'',$$unique);





}











if($$unique>0)





{





		$condition=$unique."=".$$unique;





		$data=db_fetch_object($table_master,$condition);





		foreach ($data as $key => $value)





		{ $$key=$value;}




}





if($$unique>0) $btn_name='Update OI Information'; else $btn_name='Initiate OI Information';





if($_SESSION[$unique]<1)





$$unique=db_last_insert_id($table_master,$unique);





auto_complete_from_db('item_info','item_name','concat(item_name,"#>",item_id,"#>",finish_goods_code)','sub_group_id=500100000','item_id');

//auto_complete_from_db('item_info','item_name','concat(item_name,"#>",item_id,"#>",finish_goods_code,"##>",cost_price)','','item_id_to');

$tr_from="Warehouse";

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





<script language="javascript">





function count()





{



//var pkt_size = ((document.getElementById('pkt_size').value)*1);

var pcs=((document.getElementById('pcs').value)*1);

//var ctn = ((document.getElementById('ctn').value)*1);

//var qty = (ctn * pkt_size)+ pcs;

var rate = ((document.getElementById('rate').value)*1); 

var amt = pcs * rate;

document.getElementById('amount').value = amt.toFixed(2);	






}

function sub_group_function(id){



	document.getElementById('sub_group_id').value=id;



	window.location.href = "../stock_transfer/st_issue.php?sub_group=" + id;



}





</script>




<div class="form-container_large">
<form action="" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
      <div class="container-fluid bg-form-titel">
        <div class="row">
          	  

			<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
						<div class="container n-form2">
			
			
						  <div class="form-group row m-0 pb-1">
						  <? $field='st_no';?>
							<label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">S T No : </label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
								<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" readonly="readonly"/>
							</div>
						  </div>
			
			
						  <div class="form-group row m-0 pb-1">
						  	<? $field='st_date'; if($st_date=='') $st_date =''; ?>
							<label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">ST Date : </label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
       							<input  name="<?=$field?>" type="date" id="<?=$field?>" value="<?=$$field?>" required readonly="readonly"/>
							</div>
						  </div>

						</div>
			
			
			
					  </div>
					  
					  
		<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
						<div class="container n-form2">
	  <? $field='warehouse_from'; if($warehouse_from=='') $warehouse_from =''; ?>
						  <div class="form-group row m-0 pb-1">
							<label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">WH From : </label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

								<select required name="<?=$field?>" id="<?=$field?>" disabled="disabled">
								<? foreign_relation('warehouse','warehouse_id','warehouse_name',$$field,'1 order by warehouse_name asc');?>
								
								</select>
								
								<?php /*?><input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$_SESSION['user']['depot']?>"  required/><?php */?>
			
							</div>
						  </div>
			
						
						  <div class="form-group row m-0 pb-1">
						      <? $field='warehouse_to';?>
							<label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">WH To : </label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
								<select required name="<?=$field?>" id="<?=$field?>" disabled="disabled">
								<? foreign_relation('warehouse','warehouse_id','warehouse_name',$$field,'1 order by warehouse_name asc');?>
								</select>
								
							</div>
						  </div>
			
			
						</div>
			
			
			
					  </div>
					  
		  
          <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
            <div class="container n-form2">

              <div class="form-group row m-0 pb-1">
			      <? $field='st_details';?>
                <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Note :</label>
                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
						<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required readonly="readonly"/>
                </div>
              </div>

              <div class="form-group row m-0 pb-1">
		<? $field='manual_req_no';?>
                <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Line ST No :</label>
                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

						<span id="manual_req_no">
						
								<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>
						
						</span>

                </div>
              </div>
			  
             


            </div>


          </div>

        </div>

<!--        <div class="n-form-btn-class">
    	  <input name="new" type="submit" class="btn1 btn1-bg-submit" value="<?=$btn_name?>" />
        </div>-->
		
      </div>
	  
    </form>




<form action="?<?=$unique?>=<?=$$unique?>" method="post" name="cloud" id="cloud">
	
      <!--Data multi Table design start-->
<div class="container-fluid pt-0 p-0 ">
<!--
<table class="table1  table-striped table-bordered table-hover table-sm">
    <thead class="thead1">
		<tr class="bgc-info">

		</tr>
	</thead>
	<tbody class="tbody1">

	</tbody>
  </table>-->




</div>

</form>


<? if($_SESSION[$unique]>0){?>

<form action="?<?=$unique?>=<?=$$unique?>" method="post" name="cloud" id="cloud">

<?php /*?><table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">
                        <tr>
                          <td width="15%" rowspan="2" align="center" bgcolor="#0099FF"><strong>Transfer Item  </strong></td>
                          <td width="4%" rowspan="2" align="center" bgcolor="#0099FF"><strong>Stock</strong></td>
                          <td width="5%" rowspan="2" align="center" bgcolor="#0099FF"><strong>Unit</strong></td>                   	
                          <td width="5%" rowspan="2" align="center" bgcolor="#0099FF">Rate</td>
                          <td align="center" bgcolor="#0099FF">Qty</td>						  
							 <td align="center" width="5%" rowspan="2" bgcolor="#0099FF">Amount</td>
                          <td width="10%"  rowspan="3" align="center" bgcolor="#FF0000">
                            <div class="button">
                              <input name="add" type="submit" id="add" value="ADD" tabindex="12" class="update"/>                       
                          </div>				        
						  </td>
                        </tr>
                      <tr>
                        <td width="5%" align="center" bgcolor="#0099FF"><strong>PCS/KG</strong></td>
	  </tr>
	  <tr>
<td align="center" bgcolor="#CCCCCC">
  <input  name="issue_type" type="hidden" id="issue_type" value="<?=$page_for?>"  required="required"/>
  <input  name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>
<input  name="warehouse_from" type="hidden" id="warehouse_from" value="<?=$warehouse_from?>"/>
<input  name="warehouse_to" type="hidden" id="warehouse_to" value="<?=$warehouse_to?>"/>
<input  name="st_date" type="hidden" id="st_date" value="<?=$rp_date?>"/>
<input  name="item_id" type="text" id="item_id" value="<?=$item_id?>" style="width:180px;" required  onblur="getData2('<?=$ajax_page?>', 'po',this.value,document.getElementById('warehouse_from').value);" /></td>
<td colspan="3" align="center" bgcolor="#CCCCCC"><span id="po">
  <input name="stk" type="text" class="input3" id="stk" style="width:50px;" readonly="readonly"/>
  <input name="rate" type="text" class="input3" id="rate"  style="width:50px;"  value="<?=$issue_price;?>" onchange="count()"  readonly="readonly">
  <input name="unit" type="text" class="input3" id="unit" style="width:50px;" readonly="readonly"/>
</span></td>
<td align="center" bgcolor="#CCCCCC"><input name="pcs" type="text" class="input3" id="pcs"  maxlength="100" style="width:60px;" onchange="count()" required/></td>
<td align="center" bgcolor="#CCCCCC"><input name="amount" type="text" class="input3" id="amount"  maxlength="100" style="width:60px;" onchange="count()" readonly="readonly"/></td>
</tr>
</table><?php */?>

<table width="40%" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
<tr>
<td rowspan="2" align="center" bgcolor="#CCFF99">
<a href="fg_transfer_report.php?v_no=<?=$st_no?>" target="_blank"><img src="../../../images/print.png" width="26" height="26" /></a>
</td>
</tr>
</table>


<div class="tabledesign2 pt-3">

<? 
 $res='select a.id,(SELECT item_name from item_info where item_id = a.item_id)as Item_From,a.ctn,a.pcs,a.qty Total,remarks,"x" from fg_transfer_details a,item_info b where b.item_id=a.item_id and a.st_no='.$st_no;

echo link_report($res);

?>

</div>




</form>


<form action="" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">

    <!--button design start-->
		<div class="container-fluid p-0">
        <div class="n-form-btn-class">
			<input name="return" type="submit" class="btn1 btn1-bg-cancel" value="Return"/>
      		<input name="confirmm" type="submit"  class="btn1 btn1-bg-submit" value="CONFIRM"/>
	   </div>
      </div>
	  


</form>



  </table>











<? }?>




</div>






<br /><br />
<br /><br />






<script>$("#codz").validate();$("#cloud").validate();</script>





<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>