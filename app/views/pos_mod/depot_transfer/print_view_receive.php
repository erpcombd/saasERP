<?php
session_start();
//====================== EOF ===================
//var_dump($_SESSION);
require_once "../../../assets/template/layout.top.php";


$unique_master='pi_no';
$req_no 		= $_REQUEST['req_no'];
if(prevent_multi_submit()){
if(isset($_POST['rec']))
{
		$pi_no=$req_no;
		$_POST['status']='RECEIVED';
		$_POST['received_by']=$_SESSION['user']['id'];
		$_POST['received_at']=date('Y-m-d H:i:s');
		
mysql_query('update production_issue_master set status = "'.$_POST['status'].'", rec_sl_no = "'.$_POST['rec_sl_no'].'", receive_date = "'.$_POST['receive_date'].'", received_by = "'.$_POST['received_by'].'" where pi_no="'.$req_no.'"');
		

$table_detail='production_issue_detail';
$sql="select p.*,i.d_price from production_issue_detail p, item_info i where i.item_id=p.item_id and pi_no='$req_no'";
$data=mysql_query($sql);


$master = $pi = find_all_field('production_issue_master','','pi_no='.$req_no);
$warehouse_to = $master->warehouse_to;
$warehouse_from = $master->warehouse_from;

$cc_code = find_a_field('warehouse','acc_code','warehouse_id='.$master->warehouse_to);

$narration = 'PI No-'.$pi_no.'||Invoice -'.$pi->invoice_no.'|| RecDt:'.$pi->receive_date;

while($all=mysql_fetch_object($data)){
$amount = $all->total_unit*$all->d_price;
journal_item_control($all->item_id ,$warehouse_to,$_POST['receive_date'],$all->total_unit,'0','Transfered',$all->id,$all->d_price,$warehouse_from,$pi_no);
mysql_query('update journal_item set tr_from="Transfered" where tr_no="'.$all->id.'" and tr_from="Transit"');
$total_amount = $total_amount + $amount;
}



$warehouse = find_all_field('warehouse','store_rcv_ledger_id','warehouse_id='.$_SESSION['user']['depot']);	

	$dealer_ledger = $warehouse->store_rcv_ledger_id;
	$sales_ledger  = '1102000100000000';
	
	$tr_from = 'StoreReceived';

	$sold_price = find_a_field_sql("select  sum(i.p_price*c.total_unit) as price from production_issue_detail c,item_info i where c.item_id=i.item_id and c.pi_no=".$req_no);
	
$jv_no=next_journal_sec_voucher_id();
$jv_date = strtotime($_POST['receive_date']);


	if($sold_price!=0){
	add_to_sec_journal($proj_id, $jv_no, $jv_date, $dealer_ledger, $narration, $sold_price,    '0',          $tr_from,  $pi_no,'','',$cc_code,'2','');
	add_to_sec_journal($proj_id, $jv_no, $jv_date, $sales_ledger, $narration, '0',             $sold_price,   $tr_from,  $pi_no,'','',$cc_code,'2','');
	
	}


//auto_insert_store_transfer_receive($pi->receive_date,$ledger,$sales_ledger,$pi_no,find_a_field('production_issue_detail','sum(total_amt)','pi_no='.$$unique_master),$pi_no,$cc_code,$narration);

		

	
}
}
do_calander('#receive_date');

$sql="select * from production_issue_master where  pi_no='$req_no'";
$data=mysql_query($sql);
$all=mysql_fetch_object($data);



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

#pr input[type="button"] {
    width: 70px;
    height: 25px;
    background-color: #6cff36;
    color: #333;
    font-weight: bolder;
    border-radius: 5px;
    border: 1px solid #333;
    cursor: pointer;
}
</style>
</head>
<body>
<div id="pr">
    <h2 align="center">	<input name="button" type="button" onclick="hide();window.print();" value="Print"/></h2>
</div>
<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td colspan="2"><div class="header">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><table  width="80%" border="0" align="center" cellpadding="3" cellspacing="0">
                  <tr align="center">
                    <td>
                        <h1 style="margin: 0;"><?=$_SESSION['company_name']?></h1>
                        <p style="margin: 0;">H: #985, Ave:#2, R: #16, Mirpur 12 DOHS, Dhaka</p>
                    </td>
                  </tr>
                  
                </table></td>
              </tr>
              <tr>
                <td>
				<div class="header_title" align="center">
                    <strong>(Store To Store Chalan Copy) </strong>
                </div>
                </td>
              </tr>
            </table>
            </td>
          </tr>

        </table></td>
	    </tr>

        <tr align="center">
            <td>
                <span class="style11">
		      <?=find_a_field('warehouse','warehouse_name','warehouse_id='.$all->warehouse_from);?>
            </span>
                <span style="font-size:16px;">TO</span>

            <span class="style11">
              <?=find_a_field('warehouse','warehouse_name','warehouse_id='.$all->warehouse_to);?>
            </span>

            </td>

        </tr>

        <tr align="center">
            <td>
                <br>
            </td>
        </tr>

	  <tr align="center">
	    <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">

		  <tr >
		    <td colspan="4" valign="bottom">
			<? if($all->status=='SEND'){?><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#ffd887">
              <tr>
                <td><div align="center"><strong>IN TRANSIT</strong> </div></td>
              </tr>
			                <tr>
                <td><form id="form1" name="form1" method="post" action="">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="18%" bgcolor="#FFFFCC"><strong>&nbsp;&nbsp;&nbsp;&nbsp;Receive Date : </strong></td>
                      <td width="32%" bgcolor="#FFFFCC"><label>
                        <select style="width: 70%;" name="receive_date" id="receive_date" required />
						<? for($i=0;$i<62;$i++){?>
						<option><?=date('Y-m-d',time()-(24*60*60*$i));?></option>
						<? }?>
                        </select>
                      </label></td>
                      <td width="18%" bgcolor="#FFFFCC"><div align="right"><strong>Rec SL No : </strong></div></td>
                      <td width="32%" bgcolor="#FFFFCC">
                          <label>
                              <input type="text" name="rec_sl_no" white="100%" />
                          </label>
                      </td>
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
		</table>
        </td>
	  </tr>
    </table>
    </div></td>
  </tr>

  <tr>
	<td></td>
    <td></td>
  </tr>

  <tr>
    <td><div class="line"></div></td>
    <td>&nbsp;</td>
  </tr>

  <tr>
    <td>
        <div class="header2">
          <div class="header2_left" style="height:30px;">
        <p style="margin: 0px;"><strong>Transfer ID :</strong> <span class="style14">
        <?=$all->pi_no;?> 
        </span><br />
        <strong>Send Date :</strong>
        <?=$all->pi_date;?>
        <br />
        </p>
      </div>

    </div>
    </td>

    <td align="right">
        <p style="margin: 0px;"><strong class="style11">Invoice No :</strong> <strong class="style11"><?php echo $all->invoice_no;?></strong><br />
                <strong>Carried By :</strong> <?php echo $all->carried_by;?><br />
        </p>


    </td>
  </tr>
    <tr>
        <td colspan="2"><br></td>
    </tr>
  <tr>


<td colspan="2">
<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="5" style="border-collapse:collapse; padding:">
       <tr bgcolor="powderblue">
        <td width="6%"><strong>SL</strong></td>
        <td width="7%"><strong>FG</strong></td>
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
$sql2="select * from production_issue_detail where  pi_no='$req_no'";
$data2=mysql_query($sql2);
//echo $sql2;
while($info=mysql_fetch_object($data2)){ 
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
          <?=$item->finish_goods_code?>
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
<tr bgcolor="#ffffa1">
        <td colspan="5" valign="top"><div align="right"><strong>Total:</strong></div></td>

        <td valign="top"><div align="right"><span class="style19">
          <?=number_format($grand_total_qty,2);?>
        </span></div></td>
        <td valign="top"><div align="right"><span class="style19">
          <?=number_format($grand_total_amount,2);?>
        </span></div></td>
</tr>
    </table>
    </td>
  </tr>

  <tr>
    <td colspan="2" align="center">
	<div class="footer1"><strong><br />
    </strong>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
              <td width="30%"><div align="center">&nbsp; </div></td>
              <td width="40%"><div align="center">&nbsp; </div></td>
              <td width="30%"><div align="center"> &nbsp;</div></td>
          </tr>

          <tr>
              <td width="30%"><div align="center">&nbsp;</div></td>
              <td width="40%"><div align="center"> &nbsp;</div></td>
              <td width="30%"><div align="center"> &nbsp;</div></td>
          </tr>



          <tr>
          <td align="center"><?=find_a_field('user_activity_management','fname','user_id='.$all->entry_by)?></td>
          <td align="center">&nbsp;</td>
          <td align="center"><?=find_a_field('user_activity_management','fname','user_id='.$all->received_by)?></td>
	  
	  </tr>
          <tr>
              <td width="30%"><div align="center">_ _ _ _ _ _ _ _ _ _ </div></td>
              <td width="40%"><div align="center">_ _ _ _ _ _ _ _ _ _ </div></td>
              <td width="30%"><div align="center">_ _ _ _ _ _ _ _ _ _ </div></td>
          </tr>
	  
	  
	  
        <tr>
          <td width="30%"><div align="center">
		  
            <p>Prepared By </p>
          </div></td>
          <td width="40%"><div align="center">
              <p>Received By </p>
			  
          </div></td>
          <td width="30%"><div align="center">Store Incharge </div></td>
        </tr>
      </table>
      </div>
	<div class="footer1"></div></td>
  </tr>
</table>
</body>
</html>
