<?php
session_start();

require_once("../../config/default_values.php");
require_once('../../config/db_connect_scb_main.php');
require "../../template/log_link.php";

if(isset($_POST['submit'])){
  $note = $_POST['note'];
  
  $up = mysql_query('update welcome_note set note="'.$note.'" where id=1');
  
 
}

if(isset($_POST['submit2'])){
 
   $file_name = $_FILES['att_file']['name'];
                    $file_size = $_FILES['att_file']['size'];
                    $file_temp = $_FILES['att_file']['tmp_name'];

                    $div = explode('.', $file_name);
                    $file_ext = strtolower(end($div));
                    $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
				    $uploaded_image = "file/home/".$unique_image;
					
					
move_uploaded_file($file_temp,$uploaded_image);
  
  $up2 = mysql_query('insert into welcome_images(`att_file`,`status`) value("'.$uploaded_image.'","UNPUBLISHED")');
  
 
}

if(isset($_POST['submit3'])){
    
	$att_file_name = $_POST['file_name'];
	$type = $_POST['type'];
	
   if($_FILES['policy_file']['tmp_name']!=''){
   $file_name = $_FILES['policy_file']['name'];
                    $file_size = $_FILES['policy_file']['size'];
                    $file_temp = $_FILES['policy_file']['tmp_name'];

                    $div = explode('.', $file_name);
                    $file_ext = strtolower(end($div));
                    $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
					$uploaded_image = "file/".$unique_image;
					
					
           move_uploaded_file($file_temp,$uploaded_image);
  
    if(!empty($att_file_name)){
  
$up2 = mysql_query('insert into policy(`file_name`,`type`,`att_file`) value("'.$att_file_name.'","'.$type.'","'.$uploaded_image.'")');
    
	if($up2){
	$msg = '<span class="btn btn-success">Policy Saved</span>';
	}else{
	$msg = '<span class="btn btn-danger">Policy Not Saved</span>';
	}
   }else{
     $msg = '<span class="btn btn-danger">Please Enter Policy Name</span>';
   }
  }else{
     $msg = '<span class="btn btn-danger">Invalid Upload</span>';
  }
 
}


if(isset($_POST['submit4'])){
    
	$att_file_name2 = $_POST['file_name2'];
	$type2 = $_POST['type2'];
	
   if($_FILES['policy_file2']['tmp_name']!=''){
   $file_name = $_FILES['policy_file2']['name'];
                    $file_size = $_FILES['policy_file2']['size'];
                    $file_temp = $_FILES['policy_file2']['tmp_name'];

                    $div = explode('.', $file_name);
                    $file_ext = strtolower(end($div));
                    $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
					$uploaded_image = "file/".$unique_image;
					
					
           move_uploaded_file($file_temp,$uploaded_image);
  
    if(!empty($att_file_name2)){
  
$up2 = mysql_query('insert into policy(`file_name`,`type`,`att_file`) value("'.$att_file_name2.'","'.$type2.'","'.$uploaded_image.'")');
    
	if($up2){
	$msg = '<span class="btn btn-success">Notice Published</span>';
	}else{
	$msg = '<span class="btn btn-danger">Notice Not Saved</span>';
	}
   }else{
     $msg = '<span class="btn btn-danger">Please Enter Notice Name</span>';
   }
  }else{
     $msg = '<span class="btn btn-danger">Invalid Upload</span>';
  }
 
}






if(isset($_POST['submit5'])){
    
	$att_file_name3 = $_POST['file_name3'];
	$type3 = $_POST['type3'];
	
   if($_FILES['policy_file3']['tmp_name']!=''){
   $file_name = $_FILES['policy_file3']['name'];
                    $file_size = $_FILES['policy_file3']['size'];
                    $file_temp = $_FILES['policy_file3']['tmp_name'];

                    $div = explode('.', $file_name);
                    $file_ext = strtolower(end($div));
                    $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
					$uploaded_image = "file/".$unique_image;
					
					
           move_uploaded_file($file_temp,$uploaded_image);
  
    if(!empty($att_file_name3)){
  
$up2 = mysql_query('insert into policy(`file_name`,`type`,`att_file`) value("'.$att_file_name3.'","'.$type3.'","'.$uploaded_image.'")');
    
	if($up2){
	$msg = '<span class="btn btn-success">Notice Published</span>';
	}else{
	$msg = '<span class="btn btn-danger">Notice Not Saved</span>';
	}
   }else{
     $msg = '<span class="btn btn-danger">Please Enter Notice Name</span>';
   }
  }else{
     $msg = '<span class="btn btn-danger">Invalid Upload</span>';
  }
 
}











if($_GET['del']>0){
   
   mysql_query('delete from policy where id='.$_GET['del']);
 
}


if($_GET['delete']>0){
   
   mysql_query('delete from welcome_images where id='.$_GET['delete']);
 
}

if($_GET['update']>0){
   
   mysql_query('update welcome_images set status="UNPUBLISHED" where 1');
   mysql_query('update welcome_images set status="PUBLISHED" where 1 and id='.$_GET['update']);
 
}


  $select = 'select note from welcome_note where id=1';
 $qr = mysql_query($select);
  $data = mysql_fetch_object($qr);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  
  <style>.frame {
	text-align: center;	
	position: relative;
	cursor: pointer;	
	perspective: 500px; 
}
.frame img {
	width: 300px;
	
}
.frame .details {
	width: 70%;
	height: 80%;	
	padding: 5% 8%;
	position: absolute;
	content: "";
	top: 50%;
	left: 50%;
	transform: translate(-50%, -50%) rotateY(90deg);
	transform-origin: 50%;
		
	opacity: 0;
	transition: all 0.4s ease-in;
	
}
.frame:hover .details {
	transform: translate(-50%, -50%) rotateY(0deg);
	opacity: 1;
}</style>
</head>
<body>

<div class="container" style="width:600px;">
  <h2>Welcome Note & Image Update From </h2>
  <form action="" method="post" enctype="multipart/form-data">
  <div align="center"><?php echo $msg;?></div><br>
    <div class="form-group">
      <label for="note"></label>
      <input type="text" class="form-control" id="note"  name="note" value="<?php echo $data->note;?>" style="width:70%; float:left;"> <input type="submit" name="submit" value="Welcome Note" class="btn btn-success" style="width:28%; float:right;" />
    </div>
    <div class="form-group">
      <label for="att_file"></label>
      <input type="file" class="form-control" id="att_file" name="att_file" style="width:70%; float:left;" /> <input type="submit" name="submit2" value="Login Screen" class="btn btn-success" style="width:28%; float:right;"  />
    </div>
	
	<div class="form-group">
      <label for="att_file"></label>
	  <input type="hidden" name="type" value="policy" >
      <input type="text" class="form-control" id="file_name" name="file_name" style="width:40%; float:left;" placeholder="Policy Name.." /> <input type="file" class="form-control" id="policy_file" name="policy_file" style="width:30%; float:left;" /> <input type="submit" name="submit3" value="Policy" class="btn btn-success" style="width:28%; float:right;"  />
    </div>
	
	
	
	<div class="form-group">
      <label for="att_file"></label>
	   <input type="hidden" name="type2" value="notice" >
      <input type="text" class="form-control" id="file_name2" name="file_name2" style="width:40%; float:left;" placeholder="Notice" /> <input type="file" class="form-control" id="policy_file2" name="policy_file2" style="width:30%; float:left;" /> <input type="submit" name="submit4" value="Notice" class="btn btn-success" style="width:28%; float:right;"  />
    </div>
	
	
	<div class="form-group">
      <label for="att_file"></label>
	  <input type="hidden" name="type3" value="form" >
      <input type="text" class="form-control" id="file_name3" name="file_name3" style="width:40%; float:left;" placeholder="Form Name.." /> <input type="file" class="form-control" id="policy_file3" name="policy_file3" style="width:30%; float:left;" /> <input type="submit" name="submit5" value="Form" class="btn btn-success" style="width:28%; float:right;"  />
    </div>
	
	
	
	
	 </form>
</div>
<div class="container">
<div class="row">
<div class="col-md-12">
<div class="form-group"> 

 <?
	  $select2 = 'select * from welcome_images ';
   $qr2 = mysql_query($select2);
   while($data2 = mysql_fetch_object($qr2)){

	?>
				<div style="margin-top:20px; float:left;">
 
  <div class = "frame"><img src="<?php echo  $data2->att_file?>" style="width:300px; height:200px;;">
			<div class = "details">
				
				<a href="?update=<?php echo $data2->id;?>" class="btn btn-warning">Upload</a><br><br><a href="?delete=<?php echo $data2->id;?>" class="btn btn-danger">Delete</a></div></div>
				</div>
				<?php } ?>
				
				
				
			</div>
			
		</div></div>
		</div>
		

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
 <div class="row">
 
 
 <div class="col-md-4">
  <h2 class="text-center">Policy</h2>
  <table class="table">
    <thead>
      <tr>
        <th>ID</th>
        <th>File</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
	<?
	  $select2 = 'select * from policy where 1 and type="policy"';
   $qr2 = mysql_query($select2);
   while($data2 = mysql_fetch_object($qr2)){

	?>
      <tr>
        <td><?php echo ++$i;?></td>
        <td><?php echo $data2->file_name?></td>
        <td><a href="?del=<?php echo $data2->id;?>">X</a></td>
      </tr>
     <? } ?>
    </tbody>
  </table>
  </div>
  
  <div class="col-md-4">
  <h2 class="text-center">Notice</h2>
  <table class="table">
    <thead>
      <tr>
        <th>ID</th>
        <th>File</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
	<?
	  $select2 = 'select * from policy where 1 and type="notice"';
   $qr2 = mysql_query($select2);
   while($data2 = mysql_fetch_object($qr2)){

	?>
      <tr>
        <td><?php echo ++$j;?></td>
        <td><?php echo $data2->file_name?></td>
        <td><a href="?del=<?php echo $data2->id;?>">X</a></td>
      </tr>
     <? } ?>
    </tbody>
  </table>
  </div>
  
  
  
  <div class="col-md-4">
  <h2 class="text-center">Form Name</h2>
  <table class="table">
    <thead>
      <tr>
        <th>ID</th>
        <th>File</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
	<?
	  $select2 = 'select * from policy where 1 and type="form"';
   $qr2 = mysql_query($select2);
   while($data2 = mysql_fetch_object($qr2)){

	?>
      <tr>
        <td><?php echo ++$i;?></td>
        <td><?php echo $data2->file_name?></td>
        <td><a href="?del=<?php echo $data2->id;?>">X</a></td>
      </tr>
     <? } ?>
    </tbody>
  </table>
  </div>
  
  
  
  
  
</div>
</div>

</body>
</html>

</body>
</html>
        
        
        
    

          

                     
        