<?php
require_once "../../../assets/template/layout.top.php";
$title='POS Purchase Status';

do_calander('#fdate');
do_calander('#tdate');

$table = 'purchase_master';
$unique = 'po_no';
$status = 'CHECKED';
$target_url = '../other_receive/chalan_view2.php';

if($_REQUEST[$unique]>0)
{
$_SESSION[$unique] = $_REQUEST[$unique];
header('location:'.$target_url);
}

?>
<script language="javascript">
function custom(theUrl)
{
	window.open('<?=$target_url?>?v_no='+theUrl);
}
</script>



<div class="form-container_large">
    
    <form action="" method="post" name="codz" id="codz">
         
        <div class="container-fluid bg-form-titel">
            <div class="row">
                <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">From Date:</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <input type="text" name="fdate" id="fdate"  value="<?=date('Y-m-01')?>"autocomplete="off" />
                        </div>
                    </div>

                </div>
                <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">To Date:</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <input type="text" name="tdate" id="tdate"  value="<?=date('Y-m-d')?>" autocomplete="off"/>
                        </div>
                    </div>
                </div>

                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                    
                    <input type="submit" name="submitit" id="submitit" value="VIEW PRODUCT" class="btn1 btn1-submit-input"/ >
                </div>

            </div>
        </div>






        <div class="container-fluid pt-5 p-0 ">
            <?
            if(isset($_POST['submitit'])){


                if($_POST['fdate']!=''&&$_POST['tdate']!='')
                    $con .= 'and a.or_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';

                 $res='select  a.or_no,a.or_no as lp_no,a.or_date as lp_date, a.vendor_name as purchase_from,a.requisition_from,sum(amount) as Total,a.entry_at,c.fname as user,a.status from warehouse_other_receive a,warehouse_other_receive_detail b, user_activity_management c where a.or_no=b.or_no and a.entry_by=c.user_id and a.warehouse_id = "'.$_SESSION['user']['depot'].'" and a.receive_type = "Local Purchase" '.$con.' group by a.or_no order by a.or_no desc';
                //echo link_report($res,'po_print_view.php');
                $query = mysql_query($res);
                ?>

                <table class="table1  table-striped table-bordered table-hover table-sm">
                    <thead class="thead1">
                    <tr class="bgc-info">
                        <th>Lp No</th>
                        <th>Lp Date</th>
                        <th>Purchase From</th>

                        <th>Requisition From</th>
                        <th>Total</th>
                        <th>Entry At</th>

                        <th>User</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>

                    <tbody class="tbody1">


                    <?
                    while($lps = mysql_fetch_object($query)){
                    ?>

                        <tr>
                            <td><?=$lps->lp_no?></td>
                            <td><?=$lps->lp_date?></td>
                            <td><?=$lps->purchase_from?></td>

                            <td><?=$lps->requisition_from?></td>
                            <td><?=$lps->Total?></td>
                            <td><?=$lps->entry_at?></td>

                            <td><?=$lps->user?></td>
                            <td><?=$lps->status?></td>
                            <td>
								<button type="submit" name="submitit" id="submitit" value="View"  onclick="custom(<?=$lps->lp_no?>);" class="btn2 btn1-bg-submit">
									<i class="fa-solid fa-eye"></i>
								</button>
							</td>

                        </tr>
                    <?}?>

                    </tbody>
                </table>



            <?}?>

        </div>
    </form>
</div>
















<?php /*?><div class="form-container_large">
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
          <input type="text" name="fdate" id="fdate" style="width:100px;" value="<?=date('Y-m-01')?>" />
        </strong></td>
        <td align="center" bgcolor="#FF9966"><strong> -to- </strong></td>
        <td width="1" bgcolor="#FF9966"><strong>
          <input type="text" name="tdate" id="tdate" style="width:100px;" value="<?=date('Y-m-d')?>" />
        </strong></td>
        <td bgcolor="#FF9966"><strong>
          <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" class="btn1 btn1-submit-input"/>
        </strong></td>
      </tr>
    </table>
  </form>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<div class="tabledesign2">
<? 
if(isset($_POST['submitit'])){


if($_POST['fdate']!=''&&$_POST['tdate']!='')
$con .= 'and a.or_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';

 $res='select  a.or_no,a.or_no as lp_no,a.or_date as lp_date, a.vendor_name as purchase_from,a.requisition_from,sum(amount) as Total,a.entry_at,c.fname as user,a.status from warehouse_other_receive a,warehouse_other_receive_detail b, user_activity_management c where a.or_no=b.or_no and a.entry_by=c.user_id and a.warehouse_id = "'.$_SESSION['user']['depot'].'" and a.receive_type = "Local Purchase" '.$con.' group by a.or_no order by a.or_no desc';
echo link_report($res,'po_print_view.php');

}
?>
</div>

</td>
</tr>
</table>
</div><?php */?>

<?
require_once "../../../assets/template/layout.bottom.php";
?>