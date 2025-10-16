<?php

//

//


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='PRODUCT INFORMATION';



do_calander("#f_date");

do_calander("#t_date");

create_combobox('item_id');

//auto_complete_from_db('dealer_info','concat(dealer_code,"-",dealer_name_e)','dealer_code','canceled="Yes"','dealer_code');

auto_complete_from_db('dealer_info','concat(dealer_code,"-",dealer_name_e)','concat(dealer_code,"-",dealer_name_e)','1','dealer_code');
?>



<form action="master_report.php" method="post" name="form1" target="_blank" id="form1">

  <table width="100%" border="0" cellspacing="0" cellpadding="0">

    <tr>


      <td><div class="box4" style="width:950px;">

          <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">

            <tr>

              <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

                  <tr>

                    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">

                        <tr>

                          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

                              <tr>

                                <td colspan="2" class="title1"><div align="left">Select Report </div></td>
                              </tr>
							  
							  
							  
							  <tr>

							  		 <td><input name="report" type="radio" class="radio" value="223101001" checked="checked" /></td>

									<td><div align="left">PRODUCT INFORMATION</div></td>
							 </tr>

                           
							 
																					 
																					 
																				
																					 
																					



                          </table></td>

                        </tr>

                    </table></td>

                  </tr>

              </table></td>

              <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">

                
				  
				  <tr>

                    <td>Item Mother Group:</td>

                    <td><span class="oe_form_group_cell">

                      <select name="item_mother_group" id="item_mother_group"  onchange="getData2('item_mother_group_ajax.php', 'mother_group', this.value, 
document.getElementById('item_mother_group').value);">

                      <option></option>

                        <? foreign_relation('item_mother_group','id','mother_group_name',$item_mother_group);?>

                      </select>

                    </span></td>

                  </tr>
				  
				  <tr>

                    <td>Item Group: </td>

                    <td>
					<span id="mother_group">
					<select name="item_group" id="item_group"  onchange="getData2('item_sub_group_ajax.php', 'sub_group', this.value, 
document.getElementById('item_group').value);">

                      <option></option>
                      <? foreign_relation('item_group','group_id','group_name',$item_group, 'product_type="Finish Goods" order by group_for, group_name');?>

                    </select>
					</span></td>
                  </tr>
				  
				  
				  
				    
				  <tr>

                    <td>Item Sub Group: </td>

                    <td>
					<span id="sub_group">
					<select name="item_sub_group" id="item_sub_group"  onchange="getData2('item_info_find_ajax.php', 'find_item', this.value, 
document.getElementById('item_sub_group').value);">

                      <option></option>

                      <? foreign_relation('item_sub_group','sub_group_id','sub_group_name',$item_sub_group, "fg_sub_group='Yes' order by sub_group_sl" );?>

                    </select></span></td>
                  </tr>
				  
				  
				  <tr>

                    <td>Item Name: </td>

                    <td>
					<span id="find_item">
					<select name="item_id" id="item_id">

                      <option></option>

                      <? foreign_relation('item_info i, item_sub_group s','i.item_id','i.item_name',$item_id, "i.product_nature='Salable' and s.fg_sub_group='Yes' and i.sub_group_id=s.sub_group_id order by s.sub_group_sl,  i.item_name ");?>

                    </select></span></td>
                  </tr>
				  
				  
				 
				
				 
                  

				  
				  
				  <tr>
                    <td>Company:</td>
                    <td><span class="oe_form_group_cell" >
                      <select class="form-control" name="group_for" id="group_for" >
                        <option></option>
                        <? foreign_relation('user_group','id','group_name',$group_for,'1');?>
                      </select>
                      </span></td>
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