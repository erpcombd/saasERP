<?php
// index.php

// Specify the target path
$targetPath = '/saasERP/app/views/auth/masters/';

// Redirect to the new path
header('Location: ' . $targetPath);
exit();
?>