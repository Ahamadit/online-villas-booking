<?php
ob_start(); // Start output buffering (Fix header issue)
require_once "layouts/config.php"; // Include database connection

if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']); // Convert ID to integer for security

    // Prepare delete query
    $sql = "DELETE FROM final_booking WHERE id = ?";
    $stmt = $link->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $delete_id);
        if ($stmt->execute()) {
            $stmt->close();
            $link->close();

            // Redirect BEFORE any output is sent
            header("Location: final-booking.php?msg=Booking deleted successfully");
            exit(); // Stop execution after redirect
        } else {
            echo "Error deleting record: " . $stmt->error;
        }
    } else {
        echo "Error preparing delete statement.";
    }
}

// Fetch booking data
$sql = "SELECT id, guest, villas, check_in, check_out, name, email, mobile, price FROM final_booking ORDER BY id DESC";
$result = $link->query($sql);
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
                    $title = "Final Booking";
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
                                                    <th>ID</th>
                                                    <th>Guest</th>
                                                    <th>Villas</th>
                                                    <th>Check-In</th>
                                                    <th>Check-Out</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Mobile</th>
                                                    <th>Price</th>
                                                    <th>Brochure</th>
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
                                                            <td><?php echo $counter; ?></td>
                                                            <td><?php echo htmlspecialchars($row['guest']); ?></td>
                                                            <td><?php echo htmlspecialchars($row['villas']); ?></td>
                                                            <td><?php echo date('d-m-Y', strtotime($row['check_in'])); ?></td>
                                                            <td><?php echo date('d-m-Y', strtotime($row['check_out'])); ?></td>
                                                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                                                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                                                            <td><?php echo htmlspecialchars($row['mobile']); ?></td>
                                                            <td><?php echo htmlspecialchars($row['price']); ?></td>
                                                            <td>
                                                                <a href="browcher.php?id=<?php echo $row['id']; ?>" target="_blank">
                                                                    <i class="fa-solid fa-file-invoice" style="font-size: 1.3rem;"></i>
                                                                </a>
                                                            </td>

                                                            <td>
                                                                <a href="final-booking.php?delete_id=<?php echo $row['id']; ?>"
                                                                    onclick="return confirm('Are you sure you want to delete this booking?');">
                                                                    <i class="fa-solid fa-trash text-danger" style="font-size: 1.3rem;"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                <?php
                                                        $counter++;
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='10' class='text-center'>No booking enquiries found.</td></tr>";
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
    <?php include 'layouts/right-sidebar.php'; ?>
    <?php include 'layouts/vendor-scripts.php'; ?>
</body>

</html>