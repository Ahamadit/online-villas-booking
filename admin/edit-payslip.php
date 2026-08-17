<?php
include "layouts/config.php";

if (isset($_GET['id'])) {
    $payslip_id = intval($_GET['id']);

    // Fetch existing payslip data
    $sql = "SELECT * FROM payslip WHERE id = ?";
    $stmt = $link->prepare($sql);
    $stmt->bind_param("i", $payslip_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $payslip = $result->fetch_assoc();

        // Decode earnings and deductions JSON
        $earnings = json_decode($payslip['earnings'], true) ?? [];
        $deductions = json_decode($payslip['deductions'], true) ?? [];
    } else {
        // Payslip not found; display error message
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Edit Payslip</title>
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
                    title: 'Payslip Not Found',
                    text: 'The requested payslip record does not exist.',
                    showConfirmButton: false,
                    timer: 5000,
                    timerProgressBar: true,
                    willClose: () => {
                        window.location.href = 'manage-payslips.php';
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
    // No ID provided; redirect to manage payslips page
    header("Location: manage-payslips.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data and trim whitespace
    $employee_id = $_POST['employee_id'];
    $payroll_id = $_POST['payroll_id'];
    $working_days = trim($_POST['working_days']);
    $total_days_present = trim($_POST['total_days_present']);
    $total_days_absent = trim($_POST['total_days_absent']);
    $total_pay = trim($_POST['total_pay']);
    $pay_date = $_POST['pay_date'];

    // Retrieve earnings and deductions arrays
    $earning_names = $_POST['earning_name'];
    $earning_amounts = $_POST['earning_amount'];

    $deduction_names = $_POST['deduction_name'];
    $deduction_amounts = $_POST['deduction_amount'];

    // Validate required fields
    $errors = [];
    if (empty($employee_id)) {
        $errors[] = "Employee is required.";
    }
    if (empty($payroll_id)) {
        $errors[] = "Payroll month is required.";
    }
    if (empty($total_pay)) {
        $errors[] = "Total pay is required.";
    }
    if (empty($pay_date)) {
        $errors[] = "Pay date is required.";
    }

    // Validate earnings and deductions
    $earnings_data = [];
    if (!empty($earning_names)) {
        foreach ($earning_names as $key => $name) {
            $amount = $earning_amounts[$key];
            if (!empty($name) && is_numeric($amount)) {
                $earnings_data[] = ['name' => $name, 'amount' => (float)$amount];
            } else {
                $errors[] = "Invalid earning at row " . ($key + 1) . ".";
            }
        }
    }

    $deductions_data = [];
    if (!empty($deduction_names)) {
        foreach ($deduction_names as $key => $name) {
            $amount = $deduction_amounts[$key];
            if (!empty($name) && is_numeric($amount)) {
                $deductions_data[] = ['name' => $name, 'amount' => (float)$amount];
            } else {
                $errors[] = "Invalid deduction at row " . ($key + 1) . ".";
            }
        }
    }

    if (empty($errors)) {
        // Convert earnings and deductions data to JSON
        $earnings_json = json_encode($earnings_data);
        $deductions_json = json_encode($deductions_data);

        // Prepare the UPDATE statement
        $sql = "UPDATE payslip SET employee_id = ?, payroll_id = ?, working_days = ?, total_days_present = ?, total_days_absent = ?, earnings = ?, deductions = ?, total_pay = ?, pay_date = ? WHERE id = ?";
        $stmt = $link->prepare($sql);
        $stmt->bind_param(
            "iiiisssdsi",
            $employee_id,
            $payroll_id,
            $working_days,
            $total_days_present,
            $total_days_absent,
            $earnings_json,
            $deductions_json,
            $total_pay,
            $pay_date,
            $payslip_id
        );

        if ($stmt->execute()) {
            // Display success message and redirect
            ?>
            <!DOCTYPE html>
            <html>
            <head>
                <title>Edit Payslip</title>
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
                        title: 'Payslip Updated',
                        text: 'The payslip record has been successfully updated.',
                        showConfirmButton: false,
                        timer: 5000,
                        timerProgressBar: true,
                        willClose: () => {
                            window.location.href = 'manage-payslips.php';
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
                <title>Edit Payslip</title>
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
                        title: 'Error Updating Payslip',
                        text: 'An error occurred while updating the payslip record.',
                        showConfirmButton: false,
                        timer: 5000,
                        timerProgressBar: true,
                        willClose: () => {
                            window.location.href = 'manage-payslips.php';
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
        // Display validation errors
        $error_message = implode("\\n", $errors);
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Edit Payslip</title>
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
    <title>Edit Payslip</title>
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
                $maintitle = "Payslips";
                $title = "Edit Payslip";
                include 'layouts/breadcrumb.php';
                ?>
                <!-- End page title -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Edit Payslip Details</h4>
                                <form method="post" action="edit-payslip.php?id=<?php echo $payslip_id; ?>" enctype="multipart/form-data">
                                    <div class="form-group row mb-4">
                                        <label for="employeeId" class="col-form-label col-lg-2">Employee<span class="text-danger">*</span></label>
                                        <div class="col-lg-10">
                                            <select id="employeeId" name="employee_id" class="form-control" required>
                                                <option value="">Select Employee...</option>
                                                <?php
                                                // Fetch employees
                                                $employeeSql = "SELECT id, employee_name FROM employees ORDER BY employee_name ASC";
                                                $employeeResult = $link->query($employeeSql);
                                                while ($employeeRow = $employeeResult->fetch_assoc()) {
                                                    $selected = ($payslip['employee_id'] == $employeeRow['id']) ? 'selected' : '';
                                                    echo "<option value='{$employeeRow['id']}' $selected>{$employeeRow['employee_name']}</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-4">
                                        <label for="payrollId" class="col-form-label col-lg-2">Payroll Month<span class="text-danger">*</span></label>
                                        <div class="col-lg-10">
                                            <select id="payrollId" name="payroll_id" class="form-control" required>
                                                <option value="">Select Payroll Month...</option>
                                                <?php
                                                // Fetch payroll months
                                                $payrollSql = "SELECT id, payroll_month FROM payroll ORDER BY payroll_month DESC";
                                                $payrollResult = $link->query($payrollSql);
                                                while ($payrollRow = $payrollResult->fetch_assoc()) {
                                                    $selected = ($payslip['payroll_id'] == $payrollRow['id']) ? 'selected' : '';
                                                    echo "<option value='{$payrollRow['id']}' $selected>{$payrollRow['payroll_month']}</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Optional Fields -->
                                    <div class="form-group row mb-4">
                                        <label for="workingDays" class="col-form-label col-lg-2">Working Days</label>
                                        <div class="col-lg-10">
                                            <input id="workingDays" name="working_days" type="number" class="form-control" placeholder="Enter Working Days..." value="<?php echo htmlspecialchars($payslip['working_days']); ?>">
                                        </div>
                                    </div>

                                    <div class="form-group row mb-4">
                                        <label for="daysPresent" class="col-form-label col-lg-2">Total Days Present</label>
                                        <div class="col-lg-10">
                                            <input id="daysPresent" name="total_days_present" type="number" class="form-control" placeholder="Enter Total Days Present..." value="<?php echo htmlspecialchars($payslip['total_days_present']); ?>">
                                        </div>
                                    </div>

                                    <div class="form-group row mb-4">
                                        <label for="daysAbsent" class="col-form-label col-lg-2">Total Days Absent</label>
                                        <div class="col-lg-10">
                                            <input id="daysAbsent" name="total_days_absent" type="number" class="form-control" placeholder="Enter Total Days Absent..." value="<?php echo htmlspecialchars($payslip['total_days_absent']); ?>">
                                        </div>
                                    </div>

                                    <!-- Earnings Section -->
                                    <h5 class="mb-3">Earnings</h5>
                                    <div id="earningsSection">
                                        <?php
                                        if (!empty($earnings)) {
                                            foreach ($earnings as $key => $earning) {
                                                ?>
                                                <div class="form-group row mb-2 earning-row">
                                                    <div class="col-lg-5">
                                                        <input name="earning_name[]" type="text" class="form-control" placeholder="Earning Name" value="<?php echo htmlspecialchars($earning['name']); ?>">
                                                    </div>
                                                    <div class="col-lg-5">
                                                        <input name="earning_amount[]" type="number" step="0.01" class="form-control" placeholder="Amount" value="<?php echo htmlspecialchars($earning['amount']); ?>">
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <button type="button" class="btn btn-danger remove-earning">Remove</button>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        } else {
                                            // If no earnings, display one empty row
                                            ?>
                                            <div class="form-group row mb-2 earning-row">
                                                <div class="col-lg-5">
                                                    <input name="earning_name[]" type="text" class="form-control" placeholder="Earning Name">
                                                </div>
                                                <div class="col-lg-5">
                                                    <input name="earning_amount[]" type="number" step="0.01" class="form-control" placeholder="Amount">
                                                </div>
                                                <div class="col-lg-2">
                                                    <button type="button" class="btn btn-danger remove-earning">Remove</button>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <button type="button" class="btn btn-success mb-4" id="addEarning">Add Earning</button>

                                    <!-- Deductions Section -->
                                    <h5 class="mb-3">Deductions</h5>
                                    <div id="deductionsSection">
                                        <?php
                                        if (!empty($deductions)) {
                                            foreach ($deductions as $key => $deduction) {
                                                ?>
                                                <div class="form-group row mb-2 deduction-row">
                                                    <div class="col-lg-5">
                                                        <input name="deduction_name[]" type="text" class="form-control" placeholder="Deduction Name" value="<?php echo htmlspecialchars($deduction['name']); ?>">
                                                    </div>
                                                    <div class="col-lg-5">
                                                        <input name="deduction_amount[]" type="number" step="0.01" class="form-control" placeholder="Amount" value="<?php echo htmlspecialchars($deduction['amount']); ?>">
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <button type="button" class="btn btn-danger remove-deduction">Remove</button>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        } else {
                                            // If no deductions, display one empty row
                                            ?>
                                            <div class="form-group row mb-2 deduction-row">
                                                <div class="col-lg-5">
                                                    <input name="deduction_name[]" type="text" class="form-control" placeholder="Deduction Name">
                                                </div>
                                                <div class="col-lg-5">
                                                    <input name="deduction_amount[]" type="number" step="0.01" class="form-control" placeholder="Amount">
                                                </div>
                                                <div class="col-lg-2">
                                                    <button type="button" class="btn btn-danger remove-deduction">Remove</button>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <button type="button" class="btn btn-success mb-4" id="addDeduction">Add Deduction</button>

                                    <div class="form-group row mb-4">
                                        <label for="totalPay" class="col-form-label col-lg-2">Total Pay<span class="text-danger">*</span></label>
                                        <div class="col-lg-10">
                                            <input id="totalPay" name="total_pay" type="number" step="0.01" class="form-control" placeholder="Enter Total Pay..." value="<?php echo htmlspecialchars($payslip['total_pay']); ?>" required>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-4">
                                        <label for="payDate" class="col-form-label col-lg-2">Pay Date<span class="text-danger">*</span></label>
                                        <div class="col-lg-10">
                                            <input id="payDate" name="pay_date" type="date" class="form-control" value="<?php echo htmlspecialchars($payslip['pay_date']); ?>" required>
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="row justify-content-end">
                                        <div class="col-lg-10">
                                            <button type="submit" class="btn btn-primary">Update Payslip</button>
                                            <a href="manage-payslips.php" class="btn btn-secondary">Cancel</a>
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

<!-- Include jQuery if not already included -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    // Add Earning
    $('#addEarning').click(function() {
        var earningRow = `<div class="form-group row mb-2 earning-row">
            <div class="col-lg-5">
                <input name="earning_name[]" type="text" class="form-control" placeholder="Earning Name">
            </div>
            <div class="col-lg-5">
                <input name="earning_amount[]" type="number" step="0.01" class="form-control" placeholder="Amount">
            </div>
            <div class="col-lg-2">
                <button type="button" class="btn btn-danger remove-earning">Remove</button>
            </div>
        </div>`;
        $('#earningsSection').append(earningRow);
    });

    // Remove Earning
    $(document).on('click', '.remove-earning', function() {
        $(this).closest('.earning-row').remove();
    });

    // Add Deduction
    $('#addDeduction').click(function() {
        var deductionRow = `<div class="form-group row mb-2 deduction-row">
            <div class="col-lg-5">
                <input name="deduction_name[]" type="text" class="form-control" placeholder="Deduction Name">
            </div>
            <div class="col-lg-5">
                <input name="deduction_amount[]" type="number" step="0.01" class="form-control" placeholder="Amount">
            </div>
            <div class="col-lg-2">
                <button type="button" class="btn btn-danger remove-deduction">Remove</button>
            </div>
        </div>`;
        $('#deductionsSection').append(deductionRow);
    });

    // Remove Deduction
    $(document).on('click', '.remove-deduction', function() {
        $(this).closest('.deduction-row').remove();
    });
});
</script>

</body>

</html>
