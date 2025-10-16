<?php

/*ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);*/


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$head='<link href="../../css/report_selection.css" type="text/css" rel="stylesheet"/>';

$title='Fixed Asset Addition';

do_calander('#fdate');
do_calander('#tdate');
create_combobox('do_no');
create_combobox('dealer_code');
do_calander('#fddate');
do_calander('#tddate');

$invoice_no=$_REQUEST['request_no'];

$data_found = $invoice_no;

if ($data_found==0) {
do_calander('#invoice_date');
do_calander('#need_by');
//create_combobox('fg_item_id');
  }


if(prevent_multi_submit()){


if(isset($_POST['master_data'])){
	
	$status = 'MANUAL';
	$entry_by = $_SESSION['user']['id'];
	$entry_at=date('Y-m-d H:i:s');
	$warehouse_id=$_POST['warehouse_id'];
	$group_for=$_POST['group_for'];
	$need_by = $_POST['need_by'];
	$inv_type = $_POST['inv_type'];
	$remarks = $_POST['remarks'];
	
	$invoice_date = $_POST['invoice_date'];
		
	//$pr_date = $_POST['so_date'];
	//$fg_item_id = $_POST['fg_item_id'];
	//$item_watt = find_a_field('item_info','item_watt','item_id="'.$_POST['fg_item_id'].'"');
	//$group_for=$_SESSION['user']['group'];
	//$warehouse_id=$_SESSION['user']['depot'];
	
	
		$YR = date('Y',strtotime($invoice_date));
 		$year = date('y',strtotime($invoice_date));
  		$month = date('m',strtotime($invoice_date));
		$day = date('d',strtotime($invoice_date));
 		$inv_cy_id = find_a_field('warehouse_opening_master','max(inv_id)','year="'.$YR.'"')+1;
  		$cy_id = sprintf("%06d", $inv_cy_id);
   		$invoice_no=''.$year.''.$month.''.$cy_id;
		$day_invoice_no=$YR.''.$month.''.$day.'0'.$warehouse_id;
	
	
	

	//$tr_no = date('ymd',strtotime($tr_date));
//	
//	$lot_cy_id = find_a_field('import_purchase_details','max(lot_id)','tr_no="'.$tr_no.'"')+1;
//		
//   	$cy_id = sprintf("%04d", $lot_cy_id);
//	
//   	 $lot_no_generate='LOT'.$tr_no.''.$cy_id;
	 
	 
	 if($invoice_no>0) {
	  $ins_sql = 'INSERT INTO warehouse_opening_master (invoice_no, year, inv_id, day_invoice_no, inv_type, group_for, warehouse_id, invoice_date, need_by, status, entry_at, entry_by, remarks) VALUES

("'.$invoice_no.'", "'.$YR.'", "'.$cy_id.'", "'.$day_invoice_no.'", "'.$inv_type.'", "'.$group_for.'", "'.$warehouse_id.'", "'.$invoice_date.'", "'.$need_by.'", "'.$status.'", "'.$entry_at.'", "'.$entry_by.'", "'.$remarks.'")';
	
	db_query($ins_sql);
	}

	

	 
	 ?>

<script language="javascript">
window.location.href = "invoice_entry.php?request_no=<?=$invoice_no?>";
</script>

<? 
		
}
}

?>








<style>
/*
.ui-state-default a, .ui-state-default a:link, .ui-state-default a:visited, a.ui-button, a:link.ui-button, a:visited.ui-button, .ui-button {
    color: #454545;
    text-decoration: none;
    display: none;
}*/


div.form-container_large input {
    width: 150px;
    height: 38px;
    border-radius: 0px !important;
}



</style>

<div class="form-container_large">


<form action="" method="post" name="codz" id="codz">

<? if ($data_found==0) { ?>

<div class="box" style="width:100%;">

								<table width="100%" border="0" cellspacing="0" cellpadding="0">

								  <tr>



    <?php /*?><td width="15%" align="right" >Ledger Name:</td>

    <td width="30%" >
	<? create_combobox('src_ledger_id'); ?>
	  <select name="src_ledger_id" id="src_ledger_id"  style="width:90%; height:32px;" >

        <option value=""></option>

		<? foreign_relation('accounts_ledger a, item_group g','a.ledger_id','a.ledger_name',$_POST['src_ledger_id'],'1 and a.ledger_id=g.ledger_group_id and g.ptype="asset" order by a.ledger_name');?>
      </select></td><?php */?>
	  
	  <td width="15%" align="right" >Asset Name:</td>

    <td width="30%" >
	<? create_combobox('asset_id'); ?>
	  <select name="asset_id" id="asset_id"  style="width:90%; height:32px;" >

        <option value=""></option>

		<? foreign_relation('asset_register a, item_info i','a.asset_id','i.item_name',$_POST['asset_id'],'1 and a.item_id=i.item_id order by i.item_name');?>
      </select></td>
	  
	  <td>&nbsp;</td>
	  <td width="30%">
	  <select name="group_for" id="group_for" class="form-control" required>
                               <option></option>
                               <? foreign_relation('user_group','id','group_name',$_POST['group_for'],'1')?>
                               </select>
							   </td>
	
	 <td width="13%" rowspan="9" align="center" ><strong>

      <input type="submit" name="find_data" id="find_data" value="Find Data" style="width:180px; text-transform:uppercase; background:#87CEFA; color:#000000; text-align:center; font-weight:bold; font-size:12px; height:30px; "/>

    </strong></td>
    </tr>
								  
								</table>

</div>


<? }?>








<? //if($data_found>0){ ?>


<br />




<div class="tabledesign2" style="width:100%">




<table width="100%" border="0" align="center" id="grp" cellpadding="0" cellspacing="0" style="font-size:11px; text-transform:uppercase; font-family: Arial, Helvetica, sans-serif;">

  <tr>
    <th width="5%">JV No </th>

    <th width="9%">JV Date </th>
    <th width="25%">Ledger Name </th>
	<th width="19%">Asset Code</th>
    <th width="19%">Asset Name</th>
    <th width="9%">Type</th>
	
    <th width="7%">DR Amt </th>
    
    <th width="14%">Asset ID </th>
    <th width="5%"><div align="center">Action</div></th>
  </tr>
  
  

  <?
    if(isset($_POST['find_data'])){
  if($_POST['fdate']!=''&&$_POST['tdate']!='') $so_date_con .= ' and m.do_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';


    if($_POST['src_ledger_id']!='')
	$src_ledger_id_con=" and j.ledger_id='".$_POST['src_ledger_id']."'";
	
	if($_POST['do_no']!='')
	$do_no_con=" and m.do_no='".$_POST['do_no']."'";
	
	if($_POST['group_for']>0)
	$con =" and j.group_for='".$_POST['group_for']."'";
	
	if($_POST['asset_id']!='')
	$con =" and r.asset_id='".$_POST['asset_id']."'";
	
	
		
		//$sql = "select tr_id, tr_id as order_id from fixed_asset_journal where tr_id>0 group by tr_id";
//		 $query = db_query($sql);
//		 while($info=mysqli_fetch_object($query)){
//  		 $order_id[$info->tr_id]=$info->order_id;
 $sql="SELECT distinct p.id,j.jv_no,j.jv_date,a.ledger_name, p.amount dr_amt, j.tr_no,j.tr_from,j.group_for, i.item_name,i.finish_goods_code fg_code,r.asset_id as ass_id,j.ledger_id

FROM consumable_issue_detail p,consumable_issue_master v, journal j, fixed_asset_journal f, accounts_ledger a, item_info i, asset_register r

WHERE p.sc_no=v.sc_no and p.sc_no=j.tr_no and j.tr_from='SpareParts Issue' and j.dr_amt>0 and j.ledger_id=a.ledger_id and i.ledger_id=j.ledger_id and p.asset_id=i.item_id and p.capitalized='Yes' and j.jv_no!=f.tr_no and f.fixed_asset_id=r.asset_id and r.item_id=p.asset_id  ".$src_ledger_id_con.$con."";
//		}

 //echo $sql="select j.*, a.ledger_name ,f.fixed_asset_id,n.maintenance_type,m.id
//
//from accounts_ledger a, journal j, fixed_asset_journal f, purchase_invoice m, maintenance_type n, vendor_invoice_details v 
//
//where j.ledger_id=a.ledger_id and f.fixed_asset_id=m.asset_id and j.tr_from='service_bill' and n.id=m.maintenance_type and n.capitalized='Yes' ".$src_ledger_id_con.$con." and v.po_no=m.po_no and v.system_invoice_no=j.tr_no and m.id=v.pr_id and j.dr_amt>0 and f.tr_from='Registered'
//
//group by j.id,m.id,n.maintenance_type,j.tr_no,m.asset_id order by j.id desc";

 //echo $sql="select j.*, a.ledger_name , s.asset_ledger
//
//from accounts_ledger a, journal j, asset_register f, purchase_invoice m, maintainance_type n,item_info i, item_sub_group s
//
//where  j.ledger_id=a.ledger_id and f.asset_id=m.asset_id and j.tr_from='service_bill' and m.id=j.tr_id  and n.id=m.maintenance_type and n.capitalized='Yes' and i.item_id=f.item_id and i.sub_group_id=s.sub_group_id   ".$src_ledger_id_con.$con." group by j.id order by j.jv_date, j.id desc";

  $query = db_query($sql);

  while($data=mysqli_fetch_object($query)){$i++;
  
   $exist_add=find_a_field('fixed_asset_journal','tr_no','tr_no="'.$data->jv_no.'" and fixed_asset_id="'.$data->ass_id.'" and tr_from="Addition"');

  ?>



<? if($exist_add==0) { ?>

  <tr bgcolor="<?=($i%2)?'#E8F3FF':'#fff';?>">
    <td><a href="voucher_print_view.php?jv_no=<?=$data->jv_no?>" target="_blank"><?=$data->jv_no?></a>
	<input name="order_no_<?=$data->id?>" type="hidden" id="order_no_<?=$data->id?>" value="<?=$data->id;?>" />
	<input name="jv_no_<?=$data->id?>" type="hidden" id="jv_no_<?=$data->id?>" value="<?=$data->jv_no;?>" />
	<input name="jv_date_<?=$data->id?>" type="hidden" id="jv_date_<?=$data->id?>" value="<?=$data->jv_date;?>" />	
	<input name="ledger_id_<?=$data->id?>" type="hidden" id="ledger_id_<?=$data->id?>" value="<?=$data->ledger_id;?>" />
	<input name="dr_amt_<?=$data->id?>" type="hidden" id="dr_amt_<?=$data->id?>" value="<?=$data->dr_amt;?>" />
	<input name="cr_amt_<?=$data->id?>" type="hidden" id="cr_amt_<?=$data->id?>" value="<?=$data->cr_amt;?>" />
	<input name="tr_no_<?=$data->id?>" type="hidden" id="tr_no_<?=$data->id?>" value="<?=$data->tr_no;?>" /></td>

    <td><?=date('d-M-Y',strtotime($data->jv_date));?></td>
    <td><?=$data->ledger_name?></td>
    <td><?=$data->fg_code?></td>
	<td><?=$data->item_name?></td>
    <td><?=$data->tr_from?></td>
	 
	
    <td style="font-size:14px; font-weight:700;"><div align="right">
      <?=number_format($data->dr_amt,2);?>
    </div></td>
    
    <td>
	<input type="text" name="fixed_asset_id_<?=$data->id?>" id="fixed_asset_id_<?=$data->id?>"  style="width:90%; height:32px;" value="<?=$data->ass_id?>"  readonly=""/>
	
	<?php /*?><input type="text" name="fixed_asset_id_<?=$data->id?>" id="fixed_asset_id_<?=$data->id?>"  style="width:90%; height:32px;" list="assetList" >

        <datalist id="assetList">
		<? foreign_relation('asset_register','asset_id','""',$fixed_asset_id,'1');?>
		</datalist><?php */?>
		</td>
    <td>
	
	<span id="divi_<?=$data->id?>">
	<input name="flag_<?=$data->id?>" type="hidden" id="flag_<?=$data->id?>" value="0" />

	<input type="button" name="button" value="ACCEPT"  onclick="calculation('<?=$data->id?>')" style="width:70px; font-size:12px; height:30px; background-color:#66CC66; font-weight:700;"/>
    </span></td>
  </tr>
  

  <? }  } } ?>
</table>
</div>

<br />



<br /><br />






<? //}?>








<p>&nbsp;</p>

</form>

</div>


<script>

  function calculation(id) {
  var order_no = document.getElementById('order_no_'+id).value;
  var asset_id = document.getElementById('fixed_asset_id_'+id).value;
  var jv_no = document.getElementById('jv_no_'+id).value;
  var jv_date = document.getElementById('jv_date_'+id).value;
  var ledger_id = document.getElementById('ledger_id_'+id).value;
  var dr_amt = document.getElementById('dr_amt_'+id).value;
  var cr_amt = document.getElementById('cr_amt_'+id).value;
  var tr_no = document.getElementById('tr_no_'+id).value;
  var group_for = document.getElementById('group_for').value;
    
    $.ajax({
      url: 'spare_addition_ajax.php',
      type: 'POST',
      data: {
        asset_id: asset_id,
		order_no: order_no,
		jv_no: jv_no,
		jv_date: jv_date,
		ledger_id: ledger_id,
		dr_amt: dr_amt,
		cr_amt: cr_amt,
		tr_no: tr_no,
		group_for: group_for
      },
      success: function(response) {
      
        var res = JSON.parse(response);
        
		document.getElementById("divi_"+id).innerHTML = res['msg'];
      },
      error: function(xhr, status, error) {
        
        console.error(error);
      }
    });
  }
</script>


<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>