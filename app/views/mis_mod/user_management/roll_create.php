<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

do_calander('#expire_date');
do_calander('#entry_date');
do_calander('#edit_date');


// ::::: Edit This Section ::::: 

$title='User Management';			// Page Name and Page Title

$page="user_manage.php";		// PHP File Name

$input_page="user_manage_input.php";

$root='admin';


$table='user_activity_management';		// Database Table Name Mainly related to this page

$unique='user_id';			// Primary Key of this Database table

$shown='username';				// For a New or Edit Data a must have data field

			// For a New or Edit Data a must have data field

			
$user_group_for=find_a_field('warehouse','group_for','warehouse_id="'.$warehouse_for.'"');
			

if($_GET['user_id']>0){

	 $access = $$unique = $_GET[$unique];

	}

elseif($_POST['user_id']>0){

	 $access = $$unique = $_POST[$unique];

	}

// ::::: End Edit Section :::::



if(isset($_POST['mod_add'])){



$modules_id=$_POST['module_id'];

$sql="insert into user_module_define(user_id,module_id,status)values('$user_id','$modules_id','enable')";

$query=db_query($sql);



}



if(isset($_POST['ware_add'])){



$warehouse_id=$_POST['warehouse_id'];

echo $sql="insert into warehouse_define(user_id,warehouse_id,status)values('$user_id','$warehouse_id','Active')";

$query=db_query($sql);



}


$crud      =new crud($table);
if(isset($_POST[$shown]))

{



$$unique = $_POST[$unique];



if(isset($_POST['new'])||isset($_POST['insertn']))

{
	$_POST['password']=md5($_POST['password']);
	$_POST['group_for']=find_a_field('warehouse','group_for','warehouse_id="'.$_POST['warehouse_id'].'"');
	$folder='user_pic';
	$field = 'user_pic';  //'PBI_PICTURE_ATT_PATH';
	$file_name = $folder.'-'.$user_id;
	if($_FILES['user_pic']['tmp_name']!=''){
		$_POST['user_pic']=upload_file($folder,$field,$file_name);
	}


	//////////////Sign upload Start///////////
		$folder2='sign';
		$field2 = 'sign';
			$file_name2 = $user_id;
				if($_FILES['sign']['tmp_name']!=''){
		$_POST['sign']=upload_file($folder2,$field2,$file_name2);
	}
//////////////Sign upload End///////////



$now = time();

 $$unique = $crud->insert();


//
// $user=find_a_field('user_activity_management','count(user_id)','1');
//
//if($user<=$_SESSION['maxUser']){
//
//$now				= time();
//
// $$unique = $crud->insert();
//}else{
//echo "user Limit";

//}


$type=1;

$msg='New Entry Successfully Inserted.';

$sql_wh_define="insert into warehouse_define(user_id,warehouse_id,status,entry_by,entry_at)
values('$user_id','".$_POST['warehouse_id']."','Active','".$_SESSION['user']['id']."','".date('Y-m-d H:i:s')."')";

$wh_define_query=db_query($sql_wh_define);

}





//for Modify..................................



if(isset($_POST['update']))

{
	//$_POST['password']=md5($_POST['password']);
	$folder='user_pic';
	$field = 'user_pic';  //'PBI_PICTURE_ATT_PATH';
	$file_name = $folder.'-'.$user_id;
	if($_FILES['user_pic']['tmp_name']!=''){
		$_POST['user_pic']=upload_file($folder,$field,$file_name);
	}


	//////////////Sign upload Start///////////
		$folder2='sign';
		$field2 = 'sign';
			$file_name2 = $user_id;
				if($_FILES['sign']['tmp_name']!=''){
		$_POST['sign']=upload_file($folder2,$field2,$file_name2);
	}
//////////////Sign upload End///////////
		$crud->update($unique);

		$type=1;

		$msg='Successfully Updated.';

				

}



/*$path="files/user/pic";
$file=$_FILES["file"];
upload_file($path,$file,$$unique);*/

$folder='user_pic'; 
$field = 'user_pic';  //'PBI_PICTURE_ATT_PATH';
$file_name = $folder.'-'.$unique;

if($_FILES['user_pic']['tmp_name']!=''){
$_POST['user_pic']=upload_file($folder,$field,$file_name);
}

//image_upload_on_id($path,$file,$$unique);

//for Delete..................................



if(isset($_POST['delete']))

{		$condition=$unique."=".$$unique;		$crud->delete($condition);

		unset($$unique);

		

		$type=1;

		$msg='Successfully Deleted.';

}

}



if($$unique>0)



{



		$condition=$unique."=".$$unique;



		echo $condition;



		$data=db_fetch_object($table,$condition);



		foreach ($data as $key => $value)



		{ $$key=$value;}



		



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







	function access_update(id)







	{







var page_id=id; var user_id=<?=$user_id?>; // Rent



if((document.getElementById('access'+id).checked)==1)



var access=1; else var access=0;



if((document.getElementById('add'+id).checked)==1)



var add=1; else var add=0;



if((document.getElementById('edit'+id).checked)==1)



var edit=1; else var edit=0;



if((document.getElementById('delete'+id).checked)==1)



var delete1=1; else var delete1=0;















var strURL="roll_create_ajax.php?page_id="+page_id+"&access="+access+"&add="+add+"&edit="+edit+"&delete="+delete1+"&user_id="+user_id;







		var req = getXMLHTTP();







		if (req) {







			req.onreadystatechange = function() {



				if (req.readyState == 4) {



					// only if "OK"



					if (req.status == 200) {						



						document.getElementById('pv'+id).style.display='inline';



						document.getElementById('pv'+id).innerHTML=req.responseText;						



					} else {



						alert("There was a problem while using XMLHTTP:\n" + req.statusText);



					}



				}				



			}



			req.open("GET", strURL, true);



			req.send(null);



		}	







}







</script>



<script type="text/javascript"> function DoNav(lk){



	return GB_show('ggg', '../pages/<?=$root?>/<?=$input_page?>?<?=$unique?>='+lk,600,940)



	}</script>



	<!--<style type="text/css">







.style3 {color: #FFFFFF; font-weight: bold; }







    </style>-->



	







<form action="" method="post" enctype="multipart/form-data">





<!--        --><?// include('../../common/title_bar.php');?>





<div class="container-fluid">







<div class="d-flex justify-content-center">

    <div class="n-form1 pt-0">

        <h4 class="text-center m-0 bg-titel bold pt-2 pb-2">

<!--            --><?// include('../../common/title_bar.php');?>


            User Management 

        </h4>

        <div class="container-fluid pt-4">



            <div class="row m-0 p-0">

                <div class="col-sm-6">



                    <div class="form-group row m-0 mb-1 pl-3 pr-3">

                        <label for="group_for" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"> User Name :</label>

                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

                            <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />

           <input type="hidden" name="group_for" value="<?= $user_group_for?>">

            <input type="hidden" name="entry_date" value="<?=date('Y-m-d')?>">

            <input  name="id" type="hidden" id="id" value="<? if($_SESSION['user_id']>0) echo $_SESSION['user_id']; else echo find_a_field('user_activity_management','max(user_id)+1','1');?>" readonly/>



<input  name="user_id2" type="hidden" id="user_id2" value="<?=$user_id?>"/>



            <input name="username" id="username" value="<?=$username?>" type="text" / class="form-control">	

                        </div>

                    </div>

					
					<? if($access>0){ ?>

					
					
					<? } else {?>
					
					<div class="form-group row m-0 mb-1 pl-3 pr-3">

                        <label for="group_for" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"> Password :</label>

                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

                            <input name="password" type="password" id="password" value="<?=$password?>"/ class="form-control">

                        </div>

                    </div>

					<? } ?>

					

					<div class="form-group row m-0 mb-1 pl-3 pr-3">

                        <label for="group_for" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"> Status :</label>

                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

                           <select name="status"id="status" required class="form-control">	



				    <option><?=$status?></option>



				  <option value="Active">Active</option>



				  <option value="Inactive">Inactive</option>



				   </select>

                        </div>

                    </div>

					

					

					<div class="form-group row m-0 mb-1 pl-3 pr-3">

                        <label for="group_for" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"> Expire Date :</label>

                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

                            <input type="text" name="expire_date" id="expire_date" value="<?=$expire_date?>" / class="form-control">

                        </div>

                    </div>
								<div class="form-group row m-0 mb-1 pl-3 pr-3">

                        <label for="group_for" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"> Dealer Code :</label>

                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

                            <input type="text" name="dealer_code" id="dealer_code" value="<?=$dealer_code?>" / class="form-control">

                        </div>

                    </div>
					<div class="form-group row m-0 mb-1 pl-3 pr-3">

                        <label for="group_for" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"> Vendor Code :</label>

                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

                            <input type="text" name="vendor_code" id="vendor_code" value="<?=$vendor_code?>" / class="form-control">

                        </div>

                    </div>

					<div class="form-group row m-0 mb-1 pl-3 pr-3">

                        <label for="group_for" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"> Organization :</label>

                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

                                  <select name="organization"id="organization"   class="form-control">	
				    <option><?=$organization?></option>
					<?php 
					$dsql='select * from crm_service_customer';
					$dquery=db_query($dsql);
					while($drow=mysqli_fetch_object($dquery)){
					?>
				  <option value="<?php echo $drow->customer_id;?>"><?php echo $drow->customer_name;?></option>
				 <?php } ?>
				   </select>

                        </div>

                    </div>

					<!--<div class="form-group row m-0 mb-1 pl-3 pr-3">

                        <label for="group_for" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"> </label>

                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

                            <input type="file" name="user_pic" id="file" value="" />

                        </div>

                    </div>-->

					

					

					



                    





                </div>



                <div class="col-sm-6">
				
					<div class="form-group row m-0 mb-1 pl-3 pr-3">
                        <label for="group_for" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"> User Picture : </label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                            <input type="file" name="user_pic" id="file" value="" />
                        </div>

                    </div>

<div class="form-group row m-0 mb-1 pl-3 pr-3">
                        <label for="group_for" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Sign Upload : </label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                            <input type="file" name="sign" id="sign" value="" />
                        </div>

                    </div>

<div class="form-group row m-0 mb-1 pl-3 pr-3">
                        <label for="group_for" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Sign Applicable : </label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                            <select name="sign_applicable" id="sign_applicable">
								<option value="<?php echo $sign_applicable;?>"><?php echo $sign_applicable;?></option>
								<option value="YES">YES</option>
								<option value="NO">NO</option>
							</select>
                        </div>

                    </div>


                    <div class="form-group row m-0 mb-1 pl-3 pr-3">

                        <label for="group_for" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Full Name :</label>

                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

                            <input name="fname" type="text" id="fname" value="<?=$fname?>" />

                        </div>

                    </div>



                    

					

					<div class="form-group row m-0 mb-1 pl-3 pr-3">

                        <label for="group_for" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Designation :</label>

                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

                            <input name="designation" type="text" id="designation" value="<?=$designation?>" />

                        </div>

                    </div>

					

					

					

					

					<div class="form-group row m-0 mb-1 pl-3 pr-3">

                        <label for="group_for" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"> Level :</label>

                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

                            <select name="level" id="level" class="form-control">

                    <option></option>

                    <? foreign_relation('user_type','user_level','user_type_name',$level)?>

                  </select>

                        </div>

                    </div>

					

					

					

					<div class="form-group row m-0 mb-1 pl-3 pr-3">

                        <label for="group_for" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Employee ID :</label>

                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

                           <input type="text" name="PBI_ID" id="PBI_ID" value="<?=$PBI_ID;?>" />
<!--                           <input type="text" name="PBI_ID" id="PBI_ID" value="--><?//=$PBI_ID=$_GET['user_id'];?><!--" />-->

                        </div>

                    </div>

					

					
					<div class="form-group row m-0 mb-1 pl-3 pr-3">

                        <label for="group_for" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"> Warehouse :</label>

                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

                            <select name="warehouse_id" id="warehouse_id" class="form-control">

                    <option></option>

                    <? foreign_relation('warehouse','warehouse_id','warehouse_name',$warehouse_id)?>

                  </select>

                        </div>

                    </div>




                </div>



            </div>



            <div class="n-form-btn-class">

                <? if($access>0){ ?>



<input name="update" type="submit" class="btn1 btn1-bg-update" value="Update" />



<? } else {?>

<input name="new" type="submit" class="btn1 btn1-bg-submit" value="Save"  />

<? } ?>







<? if($access>0 || $user_id>0) { $btn_name='Delete User';?>



<!--<input name="delete" id="delete"  onclick="return confirmation();"  type="submit" class="btn1 btn1-bg-cancel" value="<?=$btn_name?>"  />-->



<? }?>

            </div>



        </div>

    </div>



</div>











        <div class="oe_form_sheet oe_form_sheet_width">




          </div>



    </div>





</form>











    <form action="" method="post">

	<h4 class="text-center mt-5 bg-titel bold pt-2 pb-2">

			Module Access

                </h4>

        <div class="container-fluid bg-form-titel">

            <div class="row">

			

                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8">

                    <div class="form-group row m-0">

                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Module Access</label>

                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">

                           <select class="form-control" name="module_id" id="$post_id" >

								<option value=""></option>

												<?php 

											 $sql="select * from user_module_manage";

													$query=db_query($sql);

													while($data=mysqli_fetch_assoc($query)){
                        
                                                    if(find_a_field('user_module_define', 'count(ge_id)', 'user_id="'.$user_id.'" AND module_id = "'.$data['id'].'" AND status = "enable"') > 0){ 
                                                        
                                                        continue;
                                                    
                                                    }else{
                                    
    													$module_id=$data['id'];
    
    													$module_name=$data['module_name'];
                                                    
                                                    }

													?>

						

								<option value="<?php echo $module_id;?>"><?php echo $module_name; ?></option>

								<?php } ?>

							</select>

                        </div>

                    </div>

                </div>

                



                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">

					<input type="submit" class="btn1 btn1-submit-input" name="mod_add" value="Add"  />

                </div>



            </div>

        </div>







        <div class="container-fluid  p-0 ">



       <table class="table1  table-striped table-bordered table-hover table-sm">

                    <thead class="thead1">

                    <tr class="bgc-info">

					<?=$users_id; ?>

                        <th>Id</th>

                        <th>Module Name</th>

                        <th>Status</th>

                        <th>Order No</th>

                        <th>Delete</th>
                        
                    </tr>

                    </thead>



                    <tbody class="tbody1">

									

						

					

							

							

							<?php 

						

							 $sql="select m.ge_id, m.module_id,m.user_id,m.status,u.id,u.module_name from user_module_manage u,user_module_define m where m.user_id='".$user_id."' and m.module_id=u.id GROUP BY u.id ORDER BY u.id ";

							$query=db_query($sql);

							while($data=mysqli_fetch_assoc($query)){

                            $ge_id = $data['ge_id'];

							$module_id=$data['module_id'];

							$module_name=$data['module_name'];

							$status=$data['status'];

						

						

				

							

							echo "<tr>";

					

							echo "<td>$module_id</td>";

							echo "<td>$module_name</td>";

							echo "<td>$status</td>";
							
						    echo '<td><input type="number" id="order_'.$module_id.'" style="width:12%!important;text-align:center;" value="'.find_a_field('user_module_order_list', 'order_list', 'module="'.$module_id.'" AND user="'.$user_id.'" ORDER BY id DESC').'"> &nbsp;<span id="setIt_'.$module_id.'"><span onclick="getData2('."'setModuleOrderAjax.php'".', '."'setIt_".$module_id."'".', '.$module_id."+'##'+"."document.getElementById('order_".$module_id."').value"."+'##'+"."'".$user_id."'".')" class="btn btn-info btn-sm" style="margin-top:-2px;">SET</span></span></td>';
						

							if($status=='enable'){

							echo "<td><button type='submit' class='btn btn-success' style='background:green;'><a onClick=\" javascript: return confirm('Are you sure you want to disable this?');  \"  href='roll_create.php?delete=$user_id&mod_ac_id=$ge_id' style='color:white;'>Make Disable</a></button></td>";

							}

							else{

							echo "<td><button type='submit' class='btn' style='background:red;'><a onClick=\" javascript: return confirm('Are you sure you want to enable this?');  \"  href='roll_create.php?enable=$user_id&mod_ac_id=$ge_id' style='color:white;'>Make Enable</a></button></td>";

							}

						

							echo "</tr>";

							

							

							}

					?>

				

						<?php 

						if(isset($_GET['delete'])){

						$status_id_delete=$_GET['delete'];

							$mod_id=$_GET['mod_ac_id'];

						$sql="update user_module_define set status='disable' where user_id={$status_id_delete} and ge_id=$mod_id";

						$query=db_query($sql);

						header("Location:roll_create.php?user_id=$status_id_delete");

						

						}

						?>

						<?php 

						if(isset($_GET['enable'])){

						$status_id_enable=$_GET['enable'];

								$mod_id=$_GET['mod_ac_id'];

						$sql="update user_module_define set status='enable' where user_id={$status_id_enable} and ge_id=$mod_id";

						$query=db_query($sql);

						header("Location:roll_create.php?user_id=$status_id_enable");

						

						}

						?>

							

							</tbody>

							</table>







		<input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />



        </div>



    </form>

	



	

	
<!--
	<form action="" method="post">

	<h4 class="text-center bg-titel mt-5 bold pt-2 pb-2">

			Warehouse Access

                </h4>

        <div class="container-fluid bg-form-titel">

		

            <div class="row">

                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8">

                    <div class="form-group row m-0">

                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Warehouse Access</label>

                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">

                           <select class="form-control" name="warehouse_id" id="$post_id" >

								<option value=""></option>

												<?php 

											 $sql="select * from warehouse ";

													$query=db_query($sql);

													while($data=mysqli_fetch_assoc($query)){

													$warehouse_id=$data['warehouse_id'];

													$warehouse_name=$data['warehouse_name'];

													?>

						

								<option value="<?php echo $warehouse_id;?>"><?php echo $warehouse_name; ?></option>

								<?php } ?>

							</select>

                        </div>

                    </div>



                </div>



                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">

					<input type="submit" class="btn1 btn1-submit-input" name="ware_add" value="Add"  />

                </div>



            </div>

        </div>











        <div class="container-fluid  p-0 ">













                <table class="table1  table-striped table-bordered table-hover table-sm">

                    <thead class="thead1">

                    <tr class="bgc-info">

					<?//=$users_id; ?>

                        <th>Id</th>

                        <th>Warehouse Name</th>

                        <th>Status</th>



                        <th>Delete</th>

                    </tr>

                    </thead>



                    <tbody class="tbody1">

									

						

					

							<?php 

						

							  $sql="select w.warehouse_id,w.user_id,w.status,wa.warehouse_id,wa.warehouse_name from warehouse wa,warehouse_define w where w.user_id='".$user_id."' and w.warehouse_id=wa.warehouse_id";

							$query=db_query($sql);

							while($data=mysqli_fetch_assoc($query)){

							$warehouse_id=$data['warehouse_id'];

							$warehouse_name=$data['warehouse_name'];

							$status=$data['status'];

						

						

				

							

							echo "<tr>";

					

							echo "<td>$warehouse_id</td>";

							echo "<td>$warehouse_name</td>";

							echo "<td>$status</td>";

							

							//echo "<td><a onClick=\" javascript: return confirm('Are you sure you want to disable this?');  \"  href='roll_create.php?disable=$user_id&ware_id=$warehouse_id'>Delete</a></td>";

						if($status=='enable'){

							echo "<td><button type='submit' class='btn btn-success' style='background:green;'><a onClick=\" javascript: return confirm('Are you sure you want to disable this?');  \"  href='roll_create.php?disable=$user_id&ware_id=$warehouse_id' style='color:white;'>Make Disable</a></button></td>";

							}

							else{

							echo "<td><button type='submit' class='btn' style='background:red;'><a onClick=\" javascript: return confirm('Are you sure you want to enable this?');  \"  href='roll_create.php?enable_w=$user_id&ware_id=$warehouse_id'style='color:white;'>Make Enable</a></button></td>";

							}

							

							echo "</tr>";

							

							

							}

					?>

				

						<?php 

						if(isset($_GET['disable'])){

						$warehouse_id_desable=$_GET['disable'];

						$warehouse_id_in=$_GET['ware_id'];

						$sql="update warehouse_define set status='disable' where user_id={$warehouse_id_desable} and warehouse_id=$warehouse_id_in";

						$query=db_query($sql);

						

						header("Location:roll_create.php?user_id=$warehouse_id_desable");

					

						}

						?>

						<?php 

						if(isset($_GET['enable_w'])){

						$warehouse_id_enable=$_GET['enable_w'];

						$warehouse_id_in=$_GET['ware_id'];

						$sql="update warehouse_define set status='enable' where user_id={$warehouse_id_enable} and warehouse_id=$warehouse_id_in";

						$query=db_query($sql);

						header("Location:roll_create.php?user_id=$warehouse_id_enable");

						

						}

						?>

							

							</tbody>

							</table>





<input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />



        </div>

		

    </form>
-->










<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>















<?php /*?><form action="" method="post">

<table class="table table-bordered table-hover">

<h2>Module Access</h2>

<div class="row">

	

		<div id="bulkOptionContainer" class="col-xs-4">

		

							

	<select class="form-control" name="module_id" id="$post_id" style="padding-right:44px;">

		<option value=""></option>

						<?php 

					 $sql="select * from user_module_manage ";

							$query=db_query($sql);

							while($data=mysqli_fetch_assoc($query)){

							$module_id=$data['id'];

							$module_name=$data['module_name'];

							?>



		<option value="<?php echo $module_id;?>"><?php echo $module_name; ?></option>

		<?php } ?>

	</select>

</div>





<div class="col-xs-4">



	<input type="submit" class="btn btn-success" name="mod_add" value="Add" style="margin-left:21px;margin-top:4px;" />



</div>

</div><br /><br />



							<thead>

							<tr>

							<?=$users_id; ?>

								<th>Id</th>

								<th>Module Name</th>

								<th>Status</th>

							

								<th>Delete</th>

								</tr>

							</thead>

							

									<tbody>

									

						

					

							

							

							<?php 

						

							 $sql="select m.module_id,m.user_id,m.status,u.id,u.module_name from user_module_manage u,user_module_define m where m.user_id='".$user_id."' and m.module_id=u.id";

							$query=db_query($sql);

							while($data=mysqli_fetch_assoc($query)){

							$module_id=$data['module_id'];

							$module_name=$data['module_name'];

							$status=$data['status'];

						

						

				

							

							echo "<tr>";

					

							echo "<td>$module_id</td>";

							echo "<td>$module_name</td>";

							echo "<td>$status</td>";

							

							

							if($status=='enable'){

							echo "<td><button type='submit' class='btn btn-success' style='background:green;'><a onClick=\" javascript: return confirm('Are you sure you want to disable this?');  \"  href='roll_create.php?delete=$user_id&mod_id=$module_id' style='color:white;'>Make Disable</a></button></td>";

							}

							else{

							echo "<td><button type='submit' class='btn' style='background:red;'><a onClick=\" javascript: return confirm('Are you sure you want to enable this?');  \"  href='roll_create.php?enable=$user_id&mod_id=$module_id' style='color:white;'>Make Enable</a></button></td>";

							}

						

							echo "</tr>";

							

							

							}

					?>

				

						<?php 

						if(isset($_GET['delete'])){

						$status_id_delete=$_GET['delete'];

							$mod_id=$_GET['mod_id'];

						$sql="update user_module_define set status='disable' where user_id={$status_id_delete} and module_id=$mod_id";

						$query=db_query($sql);

						header("Location:roll_create.php?user_id=$status_id_delete");

						

						}

						?>

						<?php 

						if(isset($_GET['enable'])){

						$status_id_enable=$_GET['enable'];

								$mod_id=$_GET['mod_id'];

						$sql="update user_module_define set status='enable' where user_id={$status_id_enable} and module_id=$mod_id";

						$query=db_query($sql);

						header("Location:roll_create.php?user_id=$status_id_enable");

						

						}

						?>

							

							</tbody>





</table><input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />

</form><?php */?>



<?php /*?><form action="" method="post">



<table class="table table-bordered table-hover">

<h2>Warehouse Access</h2>

<div class="row">

	

		<div id="bulkOptionContainer" class="col-xs-4">

		

							

	<select class="form-control" name="warehouse_id" id="$post_id" style="padding-right:44px;">

		<option value=""></option>

						<?php 

					 $sql="select * from warehouse ";

							$query=db_query($sql);

							while($data=mysqli_fetch_assoc($query)){

							$warehouse_id=$data['warehouse_id'];

							$warehouse_name=$data['warehouse_name'];

							?>



		<option value="<?php echo $warehouse_id;?>"><?php echo $warehouse_name; ?></option>

		<?php } ?>

	</select><input type="submit" class="btn btn-success" name="ware_add" value="Add" style="margin-left:21px;margin-top:4px;" />

</div>





<div class="col-xs-4">



	<input type="submit" class="btn btn-success" name="ware_add" value="Add" style="margin-left:21px;margin-top:4px;" />



</div>

</div><br /><br />



							<thead>

							<tr>

						

								<th>Id</th>

								<th>warehouse Name</th>

								<th>Status</th>

							

								<th>Delete</th>

								</tr>

							</thead>

							

									<tbody>

									

						

					

							

							

							<?php 

						

							  $sql="select w.warehouse_id,w.user_id,w.status,wa.warehouse_id,wa.warehouse_name from warehouse wa,warehouse_define w where w.user_id='".$user_id."' and w.warehouse_id=wa.warehouse_id";

							$query=db_query($sql);

							while($data=mysqli_fetch_assoc($query)){

							$warehouse_id=$data['warehouse_id'];

							$warehouse_name=$data['warehouse_name'];

							$status=$data['status'];

						

						

				

							

							echo "<tr>";

					

							echo "<td>$warehouse_id</td>";

							echo "<td>$warehouse_name</td>";

							echo "<td>$status</td>";

							

							//echo "<td><a onClick=\" javascript: return confirm('Are you sure you want to disable this?');  \"  href='roll_create.php?disable=$user_id&ware_id=$warehouse_id'>Delete</a></td>";

						if($status=='enable'){

							echo "<td><button type='submit' class='btn btn-success' style='background:green;'><a onClick=\" javascript: return confirm('Are you sure you want to disable this?');  \"  href='roll_create.php?disable=$user_id&ware_id=$warehouse_id' style='color:white;'>Make Disable</a></button></td>";

							}

							else{

							echo "<td><button type='submit' class='btn' style='background:red;'><a onClick=\" javascript: return confirm('Are you sure you want to enable this?');  \"  href='roll_create.php?enable_w=$user_id&ware_id=$warehouse_id'style='color:white;'>Make Enable</a></button></td>";

							}

							

							echo "</tr>";

							

							

							}

					?>

				

						<?php 

						if(isset($_GET['disable'])){

						$warehouse_id_desable=$_GET['disable'];

						$warehouse_id_in=$_GET['ware_id'];

						$sql="update warehouse_define set status='disable' where user_id={$warehouse_id_desable} and warehouse_id=$warehouse_id_in";

						$query=db_query($sql);

						

						header("Location:roll_create.php?user_id=$warehouse_id_desable");

					

						}

						?>

						<?php 

						if(isset($_GET['enable_w'])){

						$warehouse_id_enable=$_GET['enable_w'];

						$warehouse_id_in=$_GET['ware_id'];

						$sql="update warehouse_define set status='enable' where user_id={$warehouse_id_enable} and warehouse_id=$warehouse_id_in";

						$query=db_query($sql);

						header("Location:roll_create.php?user_id=$warehouse_id_enable");

						

						}

						?>

							

							</tbody>





</table><input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />

</form><?php */?>



<script type="text/javascript">



function confirmation()



{



var answer = confirm("Are you sure?")



 if (answer)



 {



  return true;



 } else {



  if (window.event) // True with IE, false with other browsers



  {



   window.event.returnValue=false; //IE specific



  } else {



   return false



  }



 }



}







</script>



<?



require_once SERVER_CORE."routing/layout.bottom.php";



?>