<?php
@session_start();
date_default_timezone_set('Asia/Dhaka');


function findin($sql){
    
    $res = db_query($sql);
    
    if($res){
        $count = mysqli_num_rows($res);
        
        if($count > 0){
            $mi = 0;    
            while($info = mysqli_fetch_row($res)){
                if($mi == 0)
                    $ch = '"' . $info[0] . '"';
                else
                    $ch .= ',"' . $info[0] . '"';
                $mi++;
            }
            return $ch;
        } else {
            return NULL;
        }
    } else {
        return NULL;
    }
}



function show_dealer_type($id){
    $view =find1("select dealer_type from dealer_type where id='".$id."'");
    return $view;
}


function getRegions() {
    $data = array();
    $sql = "SELECT BRANCH_ID as id, BRANCH_NAME as name FROM branch";
    $res = db_query($sql);

    if ($res) {
        while ($row = mysqli_fetch_object($res)) {
            $data[$row->id] = $row->name;
        }
    } else {
        die('Error executing query: ' . mysqli_error());
    }

    return $data;
}

function getZones() {
    $data = array();
    $sql = "SELECT ZONE_CODE as id, ZONE_NAME as name FROM zon";
    $res = db_query($sql);

    if ($res) {
        while ($row = mysqli_fetch_object($res)) {
            $data[$row->id] = $row->name;
        }
    } else {
        die('Error executing query: ' . mysqli_error());
    }

    return $data;
}

function getAreas() {
    $data = array();
    $sql = "SELECT AREA_CODE as id, AREA_NAME as name FROM area";
    $res = db_query($sql);

    if ($res) {
        while ($row = mysqli_fetch_object($res)) {
            $data[$row->id] = $row->name;
        }
    } else {
        die('Error executing query: ' . mysqli_error());
    }

    return $data;
}



function getRoutes() {
    $data = array();
    $sql = "SELECT route_id as id, route_name as name FROM ss_route";
    $res = db_query($sql);

    if ($res) {
        while ($row = mysqli_fetch_object($res)) {
            $data[$row->id] = $row->name;
        }
    } else {
        die('Error executing query: ' . mysqli_error());
    }

    return $data;
}



function getCompanyNames(){
    $aa = array();
    $res = db_query("select id,company_short_code as name from user_group");

    if ($res) {
        while ($row = mysqli_fetch_object($res)) {
            $aa[$row->id] = $row->name;
        }
    } else {die('Error executing query: ' . mysqli_error());}

    return $aa;
}


function show_company2($group_for){
    $view =find1("select company_short_code from user_group where id='".$group_for."'");
    return $view;
}



function getData($sql) {
    $data = array();
    $res = db_query($sql);

    if ($res) {
        while ($row = mysqli_fetch_array($res)) {
            $data[$row[0]] = $row[1];
        }
        mysqli_free_result($res); // Free result set
    } else {
        die('Error executing query: ' . mysqli_error());
    }

    return $data;
}
// example: $group_info = getData("select id,offer_group_name from sec_cash_offer_group"); // use in site: $group_info[$data->group_id];


function getData2($sql){
    $data = array();
    $res = db_query($sql);

    if ($res) {
        while ($row = mysqli_fetch_row($res)){
        $data[$row[0]] = array($row[1], $row[2]);
        }
    } else {
        die('Error executing query: ' . mysqli_error());
    }

    return $data;
}
// example: $userinfo = getData2("select user_id,fname,boss from user_activity_management"); $userinfo[$data->entry_by][0]; // for first data.




function getDistance($lat1, $long1, $lat2, $long2)
{
	// Google API key
	$apiKey = find1('select map_api from ss_config where id=1');


	// Get latitude and longitude from the geodata
	$latitudeFrom       = $lat1;
	$longitudeFrom      = $long1;
	$latitudeTo         = $lat2;
	$longitudeTo        = $long2;

	// Calculate distance between latitude and longitude
	$theta    = $longitudeFrom - $longitudeTo;
	$dist    = sin(deg2rad($latitudeFrom)) * sin(deg2rad($latitudeTo)) +  cos(deg2rad($latitudeFrom)) * cos(deg2rad($latitudeTo)) * cos(deg2rad($theta));
	$dist    = acos($dist);
	$dist    = rad2deg($dist);
	$miles    = $dist * 60 * 1.1515;

	// Convert unit and return distance

	return round($miles * 1.609344, 2);
} // END FUNCTION




function location_save($type, $user, $ip, $latitude, $longitude, $country, $state, $city)
{
	$log_sql = "INSERT IGNORE INTO ss_location_log(type,user_id,access_date,access_time,ip,latitude,longitude,country,state,city)
    VALUES('" . $type . "','" . $user . "',NOW(),NOW(),'" . $ip . "','" . $latitude . "','" . $longitude . "','" . $country . "','" . $state . "','" . $city . "')";
	db_query($log_sql);
}


//today 31 jul 24
//function prevent_multi_submit($type = "post", $excl = "validator") {
// //    $string = "";
//    foreach ($_POST as $key => $val) {
//        if ($key != $excl) {
//            $string .= $val;
//        }
//    }
//    if (isset($_SESSION['last'])) {
//        if ($_SESSION['last'] === md5($string)) {
//            return false;
//        } else {
//            $_SESSION['last'] = md5($string);
//            return true;
//        }
//    } else {
//        $_SESSION['last'] = md5($string);
//        return true;
//    }
//}



function get_stock($item_id)
{
	$data = find1("select sum(item_in-item_ex) from journal_item where item_id='" . $item_id . "' ");
	return $data;
}


function get_price($item_id)
{
	$data = find1("select price from product where id='" . $item_id . "' ");
	return $data;
}


function get_cost_rate($item_id)
{
	$data = find1("select sum(amount)/sum(qty) from warehouse_other_receive_detail where receive_type='Local Purchase' and item_id='" . $item_id . "' ");
	return round($data, 4);
}


function journal_item_input($item_id, $warehouse_id, $ji_date, $item_in, $item_ex, $tr_from, $tr_no, $item_price = '', $r_warehouse = '', $sr_no)
{
	$sql = "INSERT INTO journal_item 
	(ji_date, item_id, warehouse_id, item_in, item_ex, item_price, tr_from, tr_no,
	entry_by, entry_at,relevant_warehouse,sr_no
	
	)VALUES (
	'" . $ji_date . "', '" . $item_id . "', '" . $warehouse_id . "', '" . $item_in . "', '" . $item_ex . "', '" . $item_price . "', '" . $tr_from . "', '" . $tr_no . "',
	'" . $_SESSION['user']['username'] . "', '" . date('Y-m-d H:i:s') . "', '" . $r_warehouse . "', '" . $sr_no . "')";

	db_query($sql);
}


function journal_item_ss($item_id, $warehouse_id, $ji_date, $item_in, $item_ex, $tr_from, $tr_no, $item_price = '', $r_warehouse = '', $sr_no = '')
{
	$sql = "INSERT INTO ss_journal_item 
	(ji_date, item_id, warehouse_id, item_in, item_ex, item_price, tr_from, tr_no,
	entry_by, entry_at,relevant_warehouse,sr_no
	
	)VALUES (
	'" . $ji_date . "', '" . $item_id . "', '" . $warehouse_id . "', '" . $item_in . "', '" . $item_ex . "', '" . $item_price . "', '" . $tr_from . "', '" . $tr_no . "',
	'" . $_SESSION['user']['username'] . "', '" . date('Y-m-d H:i:s') . "', '" . $r_warehouse . "', '" . $sr_no . "')";

	db_query($sql);
}

//today 31 jul 24
//function db_last_insert_id($table,$field) {
// //	$sql = "select MAX($field)+1 from $table";
//	if($result = db_query($sql)){
//	$data = mysqli_fetch_row($result);
//	if($data[0]<1)
//	return 1;
//	else
//	return $data[0];
//	}
//	else return 1;
//}


function price_range($pid)
{
	$sql_price_range = "select product_id, min(price) as mprice, max(price) as xprice from product_attributes where product_id='" . $pid . "'";
	$price_info = findall($sql_price_range);
	$price_min = $price_info->mprice;
	$price_max = $price_info->xprice;


	if ($price_min == $price_max) {
		$p = $price_min;
	} else {
		$p = $price_min . ' - ' . $price_max;
	}

	return $p;
}


function redirect($link)
{
?>
	<script>
		window.location.href = "<?php echo $link; ?>";
	</script>
<?php }

function redirect2($link)
{
?>
	<script>
		setTimeout(function() {
			window.location = "<?php echo $link; ?>";
		}, 1000);
	</script>
	<?php } ?><?


				function validation($data)
				{
					$data = trim($data);
					$data = stripslashes($data);
					$data = htmlspecialchars($data);
					$data = mysqli_real_escape_string($conn, $data);
					return $data;
				}



				//today 31 jul 24
				//function db_fetch_object($table,$condition){
				// //	$res="select * from $table where $condition limit 1";
				//	if($query=db_query($res)){
				//	if(mysqli_num_rows($query)>0) return mysqli_fetch_object($query);
				//	else return NULL;}else return NULL;
				//}

				//today 31 jul 24
				//function find($res){
				// //
				//	$query=db_query($res);
				//	if(mysqli_num_rows($query)>0) return 1;
				//	else return NULL;
				//}



				function db_fetch_array($table, $condition)
				{
					$res = "select * from $table where $condition limit 1";
					$query = db_query($res);
					if (mysqli_num_rows($query) > 0) return mysqli_fetch_array($query);
					else return NULL;
				}

				//today 31 jul 24
				//function get_vars ($fields) {
				// //	$vars = array();
				//
				//	foreach($fields as $field_name) {
				//		if (isset($_POST[$field_name])) {
				//			$vars[$field_name] = $_POST[$field_name];
				//		}
				//	}
				//	return $vars;
				//}


				//today 31 jul 24
				//function get_value ($fields) {
				// //
				//	$vars = array();
				//
				//	foreach($fields as $field_name) {
				//	var_dump($field_name);
				//	}
				//	return $vars;
				//}

				//today 31 jul 24
				//function db_insert($table, $vars) {
				// //
				//	foreach ($vars as $field => $value) {
				//		$fields[] = '`'.$field.'`';
				//		if ($value != 'NOW()') {
				//			$values[] = "'" . addslashes($value) . "'";
				//		} else {
				//			$values[] = $value;
				//		}
				//	}
				//
				//	$fieldList = implode(", ", $fields);
				//	$valueList = implode(", ", $values);
				//$sql="insert into $table ($fieldList) values ($valueList)";
				//	if(db_query( $sql))
				//	return mysqli_insert_id($conn);
				//	else return false;
				//}

				//today 31 jul 24
				//function db_update($table, $id, $vars, $tag='') {
				// //
				//	foreach ($vars as $field => $value) {
				//		$sets[] = "$field = '" . addslashes($value) . "'";
				//	}
				//
				//	$setList = implode(", ", $sets);
				//
				//	if($tag=='')
				//		$sql = "update $table set $setList where id= $id";
				//	else
				//		$sql = "update $table set $setList where $tag= $id";
				////echo $sql;
				//	//db_execute($conn,$sql);
				//	db_query( $sql);
				//}

				//today 31 jul 24
				//function db_delete($table,$condition) {
				// //	
				//	$sql = "delete from $table where $condition limit 1";
				//	return db_query( $sql);
				//}

				//today 31 jul 24
				//function db_delete_all($table,$condition) {
				// //	
				//	$sql = "delete from $table where $condition";
				//	return db_query( $sql);
				//}


				/*function find1($sql){
 if ($res=db_query($sql)){
		  while ($row=mysqli_fetch_row($res))
			{
			return ($row[0]);
			} 
		} else return NULL;
	}*/


				function find1($sql)
				{
					if ($res = db_query($sql)) {
						$row = mysqli_fetch_row($res);
						return ($row[0]);
					} else return NULL;
				}





				//function find_a_field($table,$field,$condition){
				// //    $sql="select $field from $table where $condition limit 1";
				//    $res=@db_query($sql);
				//    $count=@mysqli_num_rows($res);
				//    if($count>0)
				//    {
				//    $data=@mysqli_fetch_row($res);
				//    return $data[0];
				//    }
				//    else
				//    return NULL;
				//    }



				//today 31 jul 24
				//function find_a_field($table, $field, $condition) {
				//     //
				//    $sql = "SELECT $field FROM $table WHERE $condition LIMIT 1";
				//    $res = @db_query( $sql);
				//
				//    if (!$res) {
				//        // Log or display the error message
				//        error_log('Query failed: ' . mysqli_error($conn));
				//        return NULL;
				//    }
				//
				//    $count = @mysqli_num_rows($res);
				//    if ($count > 0) {
				//        $data = @mysqli_fetch_row($res);
				//        return $data[0];
				//    } else {
				//        return NULL;
				//    }
				//}





				//function find_all_field($table,$field,$condition){
				// //    $sql="select * from $table where $condition limit 1";
				//    $res=@db_query($sql);
				//    $count=@mysqli_num_rows($res);
				//    
				//    if($count>0)
				//        {
				//        $data=@mysqli_fetch_object($res);
				//        return $data;
				//        }
				//    else
				//        return NULL;
				//    }



				//today 31 jul 24
				//function find_all_field($table, $field, $condition) {
				//     //    // Check if $conn is defined
				//    if (!isset($conn)) {
				//        error_log("Database connection not established.");
				//        return NULL;
				//    }
				//
				//    $sql = "SELECT * FROM $table WHERE $condition LIMIT 1";
				//    $res = @db_query( $sql);
				//
				//    // Check if the query was successful
				//    if ($res === false) {
				//        // Log the error or handle it as needed
				//        error_log("Query failed: " . mysqli_error($conn));
				//        return NULL;
				//    }
				//
				//    $count = mysqli_num_rows($res);
				//    
				//    if ($count > 0) {
				//        $data = mysqli_fetch_object($res);
				//        return $data;
				//    } else {
				//        return NULL;
				//    }
				//}



				function findall($sql)
				{
					if ($res = db_query($sql)) {
						while ($data = mysqli_fetch_object($res)) {
							return $data;
						}
					}
				}

				function executeQuery($sql)
				{
					$query = db_query($sql);
					return $query->fetch_assoc();
				}

				function getScheduleRoute()
				{

					$dayNames = [
						1 => 'Saturday',
						2 => 'Sunday',
						3 => 'Monday',
						4 => 'Tuesday',
						5 => 'Wednesday',
						6 => 'Thursday',
						7 => 'Friday'
					];


					$weekName = date('l');
					$today = array_search($weekName, $dayNames);
					$query = "SELECT us.user_id, us.dayno, us.route_id AS schedule_route_id, ri.route_id AS route_id, ri.route_name 
            FROM 
                ss_schedule us
            JOIN 
                ss_route ri ON us.route_id = ri.route_id
            WHERE 
                us.dayno = '$today' 
                AND us.user_id = '" . $_SESSION['user']['username'] . "'
             ";

					return $route_name = executeQuery($query);
				}


				function getShopByRouteId($route_id)
				{
					// SQL query to fetch shops for a specific route
					$query = "
        SELECT 
            CONCAT(r.route_name, '-', s.shop_name) AS shop_name
        FROM 
            ss_shop s
        JOIN 
            ss_route r ON s.route_id = r.route_id
        WHERE 
            s.status = '1'
            AND s.emp_code = '" . $_SESSION['user']['username'] . "'
            AND s.route_id = '$route_id'
        ORDER BY 
            r.route_id, s.shop_name
    ";

					// Execute the query
					$result = db_query($query); // Replace with your database execution function

					// Fetch all rows into an array
					$shops = [];
					while ($row = mysqli_fetch_assoc($result)) {
						$shops[] = $row['shop_name']; // Collect shop names in an array
					}

					return $shops; // Return the array of shop names
				}





				function optionlist($sql)
				{
					$res = db_query($sql);
					while ($data = mysqli_fetch_row($res)) {
						$value = "";
						if ($value == $data[0])
							echo '<option value="' . $data[0] . '" selected>' . $data[1] . '</option>';
						else
							echo '<option value="' . $data[0] . '">' . $data[1] . '</option>';
					}
				}


				//today 31 jul 24
				//function foreign_relation($table,$id,$show,$value,$condition=''){
				//  //    
				//        if($condition=='')
				//        $sql="select $id,$show from $table";
				//        else
				//        $sql="select $id,$show from $table where $condition";
				//        //echo $sql;
				//        $res=db_query($sql);
				//        while($data=mysqli_fetch_row($res))
				//        {
				//        if($value==$data[0])
				//        echo '<option value="'.$data[0].'" selected>'.$data[1].'</option>';
				//        else
				//        echo '<option value="'.$data[0].'">'.$data[1].'</option>';
				//        }
				//}







				// -------------------------------------- Auto report
				function autoreport1($query)
				{
					$result = db_query($query);
					$table = '<table class="table table-striped"><tr>';
					for ($x = 0; $x < mysqli_num_fields($result); $x++) $table .= '<th>' . ucfirst(str_replace('_', ' ', mysqli_fetch_field_direct($result, $x)->name)) . '</th>';
					$table .= '</tr>';
					while ($rows = mysqli_fetch_assoc($result)) {
						$table .= '<tr>';
						foreach ($rows as $row) $table .= '<td>' . $row . '</td>';
						$table .= '</tr>';
					}
					$table .= '<table>';
					//mysql_data_seek($result,0); //if we need to reset the mysql result pointer to 0
					return $table;
				}









				function autoreport2($query, $report_name = '')
				{
					echo '<style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}
</style>';
					$result = db_query($query);
					$table = $report_name;
					$table .= '<table><tr>';
					for ($x = 0; $x < mysqli_num_fields($result); $x++) $table .= '<th>' . ucfirst(str_replace('_', ' ', mysqli_fetch_field_direct($result, $x)->name)) . '</th>';
					$table .= '</tr>';
					while ($rows = mysqli_fetch_assoc($result)) {
						$table .= '<tr>';
						foreach ($rows as $row) $table .= '<td>' . $row . '</td>';
						$table .= '</tr>';
					}
					$table .= '</table>';
					//mysql_data_seek($result,0); //if we need to reset the mysql result pointer to 0
					return $table;
				}









				function autoreport_crud($query, $report_name)
				{
					echo '<style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}
</style>';
					$result = db_query($query);
					$table = '<center><h2>' . $report_name . '<h2></center>';
					$table .= '<table><tr>';
					for ($x = 0; $x < mysqli_num_fields($result); $x++) $table .= '<th>' . ucfirst(str_replace('_', ' ', mysqli_fetch_field_direct($result, $x)->name)) . '</th>';

					$table .= '<th>Modify</th>';
					$table .= '</tr>';
					while ($rows = mysqli_fetch_assoc($result)) {
						$table .= '<tr>';
						foreach ($rows as $row) $table .= '<td>' . $row . '</td>';
						$table .= '<td>Edit || Delete' . $row . '</td>';

						$table .= '</tr>';
					}

					$table .= '<table>';
					//mysql_data_seek($result,0); //if we need to reset the mysql result pointer to 0
					return $table;
				}


				// --------------- INSERT
				function insert($table)
				{
					$result = db_query("SHOW COLUMNS FROM $table") or   die(mysql_error());
					$columns = array();
					while ($row = mysqli_fetch_array($result)) {
						$columns[] = $row[0];
					}

					$keys = array();
					$values = array();
					unset($columns[0]);
					foreach ($columns as $column) {

						$value = trim($_POST[$column]);
						//$value = validation($value);
						$keys[] = "`{$column}`";
						$values[] = "'{$value}'";
					}
					$query = "INSERT INTO $table (" . implode(',', $keys) . ") 
          VALUES (" . implode(',', $values) . ")";
					db_query($query);
					//echo $query;
				}
				// --------------- EXAMPLE
				/*if(isset($_POST['record'])){	
@insert('admin');
echo "New data insert successfully";
}*/


				// ------------------- UPDATE
				function update($table, $condition)
				{
					if ($condition != '') {
						//array_pop($_POST);
						foreach ($_POST as $field_name => $field_value) {
							$field_name = validation($field_name);
							$field_value = validation($field_value);
							$sql_str[] = "$field_name = '$field_value'";
						}

						$query = "UPDATE $table SET " . implode(',', $sql_str) . " WHERE $condition";
						db_query($query);
						//echo $query;

					}
				}
				//--example
				/*if(isset($_POST['update'])){	
@update('TableName');
echo "Update successfully";
}*/


				//today 31 jul 24
				//function auto_complete_from_db($table,$show,$id,$conn,$text_field_id){
				// //
				//if($con!='') $condition = " where ".$con;
				//$query="Select ".$id.", ".$show." from ".$table.$condition;
				//
				//$led=db_query( $query);
				//	if(mysqli_num_rows($led) > 0)
				//	{
				//		$ledger = '[';
				//		while($ledg = mysqli_fetch_row($led)){
				//		  $ledger .= '{ name: "'.$ledg[1].'", id: "'.$ledg[0].'" },';
				//		}
				//		$ledger = substr($ledger, 0, -1);
				//		$ledger .= ']';
				//	}
				//	else
				//	{
				//		$ledger = '[{ name: "empty", id: "" }]';
				//	}
				//
				//echo '<script type="text/javascript">
				//$(document).ready(function(){
				//    var data = '.$ledger.';
				//    $("#'.$text_field_id.'").autocomplete(data, {
				//		matchContains: true,
				//		minChars: 0,
				//		scroll: true,
				//		scrollHeight: 300,
				//        formatItem: function(row, i, max, term) {
				//            return row.name + " [" + row.id + "]";
				//		},
				//		formatResult: function(row) {
				//			return row.id;
				//		}
				//	});
				//  });
				//<script>';
				//}



				//today 31 jul 24
				//function auto_complete_from_db_sql($query,$text_field_id){
				// //
				//$led=db_query( $query);
				//	if(mysqli_num_rows($led) > 0)
				//	{
				//		$ledger = '[';
				//		while($ledg = mysqli_fetch_row($led)){
				//		  $ledger .= '{ name: "'.$ledg[1].'", id: "'.$ledg[0].'" },';
				//		}
				//		$ledger = substr($ledger, 0, -1);
				//		$ledger .= ']';
				//	}
				//	else
				//	{
				//		$ledger = '[{ name: "empty", id: "" }]';
				//	}
				//
				//echo '<script type="text/javascript">
				//$(document).ready(function(){
				//    var data = '.$ledger.';
				//    $("#'.$text_field_id.'").autocomplete(data, {
				//		matchContains: true,
				//		minChars: 0,
				//		scroll: true,
				//		scrollHeight: 300,
				//        formatItem: function(row, i, max, term) {
				//            return row.name + " [" + row.id + "]";
				//		},
				//		formatResult: function(row) {
				//			return row.id;
				//		}
				//	});
				//  });
				//<script>';
				//}



				//today 31 jul 24
				//function do_calander($field,$minDate='',$maxDate=''){
				// //$add ='';
				//if($minDate!='')
				//$add .= 'minDate: '.$minDate.', ';
				//if($maxDate!='')
				//$add .= 'maxDate: '.$maxDate.', ';
				//echo '<script type="text/javascript">
				//$(document).ready(function(){
				//	
				//	$(function() {
				//		$("'.$field.'").datepicker({
				//			changeMonth: true,
				//			changeYear: true,
				//			'.$add.'
				//			dateFormat: "yy-mm-dd"
				//		});
				//
				//	});
				//
				//});<script>';
				//}


				//today 31 jul 24
				function link_report_ss($sql, $link = '')
				{
					if ($sql == NULL) return NULL;
					$str .= '<div class="card card-style">
					<div class="content">
					<table class="table table-borderless text-center table-scroll table_new_border" style="overflow: hidden;">';
					$str .= '<thead><tr class="bg-night-light1">';
					$res = db_query($sql);
					$cols = mysqli_num_fields($res);
					for ($i = 1; $i < $cols; $i++) {
						$name = mysqli_fetch_field_direct($res, $i)->name;
						$str .= '<th scope="col" class="color-white">' . ucwords(str_replace('_', ' ', $name)) . '</th>';
					}
					$str .= '</tr></thead><tbody>';
					$c = 0;
					while ($row = mysqli_fetch_array($res)) {
						if ($link != '') $link = ' onclick="custom(' . $row[0] . ');"';
						$c++;
						if ($c % 2 == 0)	$class = ' class="alt"';
						else $class = '';

						$str .= '<tr' . $class . $link . '>';
						for ($i = 1; $i < $cols; $i++) {

							$str .= '<td style=" color: black; ">' . $row[$i] . "</td>";
						}
						$str .= '</tr>';
					}
					$str .= '</tbody></table></div></div>';
					return $str;
				}

				//today 31 jul 24
				//function link_report_del($sql,$link=''){
				// //echo '<style>
				//table {
				//    font-family: arial, sans-serif;
				//    border-collapse: collapse;
				//    width: 100%;
				//}
				//
				//td, th {
				//    border: 1px solid #dddddd;
				//    text-align: left;
				//    padding: 8px;
				//}
				//
				//tr:nth-child(even) {
				//    background-color: #dddddd;
				//}
				//</style>';
				//$str='';
				//	if($sql==NULL) return NULL;
				//		
				//		$res=db_query( $sql);
				//		$str = '<table><tr>';
				//    for ($x=0;$x<mysqli_num_fields($res);$x++) $str .= '<th>'.ucfirst(str_replace('_',' ',mysqli_fetch_field_direct($res,$x)->name)).'</th>';
				//	
				//	$str .= '<th>Modify</th>';
				//	$str .= '</tr>';
				//
				//		$c=0;
				//		while($row=mysqli_fetch_array($res))
				//			{ 
				//			if($link!='') $link= ' onclick="custom('.$row[0].');"';
				//				$c++;
				//				if($c%2==0)	$class=' class="alt"'; else $class=''; 
				//				$str .='<tr'.$class.$link.'>';
				//				for($i=0;$i<($x);$i++) {$str .='<td>&nbsp;'.$row[$i]."</td>"; }
				//				$str .='<td><a onClick="if(!confirm(\'Are You Sure Execute this?\')){return false;}" href="?del='.$row[0].'">&nbsp;X&nbsp;</a></td>';
				//				$str .='</tr>';
				//			}
				//	$str .='</table>';
				//	return $str;
				//
				//}


				//today 31 jul 24
				//function link_report_single($sql,$link=''){
				// //echo '<style>
				//table {
				//    font-family: arial, sans-serif;
				//    border-collapse: collapse;
				//    width: 100%;
				//}
				//
				//td, th {
				//    border: 1px solid #dddddd;
				//    text-align: left;
				//    padding: 8px;
				//}
				//
				//tr:nth-child(even) {
				//    background-color: #dddddd;
				//}
				//</style>';
				//$str=''; $total=''; $total_qty='';
				//	if($sql==NULL) return NULL;
				//		
				//		$res=db_query( $sql);
				//		$str = '<table><tr>';
				//    for ($x=0;$x<mysqli_num_fields($res);$x++) $str .= '<th>'.ucfirst(str_replace('_',' ',mysqli_fetch_field_direct($res,$x)->name)).'</th>';
				//
				//	$str .= '</tr>';
				//		$c=0;
				//		while($row=mysqli_fetch_array($res))
				//			{ 
				//			$total=$total+$row[5];
				//			$total_qty=$total_qty+$row[4];
				//			if($link!='') $link= ' onclick="custom('.$row[0].');"';
				//				$c++;
				//				if($c%2==0)	$class=' class="alt"'; else $class=''; 
				//				$str .='<tr'.$class.$link.'>';
				//				for($i=0;$i<$x;$i++) {$str .='<td>&nbsp;'.$row[$i]."</td>"; }
				//				$str .='</tr>';
				//			}
				//	$str .='<tr'.$class.$link.'>';
				//	$str .="<td colspan='".($x-2)."'><span style='text-align:right;'> Total: </span></td>";
				//	$str .="<td>".$total_qty."</td>";
				//	$str .="<td>".$total."</td>";
				//	$str .='</tr>';
				//	$str .='</table>';
				//	return $str;
				//}

				//today 31 jul 24
				function link_report_add_del_auto1($sql, $link = '', $sum_of1 = '', $sum_of2 = '', $sl = '')
				{
					if ($sql == NULL) return NULL;
					$str .= '<table class="table table-borderless text-center rounded-sm shadow-l" style="overflow: hidden;">';
					$str .= '<thead><tr class="bg-night-light">';
					$res = db_query($sql);
					$cols = mysqli_num_fields($res);
					$str .= '<th scope="col">S/L</th>';
					for ($i = 1; $i < $cols; $i++) {
						$name = mysqli_fetch_field_direct($res, $i)->name;
						$str .= '<th scope="col">' . ucwords(str_replace('_', ' ', $name)) . '</th>';
					}
					$str .= '</tr></thead> <tbody>';
					$c = 0;
					while ($row = mysqli_fetch_array($res)) {
						$total_qty = $total_qty + $row[$sum_of1 - 1];
						$total = $total + $row[$sum_of2 - 1];

						if ($link != '') $link = ' onclick="custom(' . $row[0] . ');"';
						$c++;
						if ($c % 2 == 0)	$class = ' class="alt"';
						else $class = '';
						$str .= '<tr' . $class . $link . '>';
						$str .= '<td>' . $c . '</td>';
						for ($i = 1; $i < ($cols - 1); $i++) {
							$str .= '<td>&nbsp;' . $row[$i] . "</td>";
						}
						$str .= '<td>
									<a href="?del=' . $row[0] . '" onclick="return confirm(\'Are you sure you want to delete this item?\');" class="btn btn-outline-danger">
											<i class="fa-solid fa-trash"></i>
									</a>
								</td>';
						$str .= '</tr>';
					}
					$str .= '<tr' . $class . $link . '>';
					if ($sum_of1 > 0)
						$str .= "<td colspan='" . ($sum_of1 - 1) . "'><span style='text-align:right;'> Total: </span></td>";
					if ($sum_of2 > 0) {
						$str .= "<td colspan='" . ($sum_of2 - $sum_of1) . "'>" . number_format($total_qty, 3) . "</td>";
						$str .= "<td colspan='" . ($cols - $sum_of1) . "'>" . number_format($total, 3) . "</td>";
					} else
						$str .= "<td colspan='" . ($cols - $sum_of1) . "'>" . number_format($total_qty, 3) . "</td>";
					$str .= '</tr>';
					$str .= '</tbody></table>';
					return $str;
				}

				//today 31 jul 24
				//function link_report_add_del($sql,$link=''){
				// //echo '<style>
				//table {
				//    font-family: arial, sans-serif;
				//    border-collapse: collapse;
				//    width: 100%;
				//}
				//
				//td, th {
				//    border: 1px solid #dddddd;
				//    text-align: left;
				//    padding: 8px;
				//}
				//
				//tr:nth-child(even) {
				//    background-color: #dddddd;
				//}
				//</style>';
				//$str=''; $total=''; $total_qty='';
				//	if($sql==NULL) return NULL;
				//		
				//		$res=db_query( $sql);
				//		$str = '<table><tr>';
				//    for ($x=0;$x<mysqli_num_fields($res);$x++) $str .= '<th>'.ucfirst(str_replace('_',' ',mysqli_fetch_field_direct($res,$x)->name)).'</th>';
				//	
				//	$str .= '<th>Modify</th>';
				//	$str .= '</tr>';
				//
				//		$c=0;
				//		while($row=mysqli_fetch_array($res))
				//			{ 
				//			$total=$total+$row[5];
				//			$total_qty=$total_qty+$row[4];
				//			if($link!='') $link= ' onclick="custom('.$row[0].');"';
				//				$c++;
				//				if($c%2==0)	$class=' class="alt"'; else $class=''; 
				//				$str .='<tr'.$class.$link.'>';
				//				for($i=0;$i<($x);$i++) {$str .='<td>&nbsp;'.$row[$i]."</td>"; }
				//				$str .='<td><a href="?del='.$row[0].'">&nbsp;X&nbsp;</a></td>';
				//				$str .='</tr>';
				//			}
				//	$str .='<tr'.$class.$link.'>';
				//	$str .="<td colspan='".($x-1)."'><span style='text-align:right;'> Total: </span></td>";
				//	$str .="<td>".$total_qty."</td>";
				//	$str .="<td>".$total."</td>";
				//	$str .='</tr>';
				//	$str .='</table>';
				//	return $str;
				//}




				function add_log($tr_date, $sr_no, $module_name, $access_detail, $user_id = '', $access_date = '', $access_time = '')
				{
					if ($access_date == '') $access_date = date('Y-m-d');
					if ($access_time == '') $access_time = date('Y-m-d H:s:i');
					if ($user_id == '') $user_id = $_SESSION['user']['username'];

					$journal = "INSERT IGNORE INTO ss_user_log ( user_id, access_date, access_time, module_name,tr_date,sr_no, access_detail
)VALUES(
'$user_id', '$access_date', '$access_time', '$module_name', '$tr_date', '$sr_no', '$access_detail'
)";

					$query_journal = db_query($journal);
				}



				function sms_bulksmsbd($number, $text)
				{

					$sms_info = findall("select mobile_no,password from setup_sms_api where id=1");

					$url = "http://66.45.237.70/api.php";
					//$number="88017,88018,88019";
					$data = array(
						'username' => $sms_info->mobile_no,
						'password' => $sms_info->password,
						'number' => "$number",
						'message' => "$text"
					);

					$ch = curl_init(); // Initialize cURL
					curl_setopt($ch, CURLOPT_URL, $url);
					curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					$smsresult = curl_exec($ch);
					$p = explode("|", $smsresult);
					$sendstatus = $p[0];
					//echo 'status = '.$smsresult;
					// echo '<br>'.$number;
					// echo '<br>'.$text;
				}




				// -------------- ecom code


				function pr($arr)
				{
					echo '<pre>';
					print_r($arr);
				}

				function prx($arr)
				{
					echo '<pre>';
					print_r($arr);
					die();
				}

				function get_safe_value($conn, $str)
				{
					if ($str != '') {
						$str = trim($str);
						return mysqli_real_escape_string($conn, $str);
					}
				}










				function autocomplete_new($sql, $id)
				{
					$under_ledger = '[';

					$a1	=	db_query($sql);
					while ($a = mysqli_fetch_row($a1)) {

						$under_ledger .= '{ value: "' . $a[0] . '>>>' . $a[1] . '",  label: "' . $a[0] . '>>>' . $a[1] . '"},';
					}
					$under_ledger  = substr($under_ledger, 0, -1);
					$under_ledger .= ']';

					echo '<script type="text/javascript">

var data = ' . $under_ledger . ';

$(function() {
$("#' . $id . '").autocomplete({
		source:data, 
		matchContains: false,
		minChars: 0,
		minLength:0,
		scroll: true,
		scrollHeight: 40
	}).bind("focus", function(){ $(this).autocomplete("search"); });

});

</script>';
				}







				//////////////This function for Selected and search//////////////
				//    function selected_two($data) {
				//        echo '<script language="javascript">
				//          $("'.$data.'").select2({
				//              placeholder: "Select",
				//              allowClear: true
				//          });<script>';
				//    }

				// function
				function getCustomerOfferItem($salesAmount)
				{
					@include "db.php";

					$f_date = $_POST['f_date'];

					$sql_slab = "SELECT gift_offer FROM ss_gift_offer_monthly2 WHERE $salesAmount >= min_qty AND $salesAmount <= max_qty and start_date='" . $f_date . "' order by min_qty";
					$result = mysqli_query($conn, $sql_slab);

					while ($row = mysqli_fetch_object($result)) {
						$offerItem = $row->gift_offer;
					}

					return $offerItem;
				}




				function haversineDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo)
				{
					$earthRadius = 6371000; // Radius of the earth in meters
					$latFrom = deg2rad((float) $latitudeFrom);
					$lonFrom = deg2rad((float) $longitudeFrom);
					$latTo = deg2rad((float) $latitudeTo);
					$lonTo = deg2rad((float) $longitudeTo);

					$latDelta = $latTo - $latFrom;
					$lonDelta = $lonTo - $lonFrom;

					$a = pow(sin($latDelta / 2), 2) +
						cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2);
					$c = 2 * asin(sqrt($a));

					return $earthRadius * $c;
				}





// end function
