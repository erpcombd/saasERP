<?php



//

$level=$_SESSION['user']['level'];

//



require "../../support/inc.all.php";


  $lc_id 		= $_REQUEST['lc_no'];
  
  $lc_data = find_all_field('lc_number_setup','','id="'.$lc_id.'"');
  
  $lc_ms = find_all_field('lc_purchase_master','','lc_manual_no="'.$lc_id.'"');



$title='L/C Entry';



do_calander('#bank_lc_date');





if(prevent_multi_submit()){

if(isset($_REQUEST['confirmit']))

{

 
$lc_id=$_POST['lc_id'];

$bank_lc_no=$_POST['bank_lc_no'];

$bank_lc_date=$_POST['bank_lc_date'];

$lc_value=$_POST['lc_value'];

$lc_data = find_all_field('lc_number_setup','','id="'.$lc_id.'"');
  
$lc_ms = find_all_field('lc_purchase_master','','lc_manual_no="'.$lc_id.'"');

$tr_no = next_transection_no($lc_data->group_for,$bank_lc_date,'lc_number_setup','tr_no');	

$entry_by = $_REQUEST['entry_by']=$_SESSION['user']['id'];

$entry_at = $_REQUEST['entry_at']=date('Y-m-d H:i:s');

	
				
 $ins_sql = 'INSERT INTO  lc_bank_entry (tr_no, lc_no, lc_date, lc_manual_no, commercial_licence, lc_number, po_no, lc_value, vendor_id, group_for, bank_info, pi_no, lc_type, status, entry_at, entry_by)
 VALUES 
("'.$tr_no.'", "'.$bank_lc_no.'", "'.$bank_lc_date.'", "'.$lc_id.'", "'.$lc_data->commercial_licence.'", "'.$lc_data->lc_number.'", "'.$lc_ms->po_no.'", "'.$lc_value.'",   "'.$lc_ms->vendor_id.'",
 "'.$lc_data->group_for.'", "'.$lc_data->bank_info.'",  "'.$lc_ms->pi_no.'", "'.$lc_data->lc_type.'", "LC CHECKED", "'.$entry_at.'", "'.$entry_by.'")';
			
db_query($ins_sql);


		$up_sql = 'update lc_purchase_master set lc_no="'.$bank_lc_no.'", lc_date="'.$bank_lc_date.'" where po_no = '.$lc_ms->po_no;
		db_query($up_sql);
				





?>


<script language="javascript">
window.location.href = "pending_pi_for_lc.php";
</script>


<?





}

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







	function update_value(item_id)

	{

var item_id=item_id; // Rent 

var p_date=(document.getElementById('p_date').value);
var group_for=(document.getElementById('group_for').value);
var from_warehouse=(document.getElementById('from_warehouse').value);
var to_warehouse=(document.getElementById('to_warehouse').value);
var rmc_type=(document.getElementById('rmc_type').value);

var semi_fg_item=(document.getElementById('semi_fg_item_'+item_id).value);
var rm_issue_qty=(document.getElementById('rm_issue_qty_'+item_id).value)*1; 
var westage_qty=(document.getElementById('westage_qty_'+item_id).value)*1; 
var total_issue_qty=(document.getElementById('total_issue_qty_'+item_id).value)*1; 
var net_total_qty=(document.getElementById('net_total_qty_'+item_id).value)*1; 

var remarks=(document.getElementById('remarks_'+item_id).value); 

var flag=(document.getElementById('flag_'+item_id).value); 

//alert(item_rate)

var strURL="rmc_ffw_extrusion_ajax.php?item_id="+item_id+"&p_date="+p_date+"&group_for="+group_for+"&from_warehouse="+from_warehouse+"&to_warehouse="+to_warehouse+
"&rmc_type="+rmc_type+"&semi_fg_item="+semi_fg_item+"&rm_issue_qty="+rm_issue_qty+"&westage_qty="+westage_qty+"&total_issue_qty="+total_issue_qty
+"&net_total_qty="+net_total_qty+"&remarks="+remarks+"&flag="+flag;



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




<script>

function calculation_ud(lc_id){

var pi_value=((document.getElementById('pi_value').value)*1);
var lc_value=((document.getElementById('lc_value').value)*1);

var ud_amt= document.getElementById('ud_amt').value= (pi_value-lc_value);





// if(total_issue_qty>rm_stock)
//  {
//alert('Can not issue more than stock.');
//document.getElementById('rm_issue_qty_'+item_id).value='';
//document.getElementById('westage_qty_'+item_id).value='';
//document.getElementById('total_issue_qty_'+item_id).value='';
//document.getElementById('net_total_qty_'+item_id).value='';
//  } 



}

</script>






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



<table width="90%" border="0" align="center">



  <tr>



    <td colspan="4" height="25" bgcolor="#FF0000"><div align="center" style="color: #000000; font-size:16px; font-weight:700"><?=$title;?></div></td>
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
    <td width="24%" align="right" bgcolor="#FF9966"><strong>Concern: </strong></td>
    <td width="26%" bgcolor="#FF9966">
	
	<input name="lc_id" type="hidden" id="lc_id" style="width:200px;" readonly="" value="<?=$lc_id?>" />
	
	
	
		<select name="group_for" id="group_for" style="width:200px;">

        <? foreign_relation('user_group','id','group_name',$_POST['group_for'],'id="'.$lc_data->group_for.'"');?>
    </select>	</td>
    <td width="20%" bgcolor="#FF9966" align="right"><strong>L/C No: </strong></td>
    <td width="30%" bgcolor="#FF9966"><input name="lc_number" type="text" id="lc_number" style="width:200px;" readonly="" value="<?=$lc_data->lc_number?>" /></td>
  </tr>
  
  
  <tr>
    <td align="right" bgcolor="#FF9966"><strong>PI No: </strong></td>
    <td bgcolor="#FF9966">
		<input name="pi_no" type="text" id="pi_no" style="width:200px;" readonly="" value="<?=$lc_ms->pi_no?>" />	</td>
    <td width="20%" bgcolor="#FF9966" align="right"><strong>PI Value (USD$): </strong></td>
    <td bgcolor="#FF9966"><input name="pi_value" type="text" id="pi_value" style="width:200px;" readonly="" onKeyUp="calculation_ud(<?=$lc_id?>)" 
	value="<?= find_a_field('lc_purchase_invoice','sum(amount_usd)','po_no="'.$lc_ms->po_no.'"');?>" /></td>
  </tr>
  
  
  
  <tr>
    <td align="right" bgcolor="#FF9966"><strong>Bank L/C No: </strong></td>
    <td bgcolor="#FF9966">
	<input name="bank_lc_no" type="text" id="bank_lc_no" style="width:200px;" value="<?=$bank_lc_no?>"  required/>	</td>
    <td width="20%" bgcolor="#FF9966" align="right"><strong>Bank L/C Date: </strong></td>
    <td bgcolor="#FF9966"><input name="bank_lc_date" type="text" id="bank_lc_date" style="width:200px;" required value="<?=$bank_lc_date?>" /></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FF9966"><strong> L/C Value  (USD$): </strong></td>
    <td bgcolor="#FF9966">
	<input name="lc_value" type="text" id="lc_value" style="width:200px;" value="<?=$lc_value?>" required onKeyUp="calculation_ud(<?=$lc_id?>)"  /></td>
    <td bgcolor="#FF9966" align="right"><strong>  UD Amount  (USD$): </strong></td>
    <td bgcolor="#FF9966">
	<input name="ud_amt" type="text" id="ud_amt" style="width:200px;" value="<?=$ud_amt?>"  required onKeyUp="calculation_ud(<?=$lc_id?>)" /></td>
  </tr>
</table>



<br />







<br />


<p style="width:100%; float:left;">



   <?php /*?><? if($log_info->status=='MANUAL'){?>  <? }?><?php */?>

	 	   <input name="confirmit" type="submit" id="confirmit" value="COMPLETE ENTRY" style=" width:300px; float:right; height:25px; background-color:#FF3300 float:right; font-weight:700;" /> 	
		   <!--<input name="confirmit" type="submit" id="confirmit" class="btn1" value="CHECKED SALES PROVISION" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:#000000; background:#215470; float:right;" autocomplete="off">  -->      

 	   

	

	</p>
	
	
	
	



</form>



</div>







<?



//



//



require_once SERVER_CORE."routing/layout.bottom.php";



?>