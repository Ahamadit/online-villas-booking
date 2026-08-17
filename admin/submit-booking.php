<?php
require_once "layouts/config.php";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $villa = $_POST['villa']; // Get villa name from the form
    $guests = $_POST['guests'];
    $check_in = $_POST['checkin'];
    $check_out = $_POST['checkout'];
    $price = $_POST['price'];

    // Validate input to prevent SQL injection
    $name = $link->real_escape_string($name);
    $email = $link->real_escape_string($email);
    $mobile = $link->real_escape_string($mobile);
    $villa = $link->real_escape_string($villa);
    $guests = (int) $guests;
    $check_in = $link->real_escape_string($check_in);
    $check_out = $link->real_escape_string($check_out);
    $price = (float) $price;

    // Insert query with the new villa field
    $sql = "INSERT INTO final_booking (name, email, mobile, villas, guest, check_in, check_out, price) 
            VALUES ('$name', '$email', '$mobile', '$villa', '$guests', '$check_in', '$check_out', '$price')";

    if ($link->query($sql) === TRUE) {
        echo "<script>alert('Booking successfully added!'); window.location.href='index.php';</script>";
    } else {
        echo "Error: " . $link->error;
    }

    $link->close();
}

?>
