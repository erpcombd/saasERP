<?php



session_start();

//====================== EOF ===================




require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.core/init.php);
require_once SERVER_CORE."routing/layout.top.php";

require_once ('../../../acc_mod/common/class.numbertoword.php');

$cid 		= $_REQUEST['id'];



if(isset($_POST['approve'])){

 

 $update = 'update crm_comunication set status="CHECKED" where id="'.$cid.'"';

 db_query($update);



}





if(isset($_POST['return'])){

 

 $update2 = 'update crm_comunication set status="MANUAL",return_note="'.$_POST['return_note'].'" where id="'.$cid.'"';

 db_query($update2);

echo '<script>window.close()</script>';

}



$sql1='select c.*,c.id,c.contact_person,cc.organization, c.overcome as service,c.c_time as contact_time, c.c_date as contact_date,c_reason from crm_comunication c,crm_customer_info cc where 1 and cc.dealer_code=c.customer_name and c.id="'.$cid.'" order by c.id desc';

$qry=db_query($sql1);

$data = mysqli_fetch_object($qry);



?>







<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">







<html xmlns="http://www.w3.org/1999/xhtml">







<head>







<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />





<link rel="shortcut icon" href="../../../logo/title.ico" type="image/x-icon">

<title>Conveyance Report</title>







<!--<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">-->

<style>

html,body{

    

}



td,th,tr{ font-size:14px;}

*{font-family: calibri;}

.c_st{

background-color:#e91c2c;

color:white;	

	}

#body{

    padding-bottom: 100px;    /* height of footer */

}

#holder{

    min-height: 100%;

    position:relative;

}

#body{

  min-height: 100%;

    position:relative;

    /* Firefox */

    min-height: -moz-calc(100% - 30px);

    /* WebKit */

    min-height: -webkit-calc(100% - 30px);

    /* Opera */

    min-height: -o-calc(100% - 30px);

    /* Standard */

    min-height: calc(100% - 30px);

}



#footer{

 height:30px;

    clear: both;

    width:100%;

    

}



@media print{

    #footer{

        bottom:0;

    }

}

</style>





<script type="text/javascript">

function hide()

{

    document.getElementById("pr").style.display="none";

}

</script>







<style type="text/css">







<!--



td{

 padding: 2px 5px;

}



-->









</style></head>







<body>

<div id="holder">

<div id="body">



<form action="" method="post">



<table width="800" border="0" cellspacing="0" cellpadding="0" align="center" style="border-collapse:collapse;">



<thead>

<tr>

 <td>

  <table width="800" border="0" cellspacing="0" cellpadding="0" align="center" style="border-collapse:collapse;">



<tr>

 <th>&nbsp;</th>

</tr>

<tr>

 <th>&nbsp;</th>

</tr>

<tr>

 <th>&nbsp;</th>

</tr>

<tr>

<th width="80%" align="center" valign="middle"><div align="center"><strong style="font-size:25px; margin-left:25%;">Conveyance</strong></div></th>

<th width="20%"><!--<img src="../../../images/demo7.png" style="width:50%;height:auto; margin-left:5px; float:right">--></th>

</tr>

  

  </table></td></tr>

  </thead>

  <!--<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">-->

  <tbody>

  <tr>

    <td colspan="3" style="float:left;"></td>

  </tr>

  <tr>



	<td width="100%" colspan="3" style="float:left; clear:right">

	<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">

		  <tr>

		    <td valign="top">

		      <table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:14px;font-family:Bank Gothic;">

		        <tr>

		          <td width="20%" align="left" valign="middle">Sales Order  No </td>

				  <td>:</td>

		          <td width="80%"><?php echo $do_no;?></td>

		        </tr>

				  

		        

		           

		        <!--<tr>

		          <td align="left" valign="middle"><span class="style6">Offer Date:</span></td>

		          <td><span class="style6">

		            <?=date('Y-m-d',strtotime($entry_time));?>

		          </span></td>

		        </tr>-->

	          </table>		      </td>

			<td width="30%"><table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:14px; font-family:Bank Gothic;">

			  <tr>

                <td width="48%" align="right" valign="middle"> <div align="left">Delivery Date</div></td>

				<td>:</td>

			    <td width="52%"><?=date('d-M-Y',strtotime($chalan_date))?></td>

			  </tr>

			  

			  

			  

			  </table></td>

		  </tr>

		</table>

	</td>

	

	

  </tr>

 <!-- </tbody>

  </table>

 <table width="800" border="0" cellspacing="0" cellpadding="0" align="center">-->



  <tr>





    <td colspan="3">

    <div id="pr">

      <div align="left">

          <table width="100%" border="0" cellspacing="0" cellpadding="0">



        

        <tr>







          <td><input name="button" type="button" onclick="hide();window.print();" value="Print" /></td>

		  <?

		   $check = find_a_field('crm_comunication','status','id="'.$cid.'"');

		   if($check=='PENDING'){

		  ?>

	    <td colspan="3"><textarea name="return_note" id="return_note"><?=$data->return_note?></textarea></td>

		<td colspan="3"><input type="submit" name="return" id="return" value="Return" style="width:100px; height:35px; background:#FFCC66;"/></td>

		<td colspan="4"><input type="submit" name="approve" id="approve" value="Approve" class="btn btn-primary" style="width:100px; height:35px; background:#00FFCC;" /></td>

		<?

		 }

		?>

		

	 

          </tr>

<tr>

          <td>

          

          </td>

        </tr>

      </table>

      </div>

    </div>

</td>

</tr>



    <tr>

      <td colspan="3">

<table width="100%" border=".5"  bordercolor="#000000" cellspacing="0" cellpadding="0" style="font: normal 12px Tahoma; font-size: 14px; border-collapse:collapse;">





 <thead>	 

       <tr style="background:#ddd;">

        <td align="center"><strong>Bus Bill</strong></td>

		<td align="center">Cng Bill</td>

        <td align="center"><strong>Rickshaw Bill</strong></td>

        <td align="center"><strong>Bike Bill</strong></td>

        <td align="center"><strong>Others Bill</strong></td>

		<td align="center"><strong>Food Bill</strong></td>

		<td align="center"><strong>Total Bill</strong></td>

      </tr>

	  </thead>

	<tbody>

	<tr>

        <td align="center"><strong><?=$data->bus_bill?></strong></td>

		<td align="center"><?=$data->cng_bill?></td>

        <td align="center"><strong><?=$data->rickshaw_bill?></strong></td>

        <td align="center"><strong><?=$data->bike_bill?></strong></td>

        <td align="center"><strong><?=$data->others_bill?></strong></td>

		<td align="center"><strong><?=$data->food_bill?></strong></td>

		<td align="center"><strong><?=$data->total_bill?></strong></td>

      </tr>

	  

	 

	</tbody>



    </table>



	

    </td>

    </tr>



	  

	</tbody>

	

	

    

  </table>

</form>

</div>







</div>

</body>







</html>







