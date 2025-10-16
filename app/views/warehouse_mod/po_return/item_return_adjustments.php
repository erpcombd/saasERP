<?php
//ini_set('display_errors',1); ini_set('display_startup_errors',1); error_reporting(E_ALL);

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Purchase Return Entry';

do_calander('#return_date','-15','+0');
$tr_type="Show";

if (isset($_REQUEST['po_no']) && !empty($_REQUEST['po_no'])) {
    $input = $_REQUEST['po_no'];
    $parts = explode('##', $input);

    $po_no = $parts[0];
} else {
    $po_no = isset($_POST['po_no']) ? $_POST['po_no'] : null;

}




$table_master='purchase_master';
$unique_master='po_no';

$table_detail='purchase_invoice';
$unique_detail='id';

$table_chalan='purchase_receive';
$unique_chalan='id';

$final_stock = find_a_field('journal_item','sum(total_in-total_ex)','item_id="'.$row->item_id.'"');

$p_no=find_a_field('purchase_receive','po_no','pr_no="'.$$unique_master.'"');
$master = find_all_field('purchase_master','','po_no='.$p_no);



if(prevent_multi_submit()){

if(isset($_POST['confirm'])){

		
		$return_date=$_POST['return_date'];
		$return_note=$_POST['return_note'];
		$chalan_no=$_POST['chalan_no'];
		$entry_at = date('Y-m-d H:i:s');
		$entry_by =$_SESSION['user']['id'];		
		$group=	$_SESSION['user']['group'];
	    //$return_no = next_transection_no($warehouse_id,$return_date,'','');
		
		
		$status = 'CHECKED';
		$master = find_all_field('purchase_master','','po_no='.$p_no);
		$warehouse_id = $master->warehouse_id;
		
	$pr_m="INSERT INTO `purchase_return_master`(`invoice_no`, `pr_date`, `group_for`, `return_type`, `vat`, `tax`, vat_include, tax_include, rebate,`rebate_percentage`,`deductible`, `vat_amt`, `vendor_id`, `delivery_address`, `remarks`, `status`,`chalan_no`, `depot_id`, `entry_at`, `entry_by`, `checked_at`, `checked_by`, `entry_time`) VALUES
 ('".$$unique_master."','".$return_date."','".$group."',1,'".$master->vat."','".$master->tax."','".$master->vat_include."','".$master->tax_include."','".$master->rebate."','".$master->rebate_percentage."','".$master->deductible."',0,'".$master->vendor_id."','','".$_POST['return_note']."','CHECKED','".$_POST['chalan_no']."','".$master->warehouse_id."','".$entry_at."','".$entry_by."','','','')";
 
 db_query($pr_m);
 $m_id = db_insert_id();	
		
		
	    $sql = 'select b.* from  purchase_receive b where pr_no = '.$po_no.' ';
		$query=db_query($sql);
		while($data=mysqli_fetch_object($query)){
		
		if($_POST['goods_'.$data->id]>0){
		
		$unit_price=$_POST['rate_'.$data->id];
		$with_vat_rate=$data->with_vat_rate;
		$goods_qty=$_POST['goods_'.$data->id];
		$goods_amt= $unit_price*$goods_qty;
		$total_amt_with_vat=($data->with_vat_rate*$goods_qty);

		$vat_rate = $data->vat_amt/$data->qty;
		$vat_amt = $vat_rate*$goods_qty;
		
		$tax_rate = $data->tax_amt/$data->qty;
		$tax_amt = ($tax_rate*$goods_qty);
		
		$payable_rate = $data->payable_amt/$data->qty;
		$payable_amt = ($payable_rate*$goods_qty);
		
		//INSERT INTO `purchase_return_details` (`id`, `pr_no`, `order_no`, `group_for`, `ref_no`, `item_id`, `item_color`, `vendor_id`, `crt_price`, `unit_price`, `with_vat_rate`, `pkt_size`, `pkt_unit`, `dist_unit`, `total_unit`, `total_amt`, `discount`, `amt_after_discount`, `vat_amt`, `total_amt_with_vat`, `dist_amt`, `commission`, `depot_id`, `t_price`, `status`, `gift_on_order`, `gift_on_item`, `gift_id`, `do_date`, `entry_time`, `dp_price`, `fp_price`, `entry_by`, `entry_at`, `remarks`);	
		
  $sr_d = "INSERT INTO  purchase_return_details (  `pr_no`, `order_no`, `vendor_id`, `item_id`,   `unit_price`,with_vat_rate, `total_unit`, `total_amt`,`vat_amt`,`tax_amt`, `total_amt_with_vat`,`payable_amt`, `status`, `entry_by`, `entry_at`)
 VALUES 
('".$m_id."',   '".$$unique_master."', '".$data->vendor_id."', '".$data->item_id."', '".$unit_price."','".$with_vat_rate."', '".$goods_qty."', '".$goods_amt."','".$vat_amt."','".$tax_amt."', '".$total_amt_with_vat."','".$payable_amt."',  'CHECKED',  '".$entry_by."', '".$entry_at."')";
	db_query($sr_d);
	
		$ch_id = db_insert_id();
		journal_item_control($data->item_id,$master->warehouse_id,$return_date,0,$goods_qty,'Purchase Return',$ch_id, $with_vat_rate,'',$m_id);
		
	}	
		}
		auto_insert_purchase_return_secoundary_toriqul($m_id);
		$tr_type="Complete";
}
else
{
	$type=0;
	$msg='Data Re-Submit Warning!';
}
}

if($po_no>0)
{
		$condition="po_no=".$po_no;
		$data=db_fetch_object($table_chalan,$condition);
		foreach ($data as $key => $value)
		{ $$key=$value;}
		
}

$dealer = find_all_field('dealer_info','','dealer_code='.$dealer_code);
auto_complete_from_db('item_info','item_name','concat(item_name,"#>",finish_goods_code)','product_nature="Salable"','item');
$tr_from="Warehouse";
?>



<script language="javascript">

function calculation(id){



var goods=((document.getElementById('goods_'+id).value)*1);


var stk_qty=((document.getElementById('stk_qty_'+id).value)*1);
var grn_qty=((document.getElementById('grn_remain_'+id).value)*1);

if(goods>stk_qty || goods<=0 || grn_qty<goods )
 {

alert('Can not issue more than Stock quantity');

document.getElementById('goods_'+id).value='';


  }

}



</script>




<div class="form-container_large">
    <form action="" method="post" name="codz" id="codz">
      <div class="container-fluid bg-form-titel">
        <div class="row">
          <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
            <div class="container n-form2">


              <div class="form-group row m-0 pb-1">
                <label for="req_note" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">GRN NO :</label>
                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
          <input   name="do_no2" type="text" id="do_no2" value="<? if($$unique_master>0) echo $$unique_master; else echo (find_a_field($table_master,'max('.$unique_master.')','1')+1);?>" readonly="readonly"/>
          <input type="hidden" name="po_no" id="po_no" value="<?=$po_no?>" />
		   <input type="hidden" name="vendor_id" id="vendor_id" value="<?=$master->vendor_id?>" />
		   

                </div>
              </div>


              <div class="form-group row m-0 pb-1">
                <label for="req_note" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">PO Date :</label>
                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
					<input  name="po_date" type="text" id="po_date" value="<?=$master->po_date;?>" readonly="readonly"/>

                </div>
              </div>


              <div class="form-group row m-0 pb-1">
                <label for="req_note" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Vendor :</label>
                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                  <input name="wo_detail2" type="text" id="wo_detail2" value="<?=find_a_field('vendor','vendor_name','vendor_id='.$master->vendor_id);?>" readonly="readonly"/>
                </div>
              </div>
			  
              <div class="form-group row m-0 pb-1">
                <label for="req_note" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">VAT (%) :</label>
                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                    <input name="vat" type="text" id="vat" value="<?=$master->vat;?>" readonly="readonly"/>

                </div>
              </div>
			  
			  <div class="form-group row m-0 pb-1">
                <label for="req_note" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">TAX (%) :</label>
                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                    <input name="tax" type="text" id="tax" value="<?=$master->tax;?>" readonly="readonly"/>

                </div>
              </div>
			  

			  
              <div class="form-group row m-0 pb-1">
                <label for="req_note" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Return Date :</label>
                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                 <input  name="return_date" type="text" id="return_date" required="required" value="<?=date('Y-m-d')?>"/>

                </div>
              </div>



            </div>



          </div>


          <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
            <div class="container n-form2">

              <div class="form-group row m-0 pb-1">
                <label for="req_note" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Chalan NO :</label>
                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                  <input name="chalan_no" type="text" id="chalan_no"/>

                </div>
              </div>


          <div class="form-group row m-0 pb-1">
                <label for="req_note" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">PO NO :</label>
                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                  <input name="po_num" type="text" id="po_num" value="<?=find_a_field('purchase_receive','po_no','pr_no="'.$$unique_master.'"');?>" readonly=""/>

                </div>
              </div>



              <div class="form-group row m-0 pb-1">
                <label for="req_note" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Invoice Date :</label>
                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                    <input name="invoice_date" type="text" id="invoice_date" value="<?=$master->quotation_date?>" tabindex="10" readonly="readonly" />

                </div>
              </div>


              <div class="form-group row m-0 pb-1">
                <label for="req_note" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">PO Type :</label>
                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                  		<input name="po_type2" type="text" id="po_type2" value="<?=find_a_field('purchase_type','po_type','id='.$master->purchase_type)?>"  readonly=""/>

                </div>
              </div>
			  
			  
			  <div class="form-group row m-0 pb-1">
                <label for="req_note" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">REBATE(%) :</label>
                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                  	 <input name="rebate_percentage" type="text" id="rebate_percentage" value="<?=$master->rebate_percentage;?>" readonly="readonly"/>

                </div>
              </div>
			  
			  
         <?php /*?>     <div class="form-group row m-0 pb-1">
                <label for="req_note" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Payment Type :</label>
                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                 		          
<input name="invoice_no" type="text" id="invoice_no" value="<?=find_a_field('payment_type','payment_type','id='.$master->payment_type)?>" />
                </div>
              </div>
			  <?php */?>
			  		  
			  
              <div class="form-group row m-0 pb-1">
                <label for="req_note" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Reasons :</label>
                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                 <input name="return_note" type="text" id="return_note" required="required"/>

                </div>
              </div>




            </div>






          </div>
		  <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
		          <table class="table1  table-striped table-bordered table-hover table-sm">
					  <thead class="thead1">
						  <tr class="bgc-info">
							<th width="90%">Return Note</th>
							<th>DC</th>
						  </tr>
					  </thead>
			
					  <tbody class="tbody1">
				<?
 $sql='select distinct pr_no, pr_date from purchase_return_master where invoice_no='.$po_no.' order by pr_no desc';
$qqq=db_query($sql);
if($qqq)
while($aaa=mysqli_fetch_object($qqq)){
?>
        <tr>
          <td style=" background-color:#FF00FF"><?=$aaa->pr_date?></td>
          <td align="center" ><a target="_blank" href="purchase_invoice_print_view.php?v_no=<?=$aaa->pr_no?>"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-printer" viewBox="0 0 16 16">
  <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1"/>
  <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1"/>
</svg></a></td>
        </tr>
<?
}
?>

										
					  </tbody>
				</table>
		
		  
		  </div>

        </div>

        
      </div>

	
	
	
      <!--return Table design start-->
      <div class="container-fluid pt-5 p-0">
		 
	  

  <? if($$unique_master>0){?>

<? 


  $sql = "select po_no, order_no,  sum(qty) as goods from purchase_receive where po_no='".$po_no."' group by order_no ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $goods[$info->order_no]=$info->goods;
		 $damage[$info->order_no]=$info->damage;		 
		 $short[$info->order_no]=$info->short;

  		 
		}


// $sql='select a.id, c.pr_no, a.item_id, b.sku_code, b.item_name, a.qty, a.rate, a.amount from purchase_invoice a,item_info b, purchase_receive c where c.po_no=a.po_no and b.item_id=a.item_id and c.pr_no='.$po_no;

$ret='select order_no,sum(total_unit) as rQty,item_id from purchase_return_details where order_no="'.$$unique_master.'"';

 $stk_qty='sum(total_in-total_ex) as stk_qty from journal_item where order_no="'.$data->item_id.'"';
 
 $sql='select r.*,i.item_name,i.item_id from purchase_receive r,item_info i where r.item_id=i.item_id and r.pr_no='.$po_no;
 $res=db_query($sql);
?>

      <table id="grp" class="table1  table-striped table-bordered table-hover table-sm">
	  				<thead class="thead1">
					  	<tr class="bgc-info">
							<th>SL</th>
							<th>Item Name</th>
							<th>Invoice Qty</th>
							<th>Stock Qty</th>
							<th>Return Qty</th>
							<th>Return Qty</th>
						</tr>
					</thead>
      <tbody class="tbody1">
          <? while($row=mysqli_fetch_object($res)){$bg++?>
          <tr bgcolor="<?=(($bg%2)==1)?'#FFEAFF':'#DDFFF9'?>">
            <td><?=++$ss;?></td>
              <td><?=$row->item_name?></td>
              <td><?=number_format($row->qty,2); $tot_po_qty +=$row->qty;?>
			  
			  
			  
			  
			  <input type="hidden" name="rate_<?=$row->id?>" id="rate_<?=$row->id?>" value="<?=$row->rate;?>" />
			  </td>
			  <td><?=$final_stock = find_a_field('journal_item','sum(item_in-item_ex) as qty2','item_id="'.$row->item_id.'" and warehouse_id="'.$row->warehouse_id.'"');?>
			  <input type="hidden" name="stk_qty_<?=$row->id?>" id="stk_qty_<?=$row->id?>" value="<?=$final_stock?>" onKeyUp="calculation(<?=$row->id?>)"/>
			  </td>
			  
			  <td><?=$rqty=find_a_field('purchase_return_details','sum(total_unit) as amt','order_no="'.$$unique_master.'" and item_id="'.$row->item_id.'"') ?>
			  
			  
			  
			  <input type="hidden" name="grn_remain_<?=$row->id?>" id="grn_remain_<?=$row->id?>" value="<?=$row->qty - $rqty;?>" />
			  
			  </td>
       
              <td align="center" bgcolor="#6699FF" style="text-align:center">
			  
			  <?php if($row->qty <=$rqty){?>
			  Done
			  <? }else{?>
				<input name="goods_<?=$row->id?>" type="text" id="goods_<?=$row->id?>" value="<?=$goods[$row->id]?>"  onkeyup="calculation(<?=$row->id?>)"/>
			  <? }?>
  		  </td>

              </tr>
          <? $trqty+=$rqty; }?>
		    <tr>
            
            <td>&nbsp;</td>
			<td align="right"><strong>Total:</strong></td>
			<td>&nbsp;</td>
			<td><strong><?=number_format($tot_po_qty,2);?></strong></td>
			<td><?=$trqty?></td>
            <td><strong><?=number_format($tot_goods_item,2);?></strong></td>
            
          </tr>
      </tbody>
      </table>





<? 

if($cow<1)
$vars['return_status']='Purchase Return';
db_update($table_master, $po_no, $vars, 'po_no');
//db_update($table_detail, $do_no, $vars, 'do_no');
//db_update($table_master, $do_no, $vars, 'do_no');

$return_count = find_a_field('purchase_return_details','count(po_no)','po_no='.$po_no);


if($return_count==0){

?>
	  <div class="n-form-btn-class">
			<input  name="po_no" type="hidden" id="po_no" value="<?=$$unique_master?>"/>
			<input  name="dealer_code" type="hidden" id="dealer_code" value="<?=$dealer->dealer_code;?>"/>
			<input name="confirm" type="submit" class="btn1 btn1-bg-submit" value="COMPLETE ENTRY"/>

      </div>
	  

<? } else {?>
<tr>
<td align="center" bgcolor="#FF3333"><strong>THIS INVOICE HAS BEEN  ADJUSTED</strong></td>
</tr>
<? }?>


<? }?>
	    
	  

      </div>
</form>

	</div>



<?

require_once SERVER_CORE."routing/layout.bottom.php";
?>