<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Receive from Production Line';
do_calander('#pr_date');

$page = 'production_receive.php';

if($_POST['line_id']>0) 
 $line_id = $_SESSION['line_id']=$_POST['line_id'];

elseif($_SESSION['line_id']>0) 



$line_id = $_POST['line_id']=$_SESSION['line_id'];

$table_master='production_floor_return_master';

$unique_master='pr_no';

$table_detail='production_floor_return_detail';

$unique_detail='id';

if($_REQUEST['old_pr_no']>0)

$$unique_master=$_REQUEST['old_pr_no'];

elseif(isset($_GET['del']))

{$$unique_master=find_a_field($table_detail,$unique_master,'id='.$_GET['del']); $del = $_GET['del'];}

else

$$unique_master=$_REQUEST[$unique_master];

if(prevent_multi_submit()){

if(isset($_POST['new']))
{

		$crud   = new crud($table_master);
		
		$$unique_master=$_POST['pr_no'];

		$_POST['entry_at']=date('Y-m-d h:s:i');

		$_POST['entry_by']=$_SESSION['user']['id'];

		$_POST['warehouse_from']=$_REQUEST['warehouse_from'];

		



		

		

		

		



		if($_POST['flag']<1){



		$crud->insert();



		$type=1;



		$msg='Product Received. (PI No-'.$$unique_master.')';



		}



		else {

		

	
		

		

		



		$crud->update($unique_master);



		$type=1;



		$msg='Successfully Updated.';



		}



}







if(isset($_POST['add'])&&($_POST[$unique_master]>0))



{
		if($_POST['total_unit']<=$_POST['stock']){
		$table		=$table_detail;
		$crud      	=new crud($table);
		$iii=explode('#>',$_POST['item_id']);
		$_POST['item_id']=$iii[2];

		$item =  find_a_field('journal_item','final_price','final_price > 0 and  item_id='.$_POST['item_id']. ' order by id desc');

		$_POST['unit_price']= $item;

		

		//$_POST['total_unit'] = ($_POST['total_ctn']*$item->pack_size)+$_POST['total_pcs'];
		$_POST['total_amt']= ($_POST['total_unit'] * $_POST['unit_price']);
		$_POST['status'] = 'RECEIVED';
		$war = find_all_field('production_floor_return_master','','pr_no='.$$unique_master);
		$_POST['warehouse_to']= $war->warehouse_to;
		$_POST['warehouse_from']=$war->warehouse_from;

		

		 $crud->insert();
		 
		 }else{
		 
		 	echo "<script>alert('Can Not Add More Than Stock.')</script>";
		 
		 }



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







		$sql = "delete from journal_item where tr_from = 'Production Return' and tr_no = '".$del."'";



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





//auto_complete_from_db($table,$show,$id,$con,$text_field_id);

if($_SESSION['session_sub_group']=='all'){

	$get_data = '';

}else{

	$get_data =$_SESSION['session_sub_group'];

}



//auto_complete_from_db('item_info','item_name','concat(item_name,"#>",item_description,"#>",item_id)','1','item_id');


   
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



    <td width="51%"><fieldset style="width:240px;">



    <div>



      <label style="width:75px;">Return No: </label>







      <input style="width:155px;"  name="pr_no" type="text" id="pr_no" value="<? if($$unique_master>0) echo $$unique_master; else echo (find_a_field($table_master,'max('.$unique_master.')','1')+1);?>" readonly="readonly"/>



    </div>



    <div>



      <label style="width:75px;">Return by:</label>



      <label>



      <input name="carried_by" type="text" id="carried_by" value="<?=$carried_by?>"  style="width:155px;"/>



      </label>



      <label style="width:75px;">Warehouse:</label>



      <label>



      <select name="warehouse_to"  style="width:155px;">



      <?=foreign_relation('warehouse','warehouse_id','warehouse_name',$warehouse_to,'1 and use_type="WH" order by warehouse_name')?>



      </select>



      </label>



</div>



    </fieldset></td>



    <td width="18%">



			<fieldset style="width:220px;">



			  <div>



			    <label style="width:105px;">Return Date : </label>



			    <input style="width:105px;"  name="pr_date" type="text" id="pr_date" value="<?=$pr_date?>" required/>



		      </div>



			  <div>



			    <label style="width:105px;">S/L No : </label>



			    <input name="remarks" type="text" id="remarks" style="width:105px;" value="<?=$remarks?>" tabindex="105" />



		      </div>

			  



			  <!--<div>



			    <label style="width:105px;">Batch No : </label>



			    <input name="batch_no" type="text" id="batch_no" style="width:105px;" value="<?=$batch_no?>" tabindex="105" required="" />



		      </div>-->



		</fieldset>	</td>



    <td width="31%"><fieldset style="width:240px;">





      



<div>

<label style="width:75px;">PL Name: </label>
<? if($line_id==0) { $line_id=$warehouse_from; } ?>
<input name="warehouse_from" type="hidden" id="warehouse_from"  value="<?=$line_id?>" />

<input name="warehouse_from4" type="text" id="warehouse_from4" style="width:155px;" value="<?=find_a_field('warehouse','warehouse_name','warehouse_id='.$line_id);?>" required />

</div>



<div>
<? $field='goods_type';?>
<label for="<?=$field?>" style="width:75px;">Goods Type: </label>

<select name="<?=$field?>" id="<?=$field?>" required=""  style="width:155px;">







<option <? if($$field=="Good Goods") echo 'selected="selected"';?>   value="Good Goods">Good Goods</option>

<option <? if($$field=="Bad Goods") echo 'selected="selected"';?>  value="Bad Goods">Bad Goods</option>







</select>

</div>

    </fieldset></td>



  </tr>



  <tr>



    <td colspan="3"><div class="buttonrow" style="margin-left:240px;">



    <? if($$unique_master>0) {?>



<input name="new" type="submit" class="btn1" value="Update Demand Order" style="width:200px; font-weight:bold; font-size:12px;" tabindex="12" />



<input name="flag" id="flag" type="hidden" value="1" />



<? }else{?>



<input name="new" type="submit" class="btn1" value="Initiate Demand Order" style="width:200px; font-weight:bold; font-size:12px;" tabindex="12" />



<input name="flag" id="flag" type="hidden" value="0" />



<? }?>



    </div></td>



    </tr>



</table>



</form>



<form action="<?=$page?>" method="post" name="codz2" id="codz2">



<? if($$unique_master>0){?>



<? //echo $_POST['goods_type']; ?>



<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">



  <tr>



    <td width="45%" align="center" bgcolor="#0099FF"><strong>Item Name</strong></td>



    <td width="15%" align="center" bgcolor="#0099FF"><span style="font-weight: bold">Unit</span></td>



    <td width="14%" align="center" bgcolor="#0099FF"><span style="font-weight: bold">Stk</span></td>



    <td width="9%" align="center" bgcolor="#0099FF" ><b>Remarks</b></td>

    <td width="9%" align="center" bgcolor="#0099FF"><strong> Qty</strong></td>



    <td width="8%"  rowspan="2" align="center" bgcolor="#FF0000"><div class="button">



      <input name="add" type="submit" id="add" value="ADD" tabindex="12" class="update"/>



    </div></td>

  </tr>

  



  <tr>



    <td align="center" bgcolor="#CCCCCC">



    <input  name="<?=$unique_master?>" type="hidden" id="<?=$unique_master?>" value="<?=$$unique_master?>"/>



    <input  name="warehouse_from" type="hidden" id="warehouse_from" value="<?=$warehouse_from?>"/>





      <input  name="pr_date" type="hidden" id="pr_date" value="<?=$pr_date?>"/>



    <!--  <input  name="item_id" type="text" id="item_id" value="<?=$item_id?>" style="width:300px;" required="required" onblur="getData2('production_receive_ajax.php', 'pr', this.value, document.getElementById('warehouse_from').value);"/>-->

  <input  name="item_id" type="text" list="item_ids" id="item_id" value="<? echo $item_id; ?>" style="width:170px;" required="required" onblur="getData2('production_receive_ajax.php', 'pr', this.value, document.getElementById('warehouse_from').value);" autocomplete="off"/>

                                                      <datalist id="item_ids">

 <? //i.sub_group_id like "%'.$get_data.'%"

  foreign_relation('item_info i,item_sub_group s','concat(i.item_name,"#>",i.item_description,"#>",i.item_id)','concat(i.item_name,"#>",i.item_description,"#>",i.item_id)',$item_id,' 1    and i.sub_group_id=s.sub_group_id ');?>

	</datalist>	
</td>
    <td colspan="2" align="center" bgcolor="#CCCCCC"><span id="pr">







    



    </span></td>



    <td align="center" bgcolor="#CCCCCC"><input name="remarks" type="text" class="input3" id="remarks"  maxlength="100" style="width:105px;" required="required"/></td>

    <td align="center" bgcolor="#CCCCCC"><input name="total_unit" type="hidden" class="input3" id="total_unit"  maxlength="100" style="width:67px;" required="required"/>

	<input name="total_unit" type="text" class="input3" id="total_unit"  maxlength="100" style="width:67px;" required="required"/>	</td>

    </tr>

</table>



<br /><br /><br /><br />







<? 







$res='select a.id,b.item_id as item_code,b.item_name,b.unit_name,a.remarks,a.total_unit,"X" from production_floor_return_detail a,item_info b where b.item_id=a.item_id and a.pr_no='.$$unique_master.' order by a.id';



?>



<table width="100%" border="0" cellspacing="0" cellpadding="0">







    <tr>



      <td><div class="tabledesign2">



        <? 



echo link_report_del($res);



		?>







      </div></td>



    </tr>



	    	



	







				



    <tr>



     <td>







 </td>



    </tr>



  </table>







</form>



<form action="select_prodiction_line.php" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">



<table width="100%" border="0">



  <tr>



      <td align="center">&nbsp;</td>

      <td align="right" style="text-align:right">

<input  name="<?=$unique_master?>" type="hidden" id="<?=$unique_master?>" value="<?=$$unique_master?>"/>

      <input name="confirm" type="submit" class="btn1" value="CONFIRM AND SEND PR" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:#090; float:right" />



      </td>



    </tr>



</table>











<? }?>



</form>



</div>



<script>$("#cz").validate();$("#cloud").validate();</script>



<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>

