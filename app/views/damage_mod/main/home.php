<?php
session_start();
ob_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
?>
<style type="text/css">
<!--
.style1 {
	font-size: 24px;
	font-weight: bold;
}
.style2 {font-size: 24px}
-->
</style>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td colspan="2" valign="middle">                                    <div align="center">
                                  <p class="style2"><strong>Welcome</strong></p>
                                  <p class="style2"><strong> To </strong></p>
                                  <p class="style1">Damage & Wastege Management</p>
                                </div></td>
                              </tr>
                            </table>
<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>