<?php


require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');


$str = $_POST['data'];
$data=explode('##',$str);

$unique='id';
$table_master = 'rfq_vendor_details';
$Crud   = new Crud($table_master);

$rfq_no  = $data[0];

$vendor = $data[1];


$_POST['rfq_no'] = $rfq_no;

if($rfq_no>0){
$_POST['vendor_id'] = $vendor;

$_POST['vendor_name'] = find_a_field('vendor','vendor_name','vendor_id="'.$vendor.'" ');
$_POST['email'] = find_a_field('vendor','email','vendor_id='.$vendor);
$_POST['vendor_category '] = find_a_field('vendor','vendor_category','vendor_id="'.$vendor.'" ');
$_POST['vendor_company '] = find_a_field('vendor','vendor_company','vendor_id="'.$vendor.'" ');

$_POST['entry_at'] = date('Y-m-d H:i:s');
$_POST['entry_by'] = $_SESSION['user']['id'];
$Crud->insert();

$_POST['field_name'] = 'Event vendor insert';
$_POST['field_value'] = $_POST['vendor_name'];
$_POST['entry_at'] = date('Y-m-d H:i:s');
$_POST['entry_by'] = $_SESSION['user']['id'];
$Crud   = new Crud('rfq_logs');
$Crud->insert();
}
?>

 <?
		 $sql = 'select v.*,r.id from vendor v,rfq_vendor_details r where v.vendor_id=r.vendor_id and r.rfq_no="'.$_SESSION['rfq_no'].'"';
		 $qry = db_query($sql);
		 if(mysqli_num_rows($qry)<1){
		 
		$info=' <tr>
					 <td colspan="9" style="text-align:center;">..Empty..</td>
					</tr>';
					
		 
		 }
		 $supplier_count = 0;
		 while($vendor=mysqli_fetch_object($qry)){
		 $supplier_count++;
		
					  $info .= "<tr>
                            <td>".$vendor->entry_at."</td>
							<td>".$vendor->vendor_name."(".$vendor->vendor_id.")</td>
                            <td>".$vendor->contact_person_name."</td>
                            <td>".$vendor->email."</td>
							
							<td></td>
							<td></td>
							<td><button type='button' name='remove_vendor' class='btn2 btn1-bg-cancel' onclick='remove_vendor(".$vendor->id.")'>x</button></td>
							<td><button type='button' onclick='notify_supplier_individual(\"{$vendor->email}\")' class='btn btn-primary'>Send Email</button></td>
                        </tr>";
						 }
					$info .='<input type="hidden" name="supplier_count" id="supplier_count" value="'.$supplier_count.'"  />';	 
						 
			 $infos['table']=$info;
			
			 if($_SESSION['user_role']=='Owner'){
				$button = '<a href="rfq_preview.php" rel="noopener"><button type="button" class="btn btn-primary">Event Preview Before Submission</button></a>';
				 } 
			  $infos['button']=$button;	
			  echo json_encode($infos); 
			 ?>
