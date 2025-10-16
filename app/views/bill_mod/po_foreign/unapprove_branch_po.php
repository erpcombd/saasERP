<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Unapproved Purchased';



$table = 'purchase_master';

$unique = 'po_no';

$status = 'UNCHECKED';
do_calander('#fdate');
do_calander('#tdate');
$target_url = '../po/branch_po_checking.php';

unset($_SESSION[$unique]);

if($_POST[$unique]>0)

{

$_SESSION[$unique] = $_POST[$unique];

header('location:'.$target_url);

}



?>
<div class="form-container_large">

<form action="" method="post" name="codz" id="codz">
    <table width="80%" border="0" align="center">
      <tr>
        <td align="center"><?=$_SESSION['msgs'];unset($_SESSION['msgs']);?></td>
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

<th class="text-center">PO No</th>

<th class="text-center"> PO Date</th>
<th class="text-center"> Vendor Name</th>
<th class="text-center">Entry By</th>
<th class="text-center">Action</th>

 </tr>


 <? 
 if($_POST['fdate']!='') {
 $con=' and a.po_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';

 }

 else{
 $con=' and a.po_date between "'.date('Y-m-o1').'" and "'.date('Y-m-d').'"';

 }

      $res ='select a.po_no,a.entry_by,a.po_date,a.vendor_id,u.fname
 
  from purchase_master a,user_activity_management u
  
  where a.entry_by=u.user_id  and  a.status="BRANCH_PO" '.$con.' order by a.po_no desc';
 
// $res= 'select p.po_no,p.entry_by,p.po_date,u.fname
// 
// from purchase_master p,vendor v,user_activity_management u
// 
// where p.vendor_id=v.vendor_id and p.status="MANUAL" and v.vendor_category=1 and p.entry_by=u.user_id and p.po_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
$query = db_query($res);
while($data = mysqli_fetch_object($query)){
?>
<tr>
<td class="text-center"><?=$data->po_no?></td>
<td class="text-center"><?=$data->po_date?></td>
<td class="text-center"><?=find_a_field('vendor','vendor_name','vendor_id="'.$data->vendor_id.'"');$data->vendor_id?></td>
<td class="text-center"><?=$data->fname?></td>
<!--<td class="text-center"><a href="../po/po_checking.php?po_no=<?=$data->po_no?>"><button class="btn btn-success btn-sm">Complete PO</button></a></td>-->
<td style="text-align:center"><!--<input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" class="btn btn-success btn-sm" />-->
<a href="../po/po_checking.php?po_no=<?=$data->po_no?>"><button class="btn btn-success btn-sm">VIEW DETAIL</button></a></td>

</tr>
<?php } ?>

</tbody></table>
</div></td>
</tr>
</table>

</div>



<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>