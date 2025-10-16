<?php

//

//


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='L/C Entry Status Report';


create_combobox('lc_no');
do_calander("#f_date");

do_calander("#t_date");

auto_complete_from_db('item_info','item_name','item_id','1','item_id');

//auto_complete_from_db('tea_garden','garden_name','garden_id','1','garden_id');

?>


<style>
/*
.ui-state-default a, .ui-state-default a:link, .ui-state-default a:visited, a.ui-button, a:link.ui-button, a:visited.ui-button, .ui-button {
    color: #454545;
    text-decoration: none;
    display: none;
}*/


div.form-container_large input {
    width: 200px;
    height: 38px;
    border-radius: 0px !important;
}


table thead  {
  / Important /
  background-color: red;
  position: sticky;
  z-index: 100;
  top: 0;
}


</style>




<form action="stock_master_report.php" method="post" name="form1" target="_blank" id="form1">

  <table width="100%" border="0" cellspacing="0" cellpadding="0">

    <tr>

      <td><div class="box4" style="width:900px;">

          <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">

            <tr>

              <td width="50%"><table width="100%" border="0" cellspacing="0" cellpadding="0">

                  <tr>

                    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">

                        <tr>

                          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

                              <tr>

                              <td colspan="2" class="title1"><div align="left">Select Report </div></td>
                              </tr>

                            
							  
							  
							  <tr>

							    <td width="10%"><input name="report" type="radio" class="radio" value="220818001" checked="checked"  /></td>

							    <td width="90%"><div align="left">L/C Entry Status Report</div></td>
						      </tr>
							  
							  <tr>

							    <td width="10%"><input name="report" type="radio" class="radio" value="221206001"  /></td>

							    <td width="90%"><div align="left">Import L/C Report</div></td>
						      </tr>
							  <tr>

							    <td width="10%"><input name="report" type="radio" class="radio" value="217217"  /></td>

							    <td width="90%"><div align="left">Import L/C Report(Loan Wise)</div></td>
						      </tr>
							  
							  
						

                          </table></td>

                        </tr>

                    </table></td>

                  </tr>

              </table></td>

              <td valign="top" width="50%"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">

                  <tr>

                    <td>&nbsp;</td>

                    <td>&nbsp;</td>
                  </tr>

				  
				  
				  
				  
				  
				  

                  <tr>

                    <td>L/C No:</td>

                    <td><span class="oe_form_group_cell">
					
					<span id="item_sub_group">

                      <select name="lc_no" id="lc_no" tabindex="4"  >

                        <option></option>

                        <? foreign_relation('lc_number_setup','id','lc_number',$lc_no, '1');?>

                      </select>

                      </span></span></td>

                  </tr>
				  
				  
				 
				  <tr>

                    <td>L/C Type:</td>

                    <td>

                      <select name="lc_type" id="lc_type" tabindex="4"  >

                        <option></option>

                        <? foreign_relation('lc_type','id','lc_type',$lc_type, '1');?>

                      </select>

                    </td>

                  </tr>
				  
				  <tr>
 
                    <td>L/C Bank Type:</td>

                    <td>

                      <select name="bank_type" id="bank_type" tabindex="4"  >

                        <option></option>
<?php 
 $b_sql='select * from lc_bank_entry where 1   group by bank_name'; 
$b_query=db_query($b_sql);
while($b_row=mysqli_fetch_object($b_query)){
?>
                       <option value="<?php echo $b_row->bank_name;?>"><?php echo $b_row->bank_name;?></option>
					   <?php } ?>

                      </select>

                    </td>

                  </tr>
				  
			<tr>
 
                    <td>L/C Loan Type:</td>

                    <td>

                      <select name="loan_type" id="loan_type" tabindex="4"  >

                        <option></option>
<?php 
 $b_sql='select * from ledger_group where 1 and sub_class in(4,5)'; 
 
$b_query=db_query($b_sql);
while($b_row=mysqli_fetch_object($b_query)){
?>
                       <option value="<?php echo $b_row->group_id;?>"><?php echo $b_row->group_name;?></option>
					   <?php } ?>

                      </select>

                    </td>

                  </tr>

                  <tr>

                    <td>From:</td>

                    <td><input  name="f_date" type="text" id="f_date" value="<?=date('Y-m-01');?>"/></td>
                  </tr>

                  <tr>

                    <td>To:</td>

                    <td><input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d');?>"/></td>
                  </tr>

				 
				  
				  
				  
				  <!--<tr>

                    <td>Company: </td>

                    <td><select name="group_for" id="group_for" >
					
					<option></option>

                      

					  <? foreign_relation('user_group','id','group_name',$group_for,'1 ');?>

                    </select></td>
                  </tr>-->
				  
				  

               
				  

              </table></td>

            </tr>

          </table>

      </div></td>

    </tr>

    <tr>

      <td>&nbsp;</td>

    </tr>

    <tr>

      <td><div class="box">

        <table width="1%" border="0" cellspacing="0" cellpadding="0" align="center">

            <tr>

              <td><input name="submit" type="submit" class="btn" value="Report" /></td>

            </tr>

          </table>

      </div></td>

    </tr>

  </table>

</form>

<?

//

//

require_once SERVER_CORE."routing/layout.bottom.php";

?>