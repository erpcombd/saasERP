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

   
		$crud   = new crud('hrm_attdump');
        $xdate = date('Y-m-d',strtotime($getData[1]));
		$pbi_id = $getData[0];
		$entry_time = date('Y-m-d h:i:s',strtotime($getData[1]));

		$_POST['bizid']= $pbi_id;

		$_POST['ztime'] = $entry_time;
		
		$_POST['xtime'] = $entry_time;

		$_POST['xmechineid'] = $getData[2];

		$_POST['xenrollid'] = $pbi_id;
		
		$_POST['xdate'] = $xdate;

		$inserted = $crud->insert();
		if($inserted){
		 $row_count +=1; 
		}


			  } 

			  }
              if($row_count>0){
			   $msg = '<span style="color:green; font-weight:bold;">Success. Total '.$row_count.' Row Inserted.</span>';
			  }else{
			   $msg = '<span style="color:red; font-weight:bold;">Try again!</span>';
			  }
			  fclose($file);  

			  }

}

?>
<div><?=$msg?></div>
<form method="post" enctype="multipart/form-data">
 <input type="file" name="att_file" id="att_file" required/>
 <input type="submit" name="done" id="done" value="Upload" />
 <div><a href="../files/attendence.csv" style="text-decoration:underline;">Download csv format</a></div>
</form>
<?



require_once SERVER_CORE."routing/layout.bottom.php";
?>
