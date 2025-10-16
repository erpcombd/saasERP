<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Requisition Status';



do_calander('#fdate');

do_calander('#tdate');



$table = 'requisition_master';

$unique = 'req_no';

$status = 'UNCHECKED';

$target_url = 'mr_print_view.php';


if($_GET['vStatus']>0){


db_query('update requisition_master set vendor_status="Yes" where req_no='.$_GET['vStatus'].'');

echo "<script>window.top.location='mr_pending.php'</script>";
}


?>

<script language="javascript">

function custom(theUrl)

{

	window.open('<?=$target_url?>?<?=$unique?>='+encodeURIComponent(theUrl));

}

</script>





<div class="form-container_large">

    

    <form action="" method="post" name="codz" id="codz">

            

        <div class="container-fluid bg-form-titel">

            <div class="row">

                <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">

                    <div class="form-group row m-0">

                        <label class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Date From:</label>

                        <div class="col-sm-7 col-md-7 col-lg-7 col-xl-7 p-0">

                            <input type="text" name="fdate" id="fdate"  value="<? if($_POST['fdate']!='') echo $_POST['fdate']; else echo date('Y-m-01')?>" />

                        </div>

                    </div>



                </div>

				<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">

                    <div class="form-group row m-0">

                        <label class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Date To:</label>

                        <div class="col-sm-7 col-md-7 col-lg-7 col-xl-7 p-0">

                            <input type="text" name="tdate" id="tdate"  value="<? if($_POST['tdate']!='') echo $_POST['tdate']; else echo date('Y-m-d')?>" />

                        </div>

                    </div>



                </div>

                



                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">

                    <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" class="btn1 btn1-submit-input" />

                    

                </div>



            </div>

        </div>













            

        <div class="container-fluid pt-5 p-0 ">



                <table class="table1  table-striped table-bordered table-hover table-sm">

                    <thead class="thead1">

                    <tr class="bgc-info">

                        <th>Req No</th>

                        <th width="10%">Req Date</th>

                        <th>Req For</th>



                        <th>Warehouse </th>

                        <th>Note</th>

                        <th>Need By</th>



                        <th>Entry At</th>

						<th>Entry By</th>

						<th>Status</th>

						<th>Action</th>

                        

                    </tr>

                    </thead>



                    <tbody class="tbody1">

						<? 



								if($_POST['status']!=''&&$_POST['status']!='ALL')

$con .= ' and a.status="'.$_POST['status'].'"';


$vendor_id = find_a_field('user_activity_management','vendor_code','user_id="'.$_SESSION['user']['id'].'"');

if($_POST['fdate']!=''&&$_POST['tdate']!='')

$con .= ' and a.req_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';

$res='select a.req_no,a.req_no, a.req_date, a.req_for, b.warehouse_name as warehouse, a.req_note as note, a.need_by,a.vendor_status, c.fname as entry_by, a.entry_at,a.status from requisition_master a,warehouse b,user_activity_management c,rfq_vendor_info r where r.req_no=a.req_no and r.status="Send" and a.warehouse_id=b.warehouse_id and a.status="CHECKED" and a.entry_by=c.user_id and r.vendor_id="'.$vendor_id.'" '.$con.' group by r.req_no order by a.req_no desc';

								

								$query=db_query($res);

								

								While($row=mysqli_fetch_object($query)){

								

								

								?>

                        <tr>

                            <td><?=$row->req_no?></td>

                            <td><?=$row->req_date?></td>

                            <td><?=$row->req_for?></td>



                            <td><?=$row->warehouse?></td>

                            <td><?=$row->note?></td>

                            <td><?=$row->need_by?></td>

							<td><?=$row->entry_at?></td>

							<td><?=$row->entry_by?></td>

							<td><?=$row->status?></td>



                            

                            <td><button type="button" onclick="custom('<?=url_encode($row->req_no);?>')" class="btn2 btn1-bg-submit"><i class="fa-solid fa-eye"></i></button></td>
						



                        </tr>

							<? 

							}

							?>

                    </tbody>

                </table>











        </div>

    </form>

</div>









<!--<div class="form-container_large">

<form action="" method="post" name="codz" id="codz">

<table width="80%" border="0" align="center">

  <tr>

    <td>&nbsp;</td>

    <td colspan="3">&nbsp;</td>

    <td>&nbsp;</td>

  </tr>

  <tr>

    <td align="right" bgcolor="#FF9966"><strong>Date:</strong></td>

    <td width="1" bgcolor="#FF9966"><strong>

      <input type="text" name="fdate" id="fdate" style="width:100px;" value="<? if($_POST['fdate']!='') echo $_POST['fdate']; else echo date('Y-m-01')?>" />

    </strong></td>

    <td align="center" bgcolor="#FF9966"><strong> -to- </strong></td>

    <td width="1" bgcolor="#FF9966"><strong>

      <input type="text" name="tdate" id="tdate" style="width:100px;" value="<? if($_POST['tdate']!='') echo $_POST['tdate']; else echo date('Y-m-d')?>" />

    </strong></td>

    <td rowspan="2" bgcolor="#FF9966"><strong>

      <input type="submit" name="submitit" id="submitit" value="View Detail" class="btn1 btn1-submit-input" />

    </strong></td>

  </tr>

  <tr>

    <td align="right" bgcolor="#FF9966"><strong><?=$title?>: </strong></td>

    <td colspan="3" bgcolor="#FF9966"><strong>

<select name="status" id="status" style="width:200px;">

<option></option>

<option <?=($_POST['status']=='CHECKED')?'selected':''?>>CHECKED</option>

<option <?=($_POST['status']=='COMPLETED')?'selected':''?>>COMPLETED</option>

</select>

    </strong></td>

    </tr>

</table>



</form>

</div>-->



<?php /*?><table width="100%" border="0" cellspacing="0" cellpadding="0">

<tr>

<td><div class="tabledesign2">

<? 

if($_POST['status']!=''&&$_POST['status']!='ALL')

$con .= ' and a.status="'.$_POST['status'].'"';



if($_POST['fdate']!=''&&$_POST['tdate']!='')

$con .= ' and a.req_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';



 $res='select  	a.req_no,a.req_no, a.req_date, a.req_for, b.warehouse_name as warehouse, a.req_note as note, a.need_by, c.fname as entry_by, a.entry_at,a.status from requisition_master a,warehouse b,user_activity_management c where  a.warehouse_id=b.warehouse_id and a.entry_by=c.user_id '.$con.' order by a.req_no';

echo link_report($res,'mr_print_view.php');

?>

</div></td>

</tr>

</table><?php */?>

<?



require_once SERVER_CORE."routing/layout.bottom.php";

?>

