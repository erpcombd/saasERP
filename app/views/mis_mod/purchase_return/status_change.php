<?php



session_start();



ob_start();




require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";





$title='PR Status change';			// Page Name and Page Title



$do_no = $_REQUEST['do_no'];

$status = $_REQUEST['status'];





if(isset($_REQUEST['do_no'])!='')



{


	 		 $sql1 = "update purchase_return_master set status = '".$status."' where pr_no='".$do_no."'";
			db_query($sql1);






;
	



}



?><title>Status Change</title>

<? if($do_no>0){ ?>


<div class="alert alert-success p-2" role="alert">
  Successfull
</div>


<? } ?>




<div class="form-container_large">
   
    <form action="" method="post">
           
        <div class="container-fluid bg-form-titel">
            <div class="row">
			                <div class="col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">PR No</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <input name="do_no" type="text" id="do_no"  value="<?=$do_no?>" required />
                        </div>
                    </div>

                </div>
                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Return To</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                           <select name="status" id="status">

						   <option value=""></option>
					
						  <option value="MANUAL">MANUAL</option>
					
					
						  </select>

                        </div>
                    </div>
                </div>

                <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
							<input name="search" class="btn1 btn1-submit-input" type="submit" id="search" value="CONFIRM" />
                  
                   
                </div>

            </div>
        </div>

    </form>
</div>



<?php /*?><form action="" method="post">



<div class="oe_view_manager oe_view_manager_current">



        






        <div class="oe_view_manager_body">



            



                <div  class="oe_view_manager_view_list"></div>



            



                <div class="oe_view_manager_view_form"><div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">



        <div class="oe_form_buttons"></div>



        <div class="oe_form_sidebar"></div>



        <div class="oe_form_pager"></div>



        <div class="oe_form_container"><div class="oe_form">



          <div class="">



<div class="oe_form_sheetbg" style="min-height:10px;">



        <div class="oe_form_sheet oe_form_sheet_width">







          <div  class="oe_view_manager_view_list"><div  class="oe_list oe_view">



           	 <table width="85%" border="0" align="center" cellpadding="5" cellspacing="0">



  <tr>



   

    <td bgcolor="#33CCFF"><strong>

 <label>PR NO </label>

      



      <input name="do_no" type="text" id="do_no" maxlength="16" value="<?=$do_no?>" required /> 



       



    </strong></td>

	







 









  



   



  



    <td height="35" colspan="3" align="center" valign="middle" bgcolor="#33CCCC"><label>



      Return to 

	  <select name="status" id="status" style="width:auto">

	  

	   <option value=""></option>

	  <option value="MANUAL">MANUAL</option>


	  </select>

	




    </label></td>



      <td rowspan="" align="center" valign="middle" bgcolor="#33CCCC"><strong>



      <label>



      <input name="search" class="btn1 btn1-submit-input" type="submit" id="search" value="CONFIRM" />



        </label>



    </strong></td>



  </tr>







</table>







		



		  



          </div></div>



          </div>



    </div>



    <div class="oe_chatter"><div class="oe_followers oe_form_invisible">



      <div class="oe_follower_list"></div>



    </div></div></div></div></div>



    </div></div>



            



        </div>



  </div>



</form><?php */?>



<?



$main_content=ob_get_contents();



ob_end_clean();



require_once SERVER_CORE."routing/layout.bottom.php";



?>