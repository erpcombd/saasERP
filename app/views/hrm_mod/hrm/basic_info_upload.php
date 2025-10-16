<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

if(isset($_POST['done'])){
		
		$filename=$_FILES["att_file"]["tmp_name"];
     	if($_FILES["att_file"]["size"] > 0){

		      $file = fopen($filename, "r");



			  $count = 0;


          	  while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)



           	  {



			  $count++; 



			  $msg= "";



			  if($count>1)
        


			  {

    $desg_check = find_a_field('designation','DESG_ID','DESG_DESC = "'.$getData[2].'"');
	if($desg_check>0){
	 $desg = $desg_check;
	}else{
	 $insert_desg = 'insert into designation (`DESG_DESC`) value("'.$getData[2].'")';
	 db_query($insert_desg);
	 $desg = mysqli_insert_id();
	}
	
	$dept_check = find_a_field('department','DEPT_ID','DEPT_DESC = "'.$getData[3].'"');
	if($dept_check>0){
	 $dept = $dept_check;
	}else{
	 $insert_dept = 'insert into department (`DEPT_DESC`) value("'.$getData[3].'")';
	 db_query($insert_dept);
	 $dept = mysqli_insert_id();
	}



		$crud   = new crud('personnel_basic_info');


		$_POST['PBI_CODE']= $getData[0];

		$_POST['pass'] = $getData[0];

		$_POST['PBI_NAME'] = $getData[1];

		$_POST['PBI_DESIGNATION'] = $desg;

		$_POST['PBI_DEPARTMENT'] = $dept;

		$_POST['EMPLOYMENT_TYPE'] = $getData[4];

		$_POST['PBI_SEX'] = $getData[5];

		$_POST['PBI_RELIGION'] = $getData[6];
		
		$_POST['PBI_MOBILE'] = $getData[7];
		
		$_POST['PBI_EMAIL'] = $getData[8];



		$crud->insert();


			  } 

			  }

			  fclose($file);  

			  }

}

?>
<form method="post" enctype="multipart/form-data">
 <input type="file" name="att_file" id="att_file" />
 <input type="submit" name="done" id="done" value="Upload" />
</form>
<?



require_once SERVER_CORE."routing/layout.bottom.php";
?>
