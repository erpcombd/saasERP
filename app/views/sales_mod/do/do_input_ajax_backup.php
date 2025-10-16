<?php

session_start();


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



//--========Table information==========-----------//
$table_master='sale_do_master';

$unique_master='do_no';

$table_detail='sale_do_details';

$unique_detail='id';

//--========Table information==========-----------//

$unique = $_POST[$unique_master];


//$_POST['unit_price']=$_POST['unit_price'] ;

$table		=$table_detail;
$crud      	=new crud($table);


		$_POST['entry_by']=$_SESSION['user']['id'];
		$_POST['group_for']=$_SESSION['user']['group'];

		$_POST['entry_at']=date('Y-m-d h:i:s');

	
//		$_POST['dist_unit'] = ($_POST['pkt_unit'] * $_POST['pkt_size']);
//		$_POST['total_unit'] = $_POST['dist_unit'];
//		$_POST['net_total_amt'] = ($_POST['total_unit'] * $_POST['unit_price']);
//		$_POST['total_amt'] = ($_POST['net_total_amt'] - $_POST['discount']);
		



$crud->insert();






 echo $res='select a.id,b.item_name,a.crt_price as CRT_price, a.pkt_unit as CRT, a.dist_unit as PCS, a.total_amt as Net_sale, a.discount, a.vat_amt, a.total_amt_with_vat as Due_amt from 
   sale_do_details a,item_info b where b.item_id=a.item_id and a.do_no='.$$unique.' order by a.id';

?>


<div  class="tabledesign2">

<table width="100%" border="0" cellspacing="0" cellpadding="0">

<tr>

<th width="1%">SL</th>

<th width="33%">Product Name</th>

<th width="8%">CRT Price</th>
<th width="6%">CRT</th>
<th width="6%">PCS</th>
<th width="9%">Net Sale</th>
<th width="10%">Discount</th>
<th width="10%">Vat Amt</th>
<th width="9%">Due Amt</th>
<th width="8%">X</th>
</tr>


<?

$i=1;

$query = db_query($res);

while($data=mysqli_fetch_object($query)){ ?>

<tr>

<td><?=$i++?></td>

<td><?=$data->item_name?></td>

<td><?=$data->CRT_price?></td>
<td>

<?=$data->CRT; $tot_crt +=$data->CRT;?></td>
<td><?=$data->PCS; $tot_pcs +=$data->PCS;?></td>
<td><?=$data->Net_sale; $tot_Net_sale +=$data->Net_sale;?></td>
<td><?=$data->discount; $tot_discount +=$data->discount;?></td>
<td><?=$data->vat_amt; $tot_vat_amt +=$data->vat_amt;?></td>
<td><?=$data->Due_amt; $tot_Due_amt +=$data->Due_amt;?></td>
<td><a href="?del=<?=$data->id?>">X</a></td>
</tr>

<? } ?>

<tr>

<td colspan="3"><div align="right"><strong> Total:</strong></div></td>

<td><?=number_format($tot_crt,2);?></td>
<td><?=number_format($tot_pcs,2);?></td>
<td><?=number_format($tot_Net_sale,2);?></td>
<td><?=number_format($tot_discount,2);?></td>
<td><?=number_format($tot_vat_amt,2);?></td>
<td><?=number_format($tot_Due_amt,2);?></td>
<td>&nbsp;</td>
</tr>






</table>

</div>


<?

$all_dealer[]=link_report_add_del_auto($res,'',7);
echo json_encode($all_dealer);

?>



