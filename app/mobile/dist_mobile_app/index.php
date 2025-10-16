<?php

ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);


// index.php

// Specify the target path
$targetPath = 'auth/index.php';

// Redirect to the new path
header('Location: ' . $targetPath);
exit();
?>