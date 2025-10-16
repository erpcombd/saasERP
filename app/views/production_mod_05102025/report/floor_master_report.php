<?

session_start();

require_once(SERVER_CORE.'core/init.php');
date_default_timezone_set('Asia/Dhaka');



if(isset($_POST['submit'])&&isset($_POST['report'])&&$_POST['report']>0)

{

	if((strlen($_POST['t_date'])==10)&&(strlen($_POST['f_date'])==10))

	{

		$t_date=$_POST['t_date'];

		$f_date=$_POST['f_date'];

	}

	

	if($_POST['by']>0) 			$by=$_POST['by'];

	if($_POST['vendor_id']>0) 	$vendor_id=$_POST['vendor_id'];

	if($_POST['cat_id']>0) 		$cat_id=$_POST['cat_id'];

	if($_POST['item_id']>0) 	$item_id=$_POST['item_id'];

	if($_POST['sub_group_id']>0)$sub_group_id=$_POST['sub_group_id'];

	if($_POST['status']!='') 	$status=$_POST['status'];



switch ($_POST['report']) {

    case 1:

		$report="Purchase Order Report";

		if(isset($by)) 			{$by_con=' and a.entry_by='.$by;}

		if(isset($vendor_id)) 	{$vendor_con=' and a.vendor_id='.$vendor_id;}

		if(isset($cat_id)) 		{$cat_con=' and d.id='.$cat_id;}

		if(isset($item_id)) 	{$item_con=' and b.item_id='.$item_id;}

		
		if(isset($sub_group_id)) 				{$item_sub_con=' and d.sub_group_id='.$sub_group_id;} 
		if($_POST['group_id']!='') 				    {$item_group_con=' and g.group_id='.$_POST['group_id'];} 

		if(isset($status)) 		{$status_con=' and a.status="'.$status.'"';}

		

if(isset($t_date)) 

{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.po_date between \''.$fr_date.'\' and \''.$to_date.'\'';}



		

		  $sql='select a.po_no, a.po_date, a.vendor_id as vendor_code, c.vendor_name, b.item_id as material_code, e.item_name as material_description, b.unit_name as UOM, b.qty, b.rate, a.currency, b.amount, a.status, a.entry_at, f.fname as entry_by 

		   

		   from purchase_master a, purchase_invoice b, vendor c, item_sub_group d, item_group g, item_info e, user_activity_management f 

		   where d.group_id=g.group_id and a.po_no=b.po_no and c.vendor_id=a.vendor_id and d.sub_group_id=e.sub_group_id and b.item_id=e.item_id and f.user_id=a.entry_by and a.status!="MANUAL" '.$date_con.$by_con.$vendor_con.$cat_con.$item_con.$status_con.$item_sub_con.$item_group_con.' order by a.po_no,b.id';

	break;
	

	case 3:

		$report="Chalan Report (Chalan Date Wise)";

		if(isset($by)) 			{$by_con=' and a.prepared_by='.$by;} 

		if(isset($vendor_id)) 	{$vendor_con=' and a.vendor_id='.$vendor_id;} 

		if(isset($cat_id)) 		{$cat_con=' and d.id='.$cat_id;} 

		if(isset($item_id)) 	{$item_con=' and b.item_id='.$item_id;} 

		if(isset($status)) 		{$status_con=' and a.status="'.$status.'"';} 

if(isset($t_date)) 

{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.po_date between \''.$fr_date.'\' and \''.$to_date.'\'';}



		

		   $sql='select a.po_date,c.vendor_name as vendor_name,a.status,f.fname as prepared_by, a.prepared_at,a.id as po_no,b.id as order_id,d.category_name,e.item_name,(b.qty*1.00) as qty,b.rate,b.amount,

((select sum(qty) from purchase_master_chalan where b.id=specification_id)*1.00) as chalan_qty, 

((select b.qty-sum(qty) from purchase_master_chalan where b.id=specification_id)) as balance_qty from purchase_master a, 

purchase_invoice b, vendor c, item_sub_group d, item_info e, user_activity_management f where a.id=b.po_no and c.id=a.vendor_id and d.id=e.product_category_id and b.item_id=e.id and f.user_id=a.prepared_by and a.status!="MANUAL" '.$date_con.$by_con.$vendor_con.$cat_con.$item_con.$status_con.' order by a.id,b.id';

	break;

	case 4:

	if($_REQUEST['wo_id']>0)
	?>
    	<script>
			window.location.replace ("../report/work_order_print.php?po_no="+<?=$_REQUEST['wo_id']?>);
		</script>
    <?
	break;

	case 5:

		$report="Purchase History Report";
        if($_POST['by']!='') 				{$by_con=' and pm.entry_by="'.$_POST['by'].'" ';} 
		
		if($_POST['group_id']!='') 				{$group_con=' and g.group_id="'.$_POST['group_id'].'" ';}
		
		if(isset($warehouse_id)) 				{$warehouse_con=' and a.relevant_warehouse='.$warehouse_id;} 
		if(isset($item_id)) 				    {$item_con=' and a.item_id='.$item_id;} 
		if(isset($sub_group_id)) 				{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 
		if(isset($group_id)) 				    {$item_group_con=' and s.group_id='.$group_id;} 
		
		if(isset($vendor_id)) 	                {$vendor_con=' and v.vendor_id='.$vendor_id;} 

		$status_con=' and a.tr_from = "Purchase" ';

		if(isset($t_date)) 
		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

  $sql='select 
ji_date as MRR_Date,a.sr_no as MRR_no,pm.po_date,pm.po_no,i.item_name,s.sub_group_name as Category,
i.unit_name as unit,pr.qty,a.item_price as rate,((a.item_in+a.item_ex)*a.item_price) as amount,v.vendor_name,a.entry_at,c.fname as User 

from journal_item a, item_info i, user_activity_management c , item_sub_group s ,item_group g, purchase_receive pr,purchase_master pm,vendor v

where s.group_id=g.group_id and pm.vendor_id=v.vendor_id and c.user_id=a.entry_by and s.sub_group_id=i.sub_group_id and a.item_id=i.item_id and a.tr_no=pr.id and pr.po_no=pm.po_no 
'.$date_con.$warehouse_con.$item_con.$status_con.$item_sub_con.$vendor_con.$item_group_con.$by_con.$group_con.' order by a.id';
		

	break;
	
	case 55:

		$report="Purchase History Report(All)";

		if(isset($by)) 				            {$by_con=' and pm.entry_by='.$by;} 
		if(isset($item_id)) 				    {$item_con=' and a.item_id='.$item_id;} 
		if(isset($sub_group_id)) 				{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 
		if($_POST['group_id']!='') 				    {$item_group_con=' and g.group_id='.$_POST['group_id'];} 
		
		if(isset($vendor_id)) 	                {$vendor_con=' and v.vendor_id='.$vendor_id;} 


		if(isset($t_date)) 
		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and pr.rec_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

$sql='select 
pr.rec_date as MRR_Date,pr.pr_no as MRR_no,pm.po_date,pm.po_no,i.item_name,s.sub_group_name as Category,
i.unit_name as unit,pr.qty,pr.rate,(pr.qty*pr.rate) as amount,v.vendor_name,(select fname from user_activity_management where user_id=pm.entry_by) as entry_by,pr.entry_at,c.fname as recieve_by 

from item_info i, user_activity_management c , item_sub_group s ,item_group g, purchase_receive pr,purchase_master pm,vendor v

where s.group_id=g.group_id and pm.vendor_id=v.vendor_id and c.user_id=pr.entry_by and s.sub_group_id=i.sub_group_id and pr.item_id=i.item_id and pr.po_no=pm.po_no 
'.$date_con.$by_con.$item_con.$item_sub_con.$vendor_con.$item_group_con.' order by pr.id';
		

	break;
	case 1001:
$report="Vendor Information";
if($_POST['vendor_category']!='')
$con.=' and a.vendor_category ='.$_POST['vendor_category'];
if($_POST['status']!='')
$con.=' and a.status = "'.$_POST['status'].'"';
if($_POST['vendor_type']!='')
$con.=' and a.vendor_type = "'.$_POST['vendor_type'].'"';

        $sql="select a.vendor_id as vendor_code, a.vendor_name, a.address, a.contact_no, a.email, a.contact_person_name as contact_person, a.contact_person_designation ,a.contact_person_mobile, c.category_name, b.vendor_type,  a.ledger_id as ledger_code, (select ledger_name from accounts_ledger where ledger_id=a.ledger_id) as ledger_name,   a.status,u.fname as entry_by from vendor a, vendor_type b, vendor_category c, user_activity_management u where a.vendor_type = b.id and a.vendor_category = c.id and a.entry_by=u.user_id ".$con." order by a.vendor_id asc";
		break;

}

}



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="content-type" content="text/html; charset=utf-8" />

<title><?=$report?></title>

<link href="../../../../public/assets/css/report.css" type="text/css" rel="stylesheet" />

<script language="javascript">

function hide()

{

document.getElementById('pr').style.display='none';

}

</script>
<style type="text/css">
<!--
.style1 {
	color: #FF0000;
	font-weight: bold;
}
-->
</style>
</head>

<body>

<div align="center" id="pr">

<input type="button" value="Print" onClick="hide();window.print();"/>

</div>

<div class="main">

<?

		$str 	.= '<div class="header">';
		if(isset($_SESSION['company_name'])) 
		$str 	.= '<h1>'.$_SESSION['company_name'].'</h1>';
		if(isset($report)) 
		$str 	.= '<h2>'.$report.'</h2>';
		if(isset($to_date)) 
		$str 	.= '<h2>'.$fr_date.' To '.$to_date.'</h2>';
		$str 	.= '</div>';
		if(isset($_SESSION['company_logo'])) 
		//$str 	.= '<div class="logo"><img height="60" src="'.$_SESSION['company_logo'].'"</div>';
		$str 	.= '<div class="left">';
		if(isset($project_name)) 
		$str 	.= '<p>Project Name: '.$project_name.'</p>';
		if(isset($allotment_no)) 
		$str 	.= '<p>Allotment No.: '.$allotment_no.'</p>';
		$str 	.= '</div><div class="right">';
		if(isset($client_name)) 
		$str 	.= '<p>Client Name: '.$client_name.'</p>';
		$str 	.= '</div><div class="date">Reporting Time: '.date("h:i A d-m-Y").'</div>';
		
		
		
if($_POST['report']==7)

{
$sql='';
$report="Purchase Requisition Report";

?>

	<table width="100%" border="0" cellpadding="2" cellspacing="0">

		

		<thead>

		<tr><td colspan="21" style="border:0px;">

		<?

		echo '<div class="header">';

		echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';

		if(isset($report)) 

		echo '<h2>'.$report.'</h2>';




if(isset($t_date)) 

		echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';
		
		
		
if($_POST['item_id']>0){ echo '<h3><b>Item Name : </b> <u>'.find_a_field('item_info','item_name','1 and item_id='.$_POST['item_id']).'</u></h3>';};


if($_POST['sub_group_id']!=''){echo '<h3><b>Sub Category  : </b> <u>'.find_a_field('item_sub_group','sub_group_name','1 and sub_group_id='.$_POST['sub_group_id']).'</u></h3>';};
if($_POST['by']!=''){echo '<h3><b>Entry By  : </b> <u>'.find_a_field('user_activity_management','fname','1 and user_id='.$_POST['by']).'</u></h3>';};

		echo '</div>';



		echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';

		?>

		</td></tr>
<tbody>



	<tr>

		<th width="5%">PR No</th>
		<th width="5%">PR Date</th>
		<th width="10%"><div align="center">Req For</div></th>
		<th width="10%"><div align="center">Req By</div></th>
        <th width="5%"><div align="center">Status</div></th>
		<th width="38%">Item Name </th>
		<th width="7%">Qty</th>
		<th width="7%">Po No</th>
		<th width="6%">PO Qty </th>
	    <th width="6%">Due Qty </th>
	</tr>

<? 

if($_POST['f_date']!=''&&$_POST['t_date']!='')
$con .= 'and a.req_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';

if($_POST['item_id']>0){$item_con= ' and i.item_id='.$_POST['item_id'].' ';};
if($_POST['sub_group_id']!=''){$sub_group_con = ' and s.sub_group_id='.$_POST['sub_group_id'].' ';};

if($_POST['by']!=''){$entry_con = ' and u.user_id='.$_POST['by'].' ';};


$res='select  a.req_no, a.req_date,b.warehouse_name req_for,u.fname as entry_by,a.status
from requisition_master a,warehouse b,user_activity_management u , requisition_order r, item_info i ,  item_sub_group s
where i.sub_group_id=s.sub_group_id and a.req_no=r.req_no and r.item_id=i.item_id and u.user_id=a.entry_by  and  b.warehouse_id = a.req_for '.$entry_con.$sub_group_con.$item_con. $con.' group by a.req_no ';

$query = db_query($res);
while($data=mysqli_fetch_object($query)){

?>
	<tr>
      	<td valign="top"><a href="mr_print_view.php?req_no=<?=$data->req_no;?>" target="_blank"><?=$data->req_no;?></a></td>
	  	<td valign="top"><?=$data->req_date;?></td>
		<td valign="top"><div align="center">
	  	  <?=$data->req_for;?>
  	    </div></td>
		<td valign="top"><div align="center">
		  <?=$data->entry_by;?>
	    </div></td>
        <td valign="top"><div align="center">
          <?=$data->status;?>
        </div></td>
	  	<td colspan="5"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:9px; border:0;">
<? 
$sql1 = 'select a.*,i.item_name from requisition_order a,item_info i, item_sub_group s where i.sub_group_id=s.sub_group_id and a.item_id=i.item_id '.$sub_group_con.$item_con.' and a.req_no="'.$data->req_no.'"';
$sqlq = db_query($sql1);

$qty = 0;
while($info=mysqli_fetch_object($sqlq)){
?>
          <tr>
            <td width="60%"><?=$info->item_name.'('.$info->unit_name.')';?></td>
            <td width="10%"><?=$qty=$info->qty?></td>
             <td width="10%"><? 
	    $i = 0;
	    $t ="select po_no,qty from purchase_invoice i where i.req_id = '".$info->id."' and
	    i.item_id=".$info->item_id;
		$total_qty=0;
	    $s = db_query($t);
	    while($q=mysqli_fetch_object($s)){ if($i>0) echo ','.'<a href="../pr/po_print_view.php?po_no='.$q->po_no.'" target="_blank">'.$q->po_no.'</a>'; else echo '<a href="../pr/po_print_view.php?po_no='.$q->po_no.'" target="_blank">'.$q->po_no.'</a>'; $i++; 
		$total_qty=($total_qty+$q->qty);
		}
		if($data->status=='CANCELED'){echo '<span style="color: red; font-weight: bold; ">CANCELED</span>';}
		else{
		
		if($i==0) echo '<span style="color: #FF00FE; font-weight: bold;">PENDING</span>';
		}
		?></td>
             <td width="10%"><? echo $total_qty; ?></td>
             <td width="10%"><? echo $p_qty=($info->qty-$total_qty); ?></td>
          </tr>
          <? }?>
		  
		  
		  
        </table></td>
	</tr>

<? 

$t_qty = $t_qty+$qty;
$t_po_qty = $t_po_qty+$total_qty;
$t_p_qty = $t_p_qty+$p_qty;

}?>

<tr>
<td>&emsp;</td>
<td>&emsp;</td>
<td>&emsp;</td>
<td>&emsp;</td>
<td>&emsp;</td>
<td>&emsp;</td>
<td><?=$t_qty?></td>
<td>&emsp;</td>
<td><?=$t_po_qty?></td>
<td><?=$t_p_qty?></td>

</tr>

</tbody></table>

<?

}
if($_POST['report']==2)

{
$sql='';
$report="Chalan Report (Purchase Order Wise)";

?>

	<table width="100%" border="0" cellpadding="2" cellspacing="0">

		

		<thead>

		<tr><td colspan="19" style="border:0px;">

		<?

		echo '<div class="header">';

		echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';

		if(isset($report)) 

		echo '<h2>'.$report.'</h2>';



if(isset($t_date)) 

		echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';

		echo '</div>';



		echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';

		?>

		</td></tr>

<tbody>



	<tr>

		<th width="7%">Po No</th>

		<th width="9%">Po Date</th>
		<th width="10%">Warehouse</th>
		<th width="20%">Vendor Name</th>
		<th width="6%">PR No</th>
		<th width="18%">Item Name </th>

		<th width="7%">Rate</th>

		<th width="6%">OQ</th>

		<th width="6%">RQ</th>

		<th width="5%">UDQ</th>

	    <th width="6%">Amt</th>

	</tr>

<? 





if($_POST['f_date']!=''&&$_POST['t_date']!='')

$con .= 'and a.po_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';

if($_POST['vendor_id']>0)

$con .= 'and a.vendor_id="'.$_POST['vendor_id'].'"';



$res='select  a.po_no, a.po_date,b.warehouse_name, v.vendor_name,u.fname as entry_by

from 

purchase_master a,warehouse b, vendor v,user_activity_management u where u.user_id=a.entry_by and a.warehouse_id=b.warehouse_id and  a.vendor_id=v.vendor_id and  a.warehouse_id = "'.$_SESSION['user']['depot'].'" '.$con.' order by a.po_no desc';



$query = db_query($res);

while($data=mysqli_fetch_object($query))

{



?>



	<tr>

      <td valign="top"><?=$data->po_no;?></td>

	  <td valign="top"><?=$data->po_date;?></td>
		<td valign="top"><?=$data->warehouse_name;?></td>
	  <td valign="top"><?=$data->vendor_name;?></td>

	  <td colspan="7">

<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:9px; border:0;">

<? 

$sql1 = 'select a.*,b.item_name from purchase_invoice a,item_info b where a.item_id=b.item_id and a.po_no="'.$data->po_no.'"';

$sqlq = db_query($sql1);

while($info=mysqli_fetch_object($sqlq)){

?>

	<tr>
	<td width="11%"><? $pr=find_a_field('purchase_receive','pr_no','order_no="'.$info->id.'"'); if($pr==''){echo 'Not Received';}else{echo $pr;}?></td>
	  <td width="33%"><?=$info->item_name.'('.$info->unit_name.')';?></td>

	  <td width="14%"><?=number_format($info->rate,2)?></td>

	  <td width="11%"><?=number_format($info->qty,0)?></td>

	  <td width="10%"><? $rq = find_a_field('purchase_receive','sum(qty)','order_no="'.$info->id.'"'); echo number_format($rq,0);?></td>

	  <td width="10%"><? $dq = $info->qty - $rq; if($dq>0) echo number_format($dq,0); $tot = $rq*$info->rate; $total = $total + $tot;?></td>

	  <td width="11%"><?=number_format(($tot),2);?></td>

	</tr>

<? }?>

</table>	  </td>

	</tr>

<? }?>

	<tr>

	  <td colspan="10" valign="top"><div align="right"><strong>Total:</strong></div></td>

	  <td><div align="right">

	    <?=number_format(($total),2);?></div></td>

	</tr>

</tbody></table>

<?

}

if($_POST['report']==6)

{

$report="Purchase Receive Report";

?>

	<table width="100%" border="0" cellpadding="2" cellspacing="0">

		

		<thead>

		<tr><td colspan="20" style="border:0px;">

		<?

		echo '<div class="header">';

		echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';

		if(isset($report)) 

		echo '<h2>'.$report.'</h2>';



if(isset($t_date)) 

		echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';

		echo '</div>';



		echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';

		?>

		</td></tr>
<tbody>



	<tr>

		<th width="5%">Po No</th>
		<th width="5%">Po Date</th>
		<th >PR NO </th>
		<th width="15%">Vendor Name</th>
		<th width="30%">Item Name </td>
		<th width="9%">Rate</td>
		<th width="9%">OQ</td>
		<th width="9%">RQ</td>
		<th width="9%">DQ</td>
	  <th width="9%">Amt</td>
	 <!-- <th width="8%">Entry By</td>	-->
	  </tr>

<? 





if($_POST['f_date']!=''&&$_POST['t_date']!='')

$con .= 'and a.po_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';

if($_POST['vendor_id']>0)

$con .= 'and a.vendor_id="'.$_POST['vendor_id'].'"';
if($_POST['by']>0)

$con .= 'and a.entry_by="'.$_POST['by'].'"';



$res='select  a.po_no, a.po_date, v.vendor_name,u.fname as entry_by,a.req_no

from 

purchase_master a,warehouse b, vendor v,user_activity_management u where u.user_id=a.entry_by and a.warehouse_id=b.warehouse_id and  a.vendor_id=v.vendor_id and  a.warehouse_id = "'.$_SESSION['user']['depot'].'" '.$con.' order by a.po_no desc';



$query = db_query($res);

while($data=mysqli_fetch_object($query))

{



?>



	<tr>

      <td valign="top"><a href="po_print_view.php?po_no=<?=$data->po_no;?>" target="_blank"><?=$data->po_no;?></a></td>

	  <td valign="top"><?=$data->po_date;?></td>

	  <td valign="top"><a href="mr_print_view.php?req_no=<?=$data->req_no;?>" target="_blank"><?=$data->req_no;?></a></td>
	  <td valign="top"><?=$data->vendor_name;?></td>

	  <td colspan="6">

<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size: 12px; border: 0;">

<? 

$sql2 = 'select a.*,b.item_name from purchase_invoice a,item_info b where a.item_id=b.item_id and a.po_no="'.$data->po_no.'"';

$sqlq = db_query($sql2);

while($info=mysqli_fetch_object($sqlq)){

?>

	<tr>

	  <td width="40%"><?=$info->item_name.'('.$info->unit_name.')';?></td>

	  <td width="12%"><?=number_format($info->rate,2)?></td>

	  <td width="12%"><?=number_format($info->qty,0)?></td>

	  <td width="12%"><? $rq = find_a_field('purchase_receive','sum(qty)','order_no="'.$info->id.'"'); echo number_format($rq,0);?></td>

	  <td width="12%"><? $dq = $info->qty - $rq; if($dq>0) echo number_format($dq,0); $tot = $rq*$info->rate; $total = $total + $tot;?></td>

	  <td width="12%"><?=number_format(($tot),2);?></td>
	  
	</tr>

<? }?>
</table>	  </td>
	</tr>

<? }?>

	<tr>

	  <td colspan="9" valign="top"><div align="right"><strong>Total:</strong></div></td>

	  <td><div align="right">

	    <?=number_format(($total),2);?></div></td>
		<!--<td>&nbsp;</td>-->
	</tr>
</tbody></table>

<?

}

elseif(isset($sql)&&$sql!='') echo report_create($sql,1,$str);

?></div>

</body>

</html>