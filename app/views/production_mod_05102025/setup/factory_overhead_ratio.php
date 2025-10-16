<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

do_calander("#to_date");

do_calander("#from_date");





error_reporting(E_ERROR | E_WARNING | E_PARSE);



$title='Factory Overhead Setup';

$proj_id=$_SESSION['proj_id'];

$now=time();



if(isset($_POST['add'])){

$cd= new crud('factory_overhead');

$_POST['entry_by']=$_SESSION['user']['id'];

$_POST['entry_at']=date("Y-m-d H:i:s");


foreach ($_POST['forLoop'] as $fordata){


 $_POST['ledger_id']=$fordata;

 $_POST['ratio']=$_POST['ratio_'.$_POST['ledger_id']];


 if( $_POST['ratio']>0){


    $exist=find_a_field('factory_overhead','id','ledger_id="'.$_POST['ledger_id'].'"');
	
	if($exist>0){

 $up='update factory_overhead set ratio="'.$_POST['ratio'].'" where id='.$exist;
db_query($up);


}else{

  $cd->insert();
  }
  
  
  }
  //check
  }
  

echo "<script>window.top.location='factory_overhead_ratio.php'</script>";
  
  }
?>



<style type="text/css">



<!--



.style2 {



	color: #0000FF;



	font-weight: bold;



}



.style3 {



	color: #006600;



	font-weight: bold;



}



.style4 {



	color: #FFFFFF;



	font-weight: bold;



}



.style5 {



	color: #000033;



	font-weight: bold;



}

.style6 {color: #FFFFFF}



-->



</style>

<?
$sql='select ledger_id,ratio from factory_overhead';
$query=db_query($sql);
while($data=mysqli_fetch_object($query)){

$val[$data->ledger_id]=$data->ratio;
}
?>


	<form id="form2" name="form2" method="post" action="">





		<div class="row justify-content-center">
		
		<div class="col-8">



			<table class="table1  table-striped table-bordered table-hover table-sm">

				<thead class="thead1">

				<tr class="bgc-info">

					<th>SL</th>

					<th>Ledger Name</th>

					<th>Ratio(%)</th>

				</tr>

				</thead>



				<tbody class="tbody1" id="ress">
		<!--		<tr><td colspan="3" style="font-size:25px">Labor Cost</td></tr>
				<?
				 $sql='select ledger_id,ledger_name from accounts_ledger where ledger_group_id in(0) order by ledger_group_id';
				
				$query=db_query($sql);
				$i=1;
				while($data=mysqli_fetch_array($query)){
				
				?>
				
				<tr>
				<td><?=$i++?></td>
				<input name="forLoop[]"  value="<?=$data[0]?>" type="hidden" />
				<input name="ledger_id" id="ledger_id" value="<?=$data[0]?>" type="hidden" />
				<td><input name="ledger_name" id="ledger_name" value="<?=$data[1]?>" type="text" readonly /></td>
				<td><input name="ratio_<?=$data[0]?>" id="ratio_<?=$data[0]?>" value="<?=$val[$data[0]]?>" type="text" /></td>
				</tr>
				
				<? }?>-->
				<tr><td colspan="3" style="font-size:25px">Factory Overhead </td></tr>
				<?
				 $sql='select ledger_id,ledger_name from accounts_ledger where ledger_group_id in(411010) order by ledger_group_id';
				
				$query=db_query($sql);
				$i=1;
				while($data=mysqli_fetch_array($query)){
				
				?>
				<tr>
				<td><?=$i++?></td>
				<input name="forLoop[]"  value="<?=$data[0]?>" type="hidden" />
				<input name="ledger_id" id="ledger_id" value="<?=$data[0]?>" type="hidden" />
				<td><input name="ledger_name" id="ledger_name" value="<?=$data[1]?>" type="text" readonly /></td>
				<td><input name="ratio_<?=$data[0]?>" id="ratio_<?=$data[0]?>" value="<?=$val[$data[0]]?>" type="text" /></td>
				</tr>
				
				<? }?>
		<tr style="font-size:25px"><td colspan="2" style="font-size:25px">Total </td><td align="left"><?=find_a_field('factory_overhead','sum(ratio)','1')?>%</td></tr>
				</tbody>

			</table>

		</div>
		
		</div>
		
		<br /><br /><br />
<div class="text-center">



<input type="submit" class="btn btn-success" name="add" value="Set Ratio" />

</div>



</div>


	</form>

<script>

$(document).ready(function() {



  $("#item_groups").change(function() {

  

	var group= $(this).val();

	var to_date=$('#to_date').val();

	var from_date=$('#from_date').val();
	
	var sales_person=$('#sales_person').val();

	

	

	$.ajax({

		  url: "do_item_ajax.php",

		  type: "POST",

		  data: {group:group,to_date:to_date,from_date:from_date,sales_person:sales_person},

		  success: function(data){

		$("#ress").html(data);

 		 }

	});

	

	

  });

  











   $("#balance").keyup(function() {

  

    var balance= $(this).val()*1;

	

	var up_balance=$('#up_balance').val()*1;

	

	$('#tot_balance').val(balance+up_balance);

  

  });

  

    $("#up_balance").keyup(function() {

  

    var balance= $(this).val()*1;

	

	var up_balance=$('#balance').val()*1;

	

	$('#tot_balance').val(balance+up_balance);

  

  });

  

  

    $("#region").change(function() {

  

	var leftPart= $(this).val();

	

	var  region_id= leftPart.split("<#")[0];


	$.ajax({

		  url: "reg_data_ajax.php",

		  type: "POST",

		  data: {region_id:region_id},

		  success: function(data){

		$("#dndm").html(data);

 		 }

	});

	

	

	

  });  

  

      $("#area").change(function() {

  

	var leftPart= $(this).val();

	

	var  area_id= leftPart.split("<#")[0];


	$.ajax({

		  url: "reg_data_ajax.php",

		  type: "POST",

		  data: {area_id:area_id},

		  success: function(data){

		$("#dndm").html(data);

 		 }

	});

	

	

	

  }); 

  

  

  

});




</script>






<?



require_once SERVER_CORE."routing/layout.bottom.php";




?>



