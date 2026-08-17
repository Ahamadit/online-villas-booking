<?php
include "layouts/config.php"; // Assuming this file has the database connection

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['asset_files']) && isset($_POST['category_id'])) {
    $category_id = $_POST['category_id'];

    // Fetch the category name from the database using the category ID
    $stmt = $link->prepare("SELECT category_name FROM assets_category WHERE id = ?");
    $stmt->bind_param("i", $category_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $category = $result->fetch_assoc();

    if ($category) {
        $category_name = $category['category_name'];
        $upload_path = "../assets/araz_assets/" . $category_name . "/";
        if (!file_exists($upload_path)) {
            mkdir($upload_path, 0777, true);
        }

        $total_files = count($_FILES['asset_files']['name']);
        $inserted_files_count = 0;

        for ($i = 0; $i < $total_files; $i++) {
            $original_name = $_FILES['asset_files']['name'][$i];
            $file_ext = pathinfo($original_name, PATHINFO_EXTENSION);
            $file_tmp = $_FILES['asset_files']['tmp_name'][$i];

            // Determine the new file name
            $new_name = isset($_POST['custom_names'][$i]) && !empty($_POST['custom_names'][$i])
                ? $_POST['custom_names'][$i] . "." . $file_ext
                : $original_name;

            $file_destination = $upload_path . $new_name;

            if (move_uploaded_file($file_tmp, $file_destination)) {
                // Insert each file path into the database
                $stmt = $link->prepare("INSERT INTO assets_file (category_id, file_paths) VALUES (?, ?)");
                $stmt->bind_param("is", $category_id, $file_destination);
                $stmt->execute();

                if ($stmt->affected_rows > 0) {
                    $inserted_files_count++;
                }
            }
        }

        if ($inserted_files_count === $total_files) {
            echo "<script>alert('All files uploaded and database updated successfully.'); window.location.href='manage-asset-files.php';</script>";
        } else {
            echo "<script>alert('Error uploading some or all files.'); window.location.href='manage-asset-files.php';</script>";
        }
    } else {
        echo "<script>alert('Invalid category ID.'); window.location.href='manage-asset-files.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request or no files uploaded.'); window.location.href='manage-asset-files.php';</script>";
}

$link->close();
?>
