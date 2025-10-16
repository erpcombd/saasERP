<?php

//

//


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='LC Closing Journal Update';

create_combobox('lc_no');


//do_calander('#tdate');

//do_calander('#odate');

$pr_no=$_REQUEST['request_data'];

$data_found = $pr_no;

if ($data_found==0) {
do_calander('#pr_date');
  }

//if ($data_found==0) {
// create_combobox('do_no');
//  }




if(prevent_multi_submit()){



//if(isset($_POST['confirm'])){






//
//if(isset($_POST['delete'])){
//	
//	$status = 'CHECKED';
//	$entry_by = $_SESSION['user']['id'];
//	$entry_at=date('Y-m-d H:i:s');
//	
//		
//	$adjustment_po = $_POST['adjustment_po'];
//	$po_no = $_POST['po_no'];
//	
//		
//	$sql_del_ms = 'delete from purchase_sp_master where  po_no="'.$po_no.'"';
//	db_query($sql_del_ms);
//	
//	$sql_del_ch = 'delete from purchase_sp_invoice where  po_no="'.$po_no.'"';
//	db_query($sql_del_ch);
//	
//	
//	$new_sql="UPDATE purchase_sp_invoice SET adj_qty=0, adj_amt=0 WHERE po_no = '".$adjustment_po."' ";
//	db_query($new_sql);
//
//	 	
//}
//






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
	
	
	function count()
{


//if(document.getElementById('unit_price').value!=''){}


var rate = ((document.getElementById('rate').value)*1);

//var total_unit = (document.getElementById('total_unit').value) = pkt_unit*pkt_size;

var qty = ((document.getElementById('qty').value)*1);

var amount = (document.getElementById('amount').value) = rate*qty;

}


	
	

function TRcalculation(order_no){

var po_qty = document.getElementById('po_qty_'+order_no).value*1;

var unit_price = document.getElementById('unit_price_'+order_no).value*1;

var adj_qty = document.getElementById('adj_qty_'+order_no).value*1;

var adj_amt = document.getElementById('adj_amt_'+order_no).value= (unit_price*adj_qty);

 if(po_qty<adj_qty)
  {
alert('You can`t reduce the qty');
document.getElementById('adj_qty_'+order_no).value='';
document.getElementById('adj_amt_'+order_no).value='';
  } 

}




function TRcalculationpo(order_no){

var rate = document.getElementById('rate_'+order_no).value*1;

var qty = document.getElementById('qty_'+order_no).value*1;


var amount = document.getElementById('amount_'+order_no).value= (rate*qty);

// if(po_qty<adj_qty)
//  {
//alert('You can`t reduce the qty');
//document.getElementById('adj_qty_'+order_no).value='';
//document.getElementById('adj_amt_'+order_no).value='';
//  } 

}



	function update_value(order_no)



	{

var order_no=order_no; // Rent

var closing_amt=(document.getElementById('closing_amt_'+order_no).value);

var flag=(document.getElementById('flag_'+order_no).value); 

var strURL="closing_update_ajax.php?order_no="+order_no+"&closing_amt="+closing_amt+"&flag="+flag;




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
    width: 300px;
    height: 38px;
    border-radius: 0px !important;
}



</style>

<div class="form-container_large">


<form action="" method="post" name="codz" id="codz">



<div class="box" style="width:100%;">

								<table width="100%" border="0" cellspacing="0" cellpadding="0">

								  <tr>

    <td width="22%" align="right" ><strong> Item Group: </strong></td>
	 <td width="40%" >
	 <select name="group_id"  id="group_id" style="width:50%; height:32px;"  tabindex="2">
	 
	 <option></option>
			

					 <? foreign_relation('item_group','group_id','group_name',$_POST['group_id'],'1');?>
			</select>
			
			<input name="view_data" type="hidden" id="view_data" value="1"  style="width:70px; height:30px; " />				 </td>
	 </tr>
								</table>

</div>



<div class="box" style="width:100%;">						
								<table width="100%">
                            <thead>
                              <tr class="oe_list_header_columns">
                                <th width="46%"><input name="submitit" type="submit" id="submitit" value="VIEW DATA" style="width:150px; height:30px; background:#20B2AA; color:#000000; font-weight:700;" /></th>
                                <th width="23%"><!--<a href="po_bill_top_shit_print_view.php?bill_id=<?=$bill_id?>" target="_blank"  style="padding:5px 30px; background:#20B2AA; color:#000000; font-size:12px; font-weight:700;">PO Top Sheet</a>--></th>
                              </tr>
                            </thead>
                            <tfoot>
                            </tfoot>
                            <tbody>
                            </tbody>
                          </table>

    </div>





<? if($_POST['view_data']>0){ ?>



<br />



<div class="tabledesign2" style="width:100%">




<table width="100%" border="0" align="center" id="grp" cellpadding="0" cellspacing="0" style="font-size:12px; text-transform:uppercase;">

  <tr>
    <th width="7%">Closing No </th>
    <th width="7%">Closing Date </th>
    <th width="36%">LC No </th>

    <th width="10%">Closing Amt </th>
    <th width="13%"><div align="center">Action</div></th>
  </tr>
  

  <?
  
  
  if($_POST['fdate']!=''&&$_POST['tdate']!='') $date_con .= ' and c.chalan_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
  
  
		//if($_POST['dealer_code']!='')
// 		$dealer_con=" and m.dealer_code='".$_POST['dealer_code']."'";
//		
//		if($_POST['do_no']!='') 
//		$do_con .= ' and m.do_no in ('.$_POST['do_no'].') ';


    if($_POST['group_id']!='')
	$group_id_con=" and s.group_id='".$_POST['group_id']."'";
	
	
	
	 	 //$sql = "select po_no, po_no from po_bill_details where 1 group by po_no";
//		 $query = db_query($sql);
//		 while($info=mysqli_fetch_object($query)){
//  		 $po_no[$info->po_no]=$info->po_no;
//	
//		}



		
		

    $sqlfg = "select l.closing_no, l.closing_date, l.lc_number, sum(l.cost_amt_bdt) as closing_amt from lc_purchase_closing l, item_info i, item_sub_group s where l.item_id=i.item_id and i.sub_group_id=s.sub_group_id  ".$group_id_con." group by l.closing_no";

  $queryfg = db_query($sqlfg);

  while($datafg=mysqli_fetch_object($queryfg)){$i++;

 // $op = find_all_field('journal_item','','warehouse_id="'.$_POST['warehouse_id'].'" and group_for="'.$_POST['group_for'].'" and item_id = "'.$data->item_id.'" and tr_from = "Opening" order by id desc');

  
  		  
  
  ?>



<? //if($po_no[$data->po_no]==0) { } ?>

  <tr bgcolor="<?=($i%2)?'#E8F3FF':'#fff';?>">
    <td><?=$datafg->closing_no;?></td>
    <td><?=$datafg->closing_date;?></td>
    <td><?=$datafg->lc_number?></td>

    <td bgcolor="#99CCFF">
	
	<input name="closing_amt_<?=$datafg->closing_no?>" type="text" id="closing_amt_<?=$datafg->closing_no?>" value="<?=$datafg->closing_amt; ?>" onkeyup="TRcalculationpo(<?=$data->closing_no?>)" style="width:150px; height:30px; " />
	<input name="order_no_<?=$datafg->closing_no?>" type="hidden" id="order_no_<?=$datafg->closing_no?>" value="<?=$datafg->closing_no?>" />      </td>
    <td>
	
	<span id="divi_<?=$datafg->closing_no?>">
	<input name="flag_<?=$datafg->closing_no?>" type="hidden" id="flag_<?=$datafg->closing_no?>" value="0" />

	<input type="button" name="Button" value="EDIT"  onclick="update_value(<?=$datafg->closing_no?>)" style="width:70px; font-size:12px; height:30px; background-color:#66CC66; font-weight:700;"/>
    </span></td>
  </tr>
  

  <? } ?>
</table>
</div>

<br />



<br /><br />




<table width="100%" border="0">





<? if($bill_data->status!="COMPLETED") {?>
<tr>

<td align="center">&nbsp;
<?php /*?><input name="delete" type="submit" class="btn1" value="DELETE" style="width:200px; font-weight:bold; float:left; font-size:12px; height:30px; background:#FF0000;color: #000000; border-radius:50px 20px;" /><?php */?>
</td>

<td align="center">
<!--<input  name="do_no" type="hidden" id="do_no" value="<?=$_POST['do_no'];?>"/>-->
<input name="confirm" type="hidden" class="btn1" value="CONFIRM &amp; SEND" style="width:270px; font-weight:bold; float:right; font-size:12px; height:30px;  background: #1E90FF; color: #000000; border-radius: 50px 20px;" /></td>

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