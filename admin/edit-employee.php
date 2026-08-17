<?php
include "layouts/config.php";

if (isset($_GET['id'])) {
    $employee_id = intval($_GET['id']);

    // Fetch existing employee data
    $sql = "SELECT * FROM employees WHERE id = ?";
    $stmt = $link->prepare($sql);
    $stmt->bind_param("i", $employee_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $employee = $result->fetch_assoc();
    } else {
        // Employee not found; display error message
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Edit Employee</title>
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
                    title: 'Employee Not Found',
                    text: 'The requested employee does not exist.',
                    showConfirmButton: false,
                    timer: 5000,
                    timerProgressBar: true,
                    willClose: () => {
                        window.location.href = 'manage-employees.php';
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
    // No ID provided; redirect to manage employees page
    header("Location: manage-employees.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data and trim whitespace
    $employee_name = trim($_POST['employee_name']);
    $designation_id = $_POST['designation_id'];
    $department_id = $_POST['department_id'];
    $date_of_joining = $_POST['date_of_joining'];
    $work_location = trim($_POST['work_location']);
    $salary = trim($_POST['salary']);
    $email = trim($_POST['email']);
    $number = trim($_POST['number']);
    $aadhar_number = trim($_POST['aadhar_number']);
    $pan_number = trim($_POST['pan_number']);
    $bank_account_number = trim($_POST['bank_account_number']);

    // Validate required fields
    $errors = [];
    if (empty($employee_name)) {
        $errors[] = "Employee name is required.";
    }
    if (empty($designation_id)) {
        $errors[] = "Designation is required.";
    }
    if (empty($department_id)) {
        $errors[] = "Department is required.";
    }
    if (empty($date_of_joining)) {
        $errors[] = "Date of joining is required.";
    }

    if (empty($errors)) {
        // Prepare the UPDATE statement
        $sql = "UPDATE employees SET employee_name = ?, designation_id = ?, department_id = ?, date_of_joining = ?, work_location = ?, salary = ?, email = ?, number = ?, aadhar_number = ?, pan_number = ?, bank_account_number = ? WHERE id = ?";
        $stmt = $link->prepare($sql);
        $stmt->bind_param(
            "siissdsssssi",
            $employee_name,
            $designation_id,
            $department_id,
            $date_of_joining,
            $work_location,
            $salary,
            $email,
            $number,
            $aadhar_number,
            $pan_number,
            $bank_account_number,
            $employee_id
        );

        if ($stmt->execute()) {
            // Display success message and redirect
            ?>
            <!DOCTYPE html>
            <html>
            <head>
                <title>Edit Employee</title>
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
                        title: 'Employee Updated',
                        text: 'The employee details have been successfully updated.',
                        showConfirmButton: false,
                        timer: 5000,
                        timerProgressBar: true,
                        willClose: () => {
                            window.location.href = 'manage-employees.php';
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
                <title>Edit Employee</title>
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
                        title: 'Error Updating Employee',
                        text: 'An error occurred while updating the employee details.',
                        showConfirmButton: false,
                        timer: 5000,
                        timerProgressBar: true,
                        willClose: () => {
                            window.location.href = 'manage-employees.php';
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
            <title>Edit Employee</title>
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
    <title>Edit Employee</title>
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
                $maintitle = "Employees";
                $title = "Edit Employee";
                include 'layouts/breadcrumb.php';
                ?>
                <!-- End page title -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Edit Employee Details</h4>
                                <form method="post" action="edit-employee.php?id=<?php echo $employee_id; ?>" enctype="multipart/form-data">
                                    <div class="form-group row mb-4">
                                        <label for="employeeName" class="col-form-label col-lg-2">Employee Name<span class="text-danger">*</span></label>
                                        <div class="col-lg-10">
                                            <input id="employeeName" name="employee_name" type="text" class="form-control" value="<?php echo htmlspecialchars($employee['employee_name']); ?>" required>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-4">
                                        <label for="designationId" class="col-form-label col-lg-2">Designation<span class="text-danger">*</span></label>
                                        <div class="col-lg-10">
                                            <select id="designationId" name="designation_id" class="form-control" required>
                                                <option value="">Select Designation...</option>
                                                <?php
                                                // Fetch designations
                                                $designationSql = "SELECT id, name FROM designation";
                                                $designationResult = $link->query($designationSql);
                                                while ($designationRow = $designationResult->fetch_assoc()) {
                                                    $selected = ($employee['designation_id'] == $designationRow['id']) ? 'selected' : '';
                                                    echo "<option value='{$designationRow['id']}' $selected>{$designationRow['name']}</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-4">
                                        <label for="departmentId" class="col-form-label col-lg-2">Department<span class="text-danger">*</span></label>
                                        <div class="col-lg-10">
                                            <select id="departmentId" name="department_id" class="form-control" required>
                                                <option value="">Select Department...</option>
                                                <?php
                                                // Fetch departments
                                                $departmentSql = "SELECT id, name FROM department";
                                                $departmentResult = $link->query($departmentSql);
                                                while ($departmentRow = $departmentResult->fetch_assoc()) {
                                                    $selected = ($employee['department_id'] == $departmentRow['id']) ? 'selected' : '';
                                                    echo "<option value='{$departmentRow['id']}' $selected>{$departmentRow['name']}</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-4">
                                        <label for="dateOfJoining" class="col-form-label col-lg-2">Date of Joining<span class="text-danger">*</span></label>
                                        <div class="col-lg-10">
                                            <input id="dateOfJoining" name="date_of_joining" type="date" class="form-control" value="<?php echo $employee['date_of_joining']; ?>" required>
                                        </div>
                                    </div>

                                    <!-- Optional Fields -->
                                    <div class="form-group row mb-4">
                                        <label for="workLocation" class="col-form-label col-lg-2">Work Location</label>
                                        <div class="col-lg-10">
                                            <input id="workLocation" name="work_location" type="text" class="form-control" value="<?php echo htmlspecialchars($employee['work_location']); ?>">
                                        </div>
                                    </div>

                                    <div class="form-group row mb-4">
                                        <label for="salary" class="col-form-label col-lg-2">Salary</label>
                                        <div class="col-lg-10">
                                            <input id="salary" name="salary" type="number" step="0.01" class="form-control" value="<?php echo htmlspecialchars($employee['salary']); ?>">
                                        </div>
                                    </div>

                                    <div class="form-group row mb-4">
                                        <label for="email" class="col-form-label col-lg-2">Email</label>
                                        <div class="col-lg-10">
                                            <input id="email" name="email" type="email" class="form-control" value="<?php echo htmlspecialchars($employee['email']); ?>">
                                        </div>
                                    </div>

                                    <div class="form-group row mb-4">
                                        <label for="number" class="col-form-label col-lg-2">Contact Number</label>
                                        <div class="col-lg-10">
                                            <input id="number" name="number" type="text" class="form-control" value="<?php echo htmlspecialchars($employee['number']); ?>">
                                        </div>
                                    </div>

                                    <div class="form-group row mb-4">
                                        <label for="aadharNumber" class="col-form-label col-lg-2">Aadhar Number</label>
                                        <div class="col-lg-10">
                                            <input id="aadharNumber" name="aadhar_number" type="text" class="form-control" value="<?php echo htmlspecialchars($employee['aadhar_number']); ?>">
                                        </div>
                                    </div>

                                    <div class="form-group row mb-4">
                                        <label for="panNumber" class="col-form-label col-lg-2">PAN Number</label>
                                        <div class="col-lg-10">
                                            <input id="panNumber" name="pan_number" type="text" class="form-control" value="<?php echo htmlspecialchars($employee['pan_number']); ?>">
                                        </div>
                                    </div>

                                    <div class="form-group row mb-4">
                                        <label for="bankAccountNumber" class="col-form-label col-lg-2">Bank Account Number</label>
                                        <div class="col-lg-10">
                                            <input id="bankAccountNumber" name="bank_account_number" type="text" class="form-control" value="<?php echo htmlspecialchars($employee['bank_account_number']); ?>">
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="row justify-content-end">
                                        <div class="col-lg-10">
                                            <button type="submit" class="btn btn-primary">Update Employee</button>
                                            <a href="manage-employees.php" class="btn btn-secondary">Cancel</a>
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

<!-- Form Validation JS (Optional) -->
<!-- You can include validation scripts if needed -->

</body>

</html>
