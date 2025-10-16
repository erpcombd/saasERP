<?php

//

//


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



create_combobox('delivery_place');

$title='FOC Delivery Challan Create';



do_calander('#so_date');

do_calander('#chalan_date');


$table_master='sale_foc_master';

$table_details='sale_foc_details';

 $unique='foc_no';


$foc_no=$_REQUEST['foc_no'];



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

		$_POST['edit_at']=date('Y-m-d h:i:s');

		$_POST['status']='PROCESSING';

		$crud   = new crud($table_master);

		$crud->update($unique);

		unset($$unique);

		unset($_SESSION[$unique]);

		$type=1;

		$msg='Successfully Completed All Purchase Order.';
		
		echo '<script>window.location.replace("select_unfinished_do.php")</script>';

}



if(isset($_POST['delete']))

{

		unset($_POST);

		$_POST[$unique]=$$unique;

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d H:i:s');

		$_POST['status']='CHECKED';

		$crud   = new crud($table_master);

		$crud->update($unique);



		unset($$unique);

		unset($_SESSION[$unique]);

		$type=1;

		$msg='Order Returned.';

}



if(prevent_multi_submit()){



if(isset($_POST['confirm'])){


		$ch_date=$_POST['chalan_date'];
		
		$prepared_by=$_POST['prepared_by'];
		$authorized_by=$_POST['authorized_by'];
		
		$vehicle_no=$_POST['vehicle_no'];
		$driver_name=$_POST['driver_name'];
		$driver_mobile=$_POST['driver_mobile'];

		$remarks=$_POST['remarks'];
		$delivery_man=$_POST['delivery_man'];
		$delivery_man_mobile=$_POST['delivery_man_mobile'];
		
		$delivery_place=$_POST['delivery_place'];
		$dealer_group=$_POST['dealer_group'];




		$entry_by= $_SESSION['user']['id'];
		$entry_at = date('Y-m-d H:i:s');
		
		
		$YR = date('Y',strtotime($ch_date));
  		$yer = date('y',strtotime($ch_date));
  		$month = date('m',strtotime($ch_date));

  		$ch_cy_id = find_a_field('sale_do_chalan','max(ch_id)','year="'.$YR.'"')+1;
   		$cy_id = sprintf("%07d", $ch_cy_id);
   		$chalan_no=''.$yer.''.$month.''.$cy_id;


		
		//$chalan_no = next_transection_no($group_for,$ch_date,'sale_do_chalan','chalan_no');

		//$gate_pass = next_transection_no('0',$ch_date,'sale_do_chalan','gate_pass');

		
		$ms_data = find_all_field('sale_do_master','','do_no='.$do_no);

		 $sql = 'select d.*, i.unit_name from sale_do_details d, item_info i where  d.item_id=i.item_id and d.do_no = '.$do_no;

		$query = db_query($sql);

		//$pr_no = next_pr_no($warehouse_id,$rec_date);
		
		

		while($data=mysqli_fetch_object($query))

		{
			if($_POST['chalan_'.$data->id]>0 && $_POST['chalan_ctn_'.$data->id]>0)

			{
			
				$qty=$_POST['chalan_'.$data->id];
				$qty_ctn=$_POST['chalan_ctn_'.$data->id];
				$rate=$_POST['rate_'.$data->id];
				$item_id =$_POST['item_id_'.$data->id];
				$amount = ($qty*$rate); 

 
  $so_invoice = 'INSERT INTO sale_do_chalan (year, ch_id, chalan_no, gate_pass, chalan_date, order_no, item_name, do_no, do_date, job_no, delivery_date, group_for, dealer_code, buyer_code, merchandizer_code, customer_po_no, unit_name, item_id, unit_price, total_ctn, total_unit, total_amt, style_no, po_no, referance, color, shade, pack_type, size, sst, count_id, count, length, length_unit, depot_id, status, entry_by, entry_at, remarks, vehicle_no, driver_name, driver_mobile, delivery_man, delivery_man_mobile, prepared_by, authorized_by, delivery_place, dealer_group)
  
  VALUES("'.$YR.'", "'.$ch_cy_id.'", "'.$chalan_no.'", "'.$chalan_no.'", "'.$ch_date.'", "'.$data->id.'", "Sewing Thread", "'.$do_no.'", "'.$data->do_date.'", "'.$data->job_no.'", "'.$data->delivery_date.'", "'.$ms_data->group_for.'", "'.$ms_data->dealer_code.'", "'.$ms_data->buyer_code.'", "'.$ms_data->merchandizer_code.'", "'.$ms_data->customer_po_no.'", "'.$data->unit_name.'", "'.$item_id.'", "'.$rate.'", "'.$qty_ctn.'", "'.$qty.'", "'.$amount.'", "'.$data->style_no.'", "'.$data->po_no.'", "'.$data->referance.'", "'.$data->color.'", "'.$data->shade.'", "'.$data->pack_type.'", "'.$data->size.'", "'.$data->sst.'", "'.$data->count_id.'", "'.$data->count.'", "'.$data->length.'", "'.$data->length_unit.'", "'.$ms_data->depot_id.'", "UNCHECKED", "'.$entry_by.'", "'.$entry_at.'", "'.$remarks.'", "'.$vehicle_no.'", "'.$driver_name.'", "'.$driver_mobile.'", "'.$delivery_man.'", "'.$delivery_man_mobile.'", "'.$prepared_by.'", "'.$authorized_by.'", "'.$delivery_place.'", "'.$dealer_group.'")';

db_query($so_invoice);



	//journal_item_control($item_id, $ms_data->depot_id, $ch_date,  0, $qty, 'Sales', $data->id, $rate, '', $chalan_no, '', '',$ms_data->group_for, $rate->unit_price, '' );



}

}


//if($chalan_no>0)
//{
//auto_insert_sales_chalan_secoundary($chalan_no);
//
//}

	

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

//if($delivery_within>0)
//{
//	$ex = strtotime($po_date) + (($delivery_within)*24*60*60)+(12*60*60);
//}



?>


<script>




function calculation(id){

var chalan=((document.getElementById('chalan_'+id).value)*1);

var pending_qty=((document.getElementById('unso_qty_'+id).value)*1);




 if(chalan>pending_qty)
  {
alert('Can not issue more than pending quantity.');

document.getElementById('chalan_'+id).value='';

  } 


}

</script>


<style type="text/css">

<!--

.style1 {color: #FF0000}
.style2 {
	font-weight: bold;
	color: #000000;
	font-size: 14px;
}
.style3 {color: #FFFFFF}

-->





/*.ui-state-default a, .ui-state-default a:link, .ui-state-default a:visited, a.ui-button, a:link.ui-button, a:visited.ui-button, .ui-button {
    color: #454545;
    text-decoration: none;
    display: none;
}*/


div.form-container_large input {
    width: 150px;
    height: 38px;
    border-radius: 0px !important;
}


</style>



<div class="form-container_large">

<form action="" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">

<table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">

  <tr>

    <td width="40%" valign="top"><fieldset style="width:100%;">

    <? $field='do_no';?>

      <div>

        <label style="width:140px;" for="<?=$field?>">SO  No: </label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" style="width:200px;" readonly="" />

      </div>

    <? $field='do_date';?>

      <div>

        <label style="width:140px;" for="<?=$field?>">SO Date:</label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required style="width:200px;" readonly="" />

      </div>
	  
	  
	  
	 
	  
	   <? $field='job_no';?>

      <div>

        <label style="width:140px;" for="<?=$field?>">Job No:</label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" style="width:200px;" readonly=""  />

      </div>
	  
	  
	 <? $field='wo_no';?>

      <div>

        <label style="width:140px;" for="<?=$field?>">WO No:</label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" style="width:200px;" readonly="" />

      </div>
	  
	 

    
<div>

        <label style="width:140px;" for="<?=$field?>"> Marketing Person:</label>

     <input  name="marketing_person2" type="text" id="marketing_person2" value="<?=find_a_field('marketing_person','marketing_person_name','person_code='.$marketing_person);?>" required="required" readonly=""  style="width:200px;"/>

	<input  name="marketing_person" type="hidden" id="marketing_person" value="<?=$marketing_person?>" required="required" style="width:200px;"/>

      </div>
  
	  
	  
	   


     

    </fieldset></td>

    <td width="9%">			</td>

    <td width="40%"><fieldset style="width:100%;">
	
	
	
	<? $field='group_for'; $table='user_group';$get_field='id';$show_field='group_name';?>

      <div>

        <label style="width:120px;" for="<?=$field?>">Company:</label>

        <input  name="group_for2" type="text" id="group_for2" value="<?=find_a_field($table,$show_field,$get_field.'='.$$field)?>" required="required" readonly=""  style="width:200px;" />

		<input  name="group_for" type="hidden" id="group_for" value="<?=$group_for?>" required="required"/>

      </div>
	  
	  <div>

        <label style="width:120px;" for="<?=$field?>"> Customer Group:</label>

        <input  name="dealer_group2" type="text" id="dealer_group2" value="<?=find_a_field('dealer_group','dealer_group','id='.$dealer_group);?>" required="required"  readonly="" style="width:200px;"/>

		<input  name="dealer_group" type="hidden" id="dealer_group" value="<?=$dealer_group?>" required="required" style="width:200px;"/>

      </div>
	  
	  
	  <div>

        <label style="width:120px;" for="<?=$field?>"> Customer:</label>

        <input  name="dealer_code2" type="text" id="dealer_code2" value="<?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$dealer_code);?>" required="required" readonly=""  style="width:200px;"/>

		<input  name="dealer_code" type="hidden" id="dealer_code" value="<?=$dealer_code?>" required="required" style="width:200px;"/>

      </div>
	  
	  
	  
	  <div>

        <label style="width:120px;" for="<?=$field?>"> Merchandiser:</label>

     <input  name="merchandizer_code2" type="text" id="merchandizer_code2" value="<?=find_a_field('merchandizer_info','merchandizer_name','merchandizer_code='.$merchandizer_code);?>"  readonly=""  required="required" style="width:200px;"/>

		<input  name="merchandizer_code" type="hidden" id="merchandizer_code" value="<?=$merchandizer_code?>" required="required" style="width:200px;"/>

      </div>
	  
	  
	  <div>

        <label style="width:120px;" for="<?=$field?>"> Buyer:</label>

     <input  name="merchandizer_code2" type="text" id="merchandizer_code2" value="<?=find_a_field('buyer_info','buyer_name','buyer_code='.$buyer_code);?>" required="required" readonly=""  style="width:200px;"/>

	<input  name="buyer_code" type="hidden" id="buyer_code" value="<?=$buyer_code?>" required="required" style="width:200px;"/>

      </div>
	
	
	
	


      

      <div></div>
 

      

              

      <div>


      

      </div>

		</fieldset></td>

    <td width="2%">&nbsp;</td>

  <td width="20%" valign="top"><table width="100%" border="1" cellspacing="0" cellpadding="0" style="font-size:12px; font-weight:700;">

	          

        <tr>

          <td align="left" bgcolor="#9999CC"><strong>Date</strong></td>

          <td align="left" bgcolor="#9999CC"><strong>Challan No </strong></td>

        </tr>

<?
 
$sql='select distinct chalan_no, chalan_date from sale_foc_chalan where foc_no='.$foc_no.' order by id desc';

$qqq=db_query($sql);

while($aaa=mysqli_fetch_object($qqq)){

?>

        <tr>

          <td bgcolor="#FFFF99" style="font-size:12px; font-weight:700; color:#000000" ><?php echo date('d-m-Y',strtotime($aaa->chalan_date));?></td>

          <td align="center" bgcolor="#FFFF99"><a target="_blank" style="font-size:12px; font-weight:700; color:#000000" href="../wo/delivery_challan_print_view.php?v_no=<?=$aaa->chalan_no?>"><?=$aaa->chalan_no?></a></td>

        </tr>

<?

}

?>



      </table></td>

  </tr>

  <tr>

    <td colspan="5" valign="top"><table width="40%" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">

      <tr>

        <td colspan="4" align="center" bgcolor="#CCFF99"><strong> Entry Information</strong></td>
      </tr>

      <tr>

        <td align="right" bgcolor="#CCFF99">Created By:</td>

        <td align="left" bgcolor="#CCFF99">&nbsp;&nbsp;

            <?=find_a_field('user_activity_management','fname','user_id='.$entry_by);?></td>

        

        <td rowspan="2" align="left" bgcolor="#CCFF99"><a title="WO Preview" target="_blank" href="../../../sales_mod/pages/wo/sales_order_print_view.php?v_no=<?=$$unique?>" ><img src="../../../images/print.png" alt="" width="30" height="30" /></a></td>
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

	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
	
	
	
	

      <tr>
        <td colspan="5"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td align="right" bgcolor="#9966FF"><strong>Chalan Date:
			  <? $ch_data = find_all_field('sale_do_chalan','','chalan_no='.$_SESSION['chalan_no']);?>
			  </strong></td>
              <td align="left" bgcolor="#9966FF"><strong>
                <input style="width:140px;"  name="chalan_date" type="text" id="chalan_date" required="required" value="<?=($ch_data->chalan_date!='')?$ch_data->chalan_date:date('Y-m-d')?>"/>
              </strong></td>
              <td align="right" bgcolor="#9966FF"><strong>Prepared By:</strong></td>
              <td align="left" bgcolor="#9966FF"><strong>
                <select name="prepared_by" required id="prepared_by"  tabindex="7" style="width:140px;">
					
                      <? foreign_relation('prepared_by','id','prepared_by',$prepared_by,'status="Active"');?>
                    </select>
              </strong></td>
              <td bgcolor="#9966FF" align="right"><strong>Authorized By:</strong></td>
              <td bgcolor="#9966FF"><strong>
                <select name="authorized_by" required id="authorized_by"  tabindex="7" style="width:140px;">
					
                      <? foreign_relation('authorized_by','id','authorized_by',$authorized_by,'status="Active"');?>
                    </select>
              </strong></td>
            </tr>
            <tr>
              <td align="right" bgcolor="#9999FF"><strong>Vehicale No:</strong></td>
              <td bgcolor="#9999FF"><strong>
                <input style="width:140px;"  name="vehicle_no" type="text" id="vehicle_no" value="<?=$ch_data->vehicle_no;?>" />
                </strong></td>
              <td align="right" bgcolor="#9999FF"><strong>Driver Name: </strong></td>
              <td bgcolor="#9999FF"><strong>
                <input style="width:140px;"  name="driver_name" type="text" id="driver_name" value="<?=$ch_data->driver_name;?>"  />
                </strong></td>
              <td align="right" bgcolor="#9999FF"><strong>Driver Mobile:</strong> </td>
              <td bgcolor="#9999FF"><strong>
                <input style="width:140px;"  name="driver_mobile"  type="text" id="driver_mobile" value="<?=$ch_data->driver_mobile;?>" />
              </strong></td>
            <td>&nbsp;</td>
            </tr>
			 <tr>
              <td align="right" bgcolor="#9999FF"><strong>Delivery Place:</strong></td>
              <td bgcolor="#9999FF"><strong>
               
				<select name="delivery_place" required id="delivery_place"  tabindex="7" style="width:140px;">
				<option></option>
					
                      <? foreign_relation('dealer_info','dealer_code','dealer_name_e',$dealer_code,'dealer_group="'.$dealer_group.'"');?>
                    </select>
				
                </strong></td>
              <td align="right" bgcolor="#9999FF"><strong>Delivery Man: </strong></td>
              <td bgcolor="#9999FF"><strong>
                <input style="width:140px;"  name="delivery_man" type="text" id="delivery_man" value="<?=$ch_data->delivery_man;?>"  />
                </strong></td>
             
             <td align="right" bgcolor="#9999FF"><strong>Delivery Man Mobile: </strong></td>
              <td bgcolor="#9999FF"><strong>
                <input style="width:140px;"  name="delivery_man_mobile" type="text" id="delivery_man_mobile" value="<?=$ch_data->delivery_man_mobile;?>"  />
                </strong></td>
            </tr>
           
          </table></td>
      </tr>
    </table></td>

    </tr>

</table>

<? if($$unique>0){

   $sql='select a.id,  a.item_id,  a.unit_price, a.color, a.referance, a.po_no, a.style_no, a.count_id, a.count, a.length, a.length_unit,  b.item_name,  b.unit_name,  a.total_unit as qty 
 from sale_foc_details a,item_info b, item_sub_group s where b.item_id=a.item_id 
  and b.sub_group_id=s.sub_group_id and  a.foc_no='.$foc_no;

$res=db_query($sql);

?>


<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">

    <tr>

      <td><div class="tabledesign2">

      <table width="100%" align="center" cellpadding="0" cellspacing="0" id="grp" style="font-size:12px">

      <tbody>

          <tr>

            <th width="1%">SL</th>

            <th width="7%">Color</th>

            <th width="11%">Referance No</th>
            <th width="7%">Shade</th>
            <th width="6%">PO No</th>
            <th width="7%">Style No</th>
            <th width="7%">Count</th>
            <th width="10%">Lenght</th>
            <th bgcolor="#FF99FF">WO Qty </th>

            <th bgcolor="#009900">Delivered</th>

            <th bgcolor="#FFFF00">Pending </th>

            <th bgcolor="#F57E22">Challan Qty </th>
            <th bgcolor="#F57E22">CTN</th>
          </tr>
          
          

          

          <? while($row=mysqli_fetch_object($res)){$bg++?>

          <tr bgcolor="<?=(($bg%2)==1)?'#FFEAFF':'#DDFFF9'?>">

            <td><?=++$ss;?></td>

            <td>
			
			<input type="hidden" name="item_id_<?=$row->id?>" id="item_id_<?=$row->id?>" value="<?=$row->item_id?>" />	
			<input type="hidden" name="rate_<?=$row->id?>" id="rate_<?=$row->id?>" value="<?=$row->unit_price?>" />	
			<?=$row->color?>			</td>

              <td><?=$row->referance?></td>
              <td><?=$row->shade?></td>
              <td><?=$row->po_no?></td>
              <td><?=$row->style_no?></td>
              <td>
			  <?=$row->count;?></td>
              <td><?=$row->length?> <?=$row->length_unit?> </td>
              <td width="9%" ><?=$row->qty;?> <?=$row->unit_name?></td>

              <td width="9%" align="center"><? echo number_format($so_qty = (find_a_field('sale_foc_chalan','sum(total_unit)','order_no="'.$row->id.'" and item_id="'.$row->item_id.'"')*(1)),2);?></td>

              <td width="9%" align="center"><? 

			  
			  echo number_format($unso_qty=($row->qty-$so_qty),2);?>

                <input type="hidden" name="unso_qty_<?=$row->id?>" id="unso_qty_<?=$row->id?>" value="<?=$unso_qty?>"  onKeyUp="calculation(<?=$row->id?>)" /></td>

              <td width="9%" align="center" bgcolor="#F57E22">
			   <? if($unso_qty>0){$cow++;?>

          <input name="chalan_<?=$row->id?>" type="text" id="chalan_<?=$row->id?>" value=""  style="width:80px; height:25px; float:none"  onKeyUp="calculation(<?=$row->id?>)" />
	

                <? } else echo 'Done';?>			  </td>
              <td width="8%" align="center" bgcolor="#F57E22">
			  
			  <? if($unso_qty>0){$cow++;?>

          <input name="chalan_ctn_<?=$row->id?>" type="text" id="chalan_ctn_<?=$row->id?>" value=""  style="width:80px; height:25px; float:none"  onKeyUp="calculation(<?=$row->id?>)" />
	

                <? } else echo 'Done';?>	
			  
			  </td>
          </tr>

          <? }?>
      </tbody>
      </table>

      </div>

      </td>

    </tr>

  </table><br /> <br />
  

  
  
  
  
	
	<br />
  

<table width="100%" border="0">

<? if($cow<1){

$vars['status']='COMPLETED';

db_update($table_master, $do_no, $vars, 'do_no');

?>

<tr>

<td colspan="2" align="center" bgcolor="#FF3333"><strong>THIS  SALES ORDER IS COMPLETE</strong></td>

</tr>

<? }else{?>

<tr>

<td align="center"><input name="delete" type="submit" class="btn1" value="CANCEL WO" style="width:270px; font-weight:bold; font-size:12px;color:#F00; height:30px" />

<input  name="do_no" type="hidden" id="do_no" value="<?=$do_no;?>"/></td>

<td align="center"><input name="confirm" type="submit" class="btn1" value="CONFIRM CHALLAN" style="width:270px; font-weight:bold; float:right; font-size:12px; height:30px; color:#090" /></td>

</tr>

<? }?>

</table>

<? }?>

</form>

</div>

<script>$("#codz").validate();$("#cloud").validate();</script>

<?

//

//

require_once SERVER_CORE."routing/layout.bottom.php";


?>