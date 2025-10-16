<?php

require_once "../../../assets/template/layout.top.php";

$title='Accounts MIS Reports';



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
							    <td><input name="report" type="radio" class="radio" value="6" /></td>

							    <td><div align="left">MIS Report</div></td>
						      </tr>
							  
							  

							  

                          </table></td>

                        </tr>

                    </table></td>

                  </tr>

              </table></td>

              <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">

                  <tr>

                    <td>&nbsp;</td>

                    <td>&nbsp;</td>
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