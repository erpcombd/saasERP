<?
session_start();
ob_start();
$trans_start = microtime(true);
require_once "../../../controllers/routing/default_values.php";
require_once "../../../controllers/uploader/upload_function.php";
//require_once "../../../controllers/uploader/upload_view.php";
require_once SERVER_CORE."core/init.php";
