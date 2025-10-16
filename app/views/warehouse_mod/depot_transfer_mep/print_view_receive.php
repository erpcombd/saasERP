<?php




require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$unique_master  ='pi_no';
$req_no 		= $_REQUEST['req_no'];

$group_for = $_SESSION['user']['group'];

if(prevent_multi_submit()){
if(isset($_POST['rec'])){
    
        $receive_date = $_POST['receive_date'];         
		$pi_no=$req_no;
		$_POST['status']='RECEIVED';
		$_POST['received_by']=$_SESSION['user']['id'];
		$_POST['received_at']=date('Y-m-d H:i:s');
		
db_query('update fg_issue_master 
set status = "'.$_POST['status'].'", rec_sl_no = "'.$_POST['rec_sl_no'].'", receive_date = "'.$_POST['receive_date'].'", received_by = "'.$_POST['received_by'].'" , party_code="'.$_POST['party_code'].'"
where pi_no="'.$req_no.'"');
		

$table_detail='fg_issue_detail';

$master = $pi = find_all_field('fg_issue_master','','pi_no='.$req_no);
$warehouse_to = $master->warehouse_to;
$warehouse_from = $master->warehouse_from;



// bin card
$sql="select p.*,i.d_price,i.group_for from fg_issue_detail p, item_info i where i.item_id=p.item_id and pi_no='$req_no'";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){


// new locker. 5 min por same item dhukbe, er age na.
    $time2=date('Y-m-d H:i:s');
    $time1_timestamp = strtotime($data->rec_time);
    $time2_timestamp = strtotime($time2);
    if (($time2_timestamp - $time1_timestamp) > 300){
        
        if($_POST['total_unit_'.$data->id]>0){
    		$qty        = $_POST['total_unit_'.$data->id];
    
    		$rate  = $data->unit_price;
    		$amount     = $qty*$rate; 
    
    		journal_item_control($data->item_id, $warehouse_to, $receive_date, $qty,0,'Transfered', $data->id,$rate,$warehouse_from,$req_no,'','',$data->group_for,'','');

        journal_item_control($data->item_id, $master->transit_warehouse, $receive_date,0,$qty,'Transfered', $data->id,$rate,$warehouse_from,$req_no,'','',$data->group_for,'','');
        
            db_query('update journal_item set tr_from="Transfered" where tr_no="'.$data->id.'" and tr_from="Transit"');
            $total_amount = $total_amount + $amount;
               
        }
    
            // update issue table
            $rec_note   = $_POST['rec_note_'.$data->id];
            
            if($data->total_unit==$qty) { $rec_status='Done';}else{ $rec_status='Pending';}
            
            db_query('update fg_issue_detail set rec_qty="'.$qty.'", rec_time="'.date('Y-m-d H:i:s').'" ,rec_note="'.$rec_note.'", rec_status="'.$rec_status.'"
            where id="'.$data->id.'" and item_id="'.$data->item_id.'"');
    
    } // end time check




} // end while



//}


// accounts hit

//$cc_code = find_a_field('warehouse','acc_code','warehouse_id='.$master->warehouse_to);

//$narration = 'PI No-'.$pi_no.'||Invoice -'.$pi->invoice_no.'|| RecDt:'.$pi->receive_date;
//$warehouse = find_all_field('warehouse','store_rcv_ledger_id','warehouse_id='.$_SESSION['user']['depot']);	

	//$dealer_ledger = $warehouse->store_rcv_ledger_id;
	//$sales_ledger  = '1102000100000000';
	
	//$tr_from = 'StoreReceived';

	//$sold_price = find_a_field_sql("select  sum(i.p_price*c.total_unit) as price from fg_issue_detail c,item_info i where c.item_id=i.item_id and c.pi_no=".$req_no);
	
//$jv_no=next_journal_sec_voucher_id();
//$jv_date = strtotime($_POST['receive_date']);


	//if($sold_price!=0){
	//add_to_sec_journal($proj_id, $jv_no, $jv_date, $dealer_ledger, $narration, $sold_price,    '0',          $tr_from,  $pi_no,'','',$cc_code,'2','');
	//add_to_sec_journal($proj_id, $jv_no, $jv_date, $sales_ledger, $narration, '0',             $sold_price,   $tr_from,  $pi_no,'','',$cc_code,'2','');
	
	//}


//auto_insert_store_transfer_receive($pi->receive_date,$ledger,$sales_ledger,$pi_no,find_a_field('fg_issue_detail','sum(total_amt)','pi_no='.$$unique_master),$pi_no,$cc_code,$narration);

		

	
} // end submit
} // end prevent


do_calander('#receive_date');

$sql_p="select * from fg_issue_master where  pi_no='$req_no'";
$all=find_all_field('fg_issue_master','','pi_no="'.$req_no.'"');
//($sql_p);



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


<form action="" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">


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
                    <td bgcolor="#00CC33" style="text-align:center; color:#FFF; font-size:14px; font-weight:bold;">
<? if($all->group_for>0){ ?>
<span class="style4"><?php /*?><?=show_company($all->group_for)?><?php */?>
<!--<br/><span class="style6"><?php /*?><?=find1("select address from user_group where id='".$all->group_for."'");?><?php */?></span>-->
</span>
<?}else{ ?>
<span class="style4">MEP Group<br/>    
<?}?>

</td>
 
                  </tr>
                  
                </table></td>
              </tr>
              <tr>
                <td>
				<div class="header_title" align="center"><strong>Transfer</strong></div></td>
              </tr>
              <tr>
                <td height="19">&nbsp;</td>
              </tr>
            </table></td>
          </tr>

        </table></td>
	    </tr>
	  <tr>
	    <td>


<style>
       .value_top td {
      vertical-align: top;
    }
</style>
	        
	        
<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr class="value_top">
            <td width="10%" valign="bottom">&nbsp;</td>
		    <td width="35%" valign="bottom"><span class="style11"><?=find_a_field('warehouse','warehouse_name','warehouse_id='.$all->warehouse_from);?></span>
            <br><?=find_a_field('warehouse','address','warehouse_id='.$all->warehouse_from);?>
            </td>
		    
		    <td width="10%" valign="bottom"><span style="font-size:16px; vertical-align: top;">TO</span></td>
		    
		    <td width="35%"><span class="style11"><?=find_a_field('warehouse','warehouse_name','warehouse_id='.$all->warehouse_to);?></span>
            <!--<br><?=find_a_field('warehouse','address','warehouse_id='.$all->warehouse_to);?>-->
            </td>
            <td width="10%" valign="bottom">&nbsp;</td>
		</tr>
</table>

		
<table width="100%" border="0" cellspacing="0" cellpadding="0">		
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
						<? for($i=0;$i<1;$i++){?>
						<option><?=date('Y-m-d',time()-(24*60*60*$i));?></option>
						<? }?>
                        </select>
                      </label></td>
                      <td width="25%" bgcolor="#FFFFCC"><div align="right"><strong>Rec SL No : </strong></div></td>
                      <td width="25%" bgcolor="#FFFFCC"><label>
                        <input type="text" name="rec_sl_no" style="width:80px;" required/>
                      </label></td>
                      
                      <td width="50%" bgcolor="#FFFFCC"><div align="center">
                            Party Code: <input type="text" name="party_code" style="width:80px;" />
                      </div></td>
                      
                    </tr>
                  </table>
</form>
                </td>
              </tr>
            </table><? }?>
<? if($all->status=='RECEIVED'){?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCFFCC">
<tr>
<td><div align="center"><strong><span class="tabledesign style17" style=" text-transform: uppercase;">(<?='Received Date: '.$all->receive_date.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Receive SL No: '.$all->rec_sl_no?>)&nbsp;</span></strong></div></td>
</tr>
</table>
<!-- <a href="../replace/replace_issue_view.php?v_no=<?=$all->pi_no;?>">Replace Issue View</a> -->
<? }?>
			</td>
		    </tr>
		</table></td>
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
</table>  

<table style="text-align:center" width="100%" border="0" cellspacing="0" cellpadding="0"> 
<tr class="value_top">
<td width="10%" valign="bottom">&nbsp;</td>
    <td width="35%">
        <div style="height:40px;">
            <p><strong>Issue NO</strong>: <span class="style14"><?=$all->pi_no;?> </span><br/>
            <strong>Issue Date</strong>:<?=$all->pi_date;?>
          </div>
          <div>Issue Note: <?php echo $all->remarks;?></div>
    </td>
    
    <td width="35%">
        <strong>Requisition No</strong>:<?=$all->req_no;?><br>
        <strong>Requisition Date</strong>: <?=find_a_field('requisition_fg_master','req_date','req_no="'.$all->req_no.'"');?><br>
        <? if($all->returnable=='YES'){ ?><span style="font-size:18px; color:red;"><strong>Returnable</strong>:<?=$all->returnable;?> </span><? }?>
    </td>



</tr>
</table>


<table>
<tr>
<td><div id="pr">
<div align="left">
<!--<form action="" method="get">-->

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <!--<tr>-->
  <!--  <td width="1"><input name="button" type="button" onclick="hide();window.print();" value="Print" /></td>-->
  <!--</tr>-->
</table>
<!--</form>-->
</div>
</div>
</td>

</tr>

</table>







    
    

<div class="tabledesign2">

<? if($all->status=='SEND'){ ?> 
<table width="80%" border="1" align="center" cellpadding="0" cellspacing="0" id="grp" style="font-size:12px">

      <tbody>

          <tr>
            <th width="1%">SL</th>
            <th width="2%">FG Code</th>
            <th width="15%">Item Name </th>
            <th bgcolor="#FFFFFF">Unit</th>
            <th bgcolor="#FF99FF">Issue Qty</th>
            <th bgcolor="#F57E22">Receive Qty</th>
            <th bgcolor="#F57E22">Note</th>
        </tr>
          
<? 
$sql3='select a.id,a.item_id,b.finish_goods_code as fg_code,b.item_name,b.unit_name, a.total_unit as qty,a.note
from fg_issue_detail a, item_info b 
where b.item_id=a.item_id and a.pi_no='.$req_no.' order by a.id';

$res3=db_query($sql3);
while($row=mysqli_fetch_object($res3)){

?>

<tr>
    <td><?=++$ss;?></td>
    <td><?=$row->fg_code;?></td>
    <td><?=$row->item_name;?><br><?=$row->note;?>
    			<input type="hidden" name="oid_<?=$row->id?>" id="oid_<?=$row->id?>" value="<?=$row->id?>" />
    			<input type="hidden" name="item_id_<?=$row->id?>" id="item_id_<?=$row->id?>" value="<?=$row->item_id?>" />	
    			<input type="hidden" name="stock_<?=$row->id?>" id="stock_<?=$row->id?>" value="<?=$row->qty?>" />	
    </td>
    <td width="2%" align="center"><?=$row->unit_name?></td>
    <td width="2%" align="center"><?=$row->qty;?></td>
    
    <td width="10%" align="center" bgcolor="#F57E22">
        <input name="total_unit_<?=$row->id?>" type="text" id="total_unit_<?=$row->id?>" onchange="stock_check(<?=$row->id?>)" value="<?=$row->qty;?>" required readonly />
    </td>
    <td width="20%" align="center" bgcolor="#F57E22">
        <input name="rec_note_<?=$row->id?>" type="text" id="rec_note_<?=$row->id?>" value="" />
    </td>    
</tr>

<? } ?>
</tbody>
</table>


<? }else{?>

<table width="80%" border="1" align="center" cellpadding="0" cellspacing="0" id="grp" style="font-size:12px">
<tbody>

          <tr>
            <th bgcolor="#F57E22" width="1%">SL</th>
            <th bgcolor="#F57E22" width="2%">FG Code</th>
            <th bgcolor="#F57E22" width="15%">Item Name </th>
            <th bgcolor="#F57E22">Unit</th>
            <th bgcolor="#F57E22">Issue Qty</th>
            <th bgcolor="#F57E22">Receive Qty</th>
            <th bgcolor="#F57E22">Diff</th>
            <th bgcolor="#F57E22">Note</th>
        </tr>
          
<? 
// slow query
// $sql='select a.id,a.item_id,b.finish_goods_code as fg_code,b.item_name,b.unit_name, a.item_in as qty, p.rec_note, p.total_unit as issue_qty
// from journal_item a, item_info b , fg_issue_detail p
// where p.pi_no=a.sr_no 
// and p.item_id=a.item_id 
// and p.item_id=b.item_id 
// and b.item_id=a.item_id 
// and a.sr_no='.$req_no.' and a.tr_from in("Transfered","Transit") and a.item_in>0 group by a.id order by a.id';

$sql='select p.id,p.item_id,b.finish_goods_code as fg_code,b.item_name,b.unit_name, p.total_unit as issue_qty, p.rec_qty as qty, p.rec_note 
from item_info b , fg_issue_detail p
where p.item_id=b.item_id
and p.pi_no='.$req_no.'
group by p.id 
order by p.id';



$res=db_query($sql);
while($row=mysqli_fetch_object($res)){

?>
<tr>
    <td><?=++$ss;?></td>
    <td><?=$row->fg_code;?></td>
    <td><?=$row->item_name; ?></td>
    <td width="2%" align="center"><?=$row->unit_name?></td>
    <td width="2%" align="center"><?=$row->issue_qty; $gissue+=$row->issue_qty;?></td>
    <td width="2%" align="center"><?=$row->qty; $gre+=$row->qty;?></td>
    <td width="2%" align="center"><?=($row->issue_qty-$row->qty); ?></td>
    <td width="5%" align="center"><?=$row->rec_note;?></td>
</tr>

<? } ?>
<tr style="font-weight:700">
    <td colspan="4">Total</td>
    <td><?=$gissue?></td>
    <td><?=$gre?></td>
</tr>
</tbody>
</table>

<p><br>
<table>
    <tr></tr>
    <tr>
        <td width="30%"></td>
        <td>Issue By: <?=show_username($all->entry_by)?><br>Received By: <?=show_username($all->received_by)?></td>
    </tr>
</table>


<? } ?>

</div>




<br/><br/><br/>





 
<? if($all->status=='SEND'){ ?>  
    <table width="100%" border="0">
      <tr>
        <td align="center"><input  name="pi_no" type="hidden" id="pi_no" value="<?=$req_no?>"/></td>

        <td align="center" style="text-align:center">
                <input class="form-control" name="rec" type="submit" id="rec" value="Received" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:black; float:center"/>
        </td>
      </tr>
    </table>
<? }?>
  </form>


<script>
    function stock_check(id){
        var stk = document.getElementById("stock_"+id).value*1;
        var qty = document.getElementById("total_unit_"+id).value*1;

        if(stk<qty){
            alert("Please check item Stock");
             document.getElementById("total_unit_"+id).value="";
        }
    }
</script>



</body>
</html>
<?
$page_name="PO Print View";
require_once SERVER_CORE."routing/layout.report.bottom.php";
?>