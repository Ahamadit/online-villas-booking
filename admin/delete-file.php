<?php
include 'layouts/config.php'; // Ensure this file contains the database connection

if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['file_path']) && isset($_GET['category_id'])) {
    $file_path = $_GET['file_path'];
    $category_id = $_GET['category_id'];

    // Security check: Validate inputs
    if (!is_numeric($category_id) || !file_exists($file_path)) {
        echo "<script>alert('Invalid operation.'); window.location.href='manage-asset-files.php';</script>";
        exit;
    }

    // Delete the file from the filesystem
    if (unlink($file_path)) {
        // Delete the file entry from the database
        $stmt = $link->prepare("DELETE FROM assets_file WHERE category_id = ? AND file_paths = ?");
        $stmt->bind_param("is", $category_id, $file_path);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "<script>alert('File deleted successfully.'); window.location.href='manage-asset-files.php';</script>";
        } else {
            echo "<script>alert('Database error, file was not deleted.'); window.location.href='manage-asset-files.php';</script>";
        }
    } else {
        echo "<script>alert('Failed to delete the file.'); window.location.href='manage-asset-files.php';</script>";
    }

    $stmt->close();
    $link->close();
} else {
    echo "<script>alert('Invalid request.'); window.location.href='manage-asset-files.php';</script>";
}
?>
