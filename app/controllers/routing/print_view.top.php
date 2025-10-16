<?
session_start();
$trans_start = microtime(true);

require_once "../../../controllers/routing/default_values.php";

require_once SERVER_CORE."core/all_functions.php";
require_once SERVER_ROOT."app/models/crud.php";
require_once SERVER_CORE."core/mod.php";
require_once SERVER_CORE."utilities/temp_function.php";

require_once SERVER_CORE."config/db_con_print_view.php";

require_once SERVER_ROOT."app/models/inc.database.php";

require_once SERVER_CORE."core/report.class.php";
require_once SERVER_CORE."core/inc.log.php";


require_once SERVER_CORE."core/class.numbertoword.php";
