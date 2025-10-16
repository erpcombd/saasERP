<?php

session_start();

ob_start();

require "../../support/inc.all.php";
require_once('../excel_lib/php-excel-reader/excel_reader2.php');
require_once('../excel_lib/SpreadsheetReader.php');


if (isset($_POST["import"]))
{
 $show_data = 1;
    
    
  $allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
  
  if(in_array($_FILES["file"]["type"],$allowedFileType)){

        $targetPath = '../excel_lib/'.$_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);
        
        $Reader = new SpreadsheetReader($targetPath);
        
        $sheetCount = count($Reader->sheets());
        for($i=0;$i<$sheetCount;$i++)
        {
            
            $Reader->ChangeSheet($i);
            
            foreach ($Reader as $Row)
            {
          
                $vendor_id = "";
                if(isset($Row[0])) {
                    $vendor_id = mysqli_real_escape_string($Row[0]);
					
	                
                }
				
				$vendor_name = "";
                if(isset($Row[1])) {
                    $vendor_name = mysqli_real_escape_string($Row[1]);
					
	                
                }
                
                $vendor_category = "";
                if(isset($Row[2])) {
                    $vendor_category =mysqli_real_escape_string($Row[2]);
                }
				
				
				
				
				  $vendor_type_id = find_a_field('vendor_type','id','vendor_type like "%'.$vendor_category.'%" ');
				  if($vendor_id>0){
                 $id_exist = find_a_field('vendor_new','id','id='.$vendor_id);
                  
				   if($id_exist>0){
				   
				   }else{
                
                    $query = 'insert into vendor_new (`vendor_id`,`vendor_name`,`vendor_category`) values("'.$vendor_id.'","'.$vendor_name.'","'.$vendor_type_id.'")';
                    $result = db_query($query);
                
                    if (! empty($result)) {
                        $type = "success";
                        $message = "Excel Data Imported into the Database";
                    } else {
                        $type = "error";
                        $message = "Problem in Importing Excel Data";
                    }
					}
					}
                
             }
        
         }
  }
  else
  { 
        $type = "error";
        $message = "Invalid File Type. Upload Excel File.";
  }
}
?>

<style>    
body {
	font-family: Arial;
	width: 100%;
}

.outer-container {
	background: #F0F0F0;
	border: #e0dfdf 1px solid;
	padding: 40px 20px;
	border-radius: 2px;
}

.btn-submit {
	background: #333;
	border: #1d1d1d 1px solid;
    border-radius: 2px;
	color: #f0f0f0;
	cursor: pointer;
    padding: 5px 20px;
    font-size:0.9em;
}

.tutorial-table {
    margin-top: 40px;
    font-size: 0.8em;
	border-collapse: collapse;
	width: 100%;
}

.tutorial-table th {
    background: #f0f0f0;
    border-bottom: 1px solid #dddddd;
	padding: 8px;
	text-align: left;
}

.tutorial-table td {
    background: #FFF;
	border-bottom: 1px solid #dddddd;
	padding: 8px;
	text-align: left;
}

#response {
    padding: 10px;
    margin-top: 10px;
    border-radius: 2px;
    display:none;
}

.success {
    background: #c7efd9;
    border: #bbe2cd 1px solid;
}

.error {
    background: #fbcfcf;
    border: #f3c6c7 1px solid;
}

div#response.display-block {
    display: block;
}
</style>

 <div class="oe_view_manager oe_view_manager_current">
    <div class="oe_view_manager_body">
      <div  class="oe_view_manager_view_list"></div>
      <div class="oe_view_manager_view_form">
        <div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">
          <div class="oe_form_buttons"></div>
          <div class="oe_form_sidebar"></div>
          <div class="oe_form_pager"></div>
          <div class="oe_form_container">
            <div class="oe_form">
              <div class="">
                <div class="oe_form_sheetbg">
                  <div class="oe_form_sheet oe_form_sheet_width">
                    <div  class="oe_view_manager_view_list">
                      <div  class="oe_list oe_view">
    <h2>Vendor List Upload</h2>
    
    <div class="outer-container">
        <form action="" method="post"
            name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
            <div>
                <label></label> <input type="file" name="file"
                    id="file" accept=".xls,.xlsx">
                <button type="submit" id="submit" name="import"
                    class="btn-submit">Import</button>
        
            </div>
        
        </form>
        
    </div>
    <div id="response" class="<?php if(!empty($type)) { echo $type . " display-block"; } ?>"><?php if(!empty($message)) { echo $message; } ?></div>
    
	<?    
	      if ($show_data> 0){
	      $sql ="SELECT * FROM vendor_new";
          $query = db_query($sql);
         

	 ?>
         
     
    <table class='tutorial-table'>
        <thead>
            <tr>
                <th>Vendor ID</th>
                <th>Vendor Name</th>
				 <th>Vendor Category</th>
                
            </tr>
        </thead>
<?php

 while ($row=mysqli_fetch_object($query)) {

?>                  
        <tbody>
        <tr>
            <td><?php  echo $row->vendor_id ?></td>
            <td><?php  echo $row->vendor_name ?></td>
			<td><?php  echo find_a_field('vendor_type','vendor_type','id='.$row->vendor_category) ?></td>
			
							
							   	
        </tr>
<?php
    } 
?>
        </tbody>
    </table>
	
	<? } ?>
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


<?php

$main_content=ob_get_contents();

ob_end_clean();

require_once SERVER_CORE."routing/layout.bottom.php";

?>
