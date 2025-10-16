<?php
require_once "../../../assets/template/layout.top.php";
$title='Gift Offer';

do_calander('#start_date');
do_calander('#end_date');

$table_master='pos_gift_offer';
$unique_master='id';

if(prevent_multi_submit()){
if(isset($_POST['new']))
{
		$crud   = new crud($table_master);
		$item=explode('#>',$_POST['item_id']);
		$_POST['item_id']=find_a_field('item_info','item_id','finish_goods_code="'.$item[1].'"');
		
		$g=explode('#>',$_POST['gift_id']);
		$_POST['gift_id']=find_a_field('item_info','item_id','finish_goods_code="'.$g[1].'"');
		
		$_POST['entry_at']=date('Y-m-d H:i:s');
		$_POST['entry_by']=$_SESSION['user']['id'];
		$_POST['warehouse_id'] = $_SESSION['user']['depot'];
		//if($_POST['flag']<1){
		$$unique_master=$crud->insert();
		unset($$unique_master);
		unset($_POST);
		$type=1;
		$msg='Work Order Initialized. (Demand Order No-'.$$unique_master.')';
		//}
		/*else {
		$crud->update($unique_master);
		$type=1;
		$msg='Successfully Updated.';
		}*/
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
		while (list($key, $value)=each($data))
		{ $$key=$value;}
		
}

if($_GET['del']>0)
{
		/*$crud   = new crud($table_master);
		$condition=$unique_master."=".$_GET['del'];		
		$crud->delete_all($condition);
		$type=1;
		$msg='Successfully Deleted.';*/
		$update = 'update pos_gift_offer set status="Inactive" where id="'.$_GET['del'].'"';
		mysql_query($update);
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
$query_i=mysql_query($sql_i);
while($is=mysql_fetch_object($query_i))
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

<? include("../../../assets/css/New_them_css_custome.css")?>
<div class="form-container_large">
<form action="" method="post" name="codz" id="codz">

<div class="container-fluid bg-form-titel">
			<fieldset>
            <div class="row">

                <!--left form-->
                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <div class="container n-form2">
                        <div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Offer ID :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
        <input class="form-control"  name="id" type="text" id="id" value="<? if($_POST['flag']==1) echo $$unique_master; else echo (find_a_field($table_master,'max('.$unique_master.')','1')+1);?>"/>
                            </div>
                        </div>



						<div class="form-group row m-0 pb-1">

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Promotional Offer Name :</label>

							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <input class="form-control"   name="offer_name" type="text" id="offer_name" value=""/>
                            </div>
                        </div>


                      <!--  <div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Group For :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
									<select id="group_for" name="group_for" class="form-control" >
									<option value="A" <?=($group_for=='A')?'selected':''?>>A</option>
									<option value="B" <?=($group_for=='B')?'selected':''?>>B</option>
									<option value="C" <?=($group_for=='C')?'selected':''?>>C</option>
									</select>
                            </div>
                        </div>-->
						
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Start Date :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
							<input class="form-control" name="start_date" type="text" id="start_date" value=""/>
                                
									  
                            </div>
                        </div>

                        <div class="form-group row m-0 pb-1">

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">End Date:</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <input class="form-control"   name="end_date" type="text" id="end_date" value=""/>
								 
                            </div>
                        </div>


                    </div>



                </div>

                <!--Right form-->
                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <div class="container n-form2">

                        <div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Main Item Name :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                
								<input class="form-control"  name="item_id" type="text" id="item_id" value=""/>

                            </div>
                        </div>

                        <div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">On Unit Qty :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                        <input class="form-control"  name="item_qty" type="text" id="item_qty" value=""/>
								

                            </div>
                        </div>
						
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Gift Item Name : </label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                
								<input class="form-control"  name="gift_id" type="text" id="gift_id" value=""/>

                            </div>
                        </div>
						
						                        <div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Gift Unit Qty :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                
								<input class="form-control" name="gift_qty" type="text" id="gift_qty" value=""/>

                            </div>
                        </div>



                    </div>



                </div>


            </div>
		</fieldset>
            <div class="n-form-btn-class">
				
    <? if($$unique_master>0) {?>
<input name="new" type="submit" class="btn1 btn1-bg-update" value="Update Demand Order"/>
<input name="flag" id="flag" type="hidden" value="1" />
<? }else{?>
<input name="new" type="submit" class="btn1 btn1-bg-submit" value="Initiate Demand Order" />
<input name="flag" id="flag" type="hidden" value="0" />
<? }?>

		            </div>
        </div>

</form>



<form action="?req_id=<?=$req_id?>" method="post" name="cloud" id="cloud"><br />
  <? 
$res='select a.id,a.offer_name,a.group_for as Grp,b.finish_goods_code as i_code,b.item_name,a.item_qty,c.finish_goods_code as g_code,c.item_name as gift_name,a.gift_qty,a.start_date,a.end_date from pos_gift_offer a,item_info b,item_info c where b.item_id=a.item_id and c.item_id=a.gift_id and a.status="Active" and a.warehouse_id="'.$_SESSION['user']['depot'].'"';
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
  </table></form>

</div>

<?
require_once "../../../assets/template/layout.bottom.php";
?>