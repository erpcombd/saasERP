<?php
session_start();
ob_start();
require "../../support/inc.all.php";
$title='Hotel Room Status';
$table="hms_hotel_room_status";

do_calander('#date');
		
if(isset($_POST['date']) &&($_POST['date']!=''))
$date=$_POST['date'];
else $date=date('Y-m-d');

$sql='SELECT 
SUM(IF(status = "0", 1,0)) AS `out_of_order`,
SUM(IF(status = "1", 1,0)) AS `free`,
SUM(IF(status = "2", 1,0)) AS `dirty`,
SUM(IF(status = "9", 1,0)) AS `checked_in`,
COUNT(status) AS `total`
FROM hms_hotel_room';
$room_table_status=mysql_fetch_object(mysql_query($sql));

$sql='SELECT 
SUM(IF(room_status = "0", 1,0)) AS `free`,
SUM(IF(room_status = "1", 1,0)) AS `reserved`,
SUM(IF(room_status = "2", 1,0)) AS `out_of_order`,
SUM(IF(room_status = "9", 1,0)) AS `checked_in`,
COUNT(room_status) AS `total`
FROM hms_hotel_room_status where `date`="'.$date.'"';
$status_table_status=mysql_fetch_object(mysql_query($sql));
$out_of_order=$room_table_status->out_of_order;
$checked_in=$status_table_status->checked_in;
$reserved=$status_table_status->reserved;
$total=$room_table_status->total;
$free=$total-($out_of_order+$checked_in+$reserved);
?>
<script type = "text/javascript">var GB_ROOT_DIR = "../../greybox/";</script>
<script type = "text/javascript" src = "../../greybox/AJS.js"></script>
<script type = "text/javascript" src = "../../greybox/AJS_fx.js"></script>
<script type = "text/javascript" src = "../../greybox/gb_scripts.js"></script>

<link href = "../../greybox/gb_styles.css" rel = "stylesheet" type = "text/css" media = "all"/>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td>              <table width="100%" border="0" cellspacing="0" cellpadding="0" align="left">
                <tr>
                  <td><form id="form1" name="form1" method="post" action="">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td><table width="70%" border="0" align="center" cellpadding="0" cellspacing="0">
                                          <tr>
                                            <td class="blue">Date:</td>
                                            <td class="blue"><input name="date" type="text" id="date" value="<?=$date?>" /></td>
                                            <td class="blue"><input type="submit" name="Submit" value="Submit" /></td>
                                            <td align="right">&nbsp;</td>
                                          </tr>
                                        </table></td>
                                        <td><table width="150" border="0" cellspacing="0" cellpadding="2">
                                          <tr>
                                            <td width="130" background="../../images/8.gif"><strong>Vaccant : </strong></td>
                                            <td background="../../images/8.gif"><div align="center"><strong><?=$free?></strong></div></td>
                                          </tr>
                                          <tr>
                                            <td background="../../images/4.gif"><strong>Expected Arrival: </strong></td>
                                            <td background="../../images/4.gif"><div align="center"><strong><?=$reserved?></strong></div></td>
                                          </tr>
                                          <tr>
                                            <td background="../../images/6.gif"><strong>Occupied : </strong></td>
                                            <td background="../../images/6.gif"><div align="center"><strong><?=$checked_in?></strong></div></td>
                                          </tr>
                                          <tr>
                                            <td background="../../images/0.gif"><strong>Out of Order : </strong></td>
                                            <td background="../../images/0.gif"><div align="center"><strong><?=$out_of_order?></strong></div></td>
                                          </tr>
                                        </table></td>
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
$sql="select id,floor_name from hms_hotel_floor order by floor_no desc";
$floorq=mysql_query($sql);
while($floor=mysql_fetch_row($floorq)){
echo '<tr>';
$sql="select r.id,f.floor_name,t.room_type,r.room_no,r.status from hms_hotel_room r, hms_hotel_floor f, hms_room_type t where r.floor_id=f.id and r.room_type_id=t.id and f.id='".$floor[0]."' order by r.room_no";
$query=mysql_query($sql);
if(mysql_num_rows($query)>0)
while($data=mysql_fetch_row($query))
{
$status = 10;
$setup_status = find_all_field('hms_hotel_room_status','room_status',"room_id='".$data[0]."' and date='".$date."' order by id asc");


if($setup_status->room_status!='')
$status = $setup_status->room_status;
$room_no=$data[3];
$floor_name=$data[1];
$room_type=$data[2];
$room_status=$data[4];

if($room_status==0) $class='red';
else
{
if($status==1) $class='yallow'; // reserve
elseif($status==9) $class='purple'; // book
else $class='green'; // free
}


//$class2		='yallow';
echo '<td class="'.$class.'"><a href = "room_info.php?id='.$data[0].'&date='.$date.'" title = "'.$room_no.' :: '.$room_type.'" rel = "gb_page_center[840, 600]">'.$room_no.'<br><font size="1px">('.$room_type.')</font></a></td>';
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
$main_content=ob_get_contents();
ob_end_clean();
include ("../../template/main_layout.php");
?>