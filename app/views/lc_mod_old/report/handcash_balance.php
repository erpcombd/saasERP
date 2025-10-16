<?php

//

//


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Cash in Hand';



do_calander("#f_date");

do_calander("#t_date");

create_combobox('ledger_id');

create_combobox('dealer_code');

auto_complete_from_db('item_info','concat(item_name)','item_id','product_nature="Salable"','item_search');
//auto_complete_from_db('dealer_info','concat(dealer_code,"-",dealer_name_e)','dealer_code','canceled="Yes"','dealer_code');

//auto_complete_from_db('dealer_info','dealer_code','concat(dealer_code,"-",dealer_name_e)','1','dealer_code');
//
//auto_complete_from_db('dealer_info','dealer_code','concat(dealer_code,"-",dealer_name_e)','1','dealer_code_to');

//auto_complete_from_db('dealer_info','concat(dealer_code,"-",dealer_name_e)','concat(dealer_code,"-",dealer_name_e)','1','dealer_code');


?>



<form action="cash_master_report.php" method="post" name="form1" target="_blank" id="form1">

  <table width="100%" border="0" cellspacing="0" cellpadding="0">

    <tr>


      <td><div class="box4" style="width:950px;">

          <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">

            <tr>

              <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

                  <tr>

                    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">

                        <tr>

                          <td><table width="100%" border="0" cellspacing="0" cellpadding="0" style="text-transform:uppercase;">

                              <tr>

                                <td colspan="2" class="title1"><div align="left">Select Report </div></td>
                              </tr>

                         
																					 
																					 
																					 
																					 
																					 
																					 
																					 
																					 
																					 
																					 
																					 
																					 
																					 
																					
																				<?php /*?>	 <? if($_SESSION['user']['id']==10002) {?>  <? }?><?php */?>
																					 <tr>

							  															  <td><input name="report" type="radio" class="radio" value="220307006" checked="checked" /></td>

																							<td><div align="left">HAND CASH Balance</div></td>
																					 </tr>
																					 
																					
																					 
																				
								

                          </table></td>

                        </tr>

                    </table></td>

                  </tr>

              </table></td>

              <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">

               
				  
				  
				  
				  
				  
				  
				  
				  
				  
				  
				  
				  
				  
				  
				  <tr>

                    <td>Ledger Name: </td>

                    <td>
					<span id="find_item">
					<select name="ledger_id" id="ledger_id">

                      <option></option>

                      <? foreign_relation('accounts_ledger','ledger_id','ledger_name',$item_id, "ledger_group_id=1013");?>

                    </select></span></td>
                  </tr>
				  
				  
				  
				  
				  
				  
				 

                  <tr>

                    <td>From Date: </td>

                    <td><input  name="f_date" type="text" id="f_date" value="<?=date('Y-m-d')?>"/></td>

                  </tr>

                  <tr>

                    <td>To Date: </td>

                    <td><input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d')?>"/></td>

                  </tr>

				  
				  
				  
				  
				  
				  
				  
				  
				  

					

				  

				
				  
				  
				  
				  
				  

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