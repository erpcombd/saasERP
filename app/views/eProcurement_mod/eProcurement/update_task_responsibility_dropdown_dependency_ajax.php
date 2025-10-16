<?php

session_start();

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');


$str = $_POST['data'];
$data=explode('##',$str);

$unique='id';
$table_master = 'timeline_Tasks';
$Crud   = new Crud($table_master);

$responsible_team  = $data[0];

 $datashowtag = $data[1];


?>
 
     <?
                        if($responsible_team=="supply chain"){
                        $sql = 'select a.id,u.fname,a.action,a.is_master,u.email from rfq_evaluation_team a, user_activity_management u where a.user_id=u.user_id and a.rfq_no="'.$_SESSION['rfq_no'].'" and a.action="Owner" limit 1';
                        }elseif($responsible_team=="business user"){
                        $sql = 'select a.id,u.fname,a.action,a.is_master,u.email from rfq_evaluation_team a, user_activity_management u where a.user_id=u.user_id and a.rfq_no="'.$_SESSION['rfq_no'].'" and a.action="Evaluator" limit 1';

                        }else{
                          $sql = 'select a.id,u.fname,a.action,a.is_master,u.email from rfq_evaluation_team a, user_activity_management u where a.user_id=u.user_id and a.rfq_no="'.$_SESSION['rfq_no'].'" and a.action="uuuuuuuuuuuuuuuuuuuuuuuuu" limit 1';

                        }
                           $flag=false;   
                              $qry = db_query($sql);
                              while($data=mysqli_fetch_object($qry)){
                                $flag=true;
                              ?>
                             <input class="form-control" type="text" id="task_owner" name="task_owner" value="<?=$data->fname?>">
                            
<? } if($flag==false){?>
  <input class="form-control" type="text" id="task_owner" name="task_owner" value="<?=$data->fname?>">
  <?}?>

