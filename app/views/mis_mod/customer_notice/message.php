<?php



require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



// ::::: Edit This Section ::::: 



$title = 'Message';      // Page Name and Page Title

do_datatable('table_head');

do_calander('#start_date');

do_calander('#end_date');

$page = "message.php";    // PHP File Name



$table = 'customer_message';    // Database Table Name Mainly related to this page

$unique = 'id';      // Primary Key of this Database table

$shown = 'tr_from';        // For a New or Edit Data a must have data field



// ::::: End Edit Section :::::



//if(isset($_GET['proj_code'])) $proj_code=$_GET[$proj_code];

$crud      = new crud($table);


  //for Insert..................................

  if (isset($_POST['insert'])) {





	  foreach($_POST['dealer_code']  as $key=> $value){
	
//	  $_POST['dealer_code']=$_POST['dealer_code'][$key];
//	  $_POST['message']=$_POST['message'];
//	  $_POST['start_date']=$_POST['start_date'];
//	  $_POST['end_date']=$_POST['end_date'];
//	  $_POST['entry_by'] = $_SESSION['user']['id'];
//      $_POST['entry_at'] =date('Y-m-d H:i:s');

 $sql='insert into customer_message (dealer_code,message,start_date,end_date,entry_by,entry_at) values("'.$_POST['dealer_code'][$key].'","'.$_POST['message'].'","'.$_POST['start_date'].'","'.$_POST['end_date'].'","'. $_SESSION['user']['id'].'","'.date('Y-m-d H:i:s').'")';
db_query($sql);
    //  $crud->insert();

}
  //  $type = 1;
//
//    $msg = 'New Entry Successfully Inserted.';
//
//    unset($_POST);
//
//    unset($$unique);

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
    // $condition = $unique . "=" . $$unique;
    $crud->delete($condition);

    // unset($$unique);

    $type = 1;

    $msg = 'Successfully Deleted.';
  }




if (isset($$unique)) {

//   $condition = $unique . "=" . $$unique;

  $data = db_fetch_object($table, $condition);

  while (list($key, $value) = each($data)) {
    $$key = $value;
  }
}

// if (!isset($$unique)) $$unique = db_last_insert_id($table, $unique);

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
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>

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
  	label{
	color:black;
	}
  -->

</style>



<script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
<link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>

 

<div class="container-fluid">
    <div class="row">
	<div class="col-md-12">
          
            <form class="n-form" method="post" action="" autocomplete="off">
                <h4 class="n-form-titel1 text-center"> <?=$title?><?= $data?>  </h4>

                <div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label req-input">Customer</label>
                    <div class="col-sm-9 p-0">
                        <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                       	<input name="id" type="hidden" id="id" value="<?=$id?>" readonly>
                        <select name="dealer_code[]" required type="text" id="dealer_code[]"  multiple class="chosen-select">
						<? foreign_relation('dealer_info','dealer_code','dealer_name_e',$_POST['dealer_code'],'1');?>	
						</select>


                    </div>
                </div>

                <div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Message</label>
                    <div class="col-sm-9 p-0">
                        <textarea name="message"  type="text" id="message" value="<?=$message?>" ></textarea>
                    </div>
                </div>

                <div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Start Date</label>
                    <div class="col-sm-9 p-0">

                        <input name="start_date" type="text" id="start_date"     value="<?=$start_date?>">

                    </div>
                </div>
				<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">End Date </label>
                    <div class="col-sm-9 p-0">

                       <input name="end_date" type="text" id="end_date" value="<?=$end_date?>">

                    </div>
                </div>
				
				
				
				

                <div class="n-form-btn-class">
                   <? if(!isset($_GET[$unique])){?>
                   <input name="insert" type="submit" id="insert" value="SAVE" class="btn1 btn1-bg-submit" />
                   <? }?>
                    
                 
                      <? if(isset($_GET[$unique])){?>
                      <input name="update" type="submit" id="update" value="UPDATE" class="btn1 btn1-bg-update" />
                      <? }?>
                  
                 
                      <input name="reset" type="button" class="btn1 btn1-bg-cancel" id="reset" value="RESET" onclick="parent.location='<?=$page?>'" />

              </div>


            </form>

        </div>
	
	
    <div class="col-md-12">



      <div class="container n-form1">
        <table id="table_head" class="table table-bordered table-bordered table-striped table-hover table-sm">
          <thead>
            <tr class="bgc-info">
              <th>ID</th>
              <th>Customer Name</th>
              <th>Message</th>
              <th>Start Date</th>
              <th>End Date</th>

            </tr>
          </thead>

          <tbody>

            <?php

            $td = 'select *  from ' . $table . '';

            $report = db_query($td);

            while ($rp = mysqli_fetch_object($report)) {
              $i++;
              if ($i % 2 == 0) {
                  $cls = ' class="alt"';
                  
              } else {
              $cls = '';
              } ?>

              <tr<?= $cls ?> ">
                <td><?= $i; ?></td>
                <td><?= find_a_field('dealer_info','dealer_name_e','dealer_code="'.$rp->dealer_code.'"'); ?></td>
                <td><?= $rp->message; ?></td>
                <td><?= $rp->start_date; ?></td>
                <td><?= $rp->end_date; ?></td>


                </tr>

              <?php } ?>
          </tbody>
        </table>

      

        <div id="pageNavPosition"></div>

      </div>

    </div>
	  </div>
	    </div>

<script>
    ClassicEditor
        .create( document.querySelector( '#message' ) )
        .catch( error => {
            console.error( error );
        } );
</script>


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


<script>
$(".chosen-select").chosen()
</script>



<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>