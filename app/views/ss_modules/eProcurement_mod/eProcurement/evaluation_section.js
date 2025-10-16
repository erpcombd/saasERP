function add_evaluation_section(section_name, section_percent, evaluation_method1,evaluation_method2) {
	
           if(document.getElementById('evaluation_method1').checked==true){
			var evaluation_method = evaluation_method1;
			}else if(document.getElementById('evaluation_method2').checked==true){
				var evaluation_method = evaluation_method2;
				}else{
					var evaluation_method = '';
					}
            var xhr = new XMLHttpRequest();

            xhr.open('POST', 'evaluation_section_add_ajax.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

           
            xhr.send('section_name=' + section_name + '&section_percent=' + section_percent + '&evaluation_method=' + evaluation_method1);

            
            xhr.onload = function() {
                if (xhr.status == 200) {
                  document.getElementById('event_section_percent').value='';
                  document.getElementById('event_section_name').value='';
					var res = JSON.parse(xhr.responseText);
            
                  get_section();
					
                }
            };
        }

function get_section(){
	
	        var section = 'section';
            var xhr = new XMLHttpRequest();

            xhr.open('POST', 'evaluation_section_get_ajax.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.send('section_name=' + section); 
            xhr.onload = function() {
                if (xhr.status == 200) {
					var res = JSON.parse(xhr.responseText);
                    document.getElementById('section_details').innerHTML = res['section_details'];
					document.getElementById('section_assign').innerHTML = res['section_assign'];
                  
					
                }
            };
	}
	
function get_eva_section(){
	var section = 'section';
	getData2("evaluation_section_for_assign_ajax.php", "section_assign", section);
	}

function remove_section(section_id) {
  var confirmation = confirm("Are you sure you want to remove this section?");
  if (confirmation) {
   var xhr = new XMLHttpRequest();

            xhr.open('POST', 'remove_section_ajax.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

           
            xhr.send('section_id=' + section_id);

            
            xhr.onload = function() {
                if (xhr.status == 200) {
					var res = JSON.parse(xhr.responseText);
                    get_section();
					
                }
            };
          }
 }
// function remove_section(section_id) {
//   // Show an alert and ask for user's decision
//   var decision = alert("Are you sure you want to remove this section?\n\nPress OK to proceed or Cancel to abort.");
  
//   // If user clicks OK, proceed with the removal
//   if (decision) {
//       var xhr = new XMLHttpRequest();
      
//       xhr.open('POST', 'remove_section_ajax.php', true);
//       xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

//       xhr.send('section_id=' + section_id);

//       xhr.onload = function() {
//           if (xhr.status == 200) {
//               var res = JSON.parse(xhr.responseText);
//               get_section();
//           }
//       };
//   } else {
//       // If user cancels, do nothing
//       return;
//   }
// }


function remove_section_child2(section_id, child_id) {
  getData2(
    "remove_section_child_ajax.php",
    "section_child_details_" + section_id,
    section_id,
    child_id
  );
}

function add_evaluator(evaulator, section) {
  getData2(
    "add_new_evaulator_ajax.php",
    "evaluator_details",
    evaulator,
    section
  );
}

function remove_evaluator(evaulator) {
  getData2("remove_evaluator_ajax.php", "evaluator_details", evaulator);
}


function add_evaluation_section_child(section_id,section_child_name,section_child_percent) {
           
            var xhr = new XMLHttpRequest();

            xhr.open('POST', 'add_evaluation_section_child_ajax.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

           
            xhr.send('section_id=' + section_id + '&section_child_name=' + section_child_name + '&section_child_percent=' + section_child_percent);

            
            xhr.onload = function() {
                if (xhr.status == 200) {
                  document.getElementById('section_child_percent'+section_id).value='';
                  document.getElementById('section_child'+section_id).value='';
					var res = JSON.parse(xhr.responseText);
                    document.getElementById('total_weight'+section_id).innerText = res['total_child_percent'];
					get_child(section_id);
					//document.getElementById('pass_policy').innerHTML = res['policy'];
					
                }
            };
        }
		
function remove_section_child(section_id, child_id) {
           
            var xhr = new XMLHttpRequest();

            xhr.open('POST', 'remove_section_child_ajax.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

           
            xhr.send('section_id=' + section_id + '&child_id=' + child_id);

            
            xhr.onload = function() {
                if (xhr.status == 200) {
					var res = JSON.parse(xhr.responseText);
                    document.getElementById('total_weight'+section_id).innerText = res['total_child_percent'];
					get_child(section_id);
					//document.getElementById('pass_policy').innerHTML = res['policy'];
					
                }
            };
        }
		
function get_child(section_id) {
	var section = "section_child_details_"+section_id;
  getData2("get_evaluation_child_ajax.php", section, section_id);
}