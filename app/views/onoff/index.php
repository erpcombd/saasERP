<?
$config = require_once "../../../app/controllers/config/db_master_config.php";
$con = mysqli_connect($config['hostname'], $config['username'], $config['password'], $config['database'], $config['port']);

$pid = $_REQUEST['pid'];
$p=100;
if($_REQUEST['pid']>0 && $_REQUEST['pid']==10112)
{
$transfer_status = $_REQUEST['tstatus'];
if($transfer_status==''){
$status =  $_REQUEST['pstatus'];
$transfer_status = 'NO';
}else{
$status = 'ON';
}

$sql2 ='update company_info set is_transfer="'.$transfer_status.'",status="'.$status.'" where id = '.$pid;
mysqli_query($con,$sql2);


$sqlq="SELECT b.db_user,b.db_pass,b.db_name,a.cid,a.id,a.company_name,a.address FROM 
company_info a,database_info b WHERE a.id='$pid' and a.id=b.company_id limit 1";


	$sql=@mysqli_query($con,$sqlq);
	if($proj=@mysqli_fetch_object($sql))
	{




					$host   = 'localhost';
					$db	    = $proj->db_name;
					$user	= $proj->db_user;
					$pass	= $proj->db_pass;

                    $mainDb = mysqli_connect($host,$user,$pass,$db);
                    
                    $sql ='update project_info set status="'.$action.'" where 1';
                    //mysqli_query($mainDb,$sql);

}
//header("Location: index.php");
//die();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control Panel</title>
<head>
<style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #e8e8e8 0%, #d5d5d5 100%);

            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .control-panel {
            background: linear-gradient(145deg, #f5f5f5, #e0e0e0);
            border: 2px solid #999;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 
                0 8px 24px rgba(0, 0, 0, 0.15),
                inset 0 1px 2px rgba(255, 255, 255, 0.8);
            max-width: 500px;
            width: 100%;
			margin: 0px !important;
            min-height: 90vh;
        }

        .panel-title {
            font-size: 24px;
            font-weight: 600;
            color: #333;
            text-align: center;
            margin-bottom: 1.5rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .status-section {
            margin-bottom: 1rem;
			margin-top:1rem;
        }

        .status-header {
            font-size: 20px;
            font-weight: 500;
            color: #555;
            margin-bottom: 0rem;
            text-transform: capitalize;
            letter-spacing: 0.5px;
        }

        .controls-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: linear-gradient(145deg, #ffffff, #f0f0f0);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .table-header {
            background: linear-gradient(145deg, #e8e8e8, #d0d0d0);
            border-bottom: 2px solid #bbb;
        }

        .table-header th {
            padding: 1rem;
            font-weight: 600;
            color: #444;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 14px;
        }

        .table-header th:first-child {
            text-align: left;
            border-right: 1px solid #bbb;
        }

        .table-header th:last-child {
            text-align: center;
        }

        .control-row {
            border-bottom: 1px solid #ddd;
            transition: background-color 0.2s ease;
        }

        .control-row:hover {
            background: linear-gradient(145deg, #f8f8f8, #eeeeee);
        }

        .control-row:last-child {
            border-bottom: none;
        }

        .control-label {
            padding: 1.5rem 1rem;
            font-weight: 500;
            color: #333;
            border-right: 1px solid #ddd;
            font-size: 16px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .control-button {
            padding: 1rem;
            text-align: center;
        }
		
		.toggle-container-off{
			position: relative;
			width: 140px;
			height: 60px;
			background: linear-gradient(145deg, #ff0f0f, #ffcbcb);
			border-radius: 30px;
			border: 2px solid #ff0f0f;
			box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1), 0 2px 6px rgba(0, 0, 0, 0.1);
			cursor: pointer;
			transition: all 0.3s ease;
			user-select: none;
			margin: 0 auto;
			color: white;
			font-weight: bold;
		}
		
		.toggle-container-on{
			position: relative;
			width: 140px;
			height: 60px;
			background: linear-gradient(145deg, #337e55, #5dffa7);
			border-radius: 30px;
			border: 2px solid #337e55;
			box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1), 0 2px 6px rgba(0, 0, 0, 0.1);
			cursor: pointer;
			transition: all 0.3s ease;
			user-select: none;
			margin: 0 auto;
			color: #ffffff;
			font-weight: bold;
		}
		
		
		.toggle-container-black{
			position: relative;
			width: 140px;
			height: 60px;
			background: linear-gradient(145deg, #000000, #7e7e7e);
			border-radius: 30px;
			border: 2px solid #000000;
			box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1), 0 2px 6px rgba(0, 0, 0, 0.1);
			cursor: pointer;
			transition: all 0.3s ease;
			user-select: none;
			margin: 0 auto;
			color: white;
			font-weight: bold;
		}
		
		.toggle-container-white{
			position: relative;
			width: 140px;
			height: 60px;
            background: linear-gradient(145deg, #f0f0f0, #d0d0d0);
            border-radius: 30px;
            border: 2px solid #999;
			box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1), 0 2px 6px rgba(0, 0, 0, 0.1);
			cursor: pointer;
			transition: all 0.3s ease;
			user-select: none;
			margin: 0 auto;
			color: #333;
			font-weight: bold;
		}

        .toggle-container {
            position: relative;
            width: 140px;
            height: 60px;
            background: linear-gradient(145deg, #f0f0f0, #d0d0d0);
            border-radius: 30px;
            border: 2px solid #999;
            box-shadow: 
                inset 0 2px 4px rgba(0, 0, 0, 0.1),
                0 2px 6px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: all 0.3s ease;
            user-select: none;
            margin: 0 auto;
        }

        .toggle-container:hover {
            box-shadow: 
                inset 0 2px 4px rgba(0, 0, 0, 0.15),
                0 4px 8px rgba(0, 0, 0, 0.15);
        }

        .toggle-slider {
            position: absolute;
            top: 3px;
            left: 3px;
            width: 66px;
            height: 50px;
            background: linear-gradient(145deg, #ffffff, #e8e8e8);
            border-radius: 25px;
            box-shadow: 
                0 2px 6px rgba(0, 0, 0, 0.2),
                inset 0 1px 2px rgba(255, 255, 255, 0.8);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid #ccc;
        }

        .toggle-labels {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 15px;
            font-weight: 600;
            font-size: 12px;
            letter-spacing: 0.5px;
        }

        .label-on,
        .label-off {
            transition: all 0.3s ease;
            z-index: 2;
            position: relative;
        }

        /* OFF State (default) */
        .toggle-container .toggle-slider {
            transform: translateX(68px);
        }

        .toggle-container .label-on {
            color: #999;
        }

        .toggle-container .label-off {
            color: #ff6b35;
            text-shadow: 0 1px 2px rgba(255, 107, 53, 0.3);
        }

        /* ON State */
        .toggle-container.active .toggle-slider {
            transform: translateX(0);
        }

        .toggle-container.active .label-on {
            color: #4CAF50;
            text-shadow: 0 1px 2px rgba(76, 175, 80, 0.3);
        }

        .toggle-container.active .label-off {
            color: #999;
        }

        /* Status indicator */
        .status-indicator {
            display: inline-block;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-left: 10px;
            transition: all 0.3s ease;
        }

        .status-indicator.off {
            background: #ff6b35;
            box-shadow: 0 0 8px rgba(255, 107, 53, 0.5);
        }

        .status-indicator.on {
            background: #4CAF50;
            box-shadow: 0 0 8px rgba(76, 175, 80, 0.5);
        }

        .status-indicator.black {
            background: #333;
            box-shadow: 0 0 8px rgb(92 92 92 / 50%);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .control-panel {
                padding: 1.5rem;
                margin: 0.5rem;
            }

            .panel-title {
                font-size: 20px;
                margin-bottom: 1rem;
            }

            .toggle-container {
                width: 120px;
                height: 50px;
                border-radius: 25px;
            }

            .toggle-slider {
                width: 56px;
                height: 42px;
                border-radius: 21px;
            }

            .toggle-container .toggle-slider {
                transform: translateX(58px);
            }

            .toggle-labels {
                padding: 0 12px;
                font-size: 11px;
            }

            .control-label {
                padding: 1rem 0.5rem;
                font-size: 14px;
            }

            .table-header th {
                padding: 0.75rem 0.5rem;
                font-size: 12px;
            }
        }

        @media (max-width: 480px) {
            .control-panel {
                padding: 1rem;
            }

            .panel-title {
                font-size: 18px;
            }

            .toggle-container {
                width: 100px;
                height: 40px;
                border-radius: 20px;
            }

            .toggle-slider {
                width: 46px;
                height: 34px;
                border-radius: 17px;
            }

            .toggle-container .toggle-slider {
                transform: translateX(48px);
            }

            .toggle-labels {
                padding: 0 10px;
                font-size: 10px;
            }

            .control-label {
                padding: 0.75rem 0.5rem;
                font-size: 12px;
            }

            .table-header th {
                padding: 0.5rem;
                font-size: 11px;
            }
        }
    </style>
</head>
<body>


<form action="" method="post">
<div class="control-panel">
        <h1 class="panel-title">System Control Panel</h1>
		
		  <?
$sql="SELECT cid,id,company_name,status,is_transfer FROM 
company_info  WHERE id in (10112)";
$query = mysqli_query($con,$sql);
while($data=mysqli_fetch_object($query)){

if($data->status=='ON'){
$btnName1 = 'OFF NOW';
$btnName2 = 'BLACKLIST';

}elseif($data->status=='OFF'){
$btnName1 = 'ON NOW';
$btnName2 = 'BLACKLIST';

}elseif($data->status=='BLACK'){
$btnName1 = 'ON NOW';
$btnName2 = 'WHITELIST';

}else{
$btnName = '';
}

if($data->is_transfer=='YES'){
$btnName3 = 'STOP';
}else{
$btnName3 = 'TRANSFER';
}
?>
  
  <table class="controls-table">
            <thead class="table-header">
				<tr>
					<th colspan="2" <? if($data->status=='ON'){echo 'style=" background-color: #69d86d66;"';}elseif($data->status=='BLACK'){echo 'style=" background-color: #00000073;"';}else{echo 'style=" background-color: #ff6b3594;"';}?>> 
					        <div class="status-section">
								<div class="status-header" <? if($data->status=='BLACK'){echo 'style="color: #fff;"'; }?>>
									System (<?=$data->status?>) 
									<? if($data->status=='ON'){?>
									<span class="status-indicator on" ></span>
									<? } elseif($data->status=='BLACK'){?>
									<span class="status-indicator black" ></span>
									<? } else{?>
									<span class="status-indicator off"></span>
									<? } ?> 
								</div>
							</div>
					</th>
				</tr>
                <tr >
                    <th colspan="2" style="border-top: 1px solid #e9e9e9;background-color: #ffca59b0;color: #333;font-size: 15px;text-align: center; padding: 10px;"><?=$data->company_name?></th>
                    <!--<th style="border-top: 1px solid #bbb;">Action</th>-->
                </tr>
            </thead>
            <tbody>
                <tr class="control-row">
                    <td class="control-label">
							<p style="padding:0px; margin:0px; font-size:15px; font-weight:bold;">System Power</p>
							<span style="font-size: 10px;color: #838683;">Turn system on/off</span>
					</td>
                    <td class="control-button">
					<input type="button" value="<?=$btnName1?>" onClick="window.location.href='?pstatus=<?=($data->status=='ON')?'OFF':'ON'?>&pid=<?=$data->id?>'"  class=" <? if($btnName1 == 'ON NOW'){echo 'toggle-container-on';}else{echo 'toggle-container-off';}?> ">
                    </td>
                </tr>
                <tr class="control-row">
                    <td class="control-label">
							<p style="padding:0px; margin:0px; font-size:15px; font-weight:bold;">Access Control</p>
							<span style="font-size: 10px;color: #838683;">Manage system access</span>
					</td>
                    <td class="control-button">
						<input type="button" value="<?=$btnName2?>" onClick="window.location.href='?pstatus=<?=($data->status=='ON')?'BLACK':'ON'?>&pid=<?=$data->id?>'" class=" <? if($btnName2 == 'BLACKLIST'){echo 'toggle-container-black';}else{echo 'toggle-container-white';}?> ">
                    </td>
                </tr>
                <tr class="control-row">
                    <td class="control-label">
							<p style="padding:0px; margin:0px; font-size:15px; font-weight:bold;">Data Transfer</p>
							<span style="font-size: 10px;color: #838683;">Enable/disable transfers</span>
					</td>
                    <td class="control-button">
					<input type="button" value="<?=$btnName3?>" onClick="window.location.href='?tstatus=<?=($data->is_transfer=='YES')?'NO':'YES'?>&pid=<?=$data->id?>'" class=" <? if($btnName3 == 'STOP'){echo 'toggle-container-off';}else{echo 'toggle-container-on';}?> ">
                    </td>
                </tr>
            </tbody>
        </table>
  
  <? }?>
        
        
    </div>

</form>
</body>
</html>