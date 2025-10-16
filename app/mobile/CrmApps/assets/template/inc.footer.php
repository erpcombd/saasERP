    




<!--<script type="text/javascript" src="../styles/select2.min.js"></script>
<script type="text/javascript" src="../styles/jquery-3.4.1.min.js"></script>-->

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var ctx = document.getElementById('leadChart').getContext('2d');
        var leadData = {
            labels: ['Total Active Lead', 'Total Generated Lead'],
            datasets: [{
                data: [
                    <?=find_a_field('crm_project_lead', 'count(id)', 'status = "1"')?>,
                    <?=find_a_field('crm_project_lead', 'count(id)', '1')?>
                ],
                backgroundColor: ['#F7E3EE', '#D8F0FA']
            }]
        };
        var leadChart = new Chart(ctx, {
            type: 'pie',
            data: leadData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    position: 'bottom'
                }
            }
        });
    });

    function openModalleadentry(orgId, orgName, orgwebsite,orgyearlyturnover,sourcename,orgemployee,orgtype,orgaddress,orgdistrict,
	orgzip,orgcountry,orgdivision,orgdescription,orgconperson,orgconnumber,orgconmail) {
      orgdescription = orgdescription.replace(/"/g, "");

      // description = description.replace(/\n/g, '<br>');

 
      
        // document.getElementById('id').value = contactId;
        document.getElementById('orgsavebtn').classList.add('d-none');// or 'inline' depending on your styling
        document.getElementById('orgentryeditbtn').classList.remove('d-none');// or 'inline' depending on your styling
        document.getElementById('orgname').value = orgName;
 
       var selectElement = document.getElementById('lead_source');
// Check if the correct select element is found
for (var i = 0; i < selectElement.options.length; i++) {
  // Check the value of each option
    if (selectElement.options[i].value == sourcename) {
        selectElement.options[i].selected = true;
        break;
    }
}
        // document.getElementById('lead_type').value = orgName;
       var selectElement = document.getElementById('lead_type');
// Check if the correct select element is found
for (var i = 0; i < selectElement.options.length; i++) {
    // Check the value of each option
    if (selectElement.options[i].value == orgtype) {
        selectElement.options[i].selected = true;
        break;
    }
}
       var selectElement = document.getElementById('district');
// Check if the correct select element is found
for (var i = 0; i < selectElement.options.length; i++) {
    // Check the value of each option
    if (selectElement.options[i].value == orgdistrict) {
        selectElement.options[i].selected = true;
        break;
    }
}
       var selectElement = document.getElementById('zip');
// Check if the correct select element is found
for (var i = 0; i < selectElement.options.length; i++) {
    // Check the value of each option
    if (selectElement.options[i].value == orgzip) {
        selectElement.options[i].selected = true;
        break;
    }
}
       var selectElement = document.getElementById('country');
// Check if the correct select element is found
for (var i = 0; i < selectElement.options.length; i++) {
    // Check the value of each option
    if (selectElement.options[i].value == orgcountry) {
        selectElement.options[i].selected = true;
        break;
    }
}
       var selectElement = document.getElementById('division');
// Check if the correct select element is found
for (var i = 0; i < selectElement.options.length; i++) {
    // Check the value of each option
    if (selectElement.options[i].value == orgdivision) {
        selectElement.options[i].selected = true;
        break;
    }
}

        document.getElementById('annual_revenue').value = orgyearlyturnover;
        document.getElementById('website').value = orgwebsite;
        document.getElementById('total_employees').value = orgemployee;
        document.getElementById('orgaddress').value = orgaddress;
		document.getElementById('contact_person').value = orgconperson;
		document.getElementById('contact_number').value = orgconnumber;
		document.getElementById('contact_email').value = orgconmail;
	    // document.getElementById('lead_type').value = orgtype;
        
        var idInput = document.createElement('input');
        idInput.setAttribute('type', 'hidden');
        idInput.setAttribute('name', 'id');
        idInput.setAttribute('id', 'id');
        idInput.setAttribute('value', orgId);

        // Append the id input field to the form using the form's ID
        var form = document.getElementById('organizationentrytable');
        form.appendChild(idInput);

        document.getElementById('description').value = orgdescription;

    }
    function openModalConverttolead(orgId,orgName) {
 
      document.getElementById('organization').value = orgId;
      document.getElementById('organizationnamelead').value = orgName;
    }
  
</script>


<script>
        $(document).ready(function () {
        $('#example1').DataTable();
		$('#example').DataTable();
		 table.page.len(10).draw();
    });

    $('#leadentrymodal').on('hidden.bs.modal', function(e) {
  $(this).find('#organizationentrytable')[0].reset();
});
    $('#convertToLead').on('hidden.bs.modal', function(e) {
  $(this).find('#converttoleadform')[0].reset();
});
</script>

<script>
function togglecustomerlist(){
    document.getElementById("customerlistid").style.display = "block";
    document.getElementById("customerlistbutton").style.backgroundColor = "#0c8";
    document.getElementById("customerleadbutton").style.backgroundColor = "#3d90a7";
    document.getElementById("customerleadbutton").style.transform = "scale(1)";
    document.getElementById("leadlistid").style.display = "none";
}

function toggleleadlist(){
    document.getElementById("leadlistid").style.display = "block";
    document.getElementById("customerleadbutton").style.backgroundColor = "#0c8";
    document.getElementById("customerlistbutton").style.backgroundColor = "#3d90a7";
    document.getElementById("customerlistbutton").style.transform = "scale(1)";
    document.getElementById("customerlistid").style.display = "none";
}
</script>




<script type="text/javascript" src="../assets/scripts/bootstrap.min.js"></script>
<script type="text/javascript" src="../assets/plugins/charts/charts.js"></script>
<script type="text/javascript" src="../assets/scripts/custom.js"></script>
<script type="text/javascript" src = "../../../../public/assets/js/jquery-3.4.1.min.js"></script>
<script type="text/javascript" src="../../../../public/assets/js/select2.min.js"></script>
</body>