<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
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
$room_table_status=mysqli_fetch_object(db_query($sql));

$sql='SELECT 
SUM(IF(room_status = "0", 1,0)) AS `free`,
SUM(IF(room_status = "1", 1,0)) AS `reserved`,
SUM(IF(room_status = "2", 1,0)) AS `out_of_order`,
SUM(IF(room_status = "9", 1,0)) AS `checked_in`,
COUNT(room_status) AS `total`
FROM hms_hotel_room_status where `date`="'.$date.'"';
$status_table_status=mysqli_fetch_object(db_query($sql));
$out_of_order=$room_table_status->out_of_order;
$dirty=$room_table_status->dirty;
$checked_in=$room_table_status->checked_in;
$reserved=$status_table_status->reserved;
$total=$room_table_status->total;
$free=$total-($out_of_order+$checked_in+$dirty);
?>
<!--<script type = "text/javascript">var GB_ROOT_DIR = "../../greybox/";</script>
<script type = "text/javascript" src = "../../greybox/AJS.js"></script>
<script type = "text/javascript" src = "../../greybox/AJS_fx.js"></script>
<script type = "text/javascript" src = "../../greybox/gb_scripts.js"></script>-->

<script type = "text/javascript">var GB_ROOT_DIR = "../../../../public/GBox/";</script>
<!--<script type = "text/javascript" src = "../../../../public/GBox/AJS.js"></script>-->
<script type = "text/javascript" src = "../../../../public/GBox/AJS_fx.js"></script>
<script type = "text/javascript" src = "../../../../public/GBox/gb_scripts.js"></script>



<link href = "../../greybox/gb_styles.css" rel = "stylesheet" type = "text/css" media = "all"/>
<style>
.green{
	color:#fff !important;
	background: linear-gradient(0deg, rgba(116,209,130,1) 0%, rgba(185,226,192,1) 60%)!important;
}
.purple{
	color:#fff !important;
background: linear-gradient(0deg, rgba(234,175,206,1) 0%, rgba(217,101,161,1) 60%) !important;
}

.red{
	color:#fff !important;
	background: linear-gradient(0deg, rgba(243,183,172,1) 0%, rgba(238,134,116,1) 60%)!important;
}

.yellow{
	color:#333 !important;
	background: linear-gradient(0deg, rgba(203,172,123,1) 14%, rgba(230,215,174,0.9920343137254902) 53%)!important;
	
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
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td><table width="70%" border="0" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                              <td colspan="3" class="blue"><div align="center">Present Time: <?=date('h:i:s A')?></div></td>
                              </tr>
                            <tr>
                              <td class="blue">Date:</td>
                              <td class="blue"><input name="date" type="text" id="date" value="<?=$date?>" /></td>
                              <td class="blue"><input type="submit" name="Submit" value="Submit" /></td>
                              <td align="right">&nbsp;</td>
                            </tr>
                        </table></td>
                        <td><table width="150" border="0" cellspacing="0" cellpadding="2">
                            <tr>
                              <td width="130"  background="../images/8.gif"><strong>Vacant Ready : </strong></td>
                              <td background="../images/8.gif"><div align="center"><strong>
                                <?=$free?>
                              </strong></div></td>
                            </tr>
                            <tr>
                              <td background="../images/5.gif"><strong>Vacant Dirty : </strong></td>
                              <td background="../images/5.gif"><div align="center"><strong>
                                <?=$dirty?>
                              </strong></div></td>
                            </tr>
                            <tr>
                              <td background="../images/6.gif"><strong>Occupied : </strong></td>
                              <td background="../images/6.gif"><div align="center"><strong>
                                <?=$checked_in?>
                              </strong></div></td>
                            </tr>
                            <tr>
                              <td background="../images/0.gif"><strong>Out of Order : </strong></td>
                              <td background="../images/0.gif"><div align="center"><strong>
                                <?=$out_of_order?>
                              </strong></div></td>
                            </tr>
                        </table></td>
                      </tr>
                    </table>
                  </form></td>
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
$floorq=db_query($sql);
while($floor=mysqli_fetch_row($floorq)){
echo '<tr>';
$sql="select r.id,f.floor_name,t.room_type,r.room_no,r.status from hms_hotel_room r, hms_hotel_floor f, hms_room_type t where r.floor_id=f.id and r.room_type_id=t.id and f.id='".$floor[0]."' order by r.room_no";
$query=db_query($sql);
if(mysqli_num_rows($query)>0)
while($data=mysqli_fetch_row($query))
{
$reserve_id=0;
$status = find_a_field('hms_hotel_room_status','room_status',"room_id='".$data[0]."' and date='".$date."' order by id desc");

$old_date = date ("Y-m-d", strtotime("-1 day", strtotime($date)));

$reserve_id = find_a_field('hms_hotel_room_status','reserve_id',"room_id='".$data[0]."' and (date='".$old_date."' or date='".$date."') order by id desc");
//echo $status;
if(($reserve_id>0)&&($status!=1)) $c_date = find_a_field('hms_reservation','check_out_date',"checked_in>0 and checked_out=0 and id=".$reserve_id);
else $c_date='0000-00-00';

$room_no=$data[3];
$floor_name=$data[1];
$room_type=$data[2];
$room_status=$data[4];

if(($c_date==$date)&&($room_status==9)){
$class='firoza'; 
}
elseif($room_status==0)
{
$class='red';
}
elseif($room_status==2)
{
$class='yellow';
}
else
{
//if($status==1){ $class='yellow'; } // reserve
if($room_status==9) 
	{
	$class='purple'; // book
	}
else 
$class='green'; // free
}


//$class2		='yallow';
echo '<td class="'.$class.'"><a href = "room_info_front.php?id='.$data[0].'&date='.$date.'" title = "'.$room_no.' :: '.$room_type.'" rel = "gb_page_center[840, 600]">'.$room_no.'<br><font size="1px">('.$room_type.')</font></a></td>';
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