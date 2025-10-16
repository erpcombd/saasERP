<?php

//

//


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='LC Receive';

//create_combobox('pi_id');
//create_combobox('dealer_code');

//do_calander('#fdate');
//do_calander('#tdate');

//do_calander('#odate');



  $lc_no 		= $_REQUEST['lc_no'];
  
  $lc_all = find_all_field('lc_master','','lc_no="'.$lc_no.'"');




if(prevent_multi_submit()){



if(isset($_POST['confirm'])){
	
	$status = 'CHECKED';
	$checked_by = $_SESSION['user']['id'];
	$checked_at=date('Y-m-d H:i:s');
		
	$lc_no = $_POST['lc_no'];
	


	$new_sql="UPDATE lc_master SET status='".$status."' WHERE lc_no = '".$lc_no."' ";
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
window.location.href = "pending_lc_list.php";
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

								 <td width="7%">LC S/L:</td>

									<td width="20%">
									
									<input name="lc_no" type="hidden" id="lc_no" tabindex="1" value="<?=$lc_no?>" readonly>
								
								

								<input name="lc_no_view" type="text" id="lc_no_view" style="width:220px; height:32px;" value="<?=$lc_all->lc_no_view?>" readonly="" tabindex="105" />

								
									</td>
									<td width="10%">LC No:</td>
									<td width="23%">
									
									<input name="export_lc_no" type="text" id="export_lc_no"  readonly="" style="width:220px; height:32px;" value="<?=$lc_all->export_lc_no?>"  required tabindex="105" />										</td>
									 
								  </tr>
								  
								  
  
								  <tr>

								 <td> Date:</td>

									<td>

									
									
									<input style="width:220px; height:32px;"  name="lc_date" type="text" id="lc_date"  value="<?=$lc_all->lc_date?>"  required />

									
																</td>
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
				<td><input name="tolerance" type="text" id="tolerance" required readonly="" style="width:100px; height:32px; " autocomplete="off"  value="<?=$lc_all->tolerance?>" /> 
				</td>
				<td>&nbsp;&nbsp; %(+/-)</td>
			</tr>
		  </table>
									</td>
								    <td>Expiry Date:</td>
								    <td><input style="width:220px; height:32px;"  name="expiry_date" type="text" id="expiry_date" readonly="" value="<?=$lc_all->expiry_date?>"   required /></td>
								    <td>Customer Bank:</td>
								    <td>
									<span id="find_dealer_bank">
									<select name="bank_buyers" id="bank_buyers" required style="width:220px;">
	
									
								
										<? foreign_relation('bank_buyers','bank_id','bank_name',$bank_buyers,'bank_id="'.$lc_all->bank_buyers.'"   order by bank_id');?>
									</select>
									</span>
									</td>
							      </tr>
								  <tr>
								    <td>Remarks</td>
								    <td><input name="remarks" type="text" id="remarks" style="width:220px; height:32px;" value="<?=$lc_all->remarks?>"  tabindex="105" /></td>
								    <td>Tenor:</td>
								    <td>
									<select name="tenor_days" id="tenor_days" required style="width:220px;">
	
		
										 <? foreign_relation('tenor_days','tenor_days','tenor_type',$tenor_days,'tenor_days="'.$lc_all->tenor_days.'" order by id');?>
									</select>
									</td>
								    <td>Contact No </td>
								    <td><input name="contact_no" type="text" id="contact_no" style="width:220px; height:32px;" value="<?=$lc_all->contact_no?>"  tabindex="105" /></td>
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
    <th width="9%"><div align="center">Action</div></th>
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
		
		
		 $sql = "select   p.pi_id, sum(w.total_unit) as pi_qty, sum(w.total_amt) as pi_amt from pi_master m, pi_details p, sale_do_details w where m.id=p.pi_id and  m.dealer_code='".$lc_all->dealer_code."' and  p.do_no=w.do_no group by p.pi_id";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $pi_qty[$info->pi_id]=$info->pi_qty;
		 $pi_amt[$info->pi_id]=$info->pi_amt;
		
		}

		
		

      $sql = "select  m.*, d.pi_id, sum(d.total_unit) as pi_qty, sum(d.total_amt) as pi_amt
   from pi_master m, pi_details d 
   where m.id=d.pi_id and m.dealer_code='".$lc_all->dealer_code."' and m.status='CHECKED' group by d.pi_id  order by  d.pi_id ";

  $query = db_query($sql);

  while($data=mysqli_fetch_object($query)){$i++;

 // $op = find_all_field('journal_item','','warehouse_id="'.$_POST['warehouse_id'].'" and group_for="'.$_POST['group_for'].'" and item_id = "'.$data->item_id.'" and tr_from = "Opening" order by id desc');

  ?>



<? if($pi_no[$data->pi_id]==0) {  ?>

  <tr bgcolor="<?=($i%2)?'#E8F3FF':'#fff';?>">

    <td>	
<? if ($data->pi_type==1 || $data->pi_type==3){  ?>
<a href="../pi/pi_print_view.php?v_no=<?=$data->id;?>" target="_blank" style=" color:#000000; font-size:12px; font-weight:700;"> <?=$data->pi_no;?></a><? }?>
<? if ($data->pi_type==2){  ?>
<a href="../pi/master_pi_print_view.php?v_no=<?=$data->id;?>" target="_blank" style=" color:#000000; font-size:12px; font-weight:700;"> <?=$data->pi_no;?></a><? }?>		
	
	</td>

    <td><?php echo date('d-m-Y',strtotime($data->pi_date));?></td>
    <td><?= find_a_field('pi_type','pi_type','id="'.$data->pi_type.'"');?></td>
    <td><?= find_a_field('dealer_info','dealer_name_e','dealer_code='.$data->dealer_code);?></td>
    <td><?=$pi_qty[$data->pi_id];?></td>
    <td><?=$pi_amt[$data->pi_id];?></td>
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