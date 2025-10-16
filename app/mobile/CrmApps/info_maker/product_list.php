<? 
//ini_set('display_errors',1); ini_set('display_startup_errors',1); error_reporting(E_ALL);
require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');
require_once SERVER_CORE."routing/layout.top.php";
require_once '../assets/support/Calendar.php';
//require_once '../assets/support/crud.php';
require_once '../assets/support/custom.php';
//require_once '../assets/support/menu_dynamic.php';
require_once '../assets/support/mix_function.php';
require_once '../assets/support/reg__ajax.php';


$cid = $_SESSION['proj_id'];

$page="home";

require_once '../assets/template/inc.header.php';

$u_id  =  $_SESSION['user']['id'];
$PBI_ID = find_a_field('user_activity_management','PBI_ID','user_id='.$u_id);
$basic = find_all_field('personnel_basic_info','','PBI_ID="'.$PBI_ID.'"');

 $cur = '&#x9f3;';
 $table1 = 'crm_project_lead';
 
 $productTable ='crm_lead_products';


?>


<style>
    .Cancel { 
        background-color: #ff4d4d !important; /* Red */
    }
    .Lost { 
        background-color: #ff704d !important; /* Dark Salmon */
    }
    .Active {
        background-color: #66cc66 !important; /* Green */
    }
    .Won { 
        background-color: #4da6ff !important; /* Blue */
    }
    .Proposal { 
        background-color: #cccccc !important; /* Gray */
    }
    .Qualified { 
        background-color: #ffff66 !important; /* Yellow */
    }
    .Negotiation { 
        background-color: #66d9ff !important; /* Cyan */
    }
    .Closed { 
        background-color: #85e085 !important; /* Medium Green */
    }
    .Junk { 
        background-color: #cccccc !important; /* Gray */
    }
    .NoBid { 
        background-color: #99aabb !important; /* Slate Blue */
    }
</style>





        

        <style>
            @keyframes modal-icon {
                0% {transform:scale(1, 1); opacity:0.5;}
                50% {transform:scale(1.1, 1.1); opacity:1}
                100% {transform:scale(1, 1); opacity:0.5;}
            }
            .modal-icon{animation:modal-icon 1.6s; animation-iteration-count: infinite;}

            @keyframes action-icon {
                0% {transform:translateY(0px); opacity:1;}
                50% {transform:translateY(5px); opacity:0.5}
                100% {transform:translateY(0px); opacity:1;}
            }
            .action-icon{animation:action-icon 1.6s; animation-iteration-count: infinite;}
        </style>
		
		
		
		
		<div class="page-content header-clear-medium">
				<div class="card card-style">
					<div class="content d-flex justify-content-center align-items-center">
						<span class="font-32 mb-0 color-black">Search </span>
						<div class="ms-auto">
						</div>
					</div>
				</div>

				<div class="me-3 ms-3 mb-3">
					<div class="search-box bg-theme rounded-m shadow-l border-0">
						<i class="fa fa-search"></i>
						<input type="text" class="border-0" placeholder="Search here.. - try the name John " data-search>
						<a href="#" class="clear-search disabled m-3"><i class="fa fa-times color-red-dark"></i></a>
					</div>
				</div>

				<!-- Search Area -->
				<div class="card card-style search-results disabled-search-list ">
					<div class="content mb-0">
						<div>
		<? 		
				  $productQry = "SELECT * FROM  $productTable WHERE 1";
				  $rslt = db_query($productQry);
		
				  while($row = mysqli_fetch_object($rslt)){
		
				?>
							<a href="#" class="d-flex py-2" data-filter-item data-filter-name="<?=$row->products?>">
									<div class="align-self-center">
					<!--                        <i class="fa fa-circle color-green-dark position-absolute ms-4 ps-2 pt-4 mt-2"></i>
											<img src="images/pictures/17s.jpg" width="45" class="rounded-xl me-3" alt="img">-->
											<i class="fa fa-box font-16 color-green-dark me-3 rounded-xl"></i>
											
										</div>
										<div class="align-self-center">
											<p class="font-14 font-600 color-theme mb-0 line-height-s"><?=$row->products?></p>
											<!--<p class="font-11 mb-0 line-height-s">I'm out walking the dog.</p>-->
										</div>
										<div class="position-absolute end-0 pe-3 align-self-center">
											<!--<span class="font-9 opacity-40 color-theme">20 min ago</span><br>-->
											<span class="float-end mt-n1 pt-1 badge rounded-pill bg-blue-dark font-9 font-400 scale-switch">5</span>
										</div>
							</a>
							
							
							<div class="search-no-results"><!-- use component-search for no results page --></div>
								<?       }  ?> 
						</div>
					</div>
			
		
		
		
		
		
		
		
		
		
		<!-- Search Area -->
       <!-- <div class="card card-style search-results disabled-search-list mt-3">
            <div class="content mt-0 mb-0 pb-0 mx-2">
                <div>
                    <a href="page-chat-bubbles-2.html" class="d-flex py-2" data-filter-item data-filter-name="all john wick">
                        <div class="align-self-center">
                            <i class="fa fa-circle color-green-dark position-absolute ms-4 ps-2 pt-4 mt-2"></i>
                            <img src="images/pictures/17s.jpg" width="45" class="rounded-xl me-3" alt="img">
                        </div>
                        <div class="align-self-center">
                            <p class="font-14 font-600 color-theme mb-0 line-height-s">John Wick</p>
                            <p class="font-11 mb-0 line-height-s">I'm out walking the dog.</p>
                        </div>
                        <div class="position-absolute end-0 pe-3">
                            <span class="font-9 opacity-40 color-theme">20 min ago</span><br>
                            <span class="float-end mt-n1 pt-1 badge rounded-pill bg-blue-dark font-9 font-400 scale-switch">5</span>
                        </div>
                    </a>
                    <a href="page-chat-bubbles-2.html" class="d-flex py-2" data-filter-item data-filter-name="all tyler durden">
                        <div class="align-self-center">
                            <i class="fa fa-circle color-green-dark position-absolute ms-4 ps-2 pt-4 mt-2"></i>
                            <img src="images/pictures/12s.jpg" width="45" class="rounded-xl me-3" alt="img">
                        </div>
                        <div class="align-self-center">
                            <p class="font-14 font-600 color-theme mb-0 line-height-s">Tyler Durden <i class="fa fa-bell-slash ps-1 pb-1 font-10 opacity-30"></i></p>
                            <p class="font-11 mb-0 line-height-s">Don't forget about rule number one.</p>
                        </div>
                        <div class="position-absolute end-0 pe-3">
                            <span class="font-9 opacity-40 color-theme">2 hours ago</span><br>
                            <span class="float-end mt-n1 pt-1 badge rounded-pill bg-blue-dark font-9 font-400 scale-switch px-1">14</span>
                        </div>
                    </a>
                    <a href="page-chat-bubbles-2.html" class="d-flex py-2" data-filter-item data-filter-name="all harry callahan">
                        <div class="align-self-center">
                            <i class="fa fa-circle color-yellow-dark position-absolute ms-4 ps-2 pt-4 mt-2"></i>
                            <img src="images/pictures/30s.jpg" width="45" class="rounded-xl me-3" alt="img">
                        </div>
                        <div class="align-self-center">
                            <p class="font-14 font-600 color-theme mb-0 line-height-s">Harry Callahan</p>
                            <p class="font-11 mb-0 line-height-s"><i>Sent 5 images and 1 Video.</i></p>
                        </div>
                        <div class="position-absolute end-0 pe-3">
                            <span class="font-9 opacity-40 color-theme">2 hours ago</span><br>
                            <span class="float-end mt-n1 pt-1 badge rounded-pill bg-green-dark font-9 font-400 scale-switch px-1"><i class="fa fa-image"></i></span>
                            <span class="float-end mt-n1 pt-1 badge rounded-pill bg-red-dark font-9 font-400 scale-switch px-1"><i class="fa fa-video"></i></span>
                        </div>
                    </a>
                    <a href="page-chat-bubbles-2.html" class="d-flex py-2" data-filter-item data-filter-name="all tony montana">
                        <div class="align-self-center">
                            <i class="fa fa-circle color-yellow-dark position-absolute ms-4 ps-2 pt-4 mt-2"></i>
                            <img src="images/pictures/8s.jpg" width="45" class="rounded-xl me-3" alt="img">
                        </div>
                        <div class="align-self-center">
                            <p class="font-14 font-600 color-theme mb-0 line-height-s">Tony Montana <i class="fa fa-bell-slash ps-1 pb-1 font-10 opacity-30"></i></p>
                            <p class="font-11 mb-0 line-height-s">Say hello to my little friend! 😅 </p>
                        </div>
                        <div class="position-absolute end-0 pe-3">
                            <span class="font-9 opacity-40 color-theme">3 days ago</span><br>
                        </div>
                    </a>
                    <a href="page-chat-bubbles-2.html" class="d-flex py-2" data-filter-item data-filter-name="all the godfather">
                        <div class="align-self-center">
                            <i class="fa fa-circle color-yellow-dark position-absolute ms-4 ps-2 pt-4 mt-2"></i>
                            <img src="images/pictures/24s.jpg" width="45" class="rounded-xl me-3" alt="img">
                        </div>
                        <div class="align-self-center">
                            <p class="font-14 font-600 color-theme mb-0 line-height-s">The Godfather</p>
                            <p class="font-11 mb-0 line-height-s">I'm have an offer you can't refuse. </p>
                        </div>
                        <div class="position-absolute end-0 pe-3">
                            <span class="font-9 opacity-40 color-theme">Yesterday</span><br>
                        </div>
                    </a>
                    <a href="page-chat-bubbles-2.html" class="d-flex py-2" data-filter-item data-filter-name="all sherlock holms">
                        <div class="align-self-center">
                            <img src="images/pictures/28s.jpg" width="45" class="rounded-xl me-3" alt="img">
                        </div>
                        <div class="align-self-center">
                            <p class="font-14 font-600 color-theme mb-0 line-height-s">Sherlock Holmes</p>
                            <p class="font-11 mb-0 line-height-s">It's elementary, my dear Watson.  </p>
                        </div>
                        <div class="position-absolute end-0 pe-3">
                            <span class="font-9 opacity-40 color-theme">Last week</span><br>
                        </div>
                    </a>
                    <a href="page-chat-bubbles-2.html" class="d-flex py-2" data-filter-item data-filter-name="all bob marley">
                        <div class="align-self-center">
                            <img src="images/pictures/15s.jpg" width="45" class="rounded-xl me-3" alt="img">
                        </div>
                        <div class="align-self-center">
                            <p class="font-14 font-600 color-theme mb-0 line-height-s">Bob Marley</p>
                            <p class="font-11 mb-0 line-height-s">Love the life you live. Live the life you love.  </p>
                        </div>
                        <div class="position-absolute end-0 pe-3">
                            <span class="font-9 opacity-40 color-theme">24th March</span><br>
                        </div>
                    </a>
                    <div class="search-no-results"><!-- use component-search for no results page --></div>
        <!--        </div>
            </div>
        </div>
-->
        <!-- List of Favorites -->
<!--        <div class="content">
            <div class="row mb-0">
                <a href="page-chat-bubbles-2.html" class="col-3 text-center">
                    <img src="images/pictures/faces/1s.png" width="60" class="rounded-xl" alt="img">
                    <p class="font-600 color-theme">John</p>
                </a>
                <a href="page-chat-bubbles-2.html" class="col-3 text-center">
                    <img src="images/pictures/faces/2s.png" width="60" class="rounded-xl" alt="img">
                    <p class="font-600 color-theme">Dean</p>
                </a>
                <a href="page-chat-bubbles-2.html" class="col-3 text-center">
                    <img src="images/pictures/faces/3s.png" width="60" class="rounded-xl" alt="img">
                    <p class="font-600 color-theme">David</p>
                </a>
                <a href="page-chat-bubbles-2.html" class="col-3 text-center">
                    <img src="images/pictures/faces/4s.png" width="60" class="rounded-xl" alt="img">
                    <p class="font-600 color-theme">Nixon</p>
                </a>
            </div>
        </div>-->
				<div class="card card-style">
					<div class="content d-flex justify-content-center align-items-center">
						<span class="font-32 mb-0 color-black">Products</span>
						<div class="ms-auto">
						</div>
					</div>
				</div>

        <!-- Chat Bubble List -->
        <div class="card card-style ">
            <div class="content mb-0">
<? 
		  $productQry = "SELECT * FROM  $productTable WHERE1";
		  $rslt = db_query($productQry);
          while($row = mysqli_fetch_object($rslt)){

		?>
			
                <a href="#" class="d-flex pb-3">
                    <div class="align-self-center">
<!--                        <i class="fa fa-circle color-green-dark position-absolute ms-4 ps-2 pt-4 mt-2"></i>
                        <img src="images/pictures/17s.jpg" width="45" class="rounded-xl me-3" alt="img">-->
						<i class="fa fa-box font-16 color-green-dark me-3 rounded-xl"></i>
						
                    </div>
                    <div class="align-self-center">
                        <p class="font-14 font-600 color-theme mb-0 line-height-s"><?=$row->products?></p>
                        <!--<p class="font-11 mb-0 line-height-s">I'm out walking the dog.</p>-->
                    </div>
                    <div class="position-absolute end-0 pe-3 align-self-center">
                        <!--<span class="font-9 opacity-40 color-theme">20 min ago</span><br>-->
                        <span class="float-end mt-n1 pt-1 badge rounded-pill bg-blue-dark font-9 font-400 scale-switch">5</span>
                    </div>
                </a>
				
				<div class="divider mb-3"></div>
				    <?       }  ?>  
            </div>
        </div>
		
		
		
		
		
    </div>
		
<?php /*?>		<? 
		
		   $sn = 1;
		
		  $leadsQry = "SELECT a.*,o.name FROM $table1 a,crm_project_org o WHERE a.organization=o.id and a.assign_person=$PBI_ID ORDER BY a.id DESC";
		  $rslt = db_query($leadsQry);

          while($row = mysqli_fetch_object($rslt)){
		  
			$entryAt = $row->entry_at;
			$formattedDate = date('d M, Y', strtotime($entryAt));
			$formattedTime = date('h:i A', strtotime($entryAt));
		    // for warning by color
		  $status = $row->status;
		  
		  $probability = find_a_field('crm_deal_stage_status', 'probability', 'id = "'.$row->status.'"');
				
		

		
		?>	 
		
        <a href="../info_maker/lead_details_show.php?view=<?=encrypTS($row->id)?>&tp='<?=encrypTS('lead')?>'">
		
            <div class="card card-style bg-5 py-4" data-card-height="120">
                <div class="card-center px-4">
                    <div class="d-flex">
<!--                        <div class="align-self-center">
                            <i class="far fa-minus-square color-green-dark fa-2x mt-1 modal-icon"></i>
                        </div>-->
                        <div class="align-self-center ps-4">
                            <h1 class="font-23 mb-0 color-white"><?=$row->name?></h1>
                            <p class="font-11 opacity-50 mt-n2 mb-0 color-white"><?=$row->lead_name?></p>
							<p class="font-11 opacity-50 mt-n2 mb-0 color-white"><?=$formattedDate?> <?=$formattedTime?></p>
                        </div>

                        <div class="aling-self-center ms-auto">
                            <!--<i class="fa fa-arrow-right pt-3 color-white opacity-60"></i>-->
							<a href="../info_maker/lead_details_show.php?view=<?=encrypTS($row->id)?>&tp='<?=encrypTS('lead')?>'" class="btn btn-m float-end rounded-xl shadow-xl text-uppercase font-800 <?=$class?> fa-2x mt-1 modal-icon bg-highlight"><?=find_a_field('crm_deal_stage_status', 'status', 'id = "'.$row->status.'"')?></a>
                        </div>
                    </div>
                </div>
				
			<div class="card-bottom ms-3 me-3 mb-3">
                        <div class="progress" style="height:8px;">
                            <div class="progress-bar border-0 bg-green-dark text-start ps-2" role="progressbar" style="width: <?=$probability;?>%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                    </div>
				
				
                <div class="card-overlay bg-black opacity-80"></div>
            </div>
        </a>
		
		
		

		
			    

    <?       } ?>   <?php */?> 

        

<!-- JavaScript Search Filter Logic -->
<script>
document.querySelector('[data-search]').addEventListener('input', function() {
    let searchTerm = this.value.toLowerCase();
    document.querySelectorAll('[data-filter-item]').forEach(function(item) {
        let itemName = item.getAttribute('data-filter-name').toLowerCase();
        if (itemName.includes(searchTerm)) {
            item.style.display = '';
        } else {
            item.style.display = 'none';
        }
    });
});
</script>




 <? require_once '../assets/template/inc.footer.php'; ?>