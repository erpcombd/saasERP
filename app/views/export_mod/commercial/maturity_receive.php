<?php

//

//


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Maturity Receive';

//create_combobox('pi_id');
//create_combobox('dealer_code');

do_calander('#invoice_date');
do_calander('#ldbc_no_date');
do_calander('#maturity_rec_date');



  $lc_no 		= $_REQUEST['lc_no'];
  
  $lc_all = find_all_field('lc_master','','lc_no="'.$lc_no.'"');




if(prevent_multi_submit()){



if(isset($_POST['confirm'])){
	
	$status = 'CHECKED';
	$entry_by = $_SESSION['user']['id'];
	$entry_at=date('Y-m-d H:i:s');
		
	$lc_no = $_POST['lc_no'];
	
	$invoice_date = $_POST['invoice_date'];
	
	$ldbc_no = $_POST['ldbc_no'];
	$ldbc_no_date = $_POST['ldbc_no_date'];
	$maturity_rec_date = $_POST['maturity_rec_date'];
	
	$invoice_no = next_transection_no('0',$invoice_date,'maturity_receive','invoice_no');	

	  
		$sql = 'select * from lc_receive where lc_no ="'.$lc_no.'"  order by id';

		$query = db_query($sql);

		while($data=mysqli_fetch_object($query))

		{

   $so_invoice = 'INSERT INTO maturity_receive ( invoice_no, invoice_date, lc_no, year, lc_id, lc_no_view, lc_date, export_lc_no, export_lc_date, expiry_date, pi_id, pi_no, pi_date, pi_type, bank_buyers, dealer_group, dealer_code, marketing_team, marketing_person, tolerance, tenor_days, contact_no, remarks, status, entry_at, entry_by,ldbc_no, ldbc_no_date, maturity_rec_date )
  
  VALUES("'.$invoice_no.'", "'.$invoice_date.'",  "'.$data->lc_no.'", "'.$data->year.'", "'.$data->lc_id.'", "'.$data->lc_no_view.'", "'.$data->lc_date.'", "'.$data->export_lc_no.'", "'.$data->export_lc_date.'", "'.$data->expiry_date.'", "'.$data->pi_id.'", "'.$data->pi_no.'", "'.$data->pi_date.'", "'.$data->pi_type.'", "'.$data->bank_buyers.'", "'.$data->dealer_group.'", "'.$data->dealer_code.'", "'.$data->marketing_team.'", "'.$data->marketing_person.'", "'.$data->tolerance.'", 
  "'.$data->tenor_days.'", "'.$data->contact_no.'", "'.$data->remarks.'", "UNCHECKED", "'.$entry_at.'", "'.$entry_by.'", "'.$ldbc_no.'", "'.$ldbc_no_date.'", "'.$maturity_rec_date.'")';

db_query($so_invoice);



}
	 
 
	 
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


var lc_no=(document.getElementById('lc_no').value);


var flag=(document.getElementById('flag_'+pi_id).value); 

var strURL="lc_update_ajax.php?pi_id="+pi_id+"&lc_no="+lc_no+"&flag="+flag;



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

								 <td width="7%">Date:</td>

									<td width="20%">
									
			<input style="width:220px; height:32px;"  name="invoice_date" type="text" id="invoice_date"  value="<?=($invoice_date!='')?$invoice_date:date('Y-m-d')?>"   required />									</td>
									<td width="10%">LC No:</td>
									<td width="23%">
									
									<input name="export_lc_no" type="text" id="export_lc_no"  readonly="" style="width:220px; height:32px;" value="<?=$lc_all->export_lc_no?>"  required tabindex="105" />										</td>
									<td width="19%">Customer Group:</td>
									<td width="21%">
									<select name="dealer_group" id="dealer_group" required style="width:220px;"  >
	
								
										<? foreign_relation('dealer_group','id','dealer_group',$dealer_group,'id="'.$lc_all->dealer_group.'"  order by id');?>
									</select></td>
								  </tr>
								  
								  
  
								  <tr>

								 <td>LC S/L:</td>

									<td>

					
									<input name="lc_no" type="hidden" id="lc_no" tabindex="1" value="<?=$lc_no?>" readonly>
								
								

				<input name="lc_no_view" type="text" id="lc_no_view" style="width:220px; height:32px;" value="<?=$lc_all->lc_no_view?>" readonly="" tabindex="105" />									</td>
									<td>LC Date:</td>
									<td>
								
									<input style="width:220px; height:32px;"  name="export_lc_date" type="text" id="export_lc_date"  value="<?=$lc_all->export_lc_date?>" required />																		</td>
									<td>Customer Name:</td>
									<td><span id="find_dealer">
									<select name="dealer_code" id="dealer_code" required style="width:220px;">
	
								
										<? foreign_relation('dealer_info','dealer_code','dealer_name_e',$dealer_code,'dealer_code="'.$lc_all->dealer_code.'"  order by dealer_code');?>
									</select>
									</span>										</td>
								  </tr>
								  <tr>
								    <td>Tolerance:</td>
								    <td>
									<table>
		  	<tr>
				<td><input name="tolerance" type="text" id="tolerance" required readonly="" style="width:100px; height:32px; " autocomplete="off"  value="<?=$lc_all->tolerance?>" />				</td>
				<td>&nbsp;&nbsp; %(+/-)</td>
			</tr>
		  </table>									</td>
								    <td>Expiry Date:</td>
								    <td><input style="width:220px; height:32px;"  name="expiry_date" type="text" id="expiry_date" readonly="" value="<?=$lc_all->expiry_date?>"   required /></td>
								    <td>Customer Bank:</td>
								    <td>
									<span id="find_dealer_bank">
									<select name="bank_buyers" id="bank_buyers" required style="width:220px;">
	
									
								
										<? foreign_relation('bank_buyers','bank_id','bank_name',$bank_buyers,'bank_id="'.$lc_all->bank_buyers.'"   order by bank_id');?>
									</select>
									</span>									</td>
							      </tr>
								  <tr>
								    <td>Remarks:</td>
								    <td><input name="remarks" type="text" id="remarks" style="width:220px; height:32px;" value="<?=$lc_all->remarks?>"  tabindex="105" /></td>
								    <td>Tenor:</td>
								    <td>
									<select name="tenor_days" id="tenor_days" required style="width:220px;">
	
		
										 <? foreign_relation('tenor_days','tenor_days','tenor_type',$tenor_days,'tenor_days="'.$lc_all->tenor_days.'" order by id');?>
									</select>									</td>
								    <td>Contact No:</td>
								    <td><input name="contact_no" type="text" id="contact_no" style="width:220px; height:32px;" value="<?=$lc_all->contact_no?>"  tabindex="105" /></td>
							      </tr>
								  <tr>
								    <td>LDBC No: </td>
								    <td><input name="ldbc_no" type="text" id="ldbc_no" style="width:220px; height:32px;" value="<?=$ldbc_no;?>"  required tabindex="105" /></td>
								    <td>LDBC Date: </td>
								    <td><input name="ldbc_no_date" type="text" id="ldbc_no_date" style="width:220px; height:32px;" value="<?=$ldbc_no_date?>" required  tabindex="105" /></td>
								    <td>Maturity Receive Date:</td>
								    <td><input name="maturity_rec_date" type="text" id="maturity_rec_date" style="width:220px; height:32px;" value="<?=$maturity_rec_date?>"  tabindex="105" /></td>
							      </tr>
								</table>

    </div>

<br />

<?

if($lc_no>0){

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
    </tr>
  

  <?
  
  
  if($_POST['fdate']!=''&&$_POST['tdate']!='') $date_con .= ' and c.chalan_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
  
  
		//if($_POST['dealer_code']!='')
// 		$dealer_con=" and m.dealer_code='".$_POST['dealer_code']."'";
//		
//		if($_POST['do_no']!='') 
//		$do_con .= ' and m.do_no in ('.$_POST['do_no'].') ';


		 $sql = "select   pi_id, pi_id as pi_no from lc_receive where 1 group by pi_id";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $pi_no[$info->pi_id]=$info->pi_no;
		
		
		}

		
		

    $sql = "select  m.*, d.pi_id, d.pi_type, d.pi_no,d.pi_date
   from lc_master m, lc_receive d
   where m.lc_no=d.lc_no and m.lc_no='".$lc_no."'  order by  d.pi_id ";

  $query = db_query($sql);

  while($data=mysqli_fetch_object($query)){$i++;


  ?>



<?php /*?><? if($pi_no[$data->pi_id]==$data->pi_no) {}  ?><?php */?>

  <tr bgcolor="<?=($i%2)?'#E8F3FF':'#fff';?>">

    <td><a title="WO Preview" target="_blank" href="../../../sales_mod/pages/wo/work_order_print_view.php?v_no=<?=$data->do_no?>"><?=$data->pi_no?></a></td>

    <td><?php echo date('d-m-Y',strtotime($data->pi_date));?></td>
    <td><?= find_a_field('pi_type','pi_type','id="'.$data->pi_type.'"');?></td>
    <td><?= find_a_field('dealer_info','dealer_name_e','dealer_code='.$data->dealer_code);?></td>
    <td><?= find_a_field('pi_details','sum(total_unit)','pi_id="'.$data->pi_id.'"');?></td>
    <td><?= find_a_field('pi_details','sum(total_amt)','pi_id="'.$data->pi_id.'"');?>
	<input name="pi_id_<?=$data->pi_id?>" type="hidden" id="pi_id_<?=$data->pi_id?>" value="<?=$data->pi_no?>" />	</td>
    </tr>

  <?  }?>
</table>

<br /><br />

</div>


<table width="100%" border="0">






<tr>

<td align="center">&nbsp;

</td>

<td align="center">
<!--<input  name="do_no" type="hidden" id="do_no" value="<?=$_POST['do_no'];?>"/>-->
<input name="confirm" type="submit" class="btn1" value="COMPLETE" style="width:270px; font-weight:bold; float:right; font-size:12px; height:30px; color:#090" /></td>

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