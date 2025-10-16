<?php
session_start ();
include ("config/access_admin.php");
include ("config/db.php");
include 'config/function.php';


$today 			  = date('Y-m-d');
$company_id   = $_SESSION['company_id'];
$menu 			  = 'Target';
$sub_menu 		= 'target_upload';




if($_POST['target_month']!=''){
$target_month=$_POST['target_month'];}
else{
$target_month=date('n');
}

if($_POST['target_year']!=''){
$target_year=$_POST['target_year'];}
else{
$target_year=date('Y');
}




if(isset($_POST["upload"])){
$target_year 		= $_POST['target_year'];
$target_month 		= sprintf('%02d', $_POST['target_month']);
$grp 				= $_POST['grp'];
$now = date('Y-m-d H:i:s');
$target_period = $target_year.$target_month;



// delete old upload if exists
$del = "DELETE FROM sale_target_upload WHERE grp='".$_POST['grp']."' and target_year='".$_POST['target_year']."' and target_month='".$_POST['target_month']."' ";
mysqli_query($conn,$del); 
// end delete


// 
$sql="SELECT * from item_info WHERE  finish_goods_code>0";
$res = mysqli_query($conn,$sql);
	while($row=mysqli_fetch_object($res))
	{
		$i_id[$row->finish_goods_code] = $row->item_id;
		$i_dp[$row->finish_goods_code] = $row->d_price;
		$i_ps[$row->finish_goods_code] = $row->pack_size;
	}




$sql="SELECT d.dealer_code,a.AREA_CODE,z.ZONE_CODE,z.REGION_ID
FROM  dealer_info d, area a,zon z
where
d.area_code=a.AREA_CODE
and a.ZONE_ID=z.ZONE_CODE
and d.dealer_type='Distributor'
order by d.dealer_code";
$res = mysqli_query($conn,$sql);
	while($row=mysqli_fetch_object($res))
	{
		$ac[$row->dealer_code] = $row->AREA_CODE;
		$zc[$row->dealer_code] = $row->ZONE_CODE;
		$rc[$row->dealer_code] = $row->REGION_ID;
	}

$s =0;
$filename=$_FILES["upload_file"]["tmp_name"];
	if($_FILES["upload_file"]["tmp_name"]!=""){	
	//echo '<span style="color: red;">Excel File Successfully Imported</span>';
	$file = fopen($filename, "r");

while (($excelData = fgetcsv($file, 50000, ",")) !== FALSE){

for($x=0;$x<100;$x++)
{

if($excelData[$x]!='')
$data[$s][$x] = $excelData[$x];
}

$s++;
} // end while loop
} // end upload file
fclose($file);
echo "Upload Complete";
} 

echo $data[0][0];

for($b=1;$b<=$s;$b++){


for($g=4;$g<=$x;$g++)
{
if($data[$b][$g]>0){

$data[$b][3] = str_replace("'","",$data[$b][3]);
$data[$b][3] = str_replace('"','',$data[$b][3]);
$data[$b][3] = trim($data[$b][3]);
			
$sql = "INSERT INTO sale_target_upload  (grp, fg_code,  area_name, dealer_code, target_period, target_month, target_year, target_ctn, entry_by, entry_at,
item_id,d_price,target_amount,region_id,zone_id,area_id) 	
VALUES									('".$grp."', '".$data[0][$g]."', '".$data[$b][3]."', '".$data[$b][1]."', '".$target_period."','".$target_month."', '".$target_year."', '".$data[$b][$g]."','".$_SESSION['username']."','".$now."',
'".$i_id[$data[0][$g]]."','".($i_dp[$data[0][$g]])."','".($i_ps[$data[0][$g]]*$i_dp[$data[0][$g]]*$data[$b][$g])."','".$rc[$data[$b][1]]."','".$zc[$data[$b][1]]."','".$ac[$data[$b][1]]."'
  		)";	

mysqli_query($conn,$sql);
}
} 


}
?>



<?php
include 'inc/header.php';
include 'inc/sidebar.php';
?>  



  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Target Upload</h1>
          </div>
<!--           <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
          </div> -->

        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->



    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">




<div class="oe_view_manager oe_view_manager_current">
<form action=""  method="post" enctype="multipart/form-data">
        <div class="oe_view_manager_body">
<div  class="oe_view_manager_view_list"></div>
<div class="oe_view_manager_view_form"><div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">
        <div class="oe_form_buttons"></div>
        <div class="oe_form_sidebar"></div>
        <div class="oe_form_pager"></div>
        <div class="oe_form_container"><div class="oe_form">
          <div class="">
<div class="oe_form_sheetbg">
        <div class="oe_form_sheet oe_form_sheet_width">
          <div  class="oe_view_manager_view_list"><div  class="oe_list oe_view">
            <table width="80%" border="1" align="center">
              <tr>

                <td height="40" colspan="6" bgcolor="#00FF00"><div align="center" class="style2">Upload Target</div></td>
                </tr>

              <tr>
                <td>Year </td>
                <td width="18%"><select name="target_year" style="width:160px;" id="target_year" required="required">
                  <option <?=($target_year=='2021')?'selected':''?>>2021</option>
				  <option <?=($target_year=='2022')?'selected':''?>>2022</option>
                </select></td>
               
			   
			    <td width="12%">Group For </td>
                <td width="59%" colspan="3"><select name="grp" id="grp" required="required">
                  <option></option>
				  <option value="A">A</option>
				  <option value="B">B</option>
				  <option value="C">C</option>
                </select></td>
              </tr>
              <tr>
                <td>Month</td>
                <td><span class="oe_form_group_cell">
                  <select name="target_month" style="width:160px;" id="target_month" required="required">
                    <option value="1" <?=($target_month=='1')?'selected':''?>>Jan</option>
                    <option value="2" <?=($target_month=='2')?'selected':''?>>Feb</option>
                    <option value="3" <?=($target_month=='3')?'selected':''?>>Mar</option>
                    <option value="4" <?=($target_month=='4')?'selected':''?>>Apr</option>
                    <option value="5" <?=($target_month=='5')?'selected':''?>>May</option>
                    <option value="6" <?=($target_month=='6')?'selected':''?>>Jun</option>
                    <option value="7" <?=($target_month=='7')?'selected':''?>>Jul</option>
                    <option value="8" <?=($target_month=='8')?'selected':''?>>Aug</option>
                    <option value="9" <?=($target_month=='9')?'selected':''?>>Sep</option>
                    <option value="10" <?=($target_month=='10')?'selected':''?>>Oct</option>
                    <option value="11" <?=($target_month=='11')?'selected':''?>>Nov</option>
                    <option value="12" <?=($target_month=='12')?'selected':''?>>Dec</option>
                  </select>
                </span></td>
                <td>&nbsp;</td>
                <td colspan="3">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td colspan="3">&nbsp;</td>
              </tr>

              <tr>
                <td width="11%">&nbsp;</td>
                <td></td>
                <td>Upload File</td>
                <td colspan="3"><input name="upload_file"  type="file" id="upload_file" required="required"/></td>
                </tr>



              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td colspan="3">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><p>
                  <input name="upload" type="submit" id="upload" value="Upload File" />
                </p>
                  <p>&nbsp; </p></td>
                <td colspan="3">&nbsp;</td>
              </tr>
              <tr>

                <td colspan="6">
                  <div align="center"></div></td>
                </tr>
<tr>
<td colspan="6"><label>
<div align="center">
<p>CSV File Example: </p>
<table width="691" align="left" cellpadding="0" cellspacing="0">
  <col width="64" span="11" />
  <tr height="20">
    <td height="20" width="40"><div align="left"><strong>SL</strong></div></td>
    <td width="55"><div align="left"><strong>Party Code </strong></div></td>
    <td width="51"><div align="left"><strong>Party Name </strong></div></td>
    <td width="125"><div align="left"><strong>Area Name </strong></div></td>
    <td width="73"><div align="center"><strong>102 </strong></div></td>
    <td width="90"><div align="center"><strong>103 </strong></div></td>
    <td width="116"><div align="center"><strong>104 </strong></div></td>
  </tr>
  <tr height="20">
    <td height="20" align="right"><div align="left">1</div></td>
    <td align="right"><div align="left">11245</div></td>
    <td><div align="left">S.M Enterprise </div></td>
    <td align="right"><div align="left">Babu Bazar </div></td>
    <td align="right"><div align="center">11</div></td>
    <td align="right"><div align="center">20</div></td>
   <td align="right"><div align="center">5</div></td>
  </tr>
  <tr height="20">
    <td height="20" align="right"><div align="left">2</div></td>
    <td align="right"><div align="left">12500</div></td>
    <td><div align="left">Mumu Enter </div></td>
    <td align="right"><div align="left">Karim Bradarz </div></td>
    <td align="right"><div align="center">10</div></td>
    <td align="right"><div align="center">15</div></td>
    <td align="right"><div align="center">9</div></td>
  </tr>
</table>
</div>

                    </label></td>
              </tr>
            </table>

            <br />
          </div>
          </div>

          </div>
    </div>
    <div class="oe_chatter"><div class="oe_followers oe_form_invisible">
      <div class="oe_follower_list"></div>
    </div></div></div></div></div>
    </div></div>
</div>
 </form>   </div>











      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 


<?php
include 'inc/footer.php';
?>  