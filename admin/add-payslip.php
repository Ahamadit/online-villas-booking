<?php
include "layouts/config.php";

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

        // Prepare the INSERT statement
        $sql = "INSERT INTO payslip (employee_id, payroll_id, working_days, total_days_present, total_days_absent, earnings, deductions, total_pay, pay_date)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $link->prepare($sql);
        $stmt->bind_param(
            "iiiisssds",
            $employee_id,
            $payroll_id,
            $working_days,
            $total_days_present,
            $total_days_absent,
            $earnings_json,
            $deductions_json,
            $total_pay,
            $pay_date
        );

        if ($stmt->execute()) {
            // Display success message and redirect
            ?>
            <!DOCTYPE html>
            <html>
            <head>
                <title>Add Payslip</title>
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
                        title: 'Payslip Added',
                        text: 'The payslip record has been successfully added.',
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
                <title>Add Payslip</title>
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
                        title: 'Error Adding Payslip',
                        text: 'An error occurred while adding the payslip record.',
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
        // Display validation errors and redirect back to the form
        $error_message = implode("\\n", $errors);
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Add Payslip</title>
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
    <title>Add Payslip</title>
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
                $title = "Add Payslip";
                include 'layouts/breadcrumb.php';
                ?>
                <!-- End page title -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Enter Payslip Details</h4>
                                <form method="post" action="add-payslip.php" enctype="multipart/form-data">
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
                                                    echo "<option value='{$employeeRow['id']}'>{$employeeRow['employee_name']}</option>";
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
                                                    echo "<option value='{$payrollRow['id']}'>{$payrollRow['payroll_month']}</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Optional Fields -->
                                    <div class="form-group row mb-4">
                                        <label for="workingDays" class="col-form-label col-lg-2">Working Days</label>
                                        <div class="col-lg-10">
                                            <input id="workingDays" name="working_days" type="number" class="form-control" placeholder="Enter Working Days...">
                                        </div>
                                    </div>

                                    <div class="form-group row mb-4">
                                        <label for="daysPresent" class="col-form-label col-lg-2">Total Days Present</label>
                                        <div class="col-lg-10">
                                            <input id="daysPresent" name="total_days_present" type="number" class="form-control" placeholder="Enter Total Days Present...">
                                        </div>
                                    </div>

                                    <div class="form-group row mb-4">
                                        <label for="daysAbsent" class="col-form-label col-lg-2">Total Days Absent</label>
                                        <div class="col-lg-10">
                                            <input id="daysAbsent" name="total_days_absent" type="number" class="form-control" placeholder="Enter Total Days Absent...">
                                        </div>
                                    </div>

                                    <!-- Earnings Section -->
                                    <h5 class="mb-3">Earnings</h5>
                                    <div id="earningsSection">
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
                                    </div>
                                    <button type="button" class="btn btn-success mb-4" id="addEarning">Add Earning</button>

                                    <!-- Deductions Section -->
                                    <h5 class="mb-3">Deductions</h5>
                                    <div id="deductionsSection">
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
                                    </div>
                                    <button type="button" class="btn btn-success mb-4" id="addDeduction">Add Deduction</button>

                                    <div class="form-group row mb-4">
                                        <label for="totalPay" class="col-form-label col-lg-2">Total Pay<span class="text-danger">*</span></label>
                                        <div class="col-lg-10">
                                            <input id="totalPay" name="total_pay" type="number" step="0.01" class="form-control" placeholder="Enter Total Pay..." required>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-4">
                                        <label for="payDate" class="col-form-label col-lg-2">Pay Date<span class="text-danger">*</span></label>
                                        <div class="col-lg-10">
                                            <input id="payDate" name="pay_date" type="date" class="form-control" required>
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="row justify-content-end">
                                        <div class="col-lg-10">
                                            <button type="submit" class="btn btn-success">Submit Payslip</button>
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
