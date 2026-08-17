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

// Get category ID from POST request
$category_id = isset($_POST['id']) ? intval($_POST['id']) : null;

if ($category_id) {
    // Retrieve the category name from the database
    $sql = "SELECT category_name FROM assets_category WHERE id = $category_id";
    $result = $link->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $category_name = $row['category_name'];
        $sanitized_name = sanitize_category_name($category_name);

        // Define the directory path
        $directory_path = "../assets/araz_assets/" . $sanitized_name;

        // Remove the directory and its contents if it exists
        if (is_dir($directory_path)) {
            array_map('unlink', glob("$directory_path/*.*"));
            rmdir($directory_path);
        }

        // Delete the category from the database
        $delete_sql = "DELETE FROM assets_category WHERE id = $category_id";
        if ($link->query($delete_sql) === TRUE) {
            echo '<script>
            alert("Category Deleted Successfully.");
            window.location.href = "manage-asset-category.php";
          </script>';
        } else {
            echo '<script>
            alert("Error: Could not delete the category.");
            window.location.href = "manage-asset-category.php";
          </script>';
        }
    } else {
        echo '<script>
        alert("Category not found.");
        window.location.href = "manage-asset-category.php";
      </script>';
    }
} else {
    echo '<script>
    alert("Category ID is required.");
    window.location.href = "manage-asset-category.php";
  </script>';
}

$link->close();
?>
