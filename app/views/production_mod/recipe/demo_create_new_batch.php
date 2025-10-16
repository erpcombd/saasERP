<?php




 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$title='Production Line Issue';















do_calander('#pi_date');



$page = 'create_new_batch.php';



if($_POST['line_id']>0) 



$line_id = $_SESSION['line_id']=$_POST['line_id'];



elseif($_SESSION['line_id']>0) 



$line_id = $_POST['line_id']=$_SESSION['line_id'];























$table_master='production_floor_issue_master';



$unique_master='pi_no';







$table_detail='production_floor_issue_detail';



$unique_detail='id';







if($_REQUEST['old_pi_no']>0)



$$unique_master=$_REQUEST['old_pi_no'];



elseif(isset($_GET['del']))



{



$$unique_master=find_a_field($table_detail,$unique_master,'id='.$_GET['del']); $del = $_GET['del'];



}



else



$$unique_master=$_REQUEST[$unique_master];







if(prevent_multi_submit()){







if(isset($_POST['new']))



{



		$crud1   = new crud($table_master);	



		$crud2   = new crud('recipe_issue_master');	



		$$unique_master=$_POST[$unique_master];



		$_POST['entry_at']=date('Y-m-d H:i:s');



		$_POST['entry_by']=$_SESSION['user']['id'];



		$_POST['status']='MANUAL';



		$pack_size = find_a_field('item_info','pack_size','item_id='.$_POST['item_id']);



		



		$_POST['batch_qty'] = ($_POST['batch_ctn']*$pack_size) + $_POST['batch_pcs'];



		



		// $_POST['batch_ctn'] = (int)($_POST['batch_qty']/$pack_size);



		// $_POST['batch_pcs'] = (int)($_POST['batch_qty']%$pack_size);



		



		$_POST['bat']=$_SESSION['user']['id'];



		if($_POST['flag']<1){



		unset($_POST[$unique_master]);



		unset($$unique_master);



		$crud1->insert();



		$crud2->insert();



		$$unique_master = find_a_field($table_master,'max('.$unique_master.')','1');



		$$unique_master2 = find_a_field('recipe_issue_master','max('.$unique_master.')','1');



		$type=1;



		$msg='Product Issued. (PI No-'.$$unique_master.')';



		}



		else {



		$crud1->update($unique_master);



		$crud2->update($unique_master2);



		$type=1;



		$msg='Successfully Updated.';



		}



}







if(isset($_POST['confirm'])&&($_POST[$unique_master]>0))



{







		$sql = 'select i.* from item_info i,production_ingredient_detail r where i.item_id =r.raw_item_id and r.item_id='.$_POST['item_id'];



		$query = db_query($sql);







		while($data = mysqli_fetch_object($query)){



if($_POST['raw_qty_'.$data->item_id]>0){	echo $_POST['raw_qty_'.$data->item_id];



		if($data->cost_price !=0){



		$total_amt = $_POST['raw_qty_'.$data->item_id]*$data->cost_price;



		}



		else {



		$p_price = find_a_field('production_floor_issue_master','unit_price','item_id='.$data->item_id);



		$total_amt = $_POST['raw_qty_'.$data->item_id]* $p_price;



		



		}



		



		$g_t_item = $_POST['total_unit_'.$data->item_id] = $_POST['raw_qty_'.$data->item_id]+$_POST['wastage_qty_'.$data->item_id];











$do = "INSERT INTO production_floor_issue_detail 



(pi_no, pi_date, item_id, warehouse_from, warehouse_to, total_unit,raw_qty,wastage_qty, unit_price, total_amt) VALUES 



('".$_POST['pi_no']."', '".$_POST['pi_date']."', '".$data->item_id."', '".$line_id."', '0', '".$_POST['total_unit_'.$data->item_id]."','".$_POST['raw_qty_'.$data->item_id]."','".$_POST['wastage_qty_'.$data->item_id]."', '".$data->cost_price."', '".$total_amt."')";



db_query($do);



















$xid = db_insert_id();







//journal_item_control($data->item_id ,$_SESSION['user']['depot'],$_POST['pi_date'],'0',$_POST['total_unit_'.$data->item_id],'Issue',$xid,'0','0',$_POST['pi_no']);







//journal_item_control($data->item_id ,$line_id,$_POST['pi_date'],$_POST['total_unit_'.$data->item_id],'0','Issue',$xid,'0','0',$_POST['pi_no']);



















journal_item_control($data->item_id ,$line_id,$_POST['pi_date'],'0',$g_t_item,'Consumption',$xid,'0','0',$_POST['pi_no']);







		}



		



				}



		if($_POST['total_unit_r_'.$data->item_id]>0){	



		



	$total_amt_recipe = $_POST['total_unit_r_'.$data->item_id]*$data->cost_price;







$do = "INSERT INTO recipe_issue_detail 



(pi_no, pi_date, item_id, warehouse_from, warehouse_to, total_unit, unit_price, total_amt) VALUES 



('".$_POST['pi_no']."', '".$_POST['pi_date']."', '".$data->item_id."', '".$line_id."', '0', '".$_POST['total_unit_r_'.$data->item_id]."', '".$data->cost_price."', '".$total_amt_recipe."')";



db_query($do);







		}



		



		



		



		$str1 = $_POST['item_id1'];











$data1=explode('#>',$str1);















 $item_id1 = $data1[2];







 



		if($item_id1>0 && $_POST['raw_qty1']>0){



		$item= find_all_field( "item_info",'','item_id='.$_POST['item_id1']);



		$total_amt = $_POST['item_id1']*$item->cost_price;



		$total_qty = $_POST['raw_qty1']+$_POST['wastage_qty1'];



		



	 $do = "INSERT INTO production_floor_issue_detail 



(pi_no, pi_date, item_id, warehouse_from, warehouse_to, total_unit,raw_qty,wastage_qty, unit_price, total_amt) VALUES 



('".$_POST['pi_no']."', '".$_POST['pi_date']."', '".$item_id1."', '".$line_id."', '".$total_qty."', '','".$_POST['raw_qty1']."','".$_POST['wastage_qty1']."', '".$item->cost_price."', '".$total_amt."')";



db_query($do);



journal_item_control($_POST['item_id1'] ,$line_id,$_POST['pi_date'],'0',($_POST['raw_qty1']+$_POST['wastage_qty1']),'Consumption',$xid,'0','0',$_POST['pi_no']);



		}



		



		



		



		



		



		



		$str2 = $_POST['item_id2'];











$data2=explode('#>',$str2);















 $item_id2 = $data2[2];



		



				if($item_id2>0 && $_POST['raw_qty2']>0){



		$item= find_all_field( "item_info",'','item_id='.$_POST['item_id2']);



		$total_amt = $_POST['item_id2']*$item->cost_price;



		$total_qty = $_POST['raw_qty2']+$_POST['wastage_qty2'];



		



		 $do = "INSERT INTO production_floor_issue_detail 



(pi_no, pi_date, item_id, warehouse_from, warehouse_to, total_unit,raw_qty,wastage_qty, unit_price, total_amt) VALUES 



('".$_POST['pi_no']."', '".$_POST['pi_date']."', '".$item_id2."', '".$line_id."', '".$total_qty."', '','".$_POST['raw_qty2']."','".$_POST['wastage_qty2']."', '".$item->cost_price."', '".$total_amt."')";



db_query($do);



journal_item_control($_POST['item_id2'] ,$line_id,$_POST['pi_date'],'0',($_POST['raw_qty2']+$_POST['wastage_qty2']),'Consumption',$xid,'0','0',$_POST['pi_no']);



		}



		



		



		



		$str3 = $_POST['item_id3'];











$data3=explode('#>',$str3);















 $item_id3 = $data3[2];







		



		if($item_id3>0 && $_POST['raw_qty3']>0){



		$item= find_all_field( "item_info",'','item_id='.$_POST['item_id3']);



		$total_amt = $_POST['item_id3']*$item->cost_price;



		$total_qty = $_POST['raw_qty3']+$_POST['wastage_qty3'];



		



		 $do = "INSERT INTO production_floor_issue_detail 



(pi_no, pi_date, item_id, warehouse_from, warehouse_to, total_unit,raw_qty,wastage_qty, unit_price, total_amt) VALUES 



('".$_POST['pi_no']."', '".$_POST['pi_date']."', '".$item_id3."', '".$line_id."', '".$total_qty."', '','".$_POST['raw_qty3']."','".$_POST['wastage_qty3']."', '".$item->cost_price."', '".$total_amt."')";



db_query($do);



journal_item_control($_POST['item_id3'] ,$line_id,$_POST['pi_date'],'0',($_POST['raw_qty3']+$_POST['wastage_qty3']),'Consumption',$xid,'0','0',$_POST['pi_no']);



		}



		



		 $sqlrb='update production_floor_issue_master set status="UNCHECKED" where pi_no='.$$unique_master.'';



		$queryrb=db_query($sqlrb);



		



		



echo '<script type="text/javascript">parent.parent.document.location.href = "select_prodiction_line.php?sucess=1";</script>';



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



		$sql = "delete from journal_item where tr_from = 'Consumption' and tr_no = '".$del."'";



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



if($batch_qty>0)



{



$pack_size = find_a_field('item_info','pack_size','item_id='.$item_id);



$batch_ctn = (int)($batch_qty/$pack_size);



$batch_pcs = (int)($batch_qty%$pack_size);



}











auto_complete_from_db('item_info','item_name','concat(item_name,"#>",item_description,"#>",item_id)','product_nature != "Saleable" ','item_id1');



auto_complete_from_db('item_info','item_name','concat(item_name,"#>",item_description,"#>",item_id)','product_nature != "Saleable" ','item_id2');



auto_complete_from_db('item_info','item_name','concat(item_name,"#>",item_description,"#>",item_id)','product_nature != "Saleable" ','item_id3');



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



<form action="<?=$page?>" method="post" name="codz2" id="codz2">



<table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">



  <tr>



    <td><fieldset style="width:240px;">



    <div>



      <label style="width:75px;">Batch No : </label>







      <input style="width:155px;"  name="pi_no" type="text" id="pi_no" value="<? if($$unique_master>0) echo $$unique_master; else echo (find_a_field($table_master,'max('.$unique_master.')','1')+1);?>" readonly="readonly"/>



    </div>



	



	



	<div>



      <label style="width:75px;">Manual No : </label>







      <input style="width:25px;"  name="short_code" type="text" id="short_code" value="<? if($short_code>0) echo $short_code; else echo  find_a_field('warehouse','short_code','warehouse_id='.$line_id); ?>" readonly="readonly"/>



	  



	  



	  



	  



	  <input style="width:128px;"  name="short_code_no" type="text" id="short_code_no" value="<? if($short_code_no>0) echo $short_code_no; else echo  find_a_field($table_master,'max(short_code_no)+1','warehouse_to='.$line_id); ?>" readonly="readonly"/>



	  



	  



	  



    </div>



	



	



    <div>



      <label style="width:75px;">Carried by : </label>



      <label>



      <input name="carried_by" type="text" id="carried_by" value="<?=$carried_by?>"  style="width:155px;"/>



      </label>



</div>



<!--<div>



      <label style="width:75px;">Batch No : </label>



      <label>



      <input name="batch_no" type="text" id="batch_no" value="<?=$batch_no?>"  style="width:155px;"  required=""/>



      </label>



</div>-->



    </fieldset></td>



    <td>



			<fieldset style="width:220px;">



			  <div>



			    <label style="width:105px;">Issue Date : </label>



			    <input style="width:105px;"  name="pi_date" type="text" id="pi_date" value="<?=($pi_date=='')?'':$pi_date;?>" required="" />



		      </div>



			  <div>



			    <label style="width:105px;">Remarks: </label>



			    <input name="remarks" type="text" id="remarks" style="width:105px;" value="<?=$remarks?>" tabindex="105"  />



	        </div>



			  <div>



			    <label style="width:105px;">Batch CTN : </label>



			    <input style="width:105px;"  name="batch_qty" type="hidden" id="batch_qty" value="<?=$batch_qty?>" required="" />



				<input style="width:105px;"  name="batch_ctn" type="text" id="batch_ctn" value="<?=$batch_ctn?>" required="" />



		      </div>



			  <div>



			    <label style="width:105px;">Batch PCS : </label>



			    <input style="width:105px;"  name="batch_pcs" type="text" id="batch_pcs" value="<?=$batch_pcs?>" required="" />



		      </div>



		</fieldset>	</td>



    <td><fieldset style="width:240px;">



      <div>



        <label style="width:75px;">PL Name : </label>



        <input name="warehouse_from" type="hidden" id="warehouse_from"  value="<?=$_SESSION['user']['depot']?>" />



        <input name="warehouse_from3" type="text" id="warehouse_from3" style="width:155px;" value="<?=find_a_field('warehouse','warehouse_name','warehouse_id='.$line_id)?>" />



      </div>



      <input name="warehouse_to" type="hidden" id="warehouse_to"  value="<?=$line_id?>" style="width:155px;" />



           



	  <div>



        <label style="width:75px;">Item Name : </label>



		



		



		<select name="item_id" id="item_id" style="width:155px;" required="">



		



		<option value="<?=$item_id ?>"><?=find_a_field('item_info','item_name','item_id='.$item_id);?></option>



		



		<? 



		foreign_relation('production_line_fg p, item_info i','i.item_id','i.item_name',$item_id,'p.fg_item_id=i.item_id and p.line_id="'.$line_id.'"');



		 ?>



		</select>



      </div>



	  



	  



	  <div>



        <label style="width:75px;">Batch Type : </label>



		



		



		<select name="batch_type" id="batch_type" style="width:155px;" required="">



		



		<option value="<?=$batch_type?>"><?=$batch_type?></option>



		



		<option value="Local">Local</option>



		<option value="Foreign">Foreign</option>



		</select>



      </div>



    </fieldset></td>



  </tr>



  <tr>



    <td colspan="3"><div class="buttonrow" style="margin-left:240px;">



    <? if($$unique_master>0) {?>



<input name="new" type="submit" class="btn1" value="Update Entry" style="width:200px; font-weight:bold; font-size:12px;" tabindex="12" />



<input name="flag" id="flag" type="hidden" value="1" />



<? }else{?>



<input name="new" type="submit" class="btn1" value="Initiate Entry" style="width:200px; font-weight:bold; font-size:12px;" tabindex="12" />



<input name="flag" id="flag" type="hidden" value="0" />



<? }?>



    </div></td>



    </tr>



</table>



</form>



<form action="" method="post" name="codz2" id="codz2" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">



<input  name="<?=$unique_master?>" type="hidden" id="<?=$unique_master?>" value="<?=$$unique_master?>"/>



<input  name="warehouse_from" type="hidden" id="warehouse_from" value="<?=$warehouse_from?>"/>



<input  name="warehouse_to" type="hidden" id="warehouse_to" value="<?=$warehouse_to?>"/>



<input  name="pi_date" type="hidden" id="pi_date" value="<?=$pi_date?>"/>



<input  name="item_id"  id="pi_date" value="<?=$item_id?>" type="hidden" />



<? if($$unique_master>0){?>



<table  width="80%" border="1" align="center"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">



  <tr>



    <td width="70%" align="center" bgcolor="#33CCFF"><strong>RAW MATERIAL</strong></td>



    <td width="10%" align="center" bgcolor="#33CCFF"><span style="font-weight: bold">Unit</span></td>



    <td width="10%" align="center" bgcolor="#33CCFF"><strong>Raw Qty </strong></td>



    <td width="10%" align="center" bgcolor="#33CCFF"><strong> Wastage Qty</strong></td>



    </tr>



<? 







$sql = 'select i.*,r.* from item_info i, production_ingredient_detail r where i.item_id =r.raw_item_id and r.item_id="'.$item_id.'" and i.sub_group_id like "3%" order by item_name';



$query = db_query($sql);



while($data = mysqli_fetch_object($query)){



$data->item_id=$data->raw_item_id;







?>



  <tr>



    <td  bgcolor="#CCCCCC"><div align="left">



      <?=$data->item_name?></div></td>



    <td align="center" bgcolor="#CCCCCC"><?=$data->unit_name?></td>



    <td align="center" bgcolor="#CCCCCC"><input name="raw_qty_<?=$data->item_id?>" type="text" class="input3" id="raw_qty_<?=$data->item_id?>" value=""  maxlength="100" style="width:67px;"/></td>



    <td align="center" bgcolor="#CCCCCC">



	<input name="wastage_qty_<?=$data->item_id?>" type="text" class="input3" id="wastage_qty_<?=$data->item_id?>" value=""  maxlength="100" style="width:67px;"/>



	<input name="total_unit_<?=$data->item_id?>" type="hidden" class="input3" id="total_unit_<?=$data->item_id?>" value=""  maxlength="100" style="width:67px;"/>



	<input name="total_unit_r_<?=$data->item_id?>" type="hidden" class="input3" id="total_unit_<?=$data->item_id?>" value="<?=($data->unit_batch_qty/$data->unit_batch_size)*$_POST['batch_qty']?>"  maxlength="100" style="width:67px;"/>	</td>



    </tr>



<? }?>



</table>



<table  width="80%" border="1" align="center"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">



  <tr>



    <td width="70%" align="center" bgcolor="#FF9999"><strong>CHEMICAL MATERIAL</strong></td>



    <td width="10%" align="center" bgcolor="#FF9999"><span style="font-weight: bold">Unit</span></td>



    <td width="10%" align="center" bgcolor="#FF9999"><strong>Raw Qty </strong></td>



    <td width="10%" align="center" bgcolor="#FF9999"><strong> Qty</strong></td>



  </tr>



  <? 



$sql = 'select i.*,r.* from item_info i, production_ingredient_detail r where i.item_id =r.raw_item_id and r.item_id="'.$item_id.'" and i.sub_group_id like "8%" order by item_name';



$query = db_query($sql);



while($data = mysqli_fetch_object($query)){



 $data->item_id=$data->raw_item_id;



?>



  <tr>



    <td  bgcolor="#CCCCCC"><div align="left">



      <?=$data->item_name?>



    </div></td>



    <td align="center" bgcolor="#CCCCCC"><?=$data->unit_name?></td>



    <td align="center" bgcolor="#CCCCCC">



	<input name="raw_qty_<?=$data->item_id?>" type="text" class="input3" id="raw_qty_<?=$data->item_id?>"  maxlength="100" style="width:67px;" value=""/></td>



    <td align="center" bgcolor="#CCCCCC">



	<input name="wastage_qty_<?=$data->item_id?>" type="text" class="input3" id="wastage_qty_<?=$data->item_id?>"  maxlength="100" style="width:67px;" value=""/>



	<input name="total_unit_<?=$data->item_id?>" type="hidden" class="input3" id="total_unit_<?=$data->item_id?>"  maxlength="100" style="width:67px;" value=""/>



	



	



	<input name="total_unit_r_<?=$data->item_id?>" type="hidden" class="input3" id="total_unit_<?=$data->item_id?>"  maxlength="100" style="width:67px;" value="<?=($data->unit_batch_qty/$data->unit_batch_size)*$_POST['batch_qty']?>"/>	</td>



  </tr>



  <? }?>



</table>



<table  width="80%" border="1" align="center"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">



  <tr>



    <td width="70%" align="center" bgcolor="#999999"><strong>PACKING MATERIAL </strong></td>



    <td width="15%" align="center" bgcolor="#999999"><span style="font-weight: bold">Unit</span></td>



    <td width="16%" align="center" bgcolor="#999999"><strong>Raw Qty </strong></td>



    <td width="50%" align="center" bgcolor="#999999"><strong> Qty</strong></td>



  </tr>



  <? 



$sql = 'select i.*,r.* from item_info i, production_ingredient_detail r where i.item_id =r.raw_item_id and r.item_id="'.$item_id.'" and (i.sub_group_id like "4%" OR i.sub_group_id like "12%") order by item_name';



$query = db_query($sql);



while($data = mysqli_fetch_object($query)){



$data->item_id=$data->raw_item_id;



?>







  <tr>



    <td  bgcolor="#CCCCCC"><div align="left">



      <?=$data->item_name?>



    </div></td>



    <td align="center" bgcolor="#CCCCCC"><?=$data->unit_name?></td>



    <td align="center" bgcolor="#CCCCCC"><input name="raw_qty_<?=$data->item_id?>" type="text" class="input3" id="raw_qty_<?=$data->item_id?>"  maxlength="100" style="width:67px;" value=""/></td>



    <td align="center" bgcolor="#CCCCCC"><input name="wastage_qty_<?=$data->item_id?>" type="text" class="input3" id="wastage_qty_<?=$data->item_id?>"  maxlength="100" style="width:67px;" value=""/>



        <input name="total_unit_<?=$data->item_id?>" type="hidden" class="input3" id="total_unit_<?=$data->item_id?>"  maxlength="100" style="width:67px;" value=""/>



        <input name="total_unit_r_<?=$data->item_id?>" type="hidden" class="input3" id="total_unit_<?=$data->item_id?>"  maxlength="100" style="width:67px;" value="<?=($data->unit_batch_qty/$data->unit_batch_size)*$_POST['batch_qty']?>"/>    </td>



  </tr>



  <? }?>  



  



  <tr>



    <td  bgcolor="#CCCCCC"><input  name="item_id1" type="text" id="item_id1" value="" style="width:170px;"  /></td>



    <td align="center" bgcolor="#CCCCCC">&nbsp;</td>



    <td align="center" bgcolor="#CCCCCC"><input name="raw_qty1" type="text" class="input3" id="raw_qty1"  maxlength="100" style="width:67px;" value=""/></td>



    <td align="center" bgcolor="#CCCCCC"><input name="wastage_qty1" type="text" class="input3" id="wastage_qty1"  maxlength="100" style="width:67px;" value=""/></td>



  </tr>



  <tr>



    <td  bgcolor="#CCCCCC"><input  name="item_id2" type="text" id="item_id2" value="" style="width:170px;"  /></td>



    <td align="center" bgcolor="#CCCCCC">&nbsp;</td>



    <td align="center" bgcolor="#CCCCCC"><input name="raw_qty2" type="text" class="input3" id="raw_qty2"  maxlength="100" style="width:67px;" value=""/></td>



    <td align="center" bgcolor="#CCCCCC"><input name="wastage_qty2" type="text" class="input3" id="wastage_qty2"  maxlength="100" style="width:67px;" value=""/></td>



  </tr>



  <tr>



    <td  bgcolor="#CCCCCC"><input  name="item_id3" type="text" id="item_id3" value="" style="width:170px;"  /></td>



    <td align="center" bgcolor="#CCCCCC">&nbsp;</td>



    <td align="center" bgcolor="#CCCCCC"><input name="raw_qty3" type="text" class="input3" id="raw_qty3"  maxlength="100" style="width:67px;" value=""/></td>



    <td align="center" bgcolor="#CCCCCC"><input name="wastage_qty3" type="text" class="input3" id="wastage_qty3"  maxlength="100" style="width:67px;" value=""/></td>



  </tr>



</table>



<br />



	<br />



















<table width="100%" border="0">



  <tr>



      <td width="41%" align="center"><input  name="pi_no" type="hidden" id="pi_no" value="<?=$$unique_master?>"/></td>



      <td width="23%" align="right" style="text-align:right"><div align="center">



        <input name="confirm" type="submit" class="btn1" value="CONFIRM AND ISSUE" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:#090; float:right" />



      </div></td>



      <td width="36%" align="right" style="text-align:right">&nbsp;</td>



    </tr>



</table>











<? }?>



</form>



</div>



<script>$("#cz").validate();$("#cloud").validate();</script>



<?



$main_content=ob_get_contents();



ob_end_clean();



require_once SERVER_CORE."routing/layout.bottom.php";



?>