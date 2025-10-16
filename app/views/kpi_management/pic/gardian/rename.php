<?php
foreach(glob('*.*') as $fileName)
	{
		$filePart = explode('.',$fileName);
		if($filePart[0]<100000&&$filePart[0]>0)
		{
        	unlink($fileName);
			$i++;
		}
	}
	echo ' File Deleted: '.$i;
?>