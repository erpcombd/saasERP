<?php
session_start();

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$title='Unapproved Purchase Order';

do_calander('#fdate');
do_calander('#tdate');

$table = 'purchase_master';
$unique = 'po_no';
$status = 'UNCHECKED';
$target_url = '../po_golden/po_checking.php';
/*if($_POST[$unique]>0)
{
$_SESSION[$unique] = $_POST[$unique];
header('location:'.$target_url);
}*/
?>
<script language="javascript">
function custom(theUrl)
{
  
	window.open('<?=$target_url?>?<?=$unique?>='+theUrl+'','_self');
	//window.open('<?=$target_url?>');
}
</script>


<div class="form-container_large">
    
    <form action="" method="post" name="codz" id="codz">
            
        <div class="container-fluid bg-form-titel">
            <div class="row">
                <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
                    <div class="form-group row m-0">
                        <label class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Date From:</label>
                        <div class="col-sm-7 col-md-7 col-lg-7 col-xl-7 p-0">
                            <input type="text" name="fdate" id="fdate"  value="<? if($_POST['fdate']!='') echo $_POST['fdate']; else echo date('Y-m-01')?>" />
    </strong></td>
                        </div>
                    </div>

                </div>
				<div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
                    <div class="form-group row m-0">
                        <label class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Date To:</label>
                        <div class="col-sm-7 col-md-7 col-lg-7 col-xl-7 p-0">
                            <input type="text" name="tdate" id="tdate"  value="<? if($_POST['tdate']!='') echo $_POST['tdate']; else echo date('Y-m-d')?>" />
                        </div>
                    </div>

                </div>
                <!--<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                    <div class="form-group row m-0">
                        <label class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Unapprove PO:</label>
                        <div class="col-sm-7 col-md-7 col-lg-7 col-xl-7 p-0">
                            
								<select name="status" id="status" >
								<option></option>
								<option <?=($_POST['status']=='UNCHECKED')?'selected':''?>>UNCHECKED</option>
								<option <?=($_POST['status']=='CHECKED')?'selected':''?>>CHECKED</option>
								</select>
									

                        </div>
                    </div>
                </div>-->

                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                    
					<input type="submit" name="submitit" id="submitit" value="View Detail" class="btn1 btn1-submit-input" />
                    
                </div>

            </div>
        </div>






            
        <div class="container-fluid pt-5 p-0 ">

                <table class="table1  table-striped table-bordered table-hover table-sm">
                    <thead class="thead1">
                    <tr class="bgc-info">
                        <th>Po No</th>
                        <th width="9%">Po Date</th>
                        <th>Vendor Name</th>

                        <th>Warehouse Name </th>
                        <th>Created By</th>
                        <th>Entry At</th>
						<th>Status</th>

                        <th>Action</th>
                        
                    </tr>
                    </thead>

                    <tbody class="tbody1">
						<? 

							//if($_POST['status']!=''&&$_POST['status']!='ALL')
							//$con .= 'and p.status="'.$_POST['status'].'"';
							
							if($_POST['fdate']!=''&&$_POST['tdate']!='')
							$con .= 'and p.po_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
							
							 $res='select p.po_no,p.po_no,p.po_date,v.vendor_name,w.warehouse_name,u.fname as created_by,p.entry_at,p.status from purchase_master p, user_activity_management u, vendor v, warehouse w where p.warehouse_id=w.warehouse_id and v.vendor_id=p.vendor_id and u.user_id=p.entry_by and p.status="UNCHECKED" '.$con. ' order by p.po_no desc';
								
								$query=db_query($res);
								
								While($row=mysqli_fetch_object($query)){
								
								
								?>
                        <tr>
                            <td><?=$row->po_no?></td>
                            <td><?=$row->po_date?></td>
                            <td style="text-align:left"><?=$row->vendor_name?></td>

                            <td style="text-align:left"><?=$row->warehouse_name?></td>
                            <td><?=$row->created_by?></td>
                            <td><?=$row->entry_at?></td>
							<td><?=$row->status?></td>

                            
                            <td><button type="button" onclick="custom(<?=$row->po_no?>)" class="btn1 btn1-bg-submit">View</button></td>

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
<option <?=($_POST['status']=='UNCHECKED')?'selected':''?>>UNCHECKED</option>
<option <?=($_POST['status']=='CHECKED')?'selected':''?>>CHECKED</option>
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
$con .= 'and a.status="'.$_POST['status'].'"';

if($_POST['fdate']!=''&&$_POST['tdate']!='')
$con .= 'and a.req_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';

 $res='select p.po_no,p.po_no,p.po_date,v.vendor_name,w.warehouse_name,u.fname as created_by,p.entry_at,p.status from purchase_master p, user_activity_management u, vendor v, warehouse w where p.warehouse_id=w.warehouse_id and v.vendor_id=p.vendor_id and u.user_id=p.entry_by and p.status="UNCHECKED"';
echo link_report($res,'mr_print_view.php');
?>
</div></td>
</tr>
</table><?php */?>

<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>