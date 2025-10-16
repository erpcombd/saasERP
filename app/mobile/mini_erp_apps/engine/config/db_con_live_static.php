<?php


$config = include_once 'db_live_config.php';
$new_conn = mysqli_connect($config['hostname'], $config['username'], $config['password'], $config['database'], $config['port']);

  
