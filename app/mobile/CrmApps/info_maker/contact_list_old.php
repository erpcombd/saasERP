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
 
 $contactTable ='crm_lead_contacts';


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
    <!-- Search Header -->
    <div class="card card-style">
        <div class="content d-flex justify-content-center align-items-center">
            <span class="font-32 mb-0 color-black">Search</span>
        </div>
    </div>

    <!-- Search Box -->
    <div class="me-3 ms-3 mb-3">
        <div class="search-box bg-theme rounded-m shadow-l border-0">
            <i class="fa fa-search"></i>
            <input type="text" class="border-0" placeholder="Search here... e.g., John" id="search-input">
            <a href="#" class="clear-search m-3 d-none" id="clear-search"><i class="fa fa-times color-red-dark"></i></a>
        </div>
    </div>

    <!-- Search Results -->
    <div class="card card-style search-results" id="search-results">
        <div class="content mb-0">
            <div id="result-container">
                <?php
                $productQry = "SELECT * FROM $contactTable";
                $rslt = db_query($productQry);

                while ($row = mysqli_fetch_object($rslt)) {
                ?>
                    <a href="#" class="d-flex py-2 search-item" data-filter-name="<?= strtolower(trim($row->contact_name)) ?>">
                        <div class="align-self-center">
                            <i class="fa fa-box font-16 color-green-dark me-3 rounded-xl"></i>
                        </div>
                        <div class="align-self-center">
                            <p class="font-14 font-600 color-theme mb-0 line-height-s"><?= $row->contact_name ?></p>
                            <p class="font-11 mb-0 line-height-s">Designation: <?= $row->contact_designation ?></p>
                            <p class="font-11 mb-0 line-height-s">Phone: <?= $row->contact_phone ?></p>
                            <p class="font-11 mb-0 line-height-s">Email: <?= $row->contact_email ?></p>
                        </div>
                    </a>
                    <div class="divider mb-3 search-divider"></div>
                <?php } ?>
            </div>
            <div id="no-results" class="text-center d-none">
                <p class="font-14 color-red-dark">No results found.</p>
            </div>
        </div>
    </div>
</div>






<!-- JavaScript for Exact Search Filter -->
<script>
    document.getElementById('search-input').addEventListener('input', function () {
        let searchTerm = this.value.toLowerCase().trim();
        let items = document.querySelectorAll('.search-item');
        let dividers = document.querySelectorAll('.search-divider');
        let noResults = document.getElementById('no-results');
        let clearSearchButton = document.getElementById('clear-search');
        let hasResults = false;

        // Display clear button only if there's a search term
        if (searchTerm.length > 0) {
            clearSearchButton.classList.remove('d-none');
        } else {
            clearSearchButton.classList.add('d-none');
        }

        // Loop through all items to filter based on the search term
        items.forEach(function (item, index) {
            let itemName = item.getAttribute('data-filter-name');
            
            // Hide all items initially
            item.style.display = 'none';
            if (dividers[index]) {
                dividers[index].style.display = 'none';
            }

            // Show only the exact matching items
            if (itemName === searchTerm) {
                item.style.display = 'flex';
                if (dividers[index]) {
                    dividers[index].style.display = '';
                }
                hasResults = true;
            }
        });

        // Show or hide the "No results" message
        if (hasResults) {
            noResults.classList.add('d-none');
        } else {
            noResults.classList.remove('d-none');
        }
    });

    // Clear search input when the clear button is clicked
    document.getElementById('clear-search').addEventListener('click', function (e) {
        e.preventDefault();
        let searchInput = document.getElementById('search-input');
        searchInput.value = '';
        searchInput.dispatchEvent(new Event('input'));
    });
	
	
	
	
</script>




 <? require_once '../assets/template/inc.footer.php'; ?>