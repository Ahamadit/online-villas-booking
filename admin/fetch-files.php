<?php
// Include your database configuration file
include "layouts/config.php";

// Ensure the category_id is passed and is numeric
if (isset($_GET['category_id']) && is_numeric($_GET['category_id'])) {
    $category_id = $_GET['category_id'];

    // Prepare a statement to select file paths
    $sql = "SELECT file_paths FROM assets_file WHERE category_id = ?";
    $stmt = $link->prepare($sql);
    $stmt->bind_param("i", $category_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $files = [];
    while ($row = $result->fetch_assoc()) {
        // Assuming file_paths contains the full path, extract just the file name
        $file_path = $row['file_paths'];
        $file_name = $file_path;
        $files[] = $file_name;
    }

    $stmt->close();
    $link->close();

    // Send back the list of file names as JSON
    header('Content-Type: application/json');
    echo json_encode($files);
} else {
    // If category_id is not set or not valid, return an empty JSON array
    echo json_encode([]);
}
?>
