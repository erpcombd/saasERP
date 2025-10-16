<?php



require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$c_id = $_SESSION['proj_id'];


$title='Primary Receive';



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



if(isset($_POST['confirm']) && $_SESSION['csrf_token']===$_POST['csrf_token']){
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));

		$vendor_id = $_POST['vendor_id'];

		$warehouse_id = $_POST['warehouse_id'];

		$qc_by=$_POST['qc_by'];

		$ch_no=$_POST['ch_no'];

		$rec_date=$_POST['rec_date'];

		$rec_no=$_POST['rec_no'];

		$now = date('Y-m-d H:i:s');
		
		$status='PRIMARY_RECEIVED';
		
		$sql = 'select * from purchase_invoice where po_no = '.$pc_no;

		$query = db_query($sql);

		$pmr_no = find_a_field('primary_receive_purchase','max(pmr_no)','1')+1;

		$vendor = find_all_field('vendor','ledger_id',"vendor_id=".$vendor_id);

		$vendor_ledger = $vendor->ledger_id;

		//$jv=next_journal_sec_voucher_id();

		while($data=mysqli_fetch_object($query))

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
				
				$all_qty=$_POST['chalan_'.$data->id];
				
				$rate=$_POST['rate_'.$data->id];

				$item_id =$_POST['item_id_'.$data->id];

				$unit_name =$data->unit_name;

				$amount = ($qty*$rate);

				$total = $total + $amount;
				

  $q = "INSERT INTO `primary_receive_purchase` (`pmr_no`, `po_no`, `order_no`, `rec_no`,`rec_date`, `vendor_id`, `item_id`, `warehouse_id`, `rate`, `qty`, `unit_name`, `amount`, `pmr_by`, `entry_by`, `entry_at`,ch_no,status,damage_qty,short_qty,quarentine,all_qty,pc_no) VALUES('".$pmr_no."', '".$po_no."', '".$data->id."', '".$rec_no."','".$rec_date."',".$vendor_id.", '".$item_id."',".$warehouse_id.", ".$rate.", '".$qty."', '".$unit_name."',  '".$amount."', '".$qc_by."',  '".$_SESSION['user']['id']."', '".$now."', '".$ch_no."','".$status."','".$damage_qty."','".$short_qty."','".$quarentine."','".$all_qty."','".$pc_no."')";

db_query($q);


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

		foreach ($data as $key => $value)

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



<script>
function cal2(id) {
  var grn_qty = ((document.getElementById('chalan_'+id).value)*1);
  var unrec_qty = ((document.getElementById('unrec_qty_'+id).value)*1);
 
  if(grn_qty>unrec_qty)
  {

		alert('Can not Receive More than Unreceive Qty.');
		document.getElementById('chalan_'+id).value='';
		document.getElementById('chalan_'+id).focus();

  }
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
								  <? $field='req_date'; $show_field=find_a_field('requisition_master','req_date','req_no='.$req_no);?>
                            <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">PR. Date:</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                              
								<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$show_field?>"  readonly="readonly" />

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
										
												  <td><strong>Primary Rec NO</strong></td>
										
												</tr>
									</thead>
										
													  

										
										<?

 $sql='select distinct pmr_no,rec_date from primary_receive_purchase where po_no='.$get_po_no.' order by pmr_no desc';

$qqq=db_query($sql);

while($aaa=mysqli_fetch_object($qqq)){

?>
										
												<tr>
										
												  <td><?=$aaa->rec_date?></td>
										
												  <td ><a target="_blank" href="chalan_view2.php?pmr_no=<?=$aaa->pmr_no?>"><?=$aaa->pmr_no?></a></td>
										
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
					
						<?php /*?><td rowspan="2" align="center" ><a href="../../../purchase_mod/pages/po/po_print_view.php?po_no=<?=$po_no?>" target="_blank"><img src="../../../images/print.png" width="26" height="26" /></a></td><?php */?>
						
						
						<td rowspan="2" align="center" ><a href="../../../purchase_mod/pages/po/po_print_view.php?c=<?=rawurlencode(url_encode($c_id))?>&v=<?=rawurlencode(url_encode($po_no))?>" target="_blank"><img src="../../../images/print.png" width="26" height="26" /></a></td>
					
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
						
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Manual Primary Rec NO</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
        

       							 <input   name="rec_no" type="text" id="rec_no" value="" required="required"/>

      
                            </div>
                        </div>

                        <div class="form-group row m-0 pb-1">
								 
                            <label  class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"> Rec Date :</label>
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
								
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Primary Receive By :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                        		<?php
									  $sql33="SELECT user_id,fname,mobile from user_activity_management";
									 
												$query23=db_query($sql33);
									
									 ?>		 
									
									 <input type="text" list="browsers112" name="qc_by" id="qc_by"  autocomplete="off" > 
									  <datalist id="browsers112">
									
									  <?php 
									  
									  while($datarow=mysqli_fetch_object($query23)){
									  
									  
									  ?>
												  
											 <option value="<?=$datarow->fname?>"> <?=$datarow->user_id?></option> 
												   
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
					
					$res=db_query($sql);
					$s=1;
					?>
            <table class="table1  table-striped table-bordered table-hover table-sm">
                <thead class="thead1">
                <tr class="bgc-info">
                    <th>SL</th>
					<th>Item Code</th>
                    <th>Item Name</th>
                    <th>UOM</th>
					<th>PO Qty</th>
                    <th>Received Qty</th>
                    <th>Pending Qty</th>
					<th>Quantity</th>
				 
                </tr>
                </thead>
				
          

                <tbody class="tbody1">
				
				 <? while($row=mysqli_fetch_object($res)){$bg++?>

				<tr <?=(($bg%2)==1)?'#FFEAFF':'#DDFFF9'?>>
	
				<td><?=++$ss;?></td>
	
				<td><?=find_a_field('item_info','finish_goods_code','item_id="'.$row->item_id.'"');?>

              <input type="hidden" name="item_id_<?=$row->id?>" id="item_id_<?=$row->id?>" value="<?=$row->item_id?>" /></td>
	
				  <td><?=$row->item_name?>
	
					<input  type="hidden" name="rate_<?=$row->id?>" id="rate_<?=$row->id?>" value="<?=$row->rate?>" style="width:90px; float:none" /></td>
	
				  <td align="center"><?=$row->unit_name?>
	
					<input type="hidden" name="unit_name_<?=$row->id?>" id="unit_name_<?=$row->id?>" value="<?=$row->unit_name?>" /></td>
	
				  <td align="center"><?=round($row->qty,0);?></td>
	
				  <td align="center"><?php   $rec_qty = (find_a_field('primary_receive_purchase','sum(qty)','order_no="'.$row->id.'" and item_id="'.$row->item_id.'"')*(1));
			  echo $get_qty=find_a_field('primary_receive_purchase','sum(qty)','order_no="'.$row->id.'" and item_id="'.$row->item_id.'"')*(1);
			  ?></td>
	
				  <td align="center"><? echo $unrec_qty=($row->qty-$get_qty);?>

                <input type="hidden" name="unrec_qty_<?=$row->id?>" id="unrec_qty_<?=$row->id?>" value="<?=$unrec_qty?>" /></td>
					
					<td align="center"> <? if($unrec_qty>0){$cow++;?>
   
                <input name="chalan_<?=$row->id?>" type="text" onkeyup="cal2(<?=$row->id?>)" id="chalan_<?=$row->id?>" style="width:70px; float:none" value=""    />

                <? } else echo 'Done';?></td>
	
				  <input name="all_qty_<?=$row->id?>" type="hidden" id="all_qty_<?=$row->id?>"  />
 
				  </tr>
					
					
				<? } ?>
                </tbody>
            </table>

        </div>
    



    <!--button design start-->
    
        <div class="container-fluid p-0 ">

            <div class="n-form-btn-class"  >
               <? 
 
if($cow<1){

$vars['status']='PRIMARY_RECEIVED';

db_update($table_master, $po_no, $vars, 'po_no');

?>

<tr>

<td colspan="2" align="center" bgcolor="RED"  ><strong style="background-color:red;color:white;padding:10px;">THIS PRIMARY RECEIVE IS COMPLETE</strong></td>

</tr>

<? }else{?>

<tr>

<td align="center"><input type="button" class="btn1 btn1-bg-help" value="CLOSE"  onclick="window.location.href='select_upcoming_po.php'" />

<input  name="vendor_id" type="hidden" id="vendor_id" value="<?=$vendor_id;?>"/></td>

<td align="center">
<input  name="csrf_token" type="hidden" id="csrf_token" value="<?=$_SESSION['csrf_token']?>"/>
<input name="confirm" type="submit" class="btn1 btn-success" value="RECEIVE"  />


</td>

</tr>

<? }?>
				
					
					
            </div>

        </div>
		
		
	<? } ?>
    </form>

</div>







<script>$("#codz").validate();$("#cloud").validate();</script>

<?

require_once SERVER_CORE."routing/layout.bottom.php";



?>