<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$title='Bill of Materials (BOM)';









$bom_no=$_REQUEST['request_no'];



$data_found = $bom_no;



if ($data_found==0) {

do_calander('#inv_date');

create_combobox('fg_item_id');

  }





if(prevent_multi_submit()){





if(isset($_POST['master_data'])){

	

	$status = 'CHECKED';

	$entry_by = $_SESSION['user']['id'];

	$entry_at=date('Y-m-d H:i:s');

	

	

	$bom_date = $_POST['inv_date'];

	$fg_item_id = $_POST['item_id'];

	$quantity = $_POST['qty'];

	$unit_name = find_a_field('item_info','unit_name','item_id="'.$_POST['fg_item_id'].'"');

	$group_for=$_SESSION['user']['group'];

	$warehouse_id=$_POST['warehouse_id'];

	$inv_type='BOM-';

	

		

	

	

	

	

	

	

	

		$YR = date('Y',strtotime($bom_date));

 		$year = date('y',strtotime($bom_date));

  		$month = date('m',strtotime($bom_date));

 		$inv_cy_id = find_a_field('bom_master','max(bom_id)','year="'.$YR.'"')+1;

  		$cy_id = sprintf("%04d", $inv_cy_id);

   		$bom_no=''.$year.''.$month.''.$cy_id;

	

	

	





//	



//		



//	



	 

	 

	 if($fg_item_id>0) {

	  $ins_sql = 'INSERT INTO bom_master (bom_no, year, bom_id, inv_type, group_for, bom_date, fg_item_id, unit_name, quantity, warehouse_id, status, entry_at, entry_by) VALUES



("'.$bom_no.'", "'.$YR.'", "'.$cy_id.'", "'.$inv_type.'", "'.$group_for.'", "'.$bom_date.'", "'.$fg_item_id.'", "'.$unit_name.'", "'.$quantity.'", "'.$warehouse_id.'", "'.$status.'", "'.$entry_at.'", "'.$entry_by.'")';

	

	db_query($ins_sql);

	}



	



	 

	 ?>



<script language="javascript">

window.location.href = "invoice_entry.php?request_no=<?=$bom_no?>";

</script>



<? 

		

}







if(isset($_POST['foe_amt'])){

	

	$status = 'CHECKED';

	$entry_by = $_SESSION['user']['id'];

	$entry_at=date('Y-m-d H:i:s');

	$bom_no = $_POST['bom_no'];

	$bom_date = $_POST['bom_date'];

	$bom_no = $_POST['bom_no'];

	$fg_item_id = $_POST['fg_item_id'];

	$group_for = $_POST['group_for'];

	

	$sql_del_foe = 'delete from bom_factory_overhead where  bom_no="'.$bom_no.'"';

	db_query($sql_del_foe);

	

		

	 $sql = 'select l.group_name, a.ledger_id, a.ledger_name from ledger_group l, accounts_ledger a 

	 where l.group_id=a.ledger_group_id and a.ledger_group_id=412001 order by l.group_id, a.ledger_id';



		$query = db_query($sql);



		while($data=mysqli_fetch_object($query))



		{



			if($_POST['foe_amt_'.$data->ledger_id]>0)



			{

			

				$ledger_id=$_POST['ledger_id_'.$data->ledger_id];

			

				$foe_amt=$_POST['foe_amt_'.$data->ledger_id];

				



  $foe_invoice = 'INSERT INTO bom_factory_overhead (bom_no, group_for, bom_date, fg_item_id, ledger_id, amount, status, entry_at, entry_by)

  

  VALUES("'.$bom_no.'", "'.$group_for.'", "'.$bom_date.'", "'.$fg_item_id.'", "'.$ledger_id.'", "'.$foe_amt.'", "'.$status.'", "'.$entry_at.'", "'.$entry_by.'")';



db_query($foe_invoice);





	 

	 



	



}



}





	

	



	 

	 ?>







<? 

		

}











//if(isset($_POST['confirm'])){



if(isset($_POST['create'])){

	

	$status = 'CHECKED';

	$entry_by = $_SESSION['user']['id'];

	$entry_at=date('Y-m-d H:i:s');	

		

	$bom_no = $_POST['bom_no'];

	$bom_date = $_POST['bom_date'];

	$group_for = $_POST['group_for'];

	$fg_item_id = $_POST['fg_item_id'];

	

	$item_id = $_POST['item_id'];

	$unit_name = $_POST['unit_name'];

	$total_unit = $_POST['total_unit_r'];



	 if($item_id>0 && $_POST['unit_price']>0) {

	   $ins_sql = 'INSERT INTO bom_raw_material (bom_no, group_for, bom_date, fg_item_id, item_id, unit_name,total_unit, status, entry_at, entry_by) VALUES



("'.$bom_no.'", "'.$group_for.'", "'.$bom_date.'", "'.$fg_item_id.'", "'.$item_id.'", "'.$unit_name.'", "'.$total_unit.'", "'.$status.'", "'.$entry_at.'", "'.$entry_by.'")';

	

	db_query($ins_sql);

	}else{

	

		echo "<script>alert('Rate Not Found.')</script>";

	

	}







	 

	 

	 

//if ($pi_data->pi_type==3) {

//	

//		

////Text Sms

//



//

//function sms($dest_addr,$sms_text){

//



//

//

//$fields = array(

//    'userID'      => "NASSA@123",

//    'passwd'      => "LizAPI@019014",

//    'sender'      => "NASSA GROUP",

//    'msisdn'      => $dest_addr,

//    'message'     => $sms_text

//);













//}

//













//if($recipients2>0) {



//}

	

//Text Sms



		//}

	 

	 

	 

	 

	 ?>



<script language="javascript">

window.location.href = "invoice_entry.php?request_no=<?=$bom_no?>";

</script>



<? 

		

}









if(isset($_POST['bcreate'])){

	

	$status = 'CHECKED';

	$entry_by = $_SESSION['user']['id'];

	$entry_at=date('Y-m-d H:i:s');	

		

	$bom_no = $_POST['bom_no'];

	$bom_date = $_POST['bom_date'];

	$group_for = $_POST['group_for'];

	$fg_item_id = $_POST['fg_item_id'];

	

	$item_id = $_POST['item_id'];

	$type = $_POST['type'];

	$rate_ratio = $_POST['rate_ratio'];

	$unit_name = $_POST['unit_name'];

	$total_unit = $_POST['total_unit'];



	 if($item_id>0) {

	   $ins_sql = 'INSERT INTO bom_by_product (bom_no, group_for, bom_date, fg_item_id, item_id, unit_name,type,rate_ratio,total_unit, status, entry_at, entry_by) VALUES



("'.$bom_no.'", "'.$group_for.'", "'.$bom_date.'", "'.$fg_item_id.'", "'.$item_id.'", "'.$unit_name.'","'.$type.'","'.$rate_ratio.'","'.$total_unit.'", "'.$status.'", "'.$entry_at.'", "'.$entry_by.'")';

	

	db_query($ins_sql);

	}



	

	

	 

	 

	 

//if ($pi_data->pi_type==3) {

//	

//		

////Text Sms

//



//

//function sms($dest_addr,$sms_text){

//



//

//

//$fields = array(

//    'userID'      => "NASSA@123",

//    'passwd'      => "LizAPI@019014",

//    'sender'      => "NASSA GROUP",

//    'msisdn'      => $dest_addr,

//    'message'     => $sms_text

//);












//}

//













//if($recipients2>0) {



//}

	

//Text Sms



		//}

	 

	 

	 

	 

	 ?>



<script language="javascript">

window.location.href = "invoice_entry.php?request_no=<?=$bom_no?>";

</script>



<? 

		

}













if(isset($_POST['confirm'])){



	

	

	$status = 'CHECKED';

	$entry_by = $_SESSION['user']['id'];

	$entry_at=date('Y-m-d H:i:s');

	$bom_no = $_POST['bom_no'];

	$bom_date = $_POST['bom_date'];

	$group_for = $_POST['group_for'];

	

	 $find_foe_data = find_a_field('bom_factory_overhead','sum(amount)','bom_no="'.$bom_no.'"');

	 $find_rm_data = find_a_field('bom_raw_material','sum(total_unit)','bom_no="'.$bom_no.'"');

	

	

	if($find_foe_data>0 && $find_rm_data>0) {

	

	  $new_sql="UPDATE bom_master SET status='".$status."', checked_by='".$entry_by."', checked_at='".$entry_at."' WHERE bom_no = '".$bom_no."' ";

	 db_query($new_sql);

	 

	 }

	 

	 ?>



<script language="javascript">

window.location.href = "invoice_entry.php";

</script>



<? 

		

}













if(isset($_POST['delete'])){

	

	$status = 'CHECKED';

	$entry_by = $_SESSION['user']['id'];

	$entry_at=date('Y-m-d H:i:s');

		

	$bom_no = $_POST['bom_no'];

	

	$sql_del_ms = 'delete from bom_master where  bom_no="'.$bom_no.'"';

	db_query($sql_del_ms);

	

	$sql_del_foe = 'delete from bom_factory_overhead where bom_no="'.$bom_no.'"';

	db_query($sql_del_foe);

	

	$sql_del_rm = 'delete from bom_raw_material where bom_no="'.$bom_no.'"';

	db_query($sql_del_rm);

	

	 ?>



<script language="javascript">

window.location.href = "invoice_entry.php";

</script>



<? 

		

}















}

















?>



<script>







function getXMLHTTP() { //fuction to return the xml http object







		var xmlhttp=false;	







		try{







			xmlhttp=new XMLHttpRequest();







		}







		catch(e)	{		







			try{			







				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");



			}



			catch(e){







				try{







				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");







				}







				catch(e1){







					xmlhttp=false;







				}







			}







		}







		 	







		return xmlhttp;







    }

	

	

	function count()

{





//if(document.getElementById('unit_price').value!=''){}





var rate = ((document.getElementById('rate').value)*1);



//var total_unit = (document.getElementById('total_unit').value) = pkt_unit*pkt_size;



var qty = ((document.getElementById('qty').value)*1);



var amount = (document.getElementById('amount').value) = rate*qty;



}





	

	



function TRcalculation(order_no){



var po_qty = document.getElementById('po_qty_'+order_no).value*1;



var unit_price = document.getElementById('unit_price_'+order_no).value*1;



var adj_qty = document.getElementById('adj_qty_'+order_no).value*1;



var adj_amt = document.getElementById('adj_amt_'+order_no).value= (unit_price*adj_qty);



 if(po_qty<adj_qty)

  {

alert('You can`t reduce the qty');

document.getElementById('adj_qty_'+order_no).value='';

document.getElementById('adj_amt_'+order_no).value='';

  } 



}









function TRcalculationpo(order_no){



var rate = document.getElementById('rate_'+order_no).value*1;



var qty = document.getElementById('qty_'+order_no).value*1;





var amount = document.getElementById('amount_'+order_no).value= (rate*qty);



// if(po_qty<adj_qty)

//  {

//alert('You can`t reduce the qty');

//document.getElementById('adj_qty_'+order_no).value='';

//document.getElementById('adj_amt_'+order_no).value='';

//  } 



}







	function update_value(order_no)







	{



var order_no=order_no; // Rent



var item_id=(document.getElementById('item_id_'+order_no).value);



//var rate=(document.getElementById('rate_'+order_no).value);

var total_unit=(document.getElementById('total_unit_r'+order_no).value);

//var amount=(document.getElementById('amount_'+order_no).value);

var flag=(document.getElementById('flag_'+order_no).value); 



var strURL="item_revise_ajax.php?order_no="+order_no+"&item_id="+item_id+"&total_unit="+total_unit+"&flag="+flag;



		var req = getXMLHTTP();







		if (req) {







			req.onreadystatechange = function() {



				if (req.readyState == 4) {



					// only if "OK"



					if (req.status == 200) {						



						document.getElementById('divi_'+order_no).style.display='inline';



						document.getElementById('divi_'+order_no).innerHTML=req.responseText;						



					} else {



						alert("There was a problem while using XMLHTTP:\n" + req.statusText);



					}



				}				



			}



			req.open("GET", strURL, true);



			req.send(null);



		}	







}



	function update_value2(order_no)







	{



var order_no=order_no; // Rent



var item_id=(document.getElementById('item_id_'+order_no).value);



//var rate=(document.getElementById('rate_'+order_no).value);

var total_unit=(document.getElementById('total_unit_'+order_no).value);

//var amount=(document.getElementById('amount_'+order_no).value);

var flag=(document.getElementById('flag_'+order_no).value); 



var strURL="item_revise2_ajax.php?order_no="+order_no+"&item_id="+item_id+"&total_unit="+total_unit+"&flag="+flag;



		var req = getXMLHTTP();







		if (req) {







			req.onreadystatechange = function() {



				if (req.readyState == 4) {



					// only if "OK"



					if (req.status == 200) {						



						document.getElementById('divi_'+order_no).style.display='inline';



						document.getElementById('divi_'+order_no).innerHTML=req.responseText;						



					} else {



						alert("There was a problem while using XMLHTTP:\n" + req.statusText);



					}



				}				



			}



			req.open("GET", strURL, true);



			req.send(null);



		}	







}









function SUMcalculation(ledger_id){

//var unit_price = (document.getElementById('unit_price_'+item_id).value)*1;

var foe_amt = (document.getElementById('foe_amt_'+ledger_id).value)*1;

//document.getElementById('foe_amt_'+item_id).value = unit_price*qty;



var foe_amt = 0;



<?



	$sql = "select l.group_name, a.ledger_id, a.ledger_name

	from ledger_group l, accounts_ledger a where l.group_id=a.ledger_group_id and a.ledger_group_id=412001

	order by l.group_id, a.ledger_id";

$query = db_query($sql);

while($data=mysqli_fetch_object($query)){

?>

foe_amt = foe_amt + document.getElementById('foe_amt_<?=$data->ledger_id?>').value*1;;

<?

}



?>



document.getElementById('foe_amt').value = foe_amt;



}

















</script>













<style>

/*

.ui-state-default a, .ui-state-default a:link, .ui-state-default a:visited, a.ui-button, a:link.ui-button, a:visited.ui-button, .ui-button {

    color: #454545;

    text-decoration: none;

    display: none;

}*/





div.form-container_large input {

    width: 220px;

    height: 38px;

    border-radius: 0px !important;

}







</style>



<div class="form-container_large">





<form action="" method="post" name="codz" id="codz">



<? if ($data_found==0) { ?>



<div class="box" style="width:100%;">



								<table class="w-100" border="0"><th></th>



								  <tr>







    <td  style="text-align: right" ><strong> Date: </strong></td>







    <td  ><input name="inv_date" type="text" id="inv_date" style="width:90%; height:32px;" value="<?=$_POST['inv_date']?>" required autocomplete="off" /></td>

	

	 <td  ><strong>  Product: </strong></td>

	 <td  >

	 

	 <select name="fg_item_id" id="fg_item_id" style="width:200px;" >



        <option value=""></option>



		<? foreign_relation('item_info','item_id','item_name',$_POST['fg_item_id'],'1 and product_nature in("Both","Salable")');?>



      </select>

	 

</td>



	<td  style="text-align: right" ><strong> Production Line: </strong></td>

	 <td  >

	 

	 <select name="warehouse_id" id="warehouse_id" style="width:200px;" >



        <option value=""></option>



		<? foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['warehouse_id'],'1 and use_type="PL"');?>



      </select>

	 

</td>









	 <td  style="text-align: right" ><strong> Quantity: </strong></td>

	 <td  ><input name="quantity" type="text" id="quantity" style="width:90%; height:32px;" value="<?=$_POST['quantity']?>" required /></td>

	 <td  rowspan="7" class="text-center" ><strong>



      <input type="submit" name="master_data" id="master_data" value="View Data" style="width:180px; text-align:center; font-weight:bold; font-size:12px; height:30px; color:#090"/>



    </strong></td>

    </tr>

								  

								</table>



</div>





<? }?>







<? if ($data_found>0) { ?>



<div class="box" style="width:100%;">



								<table class="w-100" border="0" ><th></th>



								  <tr>







    <td style="width:15%; text-align: right"><strong> BOM No: </strong></td>







    <td style="width:21%" >

	<? $ms_data = find_all_field('bom_master','','bom_no="'.$_REQUEST['request_no'].'"'); ?>

	

	<input name="bom_no" type="hidden" id="bom_no" style="width:90%; height:32px;" value="<?=$ms_data->bom_no;?>" readonly="" required />

	<input name="group_for" type="hidden" id="group_for" style="width:90%; height:32px;" value="<?=$ms_data->group_for;?>" readonly="" required />

	<input name="fg_item_id" type="hidden" id="fg_item_id" style="width:90%; height:32px;" value="<?=$ms_data->fg_item_id;?>" readonly="" required />

	

	<input name="bom" type="text" id="bom" style="width:90%; height:32px;" value="<?=$ms_data->inv_type;?><?=$ms_data->bom_no;?>" readonly="" required /></td>

	

	 <td style="width:14%; text-align: right"><strong>  BOM Date: </strong></td>

	 <td style="width:16%; text-align: right"><input name="bom_date" type="text" id="bom_date" style="width:90%; height:32px;" value="<?=$ms_data->bom_date?>" required readonly="" /></td>

	 <td style="width:14%; text-align: right"><strong>Company: </strong></td>

	 <td style="width:20%" >

	<input name="group_name" type="text" id="group_name" style="width:90%; height:32px;" value="<?=find_a_field('user_group','group_name','id="'.$ms_data->group_for.'"'); ?>" required tabindex="1" readonly="" />	 </td>

	 </tr>

								  <tr>

								    <td style="width: 15%; text-align: right" ><strong> Product Name: </strong></td>

								    <td style="width:21%" >

	<input name="item_name" type="text" id="item_name" style="width:90%; height:32px;" value="<?=find_a_field('item_info','item_name','item_id="'.$ms_data->fg_item_id.'"'); ?>" readonly="" required tabindex="1" />

									<input name="group_for" type="hidden" id="group_for" style="width:90%; height:32px;" value="<?=$ms_data->group_for;?>" readonly="" required />

									

									<input name="vendor_id" type="hidden" id="vendor_id" style="width:90%; height:32px;" value="<?=$ms_data->vendor_id;?>" readonly="" required />

									<input name="warehouse_id" type="hidden" id="warehouse_id" style="width:90%; height:32px;" value="<?=$ms_data->warehouse_id;?>" readonly="" required />									</td>

								    <td style="text-align: right; width:14%"><strong> Unit: </strong></td>

								    <td style="width:16%; text-align: right"><input name="unit_name" type="text" id="unit_name" style="width:90%; height:32px;" value="<?=$ms_data->unit_name; ?>" readonly="" required /></td>

								    <td style="text-align: right; width:14%"><strong> Quantity: </strong></td>

								    <td style="width:20%"><input name="quantity" type="text" id="quantity" style="width:90%; height:32px;" value="<?=$ms_data->quantity;?>" readonly="" required /></td>

							      </tr>

								</table>



</div>

















<? }?>







<? if($data_found>0){ ?>





<form action="?<?=$unique?>=<?=$$unique?>" method="post" name="cloud" id="cloud">
    <!--Table input one design-->
    <div class="container-fluid pt-5 p-0 ">
      <table class="table1  table-striped table-bordered table-hover table-sm">
        <thead class="thead1">
		<tr>
		 <th colspan="8">Raw Material/Spare Item</th>
		</tr>
          <tr class="bgc-info">
            <th>SL</th>
			<th>Item Group</th>
			<th>Item Name</th>
			<th>Unit</th>
            
            
            <th>Qty</th>
            
            <th>Action</th>
          </tr>
        </thead>
		<tbody class="tbody1">
          <?

						$s=0;

						echo $res='select a.id,b.item_name as item_name,a.total_unit as qty,a.unit_name,g.group_name,b.item_id,w.warehouse_name,"x" from bom_raw_material a,item_info b, item_sub_group s, item_group g, warehouse w where  b.sub_group_id=s.sub_group_id and g.group_id=s.group_id and b.item_id=a.item_id and a.bom_no='.$bom_no;

                        $qry = db_query($res);

						while($data=mysqli_fetch_object($qry)){

						?>
          <tr>
            <td><?=++$s?></td>
			<td><?=$data->group_name?></td>
            <td style="text-align:left"><?=$data->item_id?>&nbsp;<?=$data->item_id?></td>
            <td><?=$data->unit_name?></td>
            <td><?=$data->qty?></td>
            <td><a href="?del=<?=$data->id?>">
              <button type="button" class="btn2 btn1-bg-cancel"><i class="fa-solid fa-trash"></i></button>
              </a></td>
          </tr>
          <? } ?>
        
          <tr>
		  <td>NEW</td>
		  <td>
		   <select name="group_id" id="group_id" onchange="getData2('get_item_list_ajax.php','item_list',this.value,this.value)">
		   <option></option>
		   <? foreign_relation('item_group','group_id','group_name','1')?>
		  </select>
		  <input  name="<?=$unique?>"i="i" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>
              <input  name="bom_date" type="hidden" id="bom_date" value="<?=$bom_date?>"/>
			  <input  name="group_for" type="hidden" id="group_for" value="<?=$group_for?>"/>
		  </td>
            <td id="item_list">
              <input  name="item_id" type="text" id="item_id" value="<?=$item_id?>"/>
            </td>
            <td colspan="1"><div style="text-align: right"> <span id="mr">
                <table style="width:100%;" border="1">
                  <tr>
                    
                    <td style="width:23%"><input name="unit_name" type="text" id="unit_name"  maxlength="100" class="form-control" onfocus="focuson('qty')" /></td>
                  </tr>
                </table>
                </span> </div></td>
            <td><input name="qty" type="text" class="input3" id="qty" required /></td>
            <td><input name="master_data" type="submit" id="master_data" class="btn1 btn1-bg-submit" value="View Data" /></td>
          </tr>
        </tbody>
      </table>
    </div>
    <!--Data multi Table design start-->
  
  </form>

								

		

	

<? }?>





<? if($data_found>0){ ?>















<div class="tabledesign2" style="width:100%">









<table class="w-100 text-center" border="0" id="grp" style="font-size:12px; text-transform:uppercase;">



  <tr>

    <th style="width:19%">Category</th>



    <th style="width:37%">Item Name</th>

    <th style="width:10%">Unit Name </th>

    <th style="width:10%">Quantity</th>

    <th style="width:12%"><div class="text-center">Action</div></th>

  </tr>

  



  <?

  

  

  if($_POST['fdate']!=''&&$_POST['tdate']!=''){ $date_con .= ' and c.chalan_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';}

  

  

		//if($_POST['dealer_code']!='')



//		if($_POST['do_no']!='') 







    if($_POST['po_date']!=''){

	$po_dt_con=" and m.po_date='".$_POST['po_date']."'";
}
	

	

	





//		 while($info=mysqli_fetch_object($query)){


//		}







		

		



    $sqlfg = "select a.*, s.sub_group_name, i.finish_goods_code, i.item_name, i.unit_name from bom_raw_material a, item_info i, item_sub_group s where i.item_id=a.item_id  and i.sub_group_id=s.sub_group_id and a.bom_no='".$bom_no."' order by a.id ";



  $queryfg = db_query($sqlfg);



  while($datafg=mysqli_fetch_object($queryfg)){$i++;







  ?>











  <tr style="background-color: <?= ($i % 2) ? '#E8F3FF' : '#fff'; ?>;">

    <td><?=$datafg->sub_group_name?></td>



    <td> <?=$datafg->item_name?> </td>

    <td style="background-color:#99CCFF;"><?=$datafg->unit_name?></td>

    <td style="background-color:#99CCFF;">

	<input name="order_no_<?=$datafg->id?>" type="hidden" id="order_no_<?=$datafg->id?>" value="<?=$datafg->id?>" />

      <input name="item_id_<?=$datafg->id?>" type="hidden" id="item_id_<?=$datafg->id?>" value="<?=$datafg->item_id?>" />

	<input name="total_unit_r<?=$datafg->id?>" type="text" id="total_unit_r<?=$datafg->id?>" value="<?=$datafg->total_unit; $tot_total_unit +=$datafg->total_unit;?>" onkeyup="TRcalculationpo(<?=$data->id?>)" style="width:80px; height:30px; " /></td>

    <td>

	<? if($reg_revise[$datafg->id]>0) {?>

	<div class="w-100 text-center"><b>Done!</b></div>

	<? }else {?>

	<span id="divi_<?=$datafg->id?>">

	<input name="flag_<?=$datafg->id?>" type="hidden" id="flag_<?=$datafg->id?>" value="0" />



	<input type="button" name="Button" value="EDIT"  onclick="update_value(<?=$datafg->id?>)" style="width:70px; font-size:12px; height:30px; background-color:#66CC66; font-weight:700;"/>

    </span><? }?></td>

  </tr>

  



  <? } ?>

</table>

</div>



<br />







<br /><br />









<?php /*?><table width="100%" border="0">





<? if($bill_data->status!="COMPLETED") {?>

<tr>



<td class="text-center">&nbsp;

<input name="delete" type="submit" class="btn1" value="DELETE" style="width:200px; font-weight:bold; float:left; font-size:12px; height:30px; background:#FF0000;color: #000000; border-radius:50px 20px;" />

</td>



<td class="text-center">



<input name="confirm" type="submit" class="btn1" value="CONFIRM &amp; SEND" style="width:270px; font-weight:bold; float:right; font-size:12px; height:30px;  background: #1E90FF; color: #000000; border-radius: 50px 20px;" /></td>



</tr>

<? }?>





</table><?php */?>





<?php /*?><table width="100%" border="0">



<? 



 		$pi_status = find_a_field('pi_master','status','id="'.$_POST['pi_id'].'"');

		 // $issue_qty = find_a_field('sale_do_production_issue','sum(total_unit)','do_no='.$_POST['do_no']);





if($pi_status!="MANUAL"){









?>



<tr>



<td colspan="2" align="center" bgcolor="#FF3333"><strong> Master PI Data Entry Completed</strong></td>



</tr>



<? }else{?>



<tr>



<td align="center">&nbsp;



</td>



<td align="center">


<input name="confirm" type="submit" class="btn1" value="COMPLETE" style="width:270px; font-weight:bold; float:right; font-size:12px; height:30px; color:#090" /></td>



</tr>



<? }?>



</table><?php */?>









<? }?>









<? if($data_found>0){ ?>



<div class="box text-center">

	<b class="display-4">BY PRODUCT</b>

</div>



<div class="tabledesign2" style="width:100%">



								<table class="w-100" border="0">



								  <tr>

								    <th>Item Code</th>

								    <th>Item Name</th>

								    <th>Quantity</th>

									<th>Type</th>

									<th>Ratio %</th>

								    <th style="width:10%" rowspan="2"><input name="bcreate" type="submit" id="bcreate" value="ADD DATA" style="width:120px; height:40px; background:#FF0000; color:#000000; font-weight:700;" /></th>

								  </tr>

								  <tr>



								 <td style="width:15%">

									



									



						 

						 

<div>

<input list="xc" name="fg_code" id="fg_code"   style="width:90%; height:30px; font-size:16px;"  onchange="getData2('item_data2_ajax.php', 'item_data_found2', this.value, 

document.getElementById('fg_code').value);"  autocomplete="off" >

  <datalist id="xc" style="font-size:16px;" >

   

     <? foreign_relation('item_info','concat(item_id)','concat(item_id,"-> ",item_name)',$fg_code,'1');?>

  </datalist>

</div>						 									</td>

									<td style="width:20%">

									<span id="item_data_found2">

									<input name="item_name" type="text" class="input3"  readonly=""  autocomplete="off"  value="" id="item_name" style="width:90%; height:30px;" /> </span>									</td>

		                            <td style="width:10%"><input name="total_unit" type="text" class="input3"   autocomplete="off"  value="" id="total_unit" style="width:80%; height:30px;" onkeyup="count()" /></td>

								<td><select name="type">

									<option></option>

									<option>Ratio</option>

									

								</select></td>

								<td><input name="rate_ratio" type="text" class="input3"   autocomplete="off"  value="" id="rate_ratio" style="width:80%; height:30px;"/></td>

	                              </tr>

								</table>

								

	</div>

								

		

	

<? }?>





<? if($data_found>0){ ?>

<div class="tabledesign2" style="width:100%">

<table border="0" class="w-100 text-center" id="grp" style="font-size:12px; text-transform:uppercase;">

  <tr>

    <th style="width:19%">Category</th>

    <th style="width:37%">Item Name</th>

    <th style="width:10%">Unit Name </th>

	<th style="width:10%">Type</th>

	<th style="width:10%">Rate/Ratio</th>

    <th style="width:10%">Quantity</th>

    <th style="width:12%"><div class="text-center">Action</div></th>

  </tr>

  <?

  

  if($_POST['fdate']!=''&&$_POST['tdate']!=''){ $date_con .= ' and c.chalan_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';}

  

  

		//if($_POST['dealer_code']!='')



//		if($_POST['do_no']!='') 







    if($_POST['po_date']!=''){

	$po_dt_con=" and m.po_date='".$_POST['po_date']."'";
}
	

	

	





//		 while($info=mysqli_fetch_object($query)){

//		}







		

		



     $sqlfg = "select a.*, s.sub_group_name, i.finish_goods_code, i.item_name, i.unit_name from bom_by_product a, item_info i, item_sub_group s where i.item_id=a.item_id  and i.sub_group_id=s.sub_group_id and a.bom_no='".$bom_no."' order by a.id ";



  $queryfg = db_query($sqlfg);



  while($datafg=mysqli_fetch_object($queryfg)){$i++;



 



  ?>











  <tr style="background-color: <?= ($i % 2) ? '#E8F3FF' : '#fff'; ?>;">

    <td><?=$datafg->sub_group_name?></td>



    <td> <?=$datafg->item_name?> </td>

    <td style="background-color:#99CCFF;"><?=$datafg->unit_name?></td>

	<td style="background-color:#99CCFF;"><?=$datafg->type?></td>

	<td style="background-color:#99CCFF;"><?=$datafg->rate_ratio; $tot_ratio += $datafg->rate_ratio;?></td>

    <td style="background-color:#99CCFF;">

	<input name="order_no_<?=$datafg->id?>" type="hidden" id="order_no_<?=$datafg->id?>" value="<?=$datafg->id?>" />

      <input name="item_id_<?=$datafg->id?>" type="hidden" id="item_id_<?=$datafg->id?>" value="<?=$datafg->item_id?>" />

	<input name="total_unit_<?=$datafg->id?>" type="text" id="total_unit_<?=$datafg->id?>" value="<?=$datafg->total_unit; $tot_total_unit +=$datafg->total_unit;?>" onkeyup="TRcalculationpo(<?=$data->id?>)" style="width:80px; height:30px; " /></td>

    <td>

	<? if($reg_revise[$datafg->id]>0) {?>

	<div class="w-100 text-center"><b>Done!</b></div>

	<? }else {?>

	<span id="divi_<?=$datafg->id?>">

	<input name="flag_<?=$datafg->id?>" type="hidden" id="flag_<?=$datafg->id?>" value="0" />



	<input type="button" name="Button" value="EDIT"  onclick="update_value2(<?=$datafg->id?>)" style="width:70px; font-size:12px; height:30px; background-color:#66CC66; font-weight:700;"/>

    </span><? }?></td>

  </tr>

  



  <? } ?>

  

  <tr>

  	<td colspan="7">&nbsp;</td>

  </tr>

  

  <tr>

  <td>FInish Good</td>

  	<td colspan="3"><?=find_a_field('item_info','item_name','item_id="'.$ms_data->fg_item_id.'"'); ?></td>

	

	<td><?=$fg_ratio=(100-$tot_ratio);?></td>

	<td colspan="2">&nbsp;</td>

  </tr>

  

  

  

   <tr>

  	<td colspan="9">&nbsp;</td>

  </tr>

  

</table>

</div>



<br />







<br /><br />


<div class="tabledesign2" style="width:100%">









<table class="w-100 text-center" border="0" id="grp" style="font-size:12px; text-transform:uppercase;">



  <tr>

    <th style="Width:16%">Ledger Group </th>



    <th style="Width:27%">Ledger Name </th>

    <th style="Width:11%">Amount </th>

    </tr>

  



  <?

  







		 $sql = "select ledger_id, amount as foe_exp from bom_factory_overhead where bom_no='".$bom_no."' group by ledger_id";

		 $query = db_query($sql);

		 while($info=mysqli_fetch_object($query)){

  		 $foe_exp[$info->ledger_id]=$info->foe_exp;

		}



		

		



      $sql = "select l.group_name, a.ledger_id, a.ledger_name

	from ledger_group l, accounts_ledger a where l.group_id=a.ledger_group_id and a.ledger_group_id=412001

	order by l.group_id, a.ledger_id";



  $query = db_query($sql);



  while($data=mysqli_fetch_object($query)){$i++;



 



  ?>











  <tr style="background-color: <?= ($i % 2) ? '#E8F3FF' : '#fff'; ?>;">

    <td><?=$data->group_name?></td>



    <td> <?=$data->ledger_name?> </td>

    <td style="background-color:#99CCFF; text-align: right">



<input name="ledger_id_<?=$data->ledger_id?>" type="hidden" id="ledger_id_<?=$data->ledger_id?>" value="<?=$data->ledger_id?>"  onkeyup="SUMcalculation(<?=$data->ledger_id?>)" />	

<input name="foe_amt_<?=$data->ledger_id?>" type="text" id="foe_amt_<?=$data->ledger_id?>" value="<?=$foe_exp[$data->ledger_id]; $tot_foe_exp +=$foe_exp[$data->ledger_id];?>" onkeyup="SUMcalculation(<?=$data->ledger_id?>)"  style="width:120px; height:30px;" />	

</td>



 <? } ?>

    </tr>

  <tr>

    <td style="background-color:#99CCFF;">&nbsp;</td>

    <td class="text-center" style="background-color:#99CCFF;"><div class="text-center"><strong>Total</strong></div></td>

    <td style="background-color:#99CCFF; text-align: right"><input name="foe_amt" id="foe_amt" type="text" size="10"  value="<?=$tot_foe_exp;?>" style="width:120px; height:30px;" readonly="" /></td>

  </tr>



 

</table>

</div>

<div class="box" style="width:100%;">						

								<table class="w-100">

                            <thead>

                              <tr class="oe_list_header_columns">

                                <th style="width:46%">&nbsp;</th>

                                <th style="width:31%">

								

								</th>

               <th style="width:23%; text-align: right"><input name="foe_data" type="submit" id="foe_data" value="CONFIRM" style="width:150px; height:30px; background:#FF6347; color:#000000; font-weight:700; float:right;" /></th>

                              </tr>

                            </thead>

                            <tfoot>

                            </tfoot>

                            <tbody>

                            </tbody>

                          </table>



    </div>






<table class="w-100" border="0"><th></th>











<? if($bill_data->status!="COMPLETED") {?>

<tr>



<td class="text-center">&nbsp;

<input name="delete" type="submit" class="btn1" value="DELETE" style="width:200px; font-weight:bold; float:left; font-size:12px; height:30px; background:#FF0000;color: #000000; border-radius:50px 20px;" />

</td>



<td class="text-center">



<input name="confirm" type="submit" class="btn1" value="CONFIRM &amp; SEND" style="width:270px; font-weight:bold; float:right; font-size:12px; height:30px;  background: #1E90FF; color: #000000; border-radius: 50px 20px;" /></td>



</tr>

<? }?>





</table>





<?php /*?><table width="100%" border="0">



<? 



 		$pi_status = find_a_field('pi_master','status','id="'.$_POST['pi_id'].'"');

		 // $issue_qty = find_a_field('sale_do_production_issue','sum(total_unit)','do_no='.$_POST['do_no']);





if($pi_status!="MANUAL"){









?>



<tr>



<td colspan="2" align="center" bgcolor="#FF3333"><strong> Master PI Data Entry Completed</strong></td>



</tr>



<? }else{?>



<tr>



<td align="center">&nbsp;



</td>



<td align="center">



<input name="confirm" type="submit" class="btn1" value="COMPLETE" style="width:270px; font-weight:bold; float:right; font-size:12px; height:30px; color:#090" /></td>



</tr>



<? }?>



</table><?php */?>









<? }?>















<p>&nbsp;</p>



</form>



</div>







<?


require_once SERVER_CORE."routing/layout.bottom.php";



?>