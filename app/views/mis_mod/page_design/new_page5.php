<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Requisition Status';
?>



<div class="container-fluid p-0">
    <div class="row">
        <div class="col-sm-7 p-0 pr-2">

            <div class="container n-form1">
                <div id="table_head_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <div class="row"><div class="col-sm-12 col-md-6"><div class="dataTables_length" id="table_head_length">
                        <label>
                            <select name="table_head_length" aria-controls="table_head" class="custom-select custom-select-sm form-control form-control-sm">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                            </select>
                        </label>
                    </div>
                </div>
            <div class="col-sm-12 col-md-6">
                <div id="table_head_filter" class="dataTables_filter">
                    <label>
                        <input type="search" class="form-control form-control-sm" placeholder="Search.." aria-controls="table_head">
                    </label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <table id="table_head" class="table table-bordered table-bordered table-striped table-hover table-sm dataTable no-footer" role="grid" aria-describedby="table_head_info">
					<thead>
						<tr class="bgc-info" role="row"><th class="sorting_asc" tabindex="0" aria-controls="table_head" rowspan="1" colspan="1" aria-sort="ascending" aria-label=" ID: activate to sort column descending" style="width: 22.3947px;"><span> ID</span></th><th class="sorting" tabindex="0" aria-controls="table_head" rowspan="1" colspan="1" aria-label="Logo: activate to sort column ascending" style="width: 80.8553px;"><span>Logo</span></th><th class="sorting" tabindex="0" aria-controls="table_head" rowspan="1" colspan="1" aria-label="Concern Name : activate to sort column ascending" style="width: 115.105px;"><span>Concern Name </span></th><th class="sorting" tabindex="0" aria-controls="table_head" rowspan="1" colspan="1" aria-label="Concern Address : activate to sort column ascending" style="width: 315.579px;"><span>Concern Address </span></th></tr>
					</thead>
					
					<tbody>
					
												
						
						
											<tr onclick="DoNav('1');" role="row" class="odd">
						  <td class="sorting_1">1</td>
						
      	<td><img src="../../../../public/uploads/logo/1.png" style="width:80px;"></td>







						  <td>CloudERP SAAS</td>
						  <td>H: #985, Ave:#2, R: #16, Mirpur 12 DOHS, Dhaka</td>
						</tr></tbody>
					</table>
				</div>
			</div>
					<div class="row"><div class="col-sm-12 col-md-5">
					    <output 
                            id="table_head_info" 
                            class="dataTables_info" 
                            aria-live="polite">
                            Showing 1 to 1 of 1 entries
                        </output>
					</div><div class="col-sm-12 col-md-7"><div class="dataTables_paginate paging_simple_numbers" id="table_head_paginate"><ul class="pagination"><li class="paginate_button page-item previous disabled" id="table_head_previous"><a href="#" aria-controls="table_head" data-dt-idx="0" tabindex="0" class="page-link">Prev</a></li><li class="paginate_button page-item active"><a href="#" aria-controls="table_head" data-dt-idx="1" tabindex="0" class="page-link">1</a></li><li class="paginate_button page-item next disabled" id="table_head_next"><a href="#" aria-controls="table_head" data-dt-idx="2" tabindex="0" class="page-link">Next</a></li></ul></div></div></div></div>
					
					
					<div id="pageNavPosition"></div>	
					
				</div>

        </div>


        <div class="col-sm-5 p-0 pl-2">
            
            <form id="form1" name="form1" class="n-form  setup-fixed" method="post" action="" enctype="multipart/form-data">
                <h4 class="n-form-titel1 text-center"> Company Concerns </h4>

                <div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label req-input"> Concern Name</label>
                    <div class="col-sm-9 p-0">
                        <input name="id" id="id" value="2" type="hidden">
                       	<input name="id" type="hidden" id="id"  value="2" readonly="">
                        <input name="group_name" required="" type="text" id="group_name" value="">	


                    </div>
                </div>

                <div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Concern Description </label>
                    <div class="col-sm-9 p-0">
                        <input name="description" type="text" id="description" value="">

                    </div>
                </div>

                <div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Concern Address  </label>
                    <div class="col-sm-9 p-0">

                        <input name="address" type="text" id="address" value="">

                    </div>
                </div>
				<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Concern Phone  </label>
                    <div class="col-sm-9 p-0">

                       <input name="phone" type="text" id="phone" value="">

                    </div>
                </div>
				<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Mobile  </label>
                    <div class="col-sm-9 p-0">

                       <input name="mobile" type="text" id="mobile" value="">

                    </div>
                </div>
				<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Email  </label>
                    <div class="col-sm-9 p-0">

                        <input name="email" type="text" id="email" value="">

                    </div>
                </div>
				<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Website  </label>
                    <div class="col-sm-9 p-0">

                        <input name="website" type="text" id="website" value="">

                    </div>
                </div>
				<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Company Logo  </label>
                    <div class="col-sm-9 p-0">

                        <input name="company_logo" type="file" id="company_logo" value="">

                    </div>
                </div>

                <div class="n-form-btn-class">
                                         <input name="insert" type="submit" id="insert" value="SAVE" class="btn1 btn1-bg-submit">
                                          
                 
                                        
                 
                      <input name="reset" type="button" class="btn1 btn1-bg-cancel" id="reset" value="RESET" onclick="parent.location='user_group.php'">

                </div>


            </form>

        </div>

    </div>




</div>



<?

require_once SERVER_CORE."routing/layout.bottom.php";
?>
