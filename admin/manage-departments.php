<?php include 'layouts/session.php'; ?>
<?php include 'layouts/main.php'; ?>

<head>
    <title>Manage Departments</title>
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
                $maintitle = "Departments";
                $title = "Manage Departments";
                include 'layouts/breadcrumb.php';
                ?>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

                                <!-- Departments Table -->
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered align-middle">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>ID</th>
                                                <th>Department Name</th>
                                                <th>Created At</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            include "layouts/config.php";

                                            // Fetch all departments
                                            $sql = "SELECT id, name, created_at FROM department";
                                            $result = $link->query($sql);

                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                            ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                                                        <td><?php echo date('d-m-Y', strtotime($row['created_at'])); ?></td>
                                                        <td>
                                                            <!-- Delete Button -->
                                                            <a href="delete-department.php?id=<?php echo urlencode($row['id']); ?>" onclick="return confirm('Are you sure you want to delete this department?');" class="btn btn-danger btn-sm">Delete</a>
                                                        </td>
                                                    </tr>
                                            <?php
                                                }
                                            } else {
                                                echo "<tr><td colspan='4' class='text-center'>No departments found.</td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Add Department Button -->
                                <div class="mt-3">
                                    <a href="add-department.php" class="btn btn-success">Add Department</a>
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