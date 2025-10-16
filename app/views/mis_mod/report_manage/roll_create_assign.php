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












var strURL="roll_create_ajax.php?page_id="+page_id+"&access="+access+"&user_id="+user_id;







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





        <div class="oe_form_sheet oe_form_sheet_width">
		  	

<div class="container">



  <ul class="nav nav-tabs">

  <?php

  $sql_mod="select m.user_id,m.module_id,m.status,u.id,u.module_name from user_module_define m,user_module_manage u where m.user_id= '".$user_id."' and m.module_id=u.id and m.status='enable'";

  $que=db_query($sql_mod);

  while($mod=mysqli_fetch_assoc($que)){

  $module_id=$mod['module_id'];

  $module_name=$mod['module_name'];

  

   ?>

   

   <?php if($module_id==$get_module_id){ ?>



    <li class="active ml-1 mr-1 mt-3"><a href="roll_create_assign.php?user_id=<?php echo $user_id; ?>&module_id=<?php echo $module_id; ?> " class="btn1 btn1-bg-submit" ><?=$module_name;?></a></li>

<?php } else { ?>

 <li class="active ml-1 mr-1 mt-3"><a href="roll_create_assign.php?user_id=<?php echo $user_id; ?>&module_id=<?php echo $module_id; ?>  " class="btn1 btn1-bg-hrm" ><?=$module_name;?></a></li>

 <?php }} ?>

  </ul>
  
  <br><br>
  
  <span onclick="selectedAll()" class="btn" style="color:#242020;background-color:#80c4c7;border-color:#408d99;margin-bottom:12px;">CHECK ALL</span>
  <span onclick="RemoveAll()" class="btn" style="color: #ffffff;background-color: #ec4848;border-color: #994040;margin-bottom:12px;">REMOVE ALL</span>
</div>





          <div  class="oe_view_manager_view_list"><div  class="oe_list oe_view">



	   



        	<? if($access>0){



  $sql = 'select u.*,m.*,r.* from user_feature_manage u,user_module_define m,report_manage r where m.user_id="'.$user_id.'" and m.module_id=u.module_id and u.id=r.feature_id and r.status="Yes" and m.status="enable" and m.module_id="'.$get_module_id.'"';



$query = db_query($sql);
while($info = mysqli_fetch_object($query)){
 $sqls = 'select * from report_manage where feature_id = "'.$info->feature_id.'" ';
$querys = db_query($sqls);

$counts = mysqli_num_rows($querys);
}
if($counts>0){

while($infos = mysqli_fetch_object($querys)){

			?>


<table class="table1  table-striped table-bordered table-hover table-sm" border="0" cellspacing="0" cellpadding="0">

<thead class="thead1">

  <tr class="bgc-info">



    <th> <?=$infos->page_name?></td>



    <th width="8%" ><div align="center"><span class="style3">Access</span></div></td>





    <th width="8%" >&nbsp;</td>



    </tr>

	</thead>



<tbody class="tbody1">

<?











$find = find_all_field('user_report_access','','user_id="'.$user_id.'" and report_id="'.$infos->id.'"');



?>



<tr  <? if((++$i%2)==0) echo 'bgcolor="#99FFCC"'; else echo 'bgcolor="#C1F0FF"';?>>



<td align="left" valign="middle">&nbsp;&nbsp;- <?=$infos->report_name?> </td>



<td valign="middle"><div align="center">


<input type="hidden" name="info_id[]" id="info_id[]" value="<?=$infos->id?>">
<input type="checkbox"  name="access<?=$infos->id?>" id="access<?=$infos->id?>" value="1"  <?=($find->access>0)?'checked="checked";':'';?> />



</div></td>













<td valign="middle"><label>



<div id="pv<?=$infos->id?>">



  <input type="button" name="Submit" value="OK" class="btn1 btn1-bg-submit" onclick="access_update(<?=$infos->id?>)" /></div>
  <span class="btn1 btn-primary" onclick="select_all(<?=$infos->id?>)">Select All</span>
  <span class="btn1 btn-danger" onclick="remove_all(<?=$infos->id?>)">Remove All</span>



</label></td>



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

    function updatingAll(){
        $("input[name='info_id[]']").map(function(){
            access_update($(this).val());
        }).get();
    }

    function selectedAll(){

        $('input[type=checkbox]').prop('checked', true);
        
    }
	
	function RemoveAll(){

        $('input[type=checkbox]').prop('checked', false);
        
    }
    
    function select_all(perm){
       document.getElementById("access"+perm).checked = true;
    }
    
    function remove_all(perm){
       document.getElementById("access"+perm).checked = false;
    }
    
</script>