<?php



session_start();



ob_start();



require_once "../../../assets/support/inc.all.php";

$sale_no 		= $_REQUEST['sale_no'];





$title='Sales Order';







do_calander('#p_date');

if($_REQUEST['p_date']!='')

{

$p_date = $_REQUEST['p_date'];

$se_id = $_REQUEST['se_id'];



$p_found = find_a_field('item_sale_issue','1',' 1 and se_id = "'.$se_id.'" and status="COMPLETE" and sale_date="'.$p_date.'"');

$m_found = find_a_field('item_sale_issue','1',' 1 and se_id = "'.$se_id.'" and status="MANUAL" and sale_date<"'.$p_date.'"');

}

if(isset($_REQUEST['confirmit']))

{



$p_date = $_REQUEST['p_date'];

$se_id = $_REQUEST['se_id'];



$se_info = find_all_field('warehouse','','warehouse_id='.$se_id);

$se_sale =  find_all_field_sql("SELECT sum(today_sale_amt) total_sales,sale_no,status FROM `item_sale_issue` WHERE `se_id`='".$se_id."' and `sale_date`='".$p_date."' ");

$sql = "update item_sale_issue set status = 'COMPLETE' where `se_id`='".$se_id."' and `sale_date`='".$p_date."'";

mysql_query($sql);



$jv_no = next_journal_sec_voucher_id();

$jv_date = strtotime($p_date);

$narration = 'Sale NO#'.$se_sale->sale_no.' SaleDate:'.$p_date;

$cc_code = $se_info->acc_code;

add_to_sec_journal('STA', $jv_no, $jv_date, $se_info->ledger_id, $narration, $se_sale->total_sales, '0.00', 'Sales', $se_sale->sale_no,'','',$cc_code);

add_to_sec_journal('STA', $jv_no, $jv_date, '3001000100000000',  $narration, '0.00', $se_sale->total_sales, 'Sales', $se_sale->sale_no,'','',$cc_code);



}



if(isset($_REQUEST['collection']))

{



$p_date = $_REQUEST['p_date'];

$se_id = $_REQUEST['se_id'];



$c_id = $_REQUEST['c_id'];

$c_amt = $_REQUEST['c_amt'];



$se_info = find_all_field('warehouse','','warehouse_id='.$se_id);



$jv_no = next_journal_sec_voucher_id();

$jv_date = strtotime($p_date);

$narration = 'Collection Date:'.$p_date;



add_to_sec_journal('STA', $jv_no, $jv_date, $c_id              , $narration, $c_amt, '0.00', 'Collection', $se_id);

add_to_sec_journal('STA', $jv_no, $jv_date, $se_info->ledger_id,  $narration, '0.00', $c_amt, 'Collection', $se_id);



}



$se_info = find_all_field('warehouse','','warehouse_id='.$se_id);

$se_sale =  find_all_field_sql("SELECT sum(today_sale_amt) total_sales,status,sale_no FROM `item_sale_issue` WHERE `se_id`='".$se_id."' and `sale_date`='".$p_date."' ");



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

var item_id=id; // Rent 

var p_date=(document.getElementById('p_date').value);

var item_rate=(document.getElementById('item_rate_'+id).value);

var se_id=(document.getElementById('se_id').value);

var opening=(document.getElementById('opening_'+id).value)*1;

var issue=(document.getElementById('issue_'+id).value)*1;

var sale=(document.getElementById('sale_'+id).value)*1;

var sale_amt=(document.getElementById('sale_amt_'+id).value)*1;

var closing=(document.getElementById('closing_'+id).value)*1; 

var flag=(document.getElementById('flag_'+id).value); 

//alert(item_rate)

var strURL="sales_order_ajax.php?item_id="+item_id+"&opening="+opening+"&issue="+issue+"&sale="+sale+"&closing="+closing+"&item_rate="+item_rate+"&sale_amt="+sale_amt+"&se_id="+se_id+"&p_date="+p_date+"&flag="+flag;



//alert(strURL);



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





</script>

<script>

function calculation(id){

var opening=(document.getElementById('opening_'+id).value)*1; 

var issue=(document.getElementById('issue_'+id).value)*1; 

var sale=(document.getElementById('sale_'+id).value)*1; 

var item_rate=(document.getElementById('item_rate_'+id).value)*1; 

document.getElementById('sale_amt_'+id).value=(item_rate*sale);

document.getElementById('closing_'+id).value=(opening+issue)-sale;

}

</script>

<style type="text/css">

<!--

.style1 {

	color: #FFFFFF;

	font-weight: bold;

}

-->

</style>







<div class="form-container_large">



<form action="" method="post" name="codz" id="codz">



<table width="80%" border="0" align="center">



  <tr>



    <td colspan="4" bgcolor="#FF0000"><div align="center" class="style1">View Sale Information </div></td>
    </tr>



  <?



  if(isset($_POST['p_date']))



  $p_date = $_SESSION['p_date'] = $_POST['p_date'];



  elseif($_SESSION['p_date']!='')



  $p_date = $_SESSION['p_date'];



  else



  $p_date = date('Y-m-d');



  



  ?>



  <tr>



    <td align="right" bgcolor="#FF9966"><strong> Date: </strong></td>



    <td bgcolor="#FF9966"><input name="p_date" type="text" id="p_date" style="width:100px;" value="<?=$p_date?>" /></td>



    <td rowspan="2" bgcolor="#FF9966"><strong>

      <input type="submit" name="submit" id="submit" value="Open Item" style="width:170px; font-weight:bold; font-size:12px; height:30px; color:#090"/>

    </strong></td>

    <td rowspan="2" bgcolor="#FF9966"><a href="sales_order_view.php?sale_no=<?=$se_sale->sale_no?>" target="_blank"><img src="../../images/print.png" width="26" height="26" /></a></td>
  </tr>



  <tr>

    <td align="right" bgcolor="#FF9966"><strong>Select SE: </strong></td>

    <td bgcolor="#FF9966"><select name="se_id" id="se_id" style="width:220px;">

        <?

foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['se_id'],'use_type="PL" and master_warehouse_id='.$_SESSION['user']['depot'].' order by warehouse_id');

?>

    </select></td>
    </tr>
</table>



<br />







<!--Recept Sale Amount-->





<table width="80%" border="0" align="center">



  <tr>



    <td colspan="3" bgcolor="#336633"><div align="center" class="style1">Today Cash Receive </div></td>

    </tr>



  <?



  if(isset($_POST['p_date']))



  $p_date = $_SESSION['p_date'] = $_POST['p_date'];



  elseif($_SESSION['p_date']!='')



  $p_date = $_SESSION['p_date'];



  else



  $p_date = date('Y-m-d');



  



  ?>



  <tr>



    <td bgcolor="#33CC66"><strong>Select Bank/Cash: </strong></td>



    <td bgcolor="#33CC66" align="center"><strong>Amount</strong></td>

    <td rowspan="2" bgcolor="#33CC66"><strong>

      <input type="submit" name="collection" id="collection" value="Collection" style="width:200px; font-weight:bold; font-size:12px; height:30px; color:#090"/>

    </strong></td>

  </tr>



  <tr>

    <td bgcolor="#33CC66">

		<div align="left"><select name="c_id" id="c_id" style="width:320px; height:30px; float:left" onChange="open_limit(this.value)" tabindex="3">



                  <? if($_SESSION['user']['id']!='10120'){?>      <option></option><? }?>



                        <?



$led2=mysql_query("select ledger_id, ledger_name from accounts_ledger where ledger_group_id='1086' and parent=0 order by ledger_id");







if(mysql_num_rows($led2) > 0)



{



while($ledg2 = mysql_fetch_row($led2)){



echo '<option value="'.$ledg2[0].'">'. $ledg2[1].' ['.$ledg2[0].']</option>';



}



$data2 = substr($data2, 0, -1);



}



						?>



        </select></div>	</td>

    <td bgcolor="#33CC66"><input name="c_amt" type="text" id="c_amt" style="width:100px;height:30px;" value="" /></td>

    </tr>

</table>















<div class="tabledesign2" style="width:80%">

  <table width="100%" border="0" align="center" id="grp" cellpadding="0" cellspacing="0">

    <tr>

      <th><div align="center">A/C Ledger ID </div></th>

      <th>A/C Ledger Name </th>

      <th bgcolor="#FF9999">Received Amt </th>

      </tr>

<? 

$fdate = strtotime($p_date)-1;

$tdate = $fdate+84600;

$p="select a.jv_date,b.ledger_id,b.ledger_name,a.dr_amt,a.cr_amt,a.tr_from,a.narration,a.jv_no,a.tr_no,a.jv_no,a.cheq_no,a.cheq_date,a.cc_code from secondary_journal a,accounts_ledger b where a.ledger_id=b.ledger_id and a.dr_amt>0 and a.jv_no in (select distinct jv_no from secondary_journal where jv_date between '$fdate' AND '$tdate' and tr_from='Collection' and ledger_id = '".$se_info->ledger_id."')";

$query = mysql_query($p);

while($info = mysql_fetch_object($query)){

?>

    <tr>

      <td><div align="center"><?=$info->ledger_id?></div></td>

      <td><div align="center"><?=$info->ledger_name?></div></td>

      <td bgcolor="#FF9999"><div align="center"><?=$info->dr_amt?></div></td>

    </tr>

<?

}

?>

  </table>

</div>











<br /><br />





<!--/Recept Sale Amount-->



<?



if($_POST['se_id']>0){



?>



<div class="tabledesign2" style="width:100%">



<table width="100%" border="0" align="center" id="grp" cellpadding="0" cellspacing="0">



  <tr>



    <th><div align="center">Item Name </div></th>



    <th>Rate</th>



    <th>Opening</th>

    <th bgcolor="#66CC99">Issue</th>

    <th bgcolor="#FF9999">Sale</th>

    <th>Closing</th>

    <th>Sale Amt </th>

    <th><div align="center">Action</div></th>
  </tr>



  <?

  

 if($_POST['sub_group']!='')

  $con=" and sub_group_id=".$_POST['sub_group'];

  

 $sql = "select * from item_info where sub_group_id=1096000300010000".$con;



  $query = mysql_query($sql);



  while($data=mysql_fetch_object($query)){$i++;



  $info = find_all_field('item_sale_issue','','warehouse_id = "'.$_SESSION['user']['depot'].'" and sale_date = "'.$p_date.'" and item_id = "'.$data->item_id.'" and se_id = "'.$se_id.'"');

  $opening_old = find_a_field_sql("SELECT `today_close` FROM `item_sale_issue` WHERE `se_id`='".$se_id."' and `sale_date`<'".$p_date."' and item_id='".$data->item_id."' order by sale_date desc");



  //$reorder=$info->reorder_qty;



  //$position=$info->warehouse_position;



  ?>



  <tr>

<td><?=$data->item_name?></td>

<td><?=$data->d_price?>
  <input readonly name="item_rate_<?=$data->item_id?>" id="item_rate_<?=$data->item_id?>" type="hidden" value="<?=$data->d_price;?>" /></td>
<td><input readonly name="opening_<?=$data->item_id?>" id="opening_<?=$data->item_id?>" type="text" size="10"  value="<?=($opening_old==0)?'0.00':$opening_old;?>" style="width:50px;" /></td>

<td bgcolor="#66CC99"><input name="issue_<?=$data->item_id?>" id="issue_<?=$data->item_id?>" type="text" size="10"  value="<?=$info->today_issue;?>" style="width:50px;" onKeyUp="calculation(<?=$data->item_id?>)" /></td>

<td bgcolor="#FF9999"><input name="sale_<?=$data->item_id?>" id="sale_<?=$data->item_id?>" type="text" size="10"  value="<?=$info->today_sale;?>" style="width:50px;" onKeyUp="calculation(<?=$data->item_id?>)" /></td>

<td><input readonly name="closing_<?=$data->item_id?>" id="closing_<?=$data->item_id?>" type="text" size="10"  value="<?=$info->today_close;?>" style="width:50px;" /></td>

<td><input readonly name="sale_amt_<?=$data->item_id?>" id="sale_amt_<?=$data->item_id?>" type="text" size="10"  value="<?=$info->today_sale_amt;?>" style="width:60px;" /></td>

<td><span id="divi_<?=$data->item_id?>">



   <?

if($m_found==0&&$p_found==0)

	{

	if($info->id<1)

	{

?>

    <input name="flag_<?=$data->item_id?>" type="hidden" id="flag_<?=$data->item_id?>" value="0" />

    <input type="button" name="Button" value="Save"  onclick="calculation(<?=$data->item_id?>);update_value(<?=$data->item_id?>)" style="width:40px; height:20px;background-color:#66CC66"/>

<? }



		 else



			{?>



				  <input name="flag_<?=$data->item_id?>" type="hidden" id="flag_<?=$data->item_id?>" value="1" />



				  <input type="button" name="Button" value="Edit"  onclick="calculation(<?=$data->item_id?>);update_value(<?=$data->item_id?>)" style="width:40px; height:20px; background-color:#FF3366"/>



		 <? }}



		 ?>



          </span>&nbsp;</td>
  </tr>



  <? }?>
</table>



</div>

<div class="tabledesign2" style="width:100%">



<table width="100%" border="0" align="center" id="grp" cellpadding="0" cellspacing="0">



  <tr>



    <th><div align="center">A/C Ledger ID </div></th>



    <th>A/C Ledger Name </th>



    <th bgcolor="#66CC99">Credit</th>

    <th bgcolor="#FF9999">Debit</th>

    <th>Status</th>

    </tr>





  <tr>

<td><div align="center">

  <?=$se_info->ledger_id?>

</div></td>

<td><div align="center">

  <?=$se_info->warehouse_name?>

</div></td>

<td bgcolor="#66CC99"><div align="center">0.00</div></td>

<td bgcolor="#FF9999"><div align="center">

  <?=$se_sale->total_sales?>

</div></td>

</tr>

  <tr>

    <td><div align="center">3001000100000000</div></td>

    <td><div align="center">Sales</div></td>

    <td bgcolor="#66CC99"><div align="center">

      <?=$se_sale->total_sales?>

    </div></td>

    <td bgcolor="#FF9999"><div align="center">0.00</div></td>

    <td rowspan="2"><div align="center"><? if($se_sale->status=='MANUAL') echo 'PENDING'; elseif($se_sale->total_sales>0) echo 'COMPLETED'; else echo 'NOT APPLICABLE';?></div></td>

  </tr>

  

</table>



</div>



<? }?>



<p style="width:60%; float:left;">



   <? if($se_sale->status=='MANUAL'){?>

	 	   <input name="confirmit" type="submit" id="confirmit" value="TODAY SALE & ACCOUNT ENTRY COMPLETE" style=" width:300px; height:25px; background-color:#FF3300 float:right; font-weight:700;" /> 	       

 	     <? }?>

	

	</p>



</form>



</div>







<?



$main_content=ob_get_contents();



ob_end_clean();



include ("../../template/main_layout.php");



?>