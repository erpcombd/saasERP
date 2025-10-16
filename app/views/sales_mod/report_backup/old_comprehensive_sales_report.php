<?php
session_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$head = '<link href="../../css/report_selection.css" type="text/css" rel="stylesheet"/>';



$pi_id = $_REQUEST['lc_id'];



 if(isset($_POST['show'])){
 
 $from_date=$_REQUEST['from_date'];
 $to_date=$_REQUEST['to_date'];        
							if($_POST['from_date'] !=''  && $_POST['to_date'] !='')
							$con.= ' and m.lc_issue_date BETWEEN  "'.$_POST['from_date'].'" and "'.$_POST['to_date']. '"';
							
							if($_POST['item_name'] !='')
							$con.=' and i.item_name="'.$_POST['item_name'].'"';	
							if($_POST['lc_type'] !='')
							$con.=' and m.lc_type like "%'.$_POST['lc_type'].'%"';
							}
							





?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: Comprehensive Sales Report :.</title>
<link href="../../css/report.css" type="text/css" rel="stylesheet"/>
<script type = "text/javascript">var GB_ROOT_DIR = "../../GBox/";</script>
<script type = "text/javascript" src = "../../GBox/AJS.js"></script>
<script type = "text/javascript" src = "../../GBox/AJS_fx.js"></script>
<script type = "text/javascript" src = "../../GBox/gb_scripts.js"></script>
<link href = "../../GBox/gb_styles.css" rel = "stylesheet" type = "text/css" media = "all"/>
<script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../js/jquery-ui-1.8.2.custom.min.js"></script>
<script type="text/javascript" src="../../js/jquery.ui.datepicker.js"></script>
<script type="text/javascript" src="../../js/jquery.autocomplete.js"></script>
<script type="text/javascript" src="../../js/jquery.validate.js"></script>
<script type="text/javascript" src="../../js/paging.js"></script>
<script type="text/javascript" src="../../js/ddaccordion.js"></script>
<script type="text/javascript" src="../../js/js.js"></script>
<script type="text/javascript" src="../../js/pg.js"></script>
<link href="../../css/css.css" type="text/css" rel="stylesheet"/>
<link href="../../css/menu.css" type="text/css" rel="stylesheet"/>
<link href="../../css/jquery-ui-1.8.2.custom.css" rel="stylesheet" type="text/css" />
<link href="../../css/jquery.autocomplete.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
			function hide()
			{
				document.getElementById("pr").style.display = "none";
			}
		</script>
<?php
		
		do_calander('#from_date');
do_calander('#to_date');
		?>
<style type="text/css">
			<!--
			td {
				padding: 0px 0px;
			}
.style1 {
	font-size: 16px;
	text-align: center;
	color: #FFF;
	font-weight: bold;
}
.style4 {color: #000000; font-weight: bold; }
.style6 {color: #000000; font-weight: bold; font-size: 14px; }
.style7 {
	font-size: 14px;
	font-weight: bold;
}
			-->
		</style>
</head>
<body style="font-family:Tahoma, Geneva, sans-serif">
<br />
<br />
<div class="form-container_large" style="">
  <form action="" method="post" name="codz" id="codz">
    <div style="min-height:35px;" class="oe_form_sheet oe_form_sheet_width">
      <div class="oe_view_manager_view_list">
        <div class="oe_list oe_view">
          <table width="100%" height="35px;" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
            <tbody>
              <tr>
                <td width="10%" bordercolor="#333333" bgcolor="#99CCCC"><div align="right" style="font-size:14px;">Date Interval:</div></td>
                <td width="33%" bordercolor="#333333" bgcolor="#99CCCC"><input name="from_date" type="text" id="from_date" value="<?=($_REQUEST['from_date']=='')?date('Y-m-01'):$_REQUEST['from_date'];?>" />
                  &nbsp;--&nbsp;
                  <input name="to_date" type="text" id="to_date" value="<?=($_REQUEST['to_date']=='')?date('Y-m-d'):$_REQUEST['to_date'];?>" /></td>
                <td width="14%" bordercolor="#333333" bgcolor="#99CCCC"><div align="right" style="font-size:14px;">Team Name:&nbsp;</div></td>
                <td width="17%" bordercolor="#333333" bgcolor="#99CCCC"><select name="team_name"id="team_name">
                    <option value="">Select Team</option>
                    <?php foreign_relation('teams','team_name','team_name',$_POST['team_name']);?>
                  </select></td>
                <td width="26%" bordercolor="#333333" bgcolor="#99CCCC"><input name="show" type="submit" class="style4" id="show" style="width:180px; height:30px; color:#339966; font-weight:bold; font-size:15px;" value="Show Report" /></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </form>
</div>
<table width="100%" border="2" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top"><? $path=str_replace(' ','',"../../../logo/".$_SESSION['proj_name'].".jpg"); 
										if(is_file($path)) echo '<img src="'.$path.'" height="70" />';?>
      <table width="60%" border="0" align="center" cellpadding="5" cellspacing="0">
        <tr>
          <td bgcolor="#666666" style="text-align:center; color:#FFF; font-size:18px; font-weight:bold;">M. Ahmed Tea & Lands Co. Ltd</td>
        </tr>
        <tr>
          <td bgcolor="#666666" class="style1">Comprehensive Sales Report</td>
        </tr>
      </table>
  </tr>
</table>
<tr>
  <td style="border:0px;"><div id="pr">
      <div align="left">
        <form id="form1" name="form1" method="post" action="">
          <table width="50%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><input name="button" type="button" onclick="hide();window.print();" value="Print" /></td>
            </tr>
          </table>
        </form>
      </div>
    </div><?php if($_POST['team_name']!=""){?>
    <table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0">
      <tr>
        <td align="center" bgcolor="#CCCCCC"><span class="style6">SL #</span></td>
        <td align="center" bgcolor="#CCCCCC"><span class="style6">Employee Name</span></td>
        <td align="center" bgcolor="#CCCCCC"><span class="style6">Designation </span></td>
        <td align="center" bgcolor="#CCCCCC"><span class="style6">Market Segment</span></td>
        <td align="center" bgcolor="#CCCCCC"><span class="style6">Dealer Name </span></td>
        <td align="center" bgcolor="#CCCCCC"><span class="style6">Target</span></td>
        <td align="center" bgcolor="#CCCCCC"><span class="style6">Order</span></td>
        <td align="center" bgcolor="#CCCCCC"><span class="style7">IMS</span></td>
        <td align="center" bgcolor="#CCCCCC"><span class="style7">Net Sales</span></td>
        <td align="center" bgcolor="#CCCCCC"><span class="style7">Remittance</span></td>
        <td align="center" bgcolor="#CCCCCC"><span class="style7">Commission</span></td>
        <td align="center" bgcolor="#CCCCCC"><span class="style7">Sales Return</span></td>
        <td align="center" bgcolor="#CCCCCC"><span class="style7">No. of Memo</span></td>
        <td align="center" bgcolor="#CCCCCC"><span class="style6">Salary Payable</span></td>
        <td align="center" bgcolor="#CCCCCC"><span class="style6">TA/DA </span></td>
      </tr>
      <?
	  $team_net_sales=0;
	  $team_order=0;
	  $team_ims=0;
	  $team_memo=0;
	  $team_sales_return=0;
	  $team_sales_remitence=0;
	  
$sql = "select * from branch where team_name='".$_POST['team_name']."'";
$data = db_query($sql);			
while ($region = mysqli_fetch_object($data)) {
$region_net_sales=0;
$region_order=0;
$region_ims=0;
$region_memo=0;
$region_sales_return=0;
$region_sales_remitence=0;

$region_incharge=find_all_field('personnel_basic_info','PBI_NAME','PBI_BRANCH='.$region->BRANCH_ID);
$region_designation=find_a_field('designation','DESG_DESC','DESG_ID='.$region_incharge->PBI_DESIGNATION);

$pi++;
$sql5 = "select * from sub_region where REGION_ID=".$region->BRANCH_ID;
$data5 = db_query($sql5);			
while ($sub_region = mysqli_fetch_object($data5)) {
/////////////////////////////////////////////////////////////////////////

$sub_region_net_sales=0;
$sub_region_order=0;
$sub_region_ims=0;
$sub_region_memo=0;
$sub_region_sales_return=0;
$sub_region_sales_remitence=0;

$sub_region_incharge=find_all_field('personnel_basic_info','PBI_NAME','PBI_SUB_REGION='.$sub_region->SUB_REGION_CODE);
$sub_region_designation=find_a_field('designation','DESG_DESC','DESG_ID='.$sub_region_incharge->PBI_DESIGNATION);

$pi++;
$sql1 = "select * from zon where REGION_ID=".$sub_region->SUB_REGION_CODE;
$data1 = db_query($sql1);			
while ($zone = mysqli_fetch_object($data1)) {
///////////////////////////////////////////////////////////////////////

$zone_net_sales=0;
$zone_order=0;
$zone_ims=0;
$zone_memo=0;
$zone_sales_return=0;
$zone_sales_remitence=0;

$zone_incharge=find_all_field('personnel_basic_info','PBI_NAME','PBI_ZONE='.$zone->ZONE_CODE);
$zone_designation=find_a_field('designation','DESG_DESC','DESG_ID='.$zone_incharge->PBI_DESIGNATION);


$sql2 = "select * from area where ZONE_ID=".$zone->ZONE_CODE;
$data2 = db_query($sql2);			
while ($area = mysqli_fetch_object($data2)) {
$area_incharge=find_all_field('personnel_basic_info','PBI_NAME','PBI_AREA='.$area->AREA_CODE);
$designation=find_a_field('designation','DESG_DESC','DESG_ID='.$area_incharge->PBI_DESIGNATION);


$dealer_name=find_a_field('dealer_info', 'dealer_name_e', 'area_code='.$area->AREA_CODE);



$net_sale_sql="select sum(c.total_amt-(c.total_amt*m.cash_discount)/100) from sale_do_chalan c, sale_do_master m, dealer_info d where c.chalan_date between '".$from_date."' and '".$to_date."' and c.dealer_code=d.dealer_code and c.do_no=m.do_no and d.area_code=".$area->AREA_CODE;
$net_sales=find_a_field_sql($net_sale_sql);
$zone_net_sales=$zone_net_sales+$net_sales;
$sub_region_net_sales=$sub_region_net_sales+$net_sales;
$region_net_sales=$region_net_sales+$net_sales;
$team_net_sales=$team_net_sales+$net_sales;

$memo_sql="select sum(m.memo) as memo from ims_master m where  m.order_date between '".$from_date."' and '".$to_date."' and m.area_id=".$area->AREA_CODE;

$memo_data=mysqli_fetch_object(db_query($memo_sql));

$order_sale_sql="select sum(i.total_unit_today*i.unit_price) as order_amt, sum(m.memo) as memo,  sum(i.total_unit_ims*i.unit_price) as ims_amt from ims_details i, ims_master m where m.ims_no=i.ims_no and i.order_date between '".$from_date."' and '".$to_date."' and i.area_id=".$area->AREA_CODE;

$order_sale_data=mysqli_fetch_object(db_query($order_sale_sql));
$area_order_amt=$order_sale_data->order_amt;
$zone_order+=$area_order_amt;
$sub_region_order+=$area_order_amt;
$region_order+=$area_order_amt;
$team_order+=$area_order_amt;

$area_ims_amt=$order_sale_data->ims_amt;
$zone_ims+=$area_ims_amt;
$sub_region_ims+=$area_ims_amt;
$region_ims+=$area_ims_amt;
$team_ims+=$area_ims_amt;

$area_memo_tot=$memo_data->memo;
$zone_memo+=$area_memo_tot;
$sub_region_memo+=$area_memo_tot;
$region_memo+=$area_memo_tot;
$team_memo+=$area_memo_tot;



$sales_return_sql="select sum(r.amount) as amount from warehouse_other_receive_detail r, dealer_info d where r.receive_type='Return' and r.vendor_id=d.dealer_code and r.or_date between '".$from_date."' and '".$to_date."' and d.area_code=".$area->AREA_CODE;

$sales_return_data=mysqli_fetch_object(db_query($sales_return_sql));

$area_sales_return_tot=$sales_return_data->amount;
$zone_sales_return+=$area_sales_return_tot;
$sub_region_sales_return+=$area_sales_return_tot;
$region_sales_return+=$area_sales_return_tot;
$team_sales_return+=$area_sales_return_tot;


$sales_remitence_sql="select sum(j.cr_amt) as remitence from journal j, dealer_info d where j.ledger_id=d.account_code and j.jv_date between '".strtotime($from_date)."' and '".strtotime($to_date)."' and d.area_code=".$area->AREA_CODE;
//and j.jv_date between '".$from_date."' and '".$to_date."'

$sales_remitence_data=mysqli_fetch_object(db_query($sales_remitence_sql));

$area_sales_remitence=$sales_remitence_data->remitence;
$zone_sales_remitence+=$area_sales_remitence;
$sub_region_sales_remitence+=$area_sales_remitence;
$region_sales_remitence+=$area_sales_remitence;
$team_sales_remitence+=$area_sales_remitence;

?><tr align="center" valign="middle">
        <td><?=$pi?></td>
        <td><?=$area_incharge->PBI_NAME?></td>
        <td><?=$designation?></td>
        <td><strong>AREA:</strong><?=$area->AREA_NAME?></td>
        <td><?=$dealer_name?></td>
        <td><?=$info2->order_no?></td>
        <td><?=$area_order_amt?></td>
        <td><?=$area_ims_amt?></td>
        <td><?=number_format($net_sales,2)?></td>
        <td><?=$area_sales_remitence?></td>
        <td><?=$info2->qty?></td>
        <td><?=$area_sales_return_tot?></td>
        <td><?=$area_memo_tot?></td>
        <td><?=$info2->last_shipment_date?></td>
        <td><?=$info2->expiry_date?></td>
      </tr>
	  <?php }?>
      <tr align="center" valign="middle" bgcolor="#99CCFF">
        <td><?=$pi?></td>
        <td><?=$zone_incharge->PBI_NAME?></td>
        <td><?=$zone_designation?></td>
        <td><strong>ZONE:</strong><?=$zone->ZONE_NAME?></td>
        <td>&nbsp;</td>
        <td><?=$info2->order_no?></td>
        <td><?=$zone_order?></td>
        <td><?=$zone_ims?></td>
        <td><?=number_format($zone_net_sales,2)?></td>
        <td><?=$zone_sales_remitence?></td>
        <td><?=$info2->qty?></td>
        <td><?=$zone_sales_return?></td>
        <td><?=$zone_memo?></td>
        <td><?=$info2->last_shipment_date?></td>
        <td><?=$info2->expiry_date?></td>
      </tr>
	    <tr align="center" valign="middle">
        <td colspan="15">&nbsp;</td>
      </tr>
<?php 
//////////////////////////////////////////////////////////////////////
}?>
      <tr align="center" valign="middle" bgcolor="#99FF33">
        <td><?=$pi?></td>
        <td>SUB REGION: <?=$sub_region_incharge->PBI_NAME?></td>
        <td><?=$sub_region_designation?></td>
        <td><strong>SUB REGION:</strong>          <?=$sub_region->SUB_REGION_NAME?></td>
        <td>&nbsp;</td>
        <td><?=$info2->order_no?></td>
        <td><?=$sub_region_order?></td>
        <td><?=$sub_region_ims?></td>
        <td><?=number_format($sub_region_net_sales,2)?></td>
        <td><?=$sub_region_sales_remitence?></td>
        <td><?=$info2->qty?></td>
        <td><?=$sub_region_sales_return?></td>
        <td><?=$sub_region_memo?></td>
        <td><?=$info2->last_shipment_date?></td>
        <td><?=$info2->expiry_date?></td>
      </tr>
      	        <tr align="center" valign="middle">
        <td colspan="15">&nbsp;</td>
      </tr>
      <? 
	  
	  
///////////////////////////////////////////////////////////////////////////
}?>
      <tr align="center" valign="middle" bgcolor="#0099FF">
        <td><?=$pi?></td>
        <td>REGION: <?=$region_incharge->PBI_NAME?></td>
        <td><?=$region_designation?></td>
        <td><strong>REGION:</strong>          <?=$region->BRANCH_NAME?></td>
        <td>&nbsp;</td>
        <td><?=$info2->order_no?></td>
        <td><?=$region_order?></td>
        <td><?=$region_ims?></td>
        <td><?=number_format($region_net_sales,2)?></td>
        <td><?=$region_sales_remitence?></td>
        <td><?=$info2->qty?></td>
        <td><?=$region_sales_return?></td>
        <td><?=$region_memo?></td>
        <td><?=$info2->last_shipment_date?></td>
        <td><?=$info2->expiry_date?></td>
      </tr>
      	        <tr align="center" valign="middle">
        <td colspan="15">&nbsp;</td>
      </tr>
      <? }?>      <tr align="center" valign="middle" bgcolor="#FFCCFF">
        <td><?=$pi?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><?=$info2->order_no?></td>
        <td><?=$team_order?></td>
        <td><?=$team_ims?></td>
        <td><?=number_format($team_net_sales,2)?></td>
        <td><?=$team_sales_remitence?></td>
        <td><?=$info2->qty?></td>
        <td><?=$team_sales_return?></td>
        <td><?=$team_memo?></td>
        <td><?=$info2->last_shipment_date?></td>
        <td><?=$info2->expiry_date?></td>
      </tr>
      	        <tr align="center" valign="middle">
        <td colspan="15">&nbsp;</td>
      </tr>
    </table>
    <? }?>
</body>
</html>
