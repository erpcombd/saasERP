<?php





require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Depot Transfer';


do_calander('#pi_date','-30','0');
//do_calander('#old_production_date');

$page = 'depot_transfer_entry.php';
if($_REQUEST['line_id']>0){  
$line_id = $_SESSION['line_id']=$_REQUEST['line_id'];
}elseif($_SESSION['line_id']>0){ 
$line_id = $_REQUEST['line_id']=$_SESSION['line_id'];
}


$table_master='fg_issue_master';
$unique_master='pi_no';


$table_detail='fg_issue_detail';
$unique_detail='id';

//var_dump($_REQUEST);

if($_REQUEST['old_pi_no']>0)

echo $$unique_master=$_REQUEST['old_pi_no'];

elseif(isset($_GET['del'])){

$$unique_master=find_a_field($table_detail,$unique_master,'id='.$_GET['del']); $del = $_GET['del'];

}

else

$$unique_master=$_REQUEST[$unique_master];

//if($_SESSION[$unique_master]>0)
//$$unique_master=$_SESSION[$unique_master];
//elseif(isset($_GET['del']))
//{
//$$unique_master=find_a_field($table_detail,$unique_master,'id='.$_GET['del']); $del = $_GET['del'];
//}
//else
//$$unique_master=$_REQUEST[$unique_master];



if(prevent_multi_submit()){

if(isset($_POST['new'])){

		$crud   = new crud($table_master);
		$_POST['entry_at']=date('Y-m-d H:i:s');
		$_POST['entry_by']=$_SESSION['user']['id'];
		$_POST['status']='MANUAL';
		
		if($_POST['flag']<1){
    		$$unique_master=$crud->insert();
    		
    		
        // Auto Insert fg requisition item
        if($_POST['req_no']>0){
            
            $new_pi_no      = $$unique_master;
            $req_no         = $_POST['req_no'];
            $pi_date        = $_POST['pi_date'];
            $warehouse_from = $_POST['warehouse_from'];
            $warehouse_to   = $_POST['warehouse_to'];
        
                $psql="select * from requisition_fg_order where req_no='".$req_no."' order by id desc";
                $query=mysql_query($psql);
                while($info=mysql_fetch_object($query)){
                
                    $check_old_item = find1("select count(id) from fg_issue_detail where item_id ='".$info->item_id."' and req_id='".$info->id."'");
                    if($check_old_item>0){
                            
                    }else{
                
                        $unit_price = find1("select cost_price from item_info where item_id='".$info->item_id."'");
                        $total_amt= $unit_price*$info->qty;
                        
                        $ins_query="insert into fg_issue_detail(pi_no, pi_date, item_id, warehouse_from, warehouse_to, total_unit, unit_price, total_amt)
                            values
                            ('$new_pi_no','$pi_date',$info->item_id,$warehouse_from,$warehouse_to,$info->qty,$unit_price,$total_amt)
                            ";
                            mysql_query($ins_query);
                
                    } // end if old    
                    
                } // enb while
        
            $cp++;
        } // --------- end


// Auto Insert replace item		
if($_POST['replace_no']>0){
    
    $new_pi_no      = $$unique_master;
    $replace_no     = $_POST['replace_no'];
    $pi_date        = $_POST['pi_date'];
    $warehouse_from = $_POST['warehouse_from'];
    $warehouse_to   = $_POST['warehouse_to'];

    $psql2="select * from warehouse_replace_issue_detail where oi_no='".$replace_no."' order by id desc";
    $query2=db_query($psql2); 
    while($info2=mysqli_fetch_object($query2)){
    
    $unit_price = find1("select cost_price from item_info where item_id='".$info2->item_id."'");
    $total_amt= $unit_price*$info2->qty;
    
    $ins_query2="insert into fg_issue_detail(pi_no, pi_date, item_id, warehouse_from, warehouse_to, total_unit, unit_price, total_amt)
    values
    ('$new_pi_no','$pi_date',$info2->item_id,$warehouse_from,$warehouse_to,$info2->qty,$unit_price,$total_amt)";
    db_query($ins_query2);
    }
} // ----------------- end  


    		
    		
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
            
		    $check_old_item=find_a_field('fg_issue_detail','item_id','  pi_no="'.$$unique_master.'" and item_id="'.$_POST['item_id'].'" ');
            if($check_old_item==''){     
		            $xid = $crud->insert();
            }
       
        }


}

}

else

{

	$type=0;

	$msg='Data Re-Submit Error!';

}



if(isset($_GET['del']) && ($_GET['del']>0) )

{	
		$del=$_GET['del'];
		$crud   = new crud($table_detail);

		$condition=$unique_detail."=".$del;		

		$crud->delete_all($condition);

		$sql = "delete from journal_item where tr_from = 'Transit' and tr_no = '".$del."'";

		db_query($sql);

		$type=1;

		$msg='Successfully Deleted.';

}



if($$unique_master>0)

{

		$condition=$unique_master."=".$$unique_master;

		$data=db_fetch_object($table_master,$condition);

		//while (list($key, $value)=each($data))
		 foreach ($data as $key => $value)

		{ $$key=$value;}

		

}

if($warehouse_to>0){
    $line_id=$warehouse_to;
}

//auto_complete_from_db('item_info','concat(item_name,"#>",item_description,"#>",item_id)','concat(item_name,"#>",item_description,"#>",item_id)','1','item_id');?>
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
<select name="warehouse_from" type="text" id="warehouse_from"   required  >


<? foreign_relation('warehouse_define d,warehouse w','w.warehouse_id','w.warehouse_name',$warehouse_from,'w.warehouse_id=d.warehouse_id and d.user_id="'.$_SESSION['user']['id'].'" ');?>
</select>
<?php /*?><input name="warehouse_from3" type="text" id="warehouse_from3" class="form-control" value="<?=find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_from)?>" required/><?php */?>
    </div>

</div><!--end row-->

<div class="row mt-2">
    
    
<div class="col-md-2">Carried By:</div>
<div class="col-md-2"><input type="text" name="carried_by" id="carried_by" value="<?=$carried_by?>" class="form-control" required/></div>    
   
   
    <div class="col-md-2">Note:</div>
    <div class="col-md-2"><input type="text" name="remarks" id="remarks" value="<?=$remarks?>" class="form-control" /></div>



<div class="col-md-1">TO:</div>
<div class="col-md-3">
<input name="warehouse_to" type="hidden" id="warehouse_to"  value="<?=$line_id?>" required/>
<input name="warehouse_from4" type="text" id="warehouse_from4" class="form-control" value="<?=find_a_field('warehouse','warehouse_name','warehouse_id='.$line_id)?>" required/>
</div>
</div><!--end row-->


<div class="row mt-2">
        <div class="col-md-2">Company:</div>
        <div class="col-md-2">
        <? $field='group_for';?>
            <select  id="group_for" name="group_for" class="form-control" required>
            <? if($$field>0){ ?>
            <option value="<?=$$field?>"><?=find_a_field('user_group','group_name','id="'.$$field.'"');?></option> 
            <? }else{ ?>
            <option></option>
            <? foreign_relation('user_group','id','group_name',$group_for,'1 order by group_name');?>
            <? } ?>
            </select>
        </div>  
        
<? if($line_id==69 || $_SESSION['user']['depot']==69){?>        
        <div class="col-md-2">Returnable:</div>
        <div class="col-md-2">
        <? $field='returnable';?>
            <select  id="returnable" name="returnable" class="form-control" >
            <? if($$field!=''){ ?>
            <option value="<?=$$field?>"><?=$$field?></option>
            <option></option>
            <? }else{ ?>
            <option></option>
            <option>YES</option>
            <? } ?>
            </select>
        </div> 
<? }?>        
 
</div><!--end row-->


<div class="row mt-2">
<div class="col-md-2">Replace No:</div>
<div class="col-md-2">
<input type="text" name="replace_no" id="replace_no" value="<?=$replace_no?>" class="form-control" />
</div></div>




<div class="row mt-2">
    
 
<?php /*?><div class="col-md-2">FG Requisition:</div>
<div class="col-md-2">
    
<? if($req_no==''){ ?>   
    <select name="req_no" id="req_no">
        <option></option>
    <? $req_sql="select req_no,concat('Req-',req_no,' Date:',req_date) as name from requisition_fg_master where warehouse_id='".$line_id."' and status='CHECKED' limit 10";
    optionlist($req_sql); ?>
    </select>    
 <? }else{ ?>   
    <input type="text" name="req_no" id="req_no" value="<?=$req_no?>" class="form-control" readonly="readonly"/>
<? }?>
</div> <?php */?>  
  

</div><!--end row-->


<div class="row">
    <div class="col-md-12 text-center mt-2">

<? if($$unique_master>0) {

$check_status=find_a_field('fg_issue_master','status','pi_no="'.$$unique_master.'"');
if($check_status!='MANUAL'){
    ?><script>window.location.href = "select_depot.php?pal=2";</script><?
}

?>
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
  
  
  
  
  
  <form action="<?=$page?>" method="post" name="codz2" id="codz2">
    <? $merge_flag=find_a_field(' fg_issue_master','entry_by','pi_no='.$$unique_master);?>

<? if($merge_flag == $_SESSION['user']['id']){ ?>

<? if($$unique_master>0){?>
    <table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">
      <tr>
        <td align="center" width="10%" bgcolor="#0099FF"><strong>Item Code</strong></td>
        <td align="center" width="30%" bgcolor="#0099FF"><strong>Item Name</strong></td>
        <td align="center" width="10%" bgcolor="#0099FF"><strong>Note</strong></td>
        <td align="center"  bgcolor="#0099FF"><span style="font-weight: bold">Unit</span></td>
        <td align="center"  bgcolor="#0099FF"><strong>Stock</strong> </td>
        <td align="center"  bgcolor="#0099FF"><strong>Rate</strong></td>
        <td align="center"  bgcolor="#0099FF"><strong>Qty</strong></td>
        <td align="center" width="11%" bgcolor="#0099FF"><strong>Amount</strong></td>
        
        <td  rowspan="2" width="11%" align="center" bgcolor="#FF0000"><div class="button"><input name="add" type="submit" id="add" value="ADD" tabindex="12" class="update" onclick="recal();"/></div></td>
      </tr>

<tr>
        <td align="center" bgcolor="#CCCCCC"><div align="center">
            <input  name="<?=$unique_master?>" type="hidden" id="<?=$unique_master?>" value="<?=$$unique_master?>"/>
            <input  name="warehouse_from" type="hidden" id="warehouse_from" value="<?=$warehouse_from?>"/>
            <input  name="warehouse_to" type="hidden" id="warehouse_to" value="<?=$warehouse_to?>"/>
            <input  name="pi_date" type="hidden" id="pr_date" value="<?=$pi_date?>"/>
            <input  name="returnable" type="hidden" id="returnable" value="<?=$returnable?>"/>
            <input name="remarks" type="hidden" id="remarks" style="width:105px;" value="<?=$remarks?>" tabindex="105" />


<? 
// if($returnable=='YES' && $_SESSION['user']['depot']==69){

// // item in
// $sqlsend='select i.item_id,sum(p.total_unit) as qty from item_info i, fg_issue_detail p 
// where i.item_id=p.item_id and p.warehouse_to=69 and warehouse_from="'.$warehouse_to.'"  and returnable="YES" group by i.item_id order by i.item_name';
// $q1=mysql_query($sqlsend);
// while($d1=mysql_fetch_object($q1)){
//     $itemin[$d1->item_id]=$d1->qty;
// }

// // item out
// $sqlreturn='select i.item_id,sum(p.total_unit) as qty from item_info i, fg_issue_detail p 
// where i.item_id=p.item_id and p.warehouse_to="'.$warehouse_to.'" and warehouse_from=69  and returnable="YES" group by i.item_id order by i.item_name';
// $q2=mysql_query($sqlreturn);
// while($d2=mysql_fetch_object($q2)){
//     $itemout[$d2->item_id]=$d2->qty;
// }

// $sqllist='select i.item_id from item_info i, fg_issue_detail p 
// where i.item_id=p.item_id and p.warehouse_to=69 and warehouse_from="'.$warehouse_to.'"  order by i.item_name';
// $q3=mysql_query($sqllist);
// $item_list='';
// $mi = 0;
// while($d3=mysql_fetch_object($q3)){
//     if($itemin[$d3->item_id]-$itemout[$d3->item_id]>0){
        
//         if($mi==0)
// 			$item_list = $d3->item_id;
// 		else
// 			$item_list.= ','.$d3->item_id; $mi++;

//     }
// }

    
// } 
// end if

?>


<input list="items" name="item_id" type="text" class="form-control"  value="" id="item_id" style="width:90%; height:30px;" onChange="getData()" autocomplete="off" autofocus/>
 <datalist id="items">
  <?php 
//if($returnable=='YES' && $_SESSION['user']['depot']==69){
    
    //$sqlr='select i.item_id,concat(i.finish_goods_code," # ",i.item_name) from item_info i where item_id in ('.$item_list.') order by i.item_name';
  
  //optionlist($sqlr);
  
//}else{  
 foreign_relation('item_info','item_id','concat(finish_goods_code," # ",item_name)',$item_id,'1 and group_for="'.$group_for.'" order by item_name');
// optionlist('select item_id,concat(finish_goods_code," # ",item_name) from item_info where 1 and group_for="'.$group_for.'" order by item_name');
//}  
  ?>
 </datalist>          
</div></td>

<td><input name="item_name" type="text" class="form-control" id="item_name" value="" required/></td>        
<td><input name="note" type="text" class="form-control" id="note" value=""/></td>
<td><input name="unit_name" type="text" class="form-control" id="unit_name" value=""/></td>
<td><input name="stock" type="text" class="form-control" id="stock" value=""/></td>
<td><input name="unit_price" type="text" class="form-control" id="unit_price" value="" onkeyup="stock_check(); total_amtt()" required/></td>
<td align="center" bgcolor="#CCCCCC"><input name="total_unit" type="text" class="form-control" id="total_unit" required onkeyup="stock_check(); total_amtt()"/>
<td align="center" bgcolor="#CCCCCC"><input name="total_amt" type="text" class="input3" id="total_amt"  style="width:98%;" required="required"/></td>
</tr>


</table>
    <br />
    <br />
    <br />
    <br />













    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><div class="tabledesign2">
            <? 
 $res='select a.id,b.finish_goods_code as FG_code,b.item_name,a.note,b.unit_name, a.total_unit as total_qty, a.unit_price, a.total_amt, "X" 
from fg_issue_detail a,item_info b 
where b.item_id=a.item_id and a.pi_no='.$$unique_master.' order by a.id';
echo link_report_add_del_auto($res,2,6,8);

		?>
          </div></td>
      </tr>
      <tr>
        <td></td>
      </tr>
    </table>
  </form>
  <form action="select_depot.php" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
    <table width="100%" border="0">
      <tr>
        <td align="center"><input  name="pi_no" type="hidden" id="pi_no" value="<?=$$unique_master?>"/></td>
        <td align="right" style="text-align:right">
		<input name="delete" type="submit" class="btn btn-danger" value="DELETE DT" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:white; float:left" />
		
		<input name="confirm" type="submit" class="btn btn-info" value="CONFIRM AND SEND DT" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:white; float:right" />
        </td>
      </tr>
    </table>
    <? }?>
	
	 <? }?>
  </form>
</div>
<!--<script>$("#cz").validate();$("#cloud").validate();</script>-->
<script>
    function stock_check(){ 
        var stk = document.getElementById("stock").value*1;
        var qty = document.getElementById("total_unit").value*1;
        var avail = stk-qty;
        if((avail)<0){
            alert("Please check item Stock");
             document.getElementById("item_id").value="";
             document.getElementById("total_unit").value="";
             document.getElementById("unit_price").value="";
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
