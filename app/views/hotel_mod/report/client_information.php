<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Client Information Report';

do_calander("#f_date");
do_calander("#t_date");
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
                    <td>Project  :</td>
                    <td><select name="proj_code" id="proj_code" onchange="getflatData();">
                        <? if(isset($_REQUEST['proj_code'])) $proj_code=$_REQUEST['proj_code'];
foreign_relation('tbl_project_info','proj_code','proj_name',$proj_code);?>
                    </select></td>
                  </tr>
                  <tr>
                    <td>Category : </td>
                    <td><select name="building" id="building" onchange="getflatData();">
                        <? if(isset($_REQUEST['building'])&&isset($_REQUEST['proj_code'])) $building=$_REQUEST['building'];
$sql='select bid,category from tbl_building_info';
join_relation($sql,$_REQUEST['building']);?>
                    </select></td>
                  </tr>
                  <tr>
                    <td>Allotment no.: </td>
                    <? if(isset($_REQUEST['flat'])) $flat=$_REQUEST['flat'];?>
                    <td><span id="fid">
                      <select name="flat" id="flat">
                        <? 
foreign_relation('tbl_flat_info','fid','flat_no',$flat);?>
                      </select>
                    </span></td>
                  </tr>
                  <tr>
                    <td>Client: </td>
                    <td><select name="party_code" id="party_code">
                        <option value=""></option>
                        <?php $items = mysql_query("select * from tbl_party_info");
	 									 while($itemname = mysql_fetch_row($items))
	  									{
	  										if($party_code==$itemname[1]) 
	  										{
	  										echo "<option value=\"$itemname[1]\" selected>$itemname[1]: $itemname[2]</option>";
											}
	  										else
											{
												echo "<option value=\"$itemname[1]\">$itemname[1]: $itemname[2]</option>";
											}
	  									}
	  									?>
                    </select></td>
                  </tr>
                  <tr>
                    <td>From : </td>
                    <td><input  name="f_date" type="text" id="f_date" value=""/></td>
                  </tr>
                  <tr>
                    <td>To : </td>
                    <td><input  name="t_date" type="text" id="t_date" value=""/></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
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
                    <td colspan="2" class="title1"><div align="left">Select Report </div></td>
                  </tr>
                  <tr>
                    <td width="5%"><input name="report" type="radio" class="radio" value="5" /></td>
                    <td width="95%"><div align="left">Client Details Information </div></td>
                  </tr>
                  <tr>
                    <td><input name="report" type="radio" class="radio" value="2" /></td>
                    <td><div align="left">Allotment Booking Statement (Client Wise) </div></td>
                  </tr>
                  
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
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

require_once SERVER_CORE."routing/layout.bottom.php";

?>
