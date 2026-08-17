<?php
include 'layouts/config.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // SQL to update status to 'deleted'
    $sql = "UPDATE araz SET status = 'pending' WHERE id = ?";

    // Prepare the statement
    $stmt = $link->prepare($sql);

    // Bind the ID to the statement
    $stmt->bind_param("i", $id);

    // Execute the statement
    $stmt->execute();

    // Check if any rows were affected
    if ($stmt->affected_rows > 0) {
        echo "<script>alert('Araz is Restored successfully.'); window.location.href='manage-deleted-araz.php';</script>";
    } else {
        echo "<script>alert('No records affected. Please check the ID.'); window.location.href='manage-deleted-araz.php';</script>";
    }

    // Close the statement and connection
    $stmt->close();
    $link->close();
} else {
    echo "<script>alert('Error: ID not provided.'); window.location.href='manage-deleted-araz.php';</script>";
}
?>
