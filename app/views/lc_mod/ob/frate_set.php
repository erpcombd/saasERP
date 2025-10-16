<?php
//
//
require "../../support/inc.all.php";
$title='Opening Balance';
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
var f_price=(document.getElementById('f_price_'+id).value)*1;
var d_price=(document.getElementById('d_price_'+id).value)*1;
var t_price=(document.getElementById('t_price_'+id).value)*1;
var m_price=(document.getElementById('m_price_'+id).value)*1; 

var strURL="frate_set_ajax.php?item_id="+item_id+"&f_price="+f_price+"&d_price="+d_price+"&t_price="+t_price+"&m_price="+m_price;

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

  <tr>
    <td align="right" bgcolor="#FF9966"><strong>Select Product Sub Group: </strong></td>
    <td bgcolor="#FF9966">
	<select name="sub_group" id="sub_group">
	
<?
foreign_relation('item_sub_group','sub_group_id','sub_group_name',$_POST['sub_group'],'sub_group_name="Finished Goods"');
?>
    </select>    </td>
    <td bgcolor="#FF9966"><strong>
      <input type="submit" name="submitit" id="submitit" value="Rate Set" style="width:170px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
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
    <th><div align="center">FC</div></th>
    <th><div align="center">Item Name </div></th>
    <th>PKU</th>
    <th><div align="center">FRate</div></th>
    <th>DPRate</th>
    <th><div align="center">TPRate</div></th>
    <th><div align="center">MRPRate</div></th>
    <th><div align="center">Action</div></th>
  </tr>
  <?
  $sql = "select * from item_info where finish_goods_code>0 and finish_goods_code<5000 ";
  $query = db_query($sql);
  while($data=mysqli_fetch_object($query)){$i++;
  $f_price=$data->f_price;
  $d_price=$data->d_price;
  $t_price=$data->t_price;
  $m_price=$data->m_price;
  
  ?>
  <tr bgcolor="<?=($i%2)?'#E8F3FF':'#fff';?>">
    <td><?=($data->finish_goods_code>0)?$data->finish_goods_code:'';?></td>
    <td><?=$data->item_name?></td>
    <td><?=$data->pack_unit?></td>
    <td><input name="f_price_<?=$data->item_id?>" id="f_price_<?=$data->item_id?>" type="text" size="10" maxlength="10" value="<?=$f_price;?>" style="width:60px;" /></td>
    <td><input name="d_price_<?=$data->item_id?>" id="d_price_<?=$data->item_id?>" type="text" size="10" maxlength="10" value="<?=$d_price;?>" style="width:60px;" /></td>
    <td><input name="t_price_<?=$data->item_id?>" id="t_price_<?=$data->item_id?>" type="text" size="10" maxlength="10" value="<?=$t_price;?>" style="width:60px;" /></td>
    <td><input name="m_price_<?=$data->item_id?>" id="m_price_<?=$data->item_id?>" type="text" size="10" maxlength="10" value="<?=$m_price;?>" style="width:60px;" /></td>
    <td><span id="divi_<?=$data->item_id?>">
            <? 
			  if(($op->id>0)&&($op->id==$info->id))
			  {?>
			  <input name="flag_<?=$data->item_id?>" type="hidden" id="flag_<?=$data->item_id?>" value="1" />
			  <input type="button" name="Button" value="Edit"  onclick="update_value(<?=$data->item_id?>)" style="width:40px; height:20px; background-color:#FF3366"/><?
			  }
			  elseif($info->id<1)
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
//
//
require_once SERVER_CORE."routing/layout.bottom.php";
?>