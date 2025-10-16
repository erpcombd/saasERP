<?php

session_start();

ob_start();

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$title='Select Dealer Return Order';



$page_for = 'Return';

do_calander('#or_date');

do_calander('#quotation_date');





$table_master='sales_damage_receive_master';

$table_details='sales_damage_receive_detail';

$unique='or_no';

if(isset($_SESSION[$unique]))

unset($_SESSION[$unique]);

$$unique = $_POST[$unique];

if(prevent_multi_submit()){

if(isset($_POST['confirmm']))

{

		//unset($_POST);

		$_POST[$unique]=$$unique;

		$_POST['entry_by']=$_SESSION['user']['id'];

		$_POST['entry_at']=date('Y-m-d h:i:s');

		
		$_POST['status']='UNCHECKED';

		$crud   = new crud($table_master);

		$crud->update($unique);
	
		
		//auto_insert_damage_return_secoundary_new($$unique);
		
	 $sql="select * from sales_damage_receive_detail where or_no='".$$unique."'";
		
		$data = db_query($sql);
		
		while($row=mysqli_fetch_object($data)){
		
				journal_item_control($row->item_id,32,$row->or_date,$row->qty,0,'Damage Return',$xid,$row->rate,'',$row->or_no);
		
		
		}
		
		
		
		$status = find_a_field('sales_damage_receive_master','status','or_no='.$_POST[$unique]);
		
		if($staus=''){
			$update = "update sales_damage_receive_master set status='UNCHECKED' where or_no=".$_POST[$unique]."";
			db_query($update);
		}

		unset($$unique);

		unset($_SESSION[$unique]);

		$type=1;

		$msg='Successfully Forwarded.';

}



if(isset($_POST['delete']))

{

		

		$crud   = new crud($table_master);

		$condition=$unique."=".$$unique;		

		$crud->delete($condition);

		$crud   = new crud($table_details);

		$condition=$unique."=".$$unique;

		$crud->delete_all($condition);

		unset($$unique);

		unset($_SESSION[$unique]);

		$type=1;

		$msg='Successfully Deleted.';

}}

 $query = 'select d.dealer_code,concat(d.dealer_name_e,"-",d.manual_code) from dealer_info d where  1';

auto_complete_from_db_sql($query,'dealer');

?>

<script language="javascript">

window.onload = function() {document.getElementById("do").focus();}

</script>

<div class="form-container_large">

<form action="item_damage.php" method="post" name="codz" id="codz">

<table width="90%" border="0" align="center">

  <tr>

    <td width="20%" height="25%">&nbsp;</td>

    <td width="52%">&nbsp;</td>

    <td width="28%">&nbsp;</td>

  </tr>

  <tr>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

  </tr>

  <tr>

    <td align="right" bgcolor="#FF9966"><strong>Active Dealer List: </strong></td>

    <td bgcolor="#FF9966"><strong>



<?

$query = "select a.do_no,b.dealer_code,b.dealer_name_e from sale_do_master a,dealer_info b where b.dealer_code=a.dealer_code and a.status ='PROCESSING' and b.depot=".$_SESSION['user']['depot']."  order by a.do_no";

?>

<input name="dealer" type="text" id="dealer" style="width:320px;" required />

    </strong></td>

    <td bgcolor="#FF9966"><strong>

      <input type="submit" name="submitit" id="submitit" value="Damage Entry" style="width:170px; font-weight:bold; font-size:12px; height:30px; color:#090"/>

    </strong></td>

  </tr>

</table>



</form>

</div>



<?

$main_content=ob_get_contents();

ob_end_clean();

require_once SERVER_CORE."routing/layout.bottom.php";

?>