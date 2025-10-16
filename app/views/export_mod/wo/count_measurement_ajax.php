<?php


//



 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


@ini_set('error_reporting', E_ALL);


@ini_set('display_errors', 'Off');


$str = $_POST['data'];


$data=explode('##',$str);


  $count_id=$data[0];
  
   $pack_type=$data[1];
  
  // $additional_exp=explode('->',$additional);
   
  // $additional_id=$additional_exp[0];
  
  
  $count_data=find_all_field('count_measurement','',"id=".$count_id);
  
  if($pack_type=="DTM") {
  $unit_price=$count_data->price_dtm;
  }else{
  $unit_price=$count_data->price_white;
  }


?>


<input  name="unit_price" type="text" class="input3" id="unit_price" style="width:60px; height:30px;"  readonly="" value="<?=$unit_price?>" 
onkeyup="TRcalculation()"/>

<input  name="count" type="hidden" class="input3" id="count" style="width:60px; height:30px;"  readonly="" value="<?=$count_data->count?>" />
<input  name="length_unit" type="hidden" class="input3" id="length_unit" style="width:60px; height:30px;"  readonly="" value="<?=$count_data->uom?>" />
<input  name="length" type="hidden" class="input3" id="length" style="width:60px; height:30px;"  readonly="" value="<?=$count_data->measurement?>" />






