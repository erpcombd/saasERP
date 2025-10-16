<?php

//

//


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Individual PI Re-check';

//create_combobox('pi_id');
create_combobox('do_no');
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



	function update_value(pi_id)



	{



var pi_id=pi_id; // Rent

var do_no=(document.getElementById('do_no').value);
var pi_qty=(document.getElementById('pi_qty_'+pi_id).value); 

var flag=(document.getElementById('flag_'+pi_id).value); 

var strURL="individual_pi_re_check_ajax.php?pi_id="+pi_id+"&do_no="+do_no+"&pi_qty="+pi_qty+"&flag="+flag;



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

<table width="80%" border="0" align="center">
      <tr>
        <td>&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#FF9966"><strong>Job No:</strong></td>
        <td colspan="2" bgcolor="#FF9966"><select name="do_no" id="do_no" style="width:280px;">
		
		<option></option>

        <? 	foreign_relation('pi_details','do_no','job_no',$_POST['do_no'],'1 group by do_no order by do_no'); ?>
    </select>
	<? $wo_data = find_all_field('sale_do_master','','do_no='.$_POST['do_no']);?>	
	</td>
        <td bgcolor="#FF9966"><a title="WO Preview" target="_blank" href="../../../sales_mod/pages/wo/work_order_print_view.php?v_no=<?=$_POST['do_no'];?>"><?=$wo_data->job_no;?></a></td>
        <td rowspan="8" bgcolor="#FF9966"><strong>
          <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
        </strong></td>
      </tr>
    </table>

<br />

<?

if(isset($_POST['submitit'])){

?>

<div class="tabledesign2" style="width:100%">

<table width="100%" border="0" align="center" id="grp" cellpadding="0" cellspacing="0" style="font-size:12px; text-transform:uppercase;">

  <tr>

    <th width="4%">PI No </th>

    <th width="8%">PI Date </th>
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


	//	$sql = "select   c.do_no, sum(c.total_amt) as pi_amt  from sale_do_master m, pi_details c where m.do_no=c.do_no group by c.do_no ";
//		 $query = db_query($sql);
//		 while($info=mysqli_fetch_object($query)){
//  		 $pi_amt[$info->do_no]=$info->pi_amt;
//		
//		
//		}

		
		

   $sql = "select  pi_id, pi_no, pi_date, dealer_code, sum(total_unit) as pi_qty, sum(total_amt) as pi_amt
   from pi_details
   where pi_type=1 and do_no='".$_POST['do_no']."'  ".$date_con.$dealer_con.$do_con." group by pi_id  order by pi_id ";

  $query = db_query($sql);

  while($data=mysqli_fetch_object($query)){$i++;

 // $op = find_all_field('journal_item','','warehouse_id="'.$_POST['warehouse_id'].'" and group_for="'.$_POST['group_for'].'" and item_id = "'.$data->item_id.'" and tr_from = "Opening" order by id desc');

  ?>



<?php /*?><? if($data->wo_amt!=$pi_amt[$data->do_no]) { }?><?php */?>

  <tr bgcolor="<?=($i%2)?'#E8F3FF':'#fff';?>">

    <td><a title="PI Preview" target="_blank" href="pi_print_view.php?v_no=<?=$data->pi_id?>"><?=$data->pi_no?></a></td>

    <td><?php echo date('d-m-Y',strtotime($data->pi_date));?></td>
    <td><?= find_a_field('dealer_info','dealer_name_e','dealer_code='.$data->dealer_code);?></td>
    <td><input name="pi_qty_<?=$data->pi_id?>" type="text" id="pi_qty_<?=$data->pi_id?>" value="<?= $data->pi_qty;?>" style=" width:100px; height:25px; font-size:12px;" /></td>
    <td><?= $data->pi_amt;?></td>
    <td><span id="divi_<?=$data->pi_id?>">

     

	<input name="flag_<?=$data->pi_id?>" type="hidden" id="flag_<?=$data->pi_id?>" value="0" />

	 <input type="button" name="Button" value="Save"  onclick="update_value(<?=$data->pi_id?>)" style="width:70px; font-size:12px; height:30px;background-color:#66CC66"/>
			  


          </span>&nbsp;</td>
  </tr>

  <?  }?>
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