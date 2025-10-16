<?php

//

//


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Unchecked PI';

//create_combobox('pi_id');
//create_combobox('dealer_code');
do_calander('#pi_date');
do_calander('#fdate');
do_calander('#tdate');

do_calander('#odate');






if(prevent_multi_submit()){



if(isset($_POST['confirm'])){

	
		
	$status = 'CHECKED';
	$checked_by = $_SESSION['user']['id'];
	$checked_at=date('Y-m-d H:i:s');
		

		
		//$chalan_no = next_transection_no('0',$issue_date,'sale_do_production_issue','chalan_no');
		
	
	
		
		
		 if($_POST['fdate']!=''&&$_POST['tdate']!='') $date_con .= ' and m.pi_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
  
  
		if($_POST['dealer_code']!='')
 		$dealer_con=" and m.dealer_code='".$_POST['dealer_code']."'";

		
		 
		 
	$sql = "select  m.*,  sum(c.total_unit) as pi_qty, sum(c.total_amt) as pi_amt
   from pi_master m, pi_details c 
   where m.id=c.pi_id and m.status='UNCHECKED'  ".$date_con.$dealer_con." group by c.pi_id  order by  m.id ";

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
  
  VALUES('".$pi_id."', '".$data->pi_no."', '".$data->pi_date."', 'Individual PI', '".$YR."', '".$digital_sign_id."', '".$digital_sign."', 
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



	function update_value(id)



	{



var id=id; // Rent

//var pi_date=(document.getElementById('pi_date').value);
//var dealer_group=(document.getElementById('dealer_group').value);
//var dealer_code=(document.getElementById('dealer_code').value);


var flag=(document.getElementById('flag_'+id).value); 

var strURL="pi_approval_ajax.php?id="+id+"&flag="+flag;



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
        <td width="23%">&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td width="24%">&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#FF9966"><strong>PI Date:</strong></td>
        <td width="16%" bgcolor="#FF9966"><input type="text" name="fdate" id="fdate" style="width:120px;" value="<?=$_POST['fdate']?>" /></td>
        <td width="3%" align="center" bgcolor="#FF9966">-to- </td>
        <td width="34%" bgcolor="#FF9966"><input type="text" name="tdate" id="tdate" style="width:120px;" value="<?=$_POST['tdate']?>" /></td>
        <td rowspan="8" bgcolor="#FF9966"><strong>
          <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
        </strong></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#FF9966"><strong>Customer Group:</strong></td>
        <td colspan="3" bgcolor="#FF9966">
		<select name="dealer_group" id="dealer_group"  style="width:220px;" onchange="getData2('find_dealer_ajax.php', 'find_dealer', this.value,document.getElementById('dealer_group').value);" >
		
											<option></option>
									
											<? foreign_relation('dealer_group','id','dealer_group',$_POST['dealer_group'],'1 order by id');?>
										</select>	</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#FF9966"><strong>Customer Name:</strong></td>
        <td colspan="3" bgcolor="#FF9966">
		<span id="find_dealer">
										<select name="dealer_code" id="dealer_code"  style="width:220px;">
		
											<option></option>
									
											<? foreign_relation('dealer_info','dealer_code','dealer_name_e',$_POST['dealer_code'],'1 order by dealer_code');?>
										</select>
										</span>		</td>
      </tr>
    </table>

<br />

<?php /*?><? if(isset($_POST['submitit'])){ ?><? }?><?php */?>



<div class="tabledesign2" style="width:100%">

<table width="100%" border="0" align="center" id="grp" cellpadding="0" cellspacing="0" style="font-size:12px; text-transform:uppercase;">

  <tr>

    <th width="7%">PI No </th>

    <th width="11%">PI Date </th>
    <th width="24%">CUSTOMER Name </th>
    <th width="10%">PI QTY</th>
    <th width="12%">PI VALUE </th>
    <th width="13%">STATUS</th>
    <th width="13%">Prepared by</th>
    <th width="10%"><div align="center">Action</div></th>
  </tr>
  

  <?
  
  
  if($_POST['fdate']!=''&&$_POST['tdate']!='') $date_con .= ' and m.pi_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
  
  
		if($_POST['dealer_code']!='')
 		$dealer_con=" and m.dealer_code='".$_POST['dealer_code']."'";
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

		
		

   $sql = "select  m.*,  sum(c.total_unit) as pi_qty, sum(c.total_amt) as pi_amt
   from pi_master m, pi_details c 
   where m.id=c.pi_id and m.status='UNCHECKED'  ".$date_con.$dealer_con.$do_con." group by c.pi_id  order by  m.id ";

  $query = db_query($sql);

  while($data=mysqli_fetch_object($query)){$i++;

 // $op = find_all_field('journal_item','','warehouse_id="'.$_POST['warehouse_id'].'" and group_for="'.$_POST['group_for'].'" and item_id = "'.$data->item_id.'" and tr_from = "Opening" order by id desc');

  ?>



<?php /*?><? if($data->wo_amt!=$pi_amt[$data->do_no]) {  } ?><?php */?>

  <tr bgcolor="<?=($i%2)?'#E8F3FF':'#fff';?>">

    <td><a title="PI Preview" target="_blank" href="pi_print_view.php?v_no=<?=$data->id?>"><?=$data->pi_no?></a></td>

    <td><?php echo date('d-m-Y',strtotime($data->pi_date));?></td>
    <td><?= find_a_field('dealer_info','dealer_name_e','dealer_code='.$data->dealer_code);?></td>
    <td><?= $data->pi_qty;?></td>
    <td>$ <?= number_format($data->pi_amt,2);?></td>
    <td><?= $data->status;?>
	
	<input name="app_pi_<?=$data->id?>" type="hidden" id="app_pi_<?=$data->id?>" value="<?=$data->id?>" />	</td>
    <td><?= find_a_field('user_activity_management','fname','user_id='.$data->entry_by);?></td>
    <td><span id="divi_<?=$data->id?>">

     

	<input name="flag_<?=$data->id?>" type="hidden" id="flag_<?=$data->id?>" value="0" />

	 <input type="button" name="Button" value="Save"  onclick="update_value(<?=$data->id?>)" style="width:70px; font-size:12px; height:30px;background-color:#66CC66"/>
			  


          </span>&nbsp;</td>
  </tr>

  <? }?>
</table>

<br /><br />

</div>

<table width="100%" border="0">

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
<input name="confirm" type="submit" class="btn1" value="All Approve" style="width:270px; font-weight:bold; float:right; font-size:12px; height:30px; color:#090" /></td>

</tr>

<? }?>

</table>





<p>&nbsp;</p>

</form>

</div>



<?

//

//

require_once SERVER_CORE."routing/layout.bottom.php";

?>