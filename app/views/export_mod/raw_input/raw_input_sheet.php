<?php



//

$level=$_SESSION['user']['level'];

//




 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


 $log_no 		= $_REQUEST['log_no'];





$title='Raw Input Sheet';




do_calander('#p_date');

if($_REQUEST['p_date']!='')

{

$p_date = $_REQUEST['p_date'];

$group_for = $_REQUEST['group_for'];

$extrusion_type = $_REQUEST['extrusion_type'];

$log_info =  find_all_field_sql("SELECT log_no, status FROM `production_log_sheet_ffw_extrusion` WHERE `group_for`='".$group_for."' and `extrusion_type`='".$extrusion_type."'
 and `log_date`='".$p_date."'  ");


$p_found = find_a_field('item_sale_issue','1',' 1 and se_id = "'.$se_id.'" and status="COMPLETE" and sale_date="'.$p_date.'"');

$m_found = find_a_field('item_sale_issue','1',' 1 and se_id = "'.$se_id.'" and status="MANUAL" and sale_date<"'.$p_date.'"');

}


if(prevent_multi_submit()){

if(isset($_REQUEST['confirmit']))

{


$p_date = $_REQUEST['p_date'];

$group_for = $_REQUEST['group_for'];



//$sql = "update production_log_sheet_ffw_extrusion set status = 'COMPLETE' where `group_for`='".$group_for."' and `log_date`='".$p_date."'";

//db_query($sql);




}

}

if(isset($_REQUEST['delete']))

{



$p_date = $_REQUEST['p_date'];

$se_id = $_REQUEST['se_id'];

//$sale_no = $_REQUEST['sale_no'];

$se_info = find_all_field('warehouse','','warehouse_id='.$se_id);

$se_sale =  find_all_field_sql("SELECT sum(today_sale_amt) total_sales,sale_no,status FROM `item_sale_issue` WHERE `se_id`='".$se_id."' and `sale_date`='".$p_date."' ");

$sql = "update item_sale_issue set status = 'MANUAL' where `se_id`='".$se_id."' and `sale_date`='".$p_date."'";

db_query($sql);


$sql_del_secondary = "DELETE FROM secondary_journal WHERE tr_no ='".$se_sale->sale_no."'";

db_query($sql_del_secondary);

$sql_del_journal = "DELETE FROM journal WHERE tr_no ='".$se_sale->sale_no."'";

db_query($sql_del_journal);


}





if(isset($_REQUEST['collection']))

{



$p_date = $_REQUEST['p_date'];

$se_id = $_REQUEST['se_id'];



$c_id = $_REQUEST['c_id'];

$c_amt = $_REQUEST['c_amt'];



$se_info = find_all_field('warehouse','','warehouse_id='.$se_id);



$jv_no = next_journal_sec_voucher_id();

$jv_date = strtotime($p_date);

$narration = 'Collection Date:'.$p_date;


$cc_code = $se_info->acc_code;
add_to_sec_journal('STA', $jv_no, $jv_date, $c_id              , $narration, $c_amt, '0.00', 'Collection', $se_id,'','',$cc_code);

add_to_sec_journal('STA', $jv_no, $jv_date, $se_info->ledger_id,  $narration, '0.00', $c_amt, 'Collection', $se_id,'','',$cc_code);



}



$se_info = find_all_field('warehouse','','warehouse_id='.$se_id);

$se_sale =  find_all_field_sql("SELECT sum(today_sale_amt) total_sales,status,sale_no FROM `item_sale_issue` WHERE `se_id`='".$se_id."' and `sale_date`='".$p_date."' ");



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







	function update_value(item_id)

	{

var item_id=item_id; // Rent 

var p_date=(document.getElementById('p_date').value);
var dealer_code=(document.getElementById('dealer_code').value);
var buyer_code=(document.getElementById('buyer_code').value);
var merchandizer_code=(document.getElementById('merchandizer_code').value);


var L_cm=(document.getElementById('L_cm_'+item_id).value);
var W_cm=(document.getElementById('W_cm_'+item_id).value)*1; 
var H_cm=(document.getElementById('H_cm_'+item_id).value)*1; 
var WL=(document.getElementById('WL_'+item_id).value)*1; 
var WW=(document.getElementById('WW_'+item_id).value)*1; 
var ply=(document.getElementById('ply_'+item_id).value)*1; 
var paper_combination=(document.getElementById('paper_combination_'+item_id).value); 
var sqm_rate=(document.getElementById('sqm_rate_'+item_id).value)*1; 
var pcs_rate=(document.getElementById('pcs_rate_'+item_id).value)*1;


var flag=(document.getElementById('flag_'+item_id).value); 

//alert(item_rate)

var strURL="raw_input_sheet_ajax.php?item_id="+item_id+"&p_date="+p_date+"&dealer_code="+dealer_code+"&buyer_code="+buyer_code+"&merchandizer_code="+merchandizer_code+
"&L_cm="+L_cm+"&W_cm="+W_cm+"&H_cm="+H_cm+"&WL="+WL+"&WW="+WW+"&ply="+ply+"&paper_combination="+paper_combination+"&sqm_rate="+sqm_rate+"&pcs_rate="+pcs_rate+"&flag="+flag;



//alert(strURL);



		var req = getXMLHTTP();







		if (req) {







			req.onreadystatechange = function() {



				if (req.readyState == 4) {



					// only if "OK"



					if (req.status == 200) {						



						document.getElementById('divi_'+item_id).style.display='inline';



						document.getElementById('divi_'+item_id).innerHTML=req.responseText;						



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




<!--<script>

function calculation(item_id){

var rm_stock=((document.getElementById('rm_stock_'+item_id).value)*1);

var rm_issue_qty=((document.getElementById('rm_issue_qty_'+item_id).value)*1);
var westage_qty=((document.getElementById('westage_qty_'+item_id).value)*1);
var total_issue_qty= document.getElementById('total_issue_qty_'+item_id).value= (rm_issue_qty+westage_qty);
var net_total_qty= document.getElementById('net_total_qty_'+item_id).value= (total_issue_qty-westage_qty);


 if(total_issue_qty>rm_stock)
  {
alert('Can not issue more than stock.');
document.getElementById('rm_issue_qty_'+item_id).value='';
document.getElementById('westage_qty_'+item_id).value='';

  } 



//if (pp_bag >0) {
//	var pp_qty= document.getElementById('pp_qty_'+id).value= (bag_size*pp_bag);
//	var hdpe_bag= document.getElementById('hdpe_bag_'+id).value= (pp_bag/3);
//	var hdpe_qty= document.getElementById('hdpe_qty_'+id).value= (bag_size*hdpe_bag);
//	
//	var total_bag= document.getElementById('total_bag_'+id).value= (pp_bag+hdpe_bag);
//	var total_qty= document.getElementById('total_qty_'+id).value= (pp_qty+hdpe_qty);
//} else if((pp_bag ==0)) {
//	var hdpe_bag=((document.getElementById('hdpe_bag_'+id).value)*1);
//	var hdpe_qty= document.getElementById('hdpe_qty_'+id).value= (bag_size*hdpe_bag);
//	
//	var total_bag= document.getElementById('total_bag_'+id).value= (hdpe_bag);
//	var total_qty= document.getElementById('total_qty_'+id).value= (hdpe_qty);
//}
//
//var wastage_starting=((document.getElementById('wastage_starting_'+id).value)*1);
//var wastage_on_process=((document.getElementById('wastage_on_process_'+id).value)*1);
//var total_wastage= document.getElementById('total_wastage_'+id).value= (wastage_starting+wastage_on_process);
//var net_total_qty= document.getElementById('net_total_qty_'+id).value= (total_qty-total_wastage);


}

</script>-->






<style type="text/css">

<!--

.style1 {

	color: #FFFFFF;

	font-weight: bold;

}
.style2 {color: #000000}

-->

</style>







<div class="form-container_large">



<form action="" method="post" name="codz" id="codz">



<table width="80%" border="0" align="center">



  <tr>



    <td colspan="4" height="25px" bgcolor="#FF0000"><div align="center" style="color: #000000; font-size:16px; font-weight:700"><?=$title;?></div></td>
    </tr>



  <?



  if(isset($_POST['p_date']))



  $p_date = $_SESSION['p_date'] = $_POST['p_date'];



  elseif($_SESSION['p_date']!='')



  $p_date = $_SESSION['p_date'];



  else



  $p_date = date('Y-m-d');



  



  ?>



  <tr>



    <td align="right" bgcolor="#FF9966"><strong> Date: </strong></td>



    <td bgcolor="#FF9966"><input name="p_date" type="text" id="p_date" style="width:100px;" value="<?=$p_date?>" /></td>



    <td rowspan="6" bgcolor="#FF9966"><strong>

      <input type="submit" name="submit" id="submit" value="View Sheet" style="width:170px; font-weight:bold; font-size:12px; height:30px; color:#090"/>

    </strong></td>

    <td rowspan="6" bgcolor="#FF9966"><a href="rmc_view_ffw_extrusion.php?log_no=<?=$log_info->log_no?>" target="_blank"><!--<img src="../../images/print.png" width="26" height="26" />--></a></td>
  </tr>



  <tr>
    <td align="right" bgcolor="#FF9966"><strong>Customer Name: </strong></td>
    <td bgcolor="#FF9966">
		<select name="dealer_code" id="dealer_code" style="width:250px;" required onchange="getData2('buyer_ajax.php', 'buyer_filter', this.value, 

document.getElementById('dealer_code').value);">
		
		<option></option>

        <?
		
		foreign_relation('dealer_info','dealer_code','dealer_name_e',$_POST['dealer_code'],'1 order by dealer_code');

		?>
    </select>	</td>
  </tr>
  
  
  
  <tr>
    <td align="right" bgcolor="#FF9966"><strong>Buyer Name: </strong></td>
    <td bgcolor="#FF9966">
	
	<span id="buyer_filter">
		<select name="buyer_code" id="buyer_code" style="width:250px;" required  onchange="getData2('merchandizer_ajax.php', 'merchandizer_filter', this.value, 

document.getElementById('buyer_code').value);" >
		
		<option></option>

        <?
		
		foreign_relation('buyer_info','buyer_code','buyer_name',$_POST['buyer_code'],'1 order by buyer_code');

		?>
    </select>	</span></td>
  </tr>
  
  <tr>
    <td align="right" bgcolor="#FF9966"><strong>Merchandiser: </strong></td>
    <td bgcolor="#FF9966">
	<span id="merchandizer_filter">
		<select name="merchandizer_code" id="merchandizer_code" style="width:250px;" required>
		<option></option>

        <?
		
		foreign_relation('merchandizer_info','merchandizer_code','merchandizer_name',$_POST['merchandizer_code'],'1 order by merchandizer_code');

		?>
    </select>	</span></td>
  </tr>
  
  
  <tr>
    <td align="right" bgcolor="#FF9966"><strong>Classification Criteria: </strong></td>
    <td bgcolor="#FF9966">
		<select name="sub_group_id" id="sub_group_id" style="width:250px;" >
		<option></option>

        <?
		
		foreign_relation('item_sub_group','sub_group_id','sub_group_name',$_POST['sub_group_id'],'1 order by sub_group_id');

		?>
    </select>	</td>
  </tr>
  
  
</table>



<br />







<?



if($_POST['dealer_code']>0){



?>


<div class="tabledesign2" style="width:100%">



<table width="100%" border="0" align="center" id="grp" cellpadding="0" cellspacing="0">



  <tr style="font-size:12px;">
    <th width="34%">Carton Name</th>

    <th width="8%">L (CM) </th>
    <th width="8%">W (CM) </th>
    <th width="8%">H (CM) </th>
    <th width="8%">WL</th>
    <th width="9%">WW</th>
    <th width="6%" bgcolor="#FF9999"> Ply</th>

    <th width="5%" bgcolor="#FF9999">Paper Combination</th>
    <th width="14%">Sqm Rate</th>
    <th width="14%">Pcs Rate </th>
    <th width="15%"><div align="center">Action</div></th>
  </tr>
  



  <?

  if($_POST['sub_group_id']!="")

$con .= 'and i.sub_group_id="'.$_POST['sub_group_id'].'"';

 

  

  $sql = "select i.*, s.sub_group_name from item_info i, item_sub_group s where i.sub_group_id=s.sub_group_id ".$con." order by i.sub_group_id,i.item_id ";



  $query = db_query($sql);



  while($data=mysqli_fetch_object($query)){$i++;



$info ='';

  $info = find_all_field('raw_input_sheet l','','
   l.item_id = "'.$data->item_id.'" and l.dealer_code="'.$_POST['dealer_code'].'" and l.buyer_code = "'.$_POST['buyer_code'].'" 
   and l.merchandizer_code = "'.$_POST['merchandizer_code'].'" ');

if($info->id<1)
 







  ?>



  <tr style=" font-size:12px;">
    <td><?=$data->item_name?>
	<input readonly name="semi_fg_item_<?=$data->item_id?>" id="semi_fg_item_<?=$data->item_id?>" type="hidden" value="<?=$data->semi_fg_item;?>" /></td>

<td><input name="L_cm_<?=$data->item_id?>" id="L_cm_<?=$data->item_id?>" type="text" size="10"  value="<?=$data->L_cm;?>" style="width:50px; height:22px"  autocomplete="off" /></td>
<td><input name="W_cm_<?=$data->item_id?>" id="W_cm_<?=$data->item_id?>" type="text" size="10"  value="<?=$data->W_cm;?>" style="width:50px; height:22px"  autocomplete="off" /></td>
<td><input name="H_cm_<?=$data->item_id?>" id="H_cm_<?=$data->item_id?>" type="text" size="10"  value="<?=$data->H_cm;?>" style="width:50px; height:22px"  autocomplete="off" /></td>
<td><input name="WL_<?=$data->item_id?>" id="WL_<?=$data->item_id?>" type="text" size="10"  value="<?=$data->WL;?>" style="width:50px; height:22px"  autocomplete="off" /></td>
<td><input name="WW_<?=$data->item_id?>" id="WW_<?=$data->item_id?>" type="text" size="10"  value="<?=$data->WW;?>" style="width:50px; height:22px"  autocomplete="off" /></td>
<td bgcolor="#FF9999"><input name="ply_<?=$data->item_id?>" id="ply_<?=$data->item_id?>" type="text" size="10"  value="<?=($info->ply=='')?$info_old->ply:$info->ply;?>" style="width:60px; height:22px"  autocomplete="off" /></td>

<td bgcolor="#FF9999">
<input name="paper_combination_<?=$data->item_id?>" id="paper_combination_<?=$data->item_id?>" type="text" size="10"  value="<?=($info->paper_combination=='')?$info_old->paper_combination:$info->paper_combination;?>" style="width:150px; height:22px"  /></td>
<td><input name="sqm_rate_<?=$data->item_id?>" id="sqm_rate_<?=$data->item_id?>" type="text" size="10"  value="<?=($info->sqm_rate=='')?$info_old->sqm_rate:$info->sqm_rate;?>" style="width:60px; height:22px" /></td>
<td><input name="pcs_rate_<?=$data->item_id?>" id="pcs_rate_<?=$data->item_id?>" type="text" size="10"  value="<?=($info->pcs_rate=='')?$info_old->pcs_rate:$info->pcs_rate;?>" style="width:60px; height:22px" /></td>
<td><span id="divi_<?=$data->item_id?>">



   <?
   
   

if($info->status!=='COMPLETE')

	{

	if($info->item_id<1)

	{

?>

    <input name="flag_<?=$data->item_id?>" type="hidden" id="flag_<?=$data->item_id?>" value="0" />

    <input type="button" name="Button" value="Save"  onclick="update_value(<?=$data->item_id?>)" style="width:60px; height:25px;background-color:#66CC66"/>

<? }



		 else



			{?>



				  <input name="flag_<?=$data->item_id?>" type="hidden" id="flag_<?=$data->item_id?>" value="1" />



				  <input type="button" name="Button" value="Edit"  onclick="update_value(<?=$data->item_id?>)" style="width:60px; height:25px; background-color:#FF3366"/>



		 <? }}



		 ?>



          </span>&nbsp;</td>
  </tr>



  <? }?>
</table>



</div>




<? }?>


<br />


<p style="width:100%; float:left;">



   <? if($log_info->status=='MANUAL'){?>

	 	   <input name="confirmit" type="hidden" id="confirmit" value="COMPLETE ENTRY" style=" width:300px; float:right; height:25px; background-color:#FF3300 float:right; font-weight:700;" /> 	       

 	     <? }?>

	

	</p>
	
	
	
	



</form>



</div>







<?



//



//



require_once SERVER_CORE."routing/layout.bottom.php";



?>