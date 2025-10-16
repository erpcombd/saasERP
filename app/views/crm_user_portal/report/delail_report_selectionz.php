<?php
//
//

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Client Information Report';
?>

<script type="text/javascript">

function getflatData()

{

	var b=1;

	var a=document.getElementById('proj_code').value;

			$.ajax({

		  url: '../../common/flat_option_report.php',

		  data: "a="+a+"&b="+b,

		  success: function(data) {						

				$('#fid').html(data);	

			 }

		});

}

</script>

<form action="master_report.php" method="post" name="form1" target="_blank" id="form1">

  <table width="100%" border="0" cellspacing="0" cellpadding="0">

    <tr>

      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

          <tr>

            <td valign="top"><div class="box3">

                <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">

                  <tr>

                    <td>&nbsp;</td>

                    <td>&nbsp;</td>

                  </tr>

                  <tr>

                    <td colspan="2">Select Report </td>
                  </tr>

                  <tr>
                    <td align="center"><input type="checkbox" name="checkbox" id="checkbox" /></td>
                    <td><div align="left">Client Details Information </div></td>
                  </tr>
                  <tr>
                    <td align="center"><input type="checkbox" name="checkbox2" id="checkbox2" /></td>
                    <td><div align="left">Allotment Booking Statement (Client Wise) </div></td>
                  </tr>

                  <tr>
                    <td align="center"><input type="checkbox" name="checkbox4" id="checkbox6" /></td>
                    <td><div align="left">Client Details Information </div></td>
                  </tr>
                  <tr>
                    <td align="center"><input type="checkbox" name="checkbox4" id="checkbox5" /></td>
                    <td><div align="left">Allotment Booking Statement (Client Wise) </div></td>
                  </tr>

                  <tr>
                    <td align="center"><input type="checkbox" name="checkbox4" id="checkbox8" /></td>
                    <td><div align="left">Client Details Information </div></td>
                  </tr>
                  <tr>
                    <td align="center"><input type="checkbox" name="checkbox4" id="checkbox7" /></td>
                    <td><div align="left">Allotment Booking Statement (Client Wise) </div></td>
                  </tr>

                </table>

            </div></td>

            <td>&nbsp;</td>

            <td valign="top"><div class="box3" style="height:135px;">

              <table width="100%" border="0" cellspacing="0" cellpadding="0">

                  <tr>

                    <td colspan="2" class="title1">&nbsp;</td>

                  </tr>

                  <tr>

                    <td colspan="2" class="title1"><div align="left"></div></td>

                  </tr>

                  <tr>

                    <td width="5%" align="center"><input type="checkbox" name="checkbox3" id="checkbox3" /></td>

                    <td width="95%"><div align="left">Client Details Information </div></td>

                  </tr>

                  <tr>

                    <td align="center"><input type="checkbox" name="checkbox4" id="checkbox4" /></td>

                    <td><div align="left">Allotment Booking Statement (Client Wise) </div></td>

                  </tr>

                  

                  <tr>
                    <td align="center"><input type="checkbox" name="checkbox4" id="checkbox10" /></td>
                    <td><div align="left">Client Details Information </div></td>
                  </tr>
                  <tr>
                    <td align="center"><input type="checkbox" name="checkbox4" id="checkbox9" /></td>
                    <td><div align="left">Allotment Booking Statement (Client Wise) </div></td>
                  </tr>
                  <tr>
                    <td align="center"><input type="checkbox" name="checkbox4" id="checkbox12" /></td>
                    <td><div align="left">Client Details Information </div></td>
                  </tr>
                  <tr>
                    <td align="center"><input type="checkbox" name="checkbox4" id="checkbox11" /></td>
                    <td><div align="left">Allotment Booking Statement (Client Wise) </div></td>
                  </tr>
                </table>

            </div></td>

          </tr>

      </table></td>

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

