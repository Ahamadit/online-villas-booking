<?php include 'layouts/session.php'; ?>
<?php include 'layouts/main.php'; ?>

<head>

    <title>Employee Attendance Details</title>

    <?php include 'layouts/head.php'; ?>

    <!-- Include Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

    <?php include 'layouts/head-style.php'; ?>

    <!-- Include Bootstrap CSS (if not already included in head-style.php) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Include SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <!-- Custom CSS for additional styling -->
    <style>
        /* Attendance Status Colors */
        .absent {
            border-left: 5px solid #dc3545; /* Red */
        }

        .undertime {
            border-left: 5px solid #ffc107; /* Yellow */
        }

        .ontime {
            border-left: 5px solid #28a745; /* Green */
        }

        .overtime {
            border-left: 5px solid #155724; /* Dark Green */
        }

        /* Card Hover Effect */
        .attendance-card:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            cursor: pointer;
        }

        /* Responsive Grid Adjustments */
        @media (max-width: 767.98px) {
            .card-columns {
                column-count: 1;
            }
        }

        @media (min-width: 768px) and (max-width: 991.98px) {
            .card-columns {
                column-count: 2;
            }
        }

        @media (min-width: 992px) {
            .card-columns {
                column-count: 3;
            }
        }

        /* Modal Header Colors */
        .modal-header.absent {
            background-color: #dc3545;
            color: #fff;
        }

        .modal-header.undertime {
            background-color: #ffc107;
            color: #fff;
        }

        .modal-header.ontime {
            background-color: #28a745;
            color: #fff;
        }

        .modal-header.overtime {
            background-color: #155724;
            color: #fff;
        }

        /* Custom class for dark green (overtime) */
        .bg-dark-success {
            background-color: #155724 !important;
        }

        /* Additional Styling for Filter Form */
        .filter-form {
            margin-bottom: 30px;
        }

        .filter-form .form-select {
            width: 200px;
            display: inline-block;
            margin-right: 15px;
        }

        @media (max-width: 576px) {
            .filter-form .form-select {
                width: 100%;
                margin-bottom: 15px;
            }
        }
    </style>

</head>

<?php include 'layouts/body.php'; ?>

<!-- Begin page -->
<div id="layout-wrapper">

    <?php include 'layouts/menu-admin.php'; ?>

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <!-- Start Page Title -->
                <?php
                $maintitle = "Employee Attendance";
                $title = "Attendance Details";
                ?>
                <?php include 'layouts/breadcrumb.php'; ?>
                <!-- End Page Title -->

                <?php
                include "layouts/config.php";

                // Enable error reporting for debugging (Remove in production)
                ini_set('display_errors', 1);
                ini_set('display_startup_errors', 1);
                error_reporting(E_ALL);

                // Ensure the employee is logged in
                if (!isset($_SESSION['id'])) {
                    header("Location: login.php");
                    exit;
                }

                if (isset($_GET['id']) && $_GET['id'] != null)
                {
                    $_SESSION['id'] = $_GET['id'];
                }
                $employee_id = $_SESSION['id'];

                // Fetch employee details
                $stmt = $link->prepare("SELECT e.*, d.name AS department_name, des.name AS designation_name
                                        FROM employees e
                                        LEFT JOIN department d ON e.department_id = d.id
                                        LEFT JOIN designation des ON e.designation_id = des.id
                                        WHERE e.id = ?");
                $stmt->bind_param("i", $employee_id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result && $result->num_rows > 0) {
                    $employee = $result->fetch_assoc();
                } else {
                    echo "<div class='alert alert-danger'>Employee details not found.</div>";
                    exit;
                }
                $stmt->close();

                // Handle Month-Year Filter
                // If form is submitted, get selected month and year from GET parameters
                // Else, default to current month and year
                $selected_month = isset($_GET['month']) ? $_GET['month'] : date('m');
                $selected_year = isset($_GET['year']) ? $_GET['year'] : date('Y');

                // Validate month and year
                if (!checkdate($selected_month, 1, $selected_year)) {
                    // Invalid month/year, default to current
                    $selected_month = date('m');
                    $selected_year = date('Y');
                }

                // Fetch all clock_in and clock_out records for the selected month and year
                // Fetch clock_in records
                $sql_in = "SELECT clock_in_time FROM clock_in 
                           WHERE employee_id = ? 
                           AND MONTH(clock_in_time) = ? 
                           AND YEAR(clock_in_time) = ? 
                           ORDER BY clock_in_time ASC";
                $stmt_in = $link->prepare($sql_in);
                $stmt_in->bind_param("iii", $employee_id, $selected_month, $selected_year);
                $stmt_in->execute();
                $result_in = $stmt_in->get_result();
                $clock_in_data = [];
                if ($result_in && $result_in->num_rows > 0) {
                    while ($row_in = $result_in->fetch_assoc()) {
                        $date = date('Y-m-d', strtotime($row_in['clock_in_time']));
                        if (!isset($clock_in_data[$date])) {
                            $clock_in_data[$date] = [];
                        }
                        $clock_in_data[$date]['clock_in'][] = $row_in['clock_in_time'];
                    }
                }
                $stmt_in->close();

                // Fetch clock_out records
                $sql_out = "SELECT clock_out_time FROM clock_out 
                            WHERE employee_id = ? 
                            AND MONTH(clock_out_time) = ? 
                            AND YEAR(clock_out_time) = ? 
                            ORDER BY clock_out_time ASC";
                $stmt_out = $link->prepare($sql_out);
                $stmt_out->bind_param("iii", $employee_id, $selected_month, $selected_year);
                $stmt_out->execute();
                $result_out = $stmt_out->get_result();
                if ($result_out && $result_out->num_rows > 0) {
                    while ($row_out = $result_out->fetch_assoc()) {
                        $date = date('Y-m-d', strtotime($row_out['clock_out_time']));
                        if (!isset($clock_in_data[$date])) {
                            $clock_in_data[$date] = [];
                        }
                        $clock_in_data[$date]['clock_out'][] = $row_out['clock_out_time'];
                    }
                }
                $stmt_out->close();

                // Get all dates of the selected month
                $start_date = date('Y-m-01', strtotime("$selected_year-$selected_month-01"));
                $end_date = date('Y-m-t', strtotime("$selected_year-$selected_month-01"));

                $all_dates = [];
                $current = strtotime($start_date);
                $end = strtotime($end_date);
                while ($current <= $end) {
                    $all_dates[] = date('Y-m-d', $current);
                    $current = strtotime("+1 day", $current);
                }

                // Prepare attendance details
                $attendance_details = [];
                foreach ($all_dates as $date) {
                    if (isset($clock_in_data[$date])) {
                        $clock_ins = $clock_in_data[$date]['clock_in'];
                        $clock_outs = isset($clock_in_data[$date]['clock_out']) ? $clock_in_data[$date]['clock_out'] : [];

                        // Pair clock_in and clock_out times
                        $paired_times = [];
                        $count = min(count($clock_ins), count($clock_outs));
                        $total_seconds = 0;
                        for ($i = 0; $i < $count; $i++) {
                            $in_time = strtotime($clock_ins[$i]);
                            $out_time = strtotime($clock_outs[$i]);
                            if ($out_time > $in_time) {
                                // Calculate duration in seconds
                                $duration_seconds = $out_time - $in_time;
                                $paired_times[] = [
                                    'clock_in' => date('h:i A', $in_time),
                                    'clock_out' => date('h:i A', $out_time),
                                    'duration' => gmdate("H:i", $duration_seconds) // in H:i format
                                ];
                                $total_seconds += $duration_seconds;
                            }
                        }

                        // Handle ongoing clock_in (if any)
                        if (count($clock_ins) > count($clock_outs)) {
                            $last_in_time = strtotime(end($clock_ins));
                            $current_time = time();
                            if ($current_time > $last_in_time) {
                                $duration_seconds = $current_time - $last_in_time;
                                $duration_formatted = gmdate("H:i", $duration_seconds);
                                $paired_times[] = [
                                    'clock_in' => date('h:i A', $last_in_time),
                                    'clock_out' => 'Ongoing',
                                    'duration' => $duration_formatted
                                ];
                                $total_seconds += $duration_seconds;
                            }
                        }

                        // Convert total seconds to H:i format
                        $hours = floor($total_seconds / 3600);
                        $minutes = floor(($total_seconds % 3600) / 60);
                        $total_hours_formatted = sprintf("%02d:%02d", $hours, $minutes);

                        // Determine attendance status based on total hours
                        if ($hours < 8 || ($hours == 8 && $minutes < 45)) { // Less than 8h45m
                            $status = 'undertime';
                        } elseif (($hours == 8 && $minutes >= 45) || ($hours == 9 && $minutes <= 30)) { // Between 8h45m and 9h30m
                            $status = 'ontime';
                        } elseif ($hours > 9 || ($hours == 9 && $minutes > 30)) { // More than 9h30m
                            $status = 'overtime';
                        } else { // Fallback
                            $status = '';
                        }

                        $attendance_details[] = [
                            'date' => $date,
                            'clock_in' => $clock_ins,
                            'clock_out' => $clock_outs,
                            'paired_times' => $paired_times,
                            'total_hours' => $total_hours_formatted . ' hrs',
                            'status' => $status
                        ];
                    } else {
                        // Absent
                        $attendance_details[] = [
                            'date' => $date,
                            'clock_in' => [],
                            'clock_out' => [],
                            'paired_times' => [],
                            'total_hours' => '00:00 hrs',
                            'status' => 'absent'
                        ];
                    }
                }
                ?>

                <!-- Attendance Details Section -->
                <div class="row mb-4">
                    <div class="col-12">
                        <!-- Month-Year Filter Form -->
                        <form class="filter-form d-flex align-items-center flex-wrap" method="GET" action="">
                            <label for="month" class="me-2">Select Month:</label>
                            <select class="form-select me-3 mb-2" id="month" name="month" required>
                                <option value="" disabled <?php echo empty($_GET['month']) ? 'selected' : ''; ?>>-- Select Month --</option>
                                <?php
                                for ($m = 1; $m <= 12; $m++) {
                                    $month_name = date('F', mktime(0, 0, 0, $m, 10));
                                    $selected = ($m == $selected_month) ? 'selected' : '';
                                    echo "<option value='$m' $selected>$month_name</option>";
                                }
                                ?>
                            </select>

                            <label for="year" class="me-2">Select Year:</label>
                            <select class="form-select me-3 mb-2" id="year" name="year" required>
                                <option value="" disabled <?php echo empty($_GET['year']) ? 'selected' : ''; ?>>-- Select Year --</option>
                                <?php
                                $current_year = date('Y');
                                $start_year = $current_year - 5;
                                $end_year = $current_year + 5;
                                for ($y = $start_year; $y <= $end_year; $y++) {
                                    $selected = ($y == $selected_year) ? 'selected' : '';
                                    echo "<option value='$y' $selected>$y</option>";
                                }
                                ?>
                            </select>

                            <button type="submit" class="btn btn-primary mb-2">Filter</button>
                        </form>
                    </div>
                </div>

                <!-- Attendance Cards Section -->
                <div class="row">
                    <?php foreach ($attendance_details as $detail): ?>
                        <?php
                            // Determine card color based on status
                            switch ($detail['status']) {
                                case 'absent':
                                    $card_color = 'bg-danger';
                                    $modal_header_class = 'absent';
                                    break;
                                case 'undertime':
                                    $card_color = 'bg-warning';
                                    $modal_header_class = 'undertime';
                                    break;
                                case 'ontime':
                                    $card_color = 'bg-success';
                                    $modal_header_class = 'ontime';
                                    break;
                                case 'overtime':
                                    $card_color = 'bg-dark-success'; // Custom dark green
                                    $modal_header_class = 'overtime';
                                    break;
                                default:
                                    $card_color = 'bg-secondary';
                                    $modal_header_class = '';
                            }

                            // Custom class for dark green
                            if ($detail['status'] == 'overtime') {
                                echo "
                                    <style>
                                        .bg-dark-success {
                                            background-color: #155724 !important;
                                        }
                                    </style>
                                ";
                            }
                        ?>
                        <div class="col-md-4 mb-4">
                            <div class="card attendance-card <?php echo $card_color; ?> text-white attendance-card-hover" data-bs-toggle="modal" data-bs-target="#modal-<?php echo $detail['date']; ?>" style="cursor: pointer;">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo date('d M Y', strtotime($detail['date'])); ?></h5>
                                    <p class="card-text">
                                        <?php echo $detail['total_hours']; ?>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Modal for Detailed Attendance -->
                        <div class="modal fade" id="modal-<?php echo $detail['date']; ?>" tabindex="-1" aria-labelledby="modalLabel-<?php echo $detail['date']; ?>" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header <?php echo $modal_header_class; ?>">
                                        <h5 class="modal-title" id="modalLabel-<?php echo $detail['date']; ?>"><?php echo date('d M Y', strtotime($detail['date'])); ?> - <?php echo ucfirst($detail['status']); ?></h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <?php if ($detail['status'] !== 'absent'): ?>
                                            <div class="mb-3">
                                                <h6>Clock-In Time(s):</h6>
                                                <?php foreach ($detail['clock_in'] as $in_time): ?>
                                                    <span class="badge bg-primary"><?php echo date('h:i A', strtotime($in_time)); ?></span>
                                                <?php endforeach; ?>
                                            </div>
                                            <div class="mb-3">
                                                <h6>Clock-Out Time(s):</h6>
                                                <?php if (!empty($detail['clock_out'])): ?>
                                                    <?php foreach ($detail['clock_out'] as $out_time): ?>
                                                        <span class="badge bg-secondary"><?php echo date('h:i A', strtotime($out_time)); ?></span>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary">Not Clocked Out</span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="mb-3">
                                                <h6>Paired Times and Durations:</h6>
                                                <?php foreach ($detail['paired_times'] as $index => $pair): ?>
                                                    <p>
                                                        <strong>Session <?php echo $index + 1; ?>:</strong>
                                                        Clock-In: <?php echo $pair['clock_in']; ?> -
                                                        Clock-Out: <?php echo $pair['clock_out']; ?> -
                                                        Duration: <?php echo $pair['duration']; ?> hrs
                                                    </p>
                                                <?php endforeach; ?>
                                            </div>
                                            <div class="mb-3">
                                                <h6>Total Hours Worked:</h6>
                                                <p><?php echo $detail['total_hours']; ?></p>
                                            </div>
                                        <?php else: ?>
                                            <div class="text-center">
                                                <i class="fas fa-times-circle fa-3x text-danger mb-3"></i>
                                                <h5>You were <strong>Absent</strong> on this date.</h5>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
    </div>
    <!-- end main content-->
</div>
<!-- END layout-wrapper -->

<?php include 'layouts/right-sidebar.php'; ?>

<?php include 'layouts/vendor-scripts.php'; ?>

<!-- Include Bootstrap JS Bundle (includes Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
