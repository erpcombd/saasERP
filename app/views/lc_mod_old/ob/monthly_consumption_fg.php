<?php
//
//
error_reporting(0);

require "../../support/inc.all.php";
$title='Opening Stock Entry';

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

var item_id=id; // Rent
var oqty=(document.getElementById('oqty_'+id).value)*1; 
var orate=(document.getElementById('orate_'+id).value)*1; 
var orate1=(document.getElementById('orate1_'+id).value)*1; 
var sr_no=(document.getElementById('sr_no_'+id).value); 
var odate=(document.getElementById('odate').value); 
var flag=(document.getElementById('flag_'+id).value); 

var strURL="monthly_consumption_ajax.php?item_id="+item_id+"&oqty="+oqty+"&orate="+orate+"&orate1="+orate1+"&odate="+odate+"&sr_no="+sr_no+"&flag="+flag;

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
    <td bgcolor="#FF9966"><select name="group" id="group" onchange="group_check(this.value,1)"  style="width:250px; height:25px;" required>
	<option></option>
      <?
foreign_relation('item_group','group_id','group_name',$_POST['group'],'1');
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
    <th><div align="center">Item Code </div></th>
    <th><div align="center">Item Name </div></th>
    <th>Description</th>
    <th>Unit</th>
    <th><div align="center">Pre Stock </div></th>
    <th>Lot</th>
    <th><div align="center">Rate/Unit</div></th>
    <th><div align="center">New Stock </div></th>
    <th><div align="center">Action</div></th>
  </tr>
<?
$sql = "select sum(item_in)-sum(item_ex) qty, i.item_id from journal_item j, item_info i where i.item_id=j.item_id and  j.warehouse_id='".$_SESSION['user']['depot']."' and j.ji_date<='".$_POST['odate']."' and j.tr_from!='OPENING-1910' and sub_group_id=".$_POST['sub_group']." group by i.item_id ";
$query = db_query($sql);
while($data = mysqli_fetch_object($query)){
$pre_stock[$data->item_id] = $data->qty;
}

$sql = "select item_price,item_in-item_ex as unit_qty,i.item_id,j.sr_no from journal_item j, item_info i where i.item_id=j.item_id and  j.warehouse_id='".$_SESSION['user']['depot']."' and j.ji_date='".$_POST['odate']."' and j.tr_from='OPENING-1910' and sub_group_id=".$_POST['sub_group']." group by i.item_id ";

$query = db_query($sql);
while($data = mysqli_fetch_object($query)){
$adj[$data->item_id] = $data->unit_qty;
$adj_rate[$data->item_id] = $data->item_price;
$sr_no[$data->item_id] = $data->sr_no;
$flag[$data->item_id] = 1;
}

$sql = "select * from item_info where sub_group_id=".$_POST['sub_group']."   order by finish_goods_code,item_name";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){$i++;
  ?>
  <tr bgcolor="<?=($i%2)?'#E8F3FF':'#fff';?>">
    <td><?=$data->finish_goods_code?></td>
    <td><?=$data->item_name?></td>
    <td><?=$data->item_description?></td>
    <td><?=$data->unit_name?></td>
    <td><?=$pre_stock[$data->item_id];?>
      <?=$adj[$data->item_id];?>
      <input type="hidden" name="orate_<?=$data->item_id?>" id="orate_<?=$data->item_id?>" value="<?=($pre_stock[$data->item_id])?>" style="width:70px;"/></td>
    <td><input name="sr_no_<?=$data->item_id?>" id="sr_no_<?=$data->item_id?>" value="<?=$sr_no[$data->item_id]?>" style="width:70px;"/></td>
    <td><input name="orate1_<?=$data->item_id?>" id="orate1_<?=$data->item_id?>" value="<?=number_format($adj_rate[$data->item_id],4);?>" style="width:70px;"/></td>
<td><input name="oqty_<?=$data->item_id?>" id="oqty_<?=$data->item_id?>" type="text" size="10" maxlength="10" value="<?=($pre_stock[$data->item_id]+$adj[$data->item_id])?>" style="width:99px;" /></td>
    <td><span id="divi_<?=$data->item_id?>">
            <? if($flag[$data->item_id]>0)
			  {?>
			  <input name="flag_<?=$data->item_id?>" type="hidden" id="flag_<?=$data->item_id?>" value="1" />
			  <input type="button" name="Button" value="Edit"  onclick="update_value(<?=$data->item_id?>)" style="width:43px; height:27px; background-color:#FF3366"/><?
			  }
			  else
			  {
			  ?>
			  <input name="flag_<?=$data->item_id?>" type="hidden" id="flag_<?=$data->item_id?>" value="0" />
			  <input type="button" name="Button" value="Save"  onclick="update_value(<?=$data->item_id?>)" style="width:43px; height:27px;background-color:#66CC66"/><? }?>
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
//
//
require_once SERVER_CORE."routing/layout.bottom.php";
?>