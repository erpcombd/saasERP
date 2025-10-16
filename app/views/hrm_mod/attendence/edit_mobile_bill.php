<?php

//ini_set('display_errors','1');
//ini_set('display_startup_errors','1');
//error_reporting(E_ALL);
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title="Edit Mobile Bill";

do_calander('#m_date');

$head='<link href="../css/report_selection.css" type="text/css" rel="stylesheet"/>';

auto_complete_from_db('personnel_basic_info','concat(PBI_NAME,"-",PBI_ID)','PBI_ID','','PBI_ID');

$table='hrm_inout';

$unique='id';

$u_sql="select * from hrm_moblie_bill where year='".$_POST['year']."' and month='".$_POST['mon']."'";
	$u_query=db_query($u_sql);
	while($u_data=mysqli_fetch_object($u_query)){
	if(isset($_POST['update_'.$u_data->id])){
	 $upq="UPDATE `hrm_moblie_bill` SET `mobile_bill`='".$_POST['mobile_bill_'.$u_data->id]."' WHERE id=".$u_data->id;
	db_query($upq);
	}
	}
	
	 
if(isset($_POST['show']))
{
	$mon=$_POST['mon'];
	$dept=$_POST['dept'];
	$year=$_POST['year'];
	$bonus=$_POST['bonus'];
}else{
$mon=date('n');
$year=date('Y');
}
?>





<style type="text/css">

<!--

.style1 {font-size: 24px}

-->

</style>












    <form action=""  method="post" enctype="multipart/form-data">
        <div class="d-flex justify-content-center">

            <div class="n-form1 fo-white pt-0">
                <h4 class="text-center bg-titel bold pt-2 pb-2">      Edit Mobile Bill   </h4>

                <div class="container-fluid">
                    <div class="row">

                        <div class="Col-sm-6 col-md-6 col-lg-6 col-xl-6">
                            <div class="form-group row  m-0 mb-1 pl-3 pr-3">
                                <label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Year</label>
                                <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">
                                    <select name="year" id="year" required="required" class="form-control">
                                        <? foreign_relation('hrm_moblie_bill','year','year',$year,'1 group by year order by year asc')?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="Col-sm-6 col-md-6 col-lg-6 col-xl-6">
                            <div class="form-group row  m-0 mb-1 pl-3 pr-3">
                                <label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Month</label>
                                <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">
                                <span class="oe_form_group_cell">
                                          <select name="mon" id="mon" required="required">
                                              <option value="1" <?=($mon=='1')?'selected':''?>>Jan</option>
                                              <option value="2" <?=($mon=='2')?'selected':''?>>Feb</option>
                                              <option value="3" <?=($mon=='3')?'selected':''?>>Mar</option>
                                              <option value="4" <?=($mon=='4')?'selected':''?>>Apr</option>
                                              <option value="5" <?=($mon=='5')?'selected':''?>>May</option>
                                              <option value="6" <?=($mon=='6')?'selected':''?>>Jun</option>
                                              <option value="7" <?=($mon=='7')?'selected':''?>>Jul</option>
                                              <option value="8" <?=($mon=='8')?'selected':''?>>Aug</option>
                                              <option value="9" <?=($mon=='9')?'selected':''?>>Sep</option>
                                              <option value="10" <?=($mon=='10')?'selected':''?>>Oct</option>
                                              <option value="11" <?=($mon=='11')?'selected':''?>>Nov</option>
                                              <option value="12" <?=($mon=='12')?'selected':''?>>Dec</option>
                                          </select>
                                </span>
                                </div>
                            </div>
                        </div>


                    </div>

                </div>

                <div class="n-form-btn-class">
                    <input name="show" type="submit" id="show" value="SHOW" class="btn1 btn1-bg-submit" />
                </div>

            </div>

        </div>

        <div class="container-fluid pt-5">

            <table class="table1  table-striped table-bordered table-hover table-sm">
                <thead class="thead1">
                    <tr class="bgc-info bold">
                        <td> SL</td>
                        <td> Employee ID</td>
                        <td> Month</td>
                        <td> Year</td>
                        <td> Mobile No</td>
                        <td> Excess Mobile Bill</td>
                        <td> Action</td>
                    </tr>
                </thead>


                <tbody class="tbody1">

                        <?php
                        $sl=1;
                        $s_sql="select * from hrm_moblie_bill where year='".$_POST['year']."' and month='".$_POST['mon']."'";
                        $s_query=db_query($s_sql);
                        while($s_data=mysqli_fetch_object($s_query)){
                            ?>
                            <tr>
                                <td><?=$sl++;?></td>
                                <td>
                                    <?=$s_data->emp_id?>    </td>
                                <td>
                                    <?=$s_data->month?>    </td>
                                <td>
                                    <?=$s_data->year?>    </td>
                                <td>
                                    <?=$s_data->mobile_no?>    </td>
                                <td><input name="mobile_bill_<?=$s_data->id?>" type="text"  value="<?=$s_data->mobile_bill?>"/></td>
                                <td><input class="btn1 btn1-bg-update" name="update_<?=$s_data->id?>" type="submit" value="UPDATE"/></td>
                            </tr>
                        <? }?>

                </tbody>

            </table>


        </div>

    </form>










<br>
<br>
<br>
<br>
<br>



<?php /*?><div class="oe_view_manager oe_view_manager_current">

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

                <td height="40" colspan="5" bgcolor="#00FF00"><div align="center" class="style1">Edit Mobile Bill  </div></td>
                </tr>

              <tr>

                <td width="20%"><div align="right">Year : </div></td>

                <td>
                    <select name="year" style="width:160px;" id="year" required="required" class="form-control">
                    <? foreign_relation('hrm_moblie_bill','year','year',$year,'1 group by year order by year asc')?>
                </select>

                </td>
                <td>Month</td>
                <td>
                    <span class="oe_form_group_cell">
                  <select name="mon" style="width:160px;" id="mon" required="required" class="form-control">
                    <option value="1" <?=($mon=='1')?'selected':''?>>Jan</option>
                    <option value="2" <?=($mon=='2')?'selected':''?>>Feb</option>
                    <option value="3" <?=($mon=='3')?'selected':''?>>Mar</option>
                    <option value="4" <?=($mon=='4')?'selected':''?>>Apr</option>
                    <option value="5" <?=($mon=='5')?'selected':''?>>May</option>
                    <option value="6" <?=($mon=='6')?'selected':''?>>Jun</option>
                    <option value="7" <?=($mon=='7')?'selected':''?>>Jul</option>
                    <option value="8" <?=($mon=='8')?'selected':''?>>Aug</option>
                    <option value="9" <?=($mon=='9')?'selected':''?>>Sep</option>
                    <option value="10" <?=($mon=='10')?'selected':''?>>Oct</option>
                    <option value="11" <?=($mon=='11')?'selected':''?>>Nov</option>
                    <option value="12" <?=($mon=='12')?'selected':''?>>Dec</option>
                  </select>
                </span>
                </td>
                <td><input name="show" type="submit" id="show" value="SHOW" class="btn1 btn1-bg-submit" /></td>
              </tr>
            </table>

            <br />
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left"><div align="left"><strong>SL</strong></div></td>
    <td align="left"><div align="left"><strong>Employee ID </strong></div></td>
    <td align="left"><div align="left"><strong>Month</strong></div></td>
    <td align="left"><div align="left"><strong>Year</strong></div></td>
    <td align="left"><div align="left"><strong>Mobile No </strong></div></td>
    <td align="left"><div align="left"><strong>Excess Mobile Bill </strong></div></td>
    <td align="left"><div align="left"><strong>Action</strong></div></td>
  </tr>
  <?php
  $sl=1;
  $s_sql="select * from hrm_moblie_bill where year='".$_POST['year']."' and month='".$_POST['mon']."'";
	$s_query=db_query($s_sql);
	while($s_data=mysqli_fetch_object($s_query)){
  ?>
  <tr>
    <td><?=$sl++;?></td>
    <td>
      <?=$s_data->emp_id?>    </td>
    <td>
      <?=$s_data->month?>    </td>
    <td>
      <?=$s_data->year?>    </td>
    <td>
      <?=$s_data->mobile_no?>    </td>
    <td><input name="mobile_bill_<?=$s_data->id?>" type="text" style="width:50px" value="<?=$s_data->mobile_bill?>"/></td>
    <td><input class="btn1 btn1-bg-update" name="update_<?=$s_data->id?>" type="submit" value="UPDATE"/></td>
  </tr>
  <? }?>
</table>

          </div>
          </div>

          </div>

    </div>

    <div class="oe_chatter"><div class="oe_followers oe_form_invisible">

      <div class="oe_follower_list"></div>

    </div></div></div></div></div>

    </div></div>

            

        </div>

 </form>   </div><?php */?>



    




<?



require_once SERVER_CORE."routing/layout.bottom.php";

?>