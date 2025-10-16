<?php
//
//
require "../../support/inc.all.php";

do_calander('#odate');
$head='<link href="../../css/report_selection.css" type="text/css" rel="stylesheet"/>';

$table='journal_item';
$unique='id';

if(isset($_POST["upload"])){
$warehouse_id 	= $_POST['warehouse_id'];
$odate 			= $_POST['odate'];
$tr_from = 'Adjust';

$filename=$_FILES["mobile_bill"]["tmp_name"];
	if($_FILES["mobile_bill"]["tmp_name"]!=""){	
	//echo '<span style="color: red;">Excel File Successfully Imported</span>';
	$file = fopen($filename, "r");
		
while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE){
$item_id = substr($emapData[0],2,16);
	if($emapData[1]==$warehouse_id){

$s_sql="select * from journal_item where item_id ='".$item_id."' and warehouse_id='".$emapData[1]."' and ji_date='".$odate."' and tr_from='".$tr_from."'";		
$s_query=@db_query($s_sql);		$s_num_row=@mysqli_num_rows($s_query);
		
		if($s_num_row==0){			
			$sql = "INSERT INTO journal_item (ji_date,item_id,warehouse_id,item_in,item_ex,tr_from,entry_by,entry_at,item_price) VALUES
			('".$odate."','".$item_id."','".$warehouse_id."','".$emapData[2]."','".$emapData[3]."','".$tr_from."',
			'".$_SESSION['user']['id']."','".date('Y-m-d H:i:s')."','".$emapData[4]."')";
			db_query($sql); 
			} else {
		$sql = 'update journal_item set item_in = "'.$emapData[2].'",item_ex = "'.$emapData[3].'",item_price="'.$emapData[4].'",entry_by = "'.$_SESSION['user']['id'].'",entry_at = "'.date('Y-m-d H:i:s').'"
		where item_id="'.$item_id.'" and warehouse_id="'.$emapData[1].'" and ji_date="'.$odate.'" and tr_from="'.$tr_from.'" ';
		db_query($sql);
		}
	} else {echo '<span style="color: red;">Upload file not matching with select warehouse</span>';}
} // end while
fclose($file);} // end file upload if




$sql = "SELECT sum(i.f_price*j.item_in) as in_amt,sum(i.f_price*j.item_ex) as out_amt
FROM journal_item j, item_info i
WHERE
i.item_id=j.item_id 
AND j.ji_date = '".$odate."'
AND j.warehouse_id ='".$warehouse_id."'
AND j.tr_from = 'Adjust'";
$d = find_all_field_sql($sql);

$d->in_amt;
$d->out_amt;

// set 1 
$jv_no=next_journal_sec_voucher_id();
add_to_sec_journal($proj_id, $jv_no, $jv_date, $config_ledger->other_sales_exp, $narration,($data->total_amt+$total_amt_memo->total_amt), '0', $tr_from, $tr_no,'',$tr_id,$cc_code);
add_to_sec_journal($proj_id, $jv_no, $jv_date, $config_ledger->other_local_sales, $narration, '0',  $data->total_amt, $tr_from, $tr_no,'',$tr_id,$cc_code);
// set 2
$jv_no=next_journal_sec_voucher_id();
add_to_sec_journal($proj_id, $jv_no, $jv_date, $config_ledger->other_sales_exp, $narration,($data->total_amt+$total_amt_memo->total_amt), '0', $tr_from, $tr_no,'',$tr_id,$cc_code);
add_to_sec_journal($proj_id, $jv_no, $jv_date, $config_ledger->other_local_sales, $narration, '0',  $data->total_amt, $tr_from, $tr_no,'',$tr_id,$cc_code);


echo "Process Complete";
} // end submit button
?>

<div class="oe_view_manager oe_view_manager_current">
<form action=""  method="post" enctype="multipart/form-data">
        <div class="oe_view_manager_body">
<div  class="oe_view_manager_view_list"></div>
<div class="oe_view_manager_view_form"><div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">
        <div class="oe_form_buttons"></div>
        <div class="oe_form_sidebar"></div>
        <div class="oe_form_pager"></div>
        <div class="oe_form_container"><div class="oe_form">
          <div class="">
<div class="oe_form_sheetbg">
        <div class="oe_form_sheet oe_form_sheet_width">
          <div  class="oe_view_manager_view_list"><div  class="oe_list oe_view">
            <table width="80%" border="1" align="center">
              <tr>

                <td height="40" colspan="4" bgcolor="#00FF00"><div align="center" class="style1">Upload Adjust Entry </div></td>
                </tr>

              <tr>
                <td>Adjust Date </td>
<td colspan="3">
<input name="odate" type="text" id="odate" style="width:100px;" 
value="<?=date('Y-11-25')?>" /></td>
              </tr>
              <tr>
<td>Warehouse</td>
<td colspan="3"><select name="warehouse_id" id="warehouse_id">
<option></option>
<? foreign_relation('warehouse','warehouse_id','warehouse_name',
$_POST['warehouse_id'],'group_for="'.$_SESSION['user']['group'].'" 
and status="Active" order by warehouse_name');?>
                </select></td>
              </tr>
              <tr>
                <td width="20%">&nbsp;</td>
                <td colspan="3"></td>
                </tr>

              <tr>
                <td> Upload  File :</td>
<td colspan="3"><input name="mobile_bill"  type="file" id="mobile_bill"/>
<input name="upload" type="submit" id="upload" value="Upload File" /></td>
                </tr>
              <tr>

                <td colspan="4">
                  <div align="center"></div></td>
                </tr>


              <tr>

                <td colspan="4"><label>

                    <div align="center">
                      <p>CSV File Example: </p>
Item id, Warehouse id, item in, item out
                    , rate </div>

                    </label></td>
              </tr>
            </table>

            <br />
          </div>
          </div>

          </div>
    </div>
    <div class="oe_chatter"><div class="oe_followers oe_form_invisible">
      <div class="oe_follower_list"></div>
    </div></div></div></div></div>
    </div></div>
</div>
 </form>   </div>

<?
//
//
require_once SERVER_CORE."routing/layout.bottom.php";
?>