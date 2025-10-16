<?php
require_once "../../../assets/template/layout.top.php";

$depot=$_SESSION['user']['depot'];

$title='Approve Sales Order';

do_calander('#est_date');

do_calander('#do_date');

$page = 'do_check.php';

$depot_id = $_POST['depot_id'];

if($_POST['dealer']>0) 

$dealer_code = $_POST['dealer'];

$dealer = find_all_field('dealer_info','','dealer_code='.$dealer_code);

//$depot_id = find_a_field('warehouse','warehouse_name','warehouse_id='.$dealer->depot);

$table_master='sale_do_master';

$unique_master='do_no';

$table_detail='sale_do_details';

$unique_detail='id';

if($_GET['del_id']>0){
 $del_id= $_GET['del_id'];
$dsql="delete from sale_do_details where id='".$del_id."'";
mysql_query($dsql);

header('location:do_check.php?do_no='.$_GET['do_no'].'');
}


if($_REQUEST['old_do_no']>0)

$$unique_master=$_REQUEST['old_do_no'];

elseif(isset($_GET['del']))

{$$unique_master=find_a_field('sale_do_details','do_no','id='.$_GET['del']); $del = $_GET['del'];}

else

$$unique_master=$_REQUEST[$unique_master];

if(isset($_POST['confirm'])){
$d_no=$_POST['do_no'];
$user_id=$_SESSION['user']['id'];
$se_sql="select * from sale_do_details where do_no='".$d_no."'";
$se_query=mysql_query($se_sql);
while($row=mysql_fetch_object($se_query)){

$price_data=$_POST['edit_price_'.$row->id]; 

$qty_data=$_POST['edit_qty_'.$row->id];

$total_data=$price_data * $qty_data;

$up_sql="update sale_do_details set unit_price='".$price_data."',dist_unit='".$qty_data."',total_unit='".$qty_data."',total_amt='".$total_data."' where id='".$row->id."'";
mysql_query($up_sql);
}


$sqlp="UPDATE sale_do_details SET status = 'CHECKED' WHERE do_no = '".$d_no."' ";
 mysql_query($sqlp);
 
 $sqlq="UPDATE sale_do_master SET status = 'CHECKED',approved_by='".$user_id."' WHERE do_no = '".$d_no."' ";
 mysql_query($sqlq);
 
 header('location:select_uncheck_do.php');

}

if(isset($_POST['delete'])){
$do_no=$_POST['do_no'];
$del1='delete from sale_do_master where do_no="'.$do_no.'"';
mysql_query($del1);
$del2='delete from sale_do_details where do_no="'.$do_no.'"';
mysql_query($del2);
header("Location:select_uncheck_do.php");
}




if(prevent_multi_submit()){

if(isset($_POST['new']))

{
		$crud   = new crud($table_master);

		$_POST['entry_at']=date('Y-m-d H:s:i');

		$_POST['entry_by']=$_SESSION['user']['id'];

		if($_POST['flag']<1){

		$_POST['do_no'] = find_a_field($table_master,'max(do_no)','1')+1;

		$$unique_master=$crud->insert();

		unset($$unique);

		$type=1;

		$msg='Work Order Initialized. (Demand Order No-'.$$unique_master.')';

		}



		else {



		$crud->update($unique_master);



		$type=1;



		$msg='Successfully Updated.';



		}



}





if(isset($_POST['add'])&&($_POST[$unique_master]>0))

{
$details_insert = new crud($table_detail)	;
$_POST['unit_price']=$_POST['unit_price2'] ;
$details_insert->insert();
unset($$unique);
$type=1;
$msg='Item Entry Succesfull';
}



}



else



{



	$type=0;



	$msg='Data Re-Submit Error!';



}







if($del>0)



{	







		$main_del = find_a_field($table_detail,'gift_on_order','id = '.$del);



		$crud   = new crud($table_detail);



		if($del>0)



		{



			$condition=$unique_detail."=".$del;		



			$crud->delete_all($condition);



			



			$condition="gift_on_order=".$del;		



			$crud->delete_all($condition);



			



			if($main_del>0){



			$condition=$unique_detail."=".$main_del;		



			$crud->delete_all($condition);



			$condition="gift_on_order=".$main_del;		



			$crud->delete_all($condition);}



		}



		$type=1;



		$msg='Successfully Deleted.';



}











if($$unique_master>0)



{



		$condition=$unique_master."=".$$unique_master;



		$data=db_fetch_object($table_master,$condition);



		while (list($key, $value)=@each($data))



		{ $$key=$value;}



		



}



		$dealer = find_all_field('dealer_info','','dealer_code='.$dealer_code);



		if($dealer->product_group!='M') $dgp = $dealer->product_group;



auto_complete_start_from_db('item_info','concat(finish_goods_code,"#>",item_name)','finish_goods_code','product_nature in ("Salable","Both") order by finish_goods_code ASC','item');



?>



<script language="javascript">



function count()



{
var dist_unit = ((document.getElementById('dist_unit').value)*1);
var unit_price2 = ((document.getElementById('unit_price2').value)*1);
var tot_amt=dist_unit*unit_price2;
document.getElementById('total_amt').value	= tot_amt.toFixed(2);
document.getElementById('total_unit').value=dist_unit;
//
//
//if(document.getElementById('pkt_unit').value!=''){
//
//var pkt_unit = ((document.getElementById('pkt_unit').value)*1);
//
//var dist_unit = ((document.getElementById('dist_unit').value)*1);
//
//var pkt_size = 1;
//
//var unit_price2 = ((document.getElementById('unit_price2').value)*1);
//
//
//
//var total_unit = (pkt_unit*1)+dist_unit;
//
//
//
//if(unit_price2==0)
//
//var unit_price =0;
//
//else
//
//var unit_price = ((document.getElementById('unit_price2').value)*1);
//
//var total_amt  = (dist_unit*unit_price);
//
//
//
//document.getElementById('total_unit').value=total_unit;
//
//
//
//document.getElementById('total_amt').value	= total_amt.toFixed(2);
//
//
//
//var do_total = ((document.getElementById('do_total').value)*1);
//
//
//
//var do_ordering	= total_amt+do_total;
//
//
//
//document.getElementById('do_ordering').value =do_ordering.toFixed(2);
//
//
//
//}
//
//
//
//else
//
//
//
//document.getElementById('dist_unit').focus();
//


}



</script>







<script language="javascript">



function focuson(id) {
  if(document.getElementById('item').value=='')
  document.getElementById('item').focus();
  else
  document.getElementById(id).focus();
}







window.onload = function() {

if(document.getElementById("flag").value=='0')
  document.getElementById("rcv_amt").focus();
  else
  document.getElementById("item").focus();
}



</script>


<script>

/////-=============-------========-------------Ajax  Voucher Entry---------------===================-------/////////

function insert_item(){
var item1 = $("#item");
var dist_unit = $("#dist_unit");


if(item1.val()=="" || dist_unit.val()==""){
	 alert('Please check Item ID,Qty');
	  return false;
	}


	
$.ajax({
url:"do_input_ajax.php",
method:"POST",
dataType:"JSON",

data:$("#codz").serialize(),

success: function(result, msg){
var res = result;

$("#codzList").html(res[0]);	
$("#t_amount").val(res[1]);


$("#item").val('');
$("#item2").val('');
$("#dist_unit").val('');
$("#sec_unit").val('');
$("#total_amt").val('');

}
});	

//}else{ alert('Please Enter Debit Ledger'); }
//}else{ alert('Please check Ledger,amount and Date'); }

  }
/////-=============-------========-------------Ajax  Voucher Entry---------------===================-------/////////


</script>
<script>

function total_count(id){

var i_price= (document.getElementById('edit_price_'+id).value)*1;

var i_qty= (document.getElementById('edit_qty_'+id).value)*1;

var i_total= i_price * i_qty;

//alert(i_total);
document.getElementById('edit_total_'+id).value=i_total;
}


$(document).ready(function(){ 
$('#item').blur(function(event){

		event.preventDefault();

		$.ajax({

			url:"dope_ajax.php",

			method:"post",

			data: $('form').serialize(),

			dataType: "text",

			

			success:function(data2){

		
				//$('#message').text(strMessage)
				 var result1=data2.split('~');
		
    $('#sec_unit').val(result1[0]);

			}

		})
//location.reload();
	})
	

	
})




</script>



<script language="javascript">



function grp_check(id)



{



if(document.getElementById("item").value!=''){



var myCars=new Array();



myCars[0]="01815224424";



<?



//$item_i = 1;



//$sql_i='select finish_goods_code from item_info where product_nature="Salable"';



//$query_i=mysql_query($sql_i);



//while($is=mysql_fetch_object($query_i))



//{



	//echo 'myCars['.$item_i.']="'.$is->finish_goods_code.'";';



	//$item_i++;



//}



?>



//var item_check=id;



//var f=myCars.indexOf(item_check);



//if(f>0)

getData2('do_ajax_s.php', 'do',document.getElementById("item").value,'<?=$depot_id;?>');


 


//else



//{



//alert('Item is not Accessable');



//document.getElementById("item").value='';



//document.getElementById("item").focus();



//}

}



}



</script>



<style type="text/css">
label{
color:black!important;
}


<!--



.style1 {



	color: #FFFFFF;



	font-weight: bold;



}



-->


.ac_results{
width:inherit !important;
}
.ac_results > ul{
height:250px;
}


</style>







<div class="form-container_large">



<form action="<?=$page?>" method="post" name="codz2" id="codz2">



<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">



  <tr>



    <td width="33%"><fieldset  class="resp">



    <div>



      <label style="width:81px;">Order No : </label>







      <input   name="do_no" type="text" id="do_no" value="<? if($$unique_master>0) echo $$unique_master; else echo (find_a_field($table_master,'max('.$unique_master.')','1')+1);?>" readonly/>
    </div>



    <div>



      <label style="width:81px;">Customer : </label>



        <select  id="dealer_code" name="dealer_code" readonly="readonly">



        <option value="<?=$dealer->dealer_code;?>"><?=$dealer->dealer_code.'-'.$dealer->dealer_name_e;?></option>
        </select>
    </div>

	



      <div>



        <label style="width:81px;">Area : </label>



        <input   name="wo_detail2" type="text" id="wo_detail2" value="<?=$dealer->area_name?>" readonly/>
      </div>



      <div>



        <label style="width:81px;">Zone : </label>



        <input   name="wo_detail" type="text" id="wo_detail" value="<?=$dealer->zone_name?>" readonly/>
      </div>



        <div>



        <label style="width:81px;">Region : </label>



        <input  name="wo_detail" type="text" id="wo_detail" value="<?=$dealer->region_name?>" readonly/>
        </div>



        <div>



          <label style="width:81px;">Depot : </label>



          <select  id="depot_id" name="depot_id" readonly="readonly">

            <option value="<?=$dealer->depot;?>">

              <?=find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot'])?>
              </option>
          </select>

		  

		 <!--<input style="width:155px;"  name="wo_detail" type="text" id="wo_detail" value="<?=$depot_id?>" readonly="readonly"/>-->
        </div>
		<div>
              <label style="width:81px;">View PDF</label>
          <a href="do_pdf.php?file_name=<?=$do_file?>" target="_blank" style="color:#9933CC;">View PDF</a>
            </div>



    </fieldset></td>



    <td width="33%">



			<fieldset class="resp">



			  <div>



			    <label style="width:113px;">Order Date : </label>



			    <input   name="do_date" type="text" id="do_date" value="<?=($do_date!='')?$do_date:date('Y-m-d')?>" />
		      </div>



		<?php /*?>	<div>



			<label style="width:113px;">Undel Amt : </label> 



            <?



            



			?>



			<input   name="wo_subject" type="text" id="wo_subject" value="<? echo $av_amt=(find_a_field_sql('select sum(total_amt) from sale_do_details where  	dealer_code='.$dealer->dealer_code.' and status!="COMPLETED"')-find_a_field_sql('select sum(total_amt) from sale_do_chalan where  	dealer_code='.$dealer->dealer_code.' and status!="COMPLETED"'))?>" readonly/>
			</div><?php */?>



			<?php /*?><div>



			<label style="width:113px;">Credit Limit : </label> 



			<input  name="wo_subject" type="text" id="wo_subject" value="<?=$dealer->credit_limit?>" readonly/>
			</div>

<?php */?>

<?php /*?>			<div>



			  <label style="width:113px;">Available Amt : </label>



            <input name="thickness" type="text" id="thickness" value="<? echo $av_amt=find_a_field_sql('select sum(dr_amt)-sum(cr_amt) from journal where ledger_id='.$dealer->account_code)?>" readonly/>
			</div>



            <div>



			  <label style="width:113px;">Order Limit : </label>



            <input   name="thickness" type="text" id="thickness" value="" readonly/>
			</div><?php */?>

	  <div>

			    <label style="width:113px;">Delivery Request Date : </label>

			    <input   name="delivery_req_date" type="text" id="delivery_req_date" value="<?=$delivery_req_date?>" required autocomplete="off"/>
		      </div>

            <div>



              <label style="width:113px;">Address: </label>



              <input name="delivery_address" type="text" id="delivery_address"  value="<? if($delivery_address!='') echo $delivery_address; else echo $dealer->address_e?>" />
            </div>
			<div>



        <label style="width:113px;">VAT: </label>



        

		<input   name="cash_discount" type="text" id="cash_discount" value="<?=$vat?>" />
      </div>
        </fieldset>	</td>



    
  </tr>



  <tr>
    <td colspan="3"><div align="center"></div></td>
  </tr>
  <tr>



    <td colspan="3">



	<? if($dealer->canceled=='Yes'){?>
		<div class="buttonrow" style="margin-left:240px;"><span class="buttonrow" style="margin-left:240px;">
		  <? if($$unique_master>0) {?>
          <input name="new" type="submit" class="btn1" value="Update Demand Order" style="width:200px; font-weight:bold; font-size:12px; tabindex="12>
          <input name="flag" id="flag" type="hidden" value="1" />
          <? }else{?>
          <input name="new" type="submit" class="btn1" value="Initiate Demand Order" style="width:200px; font-weight:bold; font-size:12px;" tabindex="12" />
          <input name="flag" id="flag" type="hidden" value="0" />
          <? }?>
        </span></div>
        <? }elseif($dealer->canceled=='No'){?>
		<table width="40%" border="0" align="center" cellpadding="5" cellspacing="0">
          <tr>
            <td bgcolor="#FF3333"><div align="center" class="style1">DEALER IS BLOCKED </div></td>
          </tr>
        </table>
<? }else{?>
		<table width="40%" border="0" align="center" cellpadding="5" cellspacing="0">
          <tr>
            <td bgcolor="#FF3333"><div align="center" class="style1">DEALER NOT FOUND</div></td>
          </tr>
        </table>
<? }?>	</td>
    </tr>
</table>



</form>



<form action="<?=$page?>" method="post" name="codz" id="codz" >



<? if($$unique_master>0){?>



<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="0" cellspacing="2">



                      <tr>
                        <td align="center" style="width:0;" bgcolor="#0099FF"><strong>Item Code</strong></td>
                        <td align="center" bgcolor="#0099FF"><table width="100%" border="1" cellspacing="0" cellpadding="0">
                      <tr>
<td align="center" bgcolor="#0099FF" width="27%"><strong>Item Name</strong></td>

<td align="center" bgcolor="#0099FF" width="10%"><strong>In Stk</strong></td>
<td align="center" bgcolor="#0099FF" width="9%" ><strong>Qty</strong></td>
<td align="center" bgcolor="#0099FF" width="9%"><strong>Unit</strong></td>
<td align="center" bgcolor="#0099FF" width="9%"><strong>Price</strong></td>

<td align="center" bgcolor="#0099FF" width="9%" ><strong>Sec Qty</strong></td>
<td align="center" bgcolor="#0099FF" width="9%" ><strong>Sec Unit</strong></td>
<td align="center" bgcolor="#0099FF" width="12%"><strong>Total</strong></td>
                          </tr>
                        </table></td>



                        <td  rowspan="2" align="center" bgcolor="#FF0000"><div class="button">
      <input name="add" type="submit" id="add" value="ADD"  class="update"  tabindex="5"/>
                        </div></td>
      </tr>
                      <tr>
<td align="center" bgcolor="#CCCCCC">
<span id="inst_no">
<span id="inst_no">
<input name="item" type="text" class="input3" id="item"  style="width:80px; background-color:white;" required onblur="grp_check(this.value);" tabindex="1"/>
</span>
<input name="do_no" type="hidden" id="do_no" value="<?=$do_no;?>" readonly/>
<input name="group_for" type="hidden" id="group_for" value="<?=$dealer->product_group;?>" readonly/>
<input name="dealer_code" type="hidden" id="dealer_code" value="<?=$dealer->dealer_code;?>"/>
<input name="depot_id" type="hidden" id="depot_id" value="<?=$depot_id;?>"/>
<input name="flag" id="flag" type="hidden" value="1" />
</span>
<input style="width:10px;"  name="group_for" type="hidden" id="group_for" value="<?=$dealer->product_group;?>" readonly/></td>
<td bgcolor="#CCCCCC">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
 <tr>
    <td bgcolor="#CCCCCC">
	<span id="do"><table width="100%" border="0" cellspacing="0" cellpadding="0">
	
  <tr>
<td><input name="item2" type="text" class="input3" id="item2"  style="width:227px;margin-right: -50px;" required="required" tabindex="3" value="<?=$item_all->item_name?>" onfocus="focuson('dist_unit')"/></td>
  <td><input name="in_stock"  type="text" class="input3" id="in_stock"  style="width:60px;" value="<?=$in_stock?>" readonly onfocus="focuson('dist_unit')"/>
  
   <td><input name="dist_unit" type="text" class="input3" id="dist_unit" style="width:55px;" onkeyup="count();dope_count()" /></td>
   
   
  <input name="unit_price2" type="hidden" class="input3" id="unit_price2"  style="width:60px;"  value="<?=$item_all->item_id?>" readonly/></td>
  
  
 <input name="item_id" type="hidden" class="input3" id="item_id"  style="width:60px;"  value="<?=$item_all->item_id?>" readonly/></td>
  <td><input name="in_stock"  type="text" class="input3" id="in_stock"  style="width:60px;" value="<?=$in_stock?>" readonly onfocus="focuson('dist_unit')"/>
 <input name="item_id" type="hidden" class="input3" id="item_id"  style="width:60px;"  value="<?=$item_all->item_id?>" readonly/></td>
 
 
 
  <td><input name="unit_price" type="text" class="input3" id="unit_price"  style="width:55px;" onkeyup="count()" value="<?=$item_all->d_price?>" />
  <input name="pkt_size" type="hidden" class="input3" id="pkt_size"  style="width:55px;"  value="<?=$item_all->pack_size?>" readonly/></td>
  </tr>
  </table>
  
  
    </span>
	
	</td>
	
	
  <td bgcolor="#CCCCCC"><table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
     <input name="pkt_unit" type="hidden" value="0" readonly class="input3" id="pkt_unit" style="width:55px;" onkeyup="count()" required="required"  tabindex="4"/>
      <td>
	   <input name="unit_name" type="hidden" class="input3" id="unit_name"  style="width:60px;"  value="<?=$item_all->unit_name?>" readonly/></td>

	  <td><input name="dope_qty" type="text" value="" class="input3" id="dope_qty" style="width:55px;" readonly /></td>
	  
	   <td><input name="sec_unit" type="text" value="" class="input3" id="sec_unit" style="width:55px;" readonly /></td>
	   
      <td><input name="total_unit" type="hidden" class="input3" id="total_unit"  style="width:55px;" readonly/>
  <input name="total_amt" type="text" class="input3" id="total_amt" style="width:70px;" readonly/></td>
      </tr>
  </table></td>
  </tr>
  </table></td>

</tr>

    </table>

					  <br /><br /><br /><br />
</form>

<form action="" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">

<? 



$res='select a.id,b.finish_goods_code as code,b.item_name,a.unit_price as price,a.dist_unit as qty ,a.do_no,a.total_amt,"X" from sale_do_details a,item_info b where b.item_id=a.item_id and a.do_no='.$$unique_master.' order by a.id';

$query44=mysql_query($res);



?>



<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><div class="tabledesign2">
	     <span id="codzList">
		 
		
		 
       <table width="100%">
		<thead>
			<tr>
				<th>S/L</th>
				<th>Code</th>
				<th>Item Name</th>
						<th>Quantity</th>
				<th>Price</th>
		
				<th>Total</th>
				<th>X</th>
			</tr>
		</thead>
		
		<tbody>
	<?php	
	$i=1;
	
	while($data=mysql_fetch_object($query44)){
		
		?>
			<tr>
				<td><?=$i++ ?></td>
				<td><?=$data->code ?></td>
				<td><?= $data->item_name?></td>
				<td><input  style="width:95px !important" type="text" name="edit_qty_<?=$data->id?>" id="edit_qty_<?=$data->id?>" value="<?=$data->qty ?>"  onkeyup="total_count(<?=$data->id?>)"/></td>
<td><input style="width:95px !important" type="text" name="edit_price_<?=$data->id?>" id="edit_price_<?=$data->id?>"value="<?=$data->price ?>" onkeyup="total_count(<?=$data->id?>)"/></td>

				<td><input style="width:95px !important" type="text" name="edit_total_<?=$data->id?>" id="edit_total_<?=$data->id?>"value="<?= $data->total_amt?>" disabled/></td>
				
				<td><a href="?del_id=<?=$data->id?>&do_no=<?=$data->do_no?>">X</a></td>
				
			</tr>
		<?php } ?>
		</tbody>
	</table>
         </span>
      </div></td>



    </tr>



	    	



	







				



    <tr>



     <td>







 </td>



    </tr>



  </table>





<br />


<table width="100%" border="0">



  <tr>



      <td align="center">



      <input name="delete"  type="submit" class="btn1" value="DELETE DO" style="width:100px; font-weight:bold; font-size:12px;color:#F00; height:30px" />



      <input  name="do_no" type="hidden" id="do_no" value="<?=$$unique_master?>"/></td><td align="right" style="text-align:right">



      <input name="confirm" type="submit" class="btn1" value="CONFIRM AND SEND WORK ORDER" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:#090; float:right" />



      </td>



      



    </tr>



</table>











<? }?>



</form>



</div>



<script>
	function dope_count(){
	  var dist_unit = ((document.getElementById('dist_unit').value)*1);
	  var dope_unit =  ((document.getElementById('carton_qty').value)*1);
	  var dop_per_piece = (1/dope_unit);
	  var dop_qty = (dist_unit*dop_per_piece);
	  document.getElementById('dope_qty').value = dop_qty.toFixed(2);
	  
	}
</script>


<?



$main_content=ob_get_contents();



ob_end_clean();



include ("../../template/main_layout.php");



?>