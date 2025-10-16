<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$depot=$_SESSION['user']['depot'];

$title='Sales Requisition Create';

do_calander('#est_date');

do_calander('#do_date');

$page = 'do.php';

$depot_id = $_POST['depot_id'];

if($_POST['dealer']>0) 

$dealer_code = $_POST['dealer'];

$dealer = find_all_field('dealer_info','','dealer_code='.$dealer_code);

//$depot_id = find_a_field('warehouse','warehouse_name','warehouse_id='.$dealer->depot);

$table_master='sale_requisition_master';

$unique_master='do_no';

$table_detail='sale_requisition_details';

$unique_detail='id';

if($_REQUEST['old_do_no']>0)

$$unique_master=$_REQUEST['old_do_no'];

elseif(isset($_GET['del']))

{$$unique_master=find_a_field('sale_requisition_details','do_no','id='.$_GET['del']); $del = $_GET['del'];}

else

$$unique_master=$_REQUEST[$unique_master];

if(prevent_multi_submit()){

if(isset($_POST['new']))

{
		$crud   = new crud($table_master);

		$_POST['entry_at']=date('Y-m-d H:i:s');

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



auto_complete_start_from_db('item_info','concat(finish_goods_code)','finish_goods_code','product_nature="Salable" order by finish_goods_code ASC','item');



?>



<script language="javascript">



function count()



{




var unit_price = ((document.getElementById('unit_price').value)*1);

var dist_unit = ((document.getElementById('dist_unit').value)*1);


var total_unit = dist_unit;



var total_amt  = (total_unit*unit_price);



document.getElementById('total_unit').value=total_unit;



document.getElementById('total_amt').value	= total_amt.toFixed(2);



var do_total = ((document.getElementById('do_total').value)*1);



var do_ordering	= total_amt+do_total;



document.getElementById('do_ordering').value =do_ordering.toFixed(2);





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
$("#total_amt").val('');

}
});	

//}else{ alert('Please Enter Debit Ledger'); }
//}else{ alert('Please check Ledger,amount and Date'); }

  }
/////-=============-------========-------------Ajax  Voucher Entry---------------===================-------/////////


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



//$query_i=db_query($sql_i);



//while($is=mysqli_fetch_object($query_i))



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

<script language="javascript">

	function type_check(){
	var type = document.getElementById('vat_type').value;
		if(type == 1){
			var vat = document.getElementById('vat_div');
			
			vat.style.display = 'block';	
		}
		else if (type==2){
			var ait = document.getElementById('ait_div');
			
			ait.style.display = 'block';	
		}
		else if (type==3){
			var vat_ait = document.getElementById('vat_ait_div');
			
			vat_ait.style.display = 'block';	
		}
	}
</script>

<style type="text/css">



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



    <td width="33%"><fieldset >



    <div>



      <label style="width:81px;">Quo. No : </label>







      <input   name="do_no" type="text" id="do_no" value="Q-<? if($$unique_master>0) echo $$unique_master; else echo (find_a_field($table_master,'max('.$unique_master.')','1')+1);?>" readonly/>
    </div>



    <div>



      <label style="width:81px;">Dealer : </label>



        <select  id="dealer_code" name="dealer_code" readonly="readonly">



        <option value="<?=$dealer->dealer_code;?>"><?=$dealer->dealer_code.'-'.$dealer->dealer_name_e;?></option>
        </select>
    </div>

		<div>



      <label style="width:81px;">Attn : </label>



        <input type="text" id="attn" name="attn" value="<? if($attn=='') echo $dealer->propritor_name_e; else echo $attn;?>">
    </div>


	 <div>



      <label style="width:81px;">Req No : </label>



        <input type="text" id="ref_no" name="ref_no" value="<?=$ref_no?>">
    </div>
      



      



        



        <div>



          <label style="width:81px;">Warehouse:</label>



          <select  id="depot_id" name="depot_id" readonly="readonly">

            <option value="<?=$dealer->depot;?>">

              <?=find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot'])?>
              </option>
          </select>

		  

        </div>
		
		 <div>



          <label style="width:81px;">Sale Type : </label>



          <select  id="sale_type" name="sale_type" readonly="readonly">

            <option value="Regular">Receivable
              </option>
          </select>

		  

        </div>

 
    </fieldset></td>



    <td width="33%">



			<fieldset >



			  <div>



			    <label style="width:113px;">Req. Date : </label>



			    <input   name="do_date" type="text" id="do_date" value="<?=($do_date!='')?$do_date:date('Y-m-d')?>" />
		      </div>



			



			
		<div>



              <label style="width:113px;">VAT Type: </label>

				<select  id="vat_type" name="vat_type" onchange="type_check()">

 
				<option></option>
              <? foreign_relation('vat_type','id','vat_name',$vat_type,'1');?>
              </option>
          </select>

              
            </div>


			



            



            <div id="vat_div" style="display:<? if( $vat >0 ) echo "block"; else echo "none"; ?>">



              <label style="width:113px;">VAT (%): </label>



              <input name="vat" type="text" id="vat"  value="<?=$vat;?>" />
            </div>
			<div id="ait_div" style="display:<? if( $ait >0 ) echo "block"; else echo "none"; ?>">



              <label style="width:113px;">AIT (%): </label>



              <input name="ait" type="text" id="ait"  value="<?=$ait;?>" />
            </div>
			
			
			<div id="vat_ait_div" style="display:<? if( $vat_ait >0 ) echo "block"; else echo "none"; ?>">



              <label style="width:113px;">VAT & AIT (%): </label>



              <input name="vat_ait" type="text" id="vat_ait"  value="<?=$vat_ait;?>" />
            </div>
			
			<div>

              <label style="width:113px;">Discount (%): </label>


              <input name="discount" type="text" id="discount"  value="<?=$discount;?>" />
            </div>
        </fieldset>	</td>



    <td width="33%"><fieldset>


		<div>

          <label style="width:120px;">Concern: </label>



          <select  id="group_for" name="group_for" readonly="readonly">

 

              <? foreign_relation('user_group','id','group_name',$id,'1');?>
              </option>
          </select>

		  

        </div>

		<div>

          <label style="width:120px;">Deduct: </label>



         <input name="cash_discount" type="text" id="cash_discount"  value="<?=$cash_discount;?>" />
		  

        </div>
            





      <div>



        <label style="width:120px;">Note: </label>



        <input name="remarks" type="text" id="remarks"  value="<?=$remarks?>" tabindex="105" />
      </div>

	  
	<div>



        <label style="width:120px;">Is Included: </label>



        <input type="checkbox" name="is_included" id="is_included" value="1" <? if($is_included==1) echo "checked='checked'"; ?> >
      </div>
	  



    </fieldset>  </td>
	

	
  </tr>


  
  <tr>



    <td colspan="3">







		<div class="buttonrow" style="margin-left:240px;"><span class="buttonrow" style="margin-left:240px;">
		  <? if($$unique_master>0) {?>
          <input name="new" type="submit" class="btn1" value="Update Demand Order" style="width:200px; font-weight:bold; font-size:12px; tabindex="12>
          <input name="flag" id="flag" type="hidden" value="1" />
          <? }else{?>
          <input name="new" type="submit" class="btn1" value="Initiate New Order" style="width:200px; font-weight:bold; font-size:12px;" tabindex="12" />
          <input name="flag" id="flag" type="hidden" value="0" />
          <? }?>
        </span></div>



	</td>
    </tr>
</table>



</form>



<form action="<?=$page?>" method="post" name="codz" id="codz">



<? if($$unique_master>0){?>



<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="0" cellspacing="2">



                      <tr>


                 <!--           <td align="left";><?=$msgg?></td>-->
                            <td colspan="3" align="right" bgcolor="#009966" style="text-align:right"><strong>Total Ordering: 



                            </strong>



<?



$total_do = find_a_field($table_detail,'sum(total_amt)',$unique_master.'='.$$unique_master);



?>



					  <input type="text" name="do_ordering" id="do_ordering" value="<?=$total_do-($total_do*$dealer->commission/100)?>" style="float:right; width:100px;" disabled="disabled" readonly />



					  <input type="hidden" name="do_total" id="do_total" value="<?=$total_do?>" />&nbsp;</td>

      </tr>



                      <tr>



                        <td align="center" bgcolor="#0099FF"><strong>Item Code</strong></td>



                        <td align="center" bgcolor="#0099FF"><table width="100%" border="1" cellspacing="0" cellpadding="0">



                          <tr>



<td align="center" bgcolor="#0099FF" width="35%"><strong>Item <span>Description</span></strong></td>



<td align="center" bgcolor="#0099FF" width="10%"><strong>In Stk</strong></td>



<td align="center" bgcolor="#0099FF" width="9%"><strong>Unit</strong></td>



<td align="center" bgcolor="#0099FF" width="8%"><strong>Price</strong></td>
<td align="center" bgcolor="#0099FF" width="9%"><strong>Qty</strong></td>



<td align="center" bgcolor="#0099FF" width="12%"><strong>Total</strong></td>
                          </tr>



                        </table></td>



                        <td  rowspan="2" align="center" bgcolor="#FF0000"><div class="button">



                          <input name="add" type="button" id="add" value="ADD" onclick="count();insert_item()" class="update" tabindex="5"/>



                        </div></td>

      </tr>



                      <tr>



<td align="center" bgcolor="#CCCCCC">



<span id="inst_no">

<span id="inst_no">

<input name="item" type="text" class="input3" id="item"  style="width:180px; background-color:white;" required onblur="grp_check(this.value);" tabindex="1"/>

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



    <td bgcolor="#CCCCCC"><span id="do"><table width="100%" border="0" cellspacing="0" cellpadding="0">

<?php /*?><?php */?>

  <tr>



  <td><input name="item2" type="text" class="input3" id="item2"  style="width:260px;" required="required" tabindex="3" value="" onfocus="focuson('dist_unit')"/></td>



  <td><input name="in_stock"  type="text" class="input3" id="in_stock"  style="width:55px;" value="<?=$in_stock?>" readonly onfocus="focuson('dist_unit')"/>



  <input name="item_id" type="hidden" class="input3" id="item_id"  style="width:55px;"  value="<?=$item_all->item_id?>" readonly/></td>

  <td><input name="unit_price" type="text" class="input3" id="unit_price"  style="width:55px;" onchange="count()" value="<?=$item_all->d_price?>" />
  <input name="pkt_size" type="hidden" class="input3" id="pkt_size"  style="width:55px;"  value="<?=$item_all->pack_size?>" readonly/></td>
  
  <td><input name="unit_price" type="text" class="input3" id="unit_price"  style="width:55px;" onchange="count()"  />
 </td>
  </tr>



      </table>
    </span></td>



  <td bgcolor="#CCCCCC"><table width="100%" border="0" cellspacing="0" cellpadding="0">



    <tr>


      



      <td><input name="dist_unit" type="text" class="input3" id="dist_unit" style="width:55px;" onkeyup="count()" /></td>
      <td><input name="total_unit" type="hidden" class="input3" id="total_unit"  style="width:55px;" onkeyup="count()" readonly/>



        <input name="total_amt" type="text" class="input3" id="total_amt" style="width:70px;" readonly/></td>
      </tr>



  </table></td>

  </tr>

  </table></td>

</tr>

    </table>

					  <br /><br /><br /><br />


<? 



 $res='select a.id,b.finish_goods_code as item_code,a.item_description,a.unit_price as price,a.dist_unit as qty ,a.total_amt,"X" from sale_requisition_details a,item_info b where b.item_id=a.item_id and a.do_no='.$$unique_master.' order by a.id';



?>



<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><div class="tabledesign2">
	     <span id="codzList">
        <? 
             echo link_report_add_del_auto($res,'',6);
		?>
         </span>
      </div></td>



    </tr>



	    	



	







				



    <tr>



     <td>







 </td>



    </tr>



  </table>







</form>



<form action="select_dealer_do.php" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">



<table width="100%" border="0">



  <tr>



      <td align="center">



      <input name="delete"  type="submit" class="btn1" value="DELETE " style="width:100px; font-weight:bold; font-size:12px;color:#F00; height:30px" />



      <input  name="do_no" type="hidden" id="do_no" value="<?=$$unique_master?>"/></td><td align="right" style="text-align:right">



      <input name="confirm" type="submit" class="btn1" value="CONFIRM AND SEND" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:#090; float:right" />



      </td>



      



    </tr>



</table>











<? }?>



</form>



</div>






<?



//



//



require_once SERVER_CORE."routing/layout.bottom.php";



?>