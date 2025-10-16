<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title=" Asset Purchase Entry";

?>


<script type="text/javascript" src="../../../assets/js/bootstrap.min.js"></script>


    <!-- Datatables -->
    <link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->


        <!-- top navigation -->
        
        <!-- /top navigation -->

        <!-- page content -->
		

		
		    <!--product assign  model--> 
      <form method="post" id="purchase">
        <div class="modal" id="recivedModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button class="close" data-dismiss="modal">
                    &times;
                  </button>
                  <h4 id="myModalLabel">
                    Create Local Purchase. 
                  </h4>
              </div>
              <div class="modal-body">
                  
                  <!--Sign up message from PHP file-->
                  <div id="signupmessage"></div>
                  
                  <div class="form-group">
                      <label for="vendor">Vendor Information</label>
					   <textarea name="vendor" id="vendor" class="form-control" rows="5" maxlength="300" required></textarea>
				
			      </div>
                  <div class="form-group">
                      <label for="product">Product Name:</label>
					<input type="text" class="form-control" list='item' name="product" id="product" value="<?=$_POST['product']?>"  requierd/>
                      <datalist id='item'>
                      <option></option>
                      <? foreign_relation('item_info','item_id','concat(item_id," - ",item_name)',$product,'1');?>
					  </datalist>
                  </div>
				  
				    <div class="form-group">
                      <label for="qty">Purchase QTY:</label>
                      <input class="form-control" type="number" name="item_in" id="item_in" maxlength="30" requierd>
                  </div>
				  
				  
                  <div class="form-group">
                      <label for="date">Purchase Date:</label>
                      <input class="form-control" type="date" name="date" id="date"  maxlength="30" required> 
                  </div>
               
                  
				  
                  <div class="form-group">
                      <label for="remarks">Remarks: </label>
                      <textarea name="remarks" id="remarks" class="form-control" rows="5" maxlength="300"></textarea>
                  </div>
              </div>
              <div class="modal-footer">
                  <input class="btn btn-success" name="signup" type="submit" value="SAVE">
               <a href="" onclick="window.location.reload(true);"> <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button></a>
              </div>
          </div>
      </div>
      </div>
      </form>
	  
	  
	  <!--edit form -->
	  
	  <form method="post" id="editform">
        <div class="modal" id="editModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button class="close" data-dismiss="modal">
                    &times;
                  </button>
                  <h4 id="myModalLabel">
                    Assign product and Start using our Online Notes App! 
                  </h4>
              </div>
              <div class="modal-body">
                  
                  <!--Sign up message from PHP file-->
                  <div id="signupmessage"></div>
                  
                  <div class="form-group">
                      <label for="emp_id">Emp Name</label>
					  <input type="text" class="form-control"  name="emp_id" id="emp_id" value="<?=$data->asign_id?>" required />
                    

                  </div>
                
              </div>
              <div class="modal-footer">
                  <input class="btn green" name="signup" type="submit" value="SAVE">
               <a href="https://aksiderp.com/144133/asset_mod/pages/asset/product_assign.php"> <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button></a>
              </div>
          </div>
      </div>
      </div>
      </form>
	  
	  
     

            

             
                  
                  <div class="x_content">
                    <p class="text-muted font-13 m-b-30">
			 <button type="button" class="btn btn-danger btn-md" data-toggle="modal" data-target="#recivedModal"> <i class="fa fa-plus"></i> Create Local Purchase</button>
					
					
                    </p>
                    <table id="datatable-buttons" class="table1  table-striped table-bordered table-hover table-sm">
                      <thead class="thead1">
                        <tr class="bgc-info">
                          <th>SL</th>
                          <th>Vendor Name</th>
                          <th>Product Name</th>
                          <th>Purchase QTY</th>
                          <th>Purchase date</th>
                          <th>Action</th>
                        </tr>
                      </thead>
					    <tbody class="tbody1">
<?					  
					  
 $sql = 'select a.asign_id,i.item_name,a.item_in,a.asign_date,a.vendor
from product_asign a,item_info i
where tr_from="purchase" and a.product=i.item_id order by a.asign_id desc';
$query=db_query($sql);		

while($data = mysqli_fetch_object($query)){

?>			  
					  
					  


                    
                        <tr>
                          <td><?=++$s?></td>
                          <td><?=$data->vendor?></td>
                          <td><?=$data->item_name?></td>
                          <td><?=$data->item_in?></td>
                          <td><?=$data->asign_date?></td>
                          <td class="text-center">
		                    <div class="btn-group">
		                    
		                    	<a href="javascript:void(0)" data-id='' class="btn btn-info btn-flat" data-toggle="modal" data-target=""> <i class="fa fa-eye"></i> </a>
					
								
<a href="edit_local_purchase.php?asign_id=<?=$data->asign_id;?>" data-id='' class="btn btn-primary btn-flat manage_establishment"> <i class="fa fa-edit"></i> </a>
<a href="delete_local_purchase.php?asign_id=<?=$data->asign_id;?>" onclick="return confirm('Are you sure you want to delete this item?');"   class="btn btn-danger btn-flat"> <i class="fa fa-trash"></i> </a>
	                      </div>
						</td>
                        </tr>
                        
                        
              <? } ?>          
                       
                       
                        
                      </tbody>
                    </table>
                  </div>
              
              

        
       
        <!-- /page content -->

        <!-- footer content -->
		
	
		




    <!-- Datatables -->
    <script src="../vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="../vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="../vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="../vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="../vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <script src="../vendors/jszip/dist/jszip.min.js"></script>
    <script src="../vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="../vendors/pdfmake/build/vfs_fonts.js"></script>



  </body>
</html>



<script src="asset.js"></script>



<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>