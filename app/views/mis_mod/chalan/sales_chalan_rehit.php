<?php
session_start();
ob_start();
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Sales Chalan Re-hit';			// Page Name and Page Title



if(isset($_POST['pri_chalan_rehit'])){

//$pr_no = $_REQUEST['chalan_no'];
//and m.chalan_date between '2024-09-29' and '2025-07-09' 

  $pr_sql="select m.chalan_no, m.group_for, g.cogs_ledger, g.item_ledger, j.jv_no ,m.do_no,m.entry_by,m.entry_at
	
	from sale_do_chalan m, secondary_journal j, item_info i, item_sub_group g 
  
  where m.chalan_date between '2025-06-30' and '2025-08-30' and m.chalan_no=j.tr_no and  j.tr_from in ('Sales','COGS')  and i.item_id=m.item_id 
  and i.sub_group_id=g.sub_group_id and m.flag=1
  group by m.chalan_no";



$consumption_ledger= find_a_field('item_sub_group','group_concat(item_ledger)','1');
$cogs_ledger=find_a_field('item_sub_group','group_concat(cogs_ledger)','1');



$pr_query=db_query($pr_sql);
while($pr_data=mysqli_fetch_object($pr_query)){

   // and jv_date between '2024-09-29' and '2025-07-09'
$sql3="DELETE FROM secondary_journal  WHERE tr_from in ('COGS')
  AND ledger_id IN (".$consumption_ledger.",".$cogs_ledger.")
  and jv_date between '2025-06-30' and '2025-08-30'
  and tr_no=".$pr_data->chalan_no." ";
  db_query($sql3);
  
  
  $sql4="DELETE FROM journal  WHERE tr_from in ('Sales','COGS')
  and jv_date between '2025-06-30' and '2025-08-30'
  and tr_no='".$pr_data->chalan_no."' ";
  db_query($sql4);

// $sql4 = "DELETE FROM journal WHERE tr_from ='Sales' and jv_date between '2024-03-06' and '2025-06-20' and group_for=4 and  tr_no='".$pr_data->chalan_no."'";
 // db_query($sql4);


  
$ch_no=$pr_data->chalan_no;
$g_f=$pr_data->group_for;
$fg_ledger=$pr_data->item_ledger;
$cogs=$pr_data->cogs_ledger;
$jv_no=$pr_data->jv_no;
$tr_no=$pr_data->chalan_no;


$narration = 'CH:'.$ch_no.'; SO: '.$pr_data->do_no;

$tr_from ='Sales';


//$jv=next_journal_sec_voucher_id('',$tr_from,$g_f);

$ch_sum = 0;

/*$ch_sql="select c.* from sale_do_chalan c, journal_item j 
where c.chalan_no='".$ch_no."' and j.item_id=c.item_id and j.sr_no=c.chalan_no and j.tr_no=c.order_no and j.tr_from='Sales'";

$ch_query = db_query($ch_sql);



while($ch_data=mysqli_fetch_object($ch_query)){

$last_cost_price=find_a_field('journal_item','item_price','item_id="'.$ch_data->item_id.'" and sr_no='.$ch_data->chalan_no.' and tr_from="Sales"');

 $update_ch_data = "update sale_do_chalan set flag='1',cost_price='".$last_cost_price."',cost_amt=total_unit*".$last_cost_price." where chalan_no='".$ch_data->chalan_no."' and item_id='".$ch_data->item_id."' and  id=".$ch_data->id." ";

db_query($update_ch_data);

}*/

auto_insert_sales_cogs_secoundary($ch_no,$jv_no);

sec_journal_journal($jv_no,$jv_no,$tr_from);
//sec_journal_journal($jv_no,$jv_no,'COGS');

}


echo 'Chalan-'.$ch_no.',Re-Hit Complete. Check';
echo '<br>';

}







?>




<form action="" method="post">

<div class="oe_view_manager oe_view_manager_current">
<div class="oe_view_manager_body">
<div  class="oe_view_manager_view_list"></div>

<div class="oe_view_manager_view_form"><div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">

<div class="oe_form_container"><div class="oe_form">
<div class="oe_form_sheetbg" style="min-height:10px;">
<div class="oe_form_sheet oe_form_sheet_width">
<div  class="oe_view_manager_view_list">
<div  class="oe_list oe_view">



<table width="85%" border="0" align="center" cellpadding="5" cellspacing="0">

  <tr>
    <td height="35" bgcolor="#33CCFF"><strong>Primary Chalan No: </strong></td>
    <td bgcolor="#33CCFF"><input name="chalan_no" type="text" id="chalan_no" maxlength="100" value="<?=$_POST['chalan_no'];?>"  /></td>
   <td align="center" valign="middle" ><input name="pri_chalan_rehit" type="submit" id="search" class="btn1 btn1-submit-input" value="Re-Journal Primary Chalan" /></td>
  </tr>

</table>

</div></div>
</div>
</div>
</div></div>
</div></div>
</div>
</div>

</form>

<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>