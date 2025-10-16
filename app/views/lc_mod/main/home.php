<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE . "routing/layout.top.php";
$title = 'L/C Management';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title><?=htmlspecialchars($title)?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- Fonts & Chart.js -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <style>
    :root {
  --primary: #1e90ff !important;
  --secondary: #2ecc71 !important;
  --warning: #f39c12 !important;
  --background: #f5f7fa !important;
  --card-bg: #ffffff !important;
  --text-dark: #2c3e50 !important;
  --text-muted: #7f8c8d !important;
}

body {
  font-family: 'Inter', sans-serif !important;
  background-color: var(--background) !important;
  margin: 0 !important;
  padding: 0 !important;
  color: var(--text-dark) !important;
}

.dashboard-container {
  padding: 40px !important;
  max-width: 1300px !important;
  margin: auto !important;
}

.hero {
  text-align: center !important;
  margin-bottom: 50px !important;
}

/* New Animated, Colorful Large Welcome Text */
@keyframes gradientAnimation {
  0% {
    background-position: 0% 50% !important;
  }
  50% {
    background-position: 100% 50% !important;
  }
  100% {
    background-position: 0% 50% !important;
  }
}

.hero h1 {
  font-size: 50px !important;  /* Force size to 50px */
  font-weight: 900 !important;

  background-size: 1000% 1000% !important;
  -webkit-background-clip: text !important;

  animation: gradientAnimation 10s ease infinite !important;

  text-shadow: 
    0 0 15px rgba(30, 144, 255, 0.8) !important, 
    0 0 30px rgba(46, 204, 113, 0.7) !important, 
    0 0 40px rgba(243, 156, 18, 0.6) !important;

  margin-bottom: 0 !important;
}

.card-container {
  display: flex !important;
  justify-content: space-between !important;
  margin-bottom: 50px !important;
  flex-wrap: wrap !important;
  gap: 20px !important;
}

.card {
  background-color: var(--card-bg) !important;
  padding: 30px !important;
  border-radius: 12px !important;
  box-shadow: 0 6px 20px rgba(0,0,0,0.06) !important;
  flex: 1 !important;
  min-width: 250px !important;
  text-align: center !important;
  cursor: pointer !important;
  transition: all 0.3s ease !important;
}

.card:hover {
  transform: translateY(-6px) !important;
  background-color: #f0f8ff !important;
}

.card h3 {
  font-size: 18px !important;
  font-weight: 500 !important;
  color: var(--text-muted) !important;
}

.card a {
  font-size: 34px !important;
  font-weight: 700 !important;
  text-decoration: none !important;
  color: var(--primary) !important;
  display: inline-block !important;
  margin-top: 8px !important;
  cursor: pointer !important;
  position: relative !important;
  transition: color 0.3s ease !important;
}

.card a:hover {
  text-decoration: underline !important;
  color: #155d9c !important;
}

.card a::after {
  content: '' !important;
  position: absolute !important;
  bottom: -5px !important;
  left: 0 !important;
  right: 0 !important;
  height: 2px !important;
  background-color: var(--primary) !important;
  transform-origin: left !important;
  transform: scaleX(0) !important;
  transition: transform 0.3s ease !important;
}

.card a:hover::after {
  transform: scaleX(1) !important;
}

.charts-row {
  display: flex !important;
  gap: 40px !important;
  margin-bottom: 40px !important;
  flex-wrap: wrap !important;
  justify-content: center !important;
}

.chart-box {
  background-color: var(--card-bg) !important;
  padding: 25px !important;
  border-radius: 12px !important;
  box-shadow: 0 6px 20px rgba(0,0,0,0.06) !important;
  flex: 1 !important;
  min-width: 450px !important;
  max-width: 600px !important;
}

.chart-box h4 {
  text-align: center !important;
  margin-bottom: 20px !important;
  font-size: 20px !important;
  color: var(--text-dark) !important;
  font-weight: 600 !important;
}

@media (max-width: 1024px) {
  .chart-box {
    min-width: 100% !important;
    max-width: 100% !important;
  }
}

  </style>
</head>
<body>

<div class="dashboard-container">

  <!-- Welcome -->
  <div class="hero">
    <h1>Welcome to the L/C Module</h1>
  </div>

  <!-- Summary Cards -->
  <div class="card-container">
    <div class="card" title="Click to view all L/C details">
      <h3>Total L/C Issued</h3>
      <a href="#" tabindex="0" aria-label="Total L/C Issued 248">248</a>
    </div>
    <div class="card" title="Click to view pending L/Cs">
      <h3>Pending L/C Approvals</h3>
      <a href="#" tabindex="0" aria-label="Pending L/C Approvals 37">37</a>
    </div>
    <div class="card" title="Click to view approved L/Cs">
      <h3>Approved L/Cs</h3>
      <a href="#" tabindex="0" aria-label="Approved L/Cs 192">192</a>
    </div>
  </div>

  <!-- First Row: Histogram & Pie Chart -->
  <div class="charts-row">
    <div class="chart-box">
      <h4>L/C Value Distribution (Histogram)</h4>
      <canvas id="histogramChart"></canvas>
    </div>
    <div class="chart-box">
      <h4>L/C Type Breakdown</h4>
      <canvas id="pieChart"></canvas>
    </div>
  </div>

  <!-- Second Row: Trend Analysis & Ogive Curve -->
  <div class="charts-row">
    <div class="chart-box">
      <h4>Trend Analysis (Monthly L/C Volume)</h4>
      <canvas id="trendChart"></canvas>
    </div>
    <div class="chart-box">
      <h4>Ogive Curve (Cumulative %)</h4>
      <canvas id="ogiveChart"></canvas>
    </div>
  </div>

</div>

<!-- Chart.js Scripts -->
<script>
  const months = ['Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'];
  const lcValues = [100000, 120000, 90000, 150000, 130000, 110000];
  const cumulative = lcValues.map((val, i, arr) => arr.slice(0, i + 1).reduce((a, b) => a + b, 0));
  const total = lcValues.reduce((a, b) => a + b, 0);
  const cumulativePercent = cumulative.map(v => ((v / total) * 100).toFixed(2));

  // Trend Line Chart
  new Chart(document.getElementById('trendChart'), {
    type: 'line',
    data: {
      labels: months,
      datasets: [{
        label: 'L/C Volume (USD)',
        data: lcValues,
        borderColor: '#1e90ff',
        backgroundColor: 'rgba(30, 144, 255, 0.15)',
        fill: true,
        tension: 0.4,
        pointRadius: 5,
        pointHoverRadius: 7,
        pointBackgroundColor: '#1e90ff',
        borderWidth: 3,
      }]
    },
    options: {
      responsive: true,
      interaction: {
        mode: 'nearest',
        intersect: false
      },
      plugins: {
        tooltip: {
          callbacks: {
            label: ctx => `$${ctx.parsed.y.toLocaleString()}`
          }
        },
        legend: {
          display: true,
          labels: {
            color: '#2c3e50',
            font: { weight: '600' }
          }
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            callback: value => '$' + value.toLocaleString(),
            color: '#2c3e50',
            font: { weight: '600' }
          },
          grid: { color: '#e1e8f0' }
        },
        x: {
          ticks: { color: '#2c3e50', font: { weight: '600' } },
          grid: { color: '#f0f4f8' }
        }
      }
    }
  });

  // Ogive Curve Chart
  new Chart(document.getElementById('ogiveChart'), {
    type: 'line',
    data: {
      labels: months,
      datasets: [{
        label: 'Cumulative %',
        data: cumulativePercent,
        borderColor: '#2ecc71',
        backgroundColor: 'rgba(46, 204, 113, 0.2)',
        fill: true,
        tension: 0.4,
        pointRadius: 5,
        pointHoverRadius: 7,
        pointBackgroundColor: '#2ecc71',
        borderWidth: 3,
      }]
    },
    options: {
      responsive: true,
      interaction: {
        mode: 'nearest',
        intersect: false
      },
      plugins: {
        tooltip: {
          callbacks: {
            label: ctx => ctx.parsed.y + '%'
          }
        },
        legend: {
          display: true,
          labels: {
            color: '#2c3e50',
            font: { weight: '600' }
          }
        }
      },
      scales: {
        y: {
          max: 100,
          ticks: {
            callback: value => value + '%',
            color: '#2c3e50',
            font: { weight: '600' }
          },
          grid: { color: '#e1e8f0' }
        },
        x: {
          ticks: { color: '#2c3e50', font: { weight: '600' } },
          grid: { color: '#f0f4f8' }
        }
      }
    }
  });

  // Histogram Chart
  const histogramData = [1, 3, 6, 2, 4, 1];
  new Chart(document.getElementById('histogramChart'), {
    type: 'bar',
    data: {
      labels: months,
      datasets: [{
        label: 'Frequency',
        data: histogramData,
        backgroundColor: 'rgba(243, 156, 18, 0.7)',
        borderColor: '#f39c12',
        borderWidth: 1,
        borderRadius: 5
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          display: true,
          labels: {
            color: '#2c3e50',
            font: { weight: '600' }
          }
        },
        tooltip: {
          enabled: true
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          stepSize: 1,
          ticks: {
            color: '#2c3e50',
            font: { weight: '600' }
          },
          grid: { color: '#e1e8f0' }
        },
        x: {
          ticks: { color: '#2c3e50', font: { weight: '600' } },
          grid: { color: '#f0f4f8' }
        }
      }
    }
  });

  // Pie Chart
  new Chart(document.getElementById('pieChart'), {
    type: 'pie',
    data: {
      labels: ['Sight L/C', 'Usance L/C', 'Deferred', 'Back-to-Back'],
      datasets: [{
        data: [40, 25, 20, 15],
        backgroundColor: [
          '#1abc9c',
          '#3498db',
          '#f39c12',
          '#e74c3c'
        ],
        borderColor: '#ffffff',
        borderWidth: 2
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: 'bottom',
          labels: {
            color: '#2c3e50',
            font: { weight: '600' }
          }
        },
        tooltip: {
          callbacks: {
            label: ctx => ctx.label + ': ' + ctx.parsed + '%'
          }
        }
      }
    }
  });
</script>

</body>
</html>

<?php
require_once SERVER_CORE."routing/layout.bottom.php";
?>
