<?

session_start();



require_once "../../../assets/support/inc.all.php";



$item_id = $_REQUEST['item_id'];

//$item_rate = $_REQUEST['item_rate'];

$flag = $_REQUEST['flag'];

$opening = $_REQUEST['opening'];

$issue = $_REQUEST['issue'];

$sale = $_REQUEST['sale'];

$closing = $_REQUEST['closing'];

//$sale_amt = $_REQUEST['sale_amt'];

$warehouse_id = $_SESSION['user']['depot'];

$p_date = $_REQUEST['p_date'];

$se_id = $_REQUEST['se_id'];

$entry_by = $_REQUEST['entry_by']=$_SESSION['user']['id'];

$entry_at = $_REQUEST['entry_at']=date('Y-m-d H:i:s');

$sale_no = (date('ymd',strtotime($p_date))*10000)+$se_id;





if($_REQUEST['flag']==0)

{
$sql = "INSERT INTO item_sale_issue (sale_no,sale_date, item_id, warehouse_id, se_id, item_rate, today_open, today_receive, today_issue, today_close, today_sale_amt, status, entry_at, entry_by) VALUES

('".$sale_no."','".$p_date."','".$item_id."', '".$warehouse_id."', '".$se_id."','".$item_rate."', '".$opening."', '".$issue."', '".$sale."','".$closing."','".$sale_amt."', 'MANUAL', '".$entry_at."', '".$entry_by."')";

}



else

{

$sql = "UPDATE item_sale_issue SET today_receive = '".$issue."', today_issue = '".$sale."', today_close = '".$closing."', today_sale_amt = '".$sale_amt."', edit_by = '".$entry_by."', edit_at = '".$entry_at."' WHERE sale_date = '".$p_date."' and item_id = '".$item_id."' and se_id = '".$se_id."' ";

}



if(mysql_query($sql))

{

mysql_query('delete from journal_item where item_id='.$item_id.' and tr_no = '.$sale_no);



if($issue>0){

//journal_item_control($item_id ,$_SESSION['user']['depot'],$p_date,0,$issue,'Issue',$sale_no,$item_rate,$se_id);

//journal_item_control($item_id ,$se_id,$p_date,$issue,0,'Issue',$sale_no,$item_rate,$_SESSION['user']['depot']);

}

if($sale<0)

journal_item_control($item_id ,$se_id,$p_date,0,$sale,'Sale',$sale_no,$item_rate);



echo 'Success!';

}

?>