<?php

function next_value($field, $table, $diff = 1, $initiate = 100001, $btw1 = '', $btw2 = '') {
    if ($btw1 > 0) {
          $sql = "SELECT MAX(" . $field . ") FROM " . $table . " WHERE " . $field . " BETWEEN '" . $btw1 . "' AND '" . $btw2 . "'";
    } else {
          $sql = "SELECT MAX(" . $field . ") FROM " . $table;
    }

    $query = mysqli_fetch_row(db_query($sql));
	
	 $query[0];
    $value = $query[0] + $diff;
    if ($query[0] == 0) {
         $value = $initiate;
    }
      return $value;
}

function js_ledger_subledger_autocomplete($ledger_type, $proj_id) {
    $balance_type = "";
    if ($ledger_type == 'receipt') {
        $balance_type = "balance_type IN ('Credit','Both') AND";
    }
    if ($ledger_type == 'payment') {
        $balance_type = "balance_type IN ('Debit','Both') AND";
    }
    if ($ledger_type == 'journal' || $ledger_type == 'contra') {
        $balance_type = "";
    }
    echo '<script type="text/javascript">';
    echo ' var sub_ledgers = [';
    $a2 = "SELECT 
                ledger_id, 
                ledger_name 
            FROM 
                accounts_ledger 
            WHERE 
                " . $balance_type . "
                proj_id='$proj_id'
            ORDER BY 
                ledger_name";
    $a1 = db_query($a2);
    $i = 0;
    while ($a = mysqli_fetch_row($a1)) {
        if ($i == 0) {
            echo "'" . $a[1] . "'";
        } else {
            echo ", '" . $a[1] . "'";
        }

        $b2 = "SELECT 
                    sub_ledger_id,
                    sub_ledger 
                FROM 
                    sub_ledger 
                WHERE 
                    ledger_id='$a[0]'";
        $b1 = db_query($b2);
        $c = mysqli_num_rows($b1);

        if ($c > 0) {
            while ($b = mysqli_fetch_row($b1)) {
                echo ", '" . $a[1] . "::" . $b[1] . "'";
            }
        }
        $i++;
    }
    echo ' ]; </script>';
}

function prevent_multi_submit($excl = "validator") {
    $string = "";
    foreach ($_POST as $key => $val) {
        if ($key != $excl) {
            $string .= $val;
        }
    }
    if (isset($_SESSION['last'])) {
        if ($_SESSION['last'] === auth_encode($string)) {
            return false;
        } else {
            $_SESSION['last'] = auth_encode($string);
            return true;
        }
    } else {
        $_SESSION['last'] = auth_encode($string);
        return true;
    }
}

function notification($msg, $type) {
    echo '<table width="350" height="32" border="0" align="center" cellpadding="5"  class="view' . $type . '">
		<tr>
			<td width="56" align="center"><img src="icon/' . $type . '.png" width="32" height="32" /></td>
			<td width="344">' . $msg . '</td>
		</tr>
	</table>';
}

function date_value($date) {
    $j = 0;
    for ($i = 0; $i < strlen($date); $i++) {
        if (is_numeric($date[$i])) {
            $time[$j] = $time[$j] . $date[$i];
        } else {
            $j++;
        }
    }
    $time = mktime(0, 0, 0, $time[1], $time[0], $time[2]);
     $time;
}

function Date2age($d) {
    $ts = time() - strtotime(str_replace("-", "/", $d));
    if ((strtotime(str_replace("-", "/", $d))) < 1000) {
        return 'NA';
    }
    $val = '';
    if ($ts > 31536000) {
        $val .= floor($ts / 31536000) . ' year ';
    }
    if ($ts > 31536000) {
        $ts = $ts % 31536000;
    }
    if ($ts > 2419200) {
        $val .= floor($ts / 2592000) . ' month';
    }
     $val;
}

function image_upload($path, $file) {
    $root = $path . '/' . $_SESSION['employee_selected'] . '.jpg';
    move_uploaded_file($file['tmp_name'], $root);
     $root;
}

function image_upload_on_id($path, $file, $id) {
    $root = $path . '/' . $id . '.jpg';
    move_uploaded_file($file['tmp_name'], $root);
     $root;
}

function mysqli_format2array($date) {
    $j = 0;
    for ($i = 0; $i < strlen($date); $i++) {
        if (is_numeric($date[$i])) {
            $time[$j] = $time[$j] . $date[$i];
        } else {
            $j++;
        }
    }
     $time;
}

function mysqli_format2stamp($date) {
    $j = 0;
    for ($i = 0; $i < strlen($date); $i++) {
        if (is_numeric($date[$i])) {
            $time[$j] = $time[$j] . $date[$i];
        } else {
            $j++;
        }
    }
    $time = mktime(0, 0, 0, $time[1], $time[2], $time[0]);
     $time;
}

function date_2_date_diff($date1, $date2, $diff = '') {
    $str1 = strtotime($date1);
    $str2 = strtotime($date2);
	$difference= '';

    if ($diff < 2) {
         $difference = ($str2 - $str1);
    } elseif ($diff < 3) {
         $difference = (int)(($str2 - $str1) / 60) + 1;
    } elseif ($diff < 4) {
         $difference = (int)(($str2 - $str1) / 3600) + 1;
    } elseif ($diff < 5) {
         $difference = (int)(($str2 - $str1) / 86400) + 1;
    } elseif ($diff < 6) {
         $difference = (int)(($str2 - $str1) / 2592000) + 1;
    } elseif ($diff < 7) {
         $difference = (int)(($str2 - $str1) / 31536000) + 1;
    } else {
        return NULL;
    }
	return $difference;
}

function date_2_date_add_mon_duration($date, $duration = '') {
    $j = 0;
    for ($i = 0; $i < strlen($date); $i++) {
        if (is_numeric($date[$i])) {
            $time[$j] = $time[$j] . $date[$i];
        } else {
            $j++;
        }
    }
    $stamp_time = mktime(0, 0, 0, ($time[1] + $duration), $time[2], $time[0]);
    $time = date('Y-m-d', $stamp_time);
     $time;
}

function date_2_stamp_add_mon_duration($date, $duration = '') {
    $j = 0;
    for ($i = 0; $i < strlen($date); $i++) {
        if (is_numeric($date[$i])) {
            $time[$j] = $time[$j] . $date[$i];
        } else {
            $j++;
        }
    }
    $stamp_time = mktime(0, 0, 0, ($time[1] + $duration), $time[2], $time[0]);
     $stamp_time;
}



///////////////Report function/////////////////
function link_report1($sql,$link=''){
if($sql==NULL) return NULL;
$str.='
<table id="grp" class="table1  table-striped table-bordered table-hover table-sm"  >';
$str .='<thead class="thead1"><tr class="bgc-info">';
$res=db_query($sql);
$cols = mysqli_num_fields($res);
for($i=1;$i<$cols;$i++)
{
$fieldinfo = mysqli_fetch_field_direct($res,$i);
$name = $coloum[$i] =$fieldinfo -> name;
$str .='<th>'.ucwords(str_replace('_', ' ',$name)).'</th>';
}
$str .='</tr></thead>';
$c=0;
$str .='<tbody class="tbody1">';
while($row=mysqli_fetch_array($res))
{ if($link!='') $link= ' onclick="DoNav('.$row[0].');"';
$c++;
if($c%2==0)	$class=' class="alt"'; else $class=''; 
$str .='<tr'.$class.$link.'>';
for($i=1;$i<$cols;$i++) {$str .='<td>'.$row[$i]."</td>";}
$str .='</tr>';
}
$str .='</tbody></table>';
return $str;
}

////////////////////////////


//////////////This function for Selected and search//////////////
    function selected_two($data) {
        echo '<script language="javascript">
          $("'.$data.'").select2({
              placeholder: "Selected",
              allowClear: true
          });</script>';
    }


    function datatable_esourcing($data) {
        echo '<script>
    $(document).ready(function() {
        // DataTable initialization
        var table = $("'.$data.'").DataTable({
            responsive: true,
            searching: true,
            dom: "Blfrtip",
            buttons: [
                "copy", "excel", "csv", "print", "colvis"
            ],
            lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
            pageLength: 10,
            language: {
                info: "Showing _START_ to _END_ of _TOTAL_ entries"
            }
        });
    
        // Apply the search for each column
        $("'.$data.' thead tr:eq(1) th").each(function (i) {
            $("input", this).on("keyup change", function () {
                if (table.column(i).search() !== this.value) {
                    table
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        });
    
        // Optional: Check if DataTable is initialized correctly
        console.log("DataTable initialized:", $.fn.dataTable.isDataTable("'.$data.'"));
    });
    </script>';
    }







//////////////This function for Module Acess new function//////////////
function find_module_id() {
    // Get current URL
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $host = $_SERVER['HTTP_HOST'];
    $request_uri = $_SERVER['REQUEST_URI'];
    $current_url = $protocol . $host . $request_uri;

    // Parse the URL to get the path and query string
    $parsed_url = parse_url($current_url);
    $filename = basename($parsed_url['path']); // Extracts the file name
    $query_string = isset($parsed_url['query']) ? '?' . $parsed_url['query'] : ''; // Extracts the query string
    $filename_page = $filename . $query_string; // Full file name like 'credit_note.php?new=2'

    // Use regex to get the part after /views/ and before the next /
    if (preg_match('/\/views\/([^\/]+)\//', $parsed_url['path'], $module_file_name)) {
        $module_file = $module_file_name[1]; // The part after /views/
    } 
	
	if (preg_match('/\/views\/([^\/]+)\/([^\/]+)\//', $parsed_url['path'], $module_folder_name)) {
    	$module_folder = $module_folder_name[2]; // The part after /views/ and before the next /
	}

    // Get the module ID
    $module_id = find_a_field('user_module_manage', 'id', 'module_file="' . $module_file . '"');
    // Return module_id if found, otherwise return 0
    return !empty($module_id) ? $module_id : 0;
}




//////////////This function for Page Acess new function//////////////
function checkPageAccess() {
    // Get current URL
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $host = $_SERVER['HTTP_HOST'];
    $request_uri = $_SERVER['REQUEST_URI'];
    $current_url = $protocol . $host . $request_uri;

    // Parse the URL to get the path and query string
    $parsed_url = parse_url($current_url);
    $filename = basename($parsed_url['path']); // Extracts the file name
    $query_string = isset($parsed_url['query']) ? '?' . $parsed_url['query'] : ''; // Extracts the query string
    $filename_page = $filename . $query_string; // Full file name like 'credit_note.php?new=2'

    // Use regex to get the part after /views/ and before the next /
    if (preg_match('/\/views\/([^\/]+)\//', $parsed_url['path'], $module_file_name)) {
        $module_file = $module_file_name[1]; // The part after /views/
    } 
	
	if (preg_match('/\/views\/([^\/]+)\/([^\/]+)\//', $parsed_url['path'], $module_folder_name)) {
    	$module_folder = $module_folder_name[2]; // The part after /views/ and before the next /
	}
	
    // Get the module ID
    $module_id = find_a_field('user_module_manage', 'id', 'module_file="' . $module_file . '"');
    $page_verify = find_a_field('user_page_manage', 'status', 'page_link="' . $filename . '"');
	
    // Build the query to check user's access
    $acc_locker = 'SELECT u.user_id, u.page_id, u.access, p.page_link, p.status, p.feature_id, d.module_id, d.status 
                   FROM user_roll_activity u, user_module_manage m, user_module_define d, user_feature_manage f, user_page_manage p 
                   WHERE u.user_id =' . $_SESSION['user']['id'] . ' 
                   AND d.user_id = u.user_id
                   AND p.page_link like "%' . $filename . '%" 
				   AND p.folder_name = "'.$module_folder.'"
                   AND u.page_id = p.id 
                   AND p.feature_id = f.id 
                   AND f.module_id = m.id 
                   AND d.module_id = m.id 
                   AND p.status = "Yes" 
                   AND d.status = "enable" 
                   AND m.id = ' . $module_id;

    // Execute the query
    $acc_query = db_query($acc_locker);
    $accinfo = mysqli_fetch_object($acc_query);

    // Check access and return the access value
	 $accinfo->access;
     //return $accinfo->access;
	 return !empty($accinfo->access) ? $accinfo->access : 0;

}


//this function is page verify for other pages 
function OtherPageAccess() {
    // Get current URL
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://" ;
    $host = $_SERVER['HTTP_HOST'];
    $request_uri = $_SERVER['REQUEST_URI'];
    $current_url = $protocol . $host . $request_uri;

    // Parse the URL to get the path and query string
    $parsed_url = parse_url($current_url);
    $filename = basename($parsed_url['path']); // Extracts the file name
	
	if (preg_match('/\/views\/([^\/]+)\/([^\/]+)\//', $parsed_url['path'], $page_folder_name)) {
    	$page_folder = $page_folder_name[2]; // The part after /views/ and before the next /
	}
    // Get the module ID or status
    $page_verify = find_a_field('user_page_manage', 'status', 'folder_name="'.$page_folder.'" and page_link LIKE "%'.$filename.'%"');
		
	// Return 1 if $page_verify is 'yes', otherwise return 0
	return (!empty($page_verify) && strtolower($page_verify) === "yes") ? 1 : 0;
}

?>