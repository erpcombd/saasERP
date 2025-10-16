<?php
//

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');
$str = $_POST['data'];
$data=explode('##',$str);
$order_no = $data[1];

 $lc_ltr_ledger = $data[0];


//$lc_ltr_amount = find_a_field('lc_ltr_loan','ltr_amount','ledger_id="'.$lc_ltr_ledger.'"');

?>



<? if($lc_ltr_ledger>0) {?>
<input style="width:80%; height:30px;"  name="loan_amt" type="text" id="loan_amt" value=""  required />
<? }else {?>
<input style="width:80%; height:30px;"  name="loan_amt" type="text" id="loan_amt" value=""  readonly="" />
<? }?>		
	