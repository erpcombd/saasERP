<?php
require_once "../../../assets/template/layout.top.php";
$title='Select POS ID For Return';
do_calander('#fdate');
do_calander('#tdate');
$page_for = 'Return';
do_calander('#or_date');
do_calander('#quotation_date');
do_datatable("cus_table");
//auto_reinsert_sales_return_secoundary('8894');


$table_master='warehouse_other_receive';
$table_details='warehouse_other_receive_detail';
$unique='or_no';
$$unique = $_POST[$unique];
unset($_SESSION[$unique]);

//if(isset($_POST['submitit_'.$_POST['pos_id_']])){
//echo $_POST['pos_id'];
// $check = find_a_field('warehouse_other_receive','or_no','manual_or_no="'.$_POST['pos_id'].'" and receive_type="PosReturn"');
// if($check>0){
// echo '<span style="color:red;">Already Returned!</span>'.$_POST['pos_id'];
// }else{
// header('location:item_return.php');
// }
//}
if(isset($_POST['confirmm']))
{       
        
		$sql = 'select p.*,i.item_name,i.unit_name  from sale_pos_details p, item_info i where i.item_id=p.item_id and p.pos_id="'.$_SESSION['pos_id'].'"';
        $qry = mysql_query($sql);
        while($data=mysql_fetch_object($qry)){
		  
		  if($_POST['check'.$data->id]=='checked'){
		   $qty = $_POST['qty'.$data->id];
		   $rate = $data->rate;
		   $amount = $qty*$rate;
		   $details_insert = 'insert into warehouse_other_receive_detail set or_no="'.$$unique.'",item_id="'.$data->item_id.'", vendor_id="'.$data->dealer_id.'", receive_type="PosReturn", or_date="'.date('Y-m-d').'", warehouse_id="'.$_SESSION['user']['depot'].'", rate="'.$data->rate.'", qty="'.$qty.'", serial_no="'.$data->serial_no.'", unit_name="'.$data->unit_name.'", amount="'.$amount.'"';
		   mysql_query($details_insert);
		   //journal_item_control($data->item_id ,$_SESSION['user']['depot'],date('Y-m-d'),$qty,0,'PosReturn',$data->id,$data->rate,'',$$unique);
		  }
		}
		
        unset($_POST);
        $_POST[$unique]=$$unique;
		$_POST['entry_by']=$_SESSION['user']['id'];
		$_POST['entry_at']=date('Y-m-d h:s:i');
		$_POST['status']='UNCHECKED';
		$crud   = new crud($table_master);
		$crud->update($unique);
		unset($$unique);
		unset($_SESSION[$unique]);
		$type=1;
		$msg='Successfully Forwarded.';
}

if(isset($_POST['delete']))
{
		
		$crud   = new crud($table_master);
		$condition=$unique."=".$$unique;		
		$crud->delete($condition);
		$crud   = new crud($table_details);
		$condition=$unique."=".$$unique;
		$crud->delete_all($condition);
		unset($$unique);
		unset($_SESSION[$unique]);
		$type=1;
		$msg='Successfully Deleted.';
}
$target_url = '../pos/pos_print_view.php';
$target_url2 = '../pos/pos_receipt_view.php';
$target_url3 = '../salesReturn/item_return.php';
$target_url4 = '../pos/pos_gatepass_view.php';
//auto_complete_from_db('dealer_info','dealer_name_e','dealer_code',' canceled="Yes"','dealer');
?>
<script language="javascript">
window.onload = function() {document.getElementById("do").focus();}
</script>
<? include("../../../assets/css/New_them_css_custome.css")?>
<div class="form-container_large">
 <script language="javascript">
function custom(theUrl)
{
	window.open('<?=$target_url?>?v_no='+theUrl);
}
function custom2(theUrl)
{
	window.open('<?=$target_url2?>?v_no='+theUrl);
}
function custom3(theUrl)
{
	window.open('<?=$target_url3?>?pos_id='+theUrl);
}

 
</script>
    <form action="" method="post" name="codz" id="codz">
            
        <div class="container-fluid bg-form-titel">
            <div class="row">
                <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Date From:</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <input type="text" name="fdate" id="fdate" value="<?php if($_POST['fdate']!=''){echo $_POST['fdate'];}else{ echo date('Y-m-d');}?>" />
                        </div>
                    </div>

                </div>
                <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Date To:</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                           <input type="text" name="tdate" id="tdate" value="<?php if($_POST['tdate']!=''){echo $_POST['tdate'];}else{ echo date('Y-m-d');}?>" />

                        </div>
                    </div>
                </div>
				

                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                    
                    <input type="submit" name="view" id="view" value="View Product" class="btn1 btn1-submit-input"/ >
                </div>

            </div>
        </div>






        <div class="container-fluid pt-5 p-0 ">
		
		
		

                <table class="table1  table-striped table-bordered table-hover table-sm" id="cus_table">
                    <thead class="thead1">
                    <tr class="bgc-info">
                        <th>POS ID</th>
						<th>POS Date</th>
						<th>Customer Name</th>
						<th>Created By</th>
						<th>Entry At</th>
						<th>Status</th>
						<th>Action</th>
                    </tr>
                    </thead>

                    <tbody class="tbody1">
					
					<? 
if(isset($_POST['view'])){ 
unset($_SESSION['pos_id']);
  $res='select m.pos_id,m.pos_id,m.pos_date,d.dealer_name,u.fname as created_by,m.entry_at,m.status from sale_pos_master m left join dealer_pos d on d.dealer_code=m.dealer_id left join user_activity_management u on u.user_id=m.entry_by where m.status="CHECKED" and m.pos_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'" and m.warehouse_id="'.$_SESSION['user']['depot'].'" order by m.pos_id desc ';
}
else{
unset($_SESSION['pos_id']);
$from_date=date('Y-m-d');
$to_date=date('Y-m-d');
    $res='select m.pos_id,m.pos_id,m.pos_date,d.dealer_name,u.fname as created_by,m.entry_at,m.status from sale_pos_master m left join dealer_pos d on d.dealer_code=m.dealer_id left join user_activity_management u on u.user_id=m.entry_by where m.status="CHECKED" and m.pos_date between "'.$from_date.'" and "'.$to_date.'" and m.warehouse_id="'.$_SESSION['user']['depot'].'" order by m.pos_id desc ';
}

 

//echo link_report($res,'po_print_view.php');

		$query = mysql_query($res);
	 
				 
						?>					
					<?
					
					while($row = mysql_fetch_object($query)){
					$check_return = find_a_field('warehouse_other_receive','or_no','manual_or_no="'.$row->pos_id.'" and receive_type="PosReturn"');
					?>

                        <tr>
                            <td><?=$row->pos_id?></td>
                            <td><?=$row->pos_date?></td>
                            <td><?=$row->dealer_name?></td>

                            <td><?= $row->created_by?></td>
                            <td><?= $row->entry_at?></td>
							<td><?= $row->status?></td>
                            
                            <td>
							 
							 
							<input type="button" name="receipt" id="receipt" value="POS RECEIPT" class="btn1 btn1-submit-input" onclick="custom2(<?= $row->pos_id?>)"/ >
							<?php
							if($check_return>0){
							echo '<span style="font-weight:bold;color:red;">Already Returned</span>';
							}
							else{
							 ?>
							<input type="button" name="submitit " id="submitit" value="Sales Return" onclick="custom3(<?= $row->pos_id?>)" class="btn1 btn1-submit-input"  / >
							<?php } ?>
							<!--<input type="button" name="submitit" id="submitit" value="GATE PASS" class="btn1 btn1-submit-input" onclick="custom4(<? //$row->pos_id?>)"/ >-->

							</td>

                        </tr>
						<?
						}
						?>
                    </tbody>
                </table>

				



        </div>
    </form>
</div>

<!--
<div class="form-container_large">
<form action="" method="post" name="codz" id="codz">
<table width="70%" border="0" align="center">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FF9966"><strong>Enter Completed POS ID: </strong></td>
    <td bgcolor="#FF9966"><strong>

<?
//$query = "select a.do_no,b.dealer_code,b.dealer_name_e from sale_do_master a,dealer_info b where b.dealer_code=a.dealer_code and a.status ='PROCESSING' and b.depot=".$_SESSION['user']['depot']."  order by a.do_no";
?>
<input name="pos_id" type="text" id="pos_id" />
    </strong></td>
    <td bgcolor="#FF9966"><strong>
      <input type="submit" name="submitit" id="submitit" value="Return Receive" style="width:170px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
    </strong></td>
  </tr>
</table>

</form>
</div>-->

<?
require_once "../../../assets/template/layout.bottom.php";
?>