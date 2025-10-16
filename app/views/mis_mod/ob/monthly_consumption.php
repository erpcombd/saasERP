<?php
session_start();
ob_start();
error_reporting(0);

require "../../support/inc.all.php";
$title='Adjustment of Opening Balance';

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
function group_check(id,pp)
{
if(id!=''){
getData2('group_ajax.php', 'sub_group_div',id,'');
}
}
	function update_value(id)

	{

var id=id; // Rent
var oqty=(document.getElementById('oqty_'+id).value)*1; 
var item_price=(document.getElementById('item_price_'+id).value)*1; 
var lot_no=(document.getElementById('lot_no_'+id).value); 
var vendor_id=(document.getElementById('vendor_id_'+id).value); 
var flag=(document.getElementById('flag_'+id).value); 

var strURL="monthly_consumption_ajax.php?id="+id+"&oqty="+oqty+"&item_price="+item_price+"&lot_no="+lot_no+"&vendor_id="+vendor_id+"&flag="+flag;

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
<div class="form-container_large">
<form action="" method="post" name="codz" id="codz">
<table width="80%" border="0" align="center">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?
  if(isset($_POST['odate']))
  $odate = $_SESSION['odate'] = $_POST['odate'];
  elseif($_SESSION['odate']!='')
  $odate = $_SESSION['odate'];
  else
  $odate = date('Y-m-d');
  
  ?>
  <tr>
    <td align="right" bgcolor="#FF9966"><strong>Opening Date: </strong></td>
    <td bgcolor="#FF9966"><input name="odate" type="text" id="odate" style="width:107px;" value="<?=$odate?>" /></td>
    <td bgcolor="#FF9966">&nbsp;</td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FF9966"><strong>Group</strong>:</td>
    <td bgcolor="#FF9966"><select name="group" id="group" onchange="group_check(this.value,1)"  style="width:250px;height:23px;" required>
	<option></option>
      <?
foreign_relation('item_group','group_id','group_name',$_POST['group'],'1 and  group_type="RAW" order by status');
?>
        </select></td>
    <td bgcolor="#FF9966"><strong>
      <input type="submit" name="submitit" id="submitit" value="Open Item" style="width:170px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
    </strong></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FF9966"><strong>Sub Group: </strong></td>
    <td bgcolor="#FF9966"><div id="sub_group_div">
	<select name="sub_group" id="sub_group"  style="width:250px;height:23px;">
	
<?
if($_POST['group']>0) {$gcon = 'group_id = '.$_POST['group'];
foreign_relation('item_sub_group','sub_group_id','sub_group_name',$_POST['sub_group'],$gcon);}
?>
    </select>    </div></td>
    <td bgcolor="#FF9966">&nbsp;</td>
  </tr>
</table>
<br /><br />
<?
if($_POST['sub_group']>0){
?>
<div class="tabledesign2" style="width:100%">
<table width="100%" border="0" align="center" id="grp" cellpadding="0" cellspacing="0">
  <tr>
    <th width="13%"><div align="center">Item Code </div></th>
    <th width="12%"><div align="center">Item Name </div></th>
    <th width="9%">Description</th>
    <th width="6%">Unit</th>
    <th width="12%"><div align="center">Supplier</div></th>
    <th width="16%">Lot</th>
    <th width="13%"><div align="center">Rate</div></th>
    <th width="13%"><div align="center">New Stock </div></th>
    <th width="6%"><div align="center">Action</div></th>
  </tr>
<?


$sql = "select j.*,i.* from item_info i, journal_item j where i.item_id=j.item_id and i.sub_group_id=".$_POST['sub_group']." and j.tr_from like '%Opening%'  order by j.id";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){$i++;
  ?>
  <tr bgcolor="<?=($i%2)?'#E8F3FF':'#fff';?>">
    <td><?=$data->finish_goods_code?></td>
    <td><?=$data->item_name?></td>
    <td><?=$data->item_description?></td>
    <td><?=$data->unit_name?></td>
    <td>
        <select name="vendor_id_<?=$data->id?>" id="vendor_id_<?=$data->id?>">
		<option></option>
		<? foreign_relation('vendor','vendor_id','vendor_name',$data->vendor_id);?>
		</select>
        </td>
    <td><input type="text" name="lot_no_<?=$data->id?>" id="lot_no_<?=$data->id?>" value="<?=$data->lot_no?>" style="width:100px;"/></td>
    <td><input name="item_price_<?=$data->id?>" id="item_price_<?=$data->id?>" value="<?=$data->item_price?>" style="width:100px;"/></td>
    <td><input name="oqty_<?=$data->id?>" id="oqty_<?=$data->id?>" type="text" size="10" maxlength="10" value="<?=$data->item_in?>" style="width:99px;" /></td>
    <td><span id="divi_<?=$data->id?>">

			  <input name="flag_<?=$data->id?>" type="hidden" id="flag_<?=$data->id?>" value="0" />
			  <input type="button" name="Button" value="Save"  onclick="update_value(<?=$data->id?>)" style="width:43px; height:27px;background-color:#66CC66"/>
          </span>&nbsp;</td>
  </tr>
  <? }?>
</table>
</div>
<? }?>
<p>&nbsp;</p>
</form>
</div>

<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>