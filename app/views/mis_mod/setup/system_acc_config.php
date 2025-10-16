<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



// ::::: Edit This Section ::::: 



$title = 'System Accounts Config';      // Page Name and Page Title

do_datatable('table_head');

$page = "system_acc_config.php";    // PHP File Name



$table = 'system_acc_config';    // Database Table Name Mainly related to this page

$unique = 'id';      // Primary Key of this Database table

$shown = 'tr_from';        // For a New or Edit Data a must have data field



// ::::: End Edit Section :::::



//if(isset($_GET['proj_code'])) $proj_code=$_GET[$proj_code];

$crud      = new crud($table);



$$unique = $_GET[$unique];

if (isset($_POST[$shown])) {

  $$unique = $_POST[$unique];

  //for Insert..................................

  if (isset($_POST['insert'])) {


    $_POST['entry_by'] = $_SESSION['user']['id'];

    $_POST['entry_at'] = $now = date('Y-m-d H:i:s');


    $entry_by = $_SESSION['user'];



    $crud->insert();

    $type = 1;

    $msg = 'New Entry Successfully Inserted.';

    unset($_POST);

    unset($$unique);
  }





  //for Modify..................................



  if (isset($_POST['update'])) {


    $_POST['edit_by'] = $_SESSION['user']['id'];

    $_POST['edit_at'] = $now = date('Y-m-d H:i:s');



    $crud->update($unique);






    $type = 1;

    $msg = 'Successfully Updated.';
  }

  //for Delete..................................



  if (isset($_POST['delete'])) {
    $condition = $unique . "=" . $$unique;
    $crud->delete($condition);

    unset($$unique);

    $type = 1;

    $msg = 'Successfully Deleted.';
  }
}



if (isset($$unique)) {

  $condition = $unique . "=" . $$unique;

  $data = db_fetch_object($table, $condition);

  while (list($key, $value) = each($data)) {
    $$key = $value;
  }
}

if (!isset($$unique)) $$unique = db_last_insert_id($table, $unique);

?>

<script type="text/javascript">
  $(function() {

    $("#fdate").datepicker({

      changeMonth: true,

      changeYear: true,

      dateFormat: 'yy-mm-dd'

    });

  });

  function Do_Nav()

  {

    var URL = 'pop_ledger_selecting_list.php';

    popUp(URL);

  }




  function DoNav(theUrl)

  {

    document.location.href = '<?= $page ?>?<?= $unique ?>=' + theUrl;

  }

  function popUp(URL)

  {

    day = new Date();

    id = day.getTime();

    eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=1,width=800,height=800,left = 383,top = -16');");

  }
</script>

<style type="text/css">
  <!--
  .style1 {
    color: #FF0000
  }

  .style2 {
    font-weight: bold;
    color: #000000;
    font-size: 14px;
  }

  .style3 {
    color: #FFFFFF
  }
  -->

</style>



<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">

      <form id="form1" name="form1" class="n-form" method="post" action="">
        <h4 align="center" class="n-form-titel1"> <?= $title ?></h4>

        <div class="form-group row m-0 pl-3 pr-3">
          <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label req-input"> Tr From</label>
          <div class="col-sm-9 p-0">
            <input name="<?= $unique ?>" id="<?= $unique ?>" value="<?= $$unique ?>" type="hidden" />
            <input name="id" type="hidden" id="id" tabindex="1" value="<?= $id ?>" readonly>
            <input name="tr_from" required type="text" id="tr_from" tabindex="1" value="<?= $tr_from ?>">


          </div>
        </div>

        <div class="form-group row m-0 pl-3 pr-3">
          <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Table Name </label>
          <div class="col-sm-9 p-0">
            <input name="table_name" type="text" id="table_name" tabindex="1" value="<?= $table_name ?>">

          </div>
        </div>

        <div class="form-group row m-0 pl-3 pr-3">
          <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Cr</label>
          <div class="col-sm-9 p-0">

            <input name="sum_field_cr" type="text" id="sum_field_cr" tabindex="2" value="<?=$sum_field_cr ?>">

          </div>
        </div>
		<div class="form-group row m-0 pl-3 pr-3">
          <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label"> Dr </label>
          <div class="col-sm-9 p-0">

            <input name="sum_field_dr" type="text" id="sum_field_dr" tabindex="2" value="<?= $sum_field_dr ?>">

          </div>
        </div>
        
		
        <div class="form-group row m-0 pl-3 pr-3">
          <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Date Field </label>
          <div class="col-sm-9 p-0">

            <input name="date_field" type="text" id="date_field" tabindex="8" value="<?= $date_field ?>" />

          </div>
        </div>
        <div class="form-group row m-0 pl-3 pr-3">
          <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Table Condition </label>
          <div class="col-sm-9 p-0">

            <textarea name="table_condition" id="table_condition"><?= $table_condition ?></textarea>

          </div>
        </div>



        <div class="n-form-btn-class">
          <? if (!isset($_GET[$unique])) { ?>
            <input name="insert" type="submit" id="insert" value="SAVE" class="btn1 btn1-bg-submit" />
          <? } ?>


          <? if (isset($_GET[$unique])) { ?>
            <input name="update" type="submit" id="update" value="UPDATE" class="btn1 btn1-bg-update" />
          <? } ?>


          <input name="reset" type="button" class="btn1 btn1-bg-cancel" id="reset" value="RESET" onclick="parent.location='<?= $page ?>'" />

        </div>


      </form>

    </div>
    <div class="col-md-12">



      <div class="container n-form1">
        <table id="table_head" class="table table-bordered table-bordered table-striped table-hover table-sm" cellspacing="0">
          <thead>
            <tr class="bgc-info">
              <th>ID</th>
              <th>Tr From</th>
              <th>Table Name</th>
              <th>Cr</th>
			  <th>Dr</th>
              <th>Date Field</th>
              <th>Condition</th>

            </tr>
          </thead>

          <tbody>

            <?php








            $td = 'select *  from ' . $table . '';

            $report = db_query($td);

            while ($rp = mysqli_fetch_row($report)) {
              $i++;
              if ($i % 2 == 0) $cls = ' class="alt"';
              else $cls = ''; ?>

              <tr<?= $cls ?> onclick="DoNav('<?php echo $rp[0]; ?>');">
                <td><?= $rp[0]; ?></td>
                <td><?= $rp[1]; ?></td>
                <td><?= $rp[2]; ?></td>
                <td><?= $rp[3]; ?></td>
                <td><?= $rp[4]; ?></td>
                <td><?= $rp[5]; ?></td>
                <td><?= $rp[6]; ?></td>


                </tr>

              <?php } ?>
          </tbody>
        </table>

        <? //}
        ?>

        <div id="pageNavPosition"></div>

      </div>

    </div>




  </div>




</div>


<script type="text/javascript">
  var pager = new Pager('grp', 10000);

  pager.init();

  pager.showPageNav('pager', 'pageNavPosition');

  pager.showPage(1);


  document.onkeypress = function(e) {
    var
      e = window.event ||
      e
    var
      keyunicode = e.charCode ||
      e.keyCode
    if (keyunicode == 13) {
      return
      false;
    }
  }
</script>






<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>