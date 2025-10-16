<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Entitlement Opening Balance';


do_calander("#odate");

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

var entitlement_value=(document.getElementById('entitlement_value_'+id).value)*1;


var odate=(document.getElementById('odate').value); 

var flag=(document.getElementById('flag_'+id).value); 


var strURL="entitlement_opening_balance_ajax.php?item_id="+item_id+"&entitlement_value="+entitlement_value+"&odate="+odate+"&flag="+flag;



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

    <td align="right" bgcolor="#FF9966"><strong>Opening Date: </strong></td>

    <td bgcolor="#FF9966"><input name="odate" type="text" id="odate" style="width:200px;" value="<?=$odate?>" required/></td>

    <td bgcolor="#FF9966">&nbsp;</td>

  </tr>

  <tr>

    <td align="right" bgcolor="#FF9966"><strong>Select Product Sub Group: </strong></td>

    <td bgcolor="#FF9966">

	<select name="sub_group" id="sub_group" required>
	
	<option></option>

	

<? foreign_relation('item_sub_group','sub_group_id','sub_group_name',$_POST['sub_group'],'1');?>

    </select>    </td>

    <td bgcolor="#FF9966"><strong>

      <input type="submit" name="submitit" id="submitit" value="Open Balance" style="width:170px; font-weight:bold; font-size:12px; height:30px; color:#090"/>

    </strong></td>

  </tr>

</table>

<br />

<?

if($_POST['sub_group']>0){

?>

<div class="tabledesign2" style="width:100%">

<table width="100%" border="0" align="center" id="grp" cellpadding="0" cellspacing="0">

  <tr>

    <th width="14%"><div align="center">Item Code </div></th>

    <th width="42%"><div align="center">Item Name </div></th>

    <th width="11%"><div align="center">Unit</div></th>

    <th width="16%"><div align="center">Entitlement Qty</div></th>

    <th width="17%"><div align="center">Action</div></th>
  </tr>

  <?

 $sql = "select item_id, entitlement_value from lc_entitlement where status='Opening' group by item_id";

  $query = db_query($sql);

  while($data=mysqli_fetch_object($query)){

  $entitlement_value[$data->item_id] = $data->entitlement_value;

  }

  

  $sql = "select * from item_info where  sub_group_id=".$_POST['sub_group'];

  $query = db_query($sql);

  while($data=mysqli_fetch_object($query)){$i++;



  ?>

  <tr bgcolor="<?=($i%2)?'#E8F3FF':'#fff';?>">

    <td><?=$data->item_id;?></td>

    <td><?=$data->item_name;?></td>

    <td><?=$data->unit_name?></td>

    <td><input name="entitlement_value_<?=$data->item_id?>" id="entitlement_value_<?=$data->item_id?>" type="text" size="10" maxlength="10" value="<?=$entitlement_value[$data->item_id];?>" style="width:120px;" />

	 </td>

    <td><span id="divi_<?=$data->item_id?>">

            <? 

			  if($entitlement_value[$data->item_id]>0)

			  {?>

			  <input name="flag_<?=$data->item_id?>" type="hidden" id="flag_<?=$data->item_id?>" value="1" />

			  <input type="button" name="Button" value="Edit"  onclick="update_value(<?=$data->item_id?>)" style="width:60px; height:30px; background-color:#FF3366"/><?

			  }

			  elseif($entitlement_value[$data->item_id]<1)

			  {

			  ?>

			  <input name="flag_<?=$data->item_id?>" type="hidden" id="flag_<?=$data->item_id?>" value="0" />

			  <input type="button" name="Button" value="Save"  onclick="update_value(<?=$data->item_id?>)" style="width:60px; height:30px;background-color:#66CC66"/><? }?>

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

require_once SERVER_CORE."routing/layout.bottom.php";

?>