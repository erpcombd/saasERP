<?php
session_start();
ob_start();
require "../../../warehouse_mod/support/inc.all.php";

$title='Purchase Receive';

$page_for = 'Purchase';





if(isset($_POST['confirmm'])){
$pr_no = $_POST['pr_no'];

$pr_recvSql='select item_id,tax, sum(amount) as tot_amount from purchase_receive_local where pr_no='.$pr_no.' group by pr_no';

$pr_recvQuery=db_query($pr_recvSql);

$pr_recvData=mysqli_fetch_object($pr_recvQuery);

$pr_amt  = $pr_recvData->tot_amount;

$tax_amt = (($pr_recvData->tot_amount*$pr_recvData->tax)/100);

$ledger = find_a_field('item_group ig, item_sub_group isg, item_info ii','isg.sub_group_id',' ii.sub_group_id=isg.sub_group_id and isg.group_id=ig.group_id and ii.item_id='.$pr_recvData->item_id);
$ledger_id = find_all_field('item_sub_group','','sub_group_id='.$ledger);


$sales_ledger = $ledger_id->ledger_id;
$pending_ledger = $ledger_id->ledger_id_2;


if($ledger_id->group_id =='1100000000'){
reinsert_auto_reinsert_local_purchase_secoundary($pr_no);
}
else{
reinsert_auto_reinsert_local_purchase_secoundary_new($pr_no);
}
}
echo "Completed";


?>



<form action="" method="post" name="cz" id="cz">
  <table width="100%" border="0">
    <tr>
      <td align="center">&nbsp;</td>
      <td align="center">Purchase NO: 
        <input  name="pr_no" type="text" id="pr_no" value="" required/></td>
    </tr>
    <tr>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
    </tr>
    <tr>
      <td align="center">&nbsp;</td>
      <td align="center"> <input name="confirmm" type="submit" class="btn1" value="Purchase Auto Sec Journal" 
	  style="width:270px; font-weight:bold; font-size:12px; height:30px; color:#090" /></td>
    </tr>
  </table>
  <p>Note: This is only fresh Sec. journal create function.</p>
</form>













