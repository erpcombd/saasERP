<?php

class Crud {

		var $table_name;
		var $table_mail;
		var $fields = array();	
		var $fields_empty = array();
		var $fields_type = array();
		
		
public  function __construct($table_name) 
{
	

		$this->table_name = $table_name;
$sql="SHOW COLUMNS FROM ".$this->table_name;
		$query=db_query($sql);
		if($query){
		while($res=@mysqli_fetch_row($query))
		{
			$name=$res[0];
			$type=$res[1];
			$this->fields_empty = array_merge($this->fields_empty,array($name=>''));
			$this->fields = array_merge($this->fields,array($name));
			$this->fields_type = array_merge($this->fields_type,array($name=>$type));
		}
		}
}


public function insert($id='')
{			
			$vars = get_vars8($this->fields,$this->fields_type);
		//	echo 'sdfdsfds';
			if ( count($vars) > 0 ){
			$id=db_insert($this->table_name,$vars);
			}
			return $id;	
}
public function update($tag)
{
$vars = get_vars($this->fields);

if ( count($vars) > 0 ){
db_update($this->table_name,$_POST[$tag],$vars,$tag);
}
return true;	

}

public function delete($condition) 
{	
	$sql = "delete from $this->table_name where $condition limit 1";
	return db_query($sql);
}
public function delete_all($condition) 
{	
	$sql = "delete from $this->table_name where $condition";
	return db_query($sql);
}

public function link_report($sql,$link=''){
	$str='';
	if($sql==NULL) {return NULL;}
	do_datatable("grp");
		$str.='
		<table id="grp" class="display" class="w-100">';
		$str .='<thead><tr>';
		if($res=db_query($sql)){
		$cols = mysqli_num_fields($res);
		for($i=1;$i<$cols;$i++)
			{
				
				$fieldinfo = mysqli_fetch_field_direct($res,$i);
                $name = $coloum[$i] =$fieldinfo -> name;
				$str .='<th scope="col">'.ucwords(str_replace('_', ' ',$name)).'</th>';
			}
		$str .='</tr></thead><tbody>';
		$c=0;
		if(mysqli_num_rows($res)>0){
		while($row=mysqli_fetch_array($res))
			{
				$c++;
				if($c%2==0)	{$class=' class="alt"';} else{ $class=''; }
				
				$str .='<tr'.$class.' onclick="DoNav('.$row[0].');">';
				for($i=1;$i<$cols;$i++) {$str .='<td>'.$row[$i]."</td>";}
				$str .='</tr>';
			}}}
	$str .='</tbody></table>';
	return $str;

}

	}
?>