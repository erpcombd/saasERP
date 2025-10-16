<?php 

//@mysqli_connect("localhost", "bdnews_master", "master123");
//
//@mysqli_select_db('bdnews_master');



 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
//do_calander('#scld');
if($_GET['del'] >0){
     $sql="delete from schedule_setup_new where id='".$_GET['del']."'";  
	 $query=db_query($sql); 
}


$scld=date('Y-m-d');

if(isset($_POST['show'])){
  
   $scld=$_POST['scld'];
   
   }
if(isset($_POST['submit'])){
     
	
    $scld=$_POST['scld'];

    $empid=$_POST['empid'];

    $prjid=$_POST['prjid'];








$sql = "INSERT INTO schedule_setup_new(schedule, impid, prjid,note)";

$sql.="VALUES('$scld', '$empid', '$prjid','".$_POST['note']."')";

$connection=db_query($sql);

if ($connection) {

	//echo "New record created successfully";

} else {

	echo "Error: " . $sql . "<br>" . $conn->error;

}

}



?>



<!DOCTYPE html>

<html>

<head>

	<meta charset="utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<title>Schedule Management</title>

	<link rel="stylesheet" href="bootstrap.min.css">

	<script src="jquery.min.js" type="text/javascript" charset="utf-8" async defer></script>

	<script src="bootstrap.min.js" type="text/javascript" charset="utf-8" async defer></script>

</head>

</style>

<body>

</br>

<div style="border:2px solid #6D89A2; padding: 20px" class="container" width="80%">

	<form action="#" method="POST" accept-charset="utf-8" >

		<div class="form-group">
		    <div align="right"><a href="report.php" target="_blank"><strong>View Attendance Report</strong></a></div>

			<label for="scld">Schedule Date :</label>

			<input type="date" name="scld" id="scld" value="<?php // echo $scld=date('Y-m-d');?>" class="form-control"/>

		</div>

		<div class="form-group">

			<label for="empid">Employee ID :</label>

			<select name="empid" id="empid" class="form-control">
			
			 <?php $sql='select PBI_ID,PBI_NAME,PBI_MOBILE FROM personnel_basic_info WHERE PBI_JOB_STATUS LIKE "In Service"';
			       $query=db_query($sql);
				   while($result=mysqli_fetch_object($query)){
			  ?>
			  <option value="<?php echo $result->PBI_ID;?>"><?php echo $result->PBI_NAME;?></option>
			  <? }?>
			</select>

		</div>

		<div class="form-group">

			<label for="prjid">Project ID :</label>

			
			
			<select name="prjid" id="prjid" class="form-control">
			
			 <?php $sql='select PROJECT_ID,PROJECT_NAME FROM project WHERE 1 ORDER BY PROJECT_ID desc';
			       $query=db_query($sql);
				   while($result=mysqli_fetch_object($query)){
			  ?>
			  <option value="<?php echo $result->PROJECT_ID;?>"><?php echo $result->PROJECT_NAME;?></option>
			  <? }?>
			</select>

		</div>
		
		<div class="form-group">
		   

			<label for="scld">Note :</label>

			<input type="text" name="note" id="note" value="" class="form-control"/>

		</div>

		<button type="submit" name="submit" class="btn btn-success">Submit</button>&nbsp;&nbsp;
		
		<button type="submit" name="show" class="btn btn-success">show</button>&nbsp;&nbsp;
		
		<button type="submit" name="delete" class="btn btn-success">Delete</button>
		
		

	</form>
     
</br>

<!-- table............. -->



<?php 

  $sql = "SELECT s.id, s.schedule, s.impid, s.prjid,p.PBI_NAME,b.PROJECT_NAME FROM schedule_setup_new s,project b,personnel_basic_info p WHERE 1 and p.PBI_ID=s.impid and s.prjid=b.PROJECT_ID and s.schedule='".$scld."'";



 ?>
<form action="" method="post">
<table class="table table-bordered table-dark">

	<thead>

		<tr>
		     
			 <th scope="col">Select</th>

			<th scope="col">Date</th>

			<th scope="col">Employee ID</th>

			
			<th scope="col">Project ID</th>
			<th scope="col">Action</th>
		</tr>
	</thead>

	<tbody>
	
	<?php 
	  $query=db_query($sql);
     while($result=mysqli_fetch_object($query)){
	
	?>

		<tr>
		     <td><input name="choose[]" id="choose" value="<?php echo $result->id;?>" type="checkbox"/></td>

			<th scope="row"><?php echo $result->schedule;?></th>

			<td><?php echo $result->PBI_NAME;?></td>

			
			<td><?php echo $result->PROJECT_NAME;?></td>
			<td><a href="?del=<?php echo $result->id;?>" >Delete</a></td>
		</tr>

<?php }?>		
	</tbody>
</table>



<button type="submit" name="send" class="btn btn-success">Send Massege</button>


</form>


<?php if(isset($_POST['send'])){  $id=$_POST['choose'];
         $c=0;
         foreach ($id as $choose){ 
		   
		   
		   if($c==0)
           $ch .= $choose;
		 else
		 $ch.=",".$choose;
		 $c++;
		  }  $ch; 


  function sms($dest_addr,$sms_text){

           $url = "http://api.rankstelecom.com/api/v3/sendsms/plain?user=ERPCOM&password=Ui0gXQcJ";

           $sms_text="&SMSText=".$sms_text;

           $gsm="&gsm=".$dest_addr;

            $postdata=$url.$sms_text.$gsm;



//echo $postdata;

           $ch = curl_init($url);

// Set the request type to POST

          curl_setopt($ch, CURLOPT_POST, true);

// Pass the post parameters as a naked string

         curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);

// Option to Return the Result, rather than just true/false

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Perform the request, and save content to $result

       $result = curl_exec($ch);

// Show the result?

//echo $result;

}



		  
	 $sql = "SELECT s.id, s.schedule, s.impid, s.prjid,p.PBI_NAME,p.PBI_MOBILE,b.PROJECT_NAME,s.note FROM schedule_setup_new s,project b,personnel_basic_info p WHERE 1 and p.PBI_ID=s.impid and s.prjid=b.PROJECT_ID and s.id in (".$ch.")";
     $query=db_query($sql);
     while($result=mysqli_fetch_object($query)){   $result->PBI_MOBILE; 






  //Message

   

 
           $note=$result->note;
            

			 //$recipients='+88'.$phone_no->PBI_MOBILE;

			
             $recipients='+88'.$result->PBI_MOBILE;
			

			$massage ="Dear ".$result->PBI_NAME.", \r\n";

			$massage.="Tomorrow (".$result->schedule.") you will go to ".$result->PROJECT_NAME.", \r\n";

			$massage.="Note : ".$note.". \r\n";

             $sms_result=sms($recipients,$massage); 

			 

   //Message





 }
		  
}?>

</div>

</body>

</html>



