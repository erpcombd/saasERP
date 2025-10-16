<?php

require_once "../../../assets/template/layout.top.php";

$title='QC Receive Report';



do_calander('#fdate');

do_calander('#tdate');

do_datatable('grp');



$table = 'purchase_master';

$unique = 'po_no';

$status = 'CHECKED';

$target_url = '../pr_packing_mat/chalan_view2.php';



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
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Date Interval :</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <input type="text" name="fdate" id="fdate"  value="<?=($_POST['fdate']!='')?$_POST['fdate']:date('Y-m-01');?>" />
                        </div>
                    </div>

                </div>
                <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">-to-</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <input type="text" name="tdate" id="tdate"  value="<?=($_POST['tdate']!='')?$_POST['tdate']:date('Y-m-d');?>" />

                        </div>
                    </div>
                </div>
				

                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
					 <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" class="btn1 btn1-submit-input" />
                </div>

            </div>
        </div>






          
        <div class="container-fluid pt-5 p-0 ">

                <table id="grp" class="table1  table-striped table-bordered table-hover table-sm">
                    <thead class="thead1">
                    <tr class="bgc-info">
                        <th>SL No</th>
						<th>QC No</th>
                        <th>PO No</th>
                        <th>Rec Date</th>

                        <th>Party Name</th>
                        <th>Warehouse</th>

                        <th>Entry BY</th>
                        <th>Entry At</th>
                        <th>Action</th>
                    </tr>
                    </thead>
					
                    <tbody class="tbody1">
					<? 


if($_POST['fdate']!='') {$con='  and a.rec_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';}

else{$con=' and a.rec_date between "'.date('Y-m-01').'" and "'.date('Y-m-d').'"';}

$i=1;

   $res='select a.qc_no,a.po_no, a.rec_date, v.vendor_name as party_name,b.warehouse_name as warehouse,round(sum(amount),2) as Total,u.fname as entry_by,a.entry_at 

from qc_receive_purchase a,warehouse b, vendor v,user_activity_management u

where u.user_id=a.entry_by and a.warehouse_id=b.warehouse_id and  a.vendor_id=v.vendor_id   '.$con.' group by a.qc_no order by a.qc_no desc';

$query = mysql_query($res);
while($data = mysql_fetch_object($query)){
?>

                        <tr>
                            <td><?=$i++?></td>
                            <td><?=$data->qc_no?></td>
                            <td><?=$data->po_no?></td>

                            <td><?=$data->rec_date?></td>
                            <td><?=$data->party_name?></td>

                            <td><?=$data->warehouse?></td>
                            <td><?=$data->entry_by?></td>
							<td><?=$data->entry_at?></td>
                            <td><a href="chalan_view2.php?qc_no=<?=$data->qc_no?>" target="_blank"><input type="button" class="bgc-info" value="View" /></a></td>

                        </tr>
						<?php } ?>

                    </tbody>
                </table>




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

        <td   bgcolor="#FF9966"><strong>

          <input type="text" name="fdate" id="fdate" style="width:107px;" value="<?=($_POST['fdate']!='')?$_POST['fdate']:date('Y-m-01');?>" />

        </strong></td>

        <td align="center" bgcolor="#FF9966"><strong> -to- </strong></td>

        <td  bgcolor="#FF9966"><strong>

          <input type="text" name="tdate" id="tdate" style="width:107px;" value="<?=($_POST['tdate']!='')?$_POST['tdate']:date('Y-m-d');?>" />

        </strong></td>

        <td bgcolor="#FF9966"><strong>

          <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#090"/>

        </strong></td>

      </tr>

    </table>

  </form>
  </div>

  <table style="cursor:pointer" width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td><div class="tabledesign2">
<table width="100%" cellspacing="0" cellpadding="0" id="grp">
<thead>
<tr>

<th class="text-center">SL No</th>
<th class="text-center">QC No</th>
<th class="text-center">PO NO</th>
<th class="text-center">Rec Date</th>
<th class="text-center">Party Name</th>
<th class="text-center">Warehouse</th>
<th class="text-center">Entry BY</th>
<th class="text-center">Entry At</th>
<th>Action</th>

 </tr>
 </thead>
 <tbody>

<? 


if($_POST['fdate']!='') {$con='  and a.rec_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';}

else{$con=' and a.rec_date between "'.date('Y-m-01').'" and "'.date('Y-m-d').'"';}

$i=1;

   $res='select a.qc_no,a.po_no, a.rec_date, v.vendor_name as party_name,b.warehouse_name as warehouse,round(sum(amount),2) as Total,u.fname as entry_by,a.entry_at 

from qc_receive_purchase a,warehouse b, vendor v,user_activity_management u

where u.user_id=a.entry_by and a.warehouse_id=b.warehouse_id and  a.vendor_id=v.vendor_id   '.$con.' group by a.qc_no order by a.qc_no desc';

$query = mysql_query($res);
while($data = mysql_fetch_object($query)){
?>

<tr>

<td class="text-center"><?=$i++?></td>
<td class="text-center"><?=$data->qc_no?></td>
<td class="text-center"><?=$data->po_no?></td>
<td class="text-center"><?=$data->rec_date?></td>
<td class="text-center"><?=$data->party_name?></td>
<td class="text-center"><?=$data->warehouse?></td>
<td class="text-center"><?=$data->entry_by?></td>
<td class="text-center"><?=$data->entry_at?></td>
<td><a href="chalan_view2.php?qc_no=<?=$data->qc_no?>" target="_blank"><input type="button" class="btn btn-success" value="View" /></a></td>
</tr>
<?php } ?>

</tbody></table>
</div></td>
</tr>
</table><?php */?>

<?

require_once "../../../assets/template/layout.bottom.php";

?>