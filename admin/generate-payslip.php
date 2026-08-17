<?php
include 'layouts/config.php';
require 'vendor/autoload.php'; // Include Composer's autoloader

// Function to display SweetAlert2 alerts and navigate back
function showAlert($title, $text, $icon) {
    echo '
    <!DOCTYPE html>
    <html>
    <head>
        <title>' . htmlspecialchars($title) . '</title>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body>
        <script>
            Swal.fire({
                title: "' . addslashes($title) . '",
                text: "' . addslashes($text) . '",
                icon: "' . addslashes($icon) . '",
                confirmButtonText: "OK"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "manage-payslips.php"; // Corrected this line
                }
            });
        </script>
    </body>
    </html>
    ';
    exit();
}


// Make sure there's no output before PDF generation
if (isset($_GET['id'])) {
    $payslip_id = intval($_GET['id']);

    // Fetch payslip, employee, and payroll details, including working_days, total_days_present, and total_days_absent
    $sql = "SELECT p.*, e.employee_name, e.designation_id, e.department_id, e.date_of_joining, e.work_location, e.salary, e.email, e.number, 
                   d.name AS department_name, des.name AS designation_name, pr.payroll_month, p.working_days, p.total_days_present, p.total_days_absent
            FROM payslip p
            JOIN employees e ON p.employee_id = e.id
            JOIN department d ON e.department_id = d.id
            JOIN designation des ON e.designation_id = des.id
            JOIN payroll pr ON p.payroll_id = pr.id
            WHERE p.id = ?";
    $stmt = $link->prepare($sql);
    if ($stmt === false) {
        showAlert("Error", "Failed to prepare the database query.", "error");
    }
    $stmt->bind_param("i", $payslip_id);
    if (!$stmt->execute()) {
        showAlert("Error", "Failed to execute the database query.", "error");
    }
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $payslip = $result->fetch_assoc();

        // Calculate basic, HRA, and fixed allowance
        $basic = $payslip['salary'] / 2;
        $houseRentAllowance = $basic / 2;
        $fixedAllowance = $basic / 2;

        // Default Earnings
        $earnings = [
            ['name' => 'Basic', 'amount' => $basic],
            ['name' => 'House Rent Allowance', 'amount' => $houseRentAllowance],
            ['name' => 'Fixed Allowance', 'amount' => $fixedAllowance]
        ];

        // Add any other earnings
        $otherEarnings = json_decode($payslip['earnings'], true) ?? [];
        foreach ($otherEarnings as $earning) {
            $earnings[] = $earning;
        }

        // Deductions
        $deductions = json_decode($payslip['deductions'], true) ?? [];

        // Calculate total earnings and total deductions
        $totalEarnings = 0;
        foreach ($earnings as $earning) {
            $totalEarnings += $earning['amount'];
        }

        $totalDeductions = 0;
        foreach ($deductions as $deduction) {
            $totalDeductions += $deduction['amount'];
        }

        // Format the payroll month as "August 2024"
        $payroll_month_formatted = date('F Y', strtotime($payslip['payroll_month'] . '-01'));

        // Create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // Set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Unique Arts');
        $pdf->SetTitle('Payslip');
        $pdf->SetSubject('Payslip for ' . $payroll_month_formatted);
        $pdf->SetKeywords('TCPDF, PDF, payslip, employee');

        // Remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // Set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // Set margins (left, top, right)
        $pdf->SetMargins(5, 25, 5, true); // Increased top margin to 25

        // Set auto page breaks
        $pdf->SetAutoPageBreak(true, 15);

        // Set font that supports the rupee symbol
        $pdf->SetFont('dejavusans', '', 10); // Using 'dejavusans' for better Unicode support

        // Add a page
        $pdf->AddPage();

        // Start creating the content
        $html = '
        <!-- Payslip Title with additional top margin -->
        <h2 style="text-align: center; color: #393185; margin: 30px 0 10px 0;">Payslip for ' . htmlspecialchars($payroll_month_formatted) . '</h2>

        <!-- Employee Details -->
        <table style="width: 100%; margin-bottom: 20px;">
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <table cellpadding="4" cellspacing="0" style="width: 100%;">
                        <tr><td style="font-weight: bold; width: 40%;">Employee Name:</td><td>' . htmlspecialchars($payslip['employee_name']) . '</td></tr>
                        <tr><td style="font-weight: bold;">Designation:</td><td>' . htmlspecialchars($payslip['designation_name']) . '</td></tr>
                        <tr><td style="font-weight: bold;">Department:</td><td>' . htmlspecialchars($payslip['department_name']) . '</td></tr>
                        <tr><td style="font-weight: bold;">Date Of Joining:</td><td>' . date('d/m/Y', strtotime($payslip['date_of_joining'])) . '</td></tr>
                        <tr><td style="font-weight: bold;">Pay Period:</td><td>' . htmlspecialchars($payroll_month_formatted) . '</td></tr>
                    </table>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <table cellpadding="4" cellspacing="0" style="width: 100%;">
                        <tr><td style="font-weight: bold; width: 40%;">Pay Date:</td><td>' . date('d/m/Y') . '</td></tr>
                        <tr><td style="font-weight: bold;">Work Location:</td><td>' . htmlspecialchars($payslip['work_location']) . '</td></tr>
                        <tr><td style="font-weight: bold;">Email:</td><td>' . htmlspecialchars($payslip['email']) . '</td></tr>
                        <tr><td style="font-weight: bold;">Phone Number:</td><td>' . htmlspecialchars($payslip['number']) . '</td></tr>
                    </table>
                </td>
            </tr>
        </table>

        <!-- Attendance Section -->
        <div style="margin-bottom: 20px;">
            <h3 style="color: #393185; border-bottom: 1px solid #393185; padding-bottom: 5px; margin-bottom: 10px;">ATTENDANCE</h3>
            <table cellpadding="4" cellspacing="0" style="width: 100%;">
                <tr style="background-color: #f9f9f9;">
                    <th style="text-align: left; padding: 5px;">Description</th>
                    <th style="text-align: right; padding: 5px;">Days</th>
                </tr>
                <tr>
                    <td style="padding: 5px;">Working Days</td>
                    <td style="padding: 5px; text-align: right;">' . htmlspecialchars($payslip['working_days']) . '</td>
                </tr>
                <tr>
                    <td style="padding: 5px;">Total Days Present</td>
                    <td style="padding: 5px; text-align: right;">' . htmlspecialchars($payslip['total_days_present']) . '</td>
                </tr>
                <tr>
                    <td style="padding: 5px;">Total Days Absent</td>
                    <td style="padding: 5px; text-align: right;">' . htmlspecialchars($payslip['total_days_absent']) . '</td>
                </tr>
            </table>
        </div>

        <!-- Earnings and Deductions -->
        <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
            <!-- Earnings -->
            <div style="width: 48%;">
                <h3 style="color: #393185; border-bottom: 1px solid #393185; padding-bottom: 5px; margin-bottom: 10px;">EARNINGS</h3>
                <table cellpadding="4" cellspacing="0" style="width: 100%;">
                    <tr style="background-color: #f9f9f9;">
                        <th style="text-align: left; padding: 5px;">Description</th>
                        <th style="text-align: right; padding: 5px;">Amount (₹)</th>
                    </tr>';
    
        foreach ($earnings as $earning) {
            $html .= '<tr>
                        <td style="padding: 5px;">' . htmlspecialchars($earning['name']) . '</td>
                        <td style="padding: 5px; text-align: right;">' . number_format($earning['amount'], 2) . '</td>
                      </tr>';
        }

        $html .= '<tr style="background-color: #f2f2f2;">
                    <td style="padding: 5px; font-weight: bold;">Total Earnings</td>
                    <td style="padding: 5px; text-align: right; font-weight: bold;">' . number_format($totalEarnings, 2) . '</td>
                  </tr>
                </table>
                </div>

                <!-- Deductions -->
                <div style="width: 48%;">
                    <h3 style="color: #393185; border-bottom: 1px solid #393185; padding-bottom: 5px; margin-bottom: 10px;">DEDUCTIONS</h3>
                    <table cellpadding="4" cellspacing="0" style="width: 100%;">
                        <tr style="background-color: #f9f9f9;">
                            <th style="text-align: left; padding: 5px;">Description</th>
                            <th style="text-align: right; padding: 5px;">Amount (₹)</th>
                        </tr>';

        foreach ($deductions as $deduction) {
            $html .= '<tr>
                        <td style="padding: 5px;">' . htmlspecialchars($deduction['name']) . '</td>
                        <td style="padding: 5px; text-align: right;">' . number_format($deduction['amount'], 2) . '</td>
                      </tr>';
        }

        $html .= '<tr style="background-color: #f2f2f2;">
                    <td style="padding: 5px; font-weight: bold;">Total Deductions</td>
                    <td style="padding: 5px; text-align: right; font-weight: bold;">' . number_format($totalDeductions, 2) . '</td>
                  </tr>
                </table>
                </div>
            </div>

            <!-- Net Pay -->
            <div style="text-align: right; margin-bottom: 30px;">
                <h3 style="color: #393185; margin-bottom: 10px;">Net Pay: <span style="color: #000;">₹' . number_format($payslip['total_pay'], 2) . '</span></h3>
                <p>Paid Days: ' . htmlspecialchars($payslip['total_days_present']) . '</p>
            </div>

            <!-- Footer Section -->
            <hr style="border: 0; border-top: 1px solid #ddd; margin-bottom: 10px;">
            <div style="text-align: center; color: #777; font-size: 10px;">
                <p>This is a computer-generated payslip and does not require a signature.</p>
                <p>Contact us at <a href="mailto:office@uniquearts.in" style="color: #777; text-decoration: none;">office@uniquearts.in</a> | Phone: +91-7385 110 110 | Address: Samuel Street, Mumbai.</p>
            </div>
        ';

        // ----------------------------
        // New Code Begins Here
        // ----------------------------

        // Define the directory path based on payroll month
        // Assuming 'payroll_month' is in 'YYYY-MM' format
        $pdf_dir = __DIR__ . '/assets/' . $payslip['payroll_month'] . '/';

        // Check if the directory exists; if not, create it
        if (!file_exists($pdf_dir)) {
            if (!mkdir($pdf_dir, 0755, true)) { // Use 0755 instead of 0777 for security
                showAlert("Error", "Failed to create directories.", "error");
            }
        }

        // Define the filename
        $filename = $payslip['employee_name'] . ' - ' . $payroll_month_formatted . ' ' . date('Y') . '.pdf';
        $filename = str_replace(' ', '_', $filename); // Replace spaces with underscores

        // Define the full file system path
        $file_system_path = $pdf_dir . $filename;

        // Save the PDF to the specified path
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output($file_system_path, 'F'); // Save to file

        // Define the PDF URL (web-accessible path)
        // Assuming 'Unique_Arts_Payslip_Portal' is the web root. Adjust accordingly.
        $pdf_url = 'assets/' . $payslip['payroll_month'] . '/' . $filename;

        // Update the 'pdf_url' in the 'payslip' table
        $update_sql = "UPDATE payslip SET payslip_url = ? WHERE id = ?";
        $update_stmt = $link->prepare($update_sql);
        if ($update_stmt === false) {
            showAlert("Error", "Failed to prepare the update statement.", "error");
        }
        $update_stmt->bind_param("si", $pdf_url, $payslip_id);
        if (!$update_stmt->execute()) {
            showAlert("Error", "Failed to update the payslip record.", "error");
        }
        $update_stmt->close();

        // Success Alert
        showAlert("Success", "Payslip has been successfully generated and saved.", "success");

    } else {
        // Payslip not found
        showAlert("Error", "Payslip not found.", "error");
    }

    $stmt->close();
} else {
    // No ID provided
    showAlert("Error", "Invalid request. Payslip ID is missing.", "error");
}

// Make sure there's no additional output after this point
exit();
?>
