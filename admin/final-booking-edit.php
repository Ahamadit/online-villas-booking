<?php
// this code use for show the all data

include "layouts/config.php"; // Database connection

// Check if the ID is set
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Secure input

    // Fetch booking details
    $sql = "SELECT * FROM booking WHERE id = ?";
    $stmt = $link->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $booking = $result->fetch_assoc();
    $stmt->close();
} else {
    // Redirect if ID is missing
    header("Location: booking-enquiry.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Booking</title>
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
                    <h4>Edit Booking</h4>

                    <!-- Form to Edit Booking -->
                    <?php
                    require_once "layouts/config.php"; // Include database connection

                    // Check if ID is set in the URL
                    if (isset($_GET['id'])) {
                        $id = intval($_GET['id']); // Secure input

                        // Fetch booking details
                        $sql = "SELECT * FROM booking WHERE id = ?";
                        $stmt = $link->prepare($sql);

                        if (!$stmt) {
                            die("ERROR: " . $link->error); // Show MySQL error
                        }

                        $stmt->bind_param("i", $id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $booking = $result->fetch_assoc();
                        $stmt->close();
                    } else {
                        // Redirect if ID is missing
                        header("Location: booking-enquiry.php");
                        exit;
                    }

                    // Handle form submission
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $id = intval($_POST['id']);
                        $name = htmlspecialchars($_POST['name']);
                        $email = htmlspecialchars($_POST['email']);
                        $mobile = htmlspecialchars($_POST['mobile']);
                        $villa = htmlspecialchars($_POST['villa']); // Corrected to match 'villas' column
                        $guests = htmlspecialchars($_POST['guests']);
                        $checkin = $_POST['checkin'];
                        $checkout = $_POST['checkout'];
                        $price = htmlspecialchars($_POST['price']);

                        // Corrected Update query (Ensure column name matches database)
                        $sql = "UPDATE booking SET name=?, email=?, mobile=?, villas=?, guest=?, check_in=?, check_out=?, price=? WHERE id=?";
                        $stmt = $link->prepare($sql);

                        if (!$stmt) {
                            die("ERROR: " . $link->error); // Show MySQL error
                        }

                        $stmt->bind_param("ssssssssi", $name, $email, $mobile, $villa, $guests, $checkin, $checkout, $price, $id);

                        if ($stmt->execute()) {
                            echo "<script>alert('Booking updated successfully!'); window.location.href='booking-enquiry.php';</script>";
                        } else {
                            echo "<script>alert('Error updating booking: " . $stmt->error . "');</script>";
                        }
                        $stmt->close();
                    }
                    ?>

                    <form id="bookingForm" method="POST" action="submit-booking.php">
                        <input type="hidden" name="id" value="<?php echo $booking['id']; ?>">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="name" id="name" value="<?php echo htmlspecialchars($booking['name']); ?>" required>
                                    <label for="name"><i class="fa-solid fa-user"></i> Full Name</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="email" class="form-control" name="email" id="email" value="<?php echo htmlspecialchars($booking['email']); ?>" required>
                                    <label for="email"><i class="fa-solid fa-envelope"></i> Email Address</label>
                                </div>
                            </div>
                        </div>

                        <div class="row g-3 mt-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="tel" class="form-control" name="mobile" id="mobile" value="<?php echo htmlspecialchars($booking['mobile']); ?>" required>
                                    <label for="mobile"><i class="fa-solid fa-phone"></i> Mobile Number</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="villa" id="villa" value="<?php echo isset($booking['villas']) ? htmlspecialchars($booking['villas']) : ''; ?>" required>
                                    <label for="villa"><i class="fa-solid fa-home"></i> Villa Name</label>
                                </div>
                            </div>
                        </div>

                        <div class="row g-3 mt-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="guests" id="guests" value="<?php echo htmlspecialchars($booking['guest']); ?>" required>
                                    <label for="guests"><i class="fa-solid fa-users"></i> Number of Guests</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="date" class="form-control" name="checkin" id="checkin" value="<?php echo $booking['check_in']; ?>" required>
                                    <label for="checkin"><i class="fa-solid fa-calendar-check"></i> Check-in Date</label>
                                </div>
                            </div>

                        </div>

                        <div class="row g-3 mt-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="date" class="form-control" name="checkout" id="checkout" value="<?php echo $booking['check_out']; ?>" required>
                                    <label for="checkout"><i class="fa-solid fa-calendar-xmark"></i> Check-out Date</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="price" id="price" value="<?php echo htmlspecialchars($booking['price'] ?? ''); ?>" required>
                                    <label for="price"><i class="fa-solid fa-tag"></i> Price</label>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary btn-lg px-4">
                                <i class="fa-solid fa-paper-plane"></i> Submit
                            </button>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>

    <?php include 'layouts/vendor-scripts.php'; ?>

</body>

</html>