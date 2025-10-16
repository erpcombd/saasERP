<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

date_default_timezone_set('Asia/Dhaka');



if(!is_file('cs-sl.txt')) $cs_sl = 100;
else $cs_sl = file_get_contents('cs-sl.txt');
$cs_sl++;

for($i=0; $i<20; $i++){
if(is_file("cs-name-$cs_sl.txt")) $cs_sl++;
if(is_file("cs-types-$cs_sl.txt")) $cs_sl++;
}

if(!empty($_POST['cs_name'])){
    
    if(!empty($_REQUEST['itemupdate'])) $cs_sl = $_REQUEST['cs_no'];
    
    if(empty($_POST['cs_company'])) die();
    file_put_contents("cs-name-$cs_sl.txt","$_POST[cs_name]||$_POST[cs_company]||$_POST[cs_qty]||$_POST[cs_unit]||");
    file_put_contents("cs-sl.txt",$cs_sl);
    
    if(empty($_REQUEST['itemupdate']))
    echo "<script>location.href='?cs_no=$cs_sl&vendoradd=1';</script>";
}


if(empty($_REQUEST['cs_no'])){
    
    echo "<form method=post>
    Company:<br><select name=cs_company><option>AMI Industries (Pvt.) Ltd.</option><option>Sonargaon Steel Ltd.</option><option>Diamond Steel Products Company (Pvt.) Ltd.</option><option>Rahim Energy Ltd.</option><option>Carbon Bangladesh Ltd.</option><option>Rahim Super Extreme Ltd.</option><option>Ferro Alloy Co. (Pvt.) Ltd.</option></select><br><br>
    
    Item Name:<br><input name=cs_name required id=cs_name ><br><br>
    
    Quantity:<br><input name=cs_qty required type=number ><br><br>
    
    Unit:<br><input name=cs_unit required ><br><br>
    
    <script>cs_name.focus();</script>
    
    <input type=submit value='Create New'></form>";
    
    if(is_file("cs-name-101.txt")){
    
    echo "<h2>Or Select existing CS from below:</h2><hr>
    
    <form action='?'>
    <input name=cs_no placeholder='CS No' required>
    <input type=hidden name=dataupdate value=1>
    <input type=hidden name=preview value=1>
    <input type=submit value=Search >
    </form>
    
    <table border=1 cellspacing=0 cellpadding=7 >
    <tr><th>View CS</th><th>Add Row</th><th>Add Vendor</th><th>Edit Data</th></tr>";

    $file_list = opendir('.');
    $cs_all = [];
    
    while($fileN = readdir($file_list))
    $cs_all[] = $fileN;
    
    rsort($cs_all);
    
    foreach($cs_all as $fileN)
    {
        $e = explode('cs-name-',$fileN);
        if(!empty($e[1])){
            $e = explode('.txt',$e[1]);
            echo "<tr><td>CS Number: <a href='?cs_no=$e[0]&dataupdate=1&preview=1'>$e[0]</a></td><td align=center><a href='?cs_no=$e[0]&rowadd=1'>Add</a></td><td align=center><a href='?cs_no=$e[0]&vendoradd=1'>Add</a></td><td align=center><a href='?cs_no=$e[0]&dataupdate=1'>Edit</a></td></tr>";
        }
    }
    
    closedir($file_list);
    
    echo "</table>
    <script>
    const style = document.createElement('style');
    style.innerHTML = 'tr:hover { background-color: yellow; }';
    document.head.appendChild(style);
    </script>
    ";
    
    }
    
}else{
    
    
    
    $savebtn = '';
    if(empty($_GET['preview']) AND !empty($_GET['dataupdate'])) $savebtn = "<input type=submit value=Save name=savecs> | ";
    
    $bmenu = "<div class='no-print'>
        $savebtn
        <a href='?'>CS List</a> | 
        <a href='?cs_no=$_REQUEST[cs_no]&itemupdate=1'>Edit Qty</a> | 
        <a href='?cs_no=$_REQUEST[cs_no]&vendoradd=1'>Add Vendor</a> | 
        <a href='?cs_no=$_REQUEST[cs_no]&rowadd=1'>Add Row</a> | 
        <a href='?cs_no=$_REQUEST[cs_no]&dataupdate=1'>Edit CS Data</a> | 
        <a href='?cs_no=$_REQUEST[cs_no]&dataupdate=1&preview=1'>Preview CS Data</a> | 
        <a href='?cs_no=$_REQUEST[cs_no]&history=1'>History</a> | 
        <a href='#' onclick='window.print();'>Print</a> |
		<a href='/app/views/auth/masters/home.php'>Back to ERP</a>
        </div>";
    

    if(!empty($_POST['type'])) file_put_contents("cs-types-$_REQUEST[cs_no].txt","$_POST[type]\n",FILE_APPEND);
    
    if(!empty($_POST['vendor'])) file_put_contents("cs-vendors-$_REQUEST[cs_no].txt","$_POST[vendor]\n",FILE_APPEND);
    
    
    $cs_name = '';
    $cs_company = '';
    
    if(is_file("cs-name-$_REQUEST[cs_no].txt")){
        $cs_title = explode('||',file_get_contents("cs-name-$_REQUEST[cs_no].txt"));
        
        $cs_name = $cs_title[0];
        $cs_company = $cs_title[1];
        $cs_qty = 0;
        $cs_unit = '';
        if(!empty($cs_title[2])) $cs_qty = $cs_title[2];
        if(!empty($cs_title[3])) $cs_unit = $cs_title[3];
        
        if(!empty($cs_title[3])) $cs_name = "$cs_name ($cs_qty $cs_unit)";
        
    }
    
    
    
    
    
    if(!empty($_POST['savecs'])){
        
        $data_cs_write = '';
        foreach($_POST['data'] as $dataN=>$dataV){
            $dataV = rtrim($dataV);
            if(empty($dataV)) continue;
            $data_cs_write .= "[data-$dataN]$dataV"."[data-$dataN]";
        }
        file_put_contents("cs-data-$_REQUEST[cs_no].txt",$data_cs_write);
        
        $data_Vwrite = '';
        foreach($_POST['vendorX'] as $dataV){
            $dataV = rtrim($dataV);
            if(empty($dataV)) continue;
            $data_Vwrite .= "$dataV\n";
        }
        file_put_contents("cs-vendors-$_REQUEST[cs_no].txt",$data_Vwrite);
        
        $data_Twrite = '';
        foreach($_POST['typeX'] as $dataV){
            $dataV = rtrim($dataV);
            if(empty($dataV)) continue;
            $data_Twrite .= "$dataV\n";
        }
        file_put_contents("cs-types-$_REQUEST[cs_no].txt",$data_Twrite);
        
        file_put_contents("cs-extra-$_REQUEST[cs_no].txt","$_POST[preparedby]||$_POST[checkedby]||$_POST[approvedby]||$_POST[remark]||$_POST[note]||");
        
        
        // history
        
        $cs_xname = $cs_name;
        if(!empty($cs_unit)) $cs_xname = str_replace(" ($cs_qty $cs_unit)","",$cs_name);
        
        $data_file = "cs-history-$_REQUEST[cs_no]-".time().".txt";
        
        $data_history = "||$cs_company||$cs_xname||$cs_qty||$cs_unit||$data_Vwrite||$data_Twrite||$data_cs_write||$_POST[remark]||$_POST[note]||$_POST[preparedby]||$_POST[checkedby]||$_POST[approvedby]||";
        
        // generate md5
        
        // check last md5
        
        // than save
        
        
        file_put_contents($data_file,$data_history);
        
        
        
        
    }
    
    
    if(!empty($_REQUEST['history'])){
        
        $file_list = opendir('.');
        $cs_all = [];
        
        while($fileN = readdir($file_list))
        $cs_all[] = $fileN;
        
        rsort($cs_all);
        
        foreach($cs_all as $fileN)
        {
            $e = explode("cs-history-$_REQUEST[cs_no]-",$fileN);
            if(!empty($e[1])){
                $e = explode('.txt',$e[1]);
                $d = date('Y-m-d H:i',$e[0]);
                echo "Saved version on: <a href='?cs_no=$_REQUEST[cs_no]&version=$e[0]'>$d</a><hr>";
            }
        }
        
        closedir($file_list);
        
        echo "<hr>$bmenu<hr>";

    }
    
    
    if(!empty($_REQUEST['rowadd'])){
        
        echo "<h2>$cs_company</h2>
        <p>CS Number: $_REQUEST[cs_no]<br>Item Name: $cs_name</p>
        <form method=post>Items Description: <input type=hidden name=cs_no value='$_REQUEST[cs_no]'>
        <input name=type required id=type>
        <script>type.focus();</script>
        <input type=submit value=Add >
        <hr>
        
        $bmenu
        
        <hr>
        </form>";
        
        if(is_file("cs-types-$_REQUEST[cs_no].txt"))
        echo "<pre><b>Row Description Names:</b><br>".file_get_contents("cs-types-$_REQUEST[cs_no].txt")."</pre><hr>";

    }
    
    
    if(!empty($_REQUEST['vendoradd'])){
        
        echo "<h2>$cs_company</h2>
        <p>CS Number: $_REQUEST[cs_no]<br>Item Name: $cs_name</p>
        <form method=post>Enter CS Vendor Name: <input type=hidden name=cs_no value='$_REQUEST[cs_no]'>";
		
		?>
<!--		<input name=vendor required id=vendor>  -->		

			<select name='vendor' id='vendor'>
				 <option></option>
				<? foreign_relation('vendor','vendor_name','vendor_name',$vendor,'1');?>
			</select>

		<?
        echo "<script>vendor.focus();</script>
    
        <input type=submit value=Add > 
        <hr>
        
        $bmenu
        
        <hr>
        </form>";
        
        if(is_file("cs-vendors-$_REQUEST[cs_no].txt"))
        echo "<pre><b>CS Vendors:</b><br>".file_get_contents("cs-vendors-$_REQUEST[cs_no].txt")."</pre><hr>";
        
    }
    
    
    if(!empty($_REQUEST['itemupdate'])){
        
        $cs_xname = $cs_name;
        if(!empty($cs_unit)) $cs_xname = str_replace(" ($cs_qty $cs_unit)","",$cs_name);
        
        echo "<h2>$cs_company</h2>
        <p>CS Number: $_REQUEST[cs_no]</p>
        <form method=post>
        
        <input type=hidden name=cs_no value='$_REQUEST[cs_no]'>
        
        Company:<br><input name=cs_company required value='$cs_company' ><br><br>
        
        Item Name:<br><input name=cs_name required id=cs_name value='$cs_xname' ><br><br>
    
        Quantity:<br><input name=cs_qty required type=number value='$cs_qty' ><br><br>
        
        Unit:<br><input name=cs_unit required value='$cs_unit' ><br><br>
        
        <script>cs_name.focus();</script>
        
        <input type=submit value=Update name=itemupdate > 
        
        <hr>
        
        $bmenu
        
        <hr>
        </form>";
        
        
    }
    
    
    if(!empty($_REQUEST['dataupdate'])){
        
        if(!is_file("cs-types-$_REQUEST[cs_no].txt")) die('input Row items');
        if(!is_file("cs-vendors-$_REQUEST[cs_no].txt")) die('input vendors');
        
        $types = explode("\n",file_get_contents("cs-types-$_REQUEST[cs_no].txt"));
        $vendors = explode("\n",file_get_contents("cs-vendors-$_REQUEST[cs_no].txt"));
        
        echo "<br><br><form method=post autocomplete=off>
        <center>
        <h2 style='margin-bottom:-20px'>$cs_company</h2>
        <h4>29/10, K. M. Das Lane Tikatuly, Dhaka, Bangladesh – 1203</h4>
        <h3>Comparison Statement for $cs_name</h3>
        </center>
        
        <table width=100%><tr><td>CS Number: $_REQUEST[cs_no]</td><td align=right>Date: ".date('d/m/Y')."</td></tr></table>
        
        
        <table width=100% border=1 cellspacing=0>
        <tr><td rowspan=2><b>Sl</b></td><td rowspan=2><b>Item Description</b></td><td colspan=".(count($vendors)-1)." align=center ><b>Suppliers Name/Vendor Name</b></td>
        
        
        
        <tr>";
        foreach($vendors as $vendor){
        $vendor = rtrim($vendor);
        if(empty($vendor)) continue;
        
        if(!empty($_REQUEST['preview']))
        echo "<td align=center><b>$vendor</b></td>";
        else echo "<td align=center><input name='vendorX[]' value='$vendor' style='width: 100%;'></td>";
        
        }
        
        echo "</tr>";
        
        
        // default desc 1

        if(empty($sl)) $sl = 1;
        else $sl++;
        
        echo "<tr><td><b>$sl</b></td><td><b>Unit Price BDT per $cs_unit</b></td>";

        $data = '';
        if(is_file("cs-data-$_REQUEST[cs_no].txt"))
        $data = file_get_contents("cs-data-$_REQUEST[cs_no].txt");
        
        for($i=0; $i<count($vendors)-1; $i++){
            $ivalue = '';
            $dataX = [];
            if(!empty($data)){
                $dataX = explode("[data-".$sl."_".($i+1)."]",$data);
                if(!empty($dataX[1])) $ivalue = $dataX[1];
            }
            
            if(!empty($_REQUEST['preview']))
            echo "<td>$ivalue</td>";
            
            else echo "<td><input onchange=\"\" onkeyup=\" var ccc = (this.value*$cs_qty).toFixed(2); ccc = parseFloat(ccc).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 }); data_2_".($i+1).".value=ccc; \" name='data[".$sl."_".($i+1)."]' value='$ivalue' style='width: 100%;'></td>";
        }
        
        echo "</tr>";
        
        
        // default desc 2

        if(empty($sl)) $sl = 1;
        else $sl++;
        
        echo "<tr><td><b>$sl</b></td><td><b>Total Price BDT ($cs_qty $cs_unit)</b></td>";

        $data = '';
        if(is_file("cs-data-$_REQUEST[cs_no].txt"))
        $data = file_get_contents("cs-data-$_REQUEST[cs_no].txt");
        
        for($i=0; $i<count($vendors)-1; $i++){
            $ivalue = '';
            $dataX = [];
            if(!empty($data)){
                $dataX = explode("[data-".$sl."_".($i+1)."]",$data);
                if(!empty($dataX[1])) $ivalue = $dataX[1];
            }
            
            if(!empty($_REQUEST['preview']))
            echo "<td>$ivalue</td>";
            else echo "<td><input id='data_".$sl."_".($i+1)."' name='data[".$sl."_".($i+1)."]' value='$ivalue' style='width: 100%;'></td>";
        }
        
        echo "</tr>";
        
        
        foreach($types as $type){
        $type = rtrim($type);
        if(empty($type)) continue;
        
        if(empty($sl)) $sl = 1;
        else $sl++;
        
        if(!empty($_REQUEST['preview']))
        echo "<tr><td><b>$sl</b></td><td><b>$type</b></td>";
        else
        echo "<tr><td><b>$sl</b></td><td><input name='typeX[]' value='$type' style='width: 100%;'></td>";
        
        $data = '';
        if(is_file("cs-data-$_REQUEST[cs_no].txt"))
        $data = file_get_contents("cs-data-$_REQUEST[cs_no].txt");
        
        for($i=0; $i<count($vendors)-1; $i++){
            $ivalue = '';
            $dataX = [];
            if(!empty($data)){
                $dataX = explode("[data-".$sl."_".($i+1)."]",$data);
                if(!empty($dataX[1])) $ivalue = $dataX[1];
            }
            
            if(!empty($_REQUEST['preview']))
            echo "<td>$ivalue</td>";
            else echo "<td><input name='data[".$sl."_".($i+1)."]' value='$ivalue' style='width: 100%;'></td>";
        }
        
        echo "</tr>";
        }
        
        echo "</table><br>";
        
        $extradata[0] = '';
        $extradata[1] = '';
        $extradata[2] = '';
        $extradata[3] = '';
        $extradata[4] = '';
        
        if(is_file("cs-extra-$_REQUEST[cs_no].txt"))
        $extradata = explode('||',file_get_contents("cs-extra-$_REQUEST[cs_no].txt"));
        
        
        if(!empty($_REQUEST['preview'])){
        
        $pre_value = "<div style='margin-bottom: -30px;'>$extradata[0]</div>";
        $chk_value = "<div style='margin-bottom: -30px;'>$extradata[1]</div>";
        $appr_value = "<div style='margin-bottom: -30px;'>$extradata[2]</div>";
        
        $remark_value = "Remarks: $extradata[3]";
        $note_value = "Recommendation: $extradata[4]";
        
        if(empty($extradata[3])) $remark_value = '';
        if(empty($extradata[4])) $note_value = '';
        
        }else{
        
        $pre_value = "<input name=preparedby value='$extradata[0]' style='text-align:center;'>";
        $chk_value = "<input name=checkedby value='$extradata[1]' style='text-align:center;'>";
        $appr_value = "<input name=approvedby value='$extradata[2]' style='text-align:center;'>";
        $remark_value = "Remarks:</td><td><input name=remark value='$extradata[3]' style='width:100%'>";
        $note_value = "Recommendation:</td><td><input name=note value='$extradata[4]' style='width:100%'>";
        
        }
        
        
        
        echo "
        
        <table width='100%'>
        <tr><td width='150px'>$remark_value</td></tr>
        <tr><td width='150px'>$note_value</td></tr>
        </table>
        
        <br><br>
        
        <table width=100%>
        <tr>
        <td align=center>$pre_value<br>_____________________<br>Prepared By</td>
        <td align=center>$chk_value<br>_____________________<br>Checked By</td>
        <td align=center>$appr_value<br>_____________________<br>Approved By</td>
        </tr>
        </table>
        
        <br><br>
        
        $bmenu
        
        <input type=hidden name=cs_no value='$_REQUEST[cs_no]'>
        <input type=hidden name=dataupdate value=1>
        </form>
        
        ";
        
    }
    
    
    if(!empty($_REQUEST['version'])){
        
        $_REQUEST['preview'] = 1;
        
        if(!is_file("cs-types-$_REQUEST[cs_no].txt")) die('input Row items');
        if(!is_file("cs-vendors-$_REQUEST[cs_no].txt")) die('input vendors');
        
        $data_all = explode("||",file_get_contents("cs-history-$_REQUEST[cs_no]-$_REQUEST[version].txt"));
        
        // $data_history = "||$cs_company||$cs_xname||$cs_qty||$cs_unit||$data_Vwrite||$data_Twrite||$data_cs_write||$_POST[remark]||$_POST[note]||$_POST[preparedby]||$_POST[checkedby]||$_POST[approvedby]||";

        $vendors = explode("\n",$data_all[5]);
        $types = explode("\n",$data_all[6]);
        
        echo "<br><br><form method=post autocomplete=off>
        <center>
        <h2 style='margin-bottom:-20px'>$data_all[1]</h2>
        <h4>29/10, K. M. Das Lane Tikatuly, Dhaka, Bangladesh – 1203</h4>
        <h3>Comparison Statement for $data_all[2]</h3>
        </center>
        
        <table width=100%><tr><td>CS Number: $_REQUEST[cs_no]</td><td align=right>Date: ".date('d/m/Y',$_REQUEST['version'])."</td></tr></table>
        
        
        <table width=100% border=1 cellspacing=0>
        <tr><td rowspan=2><b>Sl</b></td><td rowspan=2><b>Item Description</b></td><td colspan=".(count($vendors)-1)." align=center ><b>Suppliers Name/Vendor Name</b></td>
        
        
        
        <tr>";
        foreach($vendors as $vendor){
        $vendor = rtrim($vendor);
        if(empty($vendor)) continue;
        
        if(!empty($_REQUEST['preview']))
        echo "<td align=center><b>$vendor</b></td>";
        else echo "<td align=center><input name='vendorX[]' value='$vendor' style='width: 100%;'></td>";
        
        }
        
        echo "</tr>";
        
        
        // default desc 1

        if(empty($sl)) $sl = 1;
        else $sl++;
        
        echo "<tr><td><b>$sl</b></td><td><b>Unit Price BDT per $cs_unit</b></td>";

        $data = $data_all[7];
        
        for($i=0; $i<count($vendors)-1; $i++){
            $ivalue = '';
            $dataX = [];
            if(!empty($data)){
                $dataX = explode("[data-".$sl."_".($i+1)."]",$data);
                if(!empty($dataX[1])) $ivalue = $dataX[1];
            }
            
            if(!empty($_REQUEST['preview']))
            echo "<td>$ivalue</td>";
            
            else echo "<td><input onchange=\"\" onkeyup=\" var ccc = (this.value*$cs_qty).toFixed(2); ccc = parseFloat(ccc).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 }); data_2_".($i+1).".value=ccc; \" name='data[".$sl."_".($i+1)."]' value='$ivalue' style='width: 100%;'></td>";
        }
        
        echo "</tr>";
        
        
        // default desc 2

        if(empty($sl)) $sl = 1;
        else $sl++;
        
        echo "<tr><td><b>$sl</b></td><td><b>Total Price BDT ($cs_qty $cs_unit)</b></td>";

        $data = '';
        if(is_file("cs-data-$_REQUEST[cs_no].txt"))
        $data = file_get_contents("cs-data-$_REQUEST[cs_no].txt");
        
        for($i=0; $i<count($vendors)-1; $i++){
            $ivalue = '';
            $dataX = [];
            if(!empty($data)){
                $dataX = explode("[data-".$sl."_".($i+1)."]",$data);
                if(!empty($dataX[1])) $ivalue = $dataX[1];
            }
            
            if(!empty($_REQUEST['preview']))
            echo "<td>$ivalue</td>";
            else echo "<td><input id='data_".$sl."_".($i+1)."' name='data[".$sl."_".($i+1)."]' value='$ivalue' style='width: 100%;'></td>";
        }
        
        echo "</tr>";
        
        
        foreach($types as $type){
        $type = rtrim($type);
        if(empty($type)) continue;
        
        if(empty($sl)) $sl = 1;
        else $sl++;
        
        if(!empty($_REQUEST['preview']))
        echo "<tr><td><b>$sl</b></td><td><b>$type</b></td>";
        else
        echo "<tr><td><b>$sl</b></td><td><input name='typeX[]' value='$type' style='width: 100%;'></td>";
        
        $data = '';
        if(is_file("cs-data-$_REQUEST[cs_no].txt"))
        $data = file_get_contents("cs-data-$_REQUEST[cs_no].txt");
        
        for($i=0; $i<count($vendors)-1; $i++){
            $ivalue = '';
            $dataX = [];
            if(!empty($data)){
                $dataX = explode("[data-".$sl."_".($i+1)."]",$data);
                if(!empty($dataX[1])) $ivalue = $dataX[1];
            }
            
            if(!empty($_REQUEST['preview']))
            echo "<td>$ivalue</td>";
            else echo "<td><input name='data[".$sl."_".($i+1)."]' value='$ivalue' style='width: 100%;'></td>";
        }
        
        echo "</tr>";
        }
        
        echo "</table><br>";
        
        
        
        // $data_history = "||$cs_company||$cs_xname||$cs_qty||$cs_unit||$data_Vwrite||$data_Twrite||$data_cs_write||$_POST[remark]||$_POST[note]||$_POST[preparedby]||$_POST[checkedby]||$_POST[approvedby]||";
        
        
        if(!empty($_REQUEST['preview'])){
        
        
        $remark_value = "Remarks: $data_all[8]";
        $note_value = "Recommendation: $data_all[9]";
        
        $pre_value = "<div style='margin-bottom: -30px;'>$data_all[10]</div>";
        $chk_value = "<div style='margin-bottom: -30px;'>$data_all[11]</div>";
        $appr_value = "<div style='margin-bottom: -30px;'>$data_all[12]</div>";
        
        }else{
        
        $remark_value = "Remarks:</td><td><input name=remark value='$data_all[8]' style='width:100%'>";
        $note_value = "Recommendation:</td><td><input name=note value='$data_all[9]' style='width:100%'>";
        
        $pre_value = "<input name=preparedby value='$data_all[10]' style='text-align:center;'>";
        $chk_value = "<input name=checkedby value='$data_all[11]' style='text-align:center;'>";
        $appr_value = "<input name=approvedby value='$data_all[12]' style='text-align:center;'>";
        
        }
        
        
        
        echo "
        
        <table width='100%'>
        <tr><td width='150px'>$remark_value</td></tr>
        <tr><td width='150px'>$note_value</td></tr>
        </table>
        
        <br><br>
        
        <table width=100%>
        <tr>
        <td align=center>$pre_value<br>_____________________<br>Prepared By</td>
        <td align=center>$chk_value<br>_____________________<br>Checked By</td>
        <td align=center>$appr_value<br>_____________________<br>Approved By</td>
        </tr>
        </table>
        
        <br><br>
        
        $bmenu
        
        <input type=hidden name=cs_no value='$_REQUEST[cs_no]'>
        <input type=hidden name=dataupdate value=1>
        </form>
        
        ";
        
    }
    
    echo "<script>
        const style = document.createElement('style');
        style.innerHTML = '@media print {.no-print {display: none;}}';
        document.head.appendChild(style);
        </script>";
    
}


?>
