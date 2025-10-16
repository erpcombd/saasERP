
<div class="tab-pane fade" id="tab8" role="tabpanel" aria-labelledby="reverse-tab">
    
 <style>
      #item_unique_name {
    display: grid;
    place-items: center;     
    text-align: center;
    width: 100%;      
  }
 </style>
<div class="row m-0 p-0 pt-4">
<div id="item_unique_name"></div>
<div style=" padding-top: 10px; ">
		<div class="form-group row m-0 p-0" style=" width: 200px; ">
		<label for="inputPassword" class="col-sm-2 col-form-label fs-14" style=" padding: 3px; color: white; font-weight: 600 !important; text-align: end; ">View</label>
		<div class="col-sm-10">

				 <style>
					.dropdown-toggle::after {
    display: inline-block;
    margin-left: .255em;
    vertical-align: .255em;
    content: "";
    border-top: .3em solid;
    border-right: .3em solid transparent;
    border-bottom: 0;
    border-left: .3em solid transparent;
    float: right !important;
    margin-top: 7px;
}
				 </style>
<div class="btn-group w-100">
  <button class="btn btn-secondary text-left btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style=" background-color: white; color: #333; border: 1px solid #6c757d;;">
    Item List
  </button>
  <div class="dropdown-menu w-100">
  <p style="cursor: pointer !important" onclick="graph_toggle('all','All Item')">All</p>

  <?
					$sqlb_tt = 'select r.*,i.item_name from rfq_item_details r join item_info i on r.item_id=i.item_id where r.rfq_no="'.$_SESSION['rfq_no'].'"';
					$qryb_tt = db_query($sqlb_tt);
					while($latest=mysqli_fetch_object($qryb_tt)){
                      ?>
					  <p style="cursor: pointer !important" onclick="graph_toggle(<?=$latest->item_id?>,'<?=$latest->item_name?>')"><?=$latest->item_name?></p>
					  <?
					} ?>
  </div>
</div>
		</div>
	  </div>
  </div>
  <input type="hidden"id="current_item_value" value="all">
<div id="rfq_all_item_chart"  width="400" height="200" style="width: 1000px !important;">
<canvas id="rfqChart" width="400" height="200"></canvas>
</div>
<div id="rfq_individual_item_chart"   width="400" height="200" style="display:none; width: 1000px !important;">
<canvas id="rfqChart_item_wise" width="400" height="200"></canvas>
</div>
				
</div>


</div>
<script src="chart.js"></script>
<script src="chartadapter.js"></script>
<script>
      bidconsoletab();
setInterval(function() {
    // Check if the URL contains "tab8" and call the function if true
    if (window.location.href.indexOf("tab8") > -1) {
        bidconsoletab();
    }
}, 5000);
function graph_toggle(item_id,item_name){
    $('#current_item_value').val(item_id);
    $('#item_unique_name').text(item_name);

    bidconsoletab(-89);
}

var usedColors = {};
var chartInstance = null; // Store the chart instance globally

function bidconsoletab(itemId) {
    var rfq_no = <?= $_SESSION['rfq_no'] ?>;
    var user_id = <?= $_SESSION['user']['id']; ?>;
    var currentItemValue = $('#current_item_value').val();
    if(currentItemValue=='all'){
        api_end_point='../api/bid_selcted_all_item_graph_api.php';
    }else{
        api_end_point='../api/bid_selcted_individual_item_graph_api.php';
    }

    $.ajax({
        url: api_end_point,
        type: 'POST',
        dataType: 'json',
        contentType: 'application/json',
        data: JSON.stringify({
            rfq_no: rfq_no,
            item_id: currentItemValue
        }),
        success: function(response) {
            var ctx = document.getElementById('rfqChart').getContext('2d');
            var datasets = [];
            var allEntryDates = response.all_entry_dates; // X-axis data (all entry_at dates)

            // Loop through each vendor's data to create multiple lines
            response.vendors.forEach(function(vendor, index) {
                // Align the vendor's prices with the corresponding entry_at date on the X-axis
                var alignedPrices = allEntryDates.map(function(entryAt) {
                    // Return the price for this entry_at, or null if the vendor has no data for this entry_at
                    return vendor.prices[entryAt] || null;
                });

                // Check if the vendor already has a color, otherwise assign a new one
                if (!usedColors[vendor.vendor_name]) {
                    usedColors[vendor.vendor_name] = getUniqueColor(index, response.vendors.length);
                }

                datasets.push({
                    label: vendor.vendor_name, // Use vendor name as the label
                    data: alignedPrices, // Aligned prices for all entry_at dates
                    borderColor: usedColors[vendor.vendor_name], // Use the same color for each vendor
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderWidth: 3, // Make the line thicker
                    fill: false, // Set to false for line graphs
                    spanGaps: true // This will connect the lines even when data points are missing
                });
            });

            // If the chart instance exists, update it, otherwise create it
            if (chartInstance) {
                chartInstance.data.labels = allEntryDates;
                chartInstance.data.datasets = datasets;
                chartInstance.update(); // Update the chart with new data
            } else {
                chartInstance = new Chart(ctx, {
                    type: 'line', // Use 'line' for multi-line graph
                    data: {
                        labels: allEntryDates, // X-axis labels (entry_at dates)
                        datasets: datasets // Data for each vendor
                    },
                    options: {
                        animation: false, // Disable animations
                        responsive: true,
                    }
                });
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
}


function bidconsoletab_item_wise(itemId) {
    var rfq_no = <?= $_SESSION['rfq_no'] ?>;
    var user_id = <?= $_SESSION['user']['id']; ?>;

    $.ajax({
        url: '../api/bid_selcted_all_item_graph_api.php',
        type: 'POST',
        dataType: 'json',
        contentType: 'application/json',
        data: JSON.stringify({
            rfq_no: rfq_no,
            item_id: itemId
        }),
        success: function(response) {
            var ctx = document.getElementById('rfqChart').getContext('2d');
            var datasets = [];
            var allEntryDates = response.all_entry_dates; // X-axis data (all entry_at dates)

            // Loop through each vendor's data to create multiple lines
            response.vendors.forEach(function(vendor, index) {
                // Align the vendor's prices with the corresponding entry_at date on the X-axis
                var alignedPrices = allEntryDates.map(function(entryAt) {
                    // Return the price for this entry_at, or null if the vendor has no data for this entry_at
                    return vendor.prices[entryAt] || null;
                });

                // Check if the vendor already has a color, otherwise assign a new one
                if (!usedColors[vendor.vendor_name]) {
                    usedColors[vendor.vendor_name] = getUniqueColor(index, response.vendors.length);
                }

                datasets.push({
                    label: vendor.vendor_name, // Use vendor name as the label
                    data: alignedPrices, // Aligned prices for all entry_at dates
                    borderColor: usedColors[vendor.vendor_name], // Use the same color for each vendor
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderWidth: 3, // Make the line thicker
                    fill: false, // Set to false for line graphs
                    spanGaps: true // This will connect the lines even when data points are missing
                });
            });

            // If the chart instance exists, update it, otherwise create it
            if (chartInstance) {
                chartInstance.data.labels = allEntryDates;
                chartInstance.data.datasets = datasets;
                chartInstance.update(); // Update the chart with new data
            } else {
                chartInstance = new Chart(ctx, {
                    type: 'line', // Use 'line' for multi-line graph
                    data: {
                        labels: allEntryDates, // X-axis labels (entry_at dates)
                        datasets: datasets // Data for each vendor
                    },
                    options: {
                        animation: false, // Disable animations
                        responsive: true,
                    }
                });
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
}

// Function to generate a unique color for each vendor based on the total number of vendors
function getUniqueColor(index, totalVendors) {
    var hue = (index * 360 / totalVendors) % 360; // Evenly distribute hues across the color wheel
    var saturation = 70 + Math.random() * 20; // Saturation: 70-90% for vibrancy
    var lightness = 50 + Math.random() * 10; // Lightness: 50-60% for balance

    return `hsl(${hue}, ${saturation}%, ${lightness}%)`; // HSL color format
}

</script>
