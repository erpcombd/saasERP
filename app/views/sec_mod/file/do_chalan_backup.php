<?php
session_start();



include ("config/access_admin.php");

include ("config/db.php");

include 'config/function.php';
$username	=$_SESSION['username'];





$page="do_list";





include 'inc/header.php';

include 'inc/sidebar.php';



?> 
<!-- main page content -->
<div class="content-wrapper" style="padding-left: 30px;">

<?
//$store_name = find1("select warehouse_name from warehouse where warehouse_id='".$_SESSION['warehouse_id']."'");
//do_calander('#chalan_date','-0','+0');

if($_GET['do']>0) {


$check_status = find1("select status from ss_do_master where do_no='".$_GET['do']."'");
	if($check_status=='COMPLETED'){ redirect('home.php'); }
}
echo "hhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh".'<br>';

if($_REQUEST['do']>0) $do_no = $_REQUEST['do']; else $do_no = $_POST['do_no'];

$table_master='ss_do_master';
$unique_master='do_no';

$table_detail='ss_do_details';
$unique_detail='id';

$table_chalan='ss_do_chalan';
$unique_chalan='id';

echo "hhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh".'<br>';
$item_list = '1';
echo $sql='select order_no,item_id,sum(total_unit) total_unit from ss_do_chalan where do_no='.$do_no.' group by order_no';
$qqq=mysqli_query($conn,$sql);
echo "hhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh".'<br>';
while($aaa=mysqli_fetch_object($qqq)){
$delevery_qty[$aaa->order_no] = $aaa->total_unit;
$item_list .= ','.$aaa->item_id;
} 



if(isset($_POST['confirmm']) && $_POST['randcheck']==$_SESSION['rand']){


		$chalan_date        =$_POST['chalan_date'];
		$now                = date('Y-m-d h:s:i');
		

		$chalan_no = find1("select max(chalan_no)+1 from ss_do_chalan where 1"); if($chalan_no==0) $chalan_no=1;
		
		//$config_ledger  = find_all_field('config_group_class','sales_ledger',"group_for=".$_SESSION['user']['group']);
		$dealer         = find_all_field('ss_shop','',"dealer_code=".$_POST['dealer_code']);
		
		$dealer_ledger  = 1122; //$dealer->account_code;
		$master         = find_all_field('ss_do_master','','do_no='.$do_no);
		
		$sql = 'select * from ss_do_details where do_no = '.$do_no.' ';
		$query = mysqli_query($conn, $sql);	
		while($data=mysqli_fetch_object($query)){
			
			if(($_POST['chalan_'.$data->id]>0)||($_POST['chalan2_'.$data->id]>0)){
				$chalan_pkt     =$_POST['chalan_'.$data->id];
				$chalan_dist    =$_POST['chalan2_'.$data->id];
				$unit_qty       = (($data->pkt_size*$chalan_pkt)+$chalan_dist);
                $total_amt      = ($unit_qty*$data->unit_price);
                $total_tp       = ($unit_qty*$data->t_price);
                $grand_total    = $grand_total + $total_amt;
                
                $dealer_code = $_POST['dealer_code'];
                ini_set('display_errors','1');
                ini_set('display_startup_errors','1');
                error_reporting(E_ALL);          				
$q = "INSERT INTO  ss_do_chalan (order_no, chalan_no, do_no, item_id, dealer_code,t_price,nsp_per, unit_price, pkt_size, pkt_unit, dist_unit, total_unit, total_amt,total_tp, chalan_date, depot_id, driver_name, driver_name_real,shipping_name, vehicle_no,gate_pass_no, delivery_man, entry_by, entry_at,do_date)
VALUES 
('".$data->id."', '".$chalan_no."', '".$do_no."', '".$data->item_id."', '".$dealer_code."','".$data->t_price."','".$data->nsp_per."', '".$data->unit_price."', '".$data->pkt_size."', '".$chalan_pkt."', '".$chalan_dist."', '".$unit_qty."', '".$total_amt."','".$total_tp."', '".$chalan_date."', '".$_SESSION['warehouse_id']."', '".$driver_name."',
'".$driver_name_real."','".$shipping_name."', '".$vehicle_no."', '".$gate_pass_no."', '".$delivery_man."', '".$_SESSION['username']."', '".$now."','".$master->do_date."')";
                
mysqli_query($conn, $q);
$ch_id = mysqli_insert_id($conn);
                

journal_item_ss($data->item_id ,$warehouse_id,$_POST['chalan_date'],0,$unit_qty,'Sales',$ch_id,$data->unit_price,'',$chalan_no);
			}

} // end while
		

// ---------------------- GIFT Item Calculation --------------------------
// $sql = 'select s.*,d.* from ss_do_details d, ss_gift_offer s where s.id=d.gift_id and d.do_no = '.$do_no.' and (d.item_id=1096000100010239 or d.item_id=1096000100010312 or d.item_id=1096000100010967)';
// 		$query = mysqli_query($conn, $sql);	
// 		while($data=mysqli_fetch_object($query))
// 		{
//                 $order	= find_all_field('ss_do_details','','id='.$data->gift_on_order);
//                 $gift   = find_all_field('ss_gift_offer','','id='.$data->gift_id);


// 			if(($_POST['chalan_'.$order->id]>0)||($_POST['chalan2_'.$order->id]>0))
// 			{
// 				$chalan_pkt         =$_POST['chalan_'.$order->id];
// 				$chalan_dist        =$_POST['chalan2_'.$order->id];
// 				$item_qty           =(($order->pkt_size*$chalan_pkt)+$chalan_dist);
				
// 				$data->pkt_size     = '1.00';
// 				$unit_price         = (-1)*($gift->gift_qty);
// 				$unit_qty           = (int)($item_qty/$gift->item_qty);
// 				$total_amt          = $unit_qty * $unit_price;
// 				$chalan_pkt         = '0.00';
// 				$chalan_dist        = $unit_qty;
// 				$dealer_code        = $_POST['dealer_code'];
				
				
				
// 				if($chalan_dist>0){
				
//                 $q = "INSERT INTO  ss_do_chalan (order_no, chalan_no, do_no, item_id, dealer_code, unit_price, pkt_size, pkt_unit, dist_unit, total_unit, total_amt, chalan_date, depot_id, driver_name, driver_name_real, vehicle_no,gate_pass_no, delivery_man, entry_by, entry_at,do_date)
//                  VALUES 
//                 ('".$data->id."', '".$chalan_no."', '".$do_no."', '".$data->item_id."', '".$dealer_code."', '".$data->unit_price."', '".$data->pkt_size."', '".$chalan_pkt."', '".$chalan_dist."', '".$unit_qty."', '".$total_amt."', '".$chalan_date."', '".$_SESSION['warehouse_id']."', '".$driver_name."','".$driver_name_real."', '".$vehicle_no."', '".$gate_pass_no."', '".$delivery_man."', '".$_SESSION['user']['id']."', '".$now."','".$master->do_date."')";
//                 mysqli_query($conn, $q);
//                 	$ch_id = mysqli_insert_id($conn);
                
//                 journal_item_ss($data->item_id ,$_SESSION['warehouse_id'],$_POST['chalan_date'],0,$unit_qty,'Sales',$ch_id,'','',$chalan_no);
                				
// 				}
// 			}
					
					
// 		} 
		
		// end while
		


// -------------------------- Secondary Journal Function		
//if($ch_id>0) { auto_insert_sales_chalan_secoundary($chalan_no);  }



//$chalan_no;


// update do master
$ssql="update ss_do_master set status='COMPLETED' where do_no='".$do_no."'";
mysqli_query($conn, $ssql);





redirect("chalan_view.php?v=$chalan_no");
//header('Location: chalan_view.php?v=$chalan_no');


} // end submit confirm



if(isset($_POST['delete'])){

$update_sql='update ss_do_master set status="COMPLETED" where do_no="'.$do_no.'"';
mysqli_query($conn, $update_sql);
redirect("do_list.php");
}

if($$unique_master>0){
    
		$condition=$unique_master."=".$$unique_master;
		$data=db_fetch_object($table_master,$condition);
		while (list($key, $value)=each($data))
		{ $$key=$value;}
}



$dealer = find_all_field('ss_shop','','dealer_code='.$dealer_code);
//auto_complete_from_db('item_info','item_name','concat(item_name,"#>",finish_goods_code)','product_nature="Salable"','item');

if($$unique_master>0) $do_all=find_all_field($table_master,'do_date','do_no='.$do_no);


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
	var pkt_size  = ((document.getElementById('pkt_size_'+id).value)*1);
	var pkt_unit  = ((document.getElementById('chalan_'+id).value)*1);
	var dist_unit = ((document.getElementById('chalan2_'+id).value)*1);
	var unit_price = ((document.getElementById('unit_price_'+id).value)*1);
	var qty_unit  = (pkt_unit*pkt_size)+dist_unit;
	var total_amt  = qty_unit * unit_price;
	document.getElementById('total_amt_'+id).value = total_amt;
	var undelqty = ((document.getElementById('undelqty_'+id).value)*1);
	var stockqty = ((document.getElementById('stockqty_'+id).value)*1);
	
  if(qty_unit>undelqty)
  {
alert('Can not Delivery More than Undelivered Pkt.');
document.getElementById('chalan_'+id).value='';
document.getElementById('chalan2_'+id).value='';
document.getElementById('chalan_'+id).focus();
  }
  
  if(qty_unit>stockqty)
  {
alert('Can not Delivery More than Stock Pkt.');
document.getElementById('chalan_'+id).value='';
document.getElementById('chalan2_'+id).value='';
document.getElementById('chalan_'+id).focus();
  }
  Calc_totals();
}

var active_ids = new Array();
var active_ids2 = new Array();
var active_ids3 = new Array();
	
function Calc_totals() {
	
    var answerValues = 0; 
	var answerValue = 0;
	
    for(i=0; i < active_ids3.length; i++) 
    { 
        answerValue = Number(document.getElementById(active_ids3[i]).value);
		answerValues += Number(answerValue);
    } 
	var gift_unit = Math.floor(answerValues/4000)
	var gift_total = (gift_unit*12)
	var gift_pack_size = document.getElementById('gift_pack_size').value
	var gift_ctn  = Math.floor(gift_total/gift_pack_size)
	var gift_pcs  = Math.floor(gift_total%gift_pack_size)
	document.getElementById('amtdiv').innerHTML = '<span>'+answerValues+'</span>';
	document.getElementById('giftdiv').innerHTML = '<span>SK : '+(gift_unit*3)+' // ITEM : '+gift_ctn+' CTN & '+gift_pcs+' PCS</span>';
	
    var answerValues = 0; 
	var answerValue = 0;
	
	for(i=0; i < active_ids.length; i++) 
    { 
        answerValue = Number(document.getElementById(active_ids[i]).value);
		answerValues += Number(answerValue);
    } 

	document.getElementById('crtdiv').innerHTML = '<span>'+answerValues+'</span>';
	
	var answerValues2 = 0; 
	var answerValue2 = 0;
	
    for(i=0; i < active_ids2.length; i++) 
    { 
        answerValue2 = Number(document.getElementById(active_ids2[i]).value);
		answerValues2 += Number(answerValue2);
    } 

	document.getElementById('pcsdiv').innerHTML = '<span>'+answerValues2+'</span>';
}

</script>






<form action="" method="post" name="codz" id="codz">
<?php $rand=rand(); $_SESSION['rand']=$rand; ?>
<input type="hidden" value="<?php echo $rand; ?>" name="randcheck" />


<div class="row pt-2">
        <div class="col-3"><label for="do_no" class="col-form-label">DO No:</label></div>
        <div class="col-9"><input class="form-control border border-info" name="do_no" type="text" id="do_no" value="<?=$do_no?>" required="required" readonly/></div>
</div>

<div class="row pt-2">
        <div class="col-3"><label for="do_date" class="col-form-label">Date:</label></div>
        <div class="col-9"><input class="form-control border border-info" name="do_date" type="text" id="do_date" value="<?=$do_date?>" required="required" readonly/></div>
</div>    


<div class="row pt-2">
    
            <div class="col-3"><label for="shop" class="col-sm-2 col-form-label">Shop:</label></div> 
            <div class="col-9"><? $field='dealer_code';?>
            <select class="form-control border border-info" name="<?=$field?>" id="<?=$field?>" required readonly/>
                <option value="<?=$$field?>"><?php echo $party_name=find1('select shop_name from ss_shop where dealer_code="'.$$field.'"');?></option>
            </select>
            </div>


</div> 
<!--Row end-->
<div class="row pt-2 pb-2 mt-3" style=" background-color: #bdf786; ">
        <div class="col-3"><label for="do_date" class="col-form-label">Chalan Date:</label></div>
        <div class="col-9"><input class="form-control border border-info"  name="chalan_date" type="date" id="chalan_date" required="required" value="<?=date('Y-m-d');?>" readonly="readonly"/></div>
</div>   
            
  
  
<div class="row pt-3">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
<!--          <td align="left" bgcolor="#9966FF"><strong>Chalan Date:</strong></td>
          <td bgcolor="#9966FF"><strong>
			<input style="width:150px;"  name="chalan_date" type="date" id="chalan_date" required="required" value="<?=date('Y-m-d');?>" readonly="readonly"/>
          </strong></td>-->
          
          <!--<td width="11%" align="right" bgcolor="#9966FF"><strong>Serial No:</strong></td>-->
          <!--<td width="11%" bgcolor="#9966FF"><strong><input style="width:105px;"  name="driver_name" type="text" id="driver_name" required="required"/></strong></td>-->
          
          <!--<td width="13%" bgcolor="#9966FF"><strong>Driver Mobile No :</strong></td>-->
          <!--<td width="11%" bgcolor="#9966FF"><strong><input style="width:105px;"  name="delivery_man" type="text" id="delivery_man" required="required"/></strong></td>-->
        </tr>
        
        
        <!--<tr>-->
        <!--      <td align="right" bgcolor="#9999FF"><strong>Driver: </strong></td>-->
        <!--      <td bgcolor="#9999FF"><strong>-->
        <!--        <input style="width:105px;"  name="driver_name_real" type="text" id="driver_name_real" required="required"/>-->
        <!--      </strong></td>-->
        <!--      <td align="right" bgcolor="#9999FF"><strong>Truck No:</strong></td>-->
        <!--      <td bgcolor="#9999FF"><strong>-->
        <!--        <input style="width:80px;"  name="vehicle_no" type="text" id="vehicle_no" required="required"/>-->
        <!--      </strong></td>-->
        <!--      <td bgcolor="#9999FF"><strong>Gate Pass No :</strong></td>-->
        <!--      <td bgcolor="#9999FF"><strong><input style="width:50px;"  name="gate_pass_no" type="text" id="gate_pass_no" required="required"/></strong></td>-->
        <!--    <td bgcolor="#9999FF"><strong>Shipping:</strong></td>-->
        <!--    <td width="25%" bgcolor="#9999FF"><strong>-->
        <!--    <input style="width:90px;"  name="shipping_name" type="text" id="shipping_name" required="required"/></strong></td>-->
        <!--</tr>-->
</table>  
  
</div>   
  
  
  
  
<? if($$unique_master>0){  ?>

<? 
$sql='select a.id,a.item_id,b.finish_goods_code,b.item_name,a.pkt_unit,a.unit_price,a.dist_unit,a.total_unit,a.pkt_size,a.gift_on_item 
from ss_do_details a, item_info b 
where (b.item_id!=1096000100010239 and  b.item_id!=1096000100010312 and b.item_id!=1096000100010967) 
and b.item_id=a.item_id and a.do_no='.$$unique_master.' order by a.id';

$res=mysqli_query($conn, $sql);

?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><div class="tabledesign2">
      <table width="100%" align="center" cellpadding="0" cellspacing="0" id="grp">
      <tbody>
          <tr>
            <th rowspan="1">SL</th>
            <th width="25%" rowspan="1">Item Name</th>
            <th rowspan="1">Rate</th>
            <th colspan="1" bgcolor="#FF99FF">OQ</th>
            <th colspan="1" bgcolor="#FFFF00">UQ</th>
            <th colspan="1" bgcolor="#0099CC">CQ</th>
          </tr>
          <!--<tr>-->
          <!--    <th width="7%">Crt</th>-->
          <!--    <th width="7%">Pcs</th>-->
          <!--    <th width="7%">Crt</th>-->
          <!--    <th width="8%">Pcs</th>-->
          <!--    <th width="4%">Crt</th>-->
          <!--    <th width="5%">Pcs</th>-->
          <!--    </tr>-->
          <? while($row=mysqli_fetch_object($res)){
              $bg++;
            	if($row->gift_on_item==1096000100011491&&$row->item_id!=1096000100011499)
            	$gift_pack_size = $row->pkt_size;
            	if($row->gift_on_item==1096000100011491&&$row->item_id!=1096000100011498)
            	$gift_pack_size = $row->pkt_size;
            	if($row->gift_on_item==1096000100011491&&$row->item_id!=1096000100011492)
            	$gift_pack_size = $row->pkt_size;
		  ?>
          
        <tr bgcolor="<? if($row->gift_on_item==1096000100011491) echo 'yellow'; else {if(($bg%2)==1) echo '#FFEAFF'; else echo '#DDFFF9';} ?>" >
            <td><?=++$ss;?></td>

<input type="hidden" name="item_fg_<?=$row->id?>" id="item_fg_<?=$row->id?>" value="<?=$row->finish_goods_code?>" />
<input type="hidden" name="pkt_size_<?=$row->id?>" id="pkt_size_<?=$row->id?>" value="<?=$row->pkt_size?>" />
            
            <td><?=$row->finish_goods_code?>-<?=$row->item_name?><? if($row->gift_on_item>0) echo '[GIFT]'; ?></td>
    		<td><?=number_format($row->unit_price, 2, '.', '');?>
    		<input type="hidden" name="unit_price_<?=$row->id?>" id="unit_price_<?=$row->id?>" value="<?=$row->unit_price?>" />
    		<input type="hidden" name="total_amt_<?=$row->id?>" id="total_amt_<?=$row->id?>" value="<?=$row->total_amt?>" />
    		</td>
              <!--<td align="center"><? $row->pkt_unit?></td>-->
        <td align="center"><? echo $row->total_unit; //=$row->dist_unit;  ?></td>

            
        <!-- ------------------------ Undel Qty ------------------------- -->
        <?
       $del_qty = $delevery_qty[$row->id]; $stock_qty = $stock[$row->item_id];
        // if($stock_qty>0) echo $stock_pkt = (int)($stock_qty/$row->pkt_size); else {echo $stock_pkt =0;$stock_qty=0;}
        ?>
           <!--         <td align="center"><? $undel_qty=($row->total_unit-$del_qty); echo $undel_pkt = (int)($undel_qty/$row->pkt_size);?>-->
           <!--         <input type="hidden" name="undelpkt_<?=$row->id?>" id="undelpkt_<?=$row->id?>" value="<?=$undel_pkt?>" />-->
        			<!--<input type="hidden" name="undelqty_<?=$row->id?>" id="undelqty_<?=$row->id?>" value="<?=$undel_qty?>" />-->
        			<!--</td>-->
            <td align="center"><? echo $undel_dist =$undel_qty; //  (int)($undel_qty%$row->pkt_size);?>
                <input type="hidden" name="undeldist_<?=$row->id?>" id="undeldist_<?=$row->id?>" value="<?=$undel_dist?>" />
            </td>
            
            
   <!--     <td align="center" bgcolor="#66FF66" style="text-align:center">-->
   <!--     <? if($undel_pkt>0){ ?>-->
			<!--	<script language="javascript"> active_ids.push('chalan_<?=$row->id?>'); active_ids2.push('chalan2_<?=$row->id?>'); active_ids3.push('total_amt_<?=$row->id?>');</script>-->
			<!--	<input type="text" name="chalan_<?=$row->id?>" id="chalan_<?=$row->id?>" required style="width:40px; float:none" onchange="cal(<?=$row->id?>)" />-->
			<!--	<? } else echo 'Done';?>-->
			<!--</td>-->
		  
            <td align="center" bgcolor="#6699FF" style="text-align:center">
			  <? if($undel_qty>0){ $cow++; ?>
                <input name="chalan2_<?=$row->id?>" type="number" id="chalan2_<?=$row->id?>" style="width:60px; float:none" value="<?=$undel_qty;?>" required="required" onchange="cal(<?=$row->id?>)" />
                <? } else echo 'Done';?>
            </td>
                
                
        </tr>
          <? } // end while ?>
		    
		<!--<tr>-->
  <!--          <td>&nbsp;</td>-->
  <!--          <td>&nbsp;</td>-->
  <!--          <td><div id="giftdiv"></div></td>-->
  <!--          <td><div id="amtdiv"></div></td>-->
  <!--          <td colspan="6"><span style="text-align:center"><input type="hidden" name="gift_pack_size" id="gift_pack_size" value="<?=$gift_pack_size?>" /></span></td>-->
  <!--          <td align="center" bgcolor="#FFFFFF" style="text-align:center"><div id="crtdiv"></div></td>-->
  <!--          <td align="center" bgcolor="#FFFFFF" style="text-align:center"><div id="pcsdiv"></div></td>-->
  <!--      </tr>-->
        
        
      </tbody>
      </table>
      </div>
      </td>
    </tr>
  </table>
  
  <br/>  
  
  
  
  
  
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
<? } ?>


<tr>
<td align="center"><button name="delete" type="submit" class="btn btn-danger">Cancel Order</button>
<input  name="do_no" type="hidden" id="do_no" value="<?=$$unique_master?>"/>

<input  name="dealer_code" type="hidden" id="dealer_code" value="<?=$dealer->dealer_code;?>"/></td>
<td align="center"><button name="confirmm" type="submit" class="btn btn-success">Confirm Delivery</button></td>
</tr>


</table>
</form>  
  
<? } // end if unique master ?>  
  
  
  
  
  
  
  
  
  
            


</div>
<!-- main page content ends -->


</main>
<!-- Page ends-->

<?php

include 'inc/footer.php';

?>  
