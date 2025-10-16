<?php

session_start();

ob_start();

require "../../support/inc.all.php";

$title='Work Order Create';

do_calander('#wo_date');

do_calander('#chalan_date');

$table='lc_workorder';

$unique='id';



	 $wo_id=$_POST['wo_id'];


	if(isset($_POST['id']))
	{
	$wo_id=$_POST['id'];
	$res='select a.id from lc_workorder_details a where a.wo_id='.$wo_id;
	$query=db_query($res);
		while($w=mysqli_fetch_object($query))
		{
			if(isset($_POST['edit#'.$w->id]))
			{
$unit_sql='select a.billing_unit_id from lc_product_item a,lc_workorder_details b where a.id=b.item_id and b.id='.$w->id.' limit 1';
$unit=mysqli_fetch_row(db_query($unit_sql));
if($unit[0]==3)
$amtx=number_format((($_POST['qty#'.$w->id]*$_POST['rate#'.$w->id])/12),4,'.','');
else
$amtx=number_format((($_POST['qty#'.$w->id]*$_POST['rate#'.$w->id])),4,'.','');
			$new_sql="UPDATE `lc_workorder_details` SET 
`style_no` = '".$_POST['style_no#'.$w->id]."',
`specification` = '".$_POST['specification#'.$w->id]."',
`meassurment` = '".$_POST['meassurment#'.$w->id]."',
`qty` = '".$_POST['qty#'.$w->id]."',
`rate` = '".$_POST['rate#'.$w->id]."',
`amount` = '".$amtx."' WHERE `id` ='".$w->id."'";
db_query($new_sql);
$type=1;
$msg='Successfully Edited.';
			}
		}
	}

if(isset($_POST['confirm']))

{

		unset($_POST);

		$_POST['id']=$wo_id;

		$_POST['status']='DONE';

		$crud   = new crud('lc_workorder');

		$crud->update('id');

		unset($wo_id);

		unset($_SESSION['wo_id']);

		$type=1;

		$msg='Successfully Send to Factory.';

}



if($wo_id>0)

{

		$condition=$unique."=".$wo_id;

		$data=db_fetch_object($table,$condition);

		while (list($key, $value)=@each($data))

		{ $$key=$value;}

		

}



if(isset($_POST['add'])&&($_POST['wo_id']>0))

{

		$table		='lc_workorder_chalan';

		$crud      	=new crud($table);

		$crud->insert();

}

if(isset($_POST['dwo']))
{
$dsql='delete from lc_workorder where id='.$_GET['wo_id'];	
$disql='delete from lc_workorder_details where wo_id='.$_GET['wo_id'];	
db_query($dsql);
db_query($disql);
$type=2;
$msg='Work Order Successfully Deleted.';
}

?><div class="form-container_large">

<form action="?wo_id=<?=$wo_id;?>" method="post" name="codz" id="codz">

<table width="90%" border="0" cellspacing="0" cellpadding="0" align="center">

  <tr>

    <td><fieldset>

      <div>

        <label>Work Order No : </label>

        <input  name="id" type="hidden" id="id" value="<?=$wo_id?>"/>

        <input  name="manual_wo_id" type="text" id="manual_wo_id" value="<?=$manual_wo_id?>"/>

      </div>

      <div>

        <label for="email">Work Order Date : </label>

        <input  name="wo_date" type="text" id="wo_date" value="<?=$wo_date?>"/>

      </div>

      <div>

        <label for="email">Buyer Name : </label>

        <select id="buyer_id" name="buyer_id">

        <? foreign_relation('lc_buyer','id','buyer_name',$buyer_id);?>

        </select>

      </div>

      <div>

        <label for="email">Prepared By : </label>

        <input  name="prepared_bys" type="text" id="prepared_bys" value="<?=find_a_field('user_activity_management','fname','user_id='.$prepared_by)?>" readonly="readonly"/>

        <input  name="prepared_by" type="hidden" id="prepared_by" value="<?=$_SESSION['user']['id']?>" readonly="readonly" />

      </div>
<div>

        <label for="email">WO From: </label>

        <input  name="for" type="for" id="for" value="<?=$for?>" readonly="readonly"/>

      </div>
    </fieldset></td>

    <td>

			<fieldset>

			

			<div>

			<label>Work Order For : </label> 

			<input  name="wo_subject" type="text" id="wo_subject" value="<?=$wo_subject?>"/>

			</div>

			<div>

			<label for="email">Details : </label>

            <textarea name="wo_detail" style="height:65px; width:140px" id="wo_detail"><?=$wo_detail ?></textarea>

			</div>

			</fieldset>	</td>

  </tr>

  <tr>

    <td colspan="2">



    <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006600" style="color:#CCC">

      <tr>

        <td align="center" bgcolor="#339900" style="height:30px; color:#FFF; font-size:18px;"><strong><?=$status?>
           <a target="_blank" href="../report/work_order_factory_print.php?wo_id=<?=$_SESSION['wo_id']?>">
           <img src="../../images/print.png" width="26" height="26" /></a></strong></td>

      </tr>

    </table></td>

    </tr>

</table>



<? if($wo_id>0){?>


<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>

      <td><div class="tabledesign2">

        <p>
<table width="100%" cellspacing="0" cellpadding="0" id="grp">
<tbody><tr>
<th>Order Id</th>
<th>Item Name</th>
<th>Style No</th>
<th>Specification</th>
<th>Meassurment</th>
<th>Qty</th>
<th>Rate</th>
<th>Edit</th></tr>
<? 
$res='select a.id,a.id as order_id ,b.item_name,a.style_no,a.specification,a.meassurment,a.qty,a.rate from lc_workorder_details a,lc_product_item b where b.id=a.item_id and a.wo_id='.$wo_id;
$query=db_query($res);
while($wo_item=mysqli_fetch_object($query)){
?>
<tr <? if($i%2) echo 'class="alt"';?>>
<td><?=$wo_item->id?></td>
<td><?=$wo_item->item_name?></td>
<td><input type="text" name="<?='style_no#'.$wo_item->id?>" id="<?='style_no#'.$wo_item->id?>" value="<?=$wo_item->style_no?>" style="width:100px;" /></td>
<td><input type="text" name="<?='specification#'.$wo_item->id?>" id="<?='specification#'.$wo_item->id?>" value="<?=$wo_item->specification?>" style="width:100px;" /></td>
<td><input type="text" name="<?='meassurment#'.$wo_item->id?>" id="<?='meassurment#'.$wo_item->id?>" value="<?=$wo_item->meassurment?>" style="width:100px;" /></td>
<td><input type="text" name="<?='qty#'.$wo_item->id?>" id="<?='qty#'.$wo_item->id?>" value="<?=$wo_item->qty?>" style="width:50px;" /></td>
<td><input type="text" name="<?='rate#'.$wo_item->id?>" id="<?='rate#'.$wo_item->id?>" value="<?=$wo_item->rate?>" style="width:50px;" /></td>
<td align="center"><input name="<?='edit#'.$wo_item->id?>" type="submit" id="Edit" value="Edit" style="width:30px; height:20px;" /></td>
</tr>
<?
}
?>
</tbody></table>
        </p>

      </div></td>

    </tr>

	

    <tr>

     <td>



 </td>

    </tr>

  </table>

<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">

                      <tr>

                            <td colspan="6" align="center" bgcolor="#CCCCFF"><strong>CHALAN DELIVER</strong></td>

      </tr>

    </table>
					  <br /><br />
<?

$res="select d.id,d.id as chalan_id,concat(b.category_name,'-',a.item_name,' (',c.style_no,'::',c.specification,'::',c.meassurment,')') as item,d.delivery_place,d.chalan_from,d.chalan_date,d.qty from lc_product_item a,lc_product_category b,lc_workorder_details c,lc_workorder_chalan d where c.item_id=a.id and a.product_category_id=b.id and c.id=d.specification_id  and c.wo_id=".$wo_id;





?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">



    <tr>

      <td><div class="tabledesign2" style="text-align:center">

        <? 
$check=db_query($res);
$count = mysqli_num_rows($check);
if($count>0)
echo link_report($res);
else echo '<input name="dwo" type="submit" value="Delete This WO" style="width:300px;height:30px;" />';

		?>

      </div></td>

    </tr>

	

    <tr>

     <td>



 </td>

    </tr>

  </table>

<table width="100%" border="0">

  <tr>

      <td align="center"><p>&nbsp;</p></td>

      

    </tr>

</table>

</form>

<? }?>

</div>



<?

$main_content=ob_get_contents();

ob_end_clean();

require_once SERVER_CORE."routing/layout.bottom.php";

?>