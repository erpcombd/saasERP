<?php

//

//


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Master PI Update';

create_combobox('pi_id');
create_combobox('dealer_code');

do_calander('#fdate');
do_calander('#tdate');

do_calander('#odate');








if(prevent_multi_submit()){



if(isset($_POST['confirm'])){
	
	$status = 'UNCHECKED';
	$checked_by = $_SESSION['user']['id'];
	$checked_at=date('Y-m-d H:i:s');
		
	$pi_id = $_POST['pi_id'];
	
	$pi_no_generate = find_a_field('pi_master','pi_no','id='.$pi_id);

	$new_sql="UPDATE pi_master SET status='".$status."' WHERE id = '".$pi_id."' ";
	 db_query($new_sql);
	 
	 
	 
	 
	
	
//Text Sms

$sms_rec = find_all_field('sms_receiver','','id=1');

function sms($dest_addr,$sms_text){

$url = "https://vas.banglalink.net/sendSMS/sendSMS?userID=NASSA@123&passwd=LizAPI@019014&sender=NASSA_GROUP";


$fields = array(
    'userID'      => "NASSA@123",
    'passwd'      => "LizAPI@019014",
    'sender'      => "NASSA GROUP",
    'msisdn'      => $dest_addr,
    'message'     => $sms_text
);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, count($fields));
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));
$result = curl_exec($ch);
curl_close($ch);
}

$recipients =$sms_rec->receiver_3;
$recipients2 =$sms_rec->receiver_4;
$massage  = "Dear Sir,\r\nRequest for PI Approval. \r\n";
$massage  .= "PI No : ".$pi_no_generate." \r\n";
$massage  .= "Login : https://boxes.com.bd/NATIVE/lc_mod/pages/main/index.php?module_id=13 \r\n";
$sms_result=sms($recipients, $massage);
if($recipients2>0) {
$sms_result=sms($recipients2, $massage);
}
	
//Text Sms


		

}


}

else

{

	$type=0;

	$msg='Data Re-Submit Warning!';

}







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



var id=id; // Rent

var pi_id=(document.getElementById('pi_id').value);

var item_id=(document.getElementById('item_id_'+id).value); 
var L_cm=(document.getElementById('L_cm_'+id).value); 
var W_cm=(document.getElementById('W_cm_'+id).value); 
var H_cm=(document.getElementById('H_cm_'+id).value); 
var ply=(document.getElementById('ply_'+id).value);
var total_unit=(document.getElementById('total_unit_'+id).value);
var total_weight=(document.getElementById('total_weight_'+id).value);
var unit_price=(document.getElementById('unit_price_'+id).value);
var total_amt=(document.getElementById('total_amt_'+id).value);

var flag=(document.getElementById('flag_'+id).value); 

var strURL="master_pi_update_ajax.php?id="+id+"&pi_id="+pi_id+"&item_id="+item_id+"&L_cm="+L_cm+"&W_cm="+W_cm+"&H_cm="+H_cm+"&ply="+ply+"&total_unit="+total_unit+"&total_weight="+total_weight+"&unit_price="+unit_price+"&total_amt="+total_amt+"&flag="+flag;



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
        <td width="10%" align="right" bgcolor="#FF9966"><strong>PI No:</strong></td>
        <td width="46%" bgcolor="#FF9966">
		<select name="pi_id" id="pi_id" required style="width:280px;">
		
		<option></option>

        <? foreign_relation('pi_master','id','pi_no',$_POST['pi_id'],'pi_type!=1 and status="PROCESSING" order by id');?>
    </select>	
	
	
	<? 
	$pi_data = find_all_field('pi_master','','id='.$_POST['pi_id']);
	?>		</td>
        <td width="18%" bgcolor="#FF9966"><?=$pi_data->pi_date;?></td>
        <td width="26%" rowspan="6" bgcolor="#FF9966"><strong>
          <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
        </strong></td>
      </tr>
    </table>

<br />

<?

if(isset($_POST['submitit'])){

?>

<div class="tabledesign2" style="width:100%">

<table width="100%" border="0" align="center" id="grp" cellpadding="0" cellspacing="0" style="font-size:12px; text-transform:uppercase;">

  <tr>

    <th width="15%" rowspan="2">item name </th>
    <th width="4%" rowspan="2">Unit  </th>
    <th colspan="4"><div align="center">Measurement</div></th>
    <th width="7%" rowspan="2">ply</th>
    <th width="11%" rowspan="2">quantity</th>
    <th width="13%" rowspan="2">Qty in (kg) </th>
    <th width="11%" rowspan="2">Price</th>
    <th width="14%" rowspan="2">TOTAL VALUE </th>
    <th width="10%" rowspan="2"><div align="center">Action</div></th>
  </tr>
  <tr>
    <th width="4%">L</th>
    <th width="4%">W</th>
    <th width="4%">H</th>
    <th width="3%"> unit</th>
    </tr>
  

  <?
  
  
  if($_POST['fdate']!=''&&$_POST['tdate']!='') $date_con .= ' and c.chalan_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
  
  
		//if($_POST['dealer_code']!='')
// 		$dealer_con=" and m.dealer_code='".$_POST['dealer_code']."'";
//		


		if($_POST['pi_id']!='') 
		$pi_con .= ' and m.id in ('.$_POST['pi_id'].') ';




		 $sql = "select   order_no, order_no as tr_id  from pi_details_master_pi where pi_id='".$_POST['pi_id']."' group by order_no";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $tr_id[$info->order_no]=$info->tr_id;

		}

		
		

   $sql = "select  m.*, i.item_name, d.id,  d.item_id, d.unit_name, d.measurement_unit, d.ply, d.L_cm, d.W_cm, d.H_cm, sum(d.total_unit) as total_unit,  
   sum(d.total_weight) as total_weight, sum(d.total_amt) as total_amt
   from pi_master m, pi_details d , item_info i
   where m.id=d.pi_id and i.item_id=d.item_id ".$date_con.$dealer_con.$pi_con." group by  d.item_id, d.ply  order by  d.item_id ";

  $query = db_query($sql);

  while($data=mysqli_fetch_object($query)){$i++;

 // $op = find_all_field('journal_item','','warehouse_id="'.$_POST['warehouse_id'].'" and group_for="'.$_POST['group_for'].'" and item_id = "'.$data->item_id.'" and tr_from = "Opening" order by id desc');

  ?>



<?php /*?><? if($data->total_unit!=$total_unit[$data->id]) { }?><?php */?>

  <tr bgcolor="<?=($i%2)?'#E8F3FF':'#fff';?>">

    <td><?= $data->item_name;?>
	<input name="item_id_<?=$data->id?>" type="hidden" id="item_id_<?=$data->id?>" value="<?=$data->item_id?>" style="width:50px; height:25px;" />
	</td>
    <td><?= $data->unit_name;?></td>
    <td><input name="L_cm_<?=$data->id?>" type="text" id="L_cm_<?=$data->id?>" value="<?=$data->L_cm?>" style="width:50px; height:25px;" /></td>
    <td><input name="W_cm_<?=$data->id?>" type="text" id="W_cm_<?=$data->id?>" value="<?=$data->W_cm?>" style="width:50px; height:25px;"/></td>
    <td><input name="H_cm_<?=$data->id?>" type="text" id="H_cm_<?=$data->id?>" value="<?=$data->H_cm?>" style="width:50px; height:25px;"/></td>
    <td><?= $data->measurement_unit;?></td>
    <td><input name="ply_<?=$data->id?>" type="text" id="ply_<?=$data->id?>" value="<?=$data->ply?>" style="width:50px; height:25px;"/></td>
    <td><?= $data->total_unit;?>
	<input name="total_unit_<?=$data->id?>" type="hidden" id="total_unit_<?=$data->id?>" value="<?=$data->total_unit?>" style="width:50px; height:25px;"/>
	</td>
    <td><?= $data->total_weight;?>
	<input name="total_weight_<?=$data->id?>" type="hidden" id="total_weight_<?=$data->id?>" value="<?=$data->total_weight?>" style="width:50px; height:25px;"/></td>
    <td><?= number_format($unit_price= ($data->total_amt/$data->total_unit),2);?>
	<input name="unit_price_<?=$data->id?>" type="hidden" id="unit_price_<?=$data->id?>" value="<?=$unit_price;?>" style="width:50px; height:25px;"/>
	</td>
    <td><?= $data->total_amt;?>
	<input name="total_amt_<?=$data->id?>" type="hidden" id="total_amt_<?=$data->id?>" value="<?=$data->total_amt?>" style="width:50px; height:25px;"/>
	</td>
    <td><span id="divi_<?=$data->id?>">

     <? if($tr_id[$data->id]>0) {?>

	<input name="flag_<?=$data->id?>" type="hidden" id="flag_<?=$data->id?>" value="1" />

	 <input type="button" name="Button" value="Update"  onclick="update_value(<?=$data->id?>)" style="width:70px; font-size:12px; height:30px; background-color: #FF0000;"/>
	 
	 <? } else { ?>
	 
	 <input name="flag_<?=$data->id?>" type="hidden" id="flag_<?=$data->id?>" value="0" />

	 <input type="button" name="Button" value="Approve"  onclick="update_value(<?=$data->id?>)" style="width:70px; font-size:12px; height:30px;background-color:#66CC66"/>
		
	<? }?>	  


          </span>&nbsp;</td>
  </tr>

  <?   }?>
</table>

<br /><br />

</div>




<table width="100%" border="0">

<? 

 		$pi_status = find_a_field('pi_master','status','id="'.$_POST['pi_id'].'"');
		 // $issue_qty = find_a_field('sale_do_production_issue','sum(total_unit)','do_no='.$_POST['do_no']);


if($pi_status=="PROCESSING"){




?>

<tr>

<td align="center">&nbsp;

</td>

<td align="center">
<!--<input  name="do_no" type="hidden" id="do_no" value="<?=$_POST['do_no'];?>"/>-->
<input name="confirm" type="submit" class="btn1" value="COMPLETE" style="width:270px; font-weight:bold; float:right; font-size:12px; height:30px; color:#090" /></td>

</tr>



<? }else{?>

<tr>

<td colspan="2" align="center" bgcolor="#FF3333"><strong> Master PI Data Entry Completed</strong></td>

</tr>

<? }?>

</table>







<? }?>

<p>&nbsp;</p>

</form>

</div>



<?

//

//

require_once SERVER_CORE."routing/layout.bottom.php";

?>