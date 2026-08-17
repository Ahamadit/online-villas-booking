<?php
require_once "layouts/config.php"; // Include database connection

// Ensure connection is established
if (!isset($link) || $link === false) {
    die("Database connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $writtenBy = $_POST['written_by'];
    $content = $_POST['content']; // Content from Summernote
    $mainContent = $_POST['main_content']; // Main content from Summernote

    // Handling the image upload
    $mainImage = null;
    if (isset($_FILES['main_image']) && $_FILES['main_image']['error'] == 0) {
        $fileTmpPath = $_FILES['main_image']['tmp_name'];
        $fileName = $_FILES['main_image']['name'];
        $uploadDir = 'uploads/';

        // Create directory if not exists
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $destPath = $uploadDir . $fileName;
        if (move_uploaded_file($fileTmpPath, $destPath)) {
            $mainImage = $destPath;
        } else {
            echo "Error uploading the file.";
        }
    }

    // **Removed html_entity_decode** to keep the original raw content intact
    // **Directly save HTML as entered by Summernote**

    // Prepare SQL query to insert data into the database
    $stmt = $link->prepare("INSERT INTO blog (title, written_by, content, main_content, main_image) VALUES (?, ?, ?, ?, ?)");
    if ($stmt) {
        // Insert the data with HTML content intact (no stripping or entity decoding)
        $stmt->bind_param("sssss", $title, $writtenBy, $content, $mainContent, $mainImage);
        if ($stmt->execute()) {
            echo "New record created successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error preparing the statement: " . $link->error;
    }

    // Close the connection
    $link->close();
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Blog Add</title>
    <?php include 'layouts/head.php'; ?>
    <?php include 'layouts/head-style.php'; ?>

    <!-- Include Summernote Official CSS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'layouts/body.php'; ?>
    <div id="layout-wrapper">
        <?php include 'layouts/menu-admin.php'; ?>

        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <?php
                    $maintitle = "Reservations";
                    $title = "BLOG";
                    include 'layouts/breadcrumb.php';
                    ?>

                    <div class="container my-5">
                        <div class="form-container">
                            <form method="POST" enctype="multipart/form-data" class="p-4 border rounded-3 bg-light">
                                <!-- Main Image and Written By in a single row -->
                                <div class="row g-3 mb-4">
                                    <div class="col-md-6">
                                        <label for="mainImage" class="form-label fw-bold">Main Image</label>
                                        <input type="file" class="form-control" id="mainImage" name="main_image" accept="image/*">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="writtenBy" class="form-label fw-bold">Written By</label>
                                        <input type="text" class="form-control" id="writtenBy" name="written_by" placeholder="Author's Name" required>
                                    </div>
                                </div>

                                <!-- Title -->
                                <div class="mb-4">
                                    <label for="title" class="form-label fw-bold">Title</label>
                                    <input type="text" class="form-control" id="title" name="title" placeholder="Enter the title" required>
                                </div>

                                <!-- Content and Main Content Side by Side -->
                                <div class="row g-3 mb-4">
                                    <div class="col-md-6">
                                        <label for="content" class="form-label fw-bold">Content</label>
                                        <textarea class="form-control" id="content" name="content" rows="3" placeholder="Enter content here..." required></textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="mainContent" class="form-label fw-bold">Main Content</label>
                                        <textarea class="form-control" id="mainContent" name="main_content" rows="3" placeholder="Write your main content here..." required></textarea>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="text-start">
                                    <button type="submit" class="btn btn-primary" style="width: 15%;">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div> <!-- container-fluid -->
            </div> <!-- End Page-content -->
            <?php include 'layouts/footer.php'; ?>
        </div>
    </div>

    <?php include 'layouts/right-sidebar.php'; ?>
    <?php include 'layouts/vendor-scripts.php'; ?>

 


</body>
</html>
