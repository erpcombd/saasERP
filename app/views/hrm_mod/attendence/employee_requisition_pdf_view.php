<?php
require_once "../../../controllers/routing/default_values.php";

require_once SERVER_CORE."routing/layout.top.php";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<link href="../../../assets/css/invoice.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript">
function hide()
{
    document.getElementById("pr").style.display="none";
}
</script>

<?php


$view_id = $_GET['id'];
$view_id;

$query = "SELECT * FROM `employee_requisition`  WHERE `emp_req_id`='$view_id'";
$ins_sql= db_query($query);
    while($row = mysqli_fetch_assoc($ins_sql)) {
		$date = $row['date'];
        $section_name = $row['section_name'];
        $job_title = $row['job_title'];
        $required_staff = $row['required_staff'];
        $current_staff = $row['current_staff'];
        $required_current_staff = $row['required_current_staff'];
        $male_count = $row['male_count'];
        $female_count = $row['female_count'];
        $reason_for_demand = $row['reason_for_demand'];
		$educational_qualification = $row['educational_qualification'];
        $experience = $row['experience'];
		$salary = $row['salary'];
	}
		?>



<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>স্টার লাইন ফুড প্রোডাক্টস্ লিঃ</title>
</head>

<style>
	table {
		border-collapse: collapse;
		width: 100%;

	}
	.padding {
		width: 70%;
	}
	#heading {
		height: 50px;
		text-align: center;
		font-size: 20px;
	}
	@media print {
		body {
			zoom: 80%;
		}
	}
	
	button.print-button {
  width: 100px;
  height: 100px;
}
span.print-icon, span.print-icon::before, span.print-icon::after, button.print-button:hover .print-icon::after {
  border: solid 4px #333;
}
span.print-icon::after {
  border-width: 2px;
}

button.print-button {
  position: relative;
  padding: 0;
  border: 0;
  
  border: none;
  background: transparent;
}

span.print-icon, span.print-icon::before, span.print-icon::after, button.print-button:hover .print-icon::after {
  box-sizing: border-box;
  background-color: #fff;
}

span.print-icon {
  position: relative;
  display: inline-block;  
  padding: 0;
  margin-top: 20%;

  width: 60%;
  height: 35%;
  background: #fff;
  border-radius: 20% 20% 0 0;
}

span.print-icon::before {
  content: "";
  position: absolute;
  bottom: 100%;
  left: 12%;
  right: 12%;
  height: 110%;

  transition: height .2s .15s;
}

span.print-icon::after {
  content: "";
  position: absolute;
  top: 55%;
  left: 12%;
  right: 12%;
  height: 0%;
  background: #fff;
  background-repeat: no-repeat;
  background-size: 70% 90%;
  background-position: center;
  background-image: linear-gradient(
    to top,
    #fff 0, #fff 14%,
    #333 14%, #333 28%,
    #fff 28%, #fff 42%,
    #333 42%, #333 56%,
    #fff 56%, #fff 70%,
    #333 70%, #333 84%,
    #fff 84%, #fff 100%
  );

  transition: height .2s, border-width 0s .2s, width 0s .2s;
}

button.print-button:hover {
  cursor: pointer;
}

button.print-button:hover .print-icon::before {
  height:0px;
  transition: height .2s;
}
button.print-button:hover .print-icon::after {
  height:120%;
  transition: height .2s .15s, border-width 0s .16s;
}

	
	
</style>

<body>
<div align="center" id="pr">

<button class="print-button" type="button" value="Print" onclick="hide();window.print();" ><span class="print-icon"> Print </span></button>


</div>
	<table style="
	border: 2px solid black;
	">
		<tr>
			<td>
				<div align="center" style="margin:5px;">
					<img src="https://starlineerp.com/CloudERP/logo/starline.png" alt="Starline Logo" style="width:150px;height:150px;">
				</div>
			</td>
		</tr>
		<tr>
			<th colspan="10" id="heading">স্টার লাইন ফুড প্রোডাক্টস্ লিঃ</th>
		</tr>

		<tr>
			<td colspan="10">
				<div align="center" style="margin-bottom:15px;">দক্ষিণ কশিমপুর, ফেনী।</div>
			</td>

		</tr>
		<tr>
			<td colspan="10">
				<div align="center" style="margin-bottom:15px;">কর্মকর্তা/কর্মচারী নিয়োগের চাহিদা পত্র।</div>
			</td>
		</tr>



		<tr>
			<td>
				<table style="width: 50%;margin: auto;">
				

		
    


					<tr>
						<th>
							<div align="left"><strong>তারিখ:</strong></div>
						</th>
						<td><?php echo $date; ?></td>
					</tr>
					<tr>
						<td>
							<div align="left"><strong>সেকশনের নাম:</strong></div>
						</td>
						<td><?php echo $section_name; ?></td>
					</tr>
					<tr>
						<td>
							<div align="left"><strong>পদের নাম:</strong></div>
						</td>
						<td><?php echo $job_title; ?></td>
					</tr>
					<tr>
						<td>
							<div align="left"><strong>প্রয়োজনীয় জনবল চাহিদা:</strong></div>
						</td>
						<td><?php echo $required_staff; ?></td>
					</tr>
					<tr>
						<td>
							<div align="left"><strong>বর্তমান নিয়োগ প্রাপ্ত জনবল:</strong></div>
						</td>
						<td><?php echo $current_staff; ?></td>
					</tr>
					<tr>
						<td>
							<div align="left"><strong>বর্তমানে চাহিদাকৃত জনবল:</strong></div>
						</td>
						<td><?php echo $required_current_staff; ?></td>
					</tr>
					<tr>
						<td>
							<div align="left"><strong>পুরুষ:</strong></div>
						</td>
						<td><?php echo $male_count; ?></td>
					</tr>
					<tr>
						<td>
							<div align="left"><strong>মহিলা:</strong></div>
						</td>
						<td><?php echo $female_count; ?></td>
					</tr>
					<tr>
						<td>
							<div align="left"><strong>চাহিদার কারন:</strong></div>
						</td>
						<td><?php echo $reason_for_demand; ?></td>
					</tr>
					<tr>
						<td>
							<div align="left"><strong>শিক্ষাগত যোগ্যতা:</strong></div>
						</td>
						<td><?php echo $educational_qualification; ?></td>
					</tr>
					<tr>
						<td>
							<div align="left"><strong>অভিজ্ঞতা:</strong></div>
						</td>
						<td><?php echo $experience; ?></td>
					</tr>
					<tr>
						<td>
							<div align="left"><strong>বেতন:</strong></div>
						</td>
						<td>
						<?php echo $salary; ?>
<!--							<div align="left"><strong>পুরুষ(প্রসেসিং- ), (প্যাকেজিং- )</strong></div>
							<div align="left"><strong>মহিলা(প্রসেসিং- ), (প্যাকেজিং- )</strong></div>-->
						</td>

					</tr>
				</table>
			</td>
		</tr>



		<!-- Sign -->

		<tr>
			<td colspan="16">
				<table width="100%" height="100px" style="margin-top:100px;">
					<tr>
						<td width="16.66%">
							<div align="center">
								<p style="text-decoration: overline;"><strong>সেকশন প্রধান</strong></p>
						</td>
						<td width="16.66%">
							<div align="center">
								<p style="text-decoration: overline;"><strong>এজিএম,(প্রশাসন)</strong></p>
						</td>
						<td width="16.66%">
							<div align="center">
								<p style="text-decoration: overline;"><strong>ডিজিএম(কারখানা অপারেশন)</strong></p>
						</td>
						<td width="16.66%">
							<div align="center">
								<p style="text-decoration: overline;"><strong>জিএম, (কারখানা)</strong></p>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="16">
				<table width="100%" height="100px" style="margin-top:100px;">
					<tr>
						<td width="16.66%">
							<div align="center">
								<p style="text-decoration: overline;"><strong>এজিএম, (এইচআর অ্যান্ড এডমিন)</strong></p>
						</td>
						<td width="16.66%">
							<div align="center">
								<p style="text-decoration: overline;"><strong>অনুমোদনকারী</strong></p>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</body>

</html>



