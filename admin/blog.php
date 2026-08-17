<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Reservations</title>
    <?php include 'layouts/head.php'; ?>
    <?php include 'layouts/head-style.php'; ?>
</head>

<?php include 'layouts/body.php'; ?>



<div id="layout-wrapper">
    <?php include 'layouts/menu-admin.php'; ?>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- Page Title -->
                <?php
                $maintitle = "Reservations";
                $title = "Blog Entries";
                include 'layouts/breadcrumb.php';
                ?>
                <!-- End Page Title -->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <a href="blog-add.php" class="btn btn-primary mb-3">Create Blogs</a>


                                <?php
                                include "layouts/config.php";

                                $counter = 1;

                                // Fetch all blog entries
                                $sql = "SELECT id, main_image, title, written_by, content, main_content FROM blog ORDER BY id DESC";

                                $result = $link->query($sql);

                                if (!$result) {
                                    die("<div class='alert alert-danger'>Query failed: " . $link->error . "</div>");
                                }
                                ?>

                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered align-middle">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>ID</th>
                                                <th>Main Image</th>
                                                <th>Title</th>
                                                <th>Written By</th>
                                                <th>Content</th>
                                                <th>Main Content</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                            ?>
                                                    <tr>
                                                        <td><?php echo $counter++; ?></td>

                                                        <td>
                                                            <?php if (!empty($row['main_image'])) { ?>
                                                                <img src="<?php echo htmlspecialchars($row['main_image']); ?>" alt="Blog Image" width="100">
                                                            <?php } else { ?>
                                                                No Image
                                                            <?php } ?>
                                                        </td>
                                                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['written_by']); ?></td>
                                                        <td><?php echo nl2br(htmlspecialchars(substr($row['content'], 0, 50))); ?>...</td>
                                                        <td><?php echo nl2br(htmlspecialchars(substr($row['main_content'], 0, 50))); ?>...</td>
                                                        <td>
                                                            <a href="blog-edit.php?id=<?php echo $row['id']; ?>">
                                                                <i class="fa-solid fa-pen-to-square text-warning" style="font-size: 1.3rem; margin-right: 10px;"></i>
                                                            </a>
                                                            <a href="blog-delete.php?id=<?php echo $row['id']; ?>" class="text-danger" onclick="return confirm('Are you sure you want to delete this blog?');">
                                                                <i class="fa-solid fa-trash" style="font-size: 1.3rem;"></i>
                                                            </a>
                                                        </td>

                                                    </tr>
                                            <?php
                                                }
                                            } else {
                                                echo "<tr><td colspan='7' class='text-center'>No blog entries found.</td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- end row -->
            </div> <!-- container-fluid -->
        </div> <!-- End Page-content -->

        <?php include 'layouts/footer.php'; ?>
    </div> <!-- end main content -->
</div> <!-- END layout-wrapper -->

<?php include 'layouts/right-sidebar.php'; ?>
<?php include 'layouts/vendor-scripts.php'; ?>

</body>

</html>