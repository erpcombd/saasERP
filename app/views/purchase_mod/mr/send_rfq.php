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

$req_no = $_REQUEST['req_no'];

$req_all = find_all_field('requisition_master','','req_no="'.$req_no.'"');

$tr_from="Purchase";

if(isset($_POST['confirm'])){
$crud = new crud('rfq_vendor_info');
$vendors = $_POST['vendors'];

$max = find_a_field('rfq_vendor_info','max(rfq_no)','1');
if($max==''){
$max_rfq_no = 'RFQ-1';
}else{
$maxrfq = end(explode('-',$max));
$max = $maxrfq+1;
$max_rfq_no = 'RFQ-'.$max;
}

foreach($vendors as $vendor_id){

if($vendor_id>0){

$_POST['rfq_no'] = $max_rfq_no;
$_POST['rfq_date'] = date('Y-m-d');
$_POST['vendor_id'] = $vendor_id;
$send = $crud->insert();
if($send>0){
++$total_send;
}
}

}

if($total_send>0){
echo '<span style="color:green; font-weight:bold; font-size:16px;">RFQ No. ('.$max_rfq_no.') Send To '.$total_send.' Vendors Successfully!</span>';
}else{
echo '<span style="color:red; font-weight:bold; font-size:16px;">Something Wrong!!!</span>';
}
}
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
                <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5 pt-1 pb-1">
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Requisition No.:</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <input type="text" name="req_no" id="req_no" value="<?=$req_no?>" readonly="readonly" />
                        </div>
                  </div>

                </div>
				<div class="col-sm-5 col-md-5 col-lg-5 col-xl-5 pt-1 pb-1">
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Req Date: </label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <input type="text" name="req_date" id="req_date" value="<?=$req_all->req_date?>" readonly="readonly" />
                        </div>
                  </div>

                </div>
				<div class="col-sm-5 col-md-5 col-lg-5 col-xl-5 pt-1 pb-1">
                    <div class="form-group row m-0">
             <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Req By :</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
						
                            <input type="text" name="req_by" id="req_by" value="<?=find_a_field('user_activity_management','fname','user_id="'.$req_all->entry_by.'"');?>" readonly="readonly" />
                        </div>
                    </div>

                </div>
                <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 pt-1 pb-1">
                    <div class="form-group row m-0">
            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Warehouse :</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            					  
					  	
                            <input type="text" name="warehouse" id="warehouse" value="<?=find_a_field('warehouse','warehouse_name','warehouse_id="'.$req_all->warehouse_id.'"');?>" readonly="readonly" />

                        </div>
                    </div>
                </div>

                

            </div>
        </div>
		
		

        













            

        <div class="container-fluid pt-5 p-0 ">



                <table id="example" class="table1  table-striped table-bordered table-hover table-sm">

                    <thead class="thead1">

                    <tr class="bgc-info">

                        <th>SL</th>

                        <th width="10%">Vendor Code</th>

                        <th>Vendor Name</th>

                        <th>Contact</th>
						
						<th>Vendor Category</th>

                    </tr>

                    </thead>



                    <tbody class="tbody1">

						<? 

                   $sql = 'select req_no,vendor_id from rfq_vendor_info where req_no="'.$req_no.'" group by req_no,vendor_id';
				   $qry = db_query($sql);
				   while($preData = mysqli_fetch_object($qry)){
				     $selected[$preData->req_no][$preData->vendor_id] = $preData->req_no;
				   }
                   $res='select v.vendor_id,v.vendor_name,v.contact_no,c.category_name from vendor v, vendor_category c where v.vendor_category=c.id and v.status="ACTIVE"';

					$query=db_query($res);
					While($row=mysqli_fetch_object($query)){
                            if($selected[$req_no][$row->vendor_id]>0){
							 $checked = 'checked';
							}else{
							 $checked = '';
							}
								?>

                        <tr>

                            <td><input type="checkbox" name="vendors[]" id="vendors" <?=$checked?> value="<?=$row->vendor_id?>" style="height:20px; width:10%;" /></td>

                            <td><?=$row->vendor_id?></td>

                            <td><?=$row->vendor_name?></td>

                            <td><?=$row->contact_no?></td>

                            <td><?=$row->category_name?></td>

                        </tr>

							<? 

							}

							?>

                    </tbody>
					
					<tr>
					 <td>
					 <input type="hidden" name="entry_at" id="entry_at" value="<?=date('Y-m-d H:i:s')?>" />
					 <input type="hidden" name="entry_by" id="entry_by" value="<?=$_SESSION['user']['id']?>" />
					 <input type="hidden" name="req_no" id="req_no" value="<?=$req_no?>" />
					 <input type="submit" name="confirm" id="confirm" value="Send RFQ" /></td>
					</tr>

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

