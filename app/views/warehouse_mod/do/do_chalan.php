<?php

 

 

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

$master2 = find_all_field('sale_do_master','','do_no='.$do_no);
//echo $master2->depot_id;
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
$depot = find_all_field('warehouse','',"warehouse_id=".$dealer->depot);
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
if($depot->owned_type!=2)
		//auto_insert_sales_chalan_secoundary($chalan_no);
		//Journal
		


	$jv_no=next_journal_sec_voucher_id();
	$proj_id = 'clouderp'; 
	$do_ch =    find_all_field('sale_do_chalan','do_no','chalan_no='.$chalan_no);
	$group_for =  $_SESSION['user']['group'];
	$do_master = find_all_field('sale_do_master','do_no','do_no='.$do_ch->do_no);
    $dealer = find_all_field('dealer_info','',"dealer_code=".$do_ch->dealer_code);
	
	
	
    $tr_id = $do_ch->do_no;
	$tr_no = $chalan_no;
	$tr_from = 'Sales';
	$narration = 'CH#'.$chalan_no.' (DO#'.$do_ch->do_no.')';
    
	$sql = "select sum(total_amt) as total_amt from sale_do_chalan c where  chalan_no=".$chalan_no;
	
	$ch = find_all_field_sql($sql);

	
if ($do_master->discount>0) {
	 $cash_discount = ($ch->total_amt * $do_master->discount)/100;
}else {
	 $cash_discount = $do_master->cash_discount;
}

$sales_amt = $ch->total_amt-$cash_discount;

$vat_on_sales = ($sales_amt*$do_master->vat)/100;
	

	//$jv_date = strtotime($do->chalan_date);
	
	$jv_date = $do_ch->chalan_date;

	$invoice_amt = ($sales_amt + $vat_on_sales);
	
	//$config_ledger = find_all_field('config_group_class','sales_ledger',"group_for=".$group_for);
	$config_ledger = find_all_field('config_group_class','sales_ledger',"group_for=".$_SESSION['user']['group']);
	$dealer_ledger= $dealer->account_code;
	$cc_code = $group_for;


$ch_sql = 'select c.*,i.item_name,s.ledger_id_2 from sale_do_chalan c, item_info i, item_sub_group s where i.sub_group_id=s.sub_group_id and c.item_id=i.item_id and c.chalan_no="'.$chalan_no.'"';
$ch_query = db_query($ch_sql);
while($ch_data = mysqli_fetch_object($ch_query)){
//debit	
 $avg_rate = find_a_field('journal_item', '(sum(item_in*final_price)-sum(item_ex*final_price))/(sum(item_in)-sum(item_ex))', 'item_id = "'.$ch_data->item_id.'" and warehouse_id = "'.$_SESSION['user']['depot'].'"');
 $cogs_rate = $avg_rate;
 $cogs_amt = $cogs_rate*$ch_data->dist_unit;

add_to_sec_journal($proj_id, $jv_no, $jv_date, $config_ledger->sales_ledger, $narration, '0', ($ch_data->total_amt), $tr_from, $tr_no,'',$tr_id,$cc_code,$group_for);
add_to_sec_journal($proj_id, $jv_no, $jv_date, $ch_data->ledger_id_2, $narration, '0', ($cogs_amt), $tr_from, $tr_no,'',$tr_id,$cc_code,$group_for);
add_to_sec_journal($proj_id, $jv_no, $jv_date, $config_ledger->cogs_ledger, $narration, ($cogs_amt), '0', $tr_from, $tr_no,'',$tr_id,$cc_code,$group_for);

}

if($cash_discount>0){
add_to_sec_journal($proj_id, $jv_no, $jv_date, $config_ledger->sales_discount, $narration, ($cash_discount), '0', $tr_from, $tr_no,'',$tr_id,$cc_code,$group_for);
}
if($vat_on_sales>0){
add_to_sec_journal($proj_id, $jv_no, $jv_date, $config_ledger->sales_vat, $narration, '0', ($vat_on_sales), $tr_from, $tr_no,'',$tr_id,$cc_code,$group_for);
}
add_to_sec_journal($proj_id, $jv_no, $jv_date, $dealer_ledger, $narration, ($invoice_amt), '0', $tr_from, $tr_no,'',$tr_id,$cc_code,$group_for);


		//Journal
		if($dealer->team_name=='Corporate'){
			echo "<script language='javascript'>window.open('chalan_bill_corporate.php?v_no=".$chalan_no."','Chalan Print').focus();</script>";
			header("Location:do_chalan.php?do=$do_master->do_no");
		}else{
			echo "<script language='javascript'>window.open('chalan_bill_corporate.php?v_no=".$chalan_no."','Chalan Print').focus();</script>";
			header("Location:do_chalan.php?do=$do_master->do_no");
			}
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

		alert('Can not Delivery More than Undelivered Pcs.');
		document.getElementById('chalan2_'+id).value='';
		document.getElementById('chalan2_'+id).focus();

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
<div class="row">
		<div class="col-sm-10">
			<div class="row ">
    
	
	     <div class="col-md-3 form-group">
            <label for="do_no" >DO No: </label>
            <input   name="do_no" type="text" class="form-control" id="do_no" value="<? if($$unique_master>0) echo $$unique_master; else echo (find_a_field($table_master,'max('.         $unique_master.')','1')+1);?>" readonly/>
          </div>
		  
		  <div class="col-md-3 form-group">
            <label for="dealer_code">Dealer: </label>
            <select  id="dealer_code" class="form-control" name="dealer_code" readonly="readonly">
              <option value="<?=$dealer->dealer_code;?>">
              <?=$dealer->dealer_code.'-'.$dealer->dealer_name_e;?>
              </option>
            </select>
          </div>
		  
		  
		 <div class="col-md-3 form-group">
            <label for="wo_detail2">Area: </label>
            <input   name="area_name" class="form-control"  type="text" id="area_name" value="<?=$dealer->area_name?>" readonly/>
          </div>
		  
		  
		   <div class="col-md-3 form-group">
            <label for="wo_detail">Zone: </label>
            <input   name="zone_name" class="form-control"  type="text" id="zone_name" value="<?=$dealer->zone_name?>" readonly/>
          </div>
		  
		  
		  
		  
		    <div class="col-md-3 form-group">
            <label for="wo_detail">Region: </label>
            <input  name="region_name" class="form-control"  type="text" id="region_name" value="<?=$dealer->region_name?>" readonly/>
          </div>
		  
		  
          <div class="col-md-3 form-group">
            <label for="depot_id">Commission: </label>
            
            <input class="form-control"  name="commission" type="text" id="commission" value="<?=$commission?>" readonly="readonly"/>
          </div>
		  
          <div class="col-md-3 form-group">
            <label for="rcv_amt">DO Date: </label>
            <input name="do_date" type="text" class="form-control" id="do_date"  value="<?=$do_date?>" tabindex="101" />
          </div>
		  
        <div class="col-md-3 form-group">
            <label for="remarks">Address: </label>
            <input name="remarks" type="text" id="remarks"  value="<?=$remarks?>" class="form-control"  />
          </div>
		  
		  
		  
		  
		   <div class="col-md-3 form-group">
            <label for="do_date"> Note: </label>
    <input name="wo_detail2" type="text" id="wo_detail2"  value="<?=$wo_detail2?>" class="form-control"  />
          </div>
		  
          <div class="col-md-3 form-group">
            <label for="wo_subject"> Depot: </label>
          <select  id="depot_id" name="depot_id" class="form-control"  readonly="readonly">
              <option value="<?=$dealer->depot;?>">
              <?=find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot'])?>
              </option>
            </select>
            
          </div>
		      
		  
   
		
				
		
		
		</div>
		
		

		</div>
		<div class="col-sm-2">
			<table width="100%" border="1" cellspacing="0" cellpadding="0" style="font-size:10px;">
	          <tr>
          <td bgcolor="#FFFF99">UnDel</td>
          <td align="center" bgcolor="#FFFF99"><a target="_blank" href="undel_chalan_view.php?dealer_code=<?=$dealer->dealer_code?>"><img src="../../../images/icons/print.png" width="15" height="15" /></a></td>
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
          <td align="center" bgcolor="#FFFF99"><a target="_blank" href="chalan_bill_corporate.php?v_no=<?=$aaa->chalan_no?>"><img src="../../../images/icons/print.png" width="15" height="15" /></a></td>
        </tr>
<?
}
?>
      </table>
		</div>
	</div>
  <table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
	
      
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
            <input style="width:105px;"  name="driver_name" type="text" id="driver_name" required="required" autocomplete="off"/>
          </strong></td>
          <td bgcolor="#9966FF">&nbsp;</td>
        </tr>
        <tr>
          <td align="right" bgcolor="#9999FF"><strong>Delivery Man:</strong></td>
		  <td bgcolor="#9999FF"><strong>
            <input style="width:105px;"  name="delivery_man" type="text" id="delivery_man" required="required" autocomplete="off"/>
          </strong></td>
		  <td align="right" bgcolor="#9999FF"><strong>Driver Name: </strong></td>
          <td bgcolor="#9999FF"><strong>
            <input style="width:105px;"  name="driver_name_real" type="text" id="driver_name_real" required="required" autocomplete="off"/>
          </strong></td>
		 <td align="right" bgcolor="#9999FF"><strong>Truck No:</strong></td>
          <td bgcolor="#9999FF"><strong>
            <input style="width:105px;"  name="vehicle_no" type="text" id="vehicle_no" required autocomplete="off"/>
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
              <th width="7%">Pcs</th>
              <th width="6%">Crt</th>
              <th width="6%">Pcs</th>
              <th width="7%">Crt</th>
              <th width="8%">Pcs</th>
              <th width="4%">Crt</th>
              <th width="5%">Pcs</th>
              </tr>
          <? while($row=mysqli_fetch_object($res)){$bg++?>
          <tr bgcolor="<?=(($bg%2)==1)?'#FFEAFF':'#DDFFF9'?>">
            <td><?=++$ss;?></td>
            <td><?=$row->finish_goods_code?><input type="hidden" name="item_fg_<?=$row->id?>" id="item_fg_<?=$row->id?>" value="<?=$row->finish_goods_code?>" /></td>
              <td><?=$row->item_name?></td>
              <td align="center"><?= 0 ?></td>
              <td align="center"><?=$row->total_unit?></td>
              <td align="center"><? $del_qty = find_a_field('sale_do_chalan','sum(total_unit)','order_no="'.$row->id.'" and item_id="'.$row->item_id.'"');
			  if($del_qty>0) echo $del_pkt = (int)($del_qty/$row->pkt_size); else echo 0;?></td>
              <td align="center"><? if($del_qty>0) echo $del_dist = (int)($del_qty%$row->pkt_size); else echo 0;?></td>
              <td align="center"><?= 0 ?>
                <input type="hidden" name="undelpkt_<?=$row->id?>" id="undelpkt_<?=$row->id?>" value="<?=$undel_pkt?>" /></td>
              <td align="center"><? $undel_qty=($row->total_unit-$del_qty); echo $undel_pkt = (int)($undel_qty/$row->pkt_size);?>
                <input type="hidden" name="undeldist_<?=$row->id?>" id="undeldist_<?=$row->id?>" value="<?=$undel_qty?>" /></td>
              <td align="center" bgcolor="#66FF66" style="text-align:center">
                <? if($undel_pkt>0){?>
				<!--<script language="javascript"> active_ids.push('chalan_<?=$row->id?>');</script>-->
				<input type="text" name="chalan_<?=$row->id?>"  value="<?= 0?>"id="chalan_<?=$row->id?>" required style="width:40px; float:none" onchange="cal(<?=$row->id?>)" /><? } else echo 'Done';?></td>
              <td align="center" bgcolor="#6699FF" style="text-align:center">
			  <? if($undel_qty>0){$cow++;
			  //if($dealer->product_group==''||$row->finish_goods_code>1999){
			  ?>
<input name="chalan2_<?=$row->id?>" type="text" id="chalan2_<?=$row->id?>" style="width:40px; float:none" value="<?=$row->total_unit-$del_pkt?>" required="required" onchange="cal2(<?=$row->id?>)" />
                <? //}else echo '-';
				} else echo 'Done';?></td>
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
  </table><br />
  
<table width="100%" border="0">
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
elseif(date('Y-m-d')<$from_date){
?>
<tr>
<td colspan="2" align="center" bgcolor="#FF3333"><strong>THIS DELIVERY ORDER IS COMPLETE</strong></td>
</tr>
<?
}
else{?>
<tr>
<td align="center"><input name="delete" type="button" class="btn btn-danger" value="CANCEL DELIVERY ORDER" style="width:270px; font-weight:bold; font-size:12px;color:white; height:30px" onclick="window.location = 'select_dealer_chalan.php?del=1&do_id=<?=$do_no?>';" />
<input  name="do_no" type="hidden" id="do_no" value="<?=$$unique_master?>"/>
<input  name="dealer_code" type="hidden" id="dealer_code" value="<?=$dealer->dealer_code;?>"/></td>
<td align="center"><input name="confirm" type="submit" class="btn btn-info" value="COMPLETE DELIVERY ORDER" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:white" /></td>
</tr>
<? }?>
</table>
</form>

<? }?>
</div>

<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>