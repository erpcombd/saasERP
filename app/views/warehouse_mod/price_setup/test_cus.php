<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Dealer Wise Price Setup';


$tr_type="Show";
do_calander('#odate');

        $sql='select * from dealer_info';
         $records = db_query($sql) ;
?>
<table  class="table table-striped table-condensed" id="tblData">
    <thead>
        <tr>
            <th>Dealer Name</th>
            <th>Dealer Code</th>
            <th>Ledger Group</th>
       </tr>
    </thead>

    <tbody>
       <?php 
      

foreach( $records as $monir ) 
            {
			?>
               <tr><td><?=$monir['dealer_name_e']?></td>
			   <td><?=$monir['dealer_code']?></td>
			   <td><?=$monir['ledger_group']?></td>
                           
                       </tr> 
					   <?php
            }
       ?>
    </tbody>        
</table>

<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>