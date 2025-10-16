<?php
session_start ();
include ("../config/db.php");
include '../config/function.php';

$visitor_name = $_GET['visitor_name'];
$visitor = findall("select * from visitor_table where visitor_name='".$visitor_name."' limit 1");

//echo $visitor->visitor_mobile_no;


$json = array(array('field' => 'visitor_mobile_no', 'value' => $visitor->visitor_mobile_no), 
              array('field' => 'visitor_address',  'value' => $visitor->visitor_address),
              array('field' => 'visitor_nid',  'value' => $visitor->visitor_nid),
              array('field' => 'visitor_meet_person_name',  'value' => $visitor->visitor_meet_person_name)
              
              );
              
              
echo json_encode($json );
?>