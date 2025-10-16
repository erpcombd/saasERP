<?
session_start();
require "../../../engine/tools/check.php";
require "../../../engine/configure/db_connect.php";
require "../../../engine/tools/my.php";
require "../../../engine/tools/report.class.php";

date_default_timezone_set('Asia/Dhaka');

if(isset($_POST['submit'])&&isset($_POST['report'])&&$_POST['report']>0)
{
	if((strlen($_POST['t_date'])==10)&&(strlen($_POST['f_date'])==10))
	{
		$t_date=$_POST['t_date'];
		$f_date=$_POST['f_date'];
	}
	
if($_POST['product_group']!='') 	$product_group=$_POST['product_group'];
if($_POST['item_brand']!='') 		$item_brand=$_POST['item_brand'];
if($_POST['product_nature']!='') 	$product_nature=$_POST['product_nature'];

if(isset($product_group)) 			{$product_group_con=' and i.sales_item_type like "%'.$product_group.'%"';} 
if(isset($item_brand)) 				{$item_brand_con=' and i.item_brand="'.$item_brand.'"';} 
if(isset($product_nature)) 			{$product_nature=' and i.product_nature="'.$product_nature.'"';} 


switch ($_POST['report']) {

case 1:
$report="Finish Goods List Summary";

$sql="select 
i.finish_goods_code as code, 
i.item_name,
i.item_brand,
i.brand_category,
i.brand_category_type,
i.unit_name,
i.pack_size,
i.cost_price

from 
item_info i,item_sub_group s
where s.sub_group_id=i.sub_group_id 
and i.finish_goods_code>0
".$product_group_con.$item_brand_con.$product_nature." 
order by code desc";
break;

case 11:
$report="Finish Goods List Summary";

echo $sql="select 
i.finish_goods_code as code, 
i.item_name,
i.item_brand,
i.brand_category,
i.brand_category_type,
i.unit_name,
i.pack_size,
i.cost_price,
is.sub_fg,
is.item_name as is_name

from 
item_info i,item_sub_group s
where s.sub_group_id=i.sub_group_id 
and i.finish_goods_code>0
".$product_group_con.$item_brand_con.$product_nature." 
LEFT JOIN item_info_sub is
on i.finish_goods_code = is.fg_code_master
order by code desc";
break;

case 2:
$report="Product List Details";
$sql="select i.item_id, i.item_name,s.sub_group_name, i.finish_goods_code as code, i.product_nature,i.unit_name,i.pack_unit,i.pack_size,i.purchase_unit,i.purchase_size
,i.p_price,i.f_price,i.d_price,i.t_price,i.m_price,i.cost_price,i.sale_price,i.sales_item_type,i.item_brand
from 
item_info i,item_sub_group s
where s.sub_group_id=i.sub_group_id 
and i.finish_goods_code>0
".$product_group_con.$item_brand_con.$product_nature." order by code";
break;

case 3:
$report="Price List Details";
$sql="select i.item_id, i.item_name,s.sub_group_name, i.finish_goods_code as code, i.product_nature,i.unit_name,i.pack_unit,i.pack_size,i.purchase_unit,i.purchase_size
,i.p_price,i.f_price,i.d_price,i.t_price,i.m_price,i.cost_price,i.sale_price,i.sales_item_type,i.item_brand
from 
item_info i,item_sub_group s
where s.sub_group_id=i.sub_group_id 
and i.finish_goods_code>0
".$product_group_con.$item_brand_con.$product_nature." order by code";
break;


case 4: // 
$report="Dealer Information";

$sql="select a.dealer_code as code,a.account_code as ledger_code,a.dealer_name_e as dealer_name ,
(select ledger_name from accounts_ledger where ledger_id=a.account_code) as ledger_name,
(select AREA_NAME from area where AREA_CODE=a.area_code) as area,

a.propritor_name_e as propritor_name,a.address_e as address,a.mobile_no, a.canceled as active,w.warehouse_name as depot 

from dealer_info a,warehouse w 

where w.warehouse_id=a.depot
and w.group_for = '".$_SESSION['user']['group']."'
order by a.dealer_code desc";
break;
}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title><?=$report?></title>
<link href="../../css/report.css" type="text/css" rel="stylesheet" />
<script language="javascript">
function hide()
{
document.getElementById('pr').style.display='none';
}
</script>
    <style type="text/css" media="print">
      div.page
      {
        page-break-after: always;
        page-break-inside: avoid;
      }
    </style>
</head>
<body>
<div align="center" id="pr">
<input type="button" value="Print" onclick="hide();window.print();"/>
</div>
<div class="main">
<?
		$str 	.= '<div class="header">';
		if(isset($_SESSION['company_name'])) 
		$str 	.= '<h1>'.$_SESSION['company_name'].'</h1>';
		if(isset($report)) 
		$str 	.= '<h2>'.$report.'</h2>';
		if(isset($to_date)) 
		$str 	.= '<h2>Date Interval : '.$fr_date.' To '.$to_date.'</h2>';
		if(isset($product_group)) 
		$str 	.= '<h2>Product Group : '.$product_group.'</h2>';
		$str 	.= '</div>';
		$str 	.= '<div class="left" style="width:100%">';

echo report_create($sql,1,$str);
?></div>
</body>
</html>