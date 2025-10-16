<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Work Order Advence Reports';
$target_url = '../report/bill_print_new.php';
do_calander("#bill_date");



if($_POST['chalan_no']!='')
{
$sql = "select 1 from lc_workorder_chalan where chalan_no in ('".$_POST['chalan_no']."')";
$query = db_query($sql);
$count = mysqli_num_rows($query);
if($count>0)
{
 $csql = "INSERT INTO `sale_chalan_bill` (`chalan_no`, `entry_at`, `entry_by`, `delete`, `bill_date`) VALUES ('".$_POST['chalan_no']."', '".date('Y-m-d h:s:i')."', '".$_SESSION['user']['id']."', 'NO', '".$_POST['bill_date']."')";
 db_query($csql);
}
}
?>
<script language="javascript">
function custom(theUrl)
{
	window.open('<?=$target_url?>?v_no='+theUrl);
}
</script>
<form action="" method="post" name="form1" target="" id="form1">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><div class="box4">
          <table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
            <tr>
              <td>&nbsp;</td>
              <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
				  <tr>
				    <td>Bill Date </td>
				    <td><label>
				      <input name="bill_date" type="text" id="bill_date" />
				    </label></td>
			      </tr>
				  <tr>
                    <td>Create Bill for Chalan  No(s): </td>
                    <td><input  name="chalan_no" type="text" id="chalan_no" value="" style="width:400px;"/></td>
                  </tr>
                  

              </table></td>
            </tr>
          </table>
      </div></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><div class="box">
        <table width="1%" border="0" cellspacing="0" cellpadding="0" align="center">
            <tr>
              <td><input name="submit" type="submit" class="btn" value="Create Bill" /></td>
            </tr>
          </table>
      </div></td>
    </tr>
  </table>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td><div class="tabledesign2">
<? 
$res='select  id,id as bill_no, bill_date,entry_at,(select fname from user_activity_management where user_id=entry_by) as entry_by,`delete` as `cancel`	 from sale_chalan_bill where  entry_by = '.$_SESSION['user']['id'].' order by id';
echo link_report($res,'mr_print_view.php');
?>
</div></td>
</tr>
</table>
</form>
<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>