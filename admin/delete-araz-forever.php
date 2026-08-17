<?php
include 'layouts/config.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // SQL to retrieve filePaths from the database
    $sql = "SELECT filePaths FROM araz WHERE id = ?";
    
    // Prepare the statement
    $stmt = $link->prepare($sql);
    
    // Bind the ID to the statement
    $stmt->bind_param("i", $id);
    
    // Execute the statement
    $stmt->execute();
    
    // Bind the result to a variable
    $stmt->bind_result($filePaths);
    
    // Fetch the result
    if ($stmt->fetch()) {
        // Close the statement
        $stmt->close();
        
        // Split the filePaths into an array of individual file paths
        $files = explode(',', $filePaths);
        
        // Loop through each file path and delete the file
        foreach ($files as $file) {
            $file = "../".trim($file); // Remove any extra spaces
            if (file_exists($file)) {
                unlink($file); // Delete the file from the server
            }
        }
        
        // SQL to permanently delete the record
        $sql = "DELETE FROM araz WHERE id = ?";
        
        // Prepare the statement
        $stmt = $link->prepare($sql);
        
        // Bind the ID to the statement
        $stmt->bind_param("i", $id);
        
        // Execute the statement
        $stmt->execute();
        
        // Check if any rows were affected
        if ($stmt->affected_rows > 0) {
            echo "<script>alert('Araz and associated files have been permanently deleted successfully.'); window.location.href='manage-deleted-araz.php';</script>";
        } else {
            echo "<script>alert('No records affected. Please check the ID.'); window.location.href='manage-deleted-araz.php';</script>";
        }
        
        // Close the statement and connection
        $stmt->close();
        $link->close();
    } else {
        // No filePaths found for the given ID
        echo "<script>alert('No records found with the given ID.'); window.location.href='manage-deleted-araz.php';</script>";
        $stmt->close();
        $link->close();
    }
} else {
    echo "<script>alert('Error: ID not provided.'); window.location.href='manage-deleted-araz.php';</script>";
}
?>
