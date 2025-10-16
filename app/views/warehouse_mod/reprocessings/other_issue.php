<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='KIT Pack Reproccesing Issue';
$page = "other_issue.php";
$page_for = 'Reprocess Issue';
$ajax_page = "other_issue_ajax.php";
$ajax_page2 = "other_issue_ajax2.php";
$tr_type="Show";
do_calander('#oi_date','-200','0');

$table_master='warehouse_other_issue';
$table_details='warehouse_other_issue_detail';
$unique='oi_no';
		$config = find_all_field('config_group_class','issued_to','group_for='.$_SESSION['user']['group']);

if($_GET['mhafuz']==2){
unset($_SESSION[$unique]);
}elseif($_GET['oi_no']){
$_SESSION[$unique]=$_GET['oi_no'];
}


if(isset($_POST['new']))
{
		$crud   = new crud($table_master);

		if(!isset($_SESSION[$unique])) {
		$_POST['entry_by']=$_SESSION['user']['id'];
		$_POST['entry_at']=date('Y-m-d h:s:i');
		$_POST['edit_by']=$_SESSION['user']['id'];
		$_POST['edit_at']=date('Y-m-d h:s:i');
		$$unique=$_SESSION[$unique]=$crud->insert();
		unset($$unique);
		$type=1;
		$msg=$title.'  No Created. (No :-'.$_SESSION[$unique].')';
		$tr_type="Initiate";
		}
		else {
		$_POST['edit_by']=$_SESSION['user']['id'];
		$_POST['edit_at']=date('Y-m-d h:s:i');
		$crud->update($unique);
		$type=1;
		$msg='Successfully Updated.';
		$tr_type="Add";
		}
}

$$unique=$_SESSION[$unique];

if(isset($_POST['delete']))
{
		$select_ql = "select id from warehouse_other_issue_detail where oi_no = ".$$unique." ";
		$squery = db_query($select_ql);
		while($re = mysqli_fetch_object($squery)){
		
		$sql = "delete from journal_item where tr_from = '".$page_for."' and tr_no = '".$re->id."'";
		db_query($sql);
		}
		
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
		$tr_type="Delete";
		header("Location:other_issue.php?new=2");
}

if($_GET['del']>0)
{
		$crud   = new crud($table_details);
		$condition="id=".$_GET['del'];		
		$crud->delete_all($condition);
		
		$sql = "delete from journal_item where tr_from = '".$page_for."' and tr_no = '".$_GET['del']."'";
		db_query($sql);
		$type=1;
		$msg='Successfully Deleted.';
		$tr_type="Remove";
		
}
if(isset($_POST['confirmm']))
{
		unset($_POST);
		$_POST[$unique]=$$unique;
		$_POST['entry_by']=$_SESSION['user']['id'];
		$_POST['entry_at']=date('Y-m-d h:s:i');
		$_POST['status']='UNCHECKED';
		$crud   = new crud($table_master);
		$crud->update($unique);
		$tr_type="Complete";
	//	$cc_code = find_a_field_sql('select c.id from cost_center c, warehouse w where c.cc_code=w.acc_code and w.warehouse_id='.$_SESSION['user']['depot']);
//		
//		$sql = "select * from warehouse_other_issue_detail where oi_no =".$$unique;
//		$query = db_query($sql);
//		while($data = mysqli_fetch_object($query))
//		{
//		journal_item_control($data->item_id ,$_SESSION['user']['depot'],$data->oi_date,0,$data->qty,$page_for,$data->id,$data->rate,'',$$unique);
//		$amount = $amount + ($data->qty*$data->rate);
//		}
//		$oi = find_all_field('warehouse_other_issue','issued_to','oi_no='.$$unique);
//		$config = find_all_field('config_group_class','issued_to','group_for='.$_SESSION['user']['group']);
//
//		$issued_to = $oi->issued_to;
//		$val = 'rp_'.$issued_to;
//		$vendor_ledger = $config->{$val};
//		
//		$jv=next_journal_sec_voucher_id('','Reprocess Issue');
//		$sales_ledger = find_a_field('warehouse','ledger_id','warehouse_id='.$_SESSION['user']['depot']);
//		auto_insert_process_issue_secoundary($jv,strtotime($oi->oi_date),$vendor_ledger,$sales_ledger,$$unique,$amount,$$unique,$oi->requisition_from,$cc_code);
//		
	unset($$unique);
		unset($_SESSION[$unique]);
	$type=1;
		$msg='Successfully Forwarded.';
		header("Location:other_issue.php?new=2");
}

if(isset($_POST['add'])&&($_POST[$unique]>0))
{
		$crud   = new crud($table_details);
		$iii=explode('#>',$_POST['item_id']);
		$_POST['item_id']=$iii[1];
		$_POST['entry_by']=$_SESSION['user']['id'];
		$_POST['entry_at']=date('Y-m-d h:s:i');
		$_POST['edit_by']=$_SESSION['user']['id'];
		$_POST['edit_at']=date('Y-m-d h:s:i');
		$_POST['warehouse_id'] = $_SESSION['user']['depot'];
		$xid = $crud->insert();
		journal_item_control($_POST['item_id'] ,$_SESSION['user']['depot'],$_POST['oi_date'],0,$_POST['qty'],$_POST['issue_type'],$xid,$_POST['rate']);
		header("Location:other_issue.php?oi_no=".$_POST[$unique]);
		$tr_type="Add";
}

if(isset($_POST['add2'])&&($_POST[$unique]>0))
{
		$crud   = new crud($table_details);
		$iii=explode('#>',$_POST['item_id2']);
		$_POST['item_id']=$iii[1];
		$_POST['entry_by']=$_SESSION['user']['id'];
		$_POST['entry_at']=date('Y-m-d H:i:s');
		$_POST['edit_by']=$_SESSION['user']['id'];
		$_POST['edit_at']=date('Y-m-d h:s:i');
		$_POST['warehouse_id'] = $_SESSION['user']['depot'];
		$xid = $crud->insert();
		journal_item_control($_POST['item_id'] ,$_SESSION['user']['depot'],$_POST['oi_date'],$_POST['qty'],0,$_POST['issue_type'],$xid,$_POST['rate']);
		header("Location:other_issue.php?oi_no=".$_POST[$unique]);
		$tr_type="Add";
		
}
if($$unique>0)
{
		$condition=$unique."=".$$unique;
		$data=db_fetch_object($table_master,$condition);
		foreach ($data as $key => $value)
		{ $$key=$value;}
		
}
if($$unique>0) $btn_name='Update RI Information'; else $btn_name='Initiate RI Information';
if($_SESSION[$unique]<1)
$$unique=db_last_insert_id($table_master,$unique);

//auto_complete_from_db($table,$show,$id,$con,$text_field_id);
$depot_type = find_a_field('warehouse','use_type','warehouse_id="'.$_SESSION['user']['depot'].'"');

auto_complete_from_db('item_info','item_name','concat(item_name,"#>",item_id)','1','item_id');
auto_complete_from_db('item_info','item_name','concat(item_name,"#>",item_id)','1','item_id2');
$tr_from="Warehouse";
?>
<script language="javascript">
function focuson(id) {
  if(document.getElementById('item_id').value=='')
  document.getElementById('item_id').focus();
  else
  document.getElementById(id).focus();
}
window.onload = function() {
if(document.getElementById("warehouse_id").value>0)
  document.getElementById("item_id").focus();
  else
  document.getElementById("req_date").focus();
}
</script>
<script language="javascript">
function count()
{
var num=((document.getElementById('qty').value)*1)*((document.getElementById('rate').value)*1);
document.getElementById('amount').value = num.toFixed(2);	
}
function count2()
{

var num2=((document.getElementById('qty2').value)*1)*((document.getElementById('rate2').value)*1);
document.getElementById('amount2').value = num2.toFixed(2);
}
</script>




<!--Mr create 2 form with table-->
<div class="form-container_large">
    <form action="other_issue.php" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
<!--        top form start hear-->
        <div class="container-fluid bg-form-titel">
            <div class="row">
                <!--left form-->
                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <div class="container n-form2">
                        <div class="form-group row m-0 pb-1">
							<? $field='oi_no';?>
                            <label for="do_no" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Kit Pack Issue No</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                      
          					  <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" class="form-control" />
		       				  </div>
                        </div>

                        <div class="form-group row m-0 pb-1">
							  <? $field='oi_date'; if($oi_date=='') $oi_date =''; ?>
                            <label for="dealer_code" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Kit Pack Issue Date</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                              
           
          						 <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" class="form-control" autocomplete="off" required />
        
                            </div>
                        </div>

                        <div class="form-group row m-0 pb-1">
						<? $field='requisition_from';?>
                            <label for="wo_detail" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Serial No</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                          
           						<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" class="form-control" />
    

                            </div>
                        </div>

                    </div>



                </div>

                <!--Right form-->
                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <div class="container n-form2">
                        <div class="form-group row m-0 pb-1">
								<? $field='oi_subject';?>
                            <label for="cust_name" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Note</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                
          					  <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" class="form-control" autocomplete="off" />
                            </div>
                        </div>

                        <div class="form-group row m-0 pb-1">
								   <? $field='approved_by';?>
                            <label for="rcv_amt" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Approved By</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                              
								<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" class="form-control" />
								<input  name="issue_type" type="hidden" id="issue_type" value="Reprocess Issue" class="form-control" />
        
                            </div>
                        </div>

                        

                    </div>



                </div>


            </div>

            <div class="n-form-btn-class">
                <input name="new" type="submit" class="btn1 btn1-submit-input" value="<?=$btn_name?>"/>
            </div>
        </div>

        
        
    </form>


<? if($_SESSION[$unique]>0){?>

    <form action="?<?=$unique?>=<?=$$unique?>" method="post" name="cloud" id="cloud">
        <!--Table input one design-->
        <div class="container-fluid pt-5 p-0 ">


            <table class="table1  table-striped table-bordered table-hover table-sm">
                <thead class="thead1">
                <tr class="bgc-info">
                    <th>Item Name</th>
                    <th>Unit</th>
                    <th>Price</th>
				    <th>Qty</th>
                    <th>Amount</th>
                  
                </tr>
                </thead>

                <tbody class="tbody1">
				<tr>
					<td align="center">
					<?php 
					$page_for = 'Reprocess Issue';
					?>
					  <input  name="issue_type" type="hidden" id="issue_type" value="<?=$page_for?>"  required="required"/>
					  <input  name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>
					<input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$warehouse_id?>"/>
					<input  name="oi_date" type="hidden" id="oi_date" value="<?=$oi_date?>"/>
					<input  name="issued_to" type="hidden" id="issued_to" value="<?=$issued_to?>"/>
					<input  name="item_id" type="text" id="item_id" value="<?=$item_id?>" required onblur="getData2('<?=$ajax_page?>', 'po',this.value,document.getElementById('warehouse_id').value);"/>
					</td>
					<td>
					<span id="po">
					<input name="unit_name" type="text" class="input3" id="unit_name" readonly="readonly"/>
					<input name="rate" type="text" class="input3" id="rate"  />
					</span></td>
					<td align="center"><input name="qty" type="text" class="input3" id="qty"  onchange="count()" required/></td>
					<td align="center"><input name="amount" type="text" class="input3" id="amount"  readonly="readonly" required/></td>
					<td>
						 
						  <input name="add" type="submit" id="add" value="ADD" tabindex="12" class="btn1 btn1-bg-submit"/>                       
						 </td>
      </tr>
					
					<? 
				$res='select a.id,b.item_name,a.rate as unit_price,a.qty ,a.unit_name,a.amount,"x" from warehouse_other_issue_detail a,item_info b where b.item_id=a.item_id and a.issue_type="Reprocess Issue" and a.oi_no='.$oi_no;
				echo link_report_add_del_auto($res,'',6);
				?>
                </tbody>
            </table>

</form>



        </div>
		
		<div class="alert alert-info p-2 text-center font-weight-bold" role="alert">
 			Kit Pack Receive
		</div>


      <form action="?<?=$unique?>=<?=$$unique?>" method="post" name="cloud" id="cloud">  <!--Data multi Table design start-->
        <div class="container-fluid pt-5 p-0 ">

            <table class="table1  table-striped table-bordered table-hover table-sm">
                <thead class="thead1">
                <tr class="bgc-info">
                   
                        <td>Item Name</td>
                        <td>Unit</td>
                        <td>Rate</td>
                        <td>Qty</td>
                        <td>Total Amt</td>
                          <td>
						 
						  <input name="add2" type="submit" id="add2" value="ADD" tabindex="12" class="btn1 btn1-bg-submit"/>						 	 </td>
     			</tr>
                </thead>

                <tbody class="tbody1">

               
            <tr>
			  <td align="center">
				<?php 
				$page_for = 'Reprocess Receive';
				?>
				  <input  name="issue_type" type="hidden" id="issue_type" value="<?=$page_for?>"  required="required"/>
				  <input  name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>
				<input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$warehouse_id?>"/>
				<input  name="oi_date" type="hidden" id="oi_date" value="<?=$oi_date?>"/>
				<input  name="issued_to" type="hidden" id="issued_to" value="<?=$issued_to?>"/>
				<input  name="item_id2" type="text" id="item_id2" value="<?=$item_id2?>" required onblur="getData2('other_issue_ajax2.php', 'po2',this.value,document.getElementById('warehouse_id').value);"/></td>
				<td colspan="2" align="center">
				<span id="po2">
				<input name="unit_name" type="text" class="input3" id="unit_name"  readonly="readonly"/>
				<input name="rate" type="text" class="input3" id="rate2"  />
				</span></td>
				<td align="center" ><input name="qty" type="text" class="input3" id="qty2"  onchange="count2()" required/></td>
				<td align="center"><input name="amount" type="text" class="input3" id="amount2"  readonly="readonly" required/></td>
      </tr>
                </tbody>
				<? 
			$res='select a.id,b.item_name,a.rate as unit_price,a.qty ,a.unit_name,a.amount,"x" from warehouse_other_issue_detail a,item_info b where b.item_id=a.item_id and a.issue_type="Reprocess Receive" and a.oi_no='.$oi_no;
			echo link_report_add_del_auto($res,'',6);
			?>
            </table>

        </div>
    </form>

    <!--button design start-->
    <form action="" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
        <div class="container-fluid p-0 ">

            <div class="n-form-btn-class">
                
				  <input name="delete" type="submit" class="btn1 btn1-bg-cancel" value="DELETE" />
				 
				  <input name="confirmm" type="submit" class="btn1 btn1-submit-input" value="CONFIRM AND FORWARD RD" />
            </div>

        </div>
    </form>
  <? } ?>
</div>



<?php /*?><div class="form-container_large">
<form action="other_issue.php" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">

<div class="row ">
    
	
	     <div class="col-md-3 form-group">
		<? $field='oi_no';?>
            <label for="do_no" >Kit Pack Issue  No: </label>
            <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" class="form-control" />
		
          </div>
		  
		  <div class="col-md-3 form-group">
	<? $field='oi_date'; if($oi_date=='') $oi_date =''; ?>
            <label for="dealer_code">Kit Pack Issue Date: </label>
           <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" class="form-control" autocomplete="off" required />
          </div>
		  
		<!--  
		 <div class="col-md-3 form-group">
		 <?// $field='requisition_from';?>
            <label for="wo_detail2"> Requisition From : </label>
             <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" class="form-control" />
          </div>-->
		  
		  

		
		    <input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$_SESSION['user']['depot']?>"  required/>



        <input  name="issue_type" type="hidden" id="issue_type" value="<?=$page_for?>"  required="required"/>
      
		  
		  
		  
		  
		    <div class="col-md-3 form-group">
			   <? $field='requisition_from';?>
            <label for="wo_detail">Serial No:</label>
           <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" class="form-control" />
          </div>
		  
		  
          <div class="col-md-3 form-group">
		   <? $field='oi_subject';?>
            <label for="cust_name">Note: </label>
            <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" class="form-control" autocomplete="off" />
            <!--<input style="width:155px;"  name="wo_detail" type="text" id="wo_detail" value="<?=$depot_id?>" readonly="readonly"/>-->
          </div>
		  
          <div class="col-md-3 form-group">
		   <? $field='approved_by';?>
            <label for="rcv_amt"> Approved By: </label>
            <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" class="form-control" />
			<input  name="issue_type" type="hidden" id="issue_type" value="Reprocess Issue" class="form-control" />
          </div>
		  
	<!--	  <div class="col-md-3 form-group">
		    <? //$field='chalan_no';?>
            <label for="rcv_amt"> Chalan No: </label>
              <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" class="form-control" />
			
          </div>-->
	  
   </div>

<table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">
  
  <tr>
    <td colspan="2"><div class="buttonrow" style="margin-left:240px;">
      <input name="new" type="submit" class="btn1" value="<?=$btn_name?>" style="width:250px; font-weight:bold; font-size:12px;" />
    </div></td>
    </tr>
</table>
</form>
<? if($_SESSION[$unique]>0){?>
<form action="?<?=$unique?>=<?=$$unique?>" method="post" name="cloud" id="cloud">
<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">
                      <tr>
                        <td align="center" bgcolor="#0099FF" style="width:10%;"><strong>Item Name</strong></td>
                        <td align="center" bgcolor="#0099FF" style="width:9%;"><strong>Unit</strong></td>
                        <td align="center" bgcolor="#0099FF" style="width:12%;"><strong>Price</strong></td>
                        <td align="center" bgcolor="#0099FF" style="width:12%;" ><strong>Qty</strong></td>
                        <td align="center" bgcolor="#0099FF"  style="width:12%;" ><strong>Amount</strong></td>
                          <td  rowspan="2" align="center" bgcolor="#FF0000" style="width:5%;">
						  <div class="button">
						  <input name="add" type="submit" id="add" value="ADD" tabindex="12" class="update"/>                       
						  </div>				        </td>
      </tr>
                      <tr>
<td align="center" bgcolor="#CCCCCC">
<?php 
$page_for = 'Reprocess Issue';
?>
  <input  name="issue_type" type="hidden" id="issue_type" value="<?=$page_for?>"  required="required"/>
  <input  name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>
<input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$warehouse_id?>"/>
<input  name="oi_date" type="hidden" id="oi_date" value="<?=$oi_date?>"/>
<input  name="issued_to" type="hidden" id="issued_to" value="<?=$issued_to?>"/>
<input  name="item_id" type="text" id="item_id" value="<?=$item_id?>" style="width:320px;" required onblur="getData2('<?=$ajax_page?>', 'po',this.value,document.getElementById('warehouse_id').value);"/>
</td>
<td colspan="2" align="center" bgcolor="#CCCCCC">
<span id="po">
<input name="unit_name" type="text" class="input3" id="unit_name" style="width:122px;float:left;" readonly="readonly"/>
<input name="rate" type="text" class="input3" id="rate" style="width:112px;float:left;"  />
</span></td>
<td align="center" bgcolor="#CCCCCC"><input name="qty" type="text" class="input3" id="qty"  maxlength="100" style="width:106px; " onchange="count()" required/></td>
<td align="center" bgcolor="#CCCCCC"><input name="amount" type="text" class="input3" id="amount" style="width:131px;" readonly="readonly" required/></td>
      </tr>
    </table>
    <br /><br /><br /><br />


<table width="100%" border="0" cellspacing="0" cellpadding="0">

    <tr>
      <td>
<div class="tabledesign2">
<? 
$res='select a.id,b.item_name,a.rate as unit_price,a.qty ,a.unit_name,a.amount,"x" from warehouse_other_issue_detail a,item_info b where b.item_id=a.item_id and a.issue_type="Reprocess Issue" and a.oi_no='.$oi_no;
echo link_report_add_del_auto($res,'',6);
?>
</div>
</td>
    </tr>
	    	
	

				
    <tr>
     <td>

 </td>
    </tr>
  </table>
</form>
<h3 style="text-align:center;font-weight:bold;">Kit Pack Receive</h3>
<form action="?<?=$unique?>=<?=$$unique?>" method="post" name="cloud" id="cloud">
<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">
                      <tr>
                        <td align="center" bgcolor="#0099FF" style="width:10%;"><strong>Item Name</strong></td>
                        <td align="center" bgcolor="#0099FF" style="width:9%;"><strong>Unit</strong></td>
                        <td align="center" bgcolor="#0099FF" style="width:12%;"><strong>Rate</strong></td>
                        <td align="center" bgcolor="#0099FF" style="width:12%;" ><strong>Qty</strong></td>
                        <td align="center" bgcolor="#0099FF"  style="width:12%;" ><strong>Total Amt</strong></td>
                          <td  rowspan="2" align="center" bgcolor="#FF0000" style="width:5%;">
						  <div class="button">
						  <input name="add2" type="submit" id="add2" value="ADD" tabindex="12" class="update"/>                       
						  </div>				        </td>
      </tr>
                      <tr>
<td align="center" bgcolor="#CCCCCC">
<?php $page_for = 'Reprocess Receive';?>
  <input  name="issue_type" type="hidden" id="issue_type" value="<?=$page_for?>"  required="required"/>
  <input  name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>
<input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$warehouse_id?>"/>
<input  name="oi_date" type="hidden" id="oi_date" value="<?=$oi_date?>"/>
<input  name="issued_to" type="hidden" id="issued_to" value="<?=$issued_to?>"/>
<?
//auto_complete_from_db('item_info','item_name','concat(item_name,"#>",item_id)','1 and sub_group_id=1005000100070000','item_id2');
?>


<select id="item_id2" name="item_id2"  style="width:320px;" required onchange="getData2('<?=$ajax_page2?>', 'po2',this.value,'<?=$$unique?>');">
    <option></option>
    <? foreign_relation('item_info','concat(item_name,"#>",item_id)','item_name',$item_name2,'1 and sub_group_id=1005000100070000');?>
    </select
></td>
<td colspan="2" align="center" bgcolor="#CCCCCC">
<span id="po2">
<input name="unit_name" type="text" class="input3" id="unit_name2" style="width:122px;float:left;" readonly="readonly"/>
<input name="rate" type="text" class="input3" id="rate2" style="width:112px;float:left;"/>
</span></td>
<td align="center" bgcolor="#CCCCCC"><input name="qty" type="text" class="input3" id="qty2"  maxlength="100" style="width:106px; " onchange="count2()" required/></td>
<td align="center" bgcolor="#CCCCCC"><input name="amount" type="text" class="input3" id="amount2" style="width:131px;" readonly="readonly" required/></td>
      </tr>
    </table>
    <br /><br /><br /><br />


<table width="100%" border="0" cellspacing="0" cellpadding="0">

    <tr>
      <td>
<div class="tabledesign2">
<? 
$res='select a.id,b.item_name,a.rate as unit_price,a.qty ,a.unit_name,a.amount,"x" from warehouse_other_issue_detail a,item_info b where b.item_id=a.item_id and a.issue_type="Reprocess Receive" and a.oi_no='.$oi_no;
echo link_report_add_del_auto($res,'',6);
?>
</div>
</td>
    </tr>
	    	
	

				
    <tr>
     <td>

 </td>
    </tr>
  </table>
</form>
<form action="" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
  <table width="100%" border="0">
    <tr>
      <td align="center">
	  <input name="delete" type="submit" class="btn1" value="DELETE" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:RED" />
	  </td>
      <td align="center">

      <input name="confirmm" type="submit" class="btn1" value="CONFIRM AND FORWARD RD" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:#090" />

      </td>
    </tr>
  </table>
</form>
<? }?>
</div><?php */?>

<script>$("#codz").validate();$("#cloud").validate();</script>
<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>