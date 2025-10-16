<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$title='Warehouse Transfer Receive Status';



do_calander('#fdate');

do_calander('#tdate');

$tr_type="Show";

$table = 'requisition_master';

$unique = 'req_no';

$status = 'UNCHECKED';

$target_url = '../depot_transfer/print_view_receive.php';

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
    <div class="col-sm-10 col-md-10 col-lg-10 col-xl-10">
        <div class="row">
            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 pt-1 pb-1">
                <div class="form-group row m-0">
                    <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">From Date:</label>
                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                         <input type="text" name="fdate" id="fdate"  value="<? if($_POST['fdate']=='') echo date('Y-m-01'); else echo $_POST['fdate'];?>" />
                    </div>
                </div>

            </div>
            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 pt-1 pb-1">
                <div class="form-group row m-0">
                    <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">To Date:</label>
                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                        <input type="text" name="tdate" id="tdate"  value="<? if($_POST['tdate']=='') echo date('Y-m-d'); else echo $_POST['tdate'];?>" />

                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 pt-1 pb-1">
                <div class="form-group row m-0">
                    <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Transfer Status : </label>
                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                       <select name="status" id="status">
					   

		<option <? if($_POST['status']==''||$_POST['status']=='IN TRANSIT') echo 'Selected';?>>IN Transit</option>

		<option <? if($_POST['status']=='TRANSFERED') echo 'Selected';?>>Transfered</option>

		<option <? if($_POST['status']=='SEND') echo 'Selected';?>>All Send</option>

      </select>
                    </div>
                </div>

            </div>
            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 pt-1 pb-1">
                <div class="form-group row m-0">
                    <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Sending Inventory:</label>
                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                        <select name="depot" id="depot">

							<option></option>
							
							
							
							<? foreign_relation('warehouse','warehouse_id','warehouse_name',$depot,'1 and use_type="wh" order by warehouse_name');?>
							
						</select>

                    </div>
                </div>
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



if($_POST['depot']!=''&&$_POST['depot']!='ALL')

$con .= 'and a.warehouse_from="'.$_POST['depot'].'"';



if($_POST['fdate']!=''&&$_POST['tdate']!=''){

$con .= 'and a.pi_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';



if($_POST['status']==''||$_POST['status']=='IN TRANSIT')

$con .=  'and a.status="SEND"';

elseif($_POST['status']==''||$_POST['status']=='TRANSFERED')

$con .=  'and a.status!="SEND"';

else

{$do = 'nothing';}



 $res='select  	a.pi_no as transfer_id,a.pi_no as transfer_id, a.pi_date as date, a.invoice_no, b.warehouse_name as Depot_from, a.status, u.fname as entry_by, a.entry_at,a.status from user_activity_management u, production_issue_master a, warehouse b where   a.entry_by=u.user_id and a.warehouse_from=b.warehouse_id and a.warehouse_to="'.$_SESSION['user']['depot'].'" and a.status="SEND" and b.use_type!="PL" '.$con.' order by a.pi_no desc';

//echo link_report($res,'print_view.php');


$query = db_query($res);

?>
                
				<table class="table1  table-striped table-bordered table-hover table-sm">
                    <thead class="thead1">
                    <tr class="bgc-info">
                        <th>Transfer Id</th>
                        <th>Date</th>
                        <th>Invoice No</th>

                        <th>Depot From</th>
                        <th>Status</th>
                        <th>Entry By</th>

                        <th>Entry At</th>
                        <th>Action</th>
                    </tr>
                    </thead>

                    <tbody class="tbody1">
					<?
					while($row = mysqli_fetch_object($query)){
					?>


                        <tr>
                            <td><?=$row->transfer_id?></td>
                            <td><?=$row->date?></td>
                            <td><?=$row->invoice_no?></td>

                            <td><?=$row->Depot_from?></td>
                            <td><?=$row->status?></td>
                            <td><?=$row->entry_by?></td>

                            <td><?=$row->entry_at?></td>
							
                            <td>
								<input type="button" name="submitit" id="submitit" value="VIEW" class="btn1 btn1-submit-input" onclick="custom(<?=$row->transfer_id?>);" />
							
							</td>

                        </tr>
					<? }?>

                    </tbody>
                </table>


<? }?>


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

    <td align="right" bgcolor="#FF9966"><strong>Date:</strong></td>

    <td width="1" bgcolor="#FF9966"><strong>

      <input type="text" name="fdate" id="fdate" style="width:107px;" value="<? if($_POST['fdate']=='') echo date('Y-m-01'); else echo $_POST['fdate'];?>" />

    </strong></td>

    <td align="center" bgcolor="#FF9966"><strong> -to- </strong></td>

    <td width="1" bgcolor="#FF9966"><strong>

      <input type="text" name="tdate" id="tdate" style="width:107px;" value="<? if($_POST['tdate']=='') echo date('Y-m-d'); else echo $_POST['tdate'];?>" />

    </strong></td>

    <td rowspan="3" bgcolor="#FF9966"><strong>

      <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" class="btn1 btn1-submit-input"/>

    </strong></td>

  </tr>

  <tr>

    <td align="right" bgcolor="#FF9966"><strong>Transfer Status : </strong></td>

    <td colspan="3" bgcolor="#FF9966"><strong>

<select name="status" id="status" style="width:200px;">

		<option <? if($_POST['status']==''||$_POST['status']=='IN TRANSIT') echo 'Selected';?>>IN TRANSIT</option>

		<option <? if($_POST['status']=='TRANSFERED') echo 'Selected';?>>TRANSFERED</option>

		<option <? if($_POST['status']=='ALL SEND') echo 'Selected';?>>ALL SEND</option>

      </select>

    </strong></td>

    </tr>

  <tr>

    <td align="right" bgcolor="#FF9966"><strong>Sending Inventory: </strong></td>

    <td colspan="3" bgcolor="#FF9966"><strong>

<select name="depot" id="depot" style="width:200px;">

<option></option>



<? foreign_relation('warehouse','warehouse_id','warehouse_name',$depot,'1 and use_type="SD" order by warehouse_name');?>

</select>

    </strong></td>

    </tr>

</table>



</form>

</div>



<table width="100%" border="0" cellspacing="0" cellpadding="0">

<tr>

<td><div class="tabledesign2">


<? 



if($_POST['depot']!=''&&$_POST['depot']!='ALL')

$con .= 'and a.warehouse_from="'.$_POST['depot'].'"';



if($_POST['fdate']!=''&&$_POST['tdate']!='')

$con .= 'and a.pi_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';



if($_POST['status']==''||$_POST['status']=='IN TRANSIT')

$con .=  'and a.status="SEND"';

elseif($_POST['status']==''||$_POST['status']=='TRANSFERED')

$con .=  'and a.status!="SEND"';

else

{$do = 'nothing';}



$res='select  	a.pi_no as transfer_id,a.pi_no as transfer_id, a.pi_date as date, a.invoice_no, b.warehouse_name as Depot_from, a.status, u.fname as entry_by, a.entry_at from user_activity_management u, production_issue_master a, warehouse b where   a.entry_by=u.user_id and a.warehouse_from=b.warehouse_id and a.warehouse_to="'.$_SESSION['user']['depot'].'" and b.use_type!="PL" '.$con.' order by a.pi_no desc';

echo link_report($res,'print_view.php');

?>
</div></td>

</tr>

</table><?php */?>



<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>