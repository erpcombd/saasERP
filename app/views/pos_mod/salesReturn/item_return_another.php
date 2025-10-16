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

if(isset($_POST['submitit'])){
//echo $_POST['pos_id'];
 $check = find_a_field('warehouse_other_receive','or_no','manual_or_no="'.$_POST['pos_id'].'" and receive_type="PosReturn"');
 if($check>0){
 echo '<span style="color:red;">Already Returned!</span>'.$_POST['pos_id'];
 }else{
 header('location:item_return.php?pos_id='.$_POST['pos_id']);
 }
}
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
 
//auto_complete_from_db('dealer_info','dealer_name_e','dealer_code',' canceled="Yes"','dealer');
?>
<script language="javascript">
window.onload = function() {document.getElementById("do").focus();}
</script>
 
 

<div class="form-container_large">
    
<form action="" method="post" name="codz" id="codz">
            
        <div class="container-fluid bg-form-titel">
            <div class="row">
                
                <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9">
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Enter Completed POS ID:</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">

								<?
								 //$query = "select a.do_no,b.dealer_code,b.dealer_name_e from sale_do_master a,dealer_info b where b.dealer_code=a.dealer_code and a.status ='PROCESSING' and b.depot=".$_SESSION['user']['depot']."  order by a.do_no";
								?>
								<input name="pos_id" type="text" id="pos_id" />
                        </div>
                    </div>
                </div>

                <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
				    <input type="submit" name="submitit" id="submitit" value="Return Receive"  class="btn1 btn1-submit-input"/>
                </div>

            </div>
        </div>

        
</form>
</div>

<?
require_once "../../../assets/template/layout.bottom.php";
?>