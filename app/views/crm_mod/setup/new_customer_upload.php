<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
 

if(isset($_POST['done'])){
		
		$filename=$_FILES["att_file"]["tmp_name"];
		$filename2=$_FILES["att_file"]["name"];
		$end = explode(".",$filename2);
		if($end[1]=='csv'){
     	if($_FILES["att_file"]["size"] > 0){
          
		      $file = fopen($filename, "r");



			  $count = 0;


          	  while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)



           	  {



			  $count++; 
              $check = find_a_field('crm_customer_info','dealer_code','dealer_name_e="'.$getData[0].'"');



			  if($count>1 && $check==0)
        
  

			  {
	    $user_pbi_id = find_a_field('personnel_basic_info','PBI_ID','PBI_CODE="'.$getData[8].'"');
		$crud   = new crud('crm_customer_info');
        $_POST['dealer_name_e']= $getData[0];
		$_POST['organization']= $getData[0];
		$_POST['contact_person']= $getData[1];
		$_POST['designation']= $getData[2];
		$_POST['address_e']= $getData[3];
		$_POST['tel_no']= $getData[4];
		$_POST['mobile_no']= $getData[5];
		$_POST['email']= $getData[6];
		$_POST['website']= $getData[7];
		$_POST['employee_code']= $getData[8];
		$_POST['entry_type']= 'Excel';
		$_POST['entry_by']= $user_pbi_id;
		$inserted = $crud->insert();
		
		

			  } 

			  }
              if($inserted){
			   echo '<span style="color:green; font-weight:bold;">File uploaded successfully.</span>';
			  }
			  fclose($file);  

			  } 
}
else{
echo '<span style="color:red; font-weight:bold;">Sorry! Invalid File Format. Please Download Example File</span>';
}
}

?>
<form method="post" enctype="multipart/form-data">
 <input type="file" name="att_file" id="att_file" class="form-control" required />
 <input type="submit" name="done" id="done" value="Upload" class="btn btn-success" />
 <br />
 <br />
 <a href="new_crm_client.csv" style="background:#999; color:#fff; text-decoration:underline;" download>Click Here To Download Example File.</a>
</form>
<?



require_once SERVER_CORE."routing/layout.bottom.php";
?>
