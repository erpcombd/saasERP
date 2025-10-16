<?php
session_start();
ob_start();
error_reporting(0);
ini_set('max_input_vars','20000' );

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

	function update_value(id)

	{

var item_id=id; // Rent

var orate=(document.getElementById('orate_'+id).value)*1;  
var odate=(document.getElementById('odate').value); 
var flag=(document.getElementById('flag_'+id).value); 

var cqty=(document.getElementById('cqty_'+id).value)*1; 
var pqty=(document.getElementById('pqty_'+id).value)*1; 



var strURL="monthly_adjustment_fg_ajax.php?item_id="+item_id+"&cqty="+cqty+"&orate="+orate+"&pqty="+pqty+"&odate="+odate+"&flag="+flag;

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
  if(isset($_POST['odate'])){
  $odate = $_SESSION['odate'] = $_POST['odate'];
  $sodate = date('ymd',strtotime($odate));
  }
  ?>
  <tr>
    <td align="right" bgcolor="#FF9966"><strong>Audit Date: </strong></td>
    <td bgcolor="#FF9966"><input name="odate" type="text" id="odate" style="width:100px;" value="<?=$odate?>" /></td>
    <td bgcolor="#FF9966">&nbsp;</td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FF9966"><strong>Select Product Sub Group: </strong></td>
    <td bgcolor="#FF9966">
	<select name="sub_group" id="sub_group">
	
<?
foreign_relation('item_sub_group','sub_group_id','sub_group_name',$_POST['sub_group'],'1');
?>
    </select>    </td>
    <td bgcolor="#FF9966"><strong>
      <input type="submit" name="submitit" id="submitit" value="Open Item" style="width:170px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
    </strong></td>
  </tr>
</table>
<br /><br />
<?
if($_POST['sub_group']>0){
?>
<div class="tabledesign2" style="width:100%">
<table width="100%" border="0" align="center" id="grp" cellpadding="0" cellspacing="0">
  <tr>
    <th rowspan="2"><div align="center">Item Code </div></th>
    <th rowspan="2"><div align="center">Item Name </div></th>
    <th rowspan="2">Unit</th>
    <th rowspan="2"><div align="center">Price</div></th>
    <th colspan="2"><div align="center">New Stock </div></th>
    <th rowspan="2"><div align="center">Action</div></th>
  </tr>
  <tr>
    <th>PCS IN </th>
    <th>PCS OUT </th>
  </tr>
<?
//$sql = "select sum(item_in)-sum(item_ex) qty, i.item_id from journal_item j, item_info i where i.item_id=j.item_id and  j.warehouse_id='".$_SESSION['user']['depot']."' and j.ji_date<='".$_POST['odate']."' and j.tr_from!='Adj-1809' and sub_group_id=".$_POST['sub_group']." group by i.item_id ";
//$query = db_query($sql);
//while($data = mysqli_fetch_object($query)){
//$pre_stock[$data->item_id] = $data->qty;
//}
$tr_from = 'Adjust';

$sql = "select item_price,j.item_in,j.item_ex,i.item_id 
from journal_item j, item_info i 
where i.item_id=j.item_id 
and  j.warehouse_id='".$_SESSION['user']['depot']."'  and j.tr_from='".$tr_from."' and sub_group_id=".$_POST['sub_group']." group by i.item_id ";

$query = db_query($sql);
while($data = mysqli_fetch_object($query)){
$item_in[$data->item_id] = $data->item_in;
$item_ex[$data->item_id] = $data->item_ex;
$flag[$data->item_id] = 1;
}

if($_POST['sub_group']=='1096000100010000'){
$sql = "select * from item_info where sub_group_id=".$_POST['sub_group']." and finish_goods_code >0
and finish_goods_code not in (2000,2001,2002,2003)
 order by finish_goods_code";
}else 
{
$sql = "select * from item_info where sub_group_id=".$_POST['sub_group']."   order by finish_goods_code,item_name";
}

//$sql = "select * from item_info where sub_group_id=".$_POST['sub_group']."   order by finish_goods_code,item_name";

$query = db_query($sql);
while($data=mysqli_fetch_object($query)){$i++;
  ?>
  <tr bgcolor="<?=($i%2)?'#E8F3FF':'#fff';?>">
    <td><?=$data->item_id?></td>
    <td><?=$data->item_name?></td>
    <td><?=$data->unit_name?></td>
    <td>
<input name="orate_<?=$data->item_id?>" id="orate_<?=$data->item_id?>" value="<?=$data->f_price?>" style="width:40px;"/>
<input type="hidden" name="orate_<?=$data->item_id?>2" id="orate_<?=$data->item_id?>2" value="<?=($pre_stock[$data->item_id])?>" style="width:70px;"/>
	  </td>
<td>
<input name="cqty_<?=$data->item_id?>" id="cqty_<?=$data->item_id?>" type="text" value="<?=(int)($item_in[$data->item_id])?>" style="width:40px;" /></td>
    
    <td>
<input name="pqty_<?=$data->item_id?>" id="pqty_<?=$data->item_id?>" type="text" value="<?=(int)($item_ex[$data->item_id])?>" style="width:40px;" /></td>
    <td><span id="divi_<?=$data->item_id?>">
            <? if($flag[$data->item_id]>0)
			  {?>
			  <input name="flag_<?=$data->item_id?>" type="hidden" id="flag_<?=$data->item_id?>" value="1" />
			  <input type="button" name="Button" value="Edit"  onclick="update_value(<?=$data->item_id?>)" style="width:40px; height:20px; background-color:#FF3366"/><?
			  }
			  else
			  {
			  ?>
			  <input name="flag_<?=$data->item_id?>" type="hidden" id="flag_<?=$data->item_id?>" value="0" />
			  <input type="button" name="Button" value="Save"  onclick="update_value(<?=$data->item_id?>)" style="width:40px; height:20px;background-color:#66CC66"/><? }?>
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