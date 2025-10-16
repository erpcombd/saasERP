<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Purchase Order Receive Status ';



do_calander('#fdate');

do_calander('#tdate');



$table = 'purchase_master';

$unique = 'po_no';

$status = 'CHECKED';

$target_url = '../po_receiving/chalan_view_store_jamuna.php';

$tr_type="Show";

if($_REQUEST[$unique]>0)

{

$_SESSION[$unique] = $_REQUEST[$unique];

header('location:'.$target_url);

}


$tr_from="Warehouse";
?>

<script language="javascript">

function custom(theUrl)

{

	//window.open('<?=$target_url?>?v_no='+theUrl);
	window.open('<?=$target_url?>?v_no='+encodeURIComponent(theUrl));
	

}

</script>







<div class="form-container_large">
   
    <form action="" method="post" name="codz" id="codz">
            
        <div class="container-fluid bg-form-titel">
            <div class="row">
				<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                    <div class="form-group row m-0">
                        <label class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Vendor Name:</label>
                        <div class="col-sm-7 col-md-7 col-lg-7 col-xl-7 p-0">
                            <select name="vendor_id" id="vendor_id">

		 						 <option></option>

        						  <? foreign_relation('vendor','vendor_id','vendor_name',$_POST['vendor_id'],' 1 order by vendor_name');?>

          					</select>

                        </div>
                    </div>
                </div>
				
 <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 row">
             <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 p-0">
               <div class="form-group row m-0">
            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">From  Date:</label>
                 <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                   <input type="text" name="fdate" id="fdate" value="<?=($_POST['fdate']!='')?$_POST['fdate']:date('Y-m-01');?>" />
                                </div>
                            </div>


                        </div>


                        <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 p-0">
                            <div class="form-group row m-0">
                     <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"> To Date:</label>
                                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                                    <input type="text" name="tdate" id="tdate"  value="<?=($_POST['tdate']!='')?$_POST['tdate']:date('Y-m-d');?>" /> 

                                </div>
                            </div>

                        </div>




                </div>
				

                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2 d-flex justify-content-center align-items-center">
                    
                    <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" class="btn1 btn1-submit-input"/ >
                </div>

            </div>
        </div>






        <div class="container-fluid pt-5 p-0 ">


                <table class="table1  table-striped table-bordered table-hover table-sm">
                    <thead class="thead1">
                    <tr class="bgc-info">
                        <th>SL</th>
                        <th>PO No</th>
						<th>PR No</th>
						<th>Transaction Details</th>
                        <th>Vendor Name</th>

                        <th>Received By</th>
                        <th>Received At</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>

                    <tbody class="tbody1">

                    <?

                    if(isset($_POST['submitit'])){





                        if($_POST['fdate']!=''&&$_POST['tdate']!='')

                            $con .= 'and pr.rec_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';

                        if($_POST['vendor_id']>0)

                            $con .= 'and pr.vendor_id="'.$_POST['vendor_id'].'"';
                        $si=0;

                        $sql = 'select pr.pr_no,pr.po_no,pr.warehouse_id,pr.entry_at,pr.status,v.vendor_name,u.fname from purchase_receive pr left join vendor v on v.vendor_id=pr.vendor_id left join user_activity_management u on u.user_id=pr.entry_by where 1 and pr.warehouse_id="'.$_SESSION['user']['depot'].'" '.$con.' group by pr.pr_no  DESC';

                        $sqlq = db_query($sql);

                        while($info=mysqli_fetch_object($sqlq)){

                            ?>

                            <tr>

                                <td><?=++$si;?></td>

                                <td><?=$info->po_no?></td>

								 <td><a title="GRN Preview" target="_blank" href="chalan_view_store.php?v_no=<?=rawurlencode(url_encode($info->pr_no));?>" style=" font-weight:700; color:#000000" >
								   <?=$info->pr_no;?>
								 </a></td>
								 
								  <td><a title="GRN Preview" target="_blank" href="transaction_view.php?v_no=<?=rawurlencode(url_encode($info->pr_no));?>" style=" font-weight:700; color:#000000" >
								    <?=$info->pr_no;?>
								  </a></td>

                                <td><?=$info->vendor_name?></td>

                                <td><?=$info->fname?></td>

                                <td><?=$info->entry_at?></td>
                                <td><?=$info->status?></td>
                                <td >
								<button type="submit" name="submitit" id="submitit" value="View" onclick="custom('<?=url_encode($info->pr_no);?>')" class="btn2 btn1-bg-submit">
									<i class="fa-solid fa-eye"></i>								</button>								</td>
                            </tr>


                        <? }}?>
                    </tbody>
                </table>





        </div>
    </form>
</div>








<?php /*?><div class="form-container_large">

  <form action="" method="post" name="codz" id="codz">

    <table width="80%" border="0" align="center">

      <tr>

        <td>&nbsp;</td>

        <td colspan="3">&nbsp;</td>

        <td>&nbsp;</td>

      </tr>

      <tr>

        <td align="right" bgcolor="#FF9966"><strong>Vendor Name : </strong></td>

        <td colspan="3" bgcolor="#FF9966"><label>

          <select name="vendor_id" id="vendor_id">

		  <option></option>

          <? foreign_relation('vendor','vendor_id','vendor_name',$_POST['vendor_id'],' 1 order by vendor_name');?>

          </select>

        </label></td>

        <td rowspan="2" bgcolor="#FF9966"><strong>

          <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" class="btn1 btn1-submit-input" />

        </strong></td>

      </tr>

      <tr>

        <td align="right" bgcolor="#FF9966"><strong>Date Interval :</strong></td>

        <td width="1" bgcolor="#FF9966"><strong>

          <input type="text" name="fdate" id="fdate" style="width:107px;" value="<?=($_POST['fdate']!='')?$_POST['fdate']:date('Y-m-01');?>" />

        </strong></td>

        <td align="center" bgcolor="#FF9966"><strong> -to- </strong></td>

        <td width="1" bgcolor="#FF9966"><strong>

          <input type="text" name="tdate" id="tdate" style="width:107px;" value="<?=($_POST['tdate']!='')?$_POST['tdate']:date('Y-m-d');?>" />

        </strong></td>

      </tr>

    </table>

  </form>

  <table width="100%" border="0" cellspacing="0" cellpadding="0">

<tr>

<td>

<div class="tabledesign2">



<table width="100%" cellspacing="0" cellpadding="0" id="grp">

<tbody>



	<tr>

		<th width="11%">GRN No.</th>
		<th width="11%">SL</th>

		<th width="15%">PO No</th>

		<th width="22%">Vendor Name</th>

		<th width="17%">Received By</th>

		<th width="9%">Received At</th>
		<th width="9%">Status</th>
	</tr>

<? 

if(isset($_POST['submitit'])){





if($_POST['fdate']!=''&&$_POST['tdate']!='')

$con .= 'and pr.rec_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';

if($_POST['vendor_id']>0)

$con .= 'and pr.vendor_id="'.$_POST['vendor_id'].'"';
$si=0;

 $sql = 'select pr.pr_no,pr.po_no,pr.entry_at,pr.status,v.vendor_name,u.fname from purchase_receive pr left join vendor v on v.vendor_id=pr.vendor_id left join user_activity_management u on u.user_id=pr.entry_by where 1 '.$con.'';

$sqlq = db_query($sql);

while($info=mysqli_fetch_object($sqlq)){

?>

	<tr onclick="custom(<?=$info->pr_no?>)">

	  <td><?=++$si;?></td>

	  <td><?=$info->po_no?></td>

	  <td><?=$info->vendor_name?></td>

	  <td><?=$info->fname?></td>

	  <td><?=$info->entry_at?></td>
	   <td><?=$info->status?></td>
	</tr>


<? }}?>
</tbody>

</table>

</div>

</td>

</tr>

</table>

</div><?php */?>



<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>