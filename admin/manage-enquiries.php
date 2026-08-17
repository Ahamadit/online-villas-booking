<?php
ob_start(); // Start output buffering
include "layouts/config.php"; // Database connection

// DELETE BOOKING LOGIC
if (isset($_GET['delete_id'])) {
    $id = intval($_GET['delete_id']); // Secure input

    $sql = "DELETE FROM reservations WHERE id = ?";
    $stmt = $link->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $stmt->close();
        header("Location: manage-enquiries.php"); // Redirect
        exit;
    } else {
        echo "<script>alert('Error deleting booking'); window.location.href='manage-enquiries.php';</script>";
        exit;
    }
}

// FILTERING LOGIC
$whereClauses = [];
$params = [];
$paramTypes = "";

// Check if From Date and To Date are selected
if (!empty($_GET['from_date']) && !empty($_GET['to_date'])) {
    $whereClauses[] = "check_in_date BETWEEN ? AND ?";
    $params[] = $_GET['from_date'];
    $params[] = $_GET['to_date'];
    $paramTypes .= "ss";
}

// Check for predefined range
if (!empty($_GET['predefined_range'])) {
    $today = date("Y-m-d");
    if ($_GET['predefined_range'] == "today") {
        $whereClauses[] = "check_in_date = ?";
        $params[] = $today;
        $paramTypes .= "s";
    } elseif ($_GET['predefined_range'] == "this_week") {
        $weekStart = date("Y-m-d", strtotime("monday this week"));
        $weekEnd = date("Y-m-d", strtotime("sunday this week"));
        $whereClauses[] = "check_in_date BETWEEN ? AND ?";
        $params[] = $weekStart;
        $params[] = $weekEnd;
        $paramTypes .= "ss";
    } elseif ($_GET['predefined_range'] == "this_month") {
        $monthStart = date("Y-m-01");
        $monthEnd = date("Y-m-t");
        $whereClauses[] = "check_in_date BETWEEN ? AND ?";
        $params[] = $monthStart;
        $params[] = $monthEnd;
        $paramTypes .= "ss";
    }
}

// Build the final query
$sql = "SELECT id, number_of_guests, villas, room_type, checkin, checkout, name, email, contact, services, created_at, updated_at FROM reservations";

// Add WHERE clause if any filters are applied
if (!empty($whereClauses)) {
    $sql .= " WHERE " . implode(" AND ", $whereClauses);
}

$sql .= " ORDER BY id DESC";

$stmt = $link->prepare($sql);

if ($paramTypes) {
    $stmt->bind_param($paramTypes, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();
ob_end_flush(); // Flush output buffer
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Booking Enquiries</title>
    <?php include 'layouts/head.php'; ?>
    <?php include 'layouts/head-style.php'; ?>
</head>

<body>
    <?php include 'layouts/body.php'; ?>
    <div id="layout-wrapper">
        <?php include 'layouts/menu-admin.php'; ?>

        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <?php
                    $maintitle = "Booking Enquiries";
                    $title = "Villas Booking Enquiries";
                    include 'layouts/breadcrumb.php';
                    ?>

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered align-middle">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Guests</th>
                                                    <th>Villa Name</th>
                                                    <th>Room Type</th>
                                                    <th>Check-In</th>
                                                    <th>Check-Out</th>
                                                    <th>Guest Name</th>
                                                    <th>Email</th>
                                                    <th>Contact</th>
                                                    <th>Services</th>
                                                    <th>Created At</th>
                                                    <th>Updated At</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $counter = 1;
                                                if ($result && $result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                ?>
                                                        <tr>
                                                            <td><?php echo $counter++; ?></td>
                                                            <td><?php echo htmlspecialchars($row['number_of_guests']); ?></td>
                                                            <td><?php echo htmlspecialchars($row['villas']); ?></td>
                                                            <td><?php echo htmlspecialchars($row['room_type']); ?></td>
                                                            <td><?php echo date('d-m-Y', strtotime($row['checkin'])); ?></td>
                                                            <td><?php echo date('d-m-Y', strtotime($row['checkout'])); ?></td>
                                                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                                                            <td>
                                                                <a href="mailto:<?php echo htmlspecialchars($row['email']); ?>" class="text-primary">
                                                                    <i class="fa-solid fa-envelope" style="font-size: 1.3rem;"></i>
                                                                </a>
                                                                <?php echo htmlspecialchars($row['email']); ?>
                                                            </td>
                                                            <td>
                                                                <a href="tel:<?php echo htmlspecialchars($row['contact']); ?>" class="text-success me-2" title="Call">
                                                                    <i class="fa-solid fa-phone" style="font-size: 1.3rem;"></i>
                                                                </a>
                                                                <a href="https://wa.me/<?php echo htmlspecialchars($row['contact']); ?>" target="_blank" class="text-success me-2" title="WhatsApp">
                                                                    <i class="fa-brands fa-whatsapp" style="font-size: 1.3rem;"></i>
                                                                </a>
                                                                <span class="fw-bold text-dark"><?php echo htmlspecialchars($row['contact']); ?></span>
                                                            </td>
                                                            <td><?php echo htmlspecialchars($row['services']); ?></td>
                                                            <td><?php echo date('d-m-Y H:i:s', strtotime($row['created_at'])); ?></td>
                                                            <td><?php echo date('d-m-Y H:i:s', strtotime($row['updated_at'])); ?></td>
                                                            <td>
                                                                <a href="#" class="text-danger delete-btn" data-id="<?php echo $row['id']; ?>">
                                                                    <i class="fa-solid fa-trash" style="font-size: 1.3rem;"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                <?php
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='13' class='text-center'>No booking enquiries found.</td></tr>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include 'layouts/footer.php'; ?>
        </div>
    </div>
    <?php include 'layouts/vendor-scripts.php'; ?>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".delete-btn").forEach(function(button) {
            button.addEventListener("click", function(event) {
                event.preventDefault();
                let bookingId = this.getAttribute("data-id");
                if (confirm("Are you sure you want to delete this booking?")) {
                    window.location.href = "manage-enquiries.php?delete_id=" + bookingId;
                }
            });
        });
    });
    </script>
</body>
</html>
