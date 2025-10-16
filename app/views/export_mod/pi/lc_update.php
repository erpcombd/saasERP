<?php

//

//


 
 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Master PI Entry';

create_combobox('pi_id');
create_combobox('dealer_code');

create_combobox('dealer_pi');

do_calander('#fdate');
do_calander('#tdate');

do_calander('#odate');








if(prevent_multi_submit()){



if(isset($_POST['confirm'])){
	
	$status = 'UNCHECKED';
	$checked_by = $_SESSION['user']['id'];
	$checked_at=date('Y-m-d H:i:s');
		
	$pi_id = $_POST['pi_id'];
	
	$pi_data = find_all_field('pi_master','','id='.$pi_id);
	
	
	if ($pi_data->pi_type==2) {

		// $status = 'PROCESSING';
		$status = 'CHECKED';

		} elseif ($pi_data->pi_type==3) {
		
		$status = 'CHECKED';
			 
		}
	
	
	

	$new_sql="UPDATE pi_master SET status='".$status."' WHERE id = '".$pi_id."' ";
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
//$recipients2 =$sms_rec->receiver_4;
//$massage  = "Dear Sir,\r\nRequest for PI Approval. \r\n";
//$massage  .= "PI No : ".$pi_no_generate." \r\n";
//$massage  .= "Login : https://boxes.com.bd/NATIVE/lc_mod/pages/main/index.php?module_id=13 \r\n";
//$sms_result=sms($recipients, $massage);
//if($recipients2>0) {
//$sms_result=sms($recipients2, $massage);
//}
//	
////Text Sms
//
//		}
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
		

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



	function update_value(do_no)



	{



var do_no=do_no; // Rent


var pi_id=(document.getElementById('pi_id').value);


var flag=(document.getElementById('flag_'+do_no).value); 

var strURL="lc_update_ajax.php?do_no="+do_no+"&pi_id="+pi_id+"&flag="+flag;



		var req = getXMLHTTP();



		if (req) {



			req.onreadystatechange = function() {

				if (req.readyState == 4) {

					// only if "OK"

					if (req.status == 200) {						

						document.getElementById('divi_'+do_no).style.display='inline';

						document.getElementById('divi_'+do_no).innerHTML=req.responseText;						

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
        <td width="16%" align="right" bgcolor="#FF9966"><strong>PI No:</strong></td>
        <td width="40%" bgcolor="#FF9966">
		<select name="pi_id" id="pi_id" required style="width:280px;">
		
		<option></option>

        <? foreign_relation('pi_master','id','pi_no',$_POST['pi_id'],'pi_type!=1 and status="MANUAL" order by id');?>
    </select>	
	
	
	<? $pi_data = find_all_field('pi_master','','id='.$_POST['pi_id']);?>		</td>
        <td width="18%" bgcolor="#FF9966"><?=$pi_data->pi_date;?></td>
        <td width="26%" rowspan="7" bgcolor="#FF9966"><strong>
          <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
        </strong></td>
      </tr>
	  
	  <? if($_POST['pi_id']>0) {?>
      <tr>
        <td align="right" bgcolor="#FF9966"><strong>PI Address:</strong></td>
        <td bgcolor="#FF9966">
		<select name="dealer_pi" id="dealer_pi" required style="width:280px;">
	

        <? foreign_relation('dealer_info','dealer_code','dealer_name_e',$_POST['dealer_pi'],'dealer_code="'.$pi_data->dealer_code.'"');?>
    </select></td>
        <td bgcolor="#FF9966">&nbsp;</td>
      </tr>
	  <? }?>
	  
    </table>

<br />

<?

if(isset($_POST['submitit'])){

?>

<div class="tabledesign2" style="width:100%">

<table width="100%" border="0" align="center" id="grp" cellpadding="0" cellspacing="0" style="font-size:12px; text-transform:uppercase;">

  <tr>

    <th width="4%">Job No </th>

    <th width="8%">Order Date </th>
    <th width="21%">CUSTOMER Name </th>
    <th width="14%">Buyer Name </th>
    <th width="14%">MERCHANDISER</th>
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


		 $sql = "select   c.do_no, c.do_no as find_do  from sale_do_master m, pi_details c where m.do_no=c.do_no and c.pi_type in (2,3) group by c.do_no ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $find_do[$info->do_no]=$info->find_do;
		}

		
		

    $sql = "select  m.*,  sum(c.total_unit) as wo_qty, sum(c.total_amt) as wo_amt
   from sale_do_master m, sale_do_details c, dealer_info d
   where m.do_no=c.do_no and d.dealer_code='".$pi_data->dealer_code."' and m.dealer_code=d.dealer_code  and m.status in ('COMPLETED','CHECKED') ".$date_con.$dealer_con.$do_con." group by c.do_no  order by  m.job_no ";

  $query = db_query($sql);

  while($data=mysqli_fetch_object($query)){$i++;

 // $op = find_all_field('journal_item','','warehouse_id="'.$_POST['warehouse_id'].'" and group_for="'.$_POST['group_for'].'" and item_id = "'.$data->item_id.'" and tr_from = "Opening" order by id desc');

  ?>



<? if($find_do[$data->do_no]==0) {  ?>

  <tr bgcolor="<?=($i%2)?'#E8F3FF':'#fff';?>">

    <td><a title="WO Preview" target="_blank" href="../../../sales_mod/pages/wo/work_order_print_view.php?v_no=<?=$data->do_no?>"><?=$data->job_no?></a></td>

    <td><?php echo date('d-m-Y',strtotime($data->do_date));?></td>
    <td><?= find_a_field('dealer_info','dealer_name_e','dealer_code='.$data->dealer_code);?></td>
    <td><?= find_a_field('buyer_info','buyer_name','buyer_code='.$data->buyer_code);?></td>
    <td><?= find_a_field('merchandizer_info','merchandizer_name','merchandizer_code='.$data->merchandizer_code);?></td>
    <td><?= $data->wo_qty;?></td>
    <td><?= $data->wo_amt;?></td>
    <td><span id="divi_<?=$data->do_no?>">

     

	<input name="flag_<?=$data->do_no?>" type="hidden" id="flag_<?=$data->do_no?>" value="0" />

	 <input type="button" name="Button" value="Approve"  onclick="update_value(<?=$data->do_no?>)" style="width:70px; font-size:12px; height:30px;background-color:#66CC66"/>
			  


          </span>&nbsp;</td>
  </tr>

  <?  }}?>
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