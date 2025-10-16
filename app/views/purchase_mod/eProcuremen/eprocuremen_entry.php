<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='eProcurement Entry';

do_calander("#f_date");
do_calander("#t_date");
unset($_SESSION['rfq_no']);
?>
    <script type="text/javascript" src="../../../assets/js/bootstrap.min.js"></script>	
	<script type="text/javascript" src="../../../assets/js/jquery-3.4.1.min.js"></script>

<style>
.nav-tabs .nav-item .nav-link, .nav-tabs .nav-item .nav-link:hover, .nav-tabs .nav-item .nav-link:focus {
    border: 0 !important;
    color: #007bff !important;
    font-weight: 500;
}
.sidebar, .sidemenu{
	display:none;
    width: 0% !important;
}

.main_content{
	width: 100% !important;
}
.nav-tabs{
	border-bottom: 1px solid #d9d9d9;
	background-color: ghostwhite;
}

.tab-content>.active {
    display: block;
    border: 1px solid #f5f5f5;
	background-color: #fbfbfb9e;
}

.nav-tabs .nav-item .nav-link.active{
    border: 1px solid #e1e1e1 !important;
    border-radius: 5px 5px 0px 0px;
    border-bottom: 1px solid #f8f8ff !important;
}
.nav-tabs .nav-item .nav-link:hover{
    border: 1px solid #e1e1e1 !important;
    border-radius: 5px 5px 0px 0px;
    border-bottom: 1px solid #f8f8ff !important;
}

</style>




	<div class="col-12 pt-3" align="center">
		<a href="eprocuremen_entry_entry.php"><button type="button" class="btn1 btn1-bg-submit">Create Event</button></a>
	</div>

<div class="container-fluid pt-3 p-0 ">

                <table class="table1  table-striped table-bordered table-hover table-sm">
                    <thead class="thead1">
                    <tr class="bgc-info">
                        <th>Event# </th>
                        <th>Revision</th>
                        <th>Event Name</th>
						<th>Creator</th>
                        <th>Tags</th>
                        <th>Commodity</th>
                        <th>Start Date</th>
						<th>End Date</th>
						<th>State</th>
						<th>Type</th>
						<th>Responses</th>
						<th>Actions</th>
                        
                    </tr>
                    </thead>

                    <tbody class="tbody1">
					<?php 
					$sql = 'select r.*,u.fname from rfq_master r, user_activity_management u where u.user_id=r.entry_by';
					$qry = db_query($sql);
					while($rfq=mysqli_fetch_object($qry)){
					?>
					
					    <tr>
                            <td><a href="../eProcuremen/eprocuremen_entry_entry.php?rfq_no=<?=$rfq->rfq_no?>"><?=$rfq->rfq_no?></a></td>
							<td><?=$rfq->rfq_no?></td>
                            <td><?=$rfq->event_name?></td>
                            <td><?=$rfq->fname?></td>
							<td><?=$rfq->tag?></td>
                            <td><?=$rfq->commodity?></td>
                            <td><?=$rfq->start_date?></td>
							<td><?=$rfq->end_date?></td>
							<td><?=$rfq->type?></td>
							<td><?=$rfq->response?></td>
							<td><?=$rfq->action?></td>
							<td><?=$rfq->action?></td>


                        </tr>
						<? } ?>
														
					</tbody>
                </table>





        </div>









<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>