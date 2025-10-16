<?php
session_start();
//====================== EOF ===================
//var_dump($_SESSION);

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$unique_master='pi_no';
$req_no 		= $_REQUEST['req_no'];
if(prevent_multi_submit()){
if(isset($_POST['rec']))
{
		$pi_no=$req_no;
		$_POST['status']='RECEIVED';
		$_POST['received_by']=$_SESSION['user']['id'];
		$_POST['received_at']=date('Y-m-d H:i:s');
		
db_query('update do_issue_master set status = "'.$_POST['status'].'", rec_sl_no = "'.$_POST['rec_sl_no'].'", receive_date = "'.$_POST['receive_date'].'", received_by = "'.$_POST['received_by'].'" where pi_no="'.$req_no.'"');

// all do no
	$sql1="select p.do_no from do_issue_detail p where pi_no='$req_no'";
	$data1=db_query($sql1);
	
	while($all1=mysqli_fetch_object($data1)){
		$do[] = $all1->do_no;
	}	
// end

$table_detail='do_issue_detail';
$sql="select p.*,i.d_price from do_issue_detail p, item_info i where i.item_id=p.item_id and pi_no='$req_no'";
$data=db_query($sql);


$master = $pi = find_all_field('do_issue_master','','pi_no='.$req_no);
$warehouse_to = $master->warehouse_to;
$warehouse_from = $master->warehouse_from;

$cc_code = find_a_field('warehouse','acc_code','warehouse_id='.$master->warehouse_to);

$narration = 'PI No-'.$pi_no.'||DO No -'.implode(",",$do).'|| RecDt:'.$pi->receive_date;

while($all=mysqli_fetch_object($data)){
$amount = $all->total_unit*$all->unit_price;
journal_item_control($all->item_id ,$warehouse_to,$_POST['receive_date'],$all->total_unit,'0','DO Transfered',$all->id,$all->unit_price,$warehouse_from,$pi_no);
//db_query('update journal_item set tr_from="Transfered" where tr_no="'.$all->id.'" and tr_from="Transit"');
$total_amount = $total_amount + $amount;
}



$warehouse = find_all_field('warehouse','store_rcv_ledger_id','warehouse_id='.$_SESSION['user']['depot']);	

	$dealer_ledger = $warehouse->store_rcv_ledger_id;
	$sales_ledger  = '1102000100000000';
	
	$tr_from = 'DO StoreReceived';

	$sold_price = find_a_field_sql("select  sum(i.p_price*c.total_unit) as price from do_issue_detail c,item_info i where c.item_id=i.item_id and c.pi_no=".$req_no);
	
$jv_no=next_journal_sec_voucher_id();
$jv_date = strtotime($_POST['receive_date']);


	if($sold_price!=0){
	add_to_sec_journal($proj_id, $jv_no, $jv_date, $dealer_ledger, $narration, $sold_price,    '0',          $tr_from,  $pi_no,'','',$cc_code,'2','');
	add_to_sec_journal($proj_id, $jv_no, $jv_date, $sales_ledger, $narration, '0',             $sold_price,   $tr_from,  $pi_no,'','',$cc_code,'2','');
	
	}


//auto_insert_store_transfer_receive($pi->receive_date,$ledger,$sales_ledger,$pi_no,find_a_field('do_issue_detail','sum(total_amt)','pi_no='.$$unique_master),$pi_no,$cc_code,$narration);

		

	
}
}
do_calander('#receive_date');

$sql="select * from do_issue_master where  pi_no='$req_no'";
$data=db_query($sql);
$all=mysqli_fetch_object($data);



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: FG Challan Copy :.</title>
<link href="../../css/invoice.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript">
function hide()
{
    document.getElementById("pr").style.display="none";
}
</script>
<style type="text/css">
<!--
.style11 {
	font-size: 16px;
	font-weight: bold;
}
.style14 {font-weight: bold}
.style12 {
	font-size: 12px;
	font-weight: normal;
}
.style4 {	font-size: 18px;
	color: #000000;
}
.style6 {font-size: 10px}
.style15 {
	color: #FF0000;
	font-weight: bold;
}
.style17 {color: #006600}
.style18 {font-size: 12px}
.style19 {font-size: 12px; font-weight: bold; }
-->
</style>
</head>
<body>
<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><div class="header">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><table  width="80%" border="0" align="center" cellpadding="3" cellspacing="0">
                  <tr>
                    <td bgcolor="#00CC33" style="text-align:center; color:#FFF; font-size:14px; font-weight:bold;"><span class="style4"><?=$_SESSION['company_name']?><br />
                          <span class="style6"><?=$_SESSION['company_address']?></span></span></td>
                  </tr>
                  
                </table></td>
              </tr>
              <tr>
                <td>
				<div class="header_title" align="center">
				Store To Store Chalan Copy				</div></td>
              </tr>
              <tr>
                <td height="19">&nbsp;</td>
              </tr>
            </table></td>
          </tr>

        </table></td>
	    </tr>
	  <tr>
	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
            <td width="14%" valign="bottom">&nbsp;</td>
		    <td width="20%" valign="bottom"><span class="style11">
		      <?=find_a_field('warehouse','warehouse_name','warehouse_id='.$all->warehouse_from);?>
            </span></td>
		    <td width="9%" valign="bottom"><span style="font-size:16px;">TO</span></td>
		    <td width="45%"><span class="style11">
              <?=find_a_field('warehouse','warehouse_name','warehouse_id='.$all->warehouse_to);?>
            </span></td>
		    </tr>
		  <tr>
		    <td valign="bottom">&nbsp;</td>
		    <td valign="bottom">&nbsp;</td>
		    <td valign="bottom">&nbsp;</td>
		    <td>&nbsp;</td>
		    </tr>
		  <tr>
		    <td colspan="4" valign="bottom">
			<? if($all->status=='SEND'){?><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFCC99">
              <tr>
                <td><div align="center" class="style15">IN TRANSIT </div></td>
              </tr>
			                <tr>
                <td><form id="form1" name="form1" method="post" action="">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="25%" bgcolor="#FFFFCC"><strong>&nbsp;&nbsp;&nbsp;&nbsp;Receive Date : </strong></td>
                      <td width="25%" bgcolor="#FFFFCC"><label>
                        <select name="receive_date" id="receive_date" required />
						<? for($i=0;$i<62;$i++){?>
						<option><?=date('Y-m-d',time()-(24*60*60*$i));?></option>
						<? }?>
                        </select>
                      </label></td>
                      <td width="25%" bgcolor="#FFFFCC"><div align="right"><strong>Rec SL No : </strong></div></td>
                      <td width="25%" bgcolor="#FFFFCC"><label>
                        <input type="text" name="rec_sl_no" style="width:80px;" />
                      </label></td>
                      <td width="50%" bgcolor="#FFFFCC"><div align="center">
                        <input name="rec" type="submit" id="rec" value="Received" />
                      </div></td>
                    </tr>
                  </table>
                                </form>
                </td>
              </tr>
            </table><? }?>
		    <? if($all->status=='RECEIVED'){?><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCFFCC">
                <tr>
                  <td><div align="center"><strong>
	<span class="tabledesign style17" style=" text-transform: uppercase;">(<?='Received Date: '.$all->receive_date.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Receive SL No: '.$all->rec_sl_no?>)&nbsp;</span></strong></div></td>
                </tr>
              </table><? }?>
			</td>
		    </tr>
		</table>		</td>
	  </tr>
    </table>
    </div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    
	<td>	</td>
    <td></td>
  </tr>
  <tr>
    <td><div class="line"></div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div class="header2">
          <div class="header2_left" style="height:30px;">
        <p><strong>Transfer ID</strong>: <span class="style14">
        <?=$all->pi_no;?> 
        </span><br />
        <strong>Send Date</strong>:
        <?=$all->pi_date;?>
        <br />
        </p>
      </div>
      <div class="header2_right">
        <p><strong class="style11">Invoice No</strong>: <strong class="style11"><?php echo $all->invoice_no;?></strong><br />
          Carried By: <?php echo $all->carried_by;?><br />
        </p>
      </div>
    </div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div id="pr">
<div align="left">
<form action="" method="get">

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="1"><input name="button" type="button" onclick="hide();window.print();" value="Print" /></td>
  </tr>
</table>
</form>
</div>
</div>
<table width="721" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="5" style="border-collapse:collapse; padding:">
       <tr>
        <td width="6%"><strong>SL</strong></td>
        <td width="7%"><strong>DO No</strong></td>
        <td width="41%"><strong>Product Name </strong></td>
        <td width="10%"><strong>Unit</strong></td>
        <td width="10%"><strong>Rate</strong></td>
        <td width="13%"><strong>Rec Qty</strong></td>
        <td width="13%"><strong>Total Amt</strong></td>
       </tr>
	  <?php
$final_amt=(int)$data1[0];
$pi=0;
$total=0;
$sql2="select * from do_issue_detail where  pi_no='$req_no'";
$data2=db_query($sql2);
//echo $sql2;
while($info=mysqli_fetch_object($data2)){ 
$pi++;

$total_qty=$info->total_unit;
$grand_total_qty+=$total_qty;
$rate=$info->unit_price;
$total_amount=$info->total_amt;
$grand_total_amount+=$total_amount;

$item=find_all_field('item_info','concat(item_name," : ",	item_description)','item_id='.$info->item_id);
if($item->item_id){
?>
      <tr>
        <td valign="top"><span class="style18">
          <?=$pi?>
        </span></td>
        <td align="center" valign="top"><span class="style18">
          <?=$info->do_no?>
        </span></td>
        <td align="left" valign="top"><span class="style12 style18">
          <?=$item->item_name?>
        </span></td>
        <td align="center" valign="top"><span class="style18">
          <?=$item->unit_name?>
        </span></td>
        <td align="center" valign="top"><span class="style18">
          <?=number_format($rate,2);?>
        </span></td>
        <td valign="top"><div align="right" class="style18">
          <?=number_format($total_qty,2);?>
        </div></td>
        <td valign="top"><div align="right" class="style18">
          <?=number_format($total_amount,2);?>
        </div></td>
      </tr>
      
<? }}?>
<tr>
        <td valign="top"><div align="right"><strong>Total:</strong></div></td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top"></td>
        <td valign="top">&nbsp;</td>
        <td valign="top"><div align="right"><span class="style19">
          <?=number_format($grand_total_qty,2);?>
        </span></div></td>
        <td valign="top"><div align="right"><span class="style19">
          <?=number_format($grand_total_amount,2);?>
        </span></div></td>
</tr>
    </table></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center">
	<div class="footer1"><strong><br />
    </strong>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
	  		<td><?=find_a_field('user_activity_management','fname','user_id='.$all->entry_by)?></td>
			 <td>&nbsp;</td>
			  
			 <td style="text-align:center;"><?=find_a_field('user_activity_management','fname','user_id='.$all->received_by)?></td>
	  
	  </tr>
	  
	  
	  
        <tr>
          <td width="30%"><div align="center">
		  
            <p style="float:left; font-weight:bold; font-size:12px;">Prepared By: <br />
              
            </p>
          </div></td>
          <td width="40%"><div align="center">
              <p>Received By<br />
                <strong>
                
                </strong></p>
			  
          </div></td>
          <td width="30%"><div align="center">Approved By </div></td>
        </tr>
      </table>
      </div>
	<div class="footer1"></div></td>
    <td align="center">&nbsp;</td>
  </tr>
</table>
</body>
</html>
