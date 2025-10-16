<?php

//

//


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='FOC Approval Requests';

//create_combobox('pi_id');
create_combobox('dealer_code');
do_calander('#pi_date');
do_calander('#fdate');
do_calander('#tdate');

do_calander('#odate');

do_calander('#app_date');






if(prevent_multi_submit()){



if(isset($_POST['confirm'])){

	
		
	$status = 'CHECKED';
	$checked_by = $_SESSION['user']['id'];
	$checked_at=date('Y-m-d H:i:s');
		

		
		//$chalan_no = next_transection_no('0',$issue_date,'sale_do_production_issue','chalan_no');
		
	
	
		
		
		 if($_POST['fdate']!=''&&$_POST['tdate']!='') $date_con .= ' and m.pi_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
  
  
		if($_POST['dealer_code']!='')
 		$dealer_con=" and m.dealer_code='".$_POST['dealer_code']."'";

		
		 
		 
	$sql = "select  m.*,  t.pi_type, sum(c.total_unit) as pi_qty, sum(c.total_amt) as pi_amt
   from pi_master m, pi_details c, pi_type t 
   where m.id=c.pi_id and m.pi_type=t.id and m.status='UNCHECKED'  ".$date_con.$dealer_con." group by c.pi_id  order by  m.id ";

		$query = db_query($sql);

		//$pr_no = next_pr_no($warehouse_id,$rec_date);


		while($data=mysqli_fetch_object($query))

		{
	

			if($_POST['app_pi_'.$data->id]>0)

			{
			

	$pi_id=$_POST['app_pi_'.$data->id];


   $YR = date('Y',strtotime($data->pi_date));
   $year = date('y',strtotime($data->pi_date));
   $month = date('m',strtotime($data->pi_date));
   $digital_sign_id = find_a_field('pi_master','max(digital_sign_id)','year="'.$YR.'"')+1;
   $cy_id = sprintf("%08d", $digital_sign_id);
   $digital_sign=$year.''.$month.''.$cy_id;
   
   
   
   			$new_sql="UPDATE pi_master SET status='".$status."', digital_sign_id = '".$digital_sign_id."', digital_sign = '".$digital_sign."', 
			 checked_by = '".$checked_by."', checked_at = '".$checked_at."' WHERE id = '".$pi_id."'";
			 db_query($new_sql);
				
				
		$am_ins = "INSERT INTO management_approval_history (tr_no, tr_no_view, tr_date, tr_type, year, digital_sign_id, digital_sign, checked_by, checked_at)
  
  VALUES('".$pi_id."', '".$data->pi_no."', '".$data->pi_date."', '".$data->pi_type."', '".$YR."', '".$digital_sign_id."', '".$digital_sign."', 
  '".$checked_by."',  '".$checked_at."')";

db_query($am_ins);



}

}



	

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



	function update_value(id,val)

	{

var id=id; // Rent

var val;

var app_date=(document.getElementById('app_date').value);
//var dealer_group=(document.getElementById('dealer_group').value);
//var dealer_code=(document.getElementById('dealer_code').value);



var flag=(document.getElementById('flag_'+id).value); 

var strURL="pi_approval_ajax.php?id="+id+"&app_date="+app_date+"&flag="+flag+"&val="+val;


//alert(val);

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









	function update_value2(foc_no,valw)

	{

var foc_no=foc_no; // Rent

var valw;

var app_date=(document.getElementById('app_date').value);
//var dealer_group=(document.getElementById('dealer_group').value);
//var dealer_code=(document.getElementById('dealer_code').value);


var flag=(document.getElementById('flag_'+foc_no).value); 

var strURL="foc_approval_ajax.php?foc_no="+foc_no+"&app_date="+app_date+"&flag="+flag+"&valw="+valw;



		var req = getXMLHTTP();



		if (req) {



			req.onreadystatechange = function() {

				if (req.readyState == 4) {

					// only if "OK"

					if (req.status == 200) {						

						document.getElementById('divi_'+foc_no).style.display='inline';

						document.getElementById('divi_'+foc_no).innerHTML=req.responseText;						

					} else {

						alert("There was a problem while using XMLHTTP:\n" + req.statusText);

					}

				}				

			}

			req.open("GET", strURL, true);

			req.send(null);

		}	

}





	function update_value3(do_no,valh)

	{

var do_no=do_no; // Rent

var valh;

var app_date=(document.getElementById('app_date').value);
//var dealer_group=(document.getElementById('dealer_group').value);
//var dealer_code=(document.getElementById('dealer_code').value);


var flag=(document.getElementById('flag_'+do_no).value); 

var strURL="woh_approval_ajax.php?do_no="+do_no+"&app_date="+app_date+"&flag="+flag+"&valh="+valh;



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





	function update_value4(do_no,valuh)

	{

var do_no=do_no; // Rent

var valuh;

var app_date=(document.getElementById('app_date').value);
//var dealer_group=(document.getElementById('dealer_group').value);
//var dealer_code=(document.getElementById('dealer_code').value);


var flag=(document.getElementById('flag_'+do_no).value); 

var strURL="wouh_approval_ajax.php?do_no="+do_no+"&app_date="+app_date+"&flag="+flag+"&valuh="+valuh;



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






	function update_value5(do_no,valc)

	{

var do_no=do_no; // Rent

var valc;

var app_date=(document.getElementById('app_date').value);
//var dealer_group=(document.getElementById('dealer_group').value);
//var dealer_code=(document.getElementById('dealer_code').value);


var flag=(document.getElementById('flag_'+do_no).value); 

var strURL="wocl_approval_ajax.php?do_no="+do_no+"&app_date="+app_date+"&flag="+flag+"&valc="+valc;



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


@media only screen and (max-width: 768px) {
  /* For mobile phones: */
  .form-container_large {
    width: 100%;
  }
</style>



<div class="form-container_large">

<form action="" method="post" name="codz" id="codz">


<div class="jumbotron" >
<div class="row "  >
	<div class="col-xs-4" >
	
	
	</div>
	<div class="col-xs-4" style="margin:0 auto;">
	<strong>Approve Date:</strong>
	<input type="hidden" name="fdate" id="fdate" value="<?=$_POST['fdate']?>" />
		<input type="text" name="app_date" id="app_date"  value="<?=date('Y-m-d')?>" />	
	</div>
	<div class="col-xs-4"></div>
</div>




<div class="row">
	<div class="col-xs-4" >
	
	
	</div>
	<div class="col-xs-4" style="margin:0 auto;">
	<strong>Customer Name:</strong><br />
<select name="dealer_code" id="dealer_code"  style="width:220px;">
		
											<option></option>
									
											<? foreign_relation('dealer_info','dealer_code','dealer_name_e',$_POST['dealer_code'],'1 order by dealer_code');?>
		  </select>
	</div>
	<div class="col-xs-4">
	
	</div>
</div>
<div class="row">
	<div class="col-xs-4">

	</div>
	<div class="col-xs-4" style="margin:0 auto;">
  <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" class="btn btn-info"/>
	</div>
	<div class="col-xs-4">
	
	</div>
</div>

</div>



<?php /*?><? if(isset($_POST['submitit'])){ ?><? }?><?php */?>


<?



  
  
		if($_POST['dealer_code']!='')
 		$dealer_con=" and m.dealer_code='".$_POST['dealer_code']."'";


?>




<div class="tabledesign2" style="width:100%">

<table width="100%" border="0" align="center" id="grp" cellpadding="0" cellspacing="0" style="font-size:12px; text-transform:uppercase;">

  
  <tr>

    <th width="2%">FOC No </th>

    <th width="6%">FOC Date </th>
    <th width="5%">JOB No </th>
    <th width="17%">CUSTOMER Name </th>
    <th width="9%">Buyer </th>
    <th width="13%">Marketing Person</th>
    <th width="5%">Order Qty </th>
    <th width="5%">Delivery qty</th>
    <th width="4%">FOC Qty </th>
    <th width="4%">FOC Value </th>
    <th width="10%">Reason</th>
    <th>
	<table  width="100%" border="0" align="center" id="grp" cellpadding="0" cellspacing="0" >
	<tr>
		<th width="34%" height="100%">
		Approve		</th>
		<th width="33%"  height="100%">
		Hold		</th>
		<th width="33%"  height="100%">
		Reject		</th>
	</tr>
	</table>	</th> 
    </tr>
  


 
  
  
  

  
  
  
  
  

  <?
  
  
    if($_POST['fdate']!=''&&$_POST['tdate']!='') $wo_date_con .= ' and m.do_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
  
//		
//		if($_POST['do_no']!='') 
//		$do_con .= ' and m.do_no in ('.$_POST['do_no'].') ';


		//$sql = "select   c.do_no, sum(c.total_amt) as pi_amt  from sale_do_master m, pi_details c where m.do_no=c.do_no group by c.do_no ";
//		 $query = db_query($sql);
//		 while($info=mysqli_fetch_object($query)){
//  		 $pi_amt[$info->do_no]=$info->pi_amt;
//		
//		
//		}

		
		

   $sql2 = "select  m.*,  sum(c.total_unit) as total_unit, sum(c.total_amt) as total_amt
   from sale_foc_master m, sale_foc_details c 
   where m.do_no=c.do_no and m.status='UNCHECKED'  ".$wo_date_con.$dealer_con.$do_con." group by c.do_no  order by m.wo_mis_hold, m.do_no ";

  $query2 = db_query($sql2);

  while($data2=mysqli_fetch_object($query2)){$i++;

 // $op = find_all_field('journal_item','','warehouse_id="'.$_POST['warehouse_id'].'" and group_for="'.$_POST['group_for'].'" and item_id = "'.$data->item_id.'" and tr_from = "Opening" order by id desc');

  ?>



<?php /*?><? if($data->wo_amt!=$pi_amt[$data->do_no]) {  } ?><?php */?>

  <tr>

    <td bgcolor="#DAD1E6">
<a href="../../../sales_mod/pages/foc/foc_order_print_view.php?v_no=<?=$data2->foc_no;?>" target="_blank" style=" color:#000000; font-size:14px; font-weight:700;"> <?=$data2->foc_no;?></a></td>

    <td bgcolor="#DAD1E6"><?php echo date('d-m-Y',strtotime($data2->foc_date));?></td>
    <td bgcolor="#DAD1E6"><a href="../../../sales_mod/pages/wo/work_order_print_view.php?v_no=<?=$data2->do_no;?>" target="_blank" style=" color:#000000; font-size:14px; font-weight:700;">
      <?=$data2->job_no;?>
    </a></td>
    <td bgcolor="#DAD1E6"><?= find_a_field('dealer_info','dealer_name_e','dealer_code='.$data2->dealer_code);?></td>
    <td bgcolor="#DAD1E6"><?= find_a_field('buyer_info','buyer_name','buyer_code='.$data2->buyer_code);?></td>
    <td bgcolor="#DAD1E6"><?= find_a_field('marketing_person','marketing_person_name','person_code='.$data2->marketing_person);?></td>
    <td bgcolor="#DAD1E6"><?= find_a_field('sale_do_details','sum(total_unit)','do_no='.$data2->do_no);?></td>
    <td bgcolor="#DAD1E6"><?= find_a_field('sale_do_chalan','sum(total_unit)','do_no='.$data2->do_no);?></td>
    <td bgcolor="#DAD1E6" style="color:#FF0000; font-size:14px; font-weight:700;"><?= $data2->total_unit;?>
	
	<input name="app_pi_<?=$data2->foc_no?>" type="hidden" id="app_pi_<?=$data2->foc_no?>" value="<?=$data2->foc_no?>" />	</td>
    <td bgcolor="#DAD1E6" style="color:#FF0000; font-size:14px; font-weight:700;"><?= $data2->total_amt;?></td>
    <td bgcolor="#DAD1E6"><?= $data2->foc_reason;?></td>
    <td bgcolor="#DAD1E6"><span id="divi_<?=$data2->foc_no?>">

     
<table border="0" width="100%">
	<tr>
		<td width="34%">
		<? if($data2->wo_mis_hold!="Yes") {?>
		<input name="flag_<?=$data2->foc_no?>" type="hidden" id="flag_<?=$data2->foc_no?>" value="0" />

	 <input type="button" name="Button" value="Approve"  onclick="update_value2(<?=$data2->foc_no?>,1)" style="width:70px; font-size:12px; height:30px;background-color:#66CC66"/>
	  <? }?>	 </td>
		<td  width="33%">
		<? if($data2->wo_mis_hold=="Yes") {?>
	<input name="flag_<?=$data2->foc_no?>" type="hidden" id="flag_<?=$data2->foc_no?>" value="0" />
	<input type="button" name="Button" value="Unhold"  onclick="update_value2(<?=$data2->foc_no?>,2)" style="width:70px; font-size:12px; height:30px;background-color: #0389A6"/>
	<? } else {?>

<input name="flag_<?=$data2->foc_no?>" type="hidden" id="flag_<?=$data2->foc_no?>" value="0" />
	<input type="button" name="Button" value="Hold"  onclick="update_value2(<?=$data2->foc_no?>,3)" style="width:70px; font-size:12px; height:30px;background-color: #0389A6"/>
	  <? }?>		</td>
		<td  width="33%">
		
		<? if($data2->wo_mis_hold!="Yes") {?>
		
			
<input name="flag_<?=$data2->foc_no?>" type="hidden" id="flag_<?=$data2->foc_no?>" value="0" />
	      
		  <input type="button" name="Button" value="Reject"  onclick="update_value2(<?=$data2->foc_no?>,4)" style="width:70px; font-size:12px; height:30px;background-color:#F25B3C"/>		
		  
  <? }?>		  </td>
	</tr>
</table>
	


          </span>	      </td>
    </tr>

  <? }?>
</table>
  </div>
<br /><br />



<?php /*?><table width="100%" border="0">

<? 

 		$pi_pending_count = find_a_field('pi_master','count(id)','status="UNCHECKED"');
		 // $issue_qty = find_a_field('sale_do_production_issue','sum(total_unit)','do_no='.$_POST['do_no']);


if($pi_pending_count==0){




?>

<tr>

<td colspan="2" align="center" bgcolor="#FF3333"><strong>All PI Approved</strong></td>

</tr>

<? }else{?>

<tr>

<td align="center">&nbsp;

</td>

<td align="center">
<!--<input  name="do_no" type="hidden" id="do_no" value="<?=$_POST['do_no'];?>"/>-->
<input name="confirm" type="hidden" class="btn1" value="All Approve" style="width:270px; font-weight:bold; float:right; font-size:12px; height:30px; color:#090" /></td>

</tr>

<? }?>

</table><?php */?>





<p>&nbsp;</p>

</form>

</div>



<?

//

//

require_once SERVER_CORE."routing/layout.bottom.php";

?>