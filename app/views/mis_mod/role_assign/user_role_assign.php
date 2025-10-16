<?php



session_start();



ob_start();




 

 

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

	$get_module_id=$_GET['module_id'];		

// ::::: End Edit Section :::::





if($_GET['user_id']>0){

	 $access = $_GET['user_id'];

	}



$crud      =new crud($table);



$$unique = $_GET[$unique];

if(isset($_POST[$shown]))

{

$$unique = $_POST[$unique];



if(isset($_POST['new'])||isset($_POST['insertn']))

{		

$_POST['password']=md5($_POST['password']);

$now				= time();



$check = $crud->insert();

$type=1;

if($check){

	 $access = 1;

	}

$msg='New Entry Successfully Inserted.';



if(isset($_POST['insert']))

{

$folder='user_pic'; 
$field = 'user_pic';  //'PBI_PICTURE_ATT_PATH';
$file_name = $folder.'-'.$user_id;
if($_FILES['user_pic']['tmp_name']!=''){
$_POST['user_pic']=upload_file($folder,$field,$file_name);
}

/*echo '<script type="text/javascript">

parent.parent.document.location.href = "../'.$root.'/'.$page.'";

</script>';*/

}

unset($_POST);

unset($$unique);





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


		$crud->update($unique);

		$type=1;

		$msg='Successfully Updated.';

				

}




/*
$path="../../../files/user/pic";

$file=$_FILES["file"];

image_upload_on_id($path,$file,$$unique);*/

//for Delete..................................



if(isset($_POST['delete']))

{		$condition=$unique."=".$$unique;		$crud->delete($condition);

		unset($$unique);

		

		$type=1;

		$msg='Successfully Deleted.';

}

}



if($access>0)



{



		$condition=$unique."=".$access;



		//echo $condition;



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



	



	 



<!--<head>

  

  <meta charset="utf-8">

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />

  <style type="text/css">







.style3 {color: #FFFFFF; font-weight: bold; }







    </style>

</head>-->











<form action="" method="post" enctype="multipart/form-data">



<!--        --><?// include('../../common/title_bar.php');?>





<div class="container-fluid">





<div class="d-flex justify-content-center">

    <div class="n-form1 pt-0">

        <h4 class="text-center m-0 bg-titel bold pt-2 pb-2">

            <!--            --><?// include('../../common/title_bar.php');?>

            User Management

        </h4>

        <div class="container-fluid">

            <div class="row m-0 p-0">

                <div class="col-sm-6">



                    <div class="form-group row m-0 mb-1 pl-3 pr-3">

                        <label for="group_for" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"> User Name :</label>

                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

                            <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />

           <input type="hidden" name="group_for" value="<?= $_SESSION['user']['group']?>">

            <input type="hidden" name="entry_date" value="<?=date('Y-m-d')?>">

            <input  name="id" type="hidden" id="id" value="<? if($_SESSION['user_id']>0) echo $_SESSION['user_id']; else echo find_a_field('user_activity_management','max(user_id)+1','1');?>" readonly/>



<input  name="user_id2" type="hidden" id="user_id2" value="<?=$user_id?>"/>



            <input name="username" id="username" value="<?=$username?>" type="text" / class="form-control">	

                        </div>

                    </div>

					

					<?php /*?><div class="form-group row m-0 mb-1 pl-3 pr-3">

                        <label for="group_for" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"> Password :</label>

                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

                            <input name="password" type="password" id="password" value="<?=$password?>"/ class="form-control">

                        </div>

                    </div><?php */?>

					

					

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

					

					<!--<div class="form-group row m-0 mb-1 pl-3 pr-3">

                        <label for="group_for" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"> </label>

                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

                            <input type="file" name="user_pic" id="user_pic" value="" />

                        </div>

                    </div>-->

					

					

					



                    





                </div>



                <div class="col-sm-6">





                    <div class="form-group row m-0 mb-1 pl-3 pr-3">

                        <label for="group_for" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Full Name :</label>

                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

                            <input name="fname" type="text" id="fname" value="<?=$fname?>" / class="form-control">	

                        </div>

                    </div>



                    

					

					<div class="form-group row m-0 mb-1 pl-3 pr-3">

                        <label for="group_for" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Designation :</label>

                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

                            <input name="designation" type="text" id="designation" value="<?=$designation?>" / class="form-control">

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

                           <input type="text" name="PBI_ID" id="PBI_ID" value="<?=$PBI_ID;?>"  class="form-control"/>
<!--                           <input type="text" name="PBI_ID" id="PBI_ID" value="--><?//=$PBI_ID=$_GET['user_id'];?><!--"  class="form-control"/>-->

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




		  	

 <span onclick="selectedAll()" class="btn" style="color:#242020;background-color:#80c4c7;border-color:#408d99;margin-bottom:12px;">CHECK ALL</span>
  <span onclick="RemoveAll()" class="btn" style="color: #ffffff;background-color: #ec4848;border-color: #994040;margin-bottom:12px;">REMOVE ALL</span>





          <div  class="oe_view_manager_view_list"><div  class="oe_list oe_view">



	   



<? if($access>0){

$sql = 'select * from user_role_access where user_id="'.$access.'"';
$qry = db_query($sql);
while($data=mysqli_fetch_object($qry)){
$preAccess[$data->role_id] = $data->role_id;
}

$sql = 'select * from roll_master where 1';
$query = db_query($sql);
while($info = mysqli_fetch_object($query)){

$counts = 1;

?>

			

			



<table class="table1  table-striped table-bordered table-hover table-sm" border="0" cellspacing="0" cellpadding="0">

<thead class="thead1">


  <tr class="bgc-info">
    <th><?=$info->role_name?></td>
    <th width="8%"><div align="center"><span class="style3">Give Access : <span id="showSingleMsg<?=$info->role_id?>">
	<? if($preAccess[$info->role_id]<1){?>
	<input type="button" name="btn" onclick="setAccess('<?=$access?>','<?=$info->role_id?>')" value="Click Here" class="btn btn-warning" />
	<? }else{?>
	<input type="button" name="btn"  value="Saved" class="btn btn-primary" />
	<? } ?>
	
	</span></span></div></td>
  </tr>
	</thead>



<tbody class="tbody1">

<?


$sqls = 'select m.module_name,f.feature_name,p.page_name from roll_details s,user_module_manage m, user_feature_manage f,user_page_manage p where s.module_id=m.id and s.feature_id=f.id and s.page_id=p.id and s.role_id="'.$info->role_id.'" ';

$querys = db_query($sqls);
$counts = mysqli_num_rows($querys);

while($infos = mysqli_fetch_object($querys)){



//$find = find_all_field('user_roll_activity','','user_id="'.$user_id.'" and page_id="'.$infos->id.'"');



?>



<tr  <? if((++$i%2)==0) echo 'bgcolor="#99FFCC"'; else echo 'bgcolor="#C1F0FF"';?>>



<td align="left" valign="middle">&nbsp;&nbsp;- <?=$infos->module_name?> -> <?=$infos->feature_name?> -> <?=$infos->page_name?></td>



<td valign="middle"><div align="center"></div></td>
</tr>



<? }?>
</tbody>
</table>







   	<? }} ?>



			



			



          </div>
          
          <br>
            <span class="btn btn-warning" onclick="updatingAll()">UPDATE</span>
          
          </div>



          </div>



    </div>





</form>







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


<script>

    function setAccess(user,role_id){
	 getData2('single_role_save_ajax.php','showSingleMsg'+role_id,user,role_id);
	}
    
    function select_all(perm){
       document.getElementById("access"+perm).checked = true;
       document.getElementById("add"+perm).checked = true;
       document.getElementById("edit"+perm).checked = true;
       document.getElementById("delete"+perm).checked = true;
    }
    
    function remove_all(perm){
       document.getElementById("access"+perm).checked = false;
       document.getElementById("add"+perm).checked = false;
       document.getElementById("edit"+perm).checked = false;
       document.getElementById("delete"+perm).checked = false;
    }
    
</script>