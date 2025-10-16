function add_evaluation_section(section_name, section_percent, evaluation_method) {
		
  getData2(
    "evaluation_section_add_ajax.php",
    "section_details",
    section_name,
    section_percent+ "|" + evaluation_method
  );
}

function add_evaluation_section_child(
  section_id,
  section_child_name,
  section_child_percent
) {
  getData2(
    "add_evaluation_section_child_ajax.php",
    "section_child_details_" + section_id,
    section_id,
    section_child_name + "|" + section_child_percent
  );
}

function remove_section(section_id) {
  getData2("remove_section_ajax.php", "section_details", section_id);
}

function remove_section_child(section_id, child_id) {
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
