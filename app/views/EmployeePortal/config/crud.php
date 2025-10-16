<?php

class crud {
		var $table_name;
		var $table_mail;
		var $fields = array();	
		var $fields_empty = array();
		var $fields_type = array();
		
		
function crud($table_name) {
include "db.php";

		$this->table_name = $table_name;
		$sql="SHOW COLUMNS FROM ".$this->table_name;
		$query=db_query($conn,$sql);
		while($res=@mysqli_fetch_row($query))
		{
			$name=$res[0];
			$type=$res[1];
			$this->fields_empty = array_merge($this->fields_empty,array($name=>''));
			$this->fields = array_merge($this->fields,array($name));
			$this->fields_type = array_merge($this->fields_type,array($name=>$type));
		}
}


function insert($tag='',$id=''){
include "db.php";			
			$vars = get_vars($this->fields);
			if ( count($vars) > 0 )
			$id=db_insert($this->table_name,$vars);
			return $id;	
}

function update($tag){
include "db.php";
$vars = get_vars($this->fields);

if ( count($vars) > 0 ) db_update($this->table_name,$_POST[$tag],$vars,$tag);
return $id;	
}

function delete($condition) {
include "db.php";	
	$sql = "delete from $this->table_name where $condition limit 1";
	return db_query($conn,$sql);
}

function delete_all($condition) {
include "db.php";	
	$sql = "delete from $this->table_name where $condition";
	return db_query($conn,$sql);
}

function link_report($sql,$link=''){
include "db.php";
	if($sql==NULL) return NULL;
		$str.='
		<table id="grp" cellspacing="0" cellpadding="0" width="100%">';
		$str .='<tr>';
		if($res=db_query($conn,$sql)){
		$cols = mysqli_num_fields($res);
		for($i=1;$i<$cols;$i++)
			{
				$name = mysqli_field_name($res,$i);
				$str .='<th>'.ucwords(str_replace('_', ' ',$name)).'</th>';
			}
		$str .='</tr>';
		$c=0;
		if(mysqli_num_rows($res)>0){
		while($row=mysqli_fetch_array($res))
			{
				$c++;
				if($c%2==0)	$class=' class="alt"'; else $class=''; 
				
				$str .='<tr'.$class.' onclick="DoNav('.$row[0].');">';
				for($i=1;$i<$cols;$i++) {$str .='<td>'.$row[$i]."</td>";}
				$str .='</tr>';
			}}}
	$str .='</table>';
	return $str;

}
}
?>