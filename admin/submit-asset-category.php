<?php
include "layouts/config.php";

// Function to sanitize the category name
function sanitize_category_name($name) {
    // Replace spaces with hyphens
    $name = str_replace(' ', '-', $name);
    // Remove any special characters except hyphens
    $name = preg_replace('/[^A-Za-z0-9\-]/', '', $name);
    return $name;
}

// Get form data
$event_name = isset($_POST['name']) ? $_POST['name'] : null;

if ($event_name) {
    // Sanitize the category name
    $sanitized_name = sanitize_category_name($event_name);
    
    // Create the directory if it doesn't exist
    $directory_path = "../assets/araz_assets/" . $sanitized_name;
    if (!is_dir($directory_path)) {
        mkdir($directory_path, 0777, true);
    }

    // Insert data into database
    $sql = "INSERT INTO assets_category (category_name) 
            VALUES ('$sanitized_name')";

    if ($link->query($sql) === TRUE) {
        $event_id = $link->insert_id; // Get the inserted ID
        echo '<script>
        alert("Category Added Successfully. ID: ' . $event_id . '");
        window.location.href = "manage-asset-category.php";
      </script>';
    } else {
        echo '<script>
        alert("Something Went Wrong.");
        window.location.href = "manage-asset-category.php";
      </script>';
    }
} else {
    echo '<script>
    alert("Category name is required.");
    window.location.href = "manage-asset-category.php";
  </script>';
}

$link->close();
?>
