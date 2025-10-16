<?php






 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$title='New Re_processing Issue';





$page = "rp_issue.php";





$ajax_page = "rp_issue_ajax.php";





$page_for = 'Reprocessing';





do_calander('#rp_date');











$table_master='item_reprocessing_master';





$table_details='item_reprocessing_details';





$unique='rp_no';







if(isset($_GET['rp_no']) && $_GET['rp_no']>0){

$_SESSION[$unique]=$_GET['rp_no'];

}









if(isset($_POST['new']))





{





		$crud   = new crud($table_master);











		if(!isset($_SESSION[$unique])) {



		$_POST['Issue_type'] = $page_for;

		$_POST['entry_by']=$_SESSION['user']['id'];





		$_POST['entry_at']=date('Y-m-d h:s:i');





		$_POST['edit_by']=$_SESSION['user']['id'];





		$_POST['edit_at']=date('Y-m-d h:s:i');





		$$unique=$_SESSION[$unique]=$crud->insert();





		unset($$unique);





		$type=1;





		$msg=$title.'  No Created. (No :-'.$_SESSION[$unique].')';





		}





		else {





		$_POST['edit_by']=$_SESSION['user']['id'];





		$_POST['edit_at']=date('Y-m-d h:s:i');





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





		





		$sql = "delete from journal_item where tr_from = '".$page_for."' and tr_no = '".$_GET['del']."'";





		db_query($sql);





		$type=1;





		$msg='Successfully Deleted.';





		





}





if(isset($_POST['confirmm']))

{


		unset($_POST);


		echo $_POST['rp_no'];


		$_POST[$unique]=$$unique;

		$_POST['approved_by']=$_SESSION['user']['id'];

		$_POST['entry_at']=date('Y-m-d h:s:i');





		$_POST['status']='CHECKED';





		$crud   = new crud($table_master);

		



		$crud->update($unique);

			echo	$sql ='select r.*,rm.* from  item_reprocessing_details r ,item_reprocessing_master rm where rm.rp_no=r.rp_no and rm.rp_no ="'.$$unique.'"';
				
				$result = db_query($sql);
				
				while($data=mysqli_fetch_object($result)){
		
		
		journal_item_control($data->item_id_from ,$data->warehouse_from,$data->rp_date,0,$data->qty,'Re-Processing Issue',$data->id,$data->rate_from,'',$$unique);
		journal_item_control($data->item_id_to ,$data->warehouse_to,$data->rp_date,$data->qty,0,'Re-Processing Receive',$data->id,$data->rate_from,'',$$unique);
		

}

		unset($$unique);





		unset($_SESSION[$unique]);

		$type=1;

		$msg='Successfully Forwarded.';
		


echo '<script> window.location.assign("../rp_issue/rp_issue.php"); </script>';



}











if(isset($_POST['add'])&&($_POST[$unique]>0))





{





		$crud   = new crud($table_details);

		$iii_from=explode('#>',$_POST['item_id_from']);


		$iii_to=explode('#>',$_POST['item_id_to']);
		
		
		$rate_from =explode('##>',$_POST['item_id_from']);
		$rate_to =explode('##>',$_POST['item_id_to']);

		$_POST['item_id_from']=$iii_from[1];

		$_POST['item_id_to']=$iii_to[1];

		$_POST['qty'] =( $_POST['pkt_size'] * $_POST['ctn'] ) + $_POST['pcs'];

		$_POST['rate_from'] =$rate_from[1];
		
		$_POST['rate_to'] =$rate_to[1];
		

		$_POST['amount_from'] =( $_POST['qty'] * $rate_from[1] );

		$_POST['amount_to'] =( $_POST['qty'] * $rate_to[1] );

		$_POST['entry_by']=$_SESSION['user']['id'];





		$_POST['entry_at']=date('Y-m-d h:s:i');





		$_POST['edit_by']=$_SESSION['user']['id'];





		$_POST['edit_at']=date('Y-m-d H:s:i');





		$xid = $crud->insert();





		





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





auto_complete_from_db('item_info','item_name','concat(item_name,"#>",item_id,"#>",finish_goods_code,"##>",cost_price)','','item_id_from');

auto_complete_from_db('item_info','item_name','concat(item_name,"#>",item_id,"#>",finish_goods_code,"##>",cost_price)','','item_id_to');



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





  document.getElementById("item_id_from").focus();





  else





  document.getElementById("req_date").focus();





}





</script>





<script language="javascript">





function count()





{



var pkt_size = ((document.getElementById('pkt_size').value)*1);

var pcs=((document.getElementById('pcs').value)*1);

var ctn = ((document.getElementById('ctn').value)*1);

var qty = (ctn * pkt_size)+ pcs;

var rate = ((document.getElementById('rate').value)*1); 

var amt = qty * rate;







}

function sub_group_function(id){



	document.getElementById('sub_group_id').value=id;



	window.location.href = "../other_issue/other_issue.php?sub_group=" + id;



}





</script>





<div class="form-container_large">





<form action="" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">





<table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">





  <tr>





    <td valign="top"><fieldset>





    <? $field='rp_no';?>





      <div>





        <label for="<?=$field?>">RP  No: </label>





        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>





      </div>





	<? $field='rp_date'; if($rp_date=='') $rp_date =''; ?>





      <div>





        <label for="<?=$field?>">RP Date:</label>





        <input  name="<?=$field?>" type="date" id="<?=$field?>" value="<?=$$field?>" required/>





      </div>

	  

	  

	  <? $field='warehouse_from'; if($warehouse_from=='') $warehouse_from =''; ?>





      <div>





        <label for="<?=$field?>">Warehouse From:</label>





       

<select required name="<?=$field?>" style="width:160px;" id="<?=$field?>">

<? foreign_relation('warehouse','warehouse_id','warehouse_name',$$field,'1 order by warehouse_name asc');?>

</select>





      </div>





    <? $field='warehouse_to';?>





      <div>





        <label for="<?=$field?>">Warehouse To:</label>





        <!--<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>-->



<select required name="<?=$field?>" style="width:160px;" id="<?=$field?>">

<? foreign_relation('warehouse','warehouse_id','warehouse_name',$$field,'1 order by warehouse_name asc');?>

</select>

      </div>











<?php /*?>    <input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$_SESSION['user']['depot']?>"  required/>
<?php */?>
















    </fieldset></td>





    <td>





			<fieldset>





			





    <? $field='rp_details';?>





      <div>





        <label for="<?=$field?>">Note:</label>





        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>





      </div>





      <div></div>

















			</fieldset>	</td>





  </tr>





  <tr>





    <td colspan="2"><div class="buttonrow" style="margin-left:240px;">





      <input name="new" type="submit" class="btn1" value="<?=$btn_name?>" style="width:250px; font-weight:bold; font-size:12px;" />





    </div></td>





    </tr>





</table>





</form>





<? if($_SESSION[$unique]>0){?>





<form action="?<?=$unique?>=<?=$$unique?>" method="post" name="cloud" id="cloud">





<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">





                        <tr>
                          <td width="15%" rowspan="2" align="center" bgcolor="#0099FF"><strong>Transfer Item Out </strong></td>
                          <td width="4%" rowspan="2" align="center" bgcolor="#0099FF"><strong>Stock</strong></td>
                          <td width="5%" rowspan="2" align="center" bgcolor="#0099FF"><strong>Unit</strong></td>
                          <td width="29%" rowspan="2" align="center" bgcolor="#0099FF"><strong>Transfer Item In </strong></td>
                          <td width="4%" rowspan="2" align="center" bgcolor="#0099FF"><strong>Stock</strong></td>
                          <td width="5%" rowspan="2" align="center" bgcolor="#0099FF"><strong>Unit</strong></td>
                     	
                          <td align="center" bgcolor="#0099FF">Qty</td>

                          <td width="10%"  rowspan="3" align="center" bgcolor="#FF0000">
                            
                            
                            
                            
                            
                            <div class="button">
                              
                              
                              
                              
                              
                              <input name="add" type="submit" id="add" value="ADD" tabindex="12" class="update"/>                       
                          </div>				        </td>
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





<input  name="rp_date" type="hidden" id="rp_date" value="<?=$rp_date?>"/>







<input  name="item_id_from" type="text" id="item_id_from" value="<?=$item_id_from?>" style="width:180px;" required  onblur="getData2('<?=$ajax_page?>', 'po',this.value,document.getElementById('warehouse_from').value);" /></td>


<td colspan="2" align="center" bgcolor="#CCCCCC"><span id="po">
  <input name="stk" type="text" class="input3" id="stk" style="width:30px;" readonly="readonly"/>
  <input name="rate_from" type="hidden" class="input3" id="rate_from"  style="width:30px;"  value="<?=$item_all->cost_price;?>" onchange="count()"  readonly="readonly">
  <input name="unit" type="text" class="input3" id="unit" style="width:30px;" readonly="readonly"/>
</span></td>
<td align="center" bgcolor="#CCCCCC">
<input  name="item_id_to" type="text" id="item_id_to" value="<?=$item_id_to?>" style="width:180px;" required onblur="getData2('<?=$ajax_page?>', 'rp',this.value,document.getElementById('warehouse_to').value);" /></td>
<td colspan="2" align="center" bgcolor="#CCCCCC">

<span id="rp">
<input name="stk" type="text" class="input3" id="stk" style="width:30px;" readonly="readonly"/>
<input name="rate_to" type="hidden" class="input3" id="rate_to"  style="width:30px;"  value="<?=$item_all->cost_price;?>" onchange="count()"  readonly="readonly"  />
<input name="unit" type="text" class="input3" id="unit" style="width:30px;" readonly="readonly"/>
</span></td>

<td align="center" bgcolor="#CCCCCC"><input name="pcs" type="text" class="input3" id="pcs"  maxlength="100" style="width:60px;" onchange="count()" required/></td>
</tr>
    </table>





					  <br /><br /><br /><br />

















<table width="100%" border="0" cellspacing="0" cellpadding="0">











    <tr>





      <td>





<div class="tabledesign2">





<? 

 $res='select a.id,(SELECT item_name from item_info where item_id = a.item_id_from)as Item_From,(SELECT item_name from item_info where item_id = a.item_id_to) as Item_To, a.unit_name,a.rate_from,a.qty as Total,a.amount_from,"x" from item_reprocessing_details a,item_info b where b.item_id=a.item_id_from and a.rp_no='.$rp_no;





echo link_report_add_del_auto($res);





?>





</div>





</td>





    </tr>





	    	





	











				





    <tr>





     <td>











 </td>





    </tr>





  </table>





</form>





<form action="" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">





  <table width="100%" border="0">





    <tr>





      <td align="center">&nbsp;</td>





      <td align="center">











      <input name="confirmm" type="submit" class="btn1" value="CONFIRM AND FORWARD RD" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:#090" />











      </td>





    </tr>





  </table>





</form>





<? }?>





</div>





<script>$("#codz").validate();$("#cloud").validate();</script>





<?





$main_content=ob_get_contents();





ob_end_clean();





require_once SERVER_CORE."routing/layout.bottom.php";





?>