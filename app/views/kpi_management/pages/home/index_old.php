<?php

session_start();



require_once("../../config/default_values.php");

require_once('../../config/db_connect_scb_main.php');

require "../../template/log_link.php";







if(isset($_POST['ibssignin']))

{

	

	$uid  = $_POST['uid'];

	$passward = $_POST['pass'];

	

	if($_POST['uid']==$_POST['pass']){

	$uid=(int)$uid;

	$passward=(int)$passward;

	}else{

	$uid=(int)$uid;

	}

	

	$cid  = $_POST['cid'];



$sql="SELECT b.db_user,b.db_pass,b.db_name,a.cid,a.id FROM company_info a,database_info b WHERE a.cid='$cid' and a.id=b.company_id and a.status='ON' limit 1";



	$sql=@mysql_query($sql);

	if($proj=@mysql_fetch_object($sql))

	{





					$_SESSION['proj_id']	= $proj->cid;

					$_SESSION['db_name']	= $proj->db_name;

					$_SESSION['db_user']	= $proj->db_user;

					$_SESSION['db_pass']	= $proj->db_pass;

					

require_once "../../config/db_connect.php";		

$user_sql="select * from personnel_basic_info where  PBI_ID='$uid' AND pass = '$passward'";

		

				$user_query=mysql_query($user_sql);

				if(mysql_num_rows($user_query)>0)

				{

				$proj_sql="select * from project_info limit 1";

				$proj=@mysql_fetch_object(mysql_query($proj_sql));

				$info=@mysql_fetch_row($user_query);

				

					

			$_SESSION['user']['level']	= 1;

					$_SESSION['user']['id']	= $_SESSION['employee_selected'] = $info[0];

					$_SESSION['user']['fname']	= $info[4];

					

					$_SESSION['separator']='';

					$_SESSION['mhafuz']='Active';

					$_SESSION['voucher_type']=3;

					$_SESSION['user']['panel']='YES';

		

					

//add_user_activity_log($_SESSION['user']['id'],1,1,'Login Page','Succ4essfully Logged In',$_SESSION['user']['level']);



?>



<style>



</style>

<script>



    window.location.assign("../inventory/home.php")



</script>

<?

					

				}

		}



}

else

session_destroy();

?>











<?







 $sq = 'select note from welcome_note where id=1';

$qr = mysql_query($sq);



$dt = mysql_fetch_object($qr);





?>

















<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

<?

	  $select2 = 'select * from welcome_images where 1 and status="PUBLISHED" ';

   $qr2 = mysql_query($select2);

   $image = mysql_fetch_object($qr2);



	?>

<style>

  body{

  background-image: url("<?php echo $image->att_file;?>");



 

  }

</style>

<body class="login">



    

      <a class="hiddenanchor" id="signup"></a>

      <a class="hiddenanchor" id="signin"></a>



     

		  

<div class="container">

<div class="row">





<?php

  if($dt->note !=''){

?>

<div style="font:left; background:#00CCCC; height:auto; width:69%;"><marquee style="color:#fff; font-size:18px; font-weight:bold; font-family:bankgothic;" behavior="alternate" truespeed="truespeed" width="800px;"><?=$dt->note;?></marquee></div>

<?php } ?>



<div class="col-md-1"></div>

<div class="col-md-2">

<div class="dropdown" style="margin-top:80px; float: left">  



  <button class="btn btn-default dropdown-toggle"type="button" style="background-color:#395954; width:135px; color:#FFFFFF" data-toggle="dropdown" data-hover="dropdown" data-animations="bounceInRight fadeInLeft fadeInUp fadeInRight" onClick="myfunction()">

   POLICY <span class="caret"></span>

  </button>

  <div style="display:none;" id="show">

  <div class="dropdown-content">

  <?

	  $select2 = 'select * from policy where 1 and type="policy"';

   $qr2 = mysql_query($select2);

   while($data2 = mysql_fetch_object($qr2)){



	?>

    <a href="<?php echo $data2->att_file?>" class="btn btn-warning" style="width:135px" target="_blank"><?=$data2->file_name?></a><br>

   <? } ?>

  </div>

  </div>

  </div></div>

  

  

  





	

	

	

	<div class="col-md-2">

<div class="dropdown" style="margin-top:80px; float: left">  



  <button class="btn btn-default dropdown-toggle"type="button" style="background-color:#395954; color:#FFFFFF" data-toggle="dropdown" data-hover="dropdown" data-animations="bounceInRight fadeInLeft fadeInUp fadeInRight" onClick="myfunction2()">

   NOTICE BOARD <span class="caret"></span>

  </button>

  <div style="display:none;" id="show1">

  <div class="dropdown-content" align="center">

  <?

	  $select2 = 'select * from policy where 1 and type="notice"';

   $qr2 = mysql_query($select2);

   while($data2 = mysql_fetch_object($qr2)){



	?>

    <a href="<?php echo $data2->att_file?>" class="btn btn-warning" style="width:143px" target="_blank"><?=$data2->file_name?></a><br>

   <? } ?>

  </div>

  </div>

</div></div>











<div class="col-md-2">

<div class="dropdown" style="margin-top:80px; float: left">  



  <button class="btn btn-default dropdown-toggle"type="button" style="background-color:#395954; color:#FFFFFF" data-toggle="dropdown" data-hover="dropdown" data-animations="bounceInRight fadeInLeft fadeInUp fadeInRight" onClick="myfunction3()">

   <span style="padding:50px 38px 50px 38px">Forms</span> <span class="caret"></span>

  </button>

  <div style="display:none;" id="show2">

  <div class="dropdown-content" align="center">

  <?

	  $select2 = 'select * from policy where 1 and type="form"';

   $qr2 = mysql_query($select2);

   while($data2 = mysql_fetch_object($qr2)){



	?>

    <a href="<?php echo $data2->att_file?>" class="btn btn-warning" style="width:163px" target="_blank"><?=$data2->file_name?></a><br>

   <?php } ?>

  </div>

  </div>

</div></div>





   

<div class="col-sm-4" style="float:right">

	

	 <div class="login_wrapper">

	 

        <div class="animate form login_form">

		

		<section class="login_content" style="margin-left: 90px;"> 

		  

		  

      <form action="" method="post">

              

              <div>

                <input type="text" class="form-control" name="cid" placeholder="Company Name" required="" />

              </div>

              <div>

			  

               <input type="text" class="form-control" name="uid" placeholder="ID NO" required="" />

			   <input type="hidden" class="form-control" name="ibssignin" placeholder="User ID" required="" />

              </div>

			  

			  <div>

			  

                <input type="password" name="pass" class="form-control" placeholder="Password" required="" />

              </div>

              

			  

			  <form action="../../../" method="post">

			 

               <button name="submit" class="btn btn success">Sign In</button>

                <a class="reset_pass" href="#">Lost your password?</a>              

				

				<div style="float:right; margin-top:100px;"><a href="log.php" target="_blank"><i class="fa fa-gear fa-spin" style=" color:white; font-size:35px;"></i></a></div> 



              </form>

             

                  <!--<h1><i class="fa fa-home"></i> Chemtrek Industries</h1>

                  <p>©2019 All Rights Reserved. Erp.com.bd! is a Bootstrap 3 template. Privacy and Terms</p>-->

               

				

            </form>

			

    </div>

  </div>

</div>

</section>

</div>

</div>

		  

     <script>

function myfunction() {

  var x = document.getElementById("show");

  if (x.style.display === "none") {

    x.style.display = "";

  }else{

     x.style.display = "none";

  }

  

  

}





function myfunction2() {

  var x = document.getElementById("show1");

  if (x.style.display === "none") {

    x.style.display = "";

  }else{

     x.style.display = "none";

  }

  

  

}



function myfunction3() {

  var x = document.getElementById("show2");

  if (x.style.display === "none") {

    x.style.display = "";

  }else{

     x.style.display = "none";

  }

  

  

}







</script>     

         

  </body>

</html>

        

        

        

    



          



                     

        