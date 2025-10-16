<?php 

@mysqli_connect("localhost", "bdnews_master", "master123");

@mysqli_select_db('bdnews_master');

$select = 'select sl,xdate from  hrm_attdump where 1';
$query = db_query($select);
while($data=mysqli_fetch_object($query)){

if($data->xdate);

}


?>



<!DOCTYPE html>

<html>

<head>

	<meta charset="utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<title>Weekly Attendence Report</title>

	<link rel="stylesheet" href="bootstrap.min.css">

	<script src="jquery.min.js" type="text/javascript" charset="utf-8" async defer></script>

	<script src="bootstrap.min.js" type="text/javascript" charset="utf-8" async defer></script>

</head>

</style>

<body>

</br>

<div class="container">

	<form action="#" method="POST" accept-charset="utf-8">

		<div class="form-group">
		    <div class="row">

		

		<h2>Date Start</h2>	<input style="width:180px" type="date" name="start_date" id="start_date" value="<?=$_POST['start_date']?>" class="form-control"/>

	
				&nbsp;<h2>Date end</h2><input style="width:180px " type="date" name="end_date" id="end_date" value="<?=$_POST['end_date']?>" class="form-control"/>
			</div>

		</div>

		

		<button type="submit" name="submit" class="btn btn-success">Show</button>

	</form>

</br>

<!-- table............. -->

<?php 
 
  if(isset($_POST['submit'])){





 ?>
<form action="" method="post">
<table class="table table-responsive table-bordered table-striped table-hover">

	<thead>
	    
	    	<thead>
	 		<tr>
				<th>Emoloyee Name</th>
				<th>Present</th>
				<th>Late</th>
				<th>Leave</th>
				<th>Absent</th>
			</tr>
	 	</thead>
	    
	    
<!--
		<tr>
		     
			 <th  scope="col">Select</th>

			<th scope="col">Date</th>

			<th scope="col">Employee Name</th>
			
			<th scope="col">In Time</th>
			
			<th scope="col">Out Time</th>
			<th scope="col">Task Entry</th>

			<th scope="col" >Project ID</th>

		</tr>
-->
	</thead>

	<tbody>
	
	<?php
	$i=1; 
	 $sql = "select p.PBI_ID,p.PBI_NAME from  personnel_basic_info p,hrm_attdump h where 1 and p.PBI_JOB_STATUS='In Service' and p.PBI_ID=h.bizid and h.xdate between '".$_POST['start_date']."' and '".$_POST['end_date']."' group by h.bizid ";
	  $query=db_query($sql);
	
     while($result=mysqli_fetch_object($query)){
	 
	  //$new =  mysqli_num_rows($query);
	 // find_a_field('hrm_attdump', 'time(min(ztime))', 'xdate="'.$row->schedule.'" and bizid = '.$row->impid.'')
	  
	  $sqld = 'select count(schedule) as sch from  schedule_setup_new where schedule between "'.$_POST['start_date'].'" and "'.$_POST['end_date'].'" and prjid not in (40) and impid= '.$result->PBI_ID;
	 $n_query = db_query($sqld);
	 $count = mysqli_fetch_object($n_query);
	 
	   $sqllate = 'select count(xdate) as lt from  hrm_attdump where time(min(ztime))>="10:00:01" and time(min(ztime))<="10:45:00" xdate  between "'.$_POST['start_date'].'" and "'.$_POST['end_date'].'" and bizid= '.$result->PBI_ID;
	 $querylate = db_query($sqllate);
	 $count_late = mysqli_fetch_object($querylate);
	
	?>
		<tr>
				<td><?php echo $result->PBI_NAME;?></td>
				<td><?php echo $count->sch; ?> days</td>
				<td><?php echo $count_late->lt; ?> days</td>
				<td>0</td>
				<td>0</td>
		</tr>
	
	

	<!--	<tr <?php if($result->intime > $result->xdate.' 10:30:00'){echo "style='color:#FF0000'";}elseif($result->intime > $result->xdate.' 10:00:00'&&$result->intime<$result->xdate.' 10:30:00'){echo "style='background-color:#FFFF99;color:black'";}else{} ?>>
		     <td><input name="choose[]" id="choose" value="<?php echo $result->id;?>" type="checkbox"/></td>

		<th scope="row"><?php echo $result->xdate;?></th>

			<td><?php echo $result->PBI_NAME;?></td>
			
			<td><?php echo $result->intime;?></td>
            
			<td><?php echo $result->outtime;?></td>
			<td></td>

			<td><?php echo $result->PROJECT_NAME;?></td>

		</tr>-->
<?php } ?>
		

	</tbody>

</table>

<!--
<button type="submit" name="send" class="btn btn-success">Send Massege</button>-->
</form>
<?php }?>
<?php if(isset($_POST['send'])){  $id=$_POST['choose'];
         $c=0;
         foreach ($id as $choose){ 
		   
		   
		   if($c==0)
           $ch .= $choose;
		 else
		 $ch.=",".$choose;
		 $c++;
		  }// echo $ch; 
		  
		//echo $sql = "SELECT s.id, s.schedule, s.impid, s.prjid,p.PBI_NAME,b.PROJECT_NAME FROM schedule_setup_new s,project b,personnel_basic_info p WHERE 1 and p.PBI_ID=s.impid and s.prjid=b.PROJECT_ID and s.id in (".$ch.")";
    // $query=db_query($sql);
    // while($result=mysqli_fetch_object($query)){  echo $result->PROJECT_NAME; }
		  
}?>

</div>

</body>

</html>