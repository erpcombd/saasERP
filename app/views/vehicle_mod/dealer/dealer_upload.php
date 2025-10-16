<?php

session_start();
ob_start();
require_once "../../../assets/template/layout.top.php";
$title='Customer Info Upload';
do_calander('#chalan_date');



function next_ledger_ids($group_id)

{

$max=($group_id*1000000000000)+1000000000000;

$min=($group_id*1000000000000)-1;

$s='select max(ledger_id) from accounts_ledger where ledger_id>'.$min.' and ledger_id<'.$max;

$sql=mysql_query($s);

if(mysql_num_rows($sql)>0)

$data=mysql_fetch_row($sql);

else

$acc_no=$min;

if(!isset($acc_no)&&(is_null($data[0]))) 

$acc_no=$cls;

else

$acc_no=$data[0]+100000000;

return $acc_no;

}




$con="";

$rt[] = "";


$table_master='dealer_info';



$unique_master='dealer_code';


$unique_detail='dealer_code';

if(prevent_multi_submit()){







if(isset($_POST['done'])){
		
		$filename=$_FILES["item_details"]["tmp_name"];
     	if($_FILES["item_details"]["size"] > 0){

		      $file = fopen($filename, "r");

			  $count = 0;
			   $acc=(1003000100000000);

          	  while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)

           	  {
			 $acc=($acc+100000000);
  $acc_query='INSERT INTO accounts_ledger(ledger_id, ledger_name, ledger_group_id, opening_balance, balance_type, depreciation_rate, credit_limit, opening_balance_on, proj_id, budget_enable, group_for, parent, acc_code, ledger_type) 



VALUES ("'.$acc.'","'.$getData[1].'",1003,0.00,"Both", 0.00, 0.00,'.strtotime(date("Y-m-d H:i:s")).',"Habib","NO", 2, 0, 0, 0)';

mysql_query($acc_query);
	

			$count++; 

			  $msg= "";

			  if($count>1) {



//account ledger create



		$crud   = new crud('dealer_info');
		//item id create
$dealer_type= find_a_field('dealer_type','id','dealer_type="'.$getData[2].'"');	


	if($getData[0]!=''){
	

	

		$_POST['dealer_code'] = $getData[0];
		$_POST['dealer_name_e'] = $getData[1];

		$_POST['dealer_type'] = $dealer_type;

		$_POST['contact_person'] = $getData[3];

		$_POST['designation'] = $getData[4];
		$_POST['mobile_no'] = $getData[5];
		$_POST['zone_name'] = $getData[6];
		$_POST['region_name'] = $getData[7];
		$_POST['area_name'] = $getData[8];
		$_POST['address_e'] = $getData[9];
		$_POST['account_code'] = $acc;


		
		$crud->insert();



				}	



			  } 



			  }



			  fclose($file);  



			  }





}






	
	} else {



	$type=0;



	$msg='Data Re-Submit Warning!';



}



?>



<script language="javascript">







function cal_par(id){



    var arr = $("#parcel_qty_"+id).val();



    var tot=0;



    for(var i=0;i<arr.length;i++){



        if(parseInt(arr[i].value))



            tot += parseInt(arr[i].value);



    }



   $("#tot_par").html(tot);



}



</script>

<div class="form-container_large">



<form action="" method="post" name="codz" id="codz"  enctype="multipart/form-data"  >



  <table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">




    <tr>



      <td colspan="5"><table width="100%" border="0" cellspacing="0" cellpadding="0">


        <tr>

          <td align="right" bgcolor="#fff">&nbsp;</td>

          <td align="right" bgcolor="#fff">&nbsp;</td>

          <td colspan="2" bgcolor="#fff">

		  

		  

		    <input type="file" name="item_details" id="item_details" style="height: 35px;">



  (<a target="_blank" href="export_csv.php?req_id=<?=$_REQUEST['req_id']?>&del_mode=courier">Click here</a> to download format)

		  <input type="submit" name="done" style="height:30px;" value="Submit" class="btn1" />		  </td>

          <td bgcolor="#fff">&nbsp;</td>

          <td bgcolor="#fff">&nbsp;</td>
        </tr>

        <tr>



          <td align="right" bgcolor="#fff">&nbsp;</td>



          <td align="right" bgcolor="#fff">&nbsp;</td>



          <td bgcolor="#fff">&nbsp;</td>



          <td align="right" bgcolor="#fff">&nbsp;</td>



          <td bgcolor="#fff">&nbsp;</td>



          <td bgcolor="#fff">&nbsp;</td>
        </tr>



      </table></td>
    </tr>
  </table>



  <? if($_REQUEST['req_id']>0){?>




</form>







<? }?>



</div>

<script>
function cal2(id){
var undel_qty = parseFloat($("#undeldist_"+id).val());
var del_qty = parseFloat($("#chalan2_"+id).val());
var left_qty = undel_qty - del_qty;

if(left_qty<0){
$("#left_qty_"+id).val("HI");
$("#chalan2_"+id).css("border", "1px solid red");
alert_msg.html("<p style='color:red'>Invalid Value</p>");
}else if(left_qty>=0){
$("#left_qty_"+id).val("bye");
$("#chalan2_"+id).css("border", "0px solid black");
alert_msg.html("");

		}
	}

</script>





<?



$main_content=ob_get_contents();



ob_end_clean();



require_once "../../template/main_layout.php";




?>