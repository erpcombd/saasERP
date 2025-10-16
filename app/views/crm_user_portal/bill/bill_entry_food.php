<?php
//
//

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
// ::::: Edit This Section :::::
$title = 'Entertainment Bill Entry';			// Page Name and Page Title
$page = "car_req_entry.php";		// PHP File Name
$root = 'transportation';
$table = 'vehicle_requisition';		// Database Table Name Mainly related to this page			
$unique ='req_no';					//Unique id

//user id
$u_id=$_SESSION['user']['id'];
$PBI_ID = find_a_field('user_activity_management','PBI_ID','user_id='.$u_id);










?>
<!--<style>
	.container {
  display: flex;
  flex-direction: column;
  align-items: center;
  margin-top: 20px;
}

form {
  display: flex;
  flex-direction: row;
  align-items: center;
  margin-bottom: 20px;
}

form label {
  margin-right: 10px;
}

form input {
  margin-right: 20px;
}

table {
  border-collapse: collapse;
  width: 100%;
  max-width: 600px;
  margin-bottom: 20px;
}

thead th {
  background-color: #f2f2f2;
  border: 1px solid #ddd;
  text-align: left;
  padding: 8px;
}

tbody td {
  border: 1px solid #ddd;
  padding: 8px;
}

tbody td:last-child {
  text-align: center;
}

.removeRowBtn {
  background-color: #ff6666;
  border: none;
  color: white;
  padding: 8px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 14px;
  cursor: pointer;
  border-radius: 5px;
}

.removeRowBtn:hover {
  background-color: #ff4d4d;
}

</style>-->
<div class="form-container_large">
  <div class="container-fluid pt-0 p-0">
  <form id="form1" name="form1" method="post">
      <div class="row m-0">
         <div class="card">
          <h5 class="text-center bg-info bold pt-2 pb-2">Entertainment Bill Entry </h5>
          <div class="card-body">
            <div class="row m-0">
			
			       <div class="col-md-2 form-group">
                <label class="label success" for="car_req3">Employee ID : </label>

       <input type="text"  name="emp_code" id="emp_code" 
       value="<?=find_a_field('personnel_basic_info','PBI_CODE','PBI_ID='.$PBI_ID);?>" required readonly/>

           

               <!-- <datalist id='eip_ids'>
                  <option></option>
                  <?
                //foreign_relation('personnel_basic_info','PBI_CODE','concat(PBI_CODE," - ",PBI_NAME)',$emp_code,'1');
                ?>

                </datalist> -->


              </div>
			  
              <div class="col-md-2 form-group">
                <label class="label success" for="car_req4">Bill No : </label>
              <input name="conv_no" type="text" 
					 id="conv_no" value="<? echo find_a_field('personnel_basic_info','PBI_CODE','PBI_ID='.$PBI_ID); echo '-'; echo find_a_field('bills','bills_id','1 order by bills_id desc')+1;?>" class="form-control" readonly>
              </div>
			  
			         <div class="col-md-2 form-group">
                <label class="label success" for="car_req4">Bill Date : </label>
                <input name="conveyance_date" type="date" id="conveyance_date" value="<?=$conveyance_date?>" class="form-control">
              </div>

               <div class="col-md-2 form-group">
                <label class="label success" for="car_req4">Perticular:</label>
                <input type="text" name="means" class="form-control" id="means">
              </div>

              <div class="col-md-2 form-group">
                <label class="label success" for="car_req4">Remarks:</label>
                <input type="text" name="remarks" class="form-control" id="remarks">
              </div>

               <div class="col-md-2 form-group">
                <label class="label success" for="conv_files">Attachment:</label>
               <input name="conv_files" type="file" id="conv_files" class="form-control" style="opacity:3!important;position:initial;"/>
              </div>
			  
			  
			
              <div class="col-md-2 form-group">
              <label for="success" class="">Type</label>
              <select name="con_type" id="con_type" class="form-control" required="">
             <!-- <option value=""></option>-->
              <option value="Food">Food</option>
              <!--<option value="Transport">Transport</option>
              <option value="Overtime">Overtime</option>-->
              </select>

              </div>


                <div class="col-md-2 form-group">
             <label for="success" class="">Number of Person:</label>
<input type="number" name="from_address" class="form-control" id="from_address">
              </div>

			  
              <!--<div class="col-md-2 form-group">
               <label for="success" class="">To Address</label>
<input type="text" name="to_address" class="form-control" id="to_address">
              </div>
			  -->
            
			  
			  
			  <div class="col-md-2 form-group">
  <label for="success" class="">Amount</label>
<input type="text" name="amount" class="form-control" id="amount">
              </div>
			  
			  
			  <div class="col-md-2 form-group">
     <label for="success" class=""> Add Items On Below </label>
  <input type="button" name="send" class="btn btn-danger" value="Add Data On Table" id="butsend">
              </div>
			  
			  
			  <div class="col-md-2 form-group">
  <label for="success" class=""> SAVE TO DATABASE </label>
<input type="button" name="save" class="btn btn-success" value="Final Save & Confirm" id="butsave">
              </div>
              
       
            </div>
          </div>
        </div>
		
        
      </div>
    </form>
  </div>
</div>





<table id="table1" name="table1" class="table table-bordered table-sm">
  <tbody>
    <tr class="table-success">
      <th>SL</th>
      <th>Code</th>
      <th>No</th>
      <th>Date</th>
      <th>Means</th>
      <th>Remarks</th>
      <th>Type</th>
      <th>No Of Person</th>
  
      <th>Amount</th>
      <th>Action</th>
    <tr>
  </tbody>
</table>


<script>
$(document).ready(function() {
    var id = 1;  
    /* Assigning id and class for tr and td tags for separation. */

    $("#butsend").click(function() {
        var newid = id++; 
        $("#table1").append('<tr valign="top" id="'+newid+'">\n\
            <td width="100px" >' + newid + '</td>\n\
            <td width="100px" class="emp_code'+newid+'">' + $("#emp_code").val() + '</td>\n\
            <td width="100px" class="conv_no'+newid+'">' + $("#conv_no").val() + '</td>\n\
            <td width="100px" class="conveyance_date'+newid+'">' + $("#conveyance_date").val() + '</td>\n\
            <td width="100px" class="means'+newid+'">' + $("#means").val() + '</td>\n\
            <td width="100px" class="remarks'+newid+'">' + $("#remarks").val() + '</td>\n\
            <td width="100px" class="type'+newid+'">' + $("#con_type").val() + '</td>\n\
            <td width="100px" class="f_address'+newid+'">' + $("#from_address").val() + '</td>\n\
            <td width="100px" class="amount'+newid+'">' + $("#amount").val() + '</td>\n\
            <td width="100px"><a href="javascript:void(0);" class="remCF btn btn-danger">X</a></td>\n\
        </tr>');

    });

    var serializedData = $('#form1').serialize();

    $.ajax({
        url: "save_food.php",
        type: "post",
        data: serializedData
    });

    $("#table1").on('click', '.remCF', function() {
        $(this).parent().parent().remove();
    });

   /* crating new click event for save button*/

    $("#butsave").click(function() {
        var lastRowId = $('#table1 tr:last').attr("id"); /* finds id of the last row inside table */

        var e_code = new Array();  
        var conveyance_no= new Array();
        var conveyance_date= new Array();  
        var means_of_con= new Array();
        var remarks   = new Array();  
        var bill_type = new Array();  
        var f_address = new Array();
        var amount    = new Array(); 

        for ( var i = 1; i <= lastRowId; i++) {
            /* pushing all the names listed in the table  */
            e_code.push($("#"+i+" .emp_code"+i).html()); 
            conveyance_no.push($("#"+i+" .conv_no"+i).html()); 
            conveyance_date.push($("#"+i+" .conveyance_date"+i).html()); 
            means_of_con.push($("#"+i+" .means"+i).html()); 
            remarks.push($("#"+i+" .remarks"+i).html()); 
            bill_type.push($("#"+i+" .type"+i).html());  
            f_address.push($("#"+i+" .f_address"+i).html());
            amount.push($("#"+i+" .amount"+i).html());    
        }
        var sendE_code = JSON.stringify(e_code);  
        var sendConveyance_no = JSON.stringify(conveyance_no);
        var sendConveyance_date = JSON.stringify(conveyance_date);  
        var sendMeans_of_con = JSON.stringify(means_of_con);
        var sendRemarks = JSON.stringify(remarks);
        var sendType = JSON.stringify(bill_type);  
        var sendFromaddress = JSON.stringify(f_address);
        var sendAmount = JSON.stringify(amount);
        $.ajax({
            url: "save_food.php",
            type: "post",
            data: {
              E_code    : sendE_code , 
              Conve_no  : sendConveyance_no,
              Con_date  : sendConveyance_date,
              Means     : sendMeans_of_con,
              Remarks   : sendRemarks,
              Bill_Type : sendType , 
              F_address : sendFromaddress,
              Amount    : sendAmount

            },
            success : function(data){
                alert(data);    /* alerts the response from php. */

              // redirect to another page
           window.location.href = 'conveyance_employ.php';
                }
        });
        });
});
</script>



</body></html>

<?
//
//
require_once SERVER_CORE."routing/layout.bottom.php";

?>
