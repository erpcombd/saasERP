<?php

session_start();

ob_start();


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$title='New Purchase Entry';



do_calander('#po_date');

do_calander('#quotation_date');

//create_combobox('vendor_id_draft');

$table_master='purchase_master';

$table_details='purchase_invoice';

$unique='po_no';

//var_dump($_POST);



if($_REQUEST['new']>0){

unset($_SESSION[$unique]);

}

$req_all = find_all_field('requisition_master','','req_no="'.$_SESSION['selected_req_no'].'"');



if(isset($_POST['new']))

{

		$crud   = new crud($table_master);

		

		

		if($_POST['vendor_id_draft']>0) {

		$_POST['vendor_id']=$_POST['vendor_id_draft'];

		}





		if(!isset($_SESSION[$unique])) {

		$_POST['entry_by']=$_SESSION['user']['id'];

		$_POST['entry_at']=date('Y-m-d h:s:i');

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d h:s:i');

		$$unique=$_SESSION[$unique]=$crud->insert();

		unset($$unique);

		$type=1;

		$msg='Purchase Order No Created. (PO No :-'.$_SESSION[$unique].')';

		}

		else {

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d h:s:i');

		$crud->update($unique);

		$type=1;

		$msg='Successfully Updated.';

		}

}



$$unique=$_SESSION[$unique];



if(isset($_POST['delete']))

{

$quotation_no=find_a_field('purchase_master','quotation_no','po_no="'.$$unique.'"');

if($quotation_no>0){

$quotation_update='update quotation_master set is_po=0 where quotation_no="'.$quotation_no.'"';

db_query($quotation_update);

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

}



if($_GET['del']>0)

{

		$crud   = new crud($table_details);

		$condition="id=".$_GET['del'];		

		$crud->delete_all($condition);

		$type=1;

		$msg='Successfully Deleted.';

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

		unset($$unique);

		unset($_SESSION[$unique]);

		$type=1;

		$msg='Successfully Forwarded for Approval.';

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

		$_POST['unit_name']=find_a_field('item_info','unit_name','item_id="'.$iii[1].'"');

		echo $_POST['rate']=$_POST['amount']/$_POST['qty'];

		$crud->insert();

		//echo 'this is test';

}



if($$unique>0)

{

		$condition=$unique."=".$$unique;

		$data=db_fetch_object($table_master,$condition);

		foreach ($data as $key => $value)

		{ $$key=$value;}

		

}

if($$unique>0) $btn_name='Update PO Information'; else $btn_name='Initiate PO Information';

if($_SESSION[$unique]<1)

$$unique=db_last_insert_id($table_master,$unique);



//auto_complete_start_from_db

//auto_complete_from_db($table,$show,$id,$con,$text_field_id);
auto_complete_from_db('item_info i,item_sub_group s','i.item_name','concat(finish_goods_code,"-",item_name,"#>",item_id)',' i.sub_group_id=s.sub_group_id','item_id');


//auto_complete_from_db('item_info','item_name','concat(finish_goods_code,"-",item_name,"#>",item_id)','1 ','item_id');



?>

<script language="javascript">

function count()

{

var rate=(document.getElementById('rate').value)*1;



var qty=(document.getElementById('qty').value)*1;





document.getElementById('amount').value=(rate*qty);



//var num=((document.getElementById('qty').value)*1)*((document.getElementById('rate').value)*1);

//document.getElementById('amount').value = num.toFixed(2);	

}

</script>





<!--<style type="text/css">







/*.ui-state-default a, .ui-state-default a:link, .ui-state-default a:visited, a.ui-button, a:link.ui-button, a:visited.ui-button, .ui-button {

    color: #454545;

    text-decoration: none;

    display: none;

}*/





div.form-container_large input {

    width: 220px;

    height: 37px;

    border-radius: 0px !important;

}









.onhover:focus{

background-color:#66CBEA;



}





<!--

.style2 {

	color: #FFFFFF;

	font-weight: bold;

}

.style3 {font-weight: bold}

.style4 {font-weight: bold}



</style>-->













<!--Mr create 2 form with table-->

<div class="form-container_large">

    <form action="po_create.php" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">

<!--        top form start hear-->

        <div class="container-fluid bg-form-titel">

            <div class="row">

                <!--left form-->

                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

                    <div class="container n-form2">

                        <div class="form-group row m-0 pb-1">

						  <? $field='po_no';?>

                            <label  for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">PO No</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

                               

							

									<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" readonly/>

							

                            </div>

                        </div>



                        <div class="form-group row m-0 pb-1">

								 <? $field='po_date'; if($po_date=='') $po_date =date('Y-m-d');?>

                            <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">PO Date</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

                               

						

								<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>



                            </div>

                        </div>



                        <div class="form-group row m-0 pb-1">

                            <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Company</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

                               



									<select id="group_for" name="group_for" required >

							

							

								  			<? foreign_relation('user_group','id','group_name',$group_for,'1');?>

							

									</select>



                            </div>

                        </div>

						<div class="form-group row m-0 pb-1">

						 <? $field='remarks';?>

                            <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Remarks</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

                               

							

									  <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>

							



                            </div>

                        </div>



                    </div>







                </div>



                <!--Right form-->

                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

                    <div class="container n-form2">

                        <div class="form-group row m-0 pb-1">

                            <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Vendor Name</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

                                

		

									<? if($vendor_id<1) { ?>

									<select name="vendor_id_draft" id="vendor_id_draft" required   >

								

									<option></option>						

									<? foreign_relation('vendor','vendor_id','vendor_name',$vendor_id_draft,'1');?>

									</select>

									

									<? }?>

									

									<? if($vendor_id>0){ ?>

									

									 <input  name="vendor_id" type="hidden" id="vendor_id" value="<?=$vendor_id;?>" readonly=""  required/>

									

									 <input  name="vendor_view" type="text" id="vendor_view" value="<?=find_a_field('vendor','vendor_name','vendor_id="'.$vendor_id.'"');?>" readonly=""  required/>

									

									<? }?>

                            </div>

                        </div>



                        <div class="form-group row m-0 pb-1">

									<? $field='tax';?>

                            <label  for="<?=$field?>"  class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Vat(%)</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

                                

								<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"  />



                            </div>

                        </div>
						
						
						<div class="form-group row m-0 pb-1">

									<? $field='ait';?>

                            <label  for="<?=$field?>"  class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">AIT(%)</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

                                

								<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"  />



                            </div>

                        </div>



                        <div class="form-group row m-0 pb-1">

						<? $field='warehouse_id'; $table='warehouse';$get_field='warehouse_id';$show_field='warehouse_name'; if($$field=='') $$field=$req_all->warehouse_id;?>

                            <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Warehouse</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

                                	 

							<select id="<?=$field?>" name="<?=$field?>" required style="width:220px;"    >

								<option></option>

								<? foreign_relation($table,$get_field,$show_field,$$field,'1');?>

									

							</select>



                            </div>

                        </div>
						
						
						
						
	<div class="form-group row m-0 pb-1" style="display: none;">

						<? $field='quotation_no';?>

                            <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Quotation No</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

                                	 

						<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" readonly />



                            </div>

                        </div>					
						



                    </div>

                </div>





            </div>



            <div class="n-form-btn-class">

                

				<input name="new" type="submit" class="btn1 btn1-bg-submit" value="<?=$btn_name?>"  />

            </div>

        </div>



        <!--return Table design start-->

        <div class="container-fluid pt-5 p-0 ">

            <table class="table1  table-striped table-bordered table-hover table-sm">

                <thead class="thead1">

				<?

	$sql = 'select a.*,u.fname from approver_notes a, user_activity_management u where a.entry_by=u.user_id and master_id="'.$$unique.'" and type in ("PO","PR")';

	$row_check = mysqli_num_rows(db_query($sql));

	if($row_check>0){

	?>

                <tr class="bgc-info">

                    <th>Returned By</th>

                    <th>Returned At</th>

                    <th>Remarks</th>

                </tr>

                </thead>



                <tbody class="tbody1">



                <?

				  $qry = db_query($sql);

				  while($return_note=mysqli_fetch_object($qry)){

			 	?>

				<tr>

                    <td><?=$return_note->fname?></td>

					<td><?=$return_note->entry_at?></td>

					<td><?=$return_note->note?></td>



                </tr>

				<? } ?>



                </tbody>

            </table>

			<? } ?>



        </div>

    </form>









    

	<form action="?<?=$unique?>=<?=$$unique?>" method="post" name="cloud" id="cloud">

	<? if($_SESSION[$unique]>0){?>

	<? 

		$group_for = find_a_field('warehouse','group_for','warehouse_id='.$warehouse_id.' ');

		if(($vendor->ledger_id==0)&&($group_for==2||$group_for==3)){ ?>

		<table class="table1  table-striped table-bordered table-hover table-sm">

		<tr>

		<td ><div class="container-fluid pt-5 p-0">VERDOR IS BLOCKED. NO ACCOUNT CODE FOUND</div></td>

		</tr>

		</table>

		

        <!--Table input one design-->

        <div class="container-fluid pt-5 p-0 ">





            <? }else{?>

			<table class="table1  table-striped table-bordered table-hover table-sm">

                <thead class="thead1">

                <tr class="bgc-info">

                    <th width="40%">Item Name</th>

                    <th width="10%" style="display: none;">Stock</th>

                    <th width="10%">Unit</th>



                    <th width="10%">Unit Price</th>

                    <th>Quantity</th>

                    <th>Amount</th>



                    <th>Action</th>

                </tr>

                </thead>



                <tbody class="tbody1">



                <tr>

                    <td align="center">

<input  name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>

<input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$warehouse_id?>"/>

<input  name="po_date" type="hidden" id="po_date" value="<?=$po_date?>"/>

<input  name="vendor_id" type="hidden" id="vendor_id" value="<?=$vendor_id?>"/>

<input  name="item_id" type="text" id="item_id" value="<?=$item_id?>" style="width:320px;" required onblur="getData2('po_ajax.php', 'po',this.value,document.getElementById('warehouse_id').value);"/>



</td>				

                    

						<td colspan="2">

							<div align="right">

								  <span id="po">

						<table style="width:100%;" border="1">

							<tr>



							  <td style="display: none;"><input name="stk" type="text" class="input3" id="stk" readonly="readonly"/></td>



								<td ><input name="unit_name" type="text" class="input3" id="unit_name"  readonly="readonly"/></td>



								<td ><input name="rate" type="text" class="input3" id="rate"  /></td>

							</tr>

						</table>

						</span>

							</div>

						</td>



                    <td><input name="qty" type="text" class="input3" id="qty"  maxlength="100"  onchange="count()" required /></td>

                    



                    <td><input name="amount" type="text" class="input3" id="amount" readonly="readonly" required /></td>

                    <td><input name="add" type="submit" id="add" class="btn1 btn1-bg-submit" value="ADD" tabindex="12"  /></td>



                </tr>



                </tbody>

				<? }?>

            </table>

			











        </div>





        <!--Data multi Table design start-->

		<? if($$unique>0){?>

		 <? 





			$res='select a.id, b.finish_goods_code as item_code, concat(b.item_name) as item_name,b.unit_name, a.qty as total_unit,a.rate, a.amount,"x" from purchase_invoice a,item_info b where b.item_id=a.item_id and a.po_no='.$po_no;



?>

        <div class="container-fluid pt-5 p-0 ">



            <table class="table1  table-striped table-bordered table-hover table-sm">

                <thead class="thead1">

                <tr class="bgc-info">

                    <th>S/L</th>

                    <th>Item Code</th>

                    <th>Item Name</th>



                    <th>Unit</th>

					<th>Unit Price</th>

                    <th>Quantity</th>

                    <th>Amount</th>

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

                    <td><?=$data->item_code?></td>

                    <td style="text-align:left"><?=$data->item_name?></td>



                    <td><?=$data->unit_name?></td>

					<td><?=$data->rate?></td>

                    <td><?=$data->total_unit?></td>

					<td><?=$data->amount?></td>

                    <td><a href="?del=<?=$data->id?>">X</a></td>



                </tr>

				<?

 $total_pcs +=$data->total_unit;

 $total_amt +=$data->amount;

 } ?>

 

 <tr>



<td colspan="5"><div align="right"><strong>  Total:</strong></div></td>

<td ><?=number_format($total_pcs,2);?></td>

<td ><?=number_format($total_amt,2);?></td>



</tr>



                </tbody>

				<? }?>

            </table>



        </div>

    </form>



    <!--button design start-->

    <form action="?" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">

        <div class="container-fluid p-0 ">



            <div class="n-form-btn-class">

                

				<input name="delete"  type="submit" class="btn1 btn1-bg-cancel" value="DELETE PURCHASE" />

                

				

				<input  name="po_no" type="hidden" id="po_no" value="<?=$$unique?>"/>



      			<input name="confirmm" type="submit" class="btn1 btn1-bg-submit" value="CONFIRM PURCHASE"  />

            </div>



        </div>

		<? }?>

    </form>



</div>









<br/>

<br/>

<br/>

<br/>















<?php /*?><div class="form-container_large">

<form action="po_create.php" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">

<table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">

  <tr>

    <td valign="top"><fieldset>

   <? $field='po_no';?>



      <div>



        <label for="<?=$field?>" style="text-align:left">PO  No: </label>



        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" readonly/>



      </div>

	  

	  

     <? $field='po_date'; if($po_date=='') $po_date =date('Y-m-d');?>



      <div>



        <label for="<?=$field?>" style="text-align:left">PO Date:</label>



        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>



      </div>

    

	  <div>



        <label for="<?=$field?>" style="text-align:left">Company:</label>



        <select id="group_for" name="group_for" required style="width:220px;"  >





      <? foreign_relation('user_group','id','group_name',$group_for,'1');?>



        </select>



      </div>

	  

	  

	  <? $field='remarks';?>



        <div>



          <label for="<?=$field?>" style="text-align:left">Remarks:</label>



          <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>



        </div>



      

	  

	  

	  

	       <div></div>



    </fieldset></td>

    <td>

			<fieldset style="height:182px">

			

 



      <div>

	  

	<div>



        <label for="<?=$field?>" style="text-align:left">Vendor :</label>

		

		<? if($vendor_id<1) { ?>

		<select name="vendor_id_draft" id="vendor_id_draft" required   >

	

		<option></option>						

		<? foreign_relation('vendor','vendor_id','vendor_name',$vendor_id_draft,'1');?>

		</select>

		

		<? }?>

		

		<? if($vendor_id>0) { ?>

		

		 <input style="width:190px;"  name="vendor_id" type="hidden" id="vendor_id" value="<?=$vendor_id;?>" readonly=""  required/>

		

		 <input style="width:190px;"  name="vendor_view" type="text" id="vendor_view" value="<?=find_a_field('vendor','vendor_name','vendor_id="'.$vendor_id.'"');?>" readonly=""  required/>

		

		<? }?>

      </div>  

	  

	  

	  

	  



       <div>







<? $field='tax';?>



<label for="<?=$field?>" style="text-align:left">VAT (%):</label>



<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"  />



</div>



	  

  <? $field='warehouse_id'; $table='warehouse';$get_field='warehouse_id';$show_field='warehouse_name'; if($$field=='') $$field=$req_all->warehouse_id;?>



      <div>



        <label for="<?=$field?>" style="text-align:left">Warehouse:</label>



        <select id="<?=$field?>" name="<?=$field?>" required style="width:220px;"    >



        <option></option>



        <? foreign_relation($table,$get_field,$show_field,$$field,'1');?>



        </select>



      </div>

	  

	  

		      



      </div>

			</fieldset>	</td>

  </tr>

  <tr>

    <td colspan="2"><div class="buttonrow" style="margin-left:390px;">

      <input name="new" type="submit" class="btn1" value="<?=$btn_name?>" style="width:250px; font-weight:bold; font-size:12px;" />

    </div></td>

    </tr>

	<?

	$sql = 'select a.*,u.fname from approver_notes a, user_activity_management u where a.entry_by=u.user_id and master_id="'.$$unique.'" and type in ("PO","PR")';

	$row_check = mysqli_num_rows(db_query($sql));

	if($row_check>0){

	?>

	<tr>

	   <td colspan="2">

	      <table border="1" cellpadding="0" cellspacing="0" style=" width:100%; margin:auto; border-collapse:collapse;">

		     <tr>

			    <th>Returned By</th>

				<th>Returned At</th>

				<th>Remarks</th>

			 </tr>

			 <?

			  

			  $qry = db_query($sql);

			  while($return_note=mysqli_fetch_object($qry)){

			 ?>

			 <tr>

			    <td><?=$return_note->fname?></td>

				<td><?=$return_note->entry_at?></td>

				<td><?=$return_note->note?></td>

			 </tr>

			 <? } ?>

		  </table>

	   </td>

	</tr>

	<? } ?>

</table>

</form>

<? if($_SESSION[$unique]>0){?>

<form action="?<?=$unique?>=<?=$$unique?>" method="post" name="cloud" id="cloud">



<? 

$group_for = find_a_field('warehouse','group_for','warehouse_id='.$warehouse_id.' ');

if(($vendor->ledger_id==0)&&($group_for==2||$group_for==3)){ ?>

<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">

<tr><td bgcolor="#FF3333"><div align="center" class="style1">VERDOR IS BLOCKED. NO ACCOUNT CODE FOUND</div></td></tr>

</table>



<? }else{?>

			<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">

                      <tr>

                        <td width="46%" align="center" bgcolor="#0099FF"><strong>Item Name</strong></td>

                        <td width="8%" align="center" bgcolor="#0099FF"><strong>Stock</strong></td>

                        <td width="8%" align="center" bgcolor="#0099FF"><strong>Unit</strong></td>

                        <td width="9%" align="center" bgcolor="#0099FF"><strong>Unit  Price</strong></td>

                        <td width="13%" align="center" bgcolor="#0099FF"><strong>Quantity</strong></td>

                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Amount</strong></td>

                          <td width="6%"  rowspan="2" align="center" bgcolor="#FF0000">

						  <div class="button">

						  <input name="add" type="submit" id="add" value="ADD" tabindex="12" class="update"/>                       

					    </div>				        </td>

      </tr>

                      <tr>

<td align="center" bgcolor="#CCCCCC">

<input  name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>

<input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$warehouse_id?>"/>

<input  name="po_date" type="hidden" id="po_date" value="<?=$po_date?>"/>

<input  name="vendor_id" type="hidden" id="vendor_id" value="<?=$vendor_id?>"/>

<input  name="item_id" type="text" id="item_id" value="<?=$item_id?>" style="width:320px;" required onblur="getData2('po_ajax.php', 'po',this.value,document.getElementById('warehouse_id').value);"/></td>

<td colspan="3" align="center" bgcolor="#CCCCCC">

<span id="po">

<table>

<tr>

<td>

<input name="stk" type="text" class="input3" id="stk" style="width:80px;float:left;" readonly="readonly"/>

</td>

<td>

<input name="unit" type="text" class="input3" id="unit" style="width:80px;float:left;" readonly="readonly"/>

</td>

<td>

<input name="price" type="text" class="input3" id="price" style="width:80px;float:left;"  readonly="readonly"/>

</td>

</tr>

</table>

</span></td>

<td align="center" bgcolor="#CCCCCC"><input name="qty" type="text" class="input3" id="qty"  maxlength="100" style="width:90px;" onchange="count()" required/>

									</td>

<td align="center" bgcolor="#CCCCCC"><input name="amount" type="text" class="input3" id="amount" style="width:110px;" readonly="readonly" required/></td>

      </tr>

    </table>

<? }?>				  

<br /><br /><br /><br />





<table width="100%" border="0" cellspacing="0" cellpadding="0">



    <tr>

      <td>

<div class="tabledesign2">

<? 

$res='select a.id, b.finish_goods_code as item_code, concat(b.item_name) as item_name,a.unit_name as unit,a.qty as total_unit, a.amount,"x" from purchase_invoice a,item_info b where b.item_id=a.item_id and a.po_no='.$po_no;





echo link_report_add_del_auto($res,'',5,6);

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



<br />





<form  action="?" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">

  <table width="100%" border="0">

    <tr>

      <td align="center">



      <input name="delete"  type="submit" class="btn btn-primary" value="DELETE PURCHASE" style="width:270px; font-weight:bold; font-size:12px;color:#F00; height:30px" />



      </td>

      <td align="center">

	  

	  <input  name="po_no" type="hidden" id="po_no" value="<?=$$unique?>"/>



      <input name="confirmm" type="submit" class="btn btn-success" value="CONFIRM PURCHASE" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:#fff" />

</tr>

  </table>

</form>

<? }?>

</div><?php */?>





<script>$("#codz").validate(); </script>

<?

$main_content=ob_get_contents();

ob_end_clean();

require_once SERVER_CORE."routing/layout.bottom.php";

?>