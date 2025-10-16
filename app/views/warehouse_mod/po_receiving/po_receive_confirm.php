<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='QC Approval';



do_calander('#fdate');

do_calander('#tdate');
$tr_type="Show";


$table = 'purchase_master';

$unique = 'pr_no';

$status = 'QC Proccess';

$target_url = '../po_receiving/pr_receive.php';



if($_REQUEST[$unique]>0)

{

$_SESSION[$unique] = $_REQUEST[$unique];

header('location:'.$target_url);

}


$tr_from="Warehouse";
?>

<script language="javascript">

function custom(theUrl)

{

	window.open('<?=$target_url?>?<?=$unique?>='+theUrl);

}

</script>





<div class="form-container_large">
    <form action="" method="post" name="codz" id="codz">
            
        <div class="container-fluid bg-form-titel">
            <div class="row">
                <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">From Date: </label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <input type="text" name="fdate" id="fdate" value="<?=isset($_POST['fdate'])?$_POST['fdate']:date('Y-m-01');?>" />
                        </div>
                    </div>

                </div>
                <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">To Date:</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <input type="text" name="tdate" id="tdate"  value="<?=isset($_POST['tdate'])?$_POST['tdate']:date('Y-m-d');?>" />

                        </div>
                    </div>
                </div>

                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                   
                    <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" class="btn1 btn1-submit-input"/>
                </div>

            </div>
        </div>





        <div class="container-fluid pt-5 p-0 ">

            <?

            if(isset($_POST['submitit'])){

            if($_POST['fdate']!=''&&$_POST['tdate']!='')

    $con .= 'and a.rec_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
	
  // $res='select a.po_no,a.rec_date,a.entry_by,a.entry_at,a.pr_no,sum(a.amount)as amount ,a.status,a.vendor_id from purchase_receive a,purchase_master m  where 1  '.$con.' and a.po_no=m.po_no and  a.status="QC Proccess" GROUP BY  a.pr_no ';
        $res='select a.po_no,a.rec_date,a.entry_by,a.entry_at,a.pr_no,sum(a.amount)as amount ,a.status,a.vendor_id from purchase_receive a,purchase_master m,requisition_master r  where 1  '.$con.' and a.po_no=m.po_no and m.req_no=r.req_no   and  a.status="PENDING" GROUP BY  a.pr_no ';

            $query = db_query($res);

            //echo link_report($res,'po_print_view.php');
            ?>


                <table class="table1  table-striped table-bordered table-hover table-sm">
                    <thead class="thead1">
                    <tr class="bgc-info">
                        <th>Po No</th>
                        <th>MRR No </th>
						<th>Vendor Name </th>
                        <th>Received</th>

                        <th>Entry By</th>
                        <th>Entry At</th>
						 <th>Total Amount</th>
						  <th>Status</th>
                        <th>Action </th>

                    </tr>
                    </thead>

                    <tbody class="tbody1">

                    <?
                    while($row = mysqli_fetch_object($query)){
                        ?>

                        <tr>
                            <td><?=$row->po_no?></td>
                            <td><?=$row->pr_no?></td>
							 <td><?=find_a_field('vendor','vendor_name','vendor_id='.$row->vendor_id)?></td>
                            <td><?=$row->rec_date?></td>
                            <td><?=$row->entry_by?></td>
                            <td><?=$row->entry_at?></td>
							<td><?=$row->amount?></td>
							<td><?=$row->status?></td>
							   
							
  <td>
  
<?php /*?>  <input type="submit" name="submitit" id="submitit" value="RECEIVED" class="btn1 btn1-submit-input" onclick="custom(<?=$row->pr_no?>);" /><?php */?>
							
							
						<a class="btn1 btn1-submit-input" href="pr_receive.php?pr_no=<?=$row->pr_no?>">Approve</a>

							
						</td>
							


                        </tr>

                    <? } ?>

                    </tbody>
                </table>

                <? } ?>


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

          <input type="text" name="fdate" id="fdate" style="width:107px;" value="<?=isset($_POST['fdate'])?$_POST['fdate']:date('Y-m-01');?>" />

        </strong></td>

        <td align="center" bgcolor="#FF9966"><strong> -to- </strong></td>

        <td width="1" bgcolor="#FF9966"><strong>

          <input type="text" name="tdate" id="tdate" style="width:107px;" value="<?=isset($_POST['tdate'])?$_POST['tdate']:date('Y-m-d');?>" />

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

$con .= 'and a.po_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';



  $res='select  a.po_no,a.po_no, DATE_FORMAT(a.po_date, "%d-%m-%Y") as po_date,   v.vendor_name as party_name,c.fname as entry_by, a.checked_at from purchase_master a,warehouse b,user_activity_management c, vendor v where  a.warehouse_id=b.warehouse_id and a.entry_by=c.user_id and a.vendor_id=v.vendor_id  and a.status="CHECKED"  '.$con.' order by a.po_no DESC';

echo link_report($res,'po_print_view.php');



}

?>

</div>

</td>

</tr>

</table>

</div><?php */?>




<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>