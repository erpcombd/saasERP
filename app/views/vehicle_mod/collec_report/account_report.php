<?php

require_once "../../../assets/template/layout.top.php";

$title='Sales & Collection Reports';



do_calander("#f_date");

do_calander("#t_date");



?>


<form action="master_report.php" method="post" name="form1" target="_blank" id="form1">

  <table width="100%" border="0" cellspacing="0" cellpadding="0">

    <tr>

      <td><div class="box4">

          <table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">

            <tr>

              <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

                  <tr>

                    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">

                        <tr>

                          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

                              <tr>

                              <td colspan="2" class="title1"><div align="left"><b>Select Report</b> </div></td>
                              </tr>
							  
							   

                              <tr>

                                <td width="6%"><input name="report" type="radio" class="radio" value="1010" /></td>

                                <td width="94%"><div align="left">Sales Report (Challan Wise)</div></td>
                              </tr>
							  
							  <tr>
                                <td><input name="report" type="radio" class="radio" value="353465346" /></td>
                                <td><div align="left">Invoice Maturity Report</div></td>
                              </tr>
							  
							

						
 								<tr>
							    <td><input name="report" type="radio" class="radio" value="2" /></td>

							    <td><div align="left">Cash Collection Report</div></td>
						      </tr>
							  
	 							
							  
							  <!--<tr>
							    <td><input name="report" type="radio" class="radio" value="4" /></td>

							    <td><div align="left">Sales & Collection Report</div></td>
						      </tr>-->
							  
							   <tr>
							    <td><input name="report" type="radio" class="radio" value="5" /></td>

							    <td><div align="left">Net Sales Report</div></td>
						      </tr>
								<!--<tr>
							    <td><input name="report" type="radio" class="radio" value="66" /></td>

							    <td><div align="left">Monthly Sales & Collection Report</div></td>
						      </tr>-->
								
								<tr>
							    <td><input name="report" type="radio" class="radio" value="76" /></td>

							    <td><div align="left">Yearly Net Sales Report</div></td>
						      </tr>

							  <tr>
							    <td><input name="report" type="radio" class="radio" value="86" /></td>

							    <td><div align="left">Product Group Wise Sales Report (Pending)</div></td>
						      </tr>
							  <tr>
							    <td><input name="report" type="radio" class="radio" value="86000" /></td>

							    <td><div align="left">Product Group Wise Sales Report (Pending)</div></td>
						      </tr>
							  
							   <tr>
							    <td><input name="report" type="radio" class="radio" value="96" /></td>

							    <td><div align="left">Monthly Accounts Receivable Summery Report (With Approved)</div></td>
						      </tr>
							  
							 <!-- <tr>
							    <td><input name="report" type="radio" class="radio" value="96000" /></td>

							    <td><div align="left">Monthly Accounts Receivable Summery</div></td>
						      </tr>-->
							  
	   							<tr>
							    <td><input name="report" type="radio" class="radio" value="106" /></td>

							    <td><div align="left">Delivery Pending Report (PO Wise)</div></td>
						      </tr>
							  <tr>
							    <td><input name="report" type="radio" class="radio" value="1060" /></td>

							    <td><div align="left">Customer Wise Account Receivable Report</div></td>
						      </tr>
							  <tr>
							    <td><input name="report" type="radio" class="radio" value="44412344" /></td>

							    <td><div align="left">Delivery Summary (Challan Date Wise)</div></td>
						      </tr>
							  
							  <!--<tr>
							    <td><input name="report" type="radio" class="radio" value="68" /></td>

							    <td><div align="left">Aging Report</div></td>
						      </tr>-->
                          </table>
						  
						  </td>

                        </tr>

                    </table></td>

                  </tr>

              </table></td>

              <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">

                 <tr>

                    <td>Customer Name:</td>

                    <td>
					
		<input list="cust_name" name="cust_id" id="cust_id" type="text" autocomplete="off">

<datalist id="cust_name">
<?php 
$sql='select * from dealer_info';
$query=mysql_query($sql);
while($row=mysql_fetch_object($query)){
?>
  <option value="<?php echo $row->dealer_name_e."--".$row->dealer_code;?>">
 <?php } ?>
</datalist>
					</td>
                  </tr>

                 <?php /*?> <tr>

                    <td>SR Name: </td>

                    <td><?php
  $sql="SELECT * from user_activity_management";
 
			$query=mysql_query($sql);

 ?>		 

 <input list="browsers" name="name" id="name" autocomplete="off"  style="width:250px;border-radius: 5px;"> 
               <datalist id="browsers">
		 <?php 
               while($datarow=mysql_fetch_object($query)){ ?>
              <option value="<?=$datarow->username?>"></option> 
		<?php }?>
		  </datalist></td>
                  </tr><?php */?>
                 
                    <td>From:</td>

                    <td><input  name="f_date" type="text" id="f_date" value="<?=date('Y-m-01');?>"/></td>
                  </tr>

                  <tr>

                    <td>To:</td>

                    <td><input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d');?>"/></td>
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

require_once "../../../assets/template/layout.bottom.php";

?>