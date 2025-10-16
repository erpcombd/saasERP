<?php

require_once "../../../assets/template/layout.top.php";

$title='Approve Sales Return';



$table_master='sales_return_master';

$unique_master = $unique='or_no';

do_calander('#fdate');
do_calander('#tdate');
do_datatable('grp');

$table_detail='sales_return_details';

$unique_detail='id';



$table_chalan='sale_return_chalan';

$unique_chalan='id';



if($_POST['or_no']>0){
	$$unique = $_POST['or_no'];
	}




$$unique_master=$_SESSION[$unique_master];



if(isset($_POST['delete']))

{

		$crud   = new crud($table_master);

		$condition=$unique_master."=".$$unique_master;		

		$crud->delete($condition);

		$crud   = new crud($table_detail);

		$crud->delete_all($condition);

		$crud   = new crud($table_chalan);

		$crud->delete_all($condition);

		unset($$unique_master);

		unset($_SESSION[$unique_master]);

		$type=1;

		$msg='Successfully Deleted.';

}

if(isset($_POST['confirmm']))

{
		unset($_POST);
		$_POST['entry_at']=date('Y-m-d h:i:s');
		$_POST['status']='CHECKED';
		
		
		 $sql = "update sales_return_master set status='CHECKED' where or_no = ".$$unique;
		$query = mysql_query($sql);


		$sql = "select * from sales_return_details where or_no = ".$$unique;
		$query = mysql_query($sql);
		while($data=mysql_fetch_object($query)){
		journal_item_control($data->item_id ,$_SESSION['user']['depot'],$data->or_date,$data->qty,0,'Sales Return',$data->id,$data->rate,'',$$unique);
		}
		
		
		
		auto_insert_sales_return_secoundary($$unique);
		
		

		unset($$unique_master);

		unset($_SESSION[$unique_master]);

		$type=1;

		$msg='Successfully Instructed to Depot.';

}





$table='sale_do_master';

$show='dealer_code';

$id='do_no';

$con='status="MANUAL"';



?>

<script language="javascript">

window.onload = function() {

  document.getElementById("dealer").focus();

}

</script>

<div class="form-container_large">

 <form action="" method="post" name="codz" id="codz">
    <table width="80%" border="0" align="center">
      <tr>
        <td>&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#FF9966"><strong>Date Interval :</strong></td>
        <td width="1" bgcolor="#FF9966"><strong>
          <input type="text" name="fdate" id="fdate" style="width:107px;" value="<?=($_POST['fdate']!='')?$_POST['fdate']:date('Y-m-01');?>"/>
        </strong></td>
        <td align="center" bgcolor="#FF9966"><strong> -to- </strong></td>
        <td width="1" bgcolor="#FF9966"><strong>
          <input type="text" name="tdate" id="tdate" style="width:107px;" value="<?=($_POST['tdate']!='')?$_POST['tdate']:date('Y-m-d');?>" />
        </strong></td>
        <td rowspan="2" bgcolor="#FF9966"><strong>
          <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
        </strong></td>
      </tr>
  
    </table>
  </form>
  </div>
  
  <table style="cursor:pointer" width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td><div class="tabledesign2">
<table width="100%" cellspacing="0" cellpadding="0" id="grp">
<thead>
<tr>

<th class="text-center">SR No</th>
<th class="text-center">Entry By</th>
<th class="text-center">SR Date</th>
<th class="text-center">Customer Name</th>
<th class="text-center">Action</th>

 </tr>
 </thead>
 <tbody>


<? 
if($_POST['fdate']!='') {$con=' and p.or_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';}else{$con=' and p.or_date between "'.date('Y-m-o1').'" 
and "'.date('Y-m-d').'"';}



 $res= 'select p.or_no,p.or_date,d.dealer_name_e,u.fname
 
 
from sales_return_master p,dealer_info d,user_activity_management u


 where p.vendor_id=d.dealer_code  and p.entry_by=u.user_id and p.status="UNCHECKED" '.$con.' ';


$query = mysql_query($res);
while($data = mysql_fetch_object($query)){
?>
<tr>
<td class="text-center"><?=$data->or_no?></td>
<td class="text-center"><?=$data->fname?></td>
<td class="text-center"><?=$data->or_date?></td>
<td class="text-center"><?=$data->dealer_name_e?></td>
<td class="text-center"><a href="approve_item_return.php?or_no=<?=$data->or_no?>"><button class="btn btn-success btn-sm">APPROVE</button></a></td>

</tr>
<?php } ?>

</tbody></table>
</div></td>
</tr>
</table>



<?

require_once "../../../assets/template/layout.bottom.php";

?>