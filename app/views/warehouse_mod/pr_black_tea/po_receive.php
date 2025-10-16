<?php



session_start();







ob_start();




require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";







$title='Purchased Product Receive (PR)';







do_calander('#rec_date');







$table_master='purchase_master';



$table_details='purchase_receive';



$unique='po_no';



//var_dump($_POST);



if($_SESSION[$unique]>0)



$$unique=$_SESSION[$unique];







if($_REQUEST[$unique]>0){



$$unique=$_REQUEST[$unique];



$_SESSION[$unique]=$$unique;}



else



$$unique = $_SESSION[$unique];















if(isset($_POST['confirmm']))



{



		unset($_POST);



		$_POST[$unique]=$$unique;



		$_POST['edit_by']=$_SESSION['user']['id'];



		$_POST['edit_at']=date('Y-m-d H:i:s');



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



		$_POST['edit_at']=date('Y-m-d H:i:s');



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

		

		$sale_no=$_POST['sale_no'];



		$qc_by=$_POST['qc_by'];

		

		$truck_no=$_POST['truck_no'];



		$ch_no=$_POST['ch_no'];



		$rec_date=$_POST['rec_date'];



		$rec_no=$_POST['rec_no'];



		$now = date('Y-m-d H:i:s');



		



		 $sql = 'select * from purchase_invoice where po_no = '.$po_no;



		$query = db_query($sql);



		$pr_no = find_a_field('purchase_receive','max(pr_no)','1')+1;



		$vendor = find_all_field('vendor','ledger_id',"vendor_id=".$vendor_id);



		$vendor_ledger = $vendor->ledger_id;



		$jv=next_journal_sec_voucher_id();



		while($data=mysqli_fetch_object($query))



		{



			if(($_POST['chalan_'.$data->id]>0))



			{



				$qty=$_POST['chalan_'.$data->id];



				$rate=$_POST['rate_'.$data->id];



				$item_id =$_POST['item_id_'.$data->id];

				

				$lot_no =$_POST['lot_no_'.$data->id];

				

				$garden_id =$_POST['garden_id_'.$data->id];

				

				$shed_id =$_POST['shed_id_'.$data->id];

				

				$quality =$_POST['quality_'.$data->id];

				

				$invoice_no =$_POST['invoice_no_'.$data->id];

				

				$pkgs =$_POST['pkgs_'.$data->id];

				

				$sam_pay =$_POST['sam_pay_'.$data->id];

				

				$sam_qty =$_POST['sam_qty_'.$data->id];



				$unit_name =$data->unit_name;
				
				$lot_no =$data->lot_no;
				
				$garden_id =$data->garden_id;
				
				$shed_id =$data->shed_id;
				
				$quality =$data->quality;
				
				$invoice_no =$data->invoice_no;
				
				$pkgs =$data->pkgs;
				
				$invoice_no =$data->invoice_no;
				
				$sam_pay =$data->sam_pay;
				
				$sam_qty =$data->sam_qty;



				$amount = ($qty*$rate);



				$total = $total + $amount; 



  $q = "INSERT INTO `purchase_receive` (`pr_no`, `po_no`, `sale_no`, `order_no`, `rec_no`,`rec_date`, `vendor_id`, `item_id`, `warehouse_id`, `rate`, `qty`, `unit_name`, `amount`, `qc_by`, `truck_no`,`entry_by`, `entry_at`,ch_no, `lot_no`, `garden_id`,  `shed_id`, `quality`, `invoice_no`, `pkgs`, `sam_pay`, `sam_qty` ) VALUES('".$pr_no."', '".$po_no."',  '".$sale_no."', '".$data->id."', '".$rec_no."','".$rec_date."',".$vendor_id.", ".$item_id.",".$warehouse_id.", ".$rate.", '".$qty."', '".$unit_name."',  '".$amount."', '".$qc_by."', '".$truck_no."', '".$_SESSION['user']['id']."', '".$now."', '".$ch_no."', '".$lot_no."', '".$garden_id."', '".$shed_id."', '".$quality."',  '".$invoice_no."',  '".$pkgs."',  '".$sam_pay."',  '".$sam_qty."')";



db_query($q);







$xid = db_insert_id();



journal_item_control($data->item_id ,$warehouse_id,$rec_date,$qty,0,'Purchase',$xid,$rate,'',$pr_no, $quality, $garden_id, $sale_no, $lot_no, $invoice_no );











//echo $q;











			}



		}





//if($xid>0)

//auto_insert_purchase_secoundary_update($pr_no);



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



	$ex = strtotime($po_date) + (($delivery_within)*24*60*60);



}



?>







<div class="form-container_large">



<form action="" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">



<table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">



  <tr>



    <td valign="top"><fieldset style="width:300px;">



    <? $field='po_no';?>



      <div>



        <label style="width:85px;" for="<?=$field?>">PO  No: </label>



        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" readonly="readonly"/>



      </div>



    <? $field='po_date';?>



      <div>



        <label style="width:85px;" for="<?=$field?>">PO Date:</label>



        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required readonly="readonly"/>



      </div>



    



    <? $field='warehouse_id'; $table='warehouse';$get_field='warehouse_id';$show_field='warehouse_name';?>



      <div>



        <label style="width:85px;" for="<?=$field?>">Warehouse:</label>



        <input  name="warehouse_id2" type="text" id="warehouse_id2" value="<?=find_a_field($table,$show_field,$get_field.'='.$$field)?>" required="required" readonly="readonly"/>



		<input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$warehouse_id?>" required="required"/>



      </div>



      <? $field='po_details';?>



      <div>



        <label style="width:85px;" for="<?=$field?>">Note:</label>



        <textarea name="<?=$field?>" id="<?=$field?>" readonly="readonly"><?=$$field?></textarea>



      </div>



    </fieldset></td>



    <td>			</td>



    <td><fieldset style="width:300px;">



   



      <div></div>



      <? $field='vendor_id2'; $table='vendor';$get_field='vendor_id';$show_field='vendor_name';?>



      <div>



	  <label style="width:85px;" for="<?=$field?>">Party:</label>



      <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=find_a_field($table,$show_field,$get_field.'='.$vendor_id)?>" readonly="readonly"/>



      </div>



            

			

			 <? $field='sale_no';?>



      <div>



        <label style="width:85px;" for="<?=$field?>">Sale No:</label>



        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" style="width:200px;" readonly="readonly" />



      </div>

			

			

			

			 <? $field='sale_date';?>



      <div>



        <label style="width:85px;" for="<?=$field?>">Sale Date:</label>



        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" style="width:200px;" readonly="readonly" />



      </div>

			

			

		<? $field='prompt_date';?>



      <div>



        <label style="width:85px;" for="<?=$field?>">Prompt Date:</label>



        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" style="width:200px;" readonly="readonly" />



      </div>

			

			

			

		<? $field='contract_no';?>



      <div>



        <label style="width:85px;" for="<?=$field?>">Contract No:</label>



        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" style="width:200px;" readonly="readonly" />



      </div>

			

			

			

			

			

			



<? $field='entry_by'; $table='user_activity_management';$get_field='user_id';$show_field='fname';?>



        <div>



<label style="width:85px;" for="<?=$field?>">Entry By:</label>



<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=find_a_field($table,$show_field,$get_field.'='.$$field)?>" required="required" readonly="readonly"/>



        </div>





        <?php /*?><? $field='checked_by';?>







		<div>



		<label style="width:85px;" for="<?=$field?>">Approved By:</label>



		<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=find_a_field($table,$show_field,$get_field.'='.$$field)?>"/>



		</div><?php */?>



      </div>



		</fieldset></td>



    <td>&nbsp;</td>



    <td valign="top"><table width="100%" border="1" cellspacing="0" cellpadding="0" style="font-size:10px;">



	          



        <tr>



          <td align="left" bgcolor="#9999CC"><strong>Date</strong></td>



          <td align="left" bgcolor="#9999CC"><strong>PR</strong></td>



        </tr>



<?



$sql='select distinct pr_no,rec_date from purchase_receive where po_no='.$po_no.' order by pr_no desc';



$qqq=db_query($sql);



while($aaa=mysqli_fetch_object($qqq)){



?>



        <tr>



          <td bgcolor="#FFFF99"><?=$aaa->rec_date?></td>



          <td align="center" bgcolor="#FFFF99"><a target="_blank" href="../pr_black_tea/chalan_view.php?v_no=<?=$aaa->pr_no?>"><img src="../../images/print.png" width="15" height="15" /></a></td>



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



        <td rowspan="2" align="center" bgcolor="#CCFF99"><a href="po_print_view.php?po_no=<?=$po_no?>" target="_blank"><img src="../../images/print.png" width="26" height="26" /></a></td>



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



<?php /*?>	<? if($ex<time()){?>



	<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FF0000">



      <tr>



        <td align="right" bgcolor="#FF0000"><div align="center" style="text-decoration:blink"><strong>THIS PURCHASE ORDER IS EXPIRED</strong></div></td>



        </tr>



    </table>



    <? }?><?php */?>



	<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">



      <tr>



        <td width="6%" align="right" bgcolor="#9999FF"><strong>Rec NO: </strong></td>



        <td width="4%" align="right" bgcolor="#9999FF"><strong>



          <input style="width:50px;"  name="rec_no" type="text" id="rec_no" value="" required="required"/>



        </strong></td>



        <td width="12%" align="right" bgcolor="#9999FF"><strong>Rec Date :</strong></td>



        <td width="8%" bgcolor="#9999FF"><strong>



          <input style="width:80px;"  name="rec_date" type="text" id="rec_date" value="" required="required"/>



        </strong></td>



        <td width="10%" align="right" bgcolor="#9999FF"><strong>QC By :</strong></td>



        <td width="10%" bgcolor="#9999FF"><strong>



          <input style="width:90px;"  name="qc_by" type="text" id="qc_by" required="required"/>



        </strong></td>

		

		 <td width="12%" align="right" bgcolor="#9999FF"><strong>Truck No :</strong></td>



        <td width="13%" bgcolor="#9999FF"><strong>



          <input style="width:90px;"  name="truck_no" type="text" id="truck_no" required="required"/>



        </strong></td>



        <td width="13%" bgcolor="#9999FF"><div align="right"><strong>Chalan No :</strong></div></td>



        <td width="12%" bgcolor="#9999FF"><strong>



          <input style="width:80px;"  name="ch_no" type="text" id="ch_no" required="required"/>



        </strong></td>



      </tr>



    </table></td>



    </tr>



</table>



<? if($$unique>0){



$sql='select a.*,b.item_name,b.unit_name,b.item_id, g.garden_name, w.warehouse_nickname from purchase_invoice a,item_info b, tea_garden g, tea_warehouse w where b.item_id=a.item_id and g.garden_id=a.garden_id and w.warehouse_id=a.shed_id and a.po_no='.$$unique;



$res=db_query($sql);



?>



<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">



    <tr>



      <td><div class="tabledesign2">



      <table width="100%" align="center" cellpadding="0" cellspacing="0" id="grp">



      <tbody>



          <tr>



            <th width="5%">SL</th>



            <th width="8%">Lot No. </th>

            <th width="14%">Gar. Name </th>

            <th width="8%">Inv No</th>

            <th width="10%">Item Grade </th>



            <th width="7%">Shed</th>

            <th width="7%"><strong>Liquor Marks</strong></th>

            <th bgcolor="#FFFFFF">Pkgs</th>

            <th bgcolor="#FFFFFF">Unit</th>



            <th bgcolor="#FF99FF">Total Kgs</th>



            <th bgcolor="#009900">Recd </th>



            <th bgcolor="#FFFF00">UnRecd </th>



            <th bgcolor="#0099CC">RecQty </th>

          </tr>



          



          <? while($row=mysqli_fetch_object($res)){$bg++?>



          <tr bgcolor="<?=(($bg%2)==1)?'#FFEAFF':'#DDFFF9'?>">



            <td><?=++$ss;?></td>



            <td><?=$row->lot_no?></td>

              <td><?=$row->garden_name?></td>

              <td><?=$row->invoice_no?></td>

              <td><?=$row->item_name?>

			  

			



                <input type="hidden" name="rate_<?=$row->id?>" id="rate_<?=$row->id?>" value="<?=$row->rate?>" />

                <input type="hidden" name="item_id_<?=$row->id?>" id="item_id_<?=$row->id?>" value="<?=$row->item_id?>" />

				
			</td>



              <td><?=$row->warehouse_nickname?></td>

              <td><?=$row->quality?></td>

              <td width="7%" align="center"><?=$row->pkgs?></td>

              <td width="7%" align="center"><?=$row->unit_name?>



                <input type="hidden" name="unit_name_<?=$row->id?>" id="unit_name_<?=$row->id?>" value="<?=$row->unit_name?>" /></td>



              <td width="8%" align="center"><?=$row->qty?></td>



              <td width="7%" align="center"><? echo $rec_qty = (find_a_field('purchase_receive','sum(qty)','order_no="'.$row->id.'" and item_id="'.$row->item_id.'"')*(1));?></td>



              <td width="8%" align="center"><? echo $unrec_qty=($row->qty-$rec_qty);?>



                <input type="hidden" name="unrec_qty_<?=$row->id?>" id="unrec_qty_<?=$row->id?>" value="<?=$unrec_qty?>" /></td>



              <td width="10%" align="center" bgcolor="#6699FF" style="text-align:center">



			  <? if($unrec_qty>0){$cow++;?>



                <input name="chalan_<?=$row->id?>" type="text" id="chalan_<?=$row->id?>" style="width:70px; float:none" value=""  />



                <? } else echo 'Done';?></td>

              </tr>



          <? }?>

      </tbody>

      </table>



      </div>



      </td>



    </tr>



  </table><br />



<table width="100%" border="0">



<? if($cow<1){



$vars['status']='COMPLETED';



db_update($table_master, $po_no, $vars, 'po_no');



?>



<tr>



<td colspan="2" align="center" bgcolor="#FF3333"><strong>THIS PURCHASE ORDER IS COMPLETE</strong></td>



</tr>



<? }else{?>



<tr>



<td align="center"><input name="delete" type="button" class="btn1" value="CANCEL PURCHASE ORDER" style="width:270px; font-weight:bold; font-size:12px;color:#F00; height:30px" onclick="window.location = 'select_dealer_chalan.php?del=1&po_no=<?=$po_no?>';" />



<input  name="vendor_id" type="hidden" id="vendor_id" value="<?=$vendor_id;?>"/></td>



<td align="center"><input name="confirm" type="submit" class="btn1" value="RECEIVE" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:#090" /></td>



</tr>



<? }?>



</table>



<? }?>



</form>



</div>



<script>$("#codz").validate();$("#cloud").validate();</script>



<?



$main_content=ob_get_contents();



ob_end_clean();



require_once SERVER_CORE."routing/layout.bottom.php";



?>