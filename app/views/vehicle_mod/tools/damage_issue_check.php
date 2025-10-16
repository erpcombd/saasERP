<?php

require_once "../../../assets/template/layout.top.php";



$title='New Damage Issue';

$page = "damage_issue.php";

$ajax_page = "damage_issue_ajax.php";

$page_for = 'Damage Issue';

//do_calander('#oi_date','-10','0');

//do_calander('#oi_date');

$table_master='warehouse_other_issue';

$table_details='warehouse_other_issue_detail';

$unique='oi_no';

if($_POST['oi_no']>0){
$_SESSION[$unique] = $_POST['oi_no'];
echo 'bimol';
}





if(isset($_POST['new']))

{

		$crud   = new crud($table_master);



		if(!isset($_SESSION[$unique])) {

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

		mysql_query($sql);

		$type=1;

		$msg='Successfully Deleted.';

		

}

if(isset($_POST['confirmm']))

{

		unset($_POST);

		$_POST[$unique]=$$unique;

		$_POST['entry_by']=$_SESSION['user']['id'];

		$_POST['entry_at']=date('Y-m-d h:s:i');

		$_POST['status']='CHECKED';

		$crud   = new crud($table_master);

		$crud->update($unique);
		
		$warehouse_id = find_a_field('warehouse_other_issue','warehouse_id','oi_no="'.$$unique.'"');
		
		if($$unique>0){
		 $sql = 'select w.*,i.product_type from warehouse_other_issue_detail w,item_info i where i.item_id=w.item_id and oi_no="'.$$unique.'"';
		$qry = mysql_query($sql);
		
		while($data = mysql_fetch_object($qry)){
		if($data->product_type=='Serialized'){
	   $item_info = find_all_field('journal_item','','item_id="'.$data->item_id.'" and serial_no="'.$data->serial_no.'" and warehouse_id="'.$_SESSION['user']['depot'].'" and item_in>0 and tr_from in ("Opening","Import","Purchase","Transfered")');
	    }elseif($data->product_type=='Non-serialized'){
		$item_info = find_all_field('journal_item','','item_id="'.$data->item_id.'" and item_in>0 and warehouse_id="'.$_SESSION['user']['depot'].'" and tr_from in ("Opening","Import","Purchase","Transfered") order by id desc');
		}
		$ex_info = find_all_field('journal_item','','item_id="'.$data->item_id.'" and serial_no="'.$data->serial_no.'" and item_in>0');
		$journal_item_sql = 'insert into journal_item (`ji_date`,`item_id`,`warehouse_id`,`lot_no`,`serial_no`,`item_ex`,`item_price`,`final_price`,`tr_from`,`tr_no`,`sr_no`,`entry_by`,`entry_at`) value("'.$data->oi_date.'","'.$data->item_id.'","'.$warehouse_id.'","'.$ex_info->lot_no.'","'.$data->serial_no.'","'.$data->qty.'","'.$item_info->item_price.'","'.$item_info->final_price.'","DamageIssue","'.$data->id.'","'.$$unique.'","'.$_SESSION['user']['id'].'","'.date('Y-m-d h:i:s').'")';
mysql_query($journal_item_sql);
$issu_type = find_a_field('warehouse_other_issue','issue_type','oi_no='.$data->oi_no);

if($issu_type=="Sample Issue"){
 $trf = "Sample Issue";
 }else{
 $trf = "Damage";
 }
 //$update = 'update journal_item set tr_from="'.$trf.'" where item_id="'.$data->item_id.'" and serial_no="'.$data->serial_no.'" and item_in>0';
mysql_query($update);
		}
		}

		unset($$unique);

		unset($_SESSION[$unique]);

		$type=1;

		$msg='Successfully Forwarded.';
		
		header('location:unapprove_damage_list.php');

}

if(isset($_POST['return'])){
 
 unset($_POST);
 $_POST[$unique]=$$unique;
 $_POST['status']='MANUAL';
 $crud   = new crud($table_master);
 $crud->update($unique);
 unset($$unique);
 unset($_SESSION[$unique]);
 header('location:unapprove_damage_list.php');

}



/*if(isset($_POST['add'])&&($_POST[$unique]>0))

{

		$crud   = new crud($table_details);

		$iii=explode('#>',$_POST['item_id']);

		$_POST['item_id']=$iii[1];
		$item_type = find_a_field('item_info','product_type','item_id="'.$iii[1].'"');
		if($item_type=='Serialized'){
		$check_serial = find_a_field('journal_item','serial_no','serial_no="'.$_POST['serial_no'].'" and item_id="'.$iii[1].'"');
		}else{
		$check_serial = 'Non-serialized';
		}
        if($check_serial!=''){

		$_POST['entry_by']=$_SESSION['user']['id'];

		$_POST['entry_at']=date('Y-m-d h:s:i');

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d h:s:i');

		$xid = $crud->insert();

		//journal_item_control($_POST['item_id'] ,$_SESSION['user']['depot'],$_POST['oi_date'],0,$_POST['qty'],$page_for,$xid,$_POST['rate'],'',$$unique);
}else{
 $msg = '<span style="color:red; font-weight:bold;">Invalid Serial No. Please try again with correct serial no.!</span>';
}
}*/



if($$unique>0)

{

		$condition=$unique."=".$$unique;

		$data=db_fetch_object($table_master,$condition);

		while (list($key, $value)=each($data))

		{ $$key=$value;}

		

}

if($$unique>0) $btn_name='Update DI Information'; else $btn_name='Initiate DI Information';

if($_SESSION[$unique]<1)

$$unique=db_last_insert_id($table_master,$unique);



//auto_complete_from_db($table,$show,$id,$con,$text_field_id);

$depot_type = find_a_field('warehouse','use_type','warehouse_id="'.$_SESSION['user']['depot'].'"');

//if($depot_type =='SD')

auto_complete_from_db('item_info','concat(item_name,"#>",item_id)','concat(item_name,"#>",item_id)','product_nature="Salable"','item_id');

//else

//auto_complete_from_db('item_info','finish_goods_code','concat(item_name,"#>",item_id)','1','item_id');

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

var num=((document.getElementById('qty').value)*1)*((document.getElementById('rate').value)*1);

document.getElementById('amount').value = num.toFixed(2);	

}

</script>

<div class="form-container_large">

<form action="" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">

<table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">

  <div class="row ">
    
	
	     <div class="col-md-3 form-group">
            <label for="do_no" >Damage Issue No: </label>
            <input   name="oi_no" type="text" class="form-control" id="oi_no" value="<? if($oi_no>0) echo $oi_no; else echo (find_a_field($table_master,'max('.         $unique_master.')','1')+1);?>" readonly/>
          </div>
		  
		  <div class="col-md-3 form-group">
            <label for="dealer_code">Damage Issue Date: </label>
           <input   name="oi_date" class="form-control"  type="text" id="oi_date" value="<? if($oi_date=='') echo date('Y-m-d');else echo $oi_date?>" readonly/>
          </div>
		  
		  
		   <div class="col-md-3 form-group">
            <label for="wo_detail">Note: </label>
            <input   name="oi_subject" class="form-control"  type="text" id="oi_subject" value="<?=$oi_subject?>"/>
          </div>
		  
		  
          <div class="col-md-3 form-group">
            <label for="depot_id">Depot : </label>
            <select id="warehouse_id" name="warehouse_id" class="form-control"  readonly="readonly">
              <option value="<?=$warehouse_id;?>">
              <?=find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot'])?>
              </option>
            </select>
            <!--<input style="width:155px;"  name="wo_detail" type="text" id="wo_detail" value="<?=$depot_id?>" readonly="readonly"/>-->
          </div>
		
	  
   </div>

  <tr>

    <td colspan="2"><div class="buttonrow" style="margin-left:40%;">

      <input name="new" type="submit" class="btn1" value="<?=$btn_name?>" style="width:250px; font-weight:bold; font-size:12px;" />

    </div></td>

    </tr>
	
	<tr>
	  <td class="2" align="center"><?=$msg;?></td>
	</tr>

</table>

</form>

<? if($_SESSION[$unique]>0){?>

<form action="?<?=$unique?>=<?=$$unique?>" method="post" name="cloud" id="cloud">



					  <br /><br /><br /><br />





<table width="100%" border="0" cellspacing="0" cellpadding="0">



    <tr>

      <td>

<div class="tabledesign2">

<? 

$res='select a.id,b.item_name,a.qty ,a.serial_no,a.unit_name,"x" from warehouse_other_issue_detail a,item_info b where b.item_id=a.item_id and a.oi_no='.$oi_no;

echo link_report_add_del_auto($res,'',3,6);

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
	  <input name="return" type="submit" class="btn1" value="RETURN" style="width:270px; float:right; font-weight:bold; font-size:12px; height:30px; color:#090" />
	  </td>
	  
	  <td align="center">
	  <input name="confirmm" type="submit" class="btn1" value="CONFIRM AND FORWARD DI" style="width:270px; float:right; font-weight:bold; font-size:12px; height:30px; color:#090" />
	  </td>

    </tr>

  </table>

</form>

<? }?>

</div>

<script>$("#codz").validate();$("#cloud").validate();</script>

<?

require_once "../../../assets/template/layout.bottom.php";

?>