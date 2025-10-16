<?

session_start ();

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');
//require_once SERVER_CORE."routing/layout.top.php";
include '../config/function.php';

?>

<center>
  <span style="display: flex; align-items: center; justify-content: center; font-size: 18px; width: 30% !important; background-color: #00CCCC; text-align: center; "><?=$_GET['so_name']?></span><br>
  <span style="display: flex; align-items: center; justify-content: center; font-size: 18px; width: 20% !important; background-color: #FDDE55; text-align: center; "><?=$_GET['date']?></span><br>
  <span style="display: flex; align-items: center; justify-content: center; font-size: 18px; width: 30% !important; background-color: #B3C8CF; text-align: center; "><?=$_GET['shop_name']?></span><br>
</center>
<div style="display: flex; flex-wrap: wrap; gap: 10px; justify-content: center; margin-top: 20px;">
  

<?
  $res2='SELECT * FROM ss_doc_details WHERE do_no="'.$_GET['do_no'].'"';
  $query2=mysqli_query($conn,$res2);
  while($data2=mysqli_fetch_object($query2)){
   $filename='../../../mobile/sec_mobile_app/file/'.$data2->file_name;
 $real_fileName = basename($filename);
  $href = "../../../controllers/utilities/api_upload_attachment_show.php?name=".$real_fileName."&rx=rx";

?>
 <a href='<?=$href;?>' target='_blank'>
  <img src="<?=$filename?>" alt="Image 1" style="width: 400px; height: 200px; border-radius: 5%;">
  </a>
<?}?>
</div>
