<?  
if($_GET['mod_id']>0)
$_SESSION['mod'] = $_GET['mod_id'];
$mod_id = $_SESSION['mod'];
$mod_name = find_a_field('user_module_manage','module_name','id='.$_SESSION['mod']);
$user_level =  $_SESSION['user']['level'];
$user_id    =  $_SESSION['user']['id'];







//function load_menu2($mod_id,$mod_name,$user_id){

    ?>
<style>
    .bold{
        font-weight: bold !important;
    }
    .bell-massage,.sing-out{
        font-size: 16px !important;
        background-color: whitesmoke;
        padding: 5px 8px !important;
    }
    
    #clock {
        position: relative !important;
        right: 0px !important;
        /*width: auto !important;*/
        padding-right: 0px !important;
        color: #333 !important;
    }
    
    .Profile-set{
        left: -50%;
        right: -50%;
        padding: 0px;
    }
    .Profile-set .d-flex{
        margin: 0px;
        padding: 10px;
    }
    
    .userimg {
        width: 50px;
        height: 50px;
        margin-right: 2px;
        pointer-events: none;
        border-radius: 25px;
        border: 1px solid green;
    }
    .post{
        width: 100%;
        padding: 0px 5px;
    }
    
    .sign_out{
        padding: 6px 8px;
        background-color: #f5f5f5;
        border-radius: 5px;
        cursor: pointer;
    }
    .sign_out a{
        color:#333;
    }
    
    .sign_out:hover{
         border: 1px solid #ff6200;
    }
    
    .sign_out:hover>a{
         color: #ff6200 !important;
         cursor: pointer;
    }
    
    .nav-item:hover>.nav-link{
        color: #ff6200 !important;
          border: 1px solid #ff6200;
    } 
    
    .nav-item:hover>.titel_x{
        border:0px !important;
    }
    
    .dropdown:hover>.dropdown-toggle{
        color: #ff6200 !important;
    }
    
    .dropdown:hover .dropdown-menu, .dropdown-toggle:hover .dropdown-menu{
        display: block;
        opacity: 1;
        transform: scale(1);
      
    }
    
    
    
    .dropdown-menu .dropdown-item:hover, .dropdown-menu .dropdown-item:focus, .dropdown-menu a:hover, .dropdown-menu a:focus, .dropdown-menu a:active {
        box-shadow: 0 4px 20px 0px rgba(0, 0, 0, 0.14), 0 7px 10px -5px rgba(156, 39, 176, 0.4);
        color: #333;
        background-color: #fafafad1;
    }
    
    .dropdown-menu .a{
        background-color: #f5f5f5 !important;
        box-shadow: none !important;
    }

    


</style>

<!--=============================================================================
---------------------------- Header start -----------------------------------------
==============================================================================-->

<nav class="navbar navbar-expand-md navbar-light mb-1" id="menu-sr-1">
    <a href="#" class="navbar-brand" style="overflow: hidden !important;padding: 0;margin-left: 0px;"> 
		<img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$_SESSION['proj_id']?>.png" style="height: 53px; width: 100px;"> 
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar6">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="navbar-collapse collapse justify-content-stretch" id="navbar6">
        <ul class="navbar-nav">

                             <li class="nav-item active">
                                <a class="nav-link titel_x m-0 pl-0 pr-0 bold"><?=$title?></a>
                            </li>
        </ul>

            
        <ul class="navbar-nav ml-auto" style="margin-right: 122px;">
			<li class="nav-item dropdown text-center">
                <a class="nav-link dropdown-toggle sing-out text-capitalize" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style=" margin-left: 5px !important; ">
                    <i class="fa-brands fa-windows"></i>               
                </a>
                <div class="dropdown-menu Profile-set" aria-labelledby="navbarDropdown">
				
<?
$module_sql='select m.module_name,m.id,m.module_link,m.module_icon_img,m.module_menu_icon,d.module_id,d.user_id from user_module_define d,user_module_manage m where d.module_id=m.id and d.status="enable" and d.user_id="'.$_SESSION['user']['id'].'" and m.id!='.$mod_id.' ';
$module_query=db_query($module_sql);
while($module_data=mysqli_fetch_object($module_query))

{

    ?>

<a class="nav-link" href="<?=SERVER_VIEW.$module_data->module_link;?>?mod_id=<?=$module_data->module_id;?>"><?=$module_data->module_name; ?></a>

                                
    <?

}

?>

                </div>
            </li>
			
			
			<li class="nav-item dropdown">
                <a href="#" class="bell-massage nav-link" data-toggle="tooltip" data-placement="bottom" data-original-title="Notifications" style=" margin-left: 5px !important;">
                    <span class="badge animated zoomIn"></span>
                    <i class="fa-light fa-bell"></i>
                    <!--<span class="badge badge-pill badge-danger" style="color:red; font-weight:bold;">0</span>-->
                </a>
                 
            </li>
			
						
			<li class="nav-item dropdown">
                <a href="#" class="bell-massage nav-link" data-toggle="tooltip" data-placement="bottom" data-original-title="Notifications" style=" margin-left: 5px !important;">
                    <span class="badge animated zoomIn"></span>
                    <i class="fa-light fa-envelope"></i>
                    <!--<span class="badge badge-pill badge-danger" style="color:red; font-weight:bold;">0</span>-->
                </a>
                 
            </li>
			
            
        
            <li class="nav-item dropdown text-center">
                <a class="nav-link dropdown-toggle sing-out text-capitalize" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style=" margin-left: 5px !important; ">
                    <i class="fa-light fa-user-gear"></i>
                    <span class="d-none d-sm-inline px-1">
                        <?						 
                            $user_info = find_all_field('user_activity_management','fname','user_id='.$_SESSION['user']['id']);
                             $new_nam = $user_info->fname;
                            echo substr_replace($new_nam, "..", 6);
                        ?>
                    </span>
                
                </a>
                
                <div class="dropdown-menu Profile-set" aria-labelledby="navbarDropdown">
                    <div class="d-flex dropdown-item justify-content-between">
                        <div class="img">
                            	<? 
    						     $find = find_a_field('user_activity_management','user_pic','user_id="'.$_SESSION['user']['id'].'"');
    							 
                            
								 if($find!=""){ ?>
							
								<img src="../../../assets/support/upload_view.php?name=<?=$find?>&folder=user_pic&folder=user_pic&proj_id=<?=$cid?>&mod=mis_mod" class="userimg" />
								
								<? }else{ ?>
							   <img src="../../../user_pic/user.png" class="userimg" alt=""/>
								<? } ?>
                        </div>
                        <div class="post">
                                                        
                                    <?
                                    $user_info = find_all_field('user_activity_management','fname','user_id='.$_SESSION['user']['id']);
                                    //echo $user_info->fname;
                                        $longText = $user_info->fname;
                                        $shortenedText = shortenText($longText, 16);
                                        //echo $shortenedText;

                                    ?>  
                                <p class="username m-0 p-0 text-capitalize" title="<?=$user_info->fname;?>" style="font-size: 14px; font-weight: 400; text-align: center;">
                                    <? echo $shortenedText; ?>
                                </p>
            
                                <p class="company_name m-0 p-0" align="left" style="text-align: center;">
                                    <?=$user_info->designation;?>
                                </p>
                        </div>
                        <div class="sign_out">
                            <a href="../../../views/auth/masters/logout.php" class="a"><i class="fa-regular fa-power-off"></i> </a>
                        </div>
                    </div>
                </div>
            </li>
            


            <li class="nav-item">
			<div class="today-clock">
			  	<div id="today_date"></div>
			  	<div id="now_time"></div>
                <div class="text">IP: <?=$_SERVER['REMOTE_ADDR']?></div>
            </div>
            </li>
            
        </ul>
    </div>
</nav>

    
    
    
 <?php
     function shortenText($text, $maxLength) {
        if (strlen($text) <= $maxLength) {
            return $text;
        } else {
            // Truncate the text to the specified length and add an ellipsis
            $shortenedText = substr($text, 0, $maxLength - 3) . '...';
            return $shortenedText;
        }
    }
    
 ?>
    
    
    
    
    












<!--=============================================================================
---------------------------- Manu start -----------------------------------------
==============================================================================-->
  <style>
    /* Custom styles for the dropdown */
    .sarwar-drop .dropdown-menu {
      background-color: #f9f9f9;
      box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    }

    .sarwar-drop .dropdown-submenu {
      position: relative;
    }

    .sarwar-drop .dropdown-submenu:hover .dropdown-menu {
      display: block;
      position: absolute;
      left: 100%;
      top: 0;
    }
    
    .dropdown-menu-two{
        position: absolute;
        display: none !important;
        top: 0px;
        left: 100%;
    }
    
    .dropdown-two:hover .dropdown-menu-two{
        display: block!important;
    }
    .dropdown-two{
        width:100%;
    }
    
    .dropdown-two .nav-link{
        text-align: left;
    }
    
    .dropdown-two .nav-link, .dropdown .nav-link{
        margin-left: 0px !important;
    }
    
    .dropdown-menu .nav-link{
        font-size: 11px !important;
        text-transform: capitalize !important;
    }
    
        /* width */
    ::-webkit-scrollbar {
      width: 5px;
    }
    
    /* Track */
    ::-webkit-scrollbar-track {
      background: #f1f1f1; 
    }
     
    /* Handle */
    ::-webkit-scrollbar-thumb {
      background: #888; 
    }
    
    /* Track */
    ::-webkit-scrollbar-track {
      box-shadow: inset 0 0 5px grey; 
      border-radius: 10px;
    }
     
    /* Handle */
    ::-webkit-scrollbar-thumb {
      background: #333; 
      border-radius: 10px;
    }
    
    /* Handle on hover */
    ::-webkit-scrollbar-thumb:hover {
      background: #555; 
    }
    
    .titel_x{
        padding: 10px 5px !important;
    }
    
    .nav-link{
        padding: 8px 10px !important;
        
    }


  </style>



<nav class="navbar navbar-expand-sm navbar-light bg-light m-0 p-0 zoom-menu" data-toggle="affix" id="menu-sr-2">
    <div class="mx-auto d-sm-flex d-block flex-sm-nowrap">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample11" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse text-center" id="navbarsExample11">
            <ul class="navbar-nav">
                
                <li class="nav-item" style=" margin: 0px 0px 0px 10px; ">
                    <a class="nav-link" href="#" style=" margin: 0px; padding: 4px; border: 1px solid #d0ced5;"><i class="fa-solid fa-house fa-lg"></i></a>

                </li>
<!--                <li class="nav-item dropdown text-center">
                    
                <a class="nav-link titel_x dropdown-toggle text-capitalize" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <span class="d-none d-sm-inline px-1">Configuration</span>      </a>
                
                
                    <div class="dropdown-menu m-0" aria-labelledby="navbarDropdown">
					 <a class="nav-link" href="../../../mis_mod/pages/admin/template.php">Template Configuration</a>
					 <a class="nav-link" href="#">Sub menu 2</a>
                    </div>
                </li>-->
				
				
		
				
				
				<?

 $subsql="select p.* from user_roll_activity r, user_page_manage p where r.access>0 and p.id=r.page_id and p.status='Yes'  and r.user_id=".$user_id." order by p.ordering,p.feature_id,p.id ";

    $subquery=db_query($subsql);

    while($submenu=mysqli_fetch_object($subquery))

    {

        

    if($sb_count[$submenu->feature_id]==0) {$sb_count[$submenu->feature_id] = 1;}

    else {$sb_count[$submenu->feature_id] = $sb_count[$submenu->feature_id] + 1;}

    $sb_id[$submenu->feature_id][$sb_count[$submenu->feature_id]] = $submenu->id;     

    $sb_folder[$submenu->feature_id][$sb_count[$submenu->feature_id]] = $submenu->folder_name;

    $sb_link[$submenu->feature_id][$sb_count[$submenu->feature_id]] = $submenu->page_link;

    $sb_name[$submenu->feature_id][$sb_count[$submenu->feature_id]] = $submenu->page_name;

    $sb_title[$submenu->feature_id][$sb_count[$submenu->feature_id]] = $submenu->page_title;

    }

    



    

    $sql="select distinct f.id, f.feature_name, f.icon,f.ordering

    from user_feature_manage f, user_roll_activity r, user_page_manage p 

    where r.access>0 and p.id=r.page_id and p.feature_id=f.id and r.user_id=".$user_id." and f.module_id=".$mod_id." and f.status='yes'  order by f.ordering,f.id";

    $query=db_query($sql);

    $count = mysqli_num_rows($query);

    if($count>0)

    {

        $m = 1;

        while($menu = mysqli_fetch_object($query))

        { if($m==4) {$m=1;} else {$m++;}

            



                        echo '<li class="nav-item dropdown text-center">';

                            echo '<a class="nav-link titel_x dropdown-toggle text-capitalize" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <span class="d-none d-sm-inline px-1">'.$menu->feature_name.'</span>      </a>';
							
                                    echo '<div class="dropdown-menu m-0" aria-labelledby="navbarDropdown">';

                                        for($x=1;$x<$sb_count[$menu->id]+1;$x++)

                                        {

										echo '<a class="nav-link" href="../'.$sb_folder[$menu->id][$x].'/'.$sb_link[$menu->id][$x].'">'.$sb_name[$menu->id][$x].'</a>';                                   
                                        }
											
										

                               { echo '</div>';}

                               { echo '</li>';}

        }

            

    }

?>
				
       
            </ul>
        </div>
    </div>
</nav>


  
 <?
//}
//load_menu2($mod_id,$mod_name,$user_id);

?>


<script>
    $(".dropdown-menu a.dropdown-menu").on('click',function(){ 
    if(!$(this).next() .hasClass('show')){
        $(this).parents(".dropdown-menu").first() .find("show").removeClass("show");
    }
    var $subMenu = $(this).next('.dropdown-menu');
    $subMenu.taggleClass("show");

    $(this).parents("li.nev-item.dropdown.show") .on ('hidden.bs.dropdown',function(e){
        $(".dropdown-submenu . show").removeClass("show");
    });
    return false;
});
 </script>
 <script>
    function updateTime() {
      try {
        const now = new Date();
        const dateElement = document.getElementById('today_date');
        const timeElement = document.getElementById('now_time');

        if (!dateElement || !timeElement) {
          throw new Error('Required elements not found.');
        }

        const options = { weekday: 'short', day: '2-digit', month: 'short', year: 'numeric' };
        const formattedDate = now.toLocaleDateString('en-US', options).replace(',', '.');

        const formattedTime = [
          String(now.getHours()).padStart(2, '0'),
          String(now.getMinutes()).padStart(2, '0'),
          String(now.getSeconds()).padStart(2, '0')
        ].join(':');

        dateElement.textContent = formattedDate;
        timeElement.textContent = formattedTime;
      } catch (error) {
        console.error('An error occurred while updating the time:', error);
      }
    }

    updateTime(); // Call immediately to avoid delay on first load
    setInterval(updateTime, 1000);
  </script>
  
