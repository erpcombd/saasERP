<?  

$module_id=find_module_id();
if($module_id>0)
//$_SESSION['mod'] = $_GET['mod_id'];
$_SESSION['mod'] =  $module_id;
$mod_id = $module_id;
$mod_name = find_a_field('user_module_manage','module_name','id="'.$module_id.'"');



//if($_GET['mod_id']>0)
//$_SESSION['mod'] = $_GET['mod_id'];
//$_SESSION['mod'] =  $module_id;
//$mod_id = $_SESSION['mod'];
//$mod_name = find_a_field('user_module_manage','module_name','id='.$_SESSION['mod']);

$user_level =  $_SESSION['user']['level'];
$user_id    =  $_SESSION['user']['id'];


function load_menu2($mod_id,$mod_name,$user_id){

    ?>

    

                    <style type="text/css">

                        .page_title{
                            border-radius: 5px;

                            background: transparent;

                            border: 0px;

                            float: left;

                            top: 3px;

                            margin-bottom: 15px;

                        }



                        .breadcrumb {

                            background-color: transparent;

                            border: 0px;

                            padding: 9px 13px;

                            margin-bottom: 0px;

                            padding-left: 0;

                            padding-bottom: 0;

                        }



                        .ol {

                            list-style-position: outside;

                            padding-left: 22px;

                        }





                        ol, ul {

                            margin-top: 0;

                            margin-bottom: 10px;

                        }





                        * {

                            -webkit-box-sizing: border-box;

                            -moz-box-sizing: border-box;

                            box-sizing: border-box;

                        }



                        ol {

                            display: block;

                            list-style-type: decimal;

                            margin-block-start: 1em;

                            margin-block-end: 1em;

                            margin-inline-start: 0px;

                            margin-inline-end: 0px;

                            padding-inline-start: 40px;

                        }



                        .sidebar::before, .off-canvas-sidebar nav .navbar-collapse::before{

                            height:auto!important;

                        }



                        @media only screen and  (max-width: 1023px) {

                            .main_content

                            {

                                position: relative;

                                float: left;

                                width: 100%;

                            }

                            .sidebar{width:50%;}

                        }







                        @media only screen and  (max-width: 3000px) {

                            .main_content{

                                position: relative;

                                float:right;

                                width: 82%;

                            }

                            .sidebar{width:18%;}

                        }



                        .sidebar::-webkit-scrollbar {

                            width: .2em;

                            height: .0em;

                        }





                        .sidebar::-webkit-scrollbar-track {

                            box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);

                        }








                        .sidebar{

                            height:100%;

                            overflow:scroll;

                            scrollbar-width: none;

                        }



                        .main_content{

                            position: relative; float: right;

                        }



                        #collapse_sidebar{

                            display: none;

                        }



                        @media only screen and (max-width: 991px)  {

                            .main_content{

                                width: 100% !important;

                            }

                            .navbar-brand{

                                margin-left: 50px !important;

                            }

                            .navbar .navbar-toggler{

                                margin-top:7px;

                                z-index: 1000;

                                background: #c5c5d2;

                                color: white;

                                padding: 5px;

                            }

                        }



                        @media only screen and (max-width: 700px)  {

                            #user-settings-overlay{

                                display: none !important;

                            }

                            #clock{

                                display: none !important;

                            }



                            #avatar-upload{

                                display: none !important;

                            }

                            .help_tooltip{

                                display: none !important;

                            }



                            .sidebar{

                                

                                width: 260px !important;

                            }

                        }



                        @media only screen and (min-width: 992px)  {

                            .sidebar{

                                width: 18% !important;

                            }



                            .main_content{

                                width: 82% !important;

                            }

                        }



                        .nav-open .sidebar{

                            left:0px !important;

                            z-index: 10;

                        }



                        .sidebar{

                            background: white !important;
							position: fixed;

                        }

                    </style>

                   

<div class="sidebar p-0">

                  

                        <div class="left1 theme_color_bg" >



                            <ul class="ul1 pt-2">

                                <li class="li1 active-icon">

                                    <b></b>

                                    <b></b>

                                    <a href="#"><i class="fas fa-store"></i></a>

                                </li>

                                <div style="height: 14px;"></div>





                                <?


$module_sql='select m.module_name,m.id,m.module_link,m.module_icon_img,m.module_menu_icon,d.module_id,d.user_id from user_module_define d,user_module_manage m where d.module_id=m.id and d.status="enable" and d.user_id="'.$_SESSION['user']['id'].'" and m.id!='.$mod_id.' ';
$module_query=db_query($module_sql);
while($module_data=mysqli_fetch_object($module_query))

{

    ?>



                                 <li class="li1">



                                         <a href="<?=SERVER_VIEW.$module_data->module_link;?>?mod_id=<?=$module_data->module_id;?>" class="menu-moule-icon" style=" line-height: 0.0em !important;">





                                            



                                             <i class="<?=$module_data->module_menu_icon; ?>"></i>



                                         </a>







                                     <ul class="ul2">

                                         <li class="li2"><?=$module_data->module_name; ?></li>

                                     </ul>

                                 </li>









    <?

}

?>





                            </ul>



                            <br/>

                            <br/>



                        </div>

                        <div class="right1" >

                         <div class="sidemenu-top">

							<a href="<?=SERVER_VIEW?>auth/masters/home.php">
							

								<div  class="title-image " style="padding-top: 5px !important;">
								<?php 
								$company_logo=find_a_field('project_info','company_logo','proj_id=1');
								$default_logo = "../../../../public/assets/images/logo/clouderplogo.png";
								if($company_logo !=''){
								?>
									<img alt="this is img" src="<?=SERVER_UPLOAD?>logo/<?=$_SESSION['proj_id']?>.png" class="logo-menu-cid-class" style=" width: 70%; ">
                                 <? } else{?>
								 	<img alt="this is img" src="<?=$default_logo;?>" class="logo-menu-cid-class" style=" width: 70%; ">
								 <? } ?>
								</div>

							</a>



                            

                            <h1 id="title_text" class="module-title" ><?=$mod_name?></h1>



							<!--This code for search menu  start-->
							<div class="position-relative ml-1 mr-1">                                
								<input type="search" id="menuSearch" onkeyup="filterMenu()" class="menusearch pr-4 pl-3" placeholder="Type to menu search..." oninput="toggleSearchIcon()">
								<span id="searchIcon" class="position-absolute menusearch-span" 
									style="right: 10px; top: 50%; transform: translateY(-50%); color: gray; cursor: pointer;">
									<i class="fas fa-search"></i>
								</span>
								<span id="clearIcon" class="position-absolute menusearch-span" 
									style="right: 10px; top: 50%; transform: translateY(-50%); color: gray; cursor: pointer; display: none;"
									onclick="clearSearch()">
									<i class="fas fa-times"></i>
								</span>
					
							</div>
							<p id="noMenuMessage" style="display: none; color: red; font-weight: bold; padding: 5px 10px; margin: 5px; background-color: #f8d7da; border: 1px solid #f5c6cb; border-radius: 5px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); font-size: 16px;">
                                No menu found with this name
                            </p>
							
							<!--This code for search menu  End-->
							</div>
                            <div class="menu_bg" >

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

            



                        echo '<div class="dashboard1-nav-dropdown">';

                            echo '<a class="dashboard1-nav-item  dashboard1-nav-dropdown-toggle"><i class="fas fa-clipboard-list"></i>'.$menu->feature_name.' </a>';

                                    echo '<div class="dashboard1-nav-dropdown-menu">';

                                        for($x=1;$x<$sb_count[$menu->id]+1;$x++)

                                        {

										echo '<a href="../'.$sb_folder[$menu->id][$x].'/'.$sb_link[$menu->id][$x].'" class="dashboard1-nav-dropdown-item">'.$sb_name[$menu->id][$x].'</a>';
                                        

             

                                        }

                               { echo '</div>';}

                               { echo '</div>';}

        }

            

    }

?>
<script>
function filterMenu() {
    let input = document.getElementById("menuSearch");
    let filter = input.value.toLowerCase().trim();
    let menus = document.querySelectorAll(".dashboard1-nav-dropdown");
    let noMenuMessage = document.getElementById("noMenuMessage");
    let anyVisible = false;

    menus.forEach(menu => {
        let menuTitle = menu.querySelector(".dashboard1-nav-item").textContent.toLowerCase();
        let submenus = menu.querySelectorAll(".dashboard1-nav-dropdown-item");
        let submenuContainer = menu.querySelector(".dashboard1-nav-dropdown-menu");
        let submenuVisible = false;

        submenus.forEach(submenu => {
            let submenuText = submenu.textContent.toLowerCase();
            if (submenuText.includes(filter)) {
                submenu.style.display = "block";
                submenuVisible = true;
            } else {
                submenu.style.display = "none";
            }
        });

        if (submenuVisible || menuTitle.includes(filter)) {
            menu.style.display = "block";
            if (submenuContainer) {
                submenuContainer.style.display = "block"; // Ensure submenu stays open when relevant
            }
            anyVisible = true;
        } else {
            menu.style.display = filter ? "none" : "block";
            if (submenuContainer) submenuContainer.style.display = "none";
        }

        // Add a click event to toggle submenu item visibility only when search input exists
        let menuItem = menu.querySelector(".dashboard1-nav-item");
        if (menuItem) {
            menuItem.addEventListener("click", () => {
                // Only toggle the submenu visibility if there is search input
                if (filter !== "") {
                    submenus.forEach(submenu => {
                        // If the submenu is visible (display: block), hide it (display: none)
                        if (submenu.style.display === "block") {
                            submenu.style.display = "none";
                        } else {
                            submenu.style.display = "block";
                        }
                    });
                }
            });
        }
    });

    noMenuMessage.style.display = anyVisible ? "none" : "block";

    // When filter is cleared, reset submenu visibility and menu display
    if (filter === "") {
        menus.forEach(menu => {
            menu.style.display = "block";
            let submenuContainer = menu.querySelector(".dashboard1-nav-dropdown-menu");
            if (submenuContainer) submenuContainer.style.removeProperty("display"); // Restore default behavior
            let submenus = menu.querySelectorAll(".dashboard1-nav-dropdown-item");
            submenus.forEach(submenu => {
                submenu.style.display = "none"; // Hide submenus by default when filter is cleared
            });
        });
    }
}

function toggleSearchIcon() {
    let input = document.getElementById("menuSearch");
    let searchIcon = document.getElementById("searchIcon");
    let clearIcon = document.getElementById("clearIcon");

    if (input.value.trim() !== "") {
        searchIcon.style.display = "none";
        clearIcon.style.display = "block";
    } else {
        searchIcon.style.display = "block";
        clearIcon.style.display = "none";
    }
}

function clearSearch() {
    let input = document.getElementById("menuSearch");
    input.value = "";
    toggleSearchIcon();
    filterMenu();
}
</script>
</div>

</div>

</div>



    <?

}

function load_menu3($mod_id,$mod_name,$user_id){

    ?>

    

                    <style type="text/css">

                        .page_title{
                            border-radius: 5px;

                            background: transparent;

                            border: 0px;

                            float: left;

                            top: 3px;

                            margin-bottom: 15px;

                        }



                        .breadcrumb {

                            background-color: transparent;

                            border: 0px;

                            padding: 9px 13px;

                            margin-bottom: 0px;

                            padding-left: 0;

                            padding-bottom: 0;

                        }



                        .ol {

                            list-style-position: outside;

                            padding-left: 22px;

                        }





                        ol, ul {

                            margin-top: 0;

                            margin-bottom: 10px;

                        }





                        * {

                            -webkit-box-sizing: border-box;

                            -moz-box-sizing: border-box;

                            box-sizing: border-box;

                        }



                        ol {

                            display: block;

                            list-style-type: decimal;

                            margin-block-start: 1em;

                            margin-block-end: 1em;

                            margin-inline-start: 0px;

                            margin-inline-end: 0px;

                            padding-inline-start: 40px;

                        }



                        .sidebar::before, .off-canvas-sidebar nav .navbar-collapse::before{

                            height:auto!important;

                        }



                        @media only screen and  (max-width: 1023px) {

                            .main_content

                            {

                                position: relative;

                                float: left;

                                width: 100%;

                            }

                            .sidebar{width:50%;}

                        }







                        @media only screen and  (max-width: 3000px) {

                            .main_content{

                                position: relative;

                                float:right;

                                width: 82%;

                            }

                            .sidebar{width:18%;}

                        }



                        .sidebar::-webkit-scrollbar {

                            width: .2em;

                            height: .0em;

                        }





                        .sidebar::-webkit-scrollbar-track {

                            box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);

                        }








                        .sidebar{

                            height:100%;

                            overflow:scroll;

                            scrollbar-width: none;

                        }



                        .main_content{

                            position: relative; float: right;

                        }



                        #collapse_sidebar{

                            display: none;

                        }



                        @media only screen and (max-width: 991px)  {

                            .main_content{

                                width: 100% !important;

                            }

                            .navbar-brand{

                                margin-left: 50px !important;

                            }

                            .navbar .navbar-toggler{

                                margin-top:7px;

                                z-index: 1000;

                                background: #c5c5d2;

                                color: white;

                                padding: 5px;

                            }

                        }



                        @media only screen and (max-width: 700px)  {

                            #user-settings-overlay{

                                display: none !important;

                            }

                            #clock{

                                display: none !important;

                            }



                            #avatar-upload{

                                display: none !important;

                            }

                            .help_tooltip{

                                display: none !important;

                            }



                            .sidebar{

                                

                                width: 260px !important;

                            }

                        }



                        @media only screen and (min-width: 992px)  {

                            .sidebar{

                                width: 18% !important;

                            }



                            .main_content{

                                width: 82% !important;

                            }

                        }



                        .nav-open .sidebar{

                            left:0px !important;

                            z-index: 10;

                        }



                        .sidebar{

                            background: white !important;
							position: fixed;

                        }

                    </style>

                   

<div class="sidebar p-0">

                  

                        <div class="left1 theme_color_bg" >



                            <ul class="ul1 pt-2">

                                <li class="li1 active-icon">

                                    <b></b>

                                    <b></b>

                                    <a href="#"><i class="fas fa-store"></i></a>

                                </li>

                                <div style="height: 14px;"></div>





                                <?


//$module_sql='select m.module_name,m.id,m.module_link,m.module_icon_img,m.module_menu_icon,d.module_id,d.user_id from user_module_define d,user_module_manage m where d.module_id=m.id and d.status="enable" and d.user_id="'.$_SESSION['user']['id'].'" and m.id!='.$mod_id.' ';

$module_sql = 'select m.module_name,m.id,m.module_link,m.module_icon_img,m.module_menu_icon,r.user_id,d.module_id from user_module_manage m, roll_details d, user_role_access r where m.id=d.module_id and d.role_id=r.role_id and r.user_id="'.$_SESSION['user']['id'].'" and m.id!='.$mod_id.' group by d.module_id';
$module_query=db_query($module_sql);
while($module_data=mysqli_fetch_object($module_query))

{

    ?>



                                 <li class="li1">



                                         <a href="<?=SERVER_VIEW.$module_data->module_link;?>?mod_id=<?=$module_data->module_id;?>" class="menu-moule-icon" style=" line-height: 0.0em !important;">





                                            



                                             <i class="<?=$module_data->module_menu_icon; ?>"></i>



                                         </a>







                                     <ul class="ul2">

                                         <li class="li2"><?=$module_data->module_name; ?></li>

                                     </ul>

                                 </li>









    <?

}

?>





                            </ul>



                            <br/>

                            <br/>



                        </div>





                     

                        <div class="right1" >

                          <div class="sidemenu-top">

							<a href="<?=SERVER_VIEW?>auth/masters/home.php">
							

								<div  class="title-image " style="padding-top: 5px !important;">

						

									<img alt="this is img" src="<?=SERVER_UPLOAD?>logo/<?=$_SESSION['proj_id']?>.png" class="logo-menu-cid-class" style=" width: 70%; ">
                                    
								</div>

							</a>



                            

                            <h1 id="title_text" class="module-title" ><?=$mod_name?></h1>
							
							
							

							<!--This code for search menu  start-->
							</div>
							<div class="position-relative ml-1 mr-1">                                
								<input type="search" id="menuSearch" onkeyup="filterMenu()" class="menusearch pr-4 pl-3" placeholder="Type to menu search..." oninput="toggleSearchIcon()">
								<span id="searchIcon" class="position-absolute menusearch-span" 
									style="right: 10px; top: 50%; transform: translateY(-50%); color: gray; cursor: pointer;">
									<i class="fas fa-search"></i>
								</span>
								<span id="clearIcon" class="position-absolute menusearch-span" 
									style="right: 10px; top: 50%; transform: translateY(-50%); color: gray; cursor: pointer; display: none;"
									onclick="clearSearch()">
									<i class="fas fa-times"></i>
								</span>
					
							</div>
							<p id="noMenuMessage" style="display: none; color: red; font-weight: bold; padding: 5px 10px; margin: 5px; background-color: #f8d7da; border: 1px solid #f5c6cb; border-radius: 5px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); font-size: 16px;">
                                No menu found with this name
                            </p>
							
							<!--This code for search menu  End-->

                            <div class="menu_bg" >

<?



    
$subsql="select p.* from user_role_access r, user_page_manage p, roll_details rd where p.id=rd.page_id and r.role_id=rd.role_id and r.user_id=".$user_id." order by  p.feature_id,p.id";

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

    



    $sql="select distinct f.id, f.feature_name, f.icon
    from user_feature_manage f, roll_details r, user_page_manage p, user_role_access rr
    where rr.role_id=r.role_id and p.id=r.page_id and p.feature_id=f.id and rr.user_id=".$user_id." and f.module_id=".$mod_id."  order by f.ordering,f.id";


    $query=db_query($sql);

    $count = mysqli_num_rows($query);

    if($count>0)

    {

        $m = 1;

        while($menu = mysqli_fetch_object($query))

        { if($m==4) {$m=1;} else {$m++;}

            



                        echo '<div class="dashboard1-nav-dropdown">';

                            echo '<a class="dashboard1-nav-item  dashboard1-nav-dropdown-toggle"><i class="fas fa-clipboard-list"></i>'.$menu->feature_name;
                            
                                    // Initialize $not_count for this menu item
                                    $not_count = 0;
                                    $badge_total = 0;
                                    // Calculate $not_count based on $_SESSION['notify']
                                    for ($x = 1; $x < $sb_count[$menu->id] + 1; $x++) {
                                        if (isset($_SESSION['notify'][$sb_id[$menu->id][$x]]) && $_SESSION['notify'][$sb_id[$menu->id][$x]] > 0) {
                                           $not_count += $_SESSION['notify'][$sb_id[$menu->id][$x]];
                                          $badge_total = $not_count;
                                        }
                                    }
                            
                            if($badge_total >0){echo '<span class="badge badge-danger">'.$badge_total.'</span>';}
                            
                            echo'</a>';

                                    echo '<div class="dashboard1-nav-dropdown-menu">';

                                        for($x=1;$x<$sb_count[$menu->id]+1;$x++)

                                        {

										echo '<a href="../'.$sb_folder[$menu->id][$x].'/'.$sb_link[$menu->id][$x].'" class="dashboard1-nav-dropdown-item">'.$sb_name[$menu->id][$x];
									
									if (isset($_SESSION['notify'][$sb_id[$menu->id][$x]]) && $_SESSION['notify'][$sb_id[$menu->id][$x]] > 0) {
										echo ' <span class="badge badge-danger">' . $_SESSION['notify'][$sb_id[$menu->id][$x]] . '</span>';
									}
									
									echo '</a>';
                                        

             

                                        }

                               { echo '</div>';}

                               { echo '</div>';}

        }

            

    }

?>

<script>
function filterMenu() {
    let input = document.getElementById("menuSearch");
    let filter = input.value.toLowerCase().trim();
    let menus = document.querySelectorAll(".dashboard1-nav-dropdown");
    let noMenuMessage = document.getElementById("noMenuMessage");
    let anyVisible = false;

    menus.forEach(menu => {
        let menuTitle = menu.querySelector(".dashboard1-nav-item").textContent.toLowerCase();
        let submenus = menu.querySelectorAll(".dashboard1-nav-dropdown-item");
        let submenuContainer = menu.querySelector(".dashboard1-nav-dropdown-menu");
        let submenuVisible = false;

        submenus.forEach(submenu => {
            let submenuText = submenu.textContent.toLowerCase();
            if (submenuText.includes(filter)) {
                submenu.style.display = "block";
                submenuVisible = true;
            } else {
                submenu.style.display = "none";
            }
        });

        if (submenuVisible || menuTitle.includes(filter)) {
            menu.style.display = "block";
            if (submenuContainer) {
                submenuContainer.style.display = "block"; // Ensure submenu stays open when relevant
            }
            anyVisible = true;
        } else {
            menu.style.display = filter ? "none" : "block";
            if (submenuContainer) submenuContainer.style.display = "none";
        }

        // Add a click event to toggle submenu item visibility only when search input exists
        let menuItem = menu.querySelector(".dashboard1-nav-item");
        if (menuItem) {
            menuItem.addEventListener("click", () => {
                // Only toggle the submenu visibility if there is search input
                if (filter !== "") {
                    submenus.forEach(submenu => {
                        // If the submenu is visible (display: block), hide it (display: none)
                        if (submenu.style.display === "block") {
                            submenu.style.display = "none";
                        } else {
                            submenu.style.display = "block";
                        }
                    });
                }
            });
        }
    });

    noMenuMessage.style.display = anyVisible ? "none" : "block";

    // When filter is cleared, reset submenu visibility and menu display
    if (filter === "") {
        menus.forEach(menu => {
            menu.style.display = "block";
            let submenuContainer = menu.querySelector(".dashboard1-nav-dropdown-menu");
            if (submenuContainer) submenuContainer.style.removeProperty("display"); // Restore default behavior
            let submenus = menu.querySelectorAll(".dashboard1-nav-dropdown-item");
            submenus.forEach(submenu => {
                submenu.style.display = "none"; // Hide submenus by default when filter is cleared
            });
        });
    }
}

function toggleSearchIcon() {
    let input = document.getElementById("menuSearch");
    let searchIcon = document.getElementById("searchIcon");
    let clearIcon = document.getElementById("clearIcon");

    if (input.value.trim() !== "") {
        searchIcon.style.display = "none";
        clearIcon.style.display = "block";
    } else {
        searchIcon.style.display = "block";
        clearIcon.style.display = "none";
    }
}

function clearSearch() {
    let input = document.getElementById("menuSearch");
    input.value = "";
    toggleSearchIcon();
    filterMenu();
}

</script>
</div>

</div>

</div>



    <?

}


$menu_type = find_a_field('general_configuration','menu_format','group_for="'.$_SESSION['user']['group'].'"');
if($menu_type=='Role_wise'){
load_menu3($mod_id,$mod_name,$user_id);
}else{
load_menu2($mod_id,$mod_name,$user_id);
}

?>
