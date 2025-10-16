<?php

session_start();


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$proj_id	= $_SESSION['proj_id'];



$vdate		= $_REQUEST['vdate'];

$jv_no =  $_REQUEST['v_no'];

$v_type 		= $_REQUEST['v_type'];



$v_type = strtolower($v_type);

$no 		= $v_type."_no";

$v_no = find_a_field('journal','tr_no','jv_no='.$_REQUEST['v_no']);







	$cheq_no = $_POST["cheq_no"];

	$cheq_date = strtotime($_POST["cheq_date"]);



if($v_type=='receipt'){$voucher_name='RECEIPT VOUCHER';$vtype='receipt';$tr_from='receipt';}

elseif($v_type=='payment'){$voucher_name='PAYMENT VOUCHER';$vtype='payment';$tr_from='payment';}

elseif($v_type=='journal_info'){$voucher_name='JOURNAL VOUCHER';$vtype='journal_info';$tr_from='journal_info';}

elseif($v_type=='contra'){$voucher_name='CONTRA VOUCHER';$vtype='coutra';$tr_from='contra';}

elseif($v_type=='purchase'){$v_type='jv'; $voucher_name='PURCHASE VOUCHER';$vtype='journal';$tr_from='Purchase';}

elseif($v_type=='special_journal'){$v_type='jv'; $voucher_name='JOURNAL VOUCHER';$vtype='special_journal';$tr_from='special_journal';}

elseif($v_type=='issue'){ $voucher_name='JOURNAL VOUCHER';$vtype='issue';$tr_from='Issue';}

elseif($v_type=='local purchase'){ $voucher_name='JOURNAL VOUCHER';$vtype='local purchase';$tr_from='Local Purchase';}

elseif($v_type=='cogs'){ $voucher_name='JOURNAL VOUCHER';$vtype='cogs';$tr_from='cogs';}

elseif($v_type=='Staff Sales'){ $voucher_name='JOURNAL VOUCHER';$vtype='Staff Sales';$tr_from='Staff Sales';}



else{$v_type=='coutra';$voucher_name='CONTRA VOUCHER';$vtype='coutra';$tr_from='contra';}

		

if(isset($_REQUEST['delete']))

{	

	$sqlDel1 = "DELETE FROM $vtype WHERE $no='$v_no' and 1";

	$sqlDel2 = "DELETE FROM journal WHERE tr_no='$v_no' AND tr_from='$tr_from'";

	if(db_query($sqlDel1)){}

	if(db_query($sqlDel2)){}

if($_GET['in']=='Journal_info')	echo "<script>self.opener.location = 'journal_note_new.php'; self.blur(); </script>";

elseif($_GET['in']=='Contra')	echo "<script>self.opener.location = 'coutra_note_new.php'; self.blur(); </script>";

elseif($_GET['in']=='Credit')	echo "<script>self.opener.location = 'credit_note.php'; self.blur(); </script>";

elseif($_GET['in']=='Debit')	echo "<script>self.opener.location = 'debit_note.php'; self.blur(); </script>";

else	echo "<script>self.opener.location = 'voucher_view.php'; self.blur(); </script>";



echo "<script>window.close(); </script>";

}

if($v_type=='coutra') $v_type='Contra'; else $v_type=$v_type;

if(isset($_POST['change']))

{

	$vdate = $_POST["vdate"];

    $sqldate1 = "UPDATE $vtype SET {$v_type}_date='$vdate' WHERE $no='$v_no' and 1";

	$sqldate2 = "UPDATE journal SET jv_date='$vdate' WHERE jv_no='$jv_no' AND tr_from='$tr_from'";

	@db_query($sqldate1);

	@db_query($sqldate2);

}





if(isset($_POST['narr']))

{

$count = $_POST["count"];



 $sql2="select a.id, a.tr_id,a.jv_no,a.jv_date,a.tr_from,a.tr_no from journal a where a.tr_from = '$tr_from' and a.jv_no='$jv_no' and 1";

$data2=db_query($sql2);

while($datas=mysqli_fetch_row($data2)){ 

$jv_no =  $datas[2];

$jv_date =   $datas[3];

$tr_id =  $datas[1];

$tr_from =  $datas[4];

$tr_no =  $datas[5];

$ledger_old=$_POST['ledger_'.$datas[0]];



$ledger_new = explode('#>',$ledger_old);

$ledger = $ledger_new[1];



$c_no=$_POST['c_no'];

$c_date=$_POST['c_date'];



$narration=$_POST['narration_'.$datas[0]];

$dr_amt=$_POST['dr_amt_'.$datas[0]];

$cr_amt=$_POST['cr_amt_'.$datas[0]];



if($dr_amt==0&&$cr_amt==0){

$sqldate1 = "delete from $vtype WHERE id = ".$datas[1];

$sqldate2 = "delete from journal WHERE id = ".$datas[0];

if(isset($sqldate1))@db_query($sqldate1);@db_query($sqldate2);

}

else

{

$sqldate1 = "UPDATE $vtype SET cheq_no='$cheq_no',cheq_date='$cheq_date',ledger_id='$ledger',narration='$narration',dr_amt='$dr_amt',cr_amt='$cr_amt' WHERE id = ".$datas[1];

$sqldate2 = "UPDATE journal SET cheq_no='$cheq_no',cheq_date='$cheq_date',ledger_id='$ledger',narration='$narration',dr_amt='$dr_amt',cr_amt='$cr_amt' WHERE id = ".$datas[0];

if(isset($sqldate1))@db_query($sqldate1);@db_query($sqldate2);

}

	}

	

if(($_POST['dr_amt_new1']>0||$_POST['cr_amt_new1'])&&($_POST['ledger_new1']!=''))

{

$ledger_new = explode('#>',$_POST['ledger_new1']);

$ledger = $ledger_new[1];



 $sql = "INSERT INTO $vtype 

({$v_type}_no, {$v_type}_date, `narration`, `ledger_id`, `dr_amt`, `cr_amt`) 

VALUES 

('$tr_no', '$jv_date',  '".$_POST['narration_new1']."', '$ledger', '".$_POST['dr_amt_new1']."', '".$_POST['cr_amt_new1']."')";

if(db_query($sql)){

$tr_id = db_insert_id();

add_to_journal('Sajeeb', $jv_no, $jv_date, $ledger, $_POST['narration_new1'], $_POST['dr_amt_new1'], $_POST['cr_amt_new1'], $tr_from, $tr_no, '', $tr_id, '');}

}



if(($_POST['dr_amt_new2']>0||$_POST['cr_amt_new2'])&&($_POST['ledger_new2']!=''))

{

$ledger_new = explode('#>',$_POST['ledger_new2']);

$ledger = $ledger_new[1];

 

 $sql = "INSERT INTO $vtype 

({$v_type}_no, {$v_type}_date, `narration`, `ledger_id`, `dr_amt`, `cr_amt`) 

VALUES 

('$tr_no', '$jv_date',  ".$_POST['narration_new2'].", '$ledger', '".$_POST['dr_amt_new2']."', '".$_POST['cr_amt_new2']."')";

if(db_query($sql)){

$tr_id = db_insert_id();

add_to_journal('Sajeeb', $jv_no, $jv_date, $ledger, $_POST['narration_new2'], $_POST['dr_amt_new2'], $_POST['cr_amt_new2'], $tr_from, $tr_no, '', $tr_id, '');}

}

}

if(isset($_REQUEST['view']) && $_REQUEST['view']=='Show')

{





	$sql1="select narration,cheq_no,cheq_date,' ',jv_date from journal where jv_no='$jv_no' and tr_from ='$tr_from' limit 1";

	$data1=mysqli_fetch_row(db_query($sql1));

	$sql1."<br>";

?>

<link href="../css/style.css" type="text/css" rel="stylesheet"/>

<link href="../css/menu.css" type="text/css" rel="stylesheet"/>

<link href="../css/table.css" type="text/css" rel="stylesheet"/>

<link href="../css/pagination.css" rel="stylesheet" type="text/css" />

<link href="../css/jquery-ui-1.8.2.custom.css" rel="stylesheet" type="text/css" />

<link href="../css/jquery.autocomplete.css" rel="stylesheet" type="text/css" />

<meta name="Developer" content="Md. Mhafuzur Rahman Cell:01815-224424 email:mhafuz@yahoo.com" />

<script type="text/javascript" src="../js/jquery-1.4.2.min.js"></script>

<script type="text/javascript" src="../js/jquery-ui-1.8.2.custom.min.js"></script>

<script type="text/javascript" src="../js/jquery.ui.datepicker.js"></script>

<script type="text/javascript" src="../js/jquery.autocomplete.js"></script>

<script type="text/javascript" src="../js/jquery.validate.js"></script>

<script type="text/javascript" src="../js/paging.js"></script>

<script type="text/javascript" src="../js/ddaccordion.js"></script>

<script type="text/javascript" src="../js/js.js"></script>

<script type="text/javascript">

$(document).ready(function(){

	

	$(function() {

		$("#vdate").datepicker({

			changeMonth: true,

			changeYear: true,

			dateFormat: 'dd-mm-yy'

		});

	});

	$(function() {

		$("#cheq_date").datepicker({

			changeMonth: true,

			changeYear: true,

			dateFormat: 'dd-mm-yy'

		});

	});

});

</script>



<SCRIPT LANGUAGE="JavaScript">

<!--// Hide script from non-javascript browsers.

// Load Page Into Parent Window

// Version 1.0

// Last Updated: May 18, 2000

// Code maintained at: http://www.moock.org/webdesign/javascript/

// Copy permission granted any use provided this notice is unaltered.

// Written by Colin Moock.





function loadinparent(url, closeSelf){

	self.opener.location = url;

	if(closeSelf) self.close();

	}



//-->

</SCRIPT>

<?

auto_complete_from_db('accounts_ledger','concat(ledger_name,"#>",ledger_id)','concat(ledger_name,"#>",ledger_id)','1 and  group_for = "'.$_SESSION['user']['group'].'"  and parent=0 order by ledger_name','ledger_new1');

auto_complete_from_db('accounts_ledger','concat(ledger_name,"#>",ledger_id)','concat(ledger_name,"#>",ledger_id)','1 and  group_for = "'.$_SESSION['user']['group'].'"  and parent=0 order by ledger_name','ledger_new2');

?>

<style>

body{

font-family:Verdana, Arial, Helvetica, sans-serif;

font-size:12px;}



.btn_p{

font-family:Verdana, Arial, Helvetica, sans-serif;

font-size:12px;

width:130px;

background-color:0baabf;

border:2px solid #9cd7df;

border-collapse:collapse;

text-align:center;

color:#FFFFFF;

padding:3px;

text-decoration:none;

}

.btn_p a{

background-color:0baabf;

color:#FFFFFF;

text-decoration:none;

padding:3px;

}

.btn_p a:hover{

background-color:0baabf;

color:#000000;

text-decoration:none;

padding:3px;

}

.btn_p1{

font-family:Verdana, Arial, Helvetica, sans-serif;

font-size:12px;

width:160px;

background-color:0baabf;

border:2px solid #9cd7df;

border-collapse:collapse;

text-align:center;

color:#FFFFFF;

padding:2px;

text-decoration:none;

}

.btn_p1 a{

background-color:0baabf;

color:#FFFFFF;

text-decoration:none;

padding:3px;

}

.btn_p1 a:hover{

background-color:0baabf;

color:#000000;

text-decoration:none;

padding:3px;

}



.report_font{

font-family:Verdana, Arial, Helvetica, sans-serif;

font-size:12px;

background-color:#fefee6;

}

tr {

	font-family:Verdana, Arial, Helvetica, sans-serif;

	font-size:12px;

	color: #4f6b72;

	padding:3px;

}

td{

padding:3px;}



tr.spec {

	font-family:Verdana, Arial, Helvetica, sans-serif;

	font-size:12px;

	background: #e9f4f8;

	color: #4f6b72;

}



tr.spec:hover{

	font-family:Verdana, Arial, Helvetica, sans-serif;

	font-size:12px;

	background: #F4F5F6;

	color: #4f6b72;

}

</style>

	  <form action="" method="post" name="form2" onsubmit="return validate_total()">

      <table width="99%" border="1" align="center" style="border-collapse:collapse;" bordercolor="#c1dad7" id="vbig">

        <tr>

          <td>

		  <table width="100%" border="0" align="center" bordercolor="#0099FF" bgcolor="#D9EFFF" cellspacing="0">

              <tr>

                <td width="12%" height="20" align="right">Received From:</td>

                <td width="22%" align="left"><?php echo $data1[1];?>&nbsp;</td>

                <td width="9%" align="right" valign="top">Purpose:</td>

                <td width="28%" align="left" valign="top"><?php echo $data1[0];?>&nbsp;</td>

                <td align="right">Voucher Date:</td>

                <td align="left"><input name="vdate" id="vdate" type="text" value="<?php echo $data1[4];?>" /></td>

              </tr>

              <tr>

                <td height="20" align="right">Chaque No: </td>

                <td height="20" align="left"><input name="cheq_no" id="cheq_no" type="text" value="<?php echo $data1[1];?>" /></td>

                <td width="9%" align="right" valign="top">Chaque Date: </td>

                <td width="28%" align="left" valign="top"><input name="cheq_date" id="cheq_date" type="text" value="<?=($data1[2]>943898400)?(date("d-m-Y",$data1[2])):'';?>" /></td>

                <td width="12%" align="right">Voucher  No:</td>

                <td width="17%" align="left"><?php echo $v_no;?>&nbsp;</td>

              </tr>

          </table>



		  </td>

        </tr>

        <tr>

          <td valign="top"><table width='100%' border="1" bordercolor="#c1dad7" bgcolor="#FFFFFF" style="border-collapse:collapse">

              <tr align="center">

                <td>S/L</td>

                <td>A/C Ledger</td>

                <td>Narration</td>

                <td>Debit</td>

                <td>Credit</td>

              </tr>

<?php

$pi=0;

$d_total=0;

$c_total=0;

 $sql2="select a.dr_amt,a.cr_amt,b.ledger_name,b.ledger_id,a.narration,a.id from accounts_ledger b, journal a where a.ledger_id=b.ledger_id and a.tr_from = '$tr_from' and a.jv_no='$jv_no' and a.ledger_id>0";

$data2=db_query($sql2);





while($info=mysqli_fetch_row($data2)){ $pi++;

$entry[$pi] = $info[5];

auto_complete_from_db('accounts_ledger','concat(ledger_name,"#>",ledger_id)','concat(ledger_name,"#>",ledger_id)','1 and  group_for = "'.$_SESSION['user']['group'].'"  and parent=0 order by ledger_name','ledger_'.$info[5]);



			  

			  

			  if($info[0]==0) $type='Credit';

			  else $type='Debit';

			  $d_total=$d_total+$info[0];

			  $c_total=$c_total+$info[1];

			  ?>

              <tr align="center" <? if(++$x%2!=0) echo 'class="spec"';?>>

                <td><?=$pi;?></td>

                <td><input type="text" name="ledger_<?=$info[5]?>" id="ledger_<?=$info[5]?>" style="width:250px;" value="<?=$info[2].'#>'.$info[3];?>"  /></td>

          <td>

          <input type="text" name="narration_<?=$info[5];?>" id="narration_<?=$info[5];?>" style="width:300px;" value="<?=$info[4];?>" />

          <input type="hidden" name="l_<?=$pi;?>" id="l_<?=$pi;?>" value="<?=$info[3];?>" />		  </td>

                <td><div align="right">

                  <label>

                  <input name="dr_amt_<?=$info[5];?>" type="text" id="dr_amt_<?=$info[5];?>" value="<?=$info[0]?>" style="width:80px;" onchange="add_sum()" />

                  </label></div></td>

                <td><div align="right">

                  <input name="cr_amt_<?=$info[5];?>" type="text" id="cr_amt_<?=$info[5];?>" value="<?=$info[1]?>" style="width:80px;" onchange="add_sum()" />

                  </div></td>

              </tr>

			  

			  

			  

			  

			  

			  

<?php /*?>			  

               <tr align="center" <? if(++$x%2!=0) echo 'class="spec"';?>>

                 <td align="right"><div align="center">

                   <?=$pi;?>

                 </div></td>

                 <td><input type="text" name="ledger_new1" id="ledger_new1"  style="width:250px;" value="" /></td>

                 <td align="center"><input type="text" name="narration_new1" id="narration_new1" style="width:300px;" value="" /></td>

                 <td align="right"><input name="dr_amt_new1" type="text" id="dr_amt_new1" style="width:80px;" onchange="add_sum()" /></td>

                 <td align="right"><input name="cr_amt_new1" type="text" id="cr_amt_new1" style="width:80px;" onchange="add_sum()" /></td>

               </tr>

			   

			   <tr align="center" <? if(++$x%2!=0) echo 'class="spec"';?>>

                 <td align="right"><div align="center">

                   <?=$pi;?>

                 </div></td>

                 <td><input type="text" name="ledger_new2" id="ledger_new2"  style="width:250px;" value="" /></td>

                 <td align="center"><input type="text" name="narration_new2" id="narration_new2" style="width:300px;" value="" /></td>

                 <td align="right"><input name="dr_amt_new2" type="text" id="dr_amt_new2" style="width:80px;" onchange="add_sum()" /></td>

                 <td align="right"><input name="cr_amt_new2" type="text" id="cr_amt_new2"  style="width:80px;" onchange="add_sum()" /></td>

               </tr><?php */?>

			   

			   

			  

			  

			  

			  

			  

			  

			  

			  

			  

<?php }



?>

               <tr align="center" <? if(++$x%2!=0) echo 'class="spec"';?>>

                 <td align="right"><div align="center">

                   <?=++$pi;?>

                 </div></td>

                 <td><input type="text" name="ledger_new1" id="ledger_new1"  style="width:250px;" value="" /></td>

                 <td align="center"><input type="text" name="narration_new1" id="narration_new1" style="width:300px;" value="" /></td>

                 <td align="right"><input name="dr_amt_new1" type="text" id="dr_amt_new1" style="width:80px;" onchange="add_sum()" /></td>

                 <td align="right"><input name="cr_amt_new1" type="text" id="cr_amt_new1" style="width:80px;" onchange="add_sum()" /></td>

               </tr>

			   

			   <tr align="center" <? if(++$x%2!=0) echo 'class="spec"';?>>

                 <td align="right"><div align="center">

                   <?=++$pi;?>

                 </div></td>

                 <td><input type="text" name="ledger_new2" id="ledger_new2"  style="width:250px;" value="" /></td>

                 <td align="center"><input type="text" name="narration_new2" id="narration_new2" style="width:300px;" value="" /></td>

                 <td align="right"><input name="dr_amt_new2" type="text" id="dr_amt_new2" style="width:80px;" onchange="add_sum()" /></td>

                 <td align="right"><input name="cr_amt_new2" type="text" id="cr_amt_new2"  style="width:80px;" onchange="add_sum()" /></td>

               </tr>

			   

			   

			   

	

			   

			   

			   

               

              <tr align="center">

                <td colspan="3" align="right">Total Amount :</td>

                <td><div align="right"><input name="dr_amt" type="text" id="dr_amt" value="<?=$d_total?>" style="width:80px;" readonly="readonly"/></div></td>

                <td><div align="right"><input name="cr_amt" type="text" id="cr_amt" value="<?=$c_total?>" style="width:80px;" readonly="readonly" /></div></td>

              </tr>

          </table></td>

        </tr>

      </table>

      <br />

<?php

//page select

if($vtype=='receipt'||$vtype=='Receipt') $page="credit_note.php?v_no=$v_no&v_type=$vtype&v_d=$vdate&action=edit";

if($vtype=='payment'||$vtype=='Payment') $page="debit_note.php?v_no=$v_no&v_type=$vtype&v_d=$vdate&action=edit";

if($vtype=='coutra'||$vtype=='Coutra') $page="coutra_note_new.php?v_no=$v_no&v_type=$vtype&v_d=$vdate&action=edit";

if($vtype=='journal_info'||$vtype=='Journal_info') $page="journal_note_new.php?v_no=$v_no&v_type=$vtype&v_d=$vdate&action=edit";

if($vtype=='Purchase'||$vtype=='journal') $page="journal_note_new.php?v_no=$v_no&v_type=$vtype&v_d=$vdate&action=edit";



//end

?>

<div align="center" style="margin-top:10px;">

<table border="0" cellspacing="0" cellpadding="0" align="center" style="width:400px;">

  <tr>

    <td><input class="btn_p1" name="narr" type="submit" value="Update Voucher" onmouseover="this.style.cursor='pointer';"/></td>

    <td><input class="btn_p1" name="change" type="submit" value="Change Date" onmouseover="this.style.cursor='pointer';" /></td>

    <td><? if($_SESSION['user']['level']==5){?>

<input class="btn_p1" name="delete" type="submit" value="Delete Voucher" onmouseover="this.style.cursor='pointer';" onclick="return confirm('Are you sure to delete this voucher?');" />

      <? }?></td>

    </tr>

  <tr>

    <td><div class="btn_p">

      <div align="center"><a href="voucher_print.php?v_type=<?php echo $_REQUEST['v_type'];?>&vo_no=<?php echo $jv_no;?>" target="_blank">Print This Invoice</a></div>

    </div></td>

    <td>&nbsp;</td>

    <td><div class="btn_p">

	  <div align="center"><a href="javascript:loadinparent('<?php echo $page;?>', true);this.close();">Re-Entry Voucher</a></div>

	</div></td>

    </tr>

</table>

</div>

<?php

}

?>

<script type="application/javascript">

function add_sum()

{

var dr_amt_new1 = ((document.getElementById('dr_amt_new1').value)*1)+0;

var dr_amt_new2 = ((document.getElementById('dr_amt_new2').value)*1)+0;

var cr_amt_new1 = ((document.getElementById('cr_amt_new1').value)*1)+0;

var cr_amt_new2 = ((document.getElementById('cr_amt_new2').value)*1)+0;

var dr_total = dr_amt_new1;

var cr_total = cr_amt_new1;





if(cr_amt_new2>0){

cr_total = cr_total + cr_amt_new2;}

if(dr_amt_new2>0){

dr_total = dr_total + dr_amt_new2;}

<?

for($i=1;$i<=$pi;$i++){

if($entry[$i]>0){

echo "cr_total = cr_total+((document.getElementById('cr_amt_".$entry[$i]."').value)*1);";

echo "dr_total = dr_total+((document.getElementById('dr_amt_".$entry[$i]."').value)*1);";

}}

?>



document.getElementById('cr_amt').value = cr_total.toFixed(2);

document.getElementById('dr_amt').value = dr_total.toFixed(2);

}

function validate_total() {

var dr_amt = ((document.getElementById('dr_amt').value)*1);

var cr_amt = ((document.getElementById('cr_amt').value)*1);

if(dr_amt==cr_amt)

return true;

else

{

alert('Debit and Credit have to be equal.Please Re-Check This voucher.');

return false;

}

}

function loadinparent(url)

{

	self.opener.location = url;

	self.blur(); 

}

</script>

<input name="count" id="count" type="hidden" value="<?=$pi;?>" />

</form>