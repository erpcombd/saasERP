<?php

// error_reporting(E_ALL);
// ini_set('display_errors', 1);


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Depot Transfer';


do_calander('#pi_date','-330','0');
//do_calander('#old_production_date');

$page = 'depot_transfer_entry2.php';
$table_master='fg_issue_master';
$unique_master='pi_no';
$table_detail='fg_issue_detail';
$unique_detail='id';

$prb=0; $prb_note='';


if($_REQUEST['line_id']>0){ 

		unset($$unique_master);
		unset($_SESSION[$unique_master]);

$line_id = $_SESSION['line_id']=$_REQUEST['line_id'];
}elseif($_SESSION['line_id']>0){ 
$line_id = $_REQUEST['line_id']=$_SESSION['line_id'];
}


if($_GET['req_no']>0){
    $req_no = $_GET['req_no']; 
    $check_old_req=find_a_field('fg_issue_master','pi_no','req_no="'.$req_no.'"');
    if($check_old_req>0) {$prb=1; $prb_note='<span style="color:red;">Warning!! This Req no already Partially assigned.</span>';}
    $remarks=find_a_field('requisition_fg_master','req_note','req_no="'.$req_no.'"');
}


if($_SESSION[$unique_master]>0){

$$unique_master=$_SESSION[$unique_master];

}elseif(isset($_GET['del'])){
$$unique_master=find_a_field($table_detail,$unique_master,'id='.$_GET['del']); $del = $_GET['del'];

}else{
$$unique_master=$_REQUEST[$unique_master];
}





if(prevent_multi_submit()){

if(isset($_POST['new'])){


		$crud   = new crud($table_master);
		$_POST['entry_at']=date('Y-m-d H:i:s');
		$_POST['entry_by']=$_SESSION['user']['id'];
		$_POST['status']='MANUAL';
		
		
		if($_POST['flag']<1){
    		$$unique_master=$crud->insert();
    		
	
    		unset($$unique);
    		$type=1;
    		$msg='Product Issued. (PI No-'.$$unique_master.')';

		} else {
    
    		$crud->update($unique_master);
    		$type=1;
    		$msg='Successfully Updated.';
		}
//header("Location: depot_transfer_entry.php?pi_no=$_POST['pi_no']");
}






if(isset($_POST['add'])&&($_POST[$unique_master]>0)){

		$table		=$table_detail;
		$crud      	=new crud($table);

		//$_POST['unit_price']=$_POST['unit_price'];
		//$_POST['total_amt']= ($_POST['total_unit'] * $_POST['unit_price']);

        if($_POST['item_id']>0){
		$xid = $crud->insert();
        }
}

}else{

	$type=0;
	$msg='Data Re-Submit Error!';
}



if(isset($_GET['del']) && ($_GET['del']>0) ){	
		$del=$_GET['del'];
		$crud   = new crud($table_detail);

		$condition=$unique_detail."=".$del;		

		$crud->delete_all($condition);

		$sql = "delete from journal_item where tr_from = 'Transit' and tr_no = '".$del."'";

		db_query($sql);

		$type=1;

		$msg='Successfully Deleted.';

}









if($$unique_master>0){

		$condition=$unique_master."=".$$unique_master;
		$data=db_fetch_object($table_master,$condition);
		//while (list($key, $value)=each($data))
		
		foreach ($data as $key => $value)
		
		{ $$key=$value;}
}

if($warehouse_to>0){
    $line_id=$warehouse_to;
}

?>
<script language="javascript">

function focuson(id) {

  if(document.getElementById('item_id').value=='')

  document.getElementById('item_id').focus();

  else

  document.getElementById(id).focus();

}



function recal() {
// document.getElementById('total_unit').value = (((document.getElementById('total_pkt').value)*1)*((document.getElementById('pkt_size').value)*1))+((document.getElementById('total_pcs').value)*1);
}

function total_amtt() {
document.getElementById('total_amt').value = (((document.getElementById('unit_price').value)*1)*((document.getElementById('total_unit').value)*1));
}

</script>

<div class="form-container_large">
  <form action="<?=$page?>" method="post" name="codz2" id="codz2">
  
<div class="row">
    
    <div class="col-md-2">TR NO:</div>
    <div class="col-md-2">
        <input   name="pi_no" type="text" id="pi_no" value="<? if($$unique_master>0) echo $$unique_master; else echo (find_a_field($table_master,'max('.$unique_master.')','1')+1);?>" class="form-control" readonly/>   
    </div>
    <div class="col-md-2">TR Date:</div>
    <div class="col-md-2"><input class="form-control"  name="pi_date" type="text" id="pi_date" value="<?=$pi_date?$pi_date:date('Y-m-d');?>" autocomplete="off"  required/></div>
    
    <div class="col-md-1">From:</div>
    <div class="col-md-3">
<?php /*?><input name="warehouse_from" type="hidden" id="warehouse_from"  value="<?=$_SESSION['user']['depot']?>" />
<input name="warehouse_from3" type="text" id="warehouse_from3" class="form-control" value="<?=find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot'])?>" /><?php */?>

<select name="warehouse_from" type="text" id="warehouse_from"   required  >


<? if($warehouse_from!=''){ ?>
    <option value="<?=$warehouse_from?>"><?=find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_from);?></option> 
<? }else{?>
<?
    foreign_relation('warehouse','warehouse_id','warehouse_name','','1 and warehouse_id!="'.$line_id.'"');    
?>
<? } ?>
</select>
</div>


<input name="group_for" type="hidden" id="group_for"  value="<? if($group_for>0){ echo $group_for;}else{ echo find_a_field('requisition_fg_master','group_for','req_no="'.$_GET['req_no'].'"');}?>" />

</div><!--end row-->

<div class="row mt-2">
    
    
<div class="col-md-2">Carried By:</div>
<div class="col-md-2"><input type="text" name="carried_by" id="carried_by" value="<?=$carried_by?>" class="form-control" required/></div>    
   
   
    <div class="col-md-2">Note:</div>
    <div class="col-md-2"><input type="text" name="remarks" id="remarks" value="<?=$remarks?>" class="form-control" /></div>



<div class="col-md-1">TO:</div>
<div class="col-md-3">
<input name="warehouse_to" type="hidden" id="warehouse_to"  value="<?=$line_id?>" />
<input name="warehouse_from4" type="text" id="warehouse_from4" class="form-control" value="<?=find_a_field('warehouse','warehouse_name','warehouse_id='.$line_id)?>" />
</div>
</div><!--end row-->


<div class="row mt-2">
    
 
<div class="col-md-2">FG Requisition:</div>
<div class="col-md-2">
    
<? if($req_no=='pal'){ ?>   
    <select name="req_no" id="req_no">
        <option></option>
    <? $req_sql="select req_no,concat('Req-',req_no,' Date:',req_date) as name from requisition_fg_master where warehouse_id='".$line_id."' and status='CHECKED' limit 10";
    optionlist($req_sql); ?>
    </select>    
 <? }else{ ?>   
    <input type="text" name="req_no" id="req_no" value="<?=$req_no?>" class="form-control" readonly="readonly"/>
<? }?>
</div>   
<div class="col-md-2">Trasit Warehouse:</div>
<div class="col-md-2">
    <select name="transit_warehouse" type="text" id="transit_warehouse" required  >

    <? if($transit_warehouse!=''){ ?>
        <option value="<?=$transit_warehouse?>"><?=find_a_field('warehouse','warehouse_name','warehouse_id='.$transit_warehouse);?></option> 
    <? }else{?>
    <?
        foreign_relation('warehouse','warehouse_id','warehouse_name','','1 and warehouse_id!="'.$line_id.'"');    
    ?>
    <? } ?>
</select>
</div> 
<div class="col-md-4"><? if($prb>0) { echo $prb_note;} ?></div>

 

</div><!--end row-->


<div class="row">
    
<div class="col-md-12 text-center mt-2">
<? if($$unique_master>0) {?>
		
		<button type="submit" name="new" id="new" class="btn btn-success">Update Depot Transfer</button>
            <input name="flag" id="flag" type="hidden" value="1" />
            <? }else{?>
			  <button type="submit" name="new" id="new" class="btn btn-primary">Initite Depot Transfer</button>
            <input name="flag" id="flag" type="hidden" value="0" />
<? }?>
    
    
    </div>
</div>      
  

<table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">

    </table>
  </form>
  
  







<form action="" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
    
    
<? if($$unique_master>0){
$check_status=find_a_field('fg_issue_master','status','pi_no="'.$$unique_master.'"');
if($check_status!='MANUAL'){
    ?><script>window.location.href = "select_depot.php?pal=2";</script><?
}

?>




<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">

    <tr>

      <td><div class="tabledesign2">

      <table width="100%" align="center" cellpadding="0" cellspacing="0" id="grp" style="font-size:12px">

      <tbody>

          <tr>
            <th width="1%">SL</th>
            <th width="2%">FG Code</th>
            <th width="15%">Item Name </th>
            <th bgcolor="#FFFFFF">Note</th>
            <th bgcolor="#FFFFFF">Stock</th>
            <th bgcolor="#FFFFFF">Unit</th>
            <th bgcolor="#FF99FF">Req Qty</th>
            <th bgcolor="#FF99FF">Issued Qty</th>
            <th bgcolor="#F57E22">Issue Qty</th>
        </tr>
          
<? 
//$stock_opening_date=find_a_field('warehouse','stock_date','warehouse_id="'.$_SESSION['user']['depot'].'"');
//if($stock_opening_date!='0000-00-00'){
//$stock_date_con=' and ji_date>="'.$stock_opening_date.'"';
//}

$sql='select a.id,a.req_no,a.item_id,b.finish_goods_code as fg_code,b.item_name,b.pack_size,b.unit_name, a.qty, a.item_note
from requisition_fg_order a, item_info b 
where b.item_id=a.item_id and a.req_no='.$req_no.' order by a.id';

$res=db_query($sql);
while($row=mysqli_fetch_object($res)){



//$stock_sql="select sum(item_in-item_ex) from journal_item where item_id='".$row->item_id."' ".$stock_date_con." and warehouse_id='".$warehouse_from."'";
$stock = find_a_field('journal_item','sum(item_in-item_ex)','   item_id="'.$row->item_id.'" '.$stock_date_con.' and warehouse_id="'.$warehouse_from.'"  ');
?>

<tr>
    <td><?=++$ss;?></td>
    <td><?=$row->fg_code;?></td>
    <td><?=$row->item_name; ?> (Size: <?=$row->pack_size; ?>)
    			<input type="hidden" name="oid_<?=$row->id?>" id="oid_<?=$row->id?>" value="<?=$row->id?>" />
    			<input type="hidden" name="item_id_<?=$row->id?>" id="item_id_<?=$row->id?>" value="<?=$row->item_id?>" />	
    			<input type="hidden" name="stock_<?=$row->id?>" id="stock_<?=$row->id?>" value="<?=$stock?>" />	
    </td>
    <td width="10%" align="center"><?=$row->item_note?></td>
    <td width="2%" align="center"><?=$stock?></td>
    <td width="2%" align="center"><?=$row->unit_name?></td>
    <td width="2%" align="center"><?=$row->qty;?></td>
    <td width="2%" align="center">
        <?
       // $paid_qty = "select sum(total_unit) from fg_issue_detail where req_id='".$row->id."' and req_no='".$row->req_no."'";
        echo $issued_qty = find_a_field('fg_issue_detail','sum(total_unit)','  req_id="'.$row->id.'" and req_no="'.$row->req_no.'"  ');
        ?>
        </td>
    
            <input type="hidden" name="pending_<?=$row->id?>" id="pending_<?=$row->id?>" value="<?=($row->qty-$issued_qty)?>" />    


<td width="10%" align="center" bgcolor="#F57E22">

<? if($row->qty>$issued_qty){ $pp=$row->qty;?>        
        <input name="total_unit_<?=$row->id?>" type="text" id="total_unit_<?=$row->id?>" onchange="stock_check(<?=$row->id?>)" 
        value="<? if($stock>= ($row->qty-$issued_qty)) { echo $row->qty-$issued_qty; }else{ echo '';} ?>"  />
<? }else{ ?>
    Done
<? } ?>

<? if($pp>0){$cow++;} ?>

</td>
</tr>

<? } ?>
</tbody>
</table>


</div>

</td>
</tr>
</table>
<br/><br/><br/>




<?
if(isset($_POST['confirm_pertial'])){
    
$req_no = $_POST['req_no'];	
$pi_date = $_POST['pi_date'];

$page_for = 'Transit';

$sql='select a.id,a.*,b.finish_goods_code as fg_code,b.item_name,b.unit_name
from requisition_fg_order a, item_info b 
where b.item_id=a.item_id and a.req_no='.$req_no.' order by a.id';
$query = db_query($sql);

while($data=mysqli_fetch_object($query)){
    
    if($_POST['total_unit_'.$data->id]>0){
				
				$qty        = $_POST['total_unit_'.$data->id];
				
				
               // $rate       = find1("select cost_price from item_info where item_id='".$data->item_id."'");
				
				$rate =find_a_field('journal_item','final_price','item_id='.$data->item_id.' and final_price>0 order by id desc');
				
				//if($rate==0){
				
				//$rate = find1("select cost_price from item_info where item_id='".$data->item_id."'");
				
				//}
				
				
				$amount     =$qty*$rate; 
                
				$dateTimeString = date('Y-m-d H:i:s'); 
				$dateTime = new DateTime($dateTimeString);
				$dateTime->modify('-5 minutes');
				$min5age = $dateTime->format('Y-m-d H:i:s');                
                
                $check_old=find_a_field('fg_issue_detail','id','  pi_no="'.$$unique_master.'" and item_id="'.$data->item_id.'" and entry_at>"'.$min5age.'"  ');
				//("select id from fg_issue_detail where pi_no='".$$unique_master."' and item_id='".$data->item_id."' and entry_at>'".$min5age."'");
                if($check_old==''){
                    
                    $check_old_item = find_a_field('fg_issue_detail','id','  item_id ="'.$data->item_id.'" and pi_no="'.$$unique_master.'"  ');
					//("select id from fg_issue_detail where item_id ='".$data->item_id."' and pi_no='".$$unique_master."' limit 1");
                    if($check_old_item==''){ 
                
                    $sql = 'INSERT INTO fg_issue_detail (pi_no, pi_date, item_id, warehouse_from,warehouse_to,total_unit, unit_price, total_amt,req_no,req_id)
                    
                    VALUES("'.$$unique_master.'", "'.$_POST['pi_date'].'", "'.$data->item_id.'", "'.$data->warehouse_to.'","'.$data->warehouse_id.'", "'.$qty.'"
                    ,"'.$rate.'","'.$amount.'","'.$data->req_no.'","'.$data->id.'")';
                    
                    db_query($sql);
                    $tr_id = db_insert_id();
                    
    				journal_item_control($data->item_id,$data->warehouse_to,$pi_date,0,$qty,$page_for,$tr_id,$rate,$_POST['transit_warehouse'],$$unique_master,'','',$_SESSION['user']['group'],'');
                    journal_item_control($data->item_id,$_POST['transit_warehouse'],$pi_date,$qty,0,$page_for,$tr_id,$rate,$data->warehouse_id,$$unique_master,'','',$_SESSION['user']['group'],'');




                    }

                }

    }

}


    $usql="update requisition_fg_master set status='PENDING' where req_no='".$req_no."'";
    db_query($usql);


		unset($_POST);
		$_POST[$unique_master]=$$unique_master;
		$_POST['entry_at']=date('Y-m-d H:i:s');
		$_POST['status']='SEND';
		$pi = find_all_field('fg_issue_master','pi_no','pi_no='.$$unique_master);

        
        // $usql="update requisition_fg_master set status='COMPLETE' where req_no='".$req_no."'";
        // mysql_query($usql);
		
		$crud   = new crud($table_master);
		$crud->update($unique_master);
		$crud   = new crud($table_detail);
		$crud->update($unique_master);
		
		$pi_no=$$unique_master;
		unset($$unique_master);
		unset($_POST[$unique_master]);
		
		$type=1;
		$msg='Successfully Send.';
		//redirect('fg_receive_report_all.php');
		
		header("Location: fg_receive_report_all.php");
		?><script>
// window.lcation.href = "print_view.php?req_no=<?=$pi_no?>";
</script><?

    
} // end final confirm



if(isset($_POST['confirm'])){
    
$req_no = $_POST['req_no'];	
$pi_date = $_POST['pi_date'];


$page_for = 'Transit';


$sql='select a.id,a.*,b.finish_goods_code as fg_code,b.item_name,b.unit_name
from requisition_fg_order a, item_info b 
where b.item_id=a.item_id and a.req_no='.$req_no.' order by a.id';
$query = db_query($sql);

while($data=mysqli_fetch_object($query)){
    
    if($_POST['total_unit_'.$data->id]>0){
				
				$qty        = $_POST['total_unit_'.$data->id];
				
				
				
				$rate =find_a_field('journal_item','final_price','item_id='.$data->item_id.' and final_price>0 order by id desc');
				
				
				$amount     = $qty*$rate; 
 
 
                $check_old_item = find_a_field('fg_issue_detail','id','item_id='.$data->item_id.' and pi_no='.$$unique_master); 

                if($check_old_item==''){
 
                $sql = 'INSERT INTO fg_issue_detail (pi_no, pi_date, item_id, warehouse_from,warehouse_to,total_unit, unit_price, total_amt,req_no,req_id)
                
                VALUES("'.$$unique_master.'", "'.$_POST['pi_date'].'", "'.$data->item_id.'", "'.$data->warehouse_to.'","'.$data->warehouse_id.'", "'.$qty.'"
                ,"'.$rate.'","'.$amount.'","'.$data->req_no.'","'.$data->id.'")';
                
                db_query($sql);
                $tr_id = db_insert_id();


				
				journal_item_control($data->item_id,$data->warehouse_to,$pi_date,0,$qty,$page_for,$tr_id,$rate,$_POST['transit_warehouse'],$$unique_master,'','',$_SESSION['user']['group'],'');
                journal_item_control($data->item_id,$_POST['transit_warehouse'],$pi_date,$qty,0,$page_for,$tr_id,$rate,$data->warehouse_id,$$unique_master,'','',$_SESSION['user']['group'],'');
            }
    }

}


    $usql="update requisition_fg_master set status='COMPLETE' where req_no='".$req_no."'";
    db_query($usql);


		unset($_POST);
		$_POST[$unique_master]=$$unique_master;
		$_POST['entry_at']=date('Y-m-d H:i:s');
		$_POST['status']='SEND';
		$pi = find_all_field('fg_issue_master','pi_no','pi_no='.$$unique_master);

		
		$crud   = new crud($table_master);
		$crud->update($unique_master);
		$crud   = new crud($table_detail);
		$crud->update($unique_master);
		
		$pi_no=$$unique_master;
		unset($$unique_master);
		unset($_POST[$unique_master]);
		
		$type=1;
		$msg='Successfully Send.';
		header('location:fg_receive_report_all.php');

		?>
        
        <script>
// window.lcation.href = "print_view.php?req_no=<?=$pi_no?>";
</script><?

    
} // end final confirm




if($cow<1){
    $usql="update requisition_fg_master set status='COMPLETE' where req_no='".$req_no."'";
    db_query($usql);
}




if(isset($_POST['delete'])){

		$crud   = new crud($table_master);
		$condition=$unique_master."=".$$unique_master;		
		$crud->delete($condition);
		$crud   = new crud($table_detail);
		$crud->delete_all($condition);
		unset($$unique_master);
		unset($_POST[$unique_master]);
		$type=1;
		$msg='Successfully Deleted.';
        header('location:fg_receive_report_all.php');
}



?>
 
  
<table width="100%" border="0">
<tr>
        
<td align="right" style="text-align:right">
    <input name="delete" type="submit" class="btn btn-danger" value="CANCEL" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:white; float:left" />
</td>


<td>
    <input name="confirm" type="submit" class="btn btn-info" value="Final CONFIRM" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:white;" />
</td>

<td>
    <input name="confirm_pertial" type="submit" class="btn btn-warning" value="Partial Delivery" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:white;" />
</td>


		<input  name="pi_no" type="hidden" id="pi_no" value="<?=$$unique_master?>"/>
		<input  name="req_no" type="hidden" id="req_no" value="<?=$req_no?>"/>
        <input  name="pi_date" type="hidden" id="pi_date" value="<?=$pi_date?>"/>
        <input  name="transit_warehouse" type="hidden" id="transit_warehouse" value="<?=$transit_warehouse?>"/>
    </td>
</tr>
</table>
    <? }?>
  </form>
</div>




<script>
    function stock_check(id){
        var stk = document.getElementById("stock_"+id).value*1;
        var pend = document.getElementById("pending_"+id).value*1;
        var qty = document.getElementById("total_unit_"+id).value*1;

        if(stk<qty){
            alert("Please check item Stock");
             document.getElementById("total_unit_"+id).value="";
        }
        if(pend<qty){
            alert("Please check item Pending qty");
             document.getElementById("total_unit_"+id).value="";
        }
    }
</script>


<script>
function getData(){
    
var id = document.getElementById("item_id").value;

		jQuery.ajax({
			url:'depot_transfer_ajax.php',
			type:'post',
			data:'id='+id,
			success:function(result){
				var json_data=jQuery.parseJSON(result);

				jQuery('#item_name').val(json_data.item_name);
				jQuery('#unit_name').val(json_data.unit);
				jQuery('#unit_price').val(json_data.price);
				jQuery('#stock').val(json_data.stock);

			}

		})
	
}
</script> 


<?



require_once SERVER_CORE."routing/layout.bottom.php";



?>
