<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title=" Letter";
$head = '<link href="../../css/report_selection.css" type="text/css" rel="stylesheet"/>';

do_calander('#ijdb');
do_calander('#ijda');
do_calander('#ppjdb');
do_calander('#ppjda');

if ($_POST['year'] != "")
  $year = $_POST['year'];

else
  $year = date('Y');

if ($_POST['mon'] != "")
  $mon = $_POST['mon'];

else
  $mon = date('n');
?>


<style type="text/css">
  .style1 {

    font-size: 16px;

  }
</style>







<form action="../letter_report/master_report.php" target="_blank" method="post">

  <div class="oe_view_manager oe_view_manager_current">


    <div class="oe_view_manager_body">

      <div class="oe_view_manager_view_form">
        <div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">

          <div class="oe_form_buttons"></div>

          <div class="oe_form_sidebar"></div>

          <div class="oe_form_pager"></div>

          <div class="oe_form_container">
            <div class="oe_form">

              <div class="">



                <div class="oe_form_sheetbg">
                  <div class="oe_form_sheet oe_form_sheet_width">
                    <div class="oe_view_manager_view_list">
                      <div class="oe_list oe_view">

                        <table style="width:100%; border-collapse: collapse;">



                          <tbody>

                            <tr>
                              <td style="text-align: right; padding: 10px;background-color: #2F739B;color: white;"><strong>Employee ID:</strong></td>
                              <td style="padding: 10px;background-color: #2F739B;"> <input type="text" list='eip_ids' name="emp_id" id="emp_id" value="<?= $_POST['emp_id'] ?>" />

                                <datalist id='eip_ids'>
                                  <option></option>
                                  <?
                                  foreign_relation('personnel_basic_info', 'PBI_CODE', 'concat(PBI_CODE," - ",PBI_NAME)', $emp_id, '1');
                                  ?>
                                </datalist>

                              </td>
                              <td style="text-align: right; padding: 10px;background-color: #2F739B;"></td>
                              <td style="padding: 10px;background-color: #2F739B;"></td>
                            </tr>


                            <tr>
                              <td style="text-align: right; padding: 10px; background-color: #2F739B; color: white;"><strong>Effect Date:</strong></td>

                              <td style="padding: 10px; background-color: #2F739B;">
                                <input type="date" name="effect_date" id="effect_date" style="border-radius: 4px; border: 1px solid #ccc; padding: 6px 12px;background-color: #2F739B;">
                              </td>

                              <td style="text-align: right; padding: 10px;background-color: #2F739B;"></td>

                              <td style="padding: 10px;background-color: #2F739B;"></td>
                            </tr>


                          </tbody>

                        </table>

                        <br>

                        <table style="width:100%; border-collapse: collapse;">

                          <thead>

                            <tr>

                              <th colspan="4" style="text-align: center; font-size: 20px; font-weight: bold; padding: 10px; color: white; background-color: #2F739B;">
                                Select Letter
                              </th>

                            </tr>

                          </thead>

                          <tbody>



                            <tr style="background-color: white;">

                              <td style="text-align: center; padding: 10px;"><input name="report" type="radio" class="radio" value="22" checked></td>

                              <td style="padding: 10px;"><strong>Appointment Letter</strong></td>

                              <td style="text-align: center; padding: 10px;"></td>

                              <td style="padding: 10px;"></td>

                            </tr>



                            <tr style="background-color: #f2f2f2;">

                              <td style="text-align: center; padding: 10px;"><input name="report" type="radio" class="radio" value="23"></td>

                              <td style="padding: 10px;"><strong>Offer Letter</strong></td>

                              <td style="text-align: center; padding: 10px;"></td>

                              <td style="padding: 10px;"></td>

                            </tr>



                            <tr style="background-color: white;">

                              <td style="text-align: center; padding: 10px;"><input name="report" type="radio" class="radio" value="24"></td>

                              <td style="padding: 10px;"><strong>Promotion Letter</strong></td>

                              <td style="text-align: center; padding: 10px;"></td>

                              <td style="padding: 10px;"></td>

                            </tr>



                            <tr style="background-color: white;">

                              <td style="text-align: center; padding: 10px;"><input name="report" type="radio" class="radio" value="25" checked></td>

                              <td style="padding: 10px;"><strong>Termination Request Letter</strong></td>

                              <td style="text-align: center; padding: 10px;"></td>

                              <td style="padding: 10px;"></td>

                            </tr>



                            <tr style="background-color: #f2f2f2;">

                              <td style="text-align: center; padding: 10px;"><input name="report" type="radio" class="radio" value="26"></td>

                              <td style="padding: 10px;"><strong>Salary Certificate Letter</strong></td>

                              <td style="text-align: center; padding: 10px;"></td>

                              <td style="padding: 10px;"></td>

                            </tr>



                            <tr style="background-color: white;">

                              <td style="text-align: center; padding: 10px;"><input name="report" type="radio" class="radio" value="27"></td>

                              <td style="padding: 10px;"><strong>Increment Letter</strong></td>

                              <td style="text-align: center; padding: 10px;"></td>

                              <td style="padding: 10px;"></td>

                            </tr>



                            <tr style="background-color: white;">

                              <td height="44" style="text-align: center; padding: 10px;"><input name="report" type="radio" class="radio" value="28"></td>

                              <td style="padding: 10px;"><strong>Holiday Notice Letter</strong></td>

                              <td style="text-align: center; padding: 10px;"></td>

                              <td style="padding: 10px;"></td>

                            </tr>

                          </tbody>

                        </table>


                        <div style="padding: 10px;"></div>
                        <div style="text-align: center; font-size:16px; color:green">

                          <input name="submit" type="submit" id="submit" value="SHOW" />

                        </div>





                        <!--

                        <table width="100%" class="oe_list_content">



                          <thead>



                            <tr class="oe_list_header_columns">



                              <th colspan="4">
                                <p style="text-align: center; font-size:16px; color:#C00">&nbsp;</p>

                                <p style="text-align: center; font-size:16px; color:#C00">Select Letter </p>
                              </th>

                            </tr>

                          </thead>



                          <tfoot>

                          </tfoot>



                          <tbody>



                            <tr>



      <td width="4%" align="center"><input name="report" type="radio" class="radio" value="1" checked="checked" /></td>



      <td width="44%"><strong>Basic </strong> <strong>Information</strong></td>



      <td width="4%" align="center">&nbsp;</td>



      <td width="44%">&nbsp;</td>



      </tr>







                            <tr>



                              <td width="4%" align="center">
                                <p>

                                  <input name="report" type="radio" class="radio" value="22" checked="checked" />

                                </p>
                              </td>



                              <td width="44%">
                                <p><strong>Probation Period Letter </strong></p>
                              </td>



                              <td width="4%" align="center">&nbsp;</td>



                              <td width="44%">&nbsp;</td>

                            </tr>











                            <tr class="alt">



                              <td align="center">
                                <p>&nbsp;

                                </p>

                                <p>

                                  <input name="report" type="radio" class="radio" value="23" />

                                </p>
                              </td>



                              <td>
                                <p>&nbsp;</p>

                                <p><strong>Appoinment Letter(Job Confirmation) </strong></p>
                              </td>



                              <td align="center">&nbsp;</td>



                              <td>&nbsp;</td>

                            </tr>



                            <tr  class="alt">



      <td align="center"><input name="report" type="radio" class="radio" value="7" /></td>



      <td><strong>Payroll  </strong> <strong>Information (New)</strong></td>



      <td align="center">&nbsp;</td>



      <td>&nbsp;</td>



    </tr>



                            <tr class="alt">



                              <td align="center">
                                <p>&nbsp;

                                </p>

                                <p>

                                  <input name="report" type="radio" class="radio" value="24" />

                                </p>
                              </td>



                              <td>
                                <p>&nbsp;</p>

                                <p><strong>Promotion Letter </strong><strong></strong></p>
                              </td>



                              <td align="center">&nbsp;</td>



                              <td>&nbsp;</td>

                            </tr>



                            <tr class="alt">



                              <td align="center">
                                <p>&nbsp;

                                </p>

                                <p>

                                  <input name="report" type="radio" class="radio" value="25" />

                                </p>
                              </td>



                              <td>
                                <p>&nbsp;</p>

                                <p><strong>Increment Letter</strong><strong></strong></p>
                              </td>



                              <td align="center">&nbsp;</td>



                              <td>&nbsp;</td>

                            </tr>



                            <tr class="alt">



                              <td align="center">
                                <p>&nbsp;

                                </p>

                                <p>

                                  <input name="report" type="radio" class="radio" value="26" />

                                </p>
                              </td>



                              <td>
                                <p>&nbsp;</p>

                                <p><strong>Potential Factor Report</strong><strong></strong></p>
                              </td>



                              <td align="center">&nbsp;</td>



                              <td>&nbsp;</td>

                            </tr>



                            <tr class="alt">



                              <td align="center">
                                <p>&nbsp;

                                </p>

                                <p>

                                  <input name="report" type="radio" class="radio" value="27" />

                                </p>
                              </td>



                              <td>
                                <p>&nbsp;</p>

                                <p><strong>Probationary Appointment Letter Office </strong><strong></strong></p>
                              </td>



                              <td align="center">&nbsp;</td>



                              <td>&nbsp;</td>

                            </tr>



                            <tr class="alt">



                              <td align="center">
                                <p>&nbsp;

                                </p>

                                <p>

                                  <input name="report" type="radio" class="radio" value="28" />

                                </p>
                              </td>



                              <td>
                                <p>&nbsp;</p>

                                <p><strong>Job Confirmation Letter Office</strong><strong></strong></p>
                              </td>



                              <td align="center">&nbsp;</td>



                              <td>&nbsp;</td>

                            </tr>



                            <tr class="alt">



                              <td align="center">
                                <p>&nbsp;

                                </p>

                                <p>

                                  <input name="report" type="radio" class="radio" value="29" />

                                </p>
                              </td>



                              <td>
                                <p>&nbsp;</p>

                                <p><strong>Increment salary Office</strong><strong></strong></p>
                              </td>



                              <td align="center">&nbsp;</td>



                              <td>&nbsp;</td>

                            </tr>



                            <tr class="alt">



                              <td align="center">
                                <p>&nbsp;

                                </p>

                                <p>

                                  <input name="report" type="radio" class="radio" value="30" />

                                </p>
                              </td>



                              <td>
                                <p>&nbsp;</p>

                                <p><strong>Promotion Letter Office </strong><strong></strong></p>
                              </td>



                              <td align="center">&nbsp;</td>



                              <td>&nbsp;</td>

                            </tr>

                            <tr class="alt">



                              <td align="center">
                                <p>&nbsp;

                                </p>

                                <p>

                                  <input name="report" type="radio" class="radio" value="100" />

                                </p>
                              </td>



                              <td>
                                <p>&nbsp;</p>

                                <p><strong>Promotion and Confirmaton Letter Office </strong><strong></strong></p>
                              </td>



                              <td align="center">&nbsp;</td>



                              <td>&nbsp;</td>

                            </tr>





                            <!--<tr >



      <td align="center" class="alt"><input name="report" type="radio" class="radio" value="66" /></td>



      <td class="alt"><strong>Salary Payroll Report (Final)</strong><strong></strong></td>



      <td align="center">&nbsp;</td>



      <td>&nbsp;</td>



    </tr>

                          </tbody>

                        </table>

                        <div style="text-align: center; font-size:16px; color:#C00">

                          <input name="submit" type="submit" id="submit" value="SHOW" />

                        </div>


-->


                      </div>

                    </div>

                  </div>



                </div>



              </div>



              <div class="oe_chatter">
                <div class="oe_followers oe_form_invisible">



                  <div class="oe_follower_list">

                  </div>



                </div>
              </div>
            </div>
          </div>
        </div>



      </div>
    </div>







  </div>



  </div>



</form>



<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>