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



<!-- Styles -->	
<style>
.example5 {
 height: 50px;	
 overflow: hidden;
 position: relative;
}
.example5 h3 {
 position: absolute;
 width: 100%;
 height: 100%;
 margin: 0;
 line-height: 50px;
 text-align: left;
 /* Apply animation to this element */	
 -moz-animation: example5 5s linear infinite alternate;
 -webkit-animation: example5 5s linear infinite alternate;
 animation: example5 5s linear infinite alternate;
}
/* Move it (define the animation) */
@-moz-keyframes example5 {
 0%   { -moz-transform: translateX(70%); }
 100% { -moz-transform: translateX(0%); }
}
@-webkit-keyframes example5 {
 0%   { -webkit-transform: translateX(70%); }
 100% { -webkit-transform: translateX(0%); }
}
@keyframes example5 {
 0%   { 
 -moz-transform: translateX(70%); /* Firefox bug fix */
 -webkit-transform: translateX(70%); /* Firefox bug fix */
 transform: translateX(70%); 		
 }
 100% { 
 -moz-transform: translateX(0%); /* Firefox bug fix */
 -webkit-transform: translateX(0%); /* Firefox bug fix */
 transform: translateX(0%); 
 }
}
</style>


<body class="login">
<div class="example5">
<h3 style="color:#009999">Welcome To Aksid Corporation</h3>
</div>
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

     
		  
<div class="container">

    
<div class="row">
<div class="col-xs-2">
<div class="dropdown">
  <button class="btn btn-secondary dropdown-toggle" style="background-color:#94aa86; color:#FFFFFF; font-weight:bold;margin-top:160px; padding:12px;" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Attendance Policy
  </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    <a class="dropdown-item" href="#">Action  Another action  Another action</a>
    
  </div>
</div>
</div>  


	
<div class="row">
<div class="col-xs-2">
<div class="dropdown">
  <button class="btn btn-secondary dropdown-toggle" style="background-color:#5f4f50; width:145px; color:#FFFFFF; font-weight:bold;margin-top:160px; padding:12px;" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Leave Policy 
  </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    <a class="dropdown-item" href="#">Action</a>
    <a class="dropdown-item" href="#">Another action</a>
    <a class="dropdown-item" href="#">Something else here</a>
  </div>
</div>
</div> 


	
	
<div class="row">
 <div class="col-xs-2">
<div class="dropdown">
  <button class="btn btn-secondary dropdown-toggle" style="background-color:#1b445a; width:145px;color:#FFFFFF; font-weight:bold;margin-top:160px; padding:12px;" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Holidays
  </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
     <p class="bg-primary">This text is important.</p>
  <p class="bg-success">This text indicates success.</p>
  <p class="bg-info">This text represents some information.</p>
  <p class="bg-warning">This text represents a warning.</p>
  <p class="bg-danger">This text represents danger.</p>
  </div>
</div>
</div>
				  
				  
				  
              


             
                
    
<div class="row">
	  
 <div class="col-xs-2">
	  
<div class="dropdown">
  <button class="btn btn-secondary dropdown-toggle" style="background-color:#3f4247; width:145px;color:#FFFFFF; font-weight:bold;margin-top:160px; padding:12px;" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Notice Board
  </button>
  <div class="dropdown-menu" style="background-color:aquamarine; font-size:14px;" aria-labelledby="dropdownMenuButton">
   <p>Something else here Something else here  </p>
  </div>
</div>
      
	  
</div>
		
    
	
	
	
    <div class="col-sm-4" style="float:right">
	
	 <div class="login_wrapper">
	 
        <div class="animate form login_form"> 
		
		<section class="login_content"> 
		  
		  
      <form action="" method="post">
              
              <div>
                <input type="text" class="form-control" name="cid" placeholder="Company Name" required="" />
              </div>
              <div>
			  
               <input type="text" class="form-control" name="uid" placeholder="User ID" required="" />
			   <input type="hidden" class="form-control" name="ibssignin" placeholder="User ID" required="" />
              </div>
			  
			  <div>
			  
                <input type="password" name="pass" class="form-control" placeholder="Password" required="" />
              </div>
              <div>  
			  
			  <form action="../../../" method="post">
			 
               <button name="submit">Sign In</button>
                <a class="reset_pass" href="#">Lost your password?</a>              </div>

              </form>
             
                  <!--<h1><i class="fa fa-home"></i> Chemtrek Industries</h1>
                  <p>©2019 All Rights Reserved. Erp.com.bd! is a Bootstrap 3 template. Privacy and Terms</p>-->
                </div>
              </div>
            </form>
    </div>
  </div>
</div>
		  
           
          </section>
        </div><

       
      </div>
    </div>
  </body>
</html>
        
        
        
    

          

                     
        