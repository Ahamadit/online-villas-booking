<?php
include "layouts/config.php";

if (isset($_GET['id'])) {
    $payslip_id = intval($_GET['id']);

    // Prepare the DELETE statement
    $sql = "DELETE FROM payslip WHERE id = ?";
    $stmt = $link->prepare($sql);
    $stmt->bind_param("i", $payslip_id);

    if ($stmt->execute()) {
        // If deletion is successful, show a success message
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Delete Payslip</title>
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
                    title: 'Payslip Deleted',
                    text: 'The payslip has been successfully deleted.',
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
    } else {
        // If there was an error deleting the payslip, show an error message
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Delete Payslip</title>
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
                    title: 'Error Deleting Payslip',
                    text: 'An error occurred while deleting the payslip. Please try again later.',
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
    }

    $stmt->close();
} else {
    // If no ID was provided, show an error message
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Delete Payslip</title>
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
                text: 'No valid payslip ID was provided.',
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
?>
