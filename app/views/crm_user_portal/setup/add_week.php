<?php

@//

//


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

require "../../template/main_layout.php";

// ::::: Edit This Section ::::: 

$title='Add Weeks';			// Page Name and Page Title

$page="add_week.php";		// PHP File Name

$input_page="add_week_input.php";

$root='setup';



$table='hrm_weeks';		// Database Table Name Mainly related to this page

$unique='id';			// Primary Key of this Database table

$shown='week_name';	

// ::::: End Edit Section :::::





// ::::: End Edit Section :::::





$crud      =new crud($table);



$$unique = $_GET[$unique];



$$unique = $_POST[$unique];



if(isset($_POST['insert'])){	

	

$now= time();



//$_REQUEST['entry_by'] = $_SESSION['employee_selected'];



$crud->insert();

$type=1;

$msg='New Entry Successfully Inserted.';





unset($_POST);

unset($$unique);





}





//for Modify..................................



if(isset($_POST['update']))

{

$crud->update($unique);

		$type=1;

}



if($_GET['del']>0)



{



		db_query('delete from  hrm_user_access where id='.$_GET['del']);



		$type=1;



		$msg='Successfully Deleted.';



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



$$unique=$_SESSION['employee_selected'];

if(isset($$unique))

{

$condition=$unique."=".$$unique;

$data=db_fetch_object($table,$condition);

foreach ($data as $key => $value)

{ $$key=$value;}

}

if(!isset($$unique)) $$unique=db_last_insert_id($table,$unique);

?>

<style type="text/css">

.MATERNITY_LEAVE{

display:none;

}



input[type="radio"], input[type="checkbox"] {

    line-height: normal;

    margin: 4px 0 0;

	width:20px;

}

.radio, .checkbox {

    min-height: 20px;

    padding-left: 20px;

}

.checkbox {

    margin-right: 4px !important;

}



.radio.inline, .checkbox.inline {

    display: inline-block;

    margin-bottom: 0;

    padding-top: 5px;

    vertical-align: middle;

}.radio.inline, .checkbox.inline {

    display: inline-block;

    margin-bottom: 0;

    padding-top: 5px;

    vertical-align: middle;

}

.radio.inline + .radio.inline, .checkbox.inline + .checkbox.inline {

    margin-left: 10px;

}

</style>





<style>



.frmSearch {border: 1px solid #a8d4b1;}

#country-list{float:left;list-style:none;margin-top:-3px;padding:0;width:190px;position: absolute;}

#country-list li{padding: 10px; background: #f0f0f0; border-bottom: #bbb9b9 1px solid;}

#country-list li:hover{background:#ece3d2;cursor: pointer;}

#id_no{padding: 10px;border: #a8d4b1 1px solid;}

</style>





<div class="right_col" role="main">   <!-- Must not delete it ,this is main design header-->

          <div class="">

		  

		  

           

        <div class="clearfix"></div>



            <div class="row">

              <div class="col-md-12 col-sm-12 col-xs-12">

                <div class="x_panel">

                  <div class="x_title">

                    <h2>Plain Page</h2>

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





<script type="text/javascript"> function DoNav(lk){

	return GB_show('ggg', '../pages/<?=$root?>/<?=$input_page?>?<?=$unique?>='+lk,600,940)

	}</script>





<form action="" method="post" enctype="multipart/form-data">

<div class="oe_view_manager oe_view_manager_current">



     

   

    <? include('../../common/title_bar.php');?>

        <div class="oe_view_manager_body">

            

                <div  class="oe_view_manager_view_list"></div>

            

                <div class="oe_view_manager_view_form"><div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">

        <div class="oe_form_buttons"></div>

        <div class="oe_form_sidebar"></div>

        <div class="oe_form_pager"></div>

        <div class="oe_form_container"><div class="oe_form">

          <div class="">



<div class="oe_form_sheetbg">

        <div class="oe_form_sheet oe_form_sheet_width">

<?php echo $msggg; ?>

<table class="oe_form_group " border="0" cellpadding="0" cellspacing="0"><tbody><tr class="oe_form_group_row">

            <td colspan="1" class="oe_form_group_cell" width="100%">

			

			<table width="100%" border="0" cellpadding="2" cellspacing="0" class="oe_form_group ">

              <tbody>

			    <? include('../../common/report_bar.php');?>

                

                

				  </tbody></table>

            </td>

            </tr>

			</tbody></table>

				

	<table width="100%" border="0" cellspacing="0" cellpadding="0">

        

	  

	   <? 	 $res = 'select id,week_name,date_format(s_date,"%d-%b-%y") as start_date,date_format(e_date,"%d-%b-%y") as end_date from hrm_weeks where 1';

											echo $crud->link_report($res,$link);?>

   

  </table>

          </div>

    </div>

    <div class="oe_chatter"><div class="oe_followers oe_form_invisible">

      <div class="oe_follower_list"></div>

    </div></div></div></div></div>

    </div></div>

            

        </div>

  </div>

</form>

</div>

                </div>

              </div>

            </div>

          </div>

        </div>

        <!-- /page content -->





<script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>

<script>

$(document).ready(function(){

	$("#PBI_ID").keyup(function(){

		$.ajax({

		type: "POST",

		url: "auto_com.php",

		data:'keyword='+$(this).val(),

		beforeSend: function(){

			$("#PBI_ID").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");

		},

		success: function(data){

			$("#suggesstion-box").show();

			$("#suggesstion-box").html(data);

			$("#PBI_ID").css("background","#FFF");

		}

		});

	});

});



function selectCountry(val) {

$("#PBI_ID").val(val);

$("#suggesstion-box").hide();

}

</script>

<?













include_once("../../template/footer.php");







?>

