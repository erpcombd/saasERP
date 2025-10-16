<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Sales to Depot';
$tr_type="Show";


do_calander('#pi_date','-15','0');

do_calander('#old_production_date');

$page = 'depot_transfer_checking.php';

//if($_POST['line_id']>0) 
//
//$line_id = $_SESSION['line_id']=$_POST['line_id'];
//
//elseif($_SESSION['line_id']>0) 
//
//$line_id = $_POST['line_id']=$_SESSION['line_id'];





$table_master='production_issue_master';

$unique_master='pi_no';



$table_detail='production_issue_detail';

$unique_detail='id';







if($_SESSION[$unique_master]>0)

$$unique_master=$_SESSION[$unique_master];

elseif(isset($_GET['del']))

{

$$unique_master=find_a_field($table_detail,$unique_master,'id='.$_GET['del']); $del = $_GET['del'];

}

else

$$unique_master=$_REQUEST[$unique_master];



if(prevent_multi_submit()){

if(isset($_POST['new']))

{

		$crud   = new crud($table_master);

		$_POST['entry_at']=date('Y-m-d H:i:s');

		$_POST['entry_by']=$_SESSION['user']['id'];

		if($_POST['flag']<1){

		$$unique_master=$crud->insert();

		unset($$unique);

		$type=1;

		$msg='Product Issued. (PI No-'.$$unique_master.')';
		$tr_type="Initiate";
		}

		else {

		$crud->update($unique_master);

		$type=1;

		$msg='Successfully Updated.';
		$tr_type="Add";
		}

}



if(isset($_POST['add'])&&($_POST[$unique_master]>0))

{

		$table		=$table_detail;

		$crud      	=new crud($table);



		$iii=explode('#>',$_POST['item_id']);

		$_POST['item_id']=$iii[2];

		



		$xid = $crud->insert();
		$tr_type="Add";
		





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
		$tr_type="Delete";

}



if($$unique_master>0)

{

		$condition=$unique_master."=".$$unique_master;

		$data=db_fetch_object($table_master,$condition);

		foreach ($data as $key => $value)

		{ $$key=$value;}

		

}



auto_complete_from_db('item_info','concat(item_name,"#>",item_description,"#>",item_id)','concat(item_name,"#>",item_description,"#>",item_id)','product_nature="Salable"','item_id');
$tr_from="Warehouse";
?>





<script language="javascript">

function focuson(id) {

  if(document.getElementById('item_id').value=='')

  document.getElementById('item_id').focus();

  else

  document.getElementById(id).focus();

}

function recal() {

document.getElementById('total_unit').value = (((document.getElementById('total_pkt').value)*1)*((document.getElementById('pkt_size').value)*1))+((document.getElementById('total_pcs').value)*1);

}


function total_amtt() {

document.getElementById('total_amt').value = (((document.getElementById('unit_price').value)*1)*((document.getElementById('total_pcs').value)*1));

}

</script>



<div class="form-container_large">
    <form action="<?=$page?>" method="post" name="codz2" id="codz2">
<!--        top form start hear-->
        <div class="container-fluid bg-form-titel">
            <div class="row">
                <!--left form-->
                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <div class="container n-form2">
                        <div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">TR No :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <input   name="pi_no" type="text" id="pi_no" value="<? if($$unique_master>0) echo $$unique_master; else echo (find_a_field($table_master,'max('.$unique_master.')','1')+1);?>" class="form-control" readonly/>
                            </div>
                        </div>

                        <div class="form-group row m-0 pb-1">

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Carried By:
</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <input type="text" name="carried_by" id="carried_by" value="<?=$carried_by?>" class="form-control" required/>
                            </div>
                        </div>

                        <div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Note:
</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <input type="text" name="remarks" id="remarks" value="<?=$remarks?>" class="form-control" />

                            </div>
                        </div>
						
						
						<div class="form-group row m-0 pb-1">

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">TR Date:
</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <input class="form-control"  name="pi_date" type="text" id="pi_date" value="<?=$pi_date?>" autocomplete="off"  required/>
                            </div>
                        </div>
						
						
						
						
						

                    </div>



                </div>

                <!--Right form-->
                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <div class="container n-form2">
                        <div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">From:</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <input name="warehouse_from" type="hidden" id="warehouse_from"  value="<?=$_SESSION['user']['depot']?>" />

        <input name="warehouse_from3" type="text" id="warehouse_from3" class="form-control" value="<?=find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot'])?>" />
                            </div>
                        </div>

                        

                        <div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Invoice No :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <input name="invoice_no" type="text" id="invoice_no" class="form-control" value="<?=$invoice_no?>" tabindex="105" required />

                            </div>
                        </div>
						
                        <div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Depot:</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <input name="warehouse_to" type="hidden" id="warehouse_to"  value="<?=$warehouse_to?>"   />

        <input name="warehouse_from4" type="text" id="warehouse_from4"  class="form-control" value="<?=find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_to)?>" />

                            </div>
                        </div>

                    </div>



                </div>


            </div>

            <div class="n-form-btn-class">
                <!--<input name="submit" type="submit" class="btn1 btn1-bg-submit" value="Update Requsition Information" tabindex="6">-->
				
				<? if($$unique_master>0) {?>

				<input name="new" type="submit" class="btn1 btn1-bg-submi" value="Update Demand Order"  tabindex="12" />
				
				<input name="flag" id="flag" type="hidden" value="1" />
				
				<? }else{?>
				<input name="new2" type="submit" class="btn1 btn1-bg-submi" value="Initiate Demand Order"  tabindex="12" />
				<input name="flag" id="flag" type="hidden" value="0" />
				
				<? }?>
            </div>
        </div>

        <!--return Table design start-->
        <!--<div class="container-fluid pt-5 p-0 ">
            <table class="table1  table-striped table-bordered table-hover table-sm">
                <thead class="thead1">
                <tr class="bgc-info">
                    <th>Returned By</th>
                    <th>Returned At</th>
                    <th>Remarks</th>
                </tr>
                </thead>

                <tbody class="tbody1">

                <tr>
                    <td>Row name 1</td>
                    <td>Row name 2</td>
                    <td>Row name 3</td>

                </tr>

                </tbody>
            </table>

        </div>-->
    </form>




    <form action="<?=$page?>" method="post" name="codz2" id="codz2">
	<? if($$unique_master>0){?>
        <!--Table input one design-->
        <div class="container-fluid pt-5 p-0 ">


            <table class="table1  table-striped table-bordered table-hover table-sm">
                <thead class="thead1">
                <tr class="bgc-info">
                    <th>Item Name</th>
                    <th>Unit</th>
                    <th>Stock</th>

                    <th>Rate</th>
                    <th>Qty</th>
                    <th>Amount</th>

                    <th>Action</th>
                </tr>
                </thead>

                <tbody class="tbody1">

                <tr>
                    <td><input  name="<?=$unique_master?>" type="hidden" id="<?=$unique_master?>" value="<?=$$unique_master?>"/>
      <input  name="warehouse_from2" type="hidden" id="warehouse_from2" value="<?=$warehouse_from?>"/>
      <input  name="warehouse_to2" type="hidden" id="warehouse_to2" value="<?=$warehouse_to?>"/>
      <input  name="pi_date2" type="hidden" id="pr_date" value="<?=$pi_date?>"/>
      <input  name="item_id" type="text" id="item_id" value="<?=$item_id?>" required="required" onblur="getData2('depot_transfer_ajax.php', 'pr', this.value, document.getElementById('warehouse_from').value);"/>
      <input name="remarks2" type="hidden" id="remarks2" value="<?=$remarks?>" tabindex="105" /></td>
                    
						<td colspan="3">
							<div align="right">
								  <span id="pr">
						<table style="width:100%;" border="1">
							<tr>

								<td width="20%"><input name="total_unit2" type="text" class="input3" id="total_unit2"  maxlength="100" required/></td>

								<td width="20%"><input name="old_production_date" type="text" class="input3" id="stock2"  maxlength="100" /></td>

								<td width="20%"><input name="unit_price" type="text" class="input3" id="unit_price"  maxlength="100" /></td>

							</tr>
						</table>
						</span>
							</div>
						</td>

                    <td><input name="total_unit" type="hidden" class="input3" id="total_unit"  required="required"/>
        <input name="total_pkt" type="hidden" class="input3" id="total_pkt"   required="required"/>
        <input name="total_pcs" type="text" class="input3" id="total_pcs"  required="required"  onkeyup="total_amtt()"/></td>

                    <td><input name="total_amt" type="text" class="input3" id="total_amt"  required="required"/></td>

                    <td><input name="add" type="submit" id="add" value="ADD" tabindex="12" class="btn1 btn1-bg-submit" onclick="recal();"/></td>
					

                </tr>

                </tbody>
            </table>





        </div>


        <!--Data multi Table design start-->
		<? if($$unique_master>0){?>
		 <? 


$res='select a.id,b.finish_goods_code as FG_code,b.item_name,b.unit_name,a.total_unit as total_qty, a.unit_price, a.total_amt, "X" from production_issue_detail a,item_info b where b.item_id=a.item_id and a.pi_no='.$$unique_master.' order by a.id';

?>
        <div class="container-fluid pt-5 p-0 ">

            <table class="table1  table-striped table-bordered table-hover table-sm">
                <thead class="thead1">
                <tr class="bgc-info">
                    <th>S/L</th>
                    <th>FG Code</th>
                    <th>Item Name</th>

                    <th>Unit Name</th>
                    <th>Total Qty</th>
                    <th>Unit Price</th>
					<th>Total Amt</th>
					<th>X</th>
                </tr>
                </thead>

                <tbody class="tbody1">

                <?

				$i=1;
				
				$query = db_query($res);
				
				while($data=mysqli_fetch_object($query)){ ?>
				<tr>
                    <td><?=$i++?></td>
                    <td><?=$data->FG_code?></td>
                    <td><?=$data->item_name?></td>

                    <td><?=$data->unit_name?></td>
                    <td><?=$data->total_qty?></td>
					<td><?=$data->unit_price?></td>
					<td><?=$data->total_amt?></td>
                    <td><a href="?del=<?=$data->id?>">X</a></td>

                </tr>
				<?
 $total_pcs +=$data->total_qty;
 $total_amt +=$data->total_amt;
 } ?>
 
 <tr>

<td colspan="4"><div align="right"><strong>  Total:</strong></div></td>
<td ><?=number_format($total_pcs,2);?></td>
<td>&nbsp;</td>
<td ><?=number_format($total_amt,2);?></td>

</tr>

                </tbody>
				<? }?>
            </table>

        </div>
    </form>

    <!--button design start-->
    <form action="select_unapproved_depot_transfer.php" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
        <div class="container-fluid p-0 ">

            <div class="n-form-btn-class">
				<input  name="pi_no" type="hidden" id="pi_no" value="<?=$$unique_master?>"/>
				<input name="delete" type="submit" class="btn1 btn1-bg-cancel" value="DELETE DT" />

      <input name="confirm" type="submit" class="btn1 btn1-bg-submit" value="CONFIRM AND SEND DT"  />
				
            </div>

        </div>
		<? }?>
    </form>

</div>








<?php /*?><div class="form-container_large">

<form action="<?=$page?>" method="post" name="codz2" id="codz2">
  <div class="row ">
    
	
	     <div class="col-md-3 form-group">
            <label for="do_no" >TR No : </label>
           <input   name="pi_no" type="text" id="pi_no" value="<? if($$unique_master>0) echo $$unique_master; else echo (find_a_field($table_master,'max('.$unique_master.')','1')+1);?>" class="form-control" readonly/>
          </div>
		  
		  <div class="col-md-3 form-group">
            <label for="dealer_code">Carried By: </label>
        <input type="text" name="carried_by" id="carried_by" value="<?=$carried_by?>" class="form-control" required/>
          </div>
		  
		  
		 <div class="col-md-3 form-group">
            <label for="wo_detail2"> Note: </label>
            <input type="text" name="remarks" id="remarks" value="<?=$remarks?>" class="form-control" />
          </div>
		  
		  
		   <div class="col-md-3 form-group">
            <label for="wo_detail">From: </label>
             <input name="warehouse_from" type="hidden" id="warehouse_from"  value="<?=$_SESSION['user']['depot']?>" />

        <input name="warehouse_from3" type="text" id="warehouse_from3" class="form-control" value="<?=find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot'])?>" />
          </div>
		  
		  
		  
		  
		    <div class="col-md-3 form-group">
            <label for="wo_detail">TR Date: </label>
            <input class="form-control"  name="pi_date" type="text" id="pi_date" value="<?=$pi_date?>" autocomplete="off"  required/>
          </div>
		  
		  
          <div class="col-md-3 form-group">
            <label for="depot_id">Invoice No : </label>
        <input name="invoice_no" type="text" id="invoice_no" class="form-control" value="<?=$invoice_no?>" tabindex="105" required />
            <!--<input style="width:155px;"  name="wo_detail" type="text" id="wo_detail" value="<?=$depot_id?>" readonly="readonly"/>-->
          </div>
		  
          <div class="col-md-3 form-group">
            <label for="rcv_amt"> Depot: </label>
           <input name="warehouse_to" type="hidden" id="warehouse_to"  value="<?=$warehouse_to?>"   />

        <input name="warehouse_from4" type="text" id="warehouse_from4"  class="form-control" value="<?=find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_to)?>" />
          </div>
	  
   </div>
		 
		 
<table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">

  



  <tr>

    <td colspan="3"><div class="buttonrow" style="margin-left:40%;">

    <? if($$unique_master>0) {?>

<input name="new" type="submit" class="btn btn-success" value="Update Demand Order" style="width:200px; font-weight:bold; font-size:12px;" tabindex="12" />

<input name="flag" id="flag" type="hidden" value="1" />

<? }else{?>

<input name="new" type="submit" class="btn btn-primary" value="Initiate Demand Order" style="width:200px; font-weight:bold; font-size:12px;" tabindex="12" />

<input name="flag" id="flag" type="hidden" value="0" />

<? }?>

    </div></td>

    </tr>

	  <tr>

    <td colspan="3">&nbsp;</td>

  </tr>

</table>

</form>

<form action="<?=$page?>" method="post" name="codz2" id="codz2">

<? if($$unique_master>0){?>
<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">
  <tr>
        <td align="center" width="30%" bgcolor="#0099FF"><strong>Item Name</strong></td>
        <td align="center" width="11%" bgcolor="#0099FF"><span style="font-weight: bold">Unit</span></td>
        <td align="center" width="11%" bgcolor="#0099FF"><strong>Stock</strong> </td>
        <td align="center" width="11%" bgcolor="#0099FF"><strong>Rate</strong></td>
        <td align="center" width="11%" bgcolor="#0099FF"><strong>Qty</strong></td>
        <td align="center" width="11%" bgcolor="#0099FF"><strong>Amount</strong></td>
        <td  rowspan="2" width="11%" align="center" bgcolor="#FF0000"><div class="button">
            <input name="add" type="submit" id="add" value="ADD" tabindex="12" class="update" onclick="recal();"/>
          </div></td>
      </tr>
  <tr>
    <td align="center" bgcolor="#CCCCCC"><div align="center">
      <input  name="<?=$unique_master?>" type="hidden" id="<?=$unique_master?>" value="<?=$$unique_master?>"/>
      <input  name="warehouse_from2" type="hidden" id="warehouse_from2" value="<?=$warehouse_from?>"/>
      <input  name="warehouse_to2" type="hidden" id="warehouse_to2" value="<?=$warehouse_to?>"/>
      <input  name="pi_date2" type="hidden" id="pr_date" value="<?=$pi_date?>"/>
      <input  name="item_id" type="text" id="item_id" value="<?=$item_id?>" style="width:98%;" required="required" onblur="getData2('depot_transfer_ajax.php', 'pr', this.value, document.getElementById('warehouse_from').value);"/>
      <input name="remarks2" type="hidden" id="remarks2" style="width:105px;" value="<?=$remarks?>" tabindex="105" />
    </div></td>
    <td colspan="3" align="center" bgcolor="#CCCCCC"><div align="center"><span id="pr">
      <table style="width:100%;" border="1">
	        <tr>
            <td width="33%"><input name="total_unit2" type="text" class="input3" id="total_unit2"  maxlength="100" style="width:98%;" required/></td>
            <td width="33%"> <input name="old_production_date" type="text" class="input3" id="stock2"  maxlength="100" style="width:98%;"/></td>
            <td width="33%"><input name="unit_price" type="text" class="input3" id="unit_price"  maxlength="100" style="width:98%;"/></td>
			</tr></table>
    </span> </div></td>
    <td align="center" bgcolor="#CCCCCC"><input name="total_unit" type="hidden" class="input3" id="total_unit" style="width:98%;" required="required"/>
        <input name="total_pkt" type="hidden" class="input3" id="total_pkt"  style="width:98%;" required="required"/>
        <input name="total_pcs" type="text" class="input3" id="total_pcs"  style="width:98%;" required="required"  onkeyup="total_amtt()"/></td>
    <td align="center" bgcolor="#CCCCCC"><input name="total_amt" type="text" class="input3" id="total_amt"  style="width:98%;" required="required"/></td>
  </tr>
</table>
<br /><br /><br /><br />



<? 


$res='select a.id,b.finish_goods_code as FG_code,b.item_name,b.unit_name,a.total_unit as total_qty, a.unit_price, a.total_amt, "X" from production_issue_detail a,item_info b where b.item_id=a.item_id and a.pi_no='.$$unique_master.' order by a.id';

?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">



    <tr>

      <td><div class="tabledesign2">

        <? 

echo link_report_add_del_auto($res,1,5,7);

		?>



      </div></td>

    </tr>

	    	

	



				

    <tr>

     <td>



 </td>

    </tr>

  </table>



</form>

<form action="select_unapproved_depot_transfer.php" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">

<table width="100%" border="0">

  <tr>

      <td align="center"><input  name="pi_no" type="hidden" id="pi_no" value="<?=$$unique_master?>"/></td><td align="right" style="text-align:right"><input name="delete" type="submit" class="btn btn-danger" value="DELETE DT" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:white; float:left" />

      <input name="confirm" type="submit" class="btn btn-info" value="CONFIRM AND SEND DT" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:white; float:right" />

      </td>

      

    </tr>

</table>





<? }?>

</form>

</div><?php */?>

<script>$("#cz").validate();$("#cloud").validate();</script>

<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>