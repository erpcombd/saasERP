<style>
/* Modern Variables */
:root {
  --primary-color: #122e6d;
  --secondary-color: #004c40;
  --accent-color: #FFFFFF ;
  --success-color: #4cc9f0;
  --light-color: #f8f9fa;
  --dark-color: #212529;
  --border-radius: 12px;
  --box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  --transition: all 0.3s ease;
}

/* Profile Image Styles */
.profile_info img {
  width: 70px;
  height: 70px;
  /*border-radius: 50%;*/
  border: 2px solid var(--accent-color);
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  cursor: pointer;
  transition: var(--transition);
  object-fit: cover;
}

.profile_info img:hover {
  transform: scale(1.05);
  border-color: var(--primary-color);
}

/* Search Field Styles */
.search-container {
  position: relative;
  width: 100%;
  margin-top: 15px;
}

.search-input {
  color: var(--dark-color);
  font-size: 16px;
  height: 50px;
  width: 40%;
  padding: 8px 50px 8px 20px;
  border: 1px solid rgba(0, 0, 0, 0.1);
  background: var(--light-color);
  border-radius: 30px;
  transition: var(--transition);
  box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.05);
}

.search-input:focus {
  outline: none;
  border-color: var(--primary-color);
  box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.25);
}

.search-button {
  position: absolute;
  right: 5px;
  top: 5px;
  height: 20px;
  width: 20px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  background: var(--primary-color);
  border: none;
  color: white;
  transition: var(--transition);
}

.search-button:hover {
  background: var(--secondary-color);
  transform: scale(1.05);
}

/* Employee Information Styles */
.employee-card {
  background: white;
  border-radius: var(--border-radius);
  box-shadow: var(--box-shadow);
  overflow: hidden;
  transition: var(--transition);
  margin: 10px 5px;
}

.employee-header {
  background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
  color: white;
  padding: 15px 20px;
  border-radius: var(--border-radius) var(--border-radius) 0 0;
}

.Emp_n {
  font-weight: 600;
  font-size: 16px;
  color: white;
  margin-bottom: 4px;
}

.Emp_n1 {
  font-size: 14px;
  opacity: 0.9;
  color: white;
}

.employee-info {
  display: flex;
  align-items: center;
  padding: 15px;
}

/* Custom Background */
.bg-custom {
  background: white !important;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
  border-bottom: 1px solid rgba(0, 0, 0, 0.08);
}

.employee-photo {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #ddd;
    background-color: #f5f5f5;
}

.default-photo {
    opacity: 0.7;
    border-color: #ccc;
}

.profile_info {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 10px;
}

/* Animation for loading */
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}

.animate-fade {
  animation: fadeIn 0.5s ease forwards;
}
.search_but{
	width: 385px !important;

}
/* Media Queries for Responsiveness */
@media (max-width: 992px) {
  .employee-header {
    padding: 12px 15px;
  }
  
  .profile_info img {
    width: 60px;
    height: 60px;
  }
}

@media (max-width: 768px) {
  .employee-header {
    text-align: center;
  }
  
  .employee-header .row {
    flex-direction: column;
  }
  
  .employee-header .col-md-5 {
    width: 50%;
    margin-top: 10px;
  }
  
  .employee-header .col-auto {
    margin-bottom: 10px;
  }
  
  .profile_info {
    display: flex;
    justify-content: center;
  }
  
  .search-container {
    margin-top: 15px;
    margin-bottom: 5px;
  }
}

@media (max-width: 576px) {
  .Emp_n {
    font-size: 14px;
  }
  
  .Emp_n1 {
    font-size: 12px;
  }
  
  .profile_info img {
    width: 50px;
    height: 50px;
    border-width: 2px;
  }
  
  .search-input {
    height: 40px;
    font-size: 14px;
  }
  
  .search-button {
    height: 20px;
    width: 20px;
  }
  
  .employee-card {
    margin: 5px 2px;
  }
}
</style>

<?php
if(isset($_POST['button'])) {
    $_SESSION['employee_selected'] = find_a_field('personnel_basic_info', 'PBI_ID', 'PBI_CODE="' . $_POST['employee_selected'] . '"');
    $_SESSION['PBI_CODE'] = $_POST['employee_selected'];
}
?>

<div class="container-fluid px-1">
    <div class="card employee-card animate-fade">
        <div class="employee-header">
            <div class="row align-items-center">
                <?php if($_SESSION['employee_selected'] > 0) { 
                    $module_name = find_a_field('user_module_manage', 'module_file', 'id=' . $_SESSION["mod"]);
                    $sql = @db_query("select PBI_NAME, PBI_PICTURE_ATT_PATH, DEPT_ID, DESG_ID, PBI_NID_ATT_PATH, PBI_PASSPORT_ATT_PATH 
                                    from personnel_basic_info where PBI_ID = " . $_SESSION['employee_selected']);
                    $row = @mysqli_fetch_object($sql);
                ?>
                    <div class="col-12 col-sm-auto text-center text-sm-left">
                        <div class="profile_info">
    <?php 
    // Check if employee has a profile picture
    if (!empty($row->PBI_PICTURE_ATT_PATH) && file_exists("../../../assets/support/upload_view.php?name=" . $row->PBI_PICTURE_ATT_PATH . "&folder=hrm_emp_pic&proj_id=" . $_SESSION['proj_id'] . "&mod=" . $module_name)) {
        // Show employee photo
        echo '<img src="../../../assets/support/upload_view.php?name=' . htmlspecialchars($row->PBI_PICTURE_ATT_PATH) . '&folder=hrm_emp_pic&proj_id=' . htmlspecialchars($_SESSION['proj_id']) . '&mod=' . htmlspecialchars($module_name) . '" 
                alt="Employee Photo" class="employee-photo">';
    } else {
        // Show default image
        echo '<img src="../../../assets/images/default-avatar.png" 
                alt="Default Employee Photo" class="employee-photo default-photo">';
    }
    ?>
</div>
                    </div>
                    
                    <div class="col-12 col-sm-5 text-center text-sm-left mt-2 mt-sm-0">
                        <ul class="list-unstyled m-0">
                            <li class="Emp_n"><?=$row->PBI_NAME;?></li>
                            <li class="Emp_n1">
                                <i class="fas fa-id-badge mr-2"></i>
                                <?=find_a_field('designation', 'DESG_DESC', 'DESG_ID=' . $row->DESG_ID);?>
                            </li>
                            <li class="Emp_n1">
                                <i class="fas fa-building mr-2"></i>
                                <?=find_a_field('department', 'DEPT_DESC', 'DEPT_ID=' . $row->DEPT_ID);?>
                            </li>
                        </ul>
                    </div>

                <?php } else { ?>
                    <!--<div class="col-12 col-sm-auto text-center text-sm-left">
                        <div class="profile_info">
                            <img src="../../common/office-man.png" alt="Employee Image">
                        </div>
                    </div>-->
                    
                    <!--<div class="col-12 col-sm-5 text-center text-sm-left mt-2 mt-sm-0">
                        <ul class="list-unstyled m-0">
                            <li class="Emp_n">Employee Name & ID</li>
                            <li class="Emp_n1">
                                <i class="fas fa-id-badge mr-2"></i>
                                Employee Designation
                            </li>
                            <li class="Emp_n1">
                                <i class="fas fa-building mr-2"></i>
                                Employee Department
                            </li>
                        </ul>
                    </div>-->
                <?php } ?>

                <div class=" d-flex justify-content-end search_but">
                    <form action="" method="post">
                        <div class="search-container">
                            <input type="search" list="eip_ids" name="employee_selected" id="employee_selected" 
                                value="<?=$_SESSION['PBI_CODE']?>" placeholder="Search by name or ID..."
                                class="search-input" autocomplete="off">
                            <button id="button-addon1" name="button" type="submit" class="search-button">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>

                        <datalist id="eip_ids">
                            <option></option>
                            <?php
                            $user_id = $_SESSION['user']['id'];
                            
                            if($user_id == 10073 || $user_id == 10074 || $user_id == 10108) {
                                foreign_relation('personnel_basic_info', 'PBI_CODE', 'PBI_NAME', $employee_selected, 'JOB_LOC_ID !=3');   
                            } else {
                                foreign_relation('personnel_basic_info', 'PBI_CODE', 'PBI_NAME', $employee_selected, '1');
                            }
                            ?>
                        </datalist>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>