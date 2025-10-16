<?php


//


//



 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$title='Pending Approval';





do_calander("#f_date");


do_calander("#t_date");


auto_complete_from_db('dealer_info','concat(dealer_code,"-",product_group,"-",dealer_name_e)','dealer_code','dealer_type="Distributor" and canceled="Yes"','dealer_code');


?>

<form action="pending_approval_report.php" method="post" name="form1" target="_blank" id="form1">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><div class="box4">
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
                             
							  
							  <? $paper_comb_count = find_a_field('paper_combination','count(id)','approval="No"');?>
							  
							  <tr>
                                <td><input name="report" type="radio" class="radio" value="2203211" checked="checked" tabindex="2"/></td>
                                <td><div align="left"> Paper Combination <? if($paper_comb_count>0) {?><span style="color:#FF0000; font-weight:700;">(<?=$paper_comb_count;?>)</span><? }?></div></td>
                              </tr>
							  
							  
							  
							    
							  <? $addi_info = find_a_field('additional_information','count(id)','approval="No"');?>
							  
							  <tr>
                                <td><input name="report" type="radio" class="radio" value="2203212"  tabindex="2"/></td>
                                <td><div align="left"> Additional Information <? if($addi_info>0) {?><span style="color:#FF0000; font-weight:700;">(<?=$addi_info;?>)</span><? }?></div></td>
                              </tr>
							  
							  
							  
							  <? $num_decimal = find_a_field('decimal_numbers','count(id)','approval="No"');?>
							  
							  <tr>
                                <td><input name="report" type="radio" class="radio" value="2203213"  tabindex="2"/></td>
                                <td><div align="left"> Decimal Numbers <? if($num_decimal>0) {?><span style="color:#FF0000; font-weight:700;">(<?=$num_decimal;?>)</span><? }?></div></td>
                              </tr>
							  
							  
							  
							
                            </table></td>
                        </tr>
                      </table></td>
                  </tr>
                </table></td>
              <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                  
                
				  <!--<tr>
                    <td>From :</td>
                    <td><span class="oe_form_group_cell">
                      <input  name="f_date" type="text" id="f_date" value="<?=date('Y-m-01')?>" style="width:250px"/>
                      </span></td>
                  </tr>
				  
				  <tr>
                    <td>To :</td>
                    <td><span class="oe_form_group_cell">
                      <input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d')?>" style="width:250px"/>
                      </span></td>
                  </tr>-->
				  
				  
				  
				 <tr>
                    <td>Customer Name:</td>
                    <td><span class="oe_form_group_cell">
                      <input list="dealer_name_e" name="customer_name" id="customer_name"  style="width:250px; float:left;"  onchange="getData2('buyer_ajax.php', 'buyer_filter', this.value, 
document.getElementById('customer_name').value);"  autocomplete="off" >
  <datalist id="dealer_name_e">
   
     <? foreign_relation('dealer_info','CONCAT(dealer_code, "->", dealer_name_e)','dealer_name_e',$dealer_code,'1');?>
  </datalist>
                      </span></td>
                  </tr>  
				  
				  
				
				  <tr>
                    <td>Buyer Name:</td>
                    <td><span class="oe_form_group_cell">
                     <span id="buyer_filter">

	
		 <input list="buyer_name" name="buyer" id="buyer"  style="width:250px; float:left;"   autocomplete="off" >
  <datalist id="buyer_name">
	 
	 <? foreign_relation('buyer_info','CONCAT(buyer_code, "->", buyer_name)','buyer_name',$buyer,'dealer_code="'.$dealer_code.'" order by buyer_name');?>

  </datalist>


		 </span>
                      </span></td>
                  </tr>
				  
				  
				   <tr>
                    <td>No of Ply:</td>
                    <td><span class="oe_form_group_cell">
                      <select name="ply" id="ply" tabindex="5"  style="width:250px; float:left;">
                        <option></option>
                        <? foreign_relation('paper_ply','ply','paper_ply',$ply);?>
                      </select>
                      </span></td>
                  </tr>
				  
				  
				  <tr>
                    <td>Status:</td>
                    <td><span class="oe_form_group_cell">
                      <select name="approval" id="approval" tabindex="5"  style="width:250px; float:left;">
                        <option></option>
                        <? foreign_relation('yes_no','yes_no','yes_no',$approval);?>
                      </select>
                      </span></td>
                  </tr>
				  
				  
				  <!--<tr>
                    <td>Concern Name :</td>
                    <td><span class="oe_form_group_cell">
                      <select name="group_for" id="group_for" tabindex="5">
                        <option></option>
                        <? foreign_relation('user_group','id','group_name',$group_for);?>
                      </select>
                      </span></td>
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
              <td><input name="submit" type="submit" class="btn" value="Report" tabindex="6" /></td>
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
