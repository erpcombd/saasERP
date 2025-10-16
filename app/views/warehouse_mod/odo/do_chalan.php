<?php

session_start();

ob_start();


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Demand Order Create';



//do_calander('#chalan_date','-0','+0');

do_calander('#chalan_date');



if($_REQUEST['do']>0) 

$do_no = $_REQUEST['do'];

else

$do_no = $_POST['do_no'];



$table_master='sale_do_master';

$unique_master='do_no';



$table_detail='sale_do_details';

$unique_detail='id';



$table_chalan='sale_do_chalan';

$unique_chalan='id';





if(prevent_multi_submit()){



if(isset($_POST['confirm'])){



		$driver_name=$_POST['driver_name'];

		$driver_name_real=$_POST['driver_name_real'];

		$vehicle_no=$_POST['vehicle_no'];

		$delivery_man=$_POST['delivery_man'];

		$chalan_date=$_POST['chalan_date'];

		$now = date('Y-m-d H:i:s');

		



		$chalan_no = next_chalan_no($_SESSION['user']['depot'],$chalan_date);

		

		$config_ledger = find_all_field('config_group_class','sales_ledger',"group_for=".$_SESSION['user']['group']);

		//$sales_ledger = find_a_field('config_group_class','sales_ledger',"group_for=".$_SESSION['user']['group']);

		$dealer= find_all_field('dealer_info','account_code',"dealer_code=".$_POST['dealer_code']);

		$dealer_ledger= $dealer->account_code;

		$master = find_all_field('sale_do_master','','do_no='.$do_no);

		$sql = 'select * from sale_do_details where do_no = '.$do_no.' and (item_id!=1096000100010239 and item_id!=1096000100010312)';

		$query = db_query($sql);	

		while($data=mysqli_fetch_object($query))

		{

			if(($_POST['chalan_'.$data->id]>0)||($_POST['chalan2_'.$data->id]>0))

			{

				$chalan_pkt=$_POST['chalan_'.$data->id];

				$chalan_dist=$_POST['chalan2_'.$data->id];

				$unit_qty=(($data->pkt_size*$chalan_pkt)+$chalan_dist);

				$total_amt = ($unit_qty*$data->unit_price);

				$dealer_code = $_POST['dealer_code'];

$q = "INSERT INTO  sale_do_chalan (order_no, chalan_no, do_no, item_id, dealer_code, unit_price, pkt_size, pkt_unit, dist_unit, total_unit, total_amt, chalan_date, depot_id, driver_name, driver_name_real, vehicle_no, delivery_man, entry_by, entry_at,do_date)

 VALUES 

('".$data->id."', '".$chalan_no."', '".$do_no."', '".$data->item_id."', '".$dealer_code."', '".$data->unit_price."', '".$data->pkt_size."', '".$chalan_pkt."', '".$chalan_dist."', '".$unit_qty."', '".$total_amt."', '".$chalan_date."', '".$_SESSION['user']['depot']."', '".$driver_name."','".$driver_name_real."', '".$vehicle_no."', '".$delivery_man."', '".$_SESSION['user']['id']."', '".$now."','".$master->do_date."')";

				db_query($q);

				$ch_id = db_insert_id();

				journal_item_control($data->item_id,$_SESSION['user']['depot'],$_POST['chalan_date'],0,$unit_qty,'Sales',$ch_id,'','',$chalan_no);

			}

		}

		

$sql = 'select s.*,d.* from sale_do_details d, sale_gift_offer s where s.id=d.gift_id and d.do_no = '.$do_no.' and (d.item_id=1096000100010239 or d.item_id=1096000100010312)';

		$query = db_query($sql);	

		while($data=mysqli_fetch_object($query))

		{

$order	= find_all_field('sale_do_details','','id='.$data->gift_on_order);

$gift = find_all_field('sale_gift_offer','','id='.$data->gift_id);





					

			if(($_POST['chalan_'.$order->id]>0)||($_POST['chalan2_'.$order->id]>0))

			{

				$chalan_pkt=$_POST['chalan_'.$order->id];

				$chalan_dist=$_POST['chalan2_'.$order->id];

				$item_qty=(($order->pkt_size*$chalan_pkt)+$chalan_dist);

				

				$data->pkt_size = '1.00';

				$unit_price = (-1)*($gift->gift_qty);

				$unit_qty =  (int)($item_qty/$gift->item_qty);

				$total_amt = $unit_qty * $unit_price;

				$chalan_pkt = '0.00';

				$chalan_dist = $unit_qty;

				$dealer_code = $_POST['dealer_code'];

				

				if($chalan_dist>0){

$q = "INSERT INTO  sale_do_chalan (order_no, chalan_no, do_no, item_id, dealer_code, unit_price, pkt_size, pkt_unit, dist_unit, total_unit, total_amt, chalan_date, depot_id, driver_name, driver_name_real, vehicle_no, delivery_man, entry_by, entry_at,do_date)

 VALUES 

('".$data->id."', '".$chalan_no."', '".$do_no."', '".$data->item_id."', '".$dealer_code."', '".$data->unit_price."', '".$data->pkt_size."', '".$chalan_pkt."', '".$chalan_dist."', '".$unit_qty."', '".$total_amt."', '".$chalan_date."', '".$_SESSION['user']['depot']."', '".$driver_name."','".$driver_name_real."', '".$vehicle_no."', '".$delivery_man."', '".$_SESSION['user']['id']."', '".$now."','".$master->do_date."')";

				db_query($q);

				

				$ch_id = db_insert_id();

				journal_item_control($data->item_id,$_SESSION['user']['depot'],$_POST['chalan_date'],0,$unit_qty,'Sales',$ch_id,'','',$chalan_no);

				}

			}

					

					

		}

		if($ch_id>0)

		{

		auto_insert_sales_chalan_secoundary($chalan_no);

		}



}

}

else

{

	$type=0;

	$msg='Data Re-Submit Warning!';

}

if($$unique_master>0)

{

		$condition=$unique_master."=".$$unique_master;

		$data=db_fetch_object($table_master,$condition);

		foreach ($data as $key => $value)

		{ $$key=$value;}

		

}

$dealer = find_all_field('dealer_info','','dealer_code='.$dealer_code);

auto_complete_from_db('item_info','item_name','concat(item_name,"#>",finish_goods_code)','product_nature="Salable"','item');

?>

<script language="javascript">

function count()

{

var pkt_unit = ((document.getElementById('pkt_unit').value)*1);

var dist_unit = ((document.getElementById('dist_unit').value)*1);

var pkt_size = ((document.getElementById('pkt_size').value)*1);

var total_unit = (pkt_unit*pkt_size)+dist_unit;

var unit_price = ((document.getElementById('unit_price').value)*1);

var total_amt  = (total_unit*unit_price);

document.getElementById('total_unit').value=total_unit;

document.getElementById('total_amt').value	= total_amt .toFixed(2);

}

function cal2(id) {

  var pkt_unit = ((document.getElementById('chalan_'+id).value)*1);

  var undelpkt = ((document.getElementById('undelpkt_'+id).value)*1);

  var dist_unit = ((document.getElementById('chalan2_'+id).value)*1);

  var undeldist = ((document.getElementById('undeldist_'+id).value)*1);

  if(dist_unit>undeldist)

  {

	if(pkt_unit>(undelpkt-1))

	{

		alert('Can not Delivery More than Undelivered Pcs.');

		document.getElementById('chalan2_'+id).value='';

		document.getElementById('chalan2_'+id).focus();

	}

  }

}

function cal(id) {

  var pkt_unit = ((document.getElementById('chalan_'+id).value)*1);

  var undelpkt = ((document.getElementById('undelpkt_'+id).value)*1);

  if(pkt_unit>undelpkt)

  {

alert('Can not Delivery More than Undelivered Pkt.');

document.getElementById('chalan_'+id).value='';

document.getElementById('chalan_'+id).focus();

  }

  Calc_totals();

}



var active_ids = new Array();

function Calc_totals() {

    var answerValues = 0; 

	var answerValue = 0;

    for(i=0; i < active_ids.length; i++) 

    { 

        answerValue = Number(document.getElementById(active_ids[i]).value);

		answerValues += Number(answerValue);

    } 



	document.getElementById('crtdiv').innerHTML = '<span>'+answerValues+'</span>';

}

</script>

<div class="form-container_large">

<form action="" method="post" name="codz" id="codz">

  <table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">

    <tr>

      <td><fieldset style="width:320px;">

        <div>

          <label style="width:75px;">DO No : </label>

          <input style="width:235px;"  name="do_no2" type="text" id="do_no2" value="<? if($$unique_master>0) echo $$unique_master; else echo (find_a_field($table_master,'max('.$unique_master.')','1')+1);?>" readonly="readonly"/>

        </div>

        <div>

          <label style="width:75px;">Dealer : </label>

          <select style="width:235px;" id="dealer_code" name="dealer_code" readonly="readonly">

            <option value="<?=$dealer->dealer_code;?>">

              <?=$dealer->dealer_name_e.' ['.$dealer->dealer_code.']'.' - '.$dealer->product_group;?>

              </option>

          </select>

        </div>

        <div>

          <label style="width:75px;">Area : </label>

          <input style="width:235px;"  name="wo_detail2" type="text" id="wo_detail2" value="<?=find_a_field('area','AREA_NAME','AREA_CODE='.$dealer->area_code)?>" readonly="readonly"/>

        </div>

        <div>

          <label style="width:75px;">Zone : </label>

          <input style="width:235px;"  name="wo_detail" type="text" id="wo_detail" value="<?=find_a_field_sql('select a.ZONE_NAME from zon a,area b where a.ZONE_CODE=b.ZONE_ID and b.AREA_CODE='.$dealer->area_code)?>" readonly="readonly"/>

        </div>

        <div>

          <label style="width:75px;">Region : </label>

          <input style="width:235px;"  name="wo_detail" type="text" id="wo_detail" value="<?=find_a_field_sql('select c.BRANCH_NAME from zon a,area b,branch c where a.REGION_ID=c.BRANCH_ID and a.ZONE_CODE=b.ZONE_ID and b.AREA_CODE='.$dealer->area_code)?>" readonly="readonly"/>

        </div>

      </fieldset></td>

      <td></td>

      <td><fieldset style="width:300px;">

        <div>

          <label style="width:75px;">DO Date: </label>

          <input name="do_date" type="text" id="do_date" style="width:215px;" value="<? if($$unique_master>0) echo $do_date = (find_a_field($table_master,'do_date','do_no='.$do_no));?>" tabindex="10" readonly="readonly" />

        </div>

        <div>

          <label style="width:75px;">Address: </label>

          <textarea name="delivery_address" id="delivery_address" style="width:215px;"><? if($delivery_address!='') echo $delivery_address; else echo $dealer->address_e?>

  </textarea>

        </div>

        <div>

          <label style="width:75px;">Note: </label>

          <input name="remarks" type="text" id="remarks" style="width:215px;" value="<?=$remarks?>" tabindex="10" />

        </div>

        <div>

          <label style="width:75px;">Depot : </label>

          <select style="width:215px;" id="depot_id2" name="depot_id2" readonly="readonly">

            <option value="<?=$dealer->depot;?>">

              <?=find_a_field('warehouse','warehouse_name','warehouse_id='.$dealer->depot)?>

              </option>

          </select>

        </div>

      </fieldset></td>

      <td></td>

      <td valign="top">

      <table width="100%" border="1" cellspacing="0" cellpadding="0" style="font-size:10px;">

	          <tr>

          <td bgcolor="#FFFF99">UnDel</td>

          <td align="center" bgcolor="#FFFF99"><a target="_blank" href="undel_chalan_view.php?dealer_code=<?=$dealer->dealer_code?>"><img src="../../images/print.png" width="15" height="15" /></a></td>

        </tr>

        <tr>

          <td align="left" bgcolor="#9999CC"><strong>Date</strong></td>

          <td align="left" bgcolor="#9999CC"><strong>DC</strong></td>

        </tr>

<?

$sql='select distinct chalan_no,chalan_date from sale_do_chalan where do_no='.$do_no.' order by chalan_no desc';

$qqq=db_query($sql);

while($aaa=mysqli_fetch_object($qqq)){

?>

        <tr>

          <td bgcolor="#FFFF99"><?=$aaa->chalan_date?></td>

          <td align="center" bgcolor="#FFFF99"><a target="_blank" href="chalan_bill_corporate.php?v_no=<?=$aaa->chalan_no?>"><img src="../../images/print.png" width="15" height="15" /></a></td>

        </tr>

<?

}

?>



      </table></td>

    </tr>

    <tr>

      <td colspan="5"><table width="100%" border="0" cellspacing="0" cellpadding="0">

        <tr>

          <td align="right" bgcolor="#9966FF">&nbsp;</td>

          <td align="right" bgcolor="#9966FF"><strong>Chalan Date:</strong></td>

          <td bgcolor="#9966FF"><strong>

            <input style="width:105px;"  name="chalan_date" type="text" id="chalan_date" required="required" value="<?=($_POST['chalan_date'])?$_POST['chalan_date']:date('Y-m-d')?>"/>

          </strong></td>

          <td align="right" bgcolor="#9966FF"><strong>Serial No:</strong></td>

          <td bgcolor="#9966FF"><strong>

            <input style="width:105px;"  name="driver_name" type="text" id="driver_name" required="required"/>

          </strong></td>

          <td bgcolor="#9966FF">&nbsp;</td>

        </tr>

        <tr>

          <td align="right" bgcolor="#9999FF"><strong>Delivery Man:</strong></td>

		  <td bgcolor="#9999FF"><strong>

            <input style="width:105px;"  name="delivery_man" type="text" id="delivery_man" required="required"/>

          </strong></td>

		  <td align="right" bgcolor="#9999FF"><strong>Driver Name: </strong></td>

          <td bgcolor="#9999FF"><strong>

            <input style="width:105px;"  name="driver_name_real" type="text" id="driver_name_real" required="required"/>

          </strong></td>

		 <td align="right" bgcolor="#9999FF"><strong>Truck No:</strong></td>

          <td bgcolor="#9999FF"><strong>

            <input style="width:105px;"  name="vehicle_no" type="text" id="vehicle_no" required/>

          </strong></td>

        </tr>

      </table></td>

    </tr>

  </table>

  <? if($$unique_master>0){?>



<? 

$sql='select a.id,a.item_id,b.finish_goods_code,b.item_name,a.pkt_unit,a.dist_unit,a.total_unit,a.pkt_size from sale_do_details a,item_info b where (b.item_id!=1096000100010239 and  b.item_id!=1096000100010312) and b.item_id=a.item_id and a.do_no='.$$unique_master;

$res=db_query($sql);

?>

<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">

    <tr>

      <td><div class="tabledesign2">

      <table width="100%" align="center" cellpadding="0" cellspacing="0" id="grp">

      <tbody>

          <tr>

            <th rowspan="2">SL</th>

            <th rowspan="2">Code</th>

            <th width="50%" rowspan="2">Item Name</th>

            <th colspan="2" bgcolor="#FF99FF">Order Qty</th>

            <th colspan="2" bgcolor="#009900">Del Qty</th>

            <th colspan="2" bgcolor="#FFFF00">Undel Qty</th>

            <th colspan="2" bgcolor="#0099CC">Chalan Qty</th>

          </tr>

          <tr>

              <th width="7%">Crt</th>

              <th width="7%">Kgs</th>

              <th width="6%">Crt</th>

              <th width="6%">Kgs</th>

              <th width="7%">Crt</th>

              <th width="8%">Kgs</th>

              <th width="4%">Crt</th>

              <th width="5%">Kgs</th>

              </tr>

          <? while($row=mysqli_fetch_object($res)){$bg++?>

          <tr bgcolor="<?=(($bg%2)==1)?'#FFEAFF':'#DDFFF9'?>">

            <td><?=++$ss;?></td>

            <td><?=$row->finish_goods_code?></td>

              <td><?=$row->item_name?></td>

              <td align="center"><?=$row->pkt_unit?></td>

              <td align="center"><?=$row->dist_unit?></td>

              <td align="center"><? $del_qty = find_a_field('sale_do_chalan','sum(total_unit)','order_no="'.$row->id.'" and item_id="'.$row->item_id.'"');

			  if($del_qty>0) echo $del_pkt = (int)($del_qty/$row->pkt_size); else echo 0;?></td>

              <td align="center"><? if($del_qty>0) echo $del_dist = (int)($del_qty%$row->pkt_size); else echo 0;?></td>

              <td align="center"><? $undel_qty=($row->total_unit-$del_qty); echo $undel_pkt = (int)($undel_qty/$row->pkt_size);?>

                <input type="hidden" name="undelpkt_<?=$row->id?>" id="undelpkt_<?=$row->id?>" value="<?=$undel_pkt?>" /></td>

              <td align="center"><? echo $undel_dist = (int)($undel_qty%$row->pkt_size);?>

                <input type="hidden" name="undeldist_<?=$row->id?>" id="undeldist_<?=$row->id?>" value="<?=$undel_dist?>" /></td>

              <td align="center" bgcolor="#66FF66" style="text-align:center">

                <? if($undel_pkt>0){?>

				<script language="javascript"> active_ids.push('chalan_<?=$row->id?>');</script>

				<input type="text" name="chalan_<?=$row->id?>" value="<?= 0?>" id="chalan_<?=$row->id?>" required style="width:40px; float:none" onchange="cal(<?=$row->id?>)" /><? } else echo 'Done';?></td>

              <td align="center" bgcolor="#6699FF" style="text-align:center">

			  <? if($undel_qty>0){$cow++;?>

                <input name="chalan2_<?=$row->id?>" type="text" id="chalan2_<?=$row->id?>" style="width:40px; float:none" value="<?=$row->total_unit-$del_pkt?>" required="required" onchange="cal2(<?=$row->id?>)" />

                <? } else echo 'Done';?></td>

              </tr>

          <? }?>

		    <tr>

            <td colspan="9">&nbsp;</td>

            <td align="center" bgcolor="#FFFFFF" style="text-align:center"><div id="crtdiv"></div></td>

            <td align="center" bgcolor="#FFFFFF" style="text-align:center"><div id="pcsdiv"></div></td>

          </tr>

      </tbody>

      </table>

      </div>

      </td>

    </tr>

  </table><br /><table width="100%" border="0">

<? 

if(date('d')>10)

$from_date = date('Y-m-01');

else

$from_date = date('Y-m-01',time()-(86400*date('d')+1));





if($cow<1){

$vars['status']='COMPLETED';

db_update($table_chalan, $do_no, $vars, 'do_no');

db_update($table_detail, $do_no, $vars, 'do_no');

db_update($table_master, $do_no, $vars, 'do_no');

?>

<tr>

<td colspan="2" align="center" bgcolor="#FF3333"><strong>THIS DELIVERY ORDER IS COMPLETE</strong></td>

</tr>

<? }

elseif($do_date<$from_date){

?>

<tr>

<td colspan="2" align="center" bgcolor="#FF3333"><strong>THIS DELIVERY ORDER TIME IS OVER</strong></td>

</tr>

<?

}

else{?>

<tr>

<td align="center"><input name="delete" type="button" class="btn1" value="CANCEL DELIVERY ORDER" style="width:270px; font-weight:bold; font-size:12px;color:#F00; height:30px" onclick="window.location = 'select_dealer_chalan.php?del=1&do_id=<?=$do_no?>';" />

<input  name="do_no" type="hidden" id="do_no" value="<?=$$unique_master?>"/>

<input  name="dealer_code" type="hidden" id="dealer_code" value="<?=$dealer->dealer_code;?>"/></td>

<td align="center"><input name="confirm" type="submit" class="btn1" value="COMPLETE DELIVERY ORDER" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:#090" /></td>

</tr>

<? }?>

</table>

  

</form>

<? }?>

</div>



<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>