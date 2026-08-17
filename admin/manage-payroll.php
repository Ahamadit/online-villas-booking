<?php include 'layouts/session.php'; ?>
<?php include 'layouts/main.php'; ?>

<head>
    <title>Manage Payrolls</title>
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
                $maintitle = "Payrolls";
                $title = "Manage Payrolls";
                include 'layouts/breadcrumb.php';
                ?>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

                                <!-- Payrolls Table -->
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered align-middle">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>ID</th>
                                                <th>Payroll Type</th>
                                                <th>Payroll Month</th>
                                                <th>Created At</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            include "layouts/config.php";

                                            // Fetch all payroll records
                                            $sql = "SELECT id, payroll_type, payroll_month, created_at FROM payroll";
                                            $result = $link->query($sql);

                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['payroll_type']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['payroll_month']); ?></td>
                                                        <td><?php echo date('d-m-Y', strtotime($row['created_at'])); ?></td>
                                                        <td>
                                                            <!-- Edit Button -->
                                                            <a href="edit-payroll.php?id=<?php echo urlencode($row['id']); ?>" class="btn btn-primary btn-sm">Edit</a>
                                                            <!-- Delete Button -->
                                                            <a href="#" onclick="confirmDeletion(<?php echo $row['id']; ?>)" class="btn btn-danger btn-sm">Delete</a>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                            } else {
                                                echo "<tr><td colspan='5' class='text-center'>No payroll records found.</td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Add Payroll Button -->
                                <div class="mt-3">
                                    <a href="add-payroll.php" class="btn btn-success">Add Payroll</a>
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

<!-- Delete Confirmation Script -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDeletion(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'Deleting this payroll record cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel',
        customClass: {
            confirmButton: 'btn btn-danger',
            cancelButton: 'btn btn-secondary'
        },
        buttonsStyling: false
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'delete-payroll.php?id=' + id;
        }
    });
}
</script>

<?php include 'layouts/right-sidebar.php'; ?>
<?php include 'layouts/vendor-scripts.php'; ?>
</body>

</html>
