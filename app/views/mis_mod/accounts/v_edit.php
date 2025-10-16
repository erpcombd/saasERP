<?php

session_start();

ob_start();
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Start Edit Section ::::: 

$title='Voucher Delete';			// Page Name and Page Title

if(isset($_POST['update'])){
$chalan_no = $_REQUEST['chalan_no'];

$tr_from = $_REQUEST['tr_from'];
$jv_no = $_REQUEST['jv_no'];
$jv_date = $_REQUEST['v_date'];
$ids = $_POST['ids'];

db_query("INSERT INTO journal_del select * from journal where tr_from ='".$tr_from."' and jv_no=".$jv_no."");
db_query("insert into del_modify_logs set tr_no='".$jv_no."',tr_from='".$tr_from."',action='Modify',entry_by='".$_SESSION['user']['id']."',entry_at='".date('Y-m-d H:i:s')."'");

foreach($ids as $id){
	
$narration = $_POST['narration'.$id];	
db_query('update journal set jv_date="'.$jv_date.'",narration="'.$narration.'" where id="'.$id.'" and tr_from="'.$tr_from.'"');

}
$msg = '<span style="color:green;">Voucher Updated Successfully.</span>';
}



	?>

<style type="text/css">

<!--

.style1 {

	color: #FF0000;

	font-weight: bold;

}

.style2 {

	color: #006600;

	font-weight: bold;

}

-->

</style>
<? if(isset($msg)){ ?>

	<div class="alert alert-success p-2" role="alert">
  			<?=$msg?>
	</div>

<? } ?>


<div class="form-container_large">
   
    <form action="" method="post">
           
        <div class="container-fluid bg-form-titel">
            <div class="row">
                <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Voucher No.</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <input name="v_no" type="text" id="v_no" maxlength="16" value="<?=$_POST['v_no']?>" required />
                        </div>
                    </div>

                </div>
                <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Voucher Type</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                           <select name="tr_from" id="tr_from" required>
							<option></option>
								<option value="Receipt" <?=($_POST['tr_from']=='Receipt')?'selected':''?>>Receipt</option>
								<option value="Payment" <?=($_POST['tr_from']=='Payment')?'selected':''?>>Payment</option>
								<option  value="Journal" <?=($_POST['tr_from']=='Journal')?'selected':''?>>Journal</option>
								<option value="contra" <?=($_POST['tr_from']=='contra')?'selected':''?>>Contra</option>
							</select>

                        </div>
                    </div>
                </div>

                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
							<input name="search" type="submit" class="btn1 btn1-submit-input" id="search" value="Search" />
                  
                   
                </div>

            </div>
        </div>


<div class="container n-form1">
<? if(isset($_POST['search'])){ 
$check = find_a_field('journal','jv_no','jv_no="'.$_POST['v_no'].'" and tr_from="'.$_POST['tr_from'].'"');
if($check>0){
?>
               <table  id="table_head" class="table table-bordered table-bordered table-striped table-hover table-sm">
					<thead>
						<tr>
							 <th><span>ID</span></th>
							
							<th><span>Ledger Name</span></th>
							
							<th><span>DR Amt</span></th>
							<th><span>CR Amt</span></th>
							
							<th><span>Narration</span></th>
						</tr>
					</thead>
					
					<tbody>
					
					<?php
					
					if($_POST['v_no']>0){
					 $con = ' and j.jv_no="'.$_POST['v_no'].'"';
					}
					if($_POST['tr_from']!=''){
					 $con .= ' and j.tr_from="'.$_POST['tr_from'].'"';
					}
					$sql = 'select j.*,a.ledger_name from journal j, accounts_ledger a where a.ledger_id=j.ledger_id '.$con.'';
					$qry = db_query($sql);
					while($data=mysqli_fetch_object($qry)){
					?>
					
					<tr>
					  <td><?=++$i;?></td>
					
					<td><?=$data->ledger_name?></td>
					
					<td><?=$data->dr_amt?></td>
					<td><?=$data->cr_amt?></td>
					<td><input type="hidden" name="ids[]" value="<?=$data->id?>" /><input type="text" name="narration<?=$data->id?>" id="narration<?=$data->id?>" value="<?=$data->narration?>" /></td>
					</tr>
					<? $old_v_date= $data->jv_date;}  ?>
					<tr>
					<td>Voucher Date</td>
					 <td><input type="date" name="v_date" id="v_date" value="<?=$old_v_date?>" /></td>
					 <td colspan="2"></td>
					 <td><input type="submit" name="update" id="update" value="Update" /></td>
					</tr>
					</tbody>
					</table>
					<? }else { echo 'Not Found'; } ?>
				

	

            </div>
    </form>
</div>



<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>