<?php include 'layouts/session.php'; ?>
<?php include 'layouts/main.php'; ?>

<head>
    <title>Manage Asset Files</title>
    <?php include 'layouts/head.php'; ?>
    <?php include 'layouts/head-style.php'; ?>
</head>

<?php include 'layouts/body.php'; ?>

<!-- Begin page -->
<div id="layout-wrapper">
    <?php include 'layouts/menu-admin.php'; ?>

    <!-- Start right Content here -->
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <!-- Page title -->
                <?php
                $maintitle = "Admin";
                $title = "Manage Asset Files";
                include 'layouts/breadcrumb.php';
                ?>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

                                <!-- Category Selection Form -->
                                <form method="post">
                                    <div class="mb-3">
                                        <label for="categorySelect" class="form-label">Select Category</label>
                                        <select id="categorySelect" name="category_id" class="form-control" onchange="this.form.submit()">
                                            <option value="">Select a Category...</option>
                                            <?php
                                            include "layouts/config.php";
                                            $sql = "SELECT id, category_name FROM assets_category";
                                            $result = $link->query($sql);
                                            while ($row = $result->fetch_assoc()) {
                                                $selected = (isset($_POST['category_id']) && $_POST['category_id'] == $row['id']) ? 'selected' : '';
                                                echo "<option value='{$row['id']}' {$selected}>{$row['category_name']}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </form>

                                <!-- Files Table -->
                                <div class="table-responsive">
                                    <table class="table align-middle table-nowrap">
                                        <thead>
                                            <tr>
                                                <th>File Name</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        if (isset($_POST['category_id']) && !empty($_POST['category_id'])) {
                                            $category_id = $_POST['category_id'];
                                            $sql = "SELECT file_paths FROM assets_file WHERE category_id = ?";
                                            $stmt = $link->prepare($sql);
                                            $stmt->bind_param("i", $category_id);
                                            $stmt->execute();
                                            $result = $stmt->get_result();

                                            while ($row = $result->fetch_assoc()) {
                                                $file_path = $row['file_paths'];
                                                $file_name = basename($file_path);
                                                ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($file_name); ?></td>
                                                <td>
                                                    <a href="<?php echo htmlspecialchars($file_path); ?>" class="btn btn-primary btn-rounded waves-effect waves-light" target="_blank">View</a>
                                                    <a href="delete-file.php?file_path=<?php echo urlencode($file_path); ?>&category_id=<?php echo $category_id; ?>" onclick="return confirm('Are you sure you want to delete this file?');" class="btn btn-danger btn-rounded waves-effect waves-light">Delete</a>
                                                </td>
                                            </tr>
                                                <?php
                                            }
                                            $stmt->close();
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->

            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

        <?php include 'layouts/footer.php'; ?>
    </div>
    <!-- end main content-->

</div>
<!-- END layout-wrapper -->

<?php include 'layouts/right-sidebar.php'; ?>
<?php include 'layouts/vendor-scripts.php'; ?>
</body>
</html>
