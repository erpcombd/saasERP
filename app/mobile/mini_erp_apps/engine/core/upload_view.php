<?php
	
     $file = '../../../../../mvc_media/'.htmlspecialchars($_GET["proj_id"]).'/'.htmlspecialchars($_GET["folder"]).'/'. htmlspecialchars($_GET["name"]);


	$check  =explode('.',$_GET['name']);
	$ch = strtolower($check[1]);
	
	if($ch=='pdf'){
		header("Content-type:application/pdf");
	}elseif($ch=='jpg'){
	header('Content-Type: image/jpg');
	}elseif($ch=='png'){
	header('Content-Type: image/png');
	}elseif($ch=='PNG'){
	header('Content-Type: image/PNG');
	}elseif($ch=='jpeg'){
	header('Content-Type: image/jpeg');
	
	}elseif($ch=='JPEG'){
	header('Content-Type: image/JPEG');
	}elseif($ch=='xlsx'){
	   header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	   header('Content-Disposition: attachment; filename="' . basename($_GET['name']) . '"');
	}elseif($ch=='docx'){
	   header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
	   header('Content-Disposition: attachment; filename="' . basename($_GET['name']) . '"');
	}elseif($ch=='csv'){
	   header('Content-Type: text/csv');
	   header('Content-Disposition: attachment; filename="' . basename($_GET['name']) . '"');
	}
	
	    

    readfile($file);
?>
