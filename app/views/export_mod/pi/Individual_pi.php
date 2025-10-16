<?php

//

//


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Individual PI';

//create_combobox('pi_id');
//create_combobox('dealer_code');
do_calander('#pi_date');
do_calander('#fdate');
do_calander('#tdate');

do_calander('#odate');

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

var pi_date=(document.getElementById('pi_date').value);
var dealer_group=(document.getElementById('dealer_group').value);
var dealer_code=(document.getElementById('dealer_code').value);


var flag=(document.getElementById('flag_'+do_no).value); 

var strURL="individual_pi_ajax.php?do_no="+do_no+"&dealer_group="+dealer_group+"&dealer_code="+dealer_code+"&pi_date="+pi_date+"&flag="+flag;



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
        <td>&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#FF9966"><strong>PI Date:</strong></td>
        <td colspan="3" bgcolor="#FF9966"><input style="width:220px; height:30px;"  name="pi_date" type="text" id="pi_date" value="<?=($pi_date!='')?$pi_date:date('Y-m-d')?>"   required/></td>
        <td rowspan="8" bgcolor="#FF9966"><strong>
          <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
        </strong></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#FF9966"><strong>Customer Group:</strong></td>
        <td colspan="3" bgcolor="#FF9966">
		<select name="dealer_group" id="dealer_group" required style="width:220px;" onchange="getData2('find_dealer_ajax.php', 'find_dealer', this.value,document.getElementById('dealer_group').value);" >
		
											<option></option>
									
											<? foreign_relation('dealer_group','id','dealer_group',$_POST['dealer_group'],'1 order by id');?>
										</select>		
	
	
	<? 
	$pi_data = find_all_field('pi_master','','id='.$_POST['pi_id']);
	?>		</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#FF9966"><strong>Customer Name:</strong></td>
        <td colspan="3" bgcolor="#FF9966">
		<span id="find_dealer">
										<select name="dealer_code" id="dealer_code" required style="width:220px;">
		
											<option></option>
									
											<? foreign_relation('dealer_info','dealer_code','dealer_name_e',$_POST['dealer_code'],'dealer_group="'.$_POST['dealer_group'].'" order by dealer_code');?>
										</select>
										</span>		</td>
      </tr>
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
    <th width="14%">MARKETING PERSON</th>
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


		 $sql = "select   c.do_no, c.do_no as find_do  from sale_do_master m, pi_details c where m.do_no=c.do_no group by c.do_no ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $find_do[$info->do_no]=$info->find_do;
		
		}

		
		

    $sql = "select  m.*,  sum(c.total_unit) as wo_qty, sum(c.total_amt) as wo_amt
   from sale_do_master m, sale_do_details c 
   where m.do_no=c.do_no and m.dealer_code='".$_POST['dealer_code']."' and m.status in ('COMPLETED','CHECKED') ".$date_con.$dealer_con.$do_con." group by c.do_no  order by  m.job_no ";

  $query = db_query($sql);

  while($data=mysqli_fetch_object($query)){$i++;

 // $op = find_all_field('journal_item','','warehouse_id="'.$_POST['warehouse_id'].'" and group_for="'.$_POST['group_for'].'" and item_id = "'.$data->item_id.'" and tr_from = "Opening" order by id desc');

  ?>



<? if($find_do[$data->do_no]==0) { ?>

  <tr bgcolor="<?=($i%2)?'#E8F3FF':'#fff';?>">

    <td><a title="WO Preview" target="_blank" href="../../../sales_mod/pages/wo/work_order_print_view.php?v_no=<?=$data->do_no?>"><?=$data->job_no?></a></td>

    <td><?php echo date('d-m-Y',strtotime($data->do_date));?></td>
    <td><?= find_a_field('marketing_person','marketing_person_name','person_code='.$data->marketing_person);?></td>
    <td><?= find_a_field('dealer_info','dealer_name_e','dealer_code='.$data->dealer_code);?></td>
    <td><?= find_a_field('buyer_info','buyer_name','buyer_code='.$data->buyer_code);?></td>
    <td><?= find_a_field('merchandizer_info','merchandizer_name','merchandizer_code='.$data->merchandizer_code);?></td>
    <td><?= $data->wo_qty;?></td>
    <td><?= $data->wo_amt;?></td>
    <td><span id="divi_<?=$data->do_no?>">

     

	<input name="flag_<?=$data->do_no?>" type="hidden" id="flag_<?=$data->do_no?>" value="0" />

	 <input type="button" name="Button" value="Save"  onclick="update_value(<?=$data->do_no?>)" style="width:70px; font-size:12px; height:30px;background-color:#66CC66"/>
			  


          </span>&nbsp;</td>
  </tr>

  <? } }?>
</table>

</div>

<? }?>

<p>&nbsp;</p>

</form>

</div>



<?

//

//

require_once SERVER_CORE."routing/layout.bottom.php";

?>