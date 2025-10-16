<?php
require_once "../../../assets/template/layout.top.php";
$title='Unapproved Work Order List';

do_calander('#fdate');
do_calander('#tdate');

$table = 'purchase_master';
$unique = 'po_no';
$status = 'UNCHECKED';
$target_url = '../po/po_checking.php';

if($_POST[$unique]>0)
{
$_SESSION[$unique] = $_POST[$unique];
header('location:'.$target_url);
}

$target_url = '../po/po_checking.php';

?>



<div class="form-container_large">
<form action="" method="post" name="codz" id="codz">
  <table width="70%" border="0" align="center">
	
	
	
	
	
    <tr>
      <td width="30%">&nbsp;</td>
      <td colspan="10%">&nbsp;</td>
      <td width="30%">&nbsp;</td>
    </tr>
    <tr>
      <td align="right" bgcolor="#249CF2" style="color: black"><strong>Date Interval :</strong></td>
      <td width="20%" bgcolor="#249CF2"><strong>
        <input type="text" name="fdate" id="fdate" style="width:80px;" value="<?=$_POST['fdate']?>" />
      </strong></td>
      <td width="7%" bgcolor="#249CF2" style="color:black;"><strong> -to- </strong></td>
      <td width="8%" bgcolor="#249CF2"><strong>
        <input type="text" name="tdate" id="tdate" style="width:80px; color: white" value="<?=$_POST['tdate']?>" />
      </strong></td>
      <td rowspan="2" bgcolor="#249CF2"><strong>
        <input type="submit" name="submitit2" id="submitit2" value="VIEW DETAIL" style="width:170px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
      </strong></td>
    </tr>
    <tr>
      <td align="right" bgcolor="#249CF2" style="color: black;"><strong>Concern  :</strong></td>
      <td colspan="3" bgcolor="#249CF2">
	  <select name="group_for" id="group_for" style="width:240px;" >
            <option></option>
            <? foreign_relation('user_group','id','group_name',$_POST['group_for']);?>
          </select>	  </td>
      </tr>
  </table>
</form>


<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td><div class="tabledesign2">
<table width="100%" cellspacing="0" cellpadding="0" id="grp"><tbody>
<tr>
  <th>WO No</th>
  <th>WO Date</th>
  <th>Party  Name</th>
  <th>WO Amount </th>
  <th>Concern</th>
  <th>Action</th>
  </tr>


<? 



if($_POST['fdate']!=''&&$_POST['tdate']!='') $con .= ' and m.po_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';



if($_POST['group_for']!='') $group_con .= ' and m.group_for = "'.$_POST['group_for'].'"';



 $res="select m.po_no, m.po_date, concat(v.vendor_id,'- ',v.vendor_name) as vendor_name, sum(i.amount) as amount, u.group_name
from purchase_master m, purchase_invoice i, vendor v, user_group u
where m.status in ('UNCHECKED WO') and v.vendor_id=m.vendor_id and m.po_no=i.po_no and m.group_for=u.id ".$con.$group_con." group by m.po_no";
$query = mysql_query($res);
while($data = mysql_fetch_object($query))
{
?>
<tr <?=($data->amount>0)?'style="background-color:#FFCCFF"':'';?>>
<td onClick="custom(<?=$data->po_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=$data->po_no;?></td>
<td onClick="custom(<?=$data->po_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=date("d-m-Y",strtotime($data->po_date));?></td>
<td onClick="custom(<?=$data->po_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=$data->vendor_name;?></td>
<td onClick="custom(<?=$data->po_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp; <?=number_format($data->amount,2);?></td>
<td onClick="custom(<?=$data->po_no;?>);" <?=(++$z%2)?'':'class="alt"';?>><?=$data->group_name;?></td>
<td><? if($data->amount>0&$data->po_date==date('Y-m-d')){?>
<a style="display:inline-block; font-size:14px; font-weight:700; " href="po_checking.php?po_no=<?=$data->po_no;?>">open</a><? }?></td>
</tr>
<?
$total_po_amt = $total_po_amt + $data->amount;

}

?>
<tr class="alt"><td><span style="text-align:right;"> Total: </span></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td><?=number_format($total_po_amt,2);?></td>
  <td colspan="0">&nbsp;</td>
  <td>&nbsp;</td>
  </tr>

</tbody></table>
</div></td>
</tr>
</table>

</div>

<?
require_once "../../../assets/template/layout.bottom.php";
?>