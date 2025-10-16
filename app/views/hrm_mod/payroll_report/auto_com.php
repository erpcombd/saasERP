<?php
session_start();

//
require "../../config/inc.all.php";
if(!empty($_POST["keyword"])) {
$query ="SELECT * FROM personnel_basic_info WHERE PBI_CODE like '%" . $_POST["keyword"] . "%' ORDER BY PBI_NAME LIMIT 0,6";
$result = db_query($query);

if(!empty($result)) {
?>
<ul id="country-list">
<?php
while($d = mysqli_fetch_object($result)){
?>
<li onClick="selectCountry('<?php echo $d->PBI_CODE; ?>');"><?php echo $d->PBI_NAME; ?></li>
<?php } ?>
</ul>
<?php } } ?>