<?php




require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title="Password Change";

$u_id=$_SESSION['user']['id'];
$PBI_ID = find_a_field('user_activity_management','PBI_ID','user_id='.$u_id);


if(isset($_POST['update']))

{

  $old_pass = md5($_POST['old_pass']);

  $new_pass = md5($_POST['new_pass']);

  $confirm_pass = md5($_POST['confirm_pass']);

  $orginal_old_pass = find_a_field('user_activity_management','password','PBI_ID="'.$PBI_ID.'"');

  

  if($old_pass==$orginal_old_pass){

      if($new_pass==$confirm_pass){

	  $update = 'update user_activity_management set password="'.$confirm_pass.'",default_checker="1" where user_id="'.$_SESSION['user']['id'].'" and PBI_ID="'.$PBI_ID.'"';

      $updated = db_query($update);

      $_SESSION['msggg']= '<span style="color:green;">Password Updated. Login Now</span>';

      echo "<script>window.top.location='../../pages/main/logout.php'</script>";

	  

	  }else{

	  $msg = '<span style="color:red; font-weight:bold;">New password & confirm password not match!</span>';

	  }

  }else{

     $msg = '<span style="color:red; font-weight:bold;">Old password not match!</span>';

  }







}



?>




<form action="" method="post" enctype="multipart/form-data">

		<div class="d-flex justify-content-center">

            <div class="n-form1 fo-short pt-0">
                <h4 class="text-center bg-titel bold pt-2 pb-2">      Password Change    </h4>

                        <div class="container">
                            <div class="form-group row  m-0 mb-1 pl-3 pr-3">
                                <label for="group_for" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Old Password </label>
                                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

                                      
                                                <input name="old_pass" type="password" id="old_pass" value=""  />

                                </div>
                            </div>
							<div class="form-group row  m-0 mb-1 pl-3 pr-3">
                                <label for="group_for" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">New Password </label>
                                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

                                        
                                                <input name="new_pass" type="password" id="new_pass" value="" />

                                     
                                </div>
                            </div>
							<div class="form-group row  m-0 mb-1 pl-3 pr-3">
                                <label for="group_for" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Confirm Password </label>
                                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

                                        
                                                <input name="confirm_pass" type="password" id="confirm_pass" value=""  />

                                        
                                </div>
                            </div>

                        </div>

                    <div class="n-form-btn-class">
                        <button name="update" accesskey="S" class="btn1 btn1-bg-update" type="submit">Update</button>
                    </div>

                </div>

            </div>
			
			
			
</form>


<br /><br />


<?php /*?><div class="right_col" role="main">   <!-- Must not delete it ,this is main design header-->

          <div class="">

		  

		  

           

        <div class="clearfix"></div>



            <div class="row">

              <div class="col-md-12 col-sm-12 col-xs-12">

                <div class="x_panel">

                  

				  

				  	 <div class="openerp openerp_webclient_container">

                   

				  

                  <div class="x_content">









<form action="" method="post" enctype="multipart/form-data">

<div class="oe_view_manager oe_view_manager_current">



     

   

    <? //include('../../common/title_bar.php');?>

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

<?php echo $msg; ?>

<table class="oe_form_group " border="0" cellpadding="0" cellspacing="0"><tbody><tr class="oe_form_group_row">

            <td colspan="1" class="oe_form_group_cell" width="100%">

			

			<table width="100%" border="0" cellpadding="2" cellspacing="0" class="oe_form_group ">

              <tbody>

			   

                <tr class="oe_form_group_row">

                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp; Old Password :</td>

                  <td bgcolor="#E8E8E8" colspan="4" class="oe_form_group_cell">

				  <input name="old_pass" type="password" id="old_pass" value=""  style="width:420px;"/>                  </td>

                  </tr>

				  

				  <tr class="oe_form_group_row">

                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp; New Password :</td>

                  <td bgcolor="#E8E8E8" colspan="4" class="oe_form_group_cell">

				  <input name="new_pass" type="password" id="new_pass" value=""  style="width:420px;"/>                  </td>

                  </tr>

				  

				  <tr class="oe_form_group_row">

                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp; Confirm Password :</td>

                  <td bgcolor="#E8E8E8" colspan="4" class="oe_form_group_cell">

				  <input name="confirm_pass" type="password" id="confirm_pass" value=""  style="width:420px;"/>                  </td>

                  </tr>

                

				  </tbody></table>

            </td>

            </tr>

			<tr><td><div align="center">



    <span class="oe_form_buttons_edit" style="display: inline;">

      <button name="update" accesskey="S" class="oe_button oe_form_button_save oe_highlight" type="submit">Update</button>

    </span>



			    </div></td></tr></tbody></table>

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

<?php */?>



<?
//
//
require_once SERVER_CORE."routing/layout.bottom.php";
?>

<?

//require_once SERVER_CORE."routing/layout.bottom.php";

?>