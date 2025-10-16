<?php

session_start();

ob_start();

 
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Dashboard';



?>



<?php /*?>function randomPassword() {

    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";

    $pass = array(); //remember to declare $pass as an array

    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache

    for ($i = 0; $i < 5; $i++) {

        $n = rand(0, $alphaLength);

        $pass[] = $alphabet[$n];

    }

    return implode($pass); //turn the array into a string

}







$sql = 'select PBI_ID,PBI_CODE,JOB_LOCATION from personnel_basic_info where PBI_JOB_STATUS="In Service"';

$query = db_query($sql);



while($data = mysqli_fetch_object($query)){







   $password=randomPassword();





 $insert = 'insert into hrm_user_access (`user_name`,`emp_id`,`password`,`group_id`) values("'.$data->PBI_CODE.'","'.$data->PBI_ID.'","'.$password.'","'.$data->JOB_LOCATION.'")';

 db_query($insert);

<?php */?>




<style type="text/css">

<!--

.style1 {

	font-size: 24px;

	color: #006600;

}

-->

</style>





	

	

	<div class="">

            

            

            

            <div class="row">

                      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
<a href="../report/master_report.php?report=202&&lead_status=1" target="_blank">
                        <div class="tile-stats" style="background:#99FF66;">

                          <div class="icon"><i class="fa fa-caret-square-o-right"></i>

                          </div>

                          <div class="count"><?=find_a_field('crm_lead_master','count(lead_no)','1 and lead_status = 1');?></div>



                          <h3>Active Lead</h3>

                          <p>Customer Relationship Management</p>

                        </div>
						
						</a>

                      </div>

                      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
<a href="../report/master_report.php?report=201" target="_blank">
                        <div class="tile-stats" style="background:#CCFF33;">

                          <div class="icon"><i class="fa fa-comments-o"></i>

                          </div>

                          <div class="count"><?=find_a_field('crm_customer_info','count(dealer_code)',' 1 ');?></div>



                          <h3>Total Customer</h3>

                          <p>Customer Relationship Management</p>

                        </div>
</a>
                      </div>

                      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
<a href="../report/master_report.php?report=202" target="_blank">
                        <div class="tile-stats" style="background:#FFFF99;">

                          <div class="icon"><i class="fa fa-sort-amount-desc"></i>

                          </div>

                          <div class="count"><?=find_a_field('crm_lead_master','count(lead_no)',' 1 ');?></div>



                          <h3>Total Lead</h3>

                          <p>Customer Relationship Management</p>

                        </div>
</a>
                      </div>

                      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
<a href="../report/master_report.php?report=203" target="_blank">
                        <div class="tile-stats" style="background:#33CCCC;">

                          <div class="icon"><i class="fa fa-check-square-o"></i>

                          </div>

                          <div class="count"><?=find_a_field('crm_comunication','count(id)',' 1 ');?></div>



                          <h3>Total Communication</h3>

                          <p>Customer Relationship Management</p>

                        </div>
</a>
                      </div>

                    </div>

            

            <div class="clearfix"></div>



            <div class="row">

              

            </div>

            <div class="row">

              



              <div class="col-md-6 col-sm-6 col-xs-12">

                <div class="x_panel">

                  <div class="x_title">

                    <h2>Employee Graph <small> 2019</small></h2>

                    <ul class="nav navbar-right panel_toolbox">

                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>

                      </li>

                      <li class="dropdown">

                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>

                        <ul class="dropdown-menu" role="menu">

                          <li><a href="#">Settings 1</a>

                          </li>

                          <li><a href="#">Settings 2</a>

                          </li>

                        </ul>

                      </li>

                      <li><a class="close-link"><i class="fa fa-close"></i></a>

                      </li>

                    </ul>

                    <div class="clearfix"></div>

                  </div>

                  <div class="x_content">

                    <canvas id="mybarCharts"></canvas>

                  </div>

                </div>

              </div>

			  

			  <div class="col-md-6 col-sm-6 col-xs-12">

                <div class="x_panel">

                  <div class="x_title">

                    <h2>Payroll Graph <small> 2019</small></h2>

                    <ul class="nav navbar-right panel_toolbox">

                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>

                      </li>

                      <li class="dropdown">

                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>

                        <ul class="dropdown-menu" role="menu">

                          <li><a href="#">Settings 1</a>

                          </li>

                          <li><a href="#">Settings 2</a>

                          </li>

                        </ul>

                      </li>

                      <li><a class="close-link"><i class="fa fa-close"></i></a>

                      </li>

                    </ul>

                    <div class="clearfix"></div>

                  </div>

                  <div class="x_content">

                    <canvas id="canvasDoughnut"></canvas>

                  </div>

                </div>

              </div>

            </div>
			
			
			<div class="row">

              



              <div class="col-md-6 col-sm-6 col-xs-12">

                <div class="x_panel">

                  <div class="x_title">

                    <h2>Employee Graph <small> 2019</small></h2>

                    <ul class="nav navbar-right panel_toolbox">

                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>

                      </li>

                      <li class="dropdown">

                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>

                        <ul class="dropdown-menu" role="menu">

                          <li><a href="#">Settings 1</a>

                          </li>

                          <li><a href="#">Settings 2</a>

                          </li>

                        </ul>

                      </li>

                      <li><a class="close-link"><i class="fa fa-close"></i></a>

                      </li>

                    </ul>

                    <div class="clearfix"></div>

                  </div>

                  <div class="x_content">
<div class="canvas-holder">
                    <canvas id="myChartS" width="250" height="125"></canvas>
</div>

                  </div>

                </div>

              </div>

			  

			  <div class="col-md-6 col-sm-6 col-xs-12">

                <div class="x_panel">

                  <div class="x_title">

                    <h2>Payroll Graph <small> 2019</small></h2>

                    <ul class="nav navbar-right panel_toolbox">

                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>

                      </li>

                      <li class="dropdown">

                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>

                        <ul class="dropdown-menu" role="menu">

                          <li><a href="#">Settings 1</a>

                          </li>

                          <li><a href="#">Settings 2</a>

                          </li>

                        </ul>

                      </li>

                      <li><a class="close-link"><i class="fa fa-close"></i></a>

                      </li>

                    </ul>

                    <div class="clearfix"></div>

                  </div>

                  <div class="x_content">

                    <div class="canvas-holder">
                    <canvas id="myChartSs" width="250" height="125"></canvas>
</div>

                  </div>

                </div>

              </div>

            </div>
			
			
			<div class="row">

              



              <div class="col-md-6 col-sm-6 col-xs-12">

                <div class="x_panel">

                  <div class="x_title">

                    <h2>Employee Graph <small> 2019</small></h2>

                    <ul class="nav navbar-right panel_toolbox">

                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>

                      </li>

                      <li class="dropdown">

                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>

                        <ul class="dropdown-menu" role="menu">

                          <li><a href="#">Settings 1</a>

                          </li>

                          <li><a href="#">Settings 2</a>

                          </li>

                        </ul>

                      </li>

                      <li><a class="close-link"><i class="fa fa-close"></i></a>

                      </li>

                    </ul>

                    <div class="clearfix"></div>

                  </div>

                  <div class="x_content">
<div class="canvas-holder">
                    <canvas id="myChartSsss" width="250" height="125"></canvas>
</div>

                  </div>

                </div>

              </div>

			  

			  <div class="col-md-6 col-sm-6 col-xs-12">

                <div class="x_panel">

                  <div class="x_title">

                    <h2>Payroll Graph <small> 2019</small></h2>

                    <ul class="nav navbar-right panel_toolbox">

                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>

                      </li>

                      <li class="dropdown">

                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>

                        <ul class="dropdown-menu" role="menu">

                          <li><a href="#">Settings 1</a>

                          </li>

                          <li><a href="#">Settings 2</a>

                          </li>

                        </ul>

                      </li>

                      <li><a class="close-link"><i class="fa fa-close"></i></a>

                      </li>

                    </ul>

                    <div class="clearfix"></div>

                  </div>

                  <div class="x_content">

                    <div class="canvas-holder">
                    <canvas id="myChartSss" width="250" height="125"></canvas>
</div>

                  </div>

                </div>

              </div>

            </div>
			
			
			<div class="row">

              



              <div class="col-md-6 col-sm-6 col-xs-12">

                <div class="x_panel">

                  <div class="x_title">

                    <h2>Employee Graph <small> 2019</small></h2>

                    <ul class="nav navbar-right panel_toolbox">

                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>

                      </li>

                      <li class="dropdown">

                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>

                        <ul class="dropdown-menu" role="menu">

                          <li><a href="#">Settings 1</a>

                          </li>

                          <li><a href="#">Settings 2</a>

                          </li>

                        </ul>

                      </li>

                      <li><a class="close-link"><i class="fa fa-close"></i></a>

                      </li>

                    </ul>

                    <div class="clearfix"></div>

                  </div>

                  <div class="x_content">
<div class="canvas-holder">
                    <canvas id="radarChart" width="250" height="125"></canvas>
</div>

                  </div>

                </div>

              </div>

			  

			  <div class="col-md-6 col-sm-6 col-xs-12">

                <div class="x_panel">

                  <div class="x_title">

                    <h2>Payroll Graph <small> 2019</small></h2>

                    <ul class="nav navbar-right panel_toolbox">

                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>

                      </li>

                      <li class="dropdown">

                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>

                        <ul class="dropdown-menu" role="menu">

                          <li><a href="#">Settings 1</a>

                          </li>

                          <li><a href="#">Settings 2</a>

                          </li>

                        </ul>

                      </li>

                      <li><a class="close-link"><i class="fa fa-close"></i></a>

                      </li>

                    </ul>

                    <div class="clearfix"></div>

                  </div>

                  <div class="x_content">

                    <div class="canvas-holder">
                    <canvas id="bubbleChart" width="250" height="125"></canvas>
</div>

                  </div>

                </div>

              </div>

            </div>

          </div>



<?

$main_content=ob_get_contents();

ob_end_clean();

require_once SERVER_CORE."routing/layout.bottom.php";

?>

<script>
var ctx = document.getElementById("mybarCharts");
var mybarChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange","Orange"],
        datasets: [{
            label: '# of Votes',
            data: [12, 19, 3, 5, 2, 3],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
</script>


<script>
var ctx = document.getElementById("myChartS");
var myChartS = new Chart(ctx, {
   type: 'polarArea',
    data: {
        labels: ["Red",
		"Green",
		"Yellow",
		"Grey",
		"Blue"],
        datasets: [{
            label: '# of Votes',
            data: [11,
			16,
			7,
			3,
			14],
            backgroundColor: [
                "#FF6384",
			"#4BC0C0",
			"#FFCE56",
			"#E7E9ED",
			"#36A2EB"
            ],
            borderWidth: 1
        }]
    },
    options: {
		elements: {
			arc: {
				borderColor: "#000000"
			}
		}
	}
});
</script>



<script>
var ctx = document.getElementById("myChartSs");
var myChartSs = new Chart(ctx, {
   type: 'bar',
    data: {
        labels: ["January", "February", "March", "April", "May", "June", "July", "Augest","September","October","November","December"],
        datasets: [{
			label: "My First dataset",
			backgroundColor: "rgba(255,99,132,0.2)",
			borderColor: "rgba(255,99,132,1)",
			borderWidth: 1,
			hoverBackgroundColor: "rgba(255,99,132,0.4)",
			hoverBorderColor: "rgba(255,99,132,1)",
			data: [65, 59, 80, 81, 56, 55, 40,100,90,87,98,95.5],
        }]
    },
    options: {
		scales: {
				xAxes: [{
						stacked: true
				}],
				yAxes: [{
						stacked: true
				}]
			}}
});
</script>

<script>
var ctx = document.getElementById("myChartSss");
var myChartSss = new Chart(ctx, {
  	type: 'line',
    data: {
        labels: ["January", "February", "March", "April", "May", "June", "July"],
        datasets: [{label: "My First dataset",
			fill: false,
			lineTension: 0.1,
			backgroundColor: "rgba(75,192,192,0.4)",
			borderColor: "rgba(75,192,192,1)",
			borderCapStyle: 'butt',
			borderDash: [],
			borderDashOffset: 0.0,
			borderJoinStyle: 'miter',
			pointBorderColor: "rgba(75,192,192,1)",
			pointBackgroundColor: "#fff",
			pointBorderWidth: 1,
			pointHoverRadius: 5,
			pointHoverBackgroundColor: "rgba(75,192,192,1)",
			pointHoverBorderColor: "rgba(220,220,220,1)",
			pointHoverBorderWidth: 2,
			pointRadius: 1,
			pointHitRadius: 10,
			data: [65, 59, 80, 81, 56, 55, 40],
        }]
    },
    options: {
		
		
		
		scales: {
			xAxes: [{
				type: 'linear',
				position: 'bottom'
			}]
		}
		
		
		}
});
</script>


<script>
var ctx = document.getElementById("myChartSsss");
var myChartSsss = new Chart(ctx, {
  	type: 'pie',
    data: {
        labels: [
        "Red",
        "Blue",
        "Yellow"
    ],
        datasets: [{
		
		
		
            data: [300, 50, 100],
            backgroundColor: [
                "#FF6384",
                "#36A2EB",
                "#FFCE56"
            ],
            hoverBackgroundColor: [
                "#FF6384",
                "#36A2EB",
                "#FFCE56"
            ]
		
		
		
		}]
    }
});
</script>


<script>
var ctx = document.getElementById("bubbleChart");
var bubbleChart = new Chart(ctx, {
  	type: 'bubble',
    data: {
        label: 'First Dataset',
        datasets: [{
		
		
		
            data: [ {
                    x: 20,
                    y: 30,
                    r: 15
                },
                {
                    x: 40,
                    y: 10,
                    r: 10
                }],
            backgroundColor:"#FF6384",
            hoverBackgroundColor: "#FF6384",
		
		
		
		}]
    },
	  options: {
		
		
	elements: {
            points: {
                borderWidth: 1,
                borderColor: 'rgb(0, 0, 0)'
            }
        }
		
		
		}
});
</script>

<script>
var ctx = document.getElementById("radarChart");
var radarChart = new Chart(ctx, {
  	type: 'radar',
    data: {
        labels: ["Eating", "Drinking", "Sleeping", "Designing", "Coding", "Cycling", "Running"],
     datasets: [
		{
			label: "My First dataset",
			backgroundColor: "rgba(179,181,198,0.2)",
			borderColor: "rgba(179,181,198,1)",
			pointBackgroundColor: "rgba(179,181,198,1)",
			pointBorderColor: "#fff",
			pointHoverBackgroundColor: "#fff",
			pointHoverBorderColor: "rgba(179,181,198,1)",
			data: [65, 59, 90, 81, 56, 55, 40]
		},
		{
			label: "My Second dataset",
			backgroundColor: "rgba(255,99,132,0.2)",
			borderColor: "rgba(255,99,132,1)",
			pointBackgroundColor: "rgba(255,99,132,1)",
			pointBorderColor: "#fff",
			pointHoverBackgroundColor: "#fff",
			pointHoverBorderColor: "rgba(255,99,132,1)",
			data: [28, 48, 40, 19, 96, 27, 100]
		}
	]
    },
	  options: {
		
		
	scale: {
				reverse: true,
				ticks: {
					beginAtZero: true
				}
			}
		
		
		}
});
</script>