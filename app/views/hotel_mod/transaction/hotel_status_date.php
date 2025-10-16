<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Hotel Room Status';
$table="hms_hotel_room_status";

		
if(isset($_POST['room_type']) &&($_POST['room_type']!=''))
$room_type=$_POST['room_type'];
else
$room_type=1;

$sdate=date('d');
$smon=date('m');
$syear=date('Y');

?>
<script type = "text/javascript">var GB_ROOT_DIR = "../../../../public/GBox/";</script>
<!--<script type = "text/javascript" src = "../../../../public/GBox/AJS.js"></script>-->
<script type = "text/javascript" src = "../../../../public/GBox/AJS_fx.js"></script>
<script type = "text/javascript" src = "../../../../public/GBox/gb_scripts.js"></script>

<link href = "../../../../public/GBox/gb_styles.css" rel = "stylesheet" type = "text/css" media = "all"/>
<style>
.green{
	background-color: #009900 !important;
	color:#fff !important;
}
.purple{
	background-color:#800080 !important;
	color:#fff !important;
}

.red{
	background-color:#FF0000 !important;
	color:#fff !important;
}

.yallow{
	background-color: #FFFF00 !important;
	color:#333 !important;
}
</style>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td>              <table width="100%" border="0" cellspacing="0" cellpadding="0" align="left">
                <tr>
                  <td><form id="form1" name="form1" method="post" action="">
                    <table width="30%" border="0" align="left" cellpadding="0" cellspacing="0">
                      <tr>
                        <td align="right" class="blue"><div align="center">
                          <table width="150" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td>Free/Ready : </td>
                                <td background="../images/8.gif">&nbsp;&nbsp;&nbsp;</td>
                              </tr>
                            <tr>
                              <td>Reserved : </td>
                                <td background="../images/4.gif">&nbsp;</td>
                              </tr>
                            <tr>
                              <td>Checked IN : </td>
                                <td background="../images/6.gif">&nbsp;</td>
                              </tr>
                            <tr>
                              <td>Out of Order : </td>
                                <td background="../images/0.gif">&nbsp;</td>
                              </tr>
                          </table>
                        </div></td>
                      </tr>
                    </table>
                                    </form>
                  </td>
                </tr>
              </table></td></tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>              <table border="0" cellspacing="0" cellpadding="0" align="left">
                <tr>
                  <td><div class="table_flat">
                    <table cellspacing="0" cellpadding="0">

<?

echo '<tr>';
echo '<td class="blue">d/m</td>';
$sdate=date('d');
$smon=date('m');
$syear=date('Y');
for($i=0;$i<30;$i++)
{
$sday=mktime(1,1,1,$smon,$sdate,$syear);
echo '<td class="blue">'.date("d/m",$sday).'</td>';
$sdate++;
}
echo '</tr>';


$sql="select id,room_no,status from hms_hotel_room order by room_no";
$floorq=db_query($sql);
while($floor=mysqli_fetch_row($floorq))
{

echo '<tr>';
echo '<td class="blue">'.$floor[1].'</td>';

$sdate=date('d');
$smon=date('m');
$syear=date('Y');
for($i=0;$i<30;$i++)
{
$sday=mktime(1,1,1,$smon,$sdate,$syear);
$date=date('Y-m-d',$sday);
$sdate++;
$status = find_a_field('hms_hotel_room_status','room_status',"room_id='".$floor[0]."' and date='".$date."'");

if($floor[2]==0)
{
$class='red';
}
else
{
if($status==1) $class='yallow'; // reserve
elseif($status==9) $class='purple'; // book
else $class='green'; // free
}
//$class2		='yallow';
echo '<td class="'.$class.'"><a href = "room_info.php?id='.$floor[0].'&date='.$date.'" title = "'.$floor[1].'" rel = "gb_page_center[840, 600]">'.$floor[1].'</a></td>';
}
echo '</tr>';
}


?> 
					           
                      </table>
                      </div></td>
                    </tr>
              </table></td></tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>

<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>