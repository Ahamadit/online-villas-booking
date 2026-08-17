<?php
include "layouts/config.php";

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Check if any employees are associated with this department
    $checkSql = "SELECT COUNT(*) AS employee_count FROM employees WHERE department_id = ?";
    $checkStmt = $link->prepare($checkSql);
    $checkStmt->bind_param("i", $id);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();
    $checkRow = $checkResult->fetch_assoc();

    if ($checkRow['employee_count'] > 0) {
        // There are employees associated; display error message
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Delete Department</title>
            <!-- Include SweetAlert2 CSS -->
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        </head>
        <body>
            <!-- Include SweetAlert2 JS -->
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Cannot Delete Department',
                    text: 'There are employees associated with this department.',
                    showConfirmButton: false,
                    timer: 5000,
                    timerProgressBar: true,
                    didClose: () => {
                        window.location.href = 'manage-departments.php';
                    }
                });
            </script>
        </body>
        </html>
        <?php
        exit();
    }

    // Prepare the DELETE statement
    $sql = "DELETE FROM department WHERE id = ?";
    $stmt = $link->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Deletion successful; display success message
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Delete Department</title>
            <!-- Include SweetAlert2 CSS -->
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        </head>
        <body>
            <!-- Include SweetAlert2 JS -->
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Department Deleted',
                    text: 'The department has been successfully deleted.',
                    showConfirmButton: false,
                    timer: 5000,
                    timerProgressBar: true,
                    didClose: () => {
                        window.location.href = 'manage-departments.php';
                    }
                });
            </script>
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
            <title>Delete Department</title>
            <!-- Include SweetAlert2 CSS -->
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        </head>
        <body>
            <!-- Include SweetAlert2 JS -->
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error Deleting Department',
                    text: 'An error occurred while deleting the department.',
                    showConfirmButton: false,
                    timer: 5000,
                    timerProgressBar: true,
                    didClose: () => {
                        window.location.href = 'manage-departments.php';
                    }
                });
            </script>
        </body>
        </html>
        <?php
        exit();
    }

    $stmt->close();
} else {
    // Invalid request; display error message
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Delete Department</title>
        <!-- Include SweetAlert2 CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    </head>
    <body>
        <!-- Include SweetAlert2 JS -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Invalid Request',
                text: 'No department ID provided.',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
                didClose: () => {
                    window.location.href = 'manage-departments.php';
                }
            });
        </script>
    </body>
    </html>
    <?php
    exit();
}
?>
