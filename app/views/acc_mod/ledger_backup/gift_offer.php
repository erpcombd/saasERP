<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Gift Offer';

do_calander('#start_date');
do_calander('#end_date');

$table_master='sale_gift_offer_acc';
$unique_master='id';
$page = $target_url = 'gift_offer.php';

if(isset($_POST['new']))
{if(prevent_multi_submit()){
		$crud   = new crud($table_master);
		$item=explode('#>',$_POST['item_id']);
		$_POST['item_id']=find_a_field('item_info','item_id','finish_goods_code='.$item[1]);
		
		$g=explode('#>',$_POST['gift_id']);
		$_POST['gift_id']=find_a_field('item_info','item_id','finish_goods_code='.$g[1]);
		
		if($g[1]==2000)
		$_POST['gift_qty']=find_a_field('item_info','d_price','finish_goods_code='.$item[1])*$_POST['gift_qty'];

		
		$_POST['entry_at']=date('Y-m-d h:s:i');
		$_POST['entry_by']=$_SESSION['user']['id'];
		if($_POST['flag']<1){
		$$unique_master=$crud->insert();
		unset($$unique_master);
		$type=1;
		$msg='Work Order Initialized. (Demand Order No-'.$$unique_master.')';
		}
		else {
		$crud->update($unique_master);
		$type=1;
		$msg='Successfully Updated.';}
}
else
{
	$type=0;
	$msg='Data Re-Submit Error!';
}
}

if($_GET[$unique_master]>0) $$unique_master = $_GET[$unique_master];
if($$unique_master>0)
{
		$condition=$unique_master."=".$$unique_master;
		$data=db_fetch_object($table_master,$condition);
		foreach ($data as $key => $value)
		{ $$key=$value;}
		
}

if($_GET['del']>0)
{
		$crud   = new crud($table_master);
		$condition=$unique_master."=".$_GET['del'];		
		$crud->delete_all($condition);
		$type=1;
		$msg='Successfully Deleted.';
}

$dealer = find_all_field('dealer_info','','dealer_code='.$dealer_code);

auto_complete_from_db('item_info','item_name','concat(item_name,"#>",finish_goods_code)','product_nature="Salable"','item_id');

auto_complete_from_db('item_info','item_name','concat(item_name,"#>",finish_goods_code)','product_nature="Salable"','gift_id');
?>
<script language="javascript">
function count()
{
if(document.getElementById('pkt_unit').value!=''){
var pkt_unit = ((document.getElementById('pkt_unit').value)*1);
var dist_unit = ((document.getElementById('dist_unit').value)*1);
var pkt_size = ((document.getElementById('pkt_size').value)*1);
var total_unit = (pkt_unit*pkt_size)+dist_unit;
var unit_price = ((document.getElementById('unit_price').value)*1);
var total_amt  = (total_unit*unit_price);
document.getElementById('total_unit').value=total_unit;
document.getElementById('total_amt').value	= total_amt .toFixed(2);
}
else
document.getElementById('pkt_unit').focus();
}
</script>

<script language="javascript">
function custom(theUrl)
{
	window.open('<?=$target_url?>?<?=$unique_master?>='+theUrl);
}
</script>

<div class="form-container_large">
<form action="" method="post" name="codz" id="codz">
<table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td>
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td><label style="width:150px;">Offer ID : </label></td>
            <td><input style="width:155px;"  name="id" type="text" id="id" value="<? if($_POST['flag']==1) echo $$unique_master; else echo (find_a_field($table_master,'max('.$unique_master.')','1')+1);?>"/></td>
            </tr>
          <tr>
            <td><label style="width:150px;">Promotional Offer Name : </label></td>
            <td><input style="width:255px;"  name="offer_name" type="text" id="offer_name" value="<?=$_POST['offer_name']?>"/></td>
            </tr>
          <tr>
            <td><label style="width:150px;">Group For : </label></td>
            <td align="left"><select style="float:left" id="group_for" name="group_for">
              <option value="A" <?=($_POST['group_for']=='A')?'select style="float:left"ed':''?>>A</option>
              <option value="B" <?=($_POST['group_for']=='B')?'select style="float:left"ed':''?>>B</option>
              <option value="C" <?=($_POST['group_for']=='C')?'select style="float:left"ed':''?>>C</option>
              <option value="D" <?=($_POST['group_for']=='D')?'select style="float:left"ed':''?>>D</option>
			  <option value="E" <?=($_POST['group_for']=='E')?'select style="float:left"ed':''?>>E</option>
              <option value="M" <?=($_POST['group_for']=='M')?'select style="float:left"ed':''?>>M</option>
            </select style="float:left"></td>
          </tr>
          <tr>
            <td><label style="width:150px;">Start Date : </label></td>
            <td><input style="width:155px;"  name="start_date" type="text" id="start_date" value="<?=$_POST['start_date'];?>"/></td>
          </tr>
          <tr>
            <td><label style="width:150px;">End Date : </label></td>
            <td>              <input style="width:155px;"  name="end_date" type="text" id="end_date" value="<?=$_POST['end_date'];?>"/>            </td>
          </tr>
          <tr>
            <td><label style="width:150px;">Product Item Name : </label></td>
            <td><input style="width:355px;"  name="item_id" type="text" id="item_id" value="<?=$item_id?>"/></td>
          </tr>
          <tr>
            <td><label style="width:150px;">On Unit Qty : </label></td>
            <td><input style="width:155px;"  name="item_qty" type="text" id="item_qty" value="<?=$item_qty?>"/></td>
          </tr>
          <tr>
            <td><label style="width:150px;">Gift Item Name : </label></td>
            <td><input style="width:355px;"  name="gift_id" type="text" id="gift_id" value="<?=$gift_id?>"/></td>
          </tr>
          <tr>
            <td><label style="width:150px;">Gift Unit Qty : </label></td>
            <td><input style="width:155px;"  name="gift_qty" type="text" id="gift_qty" value="<?=$gift_qty?>"/></td>
          </tr>
          <tr>
            <td><label style="width:150px;">Gift Type : </label></td>
            <td><select style="float:left" id="gift_type" name="gift_type">
              <option value="Cash" <?=($gift_type=='Cash')?'select style="float:left"ed':''?>>Cash</option>
              <option value="Non-Cash" <?=($gift_type=='Non-Cash')?'select style="float:left"ed':''?>>Non-Cash</option>
            </select style="float:left"></td>
          </tr>
          <tr>
            <td><label style="width:150px;">Calculation Mode : </label></td>
            <td><select style="float:left" id="calculation" name="calculation">
              <option value="Auto" <?=($calculation=='Auto')?'select style="float:left"ed':''?>>Auto</option>
              <option value="Manual" <?=($calculation=='Manual')?'select style="float:left"ed':''?>>Manual</option>
            </select style="float:left"></td>
          </tr>
          <tr>
            <td colspan="2"><div class="buttonrow" style="margin-left:240px;">
              <? if($$unique_master>0) {?>
 <!--             <input name="new" type="submit" class="btn1" value="Update Demand Order" style="width:200px; font-weight:bold; font-size:12px;" tabindex="12" />
              <input name="flag" id="flag" type="hidden" value="1" />-->
              <? }else{?>
              <input name="new" type="submit" class="btn1" value="Initiate Demand Order" style="width:200px; font-weight:bold; font-size:12px;" tabindex="12" />
              <input name="flag" id="flag" type="hidden" value="0" />
              <? }?>
            </div></td>
            </tr>
        </table>
       

    </td>
    </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</form>

<form action="?req_id=<?=$req_id?>" method="post" name="cloud" id="cloud"><br />
  <? 
$res='select a.id,a.offer_name,a.group_for as Grp,b.finish_goods_code as i_code,b.item_name,a.item_qty,c.finish_goods_code as g_code,c.item_name as gift_name,a.gift_qty,a.start_date,a.end_date from sale_gift_offer_acc a,item_info b,item_info c where b.item_id=a.item_id and c.item_id=a.gift_id and a.end_date>="'.date('Y-m-d').'" and a.group_for!="" order by id desc';
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">

    <tr>
      <td><div class="tabledesign2">
        
		<table width="100%" border="1" cellpadding="1" cellspacing="0" id="grp">
        <tbody>
        
        <tr><th>Id</th><th>Offer Name</th><th>Grp</th><th>I Code</th><th>Item Name</th><th>Item Qty</th><th>G Code</th><th>Gift Name</th><th>Gift Qty</th><th>Start Date</th><th>End Date</th></tr>
        <?
        $query = db_query($res);
		while($data=mysqli_fetch_row($query)){
		?>
        <tr onclick="custom(<?=$data[0]?>);"><td><?=$data[0]?></td><td><?=$data[1]?></td><td><?=$data[2]?></td><td><?=$data[3]?></td><td><?=$data[4]?></td><td><?=$data[5]?></td><td><?=$data[6]?></td><td><?=$data[7]?></td><td><?=$data[8]?></td><td><?=$data[9]?></td><td><?=$data[10]?></td></tr>
        <? }?>
        </tbody></table>
      </div></td>
    </tr>
	    	
	

				
    <tr>
     <td>

 </td>
    </tr>
  </table></form>

</div>

<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>