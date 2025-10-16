<?php 

//@mysqli_connect("localhost", "bdnews_master", "master123");
//
//@mysqli_select_db('bdnews_master');




 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

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

<div class="container">

	<form action="#" method="POST" accept-charset="utf-8">

		<div class="form-group">

			<label for="scld">Schedule Date :</label>

			<input style="width:180px" type="date" name="scld" id="scld" value="" class="form-control"/>

		
			

		</div>

		

		<button type="submit" name="submit" class="btn btn-success">Show</button>

	</form>

</br>

<!-- table............. -->

<?php 
 
  if(isset($_POST['submit'])){

 $sql = "SELECT  distinct h.xdate, (SELECT ztime FROM hrm_attdump WHERE bizid=p.PBI_ID and xdate='".$_POST['scld']."' LIMIT 1) as intime,(SELECT xtime FROM hrm_attdump WHERE bizid=p.PBI_ID and xdate='".$_POST['scld']."' order by sl desc LIMIT 1) as outtime,(SELECT pr.PROJECT_NAME from project pr,schedule_setup_new sc WHERE sc.prjid=pr.PROJECT_ID and sc.impid=p.PBI_ID and sc.schedule=h.xdate limit 1) as PROJECT_NAME,  project_id,p.PBI_NAME FROM personnel_basic_info p,hrm_attdump h WHERE 1 and h.bizid=p.PBI_ID and h.xdate='".$_POST['scld']."'";



 ?>
<form action="" method="post">
<table class="table table-bordered table-dark">

	<thead>

		<tr>
		     
			 <th  scope="col">Select</th>

			<th scope="col">Date</th>

			<th scope="col">Employee Name</th>
			
			<th scope="col">In Time</th>
			
			<th scope="col">Out Time</th>
			<th scope="col">Task Entry</th>
			<th scope="col" >IP Address</th>
             <th scope="col" >Location</th>
			<th scope="col" >Project ID</th>
		</tr>
	</thead>

	<tbody>
	
	<?php 
	  $query=db_query($sql);
     while($result=mysqli_fetch_object($query)){
	
	?>

		<tr <?php if($result->intime > $result->xdate.' 10:30:00'){echo "style='color:white;background-color:red;'";}elseif($result->intime > $result->xdate.' 10:00:00'&&$result->intime<$result->xdate.' 10:30:00'){echo "style='background-color:#FFFF99;color:black'";}else{ echo "style='color:black;background-color:#9ED68A;'";} ?>>
		     <td><input name="choose[]" id="choose" value="<?php echo $result->id;?>" type="checkbox"/></td>

			<th scope="row"><?php echo $result->xdate;?></th>

			<td><?php echo $result->PBI_NAME;?></td>
			
			<td><?php echo $result->intime;?></td>
            
			<td><?php echo $result->outtime;?></td>
			<td><?php echo $result->location;?></td>
			
			<td><?php echo $result->ip_address;?></td>

			<td><?php echo $result->PROJECT_NAME;?></td>
			<td> <?php echo $result->project_id;?></td>
		</tr>
<?php } ?>
	</tbody>
</table>

<button type="submit" name="send" class="btn btn-success">Send Massege</button>
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