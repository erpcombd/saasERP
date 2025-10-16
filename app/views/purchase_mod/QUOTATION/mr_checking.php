<?php


 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$title='Approving Purchase Quotation';

$module_name = find_a_field('user_module_manage','module_file','id='.$_SESSION["mod"]);





$table_master='quotation_master';

$table_details='quotation_detail';

$unique='quotation_no';

if($_GET[$unique]>0){
    $$unique = $_SESSION[$unique] = $_GET[$unique];
}

if(isset($_POST['new']))

{

		$crud   = new crud($table_master);



		if(!isset($_SESSION[$unique])) {

		
		
		

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d H:i:s');

		$$unique=$_SESSION[$unique]=$crud->insert();

		unset($$unique);

		$type=1;

		$msg='Requisition No Created. (Quotation No :-'.$_SESSION[$unique].')';

		}

		else {

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d H:i:s');

		$crud->update($unique);

		$type=1;

		$msg='Successfully Updated.';

		}

}



$$unique=$_SESSION[$unique];



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

		
		$_POST['checked_by']=$_SESSION['user']['id'];

		$_POST['checked_at']=date('Y-m-d H:i:s');
		

		$_POST['status']='CHECKED';

		$crud   = new crud($table_master);

		$crud->update($unique);

		unset($$unique);

		unset($_SESSION[$unique]);

		$type=1;

		$msg='Successfully Forwarded to Relevant Department.';

}



if(isset($_POST['add'])&&($_POST[$unique]>0))

{

		$crud   = new crud($table_details);

		$iii=explode('#>',$_POST['item_id']);
		
		$_POST['qty']=$_POST['qty_ctn'];

		$_POST['item_id']=$iii[2];

		$_POST['entry_by']=$_SESSION['user']['id'];

		$_POST['entry_at']=date('Y-m-d H:i:s');

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d H:i:s');

		$crud->insert();

}



if($$unique>0)

{

		$condition=$unique."=".$$unique;

		$data=db_fetch_object($table_master,$condition);

		foreach ($data as $key => $value)

		{ $$key=$value;}

		

}

if($$unique>0){ $btn_name='Update Quotation Information';} else {$btn_name='Initiate Quotation Information';}

if($_SESSION[$unique]<1){
    $$unique=db_last_insert_id($table_master,$unique);
}



auto_complete_from_db('item_info','item_name','concat(item_name,"#>",item_description,"#>",item_id)','product_nature!="Salable"','item_id');

?>

<script language="javascript">

function focuson(id) {

  if(document.getElementById('item_id').value=='')

  document.getElementById('item_id').focus();

  else

  document.getElementById(id).focus();

}



function update_edit(id)

{
var qty = (document.getElementById("qty#"+id).value);
var quotation_brand   = (document.getElementById("quotation_brand#"+id).value);
var quotation_price = (document.getElementById("quotation_price#"+id).value)*1;
var remarks  = (document.getElementById("remarks#"+id).value);

var info = qty+"<@>"+quotation_brand+"<@>"+quotation_price+"<@>"+remarks;

getData2('quotation_edit_ajax.php', 'ppp'+id,id,info);
}



window.onload = function() {

if(document.getElementById("warehouse_id").value>0)

  document.getElementById("item_id").focus();

  else

  document.getElementById("quotation_date").focus();

}

</script>




<div class="form-container_large">
    <form action="mr_create.php" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">

        <div class="container-fluid bg-form-titel">
            <div class="row">

                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <div class="container n-form2">
                        <div class="form-group row m-0 pb-1">
						   <? $field='quotation_no';?>
                            <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Quotation No :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                             
      
									<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>
									 
									<input name="store_quotation_no" type="hidden" id="store_quotation_no" 
									value="<? if($store_quotation_no>0){ echo $store_quotation_no;} else{ echo (find_a_field($table_master,'max(store_quotation_no)','1 and warehouse_id="'.$_SESSION['user']['depot'].'"')+1); }?>" readonly/>
									
   
                            </div>
                        </div>

                        <div class="form-group row m-0 pb-1">
							<? $field='quotation_date'; if($quotation_date==''){ $quotation_date =date('Y-m-d'); }?>
                            <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Quotation Date :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                 
        					<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required readonly=""/>
  
                            </div>
                        </div>

                        <div class="form-group row m-0 pb-1">
						
                            <label  for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Requisition No :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                              
								<select  name="req_no" id="req_no" required>
							
										<option></option>
							
									
								 	 <? foreign_relation('requisition_master','req_no','req_no',$req_no,'1 and warehouse_id="'.$_SESSION['user']['depot'].'" order by req_no');?>
							   </select>

                            </div>
                        </div>
						
						<div class="form-group row m-0 pb-1">
						
                            <label  for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Attached :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                              
								<!--<a href="../../../../media/quotation/<?=$data->	quotation?>" target="_blank">View Attachment</a>-->
								<a href="../../../assets/support/upload_view.php?name=<?=$data->quotation?>&folder=quotation&proj_id=<?=$_SESSION['proj_id']?>&mod=<?=$module_name?>" target="_blank">View Attachment</a>

                            </div>
                        </div>

                    </div>



                </div>

                <!--Right form-->
                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <div class="container n-form2">
                        <div class="form-group row m-0 pb-1">
                            <label for="<?=$group_for?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Company :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                
								<select  name="group_for" id="group_for" required>
								
							  <? foreign_relation('user_group','id','group_name',$group_for,'id='.$_SESSION['user']['group']);?>
								 </select>
                            </div>
                        </div>

                        <div class="form-group row m-0 pb-1">
							 <? $field='vendor_id'; $table='vendor';$get_field='vendor_id';$show_field='vendor_name';?>
                            <label for="<?=$field?>"  class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Vendor Name :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
																
										
									  
									
										
										<? if($vendor_id<1) { ?>
										
										
								
								<select  name="vendor_id" id="vendor_id" required>
								
								<option></option>
								
									
										
									  <? foreign_relation('vendor','vendor_id','vendor_name',$vendor_id,'1 order by vendor_id');?>
										 </select>
								
								
										
										
										<? }?>
										
										
										<? if($vendor_id>0) { ?>
											<input  name="vendor_id2" type="text" id="vendor_id2"  readonly=""
											value="<?=find_a_field('vendor','vendor_name','vendor_id='.$vendor_id)?>" required/>
											
											<input  name="vendor_id" type="hidden" id="vendor_id" value="<?=$vendor_id?>" required/>
										
										<? }?>
									  
									  <input  name="warehouse_id" type="hidden" id="warehouse_id" value="33" required/>
								   
                            </div>
                        </div>
<div class="form-group row m-0 pb-1">
								 
                            <label for=" "  class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Warehouse :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                
									<select  id="warehouse_id" name="warehouse_id" class="form-control"  style="width:250px;" >  
			   <? foreign_relation('warehouse','warehouse_id','warehouse_name',$warehouse_id,'warehouse_id="'.$_SESSION['user']['depot'].'"');?>
            </select>
								  

                            </div>
                        </div>
                        <div class="form-group row m-0 pb-1">
								 <? $field='remarks';?>
                            <label for="<?=$field?>"  class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Remarks :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                
									<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" />
								  

                            </div>
                        </div>

                    </div>



                </div>
            </div>

            <div class="n-form-btn-class">
                <input name="new" type="submit" class="btn1 btn1-bg-submit" value="<?=$btn_name?>" >
				
            </div>

            <div class="d-flex justify-content-center">
            <table border="1" cellpadding="5" cellspacing="0" style="padding: 5px; font-size: 9px !important;">
                <tr>
                <td style="padding: 2px; border-right: none;" align="right"><strong style="font-weight: bold;">Entry By : </strong> &nbsp;&nbsp;<?= find_a_field('user_activity_management', 'fname', 'user_id=' . $entry_by); ?></td>
                <!-- <td  style="padding: 7px;" align="left">
                    &nbsp;&nbsp;<?= find_a_field('user_activity_management', 'fname', 'user_id=' . $entry_by); ?>
                </td> -->
                <td style="padding: 2px;" align="right"><strong style="font-weight: bold;">Entry At : </strong>&nbsp;&nbsp;<?= date('d M Y, h:i:s A', strtotime($entry_at)); ?></td>
                <!-- <td style="padding: 7px;" align="left">
                    &nbsp;&nbsp;<?= date('H:i:s, d M Y', strtotime($entry_at)); ?>
                </td> -->
                <td style="padding: 2px;" align="center">
                <a href="quotation_print_view.php?quotation_no='<?=rawurlencode(url_encode($quotation_no));?>'" target="_blank">
                    <img src="../../../../public/assets/images/print.png" style="width: 20px;" />
                    </a>
                </td>
                </tr>
            </table>
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

<? if($_SESSION[$unique]>0){?>

<!-- <div class="d-flex justify-content-center">
    <table  border="1" align="center" cellpadding="0" cellspacing="0" >

  <tr>

    <td colspan="3" align="center"><strong>Entry Information</strong></td>

    </tr>

  <tr>

    <td align="right" > Entry By:</td>

    <td align="left" >&nbsp;&nbsp;<?=find_a_field('user_activity_management','fname','user_id='.$edit_by);?></td>

    <td rowspan="2" align="center" ><a href="quotation_print_view.php?quotation_no=<?=$quotation_no?>" target="_blank"><img src="../../../images/print.png"  /></a></td>

  </tr>

  <tr>

    <td align="right" >Entry On:</td>

    <td align="left" >&nbsp;&nbsp;<?=$edit_at?></td>

    </tr>

</table>
	
</div> -->

    <form action="" method="post" name="cloud" id="cloud">
        <!--Table input one design-->
        <div class="container-fluid pt-2 p-0 ">


            <table class="table1  table-striped table-bordered table-hover table-sm">
                <thead class="thead1">
                <tr class="bgc-info">
                    <th>SL</th>
                    <th>Item Name</th>
                    <th>Unit</th>

                    <th>Req Qty</th>
                    <th>Quotation Price</th>
					
                    <th>Remarks</th>

                    <th>Action</th>
                    <th>Delete</th>
                </tr>
                </thead>

                <tbody class="tbody1">
				
				
				<?
					$s=0;
					  $res='select a.id,   concat(b.item_name) as item_name, a.brand, a.origin, b.unit_name,  a.qty as qty , a.remarks, a.quotation_price, a.quotation_brand, a.remarks, "x" from quotation_detail a,item_info b where b.item_id=a.item_id and a.quotation_no='.$quotation_no;
					
					$query=db_query($res);
					
					while($data=mysqli_fetch_object($query)){
				?>

                <tr>
                    <td><?=++$s?></td>
                    <td><?=$data->item_name?></td>
                    <td><?=$data->unit_name?></td>

                    <td>
							<?=$data->qty?>
							<input type="hidden" name="<?='qty#'.$data->id?>" id="<?='qty#'.$data->id?>" value="<?=$data->qty?>"  onchange="TRcalculation(<?=$data->id?>)" />
				    </td>
                    <td>

 						<input type="hidden" name="<?='quotation_brand#'.$data->id?>" id="<?='quotation_brand#'.$data->id?>" value="0" />

						<input type="text" class="text-center" name="<?='quotation_price#'.$data->id?>" id="<?='quotation_price#'.$data->id?>" value="<?=$data->quotation_price?>"  onchange="TRcalculation(<?=$data->id?>)" />
					
					</td>
                    <td><input type="text" name="<?='remarks#'.$data->id?>" id="<?='remarks#'.$data->id?>" value="<?=$data->remarks?>"  onchange="TRcalculation(<?=$data->id?>)" />
					</td>
					

                    <td><span id="ppp<?=$data->id?>"><input name="<?='edit#'.$data->id?>" type="button" id="Edit" value="Set" class="btn1 btn1-bg-update"  onclick="update_edit(<?=$data->id?>);" /></span></td>
                    
					<td><a onclick="if(!confirm('Are You Sure Execute this?')){return false;}" href="?del=<?=$data->id?>">&nbsp;X&nbsp;</a></td>
					

                </tr>
					<? }?>
                </tbody>
            </table>





        </div>


        <!--Data multi Table design start-->
        <!--<div class="container-fluid pt-5 p-0 ">

            <table class="table1  table-striped table-bordered table-hover table-sm">
                <thead class="thead1">
                <tr class="bgc-info">
                    <th>Item Name</th>
                    <th>Stock Qty</th>
                    <th>Last Pur Qty</th>

                    <th>Last Pur Date</th>
                    <th>Qty</th>
                    <th>Action</th>
                </tr>
                </thead>

                <tbody class="tbody1">

                <tr>
                    <td>Row name 1</td>
                    <td>Row name 2</td>
                    <td>Row name 3</td>

                    <td>Row name 4</td>
                    <td>Row name 5</td>
                    <td><input name="submit" type="submit" class="btn1 btn1-bg-cancel" value="DELETE" /></td>

                </tr>

                </tbody>
            </table>

        </div>-->
    </form>

    <!--button design start-->
    <form action="" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
        <div class="container-fluid p-0 ">

            <div class="n-form-btn-class">
                
				<input name="delete"  type="submit" class="btn1 btn1-bg-cancel" value="DELETE AND CANCEL"  />
               
				<input name="confirmm" type="submit" class="btn1 btn1-bg-submit" value="CONFIRM AND FORWARD" />
            </div>

        </div>
    </form>
<? } ?>
</div>



<br /> <br />

<?php /*?><div class="form-container_large">

<form action="" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">

<table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">

  <tr>

    <td><fieldset>
    <? $field='quotation_no';?>
      <div>
        <label for="<?=$field?>" style="text-align:left">Quotation No: </label>
        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>
		 
		<input name="store_quotation_no" type="hidden" id="store_quotation_no" 
		value="<? if($store_quotation_no>0) echo $store_quotation_no; else echo (find_a_field($table_master,'max(store_quotation_no)','1 and warehouse_id="'.$_SESSION['user']['depot'].'"')+1);?>" readonly/>
		
      </div>
    <? $field='quotation_date'; if($quotation_date=='') $quotation_date =date('Y-m-d');?>
      <div>
        <label for="<?=$field?>" style="text-align:left">Quotation  Date:</label>
        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required readonly=""/>
      </div>
	  
	  
	  <? $field='req_no';?>
      <div>
        <label for="<?=$field?>" style="text-align:left">Requisition No:</label>
        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required />
      </div>
    
	  
	  
	  
	  
    </fieldset></td>

    <td>

			<fieldset style="height:225px">
			
 <div>
        <label for="<?=$group_for?>" style="text-align:left">Company:</label>
		<select  name="group_for" id="group_for" required>
		
      <? foreign_relation('user_group','id','group_name',$group_for,'id=1 ');?>
		 </select>
      </div>
	  
	  
	  
	  
	     <? $field='vendor_id'; $table='vendor';$get_field='vendor_id';$show_field='vendor_name';?>
	  
      <div>
        <label for="<?=$field?>" style="text-align:left">Vendor:</label>
		
		<? if($vendor_id<1) { ?>
		
		

<select  name="vendor_id" id="vendor_id" required>

	
		
      <? foreign_relation('vendor','vendor_id','vendor_name',$vendor_id,'vendor_category = 10 order by vendor_id');?>
		 </select>


		
		
		<? }?>
		
		
		<? if($vendor_id>0) { ?>
			<input  name="vendor_id2" type="text" id="vendor_id2"  readonly=""
			value="<?=find_a_field('vendor','vendor_name','vendor_id='.$vendor_id)?>" required/>
			
			<input  name="vendor_id" type="hidden" id="vendor_id" value="<?=$vendor_id?>" required/>
		
		<? }?>
	  
	  <input  name="warehouse_id" type="hidden" id="warehouse_id" value="33" required/>
   
	  
	  
	  <? $field='remarks';?>
      <div>
        <label for="<?=$field?>" style="text-align:left">Remarks:</label>
        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required />
      </div>
	
	      
			</fieldset>	</td>

  </tr>

  <tr>

    <td colspan="2"><div class="buttonrow" style="margin-left:300px;">

      <input name="new" type="submit" class="btn1" value="<?=$btn_name?>" style="width:250px; font-weight:bold; font-size:12px;" />

    </div></td>

    </tr>

</table>

</form>





<? if($_SESSION[$unique]>0){?>

<table width="40%" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">

  <tr>

    <td colspan="3" align="center" bgcolor="#CCFF99"><strong>Entry Information</strong></td>

    </tr>

  <tr>

    <td align="right" bgcolor="#CCFF99"> Entry By:</td>

    <td align="left" bgcolor="#CCFF99">&nbsp;&nbsp;<?=find_a_field('user_activity_management','fname','user_id='.$edit_by);?></td>

    <td rowspan="2" align="center" bgcolor="#CCFF99"><a href="quotation_print_view.php?quotation_no=<?=$quotation_no?>" target="_blank"><img src="../../../images/print.png" width="26" height="26" /></a></td>

  </tr>

  <tr>

    <td align="right" bgcolor="#CCFF99">Entry On:</td>

    <td align="left" bgcolor="#CCFF99">&nbsp;&nbsp;<?=$edit_at?></td>

    </tr>

</table>

<form action="?<?=$unique?>=<?=$$unique?>" method="post" name="cloud" id="cloud" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">

<!--<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">
                      <tr>
                        <td width="50%" align="center" bgcolor="#0099FF"><strong>Item Name</strong></td>
                            <td width="10%" align="center" bgcolor="#0099FF"><strong>Unit Name </strong></td>
                            <td width="15%" align="center" bgcolor="#0099FF"><strong>Brand</strong></td>
                            <td width="15%" align="center" bgcolor="#0099FF"><strong>Origin</strong></td>
                            <td width="15%" align="center" bgcolor="#0099FF"><strong>Quantity</strong></td>
                            <td width="15%" align="center" bgcolor="#0099FF"><strong>Remarks</strong></td>
                          <td width="5%"  rowspan="2" align="center" bgcolor="#FF0000">
						  <div class="button">
						  <input name="add" type="submit" id="add" value="ADD" tabindex="12" class="update"/>                       
						  </div>				        </td>
      </tr>
                      <tr>
                        <td align="center" bgcolor="#CCCCCC">
<input  name="<?=$unique?>"i="i" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>
<input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$warehouse_id?>"/>
<input  name="sub_depot" type="hidden" id="sub_depot" value="<?=$sub_depot?>"/>
<input  name="warehouse_to" type="hidden" id="warehouse_to" value="<?=$warehouse_to?>"/>
<input  name="quotation_date" type="hidden" id="quotation_date" value="<?=$quotation_date?>"/>
<input  name="group_for" type="hidden" id="group_for" value="<?=$group_for?>"/>
<input  name="item_id" type="text" id="item_id" value="<?=$item_id?>" style="width:320px; height:20px;" required="required" onblur="getData2('mr_ajax.php', 'mr', this.value, document.getElementById('warehouse_id').value);"/></td>
                        <td align="center" bgcolor="#CCCCCC">
						<span id="mr">
						
						<table>
							<tr>
								<td>

<input name="unit_name" type="text" class="input3" id="unit_name"  style="width:80px; height:20px;" onfocus="focuson('qty_ctn')" readonly="readonly"/>								</td>
							</tr>
						</table>
</span></td>
                        <td align="center" bgcolor="#CCCCCC">
						<select  name="brand" id="brand" required style="width:70px; height:25px;">
						<option></option>

     					 <? foreign_relation('item_brand','id','brand_name',$brand,'1');?>
					 </select>
						</td>
                        <td align="center" bgcolor="#CCCCCC">
							<select  name="origin" id="origin" required style="width:90px; height:25px;">
						<option></option>
     					 <? foreign_relation('country','id','country_name',$origin,'1');?>
					 </select>
						</td>
                        <td align="center" bgcolor="#CCCCCC"><input name="qty_ctn" type="text" class="input3" id="qty_ctn"  maxlength="100" style="width:80px;height:20px;" required/></td>
                        <td align="center" bgcolor="#CCCCCC"><input name="remarks" type="text" class="input3" id="remarks"  maxlength="100" style="width:120px;height:20px;" /></td>
      </tr>
    </table>-->

					  








  
  
  <table width="100%" border="0" cellspacing="0" cellpadding="0">&nbsp;
      <tr>
	  <br />
   
        <td><div class="tabledesign2">
          <table id="grp" width="100%" cellspacing="0" cellpadding="0"><tbody>
            
			
            <tr>
			<th width="8%">SL</th>
			<th width="36%">Item Name</th>
			<th width="7%">Unit  </th>
			<th width="13%">Req Qty </th>
			<th width="13%"><div align="center">Quotation Price </div></th>
			<th width="13%">Remarks</th>
			<th width="17%">Action</th>
      		<th width="6%">Delete</th>
			</tr>
            
            
            

<?
$s=0;
  $res='select a.id,   concat(b.item_name) as item_name, a.brand, a.origin, b.unit_name,  a.qty as qty , a.remarks, a.quotation_price, a.quotation_brand, a.remarks, "x" from quotation_detail a,item_info b where b.item_id=a.item_id and a.quotation_no='.$quotation_no;

$query=db_query($res);

while($data=mysqli_fetch_object($query)){
?>
<tr>
<td style="text-align:center;"><?=++$s?></td>
<td>&nbsp;<?=$data->item_name?></td>
<td>&nbsp;<?=$data->unit_name?></td>
<td>
<?=$data->qty?>
<input type="hidden" name="<?='qty#'.$data->id?>" id="<?='qty#'.$data->id?>" value="<?=$data->qty?>" style="width:50px; height:25px;" onchange="TRcalculation(<?=$data->id?>)" /></td>

<input type="hidden" name="<?='quotation_brand#'.$data->id?>" id="<?='quotation_brand#'.$data->id?>" value="0" style="width:50px; height:25px;" />
<td><input type="text" name="<?='quotation_price#'.$data->id?>" id="<?='quotation_price#'.$data->id?>" value="<?=$data->quotation_price?>" style="width:100px; height:25px;" onchange="TRcalculation(<?=$data->id?>)" /></td>
<td><input type="text" name="<?='remarks#'.$data->id?>" id="<?='remarks#'.$data->id?>" value="<?=$data->remarks?>" style="width:160px; height:25px;" onchange="TRcalculation(<?=$data->id?>)" /></td>
<td><span id="ppp<?=$data->id?>"><input name="<?='edit#'.$data->id?>" type="button" id="Edit" value="Edit" style="width:60px; height:30px; color:#000; font-weight:700 " onclick="update_edit(<?=$data->id?>);" /></span></td>
<td><a onclick="if(!confirm('Are You Sure Execute this?')){return false;}" href="?del=<?=$data->id?>">&nbsp;X&nbsp;</a></td>
</tr>
<? }?>







</table>
          </div></td>
      </tr>
      <tr>
        <td></td>
      </tr>
    </table>
  
  
  
  
  

</form>
<br />

<form action="" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">

  <table width="100%" border="0">

    <tr>

      <td align="center">



      <input name="delete"  type="submit" class="btn btn-primary" value="DELETE AND CANCEL" style="width:270px; font-weight:bold; font-size:12px;color:#F00; height:30px" />



      </td>

      <td align="center">



      <input name="confirmm" type="submit" class="btn btn-success" value="CONFIRM AND FORWARD" style="width:300px; font-weight:bold; float:right; font-size:12px; height:30px; color:#fff" />



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