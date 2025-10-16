<?php



session_start();



ob_start();




require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$sale_no = $_REQUEST['sale_no'];





$title='Black Tea Transection';







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

db_query($sql);






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



<table  style="width:80%; border:0; margin:0 auto; text-align:center;">



  <tr>



    <td colspan="4"  style="background-color:#FF0000;"><div  style="text-align:center;" class="style1">Black Tea Transection</div></td>
    </tr>



  <?



  if(isset($_POST['p_date'])){



  $p_date = $_SESSION['p_date'] = $_POST['p_date'];}



  elseif($_SESSION['p_date']!=''){



  $p_date = $_SESSION['p_date'];}



  else{



  $p_date = date('Y-m-d');}



  



  ?>



  <tr>



    <td  style="text-align:right; background-color:#FF9966;"><strong> Date: </strong></td>



    <td  style="background-color:#FF9966;"><input name="p_date" type="text" id="p_date" style="width:100px;" value="<?=$p_date?>" /></td>



    <td rowspan="2" style="background-color:#FF9966;"><strong>

      <input type="submit" name="submit" id="submit" value="Open Item" style="width:170px; font-weight:bold; font-size:12px; height:30px; color:#090"/>

    </strong></td>

    <td rowspan="2"  style="background-color:#FF9966;"><a href="sales_order_view.php?sale_no=<?=$se_sale->sale_no?>" target="_blank"><img src="../../images/print.png"  style="width:26px; height:26px;" /></a></td>
  </tr>



  <tr>

    <td style="text-align:right; background-color:#FF9966;"><strong>Select SE: </strong></td>

    <td style="background-color:#FF9966;"><select name="se_id" id="se_id" style="width:220px;">

        <?

foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['se_id'],'use_type="PL" and master_warehouse_id='.$_SESSION['user']['depot'].' order by warehouse_id');

?>

    </select></td>
    </tr>
</table>



<br />







<!--Recept Sale Amount-->













<br /><br />





<!--/Recept Sale Amount-->



<?



if($_POST['se_id']>0){



?>



<div class="tabledesign2" style="width:100%">



<table id="grp"  style="width:100%; border:0; border-collapse:collapse; border-spacing:0; padding:0; text-align:center;">



  <tr>



    <th><div  style="text-align:center;">Item Name </div></th>



    <th>Rate</th>



    <th>Opening</th>

    <th style="background-color:#66CC99;">Receive</th>
    <th style="background-color:#66CC99;">Issue</th>

    <th>Closing</th>

    <th>Sale Amt </th>

    <th><div style="text-align:center;">Action</div></th>
  </tr>



  <?

  

 if($_POST['sub_group']!=''){

  $con=" and sub_group_id=".$_POST['sub_group'];}

  

 $sql = "select * from item_info where sub_group_id=1096000300010000".$con;



  $query = db_query($sql);



  while($data=mysqli_fetch_object($query)){$i++;



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

<td  style="background-color:#66CC99;"><input name="issue_<?=$data->item_id?>" id="issue_<?=$data->item_id?>" type="text" size="10"  value="<?=$info->today_receive;?>" style="width:50px;" onKeyUp="calculation(<?=$data->item_id?>)" /></td>

<td style="background-color:#66CC99;"><input name="sale_<?=$data->item_id?>" id="sale_<?=$data->item_id?>" type="text" size="10"  value="<?=$info->today_issue;?>" style="width:50px;" onKeyUp="calculation(<?=$data->item_id?>)" /></td>

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





<? }?>



<p style="width:60%; float:left;">



   <? if($se_sale->status=='MANUAL'){?>

	 	   <input name="confirmit" type="submit" id="confirmit" value="TODAY SALE & ACCOUNT ENTRY COMPLETE" style=" width:300px; height:25px; background-color:#FF3300 float:right; font-weight:700;" /> 	       

 	     <? }?>

	

	</p>



</form>



</div>







<?



// $main_content=ob_get_contents();



// ob_end_clean();



require_once SERVER_CORE."routing/layout.bottom.php";



?>