<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE.'core/init.php';
require_once SERVER_CORE."routing/layout.top.php";






// ::::: Edit This Section ::::: 







$title = 'User Access Control';      // Page Name and Page Title







$page = "user_access_control.php";    // PHP File Name







$root = 'setup';







$table = 'hrm_user_access';    // Database Table Name Mainly related to this page







$unique = 'id';      // Primary Key of this Database table







$shown = 'PBI_ID';        // For a New or Edit Data a must have data field















// ::::: End Edit Section :::::























// ::::: End Edit Section :::::











$crud      = new crud($table);







$$unique = $_GET[$unique];







$$unique = $_POST[$unique];















if (isset($_POST['insert'])) {















  $now = time();















  //$_REQUEST['entry_by'] = $_SESSION['employee_selected'];







  $PBI_ID_CON = find_a_field('personnel_basic_info', 'PBI_ID', 'PBI_CODE=' . $_POST['PBI_CODE']);







  $found = find_a_field('hrm_user_access', 'PBI_ID', 'PBI_ID=' . $PBI_ID_CON);







  if ($found > 0) {







    $msggg = "Already Exist";
  } else {











    //$_REQUEST['PBI_ID'] = $PBI_ID_CON;











    $sql = "INSERT INTO hrm_user_access (PBI_ID,kpi_module) VALUES ('" . $PBI_ID_CON . "','1')";







    $query = db_query($sql);











    //$crud->insert();







    $type = 1;







    $msg = 'New Entry Successfully Inserted.';
  }















  unset($_POST);







  unset($$unique);
}























//for Modify..................................















if (isset($_POST['update'])) {







  $crud->update($unique);







  $type = 1;
}















if ($_GET['del'] > 0) {















  db_query('delete from  hrm_user_access where id=' . $_GET['del']);















  $type = 1;















  $msg = 'Successfully Deleted.';
}















//for Delete..................................















/*if(isset($_POST['delete']))







{		$condition=$unique."=".$$unique;		$crud->delete($condition);







		unset($$unique);







		echo '<script type="text/javascript">







parent.parent.document.location.href = "../inventory/home_leave.php?notify=12";







</script>';







		$type=1;







		$msg='Successfully Deleted.';







}*/















$$unique = $_SESSION['employee_selected'];







if (isset($$unique)) {







  $condition = $unique . "=" . $$unique;







  $data = db_fetch_object($table, $condition);







  foreach($data as $key => $value) {
    $$key = $value;
  }
}







if (!isset($$unique)) $$unique = db_last_insert_id($table, $unique);







?>







<style type="text/css">
  .MATERNITY_LEAVE {







    display: none;







  }















  input[type="radio"],
  input[type="checkbox"] {







    line-height: normal;







    margin: 4px 0 0;







    width: 20px;







  }







  .radio,
  .checkbox {







    min-height: 20px;







    padding-left: 20px;







  }







  .checkbox {







    margin-right: 4px !important;







  }















  .radio.inline,
  .checkbox.inline {







    display: inline-block;







    margin-bottom: 0;







    padding-top: 5px;







    vertical-align: middle;







  }

  .radio.inline,
  .checkbox.inline {







    display: inline-block;







    margin-bottom: 0;







    padding-top: 5px;







    vertical-align: middle;







  }







  .radio.inline+.radio.inline,
  .checkbox.inline+.checkbox.inline {







    margin-left: 10px;







  }
</style>























<style>
  .frmSearch {
    border: 1px solid #a8d4b1;
  }







  #country-list {
    float: left;
    list-style: none;
    margin-top: -3px;
    padding: 0;
    width: 190px;
    position: absolute;
  }







  #country-list li {
    padding: 10px;
    background: #f0f0f0;
    border-bottom: #bbb9b9 1px solid;
  }







  #country-list li:hover {
    background: #ece3d2;
    cursor: pointer;
  }







  #id_no {
    padding: 10px;
    border: #a8d4b1 1px solid;
  }
</style>























<div class="right_col" role="main"> <!-- Must not delete it ,this is main design header-->







  <div class="">































    <div class="clearfix"></div>















    <div class="row">







      <div class="col-md-12 col-sm-12 col-xs-12">







        <div class="x_panel">







          <div class="x_title">







            <h2>User Access Control</h2>







            <ul class="nav navbar-right panel_toolbox">







              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>







              </li>







              <li class="dropdown">







                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>







                <ul class="dropdown-menu" role="menu">







                  <li><a href="#">Settings 1</a>







                  </li>







                  <li><a href="#">Settings 2</a>







                  </li>







                </ul>







              </li>







              <li><a class="close-link"><i class="fa fa-close"></i></a>







              </li>







            </ul>







            <div class="clearfix"></div>







          </div>















          <div class="openerp openerp_webclient_container">







            <table class="oe_webclient">







              <tbody>















                <tr>































                  <div class="x_content">























                    <style>
                      .red-cell {



                        color: red;



                      }
                    </style>















                    <form action="" method="post" enctype="multipart/form-data">







                      <div class="oe_view_manager oe_view_manager_current">











                        <div class="oe_view_manager_body">









                          <div class="oe_view_manager_view_form">
                            <div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">













                              <div class="oe_form_container">
                                <div class="oe_form">







                                  <div class="">











                                    <?php echo $msggg; ?>







                                    <table class="oe_form_group " border="0" cellpadding="0" cellspacing="0">
                                      <tbody>
                                        <tr class="oe_form_group_row">







                                          <td colspan="1" class="oe_form_group_cell" width="100%">















                                            <table width="100%" border="0" cellpadding="2" cellspacing="0" class="oe_form_group ">







                                              <tbody>






                       








   <tr class="oe_form_group_row">
  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Employee ID:</td>
  <td bgcolor="#E8E8E8" colspan="4" class="oe_form_group_cell">
    <input name="kpi_module" type="hidden" id="kpi_module" value="1" style="width: 420px;" />
    <div class="frmSearch">
      <input type="text" list='eip_ids' name="PBI_CODE" id="PBI_CODE" value="<?=$_POST['PBI_CODE']?>" />
      <datalist id='eip_ids'>
        <option></option>
        <?
        foreign_relation('personnel_basic_info', 'PBI_CODE', 'PBI_NAME', $PBI_CODE, '1');
        ?>
      </datalist>
     <button name="insert" accesskey="S" class="oe_button oe_form_button_save oe_highlight" type="submit">ADD</button>
      <div id="suggesstion-box"></div>
    </div>
  </td>
</tr>





                                              </tbody>
                                            </table>







                                          </td>







                                        </tr>



                                        
                                      </tbody>
                                    </table>





                                    <br />















                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">







                                      <tr>







                                        <thead>
                                          <th>&nbsp; SI &nbsp; </th>
                                          <th>&nbsp; Emp ID &nbsp;</th>

                                          <th>Employee Name</th>

                                          <th>Designation</th>

                                          <th>Department/Project</th>

                                          <th>Action</th>

                                        </thead>
                                      </tr>

                                      <tbody>

                                        <?
                                         $res = 'select p.*,k.PBI_ID,k.id as kid from  hrm_user_access k, personnel_basic_info p where 1 and k.kpi_module=1 and k.PBI_ID=p.PBI_ID order by p.PBI_DEPARTMENT';
                                        $qeury = db_query($res);
                                        while ($basic = mysqli_fetch_object($qeury)) {
                                          //$basic = find_all_field('personnel_basic_info','','PBI_ID='.$data->PBI_ID);
                                          $s++;
                                        ?>
                                          <tr <? if ($s % 2 == 0) { ?> bgcolor="#E8E8E8" <? } ?>>

                                            <td> &nbsp; <?= ++$i; ?> &nbsp; </td>
                                            <td> &nbsp; <?= $basic->PBI_CODE; ?> &nbsp; </td>
                                            <td> <?= $basic->PBI_NAME; ?></td>
                                            <td><?= find_a_field('designation', 'DESG_DESC', 'DESG_ID=' . $basic->PBI_DESIGNATION); ?></td>

                                            <? if ($basic->PBI_DEPARTMENT == 13) { ?>
                                              <td><?= find_a_field('project', 'PROJECT_DESC', 'PROJECT_ID=' . $basic->JOB_LOCATION); ?></td>
                                            <? } else { ?>
                                              <td><?= find_a_field('department', 'DEPT_DESC', 'DEPT_ID=' . $basic->PBI_DEPARTMENT); ?></td>

                                            <? } ?>
                                            <? $checker = find_all_field('essential_info', '', 'PBI_ID=' . $basic->PBI_ID);   ?>

                                            <td>
                                              <button <?
                                                      if ($checker->ESS_JOB_STATUS == 'Not In Service' || $checker->ESSENTIAL_RESIG_DATE != '0000-00-00')
                                                        echo 'style="background: red; color:white"';
                                                      else
                                                        echo 'style="background: #ccc; color:white"'
                                                      ?>>
                                                <a href="user_access_control.php?del=<?= $basic->kid ?>">Delete </a>
                                              </button>
                                            </td>

                                          </tr>

                                        <? } ?>

                                      </tbody>















                                    </table>







                                  </div>















                                  <div class="oe_chatter">
                                    <div class="oe_followers oe_form_invisible">







                                      <div class="oe_follower_list"></div>







                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>







                          </div>
                        </div>



















                      </div>







                    </form>























                    <!-- /page content -->























                    <script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>






                    <!-- Employee ID -->
                    <script>
                  /*    $(document).ready(function() {
                        $("#PBI_CODE").keyup(function() {
                          $.ajax({
                            type: "POST",
                            url: "auto_com.php",
                            data: 'keyword=' + $(this).val(),
                            beforeSend: function() {
                              $("#PBI_CODE").css("background", "#FFF url(LoaderIcon.gif) no-repeat 165px");
                            },
                            success: function(data) {
                              $("#suggesstion-box").show();
                              $("#suggesstion-box").html(data);
                              $("#PBI_CODE").css("background", "#FFF");
                            }
                          });
                        });
                      });

                      function selectCountry(val) {
                        $("#PBI_CODE").val(val);
                        $("#suggesstion-box").hide();
                      }*/
                    </script>







                    <?























































                require_once SERVER_CORE."routing/layout.bottom.php";





                    ?>