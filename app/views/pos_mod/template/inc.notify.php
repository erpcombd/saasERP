<?php

$_SESSION['notify'][136]=find_a_field('requisition_master','count(req_no)','status="MANUAL" and warehouse_id="'.$_SESSION['user']['depot'].'"');
$_SESSION['notify'][137]=find_a_field('requisition_master','count(req_no)','status="UNCHECKED" and warehouse_id="'.$_SESSION['user']['depot'].'"');
$_SESSION['notify'][160]=find_a_field('production_issue_master p,warehouse w','count(p.pi_no)','p.status="MANUAL" and p.warehouse_to=w.warehouse_id and w.use_type="SD"');
$_SESSION['notify'][160]=find_a_field('production_issue_master p,warehouse w','count(p.pi_no)','p.status="UNSEND" and p.warehouse_to=w.warehouse_id and w.use_type="SD"');
?>