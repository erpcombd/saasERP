<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Cost Category';
$proj_id=$_SESSION['proj_id'];
$now=time();

do_datatable ('grp');

$cat_id=$_REQUEST['cat_id'];
if(isset($_REQUEST['category_name']) && !empty($_REQUEST['category_name']))
{
	//common part.............
	$category_name = $_REQUEST['category_name'];
		$check="select id from cost_category where category_name='$category_name'";
		if(mysqli_num_rows(db_query($check))>0)
		{
			$aaa=mysqli_num_rows(db_query($check));
				$type=0;
				$msg='Given Name('.$category_name.') is already exists.';
		}
		else
		{
	if(isset($_POST['ncategory']))
	{
		$check="select id from cost_category where category_name='$category_name'";
		if(mysqli_num_rows(db_query($check))>0)
		{
			$aaa=mysqli_num_rows(db_query($check));
			$cat_id=$aaa[0];
		}
		else
		{
			$sql="INSERT INTO `cost_category` (
			`category_name`, `proj_id`)
			VALUES ('$category_name', '$proj_id')";
			$query=db_query($sql);
		$type=1;
		$msg='New Entry Successfully Inserted.';
		}
	}
	
	//for Modify..................................
	
	if (isset($_POST['mcategory']) && isset($_GET['cat_id'])) {
        $sql = "UPDATE `cost_category` 
                SET `category_name` = '$category_name' 
                WHERE `id` = '$cat_id' 
                LIMIT 1";
        $qry = db_query($sql);
        $type = 1;
        $msg = 'Successfully Updated.';
    }
	}
		if(isset($_POST['dcategory']))
	{
		$sql="delete from cost_category
		 WHERE `id` = '$cat_id' LIMIT 1";
		$qry=db_query($sql);
		$type=1;
		$msg='Successfully Deleted.';
	}
}
$report=db_query("select id, category_name from cost_category");
if(isset($_REQUEST['cat_id']))
{
	$c_id=$_REQUEST['cat_id'];
	$ddd="select * from cost_category where id='$c_id'";
	$data=mysqli_fetch_row(db_query($ddd));
}?>
<script type="text/javascript">
function DoNav(theUrl)
{
	document.location.href = 'cost_category.php?cat_id='+theUrl;
}
</script>


<table  border="0">
    <th></th>
  <tr>    <td style="padding-right:5%; width:66%">
	<div class="left">
							<table style="width:100%" border="0">
							    <th></th>

								  <tr>
									<td>
									<table id="grp" class="table table-bordered">
									<thead>
							  			<tr>
										<th>ID</th>
										<th>Category Name</th>
										</tr>
										</thead>
										<tbody>
<?php
	
	$rrr = "select id,category_name from cost_category"; 

	$report=db_query($rrr);

	while($rp=mysqli_fetch_row($report)){
	$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>
							   <tr<?=$cls?> onclick="DoNav('<?php echo $rp[0];?>');">
								<td><?=$rp[0];?></td>
								<td><?=$rp[1];?></td>
								</tr>
	<?php 
	}
	?>
	</tbody>
							</table>
																		</td>
								  </tr>
								</table>

							</div></td>
    <td><div class="center"><form id="form2" name="form2" method="post" action="cost_category.php?cat_id=<?php echo $cat_id;?>" >
							  <table border="0">
                                <th></th>
                                <tr>
                                  <td class="w-100"><div class="box w-100">
                                    <table  border="0" class="w-100">
                                      <th>
                                      <tr>
                                        <td>Category  Name:</td>
                                        <td>
                                        <input name="category_name" type="text" id="category_name" value="<?php echo $data[1];?>" class="form-control"/></td>
									  </tr>
									  </th>
                                    </table>
                                  </div></td>
                                </tr>
                                
                                
                                <tr>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>
								  <div class="box1">
								  <table border="0">
								    <th>
                                    <tr>
                                      <td><input name="ncategory" type="submit" id="ncategory" value="Record" onclick="return checkUserName()" class="btn btn-primary" /></td>
                                      <td><input name="mcategory" type="submit" id="mcategory" value="Modify" class="btn btn-success" /></td>
                                      <td><input name="Button" type="button" class="btn btn-info" value="Clear" onClick="parent.location='cost_category.php'"/></td>
                                      <td><input class="btn btn-danger" name="dcategory" type="submit" id="dcategory" value="Delete"/></td>
                                    </tr>
                                    </th>
                                  </table>
								  </div>								  </td>
                                </tr>
                              </table>
    </form>
							</div></td>
  </tr>
</table>12
<script type="text/javascript">
	document.onkeypress=function(e){
	var e=window.event || e
	var keyunicode=e.charCode || e.keyCode
	if (keyunicode==13)
	{
		return false;
	}
}
</script>
<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>