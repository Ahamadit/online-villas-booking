<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "layouts/config.php"; // Database connection

// Check if 'id' is set in the URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Convert to integer for security

    // Check if the ID exists in the database
    $check_sql = "SELECT * FROM booking WHERE id = ?";
    $check_stmt = $link->prepare($check_sql);
    $check_stmt->bind_param("i", $id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
        // If ID exists, delete the record
        $sql = "DELETE FROM booking WHERE id = ?";
        $stmt = $link->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                // Redirect after successful deletion
                header("Location: booking-enquiry.php?success=deleted");
                exit();
            } else {
                echo "Error: Could not delete record.";
            }
            $stmt->close();
        } else {
            echo "Error: Query preparation failed.";
        }
    } else {
        echo "Error: No such booking found.";
    }

    $check_stmt->close();
} else {
    echo "Error: Invalid request.";
}

$link->close();
?>
