<?php

//

//


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Sale Contract Update';

//create_combobox('pi_id');
//create_combobox('dealer_code');

//do_calander('#fdate');
//do_calander('#tdate');

//do_calander('#odate');



  $sc_no 		= $_REQUEST['sc_no'];
  
  $sc_all = find_all_field('sales_contract_master','','sc_no="'.$sc_no.'"');




if(prevent_multi_submit()){



if(isset($_POST['confirm'])){
	
	$status = 'UNCHECKED';
	$checked_by = $_SESSION['user']['id'];
	$checked_at=date('Y-m-d H:i:s');
		
	$sc_no = $_POST['sc_no'];
	


	$new_sql="UPDATE sales_contract_master SET status='".$status."' WHERE sc_no = '".$sc_no."' ";
	 db_query($new_sql);
	 
	 
	 
	 
	 
//if ($pi_data->pi_type==3) {
//	
//		
////Text Sms
//
//$sms_rec = find_all_field('sms_receiver','','id=1');
//
//function sms($dest_addr,$sms_text){
//
//$url = "https://vas.banglalink.net/sendSMS/sendSMS?userID=NASSA@123&passwd=LizAPI@019014&sender=NASSA_GROUP";
//
//
//$fields = array(
//    'userID'      => "NASSA@123",
//    'passwd'      => "LizAPI@019014",
//    'sender'      => "NASSA GROUP",
//    'msisdn'      => $dest_addr,
//    'message'     => $sms_text
//);
//$ch = curl_init();
//curl_setopt($ch, CURLOPT_URL, $url);
//curl_setopt($ch, CURLOPT_POST, count($fields));
//curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));
//$result = curl_exec($ch);
//curl_close($ch);
//}
//
//$recipients =$sms_rec->receiver_3;
//$recipients2 =$sms_rec->receiver_2;
//$massage  = "Dear Sir,\r\nRequest for PI Approval. \r\n";
//$massage  .= "PI No : ".$pi_no_generate." \r\n";
//$massage  .= "Login : https://boxes.com.bd/NATIVE/lc_mod/pages/main/index.php?module_id=13 \r\n";
//$sms_result=sms($recipients, $massage);
//if($recipients2>0) {
//$sms_result=sms($recipients2, $massage);
//}
	
//Text Sms

		//}
	 
	 
	 
	 
	 ?>

<script language="javascript">
window.location.href = "pending_sc_no_list.php";
</script>

<?


	 
	 
	 
	 
	 
		

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



	function update_value(pi_id)



	{



var pi_id=pi_id; // Rent


var sc_no=(document.getElementById('sc_no').value);


var flag=(document.getElementById('flag_'+pi_id).value); 

var strURL="sc_update_ajax.php?pi_id="+pi_id+"&sc_no="+sc_no+"&flag="+flag;



		var req = getXMLHTTP();



		if (req) {



			req.onreadystatechange = function() {

				if (req.readyState == 4) {

					// only if "OK"

					if (req.status == 200) {						

						document.getElementById('divi_'+pi_id).style.display='inline';

						document.getElementById('divi_'+pi_id).innerHTML=req.responseText;						

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

<div class="box" style="width:100%;">

								<table width="100%" border="0" cellspacing="0" cellpadding="0">

								  <tr>

								 <td width="9%">SC S/L:</td>

									<td width="21%">
									
									<input name="sc_no" type="hidden" id="sc_no" tabindex="1" value="<?=$sc_no?>" readonly>
								
								

								<input name="sc_no_view" type="text" id="sc_no_view" style="width:200px; height:32px;" value="<?=$sc_all->sc_no_view?>" readonly="" tabindex="105" />									</td>
									<td width="10%">LC No:</td>
									<td width="23%">
									
									<input name="export_lc_no" type="text" id="export_lc_no"  readonly="" style="width:220px; height:32px;" value="<?=$sc_all->export_lc_no?>"  required tabindex="105" />										</td>
									<td width="14%">Customer Group:</td>
									<td width="23%">
									<select name="dealer_group" id="dealer_group" required style="width:220px;"  >
	
								
										<? foreign_relation('dealer_group','id','dealer_group',$dealer_group,'id="'.$sc_all->dealer_group.'"  order by id');?>
									</select></td>
								  </tr>
								  
								  
  
								  <tr>

								 <td> Date:</td>

									<td>

									
									
									<input style="width:200px; height:32px;"  name="invoice_date" type="text" id="invoice_date"  value="<?=$sc_all->invoice_date?>"  required />									</td>
									<td>Expiry Date: </td>
									<td>
								
									<input style="width:220px; height:32px;"  name="expiry_date" type="text" id="expiry_date"  value="<?=$sc_all->expiry_date?>" required />																		</td>
									<td>Customer Name:</td>
									<td><span id="find_dealer">
									  <select name="dealer_code" id="dealer_code" required style="width:220px;">
                                        <? foreign_relation('dealer_info','dealer_code','dealer_name_e',$dealer_code,'dealer_code="'.$sc_all->dealer_code.'"  order by dealer_code');?>
                                      </select>
									</span></td>
								  </tr>
								  <tr>
								    <td> Seller's Bank:</td>
								    <td>
									<select name="bank_sellers" id="bank_sellers" required style="width:200px;">
	
								
										<? foreign_relation('bank_sellers','bank_id','bank_name',$bank_sellers,
										'bank_id="'.$sc_all->bank_sellers.'" order by bank_id');?>
									</select>									</td>
								    <td>Description:</td>
								    <td><input style="width:220px; height:32px;"  name="discription_goods" type="text" id="discription_goods" readonly="" value="<?=$sc_all->discription_goods?>"   required /></td>
								    <td>Customer Bank:</td>
								    <td>
									<span id="find_dealer_bank">
									<select name="bank_buyers" id="bank_buyers" required style="width:220px;">
	
									
								
										<? foreign_relation('bank_buyers','bank_id','bank_name',$bank_buyers,'bank_id="'.$sc_all->bank_buyers.'"   order by bank_id');?>
									</select>
									</span>									</td>
							      </tr>
								</table>

    </div>

<br />

<?

if($sc_no>0){

?>

<div class="tabledesign2" style="width:100%">

<table width="100%" border="0" align="center" id="grp" cellpadding="0" cellspacing="0" style="font-size:12px; text-transform:uppercase;">

  <tr>

    <th width="4%">PI No </th>

    <th width="8%">PI Date </th>
    <th width="8%">PI Type </th>
    <th width="21%">CUSTOMER Name </th>
    <th width="7%">TOTAL QTY</th>
    <th width="9%">TOTAL VALUE </th>
    <th width="9%"><div align="center">Action</div></th>
  </tr>
  

  <?
  
  
  if($_POST['fdate']!=''&&$_POST['tdate']!='') $date_con .= ' and c.chalan_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
  
  
		//if($_POST['dealer_code']!='')
// 		$dealer_con=" and m.dealer_code='".$_POST['dealer_code']."'";
//		
//		if($_POST['do_no']!='') 
//		$do_con .= ' and m.do_no in ('.$_POST['do_no'].') ';


		 $sql = "select   pi_id, pi_id as pi_no from sales_contract where 1 group by pi_id";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $pi_no[$info->pi_id]=$info->pi_no;
		
		
		}

		
		

    $sql = "select  m.*, d.pi_id, sum(d.total_unit) as pi_qty, sum(d.total_amt) as pi_amt
   from pi_master m, pi_details d 
   where m.id=d.pi_id and m.dealer_code='".$sc_all->dealer_code."' and m.status='CHECKED' group by d.pi_id  order by  d.pi_id ";

  $query = db_query($sql);

  while($data=mysqli_fetch_object($query)){$i++;

 // $op = find_all_field('journal_item','','warehouse_id="'.$_POST['warehouse_id'].'" and group_for="'.$_POST['group_for'].'" and item_id = "'.$data->item_id.'" and tr_from = "Opening" order by id desc');

  ?>



<? if($pi_no[$data->pi_id]==0) {  ?>

  <tr bgcolor="<?=($i%2)?'#E8F3FF':'#fff';?>">

    <td>
	
<? if ($data->pi_type==1 || $data->pi_type==3){  ?><a href="../pi/pi_print_view.php?v_no=<?=$data->id;?>" target="_blank" style=" color:#000000; font-size:14px; font-weight:700;"> <?=$data->pi_no;?></a><? }?>
<? if ($data->pi_type==2){  ?><a href="../pi/master_pi_print_view.php?v_no=<?=$data->id;?>" target="_blank" style=" color:#000000; font-size:14px; font-weight:700;"> <?=$data->pi_no;?></a><? }?>	
	

	
	</td>

    <td><?php echo date('d-m-Y',strtotime($data->pi_date));?></td>
    <td><?= find_a_field('pi_type','pi_type','id="'.$data->pi_type.'"');?></td>
    <td><?= find_a_field('dealer_info','dealer_name_e','dealer_code='.$data->dealer_code);?></td>
    <td><?= $data->pi_qty;?></td>
    <td><?= $data->pi_amt;?></td>
    <td><span id="divi_<?=$data->pi_id?>">

     

	<input name="flag_<?=$data->pi_id?>" type="hidden" id="flag_<?=$data->pi_id?>" value="0" />

	 <input type="button" name="Button" value="Approve"  onclick="update_value(<?=$data->pi_id?>)" style="width:70px; font-size:12px; height:30px;background-color:#66CC66"/>
			  


          </span>&nbsp;</td>
  </tr>

  <? } }?>
</table>

<br /><br />

</div>


<table width="100%" border="0">






<tr>

<td align="center">&nbsp;

</td>

<td align="center">
<!--<input  name="do_no" type="hidden" id="do_no" value="<?=$_POST['do_no'];?>"/>-->
<input name="confirm" type="submit" class="btn1" value="COMPLETE" style="width:270px; font-weight:bold; float:right; font-size:12px; height:30px;  background:#99CCFF; color:#000000;" /></td>

</tr>



</table>


<?php /*?><table width="100%" border="0">

<? 

 		$pi_status = find_a_field('pi_master','status','id="'.$_POST['pi_id'].'"');
		 // $issue_qty = find_a_field('sale_do_production_issue','sum(total_unit)','do_no='.$_POST['do_no']);


if($pi_status!="MANUAL"){




?>

<tr>

<td colspan="2" align="center" bgcolor="#FF3333"><strong> Master PI Data Entry Completed</strong></td>

</tr>

<? }else{?>

<tr>

<td align="center">&nbsp;

</td>

<td align="center">
<!--<input  name="do_no" type="hidden" id="do_no" value="<?=$_POST['do_no'];?>"/>-->
<input name="confirm" type="submit" class="btn1" value="COMPLETE" style="width:270px; font-weight:bold; float:right; font-size:12px; height:30px; color:#090" /></td>

</tr>

<? }?>

</table><?php */?>




<? }?>








<p>&nbsp;</p>

</form>

</div>



<?

//

//

require_once SERVER_CORE."routing/layout.bottom.php";

?>