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

//********** UPDATE JOURNAL TABLE *******//
if(isset($_POST['submit'])){

echo $newid = $_POST['newid'];
echo $oldid = $_POST['oldid'];


}
//echo $update = "update journal_working set PBI_ID='".$_GET['newid']."' where PBI_ID='".$_GET['PBI_ID']."'";
//$query=mysql_query($update);


//********** UPDATE PAYMENT TABLE *******//


//********** UPDATE RECEIPT TABLE *******//



//********** UPDATE EXPENSE TABLE *******//

//********** UPDATE Journal Voucher TABLE *******//



//********** UPDATE SALES VOUCHER TABLE *******//

//********** UPDATE CONTRA TABLE *******//


 ?>






                  <div class="x_content">
                    <p class="text-muted font-13 m-b-30">  </p>
					<p><? //echo $_POST["newid"]; ?></p>
					
					

					
					
					
                    <table id="datatable-buttons" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>SL</th>
                          <th>Employee Name</th>
                          <th>OLD Employee Id</th>

                          <th>NEW Employee Id</th>


                          <th>Status</th>
                        </tr>
                      </thead>
					    <tbody>
<?

  $sql = 'select *
from journal
where  1 group by PBI_ID';
$query=mysql_query($sql);

while($data = mysql_fetch_object($query)){

?>




                        <?php /*?><tr>
                          <td><?=++$s?></td>
                          <td><?=find_a_field('personnel_basic_info','PBI_NAME','PBI_ID="'.$data->PBI_ID.'"');?></td>
                          <td><?=$data->PBI_ID?></td>
                          <td> </td>

                          <td class="text-center">
		                    <div class="btn-group">



<a href="update_emp_id.php?PBI_ID=<?=$data->PBI_ID;?>" class="buttonn btn btn-primary">Click</a>

                    </div>
						</td>
                        </tr><?php */?>
						
<form method="post" action="update_emp_id.php">
						
<tr>
<td><?=++$s?></td>
<td><?=find_a_field('personnel_basic_info','PBI_NAME','PBI_ID="'.$data->PBI_ID.'"');?></td>	
<td><?=$data->PBI_ID?></td>
<td>NEW ID: <input type="text" name="newid"> <input type="hidden" name="oldid" value="<?=$data->PBI_ID;?>"></td>
<td class="text-center"><div class="btn-group"> <input type="submit" name="submit" value="Submit"></div></td>
						
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
