<?php

require_once "../../../assets/template/layout.top.php";




$title='Purchased Material QC Inspection';



do_calander('#rec_date');



$table_master='purchase_master';

$table_details='purchase_invoice';


$get_po_no=$_GET['po_no'];
$unique='po_no';

if($_SESSION[$unique]>0)

$$unique=$_SESSION[$unique];

if($_GET[$unique]>0){

$$unique=$_GET[$unique];
$pc_no=$_GET['pc_no'];

$_SESSION[$unique]=$$unique;}

else

$$unique = $_SESSION[$unique];


if(isset($_POST['confirmm']))

{

		unset($_POST);

		$_POST[$unique]=$$unique;

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d h:s:i');

		$_POST['status']='COMPLETED';

		$crud   = new crud($table_master);

		$crud->update($unique);

		unset($$unique);

		unset($_SESSION[$unique]);

		$type=1;

		$msg='Successfully Completed All Purchase Order.';

}



if(isset($_POST['delete']))

{

		unset($_POST);

		$_POST[$unique]=$$unique;

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d h:s:i');

		$_POST['status']='CANCELED';

		$crud   = new crud($table_master);

		$crud->update($unique);

		unset($$unique);

		unset($_SESSION[$unique]);

		$type=1;

		$msg='Canceled Remainning All Purchase Order.';

}



if(prevent_multi_submit()){



if(isset($_POST['confirm'])){

		$vendor_id = $_POST['vendor_id'];

		$warehouse_id = $_POST['warehouse_id'];

		$qc_by=$_POST['qc_by'];

		$ch_no=$_POST['ch_no'];

		$rec_date=$_POST['rec_date'];

		$rec_no=$_POST['rec_no'];

		$now = date('Y-m-d H:i:s');
		
		$status='QC_RECEIVE';
		
		$sql = 'select * from purchase_invoice where po_no = '.$pc_no;

		$query = mysql_query($sql);

		$qc_no = find_a_field('qc_receive_purchase','max(qc_no)','1')+1;

		$vendor = find_all_field('vendor','ledger_id',"vendor_id=".$vendor_id);

		$vendor_ledger = $vendor->ledger_id;

		//$jv=next_journal_sec_voucher_id();

		while($data=mysql_fetch_object($query))

		{
			//////update purchase_invoice//////
			$unrec_qty=$_POST['unrec_qty_'.$data->id];
			$fresh_qty=$_POST['chalan_'.$data->id];
			$damage_qty=$_POST['damage_qty_'.$data->id];
			$tot_rec_input=$fresh_qty+$damage_qty;
			
			
		 
			$is_complete=$_POST['is_complete_'.$data->id];
				if($is_complete==1){
					$up_sql='update purchase_invoice set is_complete=1 where po_no="'.$po_no.'" and id="'.$data->id.'"';
					mysql_query($up_sql);
				}
		 

			if(($_POST['chalan_'.$data->id]>0))

			{
			
				$pc_no=$data->pc_no;
				
				$qty=$_POST['chalan_'.$data->id];
                
				$damage_qty=$_POST['damage_qty_'.$data->id];
				
				$short_qty=$_POST['short_qty_'.$data->id];
				$quarentine=$_POST['quarentine_'.$data->id];
				
				$all_qty=$_POST['all_qty_'.$data->id];
				
				$rate=$_POST['rate_'.$data->id];

				$item_id =$_POST['item_id_'.$data->id];

				$unit_name =$data->unit_name;

				$amount = ($qty*$rate);

				$total = $total + $amount;
				

  $q = "INSERT INTO `qc_receive_purchase` (`qc_no`, `po_no`, `order_no`, `rec_no`,`rec_date`, `vendor_id`, `item_id`, `warehouse_id`, `rate`, `qty`, `unit_name`, `amount`, `qc_by`, `entry_by`, `entry_at`,ch_no,status,damage_qty,short_qty,quarentine,all_qty,pc_no) VALUES('".$qc_no."', '".$po_no."', '".$data->id."', '".$rec_no."','".$rec_date."',".$vendor_id.", '".$item_id."',".$warehouse_id.", ".$rate.", '".$qty."', '".$unit_name."',  '".$amount."', '".$qc_by."',  '".$_SESSION['user']['id']."', '".$now."', '".$ch_no."','".$status."','".$damage_qty."','".$short_qty."','".$quarentine."','".$all_qty."','".$pc_no."')";

mysql_query($q);


//
//$xid = mysql_insert_id();
//
//journal_item_control($data->item_id ,$warehouse_id,$rec_date,$qty,0,'Purchase',$xid,$rate,'',$qc_no);


			}

		}
		
		
//if($xid>0)
//auto_insert_purchase_secoundary_journal($qc_no); 



}

}

else

{

	$type=0;

	$msg='Data Re-Submit Warning!';

}



if($$unique>0)

{

		$condition=$unique."=".$$unique;

		$data=db_fetch_object($table_master,$condition);

		while (list($key, $value)=each($data))

		{ $$key=$value;}

		

}

if($delivery_within>0)

{

	$ex = strtotime($po_date) + (($delivery_within)*24*60*60)+(12*60*60);

}

?>
<script>
function addup(id) {
var fresh=(document.getElementById("chalan_"+id).value)*1;
var damage=(document.getElementById("damage_qty_"+id).value)*1;
 
var add=fresh+damage;
document.getElementById("all_qty_"+id).value = add;
}

</script>

<style>
label{
color:black;
}

</style>





<div class="form-container_large">
    <form action="" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
<!--        top form start hear-->
        <div class="container-fluid bg-form-titel">
            <div class="row">
                <!--left form-->
                <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
                    <div class="container n-form2">
                        <div class="form-group row m-0 pb-1">
						 <? $field='po_no';?>
                            <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">PO NO </label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
        

       							 <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>

      
                            </div>
                        </div>

                        <div class="form-group row m-0 pb-1">
								 <? $field='po_date';?>
                            <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">PO Date</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                           

        						<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>

                            </div>
                        </div>

                        <div class="form-group row m-0 pb-1">
						<? $field='vendor_id2'; $table='vendor';$get_field='vendor_id';$show_field='vendor_name';?>
                            <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Supplier :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
              

       							 <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=find_a_field($table,$show_field,$get_field.'='.$vendor_id)?>"  readonly="readonly"/>

    

                            </div>
                        </div>
						<div class="form-group row m-0 pb-1">
								 <? $field='vendor_id2'; $table='vendor';$get_field='vendor_id';$show_field='address';?>
                            <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Address :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                            

        						<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=find_a_field($table,$show_field,$get_field.'='.$vendor_id)?>"  readonly="readonly"/>


                            </div>
                        </div>
						<div class="form-group row m-0 pb-1">
						 <? $field='vendor_id2'; $table='vendor';$get_field='vendor_id';$show_field='contact_no';?>
                            <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Contacts :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                      

       							 <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" style="width:200px;" readonly="readonly" />


                            </div>
                        </div>

                    </div>



                </div>

                <!--Right form-->
                <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
                    <div class="container n-form2">
                        <div class="form-group row m-0 pb-1">
								<? $field='req_no';?>
                            <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">PR. No :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                        
							<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"  readonly="readonly" />
    
                            </div>
                        </div>

                        <div class="form-group row m-0 pb-1">
								 <? $field='req_no';?>
                            <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">PR. Date:</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                              
								<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"  readonly="readonly" />

                            </div>
                        </div>

                        <div class="form-group row m-0 pb-1">
						      <? $field='warehouse_id'; $table='warehouse';$get_field='warehouse_id';$show_field='warehouse_name';?>
                            <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Warehouse :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                           


     								<input  name="warehouse_id2" type="text" id="warehouse_id2" value="<?=find_a_field($table,$show_field,$get_field.'='.$$field)?>" required="required" readonly="readonly"/>

		<input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$warehouse_id?>" required="required"/>


                            </div>
                        </div>
						<div class="form-group row m-0 pb-1">
						<? $field='entry_by'; $table='user_activity_management';$get_field='user_id';$show_field='fname';?>
                            <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Entry By:</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                

								<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=find_a_field($table,$show_field,$get_field.'='.$$field)?>" required="required" readonly=""/>


                            </div>
                        </div>
						
					

                    </div>



                </div>
				
				
				<div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
				
							<div class="d-flex justify-content-center pt-5 pb-2">
								<div class="n-form1 fo-white pt-0 p-0">
									<div class="container p-0">
									
									
									
								<table class="table1  table-striped table-bordered table-hover table-sm">
								
									<thead>
																			
												<tr class="bgc-yellow">
										
												  <td><strong>Date</strong></td>
										
												  <td><strong>QC NO</strong></td>
										
												</tr>
									</thead>
										
													  

										
										<?

 $sql='select distinct qc_no,rec_date from qc_receive_purchase where po_no='.$get_po_no.' order by qc_no desc';

$qqq=mysql_query($sql);

while($aaa=mysql_fetch_object($qqq)){

?>
										
												<tr>
										
												  <td><?=$aaa->rec_date?></td>
										
												  <td ><a target="_blank" href="chalan_view2.php?qc_no=<?=$aaa->qc_no?>"><?=$aaa->qc_no?></a></td>
										
												</tr>
										
										<?
										
										}
										
										?>
										
										
								</table>
										
						
						
						
									</div>
								</div>
							</div>
                   



                </div>
				


            </div>
			
			
			

            
        </div>


			<div class="d-flex justify-content-center pt-5 pb-2">
        <div class="n-form1 fo-white pt-0 p-0">
            <div class="container p-0">
			
			
			
			
			<table class="table1  table-striped table-bordered table-hover table-sm">

					  <tr>
					
						<td colspan="3" align="center"><strong>Entry Information</strong></td>
					
						</tr>
					
					  <tr>
					
						<td align="right" >Created By:</td>
					
						<td align="left" >&nbsp;&nbsp;<?=find_a_field('user_activity_management','fname','user_id='.$entry_by);?></td>
					
						<td rowspan="2" align="center" ><a href="../../../purchase_mod/pages/po/po_print_view.php?po_no=<?=$po_no?>" target="_blank"><img src="../../../images/print.png" width="26" height="26" /></a></td>
					
					  </tr>
					
					  <tr>
					
						<td align="right" >Created On:</td>
					
						<td align="left">&nbsp;&nbsp;<?=$entry_at?>></td>
					
						</tr>
					
					</table>
                



            </div>
        </div>
    </div>



<div class="container-fluid bg-form-titel">
            <div class="row">
                <!--left form-->
                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <div class="container n-form2">
                        <div class="form-group row m-0 pb-1">
						
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Manual QC NO</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
        

       							 <input   name="rec_no" type="text" id="rec_no" value="" required="required"/>

      
                            </div>
                        </div>

                        <div class="form-group row m-0 pb-1">
								 
                            <label  class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">QC Date :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                           
								<input  name="rec_date" type="text" id="rec_date" value="" required="required" autocomplete="off"/>
                            </div>
                        </div>

                       

                    </div>



                </div>

                <!--Right form-->
                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <div class="container n-form2">
                        <div class="form-group row m-0 pb-1">
								
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">QC By :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                        		<?php
									  $sql33="SELECT user_id,fname,mobile from user_activity_management";
									 
												$query23=mysql_query($sql33);
									
									 ?>		 
									
									 <input type="text" list="browsers112" name="qc_by" id="qc_by"  autocomplete="off" > 
									  <datalist id="browsers112">
									
									  <?php 
									  
									  while($datarow=mysql_fetch_object($query23)){
									  
									  
									  ?>
												  
											 <option value="<?=$datarow->user_id?>"> <?=$datarow->fname?></option> 
												   
									 <?php }?>
											  </datalist>
    
                            </div>
                        </div>

                        <div class="form-group row m-0 pb-1">
								 
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Chalan No :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                              
								<input   name="ch_no" type="text" id="ch_no" required="required"/>

                            </div>
                        </div>

                        
						
						
						
					

                    </div>



                </div>
				
				
				


            </div>
			
			
			

            
        </div>



        <!--return Table design start-->
        <div class="container-fluid pt-5 p-0 ">
				<? if($$unique>0){

					$sql='select a.id,a.item_id,b.item_name,b.unit_name,a.qty,a.rate from purchase_invoice a,item_info b where b.item_id=a.item_id and a.po_no='.$$unique;
					
					$res=mysql_query($sql);
					$s=1;
					?>
            <table class="table1  table-striped table-bordered table-hover table-sm">
                <thead class="thead1">
                <tr class="bgc-info">
                    <th rowspan="2">SL</th>
					<th rowspan="2">Item Code</th>
                    <th rowspan="2">Item Name</th>
                    <th rowspan="2">UOM</th>
					<th rowspan="2">PO Qty</th>
                    <th colspan="2">Received Qty</th>
                    <th rowspan="2">Pending Qty</th>
					<th rowspan="2">Fresh Quantity</th>
					<th rowspan="2">Damage Quantity</th>
					<th rowspan="2">Is Complete? </th>
                </tr>
				<tr>
            <th bgcolor="#009900">Fresh</th>
            <th bgcolor="#009900">Damage</th>
          </tr>
                </thead>
				
          

                <tbody class="tbody1">
				
				 <? while($row=mysql_fetch_object($res)){$bg++?>

				<tr <?=(($bg%2)==1)?'#FFEAFF':'#DDFFF9'?>>
	
				<td><?=++$ss;?></td>
	
				<td><?=find_a_field('item_info','finish_goods_code','item_id="'.$row->item_id.'"');?>

              <input type="hidden" name="item_id_<?=$row->id?>" id="item_id_<?=$row->id?>" value="<?=$row->item_id?>" /></td>
	
				  <td><?=$row->item_name?>
	
					<input  type="hidden" name="rate_<?=$row->id?>" id="rate_<?=$row->id?>" value="<?=$row->rate?>" style="width:90px; float:none" /></td>
	
				  <td align="center"><?=$row->unit_name?>
	
					<input type="hidden" name="unit_name_<?=$row->id?>" id="unit_name_<?=$row->id?>" value="<?=$row->unit_name?>" /></td>
	
				  <td align="center"><?=round($row->qty,0);?></td>
	
				  <td align="center"><?php   $rec_qty = (find_a_field('qc_receive_purchase','sum(all_qty)','order_no="'.$row->id.'" and item_id="'.$row->item_id.'"')*(1));
			  echo $fresh=find_a_field('qc_receive_purchase','sum(qty)','order_no="'.$row->id.'" and item_id="'.$row->item_id.'"')*(1);
			  ?></td>
	
				  <td align="center"><?php    echo $damage_get=find_a_field('qc_receive_purchase','sum(damage_qty)','order_no="'.$row->id.'" and item_id="'.$row->item_id.'"')*(1);?></td>
					
					<td align="center"><? echo $unrec_qty=($row->qty-$fresh);?>

                <input type="hidden" name="unrec_qty_<?=$row->id?>" id="unrec_qty_<?=$row->id?>" value="<?=$unrec_qty?>" /></td>
					
					<td align="center"> <? if($unrec_qty>0){$cow++;}?>
  <? if($row->is_complete<1){ ?>
                <input name="chalan_<?=$row->id?>" type="text" id="chalan_<?=$row->id?>" style="width:70px; float:none" value="" onchange="addup(<?=$row->id?>)"  />

                <? } else echo 'Done';?></td>
	
				  <td><input name="damage_qty_<?=$row->id?>" type="text" id="damage_qty_<?=$row->id?>" style="width:70px; float:none" value="" onchange="addup(<?=$row->id?>)"  /></td>
				 
<input name="all_qty_<?=$row->id?>" type="hidden" id="all_qty_<?=$row->id?>"  />
<td><input type="checkbox" id="is_complete_<?=$row->id?>" name="is_complete_<?=$row->id?>" value="1" <?php if ($row->is_complete>0){?>readonly checked="checked"<?php } ?>></td>
	
				  </tr>
					
					
				<? } ?>

                </tbody>
            </table>

        </div>
    



    <!--button design start-->
    
        <div class="container-fluid p-0 ">

            <div class="n-form-btn-class">
               <? 
$check_is_po=find_a_field('purchase_invoice','count(id)','is_complete!=1 and po_no="'.$po_no.'"');
if($check_is_po<1){

$vars['status']='QC_CHECKED';

db_update($table_master, $po_no, $vars, 'po_no');

?>

<tr>

<td colspan="2" align="center" bgcolor="#009900"><strong>THIS PURCHASE ORDER IS COMPLETE</strong></td>

</tr>

<? }else{?>

<tr>

<td align="center"><input name="delete" type="button" class="btn1 btn-danger" value="CANCEL PURCHASE ORDER"  onclick="window.location = 'select_dealer_chalan.php?del=1&po_no=<?=$po_no?>';" />

<input  name="vendor_id" type="hidden" id="vendor_id" value="<?=$vendor_id;?>"/></td>

<td align="center"><input name="confirm" type="submit" class="btn1 btn-success" value="RECEIVE"  /></td>

</tr>

<? }?>
				
					
					
            </div>

        </div>
		
		
	<? } ?>
    </form>

</div>









<?php /*?><div class="form-container_large">

<form action="" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">

<table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">

  <tr>

    <td valign="top"><fieldset style="width:459px;">

    <? $field='po_no';?>

      <div>

        <label style="width:85px;" for="<?=$field?>">PO  No: </label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>

      </div>

    <? $field='po_date';?>

      <div>

        <label style="width:85px;" for="<?=$field?>">PO Date:</label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>

      </div>
	  
	  <? $field='vendor_id2'; $table='vendor';$get_field='vendor_id';$show_field='vendor_name';?>

      <div>

	  <label style="width:85px;" for="<?=$field?>">Supplier :</label>

      <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=find_a_field($table,$show_field,$get_field.'='.$vendor_id)?>"  readonly="readonly"/>

      </div>
	  
	  
	  
	  <? $field='vendor_id2'; $table='vendor';$get_field='vendor_id';$show_field='address';?>

      <div>

	  <label style="width:85px;" for="<?=$field?>">Address :</label>

      <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=find_a_field($table,$show_field,$get_field.'='.$vendor_id)?>"  readonly="readonly"/>

      </div>
	  
	  
	  <? $field='vendor_id2'; $table='vendor';$get_field='vendor_id';$show_field='contact_no';?>

      <div>

	  <label style="width:85px;" for="<?=$field?>">Contacts :</label>

      <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=find_a_field($table,$show_field,$get_field.'='.$vendor_id)?>"  readonly="readonly"/>

      </div>

    

    

      
	  
	  <? $field='po_details';?>

      

    </fieldset>
	
	</td>

    <td>			
	</td>

    <td><fieldset style="width:467px;">

    <? $field='req_no';?>

      <div>

        <label style="width:85px;" for="<?=$field?>">PR. No:</label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" style="width:200px;" readonly="readonly" />

      </div>
	  
	  
	  
	  <? $field='req_date';?>

      <div>

        <label style="width:85px;" for="<?=$field?>">PR. Date:</label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" style="width:200px;" readonly="readonly" />

      </div>
	  
	  
	  
	 
	  
	  
	  <? $field='warehouse_id'; $table='warehouse';$get_field='warehouse_id';$show_field='warehouse_name';?>

      <div>

        <label style="width:85px;" for="<?=$field?>">Warehouse:</label>

        <input  name="warehouse_id2" type="text" id="warehouse_id2" value="<?=find_a_field($table,$show_field,$get_field.'='.$$field)?>" required="required" readonly="readonly"/>

		<input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$warehouse_id?>" required="required"/>

      </div>

      

         

      <div>

<? $field='entry_by'; $table='user_activity_management';$get_field='user_id';$show_field='fname';?>

        <div>

<label style="width:85px;" for="<?=$field?>">Entry By:</label>

<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=find_a_field($table,$show_field,$get_field.'='.$$field)?>" required="required" readonly=""/>

        </div>


        
		<? $field='ware_approve'; $table='user_activity_management'; $get_field='user_id';$show_field='fname';?>



		

      </div>

		</fieldset></td>

    <td>&nbsp;</td>

    <td valign="top"><table width="100%" border="1" cellspacing="0" cellpadding="0" style="font-size:10px; width:150px;">

	          

        <tr>

          <td align="center" bgcolor="white"><strong>Date</strong></td>

          <td align="center" bgcolor="white"><strong>QC NO.</strong></td>

        </tr>

<?

 $sql='select distinct qc_no,rec_date from qc_receive_purchase where po_no='.$get_po_no.' order by qc_no desc';

$qqq=mysql_query($sql);

while($aaa=mysql_fetch_object($qqq)){

?>

        <tr>

          <td bgcolor="#FFFF99"><?=$aaa->rec_date?></td>

          <td align="center" bgcolor="#FFFF99"><a target="_blank" href="chalan_view2.php?qc_no=<?=$aaa->qc_no?>"><?=$aaa->qc_no?></a></td>

        </tr>

<?

}

?>



      </table></td>

  </tr>

  <tr>

    <td colspan="5" valign="top"><table width="40%" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">

      <tr>

        <td colspan="3" align="center" bgcolor="#CCFF99"><strong>Entry Information</strong></td>

      </tr>

      <tr>

        <td align="right" bgcolor="#CCFF99">Created By:</td>

        <td align="left" bgcolor="#CCFF99">&nbsp;&nbsp;

            <?=find_a_field('user_activity_management','fname','user_id='.$entry_by);?></td>

        

      </tr>

      <tr>

        <td align="right" bgcolor="#CCFF99">Created On:</td>

        <td align="left" bgcolor="#CCFF99">&nbsp;&nbsp;

            <?=$entry_at?></td>

      </tr>

    </table></td>

  </tr>

  <tr>

    <td colspan="5" valign="top">



	<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">

      <tr>

        <td align="right" bgcolor="#9999FF"><strong>Manual QC NO: </strong></td>

        <td align="right" bgcolor="#9999FF"><strong>

          <input style="width:105px;"  name="rec_no" type="text" id="rec_no" value="" required="required"/>

        </strong></td>

        <td align="right" bgcolor="#9999FF"><strong>QC Date :</strong></td>

        <td bgcolor="#9999FF"><strong>

          <input style="width:105px;"  name="rec_date" type="text" id="rec_date" value="" required="required" autocomplete="off"/>

        </strong></td>

        <td align="right" bgcolor="#9999FF"><strong>QC By :</strong></td>

        <td bgcolor="#9999FF"><strong>

       



<?php
  $sql33="SELECT user_id,fname,mobile from user_activity_management";
 
			$query23=mysql_query($sql33);

 ?>		 

 <input list="browsers112" name="qc_by" id="qc_by" class="input3" autocomplete="off" style="width:180px;"> 
  <datalist id="browsers112">

  <?php 
  
  while($datarow=mysql_fetch_object($query23)){
  
  
  ?>
              
		 <option value="<?=$datarow->user_id?>"> <?=$datarow->fname?></option> 
			   
 <?php }?>
		  </datalist>





        </strong></td>

        <td bgcolor="#9999FF"><div align="right"><strong>Chalan No :</strong></div></td>

        <td bgcolor="#9999FF"><strong>

          <input style="width:105px;"  name="ch_no" type="text" id="ch_no" required="required"/>

        </strong></td>

      </tr>

    </table></td>

    </tr>

</table>

<? if($$unique>0){

$sql='select a.id,a.item_id,b.item_name,b.unit_name,a.qty,a.rate,a.is_complete from purchase_invoice a,item_info b where b.item_id=a.item_id  and a.po_no='.$$unique;

$res=mysql_query($sql);

?>

<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">

    <tr>

      <td><div class="tabledesign2">

      <table width="100%" align="center" cellpadding="0" cellspacing="0" id="grp">

      <tbody>

          <tr>

            <th rowspan="2">SL</th>

            <th rowspan="2">Item Code</th>

            <th width="35%" rowspan="2">Item Name</th>

            <th rowspan="2" bgcolor="#FFFFFF">UOM</th>

            <th rowspan="2" bgcolor="#FF99FF">PO Qty</th>

            <th colspan="2" bgcolor="#009900">Received Qty</th>

            <th rowspan="2" bgcolor="#FFFF00">Pending Qty</th>

            <th rowspan="2" bgcolor="#0099CC">Fresh Quantity </th>
			<th rowspan="2" bgcolor="#0099CC">Damage Quantity </th>
			 <th rowspan="2" bgcolor="#0099CC">Is Complete? </th>
          </tr>
          <tr>
            <th bgcolor="#009900">Fresh</th>
            <th bgcolor="#009900">Damage</th>
          </tr>

          

          <? while($row=mysql_fetch_object($res)){$bg++?>

          <tr bgcolor="<?=(($bg%2)==1)?'#FFEAFF':'#DDFFF9'?>">

            <td><?=++$ss;?></td>

            <td><?=find_a_field('item_info','finish_goods_code','item_id="'.$row->item_id.'"');?>

              <input type="hidden" name="item_id_<?=$row->id?>" id="item_id_<?=$row->id?>" value="<?=$row->item_id?>" /></td>

              <td><?=$row->item_name?>

                <input type="hidden" name="rate_<?=$row->id?>" id="rate_<?=$row->id?>" value="<?=$row->rate?>" /></td>

              <td width="7%" align="center"><?=$row->unit_name?>

                <input type="hidden" name="unit_name_<?=$row->id?>" id="unit_name_<?=$row->id?>" value="<?=$row->unit_name?>" /></td>

              <td width="7%" align="center"><?=round($row->qty,0);?></td>

              <td width="3%" align="center"><?php   $rec_qty = (find_a_field('qc_receive_purchase','sum(all_qty)','order_no="'.$row->id.'" and item_id="'.$row->item_id.'"')*(1));
			  echo $fresh=find_a_field('qc_receive_purchase','sum(qty)','order_no="'.$row->id.'" and item_id="'.$row->item_id.'"')*(1);
			  ?></td>

              <td width="3%" align="center"><?php    echo $damage_get=find_a_field('qc_receive_purchase','sum(damage_qty)','order_no="'.$row->id.'" and item_id="'.$row->item_id.'"')*(1);?></td>
              <td width="7%" align="center"><? echo $unrec_qty=($row->qty-$fresh);?>

                <input type="hidden" name="unrec_qty_<?=$row->id?>" id="unrec_qty_<?=$row->id?>" value="<?=$unrec_qty?>" /></td>

              <td width="5%" align="center" bgcolor="#6699FF" style="text-align:center">

			  <? if($unrec_qty>0){$cow++;}?>
  <? if($row->is_complete<1){ ?>
                <input name="chalan_<?=$row->id?>" type="text" id="chalan_<?=$row->id?>" style="width:70px; float:none" value="" onchange="addup(<?=$row->id?>)"  />

                <? } else echo 'Done';?></td>
				<td><input name="damage_qty_<?=$row->id?>" type="text" id="damage_qty_<?=$row->id?>" style="width:70px; float:none" value="" onchange="addup(<?=$row->id?>)"  /></td>
				 
<input name="all_qty_<?=$row->id?>" type="hidden" id="all_qty_<?=$row->id?>"  />
<td><input type="checkbox" id="is_complete_<?=$row->id?>" name="is_complete_<?=$row->id?>" value="1" <?php if ($row->is_complete>0){?>readonly checked="checked"<?php } ?>></td>
              </tr>

          <? }?>
      </tbody>
      </table>

      </div>

      </td>

    </tr>

  </table><br />

<table width="100%" border="0">

<? 
$check_is_po=find_a_field('purchase_invoice','count(id)','is_complete!=1 and po_no="'.$po_no.'"');
if($check_is_po<1){

$vars['status']='QC_CHECKED';

db_update($table_master, $po_no, $vars, 'po_no');

?>

<tr>

<td colspan="2" align="center" bgcolor="#FF3333"><strong>THIS PURCHASE ORDER IS COMPLETE</strong></td>

</tr>

<? }else{?>

<tr>

<td align="center"><input name="delete" type="button" class="btn btn-danger" value="CANCEL PURCHASE ORDER" style="width:270px;height:37px" onclick="window.location = 'select_dealer_chalan.php?del=1&po_no=<?=$po_no?>';" />

<input  name="vendor_id" type="hidden" id="vendor_id" value="<?=$vendor_id;?>"/></td>

<td align="center"><input name="confirm" type="submit" class="btn btn-success" value="RECEIVE" style="width:270px;height:37px;" /></td>

</tr>

<? }?>

</table>

<? }?>

</form>

</div><?php */?>

<script>$("#codz").validate();$("#cloud").validate();</script>

<?

require_once "../../../assets/template/layout.bottom.php";



?>