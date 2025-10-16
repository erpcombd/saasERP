<?php



session_start();



ob_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$title='warehouse Information';



$proj_id=$_SESSION['proj_id'];



$table='production_line';

$page="inventory_warehouse_add.php";



$crud      =new crud($table);







$warehouse_id=$_REQUEST['warehouse_id'];



$warehouse_name=$_REQUEST['warehouse_name'];



$warehouse_name		= str_replace("'","",$warehouse_name);



$warehouse_name		= str_replace("&","",$warehouse_name);



$warehouse_name		= str_replace('"','',$warehouse_name);



$warehouse_company=$_REQUEST['warehouse_company'];



$address=$_REQUEST['address'];



$contact=$_REQUEST['contact'];



$warehouse_type=$_REQUEST['warehouse_type'];



$use_type=$_REQUEST['use_type'];



$ap_name=$_REQUEST['ap_name'];



$ap_designation=$_REQUEST['ap_designation'];



$ledger_id=$_REQUEST['ledger_id'];



$return_ledger_id=$_REQUEST['return_ledger_id'];



$group_for=$_REQUEST['group_for'];



$now=time();



//end 







if(isset($_POST['nwarehouse']))



{



$check="select warehouse_id from warehouse where warehouse_name='$warehouse_name' limit 1";



if(mysqli_num_rows(db_query($check))>0)



{



	$aaa=mysqli_num_rows(db_query($check));



	$warehouse_id=$aaa[0];



	$type=0;



	$msg='Given Name('.$warehouse_name.') is already exists.';



}



else



{



	



		$sql="INSERT INTO `warehouse` (



		`warehouse_name` ,



		`warehouse_company` ,



		`address` ,



		`proj_id` ,



		`contact_no` ,



		`ap_name` ,



		`ap_designation` ,



		`warehouse_type`,



		ledger_id,



		use_type,group_for,return_ledger_id



		)



VALUES ('$warehouse_name', '$warehouse_company', '$address', '$proj_id', '$contact', '$ap_name', '$ap_designation', '$warehouse_type', '$ledger_id','$use_type',$group_for,$return_ledger_id)";



		



		$query=db_query($sql);



		$sign = db_insert_id();



		$id=$_POST['id']=$sign;



		$line_name=$_POST['line_name']=$warehouse_name;



		$crud->insert();



		$type=1;



if($_FILES['logo']['size']>0)



{



$root='../../signature/'.$sign.'.jpg';



move_uploaded_file($_FILES['logo']['tmp_name'],$root);



}



		$msg='New Entry Successfully Inserted.';







}







}







//for Modify..................................







if(isset($_POST['mwarehouse']))



{



$line_name=$_POST['line_name']=$warehouse_name;



$sql="UPDATE `warehouse` SET 



`warehouse_name` = '$warehouse_name',



`warehouse_company` = '$warehouse_company',



`address` = '$address',



`contact_no` = '$contact',



`ap_name` = '$ap_name',



`ap_designation` = '$ap_designation',



`ledger_id`='$ledger_id',



`return_ledger_id`='$return_ledger_id',



`use_type`='$use_type',



`warehouse_type` = '$warehouse_type',



group_for = '$group_for'



 WHERE `warehouse_id` = $warehouse_id LIMIT 1";







$qry=db_query($sql);



if($_FILES['logo']['size']>0)



{



$root='../../signature/'.$warehouse_id.'.jpg';



move_uploaded_file($_FILES['logo']['tmp_name'],$root);



}



		$type=1;



		$msg='Successfully Updated.';



}







if(isset($_POST['dwarehouse']))



{



$sql="delete from `warehouse` where `warehouse_id`='$warehouse_id' limit 1";



$query=db_query($sql);



		$type=1;



		$msg='Successfully Deleted.';



}







if(isset($_REQUEST['warehouse_id']))



{



$ddd="select * from warehouse where warehouse_id='$warehouse_id' and 1";



$data=mysqli_fetch_row(db_query($ddd));



}







?><script type="text/javascript">







$(document).ready(function(){







	







	$("#form2").validate();	







});	







function DoNav(theUrl)







{







	document.location.href = 'inventory_warehouse_add.php?warehouse_id='+theUrl;







}















</script>















							<table class="table table-bordered" width="100%" border="0" cellspacing="0" cellpadding="0">







								  <tr>







								    <td><div class="box"><form id="form1" name="form1" method="post" action=""><table width="100%" border="0" cellspacing="2" cellpadding="0">







                                      <tr>







                                        <td width="40%" align="right">







		    Warehouse Name :                                       </td>







                                        <td width="60%" align="right"><input type="text" style="max-width:250px;" name="cus_name" id="cus_name" value="<?php echo $_REQUEST['cus_name']; ?>" /></td>







                                      </tr>







                                      <tr>

                                        <td align="right">Incharge :                                         </td>


                                        <td align="right"><input name="cus_company" style="max-width:250px;" type="text" id="cus_company" value="<?php echo $_REQUEST['cus_company']; ?>" size="20" /></td>

                                      </tr>

                                      <tr>

                                        <td><input class="btn text-left" name="search" type="submit" id="search" value="Show" /></td>
                  </tr>

                                    </table>


								    </form></div></td>

						      </tr>


								  <tr>
									<td>&nbsp;</td>

								  </tr>

								  <tr>

									<td>


									<table class="table table-bordered" border="0" cellspacing="0" cellpadding="0" id="data_table_inner" class="display" >
									<thead>


							  <tr>

								<th>Name</th>

								<th>Incharge</th>



								<th> Type</th>


							  </tr>
</thead>
<tbody>

	<?php


	$rrr = "select warehouse_id, warehouse_name, warehouse_company, warehouse_type from warehouse where 1"; 



	if(isset($_REQUEST['search']))



	{



		$cus_name	= mysqli_real_escape_string($_REQUEST['cus_name']);



		$cus_company	= mysqli_real_escape_string($_REQUEST['cus_company']);



		$cus_type	= mysqli_real_escape_string($_REQUEST['cus_type']);



		



		$rrr .= " AND warehouse_name LIKE '%$cus_name%'";



		$rrr .= " AND warehouse_company LIKE '%$cus_company%'";



		$rrr .= " AND warehouse_type LIKE '%$cus_type%'";







				







	} 







	$rrr .= " order by warehouse_name";







	//print($rrr );







	$report=db_query($rrr);







	 while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>







							   <tr<?=$cls?> onclick="DoNav('<?php echo $rp[0];?>');">







								<td><?=$rp[1];?></td>







								<td><?=$rp[2];?></td>







								<td><?=$rp[3];?></td>







							  </tr>







	<?php }?>







							</tbody></table>						</td>







								  </tr>







								</table>





























<?







$main_content=ob_get_contents();







ob_end_clean();







include ("../../template/main_layout2.php");







?>