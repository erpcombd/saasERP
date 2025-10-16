<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Sales Order Entry';

do_calander('#odate');
?>
<script>

function getXMLHTTP() { //fuction to return the xml http object

		var xmlhttp=false;	

		try{

			xmlhttp=new XMLHttpRequest();

		}

		catch(e)	{		

			try{			

				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e){

				try{

				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");

				}

				catch(e1){

					xmlhttp=false;

				}

			}

		}

		 	

		return xmlhttp;

    }

	function update_value(id)

	{

var item_id=id; // Rent
var oqty=(document.getElementById('oqty_'+id).value)*1; 
var orate=(document.getElementById('orate_'+id).value)*1; 
var odate=(document.getElementById('odate').value); 
var flag=(document.getElementById('flag_'+id).value); 

var strURL="sales_order_ajax.php?item_id="+item_id+"&oqty="+oqty+"&orate="+orate+"&odate="+odate+"&flag="+flag;

		var req = getXMLHTTP();

		if (req) {

			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('divi_'+id).style.display='inline';
						document.getElementById('divi_'+id).innerHTML=req.responseText;						
					} else {
						alert("There was a problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}
			req.open("GET", strURL, true);
			req.send(null);
		}	

}

</script>
<script>
function calculation(id){
var yclsng=(document.getElementById('yclsng_'+id).value)*1; 
var ysale=(document.getElementById('ysale_'+id).value)*1; 
var tissue=(document.getElementById('tissue_'+id).value)*1; 
 
document.getElementById('tclsng_'+id).value=(yclsng+tissue)-ysale;
}
</script>
<div class="form-container_large">
<form action="" method="post" name="codz" id="codz">
<table  style="width:80%; margin:0 auto; border:0; text-align:center;">
  <tr>
    <td style="width:29%">&nbsp;</td>
    <td style="width:44%">&nbsp;</td>
    <td style="width:27%">&nbsp;</td>
  </tr>
  <?
  if(isset($_POST['odate'])){
  $odate = $_SESSION['odate'] = $_POST['odate'];}
  elseif($_SESSION['odate']!=''){
  $odate = $_SESSION['odate'];}
  else{
  $odate = date('Y-m-d');}
  
  ?>
  <tr>
    <td  style="background-color:#FF9966; text-align:right;"><strong> Date: </strong></td>
    <td style="background-color:#FF9966;"><input name="odate" type="text" id="odate" style="width:100px;" value="<?=$odate?>" /></td>
    <td style="background-color:#FF9966;">&nbsp;</td>
  </tr>
  <tr>
    <td  style="background-color:#FF9966; text-align:right;"><strong>Select SE: </strong></td>
    <td style="background-color:#FF9966;"><select name="se_name" id="se_name" style="width:220px;">
      <?
foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['se_name'],'use_type="PL" and master_warehouse_id='.$_SESSION['user']['depot'].' order by warehouse_id');
?>

    </select></td>
    <td style="background-color:#FF9966;">&nbsp;</td>
  </tr>
  <tr>
    <td  style="background-color:#FF9966;text-align:right;"><strong> Product Sub Group: </strong></td>
    <td style="background-colo:#FF9966;">
	<select name="sub_group" id="sub_group" style="width:220px;">
	
	<option></option>
	
<?
foreign_relation('item_sub_group','sub_group_id','sub_group_name',$_POST['sub_group'],'sub_group_name!="Finished Goods"');
?>
    </select>    </td>
    <td style="background-color:#FF9966;"><strong>
      <input type="submit" name="submitit" id="submitit" value="Open Item" style="width:150px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
    </strong></td>
  </tr>
</table>
<br /><br />
<?
if($_POST['se_name']>0){
?>
<div class="tabledesign2" style="width:100% margin:0 auto;">
<table  id="grp" style="width:100%; border:0; text-align:center; border-collapse:collapse; border-spacing:0; padding:0; text-align:center;">
  <tr>
    <th><div style="text-align:center;">Item Code </div></th>
    <th><div style="text-align:center;">Item Name </div></th>
    <th><div style="text-align:center;">FG</div></th>
    <th>Unit</th>
    <th><div style="text-align:center;">Y-Clsng</div></th>
    <th><div style="text-align:center;">Y-Sale</div></th>
    <th><div style="text-align:center;">T-Issue</div></th>
    <th><div style="text-align:center;">T-Clsng</div></th>
    <th><div style="text-align:center;">Action</div></th>
  </tr>
  <?
  if($_POST['sub_group']!=''){
  $con=" and sub_group_id=".$_POST['sub_group'];}
  
 $sql = "select * from item_info where 1".$con;
  $query = db_query($sql);
  while($data=mysqli_fetch_object($query)){$i++;
  $info = find_all_field('journal_item','','warehouse_id="'.$_SESSION['user']['depot'].'" and item_id = "'.$data->item_id.'" order by id desc');
  if($info->tr_from=='Opening'){
  $oqty=$info->final_stock;
  $orate=$info->final_price;
  }
  $op = find_all_field('journal_item','','warehouse_id="'.$_SESSION['user']['depot'].'" and item_id = "'.$data->item_id.'" and tr_from = "Opening" order by id desc');
  ?>
  <tr bgcolor="<?=($i%2)?'#E8F3FF':'#fff';?>">
    <td><?=$data->item_id?></td>
    <td><?=$data->item_name?></td>
    <td><?=($data->finish_goods_code>0)?$data->finish_goods_code:'';?></td>
    <td><?=$data->unit_name?></td>
    <td><input name="yclsng_<?=$data->item_id?>" id="yclsng_<?=$data->item_id?>" type="text" size="10" maxlength="10" value="<?=$op->final_stock;?>" style="width:60px;" onkeyup="calculation(<?=$data->item_id?>)" /></td>
    <td><input name="ysale_<?=$data->item_id?>" id="ysale_<?=$data->item_id?>" type="text" size="10" maxlength="10" value="<?=$op->final_stock;?>" style="width:60px;"  onkeyup="calculation(<?=$data->item_id?>)"/></td>
    <td><input name="tissue_<?=$data->item_id?>" id="tissue_<?=$data->item_id?>" type="text" size="10" maxlength="10" value="<?=$op->final_stock;?>" style="width:60px;"  onkeyup="calculation(<?=$data->item_id?>)"/></td>
    <td><input name="tclsng_<?=$data->item_id?>" id="tclsng_<?=$data->item_id?>" type="text" size="10" maxlength="10" value="<?=$data->f_price;?>" style="width:60px;"  onkeyup="calculation(<?=$data->item_id?>)"/>      </td>
    <td><span id="divi_<?=$data->item_id?>">
            <? 
			  if(($op->id>0)&&($op->id==$info->id))
			  {?>
			  <input name="flag_<?=$data->item_id?>" type="hidden" id="flag_<?=$data->item_id?>" value="1" />
			  <input type="button" name="Button" value="Edit"  onclick="update_value(<?=$data->item_id?>)" style="width:50px; height:20px; background-color:#FF3366"/><?
			  }
			  elseif($info->id<1)
			  {
			  ?>
			  <input name="flag_<?=$data->item_id?>" type="hidden" id="flag_<?=$data->item_id?>" value="0" />
			  <input type="button" name="Button" value="Save"  onclick="update_value(<?=$data->item_id?>)" style="width:50px; height:20px;background-color:#66CC66"/><? }?>
          </span>&nbsp;</td>
  </tr>
  <? }?>
</table>
</div>
<? }?>


	
		<p style="width:60%; float:left;">

   
	 	   <input name="confirm" type="submit" id="save" value="CONFIRM" style=" width:100px; height:25px; float:right; font-weight:700;" /> 	       
 	     
	
	</p>

</form>
</div>

<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>