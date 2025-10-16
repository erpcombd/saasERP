<?php

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
    
    <input type=submit value='Create New'></form>
    
    <h2>Or Select existing CS from below:</h2><hr>
    
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
    
}else{
    
    
    if(!empty($_POST['savecs'])){
        
        $data_write = '';
        foreach($_POST['data'] as $dataN=>$dataV){
            $dataV = rtrim($dataV);
            if(empty($dataV)) continue;
            $data_write .= "[data-$dataN]$dataV"."[data-$dataN]";
        }
        file_put_contents("cs-data-$_REQUEST[cs_no].txt",$data_write);
        
        $data_write = '';
        foreach($_POST['vendorX'] as $dataV){
            $dataV = rtrim($dataV);
            if(empty($dataV)) continue;
            $data_write .= "$dataV\n";
        }
        file_put_contents("cs-vendors-$_REQUEST[cs_no].txt",$data_write);
        
        $data_write = '';
        foreach($_POST['typeX'] as $dataV){
            $dataV = rtrim($dataV);
            if(empty($dataV)) continue;
            $data_write .= "$dataV\n";
        }
        file_put_contents("cs-types-$_REQUEST[cs_no].txt",$data_write);
        
    }
    

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
    
    
    if(!empty($_REQUEST['rowadd'])){
        
        echo "<h2>$cs_company</h2>
        <p>CS Number: $_REQUEST[cs_no]<br>Item Name: $cs_name</p>
        <form method=post>Items Description: <input type=hidden name=cs_no value='$_REQUEST[cs_no]'>
        <input name=type required id=type>
        <script>type.focus();</script>
        <input type=submit value=Add >
        <hr>
        
        <div class='no-print'>
        <a href='?'>CS List</a> | 
        <a href='?cs_no=$_REQUEST[cs_no]&itemupdate=1'>Edit Qty</a> | 
        <a href='?cs_no=$_REQUEST[cs_no]&vendoradd=1'>Add Vendor</a> | 
        <a href='?cs_no=$_REQUEST[cs_no]&rowadd=1'>Add Row</a> | 
        <a href='?cs_no=$_REQUEST[cs_no]&dataupdate=1'>Edit CS Data</a> | 
        <a href='?cs_no=$_REQUEST[cs_no]&dataupdate=1&preview=1'>Preview CS Data</a> | 
        <a href='#' onclick='window.print();'>Print</a>
        </div>
        
        <hr>
        </form>";
        
        if(is_file("cs-types-$_REQUEST[cs_no].txt"))
        echo "<pre><b>Row Description Names:</b><br>".file_get_contents("cs-types-$_REQUEST[cs_no].txt")."</pre><hr>";

    }
    
    
    if(!empty($_REQUEST['vendoradd'])){
        
        echo "<h2>$cs_company</h2>
        <p>CS Number: $_REQUEST[cs_no]<br>Item Name: $cs_name</p>
        <form method=post>Enter CS Vendor Name: <input type=hidden name=cs_no value='$_REQUEST[cs_no]'>
        <input name=vendor required id=vendor>
        <script>vendor.focus();</script>
    
        <input type=submit value=Add > 
        <hr>
        
        <div class='no-print'>
        <input type=submit value=Save name=savecs> | 
        <a href='?'>CS List</a> | 
        <a href='?cs_no=$_REQUEST[cs_no]&itemupdate=1'>Edit Qty</a> | 
        <a href='?cs_no=$_REQUEST[cs_no]&vendoradd=1'>Add Vendor</a> | 
        <a href='?cs_no=$_REQUEST[cs_no]&rowadd=1'>Add Row</a> | 
        <a href='?cs_no=$_REQUEST[cs_no]&dataupdate=1'>Edit CS Data</a> | 
        <a href='?cs_no=$_REQUEST[cs_no]&dataupdate=1&preview=1'>Preview CS Data</a> | 
        <a href='#' onclick='window.print();'>Print</a>
        </div>
        
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
        
        <div class='no-print'>
        <input type=submit value=Save name=savecs> | 
        <a href='?'>CS List</a> | 
        <a href='?cs_no=$_REQUEST[cs_no]&itemupdate=1'>Edit Qty</a> | 
        <a href='?cs_no=$_REQUEST[cs_no]&vendoradd=1'>Add Vendor</a> | 
        <a href='?cs_no=$_REQUEST[cs_no]&rowadd=1'>Add Row</a> | 
        <a href='?cs_no=$_REQUEST[cs_no]&dataupdate=1'>Edit CS Data</a> | 
        <a href='?cs_no=$_REQUEST[cs_no]&dataupdate=1&preview=1'>Preview CS Data</a> | 
        <a href='#' onclick='window.print();'>Print</a>
        </div>
        
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
            else echo "<td><input onchange=\"data_2_".($i+1).".value=(this.value*$cs_qty);\" onkeyup=\"data_2_".($i+1).".value=(this.value*$cs_qty);\" name='data[".$sl."_".($i+1)."]' value='$ivalue' style='width: 100%;'></td>";
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
        
        echo "</table><br>
        
        
        <br><br>
        
        <table width=100%>
        <tr>
        <td align=center >_____________________<br>Prepared By</td>
        <td align=center >_____________________<br>Checked By</td>
        <td align=center >_____________________<br>Approved By</td>
        </tr>
        </table>
        
        <br><br>
        
        <div class='no-print'>
        <input type=submit value=Save name=savecs> | 
        <a href='?'>CS List</a> | 
        <a href='?cs_no=$_REQUEST[cs_no]&itemupdate=1'>Edit Qty</a> | 
        <a href='?cs_no=$_REQUEST[cs_no]&vendoradd=1'>Add Vendor</a> | 
        <a href='?cs_no=$_REQUEST[cs_no]&rowadd=1'>Add Row</a> | 
        <a href='?cs_no=$_REQUEST[cs_no]&dataupdate=1'>Edit CS Data</a> | 
        <a href='?cs_no=$_REQUEST[cs_no]&dataupdate=1&preview=1'>Preview CS Data</a> | 
        <a href='#' onclick='window.print();'>Print</a>
        </div>
        
        
        
        <input type=hidden name=cs_no value='$_REQUEST[cs_no]'>
        <input type=hidden name=dataupdate value=1>
        </form>
        
        <script>
        const style = document.createElement('style');
        style.innerHTML = '@media print {.no-print {display: none;}}';
        document.head.appendChild(style);
        </script>
        
        
        ";
        
    }
    
}


?>
