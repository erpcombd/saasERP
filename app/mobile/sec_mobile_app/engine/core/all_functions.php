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
    function selected_two($data,$data2) {
        echo '<script language="javascript">
          $("'.$data.'").select2({
              placeholder: "'.$data2.'",
              allowClear: true
          });</script>';
    }
	
	
	
?>
