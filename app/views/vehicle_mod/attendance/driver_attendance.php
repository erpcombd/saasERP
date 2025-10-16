<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
require_once SERVER_CORE."routing/inc.notify.php";

if(isset($_POST['insert'])){

$emp_id = 999;

$lan = $_POST['lat'];

$long = $_POST['long'];



$xdate = date('Y-m-d');



//$xtime = date('H:i:s');

$xtime = date('Y-m-d H:i:s');

 //$insert = "INSERT INTO `hrm_attdump`(`xenrollid`,`bizid`, `latitude`, `longitude`,`xdate`,`xtime`) VALUES ('$emp_id','$emp_id','$lan','$long','$xdate','$xtime')";
 $insert = "INSERT INTO `hrm_attdump`(`xenrollid`,`bizid`, `xdate`,`xtime`) VALUES ('$emp_id','$emp_id','$xdate','$xtime')";

db_query($insert);
$inserted = "<span style='text-align: center; color: green;'>Your Attendance Successfully Submitted !!</span>";

}



?>



<!DOCTYPE html>

<html>

<head>
<style>
body {
    background: black;
}

.clock {
    position: absolute;
    
    color: #000;
    font-size: 30px;
    font-family: Orbitron;
    letter-spacing: 7px;
	richness:%;
	
   


}
</style>
</head>

<body>

<html>

<body>
<form action="" method="post"> 

<table height="300" style="width:1000px; border:0px solid #ccc; margin-top:100px; background:aliceblue;" align="center">
<tr>
  <td colspan="2"  align="center"><div align="center"><div style="margin-left:15%;"  align="center" id="MyClockDisplay" class="clock" onload="showTime()"></div></div></td>
</tr>
<tr>
  <td colspan="2" align="center">&nbsp;</td>
</tr>
<tr>
  <td colspan="2">&nbsp;</td>
</tr>
<tr>
  <td colspan="2"  align="center"><div align="center">Date : <?=date('Y-M-d')?></div></td>
</tr>

<tr>
  <td colspan="2"><span id="show" style="text-align:center"></span></td>
</tr>
<tr>
  <td colspan="2">&nbsp;</td>
</tr>
<tr>
  <td colspan="2">&nbsp;</td>
</tr>
<tr>
  <td colspan="2"><div align="center"><? if($inserted!='') echo $inserted;?></div></td>
</tr>

<tr>
  <td colspan="2">&nbsp;</td>
</tr>

<tr>
  <td colspan="2" align="center" ><input  type="hidden" name="emp_id" value="<?=$_SESSION['employee_selected']?>">

   <input style="height: 60px;" type="submit" name="insert" value="Click For Attendance"></td>
</tr>



</table>








</form>

</body>

</html>



<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>

<script>

window.onload = function() {
  getLocation();
};


var x = document.getElementById('output');



function getLocation(){



if(navigator.geolocation){

navigator.geolocation.getCurrentPosition(showPosition); 



}else{



x.innerHTML = "Browser not Supporting";

}



}



function showPosition(position){



x.innerHTML = "<br /> &emsp;<input type='hidden'  readonly='' required=''  name='lat' value='"+position.coords.latitude+"'>";

x.innerHTML += "<br /><br />" 

x.innerHTML += "<input  type='hidden' name='long'  readonly='' required='' value='"+position.coords.longitude+"'>";

x.innerHTML += "<br /><br />" ;









}

</script>





</body>



</html>





<script>
function showTime(){
    var date = new Date();
    var h = date.getHours(); // 0 - 23
    var m = date.getMinutes(); // 0 - 59
    var s = date.getSeconds(); // 0 - 59
    var session = "AM";
    
    if(h == 0){
        h = 12;
    }
    
    if(h > 12){
        h = h - 12;
        session = "PM";
    }
    
    h = (h < 10) ? "0" + h : h;
    m = (m < 10) ? "0" + m : m;
    s = (s < 10) ? "0" + s : s;
    
    var time = 'Current Time : '+ h + ":" + m + ":" + s + " " + session;
    document.getElementById("MyClockDisplay").innerText = time;
    document.getElementById("MyClockDisplay").textContent = time;
    
    setTimeout(showTime, 1000);
    
}

showTime();
</script>



<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>