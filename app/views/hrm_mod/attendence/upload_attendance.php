<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title="Upload Attendance (EXCEL)";


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



   

		//$crud   = new crud('hrm_attdump');

        $xdate = date('Y-m-d',strtotime($getData[1]));

		$pbi_id = find_a_field('personnel_basic_info','PBI_ID','PBI_ID="'.$getData[0].'"');

	   	$entry_time = date('Y-m-d H:i:s',strtotime($getData[1]));



// 		$_POST['bizid']= $pbi_id;



// 		$_POST['ztime'] = $entry_time;

		

// 		$_POST['xtime'] = $entry_time;



// 		$_POST['xmechineid'] = $getData[2];



// 		$_POST['xenrollid'] = $pbi_id;

		

// 		$_POST['xdate'] = $xdate;



		//$inserted = $crud->insert();
		
				
	 $sql="INSERT INTO hrm_attdump 
 (bizid, ztime,xtime,xmechineid,xdate,EMP_CODE)
  VALUES 

('".$pbi_id."','".$entry_time."', '".$entry_time."','".$getData[2]."', '".$xdate."', '".$pbi_id."')";
$inserted=db_query($sql);



		if($inserted){

		 $row_count +=1; 

		}





			  } 



			  }

              if($row_count>0){

			  echo $msg = '<span style="color:green; font-weight:bold;">Success. Total '.$row_count.' Row Inserted.</span>';

			  }else{

			  echo $msg = '<span style="color:red; font-weight:bold;">Try again!</span>';

			  }

			  fclose($file);  



			  }



}



?>










<form method="post"  enctype="multipart/form-data">

	<div class="d-flex justify-content-center">

		<div class="n-form1 fo-width pt-0">
			<h4 class="text-center bg-titel bold pt-2 pb-2"> File Upload   </h4>
			<div class="container-fluid p-0">

				<div class="container">

					<div class="form-group row  m-0 mb-1 pl-3 pr-3">
						<label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Selected File:  </label>
						<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">
							<input type="file" name="att_file" id="att_file" required/>
						</div>
					</div>

				</div>


				<div class="n-form-btn-class">
					<input type="submit" name="done" id="done" class="btn1 btn1-bg-submit" value="Upload" />
				</div>

				<div class="n-form-btn-class">
					<a href="../files/attendence.csv" style="text-decoration:underline;">Download csv format</a>
				</div>


			</div>

		</div>

	</div>




</form>






<?
    require_once SERVER_CORE."routing/layout.bottom.php";
?>
