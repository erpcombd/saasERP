<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$title='Select Dealer for Return Sales Order';



$table_master='sale_return_master';

$unique_master='sr_no';

$tr_type="Show";

$table_detail='sale_return_details';

$unique_detail='id';

if($_GET['mhafuz']){
unset($_SESSION['sr_no']);
}

$table_chalan='sale_do_chalan';

$unique_chalan='id';



$$unique_master=$_POST[$unique_master];



if(isset($_POST['delete']))

{

		$crud   = new crud($table_master);

		$condition=$unique_master."=".$$unique_master;		

		$crud->delete($condition);

		$crud   = new crud($table_detail);

		$crud->delete_all($condition);

		$crud   = new crud($table_chalan);

		$crud->delete_all($condition);

		unset($$unique_master);

		unset($_POST[$unique_master]);

		$type=1;

		$msg='Successfully Deleted.';
		
		

?>
<script language="javascript">
window.location.href = "do.php";
</script>
<?
}

if(isset($_POST['confirm']))

{

 $or_no = $_REQUEST['sr_no'];
 
$_POST['entry_by']=$_SESSION['user']['id'];

$_POST['entry_at']=date('Y-m-d h:i:s');

$sql2 = 'update sale_return_details set status="UNCHECKED" where sr_no = '.$or_no;
db_query($sql2);
$sql3 = 'update sale_return_master set status="UNCHECKED" where sr_no = '.$or_no;
db_query($sql3);
}	

auto_complete_from_db('dealer_info','concat(dealer_name_e)','dealer_code','depot="'.$_SESSION['user']['depot'].'"','dealer');
$tr_from="Warehouse";
?>

<script language="javascript">

window.onload = function() {document.getElementById("dealer").focus();}

</script>


<div class="form-container_large">    
<form action="do.php" method="post" name="codz" id="codz">
        <div class="container-fluid bg-form-titel">
            <div class="row">
                <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9">
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Active Dealer List:</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
						<input name="dealer" type="text" id="dealer" />
                        </div>
                    </div>

                </div>

                <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
                    <input type="submit" name="submitit" id="submitit" value="Create DO" class="btn1 btn1-submit-input"/ >
                </div>

            </div>
        </div>





        <?php /*?><div class="container-fluid pt-5 p-0 ">




                <h4 class="text-center bg-titel bold pt-2 pb-2">
                    Table Titel code hear
                </h4>

            Table code start hear
                <table class="table1  table-striped table-bordered table-hover table-sm">
                    <thead class="thead1">
                    <tr class="bgc-info">
                        <th>column name1</th>
                        <th>column name2</th>
                        <th>column name3</th>

                        <th>column name 4</th>
                        <th>columne name 5</th>
                        <th>column name 6</th>

                        <th>column name 7</th>
                        <th>column name 8</th>
                        <th>Action</th>
                    </tr>
                    </thead>

                    <tbody class="tbody1">

                        <tr>
                            <td>Row name 1</td>
                            <td>Row name 2</td>
                            <td>Row name 3</td>

                            <td>Row name 4</td>
                            <td>Row name 5</td>
                            <td>Row name 6</td>

                            <td>Row name 7</td>
                            <td>Row name 8</td>
                            <td><button type="submit" class="bgc-info">Any Button</button></td>

                        </tr>

                    </tbody>
                </table>





        </div><?php */?>
    </form>
</div>





<?php /*?><div class="form-container_large">

<form action="do.php" method="post" name="codz" id="codz">

<table width="70%" border="0" align="center">

  <tr>

    <td></td>

    <td>&nbsp;</td>

    <td></td>

  </tr>

  <tr>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

  </tr>

  <tr>

    <td align="right" bgcolor="#FF9966"><strong>Active Dealer List: </strong></td>

    <td bgcolor="#FF9966"><strong>

      <input name="dealer" type="text" id="dealer" style="background-color:white;" class="form-control"/>

    </strong></td>

    <td bgcolor="#FF9966" style="text-align:center"><strong>

      <input type="submit" name="submitit" id="submitit" value="Create DO" style="width:170px; font-weight:bold; font-size:12px; height:30px; color:DodgerBlue"/>

    </strong></td>

  </tr>

</table>



</form>

</div><?php */?>



<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>