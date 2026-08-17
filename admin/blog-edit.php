<?php
require_once "layouts/config.php";

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid Blog ID.");
}

$id = intval($_GET['id']);
$sql = "SELECT * FROM blog WHERE id = ?";
$stmt = $link->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$blog = $result->fetch_assoc();

if (!$blog) {
    die("Blog not found.");
}

// Handle form submission for updating blog
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $writtenBy = $_POST['written_by'];
    $content = $_POST['content'];
    $mainContent = $_POST['main_content'];

    $mainImage = $blog['main_image']; // Keep existing image by default

    if (isset($_FILES['main_image']) && $_FILES['main_image']['error'] == 0) {
        $fileTmpPath = $_FILES['main_image']['tmp_name'];
        $fileName = $_FILES['main_image']['name'];
        $uploadDir = 'uploads/';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $destPath = $uploadDir . $fileName;
        if (move_uploaded_file($fileTmpPath, $destPath)) {
            $mainImage = $destPath; // Update with new image
        }
    }

    // Update the blog entry
    $updateSql = "UPDATE blog SET title=?, written_by=?, content=?, main_content=?, main_image=? WHERE id=?";
    $updateStmt = $link->prepare($updateSql);
    $updateStmt->bind_param("sssssi", $title, $writtenBy, $content, $mainContent, $mainImage, $id);

    if ($updateStmt->execute()) {
        echo "<script>alert('Blog updated successfully!'); window.location='blog.php';</script>";
    } else {
        echo "Error updating blog: " . $updateStmt->error;
    }

    $updateStmt->close();
}

$link->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Blog</title>
    <?php include 'layouts/head.php'; ?>
    <?php include 'layouts/head-style.php'; ?>
</head>
<body>
<?php include 'layouts/body.php'; ?>
<div id="layout-wrapper">
    <?php include 'layouts/menu-admin.php'; ?>

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <h2>Edit Blog</h2>
                <form method="POST" enctype="multipart/form-data" class="p-4 border rounded-3 bg-light">
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Current Image</label><br>
                            <?php if (!empty($blog['main_image'])) { ?>
                                <img src="<?php echo htmlspecialchars($blog['main_image']); ?>" alt="Blog Image" width="100">
                            <?php } else { echo "No Image"; } ?>
                        </div>
                        <div class="col-md-6">
                            <label for="mainImage" class="form-label fw-bold">Upload New Image</label>
                            <input type="file" class="form-control" id="mainImage" name="main_image" accept="image/*">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Written By</label>
                        <input type="text" class="form-control" name="written_by" value="<?php echo htmlspecialchars($blog['written_by']); ?>" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Title</label>
                        <input type="text" class="form-control" name="title" value="<?php echo htmlspecialchars($blog['title']); ?>" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Content</label>
                        <!-- Display content with HTML tags -->
                        <textarea class="form-control" name="content" rows="3" required><?php echo htmlspecialchars($blog['content']); ?></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Main Content</label>
                        <!-- Display main content with HTML tags -->
                        <textarea class="form-control" name="main_content" rows="5" required><?php echo htmlspecialchars($blog['main_content']); ?></textarea>
                    </div>
                    <a href="blog.php">
                    <button type="submit" class="btn btn-success" style="width: 15%;">Update</button>
                    </a>
                </form>
            </div>
        </div>
        <?php include 'layouts/footer.php'; ?>
    </div>
</div>

<?php include 'layouts/right-sidebar.php'; ?>
<?php include 'layouts/vendor-scripts.php'; ?>
</body>
</html>
