<?php
session_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$config_ledger = find_all_field('config_group_class','sales_ledger',"group_for=".$_SESSION['user']['group']);
$mon = '09';


$day = '1';
// day 0-3

$start_day = '"2014-'.$mon.'-'.(($day*8)+1).'"';
if($day==3)
$end_day = '"2014-'.$mon.'-'.date("t", mktime(0, 0, 0, $mon, 1, 2000)).'"';

else
$end_day = '"2014-'.$mon.'-'.((($day+1)*8)).'"';

$sql = 'select c.id,c.do_no,c.chalan_no, d.account_code, c.chalan_date,c.total_amt,i.finish_goods_code from sale_do_chalan c,dealer_info d,item_info i where c.dealer_code=d.dealer_code and c.item_id = i.item_id and c.chalan_date between '.$start_day.' and '.$end_day.'';
$query = db_query($sql);
while($data = mysqli_fetch_object($query))
{
if($chalan_no != $data->chalan_no&&$chalan_no>0)
{
auto_insert_sales_secoundary($jv,$chalan_date,$dealer_ledger,$config_ledger->sales_ledger,$chalan_no,$ch_total_amt,$do_no,$ch_id);
}
echo $jv=next_journal_sec_voucher_id();
echo $chalan_no = $data->chalan_no;
echo '<br>';
$item_fg = $data->finish_goods_code;
$total_amt = $data->total_amt;
$chalan_date = $data->chalan_date;
$dealer_ledger = $data->account_code;

$do_no = $data->do_no;
$ch_id = $data->id;
		
				if($item_fg == 2000){
				$total_amt = (-1)*$total_amt;
				auto_insert_sales_secoundary($jv,$chalan_date,$config_ledger->sales_cash_discount,$dealer_ledger,$chalan_no,$total_amt,$do_no,$ch_id);}
				elseif($item_fg>5000)
				auto_insert_sales_secoundary($jv,$chalan_date,$config_ledger->sales_trade_offer,$dealer_ledger,$chalan_no,$total_amt,$do_no,$ch_id);
				else
				$ch_total_amt = $ch_total_amt + $total_amt;
++$x;}
echo 'Complete '.$x.' entries';
?>