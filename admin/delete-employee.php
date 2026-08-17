<?php
include "layouts/config.php";

if (isset($_GET['id'])) {
    $employee_id = intval($_GET['id']);

    // Check if the employee exists
    $checkSql = "SELECT * FROM employees WHERE id = ?";
    $checkStmt = $link->prepare($checkSql);
    $checkStmt->bind_param("i", $employee_id);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        // Employee exists; proceed to delete
        $sql = "DELETE FROM employees WHERE id = ?";
        $stmt = $link->prepare($sql);
        $stmt->bind_param("i", $employee_id);

        if ($stmt->execute()) {
            // Deletion successful; display success message
            ?>
            <!DOCTYPE html>
            <html>
            <head>
                <title>Delete Employee</title>
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
                        title: 'Employee Deleted',
                        text: 'The employee has been successfully deleted.',
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
            // Error occurred during deletion; display error message
            ?>
            <!DOCTYPE html>
            <html>
            <head>
                <title>Delete Employee</title>
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
                        title: 'Error Deleting Employee',
                        text: 'An error occurred while deleting the employee.',
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
        // Employee not found; display error message
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Delete Employee</title>
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

    $checkStmt->close();
} else {
    // Invalid request; display error message
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Delete Employee</title>
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
                title: 'Invalid Request',
                text: 'No employee ID provided.',
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
?>
