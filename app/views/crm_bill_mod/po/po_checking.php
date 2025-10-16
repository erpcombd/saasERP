<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$title='Approving Progress Report';


 //$d_id=$_GET['d_id'];
do_calander('#progress_date');

do_calander('#date');



$table_master='daily_progress_master';

$table_details='daily_progress_details';

$unique='d_id';

if($_GET['d_id']){
$_SESSION[$unique]=$_GET['d_id'];
}



if(isset($_POST['new2']))

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

		$msg='Requisition No Created. (PO No :-'.$_SESSION[$unique].')';

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



if(isset($_POST['return']))

{
	
	$updates = 'update daily_progress_master set status="MANUAL", checked_at="'.date('Y-m-d h:i:s').'",checked_by="'.$_SESSION['user']['id'].'",return_remarks="'.$_POST['return_remarks'].'" where d_id="'.$_REQUEST['d_id'].'"';
	db_query($updates);
	$_SESSION['msgs'] = '<span style="color:red; font-weight:bold; font-size:16px;">Successfully Returned!</span>';
	unset($$unique);
    unset($_SESSION[$unique]);
	echo '<script>location.href="select_unapproved_po.php"</script>';
	
	}



if($_GET['del']>0)

{

		$crud   = new crud($table_details);

		$condition="id=".$_GET['del'];		

		$crud->delete_all($condition);

		$type=1;

		$msg='Successfully Deleted.';

}

if(isset($_POST['confirmm']))

{

		unset($_POST);
		 $_POST[$unique]=$$unique;
		$_POST['approve_by']=$_SESSION['user']['id'];
		$_POST['approve_at']=date('Y-m-d h:s:i');
		$_POST['status']='APPROVED';
		$crud   = new crud($table_master);
		$crud->update($unique);
		//auto_insert_purchase_secoundary_update_packing($$unique);
		unset($$unique);
		unset($_SESSION[$unique]);
		$type=1;
		$msg='Successfully Forwarded to Relevant Department.';
		header('location:select_unapproved_po.php');

}



if(isset($_POST['add'])&&($_POST[$unique]>0))

{

		$crud   = new crud($table_details);

		$iii=explode('#>',$_POST['item_id']);

		$_POST['item_id']=$iii[1];


		$_POST['entry_by']=$_SESSION['user']['id'];

		$_POST['entry_at']=date('Y-m-d h:s:i');

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d h:s:i');

		$crud->insert();

		unset($item_id);

}



if($$unique>0)

{

		$condition=$unique."=".$$unique;

		$data=db_fetch_object($table_master,$condition);

		foreach ($data as $key => $value)

		{ $$key=$value;}

		

}

if($$unique>0) $btn_name='Update Information'; else $btn_name='Initiate Information';

if($_SESSION[$unique]<1)

$$unique=db_last_insert_id($table_master,$unique);





auto_complete_from_db('item_info','concat(item_name,"#>",item_id)','concat(item_name,"#>",item_id)','1 ','item_id');


?>

<script language="javascript">

function count()

{

var num=((document.getElementById('qty').value)*1)*((document.getElementById('rate').value)*1);

document.getElementById('amount').value = num.toFixed(2);	

}

</script>

<div class="form-container_large">

<form action="" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
<div class="row ">
	     <div class="col-md-3 form-group">
		 <? $field='d_id';?>
            <label for="d_id" >ID: </label>
           <input class="form-control" name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" readonly/>
  </div>
		  
		 <div class="col-md-3 form-group">
		 <? $field='progress_date'; if($progress_date=='') $progress_date =date('Y-m-d');?>
        <div>
        <label for="<?=$field?>"> Date:</label>
        <input class="form-control" name="<?=$field?>" type="text" id="<?=$field?>" value="<?=($$field!='')? $$field : date('Y-m-d');?>" readonly="readonly"  required/>
       </div>
	   </div>
	   
	   <div class="col-md-3 form-group">
      <p>
        <? $field='progress_for';?>
        <label for="<?=$field?>">Progress For: </label>
	<select name="progress_for" id="progress_for" class="form-control">
	 <? foreign_relation('daily_progress_setup','id','type',$$field,'tr_from ="progress for"');?>
	</select>
	

      </p>
	  </div>
	   
		
	</div>

  <table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">

    

    <tr>
      <td colspan="2"><div align="center">
        <input name="new2" type="submit" class="btn btn-success" value="<?=$btn_name?>" style="width:250px; font-weight:bold; font-size:12px;" />
      </div></td>
    </tr>
    <tr>

      <td colspan="2"><div class="buttonrow" style="margin-left:240px;">

        <div align="center"></div>
      </div></td>
    </tr>
  </table>

</form>





<? if($_SESSION[$unique]>0){?>

<table width="40%" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">

  <tr>

    <td colspan="3" align="center" bgcolor="#CCFF99"><strong>Entry Information</strong></td>

    </tr>

  <tr>

    <td align="right" bgcolor="#CCFF99">Created By:</td>

    <td align="left" bgcolor="#CCFF99">&nbsp;&nbsp;<?=find_a_field('user_activity_management','fname','user_id='.$entry_by);?></td>

    <td rowspan="2" align="center" bgcolor="#CCFF99"><a href="po_print_view.php?d_id=<?=$d_id?>" target="_blank"><i class="fas fa-print" style="color:black;"></i><!--<img src="../../images/print.png" width="26" height="26" />--></a></td>

  </tr>

  <tr>

    <td align="right" bgcolor="#CCFF99">Created On:</td>

    <td align="left" bgcolor="#CCFF99">&nbsp;&nbsp;<?=$entry_at?></td>

    </tr>

</table>

<form action="?<?=$unique?>=<?=$$unique?>" method="post" name="cloud" id="cloud" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">

<table width="100%" border="0" cellspacing="0" cellpadding="0">

<tr>

<td>

<div class="tabledesign2">

<? 
if($progress_for=='1'){

  $res='select a.id, a.customer_name as name, a.address as section, a.pet_type as action_plan, a.delivery as target_amount, a.gap_analysis as challenges, a.collection as progress, a.next_visit as follow_up, "x" from daily_progress_details a where  a.d_id='.$d_id;
  
} elseif($progress_for=='2'){

 $res='select a.id, d.particulars as particular, a.customer_name, a.amount, a.plan, a.progress, a.problem, a.requisition "x" 
  from daily_progress_details a,daily_progress_setup d where a.particular=d.id and  a.d_id='.$d_id;

}elseif($progress_for=='3'){

    $res='select a.id, d.particulars as particular,  a.plan, a.amount, a.progress, a.problem, "x" 
  from daily_progress_details a,daily_progress_setup d where a.particular=d.id and  a.d_id='.$d_id; 

} elseif($progress_for=='4'){

	$res='select a.id, a.date, a.customer_name, a.amount, a.problem, "x" from daily_progress_details a where  a.d_id='.$d_id;
	
} elseif($progress_for=='5'){

	$res='select a.id, d.particulars as particular,  a.customer_name, a.project_name, a.plan, a.progress, a.problem, "x" 
  from daily_progress_details a,daily_progress_setup d where a.particular=d.id and  a.d_id='.$d_id;
  
} elseif($progress_for=='31'){

	$res='select a.id, a.date, a.day, a.customer_name as section, a.plan as action_plan, a.man_power as challenges,a.collection as qty, a.progress, a.gap_analysis as recommendation,  "x" from daily_progress_details a where  a.d_id='.$d_id;
	
}elseif($progress_for=='53'){

	$res='select a.id, a.day as project_name, a.customer_name as component, a.plan as target, a.man_power as achieved, a.progress as problem_encountered,a.requisition as corrective_action, "x" from daily_progress_details a where  a.d_id='.$d_id;
	
} elseif($progress_for=='32'){

	$res='select a.id, a.customer_name as owner, a.address, a.man_power as pet_name, a.pet_type, a.pet_category as patient_category, a.service_type, a.mobile, a.email, a.next_visit, a.amount as total, a.findings as remarks, "x" from daily_progress_details a where  a.d_id='.$d_id;
	
} elseif($progress_for=='35'){

	$res='select a.id, d.particulars as particular,  a.head_office, a.showroom, a.ld_hospital, a.factory, "x" 
  from daily_progress_details a,daily_progress_setup d where a.particular=d.id and  a.d_id='.$d_id;
  
} elseif($progress_for=='51'){

	$res='select a.id, a.date, a.day, a.customer_name as section, a.plan as action_plan, a.man_power as challenges,a.collection as qty, a.progress, a.gap_analysis as recommendation,  "x" from daily_progress_details a where  a.d_id='.$d_id;
	
} elseif($progress_for=='55'){

	$res='select a.id, a.date, a.day, a.customer_name as section, a.plan as action_plan, a.man_power as challenges,a.collection as qty, a.progress, a.gap_analysis as follow_up,  "x" from daily_progress_details a where  a.d_id='.$d_id;
	
} elseif($progress_for=='52'){

	$res='select a.id, a.date, a.customer_name, a.man_power as lot_no, a.plan as product_name, a.amount as unit_price, a.collection as production_target, a.outstanding as production_achieved, a.category as delivery_target, a.pet_type as delivery_achieved, "x" from daily_progress_details a where  a.d_id='.$d_id;
	
}

echo link_report_add_del_auto($res,'',0,0);

?>

</div>

</td>

</tr>

</table>

</form>

<form action="" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">

  <table width="100%" border="0">

    <tr>

      <td align="center">

        <input type="hidden" name="return_remarks" id="return_remarks">

      <input name="return"  type="submit" class="btn btn-danger" value="RETURN" style="width:270px; font-weight:bold; font-size:12px;color:white; height:30px" onclick="return_function()" />



      </td>

      <td align="center">



      <input name="confirmm" type="submit" class="btn btn-info" value="CONFIRM" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:white" />



      </td>

    </tr>

  </table>

</form>

<? }?>

</div>

<script>$("#codz").validate();$("#cloud").validate();</script>
<script>
function return_function() {
  var person = prompt("Why Return This Progress Report", "");
  if (person != null) {
    document.getElementById("return_remarks").value =person;
  }
}
</script>


<?

$main_content=ob_get_contents();

ob_end_clean();

require_once SERVER_CORE."routing/layout.bottom.php";

?>