<?php
require_once "layouts/config.php"; // Ensure database connection is included

// Check if 'id' is provided in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: blog.php");
    exit;
}

$id = intval($_GET['id']); // Sanitize input

// Prepare delete query
$sql = "DELETE FROM blog WHERE id = ?";
$stmt = $link->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: blog.php");
} else {
    header("Location: blog.php");
}

$stmt->close();
$link->close();
exit;
?>
