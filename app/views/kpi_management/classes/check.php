<? if(!isset($_SESSION))session_start();

if($_SESSION['mhafuz']!='Active'){session_destroy();?>

<script>location.href="../index.php";</script>

<? }elseif($_SESSION['user']['panel'] != 'YES'){ session_destroy(); ?>

 <script>location.href="../index.php";</script>

 <? }else{
	if(isset($_REQUEST['employee_selected2'])&&$_REQUEST['employee_selected2']>0)

	{
        

		$_SESSION['employee_selected2']=$_REQUEST['employee_selected2'];

		$_SESSION['employee_selected']=$_REQUEST['employee_selected2'];

		

		$_GET['employee_selected']=$_SESSION['employee_selected'];
       
	}

	elseif(isset($_SESSION['employee_selected2'])&&($_SESSION['employee_selected2'])>0)

	{$_GET['employee_selected']=$_SESSION['employee_selected'];}

}

?>

