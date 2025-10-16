<?




 session_start();
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
require_once(SERVER_CORE.'core/init.php');

$cid = $_SESSION['proj_id'];

?>
<!DOCTYPE html>

<html lang="en" xml:lang="en">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">



        <meta charset="utf-8">

        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

        <title>Clouderp Demo Concern||ERP Software</title>
<link rel="icon" type="image/x-icon" href=<?=SERVER_ASSET?>"assets/images/login/erp_favicon-32x32.png"> 

        <script src=<?=SERVER_ASSET?>"home/files/jquery-1.js"></script>

        <link href="<?=SERVER_ASSET?>home/files/stylesheet.css" rel="stylesheet" type="text/css">
        <link href="<?=SERVER_ASSET?>home/files/css.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="<?=SERVER_ASSET?>home/files/normalize.css">
        <link rel="stylesheet" href="<?=SERVER_ASSET?>home/files/common.css">
        <link rel="stylesheet" href="<?=SERVER_ASSET?>home/files/website.css">
        <link rel="stylesheet" href="<?=SERVER_ASSET?>home/files/font-awesome.css">

</head>
<?php 
 $allCss = find_all_field('project_info','','1');
?>
<style>



.oe_slide.oe_website_builder_slide {

    background-color: #f0f0f0;

    color: #404040;

}

.oe_slide.oe_home_slide {

    background-color: #f0f0f0;

    color: #404040;

}

.download_text{

    font-size: 16px!important;

    font-weight: 600!important;

    margin-bottom: 5px;

}

.download_a{

    padding: 28px 16px;

}

.download_apk{

    width: 100%;

background-color: #39991a;

color: white;

font-weight: bold;

padding: 5px 5px;

border: 1px solid #39991a;

}

.logo-new-cid-class{
	width: <?=$allCss->home_width;?> !important;
	height: <?=$allCss->home_height;?> !important;
}
</style>


<body class="oe_styling_v8">

    <div class="oe_website_contents">

    <header class="oe_website_header">

      <div class="oe_row oe_fit">

        <div style="float:left">
            <?
            $cloud_logo = SERVER_ASSET."images/logo/clouderplogo.png";
            $project_logo = SERVER_UPLOAD."logo/".$cid.".png";
            if(is_file($project_logo)) {
                $show_logo = $project_logo;
            } else {
                $show_logo = $cloud_logo;
            }
            ?>
            <img alt="" src="<?=$show_logo?>" class="logo-new-cid-class" style="height:auto;">
			

        </div>

        <div style="float:right; display:none;">
            <img alt="" src="<?=SERVER_ASSET?>images/logo/erp1.png" class="w-100" height="60px">
        </div>

      </div>

      

    </header>

    



            

<article class="oe_page">
    <section class="oe_container">
        <h4 class="oe_slogan">Choose Your Department</h4>
        <div class="oe_row oe_appstore">


<?php

$u_id=$_SESSION['user']['id'];

$sql22="select a.module_name,a.module_link,a.module_icon_img,a.module_description,a.id,a.dev_status,b.user_id,b.module_id ,b.status from user_module_manage a,user_module_define b where b.module_id=a.id and a.status='Yes' and b.user_id='".$u_id."' and b.status='enable' ";




$query22=db_query($sql22);

while($data22=mysqli_fetch_object($query22)){

 ?>



            <a href="<?=SERVER_VIEW?><?=$data22->module_link?>?mod_id=<?=$data22->id?>" title="<?=$data22->module_name?>" class="oe_app ab_app_descr" >

                <? if($data22->dev_status == "BETA"){?>
				<div class="ribbon-beta"><span>- <?=$data22->dev_status;?> -</span></div>
                <? }elseif($data22->dev_status == "UPCOMING" ){?>
					<div class="ribbon-upcoming"><span>- GAMA -</span></div>
                <? }else{ ?><? } ?>
				<div class="oe_app_icon"><img src="<?=SERVER_ASSET?>home/<?=$data22->module_icon_img?>"></div>

                <div class="oe_app_name"><?=$data22->module_name?> </div>

                <div class="oe_app_descr"><?=$data22->module_description?></div>

            </a>

<?php } ?>	

        </div>



		

        <h4 class="oe_slogan new-apps">Download Our Apps</h4>

        <div class="oe_row oe_appstore new-apps">

            <a href="<?=SERVER_ASSET?>all_module_apk/SecondarySales.apk" title="Secondary Sales.apk" class="oe_app ab_app_descr download_a">

                <div class="oe_app_icon"><img alt="" src="<?=SERVER_ASSET?>home/SecondarySales.png"></div>

                <div class="oe_app_name download_text ">Secondary Sales Apps </div>

                <div class="oe_app_descr"><button class="download_apk">Download</button></div>

            </a>



            <a href="<?=SERVER_ASSET?>all_module_apk/EmployeePortal.apk" title="EmployeePortal.apk" class="oe_app ab_app_descr download_a">

                <div class="oe_app_icon"><img alt="" src="<?=SERVER_ASSET?>home/user_portal.png"></div>

                <div class="oe_app_name download_text ">Employee Portal Apps </div>

                <div class="oe_app_descr"><button class="download_apk">Download</button></div>

            </a>
			
			
			
			<a href="<?=SERVER_ASSET?>all_module_apk/EmployeePortal.apk" title="vehicle.apk" class="oe_app ab_app_descr download_a">

                <div class="oe_app_icon"><img alt="" src="<?=SERVER_ASSET?>home/vehicle.png"></div>

                <div class="oe_app_name download_text ">Vehicle Module Apps </div>

                <div class="oe_app_descr"><button class="download_apk">Download</button></div>

            </a>

        </div>
		

<? if($cid == 'robi' ){?> 
<style>
.new-apps{
	display:block;
}
</style>
<? } 
elseif($cid == 'dev'){?>
<style>
.new-apps{
	display:block;
}
</style>
<? }
else{?>

<style>
.new-apps{
	display:none;
}
</style>

<? } ?>



    </section>

    

    

    

    



    



    <section class="oe_container">

        <div class="oe_row oe_centeralign oe_more_spaced">

          

        </div>

    </section>



</article>



        </div>

        



<div class="openerp_style oe_chat_button">



</div></body>

</html>