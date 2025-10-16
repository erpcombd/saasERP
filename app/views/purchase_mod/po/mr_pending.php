<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$tr_type="Show";
$title='PR Pending';

do_calander('#fdate');

do_calander('#tdate');

$table = 'requisition_master';

$unique = 'req_no';

$status = 'UNCHECKED';

$target_url = '../mr/mr_print_view.php';


if($_GET['vStatus']>0){

$status=find_a_field('requisition_master','vendor_status','req_no='.$_GET['vStatus']);

if($status=="No" && $_GET['status']=="No"){ db_query('update requisition_master set vendor_status="Yes" where req_no='.$_GET['vStatus'].'');}

if($status=="Yes" && $_GET['status']=="Yes"){ db_query('update requisition_master set vendor_status="Expired" where req_no='.$_GET['vStatus'].'');}

echo "<script>window.top.location='mr_pending.php'</script>";
}

$tr_from="Purchase";
?>




<script language="javascript">
function custom(theUrl,c_id)
{
	window.open('<?=$target_url?>?c='+encodeURIComponent(c_id)+'&v='+ encodeURIComponent(theUrl));
}
function custom2(theUrl)
{   
	$.ajax({
		url: 'set_session.php',
		type: 'POST', 
		data: {po_no: theUrl},
		success: function(response) {

			window.open('po_create.php');
		}
	});
}
function custom3(theUrl)
{
	window.open('<?=$target_url3?>?<?=$unique?>='+theUrl);
}

</script>





<div class="form-container_large">

    

    <form action="" method="post" name="codz" id="codz">

            <div class="container-fluid bg-form-titel">
            <div class="row">
                <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5 pt-1 pb-1">
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"> From Date:</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <input type="text" name="fdate" id="fdate"  value="<? if($_POST['fdate']!='') echo $_POST['fdate']; else echo date('Y-m-01')?>" />
                        </div>
                  </div>

                </div>
				<div class="col-sm-5 col-md-5 col-lg-5 col-xl-5 pt-1 pb-1">
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">To Date: </label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <input type="text" name="tdate" id="tdate"  value="<? if($_POST['tdate']!='') echo $_POST['tdate']; else echo date('Y-m-d')?>" />
                        </div>
                  </div>

                </div>
				<div class="col-sm-5 col-md-5 col-lg-5 col-xl-5 pt-1 pb-1">
                    <div class="form-group row m-0">
             <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Req Status :</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
						
                            <select name="status" id="status">

								<option></option>

								<option <?=($_POST['status']=='CHECKED')?'selected':''?>>CHECKED</option>

								<option <?=($_POST['status']=='COMPLETED')?'selected':''?>>COMPLETED</option>

							</select>
                        </div>
                    </div>

                </div>
                <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 pt-1 pb-1">
                    <div class="form-group row m-0">
            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Warehouse :</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            					  
					  	
                            <select name="warehouse_id" id="warehouse_id">

								<option></option>
								<? user_warehouse_access($depot_id);?>

							</select>

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
						
						<th>Remain Days</th>

                        <th>Entry At</th>

						<th>Entry By</th>

						<th>Status</th>

						<th>Action</th>
						
						<th>Attach To Vendor</th>

                        

                    </tr>

                    </thead>



                    <tbody class="tbody1">

						<? 



								if($_POST['status']!='' && $_POST['status']!='ALL')

				$con .= ' and a.status="'.$_POST['status'].'"';



						if($_POST['fdate']!=''&&$_POST['tdate']!='')

				$con2 .= ' and a.req_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
				
				if($_POST['warehouse_id']!='')
								$con .= 'and a.warehouse_id = "'.$_POST['warehouse_id'].'"';



  $res='select  	a.req_no,a.req_no, a.req_date, a.req_for, b.warehouse_name as warehouse, a.req_note as note, a.need_by,a.vendor_status, c.fname as entry_by, a.entry_at,a.status
 
 from requisition_master a,warehouse b,user_activity_management c
 
 where  a.warehouse_id=b.warehouse_id  and  a.status in ("CHECKED","COMPLETED") and a.entry_by=c.user_id '.$con.$con2.'  order by a.req_no desc';

								

								$query=db_query($res);

								

								While($row=mysqli_fetch_object($query)){
								
								
								$currentDate = time();
								$targetdate = strtotime($row->need_by);
							 	$remain= $targetdate-$currentDate;
							 	$days=ceil($remain / (60 * 60 * 24));

								?>

                        <tr>

                            <td><?=$row->req_no?></td>

                            <td><?=$row->req_date?></td>

                            <td><?=$row->req_for?></td>



                            <td><?=$row->warehouse?></td>

                            <td><?=$row->note?></td>

                            <td><?=$row->need_by?></td>
							
							<td <?php if($days<1){ echo 'style="background-color:#ff6600;"'; } ?>><?=$days;?></td>

							<td><?=$row->entry_at?></td>

							<td><?=$row->entry_by?></td>

							<td><?=$row->status?></td>


                            <td>
							<button type="button" onclick="custom('<?=url_encode($row->req_no);?>')" class="btn2 btn1-bg-submit"><i class="fa-solid fa-eye"></i></button>
							
							</td>
<!--<td><a href="?vStatus=<?=$row->req_no?>&&status=<?=$row->vendor_status?>"

<?=($row->vendor_status)=='Yes'? 'data-toggle="tooltip" data-placement="bottom" title="Make Expired"':''?> 

class="<?=($row->vendor_status)=='No'?'btn btn-sm btn-warning':(($row->vendor_status)=='Yes'?'btn btn-sm btn-success':'disabled')?>" ><?=$row->vendor_status?></a></td>-->

                             <td><a href="send_rfq.php?req_no=<?=$row->req_no?>" target="_blank">Send RFQ</a></td>




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

