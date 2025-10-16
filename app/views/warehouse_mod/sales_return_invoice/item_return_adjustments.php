<?php
 
 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Sales Return Create';

$tr_type="Show";

//do_calander('#chalan_date','-6','+0');

do_calander('#chalan_date');


if($_REQUEST['chalan_no']>0) 

$chalan_no = $_REQUEST['chalan_no'];

else

$chalan_no = $_POST['chalan_no'];

if($_REQUEST['company']>0) 

$group_for = $_REQUEST['company'];

else

$group_for = $_POST['company'];


$table_master='sale_do_master';

$unique_master='do_no';



$table_detail='sale_do_details';

$unique_detail='id';



$table_chalan='sale_do_chalan';

$unique_chalan='id';



$master = find_all_field('sale_do_master','','do_no='.$unique_master);



if(prevent_multi_submit()){



if(isset($_POST['confirm'])){
		

		$chalan_date=$_POST['chalan_date'];

		$return_note=$_POST['return_note'];
		$depot_id=$_POST['depot_id'];

		$entry_at = date('Y-m-d H:i:s');

		$entry_by =$_SESSION['user']['id'];			

		$return_no = next_return_no($_SESSION['user']['depot'],$chalan_date);

		$received_status = 'Sales Return';

		$do = find_all_field('sale_do_chalan','do_no','chalan_no='.$chalan_no);

		$do_no = $do->do_no;

		$do_chalan_date = $do->chalan_date;

		//$config_ledger = find_all_field('config_group_class','sales_ledger',"group_for=".$_SESSION['user']['group']);

		//$sales_ledger = find_a_field('config_group_class','sales_ledger',"group_for=".$_SESSION['user']['group']);

		$dealer= find_all_field('dealer_info','account_code',"dealer_code=".$_POST['dealer_code']);

		$dealer_ledger= $dealer->account_code;

		$master = find_all_field('sale_do_master','','do_no='.$do_no);
	

	$sr_m = "INSERT INTO  sale_return_master (`sr_date`, group_for,  do_no, chalan_no, `dealer_code`, `status`, `depot_id`, `vat`, sp_discount, `cash_discount`, `entry_at`, `entry_by`, `received_status`, `return_note`,do_type)

 VALUES 

('".$chalan_date."',  '".$do->group_for."',   '".$do->do_no."', '".$chalan_no."', '".$do->dealer_code."', 'CHECKED', 

'".$depot_id."', '".$master->vat."', '".$master->discount."',  '".$master->cash_discount."',  '".$entry_at."', '".$entry_by."',

 '".$received_status."', '".$return_note."',1)";

				db_query($sr_m);	

			$m_id = db_insert_id();		

		

		$sql = 'select * from sale_do_chalan where chalan_no = '.$chalan_no.' ';

		$query = db_query($sql);	

		while($data=mysqli_fetch_object($query))

		{

			if(($_POST['chalan_'.$data->id]>0)||($_POST['chalan2_'.$data->id]>0))

			{

				$chalan_pkt=$_POST['chalan_'.$data->id];

				$unit_qty=$_POST['chalan2_'.$data->id];

				//$unit_qty=(($data->pkt_size*$chalan_pkt)+$chalan_dist);
				$total_amt = ($unit_qty*$data->unit_price);
				$dealer_code = $_POST['dealer_code'];
				$c_amt=$unit_qty*$data->cost_price;
				

 $sr_d = "INSERT INTO  sale_return_details (`sr_no`, `sr_date`, `group_for`, `do_no`, `chalan_no`, `order_no`, `item_id`, `dealer_code`, `unit_price`, `pkt_size`,  `dist_unit`, `total_unit`, `total_amt`, `depot_id`, `status`, `entry_at`, `entry_by`, `received_status`,cost_amt)

 VALUES 

('".$m_id ."', '".$chalan_date."', '".$data->group_for."', '".$data->do_no."', '".$chalan_no."',  '".$data->id."', '".$data->item_id."', '".$data->dealer_code."',

 '".$data->unit_price."', '".$data->pkt_size."', '".$unit_qty."', '".$unit_qty."', '".$total_amt."', '".$depot_id."', 'CHECKED', 

  '".$entry_at."', '".$entry_by."', '".$received_status."','".$c_amt."')";

				db_query($sr_d);
				$ch_id = db_insert_id();
     journal_item_control($data->item_id,$depot_id,$_POST['chalan_date'],$unit_qty,0,'Sales Return',$ch_id, $data->cost_price,'',$m_id,'','',$data->group_for);
			}

		}

		

		

		if($ch_id>0)

		{

		//auto_insert_sales_return_secoundary_journal($return_no);

		//auto_insert_sales_return_secoundary($m_id);

		

		auto_insert_sales_return_secoundary_toriqul($m_id);

		

		



		}



	$tr_type="Complete";	

}

}

else

{

	$type=0;

	$msg='Data Re-Submit Warning!';

}

if($_REQUEST['chalan_no']>0) 

$chalan_no = $_REQUEST['chalan_no'];

else

$chalan_no = $_POST['chalan_no'];

if($chalan_no>0)

{

		$condition="chalan_no=".$chalan_no;

		$data=db_fetch_object($table_chalan,$condition);

		foreach ($data as $key => $value)

		{ $$key=$value;}

		

}



$dealer = find_all_field('dealer_info','','dealer_code='.$dealer_code);

auto_complete_from_db('item_info','item_name','concat(item_name,"#>",finish_goods_code)','product_nature="Salable"','item');
$tr_from="Warehouse";
?>

<script language="javascript">

function count()

{

var pkt_unit = ((document.getElementById('pkt_unit').value)*1);

var dist_unit = ((document.getElementById('dist_unit').value)*1);

var pkt_size = ((document.getElementById('pkt_size').value)*1);

var total_unit = (pkt_unit*pkt_size)+dist_unit;

var unit_price = ((document.getElementById('unit_price').value)*1);

var total_amt  = (total_unit*unit_price);

document.getElementById('total_unit').value=total_unit;

document.getElementById('total_amt').value	= total_amt .toFixed(2);

}

function cal2(id) {

  var pkt_unit = ((document.getElementById('chalan_'+id).value)*1);

  var undelpkt = ((document.getElementById('undelpkt_'+id).value)*1);

  var dist_unit = ((document.getElementById('chalan2_'+id).value)*1);

  var undeldist = ((document.getElementById('undeldist_'+id).value)*1);

  if(dist_unit>undeldist)

  {

	if(pkt_unit>(undelpkt-1))

	{

		alert('Can not Receive More than delivered Pcs.');

		document.getElementById('chalan2_'+id).value='';

		document.getElementById('chalan2_'+id).focus();

	}

  }

}

function cal(id) {

  var pkt_unit = ((document.getElementById('chalan_'+id).value)*1);

  var undelpkt = ((document.getElementById('undelpkt_'+id).value)*1);

  if(pkt_unit>undelpkt)

  {

alert('Can not Delivery More than Undelivered Pkt.');

document.getElementById('chalan_'+id).value='';

document.getElementById('chalan_'+id).focus();

  }

  Calc_totals();

}





function calculation(id){



var unreturn_qty=(document.getElementById('unreturn_qty_'+id).value)*1; 



var return_qty=(document.getElementById('chalan2_'+id).value)*1; 



var closing_qty=(document.getElementById('closing_qty_'+id).value=(unreturn_qty-return_qty));











   if(closing_qty<0)

  {

  

alert('Can not return more than invoice quantity.');

document.getElementById('chalan2_'+id).value='';





//document.getElementById('closing_'+id).value='$info->today_close';

document.getElementById('chalan2_'+id).focus();

//document.getElementById('closing_'+id).value=(opening+issue);

  } 







}







var active_ids = new Array();

function Calc_totals() {

    var answerValues = 0; 

	var answerValue = 0;

    for(i=0; i < active_ids.length; i++) 

    { 

        answerValue = Number(document.getElementById(active_ids[i]).value);

		answerValues += Number(answerValue);

    } 



	document.getElementById('crtdiv').innerHTML = '<span>'+answerValues+'</span>';

}

</script>






  <div class="form-container_large">
    <form action="" method="post" name="codz" id="codz">
      <div class="container-fluid bg-form-titel">
        <div class="row">
          <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
            <div class="container n-form2">


              <div class="form-group row m-0 pb-1">
                <label for="req_note" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">DO NO :</label>
                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                 
          <input name="do_no2" type="text" id="do_no2" value="<? if($$unique_master>0) echo $$unique_master; else echo (find_a_field($table_master,'max('.$unique_master.')','1')+1);?>" readonly="readonly"/>

          <input type="hidden" name="chalan_no" id="chalan_no" value="<?=$chalan_no?>" />


                </div>
              </div>


              <div class="form-group row m-0 pb-1">
                <label for="req_note" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Customer :</label>
                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                  
					  <input name="dealer_code" type="hidden" id="dealer_code" value="<?=$dealer->dealer_code?>" readonly="readonly"/>
					   <input name="wo_detail2" type="text" id="wo_detail2" value="<?=$dealer->dealer_name_e?>" readonly="readonly"/>


                </div>
              </div>


              <div class="form-group row m-0 pb-1">
                <label for="req_note" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Code :</label>
                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                  <input name="wo_detail2" type="text" id="wo_detail2" value="<?=$dealer->dealer_code;?>" readonly="readonly"/>
                </div>
              </div>
			  
              <div class="form-group row m-0 pb-1">
                <label for="req_note" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Region :</label>
                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                    <input name="wo_detail" type="text" id="wo_detail" value="<?=find_a_field('branch','BRANCH_NAME','BRANCH_ID='.$dealer->region_code)?>" readonly="readonly"/>

                </div>
              </div>
			  
              <div class="form-group row m-0 pb-1">
                <label for="req_note" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Address :</label>
                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                  <input name="wo_detail" type="text" id="wo_detail" value="<?=$dealer->address_e;?>" readonly="readonly"/>
                </div>
              </div>
			  
              <div class="form-group row m-0 pb-1">
                <label for="req_note" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Return Date :</label>
                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                  <input name="chalan_date" type="text" id="chalan_date" required="required" value="<?=date('Y-m-d')?>"/>

                </div>
              </div>



            </div>



          </div>


          <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
            <div class="container n-form2">

              <div class="form-group row m-0 pb-1">
                <label for="req_note" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Invoice NO :</label>
                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                    <!--<input name="remarksa" type="text" id="remarkas" value="<?=$chalan_no?>" tabindex="10" />-->
                <input name="invoice_no" type="text" id="invoice_no" value="<?=$chalan_no?>" tabindex="10" readonly="" />
                </div>
              </div>

              <div class="form-group row m-0 pb-1">
                <label for="req_note" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Invoice Date :</label>
                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                    <input name="do_date" type="text" id="do_date" value="<? if($chalan_no>0) echo $chalan_date = find_a_field($table_chalan,'chalan_date','chalan_no='.$chalan_no);?>" readonly="readonly" />

                </div>
              </div>


              <div class="form-group row m-0 pb-1">
                <label for="req_note" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Sales Type :</label>
                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                  		  <input name="do_type" type="text" id="do_type" value="<?=find_a_field('dealer_type','dealer_type','id='.$master->do_type)?>" tabindex="10" />

                </div>
              </div>
			  
			  
              <div class="form-group row m-0 pb-1">
   <label for="req_note" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Company :</label>
                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
               <input name="group_for" type="text" id="group_for" value="<?=find_a_field('user_group','group_name','id='.$group_for)?>" tabindex="10" readonly/>
                </div>
              </div>
			  
			  
              <div class="form-group row m-0 pb-1">
                <label for="req_note" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Warehouse :</label>
                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                 <!-- <input name="depot_id" type="text" id="depot_id" value="<?=find_a_field('warehouse','warehouse_name','warehouse_id='.$depot_id)?>" />-->
				 
              <select name="depot_id" id="depot_id" value="<?=$_POST['depot_id'];?>" required>

                <option></option>
                <? user_warehouse_access($depot_id); ?>
              </select>
			  
                </div>
              </div>
			  			  
<!--              <div class="form-group row m-0 pb-1">
                <label for="req_note" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Invoice View :</label>
                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                 <a target="_blank" href="../direct_sales/sales_invoice_new.php?v_no=<?=$chalan_no?>"><img src="../../images/print.png" width="30" height="30" /></a>

                </div>
              </div>-->

		
			  
			  
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
							
						$sql='select distinct sr_no, sr_date from sale_return_master where chalan_no='.$chalan_no.' order by sr_no desc';
							
							$qqq=db_query($sql);
							
							while($aaa=mysqli_fetch_object($qqq)){
							
							?>
							
									<tr>
							
									  <td><?=$aaa->sr_date?></td>
							
									  <td align="center">
										  <a target="_blank" href="sales_return_print_view.php?v_no=<?=rawurlencode(url_encode($aaa->sr_no));?>">
										  <img src="../../../images/print.png" width="15" height="15" />
										  </a>
									  </td>
							
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

 $sql='select a.id,a.order_no,a.item_id,b.finish_goods_code,b.item_name,a.pkt_unit,a.dist_unit,a.total_unit,a.pkt_size, a.unit_price, a.total_amt 
 from sale_do_chalan a,item_info b 
 where b.item_id=a.item_id and a.chalan_no='.$chalan_no;

$res=db_query($sql);

?>
<table id="grp" class="table1  table-striped table-bordered table-hover table-sm">
	<thead class="thead1">
			  <tr  class="bgc-info">
				<th rowspan="2">SL</th>
				<th rowspan="2">Code</th>
				<th width="50%" rowspan="2">Item Name</th>
				<th colspan="3"><div align="center">Invoice Qty</div></th>
				<th width="5%" rowspan="2">Return Qty</th>
			  </tr>
	
			<tr  class="bgc-info">
				<th width="7%">Price</th>
				<th width="7%">QTY</th>
				<th width="8%">Amount</th>
			</tr>
	</thead>

      <tbody class="tbody1">

          <? while($row=mysqli_fetch_object($res)){$bg++?>

          <tr bgcolor="<?=(($bg%2)==1)?'#FFEAFF':'#DDFFF9'?>">

            <td><?=++$ss;?></td>

            <td><?=$row->finish_goods_code?><input type="hidden" name="item_fg_<?=$row->id?>" id="item_fg_<?=$row->id?>" value="<?=$row->finish_goods_code?>" /></td>

              <td><?=$row->item_name?></td>

              <td align="center"><?= number_format($row->unit_price,3);?></td>

              <td align="center"><?= $row->total_unit;?>

			  

			  <? $return_qty = find_a_field('sale_return_details','sum(total_unit)','order_no="'.$row->id.'" and item_id="'.$row->item_id.'"');?>

			  

			  <? $unreturn_qty=($row->total_unit-$return_qty); ?>

			  <input type="hidden" name="unreturn_qty_<?=$row->id?>" id="unreturn_qty_<?=$row->id?>" value="<?=$unreturn_qty?>" onkeyup="calculation(<?=$row->id?>)" style="width:80px;"/>

			  

			  <input type="hidden" name="closing_qty_<?=$row->id?>" id="closing_qty_<?=$row->id?>"  onkeyup="calculation(<?=$row->id?>)" style="width:80px;"/>

			  

               </td>

              <td align="center"><?= number_format($row->total_amt,2);?>

                </td>

              <td align="center" bgcolor="#6699FF" style="text-align:center">

			  <? if($unreturn_qty>0){$cow++;

			  

			  ?>

<input name="chalan2_<?=$row->id?>" type="text" id="chalan2_<?=$row->id?>" style="width:80px; float:none" value="0" required="required" onkeyup="calculation(<?=$row->id?>)" />

                <? 

				} else echo 'Done';?></td>

              </tr>

          <? }?>

		    <tr>

            <td colspan="6">&nbsp;</td>

            <td align="center" bgcolor="#FFFFFF" style="text-align:center"><div id="pcsdiv"></div></td>

          </tr>

      </tbody>

      </table>

<? 
if($cow<1)
$vars['chalan_type']='Return';
db_update($table_chalan, $do_no, $vars, 'do_no');
//db_update($table_detail, $do_no, $vars, 'do_no');
//db_update($table_master, $do_no, $vars, 'do_no');

$return_count = find_a_field('sale_do_chalan','count(do_no)',' chalan_type="Return" and chalan_no='.$chalan_no);
if($return_count==0){
?>

	  <div class="n-form-btn-class">
			<input  name="do_no" type="hidden" id="do_no" value="<?=$$unique_master?>"/>
			<input  name="dealer_code" type="hidden" id="dealer_code" value="<?=$dealer->dealer_code;?>"/>
			<input name="confirm" type="submit" value="COMPLETE ENTRY" class="btn1 btn1-bg-submit"/>
        </div>



<? } else {?>

<h3 align="center" bgcolor="#FF3333"><strong>THIS INVOICE HAS BEEN  ADJUSTED</strong></h3>

<? }?>


<? }?>




      </div>
</form>

	</div>





<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>