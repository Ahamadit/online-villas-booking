<?php
include "layouts/config.php";

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Check if any employees are associated with this designation
    $checkSql = "SELECT COUNT(*) AS employee_count FROM employees WHERE designation_id = ?";
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
            <title>Delete Designation</title>
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
                    title: 'Cannot Delete Designation',
                    text: 'There are employees associated with this designation.',
                    showConfirmButton: false,
                    timer: 5000,
                    timerProgressBar: true,
                    willClose: () => {
                        window.location.href = 'manage-designations.php';
                    }
                });
            </script>

            <?php include 'layouts/vendor-scripts.php'; ?>
        </body>
        </html>
        <?php
        exit();
    }

    // Prepare the DELETE statement
    $sql = "DELETE FROM designation WHERE id = ?";
    $stmt = $link->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Deletion successful; display success message
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Delete Designation</title>
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
                    title: 'Designation Deleted',
                    text: 'The designation has been successfully deleted.',
                    showConfirmButton: false,
                    timer: 5000,
                    timerProgressBar: true,
                    willClose: () => {
                        window.location.href = 'manage-designations.php';
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
            <title>Delete Designation</title>
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
                    title: 'Error Deleting Designation',
                    text: 'An error occurred while deleting the designation.',
                    showConfirmButton: false,
                    timer: 5000,
                    timerProgressBar: true,
                    willClose: () => {
                        window.location.href = 'manage-designations.php';
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
    // Invalid request; display error message
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Delete Designation</title>
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
                text: 'No designation ID provided.',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
                willClose: () => {
                    window.location.href = 'manage-designations.php';
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
