<?php



//



//



require "../../config/inc.all.php";
$page_name = 'payslip';
if(isset($_POST['submit'])){

header('location:my_pay_silp.php?mon='.$_POST['mon'].'&&year='.$_POST['mon'].'');

}


?>

<form action="" method="post">

<table width="50%" align="center">
 <tr>
    <td colspan="2">&nbsp;</td>
</tr>
 <tr>
    <td colspan="2">&nbsp;</td>
</tr>
 <tr style="line-height:50px; background:#0056A4;">
    
	
	
	<td><div align="center"><select name="mon" id="mon" style="height:35px; width:250px;">
	 <option>..Select Month..</option>
	 <option value="1" <?=($_POST['mon']==1)? 'selected' : '' ?>>January</option>
	 <option value="2" <?=($_POST['mon']==2)? 'selected' : '' ?>>February</option>
	 <option value="3" <?=($_POST['mon']==3)? 'selected' : '' ?>>March</option>
	 <option value="4" <?=($_POST['mon']==4)? 'selected' : '' ?>>April</option>
	 <option value="5" <?=($_POST['mon']==5)? 'selected' : '' ?>>May</option>
	 <option value="6" <?=($_POST['mon']==6)? 'selected' : '' ?>>June</option>
	 <option value="7" <?=($_POST['mon']==7)? 'selected' : '' ?>>July</option>
	 <option value="8" <?=($_POST['mon']==8)? 'selected' : '' ?>>August</option>
	 <option value="9" <?=($_POST['mon']==9)? 'selected' : '' ?>>September</option>
	 <option value="10" <?=($_POST['mon']==10)? 'selected' : '' ?>>October</option>
	 <option value="11" <?=($_POST['mon']==11)? 'selected' : '' ?>>November</option>
	 <option value="12" <?=($_POST['mon']==12)? 'selected' : '' ?>>December</option>
	</select></div>-</td>
	
	<td><div align="center"><select name="year" id="year" style="height:35px; width:250px;">
	 <option>..Select Year..</option>
	 <option value="2021" <?=($_POST['year']==2021)? 'selected' : '' ?>>2021</option>
	 <option value="2022" <?=($_POST['year']==2022)? 'selected' : '' ?>>2022</option>
	 
	</select></div></td>
 </tr>
 <tr style="line-height:50px; background:#0056A4;">
    <td colspan="2"><div align="center"><input type="submit" name="submit" id="submit" value="Show" style="height:35px; width:100px; background:#ffffb0;"/></div></td>
	
 </tr>
</table>
</form>

    <?



//



//



require_once SERVER_CORE."routing/layout.bottom.php";



?>