<?php

//

//


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='All Pending Approval Requests';

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









	function update_value2(do_no,valw)

	{

var do_no=do_no; // Rent

var valw;

var app_date=(document.getElementById('app_date').value);
//var dealer_group=(document.getElementById('dealer_group').value);
//var dealer_code=(document.getElementById('dealer_code').value);


var flag=(document.getElementById('flag_'+do_no).value); 

var strURL="wo_approval_ajax.php?do_no="+do_no+"&app_date="+app_date+"&flag="+flag+"&valw="+valw;



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







	function update_value31(po_no,valw)

	{

var po_no=po_no; // Rent

var valw;

var app_date=(document.getElementById('app_date').value);

var flag=(document.getElementById('flag_'+po_no).value); 

var strURL="po_approval_ajax.php?po_no="+po_no+"&app_date="+app_date+"&flag="+flag+"&valw="+valw;



		var req = getXMLHTTP();



		if (req) {



			req.onreadystatechange = function() {

				if (req.readyState == 4) {

					// only if "OK"

					if (req.status == 200) {						

						document.getElementById('divi_'+po_no).style.display='inline';

						document.getElementById('divi_'+po_no).innerHTML=req.responseText;						

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

    <th width="3%">TR No </th>

    <th width="5%">TR Date </th>
    <th width="23%">CUSTOMER Name </th>
    <th width="10%">Pending Value</th>
    <th width="9%">Document type</th>
    <th width="5%">STATUS</th>
    <th width="12%">Prepared by</th>
    <th width="5%"><div align="center">Approve</div></th>
    <th width="4%">Hold</th>
    <th width="19%">Reject</th>
  </tr>
  

  <?
  
  
  
  if($_POST['fdate']!=''&&$_POST['tdate']!='') $pi_date_con .= ' and m.pi_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
  
//		
//		if($_POST['do_no']!='') 
//		$do_con .= ' and m.do_no in ('.$_POST['do_no'].') ';


		// $sql = "select  dealer_code, sum(total_amt) as ch_amt  from sale_do_chalan where 1 group by dealer_code ";
//		 $query = db_query($sql);
//		 while($info=mysqli_fetch_object($query)){
//  		 $ch_amt[$info->dealer_code]=$info->ch_amt;
//		 }

		 // $sql = "SELECT dealer_code, chalan_date, chalan_no, sum(total_unit) as ch_qty, sum(total_amt) as ch_amt, max(chalan_date) as max_ch_date, min(chalan_date) as min_ch_date FROM sale_do_chalan WHERE  chalan_date< date_sub(now(),INTERVAL 90 day) GROUP by dealer_code";
//		 $query = db_query($sql);
//		 while($info=mysqli_fetch_object($query)){
//  		 $ch_amt[$info->dealer_code]=$info->ch_amt;
//		 $max_ch_date[$info->dealer_code]=$info->max_ch_date;
//		 }
//		 
//		 
//		 $sql = "select  dealer_code, sum(total_amt) as lc_amt  from lc_receive_details where 1 group by dealer_code ";
//		 $query = db_query($sql);
//		 while($info=mysqli_fetch_object($query)){
//  		 $lc_amt[$info->dealer_code]=$info->lc_amt;
//		 }

		
		

   $sql = "select  m.*,  sum(c.total_unit) as pi_qty, sum(c.total_amt) as pi_amt
   from pi_master m, pi_details c 
   where m.id=c.pi_id and m.status='UNCHECKED'  ".$pi_date_con.$dealer_con.$do_con." group by c.pi_id  order by m.mis_hold,  m.id ";

  $query = db_query($sql);

  while($data=mysqli_fetch_object($query)){$i++;

 // $op = find_all_field('journal_item','','warehouse_id="'.$_POST['warehouse_id'].'" and group_for="'.$_POST['group_for'].'" and item_id = "'.$data->item_id.'" and tr_from = "Opening" order by id desc');



		//$today_date = date("Y-m-d");
//		$acknow_date = strtotime($today_date);
//		$last_ch_date = strtotime($max_ch_date[$data->dealer_code]);
//		$datediff = $acknow_date - $last_ch_date;
//		$delay_days =  round($datediff / (60 * 60 * 24));

  ?>



<?php /*?><? if($data->wo_amt!=$pi_amt[$data->do_no]) {  } ?><?php */?>
<?php /*?>bgcolor="<?=($i%2)?'#E8F3FF':'#fff';?>"<?php */?>
  <tr >

    <td bgcolor="#C9DAEE">
	
<? if ($data->pi_type==1){  ?><a href="pi_print_view.php?v_no=<?=$data->id;?>" target="_blank" style=" color:#000000; font-size:14px; font-weight:700;"> <?=$data->pi_no;?></a><? }?>
<? if ($data->pi_type==2){  ?><a href="master_pi_print_view.php?v_no=<?=$data->id;?>" target="_blank" style=" color:#000000; font-size:14px; font-weight:700;"> <?=$data->pi_no;?></a><? }?>

<? if ($data->pi_type==3){  ?><a href="pi_print_view.php?v_no=<?=$data->id;?>" target="_blank" style=" color:#000000; font-size:14px; font-weight:700;"> <?=$data->pi_no;?></a><? }?>	</td>

    <td bgcolor="#C9DAEE"><?php echo date('d-m-Y',strtotime($data->pi_date));?></td>
    <td bgcolor="#C9DAEE"><?= find_a_field('dealer_info','dealer_name_e','dealer_code='.$data->dealer_code);?></td>
    <td bgcolor="#C9DAEE">
	
	<?
	
	 $psql = "select a.do_no from sale_do_chalan a where  a.dealer_code='".$data->dealer_code."' and a.chalan_date< date_sub(now(),INTERVAL 90 day) group by a.do_no ";
	$pquery		= db_query($psql);
	$pcount     = mysqli_num_rows($pquery);
	if($pcount>0)
	{
	while($info=mysqli_fetch_object($pquery)){
	++$c;
	if($c==1){$do_no .= $info->do_no;}
	else{$do_no .= ','.$info->do_no;}
	}
	}
	
	

	
  $ch_sql="SELECT sum(c.total_amt) as ch_amt FROM sale_do_chalan c WHERE c.do_no in  (".$do_no.") and c.dealer_code='".$data->dealer_code."' ";
$tot_ch_amt = find_a_field_sql($ch_sql);

 $lc_sql="SELECT sum(c.total_amt) as lc_amt FROM lc_receive_details c WHERE c.do_no in  (".$do_no.") and c.dealer_code='".$data->dealer_code."' ";
$tot_lc_amt = find_a_field_sql($lc_sql);

 
	?>
	
	
	
	
	
	$<?= number_format($lc_pending_value = ($tot_ch_amt-$tot_lc_amt),2);?>
	
	<?php /*?><? if($pending_value>0) { ?>
	<?=$delay_days;?>
<? }?><?php */?>	</td>
    <td bgcolor="#C9DAEE"><?= find_a_field('pi_type','pi_type','id='.$data->pi_type);?></td>
    <td bgcolor="#C9DAEE"><?= $data->status;?>
	
	<input name="app_pi_<?=$data->id?>" type="hidden" id="app_pi_<?=$data->id?>" value="<?=$data->id?>" />	</td>
    <td bgcolor="#C9DAEE"><?= find_a_field('user_activity_management','fname','user_id='.$data->entry_by);?></td>
    <td colspan="3" bgcolor="#C9DAEE"><span id="divi_<?=$data->id?>">
	
	
<table border="0" width="100%">
	<tr>
		<td width="34%">
		<? if($data->mis_hold!="Yes") {?>
		<input name="flag_<?=$data->id?>" type="hidden" id="flag_<?=$data->id?>" value="0" />

	 <input type="button" name="Button" value="Approve"  onclick="update_value(<?=$data->id?>,1)" style="width:70px; font-size:12px; height:30px;background-color:#66CC66"/>
	  <? }?>	 </td>
		<td  width="33%">
		<? if($data->mis_hold=="Yes") {?>
	<input name="flag_<?=$data->id?>" type="hidden" id="flag_<?=$data->id?>" value="0" />
	<input type="button" name="Button" value="Unhold"  onclick="update_value(<?=$data->id?>,2)" style="width:70px; font-size:12px; height:30px;background-color: #0389A6"/>
	<? } else {?>

<input name="flag_<?=$data->id?>" type="hidden" id="flag_<?=$data->id?>" value="0" />
	<input type="button" name="Button" value="Hold"  onclick="update_value(<?=$data->id?>,3)" style="width:70px; font-size:12px; height:30px;background-color: #0389A6"/>
	  <? }?>		</td>
		<td  width="33%">
		
		<? if($data->mis_hold!="Yes") {?>
		
			
<input name="flag_<?=$data->id?>" type="hidden" id="flag_<?=$data->id?>" value="0" />
	      <input type="button" name="Button" value="Reject"  onclick="update_value(<?=$data->id?>,4)" style="width:70px; font-size:12px; height:30px;background-color:#F25B3C"/>	
		  
  <? }?>		  	</td>
	</tr>
</table>

		   </span>		  </td>
    </tr>

  <? }?>
  


 
  
  
  

  
  
  
  
  

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
   from sale_do_master m, sale_do_details c 
   where m.do_no=c.do_no and m.status='Omar Faruk'  ".$wo_date_con.$dealer_con.$do_con." group by c.do_no  order by m.wo_mis_hold, m.do_no ";

  $query2 = db_query($sql2);

  while($data2=mysqli_fetch_object($query2)){$i++;

 // $op = find_all_field('journal_item','','warehouse_id="'.$_POST['warehouse_id'].'" and group_for="'.$_POST['group_for'].'" and item_id = "'.$data->item_id.'" and tr_from = "Opening" order by id desc');

  ?>



<?php /*?><? if($data->wo_amt!=$pi_amt[$data->do_no]) {  } ?><?php */?>

  <tr>

    <td bgcolor="#DAD1E6">
<a href="../../../sales_mod/pages/wo/work_order_print_view.php?v_no=<?=$data2->do_no;?>" target="_blank" style=" color:#000000; font-size:14px; font-weight:700;"> <?=$data2->job_no;?></a></td>

    <td bgcolor="#DAD1E6"><?php echo date('d-m-Y',strtotime($data2->do_date));?></td>
    <td bgcolor="#DAD1E6"><?= find_a_field('dealer_info','dealer_name_e','dealer_code='.$data2->dealer_code);?></td>
    <td bgcolor="#DAD1E6">&nbsp;</td>
    <td bgcolor="#DAD1E6">Work Order</td>
    <td bgcolor="#DAD1E6"><?= $data2->status;?>
	
	<input name="app_pi_<?=$data2->do_no?>" type="hidden" id="app_pi_<?=$data2->do_no?>" value="<?=$data2->do_no?>" />	</td>
    <td bgcolor="#DAD1E6"><?= find_a_field('user_activity_management','fname','user_id='.$data2->entry_by);?></td>
    <td colspan="3" bgcolor="#DAD1E6"><span id="divi_<?=$data2->do_no?>">

     
<table border="0" width="100%">
	<tr>
		<td width="34%">
		<? if($data2->wo_mis_hold!="Yes") {?>
		<input name="flag_<?=$data2->do_no?>" type="hidden" id="flag_<?=$data2->do_no?>" value="0" />

	 <input type="button" name="Button" value="Approve"  onclick="update_value2(<?=$data2->do_no?>,1)" style="width:70px; font-size:12px; height:30px;background-color:#66CC66"/>
	  <? }?>	 </td>
		<td  width="33%">
		<? if($data2->wo_mis_hold=="Yes") {?>
	<input name="flag_<?=$data2->do_no?>" type="hidden" id="flag_<?=$data2->do_no?>" value="0" />
	<input type="button" name="Button" value="Unhold"  onclick="update_value2(<?=$data2->do_no?>,2)" style="width:70px; font-size:12px; height:30px;background-color: #0389A6"/>
	<? } else {?>

<input name="flag_<?=$data2->do_no?>" type="hidden" id="flag_<?=$data2->do_no?>" value="0" />
	<input type="button" name="Button" value="Hold"  onclick="update_value2(<?=$data2->do_no?>,3)" style="width:70px; font-size:12px; height:30px;background-color: #0389A6"/>
	  <? }?>		</td>
		<td  width="33%">
		
		<? if($data2->wo_mis_hold!="Yes") {?>
		
			
<input name="flag_<?=$data2->do_no?>" type="hidden" id="flag_<?=$data2->do_no?>" value="0" />
	      
		  <input type="button" name="Button" value="Reject"  onclick="update_value2(<?=$data2->do_no?>,4)" style="width:70px; font-size:12px; height:30px;background-color:#F25B3C"/>		
		  
  <? }?>		  </td>
	</tr>
</table>
	


          </span>	      </td>
    </tr>

  <? }?>
  
  
  
  
  
  
  

  <?
  
  
    if($_POST['fdate']!=''&&$_POST['tdate']!='') $po_date_con .= ' and m.po_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
  
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

		
		

   $sql31 = "select  m.*,  sum(c.qty) as total_unit, sum(c.amount) as total_amt
   from purchase_master m, purchase_invoice c 
   where m.po_no=c.po_no and m.status='UNCHECKED'  ".$po_date_con.$dealer_con.$do_con." group by c.po_no  order by m.po_no";

  $query31 = db_query($sql31);

  while($data31=mysqli_fetch_object($query31)){$i++;

 // $op = find_all_field('journal_item','','warehouse_id="'.$_POST['warehouse_id'].'" and group_for="'.$_POST['group_for'].'" and item_id = "'.$data->item_id.'" and tr_from = "Opening" order by id desc');

  ?>



<?php /*?><? if($data->wo_amt!=$pi_amt[$data->do_no]) {  } ?><?php */?>

  <tr>

    <td bgcolor="#DAD1E6">
<a href="../../../purchase_mod/pages/powo/po_print_view.php?po_no=<?=$data31->po_no;?>" target="_blank" style=" color:#000000; font-size:14px; font-weight:700;"> <?=$data31->po_no;?></a></td>

    <td bgcolor="#DAD1E6"><?php echo date('d-m-Y',strtotime($data31->po_date));?></td>
    <td bgcolor="#DAD1E6"><?= find_a_field('vendor','vendor_name','vendor_id='.$data31->vendor_id);?></td>
    <td bgcolor="#DAD1E6">&nbsp;</td>
    <td bgcolor="#DAD1E6">Purchase Order</td>
    <td bgcolor="#DAD1E6"><?= $data31->status;?>
	
	<input name="app_pi_<?=$data31->po_no?>" type="hidden" id="app_pi_<?=$data31->po_no?>" value="<?=$data31->po_no?>" />	</td>
    <td bgcolor="#DAD1E6"><?= find_a_field('user_activity_management','fname','user_id='.$data31->entry_by);?></td>
    <td colspan="3" bgcolor="#DAD1E6"><span id="divi_<?=$data31->po_no?>">

     
<table border="0" width="100%">
	<tr>
		<td width="34%">
		<? if($data31->mis_hold!="Yes") {?>
		<input name="flag_<?=$data31->po_no?>" type="hidden" id="flag_<?=$data31->po_no?>" value="0" />

	 <input type="button" name="Button" value="Approve"  onclick="update_value31(<?=$data31->po_no?>,31)" style="width:70px; font-size:12px; height:30px;background-color:#66CC66"/>
	  <? }?>	 </td>
		<td  width="33%">
		<? if($data31->mis_hold=="Yes") {?>
	<input name="flag_<?=$data31->po_no?>" type="hidden" id="flag_<?=$data31->po_no?>" value="0" />
	<input type="button" name="Button" value="Unhold"  onclick="update_value31(<?=$data31->po_no?>,32)" style="width:70px; font-size:12px; height:30px;background-color: #0389A6"/>
	<? } else {?>

<input name="flag_<?=$data31->po_no?>" type="hidden" id="flag_<?=$data31->po_no?>" value="0" />
	<input type="button" name="Button" value="Hold"  onclick="update_value31(<?=$data31->po_no?>,33)" style="width:70px; font-size:12px; height:30px;background-color: #0389A6"/>
	  <? }?>		</td>
		<td  width="33%">
		
		<? if($data31->mis_hold!="Yes") {?>

	      
		  <!--<input type="button" name="Button" value="Reject"  onclick="update_value31(<?=$data31->po_no?>,34)" style="width:70px; font-size:12px; height:30px;background-color:#F25B3C"/>	-->
		  
		  <a href="../../../purchase_mod/pages/powo/po_checking.php?po_no=<?=$data31->po_no;?>"  target="_blank" > <input type="button" name="Button" value="Edit"  style="width:70px; font-size:12px; height:30px;background-color:#F25B3C"/>	</a>	
		  
  <? }?>		  </td>
	</tr>
</table>
	


          </span>	      </td>
    </tr>

  <? }?>
  
  
  
  
  
  
  
 
  
 
  
  
  

  
  
  
  
  

  <?
  
  
    //if($_POST['fdate']!=''&&$_POST['tdate']!='') $wo_date_con .= ' and m.do_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
  
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

		
		

   $sql3 = "select  m.*, date(m.hold_req_at) as hold_req_at, sum(c.total_unit) as total_unit, sum(c.total_amt) as total_amt
   from sale_do_master m, sale_do_details c 
   where m.do_no=c.do_no and m.status='HOLD REQUEST'  ".$wo_date_con.$dealer_con.$do_con." group by c.do_no  order by  m.h_mis_hold, m.do_no ";

  $query3 = db_query($sql3);

  while($data3=mysqli_fetch_object($query3)){$i++;

 // $op = find_all_field('journal_item','','warehouse_id="'.$_POST['warehouse_id'].'" and group_for="'.$_POST['group_for'].'" and item_id = "'.$data->item_id.'" and tr_from = "Opening" order by id desc');

  ?>



<?php /*?><? if($data->wo_amt!=$pi_amt[$data->do_no]) {  } ?><?php */?>

  <tr>

    <td bgcolor="#C6EBF4">
<a href="../../../sales_mod/pages/wo/work_order_print_view.php?v_no=<?=$data3->do_no;?>" target="_blank" style=" color:#000000; font-size:14px; font-weight:700;"> <?=$data3->job_no;?></a></td>

    <td bgcolor="#C6EBF4"><?php echo date('d-m-Y',strtotime($data3->do_date));?></td>
    <td bgcolor="#C6EBF4"><?= find_a_field('dealer_info','dealer_name_e','dealer_code='.$data3->dealer_code);?></td>
    <td bgcolor="#C6EBF4">&nbsp;</td>
    <td bgcolor="#C6EBF4">WO Hold</td>
    <td bgcolor="#C6EBF4"><?= $data3->hold_note;?>
	
	<input name="app_pi_<?=$data3->do_no?>" type="hidden" id="app_pi_<?=$data3->do_no?>" value="<?=$data2->do_no?>" />	</td>
    <td bgcolor="#C6EBF4"><?= find_a_field('user_activity_management','fname','user_id='.$data3->hold_req_by);?></td>
    <td colspan="3" bgcolor="#C6EBF4"><span id="divi_<?=$data3->do_no?>">

     
<table border="0" width="100%">
	<tr>
		<td width="34%">
		<? if($data3->h_mis_hold!="Yes") {?>
		<input name="flag_<?=$data3->do_no?>" type="hidden" id="flag_<?=$data3->do_no?>" value="0" />

	 <input type="button" name="Button" value="Approve"  onclick="update_value3(<?=$data3->do_no?>,1)" style="width:70px; font-size:12px; height:30px;background-color:#66CC66"/>
	  <? }?>	 </td>
		<td  width="33%">
		<? if($data3->h_mis_hold=="Yes") {?>
	<input name="flag_<?=$data3->do_no?>" type="hidden" id="flag_<?=$data3->do_no?>" value="0" />
	<input type="button" name="Button" value="Unhold"  onclick="update_value3(<?=$data3->do_no?>,2)" style="width:70px; font-size:12px; height:30px;background-color: #0389A6"/>
	<? } else {?>

<input name="flag_<?=$data3->do_no?>" type="hidden" id="flag_<?=$data3->do_no?>" value="0" />
	<input type="button" name="Button" value="Hold"  onclick="update_value3(<?=$data3->do_no?>,3)" style="width:70px; font-size:12px; height:30px;background-color: #0389A6"/>
	  <? }?>		</td>
		<td  width="33%">
		
		<? if($data3->h_mis_hold!="Yes") {?>
		
			
<input name="flag_<?=$data3->do_no?>" type="hidden" id="flag_<?=$data3->do_no?>" value="0" />
	      
		  <input type="button" name="Button" value="Reject"  onclick="update_value3(<?=$data3->do_no?>,4)" style="width:70px; font-size:12px; height:30px;background-color:#F25B3C"/>		
		  
  <? }?>		  </td>
	</tr>
</table>
	


          </span>	</td>
    </tr>

  <? }?>
  
  
  
  
  
  
  
 
  
  
  

  
  
  
  
  

  <?
  
  
    //if($_POST['fdate']!=''&&$_POST['tdate']!='') $wo_date_con .= ' and m.do_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
  
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

		
		

   $sql4 = "select  m.*, date(m.unhold_req_at) as unhold_req_at,  sum(c.total_unit) as total_unit, sum(c.total_amt) as total_amt
   from sale_do_master m, sale_do_details c 
   where m.do_no=c.do_no and m.status='UNHOLD'  ".$wo_date_con.$dealer_con.$do_con." group by c.do_no  order by  m.uh_mis_hold, m.do_no ";

  $query4 = db_query($sql4);

  while($data4=mysqli_fetch_object($query4)){$i++;

 // $op = find_all_field('journal_item','','warehouse_id="'.$_POST['warehouse_id'].'" and group_for="'.$_POST['group_for'].'" and item_id = "'.$data->item_id.'" and tr_from = "Opening" order by id desc');

  ?>



<?php /*?><? if($data->wo_amt!=$pi_amt[$data->do_no]) {  } ?><?php */?>

  <tr>

    <td bgcolor="#F4CACB">
<a href="../../../sales_mod/pages/wo/work_order_print_view.php?v_no=<?=$data4->do_no;?>" target="_blank" style=" color:#000000; font-size:14px; font-weight:700;"> <?=$data4->job_no;?></a></td>

    <td bgcolor="#F4CACB"><?php echo date('d-m-Y',strtotime($data4->unhold_req_at));?></td>
    <td bgcolor="#F4CACB"><?= find_a_field('dealer_info','dealer_name_e','dealer_code='.$data4->dealer_code);?></td>
    <td bgcolor="#F4CACB">&nbsp;</td>
    <td bgcolor="#F4CACB">WO Unhold</td>
    <td bgcolor="#F4CACB"><?= $data4->hold_note;?>
	
	<input name="app_pi_<?=$data4->do_no?>" type="hidden" id="app_pi_<?=$data4->do_no?>" value="<?=$data4->do_no?>" />	</td>
    <td bgcolor="#F4CACB"><?= find_a_field('user_activity_management','fname','user_id='.$data4->hold_req_by);?></td>
    <td colspan="3" bgcolor="#F4CACB"><span id="divi_<?=$data4->do_no?>">

     
<table border="0" width="100%">
	<tr>
		<td width="34%">
		<? if($data4->uh_mis_hold!="Yes") {?>
		<input name="flag_<?=$data4->do_no?>" type="hidden" id="flag_<?=$data4->do_no?>" value="0" />

	 <input type="button" name="Button" value="Approve"  onclick="update_value4(<?=$data4->do_no?>,1)" style="width:70px; font-size:12px; height:30px;background-color:#66CC66"/>
	  <? }?>	 </td>
		<td  width="33%">
		<? if($data4->uh_mis_hold=="Yes") {?>
	<input name="flag_<?=$data4->do_no?>" type="hidden" id="flag_<?=$data4->do_no?>" value="0" />
	<input type="button" name="Button" value="Unhold"  onclick="update_value4(<?=$data4->do_no?>,2)" style="width:70px; font-size:12px; height:30px;background-color: #0389A6"/>
	<? } else {?>

<input name="flag_<?=$data4->do_no?>" type="hidden" id="flag_<?=$data4->do_no?>" value="0" />
	<input type="button" name="Button" value="Hold"  onclick="update_value4(<?=$data4->do_no?>,3)" style="width:70px; font-size:12px; height:30px;background-color: #0389A6"/>
	  <? }?>		</td>
		<td  width="33%">
		
		<? if($data4->uh_mis_hold!="Yes") {?>
		
			
<input name="flag_<?=$data4->do_no?>" type="hidden" id="flag_<?=$data4->do_no?>" value="0" />
	      
		  <input type="button" name="Button" value="Reject"  onclick="update_value4(<?=$data4->do_no?>,4)" style="width:70px; font-size:12px; height:30px;background-color:#F25B3C"/>		
		  
  <? }?>		  </td>
	</tr>
</table>
	


          </span>	</td>
    </tr>

  <? }?>
  
  
  
  
  
  
  
  
 
  
  
  

  
  
  
  
  

  <?
  
  
    //if($_POST['fdate']!=''&&$_POST['tdate']!='') $wo_date_con .= ' and m.do_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
  
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

		
		

   $sql5 = "select  m.*, date(m.cancel_req_at) as cancel_req_at, sum(c.total_unit) as total_unit, sum(c.total_amt) as total_amt
   from sale_do_master m, sale_do_details c 
   where m.do_no=c.do_no and m.status='CANCEL REQUEST'  ".$wo_date_con.$dealer_con.$do_con." group by c.do_no  order by m.c_mis_hold, m.do_no ";

  $query5 = db_query($sql5);

  while($data5=mysqli_fetch_object($query5)){$i++;

 // $op = find_all_field('journal_item','','warehouse_id="'.$_POST['warehouse_id'].'" and group_for="'.$_POST['group_for'].'" and item_id = "'.$data->item_id.'" and tr_from = "Opening" order by id desc');

  ?>



<?php /*?><? if($data->wo_amt!=$pi_amt[$data->do_no]) {  } ?><?php */?>

  <tr>

    <td bgcolor="#E3EECC">
<a href="../../../sales_mod/pages/wo/work_order_print_view.php?v_no=<?=$data5->do_no;?>" target="_blank" style=" color:#000000; font-size:14px; font-weight:700;"> <?=$data5->job_no;?></a></td>

    <td bgcolor="#E3EECC"><?php echo date('d-m-Y',strtotime($data5->cancel_req_at));?></td>
    <td bgcolor="#E3EECC"><?= find_a_field('dealer_info','dealer_name_e','dealer_code='.$data5->dealer_code);?></td>
    <td bgcolor="#E3EECC">&nbsp;</td>
    <td bgcolor="#E3EECC">WO CANCELE</td>
    <td bgcolor="#E3EECC"><?= $data5->cancel_note;?>
	
	<input name="app_pi_<?=$data5->do_no?>" type="hidden" id="app_pi_<?=$data5->do_no?>" value="<?=$data5->do_no?>" />	</td>
    <td bgcolor="#E3EECC"><?= find_a_field('user_activity_management','fname','user_id='.$data5->cancel_req_by);?></td>
    <td colspan="3" bgcolor="#E3EECC"><span id="divi_<?=$data5->do_no?>">

     
<table border="0" width="100%">
	<tr>
		<td width="34%">
		<? if($data5->c_mis_hold!="Yes") {?>
		<input name="flag_<?=$data5->do_no?>" type="hidden" id="flag_<?=$data5->do_no?>" value="0" />

	 <input type="button" name="Button" value="Approve"  onclick="update_value5(<?=$data5->do_no?>,1)" style="width:70px; font-size:12px; height:30px;background-color:#66CC66"/>
	  <? }?>	 </td>
		<td  width="33%">
		<? if($data5->c_mis_hold=="Yes") {?>
	<input name="flag_<?=$data5->do_no?>" type="hidden" id="flag_<?=$data5->do_no?>" value="0" />
	<input type="button" name="Button" value="Unhold"  onclick="update_value5(<?=$data5->do_no?>,2)" style="width:70px; font-size:12px; height:30px;background-color: #0389A6"/>
	<? } else {?>

<input name="flag_<?=$data5->do_no?>" type="hidden" id="flag_<?=$data5->do_no?>" value="0" />
	<input type="button" name="Button" value="Hold"  onclick="update_value5(<?=$data5->do_no?>,3)" style="width:70px; font-size:12px; height:30px;background-color: #0389A6"/>
	  <? }?>		</td>
		<td  width="33%">
		
		<? if($data5->c_mis_hold!="Yes") {?>
		
			
<input name="flag_<?=$data5->do_no?>" type="hidden" id="flag_<?=$data5->do_no?>" value="0" />
	      
		  <input type="button" name="Button" value="Reject"  onclick="update_value5(<?=$data5->do_no?>,4)" style="width:70px; font-size:12px; height:30px;background-color:#F25B3C"/>		
		  
  <? }?>		  </td>
	</tr>
</table>
	


          </span></td>
    </tr>

  <? }?>
</table>

<br /><br />

</div>

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