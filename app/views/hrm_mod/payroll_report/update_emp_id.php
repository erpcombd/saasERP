<?php

@session_start();

//

require "../../config/inc.all.php";

require "../../template/main_layout.php";


?>





    <!-- Datatables -->
    <link href="../../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="../../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="../../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="../../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="../../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->


        <!-- top navigation -->

        <!-- /top navigation -->

        <!-- page content -->

        	<div class="right_col" role="main">   <!-- Must not delete it ,this is main design header-->

                  <div class="">







                <div class="clearfix"></div>



                    <div class="row">

                      <div class="col-md-12 col-sm-12 col-xs-12">

              	 <div class="openerp openerp_webclient_container">









                          <div class="x_content">




	  <!--edit form -->



<style>
.button {
  position: relative;
  background-color: #04AA6D;
  border: none;
  font-size: 28px;
  color: #FFFFFF;
  padding: 20px;
  width: 200px;
  text-align: center;
  -webkit-transition-duration: 0.4s; /* Safari */
  transition-duration: 0.4s;
  text-decoration: none;
  overflow: hidden;
  cursor: pointer;
}

.button:after {
  content: "";
  background: #90EE90;
  display: block;
  position: absolute;
  padding-top: 300%;
  padding-left: 350%;
  margin-left: -20px!important;
  margin-top: -120%;
  opacity: 0;
  transition: all 0.8s
}

.button:active:after {
  padding: 0;
  margin: 0;
  opacity: 1;
  transition: 0s
}
</style>

<?

/*if(isset($_POST['submit'])){

echo $newid = $_POST['bonus_date'];

}*/
/*echo $update = "update salary_bonus set bonus_date='".$_POST['bonus_date']."' where id='".$_GET['id']."'";
$query=db_query($update);*/










 ?>






                  <div class="x_content">
                    <p class="text-muted font-13 m-b-30">  </p>
					<p><? //echo $_POST["newid"]; ?></p>
					
					

					
					
					
                    <table id="datatable-buttons" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>SL</th>
						  <th>Bonus ID</th>
                          <th>Employee Name</th>
                          <th>Employee Id</th>
						  <th>Mon</th>
						  <th>Year</th>
                          <th>Bonus Date</th>

                        </tr>
                      </thead>
					    <tbody>
<?





 echo $sql = 'select *
from salary_bonus a, personnel_basic_info b
where a.PBI_ID=b.PBI_ID and  a.year>2020 and b.ESSENTIAL_TIN_NO>0 group by a.id order by a.PBI_ID';
$query=db_query($sql);

while($data = mysqli_fetch_object($query)){


echo $bonus = $_POST['bonus_date'];

?>


						
<form method="POST" action="update_emp_id.php">
						
<tr>
<td><?=++$s?></td>
<td><?=$data->id?></td>
<td><?=find_a_field('personnel_basic_info','PBI_NAME','PBI_ID="'.$data->PBI_ID.'"');?></td>	
<td><?=find_a_field('personnel_basic_info','PBI_CODE','PBI_ID="'.$data->PBI_ID.'"');?></td>
<td><?=$data->mon?></td>
<td><?=$data->year?></td>
<td></td>

</tr>					
						
</form>						
						
						


              <? } ?>



                      </tbody>
                    </table>
					
					
				
				
					
					
					
                  </div>




                  		   </div>





                  		   </div>

                  		    </div>

                              </div>

                  			</div>

                  			</div>

                  			 </div>

                                </div>



                            </div>

                          </div>

                        </div>

                      </div>

                    </div>





                      </div>

        <!-- /page content -->

        <!-- footer content -->







    <!-- Datatables -->
    <script src="../../vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../../vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="../../vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../../vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="../../vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="../../vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="../../vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="../../vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="../../vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="../../vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../../vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="../../vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <script src="../../vendors/jszip/dist/jszip.min.js"></script>
    <script src="../../vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="../../vendors/pdfmake/build/vfs_fonts.js"></script>



  </body>
</html>



<script src="asset.js"></script>




<?

include_once("../../template/footer.php");

?>
