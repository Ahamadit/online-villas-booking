<?php
// delete-reservation.php

include "layouts/config.php";

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Optional: Check if the reservation is associated with any other records
    // For example, if there are payment records linked to the reservation
    // Uncomment and modify the following block if such associations exist

    /*
    $checkSql = "SELECT COUNT(*) AS payment_count FROM payments WHERE reservation_id = ?";
    $checkStmt = $link->prepare($checkSql);
    $checkStmt->bind_param("i", $id);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();
    $checkRow = $checkResult->fetch_assoc();

    if ($checkRow['payment_count'] > 0) {
        // There are payments associated; display error message
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Delete Reservation</title>
            <!-- Include SweetAlert2 CSS -->
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        </head>
        <body>
            <!-- Include SweetAlert2 JS -->
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Cannot Delete Reservation',
                    text: 'There are payments associated with this reservation.',
                    showConfirmButton: false,
                    timer: 5000,
                    timerProgressBar: true,
                    didClose: () => {
                        window.location.href = 'manage-enquiries.php';
                    }
                });
            </script>
        </body>
        </html>
        <?php
        exit();
    }
    */

    // Prepare the DELETE statement
    $sql = "DELETE FROM reservations WHERE id = ?";
    $stmt = $link->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Deletion successful; display success message
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Delete Reservation</title>
            <!-- Include SweetAlert2 CSS -->
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        </head>
        <body>
            <!-- Include SweetAlert2 JS -->
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Reservation Deleted',
                    text: 'The reservation has been successfully deleted.',
                    showConfirmButton: false,
                    timer: 5000,
                    timerProgressBar: true,
                    didClose: () => {
                        window.location.href = 'manage-enquiries.php';
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
            <title>Delete Reservation</title>
            <!-- Include SweetAlert2 CSS -->
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        </head>
        <body>
            <!-- Include SweetAlert2 JS -->
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error Deleting Reservation',
                    text: 'An error occurred while deleting the reservation.',
                    showConfirmButton: false,
                    timer: 5000,
                    timerProgressBar: true,
                    didClose: () => {
                        window.location.href = 'manage-enquiries.php';
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
        <title>Delete Reservation</title>
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
                text: 'No reservation ID provided.',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
                didClose: () => {
                    window.location.href = 'manage-enquiries.php';
                }
            });
        </script>
    </body>
    </html>
    <?php
    exit();
}
?>
