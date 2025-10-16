<?php

//

//


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='WO Revise Entry';

//create_combobox('dealer_code');

do_calander('#po_date');
//do_calander('#tdate');

//do_calander('#odate');


 $data_found = $_POST['do_no'];

if ($data_found==0) {
 create_combobox('do_no');
  }




if(prevent_multi_submit()){



if(isset($_POST['confirm'])){
	
	$status = 'CHECKED';
	$checked_by = $_SESSION['user']['id'];
	$checked_at=date('Y-m-d H:i:s');
		
	$bill_id = $_POST['bill_id'];
	


	$new_sql="UPDATE po_bill_master SET status='".$status."' WHERE bill_id = '".$bill_id."' ";
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
window.location.href = "po_bill_pending.php";
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
	
	
	

function TRcalculation(order_no){

var unit_price = document.getElementById('unit_price_'+order_no).value*1;
var total_unit = document.getElementById('total_unit_'+order_no).value*1;
var total_amt = document.getElementById('total_amt_'+order_no).value= (unit_price*total_unit);

// if(unit_price<final_price)
//  {
//alert('You can`t reduce the price');
//document.getElementById('unit_price#'+id).value='';
//  } 

}




	function update_value(order_no)



	{

var order_no=order_no; // Rent

var item_id=(document.getElementById('item_id_'+order_no).value);
var color=(document.getElementById('color_'+order_no).value);
var referance=(document.getElementById('referance_'+order_no).value);
var shade=(document.getElementById('shade_'+order_no).value);
var po_no=(document.getElementById('po_no_'+order_no).value);
var style_no=(document.getElementById('style_no_'+order_no).value);
var pack_type=(document.getElementById('pack_type_'+order_no).value);
var sst=(document.getElementById('sst_'+order_no).value);

var unit_price=(document.getElementById('unit_price_'+order_no).value);
var total_unit=(document.getElementById('total_unit_'+order_no).value);
var total_amt=(document.getElementById('total_amt_'+order_no).value);

var flag=(document.getElementById('flag_'+order_no).value); 

var strURL="wo_revise_ajax.php?order_no="+order_no+"&item_id="+item_id+"&color="+color+"&referance="+referance+"&shade="+shade+"&po_no="+po_no+"&style_no="+style_no+"&pack_type="+pack_type+"&sst="+sst+"&unit_price="+unit_price+"&total_unit="+total_unit+"&total_amt="+total_amt+"&flag="+flag;





		var req = getXMLHTTP();



		if (req) {



			req.onreadystatechange = function() {

				if (req.readyState == 4) {

					// only if "OK"

					if (req.status == 200) {						

						document.getElementById('divi_'+order_no).style.display='inline';

						document.getElementById('divi_'+order_no).innerHTML=req.responseText;						

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
    width: 220px;
    height: 38px;
    border-radius: 0px !important;
}



</style>

<div class="form-container_large">


<form action="" method="post" name="codz" id="codz">

<? if ($data_found==0) { ?>

<div class="box" style="width:100%;">

								<table width="100%" border="0" cellspacing="0" cellpadding="0">

								  <tr>



    <td width="9%" align="right" ><strong>WO NO: </strong></td>



    <td width="34%" ><select name="do_no" id="do_no" style="width:220px;" required>
      <option></option>
      <? foreign_relation('sale_do_master','do_no','job_no',$_POST['do_no'],'status="CHECKED"');?>
    </select></td>
	
	
	 <td width="10%" rowspan="4" >&nbsp;</td>
	 <td width="47%" rowspan="4" ><strong>

      <input type="submit" name="submit" id="submit" value="View Data" style="width:180px; text-align:center; font-weight:bold; font-size:12px; height:30px; color:#090"/>

    </strong></td>
    </tr>
								</table>

</div>


<? }?>

<? if($data_found>0){ ?>


<div class="box" style="width:100%;">

								<table width="100%" border="0" cellspacing="0" cellpadding="0">

								  <tr>

								 <td width="8%">Job No:</td>

									<td width="20%">
									
									<? $ms_data = find_all_field('sale_do_master','','do_no='.$_POST['do_no']); ?>
									
									<input name="do_no" type="hidden" id="do_no" tabindex="1" value="<?=$ms_data->do_no?>" readonly>
								
								

								<input name="job_no" type="text" id="job_no" style="width:200px; height:32px;" value="<?=$ms_data->job_no?>" readonly="" tabindex="105" />									</td>
									<td width="11%">Cust. Group:</td>
									<td width="22%">
									
									<input name="cut_group" type="text" id="cut_group"  readonly="" style="width:220px; height:32px;"  
									value="<?=find_a_field('dealer_group','dealer_group',"id=".$ms_data->dealer_group);?>"   required  />										</td>
								    <td width="17%"><span style="width:220px;">Merchandiser</span>:</td>
								    <td width="22%"><input name="merchandiser" type="text" id="merchandiser"  readonly="" style="width:220px; height:32px;"  
									value="<?=find_a_field('merchandizer_info','merchandizer_name','merchandizer_code='.$ms_data->merchandizer_code);?>"   required  /></td>
								  </tr>
								  
								  
  
								  <tr>

								 <td> Job Date:</td>

									<td>

									
									
									<input style="width:200px; height:32px;"  name="do_date" type="text" id="do_date"  value="<?=$ms_data->do_date?>"  readonly="" required />									</td>
									<td>Cust. Name:</td>
									<td>
								
									<input style="width:220px; height:32px;"  name="cust_name" type="text" id="cust_name" readonly="" 
									value="<?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$ms_data->dealer_code);?>"  />																		</td>
								    <td><span style="width:220px;">Buyer</span>:</td>
								    <td><input name="buyer" type="text" id="buyer"  readonly="" style="width:220px; height:32px;"  
									value="<?=find_a_field('buyer_info','buyer_name','buyer_code='.$ms_data->buyer_code);?>"  required  /></td>
								  </tr>
								</table>
								
	</div>
								
		<div class="box" style="width:100%;">						
								<table width="100%">
                            <thead>
                              <tr class="oe_list_header_columns">
                                <th width="46%"><input name="create" type="submit" id="create" value="VIEW DATA" style="width:150px; height:30px; background:#20B2AA; color:#000000; font-weight:700;" /></th>
                                <th width="31%"><a href="../wo/work_order_print_view.php?v_no=<?=$data_found?>" target="_blank" style="padding:5px 30px; background:#20B2AA; color:#000000; font-size:12px; font-weight:700;">WO View</a></th>
                                <th width="23%"><!--<a href="po_bill_top_shit_print_view.php?bill_id=<?=$bill_id?>" target="_blank"  style="padding:5px 30px; background:#20B2AA; color:#000000; font-size:12px; font-weight:700;">PO Top Sheet</a>--></th>
                              </tr>
                            </thead>
                            <tfoot>
                            </tfoot>
                            <tbody>
                            </tbody>
                          </table>

    </div>
	
<? }?>


<? if($data_found>0){ ?>

<div class="tabledesign2" style="width:100%">




<table width="100%" border="0" align="center" id="grp" cellpadding="0" cellspacing="0" style="font-size:12px; text-transform:uppercase;">

  <tr>

    <th width="9%">Color</th>

    <th width="10%"> Referance</th>
    <th width="15%">Shade</th>
    <th width="26%">PO No </th>
    <th width="14%">Style No</th>
    <th width="14%">Type</th>
    <th width="14%">SST</th>
    <th width="14%">Count</th>
    <th width="14%">Lenght</th>
    <th width="14%">US$</th>
    <th width="14%">Qty</th>
    <th width="14%">Value</th>
    <th width="14%"><div align="center">Action</div></th>
  </tr>
  

  <?
  
  
  if($_POST['fdate']!=''&&$_POST['tdate']!='') $date_con .= ' and c.chalan_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
  
  
		//if($_POST['dealer_code']!='')
// 		$dealer_con=" and m.dealer_code='".$_POST['dealer_code']."'";
//		
//		if($_POST['do_no']!='') 
//		$do_con .= ' and m.do_no in ('.$_POST['do_no'].') ';


    if($_POST['po_date']!='')
	$po_dt_con=" and m.po_date='".$_POST['po_date']."'";
	
	
	
	 	 //$sql = "select po_no, po_no from po_bill_details where 1 group by po_no";
//		 $query = db_query($sql);
//		 while($info=mysqli_fetch_object($query)){
//  		 $po_no[$info->po_no]=$info->po_no;
//	
//		}


		 $sql = "select id, reg_revise from sale_do_details where do_no='".$data_found."'";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $reg_revise[$info->id]=$info->reg_revise;
	
		}

		
		

    $sql = "select a.* from sale_do_details a, item_info b, item_sub_group s where b.item_id=a.item_id  and b.sub_group_id=s.sub_group_id and a.do_no=".$data_found." order by a.id ";

  $query = db_query($sql);

  while($data=mysqli_fetch_object($query)){$i++;

 // $op = find_all_field('journal_item','','warehouse_id="'.$_POST['warehouse_id'].'" and group_for="'.$_POST['group_for'].'" and item_id = "'.$data->item_id.'" and tr_from = "Opening" order by id desc');

  ?>



<? //if($po_no[$data->po_no]==0) { } ?>

  <tr bgcolor="<?=($i%2)?'#E8F3FF':'#fff';?>">

    <td>
	<input name="color_<?=$data->id?>" type="text" id="color_<?=$data->id?>" value="<?=$data->color?>" style="width:80px; height:30px; " /> 	</td>

    <td><input name="referance_<?=$data->id?>" type="text" id="referance_<?=$data->id?>" value="<?=$data->referance?>" style="width:100px; height:30px; " /></td>
    <td><input name="shade_<?=$data->id?>" type="text" id="shade_<?=$data->id?>" value="<?=$data->shade?>" style="width:80px; height:30px; " />
	 <input name="order_no_<?=$data->id?>" type="hidden" id="order_no_<?=$data->id?>" value="<?=$data->id?>" />
      <input name="item_id_<?=$data->id?>" type="hidden" id="item_id_<?=$data->id?>" value="<?=$data->item_id?>" />
		</td>
    <td><input name="po_no_<?=$data->id?>" type="text" id="po_no_<?=$data->id?>" value="<?=$data->po_no?>" style="width:80px; height:30px; " />
		</td>
    <td><input name="style_no_<?=$data->id?>" type="text" id="style_no_<?=$data->id?>" value="<?=$data->style_no?>" style="width:80px; height:30px; " /></td>
    <td>
	
	<select  name="pack_type_<?=$data->id?>" id="pack_type_<?=$data->id?>"  style="width:80px; height:30px;" required>
  
 		 <option></option>

     	 <? foreign_relation('dtm_setup','dtm','dtm',$data->pack_type,'1');?>
		 </select>
	
	</td>
    <td>
	<select  name="sst_<?=$data->id?>" id="sst_<?=$data->id?>"  style="width:80px; height:30px;" required>
  
 		 <option></option>

     	  <? foreign_relation('sst_setup','sst','sst',$data->sst,'1');?>
		 </select>
	
	</td>
    <td><input name="count_<?=$data->id?>" type="text" id="count_<?=$data->id?>" value="<?=$data->count?>"  readonly="" style="width:80px; height:30px; " /></td>
    <td><input name="length_<?=$data->id?>" type="text" id="length_<?=$data->id?>" value="<?=$data->length?>" readonly="" style="width:80px; height:30px; " /></td>
    <td bgcolor="#99CCFF"><input name="unit_price_<?=$data->id?>" type="text" id="unit_price_<?=$data->id?>" value="<?=$data->unit_price?>" onkeyup="TRcalculation(<?=$data->id?>)" style="width:80px; height:30px; " /></td>
    <td bgcolor="#99CCFF"><input name="total_unit_<?=$data->id?>" type="text" id="total_unit_<?=$data->id?>" value="<?=$data->total_unit?>" onkeyup="TRcalculation(<?=$data->id?>)" style="width:80px; height:30px; " /></td>
    <td bgcolor="#99CCFF"><input name="total_amt_<?=$data->id?>" type="text" id="total_amt_<?=$data->id?>" value="<?=$data->total_amt?>" readonly="" style="width:80px; height:30px; " /></td>
    <td>
	<? if($reg_revise[$data->id]>0) {?>
	<center><b>Done!</b></center>
	<? }else {?>
	<span id="divi_<?=$data->id?>">
	<input name="flag_<?=$data->id?>" type="hidden" id="flag_<?=$data->id?>" value="0" />

	<input type="button" name="Button" value="Save"  onclick="update_value(<?=$data->id?>)" style="width:70px; font-size:12px; height:30px; background-color:#66CC66; font-weight:700;"/>
    </span><? }?></td>
  </tr>

  <? } ?>
</table>
</div>
<br /><br />




<table width="100%" border="0">





<? if($bill_data->status!="COMPLETED") {?>
<tr>

<td align="center">&nbsp;

</td>

<td align="center">
<!--<input  name="do_no" type="hidden" id="do_no" value="<?=$_POST['do_no'];?>"/>-->
<!--<input name="confirm" type="submit" class="btn1" value="CONFIRM &amp; SEND" style="width:270px; font-weight:bold; float:right; font-size:12px; height:30px;  background: #1E90FF; color: #000000; border-radius: 50px 20px;" />--></td>

</tr>
<? }?>


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