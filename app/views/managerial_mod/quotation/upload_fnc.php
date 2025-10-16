<? 



function upload_file($folder,$field_name,$file_name=''){
	

$file_name2= $_FILES[$field_name]['name'];

$file_tmp2= $_FILES[$field_name]['tmp_name'];

$file_size= $filesize = $_FILES["photo"]["size"];

$ext2=end(explode('.',$file_name2));

$path = '../../../../../media/'.$folder.'/';


if(($ext2=='jpg' || $ext2=='jpeg' || $ext2=='pdf' || $ext2=='png') && $file_size < 500000 ){

$uploaded_file2 = $path.$file_name.'.'.$ext2;

move_uploaded_file($file_tmp2,$uploaded_file2);


return  $uploaded_file2;

}

}



 ?>