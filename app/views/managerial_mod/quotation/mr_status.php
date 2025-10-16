<?php




 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$title='Purchase Quotation Status';

$module_name = find_a_field('user_module_manage','module_file','id='.$_SESSION["mod"]);

do_calander('#fdate');

do_calander('#tdate');



$table = 'quotation_master';

$unique = 'quotation_no';

$status = 'UNCHECKED';

$target_url = '../quotation/quotation_print_view.php';



?>

<script language="javascript">

function custom(theUrl)

{

	window.open('<?=$target_url?>?<?=$unique?>='+theUrl);

}

</script>







<div class="form-container_large">

    

    <form action="" method="post" name="codz" id="codz">

            

        <div class="container-fluid bg-form-titel">

            <div class="row">

                <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">

                    <div class="form-group row m-0">

                        <label class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Date From:</label>

                        <div class="col-sm-7 col-md-7 col-lg-7 col-xl-7 p-0">

                            <input type="text" name="fdate" id="fdate"  value="<?=$_POST['fdate']?>" autocomplete="off" />

                        </div>

                    </div>



                </div>

				<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">

                    <div class="form-group row m-0">

                        <label class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Date To:</label>

                        <div class="col-sm-7 col-md-7 col-lg-7 col-xl-7 p-0">

                            <input type="text" name="tdate" id="tdate"  value="<?=$_POST['tdate']?>" autocomplete="off" />

                        </div>

                    </div>



                </div>

                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">

                    <div class="form-group row m-0">

                        <label class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Purchase QS:</label>

                        <div class="col-sm-7 col-md-7 col-lg-7 col-xl-7 p-0">

                            <select name="status" id="status" >

								<option><?=$_POST['status']?></option>

								<option>UNCHECKED</option>

								<option>CHECKED</option>

								<option>ALL</option>

							</select>



                        </div>

                    </div>

                </div>



                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">

                    <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" class="btn1 btn1-submit-input" />

					

                    

                </div>



            </div>

        </div>













            

        <div class="container-fluid pt-5 p-0 ">



                <table class="table1  table-striped table-bordered table-hover table-sm">

                    <thead class="thead1">

                    <tr class="bgc-info">

                        <th>Quotation No</th>

                        <th>Quotation Date</th>

                        <th>Vendor Name</th>



                        <th>Entry By </th>

                        <th>Entry At</th>

                        <th>Status</th>

						<th>Action</th>

                        <th>Attachment</th>

                        

                    </tr>

                    </thead>



                    <tbody class="tbody1">

					

					<? 

							if($_POST['status']!=''&&$_POST['status']!='ALL')

							$con .= 'and a.status="'.$_POST['status'].'"';

							

							if($_POST['fdate']!=''&&$_POST['tdate']!='')

							$con .= 'and a.quotation_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';

							

							

							   $res='select  	a.quotation_no,a.quotation_no as quotation_no, DATE_FORMAT(a.quotation_date, "%d-%m-%Y") as quotation_date,  v.vendor_name as vendor_name,    a.status,  c.fname as entry_by,  a.entry_at, a.quotation from quotation_master a, user_activity_management c, vendor v where a.vendor_id=v.vendor_id and

							 a.entry_by=c.user_id and a.entry_by="'.$_SESSION['user']['id'].'" '.$con.' and a.status in ("UNCHECKED","CHECKED", "COMPLETED") group by a.quotation_no order by a.quotation_no desc';

						



								

								$query=db_query($res);

								

								While($row=mysqli_fetch_object($query)){

								

								

								?>

                        <tr>

                            <td><?=$row->quotation_no?></td>

                            <td><?=$row->quotation_date?></td>

                            <td style="text-align:left"><?=$row->vendor_name?></td>



                            <td><?=$row->entry_by?></td>

                            <td><?=$row->entry_at?></td>

                            <td><?=$row->status?></td>

							<td><button type="button" onclick="custom(<?=$row->quotation_no?>)" class="btn2 btn1-bg-submit"><i class="fa-solid fa-eye"></i></button></td>



                            <!--<td><a href="../../../../media/quotation/<?=$row->quotation?>" target="_blank">View Attachment</a></td>-->

							 <td><a href="../../../assets/support/upload_view.php?name=<?=$row->quotation?>&folder=quotation&proj_id=<?=$_SESSION['proj_id']?>&mod=<?=$module_name?>" target="_blank">View Attachment</a></td>

                            



                        </tr>

							<? 

							}

							?>

                    </tbody>

                </table>











        </div>

    </form>

</div>















<br /><br />



<!--<div class="form-container_large">

<form action="" method="post" name="codz" id="codz">

<table width="80%" border="0" align="center">

  <tr>

    <td>&nbsp;</td>

    <td colspan="3">&nbsp;</td>

    <td>&nbsp;</td>

  </tr>

  <tr>

    <td align="right" bgcolor="#FF9966"><strong>Date:</strong></td>

    <td width="1" bgcolor="#FF9966"><strong>

      <input type="text" name="fdate" id="fdate" style="width:120px;" value="<?=$_POST['fdate']?>" />

    </strong></td>

    <td align="center" bgcolor="#FF9966"><strong> -to- </strong></td>

    <td width="1" bgcolor="#FF9966"><strong>

      <input type="text" name="tdate" id="tdate" style="width:120px;" value="<?=$_POST['tdate']?>" />

    </strong></td>

    <td rowspan="2" bgcolor="#FF9966"><strong>

      <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" class="btn1 btn1-submit-input" />

    </strong></td>

  </tr>

  <tr>

    <td align="right" bgcolor="#FF9966"><strong><?=$title?>: </strong></td>

    <td colspan="3" bgcolor="#FF9966"><strong>

<select name="status" id="status" style="width:200px;">

<option><?=$_POST['status']?></option>

<option>UNCHECKED</option>

<option>CHECKED</option>

<option>ALL</option>

</select>

    </strong></td>

    </tr>

</table>



</form>

</div>-->



<?php /*?><table width="100%" border="0" cellspacing="0" cellpadding="0">

<tr>

<td><div class="tabledesign2">

<? 

if($_POST['status']!=''&&$_POST['status']!='ALL')

$con .= 'and a.status="'.$_POST['status'].'"';



if($_POST['fdate']!=''&&$_POST['tdate']!='')

$con .= 'and a.quotation_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';





 $res='select  	a.quotation_no,a.quotation_no as quotation_no, DATE_FORMAT(a.quotation_date, "%d-%m-%Y") as quotation_date,  v.vendor_name as vendor_name,    a.status,  c.fname as entry_by,  a.entry_at from quotation_master a, user_activity_management c, vendor v where a.vendor_id=v.vendor_id and

 a.entry_by=c.user_id '.$con.' and a.status in ("UNCHECKED","CHECKED", "COMPLETED") group by a.quotation_no order by a.quotation_no desc';

echo link_report($res,'mr_print_view.php');







?>

</div></td>

</tr>

</table><?php */?>



<?



require_once SERVER_CORE."routing/layout.bottom.php";

?>