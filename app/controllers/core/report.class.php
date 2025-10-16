<?php
function report_create($sql,$s='',$head=''){
$str = '';
$space_row ='<td>&nbsp;</td>';
	if($s!='') {$sl=$s;}

	if($sql==NULL){ return NULL;}

		$res	 = db_query($sql);
		if($res){

		$cols 	 = mysqli_num_fields($res);}

		if(isset($sl)){ $total_cols=$cols+1;}
		else {$total_cols=$cols;}

		$str	.= '<table class="w-100" id="ExportTable" border="0" cellpadding="2" >';

		$str 	.= '<thead>';

		$str 	.= '<tr><td colspan="'.$total_cols.'" style="border:0px;">';

		$str 	.= $head;

		$str 	.= '</td></tr>';

		$str 	.= '<tr>';

		if(isset($sl)){$str .='<th scope="col">S/L</th>';}
        $i=0;
		for($i=0;$i<$cols;$i++)

			{
$fieldinfo = mysqli_fetch_field_direct($res,$i);
                $name = $coloum[$i] =$fieldinfo -> name;


				$str .='<th scope="col">'.ucwords(str_replace('_', ' ',$name)).'</th>';

			}

		$str .='</tr></thead><tbody>';


        if($res){
		while($row=mysqli_fetch_array($res))

			{				

				$str .='<tr>';

				if(isset($sl)){$str .='<td>'.$sl.'</td>';$sl++;}

				for($i=0;$i<$cols;$i++) 

{

if($_POST['report']==3){

if($coloum[$i]=='rate')

{$str .='<td style="text-align:right">'.@number_format($row[$i],4).'</td>';}

elseif($show[$i]!=1&&(is_numeric($row[$i])))

{$sum[$i]=$sum[$i]+$row[$i]; $str .='<td style="text-align:right">'.$row[$i].'</td>';}

else {$show[$i]=1; $str .='<td>'.$row[$i].'</td>';}}

else{

if($coloum[$i]=='warehouse')

{$str .='<td style="text-align:right">'.$row[$i].'</td>';}

elseif(($coloum[$i]=='rate')||($coloum[$i]=='price'))

{$str .='<td style="text-align:right">'.@number_format($row[$i],4).'</td>';}

elseif($show[$i]!=1&&(is_numeric($row[$i])&&strpos($row[$i],'.')||$row[$i]==''))

{
	if ($sum[$i] == '') {
    $sum[$i] = 0;
}
if (is_numeric($sum[$i]) && is_numeric($row[$i])) 
	$sum[$i]=$sum[$i]+$row[$i]; $str .= '<td style="text-align:right">' . @number_format((float)$row[$i], 2) . '</td>';}

else {$show[$i]=1; $str .='<td>'.$row[$i].'</td>';}}

}

				$str .='</tr>';

			}
		}

		$str .='<tr class="footer">';

		if(isset($sl)){$str .=$space_row;}

		for($i=0;$i<$cols;$i++)

			{



				if($_POST['report']==3){				if($coloum[$i]=='rcv_amt'){ $str .=$space_row;}

				elseif($show[$i]!=1&&$sum[$i]!=0){$str .='<td style="text-align:right">'.$sum[$i].'</td>';}

				else{ $str .=$space_row;}
			}

else{				if($show[$i]!=1&&$sum[$i]!=0){$str .='<td style="text-align:right">'.number_format($sum[$i],2).'</td>';}

				else {$str .=$space_row;}
			}

			}

		$str .='</tr></tbody>';

	$str .='</table>';

	return $str;



}





function link_report($sql,$link=''){
$str = '';


	if($sql==NULL){ return NULL;}



		$str.='

		<table id="grp"   class="w-100">';

		$str .='<tr>';

		$res=db_query($sql);

		$cols = mysqli_num_fields($res);


     for ($i = 1; $i < $cols; $i++) {
            $field = mysqli_fetch_field_direct($res, $i);
            $name = $field->name;
            $str .= '<th scope="col">' . ucwords(str_replace('_', ' ', $name)) . '</th>';
        }

		$str .='</tr>';

		$c=0;

		while($row=mysqli_fetch_array($res))

			{ if($link!='') {$link= ' onclick="custom('.$row[0].');"';

				$c++;}

				if($c%2==0)	{$class=' class="alt"';} else {$class=''; }

				

				$str .='<tr'.$class.$link.'>';

				for($i=1;$i<$cols;$i++) {$str .='<td>'.$row[$i]."</td>";}

				$str .='</tr>';

			}

	$str .='</table>';

	return $str;



}







function link_report_addon($sql,$link='',$col1='',$col2=''){
$str = '';


	if($sql==NULL) {return NULL;}

		$str.='

		<table id="grp"   class="w-100">';

		$str .='<tr>';

		$res=db_query($sql);

		$cols = mysqli_num_fields($res);

		for($i=1;$i<$cols;$i++)

			{

				$name = mysqli_field_name($res,$i);

				$str .='<th scope="col">'.ucwords(str_replace('_', ' ',$name)).'</th>';

			}

		$str .='</tr>';

		$c=0;

		while($row=mysqli_fetch_array($res))

			{ 

			$total1=$total1+$row[$col1];

			$total2=$total2+$row[$col2];

			if($link!='') {$link= ' onclick="custom('.$row[0].');"';

				$c++;
			    
			}

				if($c%2==0)	{$class=' class="alt"';} else {$class='';} 

				$str .='<tr'.$class.$link.'>';

				for($i=1;$i<$cols;$i++) {$str .='<td>&nbsp;'.$row[$i]."</td>"; }

				$str .='</tr>';

			}

	$str .='<tr'.$class.$link.'>';

	$str .="<td colspan='".(($col1)-1)."'><span style='text-align:right;'> Total: </span></td>";

	$str .="<td colspan='".(($col2-$col1)-1)."'>".$total1."</td>";

	$str .="<td colspan='".(($cols-($col1+$col2))-1)."'>".$total2."</td>";

	$str .='</tr>';

	$str .='</table>';

	return $str;



}

function link_report_add($sql,$link=''){
$str = '';


	if($sql==NULL) {return NULL;}

		$str.='

		<table id="grp"   class="w-100">';

		$str .='<tr>';

		$res=db_query($sql);

		$cols = mysqli_num_fields($res);

		for($i=1;$i<$cols;$i++)

			{

				$name = mysqli_field_name($res,$i);

				$str .='<th scope="col">'.ucwords(str_replace('_', ' ',$name)).'</th>';

			}

		$str .='</tr>';

		$c=0;

		while($row=mysqli_fetch_array($res))

			{ 

			$total=$total+$row[7];

			$total_qty=$total_qty+$row[5];

			if($link!='') {$link= ' onclick="custom('.$row[0].');"';

				$c++;
			    
			}

				if($c%2==0)	{$class=' class="alt"';} else {$class=''; }

				$str .='<tr'.$class.$link.'>';

				for($i=1;$i<$cols;$i++) {$str .='<td>&nbsp;'.$row[$i]."</td>"; }

				$str .='</tr>';

			}

	$str .='<tr'.$class.$link.'>';

	$str .="<td colspan='".($cols-5)."'><span style='text-align:right;'> Total: </span></td>";

	$str .="<td colspan='2'>".$total_qty."</td>";

	$str .="<td colspan='2'>".$total."</td>";

	$str .='</tr>';

	$str .='</table>';

	return $str;



}





function link_report_del($sql,$link=''){
$str = '';


	if($sql==NULL) {return NULL;}

		$str.='

		<table id="grp"   class="w-100">';

		$str .='<tr>';

		$res=db_query($sql);

		$cols = mysqli_num_fields($res);

		for($i=1;$i<$cols;$i++)

			{

				 $field = mysqli_fetch_field_direct($res, $i);
                 $name = $field->name;

				$str .='<th scope="col">'.ucwords(str_replace('_', ' ',$name)).'</th>';

			}

		$str .='</tr>';

		$c=0;

		while($row=mysqli_fetch_array($res))

			{ 

			if($link!='') {$link= ' onclick="custom('.$row[0].');"';

				$c++;
			    
			}

				if($c%2==0)	{$class=' class="alt"';} else {$class='';} 

				$str .='<tr'.$class.$link.'>';

				for($i=1;$i<($cols-1);$i++) {$str .='<td>&nbsp;'.$row[$i]."</td>"; }

				$str .='<td><a onclick="if(!confirm(\'Are You Sure Execute this?\')){return false;}" href="?del='.$row[0].'">&nbsp;X&nbsp;</a></td>';

				$str .='</tr>';

			}

	$str .='</table>';

	return $str;



}







function link_report_add_del($sql,$link=''){

$str = '';

	if($sql==NULL) {return NULL;}

		$str.='

		<table id="grp"   class="w-100">';

		$str .='<tr>';

		$res=db_query($sql);

		$cols = mysqli_num_fields($res);

		for($i=1;$i<$cols;$i++)

			{

				$name = mysqli_field_name($res,$i);

				$str .='<th scope="col">'.ucwords(str_replace('_', ' ',$name)).'</th>';

			}

		$str .='</tr>';

		$c=0;

		while($row=mysqli_fetch_array($res))

			{ 

			$total=$total+$row[7];

			$total_qty=$total_qty+$row[5];

			if($link!='') {$link= ' onclick="custom('.$row[0].');"';

				$c++;
			    
			}

				if($c%2==0)	{$class=' class="alt"';} else {$class='';} 

				$str .='<tr'.$class.$link.'>';

				for($i=1;$i<($cols-1);$i++) {$str .='<td>&nbsp;'.$row[$i]."</td>"; }

				$str .='<td><a href="?del='.$row[0].'">&nbsp;X&nbsp;</a></td>';

				$str .='</tr>';

			}

	$str .='<tr'.$class.$link.'>';

	$str .="<td colspan='".($cols-5)."'><span style='text-align:right;'> Total: </span></td>";

	$str .="<td colspan='2'>".$total_qty."</td>";

	$str .="<td colspan='2'>".$total."</td>";

	$str .='</tr>';

	$str .='</table>';

	return $str;

}



function link_report_add_auto($sql,$link='',$sum_of1='',$sum_of2=''){
$str = '';


	if($sql==NULL) {return NULL;}

		$str.='

		<table id="grp"   class="w-100">';

		$str .='<tr>';

		$res=db_query($sql);

		$cols = mysqli_num_fields($res);

		for($i=1;$i<$cols-1;$i++)

			{

				$name = mysqli_field_name($res,$i);

				$str .='<th scope="col">'.ucwords(str_replace('_', ' ',$name)).'</th>';

			}

		$str .='</tr>';

		$c=0;

		while($row=mysqli_fetch_array($res))

			{ 

			$total_qty=$total_qty+$row[$sum_of1];

			$total=$total+$row[$sum_of2];

			

			if($link!='') {$link= ' onclick="custom('.$row[0].');"';

				$c++;
			    
			}

				if($c%2==0)	{$class=' class="alt"';} else {$class='';} 

				$str .='<tr'.$class.$link.'>';

				for($i=1;$i<($cols-1);$i++) {$str .='<td>&nbsp;'.$row[$i]."</td>"; }

				$str .='</tr>';

			}

	$str .='<tr'.$class.$link.'>';

	if($sum_of1>0)

	{$str .="<td colspan='".($sum_of1-1)."'><span style='text-align:right;'> Total: </span></td>";}

	if($sum_of2>0)

	{

		$str .="<td colspan='".($sum_of2-$sum_of1)."'>".number_format($total_qty,2)."</td>";

		$str .="<td colspan='".($cols-$sum_of1)."'>".number_format($total,2)."</td>";

	}

	else{

		$str .="<td colspan='".($cols-$sum_of1)."'>".number_format($total_qty,2)."</td>";

	$str .='</tr>';

	$str .='</table>';}

	return $str;

}



function link_report_add_del_auto($sql,$link='',$sum_of1='0',$sum_of2='0'){
$str = '';


	if($sql==NULL) {return NULL;}

		$str.='

		<table class="table1  table-striped table-bordered table-hover table-sm" id="response">';

		$str .='<tr class="bgc-info">';

		$res=db_query($sql);

		$cols = mysqli_num_fields($res);

		$str .='<th scope="col">S/L</th>';

		for($i=1;$i<$cols;$i++)

			{

		$field_info = mysqli_fetch_field_direct($res, $i);
        $name = $field_info->name;
        $str .= '<th scope="col">' . ucwords(str_replace('_', ' ', $name)) . '</th>';

			}

		$str .='</tr>';

		$str .='<tbody>';

		$c=0;

		while($row=mysqli_fetch_array($res))

			{ 

			$total_qty=$total_qty+$row[$sum_of1-1];

			$total=$total+$row[$sum_of2-1];

			

			if($link!='') {$link= ' onclick="custom('.$row[0].');"';

				$c++;
			    
			}
				else {
				$c++;
				    $class = '';
				    $link='';
				}



				$str .='<tr'.$class.$link.'>';

				$str .='<td>'.$c.'</td>';

				for($i=1;$i<($cols-1);$i++) {$str .='<td>&nbsp;'.$row[$i]."</td>"; }

				$str .='<td><a href="?del='.$row[0].'"><em class="fa fa-trash" style="color:red"></em></a></td>';

				$str .='</tr>';

			}

			$str .= '</tbody>';

	$str .='<tfoot><tr'.$class.$link.'>';

	if($sum_of1>0)

	{$str .="<td colspan='".($sum_of1-1)."'><span style='text-align:right;'> Total: </span></td>";}

	if($sum_of2>0)

	{

	$str .="<td colspan='".($sum_of2-$sum_of1)."'>".number_format($total_qty,2)."</td>";

	$str .="<td colspan='".($cols-$sum_of1)."'>".number_format($total,2)."</td>";

	}

	$str .='</tr></tfoot></table>';

	return $str;

}



function link_report_add_report($sql,$link=''){
$str = '';


	if($sql==NULL) {return NULL;}

		$str.='

		<table id="grp"   class="w-100">';

		$str .='<tr>';

		$res=db_query($sql);

		$cols = mysqli_num_fields($res);

		for($i=1;$i<$cols;$i++)

			{

				$name = mysqli_field_name($res,$i);

				$str .='<th scope="col">'.ucwords(str_replace('_', ' ',$name)).'</th>';

			}

		$str .='</tr>';

		$c=0;

		while($row=mysqli_fetch_array($res))

			{ 

			$total=$total+$row[7];

			$total_qty=$total_qty+$row[6];

			if($link!='') {$link= ' onclick="custom('.$row[0].');"';

				$c++;
			    
			}

				if($c%2==0)	{$class=' class="alt"';} else {$class=''; }

				$str .='<tr'.$class.$link.'>';

				for($i=1;$i<($cols-1);$i++) {$str .='<td>&nbsp;'.$row[$i]."</td>"; }

				$str .='<td><a href="../report/invoice_print_new.php?v_no='.$row[0].'" target="_blank" rel="noopener">&nbsp;Click&nbsp;</a></td>';

				$str .='</tr>';

			}

	$str .='<tr'.$class.$link.'>';

	$str .="<td colspan='".($cols-3)."'><span style='text-align:right;'> Total: </span></td>";

	$str .="<td colspan='2'>".$total_qty."</td>";

	$str .='</tr>';

	$str .='</table>';

	return $str;



}



function link_report_single($sql,$link=''){
$str = '';


	if($sql==NULL) {return NULL;}

		$str.='

		<table id="grp"   class="w-100">';

		$str .='<tr>';

		$res=db_query($sql);

		$cols = mysqli_num_fields($res);

		for($i=1;$i<$cols;$i++)

			{

				$name = mysqli_field_name($res,$i);

				$str .='<th scope="col">'.ucwords(str_replace('_', ' ',$name)).'</th>';

			}

		$str .='</tr>';

		$c=0;

		while($row=mysqli_fetch_array($res))

			{ 

			$total=$total+$row[7];

			$total_qty=$total_qty+$row[5];

			if($link!='') {$link= ' onclick="custom('.$row[0].');"';

				$c++;
			    
			}

				if($c%2==0)	{$class=' class="alt"';} else {$class=''; }

				$str .='<tr'.$class.$link.'>';

				for($i=1;$i<$cols;$i++) {$str .='<td>&nbsp;'.$row[$i]."</td>"; }

				$str .='</tr>';

			}

	$str .='<tr'.$class.$link.'>';

	$str .="<td colspan='".($cols-4)."'><span style='text-align:right;'> Total: </span></td>";

	$str .="<td colspan='2'>".$total_qty."</td>";

	$str .="<td colspan='2'>".$total."</td>";

	$str .='</tr>';

	$str .='</table>';

	return $str;



}





function ajax_report($sql,$url,$div){
$str = '';


	if($sql==NULL) {return NULL;}



		$str.='

		<table id="grp"   class="w-100">';

		$str .='<tr>';

		$res=db_query($sql);

		$cols = mysqli_num_fields($res);

		for($i=1;$i<$cols;$i++)

			{

				$name = mysqli_field_name($res,$i);

				$str .='<th scope="col">'.ucwords(str_replace('_', ' ',$name)).'</th>';

			}

		$str .='</tr>';

		$c=0;

		while($row=mysqli_fetch_array($res))

			{

				$c++;

				if($c%2==0)	{$class=' class="alt"'; }
				else {$class=''; }

				

				$str .='<tr'.$class.' onclick="getData(\''.$url.'\',\''.$div.'\','.$row[0].');">';

				for($i=1;$i<$cols;$i++) {$str .='<td>'.$row[$i]."</td>";}

				$str .='</tr>';

			}

	$str .='</table>';

	return $str;



}




function upload_file($folder, $field_name, $file_name = '') {
    if (empty($_FILES[$field_name]['name'])) {
        return false; // No file uploaded
    }

    $file_name2 = $_FILES[$field_name]['name'];
    $file_tmp2  = $_FILES[$field_name]['tmp_name'];
    $extension  = strtolower(pathinfo($file_name2, PATHINFO_EXTENSION));

    // Allowed file types
    $allowed = ['jpg','jpeg','pdf','png','docx','xls','xlsx','csv'];
    if (!in_array($extension, $allowed)) {
        error_log("Invalid file type: " . $extension);
        return false;
    }

    // Directories
    $directory = constant('SERVER_FILE_PATH') .'/'.$_SESSION['proj_id'] . '/';
    if (!is_dir($directory)) mkdir($directory, 0777, true);

    $subdirectory = $directory . $folder . '/';
    if (!is_dir($subdirectory)) mkdir($subdirectory, 0777, true);

    // File name
    $file_data = $file_name ? $file_name . '.' . $extension : $folder . '_' . time() . '.' . $extension;
    $uploaded_file2 = $subdirectory . $file_data;

    // Upload
    if (move_uploaded_file($file_tmp2, $uploaded_file2)) {
        return $file_data;
    } else {
        error_log("File upload failed: " . $uploaded_file2);
        return false;
    }
}



function upload_file_old($folder, $field_name, $file_name = '') {
    // Retrieve file details
    $file_name2 = $_FILES[$field_name]['name'];
    $file_tmp2 = $_FILES[$field_name]['tmp_name'];
    $extension = end(explode('.', $file_name2));
    $extension = strtolower($extension);

    // Define the directory using a constant
    $directory = constant('SERVER_FILE_PATH') .'/'.$_SESSION['proj_id'] . '/';
    if (!is_dir($directory)) mkdir($directory, 0755, true);

    $subdirectory = $directory . $folder . '/';
    if (!is_dir($subdirectory)) mkdir($subdirectory, 0755, true);


    // Set the path and file data
    $path = $subdirectory . '/';
    $rand = time();
    $file_data = $file_name ? $file_name . '.' . $extension : $folder . '-' . $rand . '.' . $extension;

    // Check allowed file types and upload
    if (in_array($extension, ['jpg', 'jpeg', 'pdf', 'png', 'docx', 'xls', 'xlsx', 'csv'])) {
        $uploaded_file2 = $path . $file_data;
        move_uploaded_file($file_tmp2, $uploaded_file2);
        return $file_data;
    }
}




function upload_files($folder, $field_name, $file_name_prefix = '') {
	$uploaded_files = [];

	// Define the directory using a constant
	$directory = constant('SERVER_FILE_PATH') . $_SESSION['proj_id'] . '/';
	if (!is_dir($directory)) {
		mkdir($directory);
	}

	// Define the subdirectory
	$subdirectory = constant('SERVER_FILE_PATH') . $_SESSION['proj_id'] . '/' . $folder;
	if (!is_dir($subdirectory)) {
		mkdir($subdirectory);
	}

	// Set the path
	$path = $subdirectory . '/';

	// Check if multiple files are uploaded
	if (is_array($_FILES[$field_name]['name'])) {
		// Loop through each file in the field
		foreach ($_FILES[$field_name]['name'] as $index => $file_name) {
			$file_tmp = $_FILES[$field_name]['tmp_name'][$index];
			$extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

			// Generate a unique file name
			$rand = time() . '_' . $index;
			$file_data = $folder . '-' . $rand . '.' . $extension;

			// Check allowed file types and upload
			if (in_array($extension, ['jpg', 'jpeg', 'pdf', 'png', 'docx', 'xls', 'xlsx', 'csv'])) {
				$uploaded_file = $path . $file_data;
				if (move_uploaded_file($file_tmp, $uploaded_file)) {
					$uploaded_files[] = $file_data;
				}
			}
		}
	} 

	return $uploaded_files;
}



?>