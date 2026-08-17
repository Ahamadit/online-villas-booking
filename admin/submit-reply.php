<?php
include "layouts/config.php"; // Include your database config file

// Ensure ID and paragraph are posted
if (isset($_POST['id'], $_POST['paragraph'])) {
    $id = $_POST['id'];
    $paragraph = $_POST['paragraph'];
    $link->begin_transaction(); // Start transaction

    try {
        // Update status to "completed"
        $stmt = $link->prepare("UPDATE araz SET status = 'completed' WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        // Fetch details from the araz table
        $stmt = $link->prepare("SELECT * FROM araz WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $araz = $result->fetch_assoc();

        // Store details into variables
        $user_id = $araz['user_id'];
        $name = $araz['name'];
        $email = $araz['email'];
        $city = $araz['city'];
        $number = $araz['number'];
        $created_at = $araz['created_at'];

        // Handle file uploads
        $uploadDir = '../assets/' . $email . '/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $replies_filePaths = '';
        foreach ($_FILES['files']['name'] as $key => $filename) {
            $filePath = $uploadDir . basename($filename);
            if (move_uploaded_file($_FILES['files']['tmp_name'][$key], $filePath)) {
                $replies_filePaths .= $filePath . ',';
            }
        }
        $replies_filePaths = rtrim($replies_filePaths, ',');

        // Handle assets selected from the form
        $replied_assets = implode(',', $_POST['selectedFiles'] ?? []);

        // Insert into completed_araz table
        $stmt = $link->prepare("INSERT INTO completed_araz (user_id, name, email, city, number, araz, filePaths, created_at, status, replied_araz, replies_filePaths, replied_assets) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'completed', ?, ?, ?)");
        $stmt->bind_param("issssssssss", $user_id, $name, $email, $city, $number, $araz['araz'], $araz['filePaths'], $created_at, $paragraph, $replies_filePaths, $replied_assets);
        $stmt->execute();

        $link->commit(); // Commit transaction
        echo '<script>
        alert("Replied Successfully.");
        window.location.href = "mailto:' . $email . '?subject=Your Araz Reply&body=Salamun Alaykum ' . $name . ',%0D%0A%0D%0AAlhamdulillah you have got your reply for your araz.%0D%0A%0D%0APlease login to fatemidawat-araz.com to check the reply.%0D%0A%0D%0AJazakallah.";
        window.location.href = "manage-completed-araz.php";
    </script>';
    } catch (Exception $e) {
        $link->rollback(); // Roll back on error
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Required data not provided.";
}
?>
