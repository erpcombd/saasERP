<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$title='Bill Payment';

$proj_id=$_SESSION['proj_id'];

$user_id=$_SESSION['user']['id'];

do_calander('#jv_date');

do_calander('#c_date');

$cgc=find_all_field('config_group_class','group_id',"group_for=".$_SESSION['user']['group']);

$cash_and_bank_balance=find_a_field('ledger_group','group_id',"group_sub_class='1020' and group_for=".$_SESSION['user']['group']);
$chk_voucher_mode = db_query("SELECT voucher_mode,voucher_entry_mode FROM project_info LIMIT 1");

$old_voucher_mode = mysqli_result($chk_voucher_mode,0,'voucher_mode');

$voucher_type = mysqli_result($chk_voucher_mode,0,'voucher_entry_mode');

$separator=$_SESSION['separator'];

if($_SESSION['vendor_ledger']==''){
$vendor_ledger = $_POST['vendor'];
$_SESSION['vendor_ledger'] = $vendor_ledger;
}
$tr_from = 'Bill_Payment';

//step 1

if(!isset($_GET['v_d'])&&!isset($_GET['v_type']))

	{

		$voucher_mode = $_POST['voucher_mode'];

	if($voucher_mode==0&&$_POST['receipt_no']>0)

			{

		$receipt_no		   = next_invoice('receipt_no','receipt');

		$manual_receipt_no = next_invoice('receipt_no','receipt');

			}

			

		else

			{

		$receiptno=next_invoice('receipt_no','receipt');

		$receipt_no		   = $receiptno;

		$manual_receipt_no = '';

			}

		

		$v_d=time();

		if( $voucher_mode != $old_voucher_mode )

			db_query("UPDATE project_info SET voucher_mode=$voucher_mode WHERE 1");			

	}

else

{

	$receipt_no	= $_GET['v_no'];

	$v_d		= $_GET['v_d'];

	$v_no		= $_GET['v_no'];

	$v_type		= $_GET['v_type'];

}

///////////////////

if(isset($_POST['receipt']))

{

$receipt_no = $_POST['receipt_no'];
$date  = $_POST['date'];
$r_from  = $_POST['r_from'];
$c_no = $_POST['c_no'];
$cheq_date = $_POST['c_date'];
$bank = $_POST['bank'];
$jv_date = $_POST['jv_date'];
$user_id = $_SESSION['user']['id'];
$dnarr = $_POST['r_from'];
$checked = 'NO';
if($_POST['c_id']!=''){

$credit_ledger = $_POST['c_id'];
}elseif($_POST['b_id']!=''){
$credit_ledger = $_POST['b_id'];

}
$tr_from = "Bill_Payment";
$jv_no = next_journal_sec_voucher_id($tr_from);

$sql='select jv_no,jv_date,cr_amt,ledger_id,tr_no from secondary_journal where tr_from="Bill" and ledger_id="'.$_SESSION['vendor_ledger'].'"';
$query=db_query($sql);
 while($data=mysqli_fetch_object($query)){
$tr_no = $_POST['tr_no'.$data->jv_no];
$debit_ledger  = $_POST['debit_ledger'.$data->jv_no];
$amount = $_POST['v_amt'.$data->jv_no];
$do_no = $_POST['do_no'.$data->jv_no];

//debit
add_to_sec_journal($proj_id, $jv_no, $jv_date, $debit_ledger, $dnarr, $amount , '0', $tr_from, $tr_no,'',$do_no,$cc_code,'',$user_id,'',$r_from, $bank,$c_no,$cheq_date,$receive_ledger,$checked);
//credit
add_to_sec_journal($proj_id, $jv_no, $jv_date, $credit_ledger, $dnarr, '0', $amount, $tr_from, $tr_no,'',$do_no,$cc_code,'',$user_id,'',$r_from, $bank,$c_no,$cheq_date,$receive_ledger,$checked);
}



$jv_config = find_a_field('voucher_config','direct_journal','voucher_type="'.$tr_from.'"');



if($jv_config=="Yes"){

$time_now = date('Y-m-d H:i:s');
$up2='update secondary_journal set checked="YES",checked_at="'.$time_now.'",checked_by="'.$_SESSION['user']['id'].'" where jv_no="'.$jv_no.'" and tr_from="'.$tr_from.'"';

db_query($up2);

sec_journal_journal($jv_no,$jv_no,$tr_from);


}
$_SESSION['vendor_ledger'] = '';

header('Location:../files/select_bill.php');
}


//print code

if(!isset($_GET['v_d']))

{

	$receiptno=next_invoice('receipt_no','receipt');

	$v_d=time();

}

?>

<?php js_ledger_subledger_autocomplete_new('receipt',$proj_id,$voucher_type,$_SESSION['user']['group']); 
    $led2=db_query("select  concat(ledger_name,'##>>',ledger_id), concat(ledger_name,'##>>',ledger_id) FROM accounts_ledger WHERE ledger_name not like '%cash%' and ledger_group_id='$cash_and_bank_balance' and parent=0 order by ledger_id");

	if(mysqli_num_rows($led2) > 0)

	{

      $data2 = '[';

	  while($ledg2 = mysqli_fetch_row($led2)){$data2 .= '{ name: "'.$ledg2[1].'", id: "'.$ledg2[0].'" },';}

      $data2 = substr($data2, 0, -1);

      $data2 .= ']';

	}

	else {$data2 = '[{name:"empty", id:""}]';}

?>

<script type="text/javascript">

$(document).ready(function(){
	function formatResult(row) {

		return row[0].replace(/(<.+?>)/gi, '');

	}
	var data2 = <?php echo $data2; ?>;

    $("#b_id").autocomplete(data2, {



		matchContains: true,



		minChars: 0,



		scroll: true,



		scrollHeight: 300,



        formatItem: function(row, i, max, term) {



            return row.name; // + " [" + row.id + "]";



		},



		formatResult: function(row) {



			return row.id;



		}



	});

$(window).load(function() {

      open_limit(1);

});

  });

</script>

<script type="text/javascript">

function voucher_no(val)

	{

		var voucher_mode = val;

		

		if( voucher_mode == 0 )

			{

				document.getElementById('receipt_no').value		= "";

				document.getElementById('receipt_no').readOnly	= false;

				document.getElementById('receipt_no').select();

				document.getElementById('receipt_no').focus();

			}

		else if( voucher_mode == 1 )

			{

				document.getElementById('receipt_no').value		= "<?php echo $receipt_no;?>";

				document.getElementById('receipt_no').readOnly	= true;

			}

	}

	

function DoNav(theUrl)

{

	var URL = 'voucher_view_popup.php?'+theUrl;

	popUp(URL);

}

function popUp(URL) 

{

day = new Date();

id = day.getTime();

eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=1,width=800,height=800,left = 383,top = -16');");

}

	

function sr_alert(id){

var tot = (document.getElementById('tott_'+id).value)*1;
var v_amt = (document.getElementById('v_amt_'+id).value)*1;

if(tot<v_amt){
alert("You Cant Place More Then Payabel Amount !!");
document.getElementById('v_amt_'+id).value = '';

}

}
function sum_sum(id){
var tot = (document.getElementById('pending_amt'+id).value)*1;

document.getElementById('v_amt'+id).value = tot;

}


function goto_tab()

{

	//alert('tab mamaun');

	document.getElementById('ledger_id').focus()

}

	

</script>

<script type="text/javascript" src="../common/js/check_balance.js"></script>

<script type="text/javascript" src="../common/receipt_check.js"></script>

<style type="text/css">

<!--

.style1 {font-size: 18px}

.style2 {font-size: 10px}

-->

</style>

<form action="" id="form2" name="form2" method="post" >
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #C1DAD7;border-collapse:collapse;width:100%;">

  <tr>

    <td>      <table width="100%" border="0" cellspacing="0" cellpadding="0">

        <tr>

			<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><table width="100%" border="0" cellspacing="2" cellpadding="2" style=" margin-left:-18px; margin-top:10px;" >
                    <!--<tr>
                      <td><div align="right">Voucher Mode:</div></td>
                      <td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td><input type="radio" name="voucher_mode" id="voucher_mode_manual" class="radio" value="0" <?php if($old_voucher_mode==0){ ?>checked="checked"<?php } ?> onclick="voucher_no(this.value)"/>
                              Manual</td>
                            <td><input class="radio" type="radio" name="voucher_mode" id="voucher_mode_auto" value="1" <?php if($old_voucher_mode==1){ ?>checked="checked"<?php } ?> onclick="voucher_no(this.value)"/>
                              Auto</td>
                          </tr>
                      </table></td>
                    </tr>-->
                    <tr>
                      <td><div align="right">Voucher No:</div></td>
                      <td><? 

$receipt_no=next_invoice('receipt_no','receipt');

if($v_d>10000)

$v_d=date("d-m-y",$v_d);
if($_GET['action']=='edit') {$v_no_show='value="'.$v_no.'" readonly'; } 

elseif($old_voucher_mode==1){$v_no_show='value="'.$receiptno.'" readonly'; } 

else $v_no_show='';

?>
                          <input name="receipt_no" type="text" id="receipt_no" size="15" class="form-control" <?=$v_no_show?> />
                          <?php if($_GET['action']=='edit') echo "<font color='#FF0000'>EDITING</font>";?>                      </td>
                      <td width="19%" align="right"><div align="right">Voucher Date:</div></td>



                        <td width="30%"><input name="jv_date" type="text" id="jv_date" value="" size="10" tabindex="1"required class="form-control" />
                          </td>
                    </tr>
                    <tr>
                      <td><div align="right">Naration :</div></td>
                      <td colspan="3">
                        <input name="r_from" type="text" id="r_from" value="" tabindex="1" required class="form-control"/>
                      </td>
                    </tr>
                    <tr>
                      <td><div align="right">Cash A/c Debit:</div></td>
                      <td colspan="3" style="text-align:left">



                        <div align="left">
                         <select name="c_id"  style="float:left" tabindex="2" class="form-control" >
                            <option></option>
                        <?

$led2=db_query("select ledger_id, ledger_name from accounts_ledger where ledger_name like '%cash%' and parent=0 order by ledger_id");

if(mysqli_num_rows($led2) > 0)

{

while($ledg2 = mysqli_fetch_row($led2)){

echo '<option value="'.$ledg2[0].'">'. $ledg2[1].' ['.$ledg2[0].']</option>';

}

$data2 = substr($data2, 0, -1);



}



						?>



                        </select>
                          </div></td></tr>
                    <tr>
                      <td><div align="right">Bank A/c Debit:</div></td>
                      <td colspan="3"><div align="left">
                       <select name="b_id" id="bank_disable_id" style="float:left" tabindex="2" class="form-control" >
                                     <option value="0"></option>
                          <?

foreign_relation('accounts_ledger','ledger_id','ledger_name',$b_id,"ledger_name not like '%cash%' and parent=0 and ledger_id like '".$cash_and_bank_balance."%'  order by ledger_id");

						?>

                         

                        </select>
                      </div></td>
                    </tr>
                    <tr>
                      <td><div align="right"><span>Cheque No:</span></div></td>
                      <td colspan="3">
                        <input name="c_no" type="text" id="c_no" value="" size="20" maxlength="25" tabindex="4" class="form-control"/>
                      </td>
                    </tr>
                    <tr>
                      <td><div align="right"><span>Cheque</span> Date: </div></td>
                      <td colspan="3">
                        <input name="c_date" type="text" id="c_date" tabindex="6" value="" size="12" maxlength="10" class="form-control" />
                      </td>
                    </tr>
                    <tr>
                      <td align="right"><div align="right">Of Bank:</div></td>
                      <td colspan="3">
                        <input name="bank" type="text" id="bank" value=""  tabindex="7" class="form-control"/>
						
						
                      </td>
                    </tr>
                </table></td>
                <td align="right" valign="top"><div class="box">
                    <table  class="tabledesign table-bordered" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #C1DAD7;border-collapse:collapse;width:100%;">
                      <tr>
                        <th>Voucher No </th>
                        <th>Amount</th>
                        <th colspan="3">Narration</th>
                      </tr>
                      <?

$sql2="select a.tr_no, a.cr_amt, a.narration,a.jv_date, a.do_no,a.jv_no

from  secondary_journal a where a.tr_from='Bill_Payment' and a.group_for='".$_SESSION['user']['group']."' and SUBSTRING(a.tr_no,5,1)='0' and  a.cr_amt>0 order by a.tr_no desc limit 6";

$data2=db_query($sql2);

if(mysqli_num_rows($data2)>0){

while($dataa=mysqli_fetch_row($data2))

{$dataa[2]=substr($dataa[2],0,20).'...';

					?>
                      <tr class="alt">
                        <td><?=$dataa[0]?></td>
                        <td><?=$dataa[1]?></td>
                        <td><?=$dataa[2]?></td>
                        <td style="padding:1px;" onclick="DoNav('<?php echo 'v_type=Bill_Payment&vdate='.date("Y-m-d",$dataa[3]).'&v_no='.$dataa[4].'&view=Show&in=receipt' ?>');"><img src="../images/copy_hover.png" width="16" height="16" border="0" /></td>
                        <td style="padding:1px;" ><a href="voucher_print_receipt.php?v_type=Bill_Payment&amp;vo_no=<?php echo $dataa[5];?>" target="_blank"><img src="../images/print.png" width="16" height="16" border="0" /></a></td>
                      </tr>
                      <? }}?>
                    </table>
                </div></td>
              </tr>
            </table></td>

	    </tr>

		<tr><td>&nbsp;</td></tr>

        <tr>

          <td>
      <table width="98%" align="center" cellspacing="0" class="tabledesign">

      <tbody>
	

      <tr>

      <th>SL</th>

      <th>Jv Date </th>
      <th>Voucher No</th>

      

      <th>Payable Party </th>
      <th>Total Bill </th>
      <th>Total Paid Amt </th>
      <th>Payable Amt</th>

      <th>Action</th>

      <th>Checked?</th>
      <th>&nbsp;</th>
      </tr>

	  <?
		// if($_POST['do_date_fr']!=''){

	  $i=0;

		
	  $sql='select jv_no,jv_date,cr_amt,ledger_id,tr_no from secondary_journal where cr_amt>0 and tr_from="Bill" and ledger_id="'.$_SESSION['vendor_ledger'].'"';

	  $query=db_query($sql);
	  while($data=mysqli_fetch_object($query)){
	 
	  $tot_amt =  find_all_field_sql("select sum(dr_amt) tdr,sum(cr_amt) tcr from journal where tr_id=".$data->tr_no." and tr_from='Bill_Payment' and ledger_id=".$data->ledger_id);
	  $tot = $data->cr_amt; 
	  $tot_payable_amt = ($tot-$tot_amt->tdr);
	  
    

	  ?>

      <tr class="alt">

      <td align="center"><div align="left">

        <?=++$i;?>

      </div></td>

      <td align="center"><? echo $data->jv_date;?></td>
      <td align="center"><div align="left"><?=$data->jv_no;?></div></td>
      

      <td align="right"><?=find_a_field('accounts_ledger','ledger_name','ledger_id='.$data->ledger_id);?></td>
      <td align="right"><?=$data->cr_amt;?></td>
      <td align="right"><?=$tot_amt->tdr;?>
	  <input type="hidden" id="debit_ledger<?=$data->jv_no?>" name="debit_ledger<?=$data->jv_no?>" value="<?=$data->ledger_id;?>" />
	  <input type="hidden" name="do_no<?=$data->jv_no?>" value="<?=$data->tr_no;?>"  />	  </td>
      <td align="right"><?=$tot_payable_amt;?><input type="hidden" id="pending_amt<?=$data->jv_no?>" name="pending_amt<?=$data->jv_no?>" value="<?=$tot_payable_amt;?>" /><input type="hidden" id="credit_ledger<?=$data->jv_no?>" name="credit_ledger<?=$data->jv_no?>" value="<?=$data->ledger_id;?>" />
	  <input type="hidden" name="tr_no<?=$data->jv_no?>" value="<?=$data->tr_no?>" />
	  </td>
	  
	  
	  
      <td align="center"><button onclick="sum_sum(<?=$data->jv_no?>)" type="button">Full</button></td>

      <td align="center"><input type="number" name="v_amt<?=$data->jv_no?>" id="v_amt<?=$data->jv_no?>" style=" width: 90px; " onchange="sr_alert(<?=$data->jv_no?>)" onblur="" class="form-control" /></td>
      <td align="center"><a target="_blank" href="purchase_sec_print_view.php?do_no=<?=$data->do_no ?>"><img src="../images/print_hover.png" width="20" height="20" /></a></td>
      </tr>

	  <? $g_tot_paid = $g_tot_paid + $tot_paid_amt;  $g_tot_payable = $g_tot_payable + $tot_payable_amt;   } 
	  
	  //}?>

	        <tr class="alt">

        <td colspan="5" align="center"><div align="right"><strong>Total : </strong></div>

          

            <div align="left"></div></td>

        <td align="right"><?=number_format($received,2);?></td>
        <td align="right"><?=number_format($g_tot_paid,2);?></td>
        <td align="right"><?=number_format($g_tot_payable,2);?></td>

        <td align="center">&nbsp;</td>

        <td align="center">&nbsp;</td>
        <td align="center"><div align="left"></div></td>
      </tr>
  </tbody></table>	
  <br />
      <div align="center">
              <input type="submit" class="btn btn-success" name="receipt" value="SUBMIT"  />
	
          </div>

  </td>

	    </tr>

		<tr>

		<td>&nbsp;</td>

		</tr>

		<tr>

		<td>

		<div>

                    

		<table width="100%" border="0" cellspacing="0" cellpadding="0">		

		<tr>		

		<td>

		<div style="width:380px;"></div></td>

		</tr>

		</table>

	        </div>

		</td>

		</tr>

      </table></td></tr>

</table>


</form>	  
<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>

