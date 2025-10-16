<?php







session_start();



$level=$_SESSION['user']['level'];



ob_start();








require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";





 $log_no 		= $_REQUEST['log_no'];











$title='Monthly Inventory Journal Calculation ';











do_calander('#f_date');



do_calander('#t_date');







if($_REQUEST['p_date']!='')



{



$p_date = $_REQUEST['p_date'];



$group_for = $_REQUEST['group_for'];



$log_shift = $_REQUEST['log_shift'];







$log_info =  find_all_field_sql("SELECT log_no, status FROM `production_log_sheet_ffw_rope` WHERE `group_for`='".$group_for."' and `log_date`='".$p_date."' and `log_shift`='".$log_shift."' ");





$p_found = find_a_field('item_sale_issue','1',' 1 and se_id = "'.$se_id.'" and status="COMPLETE" and sale_date="'.$p_date.'"');



$m_found = find_a_field('item_sale_issue','1',' 1 and se_id = "'.$se_id.'" and status="MANUAL" and sale_date<"'.$p_date.'"');



}





if(prevent_multi_submit()){



if(isset($_REQUEST['confirmit']))



{





$p_date = $_REQUEST['p_date'];



$group_for = $_REQUEST['group_for'];



$log_shift = $_REQUEST['log_shift'];



$sql = "update production_log_sheet_ffw_rope set status = 'COMPLETE' where `group_for`='".$group_for."' and  log_shift='".$log_shift."' and `log_date`='".$p_date."'";



db_query($sql);









}



}



if(isset($_REQUEST['delete']))



{







$p_date = $_REQUEST['p_date'];



$se_id = $_REQUEST['se_id'];



//$sale_no = $_REQUEST['sale_no'];



$se_info = find_all_field('warehouse','','warehouse_id='.$se_id);



$se_sale =  find_all_field_sql("SELECT sum(today_sale_amt) total_sales,sale_no,status FROM `item_sale_issue` WHERE `se_id`='".$se_id."' and `sale_date`='".$p_date."' ");



$sql = "update item_sale_issue set status = 'MANUAL' where `se_id`='".$se_id."' and `sale_date`='".$p_date."'";



db_query($sql);





$sql_del_secondary = "DELETE FROM secondary_journal WHERE tr_no ='".$se_sale->sale_no."'";



db_query($sql_del_secondary);



$sql_del_journal = "DELETE FROM journal WHERE tr_no ='".$se_sale->sale_no."'";



db_query($sql_del_journal);





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





$cc_code = $se_info->acc_code;

add_to_sec_journal('STA', $jv_no, $jv_date, $c_id              , $narration, $c_amt, '0.00', 'Collection', $se_id,'','',$cc_code);



add_to_sec_journal('STA', $jv_no, $jv_date, $se_info->ledger_id,  $narration, '0.00', $c_amt, 'Collection', $se_id,'','',$cc_code);







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



var machine_id=id; // Rent 



var p_date=(document.getElementById('p_date').value);

var group_for=(document.getElementById('group_for').value);

var supervisor=(document.getElementById('supervisor').value);

var log_shift=(document.getElementById('log_shift').value);

var wastage=(document.getElementById('wastage').value);



var machine_id=(document.getElementById('machine_id_'+id).value);

var PBI_ID=(document.getElementById('PBI_ID_'+id).value)*1;

var item_id=(document.getElementById('item_id_'+id).value)*1; 

var nd_item_id=(document.getElementById('nd_item_id_'+id).value)*1; 

var production=(document.getElementById('production_'+id).value)*1; 

var nd_production=(document.getElementById('nd_production_'+id).value)*1; 

var machine_wastage=(document.getElementById('machine_wastage_'+id).value)*1; 

var remarks=(document.getElementById('remarks_'+id).value); 



var flag=(document.getElementById('flag_'+id).value); 



//alert(item_rate)



var strURL="log_sheet_ffw_rope_ajax.php?machine_id="+machine_id+"&p_date="+p_date+"&group_for="+group_for+"&supervisor="+supervisor+"&log_shift="+log_shift+"&wastage="+wastage+"&machine_id="+machine_id+

"&PBI_ID="+PBI_ID+"&item_id="+item_id+"&nd_item_id="+nd_item_id+"&production="+production+"&nd_production="+nd_production+"&machine_wastage="+machine_wastage+"&remarks="+remarks+"&flag="+flag;







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









<script>



function calculation(id){







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







    <td colspan="6" height="25px" bgcolor="#FF0000"><div align="center" class="style1">Monthly Inventory Journal Calculation </div></td>

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







    <td bgcolor="#FF9966"><input name="f_date" type="text" id="f_date" style="width:107px;" value="<?=$_POST['f_date']?>" /></td>







    <td bgcolor="#FF9966"><div align="center"><strong>To</strong></div></td>

    <td bgcolor="#FF9966"><input name="t_date" type="text" id="t_date" style="width:107px;" value="<?=$_POST['t_date']?>" /></td>

    <td rowspan="4" bgcolor="#FF9966"><strong>



      <input type="submit" name="submit" id="submit" value="View Info" style="width:170px; font-weight:bold; font-size:12px; height:30px; color:#090"/>



    </strong></td>



    <td rowspan="4" bgcolor="#FF9966"><?php /*?><a href="log_sheet_view_ffw_rope.php?log_no=<?=$log_info->log_no?>" target="_blank"><img src="../../images/print.png" width="26" height="26" /></a><?php */?></td>

  </tr>







  

   

  

</table>







<br />

















<div class="tabledesign2" style="width:100%">







<table width="100%" border="0" align="center" id="grp" cellpadding="0" cellspacing="0">







  <tr style="font-size:14px;">







    <th width="7%"><div align="center">S/L</div></th>





    <th width="37%" bgcolor="#66CC99">Particulars</th>

    <th width="23%" bgcolor="#FF9999">Value</th>

    </tr>







  <?



  



 



  



  $sql = 'select sum(b.pkgs) as pkgs, sum(b.qty) as qty, sum(b.amount) as amount from purchase_receive  b, vendor v where b.vendor_id=v.vendor_id and v.vendor_category=2 and  b.rec_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';



  $query = db_query($sql);



  while($data=mysqli_fetch_object($query)){$i++;

  



$rec_pkgs=$data->pkgs;

$rec_qty=$data->qty;

$rec_amt=$data->amount;

$rec_rate=$rec_amt/$rec_qty;



$packing_materials_stock = find_a_field('journal','sum(dr_amt)','jv_date between "'.strtotime($_POST['f_date']).'" and "'.strtotime($_POST['t_date']).'" and ledger_id=4065002900000000');



$last_date = find_a_field('item_sale_issue','sale_date','sale_date<"'.$_POST['f_date'].'" GROUP by `sale_date` ORDER by sale_date desc ');



$raw_tea_closing = find_a_field('item_sale_issue','sum(today_close)','sale_date="'.$last_date.'"');



$raw_tea_closing_amt = find_a_field('journal','sum(dr_amt-cr_amt)','jv_date<="'.strtotime($_POST['f_date']).'" and ledger_id=1095000100000000');



$raw_tea_closing_rate=$raw_tea_closing_amt/$raw_tea_closing;



$production_qty = find_a_field('journal_item','sum(item_in)','ji_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'" and tr_from="Receive" and warehouse_id=5');



$black_tea_qty = find_a_field('blend_sheet_master m, blend_sheet_details d','sum(d.qty)',' m.blend_id=d.blend_id and m.blend_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'" ');



$black_tea_amt = find_a_field('blend_sheet_master m, blend_sheet_details d','sum(d.amount)',' m.blend_id=d.blend_id and m.blend_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'" ');



//$black_tea_issue_rate=$black_tea_amt/$black_tea_qty;



$black_tea_issue_rate=($raw_tea_closing_amt+$rec_amt)/($raw_tea_closing+$rec_qty);



$black_tea_issue_amt=$production_qty*$black_tea_issue_rate;



$packing_material = find_a_field('blend_sheet_master m, blend_sheet_packing_material p','sum(p.amount)',' m.blend_id=p.blend_id and m.blend_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'" ');



$production_profit_margin=(($black_tea_issue_amt+$packing_material)*5)/100;



$production_amount=($black_tea_issue_amt+$packing_material+$production_profit_margin);



$production_rate=($production_amount/$production_qty);



$previous_month_fct_amt = find_a_field('journal','sum(dr_amt-cr_amt)','jv_date<="'.strtotime($_POST['f_date']).'" and ledger_id=1098000100000000');



$previous_month_fct_qty = find_a_field('journal_item','sum(item_in-item_ex)','ji_date<="'.$_POST['f_date'].'" and warehouse_id=5 and `item_id` LIKE "%109600090001%"');



$previous_month_fct_rate=$previous_month_fct_amt/$previous_month_fct_qty;



$factory_average_rate_fg=($production_amount+$previous_month_fct_amt)/($production_qty+$previous_month_fct_qty);



$despatch_qty_sylhet = find_a_field('journal_item','sum(item_ex)','ji_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'" and tr_from in ("Transfered","Transit") and relevant_warehouse=1');



$despatch_amt_sylhet = $despatch_qty_sylhet*$factory_average_rate_fg;



$despatch_qty_dhaka = find_a_field('journal_item','sum(item_ex)','ji_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'" and tr_from in ("Transfered","Transit") and relevant_warehouse=3');



$despatch_amt_dhaka = $despatch_qty_dhaka*$factory_average_rate_fg;



$despatch_qty_ctg = find_a_field('journal_item','sum(item_ex)','ji_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'" and tr_from in ("Transfered","Transit") and relevant_warehouse=2');



$despatch_amt_ctg = $despatch_qty_ctg*$factory_average_rate_fg;





$previous_month_sylhet_amt = find_a_field('journal','sum(dr_amt-cr_amt)','jv_date<="'.strtotime($_POST['f_date']).'" and ledger_id=1103000100000000');



$previous_month_sylhet_qty = find_a_field('journal_item','sum(item_in-item_ex)','ji_date<="'.$_POST['f_date'].'" and warehouse_id=1 and `item_id` LIKE "%109600090001%"');



$previous_month_sylhet_rate=$previous_month_sylhet_amt/$previous_month_sylhet_qty;





$previous_month_dhaka_amt = find_a_field('journal','sum(dr_amt-cr_amt)','jv_date<="'.strtotime($_POST['f_date']).'" and ledger_id=1104000100000000');



$previous_month_dhaka_qty = find_a_field('journal_item','sum(item_in-item_ex)','ji_date<="'.$_POST['f_date'].'" and warehouse_id=3 and `item_id` LIKE "%109600090001%"');



$previous_month_dhaka_rate=$previous_month_dhaka_amt/$previous_month_dhaka_qty;







$previous_month_ctg_amt = find_a_field('journal','sum(dr_amt-cr_amt)','jv_date<="'.strtotime($_POST['f_date']).'" and ledger_id=1105000100000000');



$previous_month_ctg_qty = find_a_field('journal_item','sum(item_in-item_ex)','ji_date<="'.$_POST['f_date'].'" and warehouse_id=2 and `item_id` LIKE "%109600090001%"');



$previous_month_ctg_rate=$previous_month_ctg_amt/$previous_month_ctg_qty;



$sylhet_average_rate_fg=($despatch_amt_sylhet+$previous_month_sylhet_amt)/($despatch_qty_sylhet+$previous_month_sylhet_qty);



$dhaka_average_rate_fg=($despatch_amt_dhaka+$previous_month_dhaka_amt)/($despatch_qty_dhaka+$previous_month_dhaka_qty);



$ctg_average_rate_fg=($despatch_amt_ctg+$previous_month_ctg_amt)/($despatch_qty_ctg+$previous_month_ctg_qty);



$sale_qty_sylhet = find_a_field('journal_item','sum(item_ex)','ji_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'" and warehouse_id=1');



$sale_amt_sylhet = $sale_qty_sylhet*$sylhet_average_rate_fg;



$sale_qty_dhaka = find_a_field('journal_item','sum(item_ex)','ji_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'" and warehouse_id=3');



$sale_amt_dhaka = $sale_qty_dhaka*$dhaka_average_rate_fg;



$sale_qty_ctg = find_a_field('journal_item','sum(item_ex)','ji_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'" and warehouse_id=2');



$sale_amt_ctg = $sale_qty_ctg*$ctg_average_rate_fg;



$profit_margin_adjustment_sylhet= ($sale_qty_sylhet*100)/($sale_qty_sylhet+$sale_qty_dhaka+$sale_qty_ctg);



$profit_margin_adjustment_dhaka= ($sale_qty_dhaka*100)/($sale_qty_sylhet+$sale_qty_dhaka+$sale_qty_ctg);



$profit_margin_adjustment_ctg= ($sale_qty_ctg*100)/($sale_qty_sylhet+$sale_qty_dhaka+$sale_qty_ctg);



$profit_margin_adjustment_amt_sylhet=($production_profit_margin*$profit_margin_adjustment_sylhet)/100;



$profit_margin_adjustment_amt_dhaka=($production_profit_margin*$profit_margin_adjustment_dhaka)/100;



$profit_margin_adjustment_amt_chittagong=($production_profit_margin*$profit_margin_adjustment_ctg)/100;





if(isset($_REQUEST['journal_create']))



{







//Packing Materials Stock

$jv_no = next_journal_voucher_id();

$jv_date = strtotime($_POST['t_date']);

$proj_id = 'magnol';

$tr_from = 'Inventory Journal';

$tr_no = date('Ymd', strtotime($_POST['t_date']));



$group_for=2;



$packing_materials_stock_dr=1110000100000000;



$packing_materials_stock_cr=1106000200000000;





$narration = 'Packing Materials Received.';





if($packing_materials_stock>0) {

add_to_journal($proj_id, $jv_no, $jv_date, $packing_materials_stock_dr, $narration, $packing_materials_stock, '0.00', $tr_from, $tr_no,'', '', '5',''); }



if($packing_materials_stock>0) {

add_to_journal($proj_id, $jv_no, $jv_date,  $packing_materials_stock_cr, '', '0.00', $packing_materials_stock, $tr_from, $tr_no,'', '', '5', '');	}













//Black Tea Despatch Journal

$jv_no = next_journal_voucher_id();

$jv_date = strtotime($_POST['t_date']);

$proj_id = 'magnol';

$tr_from = 'Inventory Journal';

$tr_no = date('Ymd', strtotime($_POST['t_date']));



$group_for=2;



$black_tea_despatch_dr=1094000100000000;



$black_tea_despatch_cr=1093000100000000;





$narration = 'Black Tea Despatch Chittagong to Magnolia Factory. Pkgs: ('.$rec_pkgs.'), Qty: ('.$rec_qty.' KG), at the rate: ('.$rec_rate.' taka per KG)';





if($rec_amt>0) {

add_to_journal($proj_id, $jv_no, $jv_date, $black_tea_despatch_dr, $narration, $rec_amt, '0.00', $tr_from, $tr_no,'', '', '2',''); }



if($rec_amt>0) {

add_to_journal($proj_id, $jv_no, $jv_date,  $black_tea_despatch_cr, '', '0.00', $rec_amt, $tr_from, $tr_no,'', '', '2', '');	}







$jv_no = next_journal_voucher_id();

$jv_date = strtotime($_POST['t_date']);

$proj_id = 'magnol';

$tr_from = 'Inventory Journal';

$tr_no = date('Ymd', strtotime($_POST['t_date']));



$group_for=2;



$black_tea_receive_dr=1095000100000000;



$black_tea_receive_cr=1096000100000000;





$narration = 'Black Tea Received from Chittagong Warehouse. Pkgs: ('.$rec_pkgs.'), Qty: ('.$rec_qty.' KG), at the rate: ('.$rec_rate.' taka per KG)';





if($rec_amt>0) {

add_to_journal($proj_id, $jv_no, $jv_date, $black_tea_receive_dr, $narration, $rec_amt, '0.00', $tr_from, $tr_no,'', '', '5',''); }



if($rec_amt>0) {

add_to_journal($proj_id, $jv_no, $jv_date,  $black_tea_receive_cr, '', '0.00', $rec_amt, $tr_from, $tr_no,'', '', '5','');	}







//FG Production Journal







$jv_no = next_journal_voucher_id();

$jv_date = strtotime($_POST['t_date']);

$proj_id = 'magnol';

$tr_from = 'Inventory Journal';

$tr_no = date('Ymd', strtotime($_POST['t_date']));



$group_for=2;



$fg_production_dr=1098000100000000;



$black_tea_issue_cr=1095000100000000;



$packing_material_cr=1110000100000000;



$profit_margin_cr=3027000100000000;





$narration_fg = 'Finish goods production: ('.$production_qty.' KG), at the rate: ('.$production_rate.' taka per KG)';

$narration_bt = 'Black tea issue qty: ('.$production_qty.' KG), at the rate: ('.$black_tea_issue_rate.' taka per KG)';







add_to_journal($proj_id, $jv_no, $jv_date, $fg_production_dr, $narration_fg, ($black_tea_issue_amt+$packing_material+$production_profit_margin), '0.00', $tr_from, $tr_no,'', '', '5',''); 



add_to_journal($proj_id, $jv_no, $jv_date,  $black_tea_issue_cr, $narration_bt, '0.00', $black_tea_issue_amt, $tr_from, $tr_no,'', '', '5','');



add_to_journal($proj_id, $jv_no, $jv_date,  $packing_material_cr, 'Packing materials issue', '0.00', $packing_material, $tr_from, $tr_no,'', '', '5','');	



add_to_journal($proj_id, $jv_no, $jv_date,  $profit_margin_cr, 'Production Profit Margin (5 Percent)', '0.00', $production_profit_margin, $tr_from, $tr_no,'', '', '5','');	











//Despatch Journal



$jv_no = next_journal_voucher_id();

$jv_date = strtotime($_POST['t_date']);

$proj_id = 'magnol';

$tr_from = 'Inventory Journal';

$tr_no = date('Ymd', strtotime($_POST['t_date']));



$group_for=2;



$despatch_sylhet_dr=1099000100000000;

$despatch_dhaka_dr=1100000100000000;

$despatch_ctg_dr=1101000100000000;

$despatch_cr=1098000100000000;





$narration_sylhet = 'Depot Transfer: ('.$despatch_qty_sylhet.' KG), at the rate: ('.$factory_average_rate_fg.' taka per KG)';

$narration_dhaka = 'Depot Transfer: ('.$despatch_qty_dhaka.' KG), at the rate: ('.$factory_average_rate_fg.' taka per KG)';

$narration_ctg = 'Depot Transfer: ('.$despatch_qty_ctg.' KG), at the rate: ('.$factory_average_rate_fg.' taka per KG)';







add_to_journal($proj_id, $jv_no, $jv_date, $despatch_sylhet_dr, $narration_sylhet, $despatch_amt_sylhet, '0.00', $tr_from, $tr_no,'', '', '5',''); 



add_to_journal($proj_id, $jv_no, $jv_date, $despatch_dhaka_dr, $narration_dhaka, $despatch_amt_dhaka, '0.00', $tr_from, $tr_no,'', '', '5',''); 



add_to_journal($proj_id, $jv_no, $jv_date, $despatch_ctg_dr, $narration_ctg, $despatch_amt_ctg, '0.00', $tr_from, $tr_no,'', '', '5','');



add_to_journal($proj_id, $jv_no, $jv_date,  $despatch_cr, '', '0.00', ($despatch_amt_sylhet+$despatch_amt_dhaka+$despatch_amt_ctg), $tr_from, $tr_no,'', '', '5','');	











//Despatch Receive Journal



$jv_no = next_journal_voucher_id();

$jv_date = strtotime($_POST['t_date']);

$proj_id = 'magnol';

$tr_from = 'Inventory Journal';

$tr_no = date('Ymd', strtotime($_POST['t_date']));



$group_for=2;



$despatch_receive_sylhet_dr=1103000100000000;

$despatch_receive_dhaka_dr=1104000100000000;

$despatch_receive_ctg_dr=1105000100000000;

$despatch_receive_cr=1102000100000000;





$narration_sylhet = 'Transfer Received: ('.$despatch_qty_sylhet.' KG), at the rate: ('.$factory_average_rate_fg.' taka per KG)';

$narration_dhaka = 'Transfer Received: ('.$despatch_qty_dhaka.' KG), at the rate: ('.$factory_average_rate_fg.' taka per KG)';

$narration_ctg = 'Transfer Received: ('.$despatch_qty_ctg.' KG), at the rate: ('.$factory_average_rate_fg.' taka per KG)';







add_to_journal($proj_id, $jv_no, $jv_date, $despatch_receive_sylhet_dr, $narration_sylhet, $despatch_amt_sylhet, '0.00', $tr_from, $tr_no,'', '', '1',''); 



add_to_journal($proj_id, $jv_no, $jv_date, $despatch_receive_dhaka_dr, $narration_dhaka, $despatch_amt_dhaka, '0.00', $tr_from, $tr_no,'', '', '3',''); 



add_to_journal($proj_id, $jv_no, $jv_date, $despatch_receive_ctg_dr, $narration_ctg, $despatch_amt_ctg, '0.00', $tr_from, $tr_no,'', '', '2','');



add_to_journal($proj_id, $jv_no, $jv_date,  $despatch_receive_cr, '', '0.00', ($despatch_amt_sylhet+$despatch_amt_dhaka+$despatch_amt_ctg), $tr_from, $tr_no,'', '', '5','');	







//Depot Sale 



$jv_no = next_journal_voucher_id();

$jv_date = strtotime($_POST['t_date']);

$proj_id = 'magnol';

$tr_from = 'Inventory Journal';

$tr_no = date('Ymd', strtotime($_POST['t_date']));



$group_for=2;



$depot_sale_sylhet_dr=1102000100000000;



$depot_sale_sylhet_cr=1103000100000000;





$narration = 'Depot Sales Qty: ('.$sale_qty_sylhet.' KG), at the rate: ('.$sylhet_average_rate_fg.' taka per KG)';







add_to_journal($proj_id, $jv_no, $jv_date, $depot_sale_sylhet_dr, $narration, $sale_amt_sylhet, '0.00', $tr_from, $tr_no,'', '', '1',''); 





add_to_journal($proj_id, $jv_no, $jv_date,  $depot_sale_sylhet_cr, '', '0.00', $sale_amt_sylhet, $tr_from, $tr_no,'', '', '1','');	









$jv_no = next_journal_voucher_id();

$jv_date = strtotime($_POST['t_date']);

$proj_id = 'magnol';

$tr_from = 'Inventory Journal';

$tr_no = date('Ymd', strtotime($_POST['t_date']));



$group_for=2;



$depot_sale_dhaka_dr=1102000100000000;



$depot_sale_dhaka_cr=1104000100000000;





$narration = 'Depot Sales Qty: ('.$sale_qty_dhaka.' KG), at the rate: ('.$dhaka_average_rate_fg.' taka per KG)';







add_to_journal($proj_id, $jv_no, $jv_date, $depot_sale_dhaka_dr, $narration, $sale_amt_dhaka, '0.00', $tr_from, $tr_no,'', '', '3',''); 





add_to_journal($proj_id, $jv_no, $jv_date,  $depot_sale_dhaka_cr, '', '0.00', $sale_amt_dhaka, $tr_from, $tr_no,'', '', '3','');	









$jv_no = next_journal_voucher_id();

$jv_date = strtotime($_POST['t_date']);

$proj_id = 'magnol';

$tr_from = 'Inventory Journal';

$tr_no = date('Ymd', strtotime($_POST['t_date']));



$group_for=2;



$depot_sale_ctg_dr=1102000100000000;



$depot_sale_ctg_cr=1105000100000000;





$narration = 'Depot Sales Qty: ('.$sale_qty_ctg.' KG), at the rate: ('.$ctg_average_rate_fg.' taka per KG)';





add_to_journal($proj_id, $jv_no, $jv_date, $depot_sale_ctg_dr, $narration, $sale_amt_ctg, '0.00', $tr_from, $tr_no,'', '', '2',''); 





add_to_journal($proj_id, $jv_no, $jv_date,  $depot_sale_ctg_cr, '', '0.00', $sale_amt_ctg, $tr_from, $tr_no,'', '', '2','');	











//Profit Margin Adjustment





$jv_no = next_journal_voucher_id();

$jv_date = strtotime($_POST['t_date']);

$proj_id = 'magnol';

$tr_from = 'Inventory Journal';

$tr_no = date('Ymd', strtotime($_POST['t_date']));



$group_for=2;



$profit_margin_dr=3027000100000000;



$profit_margin_sylhet_cr=1099000100000000;



$profit_margin_dhaka_cr=1100000100000000;



$profit_margin_ctg_cr=1101000100000000;





$narration = 'Factory Profit Margin Adjustment';





add_to_journal($proj_id, $jv_no, $jv_date, $profit_margin_dr, $narration, $production_profit_margin, '0.00', $tr_from, $tr_no,'', '', '5','');



add_to_journal($proj_id, $jv_no, $jv_date,  $profit_margin_sylhet_cr, '', '0.00', $profit_margin_adjustment_amt_sylhet, $tr_from, $tr_no,'', '', '5','');



add_to_journal($proj_id, $jv_no, $jv_date,  $profit_margin_dhaka_cr, '', '0.00', $profit_margin_adjustment_amt_dhaka, $tr_from, $tr_no,'', '', '5','');



add_to_journal($proj_id, $jv_no, $jv_date,  $profit_margin_ctg_cr, '', '0.00', $profit_margin_adjustment_amt_chittagong, $tr_from, $tr_no,'', '', '5','');











	

	

		

		$msg='Successfully Journal Voucher Create.';

		





}





  ?>

  

<? } ?>





<tr style=" font-size:12px;">



<td><div align="center">01	</div></td>



<td bgcolor="#66CC99"><strong>Packing Materials Stock In (Factory)

</strong>

<td bgcolor="#FF9999"><input name="" id="" type="text" size="10"  value="<?=$packing_materials_stock?>" style="width:150px;"></td>

</tr>





<tr style=" font-size:12px;">



<td><div align="center">02	</div></td>



<td bgcolor="#66CC99"><strong>Previous Month Black Tea Closing Quantity

</strong>

<td bgcolor="#FF9999"><input name="" id="" type="text" size="10"  value="<?=$raw_tea_closing?>" style="width:150px;"></td>

</tr>





<tr style=" font-size:12px;">



<td><div align="center">03</div></td>



<td bgcolor="#66CC99"><strong>Previous Month Black Tea Closing Amount

</strong>

<td bgcolor="#FF9999"><input name="" id="" type="text" size="10"  value="<?=$raw_tea_closing_amt?>" style="width:150px;"></td>

</tr>



<!--<tr style=" font-size:12px;">



<td><div align="center">04</div></td>



<td bgcolor="#66CC99"><strong>Previous Month Black Tea Closing Rate

</strong>

<td bgcolor="#FF9999"><input name="" id="" type="text" size="10"  value="<?=$raw_tea_closing_rate?>" style="width:150px;"></td>

</tr>-->











<tr style=" font-size:12px;">



<td><div align="center">05</div></td>



<td bgcolor="#66CC99"><strong>Present Month Black Tea Despatch Amount

</strong>

<td bgcolor="#FF9999"><input name="" id="" type="text" size="10"  value="<?=$rec_amt?>" style="width:150px;"></td>

</tr>







  <tr style=" font-size:12px;">



<td><div align="center">06</div></td>



<td bgcolor="#66CC99"><strong>Present Month Black Tea Despatch Quantity

</strong>

<td bgcolor="#FF9999"><input name="" id="" type="text" size="10"  value="<?=$rec_qty?>" style="width:150px;"></td>

</tr>





<tr style=" font-size:12px;">



<td><div align="center">07</div></td>



<td bgcolor="#66CC99"><strong>Present Month Black Tea Despatch Rate

</strong>

<td bgcolor="#FF9999"><input name="" id="" type="text" size="10"  value="<?=$rec_rate?>" style="width:150px;"></td>

</tr>





<tr style=" font-size:12px;">



<td><div align="center">08</div></td>



<td bgcolor="#66CC99"><strong>Present Month Production Quantity

</strong>

<td bgcolor="#FF9999"><input name="" id="" type="text" size="10"  value="<?=$production_qty;?>" style="width:150px;"></td>

</tr>



<tr style=" font-size:12px;">



<td><div align="center">09</div></td>



<td bgcolor="#66CC99"><strong>Present Month Black Tea Issue Rate</strong>

<td bgcolor="#FF9999"><input name="" id="" type="text" size="10"  value="<?=$black_tea_issue_rate;?>" style="width:150px;"></td>

</tr>



<tr style=" font-size:12px;">



<td><div align="center">10</div></td>



<td bgcolor="#66CC99"><strong>Present Month Black Tea Issue Amount</strong>

<td bgcolor="#FF9999"><input name="" id="" type="text" size="10"  value="<?=$black_tea_issue_amt;?>" style="width:150px;"></td>

</tr>



<tr style=" font-size:12px;">



<td><div align="center">11</div></td>



<td bgcolor="#66CC99"><strong>Present Month Packing Materials Issue Amount</strong>

<td bgcolor="#FF9999"><input name="" id="" type="text" size="10"  value="<?=$packing_material;?>" style="width:150px;"></td>

</tr>



<tr style=" font-size:12px;">



<td><div align="center">12</div></td>



<td bgcolor="#66CC99"><strong>Present Month Production Profit Margin (5%)</strong>

<td bgcolor="#FF9999"><input name="" id="" type="text" size="10"  value="<?=$production_profit_margin;?>" style="width:150px;"></td>

</tr>



<tr style=" font-size:12px;">



<td><div align="center">13</div></td>



<td bgcolor="#66CC99"><strong>Present Month FG Production Amount</strong>

<td bgcolor="#FF9999"><input name="" id="" type="text" size="10"  value="<?=$production_amount;?>" style="width:150px;"></td>

</tr>





<tr style=" font-size:12px;">



<td><div align="center">14</div></td>



<td bgcolor="#66CC99"><strong>Present Month FG Production Rate</strong>

<td bgcolor="#FF9999"><input name="" id="" type="text" size="10"  value="<?=$production_rate;?>" style="width:150px;"></td>

</tr>







<tr style=" font-size:12px;">



<td><div align="center">15</div></td>



<td bgcolor="#66CC99"><strong>Previous Month Factory Closing Amount</strong>

<td bgcolor="#FF9999"><input name="" id="" type="text" size="10"  value="<?=$previous_month_fct_amt;?>" style="width:150px;"></td>

</tr>



<tr style=" font-size:12px;">



<td><div align="center">16	</div></td>



<td bgcolor="#66CC99"><strong>Previous Month Factory Closing Qty</strong>

<td bgcolor="#FF9999"><input name="" id="" type="text" size="10"  value="<?=$previous_month_fct_qty;?>" style="width:150px;"></td>

</tr>





<tr style=" font-size:12px;">



<td><div align="center">17	</div></td>



<td bgcolor="#66CC99"><strong>Previous Month Factory Closing Rate</strong>

<td bgcolor="#FF9999"><input name="" id="" type="text" size="10"  value="<?=$previous_month_fct_rate;?>" style="width:150px;"></td>

</tr>











<tr style=" font-size:12px;">



<td><div align="center">18	</div></td>



<td bgcolor="#66CC99"><strong>Present Month Factory Average Rate (FG)</strong>

<td bgcolor="#FF9999"><input name="" id="" type="text" size="10"  value="<?=$factory_average_rate_fg;?>" style="width:150px;"></td>

</tr>



<tr style="font-size:12px;">



<td><div align="center">19	</div></td>



<td bgcolor="#66CC99"><strong>Present Month Product Despatch Qty (Sylhet)</strong>

<td bgcolor="#FF9999"><input name="" id="" type="text" size="10"  value="<?=$despatch_qty_sylhet;?>" style="width:150px;"></td>

</tr>



<tr style="font-size:12px;">



<td><div align="center">20</div></td>



<td bgcolor="#66CC99"><strong>Present Month Product Despatch Amount (Sylhet)</strong>

<td bgcolor="#FF9999"><input name="" id="" type="text" size="10"  value="<?=$despatch_amt_sylhet;?>" style="width:150px;"></td>

</tr>









<tr style="font-size:12px;">



<td><div align="center">21</div></td>



<td bgcolor="#66CC99"><strong>Present Month Product Despatch Qty (Dhaka)</strong>

<td bgcolor="#FF9999"><input name="" id="" type="text" size="10"  value="<?=$despatch_qty_dhaka;?>" style="width:150px;"></td>

</tr>



<tr style="font-size:12px;">



<td><div align="center">22</div></td>



<td bgcolor="#66CC99"><strong>Present Month Product Despatch Amount (dhaka)</strong>

<td bgcolor="#FF9999"><input name="" id="" type="text" size="10"  value="<?=$despatch_amt_dhaka;?>" style="width:150px;"></td>

</tr>







<tr style="font-size:12px;">



<td><div align="center">23</div></td>



<td bgcolor="#66CC99"><strong>Present Month Product Despatch Qty (Chittagong)</strong>

<td bgcolor="#FF9999"><input name="" id="" type="text" size="10"  value="<?=$despatch_qty_ctg;?>" style="width:150px;"></td>

</tr>



<tr style="font-size:12px;">



<td><div align="center">24</div></td>



<td bgcolor="#66CC99"><strong>Present Month Product Despatch Amount (Chittagong)</strong>

<td bgcolor="#FF9999"><input name="" id="" type="text" size="10"  value="<?=$despatch_amt_ctg;?>" style="width:150px;"></td>

</tr>







<tr style=" font-size:12px;">



<td><div align="center">25</div></td>



<td bgcolor="#66CC99"><strong>Previous Month Sylhet Closing Amount</strong>

<td bgcolor="#FF9999"><input name="" id="" type="text" size="10"  value="<?=$previous_month_sylhet_amt;?>" style="width:150px;"></td>

</tr>



<tr style=" font-size:12px;">



<td><div align="center">26</div></td>



<td bgcolor="#66CC99"><strong>Previous Month Sylhet Closing Qty</strong>

<td bgcolor="#FF9999"><input name="" id="" type="text" size="10"  value="<?=$previous_month_sylhet_qty;?>" style="width:150px;"></td>

</tr>





<tr style=" font-size:12px;">



<td><div align="center">27	</div></td>



<td bgcolor="#66CC99"><strong>Previous Month Sylhet Closing Rate</strong>

<td bgcolor="#FF9999"><input name="" id="" type="text" size="10"  value="<?=$previous_month_sylhet_rate;?>" style="width:150px;"></td>

</tr>











<tr style=" font-size:12px;">



<td><div align="center">28	</div></td>



<td bgcolor="#66CC99"><strong>Previous Month Dhaka Closing Amount</strong>

<td bgcolor="#FF9999"><input name="" id="" type="text" size="10"  value="<?=$previous_month_dhaka_amt;?>" style="width:150px;"></td>

</tr>



<tr style=" font-size:12px;">



<td><div align="center">29	</div></td>



<td bgcolor="#66CC99"><strong>Previous Month Dhaka Closing Qty</strong>

<td bgcolor="#FF9999"><input name="" id="" type="text" size="10"  value="<?=$previous_month_dhaka_qty;?>" style="width:150px;"></td>

</tr>





<tr style=" font-size:12px;">



<td><div align="center">30</div></td>



<td bgcolor="#66CC99"><strong>Previous Month Dhaka Closing Rate</strong>

<td bgcolor="#FF9999"><input name="" id="" type="text" size="10"  value="<?=$previous_month_dhaka_rate;?>" style="width:150px;"></td>

</tr>













<tr style=" font-size:12px;">



<td><div align="center">31</div></td>



<td bgcolor="#66CC99"><strong>Previous Month Chittagogn Closing Amount</strong>

<td bgcolor="#FF9999"><input name="" id="" type="text" size="10"  value="<?=$previous_month_ctg_amt;?>" style="width:150px;"></td>

</tr>



<tr style=" font-size:12px;">



<td><div align="center">32</div></td>



<td bgcolor="#66CC99"><strong>Previous Month Chittagogn Closing Qty</strong>

<td bgcolor="#FF9999"><input name="" id="" type="text" size="10"  value="<?=$previous_month_ctg_qty;?>" style="width:150px;"></td>

</tr>





<tr style=" font-size:12px;">



<td><div align="center">33</div></td>



<td bgcolor="#66CC99"><strong>Previous Month Chittagogn Closing Rate</strong>

<td bgcolor="#FF9999"><input name="" id="" type="text" size="10"  value="<?=$previous_month_ctg_rate;?>" style="width:150px;"></td>

</tr>









<tr style=" font-size:12px;">



<td><div align="center">34</div></td>



<td bgcolor="#66CC99"><strong>Present Month Sylhet Average Rate (FG)</strong>

<td bgcolor="#FF9999"><input name="" id="" type="text" size="10"  value="<?=$sylhet_average_rate_fg;?>" style="width:150px;"></td>

</tr>





<tr style=" font-size:12px;">



<td><div align="center">35</div></td>



<td bgcolor="#66CC99"><strong>Present Month Dhaka Average Rate (FG)</strong>

<td bgcolor="#FF9999"><input name="" id="" type="text" size="10"  value="<?=$dhaka_average_rate_fg;?>" style="width:150px;"></td>

</tr>





<tr style=" font-size:12px;">



<td><div align="center">36</div></td>



<td bgcolor="#66CC99"><strong>Present Month Chittagong Average Rate (FG)</strong>

<td bgcolor="#FF9999"><input name="" id="" type="text" size="10"  value="<?=$ctg_average_rate_fg;?>" style="width:150px;"></td>

</tr>









<tr style="font-size:12px;">



<td><div align="center">37	</div></td>



<td bgcolor="#66CC99"><strong>Present Month Product Sale Qty (Sylhet)</strong>

<td bgcolor="#FF9999"><input name="" id="" type="text" size="10"  value="<?=$sale_qty_sylhet;?>" style="width:150px;"></td>

</tr>



<tr style="font-size:12px;">



<td><div align="center">38	</div></td>



<td bgcolor="#66CC99"><strong>Present Month Product Sale Amount (Sylhet)</strong>

<td bgcolor="#FF9999"><input name="" id="" type="text" size="10"  value="<?=$sale_amt_sylhet;?>" style="width:150px;"></td>

</tr>









<tr style="font-size:12px;">



<td><div align="center">39	</div></td>



<td bgcolor="#66CC99"><strong>Present Month Product Sale Qty (Dhaka)</strong>

<td bgcolor="#FF9999"><input name="" id="" type="text" size="10"  value="<?=$sale_qty_dhaka;?>" style="width:150px;"></td>

</tr>



<tr style="font-size:12px;">



<td><div align="center">40</div></td>



<td bgcolor="#66CC99"><strong>Present Month Product Sale Amount (dhaka)</strong>

<td bgcolor="#FF9999"><input name="" id="" type="text" size="10"  value="<?=$sale_amt_dhaka;?>" style="width:150px;"></td>

</tr>







<tr style="font-size:12px;">



<td><div align="center">41</div></td>



<td bgcolor="#66CC99"><strong>Present Month Product Sale Qty (Chittagong)</strong>

<td bgcolor="#FF9999"><input name="" id="" type="text" size="10"  value="<?=$sale_qty_ctg;?>" style="width:150px;"></td>

</tr>



<tr style="font-size:12px;">



<td><div align="center">42</div></td>



<td bgcolor="#66CC99"><strong>Present Month Product Sale Amount (Chittagong)</strong>

<td bgcolor="#FF9999"><input name="" id="" type="text" size="10"  value="<?=$sale_amt_ctg;?>" style="width:150px;"></td>

</tr>





<tr style="font-size:12px;">



<td><div align="center">43</div></td>



<td bgcolor="#66CC99"><strong>Profit Margin Adjustment (Sylhet)</strong>

<td bgcolor="#FF9999"><input name="" id="" type="text" size="10"  value="<?=$profit_margin_adjustment_amt_sylhet;?>" style="width:150px;"></td>

</tr>





<tr style="font-size:12px;">



<td><div align="center">44</div></td>



<td bgcolor="#66CC99"><strong>Profit Margin Adjustment (Dhaka)</strong>

<td bgcolor="#FF9999"><input name="" id="" type="text" size="10"  value="<?=$profit_margin_adjustment_amt_dhaka;?>" style="width:150px;"></td>

</tr>



<tr style="font-size:12px;">



<td><div align="center">45</div></td>



<td bgcolor="#66CC99"><strong>Profit Margin Adjustment (Chittagong)</strong>

<td bgcolor="#FF9999"><input name="" id="" type="text" size="10"  value="<?=$profit_margin_adjustment_amt_chittagong;?>" style="width:150px;"></td>

</tr>

</table>







</div>















<br /><br />





<p style="width:100%; float:left;">







 



	 	   <input name="journal_create" type="submit" id="journal_create" value="JOURNAL CREATE" style=" width:300px; float:right; height:25px; background-color:#FF3300 float:right; font-weight:700;" /> 	       



 	  



	



	</p>

	

	

	

	







</form>







</div>















<?







$main_content=ob_get_contents();







ob_end_clean();







require_once SERVER_CORE."routing/layout.bottom.php";







?>