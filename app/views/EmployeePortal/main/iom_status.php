<?php



session_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE.'core/init.php';

include '../config/access.php';



$u_id= $_SESSION['user_id']; //$_SESSION['user']['id'];

$PBI_ID = find_a_field('user_activity_management','PBI_ID','user_id='.$u_id);



$user_id	= $PBI_ID; //$_SESSION['user_id'];







$page="do_unfinished";







include "../inc/header.php";







?>





    <!-- main page content -->



    <div class="main-container container">







        <!-- User list items  -->



        <div class="row">











            <div class="row" style="margin: 0 auto;">



                <div class="card pt-2 pb-3">

                    <div class="row text-center mb-2"><h4> IOM Status</h4></div>



                    <table class="table1  table-striped table-bordered table-hover table-sm">

                        <thead class="thead1 bold">

                        <tr class="bgc-info">

                            <th>SL</th>

                            <th>IOM Type</th>
							
							<th>IOM Date</th>

                            <th>Start Time</th>
                            <th>End Time</th>

                            <th>Total Days</th>

                            <th>Status</th>


                       

                        </tr>

                        </thead>



                        <tbody class="tbody1">
			
					<?php 
					
			$g_s_date=date('Y-01-01');
			$g_e_date=date('Y-12-31');
			
			 $sql_t = "select a.* from hrm_iom_info a where s_date between '".$g_s_date."' and '".$g_e_date."' and PBI_ID='".$PBI_ID ."'   order by PBI_ID";
			
			$query2=db_query($sql_t);
			
			while($data2=mysqli_fetch_object($query2)){
			
			?> 
                               



                        <tr>

                            <td><?=++$s?></td>

                            <td><?=$data2->type?></td>

                            <td><?=$data2->iom_apply_date?></td>

                            <td><?=$data2->s_time?></td>

                            <td><?=$data2->e_time?></td>

                            <td><?=$data2->total_days?></td>
							
							 <td><?=$data2->iom_status?></td>

                        



                        </tr>

               <?php } ?>  



                        </tbody>

                    </table>



                </div>



            </div>











        </div>









    </div>



    <!-- main page content ends -->



    <!-- Page ends-->







<?php include "../inc/footer.php"; ?>