<?php include 'layouts/session.php'; ?>
<?php include 'layouts/main.php'; ?>

<head>
    <title>Manage Payslips</title>
    <?php include 'layouts/head.php'; ?>
    <?php include 'layouts/head-style.php'; ?>
    <!-- Include SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
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
                $maintitle = "Payslips";
                $title = "Manage Payslips";
                include 'layouts/breadcrumb.php';
                ?>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

                                <!-- Filter Form -->
                                <form method="get" action="manage-payslips.php" class="mb-4">
                                    <div class="form-group row">
                                        <label for="payrollMonth" class="col-form-label col-lg-2">Filter by Payroll Month</label>
                                        <div class="col-lg-6">
                                            <select id="payrollMonth" name="payroll_month" class="form-control">
                                                <option value="">All Months</option>
                                                <?php
                                                include "layouts/config.php";

                                                // Fetch distinct payroll months from payroll table
                                                $monthSql = "SELECT DISTINCT payroll_month FROM payroll ORDER BY payroll_month DESC";
                                                $monthResult = $link->query($monthSql);
                                                while ($monthRow = $monthResult->fetch_assoc()) {
                                                    $selected = '';
                                                    if (isset($_GET['payroll_month']) && $_GET['payroll_month'] == $monthRow['payroll_month']) {
                                                        $selected = 'selected';
                                                    }
                                                    echo "<option value='{$monthRow['payroll_month']}' $selected>{$monthRow['payroll_month']}</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-4">
                                            <button type="submit" class="btn btn-primary">Filter</button>
                                            <a href="manage-payslips.php" class="btn btn-secondary">Reset</a>
                                        </div>
                                    </div>
                                </form>

                                <!-- Payslips Table -->
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered align-middle">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>ID</th>
                                                <th>Employee Name</th>
                                                <th>Payroll Month</th>
                                                <th>Total Pay</th>
                                                <th>Pay Date</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // Build the SQL query with optional filtering
                                            $sql = "SELECT p.id, e.employee_name, pr.payroll_month, p.total_pay, p.pay_date, p.payslip_url
                                                    FROM payslip p
                                                    LEFT JOIN employees e ON p.employee_id = e.id
                                                    LEFT JOIN payroll pr ON p.payroll_id = pr.id";

                                            // Apply filter if payroll_month is selected
                                            if (isset($_GET['payroll_month']) && !empty($_GET['payroll_month'])) {
                                                $payroll_month = $_GET['payroll_month'];
                                                $sql .= " WHERE pr.payroll_month = ?";
                                                $stmt = $link->prepare($sql);
                                                $stmt->bind_param("s", $payroll_month);
                                                $stmt->execute();
                                                $result = $stmt->get_result();
                                            } else {
                                                $result = $link->query($sql);
                                            }

                                            if ($result && $result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['employee_name']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['payroll_month']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['total_pay']); ?></td>
                                                        <td><?php echo date('d-m-Y', strtotime($row['pay_date'])); ?></td>
                                                        <td>
                                                            <!-- Edit Button -->
                                                            <a href="edit-payslip.php?id=<?php echo urlencode($row['id']); ?>" class="btn btn-primary btn-sm">Edit</a>
                                                            <!-- Delete Button -->
                                                            <a href="#" onclick="confirmDeletion(<?php echo $row['id']; ?>)" class="btn btn-danger btn-sm">Delete</a>
                                                            <!-- Generate Payslip PDF Button -->
                                                            <a href="generate-payslip.php?id=<?php echo urlencode($row['id']); ?>" class="btn btn-success btn-sm">Generate Payslip</a>
                                                            <!-- View Payslip PDF Button -->
                                                            <?php if (isset($row['payslip_url']) && !empty($row['payslip_url'])): ?>
                                                                <a href="<?php echo htmlspecialchars($row['payslip_url']); ?>" class="btn btn-warning btn-sm" target="_blank">View Payslip</a>
                                                                <a href="share-payslip.php?id=<?php echo urlencode($row['id']); ?>" class="btn btn-info btn-sm">Send Payslip</a>
                                                            <?php endif; ?>

                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                            } else {
                                                echo "<tr><td colspan='6' class='text-center'>No payslip records found.</td></tr>";
                                            }

                                            if (isset($stmt)) {
                                                $stmt->close();
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Add Payslip Button -->
                                <div class="mt-3">
                                    <a href="add-payslip.php" class="btn btn-success">Add Payslip</a>
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
        text: 'Deleting this payslip record cannot be undone.',
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
            window.location.href = 'delete-payslip.php?id=' + id;
        }
    });
}
</script>

<?php include 'layouts/right-sidebar.php'; ?>
<?php include 'layouts/vendor-scripts.php'; ?>
</body>

</html>
