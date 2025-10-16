<?php
//
//

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Spare Parts Opening';

//do_calander('#odate');


create_combobox('item_id');
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

var strURL="spare_parts_opening_balance_ajax.php?item_id="+item_id+"&oqty="+oqty+"&orate="+orate+"&odate="+odate+"&flag="+flag;

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

<style>
/*
.ui-state-default a, .ui-state-default a:link, .ui-state-default a:visited, a.ui-button, a:link.ui-button, a:visited.ui-button, .ui-button {
    color: #454545;
    text-decoration: none;
    display: none;
}*/


div.form-container_large input {
    width: 280px;
    height: 38px;
    border-radius: 0px !important;
}



</style>


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
    <td bgcolor="#FF9966"><input name="odate" type="text" id="odate" style="width:100px;" value="2021-04-13"  readonly=""/></td>
    <td bgcolor="#FF9966">&nbsp;</td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FF9966"><strong>Sub Group: </strong></td>
    <td bgcolor="#FF9966">
	<select name="sub_group" id="sub_group">
	
	<option></option>
	
<? foreign_relation('item_sub_group','sub_group_id','sub_group_name',$_POST['sub_group'],'group_id="1000000000"');?>
    </select>    </td>
    <td bgcolor="#FF9966"><strong>
      <input type="submit" name="submitit" id="submitit" value="Open Balance" style="width:170px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
    </strong></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FF9966"><strong>Item Name: </strong></td>
    <td bgcolor="#FF9966">
	
	<select name="item_id" id="item_id">
	
	<option></option>
	
		<? foreign_relation('item_info','item_id','item_name',$_POST['item_id'],'product_type="Spare Parts"');?>
    </select>
	
	</td>
    <td bgcolor="#FF9966">&nbsp;</td>
  </tr>
</table>

<?
if($_POST['odate']>0){
?>
<div class="tabledesign2" style="width:100%">
<table width="100%" border="0" align="center" id="grp" cellpadding="0" cellspacing="0">
  <tr>
    <th><div align="center">Item Code </div></th>
    <th><div align="center">Item Name </div></th>
    <th>Unit</th>
    <th><div align="center">OQty</div></th>
    <th><div align="center">ORate</div></th>
    <th><div align="center">Action</div></th>
  </tr>
  <?
  
  	if($_POST['item_id']!='')
	$con=" and item_id='".$_POST['item_id']."' ";
	
	
	if($_POST['sub_group']!='')
	$con=" and sub_group_id='".$_POST['sub_group']."' ";
  
  $sql = "select * from item_info where product_type='Spare Parts' ".$con." ";
  $query = db_query($sql);
  while($data=mysqli_fetch_object($query)){$i++;
 
 
 
  ?>
  <tr bgcolor="<?=($i%2)?'#E8F3FF':'#fff';?>">
    <td><?=$data->item_id?></td>
    <td><?=$data->item_name?></td>
    <td><?=$data->unit_name?></td>
    <td><input name="oqty_<?=$data->item_id?>" id="oqty_<?=$data->item_id?>" type="text" size="10" maxlength="10" value="" style="width:100px;" /></td>
    <td><input name="orate_<?=$data->item_id?>" id="orate_<?=$data->item_id?>" type="text" size="10" maxlength="10" value="" style="width:80px;" />      </td>
    <td><span id="divi_<?=$data->item_id?>">
            
			  <input name="flag_<?=$data->item_id?>" type="hidden" id="flag_<?=$data->item_id?>" value="0" />
			  <input type="button" name="Button" value="Save"  onclick="update_value(<?=$data->item_id?>)" style="width:60px; height:30px;background-color:#66CC66"/>
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