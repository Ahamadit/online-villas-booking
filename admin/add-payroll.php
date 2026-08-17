<?php
include "layouts/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data and trim whitespace
    $payroll_type = trim($_POST['payroll_type']);
    $payroll_month = trim($_POST['payroll_month']);

    // Validate required fields
    $errors = [];
    if (empty($payroll_type)) {
        $errors[] = "Payroll type is required.";
    }
    if (empty($payroll_month)) {
        $errors[] = "Payroll month is required.";
    }

    if (empty($errors)) {
        // Prepare the INSERT statement
        $sql = "INSERT INTO payroll (payroll_type, payroll_month) VALUES (?, ?)";
        $stmt = $link->prepare($sql);
        $stmt->bind_param("ss", $payroll_type, $payroll_month);

        if ($stmt->execute()) {
            // Display success message and redirect
            ?>
            <!DOCTYPE html>
            <html>
            <head>
                <title>Add Payroll</title>
                <!-- Include SweetAlert2 CSS -->
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
                <?php include 'layouts/head.php'; ?>
                <?php include 'layouts/head-style.php'; ?>
            </head>
            <body>
                <?php include 'layouts/body.php'; ?>

                <!-- Include SweetAlert2 JS -->
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Payroll Added',
                        text: 'The payroll record has been successfully added.',
                        showConfirmButton: false,
                        timer: 5000,
                        timerProgressBar: true,
                        willClose: () => {
                            window.location.href = 'manage-payroll.php';
                        }
                    });
                </script>

                <?php include 'layouts/vendor-scripts.php'; ?>
            </body>
            </html>
            <?php
            exit();
        } else {
            // Display error message and redirect
            ?>
            <!DOCTYPE html>
            <html>
            <head>
                <title>Add Payroll</title>
                <!-- Include SweetAlert2 CSS -->
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
                <?php include 'layouts/head.php'; ?>
                <?php include 'layouts/head-style.php'; ?>
            </head>
            <body>
                <?php include 'layouts/body.php'; ?>

                <!-- Include SweetAlert2 JS -->
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error Adding Payroll',
                        text: 'An error occurred while adding the payroll record.',
                        showConfirmButton: false,
                        timer: 5000,
                        timerProgressBar: true,
                        willClose: () => {
                            window.location.href = 'manage-payroll.php';
                        }
                    });
                </script>

                <?php include 'layouts/vendor-scripts.php'; ?>
            </body>
            </html>
            <?php
            exit();
        }

        $stmt->close();
    } else {
        // Display validation errors and redirect back to the form
        $error_message = implode("\\n", $errors);
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Add Payroll</title>
            <!-- Include SweetAlert2 CSS -->
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
            <?php include 'layouts/head.php'; ?>
            <?php include 'layouts/head-style.php'; ?>
        </head>
        <body>
            <?php include 'layouts/body.php'; ?>

            <!-- Include SweetAlert2 JS -->
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                Swal.fire({
                    icon: 'warning',
                    title: 'Validation Errors',
                    html: '<?php echo nl2br(htmlspecialchars($error_message)); ?>',
                    showConfirmButton: true,
                }).then(() => {
                    window.history.back();
                });
            </script>

            <?php include 'layouts/vendor-scripts.php'; ?>
        </body>
        </html>
        <?php
        exit();
    }
}
?>

<?php include 'layouts/session.php'; ?>
<?php include 'layouts/main.php'; ?>
<head>
    <title>Add Payroll</title>
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

                <!-- Start page title -->
                <?php
                $maintitle = "Payrolls";
                $title = "Add Payroll";
                include 'layouts/breadcrumb.php';
                ?>
                <!-- End page title -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Enter Payroll Details</h4>
                                <form method="post" action="add-payroll.php" enctype="multipart/form-data">
                                    <div class="form-group row mb-4">
                                        <label for="payrollType" class="col-form-label col-lg-2">Payroll Type<span class="text-danger">*</span></label>
                                        <div class="col-lg-10">
                                            <select id="payrollType" name="payroll_type" class="form-control" required>
                                                <option value="">Select Payroll Type...</option>
                                                <option value="Yearly">Yearly</option>
                                                <option value="Monthly">Monthly</option>
                                                <option value="Quarterly">Quarterly</option>
                                                <option value="Daily">Daily</option>
                                                <option value="Project Wise">Project Wise</option>
                                                <option value="Half Month">Half Month</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-4">
                                        <label for="payrollMonth" class="col-form-label col-lg-2">Payroll Month<span class="text-danger">*</span></label>
                                        <div class="col-lg-10">
                                            <input id="payrollMonth" name="payroll_month" type="month" class="form-control" required>
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="row justify-content-end">
                                        <div class="col-lg-10">
                                            <button type="submit" class="btn btn-success">Submit Payroll</button>
                                            <a href="manage-payroll.php" class="btn btn-secondary">Cancel</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End row -->

            </div> <!-- Container-fluid -->
        </div>
        <!-- End Page-content -->

        <?php include 'layouts/footer.php'; ?>
    </div>
    <!-- End main content-->

</div>
<!-- END layout-wrapper -->

<?php include 'layouts/right-sidebar.php'; ?>

<?php include 'layouts/vendor-scripts.php'; ?>

</body>

</html>
