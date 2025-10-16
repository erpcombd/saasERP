<?php

session_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
ob_start();

require "../../support/inc.all.php";

$title='Gift Offer';



do_calander('#start_date');

do_calander('#end_date');



$table_master='sale_gift_offer';

$unique_master='id';



if(prevent_multi_submit()){

if(isset($_POST['new']))

{

		$crud   = new crud($table_master);

		$item=explode('#>',$_POST['item_id']);

		$_POST['item_id']=find_a_field('item_info','item_id','finish_goods_code='.$item[1]);

		

		$g=explode('#>',$_POST['gift_id']);

		$_POST['gift_id']=find_a_field('item_info','item_id','finish_goods_code='.$g[1]);

		

		$_POST['entry_at']=date('Y-m-d H:i:s');

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

		$msg='Successfully Updated.';

		}

}



}

else

{

	$type=0;

	$msg='Data Re-Submit Error!';

}

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

function focuson(id) {

  if(document.getElementById('item').value=='')

  document.getElementById('item').focus();

  else

  document.getElementById(id).focus();

}



window.onload = function() {

if(document.getElementById("flag").value=='0')

  document.getElementById("remarks").focus();

  else

  document.getElementById("item").focus();

}

</script>

<script language="javascript">

function grp_check(id)

{

if(document.getElementById("item").value!=''){

var myCars=new Array();

myCars[0]="01815224424";

<?

$item_i = 1;

$sql_i='select finish_goods_code from item_info where sales_item_type="'.$dealer->product_group.'" and product_nature="Salable"';

$query_i=db_query($sql_i);

while($is=mysqli_fetch_object($query_i))

{

	echo 'myCars['.$item_i.']="'.$is->finish_goods_code.'";';

	$item_i++;

}

?>

var item_check=id;

var f=myCars.indexOf(item_check);

if(f>0)

getData2('do_ajax.php', 'do',document.getElementById("item").value,'<?=$dealer->depot;?>');

else

{

alert('Item is not Accessable');

document.getElementById("item").value='';

document.getElementById("item").focus();

}}

}

</script>

<div class="form-container_large">

<form action="" method="post" name="codz" id="codz">

<table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">

  <tr>

    <td><fieldset style="width:700px;">

      <div>

        <label style="width:150px;">Offer ID : </label>

        

        <input style="width:155px;"  name="id" type="text" id="id" value="<? if($_POST['flag']==1) echo $$unique_master; else echo (find_a_field($table_master,'max('.$unique_master.')','1')+1);?>"/>

        </div>

      <div>

        <label style="width:150px;">Promotional Offer Name : </label>

        <input style="width:255px;"  name="offer_name" type="text" id="offer_name" value=""/>

      </div>

      <div>

        <label style="width:150px;">Group For : </label>

        <select id="group_for" name="group_for">

        <option value="A" <?=($group_for=='A')?'selected':''?>>A</option>

        <option value="B" <?=($group_for=='B')?'selected':''?>>B</option>

        <option value="C" <?=($group_for=='C')?'selected':''?>>C</option>

        </select>

      </div>

      <div>

        <label style="width:150px;">Start Date :  </label>

        <input style="width:155px;"  name="start_date" type="text" id="start_date" value=""/>

        

        </div>

      <div>

        <label style="width:150px;">End Date : </label>

        <input style="width:155px;"  name="end_date" type="text" id="end_date" value=""/>

        </div>

      <div>

        <label style="width:150px;">Product Item Name : </label>

        <input style="width:355px;"  name="item_id" type="text" id="item_id" value=""/>

      </div>

      <div>

        <label style="width:150px;">On Unit Qty : </label>

        <input style="width:155px;"  name="item_qty" type="text" id="item_qty" value=""/>

      </div>

      <div>

        <label style="width:150px;">Gift Item Name : </label>

        <input style="width:355px;"  name="gift_id" type="text" id="gift_id" value=""/>

      </div>

      <div>

        <label style="width:150px;">Gift Unit Qty : </label>

        <input style="width:155px;"  name="gift_qty" type="text" id="gift_qty" value=""/>

      </div>

    </fieldset></td>

    </tr>

  <tr>

    <td><div class="buttonrow" style="margin-left:240px;">

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



<form action="?req_id=<?=$req_id?>" method="post" name="cloud" id="cloud"><br />

  <? 

$res='select a.id,a.offer_name,a.group_for as Grp,b.finish_goods_code as i_code,b.item_name,a.item_qty,c.finish_goods_code as g_code,c.item_name as gift_name,a.gift_qty,a.start_date,a.end_date from sale_gift_offer a,item_info b,item_info c where b.item_id=a.item_id and c.item_id=a.gift_id and a.group_for!=""';

?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">



    <tr>

      <td><div class="tabledesign2">

        <? 

echo link_report($res);

		?>



      </div></td>

    </tr>

	    	

	



				

    <tr>

     <td>



 </td>

    </tr>

  </table></form>



</div>



<?

$main_content=ob_get_contents();

ob_end_clean();

require_once SERVER_CORE."routing/layout.bottom.php";

?>