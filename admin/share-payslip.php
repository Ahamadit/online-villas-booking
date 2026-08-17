<?php
// share-payslip.php

// Start the session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include "layouts/config.php"; // Ensure this file sets up the $link (mysqli) connection

// Check if 'id' is set in GET parameters
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    // Validate that 'id' is an integer to prevent SQL injection
    if (!filter_var($id, FILTER_VALIDATE_INT)) {
        die('Invalid Payslip ID.');
    }

    // Step 1: Retrieve employee_id and payroll_id from the payslip table
    $stmt_payslip = $link->prepare("SELECT employee_id, payroll_id, payslip_url FROM payslip WHERE id = ?");
    if (!$stmt_payslip) {
        die('Prepare failed (payslip): (' . $link->errno . ') ' . $link->error);
    }

    // Bind the 'id' parameter
    $stmt_payslip->bind_param("i", $id);

    // Execute the statement
    if (!$stmt_payslip->execute()) {
        die('Execute failed (payslip): (' . $stmt_payslip->errno . ') ' . $stmt_payslip->error);
    }

    // Bind the result variables
    $stmt_payslip->bind_result($employee_id, $payroll_id, $payslip_url);

    // Fetch the result
    if ($stmt_payslip->fetch()) {
        // Close the payslip statement
        $stmt_payslip->close();

        // Step 2: Retrieve employee details from the employee table
        $stmt_employee = $link->prepare("SELECT employee_name, email FROM employees WHERE id = ?");
        if (!$stmt_employee) {
            die('Prepare failed (employee): (' . $link->errno . ') ' . $link->error);
        }

        // Bind the 'employee_id' parameter
        $stmt_employee->bind_param("i", $employee_id);

        // Execute the statement
        if (!$stmt_employee->execute()) {
            die('Execute failed (employee): (' . $stmt_employee->errno . ') ' . $stmt_employee->error);
        }

        // Bind the result variables
        $stmt_employee->bind_result($employee_name, $employee_email);

        // Fetch the employee details
        if ($stmt_employee->fetch()) {
            // Close the employee statement
            $stmt_employee->close();
        } else {
            // Employee not found
            $stmt_employee->close();
            $link->close();

            echo '<!DOCTYPE html>
            <html>
            <head>
                <title>Share Payslip</title>
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            </head>
            <body>
                <script>
                    Swal.fire({
                        title: "Error",
                        text: "Employee details not found.",
                        icon: "error",
                        confirmButtonText: "OK"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "manage-payslip.php";
                        }
                    });
                </script>
            </body>
            </html>';
            exit();
        }

        // Step 3: Retrieve payroll_month from the payroll table
        $stmt_payroll = $link->prepare("SELECT payroll_month FROM payroll WHERE id = ?");
        if (!$stmt_payroll) {
            die('Prepare failed (payroll): (' . $link->errno . ') ' . $link->error);
        }

        // Bind the 'payroll_id' parameter
        $stmt_payroll->bind_param("i", $payroll_id);

        // Execute the statement
        if (!$stmt_payroll->execute()) {
            die('Execute failed (payroll): (' . $stmt_payroll->errno . ') ' . $stmt_payroll->error);
        }

        // Bind the result variable
        $stmt_payroll->bind_result($payroll_month);

        // Fetch the payroll month
        if ($stmt_payroll->fetch()) {
            // Close the payroll statement
            $stmt_payroll->close();
        } else {
            // Payroll not found
            $stmt_payroll->close();
            $link->close();

            echo '<!DOCTYPE html>
            <html>
            <head>
                <title>Share Payslip</title>
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            </head>
            <body>
                <script>
                    Swal.fire({
                        title: "Error",
                        text: "Payroll details not found.",
                        icon: "error",
                        confirmButtonText: "OK"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "manage-payslip.php";
                        }
                    });
                </script>
            </body>
            </html>';
            exit();
        }

        // Close the database connection
$link->close();

// Step 4: Generate the mailto link
$date = DateTime::createFromFormat('Y-m', $payroll_month);
$formatted_month = $date->format('F Y'); // Format as 'August 2024'

$subject = "Your Payslip for " . htmlspecialchars($formatted_month);

// Manually encode the body content for mailto
$body = "Hello " . htmlspecialchars($employee_name). "," . "%0A%0A" .
        "Hope you are doing well. Your payslip for the month of " . htmlspecialchars($formatted_month). " has been issued." . "%0A%0A" .
        "To view or download your payslip use the following link: https://payslip.uniquearts.in/" . htmlspecialchars($payslip_url) . "%0A%0A" .
        "Regards,%0AUniqueArts.";

// Manually replace spaces with %20 in the body and subject
$mailto_link = "mailto:" . rawurlencode($employee_email) .
               "?subject=" . str_replace(' ', '%20', htmlspecialchars($subject)) .
               "&body=" . str_replace(' ', '%20', htmlspecialchars($body));

// Output the HTML with SweetAlert2
echo '<!DOCTYPE html>
<html>
<head>
    <title>Share Payslip</title>
    <!-- Include SweetAlert2 CSS and JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <script>
        // Open the mailto link in a new tab/window
        window.open("' . $mailto_link . '", "_blank");

        // Show SweetAlert2 success message
        Swal.fire({
            title: "Success",
            text: "Payslip shared successfully.",
            icon: "success",
            confirmButtonText: "OK"
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect to manage-payslip.php after clicking OK
                window.location.href = "manage-payslips.php";
            }
        });
    </script>
</body>
</html>';
    } else {
        // No payslip found with the given ID
        $stmt_payslip->close();
        $link->close();

        echo '<!DOCTYPE html>
        <html>
        <head>
            <title>Share Payslip</title>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        </head>
        <body>
            <script>
                Swal.fire({
                    title: "Error",
                    text: "Payslip not found.",
                    icon: "error",
                    confirmButtonText: "OK"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "manage-payslip.php";
                    }
                });
            </script>
        </body>
        </html>';
    }
} else {
    // 'id' is not set or is empty
    echo '<!DOCTYPE html>
    <html>
    <head>
        <title>Share Payslip</title>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body>
        <script>
            Swal.fire({
                title: "Error",
                text: "Invalid request. Payslip ID is missing.",
                icon: "error",
                confirmButtonText: "OK"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "manage-payslip.php";
                }
            });
        </script>
    </body>
    </html>';
}
