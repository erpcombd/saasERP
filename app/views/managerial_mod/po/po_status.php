<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Purchase Order Status';

do_calander('#fdate');
do_calander('#tdate');
$user_to_vendor = find_a_field('user_activity_management','vendor_code','user_id="'.$_SESSION['user']['id'].'"');
$table = 'purchase_master';
$unique = 'po_no';
$status = 'UNCHECKED';
$target_url = '../po/po_print_view.php';

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
                <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
                    <div class="form-group row m-0">
                        <label class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Date From:</label>
                        <div class="col-sm-7 col-md-7 col-lg-7 col-xl-7 p-0">
                            <input type="text" name="fdate" id="fdate"  value="<?=$_POST['fdate']?>" autocomplete="off" />
                        </div>
                    </div>

                </div>
				<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
                    <div class="form-group row m-0">
                        <label class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Date To:</label>
                        <div class="col-sm-7 col-md-7 col-lg-7 col-xl-7 p-0">
                            <input type="text" name="tdate" id="tdate"  value="<?=$_POST['tdate']?>" autocomplete="off" />
                        </div>
                    </div>

                </div>
                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                    <div class="form-group row m-0">
                        <label class="col-sm-6 col-md-6 col-lg-6 col-xl-6 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Receive Warehouse:</label>
                        <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 p-0">
                            <select name="warehouse_id" id="warehouse_id">
								<option value=""></option>
								 <? foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['warehouse_id'],'warehouse_id="'.$_SESSION['user']['depot'].'"');?>
							 </select>

                        </div>
                    </div>
                </div>

                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                    <input type="submit" name="submitit" id="submitit" value="View Detail" class="btn1 btn1-submit-input" />
					
                    
                </div>

            </div>
        </div>






            
        <div class="container-fluid pt-5 p-0 ">

                <table class="table1  table-striped table-bordered table-hover table-sm">
                    <thead class="thead1">
                    <tr class="bgc-info">
                        <th>PO No</th>
                        <th width="9%">PO Date</th>
                        <th>Reg No</th>
						<th>Quo No</th>
                        <th>Vendor Name </th>
                        <th>Warehouse</th>
                        

                        <th>Entry By</th>
						<th>Entry At</th>
						<th>Status</th>
						<th width="10%">Action</th>
                        
                    </tr>
                    </thead>

                    <tbody class="tbody1">
					
					<? 
							if(isset($_POST['fdate'])){
								if($_POST['status']!=''&&$_POST['status']!='ALL')
								$con .= 'and a.status="'.$_POST['status'].'"';
								
								if($_POST['fdate']!=''&&$_POST['tdate']!='')
								$con .= 'and a.po_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
								
								if($_POST['group_for']!='')
								$con .= 'and b.group_for = "'.$_POST['group_for'].'"';
								
								if($_POST['warehouse_id']!='')
								$con .= 'and b.warehouse_id = "'.$_POST['warehouse_id'].'"';
								
								$res='select  a.po_no,a.po_no, a.po_date, a.req_no,v.vendor_name, v.vendor_id, b.warehouse_name as warehouse, a.quotation_no as note, c.fname as "by", a.entry_at,a.status from purchase_master a,warehouse b,user_activity_management c, vendor v where   a.warehouse_id=b.warehouse_id and a.entry_by=c.user_id and a.entry_by="'.$_SESSION['user']['id'].'" and v.vendor_id="'.$user_to_vendor.'" and a.vendor_id=v.vendor_id '.$con.' order by a.po_no desc';
						

								
								$query=db_query($res);
								
								While($row=mysqli_fetch_object($query)){
								
								
								?>
                        <tr>
                            <td><?=$row->po_no?></td>
                            <td><?=$row->po_date?></td>
                            <td><?=$row->req_no?></td>
							<td><?=$row->note?></td>
                            <td style="text-align:left"><?=$row->vendor_name?></td>
                            <td><?=$row->warehouse?></td>
                            
							<td><?=$row->by?></td>
							<td><?=$row->entry_at?></td>
							<td><?=$row->status?></td>
							

                            
                            <td><button type="button" onclick="custom(<?=$row->po_no?>)" class="btn1 btn1-bg-submit">View</button></td>

                        </tr>
							<? 
							}
							?>
							
							<? }?>
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
      <input type="text" name="fdate" id="fdate" style="width:100px;" value="<?=($_POST['fdate']!='')?$_POST['fdate']:date('Y-m-01')?>" />
    </strong></td>
    <td align="center" bgcolor="#FF9966"><strong> -to- </strong></td>
    <td width="1" bgcolor="#FF9966"><strong>
      <input type="text" name="tdate" id="tdate" style="width:100px;" value="<?=($_POST['tdate']!='')?$_POST['tdate']:date('Y-m-d')?>" />
    </strong></td>
    <td rowspan="4" bgcolor="#FF9966"><strong>
      <input type="submit" name="submitit" id="submitit" value="View Detail" class="btn1 btn1-submit-input" />
    </strong></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FF9966">Receiving Warehouse Name : </td>
    <td colspan="3" bgcolor="#FF9966"><strong>
      <select name="warehouse_id" id="warehouse_id" style="width:200px;">
        <option value="">ALL</option>
		<? foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['warehouse_id'],' use_type in ("WH","SD") ');?>
      </select>
    </strong></td>
  </tr>
  <!--<tr>
    <td align="right" bgcolor="#FF9966">Company Name : </td>
    <td colspan="3" bgcolor="#FF9966"><select name="group_for" id="group_for">
      <option></option>
      <?	$sql="select * from user_group where id!=1 order by group_name";
											$query=db_query($sql);
											while($datas=mysqli_fetch_object($query))
										{
										?>
      <option <? if($datas->id==$group_for) echo 'Selected ';?> value="<?=$datas->id?>">
      <?=$datas->group_name?>
      </option>
      <? } ?>
    </select></td>
  </tr>-->
  <!--<tr>
    <td align="right" bgcolor="#FF9966"><strong><?=$title?>: </strong></td>
    <td colspan="3" bgcolor="#FF9966"><strong>
<select name="status" id="status" style="width:200px;">
<option><?=$_POST['status']?></option>
<option>UNCHECKED</option>
<option>CHECKED</option>
<option>ALL</option>
</select>
    </strong></td>
    </tr>-->
<!--</table>

</form>
</div>-->

<?php /*?><table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td><div class="tabledesign2">
<? 
if(isset($_POST['fdate'])){
if($_POST['status']!=''&&$_POST['status']!='ALL')
$con .= 'and a.status="'.$_POST['status'].'"';

if($_POST['fdate']!=''&&$_POST['tdate']!='')
$con .= 'and a.po_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';

if($_POST['group_for']!='')
$con .= 'and b.group_for = "'.$_POST['group_for'].'"';

if($_POST['warehouse_id']!='')
$con .= 'and b.warehouse_id = "'.$_POST['warehouse_id'].'"';

$res='select  a.po_no,a.po_no, a.po_date, a.req_no,v.vendor_name, b.warehouse_name as warehouse, a.quotation_no as note, c.fname as "by", a.entry_at,a.status from purchase_master a,warehouse b,user_activity_management c, vendor v where a.status!="Manual" and a.warehouse_id=b.warehouse_id and a.entry_by=c.user_id and a.vendor_id=v.vendor_id '.$con.' order by a.po_no desc';
echo link_report($res,'po_print_view.php');

}
?>
</div></td>
</tr>
</table><?php */?>

<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>