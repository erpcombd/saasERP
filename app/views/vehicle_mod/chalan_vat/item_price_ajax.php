<?

session_start();

require_once "../../../assets/support/inc.all.php";



$chalan_no=$_REQUEST['item_id'];

$memo_no=find_a_field('sale_do_chalan','max(memo_no)+1',' 1');
if($memo_no<4300) $memo_no=4300;
$sql='update sale_do_chalan set memo_no='.$memo_no.' , vat_approval="Yes" where chalan_no='.$chalan_no;



mysql_query($sql);

echo 'Success!';

?>