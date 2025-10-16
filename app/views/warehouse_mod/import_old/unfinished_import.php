<?php

require_once "../../../assets/template/layout.top.php";

$title='Select Unfinished Chalan';



$table_master='purchase_master';

$unique_master='do_no';

do_calander('#fdate');
do_calander('#tdate');
$table_detail='purchase_invoice';

$unique_detail='id';



$table_chalan='purchase_receive';

$unique_chalan='id';



$$unique_master=$_SESSION[$unique_master];








if(isset($_POST['confirm']))

{

		unset($_POST);

		$_POST[$unique_master]=$$unique_master;

		$_POST['entry_at']=date('Y-m-d h:s:i');

		$_POST['status']='PROCESSING';

		$crud   = new crud($table_master);

		$crud->update($unique_master);

		$crud   = new crud($table_detail);

		$crud->update($unique_master);

		$crud   = new crud($table_chalan);

		$crud->update($unique_master);

		unset($$unique_master);

		unset($_SESSION[$unique_master]);

		$type=1;

		$msg='Successfully Instructed to Depot.';

}

//

//$table='sale_do_master';

//$show='dealer_code';

//$id='do_no';

//$con='status="PROCESSING"';

//$text_field_id='do';

//

//if($con!='') $condition = " where ".$con;

//$query="Select ".$id.", ".$show." from ".$table.$condition;

//

//$led=mysql_query($query);

//	if(mysql_num_rows($led) > 0)

//	{

//		$ledger = '[';

//		while($ledg = mysql_fetch_row($led)){

//		  $ledger .= '{ name: "'.find_a_field('dealer_info','dealer_name_e','dealer_code='.$ledg[1]).'", id: "'.$ledg[0].'" },';

//		}

//		$ledger = substr($ledger, 0, -1);

//		$ledger .= ']';

//	}

//	else

//	{

//		$ledger = '[{ name: "empty", id: "" }]';

//	}

//

//echo '<script type="text/javascript">

//$(document).ready(function(){

//    var data = '.$ledger.';

//    $("#'.$text_field_id.'").autocomplete(data, {

//		matchContains: true,

//		minChars: 0,

//		scroll: true,

//		scrollHeight: 300,

//        formatItem: function(row, i, max, term) {

//            return row.name + " [" + row.id + "]";

//		},

//		formatResult: function(row) {

//			return row.id;

//		}

//	});

//  });

//</script>';



?>

<script language="javascript">

window.onload = function() {

  document.getElementById("do").focus();

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
  
  
  <table style="cursor:pointer" width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td><div class="tabledesign2">
<table width="100%" cellspacing="0" cellpadding="0" id="grp">
<tbody>
<tr>

<th class="text-center">Import No</th>
<th class="text-center">Import Date</th>
<th class="text-center">Vendor Name</th>
<th class="text-center">Entry By</th>
<th class="text-center">Action</th>

 </tr>


 <? 
 if($_POST['fdate']!='') {
 $con=' and a.or_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';

 }

 else{
 $con=' and a.or_date between "'.date('Y-m-01').'" and "'.date('Y-m-d').'"';

 }

     $res ='select a.or_no,a.or_no, a.or_date,a.entry_by,a.vendor_id,u.fname
 
  from warehouse_other_receive a,user_activity_management u, lc_import l
  
  where l.import_no=a.or_no and a.entry_by=u.user_id  and a.journal="Pending" and a.receive_type="Import" and l.journal_status="Pending" '.$con.' group by l.import_no order by a.or_no desc';
 
// $res= 'select p.po_no,p.entry_by,p.po_date,u.fname
// 
// from purchase_master p,vendor v,user_activity_management u
// 
// where p.vendor_id=v.vendor_id and p.status="MANUAL" and v.vendor_category=1 and p.entry_by=u.user_id and p.po_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
$query = mysql_query($res);
while($data = mysql_fetch_object($query)){
?>
<tr>
<td class="text-center"><?=$data->or_no?></td>
<td class="text-center"><?=$data->or_date?></td>
<td class="text-center"><?=find_a_field('vendor','vendor_name','vendor_id='.$data->vendor_id);?></td>
<td class="text-center"><?=$data->fname?></td>
<td style="text-align:center"><a href="unfinished_import_confirm.php?or_no=<?=$data->or_no?>"><input type="button" name="submitit" id="submitit" value="VIEW DETAIL" class="btn btn-success btn-sm" /></a></td>

</tr>
<?php } ?>

</tbody></table>
</div></td>
</tr>
</table>

</div>



<?

require_once "../../../assets/template/layout.bottom.php";

?>