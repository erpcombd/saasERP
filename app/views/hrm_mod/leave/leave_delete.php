<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title="Leave Delete Option";

do_calander('#m_date');

$head='<link href="../css/report_selection.css" type="text/css" rel="stylesheet"/>';

auto_complete_from_db('personnel_basic_info','concat(PBI_NAME,"-",PBI_ID)','PBI_ID','','PBI_ID');

$table='hrm_inout';

$unique='id';



$id=$_POST["id"];





if(isset($_POST["delete"])){



$sql2="DELETE FROM hrm_leave_info WHERE id = '".$id."'";

$q3 = db_query($sql2);



 $sql2="DELETE FROM hrm_att_summary WHERE leave_id = '".$id."'";

$q3 = db_query($sql2);


echo "Deleted";

}



?>

<style type="text/css">

<!--

.style1 {font-size: 24px}

-->

</style>











    <form action=""  method="post" enctype="multipart/form-data">

        <div class="d-flex justify-content-center">



            <div class="n-form1 fo-white pt-0 fo-short ">

                <h4 class="text-center bg-titel bold pt-2 pb-2">  LEAVE DELETE SECTION  </h4>



                        <div class="container">

                            <div class="form-group row  m-0 mb-1 pl-3 pr-3">

                                <label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Leave ID :  </label>

                                <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">



                                        <span class="oe_form_group_cell">

                                                <input type="text" name="id"  id="id" value="<?=$_POST['id']; ?>" required="required" />



                                        </span>

                                </div>

                            </div>



                        </div>



                    <div class="n-form-btn-class">

                        <input name="delete" class="btn1 btn1-bg-submit" type="submit" id="delete" value="Leave Delete" />

                    </div>



                </div>



            </div>



        </div>



    </form>

























<?php/*>

<div class="oe_view_manager oe_view_manager_current">



        <form action=""  method="post" enctype="multipart/form-data">



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







          <div  class="oe_view_manager_view_list"><div  class="oe_list oe_view">



       <table width="80%" border="1" align="center">

<tr><td height="40" colspan="4" bgcolor="#00FF00"><div align="center" class="style1">Delete IOM </div></td></tr>



<tr>

  <td>&nbsp;</td>

  <td colspan="3">&nbsp;</td>

</tr>

<tr>

  <td>&nbsp;</td>

  <td colspan="3">&nbsp;</td>

</tr>

<tr>

<td width="20%">IOM ID </td>

<td colspan="3">



    <span class="oe_form_group_cell">

<input name="id" style="width:160px;" id="id" value="<?=$_POST['id']; ?>" required="required" / class="form-control">



                </span>



</td>

                </tr>



              

              <tr>

<td colspan="4"><div align="center"><input name="delete" class="btn1 btn1-bg-submit" type="submit" id="delete" value="IOM Delete" /></div></td>

                </tr>

            </table>     

		

			



            <br />

          </div>

          </div>



          </div>



    </div>



    <div class="oe_chatter"><div class="oe_followers oe_form_invisible">



      <div class="oe_follower_list"></div>



    </div></div></div></div></div>



    </div></div>



            



        </div>



 </form>   </div>



    <*/?>



















<?






require_once SERVER_CORE."routing/layout.bottom.php";



?>