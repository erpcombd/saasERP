<?php 
session_start();

require_once "../engine/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once '../assets/support/ss_function.php';

$title = "Confirm Delivery";
$page = "do_chalan.php";
//var_dump($_SESSION);

require_once '../assets/template/inc.header.php';
$username	=$_SESSION['user']['username'];
$warehouse_id=$_SESSION['user']['warehouse_id'];
if($warehouse_id<1) die('Sorry you have no Dealer Info! Contact Support Team..');
$_SESSION['user']['group']=1;

//$store_name = find1("select warehouse_name from warehouse where warehouse_id='".$_SESSION['warehouse_id']."'");
//do_calander('#chalan_date','-0','+0');

if($_GET['do']>0) {
$check_status = find1("select status from ss_do_master where do_no='".$_GET['do']."'");
	if($check_status=='COMPLETED'){ redirect('home.php'); }
}

if($_REQUEST['do']>0) $do_no = $_REQUEST['do']; else $do_no = $_POST['do_no'];

$table_master='ss_do_master';
$unique_master='do_no';

$table_detail='ss_do_details';
$unique_detail='id';

$table_chalan='ss_do_chalan';
$unique_chalan='id';


$item_list = '1';
$sql='select order_no,item_id,sum(total_unit) total_unit from ss_do_chalan where do_no='.$do_no.' group by order_no';
$qqq=mysqli_query($conn,$sql);
while($aaa=mysqli_fetch_object($qqq)){
$delevery_qty[$aaa->order_no] = $aaa->total_unit;
$item_list .= ','.$aaa->item_id;
} 



if(isset($_POST['confirmm']) && $_POST['randcheck']==$_SESSION['user']['rand']){

		$chalan_date        =$_POST['chalan_date'];
		$now                = date('Y-m-d H:i:s');
		

		$chalan_no = find1("select max(chalan_no)+1 from ss_do_chalan where 1"); if($chalan_no==0) $chalan_no=1;
		
		//$config_ledger  = find_all_field('config_group_class','sales_ledger',"group_for=".$_SESSION['user']['group']);
		$dealer         = find_all_field('ss_shop','',"dealer_code=".$_POST['dealer_code']);
		
		$dealer_ledger  = 1122; //$dealer->account_code;
		$master         = find_all_field('ss_do_master','','do_no='.$do_no);
		
		$sql = 'select * from ss_do_details where do_no = '.$do_no.' ';
		$query = mysqli_query($conn, $sql);	
		while($data=mysqli_fetch_object($query)){
			
			if(($_POST['chalan_'.$data->id]>0)||($_POST['chalan2_'.$data->id]>0)){
				$chalan_pkt     =$_POST['chalan_'.$data->id];
				$chalan_dist    =$_POST['chalan2_'.$data->id];
				$unit_qty       = (($data->pkt_size*$chalan_pkt)+$chalan_dist);
                $total_amt      = ($unit_qty*$data->unit_price);
                $total_tp       = ($unit_qty*$data->t_price);
                $grand_total    = $grand_total + $total_amt;
                
                $dealer_code = $_POST['dealer_code'];
                				
               $q = "INSERT INTO  ss_do_chalan (order_no, chalan_no, do_no, item_id, dealer_code,t_price,nsp_per, unit_price, pkt_size, pkt_unit, dist_unit, total_unit, total_amt,total_tp, chalan_date, depot_id, driver_name, driver_name_real,shipping_name, vehicle_no,gate_pass_no, delivery_man, entry_by, entry_at,do_date,offer_ignore,do_type)
                VALUES 
                ('".$data->id."', '".$chalan_no."', '".$do_no."', '".$data->item_id."', '".$dealer_code."','".$data->t_price."','".$data->nsp_per."', '".$data->unit_price."', '".$data->pkt_size."', '".$chalan_pkt."', '".$chalan_dist."', '".$unit_qty."', '".$total_amt."','".$total_tp."', '".$chalan_date."', '".$_SESSION['user']['warehouse_id']."', '".$driver_name."',
                '".$driver_name_real."','".$shipping_name."', '".$vehicle_no."', '".$gate_pass_no."', '".$delivery_man."', '".$_SESSION['user']['username']."', 
                '".$now."','".$master->do_date."','".$data->offer_ignore."','".$master->do_type."')";
                                
                mysqli_query($conn, $q);
                $ch_id = mysqli_insert_id($conn);
                                
                
                journal_item_ss($data->item_id ,$warehouse_id,$_POST['chalan_date'],0,$unit_qty,'Sales',$ch_id,$data->unit_price,'',$chalan_no);
			}
			

// update dashboard report.
$ch_total       = find1("select sum(total_amt) from ss_do_chalan where chalan_no='".$chalan_no."' ");

$check_tdate = find1("select id from ss_dashboard where report_date='".date('Y-m-d')."' and code='".$username."'");
if($check_tdate>0){
    // update
    $sql_up_home ="update ss_dashboard set t_chalan=t_chalan+'".$ch_total."', edit_at='".date('Y-m-d H:i:s')."'
    where id='".$check_tdate."' ";
    mysqli_query($conn, $sql_up_home);
    
}else{
    // new entry
    $sql_new="insert ignore into ss_dashboard (report_date,code,t_chalan,entry_at) values('".date('Y-m-d')."','".$username."','".$ch_total."','".date('Y-m-d H:i:s')."')";
    mysqli_query($conn, $sql_new);
    
}

unset($_SESSION['sec_sales']);
// end dashboard	
			
			
			

} // end while
		

// ---------------------- GIFT Item Calculation --------------------------
// $sql = 'select s.*,d.* from ss_do_details d, ss_gift_offer s where s.id=d.gift_id and d.do_no = '.$do_no.' and (d.item_id=1096000100010239 or d.item_id=1096000100010312 or d.item_id=1096000100010967)';
// 		$query = mysqli_query($conn, $sql);	
// 		while($data=mysqli_fetch_object($query))
// 		{
//                 $order	= find_all_field('ss_do_details','','id='.$data->gift_on_order);
//                 $gift   = find_all_field('ss_gift_offer','','id='.$data->gift_id);


// 			if(($_POST['chalan_'.$order->id]>0)||($_POST['chalan2_'.$order->id]>0))
// 			{
// 				$chalan_pkt         =$_POST['chalan_'.$order->id];
// 				$chalan_dist        =$_POST['chalan2_'.$order->id];
// 				$item_qty           =(($order->pkt_size*$chalan_pkt)+$chalan_dist);
				
// 				$data->pkt_size     = '1.00';
// 				$unit_price         = (-1)*($gift->gift_qty);
// 				$unit_qty           = (int)($item_qty/$gift->item_qty);
// 				$total_amt          = $unit_qty * $unit_price;
// 				$chalan_pkt         = '0.00';
// 				$chalan_dist        = $unit_qty;
// 				$dealer_code        = $_POST['dealer_code'];
				
				
				
// 				if($chalan_dist>0){
				
//                 $q = "INSERT INTO  ss_do_chalan (order_no, chalan_no, do_no, item_id, dealer_code, unit_price, pkt_size, pkt_unit, dist_unit, total_unit, total_amt, chalan_date, depot_id, driver_name, driver_name_real, vehicle_no,gate_pass_no, delivery_man, entry_by, entry_at,do_date)
//                  VALUES 
//                 ('".$data->id."', '".$chalan_no."', '".$do_no."', '".$data->item_id."', '".$dealer_code."', '".$data->unit_price."', '".$data->pkt_size."', '".$chalan_pkt."', '".$chalan_dist."', '".$unit_qty."', '".$total_amt."', '".$chalan_date."', '".$_SESSION['warehouse_id']."', '".$driver_name."','".$driver_name_real."', '".$vehicle_no."', '".$gate_pass_no."', '".$delivery_man."', '".$_SESSION['user']['id']."', '".$now."','".$master->do_date."')";
//                 mysqli_query($conn, $q);
//                 	$ch_id = mysqli_insert_id($conn);
                
//                 journal_item_ss($data->item_id ,$_SESSION['warehouse_id'],$_POST['chalan_date'],0,$unit_qty,'Sales',$ch_id,'','',$chalan_no);
                				
// 				}
// 			}
					
					
// 		} 
		
		// end while
		


// -------------------------- Secondary Journal Function		
//if($ch_id>0) { auto_insert_sales_chalan_secoundary($chalan_no);  }



//$chalan_no;


// update do master
if($master->do_type=='Booking'){
    
}else{
    $ssql="update ss_do_master set status='COMPLETED' where do_no='".$do_no."'";
    mysqli_query($conn, $ssql);
}




redirect("chalan_view.php?v=$chalan_no");
//header('Location: chalan_view.php?v=$chalan_no');


} // end submit confirm



// cancel order button
if(isset($_POST['delete'])){

$update_sql='update ss_do_master set status="COMPLETED" where do_no="'.$do_no.'"';
mysqli_query($conn, $update_sql);
redirect("do_list.php");
}

if($$unique_master>0){
		$condition=$unique_master."=".$$unique_master;
		$data=db_fetch_object($table_master,$condition);
		while (list($key, $value)=each($data)){ $$key=$value;}
}



$dealer = find_all_field('ss_shop','','dealer_code='.$dealer_code);
//auto_complete_from_db('item_info','item_name','concat(item_name,"#>",finish_goods_code)','product_nature="Salable"','item');

if($$unique_master>0) $do_all=find_all_field($table_master,'do_date','do_no='.$do_no);


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
		alert('Can not Delivery More than Undelivered Pcs.');
		document.getElementById('chalan2_'+id).value='';
		document.getElementById('chalan2_'+id).focus();
	}
  }
}




function cal(id) {
	var pkt_size  = ((document.getElementById('pkt_size_'+id).value)*1);
	//var pkt_unit  = ((document.getElementById('chalan_'+id).value)*1);
	var dist_unit = ((document.getElementById('chalan2_'+id).value)*1);
	var unit_price = ((document.getElementById('unit_price_'+id).value)*1);
	//var qty_unit  = (pkt_unit*pkt_size)+dist_unit;
	var total_amt  = dist_unit * unit_price;
	document.getElementById('total_amt_'+id).value = total_amt;
	var undelqty = ((document.getElementById('undelqty_'+id).value)*1);
	var stockqty = ((document.getElementById('stockqty_'+id).value)*1);
	

	
    if(dist_unit>undelqty){
        alert('Can not Delivery More than Undelivered Qty.');
        //document.getElementById('chalan_'+id).value='';
        document.getElementById('chalan2_'+id).value=0;
        //document.getElementById('chalan_'+id).focus();
     }
  
//var stockopen = (document.getElementById('stock_open').value);
//if(stockopen=='NO'){
    if(dist_unit>stockqty){
        alert('Can not Delivery More than Stock.');
        //document.getElementById('chalan_'+id).value='';
        document.getElementById('chalan2_'+id).value=0;
        //document.getElementById('chalan_'+id).focus();
    }
//}  
  
  Calc_totals();
}

var active_ids = new Array();
var active_ids2 = new Array();
var active_ids3 = new Array();
	
function Calc_totals() {
	
    var answerValues = 0; 
	var answerValue = 0;
	
    for(i=0; i < active_ids3.length; i++) 
    { 
        answerValue = Number(document.getElementById(active_ids3[i]).value);
		answerValues += Number(answerValue);
    } 
	var gift_unit = Math.floor(answerValues/4000)
	var gift_total = (gift_unit*12)
	var gift_pack_size = document.getElementById('gift_pack_size').value
	var gift_ctn  = Math.floor(gift_total/gift_pack_size)
	var gift_pcs  = Math.floor(gift_total%gift_pack_size)
	document.getElementById('amtdiv').innerHTML = '<span>'+answerValues+'</span>';
	document.getElementById('giftdiv').innerHTML = '<span>SK : '+(gift_unit*3)+' // ITEM : '+gift_ctn+' CTN & '+gift_pcs+' PCS</span>';
	
    var answerValues = 0; 
	var answerValue = 0;
	
	for(i=0; i < active_ids.length; i++) 
    { 
        answerValue = Number(document.getElementById(active_ids[i]).value);
		answerValues += Number(answerValue);
    } 

	document.getElementById('crtdiv').innerHTML = '<span>'+answerValues+'</span>';
	
	var answerValues2 = 0; 
	var answerValue2 = 0;
	
    for(i=0; i < active_ids2.length; i++) 
    { 
        answerValue2 = Number(document.getElementById(active_ids2[i]).value);
		answerValues2 += Number(answerValue2);
    } 

	document.getElementById('pcsdiv').innerHTML = '<span>'+answerValues2+'</span>';
}

</script>




<!-- start of Page Content-->  
   <div class="page-content header-clear-medium">
   
			<form action="" method="post" name="codz" id="codz">
				<?php $rand=rand(); $_SESSION['user']['rand']=$rand; ?>
				<input type="hidden" value="<?php echo $rand; ?>" name="randcheck" />
        <div class="card card-style mb-0">
				<div class="content mt-0 ms-0 me-0">
					<div class="row mb-1">
						<div class="col-lg-6">
						<label for="form44">DO No</label>
						<input class="form-control validate-text" name="do_no" type="text" id="do_no" value="<?=$do_no?>" required="required" readonly placeholder="DO No"/>
						</div>
						<div class="col-lg-6">
						<label for="form4" >Date</label>
						<input class="form-control validate-text" name="do_date" type="date" id="do_date" value="<?=$do_date?>" required="required" readonly  placeholder="Date"/>
						</div>
					</div>
					
						

	
					<!-- <div class="input-style-new input-style-always-active has-borders no-icon validate-field mb-4"> -->
					
						
						<!-- <i class="fa fa-times disabled invalid color-red-dark"></i>
						<i class="fa fa-check disabled valid color-green-dark"></i>
						<em>(required)</em>
					</div> -->
					
	
					<!-- <div class="input-style has-borders no-icon validate-field mb-4"> -->
			
					<div class="row mb-1">
						<div class="col-lg-6">
						<? $field='dealer_code';?>
					<label for="form4" >Shop</label>
					<select name="<?=$field?>" id="<?=$field?>" required readonly/>
						<option value="<?=$$field?>"><?php echo $party_name=find1('select shop_name from ss_shop where dealer_code="'.$$field.'"');?></option>
					</select>
						</div>
						<div class="col-lg-6">
						<label for="form6" >Chalan Date</label>
						<input class="form-control validate-text"  name="chalan_date" type="date" id="chalan_date" required="required" value="<?=date('Y-m-d');?>" readonly="readonly" placeholder="Chalan Date"/>
						
						</div>
					</div>
					
					
						
						<!-- <i class="fa fa-times disabled invalid color-red-dark"></i>
						<i class="fa fa-check disabled valid color-green-dark"></i>
						<em>(required)</em>
					</div> -->
	
					<!-- <div class="input-style-new input-style-always-active has-borders no-icon validate-field mb-4"> -->
					
						<!-- <i class="fa fa-check disabled valid me-4 pe-3 font-12 color-green-dark"></i>
						<i class="fa fa-check disabled invalid me-4 pe-3 font-12 color-red-dark"></i>
					</div> -->

				</div>
            </div>
			

			<div class="card card-style">
			<? if($$unique_master>0){
			// stock list
			$dealer_code	=$_SESSION['user']['warehouse_id'];
			//$opening_date = find1("select max(ji_date) from ss_journal_item where tr_from='".Opening."' and warehouse_id='".$dealer_code."' ");
			//if($opening_date=='') {
				$opening_date   ='2023-10-01';
			//}
			
			
			// primary chalan
			$sql_in="select item_id, sum(total_unit) as qty from sale_do_chalan 
			where chalan_date>='".$opening_date."' and chalan_date<='".date('Y-m-d')."' and dealer_code='".$dealer_code."' group by item_id";
			$query1 = mysqli_query($conn,$sql_in);
			while($info1=mysqli_fetch_object($query1)){
			$item_in[$info1->item_id]=$info1->qty;
			}
			
			// primary sales return
			$pr="select d.item_id,sum(d.total_unit) as qty 
			from sale_return_master m, sale_return_details d 
			where m.do_no=d.do_no and m.dealer_code='".$dealer_code."' and m.do_date>='".$opening_date."' and m.status in ('CHECKED','COMPLETED') 
			group by d.item_id";
			$query3 = mysqli_query($conn,$pr);
			while($info3=mysqli_fetch_object($query3)){
				$preturn[$info3->item_id]=$info3->qty;
			}
			
			// sec bin card
		 $sql2="select item_id,sum(item_in-item_ex) as qty from ss_journal_item
			where warehouse_id='".$dealer_code."' and ji_date>='".$opening_date."'
			group by item_id";
			$query2 = mysqli_query($conn,$sql2);
			while($info2=mysqli_fetch_object($query2)){
			$item_ss[$info2->item_id]=$info2->qty;
			} 
			
			 ?> 
				<div class="content m-0">

					<table class="table table-borderless text-center table-scroll table_new_border" style="overflow: hidden; width: 100%; zoom: 85%;">
						<thead>
							<tr class="bg-night-light1">
								<th scope="col" class="color-white">SL</th>
								<th scope="col" class="color-white">Item Name</th>
								<th scope="col" class="color-white">Rate</th>
								<th scope="col" class="color-white">Stock</th>
								<th scope="col" class="color-white">OQ</th>
								<th scope="col" class="color-white">UQ</th>
								<th scope="col" class="color-white">CQ</th>
							</tr>
						</thead>
						<tbody>
		<?
		 $sql='select a.id,a.item_id,b.finish_goods_code,b.item_name,a.pkt_unit,a.unit_price,a.dist_unit,a.total_unit,a.pkt_size,a.gift_on_item 
		from ss_do_details a, item_info b 
		where (b.item_id!=1096000100010239 and  b.item_id!=1096000100010312 and b.item_id!=1096000100010967) 
		and b.item_id=a.item_id and a.do_no='.$$unique_master.' order by a.id';
	

		$res=mysqli_query($conn, $sql); 
		 while($row=mysqli_fetch_object($res)){
              $bg++;
			    $stock_qty = ($item_ss[$row->item_id]+$item_in[$row->item_id]-$preturn[$row->item_id]);
            	if($row->gift_on_item==1096000100011491&&$row->item_id!=1096000100011499)
            	$gift_pack_size = $row->pkt_size;
            	if($row->gift_on_item==1096000100011491&&$row->item_id!=1096000100011498)
            	$gift_pack_size = $row->pkt_size;
            	if($row->gift_on_item==1096000100011491&&$row->item_id!=1096000100011492)
            	$gift_pack_size = $row->pkt_size;
		  ?>
          
       <tr bgcolor="<? if($row->gift_on_item==1096000100011491) echo 'yellow'; else {if(($bg%2)==1) echo '#FFEAFF'; else echo '#DDFFF9';} ?>" >
            <td><?=++$ss;?></td>

<input type="hidden" name="item_fg_<?=$row->id?>" id="item_fg_<?=$row->id?>" value="<?=$row->finish_goods_code?>" />
<input type="hidden" name="pkt_size_<?=$row->id?>" id="pkt_size_<?=$row->id?>" value="<?=$row->pkt_size?>" />
            
<td><?=$row->finish_goods_code?>-<?=$row->item_name?><? if($row->gift_on_item>0) echo '[GIFT]'; ?></td>
<td><?=number_format($row->unit_price, 2, '.', '');?>
<input type="hidden" name="unit_price_<?=$row->id?>" id="unit_price_<?=$row->id?>" value="<?=$row->unit_price?>" />
<input type="hidden" name="total_amt_<?=$row->id?>" id="total_amt_<?=$row->id?>" value="<?=$row->total_amt?>" />
</td>

<td><?=$stock_qty;?>
<input type="hidden" name="stockqty_<?=$row->id?>" id="stockqty_<?=$row->id?>" value="<?=$stock_qty?>" />
</td>

<td align="center"><? echo $row->total_unit; //=$row->dist_unit;  ?></td>

            
<!-- ------------------------ Undel Qty ------------------------- -->
<?
$del_qty = $delevery_qty[$row->id];
$undel_qty=($row->total_unit-$del_qty);



//$stock_qty = $stock[$row->item_id];
// if($stock_qty>0) echo $stock_pkt = (int)($stock_qty/$row->pkt_size); else {echo $stock_pkt =0;$stock_qty=0;}
?>
           <!--         <td align="center"><? $undel_qty=($row->total_unit-$del_qty); echo $undel_pkt = (int)($undel_qty/$row->pkt_size);?>-->
           <!--         <input type="hidden" name="undelpkt_<?=$row->id?>" id="undelpkt_<?=$row->id?>" value="<?=$undel_pkt?>" />-->
<input type="hidden" name="undelqty_<?=$row->id?>" id="undelqty_<?=$row->id?>" value="<?=$undel_qty?>" />
        			<!--</td>-->
            
            
            
            <td align="center"><? echo $undel_dist =$undel_qty; ?>
                <input type="hidden" name="undeldist_<?=$row->id?>" id="undeldist_<?=$row->id?>" value="<?=$undel_dist?>" />
            </td>
            
<?
//if($stock_open=='NO'){
//    if($undel_qty>$stock_qty){$undel_qty=-1;}
//}
//change by ERP TEAM ***************
//if($undel_qty>$stock_qty){$undel_qty=-1;}
?>
		  
            <td align="center" bgcolor="#6699FF" style="text-align:center">
			  <? if($undel_qty>0){ $cow++; ?>
                <input name="chalan2_<?=$row->id?>" type="number" id="chalan2_<?=$row->id?>" style="width:60px; float:none; border-radius: 5px;" value="<?=$undel_qty;?>" required="required" onchange="cal(<?=$row->id?>)" />
                <? }elseif($undel_qty==-1){
                    //echo 'Short';
                    ?><input name="chalan2_<?=$row->id?>" type="number" id="chalan2_<?=$row->id?>" style="width:60px; float:none; border-radius: 5px;" value="" required="required" onchange="cal(<?=$row->id?>)" /><?
                } else echo 'Done';?>
            </td>
                
                
        </tr>
          <? } ?>





						</tbody>
					</table>
					
					<div class="row">
						<? 
						if(date('d')>10)
						$from_date = date('Y-m-01');
						else
						$from_date = date('Y-m-01',time()-(86400*date('d')+1));
						
						
						if($cow<1){
						$vars['status']='COMPLETED';
						db_update($table_chalan, $do_no, $vars, 'do_no');
						db_update($table_detail, $do_no, $vars, 'do_no');
						db_update($table_master, $do_no, $vars, 'do_no');
						?>
						<div class="col-12">
							<a class="demo-color bg-mint-dark">THIS DELIVERY ORDER IS COMPLETE</a>
						</div>
						<? } ?>
						

						<div class="col-6">
							<input name="delete" type="submit"  value="Cancel Order" class="b-n btn btn-danger btn-3d btn-block  text-light w-100 py-3"/>
							<input  name="do_no" type="hidden" id="do_no" value="<?=$$unique_master?>"/>
						</div>
						<div class="col-6">
						  <input name="confirmm" type="submit"  value="Delivery" class="b-n btn btn-success btn-3d btn-block  text-light w-100 py-3"/>
						  <input  name="dealer_code" type="hidden" id="dealer_code" value="<?=$dealer->dealer_code;?>"/>
					  </div>
					</div>
				</div>
				
				<? } // end if unique master ?> 
            </div>
			</form>
			
        </div>
    <!-- End of Page Content--> 
    
    



<?php 
 require_once '../assets/template/inc.footer.php';
 ?>