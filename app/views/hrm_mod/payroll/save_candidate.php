<?php
require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');




try {
    // Validate required fields
    $required_fields = ['full_name', 'email', 'phone', 'address', 'work_experience_years', 'highest_degree'];
    foreach ($required_fields as $field) {
        if (!isset($_POST[$field]) || empty($_POST[$field])) {
            throw new Exception("$field is required");
        }
    }

    // Generate unique token
    $token = md5(uniqid(rand(), true));
    
    // Prepare data for insertion
    $data = [
        'full_name' => $_POST['full_name'],
        'email' => $_POST['email'],
        'phone' => $_POST['phone'],
        'address' => $_POST['address'],
        'work_experience_years' => $_POST['work_experience_years'],
        'current_position' => $_POST['current_position'] ?? null,
        'work_experience_details' => $_POST['work_experience_details'] ?? null,
        'highest_degree' => $_POST['highest_degree'],
        'graduation_year' => $_POST['graduation_year'] ?? null,
        'education_details' => $_POST['education_details'] ?? null,
        'skills' => $_POST['skills'] ?? null,
        'additional_info' => $_POST['additional_info'] ?? null,
        'token' => $token,
        'created_at' => date('Y-m-d H:i:s')
    ];

    // Insert into database
    $crud = new crud('candidate_profiles');
    $result = $crud->insert($data);

    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Candidate profile created successfully']);
    } else {
        throw new Exception("Failed to save candidate profile");
    }

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>